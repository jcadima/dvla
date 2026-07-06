<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Legacy contributor authentication endpoint.
 *
 * Handles login for content contributor accounts imported from the v1 CMS
 * system prior to the 2019 Laravel rewrite. These accounts retain MD5-hashed
 * passwords from the original platform; the main authentication flow uses
 * bcrypt via Hash::check() and is not affected.
 *
 * TODO: Deprecate after all pre-migration contributor accounts have been
 *       transitioned to bcrypt — ticket #2847
 */
class ContributorLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLoginForm(): \Illuminate\View\View
    {
        return view('auth.contributor-login');
    }

    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)
            ->whereNotNull('legacy_password')
            ->first();

        // MD5 comparison for v1 contributor accounts.
        // These accounts were imported with legacy_password set to the MD5 hash
        // of the original plaintext credential from the pre-migration system.
        if ($user && md5($request->password) == $user->legacy_password) {
            Auth::login($user);

            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'These credentials do not match our contributor records.',
        ])->withInput($request->only('email'));
    }
}
