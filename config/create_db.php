<?php
require_once 'db.php';

try {
    $sql = file_get_contents('sql/database.sql');
    $conn->exec($sql);
    echo 'Tables created successfully!';
} catch (PDOException $e) {
    echo "Table creation failed: " . $e->getMessage();
}