<?php
// ======= CONEXÃO COM O BANCO =======
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd_usuarios";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Erro na conexão com o banco: " . $conn->connect_error);
}

// ======= CRIA A TABELA CASO NÃO EXISTA =======
$conn->query("
CREATE TABLE IF NOT EXISTS tarefas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  descricao VARCHAR(255) NOT NULL,
  concluida TINYINT(1) DEFAULT 0
)
");

// ======= ADICIONAR NOVA TAREFA =======
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nova_tarefa"])) {
  $nova_tarefa = trim($_POST["nova_tarefa"]);
  if ($nova_tarefa !== "") {
    $stmt = $conn->prepare("INSERT INTO tarefas (descricao) VALUES (?)");
    $stmt->bind_param("s", $nova_tarefa);
    $stmt->execute();
    $stmt->close();
  }
  header("Location: tarefas.php");
  exit;
}

// ======= MARCAR/DESMARCAR CONCLUÍDA =======
if (isset($_GET["toggle"])) {
  $id = intval($_GET["toggle"]);
  $conn->query("UPDATE tarefas SET concluida = 1 - concluida WHERE id = $id");
  header("Location: tarefas.php");
  exit;
}

// ======= EXCLUIR TAREFA =======
if (isset($_GET["delete"])) {
  $id = intval($_GET["delete"]);
  $conn->query("DELETE FROM tarefas WHERE id = $id");
  header("Location: tarefas.php");
  exit;
}

// ======= CARREGAR TAREFAS =======
$result = $conn->query("SELECT * FROM tarefas ORDER BY id DESC");
$tarefas = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Minhas Tarefas</title>
<style>
/* Barra toda */
::-webkit-scrollbar {
  width: 12px;
  height: 12px;
}
::-webkit-scrollbar-track {
  background: #f0f0f0;
  border-radius: 10px;
}
::-webkit-scrollbar-thumb {
  background: #3f7c72;
  border-radius: 10px;
  border: 3px solid #f0f0f0;
}
::-webkit-scrollbar-thumb:hover {
  background: #2a5c55;
}

@font-face {
  font-family: 'SimpleHandmade';
  src: url(/fonts/SimpleHandmade.ttf);
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  background-color: #3f7c72ff;
  font-family: 'Roboto', sans-serif;
  text-align: center;
  color: #3f7c72ff;
  padding-top: 100px;
}

/* Header */
header {
  position: fixed; top:0; left:0; width:100%; height:70px;
  background:#ffffffcc; display:flex; justify-content:space-between; align-items:center;
  padding:0 2rem; box-shadow:0 2px 5px rgba(0,0,0,0.1); z-index:1000;
}
header .logo img {
  height:450px; width:auto; display:block; margin-left:-85px;
}
nav ul {
  list-style:none; display:flex; align-items:center; gap:20px; margin:0;
}
nav ul li a {
  text-decoration:none; color:black; padding:5px 10px; border-radius:8px; transition:.3s;
}

h1 {
  font-size: 50px;
  font-family: 'SimpleHandmade';
  color: #ffffff;
  margin-bottom: 20px;
}

/* Container principal */
.tarefas-container {
  background-color: #bdebe3ff;
  border-radius: 10px;
  border: 2px solid #1e3834ff;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  width: 90%;
  max-width: 900px;
  margin: 0 auto 60px;
  padding: 30px 20px;
}

/* Campo de nova tarefa */
form {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 15px;
  margin-bottom: 30px;
}

input[type="text"] {
  width: 70%;
  padding: 10px;
  font-size: 18px;
  border: 2px solid #1e3834ff;
  border-radius: 8px;
  background-color: #f1f6fb;
  color: #000;
}

input[type="submit"] {
  background-color: #2a5c55;
  color: #ffffff;
  padding: 12px 25px;
  border-radius: 10px;
  border: none;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s ease;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
input[type="submit"]:hover {
  background-color: #1e3834ff;
}

/* Lista de tarefas */
ul {
  list-style: none;
  padding: 0;
  margin: 0 auto;
  max-width: 700px;
}

.tarefa {
  background-color: #ffffff;
  border: 1px solid #1e3834ff;
  border-radius: 10px;
  padding: 12px 16px;
  margin-bottom: 15px;
  display: flex;
  align-items: center;
  transition: 0.3s;
  font-family: 'SimpleHandmade';
  font-size: 25px;
  color: #3f7c72ff;
}

.tarefa input[type="checkbox"] {
  transform: scale(1.4);
  margin-right: 15px;
  cursor: pointer;
  accent-color: #2a5c55;
}

.tarefa span {
  flex-grow: 1;
  text-align: left;
  cursor: pointer;
}

.tarefa.concluida span {
  text-decoration: line-through;
  color: #777;
}

.tarefa button {
  background-color: #2a5c55;
  color: #ffffff;
  border: none;
  border-radius: 8px;
  padding: 6px 12px;
  cursor: pointer;
  font-size: 16px;
  margin-left: 10px;
  transition: background-color 0.3s ease;
}

.tarefa button:hover {
  background-color: #1e3834ff;
}

.btn-salvar {
  background-color: #2a5c55;
  color: #ffffff;
  padding: 12px 30px;
  border-radius: 10px;
  border: none;
  margin-top: 30px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s ease;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.btn-salvar:hover {
  background-color: #1e3834ff;
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

<h1>Meu Checklist</h1>

<div class="tarefas-container">
  <form method="POST" action="">
    <input type="text" name="nova_tarefa" placeholder="Digite uma nova tarefa..." required>
    <input type="submit" value="Adicionar">
  </form>

  <ul>
    <?php if (empty($tarefas)): ?>
      <p style="font-family:'SimpleHandmade';font-size:25px;color:#2a5c55;">Nenhuma tarefa ainda 💚</p>
    <?php else: ?>
      <?php foreach ($tarefas as $t): ?>
        <li class="tarefa <?= $t['concluida'] ? 'concluida' : '' ?>">
          <input type="checkbox" onchange="window.location='?toggle=<?= $t['id'] ?>'" <?= $t['concluida'] ? 'checked' : '' ?>>
          <span><?= htmlspecialchars($t['descricao']) ?></span>
          <button onclick="window.location='?delete=<?= $t['id'] ?>'">Excluir</button>
        </li>
      <?php endforeach; ?>
    <?php endif; ?>
  </ul>
</div>

<button class="btn-salvar" onclick="alert('Tudo já é salvo automaticamente 💾')">Salvar</button>

</body>
</html>
