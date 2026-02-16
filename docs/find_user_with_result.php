<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=tpt_feb_2026', 'root', 'password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check permits table
print("=== permits columns ===\n");
$stmt = $pdo->query('DESCRIBE permits');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $row) {
    print($row['Field'] . " | " . $row['Type'] . "\n");
}

// Find permits that have examinee_number_updated matching a result
print("\n=== Permits matching results (first 5) ===\n");
$stmt = $pdo->query("
    SELECT p.id as permit_id, p.user_id, p.examinee_number_updated, u.email, u.first_name, u.last_name, r.full_name as result_name
    FROM permits p
    JOIN users u ON u.id = p.user_id
    JOIN results r ON r.examinee_number = p.examinee_number_updated
    LIMIT 5
");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($rows)) {
    print("No matches found!\n\n");

    // Show sample permits
    print("=== Sample permits ===\n");
    $stmt = $pdo->query("SELECT id, user_id, examinee_number_updated FROM permits WHERE examinee_number_updated IS NOT NULL LIMIT 5");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        print("  Permit #{$row['id']}: user_id={$row['user_id']}, examinee_number={$row['examinee_number_updated']}\n");
    }

    print("\n=== Sample result examinee numbers ===\n");
    $stmt = $pdo->query("SELECT examinee_number, full_name FROM results LIMIT 5");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        print("  {$row['examinee_number']}: {$row['full_name']}\n");
    }

    print("\n=== Total permits with examinee_number_updated ===\n");
    $stmt = $pdo->query("SELECT COUNT(*) as c FROM permits WHERE examinee_number_updated IS NOT NULL AND examinee_number_updated != ''");
    print($stmt->fetch()['c'] . "\n");
} else {
    foreach ($rows as $row) {
        print("  User ID: {$row['user_id']}\n");
        print("  Email: {$row['email']}\n");
        print("  Name: {$row['first_name']} {$row['last_name']}\n");
        print("  Examinee #: {$row['examinee_number_updated']}\n");
        print("  Result Name: {$row['result_name']}\n");
        print("---\n");
    }
}
