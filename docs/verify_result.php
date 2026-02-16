<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = \App\Models\User::find(175);
$permit = $user->permit;
$examinee_number = $permit->examinee_number_updated;
$result = \App\Models\Result::where('examinee_number', $examinee_number)->first();
$examination = $user->application->examination ?? null;

print("=== User ===\n");
print("Name: {$user->first_name} {$user->last_name}\n");
print("Email: {$user->email}\n");

print("\n=== Permit ===\n");
print("Examinee #: {$examinee_number}\n");

print("\n=== Examination ===\n");
if ($examination) {
    print("Title: {$examination->title}\n");
    print("show_results: {$examination->show_results}\n");
} else {
    print("No examination linked\n");
}

print("\n=== Result (what would display on /applicant/result) ===\n");
if ($result) {
    $r = new \App\Models\Result();
    print("Full Name: {$result->full_name}\n\n");
    print("SUBJECT            | STANDARD SCORE | STANINE | INTERPRETATION\n");
    print("-------------------|----------------|---------|---------------\n");
    print("ENGLISH            | {$result->english_standard_score}            | {$result->english_raw_score}       | " . $r->stanineInterpretation($result->english_raw_score) . "\n");
    print("FILIPINO           | {$result->filipino_standard_score}            | {$result->filipino_raw_score}       | " . $r->stanineInterpretation($result->filipino_raw_score) . "\n");
    print("MATHEMATICS        | {$result->math_standard_score}            | {$result->math_raw_score}       | " . $r->stanineInterpretation($result->math_raw_score) . "\n");
    print("SCIENCE            | {$result->science_standard_score}            | {$result->science_raw_score}       | " . $r->stanineInterpretation($result->science_raw_score) . "\n");
    print("SOCIAL STUDIES     | {$result->social_studies_standard_score}            | {$result->social_studies_raw_score}       | " . $r->stanineInterpretation($result->social_studies_raw_score) . "\n");
    print("OVERALL            | {$result->total_standard_score}            | {$result->total_raw_score}       | " . $r->stanineInterpretation($result->total_raw_score) . "\n");
} else {
    print("NO RESULT FOUND for examinee #{$examinee_number}\n");
}

// Cross-check with original CSV
print("\n=== Cross-check with original CSV ===\n");
$csv = fopen(__DIR__ . '/SKSU TPT RESULT 2026.csv', 'r');
fgetcsv($csv); // skip row 1
fgetcsv($csv); // skip row 2
while (($row = fgetcsv($csv)) !== false) {
    if (isset($row[1]) && trim($row[1]) == $examinee_number) {
        print("Original CSV row for #{$examinee_number}:\n");
        print("  Name: {$row[0]}\n");
        print("  English:  SS={$row[3]}, Stanine={$row[4]}, QI={$row[5]}\n");
        print("  Science:  SS={$row[6]}, Stanine={$row[7]}, QI={$row[8]}\n");
        print("  Math:     SS={$row[9]}, Stanine={$row[10]}, QI={$row[11]}\n");
        print("  Filipino: SS={$row[12]}, Stanine={$row[13]}, QI={$row[14]}\n");
        print("  SocStud:  SS={$row[15]}, Stanine={$row[16]}, QI={$row[17]}\n");
        print("  Overall:  SS={$row[21]}, Stanine={$row[22]}, QI={$row[23]}\n");
        break;
    }
}
fclose($csv);
