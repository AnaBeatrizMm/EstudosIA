<?php 
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_logado = $_SESSION['usuario_id'];

/* BUSCAR MENSAGENS PRINCIPAIS */
$sql = "
SELECT c.*, u.nome, u.foto
FROM chat_grupo_jogos c
JOIN usuarios u ON c.user_id = u.id
WHERE c.resposta_para IS NULL
ORDER BY c.id DESC
";
$mensagens = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

/* BUSCAR TODAS AS RESPOSTAS */
$respostas = [];
$stmt = $conn->prepare("
    SELECT c.*, u.nome, u.foto
    FROM chat_grupo_jogos c
    JOIN usuarios u ON c.user_id = u.id
    WHERE resposta_para = ?
    ORDER BY c.id ASC
");

foreach ($mensagens as $msg) {
    $stmt->bind_param("i", $msg["id"]);
    $stmt->execute();
    $respostas[$msg["id"]] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Chat - Jogos</title>

<style>
body {
    font-family: Arial;
    background: #e8f5f3;
    margin: 0;
    padding: 0;
}

/* HEADER */
header {
  position: fixed; 
  top:0; left:0; 
  width:100%; 
  height:70px;
  background:#ffffffcc; 
  display:flex; 
  justify-content:space-between; 
  align-items:center;
  padding:0 1.5rem; 
  box-shadow:0 2px 5px rgba(0,0,0,0.1); 
  z-index:1000;
}

header .logo img{
  height:55px;
  width:auto;
}

nav ul{
  list-style:none; 
  display:flex; 
  align-items:center; 
  gap:15px; 
  margin:0;
}

nav ul li a{
  text-decoration:none; 
  color:black;  
  padding:6px 12px; 
  border-radius:8px; 
  font-size:17px;
  transition:.3s;
}

/* CHAT */
.chat-box {
    width: 70%;
    margin: 120px auto 30px auto;
    background: white;
    padding: 20px;
    border-radius: 12px;
    border: 4px solid #6bb7a8;
}

/* TÍTULO COM IMAGEM */
.titulo-grupo {
    display: flex;
    align-items: center;
    gap: 15px;
}

.titulo-grupo img {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    border: 3px solid #6bb7a8;
}

/* MENSAGEM */
.msg {
    border-bottom: 1px solid #ccc;
    padding: 12px 0;
}

.msg img.foto {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid #6bb7a8;
    margin-right: 10px;
}

.msg .nome {
    font-weight: bold;
    color: #2d5c54;
}

/* RESPOSTA */
.resposta {
    margin-left: 50px;
    background: #f4fffb;
    padding: 10px;
    border-left: 4px solid #6bb7a8;
    border-radius: 10px;
    margin-top: 10px;
}

/* BOTÕES */
.botao-responder {
    background: #6bb7a8;
    color: white;
    padding: 6px 14px;
    font-size: 14px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    margin-top: 10px;
}

.caixa-resposta {
    display: none;
    margin-top: 10px;
}

.botao-excluir {
    background: #ff8fa3;
    color: white;
    padding: 5px 12px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: .2s;
}
.botao-excluir:hover { background: #ff5c77; }

</style>

<script>
function mostrarResposta(id) {
    let div = document.getElementById("responder-" + id);
    div.style.display = div.style.display === "block" ? "none" : "block";
}
</script>

</head>
<body>

<header>
    <div class="logo"><img src="/imagens/logoatual.png"></div>
    <nav>
        <ul>
            <li><a href="/redesocial.php">Voltar</a></li>
        </ul>
    </nav>
</header>

<div class="chat-box">

<div class="titulo-grupo">
    <img src="/imagens/renomear.jfif">
    <h2>Jogos</h2>
</div>

<br>

<!-- FORMULÁRIO PRINCIPAL -->
<form action="enviar_mensagem_jogos.php" method="POST" enctype="multipart/form-data">
    <textarea name="mensagem" placeholder="Digite uma mensagem..." required 
    style="width:100%;height:80px;border-radius:10px;border:2px solid #6bb7a8;padding:10px;"></textarea>

    <input type="file" name="arquivo"><br><br>

    <button style="padding:10px 20px;background:#3f7c72;color:white;border:none;border-radius:10px;cursor:pointer;">
        Enviar
    </button>
</form>

<hr><br>

<?php foreach ($mensagens as $msg): ?>
<div class="msg">

    <img class="foto" src="<?= $msg['foto'] ?>">
    <span class="nome"><?= htmlspecialchars($msg['nome']) ?></span>
    <small style="color:#777;"> — <?= $msg['data_envio'] ?></small>

    <p><?= nl2br(htmlspecialchars($msg['mensagem'])) ?></p>

    <?php if($msg['arquivo']): ?>
    <?php 
        $ext = strtolower(pathinfo($msg['arquivo'], PATHINFO_EXTENSION));
        $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
    ?>

    <?php if ($isImage): ?>
        <img src="<?= $msg['arquivo'] ?>" 
             style="max-width:250px;border-radius:10px;margin-top:10px;border:2px solid #6bb7a8;">
    <?php else: ?>
        <a href="<?= $msg['arquivo'] ?>" target="_blank" style="color:#2d5c54;font-weight:bold;">📎 Abrir arquivo</a>
    <?php endif; ?>
<?php endif; ?>

    <br>

    <!-- BOTÃO -->
    <button class="botao-responder" onclick="mostrarResposta(<?= $msg['id'] ?>)">Responder</button>

    <!-- CAIXA DE RESPOSTA -->
    <div id="responder-<?= $msg['id'] ?>" class="caixa-resposta">
        <form action="enviar_mensagem_jogos.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="resposta_para" value="<?= $msg['id'] ?>">

            <textarea name="mensagem" placeholder="Responder..." 
            style="width:90%;height:60px;border-radius:10px;border:2px solid #6bb7a8;padding:10px;"></textarea>

            <input type="file" name="arquivo"><br><br>
            <button style="background:#6bb7a8;color:white;border:none;padding:6px 12px;border-radius:8px;">
                Enviar resposta
            </button>
        </form>
    </div>

    <!-- EXCLUIR -->
    <?php if ($msg['user_id'] == $usuario_logado): ?>
    <form action="excluir_mensagem_jogos.php" method="POST" style="display:inline;">
        <input type="hidden" name="id" value="<?= $msg['id'] ?>">
        <button class="botao-excluir">Excluir</button>
    </form>
    <?php endif; ?>

    <!-- RESPOSTAS -->
    <?php foreach ($respostas[$msg['id']] as $r): ?>
        <div class="resposta">
            <img class="foto" src="<?= $r['foto'] ?>">
            <span class="nome"><?= htmlspecialchars($r['nome']) ?></span>
            <small style="color:#777;"> — <?= $r['data_envio'] ?></small>
            <p><?= nl2br(htmlspecialchars($r['mensagem'])) ?></p>

            <?php if($r['arquivo']): ?>
                <?php 
                    $extR = strtolower(pathinfo($r['arquivo'], PATHINFO_EXTENSION));
                    $isImageR = in_array($extR, ['jpg','jpeg','png','gif','webp']);
                ?>

                <?php if ($isImageR): ?>
                    <img src="<?= $r['arquivo'] ?>" 
                    style="max-width:250px;border-radius:10px;margin-top:10px;border:2px solid #6bb7a8;">
                <?php else: ?>
                    <a href="<?= $r['arquivo'] ?>" target="_blank" style="color:#2d5c54;font-weight:bold;">
                        📎 Abrir arquivo
                    </a>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    <?php endforeach; ?>

</div>
<?php endforeach; ?>

</div>

</body>
</html>
