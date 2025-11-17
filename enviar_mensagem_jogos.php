<?php
session_start();
include 'conexao.php'; // conexão com banco

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['usuario_id'];

// PEGAR CAMPOS
$mensagem = $_POST['mensagem'] ?? '';
$resposta_para = $_POST['resposta_para'] ?? null;
$arquivo = null;

// UPLOAD DE ARQUIVO
if (!empty($_FILES['arquivo']['name'])) {

    $nome = time() . "_" . basename($_FILES['arquivo']['name']);
    $destino = "uploads/" . $nome;

    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino)) {
        $arquivo = $destino;
    }
}

// SALVAR NO BANCO
$stmt = $conn->prepare("
    INSERT INTO chat_grupo_jogos (user_id, mensagem, arquivo, resposta_para, data_envio)
    VALUES (?, ?, ?, ?, NOW())
");

$stmt->bind_param("issi", $user_id, $mensagem, $arquivo, $resposta_para);
$stmt->execute();
$stmt->close();

$conn->close();

// VOLTAR PARA CHAT DE JOGOS
header("Location: jogos.php");
exit();
?>
