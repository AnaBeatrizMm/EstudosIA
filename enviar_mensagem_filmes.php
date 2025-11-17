<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['usuario_id'];
$mensagem = $_POST['mensagem'] ?? '';
$resposta_para = $_POST['resposta_para'] ?? null;
$arquivo = null;

/* UPLOAD */
if (!empty($_FILES['arquivo']['name'])) {

    if (!is_dir("uploads_filmes")) {
        mkdir("uploads_filmes", 0777, true);
    }

    $nome = time() . "_" . basename($_FILES['arquivo']['name']);
    $destino = "uploads_filmes/" . $nome;

    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino)) {
        $arquivo = $destino;
    }
}

/* SALVAR NO BANCO */
$stmt = $conn->prepare("
    INSERT INTO chat_grupo_filmes (user_id, mensagem, arquivo, resposta_para)
    VALUES (?, ?, ?, ?)
");

$stmt->bind_param("issi", $user_id, $mensagem, $arquivo, $resposta_para);
$stmt->execute();
$stmt->close();

header("Location: filmes.php");
exit();
?>
