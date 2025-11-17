<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_POST['id'];
$usuario = $_SESSION['usuario_id'];

/* Verificar se a mensagem pertence ao usuário */
$stmt = $conn->prepare("SELECT arquivo FROM chat_grupo_filmes WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $usuario);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {

    /* Apagar arquivo se existir */
    $stmt->bind_result($arquivo);
    $stmt->fetch();

    if ($arquivo && file_exists($arquivo)) {
        unlink($arquivo);
    }

    /* Apagar respostas vinculadas */
    $deleteResp = $conn->prepare("DELETE FROM chat_grupo_filmes WHERE resposta_para = ?");
    $deleteResp->bind_param("i", $id);
    $deleteResp->execute();

    /* Apagar mensagem principal */
    $delete = $conn->prepare("DELETE FROM chat_grupo_filmes WHERE id = ?");
    $delete->bind_param("i", $id);
    $delete->execute();
}

header("Location: filmes.php");
exit();
?>
