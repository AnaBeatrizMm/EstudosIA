<?php
session_start();
include 'conexao.php';

$usuario_id = intval($_SESSION['usuario_id'] ?? 0);
if (!$usuario_id) {
    echo "<p>Não logado</p>";
    exit;
}

// Pega notificações não lidas de amizade
$sql = "SELECT n.id AS notif_id, n.mensagem, u.nome, u.foto 
        FROM notificacoes n 
        LEFT JOIN usuarios u ON n.usuario_id = u.id 
        WHERE n.usuario_id = ? AND n.lida = 0 AND n.tipo = 'amizade'
        ORDER BY n.data_criacao DESC
        LIMIT 25";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "<p>Sem notificações novas</p>";
    exit;
}

while($row = $res->fetch_assoc()){
    $nome = htmlspecialchars($row['nome']);
    $foto = (!empty($row['foto']) && file_exists($row['foto'])) ? $row['foto'] : 'imagens/usuarios/default.jpg';
    $mensagem = htmlspecialchars($row['mensagem']);
    echo "<div class='notif-item'>
            <img src='$foto' class='notif-avatar'>
            <span><strong>$nome</strong>: $mensagem</span>
          </div>";
}

$stmt->close();
?>
