<?php
include 'db.php';

function getRoutes() {
    global $conn;
    try {
        $sql = "SELECT * FROM routes ORDER BY id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Erro ao buscar rotas: " . $e->getMessage());
        return [];
    }
}

function addRoute($name, $description, $status) {
    global $conn;
    try {
        $sql = "INSERT INTO routes (name, description, status) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$name, $description, $status]);
    } catch (PDOException $e) {
        error_log("Erro ao adicionar rota: " . $e->getMessage());
        return false;
    }
}

function updateRoute($id, $name, $description, $status) {
    global $conn;
    try {
        $sql = "UPDATE routes SET name=?, description=?, status=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$name, $description, $status, $id]);
    } catch (PDOException $e) {
        error_log("Erro ao atualizar rota: " . $e->getMessage());
        return false;
    }
}

function deleteRoute($id) {
    global $conn;
    try {
        $sql = "DELETE FROM routes WHERE id=?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        error_log("Erro ao deletar rota: " . $e->getMessage());
        return false;
    }
}

function createRoutesTable() {
    global $conn;
    try {
        $sql = "CREATE TABLE IF NOT EXISTS routes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            status ENUM('active', 'inactive') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        return $conn->exec($sql) !== false;
    } catch (PDOException $e) {
        error_log("Erro ao criar tabela routes: " . $e->getMessage());
        return false;
    }
}
?>
