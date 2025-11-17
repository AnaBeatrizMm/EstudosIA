<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    exit("Acesso negado");
}

$user_id = $_SESSION['usuario_id'];
$mensagem = $_POST['mensagem'];
$resposta_para = isset($_POST['resposta_para']) ? $_POST['resposta_para'] : NULL;
$arquivo_path = NULL;

/* UPLOAD DO ARQUIVO */
if (!empty($_FILES['arquivo']['name'])) {
    $pasta = "uploads/animes/";
    if (!is_dir($pasta)) mkdir($pasta, 0777, true);

    $nomeArquivo = time() . "_" . basename($_FILES["arquivo"]["name"]);
    $arquivo_path = $pasta . $nomeArquivo;

    move_uploaded_file($_FILES["arquivo"]["tmp_name"], $arquivo_path);
}

/* SALVAR */
$stmt = $conn->prepare("
INSERT INTO chat_grupo_animes (user_id, mensagem, arquivo, resposta_para)
VALUES (?, ?, ?, ?)
");

$stmt->bind_param("issi", $user_id, $mensagem, $arquivo_path, $resposta_para);
$stmt->execute();

header("Location: animes.php");
exit();
?>
