<?php
$conn = new mysqli("localhost", "root", "", "bd_usuarios");
if ($conn->connect_error) die("Erro: " . $conn->connect_error);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Redefinir Senha</title>
<style>
@font-face { font-family: raesha; src: url('fonts/Raesha.ttf') format('truetype'); }

body {
  font-family: Arial, sans-serif;
  background: rgb(243,228,201);
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.container {
  background: white;
  padding: 30px;
  border-radius: 15px;
  width: 350px;
  text-align: center;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

h2 {
  color: rgb(139,80,80);
  font-family: 'raesha';
  margin-bottom: 20px;
}

input {
  width: 80%;
  padding: 12px;
  margin: 10px 0;
  border: 2px solid rgb(192,98,98);
  border-radius: 25px;
  font-size: 1rem;
  outline: none;
}

input:focus { border-color: rgb(139,80,80); }

button {
  width: 50%;
  padding: 12px;
  background-color: rgb(192,98,98);
  color: white;
  border: none;
  border-radius: 25px;
  font-size: 1.1rem;
  cursor: pointer;
  margin-top: 10px;
}

button:hover { background-color: rgb(139,80,80); }

.mensagem {
  margin-top: 15px;
  padding: 10px;
  border-radius: 5px;
  font-weight: bold;
}

.sucesso {
  background-color: #d4edda;
  color: #155724;
}

.erro {
  background-color: #f8d7da;
  color: #721c24;
}
</style>
</head>
<body>
<div class="container">
  <h2>Redefinir Senha</h2>
  <?php
  if (isset($_GET["token"])) {
      $token = $conn->real_escape_string($_GET["token"]);
      $sql = "SELECT * FROM usuarios WHERE token='$token' AND expira_token > NOW()";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          if ($_SERVER["REQUEST_METHOD"] === "POST") {
              $nova_senha = password_hash($_POST["nova_senha"], PASSWORD_DEFAULT);
              $conn->query("UPDATE usuarios SET senha='$nova_senha', token=NULL, expira_token=NULL WHERE token='$token'");
              echo "<div class='mensagem sucesso'>Senha alterada com sucesso!</div>";
          } else {
              echo '
              <form method="POST">
                <input type="password" name="nova_senha" placeholder="Digite sua nova senha" required>
                <button type="submit">Redefinir</button>
              </form>';
          }
      } else {
          echo "<div class='mensagem erro'>Token inválido ou expirado.</div>";
      }
  } else {
      echo "<div class='mensagem erro'>Token não informado.</div>";
  }
  ?>
</div>
</body>
</html>
