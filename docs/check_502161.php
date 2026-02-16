<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=tpt_feb_2026', 'root', 'password');
$stmt = $pdo->prepare('SELECT * FROM results WHERE examinee_number = ?');
$stmt->execute(['502161']);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    print("Full Name: {$row['full_name']}\n\n");
    print("SUBJECT            | STANDARD SCORE | STANINE | INTERPRETATION\n");
    print("-------------------|----------------|---------|---------------\n");

    $subjects = [
        'ENGLISH' => ['english_standard_score', 'english_raw_score'],
        'FILIPINO' => ['filipino_standard_score', 'filipino_raw_score'],
        'MATHEMATICS' => ['math_standard_score', 'math_raw_score'],
        'SCIENCE' => ['science_standard_score', 'science_raw_score'],
        'SOCIAL STUDIES' => ['social_studies_standard_score', 'social_studies_raw_score'],
        'OVERALL' => ['total_standard_score', 'total_raw_score'],
    ];

    $interp = function($s) {
        if ($s == 9) return 'Outstanding';
        if ($s == 8) return 'Above Average';
        if ($s == 7) return 'Above Average';
        if ($s == 6) return 'High Average';
        if ($s == 5) return 'Middle Average';
        if ($s == 4) return 'Low Average';
        if ($s == 3) return 'Below Average';
        if ($s == 2) return 'Below Average';
        if ($s == 1) return 'Low';
        return '';
    };

    foreach ($subjects as $name => $cols) {
        $ss = $row[$cols[0]];
        $st = $row[$cols[1]];
        $qi = $interp($st);
        printf("%-19s| %-15s| %-8s| %s\n", $name, $ss, $st, $qi);
    }
} else {
    print("No result found for examinee 502161\n");
}

// Also check original CSV
print("\n=== Cross-check with original CSV ===\n");
$csv = fopen(__DIR__ . '/SKSU TPT RESULT 2026.csv', 'r');
fgetcsv($csv);
fgetcsv($csv);
while (($r = fgetcsv($csv)) !== false) {
    if (isset($r[1]) && trim($r[1]) == '502161') {
        print("Name: {$r[0]}\n");
        print("English:  SS={$r[3]}, Stanine={$r[4]}, QI={$r[5]}\n");
        print("Science:  SS={$r[6]}, Stanine={$r[7]}, QI={$r[8]}\n");
        print("Math:     SS={$r[9]}, Stanine={$r[10]}, QI={$r[11]}\n");
        print("Filipino: SS={$r[12]}, Stanine={$r[13]}, QI={$r[14]}\n");
        print("SocStud:  SS={$r[15]}, Stanine={$r[16]}, QI={$r[17]}\n");
        print("Overall:  SS={$r[21]}, Stanine={$r[22]}, QI={$r[23]}\n");
        break;
    }
}
fclose($csv);
