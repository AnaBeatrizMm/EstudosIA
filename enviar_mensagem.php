<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mensagem'])) {
    $msg = trim($_POST['mensagem']);
    if ($msg !== '') {
        // Aqui você salvaria a mensagem no banco de dados
        // Exemplo: INSERT INTO mensagens (usuario, texto, grupo) VALUES (...)
        header("Location: estudos.php");
        exit();
    }
}
?>
