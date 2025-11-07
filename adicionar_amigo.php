<?php
session_start();
include 'conexao.php';

header('Content-Type: application/json');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Não logado']);
    exit();
}

$de_usuario_id = intval($_SESSION['usuario_id']);
$para_usuario_id = intval($_POST['destinatario'] ?? 0);

if (!$para_usuario_id) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário inválido']);
    exit();
}

// Verifica se já existe solicitação pendente
$stmt = $conn->prepare("SELECT id FROM solicitacoes_amizade WHERE de_usuario_id=? AND para_usuario_id=? AND status='pendente'");
$stmt->bind_param("ii", $de_usuario_id, $para_usuario_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Solicitação já enviada']);
    exit();
}
$stmt->close();

// Insere a nova solicitação
$stmt = $conn->prepare("INSERT INTO solicitacoes_amizade (de_usuario_id, para_usuario_id, status, criado_em) VALUES (?, ?, 'pendente', NOW())");
$stmt->bind_param("ii", $de_usuario_id, $para_usuario_id);

if ($stmt->execute()) {
    // Cria notificação para o usuário destinatário
    $id_solicitacao = $conn->insert_id;
    $mensagem = "Você recebeu uma solicitação de amizade";
    $data_criacao = date('Y-m-d H:i:s'); // Usando PHP para data

    $stmt_notif = $conn->prepare("INSERT INTO notificacoes (usuario_id, tipo, mensagem, referencia_id, lida, data_criacao) VALUES (?, 'amizade', ?, ?, 0, ?)");
    $stmt_notif->bind_param("isis", $para_usuario_id, $mensagem, $id_solicitacao, $data_criacao);
    $stmt_notif->execute();
    $stmt_notif->close();

    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Solicitação enviada!']);
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao enviar solicitação']);
}

$stmt->close();
?>
