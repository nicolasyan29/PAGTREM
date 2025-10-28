<?php
include 'db.php';

function getRoutes() {
    global $conn;
    $sql = "SELECT * FROM routes ORDER BY id DESC";
    $result = $conn->query($sql);
    $routes = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $routes[] = $row;
        }
    }
    return $routes;
}

function addRoute($name, $description, $status) {
    global $conn;
    $sql = "INSERT INTO routes (name, description, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $description, $status);
    return $stmt->execute();
}

function updateRoute($id, $name, $description, $status) {
    global $conn;
    $sql = "UPDATE routes SET name=?, description=?, status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $description, $status, $id);
    return $stmt->execute();
}

function deleteRoute($id) {
    global $conn;
    $sql = "DELETE FROM routes WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function createRoutesTable() {
    global $conn;
    $sql = "CREATE TABLE IF NOT EXISTS routes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    return $conn->query($sql);
}
?>
