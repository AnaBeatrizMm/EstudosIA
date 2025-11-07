<?php
session_start();
include 'config.php';

// ------------------- Usuário logado -------------------
// Pegando o usuário da sessão
if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para acessar esta página.");
}
$usuario_id = $_SESSION['usuario_id'];

// ------------------- Adicionar plano -------------------
if (isset($_POST['acao']) && $_POST['acao'] === 'add') {
    $semana = intval($_POST['semana']);
    $atividades = $_POST['atividades'];

    try {
        $stmt = $pdo->prepare("INSERT INTO planos (usuario_id, semana, atividades) VALUES (:usuario_id, :semana, :atividades)");
        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':semana' => $semana,
            ':atividades' => $atividades
        ]);
        header("Location: plano_estudos.php");
        exit;
    } catch (PDOException $e) {
        die("Erro ao salvar plano: " . $e->getMessage());
    }
}

// ------------------- Editar plano -------------------
if (isset($_POST['acao']) && $_POST['acao'] === 'edit') {
    $id = intval($_POST['id']);
    $semana = intval($_POST['semana']);
    $atividades = $_POST['atividades'];

    try {
        $stmt = $pdo->prepare("UPDATE planos SET semana = :semana, atividades = :atividades WHERE id = :id AND usuario_id = :usuario_id");
        $stmt->execute([
            ':semana' => $semana,
            ':atividades' => $atividades,
            ':id' => $id,
            ':usuario_id' => $usuario_id
        ]);
        header("Location: plano_estudos.php");
        exit;
    } catch (PDOException $e) {
        die("Erro ao atualizar plano: " . $e->getMessage());
    }
}

// ------------------- Excluir plano -------------------
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    try {
        $stmt = $pdo->prepare("DELETE FROM planos WHERE id = :id AND usuario_id = :usuario_id");
        $stmt->execute([
            ':id' => $id,
            ':usuario_id' => $usuario_id
        ]);
        header("Location: plano_estudos.php");
        exit;
    } catch (PDOException $e) {
        die("Erro ao excluir plano: " . $e->getMessage());
    }
}

// ------------------- Buscar planos do usuário -------------------
try {
    $stmt = $pdo->prepare("SELECT * FROM planos WHERE usuario_id = :usuario_id ORDER BY semana ASC");
    $stmt->execute([':usuario_id' => $usuario_id]);
    $planos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar planos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Plano de Estudos</title>
    <link rel="icon" type="image/png" href="/anotacoes/imagens/icon site.png" sizes="612x612">
    <link rel="stylesheet" href="estilo.css">
    <style>
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
  color: #3f7c72ff;
  text-align: center;
  padding: 40px;
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

/* Títulos */
h1 {
  margin-top: 70px;
  font-family: 'SimpleHandmade';
  font-size: 50px;
  color: #ffffff;
  margin-bottom: 50px;
}

h2 {
  font-family: 'SimpleHandmade';
  font-size: 35px;
  color: #ffffff;
  margin-top: 40px;
  margin-bottom: 20px;
}

/* Formulários */
form {
  background: #bdebe3ff;
  padding: 20px;
  border-radius: 12px;
  max-width: 700px;
  margin: 0 auto 40px auto;
  box-shadow: 0 4px 10px rgba(0,0,0,0.15);
  text-align: left;
}

form label {
  font-weight: bold;
  display: block;
  margin-bottom: 8px;
  font-size: 18px;
  color: #2a5c55;
}

input[type="number"],
textarea {
  width: 100%;
  padding: 10px;
  border-radius: 8px;
  border: 2px solid #2a5c55;
  margin-bottom: 20px;
  font-size: 16px;
  background-color: #f1f6fb;
}

textarea {
  resize: none;
  height: 120px;
}

button {
  font-family: 'SimpleHandmade';
  background-color: #2a5c55;
  color: #ffffff;
  padding: 12px 25px;
  border-radius: 10px;
  font-size: 20px;
  border: none;
  cursor: pointer;
  transition: .3s;
}

button:hover {
  background-color: #1e3834ff;
}

/* Tabela */
table {
  margin: 20px auto;
  border-collapse: collapse;
  width: 95%;
  max-width: 900px;
  background-color: #bdebe3ff;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

th, td {
  font-family: 'SimpleHandmade';
  border: 1px solid #1e3834ff;
  padding: 12px;
  font-size: 20px;
  text-align: center;
}

th {
  background-color: #2a5c55;
  color: #ffffff;
}

/* Links de ação */
.actions a {
  display: inline-block;
  background-color: #2a5c55;
  color: #fff;
  padding: 8px 15px;
  border-radius: 8px;
  text-decoration: none;
  margin: 5px;
  transition: .3s;
  font-size: 16px;
}

.actions a:hover {
  background-color: #1e3834ff;
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
    <h1>Plano de Estudos</h1>

    <!-- Adicionar Plano -->
    <h2>Adicionar Plano</h2>
    <form method="POST">
        <input type="hidden" name="acao" value="add">
        Semana: <input type="number" name="semana" required>
        <br><br>
        Atividades:<br>
        <textarea name="atividades" rows="4" required></textarea>
        <br><br>
        <button type="submit">Salvar Plano</button>
    </form>

    <!-- Listagem de Planos -->
    <h2>Planos Salvos</h2>
    <table>
        <tr>
            <th>Semana</th>
            <th>Atividades</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($planos as $plano): ?>
        <tr>
            <td><?= htmlspecialchars($plano['semana']) ?></td>
            <td><?= nl2br(htmlspecialchars($plano['atividades'])) ?></td>
            <td class="actions">
                <a href="?edit=<?= $plano['id'] ?>">Editar</a>
                <a href="?delete=<?= $plano['id'] ?>" onclick="return confirm('Deseja realmente excluir?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Formulário de Edição -->
    <?php
    if (isset($_GET['edit'])):
        $edit_id = intval($_GET['edit']);
        try {
            $stmt = $pdo->prepare("SELECT * FROM planos WHERE id = :id AND usuario_id = :usuario_id");
            $stmt->execute([':id' => $edit_id, ':usuario_id' => $usuario_id]);
            $plano_edit = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erro ao buscar plano para edição: " . $e->getMessage());
        }

        if ($plano_edit):
    ?>
        <h2>Editar Plano - Semana <?= $plano_edit['semana'] ?></h2>
        <form method="POST">
            <input type="hidden" name="acao" value="edit">
            <input type="hidden" name="id" value="<?= $plano_edit['id'] ?>">
            Semana: <input type="number" name="semana" value="<?= $plano_edit['semana'] ?>" required>
            <br><br>
            Atividades:<br>
            <textarea name="atividades" rows="4" required><?= htmlspecialchars($plano_edit['atividades']) ?></textarea>
            <br><br>
            <button type="submit">Atualizar Plano</button>
        </form>
    <?php 
        endif;
    endif; 
    ?>
</body>
</html>
