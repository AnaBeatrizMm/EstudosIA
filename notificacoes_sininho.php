<?php
// Sem nada antes do <?php — NADA (nem espaços, nem BOM)

// Inicia buffer e remove headers/saídas anteriores
ob_start();
header_remove();

// Evita mostrar warnings/notices que "quebram" JSON em produção
error_reporting(0);
ini_set('display_errors', '0');

// Força JSON
header('Content-Type: application/json; charset=utf-8');

session_start();

// Inclua a conexão — GARANTA que conexao.php não imprime nada (ver checklist abaixo)
require_once 'conexao.php';

// Pega id do usuário (0 se não logado)
$usuario_id = intval($_SESSION['usuario_id'] ?? 0);
if (!$usuario_id) {
    echo json_encode(['html' => '<p>Não logado</p>', 'count' => 0], JSON_UNESCAPED_UNICODE);
    exit;
}

// Consulta notificações
$sql = "SELECT n.id AS notif_id, n.mensagem, u.nome, u.foto
        FROM notificacoes n
        LEFT JOIN usuarios u ON n.usuario_id = u.id
        WHERE n.usuario_id = ? AND n.lida = 0
        ORDER BY n.data_criacao DESC
        LIMIT 25";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    // Erro na preparação — não devolve detalhes ao cliente para não vazar info
    echo json_encode(['html' => '<p>Erro no servidor</p>', 'count' => 0], JSON_UNESCAPED_UNICODE);
    exit;
}

$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$res = $stmt->get_result();

$count = $res ? $res->num_rows : 0;
$html = '';

// quando não houver notificações
if ($count === 0) {
    // retorna texto simples em vez de HTML pronto
    $html = 'Sem notificações novas';
}  else {
    while ($row = $res->fetch_assoc()) {
        $nome = htmlspecialchars($row['nome']);
        $foto = (!empty($row['foto']) && file_exists($row['foto'])) ? $row['foto'] : 'imagens/usuarios/default.jpg';
        $mensagem = htmlspecialchars($row['mensagem']);
        $html .= "<div class='notif-item'>
                    <img src='$foto' class='notif-avatar' alt='avatar'>
                    <span><strong>$nome</strong>: $mensagem</span>
                  </div>";
    }
}

$stmt->close();

// Garante que só JSON seja enviado
ob_clean();
echo json_encode(['html' => $html, 'count' => $count], JSON_UNESCAPED_UNICODE);
exit;
?>