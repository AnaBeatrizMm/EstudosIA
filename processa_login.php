<?php
include 'conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario_id']   = $user['id'];
$_SESSION['usuario_nome'] = $user['nome'];

            // guarda a mensagem na sessão em vez de localStorage
$_SESSION['mensagemLogin'] = "Login realizado com sucesso!";

// redireciona para inicio.php
header("Location: inicio.php");
exit;

            exit;
        } else {
            echo "<script>
            localStorage.setItem('mensagemErro', 'Senha incorreta! Tente novamente.');
            window.location.href = 'login.php';
        </script>";
            exit;
        }
    } else {
        echo "<script>
        localStorage.setItem('mensagemErro', 'E-mail não cadastrado!');
        window.location.href = 'login.php';
    </script>";
        exit;
    }
}
?>
