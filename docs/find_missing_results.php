<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=tpt_feb_2026', 'root', 'password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Find all permits with examinee_number_updated that DON'T have a matching result
$stmt = $pdo->query("
    SELECT
        p.id as permit_id,
        p.user_id,
        p.examinee_number_updated,
        u.first_name,
        u.last_name,
        u.email,
        a.status as app_status
    FROM permits p
    JOIN users u ON u.id = p.user_id
    LEFT JOIN applications a ON a.user_id = p.user_id
    LEFT JOIN results r ON r.examinee_number = p.examinee_number_updated
    WHERE p.examinee_number_updated IS NOT NULL
      AND p.examinee_number_updated != ''
      AND r.id IS NULL
    ORDER BY p.examinee_number_updated
");
$missing = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get totals
$stmt = $pdo->query("SELECT COUNT(*) as c FROM permits WHERE examinee_number_updated IS NOT NULL AND examinee_number_updated != ''");
$totalPermits = $stmt->fetch()['c'];

$stmt = $pdo->query("
    SELECT COUNT(*) as c FROM permits p
    JOIN results r ON r.examinee_number = p.examinee_number_updated
    WHERE p.examinee_number_updated IS NOT NULL AND p.examinee_number_updated != ''
");
$matchedPermits = $stmt->fetch()['c'];

// Also find permits with NULL or empty examinee number
$stmt = $pdo->query("
    SELECT
        p.id as permit_id,
        p.user_id,
        p.examinee_number,
        p.examinee_number_updated,
        u.first_name,
        u.last_name,
        u.email
    FROM permits p
    JOIN users u ON u.id = p.user_id
    WHERE p.examinee_number_updated IS NULL OR p.examinee_number_updated = ''
    ORDER BY p.user_id
");
$noExamineeNum = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Write MD file
$md = "# Applicants With Permits But No Matching Result\n\n";
$md .= "Generated: " . date('Y-m-d H:i:s') . "\n\n";
$md .= "---\n\n";
$md .= "## Summary\n\n";
$md .= "| Metric | Count |\n";
$md .= "| --- | --- |\n";
$md .= "| Total permits with examinee number | {$totalPermits} |\n";
$md .= "| Permits matched to a result | {$matchedPermits} |\n";
$md .= "| Permits with NO matching result | " . count($missing) . " |\n";
$md .= "| Permits with empty/null examinee number | " . count($noExamineeNum) . " |\n\n";
$md .= "---\n\n";

$md .= "## How Matching Works\n\n";
$md .= "The system matches applicants to results using:\n";
$md .= "- `permits.examinee_number_updated` → `results.examinee_number`\n";
$md .= "- If no match is found, the applicant sees a \"result not found\" message\n\n";
$md .= "---\n\n";

if (count($missing) > 0) {
    $md .= "## Applicants With Permit But No Result (" . count($missing) . " total)\n\n";
    $md .= "These applicants have an examinee number assigned but their number does not exist in the results table.\n\n";
    $md .= "| # | User ID | Examinee # | Name | Email | App Status |\n";
    $md .= "| --- | --- | --- | --- | --- | --- |\n";
    $i = 1;
    foreach ($missing as $row) {
        $name = $row['first_name'] . ' ' . $row['last_name'];
        $md .= "| {$i} | {$row['user_id']} | {$row['examinee_number_updated']} | {$name} | {$row['email']} | {$row['app_status']} |\n";
        $i++;
    }
    $md .= "\n---\n\n";
}

if (count($noExamineeNum) > 0) {
    $md .= "## Applicants With Permit But No Examinee Number (" . count($noExamineeNum) . " total)\n\n";
    $md .= "These applicants have a permit record but no examinee number assigned.\n\n";
    $md .= "| # | User ID | Name | Email | Examinee # (original) | Examinee # (updated) |\n";
    $md .= "| --- | --- | --- | --- | --- | --- |\n";
    $i = 1;
    foreach ($noExamineeNum as $row) {
        $name = $row['first_name'] . ' ' . $row['last_name'];
        $orig = $row['examinee_number'] ?? 'NULL';
        $updated = $row['examinee_number_updated'] ?? 'NULL';
        $md .= "| {$i} | {$row['user_id']} | {$name} | {$row['email']} | {$orig} | {$updated} |\n";
        $i++;
    }
    $md .= "\n---\n\n";
}

$md .= "## Possible Reasons\n\n";
$md .= "1. **Examinee number mismatch** — The permit has a different examinee number than what's in the Excel result file\n";
$md .= "2. **Applicant didn't take the exam** — They registered and got a permit but didn't actually take the test\n";
$md .= "3. **Data entry error** — The examinee number was entered incorrectly in the permit\n";
$md .= "4. **Not in Excel file** — The examinee's result was not included in the original SKSU_TPT_RESULT_2026.xlsx\n\n";
$md .= "## Recommended Action\n\n";
$md .= "- Cross-check the examinee numbers in this list against the original Excel file\n";
$md .= "- Verify if these applicants actually took the exam\n";
$md .= "- Correct any examinee number mismatches in the `permits` table\n";

file_put_contents(__DIR__ . '/APPLICANTS_MISSING_RESULTS.md', $md);

print("Total permits with examinee number: {$totalPermits}\n");
print("Matched to result: {$matchedPermits}\n");
print("NO matching result: " . count($missing) . "\n");
print("No examinee number at all: " . count($noExamineeNum) . "\n");
print("\nWritten to docs/APPLICANTS_MISSING_RESULTS.md\n");
