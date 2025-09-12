<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

$users = App\Models\User::all();
foreach($users as $user) {
    echo "ID: {$user->id}, Email: {$user->email}, Verificado: " . 
         ($user->email_verified_at ? 'Sí' : 'No') . 
         ", Session: " . ($user->current_session_id ?? 'Ninguna') . PHP_EOL;
}