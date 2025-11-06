<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

include('conexao.php');

$usuario_id = $_SESSION['usuario_id'];

// SELECT principal
$sql = "SELECT nome, email, biografia, foto FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($nome, $email, $biografia, $foto);
$stmt->fetch();
$stmt->close();

// checar existência de colunas opcionais
$has_aniversario = $conn->query("SHOW COLUMNS FROM usuarios LIKE 'aniversario'")->num_rows > 0;
$has_favoritos   = $conn->query("SHOW COLUMNS FROM usuarios LIKE 'favoritos'")->num_rows > 0;
$has_bio_foto    = $conn->query("SHOW COLUMNS FROM usuarios LIKE 'bio_foto'")->num_rows > 0;
$has_banner      = $conn->query("SHOW COLUMNS FROM usuarios LIKE 'banner'")->num_rows > 0;

$aniversario_db = '';
$favoritos_db   = '';
$bio_foto_db    = '';
$banner_db      = '';

if ($has_aniversario || $has_favoritos || $has_bio_foto || $has_banner) {
    $cols = [];
    if ($has_aniversario) $cols[] = 'aniversario';
    if ($has_favoritos)   $cols[] = 'favoritos';
    if ($has_bio_foto)    $cols[] = 'bio_foto';
    if ($has_banner)      $cols[] = 'banner';

    $sql2 = "SELECT " . implode(', ', $cols) . " FROM usuarios WHERE id = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param('i', $usuario_id);
    $stmt2->execute();
    $stmt2->store_result();

    $bind_names = [];
    $meta = $stmt2->result_metadata();
    $fields = [];
    foreach ($meta->fetch_fields() as $field) {
        $fields[] = &$row[$field->name];
        $bind_names[] = &$row[$field->name];
    }
    if (!empty($bind_names)) {
        call_user_func_array(array($stmt2, 'bind_result'), $bind_names);
        $stmt2->fetch();
        if ($has_aniversario && isset($row['aniversario'])) $aniversario_db = $row['aniversario'];
        if ($has_favoritos && isset($row['favoritos']))     $favoritos_db   = $row['favoritos'];
        if ($has_bio_foto && isset($row['bio_foto']))       $bio_foto_db    = $row['bio_foto'];
        if ($has_banner && isset($row['banner']))           $banner_db      = $row['banner'];
    }
    $stmt2->close();
}

// valores fictícios para exibição
$seguidores_count = 121;
$favoritos_count  = 23;
$fans_count       = 106;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_usuario = $_POST['nome_usuario'] ?? $nome;
    $email        = $_POST['email'] ?? $email;
    $senha        = !empty($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : null;
    $biografia    = $_POST['biografia'] ?? $biografia;

    $aniversario  = $has_aniversario ? ($_POST['aniversario'] ?? $aniversario_db) : null;
    $favoritos    = $has_favoritos ? ($_POST['favoritos'] ?? $favoritos_db) : null;

    // FOTO DE PERFIL VIA CANVAS
    if (!empty($_POST['cropped_image'])) {
        $image_data = $_POST['cropped_image'];
        $image_data = str_replace('data:image/png;base64,', '', $image_data);
        $image_data = str_replace(' ', '+', $image_data);
        $image_data = base64_decode($image_data);
        $filename = 'imagens/usuarios' . uniqid() . '.png';

        if (!is_dir(dirname($filename))) {
            mkdir(dirname($filename), 0755, true);
        }
        file_put_contents($filename, $image_data);
        $foto = $filename;
    } else {
        // mantém foto antiga
        $sql_foto = "SELECT foto FROM usuarios WHERE id = ?";
        $stmt_foto = $conn->prepare($sql_foto);
        $stmt_foto->bind_param("i", $usuario_id);
        $stmt_foto->execute();
        $stmt_foto->bind_result($foto_antiga);
        $stmt_foto->fetch();
        $stmt_foto->close();
        $foto = $foto_antiga;
    }

    // UPLOAD da foto da bio
    $bio_foto_saved = '';
    if (isset($_FILES['bio_foto_file']) && $_FILES['bio_foto_file']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['bio_foto_file']['name'], PATHINFO_EXTENSION);
        $bio_filename = 'imagens/bio/' . uniqid() . '.' . ($ext ?: 'jpg');

        if (!is_dir(dirname($bio_filename))) {
            mkdir(dirname($bio_filename), 0755, true);
        }
        if (move_uploaded_file($_FILES['bio_foto_file']['tmp_name'], $bio_filename)) {
            $bio_foto_saved = $bio_filename;
        }
    }

    // UPLOAD do banner
    $banner_saved = '';
if (isset($_FILES['banner_file']) && $_FILES['banner_file']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['banner_file']['name'], PATHINFO_EXTENSION);
    $banner_filename = 'imagens/usuarios/' . uniqid() . '.' . ($ext ?: 'jpg');

    if (!is_dir(dirname($banner_filename))) {
        mkdir(dirname($banner_filename), 0755, true);
    }
    if (move_uploaded_file($_FILES['banner_file']['tmp_name'], $banner_filename)) {
        $banner_saved = $banner_filename;
    }
}

    // montar UPDATE dinâmico
    $fields = [];
    $types  = '';
    $values = [];

    $fields[] = 'nome';      $types .= 's'; $values[] = $nome_usuario;
    $fields[] = 'email';     $types .= 's'; $values[] = $email;
    if ($senha) {
        $fields[] = 'senha'; $types .= 's'; $values[] = $senha;
    }
    $fields[] = 'biografia'; $types .= 's'; $values[] = $biografia;
    $fields[] = 'foto';      $types .= 's'; $values[] = $foto;

    if ($has_aniversario) { $fields[] = 'aniversario'; $types .= 's'; $values[] = $aniversario; }
    if ($has_favoritos)   { $fields[] = 'favoritos';   $types .= 's'; $values[] = $favoritos; }
    if ($has_bio_foto) {
        $bio_to_save = $bio_foto_saved ?: $bio_foto_db;
        $fields[] = 'bio_foto'; $types .= 's'; $values[] = $bio_to_save;
    }
    if ($has_banner) {
        $banner_to_save = $banner_saved ?: $banner_db;
        $fields[] = 'banner'; $types .= 's'; $values[] = $banner_to_save;
    }

    $set_sql = implode(' = ?, ', $fields) . ' = ?';
    $sql_update = "UPDATE usuarios SET $set_sql WHERE id = ?";

    $stmt_upd = $conn->prepare($sql_update);
    if ($stmt_upd === false) {
        die("Erro ao preparar UPDATE: " . htmlspecialchars($conn->error));
    }

    $types_with_id = $types . 'i';
    $params = $values;
    $params[] = $usuario_id;

    $bind_names = [];
    $bind_names[] = &$types_with_id;
    for ($i = 0; $i < count($params); $i++) {
        $bind_names[] = &$params[$i];
    }

    call_user_func_array(array($stmt_upd, 'bind_param'), $bind_names);

    $_SESSION['usuario_nome'] = $nome_usuario;
    $stmt_upd->execute();
    $stmt_upd->close();

    header("Location: editar_usuario.php?sucesso=1");
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Perfil</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.css" rel="stylesheet"/>
  <style>
        * {
      box-sizing: border-box;
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
   /* Header */
header {
  position: fixed; top:0; left:0; width:100%; height:70px;
  background:#ffffffcc; display:flex; justify-content:space-between; align-items:center;
  padding:0 2rem; box-shadow:0 2px 5px rgba(0,0,0,0.1); z-index:1000;
}
    header .logo img{height:450px;width:auto;display:block; margin-left: -85px;}


    nav ul{list-style:none; display:flex; align-items:center; gap:20px; margin:0;}
nav ul li a{ text-decoration:none; color:black;  padding:5px 10px; border-radius:8px; transition:.3s;}

    /* font personalizada para o título */
    @font-face {
      font-family: 'SimpleHandmade';
      src: url('/fonts/SimpleHandmade.ttf');
    }

    body {
      background-color: #eaf2f0;
      font-family: 'Inter', sans-serif;
      padding: 2rem;
      margin: 0;
    }

    .container {
      max-width: 900px;
      margin: 2rem auto;
      background-color: #fff;
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      display: grid;
      grid-template-columns: 360px 1fr;
      gap: 1.5rem;
    }

    h1 {
      text-align: center;
      color: #2c544f;
      margin-bottom: 1rem;
      font-family: 'SimpleHandmade', cursive;
      font-size: 2.0rem;
    }

    /* PREVIEW LATERAL */
    .preview {
      text-align: center;
      border-radius: 12px;
      padding: 1rem;
      background: linear-gradient(180deg, #f6fffb 0%, #ffffff 100%);
      border: 1px solid #e6f2ef;
    }

    .perfil-foto {
      position: relative;
      display: inline-block;
      margin-bottom: 0.8rem;
    }

    .perfil-foto img {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      border: 4px solid #4a766e;
      object-fit: cover;
      transition: transform .3s ease, opacity .3s;
    }

    .perfil-foto img.updated {
      animation: pulse 1s ease;
    }

    @keyframes pulse {
      0% { transform: scale(.95); opacity: .8; }
      50% { transform: scale(1.03); opacity: 1; }
      100% { transform: scale(1); }
    }

    .online-bullet {
      position: absolute;
      bottom: 8px;
      right: 8px;
      width: 18px;
      height: 18px;
      background: #4caf50;
      border: 2px solid white;
      border-radius: 50%;
    }

    /* FORM */
    form {
      display: block;
    }

    label { font-weight: 600; display:block; margin-top: 1rem; margin-bottom: .3rem; color:#334; }
    input[type="text"], input[type="email"], input[type="password"], input[type="date"], textarea {
      width: 100%;
      padding: 0.7rem;
      border: 1px solid #cfd8dc;
      border-radius: 12px;
      font-size: 1rem;
      background-color: #f9fafa;
    }

    .foto-preview {
      text-align: center;
      margin: 1rem 0;
    }

    #preview-img {
      max-width: 160px;
      max-height: 160px;
      border-radius: 50%;
      border: 3px solid #4a766e;
      object-fit: cover;
    }

    .botoes {
      display: flex;
      justify-content: flex-start;
      gap: 0.8rem;
      margin-top: 1rem;
    }

    button {
      background-color: #4a766e;
      color: white;
      border: none;
      padding: 0.7rem 1.2rem;
      border-radius: 12px;
      cursor: pointer;
      font-weight: 600;
    }

    .botao-voltar {
      background-color: #eaf2f0;
      color: #4a766e;
      border: 1px solid #4a766e;
    }

    /* Cropper modal */
    #cropper-modal {
      display: none;
      position: fixed;
      z-index: 9999;
      top: 0; left: 0; right: 0; bottom: 0;
      background-color: rgba(0, 0, 0, 0.7);
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }
    #cropper-modal .content {
      background: white;
      padding: 1rem;
      border-radius: 10px;
      text-align: center;
      max-width: 700px;
      width: 100%;
    }
    #image-to-crop { max-width: 100%; max-height: 60vh; display:block; margin: 0 auto; }
    .modal-buttons { margin-top: 1rem; display:flex; justify-content:center; gap:1rem; }

    /* seção SOBRE MIM (preview lateral) */
    .about {
      text-align: left;
      margin-top: 1rem;
      padding-top: 0.4rem;
    }
    .about h4 { margin: .4rem 0; font-size:1.05rem; color:#2c544f; font-weight:700; }
    .bio-photo-preview {
      width: 100%;
      border-radius: 10px;
      max-height: 160px;
      object-fit: cover;
      display:block;
      margin-bottom: .6rem;
    }

    .favoritos-box {
      background: #e0f2f1;
      border-radius: 10px;
      padding: 0.6rem;
      margin-top: .6rem;
    }

    .alerta {
      position: fixed;
      top: 30px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #4a766e;
      color: white;
      padding: 0.8rem 1.5rem;
      border-radius: 12px;
      font-weight: 600;
      z-index: 10000;
      animation: fadeOut 4s forwards;
    }
    .perfil-banner {
  position: relative;
  width: 100%;
  height: 160px;
  border-radius: 12px;
  overflow: hidden;
  margin-bottom: -70px; /* faz a foto sobrepor o banner */
}

.perfil-banner img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.perfil-foto {
  position: relative;
  display: inline-block;
}

.edit-icon {
  position: absolute;
  bottom: 8px;
  right: 8px;
  background: rgba(0,0,0,0.6);
  color: white;
  font-size: 18px;
  padding: 6px;
  border-radius: 50%;
  cursor: pointer;
}

.edit-icon.small.left {
  top: 8px;    /* fica no topo */
  left: 8px;   /* lado oposto da bolinha verde */
  right: auto;
  bottom: auto;
}

/* novo estilo simples para o botão de selecionar foto da bio (na lateral) */
.bio-file-label {
  display: inline-block;
  padding: 6px 10px;
  background: #4a766e;
  color: #fff;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 700;
  margin-top: 0.4rem;
  text-decoration: none;
  font-size: 0.95rem;
}

    @keyframes fadeOut { 0% { opacity: 1; } 85% { opacity: 1; } 100% { opacity: 0; transform: translateX(-50%) translateY(-20px); } }

    /* responsividade simples */
    @media (max-width: 880px) {
      .container { grid-template-columns: 1fr; }
      .preview { margin-bottom: 1rem; }
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
<?php if (isset($_GET['sucesso'])): ?>
  <div class="alerta">Alterações salvas com sucesso!</div>
<?php endif; ?>

<div class="container">
  <!-- PREVIEW LATERAL -->
<div class="preview">
  <h1>Editar Perfil</h1>

  <!-- BANNER -->
  <div class="perfil-banner">
  <img id="banner-img" src="<?php echo !empty($banner_db) ? $banner_db : 'imagens/usuarios/default-banner.jpg'; ?>" alt="Banner">
    <label for="banner-file" class="edit-icon">✏️</label>
    <input type="file" name="banner_file" id="banner-file" accept="image/*" style="display:none;" form="perfil-form">
  </div>

  <!-- FOTO PERFIL -->
  <div class="perfil-foto">
    <img id="preview-img" src="<?php echo !empty($foto) && file_exists($foto) ? $foto : 'imagens/usuarios/default.jpg'; ?>" alt="Preview">
    <label for="foto" class="edit-icon small left">✏️</label>
    <input type="file" accept="image/*" id="foto" style="display:none;">
    <div class="online-bullet" title="Online"></div>
  </div>

  <div style="margin-top: .5rem; font-weight:700; color:#2c544f;">
    <?php echo htmlspecialchars($nome); ?> ♡
  </div>

  <div class="about">
    <h4>Sobre mim</h4>
    <?php if (!empty($bio_foto_db) && file_exists($bio_foto_db)): ?>
  <img class="bio-photo-preview" id="bio-preview-sidebar" src="<?php echo $bio_foto_db; ?>" alt="">
<?php else: ?>
  <img class="bio-photo-preview" id="bio-preview-sidebar" src="imagens/bio/default.jpg" alt="">
<?php endif; ?>


    <!-- aqui vai a seleção de arquivo, agora EMBUTIDA na lateral embaixo da foto -->
    <label for="bio_foto_file" class="bio-file-label">Alterar foto</label>
    <input type="file" accept="image/*" name="bio_foto_file" id="bio_foto_file" form="perfil-form" style="display:none;">

    <div style="color:#334; font-size:0.95rem; margin-top:0.6rem;">
      <?php echo nl2br(htmlspecialchars($biografia)); ?>
    </div>

    <div style="margin-top:.6rem; font-weight:700;">
      🎂 Aniversário: 
      <?php echo ($has_aniversario && !empty($aniversario_db)) ? date('d/m/Y', strtotime($aniversario_db)) : 'Não informado'; ?>
    </div>

    <div class="favoritos-box">
      <strong>✨ Favoritos</strong>
      <ul style="margin: .4rem 0 0 1.1rem; padding:0;">
        <?php
          if ($has_favoritos && !empty($favoritos_db)) {
              $lista = explode(',', $favoritos_db);
              foreach ($lista as $it) {
                  echo "<li>" . htmlspecialchars(trim($it)) . "</li>";
              }
          } else {
              echo "<li>Adicione seus favoritos</li>";
          }
        ?>
      </ul>
    </div>
  </div>
</div>
  <!-- FORM EDITAR -->
  <div>
    <form method="POST" enctype="multipart/form-data" id="perfil-form">
      

      <input type="hidden" name="cropped_image" id="cropped_image">

      <div class="foto-preview">
        <!-- preview já presente na lateral sincronizado pelo JS -->
      </div>

      <label for="nome_usuario">Nome de Usuário</label>
      <input type="text" name="nome_usuario" id="nome_usuario" value="<?php echo htmlspecialchars($nome); ?>" required>

      <label for="email">Email</label>
      <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>

      <label for="senha">Senha</label>
      <input type="password" name="senha" placeholder="Deixe em branco se não for alterar">

      <label for="biografia">Biografia</label>
      <textarea name="biografia" id="biografia" rows="4"><?php echo htmlspecialchars($biografia); ?></textarea>

      <?php if ($has_aniversario): ?>
        <label for="aniversario">Aniversário</label>
        <input type="date" name="aniversario" id="aniversario" value="<?php echo !empty($aniversario_db) ? htmlspecialchars(date('Y-m-d', strtotime($aniversario_db))) : ''; ?>">
      <?php else: ?>
        <!-- se quiser persistir, crie a coluna 'aniversario' no DB (DATE) -->
      <?php endif; ?>

      <?php if ($has_favoritos): ?>
        <label for="favoritos">Favoritos (separe por vírgula)</label>
        <input type="text" name="favoritos" id="favoritos" value="<?php echo htmlspecialchars($favoritos_db); ?>" placeholder="Ex: Taylor Swift, Clairo, Coffee">
      <?php else: ?>
        <!-- se quiser persistir, crie a coluna 'favoritos' no DB (TEXT) -->
      <?php endif; ?>

      <!-- REMOVI AQUI o campo de foto da bio e o texto explicativo; agora o input está na lateral (sobre mim) -->
      <div class="botoes">
        <button type="submit">Salvar Alterações</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal de Crop -->
<div id="cropper-modal">
  <div class="content" role="dialog" aria-modal="true" aria-label="Recortar imagem">
    <h3>Recorte sua imagem</h3>
    <img id="image-to-crop" alt="Imagem para recortar">
    <div class="modal-buttons">
      <button id="crop-btn" type="button">Recortar</button>
      <button id="cancel-btn" type="button" class="botao-voltar">Cancelar</button>
    </div>
  </div>
</div>
<!-- dentro da PREVIEW -->

<script src="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.js"></script>
<script>
  const input = document.getElementById('foto');
  const imageToCrop = document.getElementById('image-to-crop');
  const modal = document.getElementById('cropper-modal');
  const cropBtn = document.getElementById('crop-btn');
  const cancelBtn = document.getElementById('cancel-btn');
  const preview = document.getElementById('preview-img'); // foto principal preview
  const hiddenCropped = document.getElementById('cropped_image');

  let cropper = null;
  let originalPreviewSrc = preview.src;

  input.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    originalPreviewSrc = preview.src;

    const reader = new FileReader();
    reader.onload = function (event) {
      imageToCrop.src = event.target.result;
      modal.style.display = 'flex';
    };
    reader.readAsDataURL(file);
  });

  imageToCrop.addEventListener('load', function () {
    if (cropper) {
      cropper.destroy();
      cropper = null;
    }

    cropper = new Cropper(imageToCrop, {
      aspectRatio: 1,
      viewMode: 1,
      autoCropArea: 1,
      responsive: true,
    });
  });

  cropBtn.addEventListener('click', function (e) {
    e.preventDefault();
    if (!cropper) return;

    try {
      const canvas = cropper.getCroppedCanvas({
        width: 400,
        height: 400,
        imageSmoothingQuality: 'high'
      });

      const dataUrl = canvas.toDataURL('image/png');
      preview.src = dataUrl;
      preview.classList.add('updated');
      hiddenCropped.value = dataUrl;

      // também atualizar preview sidebar bio (garante sincronia)
      const sidebarPreview = document.getElementById('bio-preview-sidebar');
      if (sidebarPreview && !sidebarPreview.src.includes('default')) {
        // nada — não sobrescrever a foto da bio
      }

      closeModal(false);
    } catch (err) {
      console.error('Erro ao recortar:', err);
      alert('Ocorreu um erro ao recortar a imagem. Veja o console do navegador.');
    }
  });

  cancelBtn.addEventListener('click', function (e) {
    e.preventDefault();
    closeModal(true);
  });

  function closeModal(restoreOldPreview = true) {
    modal.style.display = 'none';
    if (cropper) {
      try { cropper.destroy(); } catch (e) {}
      cropper = null;
    }
    if (restoreOldPreview) {
      preview.src = originalPreviewSrc;
      hiddenCropped.value = '';
    }
    try { input.value = ''; } catch (e) {}
  }

  modal.addEventListener('click', function (ev) {
    if (ev.target === modal) {
      closeModal(true);
    }
  });

  // preview simples para foto da bio (sem cropper para manter simples)
  const bioFileInput = document.getElementById('bio_foto_file');
  if (bioFileInput) {
    bioFileInput.addEventListener('change', function (e) {
      const f = e.target.files[0];
      if (!f) return;
      const r = new FileReader();
      r.onload = function (ev) {
        const sidebarPreview = document.getElementById('bio-preview-sidebar');
        if (sidebarPreview) sidebarPreview.src = ev.target.result;
      };
      r.readAsDataURL(f);
    });
  }
  // Preview do banner
const bannerInput = document.getElementById('banner-file');
const bannerImg = document.getElementById('banner-img');

if (bannerInput) {
  bannerInput.addEventListener('change', function(e) {
    const f = e.target.files[0];
    if (!f) return;
    const r = new FileReader();
    r.onload = function(ev) {
      bannerImg.src = ev.target.result;
    };
    r.readAsDataURL(f);
  });
}
</script>

</body>
</html>