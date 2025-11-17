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
<?php
// Buscar amigos do usuário
$sql_amigos = "SELECT u.id, u.nome, u.foto 
               FROM usuarios u
               JOIN amizades a ON (u.id = a.id_usuario1 AND a.id_usuario2 = ?) 
                               OR (u.id = a.id_usuario2 AND a.id_usuario1 = ?)";
$stmt = $conn->prepare($sql_amigos);
$stmt->bind_param("ii", $usuario_logado, $usuario_logado);
$stmt->execute();
$res = $stmt->get_result();
$amigos = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Rede Social</title>
<link rel="icon" type="image/png" href="/anotacoes/imagens/icon site.png" sizes="612x612">
<link rel="stylesheet" href="estilo.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root{--bg:#bdebe3ff;--primary:#3f7c72ff;--white:#fff;--dark:#1e3834ff;}
body{font-family:Inter,Arial; background:var(--bg); margin:0; padding:0;background: url('https://i.pinimg.com/736x/08/e4/35/08e435bf1c146132594f8488b41b883a.jpg') no-repeat center center fixed;background-size: cover;}
header {
  background: var(--white);
  padding: 10px 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 2px 10px rgba(0,0,0,0.08);
  position: sticky;
  top: 0;
  z-index: 10;
}

/* Contêiner das bolinhas */
.bolinhas {
  display: flex;
  gap: 35px;
  align-items: center;
}

/* Cada bolinha */
.bolinhas a {
  position: relative;
  display: inline-block;
  text-decoration: none;
}

/* Imagem da bolinha */
.bolinhas a img {
  width: 55px;
  height: 55px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #3f7c72ff;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Efeito fofo ao passar o mouse */
.bolinhas a:hover img {
  transform: scale(1.15);
  box-shadow: 0 0 10px rgba(63, 124, 114, 0.5);
}

/* Texto flutuante ao passar o mouse */
.bolinhas a span {
  position: absolute;
  bottom: -15px;
  left: 50%;
  transform: translate(-50%, 10px);
  background: rgba(63, 124, 114, 0.9);
  color: white;
  font-size: 13px;
  font-weight: 600;
  padding: 5px 10px;
  border-radius: 8px;
  opacity: 0;
  pointer-events: none;
  transition: all 0.3s ease;
  white-space: nowrap;
}

/* Animação suave ao passar o mouse */
.bolinhas a:hover span {
  opacity: 1;
  transform: translate(-50%, -5px);
}

/* Agrupa foto e botão Voltar */
.usuario-area {
  display: flex;
  align-items: center;
  gap: 20px;
}

/* Foto do usuário */
.usuario img {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #3f7c72ff;
  transition: transform 0.2s ease;
}

.usuario img:hover {
  transform: scale(1.1);
}

.wrap{max-width:1100px;margin:24px auto;display:flex;gap:20px;padding:0 12px;}
.feed {
    flex: 2.6;
    display: flex;
    flex-direction: column;
    gap: 18px;
    margin-left: 50px; /* largura da barra + um pequeno espaço */
}
.sidebar{flex:1;background:var(--white);border-radius:12px;padding:14px;box-shadow:0 6px 18px rgba(0,0,0,0.06);height:fit-content;border: 12px solid 	#8FBC8F; /* borda visível */}
.card{background:#fff;padding:18px;border-radius:12px;box-shadow:0 6px 18px rgba(0,0,0,0.06);border: 12px solid 	#8FBC8F; /* borda visível */}
#novo-post textarea{width:97%;min-height:80px;border-radius:10px;padding:10px;border:1px solid #ddd;resize:vertical;}
#novo-post .file-label{display:inline-block;margin-top:10px;background:var(--primary);color:var(--white);padding:8px 12px;border-radius:10px;cursor:pointer;font-weight:700;}
#novo-post button{float:right;margin-top:10px;background:var(--primary);color:var(--white);padding:8px 14px;border-radius:10px;border:none;cursor:pointer;font-weight:700;}
.post {
  border-radius: 12px;
  padding: 16px;
  background: #fff;
  position: relative;
  border: 12px solid 	#8FBC8F; /* borda visível */
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); /* toque de profundidade */
}
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
/* Estilo da ul */
/* UL de voltar */
nav ul {
  list-style: none;
  display: flex;
  align-items: center;
  margin: 0;
  padding: 0;
}

nav ul li a {
  text-decoration: none;
  color: black;
  padding: 6px 12px;
  border-radius: 8px;
  font-weight: 600;
  transition: 0.3s;
}
.modal-perfil {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2000;
  animation: aparecer 0.25s ease;
}

@keyframes aparecer {
  from { opacity: 0; transform: scale(0.9); }
  to { opacity: 1; transform: scale(1); }
}

.modal-perfil .conteudo-perfil {
  background: white;
  border-radius: 16px;
  padding: 20px;
  max-width: 600px;
  width: 90%;
  max-height: 85%;
  overflow-y: auto;
  box-shadow: 0 4px 25px rgba(0,0,0,0.2);
  position: relative;
}

.modal-perfil .fechar {
  position: absolute;
  top: 10px; right: 15px;
  background: none;
  border: none;
  font-size: 22px;
  cursor: pointer;
  color: #444;
  transition: 0.2s;
}

.modal-perfil .fechar:hover {
  color: #b33;
}
</style>
<style>
#msg-flutuante {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #3f7c72;
    color: white;
    padding: 12px 18px;
    border-radius: 10px;
    font-size: 15px;
    box-shadow: 0px 4px 10px #00000044;
    opacity: 0;
    transition: opacity .3s;
    z-index: 9999;
}
#msg-flutuante.erro { background: #b33; }
/* Container do botão */
.amigos-lateral-container {
  position: fixed;
  top: 50px; /* ajuste conforme quiser */
  left: 0;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  z-index: 1000;
}

/* Checkbox escondido */
.amigos-lateral-container input {
  display: none;
}

/* Botão com seta */
.container {
  background: white;
  border: 2px solid #8f7c72;
  border-radius: 8px;
  padding: 10px 16px;
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
  font-weight: 600;
  position: relative;
  user-select: none;
}

.container .chevron-right {
  width: 20px;
  height: 20px;
  fill: #8f7c72;
  transition: transform 0.5s ease;
}

/* Gira a seta ao clicar */
input:checked + .container .chevron-right {
  transform: rotate(180deg);
}

/* Barra lateral de amigos */
#amigos-lateral {
  position: fixed;
  top: 0;
  left: -260px; /* começa escondida */
  width: 250px;
  height: 100vh;
  background: white;
  border-right: 2px solid #8f7c72;
  padding: 16px;
  box-shadow: 4px 0 12px rgba(0,0,0,0.1);
  transition: left 0.5s ease;
  overflow-y: auto;
  z-index: 999;
}
/* Mostra a barra ao clicar no checkbox */
input:checked ~ #amigos-lateral {
  left: 0;
}

/* Título da barra */
#amigos-lateral h3 {
    margin: 0;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
}


/* Amigos internos */
.amigo-item {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
  cursor: pointer;
}

.amigo-item:hover {
    background: rgba(63,124,114,0.1);
}

.amigo-item img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #8f7c72;
}
.amigo-item span {
    font-size: 14px;
    font-weight: 500;
    flex: 1;
}
</style>

<div id="msg-flutuante"></div>

<script>
function mostrarMensagem(texto, tipo){
    const msg = document.getElementById("msg-flutuante");

    msg.textContent = texto;

    msg.classList.remove("erro");
    if(tipo === "erro") msg.classList.add("erro");

    msg.style.opacity = "1";

    setTimeout(() => {
        msg.style.opacity = "0";
    }, 2500);
}
</script>
</head>
<body>

<header>
  <div class="bolinhas">
    <a href="chat_grupo.php">
      <img src="https://i.pinimg.com/1200x/e4/6d/1a/e46d1add185e813f4cc36b417128647f.jpg" alt="Estudos">
      <span>Estudos</span>
    </a>

    <a href="jogos.php">
      <img src="/imagens/renomear.jfif" alt="Jogos">
      <span>Jogos</span>
    </a>

    <a href="filmes.php">
      <img src="https://i.pinimg.com/736x/33/39/9d/33399df9faacc5de9e3928f52fabbacf.jpg" alt="Filmes e Séries">
      <span>Filmes e Séries</span>
    </a>

    <a href="desenhos.php">
      <img src="https://i.pinimg.com/736x/c0/c5/1d/c0c51db66d48aa18dc34ed1f89d68419.jpg" alt="Desenhos">
      <span>Desenhos</span>
    </a>

    <a href="animes.php">
      <img src="https://i.pinimg.com/736x/e2/d2/19/e2d219c83bd9741d6f35a8daab064355.jpg" alt="Animes">
      <span>Animes</span>
    </a>

    <a href="comida.php">
      <img src="https://i.pinimg.com/736x/45/f9/25/45f9250c4b1be495775d8c836c325a81.jpg" alt="Comida">
      <span>Comida</span>
    </a>

    <a href="costura.php">
      <img src="https://i.pinimg.com/1200x/7a/0f/d6/7a0fd63c19604cd60b7ac8d97db730c2.jpg" alt="Costura/Crochê">
      <span>Costura/Crochê</span>
    </a>

    <a href="pintura.php">
      <img src="https://i.pinimg.com/736x/a3/a3/28/a3a328afff89c2721b8b0e2f9b0eba37.jpg" alt="Pintura">
      <span>Pintura</span>
    </a>

    <a href="musica.php">
      <img src="https://i.pinimg.com/736x/bb/91/e0/bb91e06701db02de0d2fd2305be68d8c.jpg" alt="Música">
      <span>Música</span>
    </a>
  </div>

  <div class="usuario-area">
  <div class="usuario">
  <img 
  src="<?= htmlspecialchars($_SESSION['usuario_foto'] ?: 'imagens/usuarios/default.jpg') ?>" 
  alt="Foto do usuário" 
  onclick="abrirModal(<?= (int)$_SESSION['usuario_id'] ?>)" 
  style="cursor:pointer;">
</div>

    <nav>
      <ul>
        <li><a href="/inicio.php">Voltar</a></li>
      </ul>
    </nav>
  </div>
</header>

<!-- Modal de edição do usuário -->
<div id="modal-editar-usuario" style="
  display:none;
  position:fixed;
  top:0; left:0;
  width:100%; height:100%;
  background:rgba(0,0,0,0.5);
  align-items:center;
  justify-content:center;
  z-index:2000;
">
  <div style="
    background:white;
    border-radius:12px;
    width:90%;
    max-width:600px;
    height:80%;
    position:relative;
    box-shadow:0 0 15px rgba(0,0,0,0.3);
    overflow:hidden;
  ">
    <button onclick="fecharModalEditarUsuario()" 
            style="position:absolute;top:10px;right:12px;background:none;border:none;font-size:22px;cursor:pointer;">&times;</button>

    <iframe id="iframe-editar-usuario" 
            src="" 
            style="width:100%;height:100%;border:none;border-radius:12px;"></iframe>
  </div>
</div>
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
          <i class="<?= $post['ja_curti'] ? 'fa-solid' : 'fa-regular' ?> fa-heart"
            id="icon-heart-<?= $post['post_id'] ?>"></i>
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
  
  <div class="amigos-lateral-container">
  <!-- Checkbox escondido para controlar animação -->
  <input type="checkbox" id="toggle-amigos">

  <!-- Botão com a seta -->
  <label for="toggle-amigos" class="container">
    Amigos
    <svg class="chevron-right" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
      <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/>
    </svg>
  </label>

  <!-- Barra lateral de amigos -->
  <div id="amigos-lateral">
    <h3>Amigos</h3>
    <div class="amigo-item">
      <img src="imagens/usuarios/default.jpg" alt="Amigo">
      <span>Amigo 1</span>
    </div>
    <div class="amigo-item">
      <img src="imagens/usuarios/default.jpg" alt="Amigo">
      <span>Amigo 2</span>
    </div>
    <!-- Adicione mais amigos aqui -->
  </div>
</div>
  <div class="sidebar">
    <h3>Sugestões</h3>
    <?php foreach($sugestoes as $s): ?>
  <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
    <img src="<?= htmlspecialchars($s['foto'] ?: 'imagens/usuarios/default.jpg') ?>" style="width:46px;height:46px;border-radius:50%;object-fit:cover;border:2px solid var(--primary);">
    <div style="flex:1;"><?= htmlspecialchars($s['nome']) ?></div>
    <button onclick="adicionarAmigo(<?= intval($s['id']) ?>)" 
            style="background:#3f7c72;color:#fff;border:none;padding:6px 10px;border-radius:8px;cursor:pointer;font-weight:700;">
      Adicionar
    </button>
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
    <div id="amigos-online">
        <img src="/imagens/BMO1.png" alt="bmo" style="width: 225px;">
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

function curtirPost(id) {
    fetch("curtir.php?id=" + id)
    .then(r => r.json())
    .then(data => {
        if (data.ok) {
            document.getElementById("curtidas-" + id).innerText = data.curtidas;

            let icon = document.getElementById("icon-heart-" + id);

            if (data.curtiu === 1) {
                icon.classList.remove("fa-regular");
                icon.classList.add("fa-solid");
            } else {
                icon.classList.remove("fa-solid");
                icon.classList.add("fa-regular");
            }
        }
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
  fetch('adicionar_amigo.php',{
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:'destinatario='+destinatario
  })
  .then(r => r.json())
  .then(data => {

    // Mostra sempre a mensagem recebida
    mostrarMensagem(data.mensagem, data.status);

    // Se realmente for sucesso, atualiza
    if(data.status === 'sucesso'){
      atualizarSugestoes();
    }

    // NÃO TEM ELSE AQUI
  })
  .catch(() => {
    mostrarMensagem("Erro ao enviar solicitação", "erro");
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
// Atualiza posts, comentários, notificações e amigos online a cada 10 segundos
setInterval(() => {
  atualizarFeed();
  atualizarNotificacoes();
  atualizarAmigosOnline();
}, 10000);
  // Atualiza a página automaticamente a cada 1 minuto (60.000 ms)
  setInterval(function() {
    location.reload()
  }, 60000);
</script>
<script>
function abrirPerfilUsuario(usuarioId) {
  fetch('perfil_ajax.php?id=' + usuarioId)
    .then(res => res.text())
    .then(html => {
      // cria o modal
      const modal = document.createElement('div');
      modal.className = 'modal-perfil';
      modal.innerHTML = `
        <div class="conteudo-perfil">
          <button class="fechar" onclick="this.closest('.modal-perfil').remove()">&times;</button>
          ${html}
        </div>
      `;
      document.body.appendChild(modal);

      // fecha clicando fora
      modal.addEventListener('click', e => {
        if (e.target.classList.contains('modal-perfil')) modal.remove();
      });
    })
    .catch(err => console.error('Erro ao carregar perfil:', err));
}
</script>
</script>
<script>
let ultimoPostId = <?= !empty($posts) ? $posts[0]['post_id'] : 0 ?>;

function carregarNovosPosts() {
  fetch('buscar_posts.php?ultimo_id=' + ultimoPostId)
    .then(r => r.json())
    .then(data => {
      if (data.status === 'sucesso' && data.posts.length > 0) {
        const feed = document.querySelector('.feed');
        data.posts.forEach(post => {
          const novo = document.createElement('div');
          novo.className = 'post card';
          novo.id = 'post-' + post.post_id;
          novo.innerHTML = `
            <div class="user">
              <img src="${post.foto || 'imagens/usuarios/default.jpg'}" alt="">
              <strong>${escapeHtml(post.nome)}</strong>
            </div>
            <p>${escapeHtml(post.conteudo)}</p>
            ${post.imagem ? `<img class="content-img" src="${post.imagem}" alt="">` : ''}
          `;
          feed.prepend(novo);
          ultimoPostId = Math.max(ultimoPostId, post.post_id);
        });
      }
    })
    .catch(err => console.error('Erro ao buscar novos posts:', err));
}

// Atualiza a cada 5 segundos
setInterval(carregarNovosPosts, 5000);

function escapeHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}
</script>
<script>
  // Atualiza a página automaticamente a cada 1 minuto (60.000 ms)
  setInterval(function() {
    location.reload();
  }, 60000);
  let timeoutMsg;
function mostrarMensagem(texto, tipo) {
    const msg = document.getElementById("msg-flutuante");
    msg.textContent = texto;
    msg.classList.remove("erro");
    if(tipo === "erro") msg.classList.add("erro");
    msg.style.opacity = "1";

    clearTimeout(timeoutMsg);
    timeoutMsg = setTimeout(() => {
        msg.style.opacity = "0";
    }, 2500);
}
</script>

</body>
</html>
