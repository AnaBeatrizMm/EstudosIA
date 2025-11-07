<?php
session_start();

// ========================= CONFIG =========================
$uploadDir = __DIR__ . '/uploads';
$maxSize   = 10 * 1024 * 1024; // 10 MB
$allowedMime = ['application/pdf'];
$allowedExt  = ['pdf'];

// CSRF simples
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}
$csrf = $_SESSION['csrf'];

// Cria pasta se não existir + .htaccess
if (!is_dir($uploadDir)) {
    @mkdir($uploadDir, 0775, true);
}
$htaccess = $uploadDir . '/.htaccess';
if (!file_exists($htaccess)) {
    @file_put_contents($htaccess, "Options -Indexes\nRemoveHandler .php\nRemoveType .php\n");
}

// Helper p/ feedback
function flash($msg, $type='ok'){
    $_SESSION['flash'][] = ['t'=>$type, 'm'=>$msg];
}
if (!isset($_SESSION['flash'])) $_SESSION['flash'] = [];

// ========================= BANCO DE DADOS (PDO) =========================
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=bd_usuarios;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro na conexão com o banco: " . $e->getMessage());
}

// ========================= UPLOAD HANDLER =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['do_upload'])) {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        flash('Sessão expirada. Atualize a página e tente novamente.', 'err');
        header('Location: '.$_SERVER['REQUEST_URI']); exit;
    }

    if (!isset($_FILES['pdf']) || $_FILES['pdf']['error'] !== UPLOAD_ERR_OK) {
        flash('Nenhum arquivo selecionado ou erro no envio.', 'err');
        header('Location: '.$_SERVER['REQUEST_URI']); exit;
    }

    $f = $_FILES['pdf'];

    if ($f['size'] > $maxSize) {
        flash('Arquivo muito grande. Limite de 10 MB.', 'err');
        header('Location: '.$_SERVER['REQUEST_URI']); exit;
    }

    // Verifica MIME real
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($f['tmp_name']);
    $ext   = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));

    if (!in_array($mime, $allowedMime, true) || !in_array($ext, $allowedExt, true)) {
        flash('Apenas arquivos PDF são permitidos.', 'err');
        header('Location: '.$_SERVER['REQUEST_URI']); exit;
    }

    // Gera nome limpo e único
    $base = preg_replace('/[^a-z0-9\-_. ]+/i', '_', pathinfo($f['name'], PATHINFO_FILENAME));
    $destName = $base . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(3)) . '.pdf';
    $destPath = $uploadDir . '/' . $destName;

    if (!move_uploaded_file($f['tmp_name'], $destPath)) {
        flash('Falha ao salvar o arquivo.', 'err');
    } else {
        // Salva no banco
        $stmt = $pdo->prepare("INSERT INTO arquivos (nome_original, nome_servidor, tamanho, data_envio) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$f['name'], $destName, $f['size']]);
        flash('PDF enviado com sucesso!', 'ok');
    }

    header('Location: '.$_SERVER['REQUEST_URI']); exit;
}

// ========================= DELETE HANDLER =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        flash('Sessão expirada. Atualize a página e tente novamente.', 'err');
        header('Location: '.$_SERVER['REQUEST_URI']); exit;
    }

    $id = (int)$_POST['delete_id'];

    // Busca arquivo no banco
    $stmt = $pdo->prepare("SELECT nome_servidor FROM arquivos WHERE id = ?");
    $stmt->execute([$id]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($file) {
        $filepath = $uploadDir . '/' . $file['nome_servidor'];
        if (is_file($filepath)) {
            @unlink($filepath);
        }

        // Deleta do banco
        $stmt = $pdo->prepare("DELETE FROM arquivos WHERE id = ?");
        $stmt->execute([$id]);

        flash('Arquivo excluído com sucesso!', 'ok');
    } else {
        flash('Arquivo não encontrado.', 'err');
    }

    header('Location: '.$_SERVER['REQUEST_URI']); exit;
}

// ========================= LISTA DE ARQUIVOS =========================
$files = [];
try {
    $stmt = $pdo->query("SELECT * FROM arquivos ORDER BY data_envio DESC");
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    flash("Erro ao buscar arquivos: " . $e->getMessage(), 'err');
}

// Função para exibir tamanho legível
function humanSize($bytes){
    $u = ['B','KB','MB','GB','TB'];
    $i = 0;
    while ($bytes >= 1024 && $i < count($u)-1){ $bytes/=1024; $i++; }
    return number_format($bytes, ($i?1:0), ',', '.') . ' ' . $u[$i];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Upload PDF</title>
<link rel="icon" type="image/png" href="/anotacoes/imagens/icon site.png" sizes="612x612">
<link rel="stylesheet" href="estilo.css">

<!-- ========================= ESTILO COMPLETO ========================= -->
<style>
          @font-face {
      font-family: 'SimpleHandmade';
      src: url(/fonts/SimpleHandmade.ttf);
    }
*{box-sizing:border-box}
   /* Header */
   header {
  position: fixed; top:0; left:0; width:100%; height:70px;
  background:#ffffffcc; display:flex; justify-content:space-between; align-items:center;
  padding:0 2rem; box-shadow:0 2px 5px rgba(0,0,0,0.1); z-index:1000;
}
    header .logo img{height:450px;width:auto;display:block; margin-left: -85px;}


    nav ul{list-style:none; display:flex; align-items:center; gap:20px; margin:0;}
nav ul li a{ text-decoration:none; color:black;  padding:5px 10px; border-radius:8px; transition:.3s;}

body{
  font-family:'Roboto',sans-serif;
  background-color: #3f7c72ff;
  color: #3f7c72ff;
}

.brand{
  display:flex; align-items:center; gap:12px;
}
.brand img{ height:44px; display:block }

/* ========= CONTEÚDO ========= */
.container{
  max-width: 1100px; margin: 24px auto 80px; padding: 0 24px;
}
h1{
  margin-top: 95px;
  font-family: 'SimpleHandmade';
  font-size: 50px;
  text-align:center;
  color: #ffffff;
}

/* Bloco de envio */
.upload-card{
  background-color: #bdebe3ff;
  border: 1px solid #1e3834ff;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  padding: 22px;
  margin-bottom: 18px;
}
.upload-row{
  display:flex; gap:12px; align-items:center; justify-content:center; flex-wrap:wrap;
}
/* Botões */
.btn{
  background-color: #2a5c55;
  color: #ffffff;
  cursor: pointer;
  transition: background 0.3s;
  padding: 12px 25px;
  border: none;
  font-weight:800; border-radius:999px;
  font-family: 'SimpleHandmade';
  font-size: 22px;
}
.btn:hover{ background-color: #1e3834ff; }
.btn:active{ transform: translateY(1px) }

.btn.danger {
  background: linear-gradient(180deg, #912e2e 0%, #641f1f 100%);
  color: #fff;
  padding: 8px 14px;
  font-weight: 700;
  border: none;
  border-radius: 999px;
  cursor: pointer;
  box-shadow: 0 6px 14px rgba(100, 31, 31, 0.3);
}
.btn.danger:hover {
  filter: brightness(1.1);
}

/* Botão Baixar atualizado */
.btn-download {
  background-color: #2a5c55;
  color: #ffffff;
  cursor: pointer;
  transition: background 0.3s;
  padding: 12px 25px;
  border: none;
  font-weight:800; border-radius:999px;
  font-family: 'SimpleHandmade';
  font-size: 22px;
}

.btn-download:hover {
  background-color: #1e3834ff;
}

/* Alerts */
.alerts{ margin: 12px 0 0 }
.alert{
  padding:10px 14px; border-radius:12px; font-weight:600; margin-bottom:8px;
}
.alert.ok{ background:#e6f6eb; color:#114b26; border:1px solid #bfe7c9 }
.alert.err{ background:#fde8e7; color:#6d1815; border:1px solid #f1b7b4 }

/* Tabela */
.table-wrap{
  background-color: #bdebe3ff; border: 2px solid #2a5c55; border-radius:16px; overflow:hidden;
  box-shadow: 0 4px 12px rgba(0,0,0,.06);
}
table.table-pdf{
  width:100%; border-collapse:collapse; color: var(--terracotta-700);
}
.table-pdf thead{ background-color: #1e3834ff; color:#fff; font-family: 'SimpleHandmade'; font-size: 20px; }
.table-pdf th, .table-pdf td{ padding:12px 14px }
.table-pdf thead th{ font-weight:700 }
.table-pdf tbody tr{ border: 1px solid #1e3834ff; }
.table-pdf tbody tr:hover{ border: 1px solid #1e3834ff; }
.table-pdf td.nome{ font-weight:700; color:#a94545 }
.table-pdf a{ color:inherit; text-decoration:none }
.table-pdf a:hover{ text-decoration:underline }

/* Upload wrapper */
.file-upload-wrapper {
  background-color: #2a5c55;
  color: #ffffff;
  transition: background 0.3s;
  padding: 12px 25px;
  border: none;
  border: 1px solid #1e3834ff;
  font-weight:800; border-radius:999px;
  font-family: 'SimpleHandmade';
  font-size: 22px;
}
.file-upload-wrapper:hover {
  background-color: #1e3834ff;
}
.file-upload-wrapper input[type="file"] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
  cursor: pointer;
  height: 100%;
  width: 100%;
  border: none;
  margin: 0;
  padding: 0;
}

.btn-action {
  background: linear-gradient(180deg, #6b4c3b 0%, #5a3b2c 100%);
  color: #fff !important;
  padding: 8px 14px;
  font-weight:700;
  border: none;
  border-radius: 999px;
  cursor: pointer;
  box-shadow: 0 6px 14px rgba(90,59,44,0.3);
  text-decoration: none;
}

.btn-action:hover {
  filter: brightness(1.05);
}
/* Barra toda */
::-webkit-scrollbar {
  width: 12px; /* largura da barra vertical */
  height: 12px; /* altura da barra horizontal */
}

/* Fundo da barra */
::-webkit-scrollbar-track {
  background: #f0f0f0; /* cor do fundo da barra */
  border-radius: 10px;
}

/* Parte que se move (thumb) */
::-webkit-scrollbar-thumb {
  background: #3f7c72; /* cor do "polegar" */
  border-radius: 10px;
  border: 3px solid #f0f0f0; /* dá efeito de espaçamento */
}

/* Thumb ao passar o mouse */
::-webkit-scrollbar-thumb:hover {
  background: #2a5c55;
}
</style>
</head>
<body>
<header>
    <div class="logo"><img src="/imagens/logoatual.png" alt="Logo"></div>
    <nav>
      <ul>
          <li><a href="/inicio.php">Voltar</a></li>
      </ul>
    </nav>
  </header>
<main class="container">
  <h1>Envie seu arquivo PDF</h1>

  <!-- Formulário de upload -->
  <section class="upload-card">
    <form method="post" enctype="multipart/form-data" class="upload-row">
      <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf, ENT_QUOTES); ?>">
      <label class="file-upload-wrapper">
        <input type="file" name="pdf" accept="application/pdf" required> Escolher Arquivo
      </label>
      <button class="btn" type="submit" name="do_upload" value="1">Enviar PDF</button>
    </form>
  </section>

  <!-- Flash messages -->
  <?php if (!empty($_SESSION['flash'])): ?>
    <div class="alerts">
      <?php foreach ($_SESSION['flash'] as $f): ?>
        <div class="alert <?php echo $f['t']==='ok'?'ok':'err'; ?>">
          <?php echo $f['m']; ?>
        </div>
      <?php endforeach; $_SESSION['flash']=[]; ?>
    </div>
  <?php endif; ?>

  <!-- Tabela de arquivos -->
  <section class="table-wrap">
    <table class="table-pdf">
      <thead>
        <tr>
          <th style="width:45%">Nome</th>
          <th style="width:15%">Tamanho</th>
          <th style="width:20%">Modificado</th>
          <th style="width:20%">Ação</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$files): ?>
          <tr><td colspan="4">Nenhum PDF enviado ainda.</td></tr>
        <?php else: foreach ($files as $it): 
            $url = 'uploads/' . rawurlencode($it['nome_servidor']);
        ?>
          <tr>
            <td class="nome">
              <a href="<?php echo htmlspecialchars($url, ENT_QUOTES); ?>" target="_blank" rel="noopener">
                <?php echo htmlspecialchars($it['nome_original'], ENT_QUOTES); ?>
              </a>
            </td>
            <td><?php echo humanSize($it['tamanho']); ?></td>
            <td><?php echo date('d/m/Y H:i', strtotime($it['data_envio'])); ?></td>
            <td style="display:flex; gap:10px; align-items:center;">
              <!-- Botão Baixar -->
              <a class="btn-action" href="<?php echo htmlspecialchars($url, ENT_QUOTES); ?>" download>
                Baixar
              </a>

              <!-- Botão Excluir -->
              <form method="post" style="margin:0" onsubmit="event.preventDefault(); showConfirm(this);">
                <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf, ENT_QUOTES); ?>">
                <input type="hidden" name="delete_id" value="<?php echo (int)$it['id']; ?>">
                <button type="submit" class="btn-action">Excluir</button>
              </form>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </section>
</main>

<!-- Modal de confirmação -->
<div id="confirmModal" class="modal" style="display:none">
  <div class="modal-content">
    <p>Tem certeza que deseja excluir este arquivo?</p>
    <div class="modal-buttons">
      <button id="cancelBtn" class="btn-action">Cancelar</button>
      <button id="confirmBtn" class="btn-action">Excluir</button>
    </div>
  </div>
</div>

<script>
function showConfirm(form) {
  const modal = document.getElementById('confirmModal');
  modal.style.display = 'flex';

  const confirmBtn = document.getElementById('confirmBtn');
  const cancelBtn = document.getElementById('cancelBtn');

  confirmBtn.onclick = function() {
    modal.style.display = 'none';
    form.submit();
  };
  cancelBtn.onclick = function() {
    modal.style.display = 'none';
  };
}
</script>
</body>
</html>