<?php
// === Conexão com o banco ===
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd_usuarios";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Erro de conexão: " . $conn->connect_error);
}

// === Salvar anotação ===
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $conteudo = $_POST['conteudo'];

  // Apaga o anterior e salva o novo
  $conn->query("DELETE FROM anotacoes");
  $stmt = $conn->prepare("INSERT INTO anotacoes (conteudo) VALUES (?)");
  $stmt->bind_param("s", $conteudo);
  $stmt->execute();
  $stmt->close();

  echo "<script>alert('💾 Anotação salva com sucesso!'); window.location='anotacoes.php';</script>";
  exit;
}

// === Carregar anotação existente ===
$conteudo_salvo = "";
$res = $conn->query("SELECT conteudo FROM anotacoes LIMIT 1");
if ($res && $res->num_rows > 0) {
  $conteudo_salvo = $res->fetch_assoc()['conteudo'];
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Caderno de Anotações</title>
  <style>
    /* === SEU CSS AJUSTADO === */
::-webkit-scrollbar { width: 12px; height: 12px; }
::-webkit-scrollbar-track { background: #f0f0f0; border-radius: 10px; }
::-webkit-scrollbar-thumb { background: #3f7c72; border-radius: 10px; border: 3px solid #f0f0f0; }
::-webkit-scrollbar-thumb:hover { background: #2a5c55; }

@font-face {
  font-family: 'SimpleHandmade';
  src: url(/fonts/SimpleHandmade.ttf);
}
* { box-sizing: border-box; }

body {
  background-color: #3f7c72ff;
  font-family:'Roboto',sans-serif;
  color: #3f7c72ff;
  padding: 40px;
  text-align: center;
  position: relative;
  min-height: 100vh;
}

header {
  position: fixed; top:0; left:0; width:100%; height:70px;
  background:#ffffffcc; display:flex; justify-content:space-between; align-items:center;
  padding:0 2rem; box-shadow:0 2px 5px rgba(0,0,0,0.1); z-index:1000;
}
header .logo img { height:450px;width:auto;display:block; margin-left: -85px; }

nav ul{list-style:none; display:flex; align-items:center; gap:20px; margin:0;}
nav ul li a{ text-decoration:none; color:black;  padding:5px 10px; border-radius:8px; transition:.3s;}
nav ul li a:hover { background-color:#bdebe3; }

h1 {
  margin-top: 95px;
  font-size: 50px;
  margin-bottom: 20px;
  font-family: 'SimpleHandmade';
  color: #ffffff;
}

.toolbar {
  margin-bottom: 20px;
  display: flex;
  justify-content: center; /* Centraliza os botões */
  align-items: center;
  gap: 10px;
}

.toolbar select,
.toolbar input[type="color"],
.toolbar button {
  font-family: 'SimpleHandmade';
  font-size: 20px;
  padding: 6px 10px;
  border: 1px solid #ffffff;
  border-radius: 8px;
  background-color: #2a5c55;
  cursor: pointer;
  color: #ffffff;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.toolbar button:hover,
.toolbar select:hover,
.toolbar input[type="color"]:hover {
  background-color: #1e3834ff;
  color: #ffffff;
}

.caderno {
  background-color: #bdebe3ff;
  border: 2px solid #1e3834ff;
  border-radius: 10px;
  width: 90%;
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  text-align: left;
  position: relative;
  z-index: 1;
}

.editor {
  background-image: repeating-linear-gradient(
    to bottom,
    #ffffff 0px,
    #ffffff 30px,
    #1e383450 31px,
    #ffffff 32px
  );
  min-height: 400px;
  padding: 20px 30px;
  outline: none;
  font-size: 16px;
  color: #2a5c55;
  line-height: 32px;
  white-space: pre-wrap;
  position: relative;
  z-index: 1;
  overflow-wrap: break-word;
  border-radius: 10px;
}

.btn-salvar {
  position: fixed;
  background-color: #2a5c55;
  color: #fff;
  padding: 12px 25px;
  border-radius: 12px;
  text-decoration: none;
  font-weight: bold;
  font-size: 16px;
  cursor: pointer;
  border: none;
  transition: 0.3s;
  user-select: none;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  z-index: 1000;
}

.btn-salvar {
  bottom: 40px;
  left: 50%;
  transform: translateX(-50%);
}

.btn-salvar:hover {
  background-color: #1e3834ff;
  color: #fff;
}
  </style>
</head>

<body>
<header>
  <div class="logo"><img src="/imagens/logoatual.png" alt="Logo"></div>
  <nav>
    <ul>
      <li><a href="/anotacoes/index.php">Voltar</a></li>
    </ul>
  </nav>
</header>

<h1>Meu Caderno de Anotações</h1>

<form method="POST" action="">
  <div class="caderno">
    <div class="toolbar">
      <button type="button" onclick="document.execCommand('bold', false, null)">Negrito</button>

      <select id="fontSize" onchange="alterarTamanho(this.value)">
        <option value="3">Tamanho Médio</option>
        <option value="2">Tamanho Pequeno</option>
        <option value="5">Tamanho Grande</option>
      </select>

      <input type="color" id="colorPicker" title="Escolher Cor" onchange="alterarCor(this.value)">
    </div>

    <div id="editor" class="editor" contenteditable="true"><?= $conteudo_salvo ?></div>
    <input type="hidden" name="conteudo" id="conteudo">

    <button type="submit" class="btn-salvar" onclick="salvarConteudo()">💾 Salvar Anotação</button>
  </div>
</form>

<script>
  function salvarConteudo() {
    document.getElementById('conteudo').value = document.getElementById('editor').innerHTML;
  }

  function alterarCor(cor) {
    document.execCommand("foreColor", false, cor);
  }

  function alterarTamanho(tamanho) {
    document.execCommand("fontSize", false, tamanho);
  }
</script>
</body>
</html>
