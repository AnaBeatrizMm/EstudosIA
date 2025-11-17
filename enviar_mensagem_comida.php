<?php
session_start();
require_once "conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado.");
}

$user_id = $_SESSION['usuario_id'];
$mensagem = $_POST['mensagem'] ?? '';
$resposta_para = !empty($_POST['resposta_para']) ? $_POST['resposta_para'] : null;

$arquivo_nome = null;

/* UPLOAD */
if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === 0) {
    $pasta = "uploads/comida/";

    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $arquivo_nome = time() . "_" . basename($_FILES['arquivo']['name']);
    $destino = $pasta . $arquivo_nome;

    move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino);
}

/* INSERÇÃO */
$sql = "INSERT INTO chat_grupo_comida (user_id, mensagem, arquivo, resposta_para, data_envio) 
        VALUES (?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar: " . $conn->error);
}

$stmt->bind_param("isss", $user_id, $mensagem, $arquivo_nome, $resposta_para);

if (!$stmt->execute()) {
    die("Erro ao enviar: " . $stmt->error);
}

header("Location: comida.php");
exit;
