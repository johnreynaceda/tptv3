<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=tpt_feb_2026', 'root', 'password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->query("
    SELECT
        p.examinee_number_updated as examinee_number,
        CONCAT(u.first_name, ' ', u.last_name) as name,
        u.email,
        a.status as application_status,
        a.submited_at,
        a.created_at as application_date,
        p.created_at as permit_date,
        p.user_id
    FROM permits p
    JOIN users u ON u.id = p.user_id
    LEFT JOIN applications a ON a.user_id = p.user_id
    LEFT JOIN results r ON r.examinee_number = p.examinee_number_updated
    WHERE p.examinee_number_updated IS NOT NULL
      AND p.examinee_number_updated != ''
      AND r.id IS NULL
    ORDER BY p.examinee_number_updated
");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = __DIR__ . '/APPLICANTS_MISSING_RESULTS.csv';
$fout = fopen($output, 'w');

// BOM for Excel to recognize UTF-8
fwrite($fout, "\xEF\xBB\xBF");

fputcsv($fout, ['#', 'User ID', 'Examinee Number', 'Name', 'Email', 'Application Status', 'Submitted At', 'Application Date', 'Permit Date']);

$i = 1;
foreach ($rows as $row) {
    fputcsv($fout, [
        $i,
        $row['user_id'],
        $row['examinee_number'],
        $row['name'],
        $row['email'],
        $row['application_status'],
        $row['submited_at'] ?? '',
        $row['application_date'] ?? '',
        $row['permit_date'] ?? '',
    ]);
    $i++;
}

fclose($fout);
print("Exported {$i} rows to {$output}\n");
