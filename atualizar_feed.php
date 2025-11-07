<?php
session_start();
include 'conexao.php';

if(!isset($_SESSION['usuario_id'])) exit();
$usuario_logado = intval($_SESSION['usuario_id']);

// Buscar posts mais recentes
$sql = "SELECT p.id AS post_id, p.conteudo, p.imagem, p.usuario_id,
        u.nome, u.foto,
        (SELECT COUNT(*) FROM curtidas c WHERE c.id_post = p.id) AS total_curtidas,
        (SELECT COUNT(*) FROM comentarios cm WHERE cm.id_post = p.id) AS total_comentarios,
        (SELECT COUNT(*) FROM curtidas c2 WHERE c2.id_post = p.id AND c2.id_usuario = ?) AS ja_curti
    FROM posts p
    JOIN usuarios u ON p.usuario_id = u.id
    ORDER BY p.id DESC LIMIT 20";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_logado);
$stmt->execute();
$res = $stmt->get_result();
$posts = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Carregar comentários recentes
$comentarios_posts = [];
foreach($posts as $p){
    $stmt = $conn->prepare("SELECT cm.id, cm.conteudo, cm.data_criacao, u.id AS usuario_id, u.nome, u.foto
                            FROM comentarios cm
                            JOIN usuarios u ON cm.id_usuario = u.id
                            WHERE cm.id_post = ? ORDER BY cm.id ASC");
    $stmt->bind_param("i", $p['post_id']);
    $stmt->execute();
    $res = $stmt->get_result();
    $comentarios_posts[$p['post_id']] = $res->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// Gerar HTML parcial
foreach($posts as $post): ?>
<div class="post card" id="post-<?= $post['post_id'] ?>">
    <?php if($post['usuario_id'] == $usuario_logado): ?>
      <span class="delete-post" onclick="excluirPost(<?= $post['post_id'] ?>)" title="Excluir post">
        <i class="fa-solid fa-trash"></i>
      </span>
    <?php endif; ?>

    <div class="user" onclick="abrirModal(<?= $post['usuario_id'] ?>)">
      <img src="<?= htmlspecialchars($post['foto'] ?: 'imagens/usuarios/default.jpg') ?>" alt="">
      <strong><?= htmlspecialchars($post['nome']) ?></strong>
    </div>

    <p><?= nl2br(htmlspecialchars($post['conteudo'])) ?></p>
    <?php if(!empty($post['imagem'])): ?>
      <img class="content-img" src="<?= htmlspecialchars($post['imagem']) ?>" alt="">
    <?php endif; ?>

    <div class="post-actions">
      <button onclick="curtirPost(<?= $post['post_id'] ?>)" title="Curtir">
        <i class="<?= $post['ja_curti'] ? 'fa-solid' : 'fa-regular' ?> fa-heart" id="icon-heart-<?= $post['post_id'] ?>"></i>
        <span id="curtidas-<?= $post['post_id'] ?>"><?= $post['total_curtidas'] ?></span>
      </button>

      <button onclick="toggleComentarioBox(<?= $post['post_id'] ?>)" title="Comentar">
        <i class="fa-regular fa-comment"></i>
        <span id="comentarios-<?= $post['post_id'] ?>"><?= $post['total_comentarios'] ?></span>
      </button>
    </div>

    <div class="comentario-box" id="comentario-box-<?= $post['post_id'] ?>" style="display:none;">
      <input id="input-comentario-<?= $post['post_id'] ?>" placeholder="Escreva um comentário...">
      <button onclick="enviarComentario(<?= $post['post_id'] ?>)">Enviar</button>
    </div>

    <div class="comentario-list" id="lista-comentarios-<?= $post['post_id'] ?>">
      <?php if(!empty($comentarios_posts[$post['post_id']])): ?>
        <?php foreach($comentarios_posts[$post['post_id']] as $c): ?>
          <div class="comentario-item">
            <img src="<?= htmlspecialchars($c['foto'] ?: 'imagens/usuarios/default.jpg') ?>" alt="">
            <div class="meta"><strong><?= htmlspecialchars($c['nome']) ?></strong><small><?= htmlspecialchars($c['data_criacao']) ?></small><div><?= nl2br(htmlspecialchars($c['conteudo'])) ?></div></div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>
