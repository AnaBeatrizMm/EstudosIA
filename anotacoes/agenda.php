<?php
session_start();

// ===================== VERIFICAR LOGIN =====================
if (!isset($_SESSION['usuario_id'])) {
  header("Location: /login.php");
  exit;
}
$usuario_id = $_SESSION['usuario_id'];

// ===================== CONEXÃO COM O BANCO =====================
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd_usuarios";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Erro na conexão com o banco: " . $conn->connect_error);
}

// ===================== SALVAR DADOS =====================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Apaga todos os registros antigos desse usuário
  $conn->query("DELETE FROM agenda WHERE usuario_id = $usuario_id");

  $dias = ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo'];

  foreach ($dias as $dia) {
    $compromisso = $_POST["compromisso_$dia"] ?? '';
    $horario = $_POST["horario_$dia"] ?? '';
    if (!empty($compromisso) || !empty($horario)) {
      $stmt = $conn->prepare("INSERT INTO agenda (dia, compromisso, horario, usuario_id) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("sssi", $dia, $compromisso, $horario, $usuario_id);
      $stmt->execute();
      $stmt->close();
    }
  }

  // Salvar notas gerais
  $notas = $_POST["notas"] ?? '';
  if (!empty($notas)) {
    $stmt = $conn->prepare("INSERT INTO agenda (dia, notas, usuario_id) VALUES ('notas', ?, ?)");
    $stmt->bind_param("si", $notas, $usuario_id);
    $stmt->execute();
    $stmt->close();
  }

  echo "<script>alert('💾 Agenda salva com sucesso!');</script>";
}

// ===================== CARREGAR DADOS =====================
$agenda = [];
$result = $conn->query("SELECT * FROM agenda WHERE usuario_id = " . $usuario_id);
while ($row = $result->fetch_assoc()) {
  $agenda[$row['dia']] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Agenda</title>
  <link rel="icon" type="image/png" href="/anotacoes/imagens/icon site.png" sizes="612x612">
  <link rel="stylesheet" href="estilo.css">
  <style>
    /* Barra toda */
    ::-webkit-scrollbar { width: 12px; height: 12px; }
    ::-webkit-scrollbar-track { background: #f0f0f0; border-radius: 10px; }
    ::-webkit-scrollbar-thumb { background: #3f7c72; border-radius: 10px; border: 3px solid #f0f0f0; }
    ::-webkit-scrollbar-thumb:hover { background: #2a5c55; }

    @font-face { font-family: 'SimpleHandmade'; src: url(/fonts/SimpleHandmade.ttf); }

    * { box-sizing: border-box; }

    body {
      background-color: #3f7c72ff;
      font-family: 'Roboto', sans-serif;
      text-align: center;
      color: #3f7c72ff;
      padding: 40px;
    }

    h1 {
      margin-top: 95;
      font-size: 50px;
      font-family: 'SimpleHandmade';
      color: #ffffff;
    }

    table {
      margin: 20px auto;
      border-collapse: collapse;
      width: 95%;
      max-width: 800px;
      background-color: #bdebe3ff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
      font-family: 'SimpleHandmade';
      border: 1px solid #1e3834ff;
      padding: 12px;
      font-size: 25px;
    }

    th {
      background-color: #2a5c55;
      color: #ffffff;
    }

    input[type="text"],
    input[type="time"] {
      width: 90%;
      padding: 8px;
      font-size: 14px;
      border-radius: 6px;
      border: 1px solid #2a5c55;
      background-color: #f1f6fb;
      color: #000000;
    }

    textarea {
      width: 90%;
      height: 100px;
      border-radius: 8px;
      border: 2px solid #2a5c55;
      padding: 10px;
      background-color: #bdebe3ff;
      resize: none;
      font-size: 16px;
      color: #000000;
      margin-top: 20px;
    }

    .btn-salvar {
      font-family: 'SimpleHandmade';
      margin-top: 25px;
      background-color: #2a5c55;
      color: #ffffff;
      padding: 12px 25px;
      border-radius: 10px;
      font-size: 22px;
      font-weight: bold;
      border: none;
      cursor: pointer;
    }

    .btn-salvar:hover {
      background-color: #1e3834ff;
    }

    header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 70px;
      background: #ffffffcc;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 2rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      z-index: 1000;
    }

    header .logo img {
      height: 450px;
      width: auto;
      display: block;
      margin-left: -85px;
    }

    nav ul {
      list-style: none;
      display: flex;
      align-items: center;
      gap: 20px;
      margin: 0;
    }

    nav ul li a {
      text-decoration: none;
      color: black;
      padding: 5px 10px;
      border-radius: 8px;
      transition: .3s;
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

  <h1>Agenda</h1>

  <form method="POST" action="">
    <table>
      <thead>
        <tr>
          <th>Dia</th>
          <th>Compromisso</th>
          <th>Horário</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $dias_semana = [
          'segunda' => 'Segunda',
          'terca' => 'Terça',
          'quarta' => 'Quarta',
          'quinta' => 'Quinta',
          'sexta' => 'Sexta',
          'sabado' => 'Sábado',
          'domingo' => 'Domingo'
        ];
        foreach ($dias_semana as $chave => $nome) {
          $comp = $agenda[$chave]['compromisso'] ?? '';
          $hora = $agenda[$chave]['horario'] ?? '';
          echo "<tr>
                  <td>$nome</td>
                  <td><input type='text' name='compromisso_$chave' value='$comp'></td>
                  <td><input type='time' name='horario_$chave' value='$hora'></td>
                </tr>";
        }
        ?>
      </tbody>
    </table>

    <textarea name="notas" placeholder="Notas gerais..."><?php echo $agenda['notas']['notas'] ?? ''; ?></textarea><br>

    <button type="submit" class="btn-salvar">💾 Salvar Agenda</button>
  </form>
</body>
</html>
