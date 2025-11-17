<?php
session_start();
require_once "conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para enviar mensagens.");
}

$user_id = $_SESSION['usuario_id'];
$mensagem = $_POST['mensagem'] ?? '';
$resposta_para = $_POST['resposta_para'] ?? null;

$arquivo_nome = null;

if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === 0) {
    $pasta = "uploads/costura/";
    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $arquivo_nome = $pasta . time() . "_" . basename($_FILES['arquivo']['name']);
    move_uploaded_file($_FILES['arquivo']['tmp_name'], $arquivo_nome);
}

$sql = "INSERT INTO chat_grupo_costura (user_id, mensagem, arquivo, resposta_para, data_envio)
        VALUES (?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $user_id, $mensagem, $arquivo_nome, $resposta_para);
$stmt->execute();

header("Location: costura.php");
exit;
?>
