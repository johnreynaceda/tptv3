<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = \App\Models\User::find(175); // Jurick Salili
$user->password = bcrypt('password');
$user->save();

print("Password changed for:\n");
print("  Name: {$user->first_name} {$user->last_name}\n");
print("  Email: {$user->email}\n");
print("  Examinee #: " . $user->permit->examinee_number_updated . "\n");
print("  New password: password\n");
