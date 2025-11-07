<?php
session_start();
include 'conexao.php';
if(!isset($_SESSION['usuario_id'])) exit();
$usuario_logado = intval($_SESSION['usuario_id']);

$sql_s = "SELECT u.id, u.nome, u.foto FROM usuarios u
          WHERE u.id != ? 
          AND u.id NOT IN (
             SELECT CASE WHEN a.id_usuario1 = ? THEN a.id_usuario2 ELSE a.id_usuario1 END
             FROM amizades a WHERE a.id_usuario1 = ? OR a.id_usuario2 = ?
          )
          LIMIT 6";
$stmt = $conn->prepare($sql_s);
$stmt->bind_param("iiii", $usuario_logado, $usuario_logado, $usuario_logado, $usuario_logado);
$stmt->execute();
$res = $stmt->get_result();
$sugestoes = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();

foreach($sugestoes as $s){
    echo '<div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
            <img src="'.htmlspecialchars($s['foto'] ?: 'imagens/usuarios/default.jpg').'" style="width:46px;height:46px;border-radius:50%;object-fit:cover;border:2px solid #3f7c72;">
            <div style="flex:1;">'.htmlspecialchars($s['nome']).'</div>
            <button onclick="adicionarAmigo('.intval($s['id']).')" 
                    style="background:#3f7c72;color:#fff;border:none;padding:6px 10px;border-radius:8px;cursor:pointer;font-weight:700;">
              Adicionar
            </button>
          </div>';
}
