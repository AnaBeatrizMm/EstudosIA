<?php
session_start();
$usuario = $_SESSION['usuario'] ?? 'Convidado';

$conn = new mysqli('localhost', 'root', '', 'bd_usuarios');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$mensagem = $_POST['mensagem'] ?? '';
$arquivo = null;

// Upload de arquivo
if (!empty($_FILES['arquivo']['name'])) {
    $nome = basename($_FILES['arquivo']['name']);
    $destino = "uploads/" . $nome;

    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino)) {
        $arquivo = $destino;
    }
}

$stmt = $conn->prepare("INSERT INTO chat_grupo (usuario, mensagem, arquivo) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $usuario, $mensagem, $arquivo);
$stmt->execute();
$stmt->close();

$conn->close();

// Retorna para o chat
header("Location: estudos.php");
exit;
?>
