<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['usuario_id'];
$mensagem = $_POST['mensagem'];
$resposta_para = $_POST['resposta_para'] ?? NULL;

$arquivo_path = null;

if (!empty($_FILES['arquivo']['name'])) {
    $pasta = "uploads/musica/";
    if (!is_dir($pasta)) mkdir($pasta, 0777, true);

    $arquivo = $pasta . time() . "_" . basename($_FILES['arquivo']['name']);
    move_uploaded_file($_FILES['arquivo']['tmp_name'], $arquivo);

    $arquivo_path = $arquivo;
}

$stmt = $conn->prepare("
    INSERT INTO chat_grupo_musica (user_id, mensagem, arquivo, resposta_para)
    VALUES (?,?,?,?)
");

$stmt->bind_param("isss", $user_id, $mensagem, $arquivo_path, $resposta_para);
$stmt->execute();

header("Location: musica.php");
exit();
