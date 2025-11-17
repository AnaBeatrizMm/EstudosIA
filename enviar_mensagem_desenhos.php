<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['usuario_id'];
$mensagem = $_POST['mensagem'] ?? '';
$resposta_para = $_POST['resposta_para'] ?? NULL;
$arquivoPath = NULL;

/* UPLOAD DE ARQUIVO */
if (!empty($_FILES['arquivo']['name'])) {
    $pasta = "uploads/";
    if (!is_dir($pasta)) mkdir($pasta);

    $nomeArquivo = time() . "_" . basename($_FILES['arquivo']['name']);
    $caminhoCompleto = $pasta . $nomeArquivo;

    move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminhoCompleto);
    $arquivoPath = $caminhoCompleto;
}

/* SALVAR NO BANCO */
$stmt = $conn->prepare("
    INSERT INTO chat_grupo_desenhos (user_id, mensagem, arquivo, resposta_para)
    VALUES (?, ?, ?, ?)
");

$stmt->bind_param("issi", $user, $mensagem, $arquivoPath, $resposta_para);
$stmt->execute();
$stmt->close();

header("Location: desenhos.php");
exit();
?>
