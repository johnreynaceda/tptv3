<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get first few results
$results = \App\Models\Result::take(10)->get();

foreach ($results as $result) {
    $application = \App\Models\Application::where('examinee_number', $result->examinee_number)->first();
    if ($application) {
        $user = \App\Models\User::find($application->user_id);
        if ($user) {
            echo "FOUND MATCH!" . PHP_EOL;
            echo "Examinee: {$result->full_name}" . PHP_EOL;
            echo "Examinee Number: {$result->examinee_number}" . PHP_EOL;
            echo "Email: {$user->email}" . PHP_EOL;
            echo "User ID: {$user->id}" . PHP_EOL;

            // Change password to 'password'
            $user->password = bcrypt('password');
            $user->save();
            echo "Password changed to: password" . PHP_EOL;
            exit(0);
        }
    }
}

echo "No matching applicant found in first 10 results. Trying broader search..." . PHP_EOL;

// Try matching by name instead
$results = \App\Models\Result::take(50)->get();
$applications = \App\Models\Application::all();

echo "Total applications: " . $applications->count() . PHP_EOL;
echo "Total results: " . \App\Models\Result::count() . PHP_EOL;

// Show some examinee numbers from applications
echo PHP_EOL . "Sample application examinee numbers:" . PHP_EOL;
foreach ($applications->take(5) as $a) {
    echo "  App #{$a->id}: examinee_number={$a->examinee_number}, user_id={$a->user_id}" . PHP_EOL;
}

echo PHP_EOL . "Sample result examinee numbers:" . PHP_EOL;
foreach ($results->take(5) as $r) {
    echo "  Result: examinee_number={$r->examinee_number}, name={$r->full_name}" . PHP_EOL;
}
