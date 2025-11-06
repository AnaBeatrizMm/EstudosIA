<?php
// ===================== CONFIGURAÇÃO DO BANCO =====================
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd_usuarios"; // verifique que este banco existe no seu phpMyAdmin

// Ativa exibição de erros (apenas para desenvolvimento)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ===================== CONEXÃO =====================
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Erro na conexão com o banco: " . $conn->connect_error);
}

// ===================== EXCLUIR REGISTRO =====================
if (isset($_GET['excluir'])) {
  $idExcluir = intval($_GET['excluir']);
  $stmt = $conn->prepare("DELETE FROM financas WHERE id = ?");
  $stmt->bind_param("i", $idExcluir);
  $stmt->execute();
  $stmt->close();
  echo "<script>alert('🗑️ Registro excluído com sucesso!'); window.location='financias.php';</script>";
  exit;
}

// ===================== SALVAR DADOS (FORM POST) =====================
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['data'])) {
  $datas = $_POST['data'];
  $descricoes = $_POST['descricao'];
  $valores = $_POST['valor'];

  $stmt = $conn->prepare("INSERT INTO financas (`data`, descricao, valor) VALUES (?, ?, ?)");
  if (!$stmt) {
    $saveError = "Erro no prepare: " . $conn->error;
  } else {
    for ($i = 0; $i < count($datas); $i++) {
      $d = $datas[$i];
      $desc = $descricoes[$i];
      $val = $valores[$i];

      if (trim($d) === "" && trim($desc) === "" && trim($val) === "") continue;

      $valFloat = is_numeric($val) ? (float)$val : 0.0;
      $stmt->bind_param("ssd", $d, $desc, $valFloat);
      if (!$stmt->execute()) {
        $saveError = "Erro ao inserir: " . $stmt->error;
        break;
      }
    }
    $stmt->close();
  }

  if (!empty($saveError)) {
    echo "<script>alert('Erro ao salvar: " . addslashes($saveError) . "');</script>";
  } else {
    echo "<script>alert('✅ Finanças salvas com sucesso!');</script>";
    echo "<script>window.location = window.location.href;</script>";
    exit;
  }
}

// ===================== CARREGAR DADOS =====================
$financas = [];
$listError = "";
$sql = "SELECT id, `data`, descricao, valor FROM financas ORDER BY `data` DESC, id DESC";
$result = $conn->query($sql);
if ($result === false) {
  $listError = "Erro na consulta: " . $conn->error;
} else {
  while ($row = $result->fetch_assoc()) {
    $financas[] = $row;
  }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Finanças - Controle</title>

  <style>
    /* Barra de rolagem personalizada */
    ::-webkit-scrollbar { width: 12px; height: 12px; }
    ::-webkit-scrollbar-track { background: #f0f0f0; border-radius: 10px; }
    ::-webkit-scrollbar-thumb {
      background: #3f7c72; border-radius: 10px; border: 3px solid #f0f0f0;
    }
    ::-webkit-scrollbar-thumb:hover { background: #2a5c55; }

    /* Fonte personalizada */
    @font-face {
      font-family: 'SimpleHandmade';
      src: url(/fonts/SimpleHandmade.ttf);
    }

    * { box-sizing: border-box; }

    body {
      background-color: #3f7c72ff;
      font-family: 'Roboto', sans-serif;
      text-align: center;
      color: #ffffff;
      padding: 40px;
      margin-top: 100px;
    }

    /* Header fixo */
    header {
      position: fixed; top: 0; left: 0; width: 100%; height: 70px;
      background: #ffffffcc;
      display: flex; justify-content: space-between; align-items: center;
      padding: 0 2rem; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      z-index: 1000;
    }

    header .logo img {
      height: 450px; width: auto; display: block; margin-left: -85px;
    }

    nav ul {
      list-style: none; display: flex; align-items: center; gap: 20px;
      margin: 0; padding: 0;
    }

    nav ul li a {
      text-decoration: none; color: black; padding: 5px 10px;
      border-radius: 8px; transition: .3s; font-size: 18px;
    }

    nav ul li a:hover { background-color: #bdebe3; }

    h1 { font-family: 'SimpleHandmade'; font-size: 50px; margin-top: 20px; }
    h2 { font-family: 'SimpleHandmade'; font-size: 35px; color: white; }

    /* Tabela */
    table {
      margin: 20px auto; border-collapse: collapse; width: 90%;
      background-color: #bdebe3ff; border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    th, td {
      font-family: 'SimpleHandmade';
      border: 1px solid #1e3834ff; padding: 12px;
      font-size: 25px; color: #000;
    }

    th { background-color: #1e3834ff; color: white; }

    /* Botões */
    .btn {
      font-family: 'SimpleHandmade'; background-color: #2a5c55; color: white;
      padding: 10px 20px; border-radius: 10px; text-decoration: none;
      margin: 10px 5px; border: none; cursor: pointer; font-size: 22px;
      transition: 0.3s;
    }

    .btn:hover { background-color: #1e3834ff; }

    .btn-excluir {
      background-color: #c0392b;
      color: #fff;
      padding: 8px 14px;
      border-radius: 8px;
      font-size: 20px;
      cursor: pointer;
    }

    .btn-excluir:hover {
      background-color: #a93226;
    }

    input[type="text"],
    input[type="date"],
    select,
    input[type="number"] {
      width: 90%;
      padding: 8px;
      font-size: 14px;
      border-radius: 6px;
      border: 1px solid #2a5c55;
      background-color: #f1f6fb;
      color: #000000;
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

  <h1>Controle de Finanças</h1>

  <?php if (!empty($listError)): ?>
    <div class="msg-erro">Erro ao carregar registros: <?= htmlspecialchars($listError) ?></div>
  <?php endif; ?>

  <!-- Formulário de Inserção -->
  <form method="POST" action="">
    <table id="tabela">
      <thead>
        <tr><th>Data</th><th>Descrição</th><th>Valor (R$)</th></tr>
      </thead>
      <tbody>
        <tr>
          <td><input type="date" name="data[]"></td>
          <td><input type="text" name="descricao[]" placeholder="Ex: Compra de livro"></td>
          <td><input type="number" step="0.01" name="valor[]"></td>
        </tr>
      </tbody>
    </table>
    <button type="submit" class="btn">💾 Salvar</button>
  </form>

  <!-- Registros Salvos -->
  <h2>Registros Salvos</h2>
  <?php if (empty($financas)): ?>
    <p>Nenhum registro encontrado.</p>
  <?php else: ?>
    <table>
      <thead><tr><th>Data</th><th>Descrição</th><th>Valor (R$)</th><th>Ações</th></tr></thead>
      <tbody>
        <?php foreach ($financas as $f): ?>
          <tr>
            <td><?= htmlspecialchars($f['data']) ?></td>
            <td><?= htmlspecialchars($f['descricao']) ?></td>
            <td style="text-align:right"><?= number_format($f['valor'], 2, ',', '.') ?></td>
            <td><a class="btn-excluir" href="?excluir=<?= $f['id'] ?>" onclick="return confirm('Excluir este registro?')">Excluir</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

</body>
</html>
