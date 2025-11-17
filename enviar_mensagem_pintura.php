<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['usuario_id'];
$mensagem = $_POST['mensagem'];
$resposta_para = $_POST['resposta_para'] ?? null;

$arquivo_path = null;

if (!empty($_FILES['arquivo']['name'])) {
    $pasta = "uploads/pintura/";
    if (!is_dir($pasta)) mkdir($pasta, 0777, true);

    $nomeArquivo = time() . "_" . basename($_FILES["arquivo"]["name"]);
    $arquivo_path = $pasta . $nomeArquivo;

    move_uploaded_file($_FILES["arquivo"]["tmp_name"], $arquivo_path);
}

$stmt = $conn->prepare("
INSERT INTO chat_grupo_pintura (user_id, mensagem, arquivo, resposta_para)
VALUES (?, ?, ?, ?)");
$stmt->bind_param("issi", $user_id, $mensagem, $arquivo_path, $resposta_para);
$stmt->execute();
$stmt->close();

header("Location: pintura.php");
exit();
