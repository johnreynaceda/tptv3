<?php

$input = __DIR__ . '/SKSU TPT RESULT 2026.csv';
$output = __DIR__ . '/SKSU_TPT_RESULT_2026_CLEAN.csv';

echo "Input exists: " . (file_exists($input) ? 'yes' : 'no') . PHP_EOL;

// Headers in EXACT table column order (from DESCRIBE results)
$headers = [
    'examination_id',
    'examinee_number',
    'full_name',
    'math_raw_score',
    'math_standard_score',
    'english_raw_score',
    'english_standard_score',
    'filipino_raw_score',
    'filipino_standard_score',
    'science_raw_score',
    'science_standard_score',
    'social_studies_raw_score',
    'social_studies_standard_score',
    'total_raw_score',
    'total_standard_score',
];

// Column indexes from original CSV (0-based) — matched to table order above
// exam_id=added, 1=ExNumber, 0=Name,
// 10=MathStanine, 9=MathSS, 4=EngStanine, 3=EngSS,
// 13=FilStanine, 12=FilSS, 7=SciStanine, 6=SciSS,
// 16=SocStudStanine, 15=SocStudSS, 22=OverallStanine, 21=OverallSS
$cols = [1, 0, 10, 9, 4, 3, 13, 12, 7, 6, 16, 15, 22, 21];

$fin = fopen($input, 'r');
$fout = fopen($output, 'w');

// Write clean header
fputcsv($fout, $headers);

// Skip row 1 (group labels) and row 2 (sub-labels)
fgetcsv($fin);
fgetcsv($fin);

$count = 0;
$skipped = 0;

while (($row = fgetcsv($fin)) !== false) {
    $name = isset($row[0]) ? trim($row[0]) : '';
    if ($name === '') {
        $skipped++;
        continue;
    }

    $extracted = [3]; // examination_id = 3
    foreach ($cols as $i) {
        $extracted[] = isset($row[$i]) ? trim($row[$i]) : '';
    }
    fputcsv($fout, $extracted);
    $count++;
}

fclose($fin);
fclose($fout);

echo "Done! Wrote {$count} rows, skipped {$skipped} empty rows." . PHP_EOL;
echo "Output: {$output}" . PHP_EOL;
