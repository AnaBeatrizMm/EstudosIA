<?php
include '../conexao.php';

$result = $conn->query("SELECT texto, marcada FROM tarefas ORDER BY id ASC");
$tarefas = [];

while ($row = $result->fetch_assoc()) {
    $tarefas[] = $row;
}

header('Content-Type: application/json');
echo json_encode($tarefas);
$conn->close();
?>
