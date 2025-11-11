<?php
session_start();

// Caso o usuário não esteja logado, defina um nome padrão temporário
$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Convidado';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Grupo de Estudos</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #2f4f3e;
            background-image: url('flores.png');
            background-repeat: repeat;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            width: 80%;
            margin: 40px auto;
            background-color: #f9fff7;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            height: 85vh;
        }

        .header-grupo {
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: center;
            padding: 15px;
            border-bottom: 2px solid #e0efe0;
        }

        .header-grupo img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #4a7058;
        }

        .titulo-grupo {
            font-size: 24px;
            font-weight: bold;
            color: #2f4f3e;
        }

        .descricao {
            text-align: center;
            font-size: 15px;
            color: #4a7058;
            padding: 8px 0;
            border-bottom: 1px solid #d7e8d7;
        }

        .mensagens {
            flex: 1;
            background-color: #e5f2e0;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .mensagem {
            max-width: 65%;
            padding: 10px 15px;
            border-radius: 15px;
            font-size: 15px;
            line-height: 1.4;
            word-wrap: break-word;
            display: inline-block;
            position: relative;
        }

        .enviada {
            background-color: #d9fdd3;
            align-self: flex-end;
            border-bottom-right-radius: 5px;
        }

        .recebida {
            background-color: #fff;
            align-self: flex-start;
            border-bottom-left-radius: 5px;
        }

        .mensagem strong {
            display: block;
            font-size: 13px;
            color: #355f40;
            margin-bottom: 2px;
        }

        .mensagem img {
            max-width: 180px;
            border-radius: 10px;
            margin-top: 5px;
        }

        .input-area {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background-color: #f4fff3;
            border-top: 1px solid #d7e8d7;
            border-radius: 0 0 20px 20px;
        }

        .input-area textarea {
            flex: 1;
            border-radius: 15px;
            border: 1px solid #ccc;
            padding: 10px;
            resize: none;
            height: 45px;
            font-family: inherit;
        }

        .input-area input[type="file"] {
            display: none;
        }

        .file-label {
            background-color: #4a7058;
            color: white;
            border-radius: 10px;
            padding: 8px 12px;
            cursor: pointer;
            transition: 0.3s;
            font-size: 14px;
        }

        .file-label:hover {
            background-color: #6ba57a;
        }

        .input-area button {
            background-color: #4a7058;
            color: white;
            border: none;
            border-radius: 15px;
            padding: 10px 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        .input-area button:hover {
            background-color: #6ba57a;
        }

        /* Scroll bonitinho */
        .mensagens::-webkit-scrollbar {
            width: 8px;
        }
        .mensagens::-webkit-scrollbar-thumb {
            background-color: #a3d2a0;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Cabeçalho do grupo -->
        <div class="header-grupo">
            <img src="https://i.pinimg.com/1200x/e4/6d/1a/e46d1add185e813f4cc36b417128647f.jpg" alt="Ícone do grupo">
            <div class="titulo-grupo"> Grupo de Estudos</div>
        </div>

        <div class="descricao">
            Bem-vindo, <strong><?php echo htmlspecialchars($usuario); ?></strong>!  
            Participe das conversas e compartilhe arquivos 📚
        </div>

        <!-- Área de mensagens -->
        <div class="mensagens" id="chat">
            <div class="mensagem recebida">
                <strong>Ana</strong>
                Alguém pode me ajudar com o TCC de banco de dados? 😭
            </div>
            <div class="mensagem recebida">
                <strong>Lucas</strong>
                Eu também estou nessa parte! Vamos fazer juntos?
            </div>
            <div class="mensagem enviada">
                <strong>Marques</strong>
                Claro! Qual parte vocês estão revisando?
            </div>
        </div>

        <!-- Área de envio -->
        <form class="input-area" method="POST" action="enviar_mensagem.php" enctype="multipart/form-data">
            <label for="arquivo" class="file-label">📎 Arquivo</label>
            <input type="file" name="arquivo" id="arquivo">
            <textarea name="mensagem" placeholder="Digite sua mensagem..."></textarea>
            <button type="submit">Enviar</button>
        </form>
    </div>

    <script>
        // Scroll automático pro final do chat
        const chat = document.getElementById('chat');
        chat.scrollTop = chat.scrollHeight;
    </script>
</body>
</html>
