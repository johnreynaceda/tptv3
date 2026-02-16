<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=tpt_feb_2026', 'root', 'password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    print("Connected OK\n");

    $stmt = $pdo->query('DESCRIBE results');
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    print("Field | Type | Null | Default | Extra\n");
    print("------|------|------|---------|------\n");
    foreach ($rows as $row) {
        $default = $row['Default'] === null ? 'NULL' : $row['Default'];
        print("{$row['Field']} | {$row['Type']} | {$row['Null']} | {$default} | {$row['Extra']}\n");
    }
} catch (PDOException $e) {
    print("ERROR: " . $e->getMessage() . "\n");
}
