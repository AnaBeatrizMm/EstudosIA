<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "bd_usuarios";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Falha na conexão: " . $conn->connect_error);

$mensagem = "";

if (isset($_POST['email'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $result = $conn->query("SELECT nome FROM usuarios WHERE email='$email'");

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nome = $row['nome'];
        
        // Gera token e data de expiração (30 minutos)
        $token = bin2hex(random_bytes(16));
        $expira = date("Y-m-d H:i:s", strtotime("+30 minutes"));
        $conn->query("UPDATE usuarios SET token='$token', expira_token='$expira' WHERE email='$email'");
        
        // Gera link e exibe direto na tela
        $link = "http://localhost:8000/redefinir.php?token=".$token;
        $mensagem = "
        <div style='background:#3f7c72ff;padding:20px;border-radius:10px;text-align:center;'>
            <h3 style='color:#3f7c72ff;'>Recuperação de Senha</h3>
            <p style='color:#fff;'>Olá, <strong>{$nome}</strong>! Aqui está seu link para redefinir a senha:</p>
            <p><a href='{$link}' style='background-color:#fff;color:#3f7c72ff;padding:10px 20px;border-radius:5px;text-decoration:none;'>Redefinir Senha</a></p>
            <p style='font-size:13px;color:#666;'>O link expira em 30 minutos.</p>
        </div>";
    } else {
        $mensagem = "Email não cadastrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Recuperar Senha</title>
<style>
@font-face { font-family: raesha; src: url('fonts/Raesha.ttf') format('truetype'); }
body {
  font-family: Arial, sans-serif;
  background: #3f7c72ff;
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
h2 { color: #3f7c72ff; font-family: 'raesha'; margin-bottom: 20px; }
input {
  width: 80%;
  padding: 12px;
  margin: 10px 0;
  border: 2px solid #3f7c72ff;
  border-radius: 25px;
  font-size: 1rem;
  outline: none;
}
input:focus { border-color: #1e3834ff; }
button {
  width: 50%;
  padding: 12px;
  background-color: #3f7c72ff;
  color:white;
  border:none;
  border-radius:25px;
  font-size:1.1rem;
  cursor:pointer;
  margin-top:10px;
}
button:hover { background-color: #1e3834ff; }
.mensagem {
  margin: 15px 0;
}
</style>
</head>
<body>
<div class="container">
  <h2>Recuperar Senha</h2>
  <?php if($mensagem) echo "<div class='mensagem'>{$mensagem}</div>"; ?>
  <form method="POST">
    <input type="email" name="email" placeholder="Digite seu e-mail" required>
    <button type="submit">Gerar Link</button>
  </form>
</div>
</body>
</html>
