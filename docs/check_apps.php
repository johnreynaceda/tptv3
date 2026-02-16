<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=tpt_feb_2026', 'root', 'password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

print("=== applications columns ===\n");
$stmt = $pdo->query('DESCRIBE applications');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $row) {
    print($row['Field'] . " | " . $row['Type'] . "\n");
}

print("\n=== Sample applications ===\n");
$stmt = $pdo->query('SELECT * FROM applications LIMIT 3');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $row) {
    foreach ($row as $k => $v) {
        print("  $k: $v\n");
    }
    print("---\n");
}

print("\n=== users table columns ===\n");
$stmt = $pdo->query('DESCRIBE users');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $row) {
    print($row['Field'] . " | " . $row['Type'] . "\n");
}

print("\n=== Total counts ===\n");
$stmt = $pdo->query('SELECT COUNT(*) as c FROM applications');
print("Applications: " . $stmt->fetch()['c'] . "\n");
$stmt = $pdo->query('SELECT COUNT(*) as c FROM users');
print("Users: " . $stmt->fetch()['c'] . "\n");
$stmt = $pdo->query('SELECT COUNT(*) as c FROM results');
print("Results: " . $stmt->fetch()['c'] . "\n");
