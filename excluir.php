<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id = $_POST['id'] ?? 0;

$conn = new mysqli('localhost', 'root', '', 'bd_usuarios');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$stmt = $conn->prepare("DELETE FROM chat_grupo WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: estudos.php");
exit;
?>
