<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_POST['id'];
$usuario = $_SESSION['usuario_id'];

/* CONFIRMAR SE É DONO */
$stmt = $conn->prepare("SELECT user_id FROM chat_grupo_desenhos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($autor);
$stmt->fetch();
$stmt->close();

if ($autor != $usuario) {
    die("Você não pode excluir isso!");
}

/* EXCLUIR */
$stmt = $conn->prepare("DELETE FROM chat_grupo_desenhos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: desenhos.php");
exit();
?>
