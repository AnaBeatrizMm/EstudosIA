<?php
session_start();
include 'conexao.php';
if(!isset($_SESSION['usuario_id'])) exit();
$usuario_logado = intval($_SESSION['usuario_id']);

$sql = "SELECT n.id AS notif_id, n.mensagem, n.referencia_id, s.de_usuario_id, u.nome, u.foto
        FROM notificacoes n
        LEFT JOIN solicitacoes_amizade s ON n.referencia_id = s.id
        LEFT JOIN usuarios u ON s.de_usuario_id = u.id
        WHERE n.usuario_id = ? AND n.lida = 0 AND n.tipo = 'amizade'
        ORDER BY n.data_criacao DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_logado);
$stmt->execute();
$res = $stmt->get_result();
$notificacoes = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if(!empty($notificacoes)){
    foreach($notificacoes as $n): ?>
    <div class="notif" id="notif-<?= $n['notif_id'] ?>">
      <img src="<?= htmlspecialchars($n['foto'] ?: 'imagens/usuarios/default.jpg') ?>" alt="">
      <div><strong><?= htmlspecialchars($n['nome'] ?: 'Usuário') ?></strong>
      <div style="font-size:13px;color:#444;"><?= htmlspecialchars($n['mensagem']) ?></div></div>
      <div class="actions">
        <button onclick="responderSolicitacao(<?= intval($n['referencia_id']) ?>,'aceita')" style="background:#3f7c72;color:#fff;border:none;padding:6px 10px;border-radius:8px;cursor:pointer;">Aceitar</button>
        <button onclick="responderSolicitacao(<?= intval($n['referencia_id']) ?>,'recusada')" style="background:#ccc;color:#000;border:none;padding:6px 10px;border-radius:8px;cursor:pointer;">Recusar</button>
      </div>
    </div>
<?php endforeach;
}else{
    echo "<div>Sem notificações.</div>";
}
