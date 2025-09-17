<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "=== DEBUG USUARIOS (SIMPLIFICADO) ===\n";

$users = User::all();

foreach ($users as $user) {
    echo "ID: {$user->id}\n";
    echo "Name: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo 'is_suspended: '.($user->is_suspended ? 'true' : 'false')."\n";
    echo 'suspended_until: '.($user->suspended_until ? $user->suspended_until->format('Y-m-d H:i:s') : 'null')."\n";
    echo 'isSuspended(): '.($user->isSuspended() ? 'true' : 'false')."\n";
    echo 'getAccountStatus(): '.$user->getAccountStatus()."\n";
    echo 'getAccountStatusColor(): '.$user->getAccountStatusColor()."\n";
    echo 'canLogin(): '.($user->canLogin() ? 'true' : 'false')."\n";
    echo "---\n";
}
