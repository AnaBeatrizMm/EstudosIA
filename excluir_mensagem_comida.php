<?php
session_start();
require_once "conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado.");
}

$id = $_POST['id'] ?? null;
$usuario = $_SESSION['usuario_id'];

if (!$id) {
    die("ID inválido.");
}

/* CONFIRMAR SE A MENSAGEM PERTENCE AO USUÁRIO */
$check = $conn->prepare("SELECT arquivo FROM chat_grupo_comida WHERE id = ? AND user_id = ?");
$check->bind_param("ii", $id, $usuario);
$check->execute();
$result = $check->get_result();

if ($result->num_rows === 0) {
    die("Você não pode excluir esta mensagem.");
}

$dados = $result->fetch_assoc();

/* EXCLUI ARQUIVO */
if (!empty($dados["arquivo"]) && file_exists($dados["arquivo"])) {
    unlink($dados["arquivo"]);
}

/* EXCLUI RESPOSTAS VINCULADAS */
$conn->query("DELETE FROM chat_grupo_comida WHERE resposta_para = $id");

/* EXCLUI A MENSAGEM */
$del = $conn->prepare("DELETE FROM chat_grupo_comida WHERE id = ?");
$del->bind_param("i", $id);
$del->execute();

header("Location: comida.php");
exit;
