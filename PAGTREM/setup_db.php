<?php

$servername = "localhost";
$username = "root";
$password = "";

try {
    // Connect without dbname to create database
    $conn = new PDO("mysql:host=$servername;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = file_get_contents('../db.sql');
    $conn->exec($sql);
    echo "Database setup completed successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
