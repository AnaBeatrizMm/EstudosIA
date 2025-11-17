<?php
session_start();
include "conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado.");
}

$id = $_POST['id'];
$user_id = $_SESSION['usuario_id'];

// Confirma se a mensagem pertence ao usuário
$sql = "SELECT arquivo FROM chat_grupo_costura WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Você não pode excluir esta mensagem.");
}

$arquivo = $result->fetch_assoc()['arquivo'];

if ($arquivo && file_exists($arquivo)) {
    unlink($arquivo);
}

$delete = $conn->prepare("DELETE FROM chat_grupo_costura WHERE id = ?");
$delete->bind_param("i", $id);
$delete->execute();

header("Location: costura.php");
exit;
?>
