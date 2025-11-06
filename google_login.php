<?php
require_once 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('912161681251-kin562keuc3vj5l4klc2nlhi9q7irq47.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost:8000/google_callback.php');
$client->addScope('email');
$client->addScope('profile');

header('Location: ' . $client->createAuthUrl());
exit;
?>