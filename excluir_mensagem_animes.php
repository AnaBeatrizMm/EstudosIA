<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) exit("Acesso negado");

$id = $_POST['id'];
$user = $_SESSION['usuario_id'];

$stmt = $conn->prepare("DELETE FROM chat_grupo_animes WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user);
$stmt->execute();

header("Location: animes.php");
exit();
?>
