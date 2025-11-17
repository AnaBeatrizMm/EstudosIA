<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_logado = $_SESSION['usuario_id'];

if (!isset($_POST['id'])) {
    header("Location: jogos.php");
    exit();
}

$id = intval($_POST['id']);

/* VERIFICAR SE A MENSAGEM É DO USUÁRIO */
$stmt = $conn->prepare("SELECT arquivo, user_id FROM chat_grupo_jogos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: jogos.php");
    exit();
}

$msg = $result->fetch_assoc();

if ($msg['user_id'] != $usuario_logado) {
    header("Location: jogos.php");
    exit();
}

/* EXCLUIR ARQUIVO DA MENSAGEM PRINCIPAL */
if (!empty($msg['arquivo']) && file_exists($msg['arquivo'])) {
    unlink($msg['arquivo']);
}

/* BUSCAR E EXCLUIR ARQUIVOS DAS RESPOSTAS */
$stmt = $conn->prepare("SELECT arquivo FROM chat_grupo_jogos WHERE resposta_para = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

while ($r = $res->fetch_assoc()) {
    if (!empty($r['arquivo']) && file_exists($r['arquivo'])) {
        unlink($r['arquivo']);
    }
}

/* EXCLUI TODAS AS RESPOSTAS DA MENSAGEM */
$stmt = $conn->prepare("DELETE FROM chat_grupo_jogos WHERE resposta_para = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

/* EXCLUI A MENSAGEM PRINCIPAL */
$stmt = $conn->prepare("DELETE FROM chat_grupo_jogos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

/* VOLTAR PARA O CHAT */
header("Location: jogos.php");
exit();
?>
