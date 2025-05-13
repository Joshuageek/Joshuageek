<?php
ob_start();
try{
    $conn = new PDO('mysql:host=localhost;dbname=swiftdoc', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    throw new Exception("Database connection error");
}
ob_end_clean();
?>