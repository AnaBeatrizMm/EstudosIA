<?php
session_start();
include 'conexao.php';

header('Content-Type: application/json');

// Verifica login
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status'=>'erro','mensagem'=>'Não logado']);
    exit();
}

$usuario_id = intval($_SESSION['usuario_id']);
$id_solicitacao = intval($_POST['id_solicitacao'] ?? 0);
$resposta = strtolower(trim($_POST['resposta'] ?? ''));

if (!$id_solicitacao || !in_array($resposta, ['aceita','recusada'])) {
    echo json_encode(['status'=>'erro','mensagem'=>'Solicitação ou resposta inválida']);
    exit();
}

// Busca solicitação e garante que o usuário é o destinatário
$stmt = $conn->prepare("
    SELECT s.id, s.de_usuario_id, s.para_usuario_id, n.id AS notif_id
    FROM solicitacoes_amizade s
    LEFT JOIN notificacoes n ON n.referencia_id = s.id AND n.usuario_id = ?
    WHERE s.id = ?
    LIMIT 1
");
$stmt->bind_param("ii", $usuario_id, $id_solicitacao);
$stmt->execute();
$res = $stmt->get_result();
if(!$res || $res->num_rows === 0){
    echo json_encode(['status'=>'erro','mensagem'=>'Solicitação não encontrada']);
    exit();
}
$sol = $res->fetch_assoc();
$stmt->close();

// Confirma que o usuário é destinatário
if ($sol['para_usuario_id'] != $usuario_id) {
    echo json_encode(['status'=>'erro','mensagem'=>'Você não pode responder a esta solicitação']);
    exit();
}

// Aceitar solicitação
if ($resposta === 'aceita') {
    // Cria amizade
    $stmt = $conn->prepare("INSERT INTO amizades (id_usuario1, id_usuario2) VALUES (?, ?)");
    $stmt->bind_param("ii", $sol['de_usuario_id'], $sol['para_usuario_id']);
    $stmt->execute();
    $stmt->close();
}

// Remove solicitação
$stmt = $conn->prepare("DELETE FROM solicitacoes_amizade WHERE id = ?");
$stmt->bind_param("i", $id_solicitacao);
$stmt->execute();
$stmt->close();

// Remove notificação relacionada
$stmt = $conn->prepare("DELETE FROM notificacoes WHERE referencia_id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $id_solicitacao, $usuario_id);
$stmt->execute();
$stmt->close();

// Retorna resposta
echo json_encode([
    'status'=>'sucesso',
    'mensagem'=> $resposta === 'aceita' ? 'Solicitação aceita' : 'Solicitação recusada',
    'notif_id'=> $id_solicitacao,
    'novo_amigo_id'=> $resposta === 'aceita' ? $sol['de_usuario_id'] : null
]);
?>
