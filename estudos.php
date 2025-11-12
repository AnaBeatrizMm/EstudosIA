<?php
session_start();

// se não estiver logado, volta pro login
// se o usuário não estiver logado, define user_id como 0 (sem redirecionar)
$user_id = $_SESSION['user_id'] ?? 0;

// conecta ao banco
$conn = new mysqli('localhost', 'root', '', 'bd_usuarios');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// busca nome do usuário logado (se existir)
$usuario = "Visitante";
if ($user_id > 0) {
    $stmt = $conn->prepare("SELECT nome FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $usuario = $row['nome'];
    }
    $stmt->close();
}


$user_id = $_SESSION['user_id'];

// conecta ao banco
$conn = new mysqli('localhost', 'root', '', 'bd_usuarios');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// busca nome do usuário logado
$stmt = $conn->prepare("SELECT nome FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc()['nome'] ?? "Usuário";

$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Grupo de Estudos 💬</title>
<style>
    body {
        font-family: "Poppins", sans-serif;
        background-color: #2e7d32;
        margin: 0;
        padding: 0;
    }

    .chat-container {
        width: 90%;
        max-width: 1000px;
        height: 92vh;
        margin: 30px auto;
        background-color: #e9f7ec;
        border-radius: 25px;
        box-shadow: 0 0 25px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .chat-header {
        background-color: #e9f7ec;
        color: #1b5e20;
        padding: 25px;
        display: flex;
        flex-direction: column;
        align-items: center;
        border-bottom: 3px solid #c8e6c9;
    }

    .chat-header-content {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .chat-header img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #1b5e20;
    }

    .chat-header h1 {
        font-size: 26px;
        margin: 0;
        color: #1b5e20;
    }

    .chat-header p {
        font-size: 14px;
        color: #388e3c;
        margin-top: 6px;
    }

    .chat-messages {
        flex: 1;
        padding: 25px;
        overflow-y: auto;
        background-color: #f7fff8;
        display: flex;
        flex-direction: column-reverse;
    }

    .mensagem {
        background-color: #ffffff;
        border-radius: 15px;
        padding: 12px 16px;
        margin-bottom: 18px;
        max-width: 70%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .minha-mensagem {
        align-self: flex-end;
        background-color: #d0f0d4;
    }

    .mensagem strong {
        display: block;
        font-size: 14px;
        color: #1b5e20;
        margin-bottom: 5px;
    }

    .responder-btn,
    .excluir-btn {
        font-size: 12px;
        background: none;
        border: none;
        cursor: pointer;
        margin-top: 10px;
        display: block;
    }

    .responder-btn {
        color: #2e7d32;
    }

    .responder-btn:hover {
        text-decoration: underline;
    }

    .excluir-btn {
        color: red;
        font-size: 18px;
    }

    .chat-input {
        display: flex;
        align-items: center;
        padding: 12px;
        border-top: 2px solid #c8e6c9;
        background-color: #f9fff8;
    }

    textarea {
        flex: 1;
        border-radius: 20px;
        border: 1px solid #a5d6a7;
        padding: 10px;
        resize: none;
        height: 45px;
        font-family: inherit;
        margin-right: 8px;
        background-color: #ffffff;
    }

    .file-label {
        background-color: #2e7d32;
        color: white;
        padding: 8px 12px;
        border-radius: 20px;
        cursor: pointer;
        margin-right: 8px;
    }

    .file-label:hover {
        background-color: #43a047;
    }

    button {
        background-color: #2e7d32;
        color: white;
        border: none;
        border-radius: 20px;
        padding: 10px 18px;
        cursor: pointer;
    }

    button:hover {
        background-color: #43a047;
    }

    .mensagem img {
        max-width: 150px;
        border-radius: 8px;
        margin-top: 6px;
    }

    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }

    .chat-messages::-webkit-scrollbar-thumb {
        background-color: #a5d6a7;
        border-radius: 10px;
    }

    .resposta-info {
        font-size: 12px;
        color: #388e3c;
        background-color: #e8f5e9;
        border-left: 3px solid #43a047;
        padding: 4px 8px;
        border-radius: 6px;
        margin-bottom: 6px;
    }
</style>
</head>
<body>
<div class="chat-container">
    <div class="chat-header">
        <div class="chat-header-content">
            <img src="https://i.pinimg.com/1200x/e4/6d/1a/e46d1add185e813f4cc36b417128647f.jpg" alt="Grupo">
            <h1>Grupo de Estudos</h1>
        </div>
        <p>Bem-vindo(a), <strong><?= htmlspecialchars($usuario) ?></strong> 🌿</p>
    </div>

    <div class="chat-messages" id="chat">
        <?php
        $sql = "SELECT m.*, u.nome FROM chat_grupo m 
                JOIN usuarios u ON m.user_id = u.id 
                ORDER BY m.data_envio DESC";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $classe = ($row['user_id'] == $user_id) ? 'mensagem minha-mensagem' : 'mensagem';
            echo "<div class='$classe'>";
            
            if (!empty($row['resposta_para'])) {
                echo "<div class='resposta-info'>Respondendo a <strong>" . htmlspecialchars($row['resposta_para']) . "</strong></div>";
            }
            
            echo "<strong>" . htmlspecialchars($row['nome']) . "</strong>";
            echo nl2br(htmlspecialchars($row['mensagem']));
            
            if (!empty($row['arquivo'])) {
                $ext = pathinfo($row['arquivo'], PATHINFO_EXTENSION);
                if (in_array(strtolower($ext), ['jpg','jpeg','png','gif'])) {
                    echo "<br><img src='" . htmlspecialchars($row['arquivo']) . "' alt='imagem'>";
                } else {
                    echo "<br><a href='" . htmlspecialchars($row['arquivo']) . "' download>📎 " . basename($row['arquivo']) . "</a>";
                }
            }

            echo "<button class='responder-btn' onclick=\"responder('" . htmlspecialchars($row['nome']) . "')\">Responder</button>";

            // botão 🗑️ só para o autor
            if ($row['user_id'] == $user_id) {
                echo "<form action='excluir.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <button type='submit' class='excluir-btn' title='Excluir mensagem'>🗑️</button>
                      </form>";
            }

            echo "</div>";
        }

        $conn->close();
        ?>
    </div>

    <form class="chat-input" action="enviar.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="resposta_para" id="resposta_para">
        <label for="arquivo" class="file-label">📎</label>
        <input type="file" name="arquivo" id="arquivo" style="display:none;">
        <textarea name="mensagem" placeholder="Escreva sua mensagem..."></textarea>
        <button type="submit">Enviar</button>
    </form>
</div>

<script>
    const chat = document.getElementById('chat');
    chat.scrollTop = chat.scrollHeight;

    function responder(usuario) {
        document.getElementById('resposta_para').value = usuario;
        const input = document.querySelector('textarea');
        input.placeholder = "Respondendo a " + usuario + "...";
        input.focus();
    }
</script>
</body>
</html>
