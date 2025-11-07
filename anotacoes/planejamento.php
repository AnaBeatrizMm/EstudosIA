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

// ===================== SALVAR PLANEJAMENTO =====================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Apaga o planejamento antigo deste usuário
  $conn->query("DELETE FROM planejamento WHERE usuario_id = $usuario_id");

  // Recebe os dados do formulário
  $dias = $_POST["dia"] ?? [];
  $textos = $_POST["texto"] ?? [];

  for ($i = 0; $i < count($dias); $i++) {
    $dia = $dias[$i];
    $texto = $textos[$i];
    if (!empty($texto)) {
      $stmt = $conn->prepare("INSERT INTO planejamento (dia, texto, usuario_id) VALUES (?, ?, ?)");
      $stmt->bind_param("ssi", $dia, $texto, $usuario_id);
      $stmt->execute();
      $stmt->close();
    }
  }

  echo "<script>alert('💾 Planejamento salvo com sucesso!');</script>";
}

// ===================== CARREGAR PLANEJAMENTO =====================
$planejamento = [];
$result = $conn->query("SELECT * FROM planejamento WHERE usuario_id = $usuario_id");
while ($row = $result->fetch_assoc()) {
  $planejamento[$row['dia']] = $row['texto'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Planejamento</title>
  <link rel="icon" type="image/png" href="/anotacoes/imagens/icon site.png" sizes="612x612">
  <link rel="stylesheet" href="estilo.css">
  <style>
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
    @font-face {
      font-family: 'SimpleHandmade';
      src: url(/fonts/SimpleHandmade.ttf);
    }
    * {
      box-sizing: border-box;
    }
    /* Espaço extra para o conteúdo não ficar atrás da nav fixa */
    body {
      background-color: #3f7c72ff;
      font-family:'Roboto',sans-serif;
      text-align: center;
      color: #3f7c72ff;
      padding: 40px 40px 40px 40px;
      margin: 0;
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

    h1 {
      font-size: 50px;
      font-family: 'SimpleHandmade';
      color: #ffffff;
      margin-top: 105;
    }

    table {
      margin: 20px auto;
      width: 90%;
      max-width: 900px;
      border-collapse: collapse;
      background-color: #bdebe3ff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
      font-family: 'SimpleHandmade';
      border: 1px solid #1e3834ff;
      padding: 12px;
      font-size: 25px;
      color: #3f7c72ff;
    }

    th {
      background-color: #2a5c55;
      color: #ffffff;
    }

    td:first-child {
      width: 30%;
      font-weight: bold;
    }

    td textarea {
    width: 95%;
    height: 60px;
    border-radius: 8px;
    padding: 8px;
    border: 1px solid #2a5c55;
    background-color: #f1f6fb;
    resize: vertical;
    color: #000000; /* COR ESCURA PARA TEXTO VISÍVEL */
    font-size: 14px;
}

    .btn {
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
      transition: background 0.3s;
    }

    .btn:hover {
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
  <h1>Planejamento Semanal</h1>
  
  <form method="POST">
  <table id="tabela-planejamento">
    <tr><th>Dia</th><th>Planejamento</th></tr>
    <?php
      $dias = ['Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado','Domingo'];
      foreach ($dias as $dia) {
        $texto = $planejamento[$dia] ?? '';
        echo "
          <tr>
            <td><input type='hidden' name='dia[]' value='$dia'>$dia</td>
            <td><textarea name='texto[]' placeholder='O que vou fazer?'>$texto</textarea></td>
          </tr>
        ";
      }
    ?>
  </table>

  <!-- Botão centralizado embaixo da tabela -->
  <button class="btn" type="submit">💾 Salvar</button>
</form>


  <script>
    function salvarPlanejamento() {
      const linhas = document.querySelectorAll('#tabela-planejamento tr');
      const planejamento = [];

      for (let i = 1; i < linhas.length; i++) {
        const dia = linhas[i].cells[0].innerText;
        const texto = linhas[i].cells[1].querySelector('textarea').value;
        planejamento.push({ dia, planejamento: texto });
      }

      console.log("Planejamento da semana:", planejamento);
      alert("Planejamento salvo no console! (simulação)");
    }
  </script>

</body>
</html>
