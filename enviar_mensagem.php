<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Não logado.");
}

$user_id = $_SESSION['usuario_id'];
$mensagem = $_POST['mensagem'] ?? '';
$resposta_para = $_POST['resposta_para'] ?? null;

$arquivo = null;

// Verificar upload
if (!empty($_FILES['arquivo']['name'])) {
    $nome = uniqid() . "-" . basename($_FILES['arquivo']['name']);
    $destino = "uploads_chat/" . $nome;

    if (!is_dir("uploads_chat")) {
        mkdir("uploads_chat", 0777, true);
    }

    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino)) {
        $arquivo = $destino;
    }
}

$stmt = $conn->prepare("INSERT INTO chat_grupo (user_id, mensagem, arquivo, resposta_para) 
                        VALUES (?, ?, ?, ?)");
$stmt->bind_param("issi", $user_id, $mensagem, $arquivo, $resposta_para);
$stmt->execute();
$stmt->close();

header("Location: chat_grupo.php");
exit;
