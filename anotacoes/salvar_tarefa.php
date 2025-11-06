<?php
include '../conexao.php';

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data['tarefas'])) {
    die("Nenhum dado recebido.");
}

// Limpa as tarefas antigas antes de salvar novamente
$conn->query("DELETE FROM tarefas");

// Insere cada tarefa nova
$stmt = $conn->prepare("INSERT INTO tarefas (texto, marcada) VALUES (?, ?)");
foreach ($data['tarefas'] as $tarefa) {
    $texto = $tarefa['texto'];
    $marcada = $tarefa['marcada'] ? 1 : 0;
    $stmt->bind_param("si", $texto, $marcada);
    $stmt->execute();
}

echo "Tarefas salvas com sucesso! 💾";
$conn->close();
?>
