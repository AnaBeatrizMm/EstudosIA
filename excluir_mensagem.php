<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado.");
}

$usuario_logado = $_SESSION['usuario_id'];
$id = $_POST['id'] ?? 0;

// Verifica se a mensagem pertence ao usuário
$stmt = $conn->prepare("SELECT arquivo FROM chat_grupo WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $usuario_logado);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {

    // Apagar arquivo se existir
    if (!empty($row['arquivo']) && file_exists($row['arquivo'])) {
        unlink($row['arquivo']);
    }

    // Deletar mensagem
    $delete = $conn->prepare("DELETE FROM chat_grupo WHERE id = ?");
    $delete->bind_param("i", $id);
    $delete->execute();
}

header("Location: chat_grupo.php");
exit;
