<?php
session_start();
include 'conexao.php';
if(!isset($_SESSION['usuario_id'])) exit();
$usuario_logado = intval($_SESSION['usuario_id']);

$sql = "SELECT u.id, u.nome, u.foto FROM usuarios u
        JOIN amizades a ON (u.id = a.id_usuario1 OR u.id = a.id_usuario2)
        WHERE (a.id_usuario1 = ? OR a.id_usuario2 = ?) AND u.online = 1 AND u.id != ?
        LIMIT 10";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $usuario_logado, $usuario_logado, $usuario_logado);
$stmt->execute();
$res = $stmt->get_result();
$amigos = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if(!empty($amigos)){
    foreach($amigos as $a){
        echo '<div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                <img src="'.htmlspecialchars($a['foto'] ?: 'imagens/usuarios/default.jpg').'" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid #3f7c72;">
                <div>'.htmlspecialchars($a['nome']).'</div>
              </div>';
    }
}else{
    echo "Nenhum amigo online.";
}
