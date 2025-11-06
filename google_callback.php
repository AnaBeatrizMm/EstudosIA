<?php
require_once 'vendor/autoload.php';
require_once 'conexao.php';
session_start();

$client = new Google_Client();
$client->setClientId('912161681251-kin562keuc3vj5l4klc2nlhi9q7irq47.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost:8000/google_callback.php');

$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
$client->setAccessToken($token);

$oauth = new Google_Service_Oauth2($client);
$google_user = $oauth->userinfo->get();

$email = $google_user->email;
$nome  = $google_user->name;

// verifica se já existe usuário no banco
$stmt = $conn->prepare("SELECT id, nome FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // cadastra novo usuário (senha nula, pois é login social)
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, '')");
    $stmt->bind_param("ss", $nome, $email);
    $stmt->execute();
    $user_id = $stmt->insert_id;
} else {
    $user = $result->fetch_assoc();
    $user_id = $user['id'];
    $nome    = $user['nome'];
}

$_SESSION['usuario_id'] = $user_id;
$_SESSION['usuario_nome'] = $nome;

header('Location: inicio.php');
exit;
?>
