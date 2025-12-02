
<?php
include '../../public/db.php';
session_start();
// Verifica se o usuario está logado e tem permissão se necessário (não enviado)
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../lista_usuarios.php?msg=ID inválido');
    exit();
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM usuario WHERE id_usuario = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $stmt->close();
    header('Location: ../lista_usuarios.php?msg=Usuário deletado com sucesso');
    exit();
} else {
    $error = $stmt->error;
    $stmt->close();
    header('Location: ../lista_usuarios.php?msg=Erro ao deletar usuário: ' . urlencode($error));
    exit();
}
?>
