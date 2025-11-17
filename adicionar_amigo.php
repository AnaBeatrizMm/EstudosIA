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
    $id_solicitacao = $conn->insert_id;
    $mensagem = "Você recebeu uma solicitação de amizade";
    $data_criacao = date('Y-m-d H:i:s');

    $stmt_notif = $conn->prepare("INSERT INTO notificacoes (usuario_id, tipo, mensagem, referencia_id, lida, data_criacao) VALUES (?, 'amizade', ?, ?, 0, ?)");
    if (!$stmt_notif) {
        echo json_encode(['status'=>'erro','mensagem'=>'Erro no prepare de notificacao: '.$conn->error]);
        exit;
    }

    if (!$stmt_notif->bind_param("isis", $para_usuario_id, $mensagem, $id_solicitacao, $data_criacao)) {
        echo json_encode(['status'=>'erro','mensagem'=>'Erro no bind_param de notificacao: '.$stmt_notif->error]);
        exit;
    }

    if (!$stmt_notif->execute()) {
        echo json_encode(['status'=>'erro','mensagem'=>'Erro no execute de notificacao: '.$stmt_notif->error]);
        exit;
    }

    $stmt_notif->close();
    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Solicitação enviada!']);
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao enviar solicitação: '.$stmt->error]);
}
?>
