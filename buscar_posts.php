<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    exit(json_encode(['status' => 'erro', 'mensagem' => 'Não logado']));
}

$ultimo_id = isset($_GET['ultimo_id']) ? intval($_GET['ultimo_id']) : 0;

$sql = "SELECT p.id AS post_id, p.conteudo, p.imagem, p.usuario_id, 
               u.nome, u.foto
        FROM posts p
        JOIN usuarios u ON p.usuario_id = u.id
        WHERE p.id > ?
        ORDER BY p.id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ultimo_id);
$stmt->execute();
$res = $stmt->get_result();
$posts = $res->fetch_all(MYSQLI_ASSOC);

echo json_encode(['status' => 'sucesso', 'posts' => $posts]);
