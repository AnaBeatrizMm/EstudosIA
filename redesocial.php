<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
$usuario_logado = intval($_SESSION['usuario_id']);

// Busca info do logado (nome/foto)
$stmt = $conn->prepare("SELECT nome, foto FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_logado);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    $_SESSION['usuario_nome'] = $row['nome'];
    $_SESSION['usuario_foto'] = $row['foto'];
} else {
    $_SESSION['usuario_nome'] = 'Usuário';
    $_SESSION['usuario_foto'] = 'imagens/usuarios/default.jpg';
}
$stmt->close();

// Enviar post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['conteudo'])) {
    $conteudo = $_POST['conteudo'];
    $imagem = '';
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $filename = 'imagens/posts/' . uniqid() . '.' . ($ext ?: 'jpg');
        if (!is_dir(dirname($filename))) mkdir(dirname($filename), 0755, true);
        move_uploaded_file($_FILES['imagem']['tmp_name'], $filename);
        $imagem = $filename;
    }
    $stmt = $conn->prepare("INSERT INTO posts (usuario_id, conteudo, imagem) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $usuario_logado, $conteudo, $imagem);
    $stmt->execute();
    $stmt->close();
    header("Location: redesocial.php");
    exit();
}

// Buscar posts
$sql = "SELECT p.id AS post_id, p.conteudo, p.imagem, p.usuario_id,
        u.nome, u.foto,
        (SELECT COUNT(*) FROM curtidas c WHERE c.id_post = p.id) AS total_curtidas,
        (SELECT COUNT(*) FROM comentarios cm WHERE cm.id_post = p.id) AS total_comentarios,
        (SELECT COUNT(*) FROM curtidas c2 WHERE c2.id_post = p.id AND c2.id_usuario = ?) AS ja_curti
    FROM posts p
    JOIN usuarios u ON p.usuario_id = u.id
    ORDER BY p.id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_logado);
$stmt->execute();
$res = $stmt->get_result();
$posts = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Carrega comentários antigos
$comentarios_posts = [];
foreach ($posts as $p) {
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

// Sugestões de amizade
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

// Notificações amizade
$sql_n = "SELECT n.id AS notif_id, n.mensagem, n.referencia_id, s.de_usuario_id, u.nome, u.foto
          FROM notificacoes n
          LEFT JOIN solicitacoes_amizade s ON n.referencia_id = s.id
          LEFT JOIN usuarios u ON s.de_usuario_id = u.id
          WHERE n.usuario_id = ? AND n.lida = 0 AND n.tipo = 'amizade'
          ORDER BY n.data_criacao DESC";
$stmt = $conn->prepare($sql_n);
$stmt->bind_param("i", $usuario_logado);
$stmt->execute();
$res = $stmt->get_result();
$notificacoes = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Rede Social</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root{--bg:#bdebe3ff;--primary:#3f7c72ff;--white:#fff;--dark:#1e3834ff;}
body{font-family:Inter,Arial; background:var(--bg); margin:0; padding:0;}
header{background:var(--white); padding:12px 20px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 2px 10px rgba(0,0,0,0.08); position:sticky; top:0; z-index:10;}
header a{color:var(--dark); text-decoration:none; font-weight:700;}
.usuario{display:flex; align-items:center; gap:12px;}
.usuario img{width:46px;height:46px;border-radius:50%;object-fit:cover;border:2px solid var(--primary);}
.wrap{max-width:1200px;margin:24px auto;display:flex;gap:20px;padding:0 12px;}
.feed{flex:2.6;display:flex;flex-direction:column;gap:18px;}
.sidebar{flex:1;background:var(--white);border-radius:12px;padding:14px;box-shadow:0 6px 18px rgba(0,0,0,0.06);height:fit-content;}
.card{background:var(--white);padding:18px;border-radius:12px;box-shadow:0 6px 18px rgba(0,0,0,0.06);}
#novo-post textarea{width:100%;min-height:80px;border-radius:10px;padding:10px;border:1px solid #ddd;resize:vertical;}
#novo-post .file-label{display:inline-block;margin-top:10px;background:var(--primary);color:var(--white);padding:8px 12px;border-radius:10px;cursor:pointer;font-weight:700;}
#novo-post button{float:right;margin-top:10px;background:var(--primary);color:var(--white);padding:8px 14px;border-radius:10px;border:none;cursor:pointer;font-weight:700;}
.post{border-radius:12px;padding:16px;background:var(--white);position:relative;}
.post .user{display:flex;align-items:center;gap:12px;cursor:pointer;}
.post .user img{width:52px;height:52px;border-radius:50%;object-fit:cover;border:2px solid var(--primary);}
.post p{margin:12px 0;white-space:pre-wrap;color:#222;}
.post img.content-img{width:100%;border-radius:10px;max-height:420px;object-fit:cover;margin-top:8px;}
.post-actions{display:flex;gap:12px;margin-top:12px;align-items:center;}
.post-actions button{background:none;border:none;cursor:pointer;color:var(--primary);display:flex;gap:8px;align-items:center;font-weight:700;}
.delete-post{position:absolute;right:12px;top:12px;color:#c0392b;cursor:pointer;padding:6px;border-radius:6px;}
.delete-post:hover{background:#fceaea}
.comentario-box{display:flex;gap:8px;margin-top:12px;}
.comentario-box input{flex:1;padding:8px 12px;border-radius:10px;border:1px solid #ddd;}
.comentario-list{margin-top:12px;border-top:1px solid #f0f0f0;padding-top:10px;}
.comentario-item{display:flex;gap:8px;align-items:flex-start;margin-bottom:8px;}
.comentario-item img{width:34px;height:34px;border-radius:50%;object-fit:cover;border:2px solid var(--primary);}
.comentario-item .meta{font-size:14px;color:#333;}
.comentario-item .meta small{display:block;color:#666;font-size:12px;}
.notif{display:flex;align-items:center;gap:10px;padding:8px;border-radius:8px;border:1px solid #f0f0f0;margin-bottom:8px;}
.notif img{width:42px;height:42px;border-radius:50%;object-fit:cover;border:2px solid var(--primary);}
.notif .actions{margin-left:auto;display:flex;gap:8px;}
@media(max-width:1000px){.wrap{flex-direction:column}.sidebar{order:2}}
</style>
</head>
<body>

<header>
    <a href="inicio.php">Início</a>
    <div class="usuario">
        <img src="<?= htmlspecialchars($_SESSION['usuario_foto'] ?: 'imagens/usuarios/default.jpg') ?>" alt="">
        <div>Bem-vindo(a), <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong></div>
    </div>
</header>

<div class="wrap">
  <div class="feed">
    <div class="card" id="novo-post">
      <form method="POST" enctype="multipart/form-data">
        <textarea name="conteudo" placeholder="O que você está pensando?" required></textarea>
        <label class="file-label" for="imagem"><i class="fa-solid fa-image"></i> Escolher arquivo</label>
        <input id="imagem" name="imagem" type="file" accept="image/*" style="display:none;">
        <button type="submit">Postar</button>
      </form>
    </div>

    <?php foreach($posts as $post): ?>
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
            <i class="fa-regular fa-heart" id="icon-heart-<?= $post['post_id'] ?>"></i>
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
  </div>

  <div class="sidebar">
    <h3>Sugestões</h3>
    <?php foreach($sugestoes as $s): ?>
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
        <img src="<?= htmlspecialchars($s['foto'] ?: 'imagens/usuarios/default.jpg') ?>" style="width:46px;height:46px;border-radius:50%;object-fit:cover;border:2px solid var(--primary);">
        <div><?= htmlspecialchars($s['nome']) ?></div>
c
      </div>
    <?php endforeach; ?>

    <hr style="margin:14px 0;">
    <h3>Notificações</h3>
    <div id="lista-notificacoes">
      <?php if(!empty($notificacoes)): ?>
        <?php foreach($notificacoes as $n): ?>
          <div class="notif" id="notif-<?= $n['notif_id'] ?>">
            <img src="<?= htmlspecialchars($n['foto'] ?: 'imagens/usuarios/default.jpg') ?>" alt="">
            <div><strong><?= htmlspecialchars($n['nome'] ?: 'Usuário') ?></strong><div style="font-size:13px;color:#444;"><?= htmlspecialchars($n['mensagem']) ?></div></div>
            <div class="actions">
              <button onclick="responderSolicitacao(<?= intval($n['referencia_id']) ?>,'aceita')" style="background:#3f7c72;color:#fff;border:none;padding:6px 10px;border-radius:8px;cursor:pointer;">Aceitar</button>
              <button onclick="responderSolicitacao(<?= intval($n['referencia_id']) ?>,'recusada')" style="background:#ccc;color:#000;border:none;padding:6px 10px;border-radius:8px;cursor:pointer;">Recusar</button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div>Sem notificações.</div>
      <?php endif; ?>
    </div>

    <hr style="margin:14px 0;">
    <h3>Amigos Online</h3>
    <div id="amigos-online">
      Carregando...
    </div>
  </div>
</div>

<div id="modal" style="display:none;position:fixed;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.5);align-items:center;justify-content:center;z-index:1000;">
  <div style="background:#fff;padding:20px;border-radius:12px;max-width:420px;width:90%;position:relative;">
    <button onclick="fecharModal()" style="position:absolute;right:12px;top:12px;background:none;border:none;font-size:18px;cursor:pointer;">&times;</button>
    <div id="info-usuario">Carregando...</div>
  </div>
</div>

<script>
function fecharModal(){ document.getElementById('modal').style.display = 'none'; }

function curtirPost(postId){
  fetch('curtir_ajax.php?post_id='+postId)
    .then(r=>r.json()).then(data=>{
      if(data.status==='sucesso'){
        document.getElementById('curtidas-'+postId).innerText = data.total;
        const icon = document.getElementById('icon-heart-'+postId);
        icon.className = data.ja_curti ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
      } else alert('Erro ao curtir');
    });
}
function abrirPerfil(usuarioId) {
  fetch('perfil_ajax.php?id=' + usuarioId)
    .then(res => res.text())
    .then(html => {
      const modal = document.createElement('div');
      modal.className = 'modal-perfil';
      modal.innerHTML = html;
      document.body.appendChild(modal);

      modal.addEventListener('click', e => {
        if (e.target.classList.contains('modal-perfil')) modal.remove();
      });
    })
    .catch(err => console.error('Erro ao carregar perfil:', err));
}

// Listener para quando clicarem em um avatar de comentário
document.addEventListener('click', e => {
  const avatar = e.target.closest('.avatar-comentario');
  if (avatar && avatar.dataset.usuarioId) {
    abrirPerfil(avatar.dataset.usuarioId);
  }
});
function toggleComentarioBox(postId){
  const box = document.getElementById('comentario-box-'+postId);
  box.style.display = box.style.display==='none'?'flex':'none';
}

function enviarComentario(postId){
  const input = document.getElementById('input-comentario-'+postId);
  const conteudo = input.value.trim();
  if(!conteudo) return;
  fetch('comentar_ajax.php',{
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:'post_id='+postId+'&conteudo='+encodeURIComponent(conteudo)
  }).then(r=>r.json()).then(data=>{
    if(data.status==='sucesso'){
      document.getElementById('comentarios-'+postId).innerText = data.total;
      const lista = document.getElementById('lista-comentarios-'+postId);
      const div = document.createElement('div');
      div.className = 'comentario-item';
      div.innerHTML = '<img src="<?= htmlspecialchars($_SESSION['usuario_foto'] ?: 'imagens/usuarios/default.jpg') ?>"/><div class="meta"><strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong><small>Agora</small><div>'+escapeHtml(conteudo)+'</div></div>';
      lista.appendChild(div);
      input.value='';
    } else alert('Erro ao enviar comentário');
  });
}

function excluirPost(postId){
  if(!confirm('Tem certeza que deseja excluir este post?')) return;
  fetch('excluir_post.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:'post_id='+postId})
    .then(r=>r.json()).then(data=>{
      if(data.status==='sucesso') document.getElementById('post-'+postId).remove();
      else alert(data.mensagem||'Erro');
    });
}

function adicionarAmigo(destinatario){
  fetch('adicionar_amigo.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:'destinatario='+destinatario})
    .then(r=>r.json()).then(data=>{
      alert(data.mensagem);
      location.reload();
    });
}

function responderSolicitacao(id,resposta){
  fetch('responder_solicitacao.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:'id_solicitacao='+id+'&resposta='+resposta})
    .then(r=>r.json()).then(data=>{
      alert(data.mensagem);
      if(data.status==='sucesso'){
        const notif = document.getElementById('notif-'+id);
        if(notif) notif.remove();
        atualizarAmigosOnline();
      }
    });
}
function escapeHtml(text){return text.replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));}
</script>
<script>
function abrirModal(usuarioId) {
  const modal = document.getElementById('modal');
  const info = document.getElementById('info-usuario');

  modal.style.display = 'flex';
  info.innerHTML = 'Carregando...';

  // Faz a requisição AJAX para pegar o perfil
  fetch('perfil_ajax.php?perfil_usuario_id=' + usuarioId)
    .then(response => response.text())
    .then(html => {
      info.innerHTML = html;
    })
    .catch(err => {
      info.innerHTML = '<p style="color:red;">Erro ao carregar perfil.</p>';
      console.error(err);
    });
}
</script>
</body>
</html>
