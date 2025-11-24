<?php
// ====================== CONEXÃO COM O BANCO ======================
try {
    $pdo = new PDO("mysql:host=localhost;dbname=jogo_rankeado", "root", ""); // ajuste usuário e senha
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// ====================== FUNÇÃO PARA CONVERTER TEMPO ======================
function hmsParaSegundos($hms) {
    list($h, $m, $s) = explode(':', $hms);
    return $h*3600 + $m*60 + $s;
}

// ====================== FUNÇÃO PARA ATUALIZAR RANKING ======================
function atualizarRanking($pdo, $nome, $distancia, $inimigos, $tempo) {
    $tempo_seg = hmsParaSegundos($tempo);

    // Verifica total de jogadores
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM ranking");
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    if ($total < 10) {
        // Insere direto
        $stmt = $pdo->prepare("INSERT INTO ranking (nome_usuario, distancia, inimigos_derrotados, tempo_jogado) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $distancia, $inimigos, $tempo]);
    } else {
        // Pega o jogador com o menor tempo
        $stmt = $pdo->query("SELECT id, TIME_TO_SEC(tempo_jogado) as tempo_seg FROM ranking ORDER BY TIME_TO_SEC(tempo_jogado) ASC LIMIT 1");
        $menor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tempo_seg > $menor['tempo_seg']) {
            // Substitui o jogador com menor tempo
            $pdo->prepare("DELETE FROM ranking WHERE id = ?")->execute([$menor['id']]);
            $stmt = $pdo->prepare("INSERT INTO ranking (nome_usuario, distancia, inimigos_derrotados, tempo_jogado) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nome, $distancia, $inimigos, $tempo]);
        }
    }
}

// ====================== EXEMPLO: ADICIONAR JOGADOR ======================
atualizarRanking($pdo, "Jogador1", 500, 20, "00:15:30");
atualizarRanking($pdo, "Jogador2", 600, 25, "00:12:10");
atualizarRanking($pdo, "Jogador3", 450, 18, "00:20:05");

// ====================== PEGAR TOP 10 ======================
$stmt = $pdo->query("
    SELECT nome_usuario, distancia, inimigos_derrotados, TIME_FORMAT(tempo_jogado, '%H:%i:%s') AS tempo_jogado
    FROM ranking
    ORDER BY TIME_TO_SEC(tempo_jogado) DESC
    LIMIT 10
");

$top10 = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ====================== EXIBIR TABELA ======================
echo "<div class='ranking'>";
echo "<h2>🏆 Ranking dos Heróis</h2>";
echo "<table border='1' cellpadding='6' cellspacing='0'>";
echo "<tr><th>Posição</th><th>Nome</th><th>Distância</th><th>Inimigos</th><th>Tempo</th></tr>";
$pos = 1;
foreach ($top10 as $jogador) {
    echo "<tr>";
    echo "<td>{$pos}</td>";
    echo "<td>{$jogador['nome_usuario']}</td>";
    echo "<td>{$jogador['distancia']}</td>";
    echo "<td>{$jogador['inimigos_derrotados']}</td>";
    echo "<td>{$jogador['tempo_jogado']}</td>";
    echo "</tr>";
    $pos++;
}
echo "</table>";
echo "</div>";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Batalha do Cavaleiro - Jogo de Aventura</title>
  <link rel="icon" type="image/png" href="/anotacoes/imagens/icon site.png" sizes="612x612">
  <link rel="stylesheet" href="">

  <style>
    /* ===== NOVO ESTILO PARA CABEÇALHO E CRONÔMETRO ===== */
@font-face {
  font-family: 'SimpleHandmade';
  src: url(/fonts/SimpleHandmade.ttf);
}
* { box-sizing: border-box; }
body {
  font-family: 'Roboto', sans-serif;
  background: white;
  color: #333;
}

/* Painel superior fora do quadrado do jogo */
.game-header {
  background: #ffffffcc;
  border: none;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  padding: 15px 25px;
  border-bottom: 2px solid #bdebe3;
}

.info-panel h1 {
  font-family: 'SimpleHandmade', cursive;
  color: #3f7c72;
  font-size: 32px;
  margin-bottom: 10px;
  text-shadow: none;
}

.stats {
  display: flex;
  gap: 25px;
}

.stat-item .label {
  color: #666;
  font-size: 13px;
  text-transform: uppercase;
  font-weight: 500;
}

.stat-item .value {
  color: #2a5c55;
  font-size: 20px;
  font-weight: bold;
}

/* Cronômetro */
.timer-panel {
  background: #fff;
  border-radius: 15px;
  padding: 10px 20px;
  box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}

.timer-display {
  background: #bdebe3;
  border: none;
  border-radius: 10px;
  padding: 10px 25px;
}

#timer {
  font-family: 'Jojoba', sans-serif;
  font-size: 42px;
  color: #2a5c55;
  text-shadow: none;
}

/* Botões */
.btn {
  border-radius: 999px;
  padding: 10px 20px;
  font-family: 'SimpleHandmade', cursive;
  font-size: 14px;
  font-weight: bold;
  transition: 0.3s;
}

.btn-start {
  background: #3f7c72;
  color: white;
}
.btn-start:hover {
  background: #2a5c55;
}

.btn-pause {
  background: #bdebe3;
  color: #2a5c55;
}
.btn-pause:hover {
  background: #a3dcd1;
}

.btn-reset {
  background: #f5f5f5;
  color: #555;
}
.btn-reset:hover {
  background: #ddd;
}

/* Instruções */
.instructions {
  background: #f9f9f9;
  color: #333;
  border-top: 2px solid #bdebe3;
  font-family: 'SimpleHandmade', cursive;
  font-size: 16px;
}

.instructions kbd {
  background: #3f7c72;
  color: #fff;
  border: none;
  font-family: monospace;
}

    /* ===== FONTES PERSONALIZADAS ===== */
@font-face {
  font-family: 'SimpleHandmade';
  src: url(/fonts/SimpleHandmade.ttf);
}

/* ===== REGRAS GERAIS ===== */
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: white;
  color: #333;
  overflow: hidden;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

/* ===== CONTAINER PRINCIPAL ===== */
.game-container {
  width: 95%;
  max-width: 1400px;
  height: 95vh;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 20px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

/* ===== CABEÇALHO (NOVO ESTILO) ===== */
.game-header {
  background: #ffffffcc;
  border: none;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  padding: 15px 25px;
  border-bottom: 2px solid #bdebe3;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.info-panel h1 {
  font-family: 'SimpleHandmade', cursive;
  color: #3f7c72;
  font-size: 32px;
  margin-bottom: 10px;
  text-shadow: none;
}

.stats {
  display: flex;
  gap: 25px;
}

.stat-item {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.stat-item .label {
  color: #666;
  font-size: 13px;
  text-transform: uppercase;
  font-weight: 500;
}

.stat-item .value {
  color: #2a5c55;
  font-size: 20px;
  font-weight: bold;
}

/* ===== CRONÔMETRO (NOVO ESTILO) ===== */
.timer-panel {
  background: #fff;
  border-radius: 15px;
  padding: 10px 20px;
  box-shadow: 0 3px 8px rgba(0,0,0,0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 15px;
}

.timer-display {
  background: #bdebe3;
  border: none;
  border-radius: 10px;
  padding: 10px 25px;
}

#timer {
  font-family: 'Jojoba', sans-serif;
  font-size: 42px;
  color: #2a5c55;
  text-shadow: none;
}

/* ===== BOTÕES (NOVO ESTILO) ===== */
.timer-controls {
  display: flex;
  gap: 10px;
}

.btn {
  padding: 10px 20px;
  border-radius: 999px;
  font-family: 'SimpleHandmade', cursive;
  font-size: 14px;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.3s ease;
  border: none;
  text-transform: uppercase;
}

.btn-start {
  background: #3f7c72;
  color: #fff;
}
.btn-start:hover { background: #2a5c55; }

.btn-pause {
  background: #bdebe3;
  color: #2a5c55;
}
.btn-pause:hover { background: #a3dcd1; }

.btn-reset {
  background: #f5f5f5;
  color: #555;
}
.btn-reset:hover { background: #ddd; }

.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* ===== ÁREA DO JOGO ===== */
.game-world {
  flex: 1;
  position: relative;
  overflow: hidden;
  transition: background 2s ease;
}

.day-sunny { background: linear-gradient(to bottom, #87CEEB 0%, #FFE4B5 100%); }
.day-cloudy { background: linear-gradient(to bottom, #B0C4DE 0%, #D3D3D3 100%); }
.afternoon { background: linear-gradient(to bottom, #FF8C00 0%, #FFA07A 100%); }
.evening { background: linear-gradient(to bottom, #FF6347 0%, #FF4500 100%); }
.night { background: linear-gradient(to bottom, #191970 0%, #000080 100%); }
.storm { background: linear-gradient(to bottom, #2F4F4F 0%, #696969 100%); }

.bg-layer {
  position: absolute;
  width: 100%;
  height: 100%;
  transition: all 2s ease;
}

.sky { z-index: 1; }
.mountains {
  bottom: 0;
  height: 40%;
  background: linear-gradient(to bottom, transparent 0%, rgba(139,69,19,0.3) 100%);
  z-index: 2;
}
.ground {
  bottom: 0;
  height: 150px;
  background: linear-gradient(to bottom, #8B4513 0%, #654321 100%);
  border-top: 4px solid #A0522D;
  z-index: 3;
}

/* ===== CAVALEIRO ===== */
.knight {
  position: absolute;
  bottom: 150px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 10;
  transition: left 0.1s linear;
}

.knight-body {
  width: 80px;
  height: 120px;
  position: relative;
  animation: knight-idle 2s ease-in-out infinite;
}
@keyframes knight-idle {
  0%,100% { transform: translateY(0); }
  50% { transform: translateY(-5px); }
}
.helmet {
  width: 45px;
  height: 50px;
  background: linear-gradient(135deg, #808080 0%, #505050 100%);
  border-radius: 50% 50% 0 0;
  position: absolute;
  top: 0;
  left: 50%;
  transform: translateX(-50%);
  border: 2px solid #696969;
}
.helmet::after {
  content: '';
  position: absolute;
  width: 20px;
  height: 8px;
  background: #FFD700;
  top: 15px;
  left: 50%;
  transform: translateX(-50%);
  border-radius: 2px;
}
.armor {
  width: 60px;
  height: 50px;
  background: linear-gradient(135deg, #C0C0C0 0%, #808080 100%);
  position: absolute;
  top: 45px;
  left: 50%;
  transform: translateX(-50%);
  border-radius: 5px;
  border: 2px solid #A9A9A9;
}
.armor::before {
  content: '⚔️';
  position: absolute;
  font-size: 20px;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.sword {
  width: 8px;
  height: 60px;
  background: linear-gradient(to bottom, #FFD700 0%, #FFA500 20%, #C0C0C0 20%, #808080 100%);
  position: absolute;
  top: 20px;
  right: -25px;
  transform: rotate(45deg);
  border-radius: 2px;
  transition: all 0.2s;
}
.knight.attacking .sword { animation: sword-attack 0.4s ease; }
@keyframes sword-attack {
  0% { transform: rotate(45deg); }
  50% { transform: rotate(-90deg) scale(1.2); }
  100% { transform: rotate(45deg); }
}
.shield {
  width: 35px;
  height: 45px;
  background: linear-gradient(135deg, #4169E1 0%, #1E90FF 100%);
  position: absolute;
  top: 40px;
  left: -25px;
  border-radius: 50% 50% 10px 10px;
  border: 3px solid #FFD700;
}
.shield::after {
  content: '⚡';
  position: absolute;
  font-size: 18px;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.legs {
  width: 50px;
  height: 30px;
  background: linear-gradient(135deg, #696969 0%, #505050 100%);
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  border-radius: 5px;
}

/* ==========================================================
   🩸 ESTILO DO BOSS — APARECE A CADA 10 MINUTOS
   ========================================================== */

/* Visual principal do Boss */
.enemy.boss {
  transform: scale(1.6);
  filter: hue-rotate(-10deg) saturate(1.8);
  z-index: 15;
}

/* Cabeça, tronco e pernas em tons de vermelho */
.enemy.boss .enemy-head {
  background: #b22222;          /* vermelho escuro */
  border: 3px solid #8b0000;    /* contorno mais forte */
}

.enemy.boss .enemy-torso {
  background: #8b0000;          /* corpo vinho */
  border: 2px solid #a52a2a;
}

.enemy.boss .enemy-legs {
  background: #a52a2a;
  border: 1px solid #800000;
}

.enemy.boss {
    transform: scale(1.5);
    filter: brightness(1.2);
    background: none !important;
}

.enemy.boss .enemy-head,
.enemy.boss .enemy-torso,
.enemy.boss .enemy-legs {
    background: #8B0000 !important; /* vermelho escuro original */
}


/* Insígnia "BOSS" acima da cabeça */
.boss-badge {
  position: absolute;
  top: -18px;
  left: 50%;
  transform: translateX(-50%);
  background: #b22222;
  color: #fff;
  padding: 3px 8px;
  border-radius: 8px;
  font-size: 12px;
  font-weight: bold;
  letter-spacing: 1px;
  text-shadow: 0 0 3px rgba(0, 0, 0, 0.5);
  box-shadow: 0 2px 6px rgba(0,0,0,0.3);
  animation: bossBadgePulse 1.5s infinite ease-in-out;
}

/* Pequeno pulso de energia no badge */
@keyframes bossBadgePulse {
  0% { transform: translateX(-50%) scale(1); opacity: 1; }
  50% { transform: translateX(-50%) scale(1.1); opacity: 0.8; }
  100% { transform: translateX(-50%) scale(1); opacity: 1; }
}

/* Alerta no topo quando o Boss surge */
.boss-alert {
  position: fixed;
  top: 20px;
  left: 50%;
  transform: translateX(-50%);
  background: #b22222;
  color: white;
  font-family: 'SimpleHandmade', cursive;
  font-size: 22px;
  padding: 12px 25px;
  border-radius: 12px;
  z-index: 2000;
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
  animation: bossAppear 0.4s ease-out, bossBlink 1.2s infinite alternate;
}

/* Efeitos de aparição e piscar */
@keyframes bossAppear {
  from {
    transform: translate(-50%, -30px);
    opacity: 0;
  }
  to {
    transform: translate(-50%, 0);
    opacity: 1;
  }
}

@keyframes bossBlink {
  0% { background: #b22222; }
  100% { background: #ff0000; }
}

/* Efeito de vibração da tela ao derrotar o Boss */
.screen-shake {
  animation: shake 0.3s ease-in-out;
}

@keyframes shake {
  0% { transform: translate(0); }
  20% { transform: translate(-5px, 5px); }
  40% { transform: translate(5px, -5px); }
  60% { transform: translate(-5px, -5px); }
  80% { transform: translate(5px, 5px); }
  100% { transform: translate(0); }
}


/* ===== INIMIGOS ===== */
.enemy {
  position: absolute;
  bottom: 150px;
  width: 60px;
  height: 80px;
  z-index: 9;
  transition: left 0.05s linear;
}
.enemy-body {
  width: 100%;
  height: 100%;
  position: relative;
  animation: enemy-walk 1s ease-in-out infinite;
}
@keyframes enemy-walk {
  0%,100% { transform: translateY(0) rotate(-5deg); }
  50% { transform: translateY(-8px) rotate(5deg); }
}
.enemy-head {
  width: 40px;
  height: 40px;
  background: #228B22;
  border-radius: 50%;
  position: absolute;
  top: 0;
  left: 50%;
  transform: translateX(-50%);
  border: 2px solid #006400;
}
.enemy-head::before {
  content: '👹';
  position: absolute;
  font-size: 24px;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.enemy-torso {
  width: 45px;
  height: 35px;
  background: #8B4513;
  position: absolute;
  top: 35px;
  left: 50%;
  transform: translateX(-50%);
  border-radius: 5px;
}
.enemy-legs {
  width: 40px;
  height: 20px;
  background: #654321;
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  border-radius: 3px;
}
.enemy.defeated { animation: enemy-defeat 0.5s ease forwards; }
@keyframes enemy-defeat {
  0% { transform: rotate(0) scale(1); opacity: 1; }
  100% { transform: rotate(360deg) scale(0); opacity: 0; }
}

/* ===== PARTÍCULAS E CHUVA ===== */
.particle {
  position: absolute;
  width: 8px;
  height: 8px;
  background: #FFD700;
  border-radius: 50%;
  pointer-events: none;
  animation: particle-float 1s ease-out forwards;
  z-index: 20;
}
@keyframes particle-float {
  0% { transform: translate(0,0) scale(1); opacity: 1; }
  100% { transform: translate(var(--tx), var(--ty)) scale(0); opacity: 0; }
}
.rain {
  position: absolute;
  width: 2px;
  height: 20px;
  background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.6));
  animation: rain-fall 0.5s linear infinite;
}
@keyframes rain-fall {
  0% { transform: translateY(-20px); opacity: 0; }
  10% { opacity: 1; }
  100% { transform: translateY(100vh); opacity: 0.5; }
}

/* ====== TABELA DO RANKING ====== */
.ranking {
  background: #f9f9f9;
  padding: 30px 20px;
  border-top: 3px solid #bdebe3;
  text-align: center;
  font-family: 'SimpleHandmade', cursive;
}

.ranking h2 {
  color: #3f7c72;
  font-size: 2rem;
  margin-bottom: 20px;
}

.ranking table {
  width: 100%;
  border-collapse: collapse;
  background: white;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.ranking th, .ranking td {
  padding: 12px 15px;
  border-bottom: 1px solid #e0e0e0;
  font-size: 16px;
}

.ranking th {
  background: #3f7c72;
  color: white;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-size: 14px;
}

.ranking tr:hover {
  background: #f0f8f6;
}

.ranking td {
  color: #333;
}

.ranking td:first-child {
  font-weight: bold;
  color: #2a5c55;
}

/* ================================
   🧩 Modal de Pergunta (Quiz)
   ================================ */
   #quiz-container {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 2000;
}

.quiz-box {
  background: #fff;
  color: #333;
  padding: 2rem;
  border-radius: 20px;
  width: 90%;
  max-width: 500px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.3);
  text-align: center;
  animation: aparecer 0.3s ease;
}

.quiz-box h2 {
  font-family: 'SimpleHandmade', cursive;
  color: #3f7c72;
  margin-bottom: 1.5rem;
  font-size: 1.6rem;
}

#quiz-options {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.quiz-option {
  padding: 0.8rem 1.5rem;
  background: #bdebe3;
  color: #2a5c55;
  border: none;
  border-radius: 12px;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
}

.quiz-option:hover {
  background: #3f7c72;
  color: white;
}

@keyframes aparecer {
  from { opacity: 0; transform: scale(0.8); }
  to { opacity: 1; transform: scale(1); }
}


/* ================================
   🌿 NAVBAR — estilo idêntico ao exemplo fornecido
   ================================ */

/* Fontes personalizadas (caso use no projeto principal) */
@font-face {
  font-family: 'SimpleHandmade';
  src: url(/fonts/SimpleHandmade.ttf);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Roboto', sans-serif;
  background: white;
  color: #333;
  line-height: 1.6;
  padding-top: 80px; /* espaço para a navbar fixa */
}

/* Header */
header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 70px;
  background: #ffffffcc; /* translúcido */
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 2rem;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  z-index: 1000;
}

header .logo img {
  height: 450px;
  width: auto;
  display: block;
  margin-left: -85px; /* igual ao exemplo */
}

/* Navegação */
nav {
  display: flex;
  align-items: center;
  gap: 20px;
}

nav ul {
  list-style: none;
  display: flex;
  align-items: center;
  gap: 20px;
  margin: 0;
}

nav ul li a {
  text-decoration: none;
  color: #333;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 5px 10px;
  border-radius: 8px;
  transition: .3s;
}

nav ul li a:hover {
  background: #f0f0f0;
}

/* ================================
   🌿 Barra de rolagem personalizada
   ================================ */
::-webkit-scrollbar {
  width: 12px;
  height: 12px;
}

::-webkit-scrollbar-track {
  background: #f0f0f0;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: #3f7c72;
  border-radius: 10px;
  border: 3px solid #f0f0f0;
}

::-webkit-scrollbar-thumb:hover {
  background: #2a5c55;
}

/* ====== ALERTA PERSONALIZADO ====== */
.alert-box {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.55);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 99999;
}

.alert-content {
  background: #ffffff;
  padding: 25px;
  border-radius: 15px;
  max-width: 380px;
  width: 85%;
  text-align: center;
  font-family: 'SimpleHandmade';
  color: #2a5c55;
  border: 2px solid #bdebe3;
}

.alert-btn {
  margin-top: 20px;
  background: #3f7c72;
  color: white;
  border: none;
  padding: 10px 25px;
  border-radius: 999px;
  font-family: 'SimpleHandmade';
  font-size: 18px;
  cursor: pointer;
  transition: 0.3s;
}

.alert-btn:hover {
  background: #2a5c55;
}


/* ============================
   🎯 ESTILO DOS FILTROS
   (Integrado ao estilo do site)
=============================== */

.info-item,
.info-item2 {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 0px;

    background: #ffffffcc;
    padding: 8px 14px;
    border-radius: 12px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.08);

    font-family: 'SimpleHandmade', cursive;
    color: #2a5c55;
}

/* rótulo */
.info-item label,
.info-item2 label {
    font-size: 15px;
    font-weight: bold;
    color: #3f7c72;
}

/* select padrão */
.info-item select,
.info-item2 select {
    padding: 6px 10px;
    border-radius: 10px;
    border: 2px solid #bdebe3;
    background: #fff;
    color: #2a5c55;
    font-size: 14px;
    cursor: pointer;
    transition: 0.3s;
}

/* hover no select */
.info-item select:hover,
.info-item2 select:hover {

    background: #bdebe330;
}

/* Lado a lado + alinhamento */
.info-item2 {
  margin-left: 210px;  /* distância lateral que você queria */
  margin-top: -50px;       /* zera o deslocamento vertical */
}


/* ===== RESPONSIVIDADE ===== */
@media (max-width: 768px) {
  .game-header {
    flex-direction: column;
    gap: 20px;
  }
  .stats {
    flex-direction: column;
    gap: 10px;
  }
  .info-panel h1 {
    font-size: 24px;
  }
  #timer {
    font-size: 32px;
  }
  .knight-body {
    transform: scale(0.8);
  }
}

  </style>
</head>

<body>
<header>
  <div class="logo">
    <img src="/imagens/logoatual.png" alt="Logo">
  </div>
  <nav>
    <ul>
      <li><a href="/Cronometro_Raking/cronometro.php">Voltar</a></li>
    </ul>
  </nav>
</header>

  <div class="game-container">
    <div class="game-header">
      <div class="info-panel">
        <h1>⚔️ BATALHA DO CAVALEIRO ⚔️</h1>
        <div class="stats">
          <div class="stat-item"><span class="label">Distância:</span><span id="distance" class="value">0m</span></div>
          <div class="stat-item"><span class="label">Inimigos Derrotados:</span><span id="enemies-killed" class="value">0</span></div>
          <div class="stat-item"><span class="label">Clima:</span><span id="weather" class="value">Ensolarado</span></div>
        </div>
      </div>
      <div class="timer-panel">
        <div class="timer-display"><span id="timer">00:00</span></div>
        <div class="timer-controls">
          <button id="startBtn" class="btn btn-start">▶ Iniciar</button>
          <button id="pauseBtn" class="btn btn-pause" disabled>⏸ Pausar</button>
          <button id="resetBtn" class="btn btn-reset">↻ Resetar</button>
        </div>
      </div>
    </div>

    <div id="game-world" class="game-world day-sunny">
      <div class="bg-layer sky"></div>
      <div class="bg-layer mountains"></div>
      <div class="bg-layer ground"></div>
      <div id="knight" class="knight">
        <div class="knight-body">
          <div class="helmet"></div><div class="armor"></div><div class="sword"></div>
          <div class="shield"></div><div class="legs"></div>
        </div>
      </div>
      <div id="enemies-container"></div>
      <div id="particles-container"></div>
    </div>

      <!-- =====================================================
     🎯 FILTRO DE DIFICULDADE
====================================================== -->
<div class="info-item">
    <label>Dificuldade:</label>
    <select id="dificuldadeSelect">
        <option value="">-- selecione  --</option>
        <option value="facil">Fácil</option>
        <option value="media">Média</option>
        <option value="dificil">Difícil</option>
    </select>
</div>

      <div class="info-item2">
    <label>Matéria:</label>
    <select id="materiaSelect" onchange="atualizarPerguntasPorMateria()">
        <option value="">-- selecione --</option>
        <option value="matematica">Matemática</option>
        <option value="portugues">Português</option>
        <option value="ingles">Inglês</option>
        <option value="historia">História</option>
        <option value="geografia">Geografia</option>
        <option value="ciencias">Ciências</option>
        <option value="fisica">Física</option>
        <option value="quimica">Química</option>
        <option value="biologia">Biologia</option>
        <option value="filosofia">Filosofia</option>
        <option value="sociologia">Sociologia</option>
        <option value="edfisica">Educação Física</option>
        <option value="artes">Artes</option>
    </select>
</div>


<!-- =====================================================
     🧩 QUIZ POPUP (PERGUNTAS)
====================================================== -->
<div id="quiz-container" style="
    display:none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.7);
    justify-content: center;
    align-items: center;
    z-index: 9999;
">
    <div style="
        background: #fff;
        padding: 25px;
        width: 360px;
        border-radius: 12px;
        text-align: center;
        font-family: Arial;
        box-shadow: 0 0 20px rgba(0,0,0,0.3);
    ">

        <h2 id="quiz-question" style="
            margin-bottom: 20px;
            font-size: 20px;
        ">
            Pergunta aparece aqui
        </h2>

        <div id="quiz-options" style="
            display:flex;
            flex-direction: column;
            gap: 12px;
        "></div>

    </div>
</div>

    <div class="ranking">
  <h2>🏆 Ranking dos Heróis</h2>
  <table id="rankingTable">
    <thead>
      <tr>
        <th>Posição</th>
        <th>Nome do Jogador</th>
        <th>Distância</th>
        <th>Inimigos Derrotados</th>
        <th>Tempo Jogado</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $pos = 1;
      foreach ($rankings as $player) {
          echo "<tr>";
          echo "<td>{$pos}</td>";
          echo "<td>{$player['nome']}</td>";
          echo "<td>{$player['distancia']}</td>";
          echo "<td>{$player['inimigos_derrotados']}</td>";
          echo "<td>{$player['tempo']}</td>";
          echo "</tr>";
          $pos++;
      }
      ?>
    </tbody>
  </table>
</div>

<div id="gameAlert" class="alert-box">
  <div class="alert-content">
    <p id="alertMessage"></p>
    <button id="alertOk" class="alert-btn">OK</button>
  </div>
</div>


<script>
/* ==========================================================
   ⚔️ CRONÔMETRO GAMIFICADO — SCRIPT COMPLETO (COM MATEMÁTICA)
   - Inclui: jogo, inimigos, boss, ataque automático
   - Filtro: matéria (13) + dificuldade (fácil/média/difícil)
   - Quiz: aparece ao derrotar o boss; usa perguntas da matéria+dificuldade escolhidas
   ========================================================== */

/* =============== VARIÁVEIS GLOBAIS =============== */
let timer = 0;
let isRunning = false;
let distance = 0;
let enemiesKilled = 0;
let currentWeather = 'Ensolarado';

let timerInterval = null;
let enemySpawnInterval = null;
let gameLoopInterval = null;

let enemies = [];

const timerDisplay = document.getElementById('timer');
const startBtn = document.getElementById('startBtn');
const pauseBtn = document.getElementById('pauseBtn');
const resetBtn = document.getElementById('resetBtn');
const distanceDisplay = document.getElementById('distance');
const enemiesKilledDisplay = document.getElementById('enemies-killed');
const weatherDisplay = document.getElementById('weather');
const knight = document.getElementById('knight');
const gameWorld = document.getElementById('game-world');
const enemiesContainer = document.getElementById('enemies-container');
const particlesContainer = document.getElementById('particles-container');

/* Controle de ataque automático */
let lastAutoAttackTime = 0;
const AUTO_ATTACK_COOLDOWN = 700;

/* Configurações gerais */
const ENEMY_SPAWN_MS = 4000;
const GAME_LOOP_MS = 50;
const BOSS_INTERVAL_SECONDS = 5; // boss a cada 10 minutos (600s)
const BOSS_ON_START = false;       // true = boss aparece logo ao iniciar

/* ==========================================================
   2. CONTROLE DO TEMPO
   ========================================================== */
function formatTime(seconds) {
  const m = Math.floor(seconds / 60);
  const s = seconds % 60;
  return `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
}

function updateTimer() {
  timer++;
  timerDisplay.textContent = formatTime(timer);
  distance += 5;
  distanceDisplay.textContent = `${distance}m`;
  updateWeatherAndScenery();
}

function startTimer() {
  // Bloqueia se matéria/dificuldade não escolhidas
  if (!materiaSelecionada) {
    showAlert("📘 Escolha uma MATÉRIA antes de iniciar o jogo!");
    return;
  }
  if (!dificuldadeSelecionada) {
    showAlert("🎯 Escolha a DIFICULDADE antes de iniciar o jogo!");
    return;
  }
  if (!perguntasQuiz || perguntasQuiz.length === 0) {
    showAlert("⚠️ Esta combinação não possui perguntas! Adicione perguntas primeiro.");
    return;
  }

  if (isRunning) return;
  isRunning = true;

  timerInterval = setInterval(updateTimer, 1000);
  enemySpawnInterval = setInterval(spawnEnemy, ENEMY_SPAWN_MS);
  gameLoopInterval = setInterval(gameLoop, GAME_LOOP_MS);

  startBtn.disabled = true;
  pauseBtn.disabled = false;

  if (BOSS_ON_START) spawnBossImmediate();
}

function pauseTimer() {
  if (!isRunning) return;
  isRunning = false;
  clearInterval(timerInterval);
  clearInterval(enemySpawnInterval);
  clearInterval(gameLoopInterval);
  startBtn.disabled = false;
  pauseBtn.disabled = true;
}

function resetTimer() {
  pauseTimer();
  timer = 0;
  distance = 0;
  enemiesKilled = 0;

  timerDisplay.textContent = formatTime(timer);
  distanceDisplay.textContent = `${distance}m`;
  enemiesKilledDisplay.textContent = enemiesKilled;

  enemies.forEach(e => { if (e.element && e.element.parentNode) e.element.remove(); });
  enemies = [];

  currentWeather = 'Ensolarado';
  weatherDisplay.textContent = currentWeather;
  gameWorld.className = 'game-world day-sunny';
  particlesContainer.innerHTML = '';

  startBtn.disabled = false;
  pauseBtn.disabled = true;
}

// ===== ALERTA PERSONALIZADO =====
function showAlert(msg) {
  const box = document.getElementById("gameAlert");
  const msgBox = document.getElementById("alertMessage");
  const ok = document.getElementById("alertOk");

  msgBox.textContent = msg;
  box.style.display = "flex";

  ok.onclick = () => {
    box.style.display = "none";
  };
}

/* ==========================================================
   3. CENÁRIO E CLIMA
   ========================================================== */
function updateWeatherAndScenery() {
  const scenes = [
    { time: 0, weather: 'Ensolarado', class: 'day-sunny' },
    { time: 30, weather: 'Nublado', class: 'day-cloudy' },
    { time: 60, weather: 'Entardecer', class: 'afternoon' },
    { time: 90, weather: 'Crepúsculo', class: 'evening' },
    { time: 120, weather: 'Noite', class: 'night' },
    { time: 150, weather: 'Tempestade', class: 'storm' }
  ];

  let cur = scenes[0];
  for (let i = scenes.length - 1; i >= 0; i--) {
    if (timer >= scenes[i].time) { cur = scenes[i]; break; }
  }

  if (currentWeather !== cur.weather) {
    currentWeather = cur.weather;
    weatherDisplay.textContent = currentWeather;
    gameWorld.className = `game-world ${cur.class}`;
    if (cur.weather === 'Tempestade') createRainEffect();
  }
}

function createRainEffect() {
  for (let i = 0; i < 50; i++) {
    setTimeout(() => {
      const rain = document.createElement('div');
      rain.className = 'rain';
      rain.style.left = `${Math.random() * 100}%`;
      rain.style.animationDelay = `${Math.random() * 0.5}s`;
      gameWorld.appendChild(rain);
      setTimeout(() => rain.remove(), 1000);
    }, i * 50);
  }
}

/* ==========================================================
   4. INIMIGOS E BOSS
   ========================================================== */
function spawnEnemy() {
  if (!isRunning) return;

  const isBoss = timer > 0 && timer % BOSS_INTERVAL_SECONDS === 0;
  const startX = window.innerWidth + 50;

  const enemy = {
    x: startX,
    y: 150,
    speed: isBoss ? 2.2 : 2 + Math.random() * 2,
    defeated: false,
    isBoss: isBoss,
    element: createEnemyElement(isBoss)
  };

  enemy.element.style.left = `${enemy.x}px`;
  enemiesContainer.appendChild(enemy.element);
  enemies.push(enemy);

  if (isBoss) showBossAlert();
}

function createEnemyElement(isBoss = false) {
  const d = document.createElement('div');
  d.className = isBoss ? 'enemy boss' : 'enemy';
  d.innerHTML = `
    <div class="enemy-body">
      <div class="enemy-head"></div>
      <div class="enemy-torso"></div>
      <div class="enemy-legs"></div>
    </div>`;
  return d;
}

function showBossAlert() {
  const alert = document.createElement('div');
  alert.className = 'boss-alert';
  alert.textContent = '⚠️ UM BOSS SURGIU! PREPARE-SE!';
  document.body.appendChild(alert);
  setTimeout(() => { alert.remove(); }, 3000);
}

/* ==========================================================
   5. ATAQUE AUTOMÁTICO E COMBATE
   ========================================================== */
function updateEnemies() {
  if (!isRunning) return;

  const kRect = knight.getBoundingClientRect();
  const knightCenterX = kRect.left + kRect.width / 2;
  const now = Date.now();

  let updated = [];
  let enemyNearby = false;

  enemies.forEach(enemy => {
    if (enemy.defeated || !enemy.element) return;

    enemy.x -= enemy.speed;
    enemy.element.style.left = `${enemy.x}px`;

    if (enemy.x < -150) {
      if (enemy.element.parentNode) enemy.element.remove();
      return;
    }

    const eRect = enemy.element.getBoundingClientRect();
    const eCenterX = eRect.left + eRect.width / 2;
    const dx = eCenterX - knightCenterX;
    const dy = (eRect.top + eRect.height/2) - (kRect.top + kRect.height/2);
    const distanceToKnight = Math.sqrt(dx*dx + dy*dy);

    const PROXIMITY = enemy.isBoss ? 200 : 140;
    if (distanceToKnight < PROXIMITY) {
      enemy.element.style.filter = 'brightness(1.3)';
      enemyNearby = true;
    } else {
      enemy.element.style.filter = 'brightness(1)';
    }

    enemy.element.style.transform = enemy.isBoss
      ? `scale(1.5) translateY(${Math.sin(now / 500) * 2}px)`
      : `translateY(${Math.sin(now / 300) * 3}px)`;

    updated.push(enemy);
  });

  enemies = updated;

  // ataque automático
  if (enemyNearby && isRunning) {
    if (now - lastAutoAttackTime >= AUTO_ATTACK_COOLDOWN) {
      const hit = attackNearbyEnemies();
      if (hit) lastAutoAttackTime = now;
    }
  }
}

function attackNearbyEnemies() {
  if (!isRunning) return false;
  let hit = false;

  const kRect = knight.getBoundingClientRect();
  const kCenterX = kRect.left + kRect.width / 2;

  enemies.slice().forEach(enemy => {
    if (enemy.defeated || !enemy.element) return;
    const eRect = enemy.element.getBoundingClientRect();
    const eCenterX = eRect.left + eRect.width / 2;
    const dx = Math.abs(eCenterX - kCenterX);
    const ATTACK_RANGE = enemy.isBoss ? 160 : 120;
    if (dx <= ATTACK_RANGE) {
      defeatEnemy(enemy);
      hit = true;
    }
  });

  if (hit) {
    knight.classList.add('attacking');
    setTimeout(() => knight.classList.remove('attacking'), 400);
  }
  return hit;
}

function defeatEnemy(enemy) {
  if (enemy.defeated) return;
  enemy.defeated = true;
  enemy.element.classList.add('defeated');
  enemiesKilled++;
  enemiesKilledDisplay.textContent = enemiesKilled;

  if (enemy.isBoss) createBossParticles(enemy.element);
  else createDefeatParticles(enemy.element);

  setTimeout(() => {
    if (enemy.element && enemy.element.parentNode) enemy.element.remove();
    enemies = enemies.filter(e => e !== enemy);
  }, 600);
}

/* ==========================================================
   6. PARTÍCULAS E EFEITOS
   ========================================================== */
function createDefeatParticles(element) {
  const r = element.getBoundingClientRect();
  const cx = r.left + r.width / 2;
  const cy = r.top + r.height / 2;

  for (let i = 0; i < 12; i++) {
    const p = document.createElement('div');
    p.className = 'particle';
    const a = (Math.PI * 2 * i) / 12;
    const dist = 50 + Math.random() * 30;
    const tx = Math.cos(a) * dist;
    const ty = Math.sin(a) * dist;
    p.style.left = `${cx}px`;
    p.style.top = `${cy}px`;
    p.style.setProperty('--tx', `${tx}px`);
    p.style.setProperty('--ty', `${ty}px`);
    const colors = ['#FFD700', '#FFA500', '#FF6347', '#FF4500', '#FFFF00'];
    p.style.background = colors[Math.floor(Math.random() * colors.length)];
    particlesContainer.appendChild(p);
    setTimeout(() => p.remove(), 1000);
  }
}

function createBossParticles(element) {
  const r = element.getBoundingClientRect();
  const cx = r.left + r.width / 2;
  const cy = r.top + r.height / 2;

  for (let i = 0; i < 30; i++) {
    const p = document.createElement('div');
    p.className = 'particle';
    const a = (Math.PI * 2 * i) / 30;
    const dist = 80 + Math.random() * 40;
    const tx = Math.cos(a) * dist;
    const ty = Math.sin(a) * dist;
    p.style.left = `${cx}px`;
    p.style.top = `${cy}px`;
    p.style.setProperty('--tx', `${tx}px`);
    p.style.setProperty('--ty', `${ty}px`);
    const colors = ['#E53935', '#FF7043', '#FFEB3B'];
    p.style.background = colors[Math.floor(Math.random() * colors.length)];
    particlesContainer.appendChild(p);
    setTimeout(() => p.remove(), 1200);
  }

  setTimeout(() => {
    mostrarPerguntaQuiz();
  }, 800);
}

/* ==========================================================
   7. LOOP PRINCIPAL E EVENTOS
   ========================================================== */
function gameLoop() {
  updateEnemies();
}

// estrelas de fundo (noite)
function initializeBackground() {
  for (let i = 0; i < 50; i++) {
    const s = document.createElement('div');
    s.className = 'star';
    s.style.position = 'absolute';
    s.style.width = '2px';
    s.style.height = '2px';
    s.style.background = 'white';
    s.style.borderRadius = '50%';
    s.style.left = `${Math.random() * 100}%`;
    s.style.top = `${Math.random() * 70}%`;
    s.style.opacity = '0';
    s.style.transition = 'opacity 2s';
    gameWorld.appendChild(s);
  }
}

initializeBackground();

setInterval(() => {
  document.querySelectorAll('.star').forEach(s => {
    s.style.opacity = currentWeather === 'Noite' ? (Math.random() > 0.5 ? '1' : '0.5') : '0';
  });
}, 200);

startBtn.addEventListener('click', startTimer);
pauseBtn.addEventListener('click', pauseTimer);
resetBtn.addEventListener('click', resetTimer);

document.addEventListener('keydown', e => {
  if (e.code === 'Space') {
    e.preventDefault();
    attackNearbyEnemies();
  }
});

gameWorld.addEventListener('click', () => {
  if (isRunning) attackNearbyEnemies();
});

/* ==========================================================
   8. SISTEMA DE QUIZ + FILTRO MATÉRIA + DIFICULDADE
   - 13 matérias suportadas
   - Apenas MATEMÁTICA preenchida (listas abaixo)
   ========================================================== */

/* variáveis do quiz / filtro */
let perguntasQuiz = [];
let materiaSelecionada = null;
let dificuldadeSelecionada = null;

/* -------------------------
   LISTAS DE PERGUNTAS: MATEMÁTICA (50 fáceis, 50 médias, 50 difíceis)
   (estas são as perguntas que você pediu — sem alteração)
   ------------------------- */

/* ===== Perguntas Fáceis (50) ===== */
const perguntasMatematicaFaceis = [
{ pergunta: "Quanto é 2 + 2?", opcoes: ["3","4","5"], correta: 1 },
{ pergunta: "Quanto é 10 - 4?", opcoes: ["5","6","7"], correta: 1 },
{ pergunta: "Quanto é 3 × 3?", opcoes: ["6","8","9"], correta: 2 },
{ pergunta: "Quanto é 20 ÷ 4?", opcoes: ["5","6","4"], correta: 0 },
{ pergunta: "Quanto é 7 + 8?", opcoes: ["15","14","16"], correta: 0 },
{ pergunta: "Quanto é 12 - 5?", opcoes: ["9","7","6"], correta: 1 },
{ pergunta: "Quanto é 4 × 2?", opcoes: ["6","8","10"], correta: 1 },
{ pergunta: "Quanto é 15 ÷ 3?", opcoes: ["5","4","6"], correta: 0 },
{ pergunta: "Qual é a raiz quadrada de 9?", opcoes: ["2","3","4"], correta: 1 },
{ pergunta: "Quanto é 5 + 5?", opcoes: ["10","15","5"], correta: 0 },
{ pergunta: "Quanto é 9 - 3?", opcoes: ["6","7","5"], correta: 0 },
{ pergunta: "Quanto é 6 × 2?", opcoes: ["10","12","14"], correta: 1 },
{ pergunta: "Quanto é 18 ÷ 2?", opcoes: ["9","8","7"], correta: 0 },
{ pergunta: "Qual número é par?", opcoes: ["7","10","13"], correta: 1 },
{ pergunta: "Qual número é ímpar?", opcoes: ["2","4","7"], correta: 2 },
{ pergunta: "Quanto é 1/2 de 10?", opcoes: ["3","5","7"], correta: 1 },
{ pergunta: "Quanto é 25% de 100?", opcoes: ["10","20","25"], correta: 2 },
{ pergunta: "Qual é o dobro de 8?", opcoes: ["14","16","18"], correta: 1 },
{ pergunta: "Quanto é 30 + 10?", opcoes: ["30","40","50"], correta: 1 },
{ pergunta: "Quanto é 50 - 20?", opcoes: ["20","25","30"], correta: 2 },
{ pergunta: "Quanto é 9 + 6?", opcoes: ["14","15","16"], correta: 1 },
{ pergunta: "Quanto é 14 - 7?", opcoes: ["5","7","6"], correta: 1 },
{ pergunta: "Quanto é 11 + 11?", opcoes: ["20","21","22"], correta: 2 },
{ pergunta: "Quanto é 3×4?", opcoes: ["12","16","9"], correta: 0 },
{ pergunta: "Quanto é 40÷5?", opcoes: ["7","8","9"], correta: 1 },
{ pergunta: "Qual é a raiz quadrada de 16?", opcoes: ["3","4","5"], correta: 1 },
{ pergunta: "Quanto é 2³?", opcoes: ["6","8","4"], correta: 1 },
{ pergunta: "Quanto é 10% de 50?", opcoes: ["2","5","10"], correta: 1 },
{ pergunta: "Qual número é maior?", opcoes: ["13","15","12"], correta: 1 },
{ pergunta: "Quanto é 60 - 15?", opcoes: ["45","40","35"], correta: 0 },
{ pergunta: "Quanto é 24 ÷ 6?", opcoes: ["2","3","4"], correta: 2 },
{ pergunta: "Quanto é 7 × 2?", opcoes: ["14","12","10"], correta: 0 },
{ pergunta: "Quanto é 5 × 5?", opcoes: ["20","25","30"], correta: 1 },
{ pergunta: "Quanto é 8 ÷ 2?", opcoes: ["2","4","6"], correta: 1 },
{ pergunta: "Qual é o triplo de 3?", opcoes: ["6","9","12"], correta: 1 },
{ pergunta: "Qual é o antecessor de 10?", opcoes: ["8","9","11"], correta: 1 },
{ pergunta: "Quanto é 13 + 6?", opcoes: ["17","18","19"], correta: 2 },
{ pergunta: "Quanto é 21 - 9?", opcoes: ["11","12","13"], correta: 1 },
{ pergunta: "Quanto é 4²?", opcoes: ["8","12","16"], correta: 2 },
{ pergunta: "Qual a metade de 16?", opcoes: ["6","8","10"], correta: 1 },
{ pergunta: "Quanto é 3 + 14?", opcoes: ["17","18","19"], correta: 0 },
{ pergunta: "Quanto é 22 - 11?", opcoes: ["10","11","12"], correta: 1 },
{ pergunta: "Quanto é 6³?", opcoes: ["126","216","96"], correta: 1 },
{ pergunta: "Quanto é 4 + 9?", opcoes: ["11","12","13"], correta: 2 },
{ pergunta: "Quanto é 32 ÷ 4?", opcoes: ["6","8","9"], correta: 1 },
{ pergunta: "Quanto é 3 × 7?", opcoes: ["20","21","24"], correta: 1 },
{ pergunta: "Quanto é 100 ÷ 10?", opcoes: ["5","10","20"], correta: 1 },
{ pergunta: "Qual número é menor?", opcoes: ["7","3","9"], correta: 1 },
{ pergunta: "Quanto é 18 + 2?", opcoes: ["18","20","22"], correta: 1 }
];

/* ===== Perguntas Médias (50) ===== */
const perguntasMatematicaMedias = [
{ pergunta: "Quanto é 12 × 12?", opcoes: ["124","144","134"], correta: 1 },
{ pergunta: "A raiz quadrada de 121 é:", opcoes: ["10","11","12"], correta: 1 },
{ pergunta: "Qual é o valor de 3² + 4²?", opcoes: ["25","12","18"], correta: 0 },
{ pergunta: "Quanto é 180 ÷ 6?", opcoes: ["20","25","30"], correta: 2 },
{ pergunta: "Quanto é 15 × 8?", opcoes: ["110","115","120"], correta: 2 },
{ pergunta: "Qual é o MMC de 6 e 8?", opcoes: ["24","12","18"], correta: 0 },
{ pergunta: "Qual é o MDC de 16 e 24?", opcoes: ["6","8","4"], correta: 1 },
{ pergunta: "Quanto é 9²?", opcoes: ["72","81","91"], correta: 1 },
{ pergunta: "A raiz cúbica de 27 é:", opcoes: ["4","3","5"], correta: 1 },
{ pergunta: "Quanto é 50% de 80?", opcoes: ["30","40","50"], correta: 1 },
{ pergunta: "Qual é o valor de 2⁵?", opcoes: ["16","32","64"], correta: 1 },
{ pergunta: "Quanto é 7 × 9?", opcoes: ["63","72","54"], correta: 0 },
{ pergunta: "Qual é a soma dos ângulos internos do triângulo?", opcoes: ["90°","180°","270°"], correta: 1 },
{ pergunta: "Qual é a área de um quadrado de lado 6?", opcoes: ["36","30","42"], correta: 0 },
{ pergunta: "Quanto é 3/4 de 40?", opcoes: ["20","25","30"], correta: 2 },
{ pergunta: "Quanto é 25 × 4?", opcoes: ["50","75","100"], correta: 2 },
{ pergunta: "Qual é a média de 4, 6 e 10?", opcoes: ["6","7","8"], correta: 2 },
{ pergunta: "Quanto é 15²?", opcoes: ["225","250","200"], correta: 0 },
{ pergunta: "Qual é a área de um triângulo base 10 e altura 4?", opcoes: ["20","40","15"], correta: 0 },
{ pergunta: "Quanto é 14 × 3?", opcoes: ["42","44","46"], correta: 0 },
{ pergunta: "Qual a raiz quadrada de 64?", opcoes: ["6","8","10"], correta: 1 },
{ pergunta: "Quanto é 120 ÷ 8?", opcoes: ["14","15","16"], correta: 1 },
{ pergunta: "Quanto é √49?", opcoes: ["6","7","8"], correta: 1 },
{ pergunta: "Se x=3, quanto vale 2x + 4?", opcoes: ["8","10","6"], correta: 1 },
{ pergunta: "Se um ângulo tem 90°, ele é:", opcoes: ["obtuso","reto","agudo"], correta: 1 },
{ pergunta: "Qual é o perímetro de um quadrado de lado 5?", opcoes: ["10","20","25"], correta: 1 },
{ pergunta: "Quanto é 11 × 11?", opcoes: ["110","121","122"], correta: 1 },
{ pergunta: "Quanto é 8³?", opcoes: ["512","256","128"], correta: 0 },
{ pergunta: "Quanto é 72 ÷ 6?", opcoes: ["11","12","13"], correta: 1 },
{ pergunta: "Quanto é 100% de 45?", opcoes: ["45","55","65"], correta: 0 },
{ pergunta: "Qual é o valor de | -15 |?", opcoes: ["-15","15","0"], correta: 1 },
{ pergunta: "Quanto é 3 × (4 + 5)?", opcoes: ["27","30","32"], correta: 0 },
{ pergunta: "Qual é a área de um círculo com raio 3? (π=3,14)", opcoes: ["28,26","30","25"], correta: 0 },
{ pergunta: "Qual é o valor de π arredondado?", opcoes: ["2,14","3,14","4,14"], correta: 1 },
{ pergunta: "Quanto é 16 × 4?", opcoes: ["60","64","68"], correta: 1 },
{ pergunta: "Quanto é 4³?", opcoes: ["64","32","16"], correta: 1 },
{ pergunta: "Quanto é 28 ÷ 7?", opcoes: ["3","4","5"], correta: 1 },
{ pergunta: "Se x=10, quanto vale x²?", opcoes: ["50","100","10"], correta: 1 },
{ pergunta: "Quanto é 13 × 4?", opcoes: ["42","52","62"], correta: 1 },
{ pergunta: "Quanto é 1/5 de 100?", opcoes: ["10","20","25"], correta: 1 },
{ pergunta: "Qual é a raiz de 144?", opcoes: ["10","11","12"], correta: 2 },
{ pergunta: "Quanto é 90 ÷ 9?", opcoes: ["9","10","11"], correta: 0 },
{ pergunta: "Quanto é 2⁶?", opcoes: ["64","32","48"], correta: 0 },
{ pergunta: "Qual é a área de um retângulo 8×6?", opcoes: ["36","42","48"], correta: 2 },
{ pergunta: "Quanto é 45 ÷ 5?", opcoes: ["5","9","7"], correta: 1 },
{ pergunta: "Qual é a raiz de 225?", opcoes: ["12","15","18"], correta: 1 },
{ pergunta: "Quanto é 33 + 17?", opcoes: ["48","50","52"], correta: 1 },
{ pergunta: "Quanto é 14²?", opcoes: ["196","176","206"], correta: 0 }
];

/* ===== Perguntas Difíceis (50) ===== */
const perguntasMatematicaDificeis = [
{ pergunta: "Qual é o valor de √289?", opcoes: ["15","16","17"], correta: 2 },
{ pergunta: "Resolva: 2x + 5 = 17", opcoes: ["4","5","6"], correta: 0 },
{ pergunta: "Quanto é 13³?", opcoes: ["2197","1597","2000"], correta: 0 },
{ pergunta: "Qual é o log₂(32)?", opcoes: ["4","5","6"], correta: 1 },
{ pergunta: "Qual é a derivada de x²?", opcoes: ["x","2x","x²"], correta: 1 },
{ pergunta: "Quanto é 15 × 17?", opcoes: ["240","255","265"], correta: 1 },
{ pergunta: "Quanto é √625?", opcoes: ["20","25","30"], correta: 1 },
{ pergunta: "Qual é o valor de 9!/8?", opcoes: ["5040","4536","362880"], correta: 0 },
{ pergunta: "Quanto é 7⁴?", opcoes: ["1201","2401","3401"], correta: 1 },
{ pergunta: "Qual é a raiz cúbica de 512?", opcoes: ["6","7","8"], correta: 2 },
{ pergunta: "Qual é o MDC entre 84 e 126?", opcoes: ["21","14","7"], correta: 0 },
{ pergunta: "Calcule: 3(2x - 5) = 21", opcoes: ["x=4","x=5","x=6"], correta: 0 },
{ pergunta: "Quanto é 18²?", opcoes: ["324","348","304"], correta: 0 },
{ pergunta: "Qual é a área de um círculo de raio 10? (π=3,14)", opcoes: ["200","314","400"], correta: 1 },
{ pergunta: "Resolva: 5x - 15 = 0", opcoes: ["2","3","4"], correta: 1 },
{ pergunta: "Qual é o valor de log10(1000)?", opcoes: ["1","2","3"], correta: 2 },
{ pergunta: "Qual é o seno de 30°?", opcoes: ["0,5","0,7","0,3"], correta: 0 },
{ pergunta: "Quanto é 8 × 19?", opcoes: ["152","144","168"], correta: 0 },
{ pergunta: "Quanto é 14 × 14?", opcoes: ["176","196","206"], correta: 1 },
{ pergunta: "Qual é a tangente de 45°?", opcoes: ["0","1","√2"], correta: 1 },
{ pergunta: "Se f(x)=3x-2, então f(5)=", opcoes: ["13","15","12"], correta: 0 },
{ pergunta: "Resolva: x² - 9 = 0", opcoes: ["x=3 ou -3","x=9","x=0"], correta: 0 },
{ pergunta: "Qual é o determinante de [[2,3],[1,4]]?", opcoes: ["5","6","7"], correta: 1 },
{ pergunta: "Quanto é 5⁴?", opcoes: ["525","625","725"], correta: 1 },
{ pergunta: "Quanto é 20% de 350?", opcoes: ["60","70","80"], correta: 1 },
{ pergunta: "Qual é a integral de 2x?", opcoes: ["x² + C","2x²","x + C"], correta: 0 },
{ pergunta: "Quanto é 30²?", opcoes: ["900","600","1200"], correta: 0 },
{ pergunta: "Qual é a raiz de 484?", opcoes: ["20","22","24"], correta: 1 },
{ pergunta: "Quanto é 101 × 12?", opcoes: ["1112","1212","1312"], correta: 1 },
{ pergunta: "Resolva: 4x + 8 = 40", opcoes: ["6","7","8"], correta: 2 },
{ pergunta: "Quanto é 11³?", opcoes: ["1131","1211","1331"], correta: 2 },
{ pergunta: "Qual é o valor de e≈?", opcoes: ["2,71","3,14","1,61"], correta: 0 },
{ pergunta: "Quanto é √900?", opcoes: ["30","25","20"], correta: 0 },
{ pergunta: "Quanto é 9 × 17?", opcoes: ["143","153","163"], correta: 1 },
{ pergunta: "Quanto é 19²?", opcoes: ["361","351","371"], correta: 0 },
{ pergunta: "Qual é a probabilidade de sair cara em uma moeda?", opcoes: ["25%","50%","75%"], correta: 1 },
{ pergunta: "Quanto é 45 × 14?", opcoes: ["610","630","650"], correta: 1 },
{ pergunta: "Qual é o valor de π² arredondado?", opcoes: ["6,14","8,86","9,86"], correta: 2 },
{ pergunta: "Qual a hipotenusa de um triângulo 9-12?", opcoes: ["15","17","20"], correta: 0 },
{ pergunta: "Quanto é 3⁵?", opcoes: ["243","125","225"], correta: 0 },
{ pergunta: "Quanto é 27 × 19?", opcoes: ["503","513","523"], correta: 1 },
{ pergunta: "Qual é a raiz de 1024?", opcoes: ["28","30","32"], correta: 2 },
{ pergunta: "Quanto é 2⁸?", opcoes: ["64","128","256"], correta: 2 },
{ pergunta: "Resolva: x/5 = 9", opcoes: ["35","40","45"], correta: 2 },
{ pergunta: "Quanto é 17³?", opcoes: ["3893","4913","5833"], correta: 1 },
{ pergunta: "Quanto é 1/3 de 300?", opcoes: ["50","80","100"], correta: 2 },
{ pergunta: "Quanto é 16 × 19?", opcoes: ["284","304","324"], correta: 1 },
{ pergunta: "Quanto é 5 × 41?", opcoes: ["205","215","225"], correta: 0 }
];

/* ==========================================================
   9. OUTRAS MATÉRIAS (vazias — preencha depois)
   ========================================================== */
const perguntasPortuguesFaceis = [
{ pergunta: "Qual é o antônimo de 'feliz'?", opcoes: ["Alegre", "Contente", "Triste", "Animado"], correta: 2 },
{ pergunta: "Qual palavra está escrita corretamente?", opcoes: ["Excessão", "Exceção", "Execeção", "Exeção"], correta: 1 },
{ pergunta: "Qual é o plural de 'pão'?", opcoes: ["Pãos", "Pães", "Pões", "Paons"], correta: 1 },
{ pergunta: "Qual é o aumentativo de 'casa'?", opcoes: ["Casão", "Caseira", "Casebre", "Casão"], correta: 0 },
{ pergunta: "Qual é o diminutivo de 'flor'?", opcoes: ["Florzinha", "Florinha", "Florzinhaa", "Florzita"], correta: 0 },
{ pergunta: "Qual é o significado de 'sincero'?", opcoes: ["Mentiroso", "Agressivo", "Honesto", "Desatento"], correta: 2 },
{ pergunta: "Qual palavra indica ação?", opcoes: ["Verbo", "Substantivo", "Artigo", "Adjetivo"], correta: 0 },
{ pergunta: "Qual é o feminino de 'ator'?", opcoes: ["Atora", "Atoriza", "Atriz", "Atrisa"], correta: 2 },
{ pergunta: "Qual destes é um substantivo?", opcoes: ["Pulando", "Mesa", "Rapidamente", "Belo"], correta: 1 },
{ pergunta: "O que é um adjetivo?", opcoes: ["Palavra que dá nome", "Palavra que indica ação", "Palavra que caracteriza o substantivo", "Palavra que liga frases"], correta: 2 },
{ pergunta: "Qual palavra é um verbo?", opcoes: ["Correr", "Mesa", "Bonito", "Eles"], correta: 0 },
{ pergunta: "Qual é o plural de 'animal'?", opcoes: ["Animais", "Animales", "Animãos", "Animales"], correta: 0 },
{ pergunta: "O que é um sinônimo?", opcoes: ["Palavra igual", "Palavra parecida", "Palavra contrária", "Palavra com sentido próximo"], correta: 3 },
{ pergunta: "Qual é o sinônimo de 'rápido'?", opcoes: ["Veloz", "Lento", "Fraco", "Calmo"], correta: 0 },
{ pergunta: "Qual das palavras é um adjetivo?", opcoes: ["Mesa", "Azul", "Correr", "Correram"], correta: 1 },
{ pergunta: "Qual palavra completa a frase: 'Eu _____ estudar hoje'?", opcoes: ["vou", "foi", "iremos", "fui"], correta: 0 },
{ pergunta: "Qual é o antônimo de 'forte'?", opcoes: ["Grande", "Intenso", "Fraco", "Bonito"], correta: 2 },
{ pergunta: "Qual destas é uma interjeição?", opcoes: ["Ah!", "Mesa", "Bonita", "Escrever"], correta: 0 },
{ pergunta: "Qual palavra está no passado?", opcoes: ["Canto", "Cantarei", "Cantava", "Cantarei"], correta: 2 },
{ pergunta: "Qual é o coletivo de 'peixes'?", opcoes: ["Manada", "Cardume", "Rebanho", "Tropa"], correta: 1 },
{ pergunta: "Qual é o coletivo de 'abelhas'?", opcoes: ["Cardume", "Colmeia", "Alcateia", "Rebanho"], correta: 1 },
{ pergunta: "Qual é o plural de 'cão'?", opcoes: ["Cães", "Cãos", "Cones", "Cãs"], correta: 0 },
{ pergunta: "Qual palavra indica intensidade?", opcoes: ["Muito", "Mesa", "Correr", "Ele"], correta: 0 },
{ pergunta: "Qual é o sinônimo de 'trabalhar'?", opcoes: ["Labutar", "Comer", "Dormir", "Conhecer"], correta: 0 },
{ pergunta: "Qual é o antônimo de 'alto'?", opcoes: ["Comprido", "Grande", "Baixo", "Largo"], correta: 2 },
{ pergunta: "Qual é o plural de 'pneu'?", opcoes: ["Pneus", "Pneuses", "Pneis", "Pners"], correta: 0 },
{ pergunta: "Qual é o diminutivo de 'menino'?", opcoes: ["Menininho", "Meninote", "Meninão", "Meninoco"], correta: 0 },
{ pergunta: "Quais são vogais?", opcoes: ["B C D", "A E I O U", "J K L", "P Q R"], correta: 1 },
{ pergunta: "Qual destes é um pronome?", opcoes: ["Mesa", "Ele", "Rapidamente", "Azul"], correta: 1 },
{ pergunta: "Qual é o oposto de 'claro'?", opcoes: ["Lindo", "Escuro", "Rápido", "Calmo"], correta: 1 },
{ pergunta: "Qual dessas palavras está no plural?", opcoes: ["Livro", "Carros", "Mesa", "Amor"], correta: 1 },
{ pergunta: "Qual é a forma correta?", opcoes: ["Agente (nós)", "A gente (nós)", "Agente (profissão)", "A-gente"], correta: 1 },
{ pergunta: "Qual palavra rima com 'coração'?", opcoes: ["Limão", "Casa", "Carro", "Mesa"], correta: 0 },
{ pergunta: "Qual é o coletivo de 'lobos'?", opcoes: ["Bando", "Alcateia", "Manada", "Rebanho"], correta: 1 },
{ pergunta: "A forma verbal 'comeram' está em:", opcoes: ["Presente", "Passado", "Futuro", "Condicional"], correta: 1 },
{ pergunta: "Qual destas é uma preposição?", opcoes: ["Para", "Mesa", "Carro", "Belo"], correta: 0 },
{ pergunta: "Qual destas é escrita corretamente?", opcoes: ["Concerto (música)", "Conserto (arrumar)", "As duas estão corretas", "Nenhuma"], correta: 2 },
{ pergunta: "Qual é o superlativo de 'bom'?", opcoes: ["Ótimo", "Melhor", "Bom demais", "Bem"], correta: 0 },
{ pergunta: "A palavra 'felizmente' é um:", opcoes: ["Verbo", "Advérbio", "Substantivo", "Adjetivo"], correta: 1 },
{ pergunta: "Quantas sílabas tem a palavra 'caminho'?", opcoes: ["2", "3", "4", "5"], correta: 1 },
{ pergunta: "Qual é o gênero da palavra 'floresta'?", opcoes: ["Masculino", "Feminino", "Neutro", "Ambíguo"], correta: 1 },
{ pergunta: "Qual é o plural de 'sol'?", opcoes: ["Sóis", "Soles", "Sons", "Solos"], correta: 0 },
{ pergunta: "Qual é o sinônimo de 'coragem'?", opcoes: ["Medo", "Valentia", "Tristeza", "Frieza"], correta: 1 },
{ pergunta: "Qual é o antônimo de 'quente'?", opcoes: ["Frio", "Morno", "Gelado", "Seco"], correta: 0 },
{ pergunta: "Qual destas é uma frase?", opcoes: ["Feliz dia!", "Porta azul.", "Carro.", "Muito rápido."], correta: 0 },
{ pergunta: "Qual é a forma correta?", opcoes: ["Mal (oposto de bem)", "Mau (oposto de bom)", "As duas existem", "Nenhuma"], correta: 2 },
{ pergunta: "Qual é o coletivo de 'árvores'?", opcoes: ["Bosque", "Bando", "Rebanho", "Colmeia"], correta: 0 },
{ pergunta: "Qual das opções é uma conjunção?", opcoes: ["E", "Mesa", "Bonito", "Correr"], correta: 0 },
{ pergunta: "Qual palavra é sinônimo de 'feliz'?", opcoes: ["Alegre", "Sério", "Cansado", "Ocupado"], correta: 0 },
{ pergunta: "Qual é o plural de 'papel'?", opcoes: ["Papeis", "Papéis", "Papeus", "Papeus"], correta: 1 }
];
const perguntasPortuguesMedias = [
{ pergunta: "Qual é a função da vírgula na frase: 'João, venha aqui'?", opcoes: ["Separar vocativo", "Indicar pausa longa", "Marcar enumeração", "Isolar adjunto adverbial"], correta: 0 },
{ pergunta: "Em qual opção há um adjetivo?", opcoes: ["Rapidamente", "Amarelo", "Andando", "Eles"], correta: 1 },
{ pergunta: "O plural de 'cidadão' é:", opcoes: ["Cidadões", "Cidadãos", "Cidades", "Cidões"], correta: 1 },
{ pergunta: "Qual das frases está corretamente acentuada?", opcoes: ["Heroi", "Épico", "Ideia", "Papeis"], correta: 1 },
{ pergunta: "Qual das palavras é um advérbio?", opcoes: ["Feliz", "Rapidamente", "Correr", "Mesa"], correta: 1 },
{ pergunta: "Qual é a figura de linguagem em: 'Ele é um poço de sabedoria'?", opcoes: ["Metáfora", "Comparação", "Ironia", "Metonímia"], correta: 0 },
{ pergunta: "Qual é o sujeito da frase: 'Choveu muito ontem'?", opcoes: ["Ontem", "Muito", "Oculto", "Inexistente"], correta: 3 },
{ pergunta: "Qual é a classe gramatical de 'porém'?", opcoes: ["Substantivo", "Verbo", "Conjunção adversativa", "Preposição"], correta: 2 },
{ pergunta: "Qual é o antônimo de 'superficial'?", opcoes: ["Raso", "Sutil", "Profundo", "Leve"], correta: 2 },
{ pergunta: "Qual alternativa contém duas preposições?", opcoes: ["Para e com", "Mesa e livro", "Rápido e devagar", "Ele e ela"], correta: 0 },
{ pergunta: "Em 'Os alunos estudaram muito', o termo 'muito' é:", opcoes: ["Adjetivo", "Advérbio", "Verbo", "Artigo"], correta: 1 },
{ pergunta: "Qual é o plural de 'país'?", opcoes: ["Paizes", "Paises", "Países", "Paízes"], correta: 2 },
{ pergunta: "Qual é o tempo verbal de 'eu fiz'?", opcoes: ["Futuro", "Presente", "Pretérito perfeito", "Pretérito imperfeito"], correta: 2 },
{ pergunta: "Qual frase está escrita corretamente?", opcoes: ["Houveram muitas pessoas", "Existiram muitas pessoas", "Fazem dois anos", "Havia muitas pessoas que chegaram"], correta: 3 },
{ pergunta: "Qual é o coletivo de 'atores'?", opcoes: ["Elenco", "Tropa", "Rebanho", "Galeria"], correta: 0 },
{ pergunta: "Qual das frases usa crase corretamente?", opcoes: ["Vou à escola", "Cheguei à meia-noite", "Fui à o parque", "Entreguei à ele"], correta: 0 },
{ pergunta: "O que é uma oração coordenada?", opcoes: ["Depende de outra", "Núcleo do sujeito", "Independente sintaticamente", "Complemento do verbo"], correta: 2 },
{ pergunta: "Qual palavra é paroxítona?", opcoes: ["Pé", "Abacaxi", "Árvore", "Fóssil"], correta: 2 },
{ pergunta: "Qual é o sinônimo de 'perseverar'?", opcoes: ["Desistir", "Persistir", "Recuar", "Adiar"], correta: 1 },
{ pergunta: "Em: 'Estamos felizes', 'felizes' funciona como:", opcoes: ["Sujeito", "Predicativo", "Objeto direto", "Adjunto nominal"], correta: 1 },
{ pergunta: "Qual das palavras é um substantivo abstrato?", opcoes: ["Mesa", "Tristeza", "Caderno", "Vento"], correta: 1 },
{ pergunta: "Qual é o antônimo de 'falso'?", opcoes: ["Incerto", "Verdadeiro", "Tímido", "Cruel"], correta: 1 },
{ pergunta: "Em 'O carro que comprei é novo', 'que' é um:", opcoes: ["Pronome relativo", "Conjunção", "Advérbio", "Artigo"], correta: 0 },
{ pergunta: "Qual frase apresenta ambiguidade?", opcoes: ["Comprei pão na padaria", "Ele viu o homem com o telescópio", "Ela estudou a noite toda", "O cachorro correu rápido"], correta: 1 },
{ pergunta: "Qual é o plural de 'aval'?", opcoes: ["Aváis", "Avales", "Avals", "Avais"], correta: 3 },
{ pergunta: "Qual é o plural de 'mal' (substantivo)?", opcoes: ["Males", "Maus", "Maleses", "Mauses"], correta: 0 },
{ pergunta: "Qual destas é uma oração subordinada?", opcoes: ["Saí cedo, mas voltei tarde", "Quando cheguei, choveu", "Ele estudou muito", "Não sei a resposta"], correta: 1 },
{ pergunta: "Qual é o verbo transitivo direto?", opcoes: ["Chegar", "Sorrir", "Amar", "Viver"], correta: 2 },
{ pergunta: "Qual é a forma nominal do verbo 'cantar'?", opcoes: ["Cantou", "Cantando", "Canta", "Cantará"], correta: 1 },
{ pergunta: "A função da crase em 'vou à praia' é:", opcoes: ["Futuro", "Plural", "Fusão de preposição + artigo", "Conjunção"], correta: 2 },
{ pergunta: "Em 'Se eu pudesse', o verbo está no:", opcoes: ["Indicativo", "Imperativo", "Subjuntivo", "Gerúndio"], correta: 2 },
{ pergunta: "A palavra 'impossível' é:", opcoes: ["Verbo", "Advérbio", "Adjetivo", "Preposição"], correta: 2 },
{ pergunta: "Qual é o sujeito de 'Faltam dez minutos'?", opcoes: ["Faltam", "Dez minutos", "Minutos", "Oculto"], correta: 1 },
{ pergunta: "Qual dessas palavras exige acento?", opcoes: ["Ideia", "Heroi", "Porem", "Fácil"], correta: 3 },
{ pergunta: "Qual é o antônimo de 'rigoroso'?", opcoes: ["Exato", "Permissivo", "Duro", "Cruel"], correta: 1 },
{ pergunta: "Qual é a função do hífen em 'bem-estar'?", opcoes: ["Separar verbos", "Unir palavras formando um composto", "Indicar pausa", "Criar plural"], correta: 1 },
{ pergunta: "Qual é o plural de 'alface'?", opcoes: ["Alfaces", "Alfaceses", "Alfacez", "Alfaceis"], correta: 0 },
{ pergunta: "Em 'João viu Maria correndo', quem está correndo?", opcoes: ["João", "Maria", "Ambos", "Nenhum"], correta: 1 },
{ pergunta: "Qual é o tipo de sujeito em 'Vendem-se casas'?", opcoes: ["Oculto", "Indeterminado", "Composto", "Inexistente"], correta: 1 },
{ pergunta: "A palavra 'sutil' é acentuada por ser:", opcoes: ["Ditongo", "Oxítona terminada em 'l'", "Hiato", "Paroxítona"], correta: 2 },
{ pergunta: "Qual é o sinal usado para indicar fala em diálogos?", opcoes: ["Ponto e vírgula", "Travessão", "Asterisco", "Hífen"], correta: 1 },
{ pergunta: "Qual é o predicado da frase 'O céu está azul'?", opcoes: ["O céu", "Está azul", "Azul", "Céu"], correta: 1 },
{ pergunta: "Qual é o plural de 'qualquer'?", opcoes: ["Qualquers", "Quaisquer", "Quaisqueres", "Qualqueres"], correta: 1 },
{ pergunta: "Qual é o conceito de 'polissemia'?", opcoes: ["Palavra com vários sentidos", "Palavra contrária", "Palavra igual", "Som igual"], correta: 0 },
{ pergunta: "A palavra 'pôde' (verbo) se refere a:", opcoes: ["Presente", "Passado", "Futuro", "Imperativo"], correta: 1 },
{ pergunta: "O que caracteriza um texto dissertativo?", opcoes: ["Contar uma história", "Descrever pessoas", "Defender um ponto de vista", "Reproduzir diálogo"], correta: 2 },
{ pergunta: "Qual é o tipo de discurso em 'Ele disse que viria'?", opcoes: ["Direto", "Indireto", "Citado", "Figurado"], correta: 1 },
{ pergunta: "O que é redundância?", opcoes: ["Repetição desnecessária", "Falta de clareza", "Metáfora", "Sinônimo"], correta: 0 }
];
const perguntasPortuguesDificeis = [
{ pergunta: "Qual é a figura de linguagem em: 'Ele morreu de rir'?", opcoes: ["Hipérbole", "Ironia", "Metonímia", "Catacrese"], correta: 0 },
{ pergunta: "Em 'A casa foi construída por José', a voz verbal é:", opcoes: ["Ativa", "Passiva analítica", "Passiva sintética", "Reflexiva"], correta: 1 },
{ pergunta: "Qual é a função sintática de 'de matemática' em 'gosto de matemática'?", opcoes: ["Adjunto nominal", "Complemento nominal", "Objeto indireto", "Adjunto adverbial"], correta: 1 },
{ pergunta: "O que é anáfora?", opcoes: ["Referência posterior", "Referência anterior", "Comparação indireta", "Repetição sonora"], correta: 1 },
{ pergunta: "Qual frase usa corretamente o 'porquê' separado e com acento?", opcoes: ["Não sei porquê ele fez isso", "Ele não veio por quê?", "O motivo por que saí", "Por que você não veio"], correta: 1 },
{ pergunta: "Em 'vendo carro usado', qual interpretação é ambígua?", opcoes: ["Carro usado por mim", "Carro usado pelo uso", "Pode ser o carro ou a ação de vender", "Nenhuma"], correta: 2 },
{ pergunta: "Qual palavra é paroxítona e leva acento?", opcoes: ["Táxi", "Lapis", "Pires", "Jovem"], correta: 0 },
{ pergunta: "A regência correta é:", opcoes: ["Assistir o filme", "Assistir ao filme", "Assistir o show", "Assistir ele"], correta: 1 },
{ pergunta: "Qual é o erro em 'Houveram muitos problemas'?", opcoes: ["Concordância verbal", "Regência", "Ortografia", "Pontuação"], correta: 0 },
{ pergunta: "Qual é um exemplo de metonímia?", opcoes: ["Ela é um anjo", "Ler Machado de Assis", "Ele chorou rios de lágrimas", "Como um touro"], correta: 1 },
{ pergunta: "Em 'é necessário coragem', o termo 'coragem' funciona como:", opcoes: ["Sujeito", "Predicativo", "Objeto direto", "Adjunto adverbial"], correta: 0 },
{ pergunta: "Qual oração possui sentido concessivo?", opcoes: ["Embora estivesse cansado, estudou", "Queria que viesse", "Se chover, não irei", "Cheguei quando anoiteceu"], correta: 0 },
{ pergunta: "A palavra 'ânsia' apresenta encontro:", opcoes: ["Hiato", "Ditongo crescente", "Tritongo", "Consoante dupla"], correta: 0 },
{ pergunta: "Qual das frases apresenta crase obrigatória?", opcoes: ["Cheguei a tarde", "Fui a Roma", "Referi-me à aluna", "Entreguei a ele"], correta: 2 },
{ pergunta: "Qual é a figura de linguagem em: 'Brasília decidiu aumentar os impostos'?", opcoes: ["Metáfora", "Metonímia", "Sinestesia", "Antítese"], correta: 1 },
{ pergunta: "A expressão 'à medida que' indica:", opcoes: ["Alternância", "Condição", "Proporção", "Finalidade"], correta: 2 },
{ pergunta: "Em 'Sou eu que mando', o verbo deve concordar com:", opcoes: ["Eu", "Que", "Mando", "Sou"], correta: 0 },
{ pergunta: "Qual é o valor semântico de 'logo que'?", opcoes: ["Tempo", "Condição", "Consequência", "Adversidade"], correta: 0 },
{ pergunta: "Em 'O aluno parece cansado', 'cansado' é:", opcoes: ["Objeto direto", "Adjunto adverbial", "Predicativo do sujeito", "Aposto"], correta: 2 },
{ pergunta: "Qual frase possui erro de colocação pronominal?", opcoes: ["Me disseram a verdade", "Disseram-me a verdade", "Dirão-lhe a verdade", "Contaram-nos tudo"], correta: 0 },
{ pergunta: "Qual palavra NÃO é oxítona?", opcoes: ["Você", "Sabiá", "Café", "Lápis"], correta: 3 },
{ pergunta: "O termo 'cujo' exige:", opcoes: ["Vírgula antes", "Artigo após", "Concordância com o possuidor", "Crase"], correta: 2 },
{ pergunta: "A palavra 'impresso' é:", opcoes: ["Gerúndio", "Particípio irregular", "Infinitivo", "Particípio regular"], correta: 1 },
{ pergunta: "Qual é a relação semântica em: 'Ele correu tanto que caiu'?", opcoes: ["Tempo", "Causa", "Condição", "Consequência"], correta: 3 },
{ pergunta: "Em 'A menina a quem me referi', 'a quem' indica:", opcoes: ["Objeto direto", "Objeto indireto", "Adjunto adverbial", "Predicativo"], correta: 1 },
{ pergunta: "Qual frase apresenta paralelismo?", opcoes: ["Ele gosta de ler e de escrever", "Ele gosta de ler e escrever", "Ele gosta de ler e de música", "Ele gosta ler e escrever"], correta: 0 },
{ pergunta: "Qual é a oração reduzida?", opcoes: ["Quando eu cheguei", "Ao entrar na sala", "Porque estou cansado", "Embora estudasse"], correta: 1 },
{ pergunta: "Qual é o plural de 'qualquer'?", opcoes: ["Qualqueres", "Quaisquer", "Quaisquers", "Qualquers"], correta: 1 },
{ pergunta: "O termo entre vírgulas em 'João, o professor, chegou' é:", opcoes: ["Adjunto adjetivo", "Aposto explicativo", "Vocativo", "Adjunto adverbial"], correta: 1 },
{ pergunta: "Em 'Vimos o aluno chegar', o termo 'chegar' é:", opcoes: ["Verbo auxiliar", "Verbo finito", "Infinitivo", "Gerúndio"], correta: 2 },
{ pergunta: "O que caracteriza um texto argumentativo?", opcoes: ["Narrar fatos", "Expor sentimentos", "Convencer o leitor", "Reproduzir discursos"], correta: 2 },
{ pergunta: "Qual é o advérbio em 'Ele falou claramente'?", opcoes: ["Ele", "Falou", "Claramente", "Falou claramente"], correta: 2 },
{ pergunta: "Qual é o nome do processo em que palavras mudam de classe?", opcoes: ["Derivação", "Hibridismo", "Metaplasmo", "Conversão"], correta: 3 },
{ pergunta: "A regência de 'preferir' está correta em:", opcoes: ["Prefiro mais estudar", "Prefiro estudar do que trabalhar", "Prefiro estudar a trabalhar", "Prefiro estudar que trabalhar"], correta: 2 },
{ pergunta: "O que é ambiguidade?", opcoes: ["Confusão intencional", "Duplo sentido", "Erro de ortografia", "Uso de metáfora"], correta: 1 },
{ pergunta: "Qual é o termo acessório da oração?", opcoes: ["Complemento nominal", "Adjunto adverbial", "Objeto direto", "Predicado"], correta: 1 },
{ pergunta: "Em 'É proibido entrada', há erro por falta de:", opcoes: ["Artigo", "Verbo", "Pronome", "Preposição"], correta: 0 },
{ pergunta: "Qual é a relação semântica de 'apesar de'?", opcoes: ["Causa", "Explicação", "Concessão", "Comparação"], correta: 2 },
{ pergunta: "O plural de 'pão-duro' é:", opcoes: ["Pães-duros", "Pães-duro", "Pão-duros", "Pões-duro"], correta: 0 },
{ pergunta: "Qual das frases está correta?", opcoes: ["Fazem dois anos que estudo", "Faz dois anos que estudo", "Houveram muitos alunos", "Existem muitos aluno"], correta: 1 },
{ pergunta: "Qual palavra apresenta dígrafo?", opcoes: ["Chuva", "Rato", "Peso", "Lago"], correta: 0 },
{ pergunta: "A oração 'Se eu soubesse' está no tempo:", opcoes: ["Futuro do presente", "Pretérito imperfeito do subjuntivo", "Pretérito mais-que-perfeito", "Gerúndio"], correta: 1 },
{ pergunta: "Qual é o tipo de discurso em 'Pedro afirmou: “Voltarei amanhã”'?", opcoes: ["Direto", "Indireto", "Indireto livre", "Citado"], correta: 0 },
{ pergunta: "O termo 'por conseguinte' expressa:", opcoes: ["Conclusão", "Oposição", "Tempo", "Finalidade"], correta: 0 },
{ pergunta: "Qual é a classificação de 'felizmente'?", opcoes: ["Adjetivo", "Advérbio de modo", "Conjunção", "Pronome"], correta: 1 },
{ pergunta: "A palavra 'intervenção' apresenta:", opcoes: ["Hiato", "Tritongo", "Ditongo", "Dígrafo"], correta: 2 },
{ pergunta: "Em 'Eles se olharam', a voz verbal é:", opcoes: ["Ativa", "Passiva analítica", "Reflexiva", "Recíproca"], correta: 3 },
{ pergunta: "A pontuação correta é:", opcoes: ["João porém saiu cedo", "João, porém, saiu cedo", "João, porém saiu cedo", "João porém, saiu cedo"], correta: 1 },
{ pergunta: "Qual é o termo destacado em: 'Ela comprou o livro *de capa azul*'?", opcoes: ["Adjunto nominal", "Predicativo", "Objeto indireto", "Aposto"], correta: 0 }
];

const perguntasInglesFaceis = [
{ pergunta: "Como se diz 'cachorro' em inglês?", opcoes: ["Dog", "Cat", "Horse", "Duck"], correta: 0 },
{ pergunta: "Como se diz 'gato' em inglês?", opcoes: ["Dog", "Cow", "Cat", "Bear"], correta: 2 },
{ pergunta: "Como se diz 'livro' em inglês?", opcoes: ["Notebook", "Book", "Paper", "Pencil"], correta: 1 },
{ pergunta: "Como se diz 'maçã' em inglês?", opcoes: ["Apple", "Banana", "Orange", "Pear"], correta: 0 },
{ pergunta: "Como se diz 'feliz' em inglês?", opcoes: ["Sad", "Angry", "Happy", "Tired"], correta: 2 },
{ pergunta: "Como se diz 'água' em inglês?", opcoes: ["Juice", "Tea", "Milk", "Water"], correta: 3 },
{ pergunta: "Como se diz 'casa' em inglês?", opcoes: ["Home", "Room", "House", "Building"], correta: 2 },
{ pergunta: "Como se diz 'vermelho' em inglês?", opcoes: ["Blue", "Yellow", "Red", "Green"], correta: 2 },
{ pergunta: "Como se diz 'azul' em inglês?", opcoes: ["White", "Black", "Blue", "Pink"], correta: 2 },
{ pergunta: "Como se diz 'amigo' em inglês?", opcoes: ["Friend", "Brother", "Teacher", "Boy"], correta: 0 },
{ pergunta: "Como se diz 'tchau' em inglês?", opcoes: ["Hello", "Bye", "Thanks", "Please"], correta: 1 },
{ pergunta: "Como se diz 'obrigado' em inglês?", opcoes: ["Sorry", "Hello", "Thanks", "Good"], correta: 2 },
{ pergunta: "Como se diz 'pequeno' em inglês?", opcoes: ["Big", "Small", "Tall", "Short"], correta: 1 },
{ pergunta: "Como se diz 'grande' em inglês?", opcoes: ["Small", "Soft", "Tall", "Big"], correta: 3 },
{ pergunta: "Como se diz 'comida' em inglês?", opcoes: ["Food", "Foot", "Feed", "Face"], correta: 0 },
{ pergunta: "Como se diz 'carro' em inglês?", opcoes: ["Bike", "Car", "Bus", "Train"], correta: 1 },
{ pergunta: "Como se diz 'janela' em inglês?", opcoes: ["Window", "Door", "Wall", "Floor"], correta: 0 },
{ pergunta: "Como se diz 'porta' em inglês?", opcoes: ["Window", "Gate", "Door", "Wall"], correta: 2 },
{ pergunta: "Como se diz 'sol' em inglês?", opcoes: ["Sun", "Moon", "Star", "Sky"], correta: 0 },
{ pergunta: "Como se diz 'noite' em inglês?", opcoes: ["Morning", "Night", "Afternoon", "Evening"], correta: 1 },
{ pergunta: "Como se diz 'bom dia' em inglês?", opcoes: ["Good night", "Good morning", "Hello", "Good evening"], correta: 1 },
{ pergunta: "Como se diz 'boa noite' (ao dormir) em inglês?", opcoes: ["Good evening", "Good night", "Bye", "See you"], correta: 1 },
{ pergunta: "Como se diz 'professor' em inglês?", opcoes: ["Doctor", "Master", "Teacher", "Chief"], correta: 2 },
{ pergunta: "Como se diz 'escola' em inglês?", opcoes: ["School", "Class", "Room", "Center"], correta: 0 },
{ pergunta: "Como se diz 'mesa' em inglês?", opcoes: ["Desk", "Table", "Chair", "Seat"], correta: 1 },
{ pergunta: "Como se diz 'cadeira' em inglês?", opcoes: ["Sofa", "Chair", "Desk", "Table"], correta: 1 },
{ pergunta: "Como se diz 'roupa' em inglês?", opcoes: ["Clothes", "Shoes", "Dress", "Wear"], correta: 0 },
{ pergunta: "Como se diz 'leite' em inglês?", opcoes: ["Milk", "Water", "Juice", "Tea"], correta: 0 },
{ pergunta: "Como se diz 'forte' em inglês?", opcoes: ["Weak", "Tall", "Strong", "Fast"], correta: 2 },
{ pergunta: "Como se diz 'fraco' em inglês?", opcoes: ["Thin", "Weak", "Short", "Tiny"], correta: 1 },
{ pergunta: "Como se diz 'rápido' em inglês?", opcoes: ["Fast", "Slow", "Late", "Early"], correta: 0 },
{ pergunta: "Como se diz 'devagar' em inglês?", opcoes: ["Fast", "Slow", "Soft", "Short"], correta: 1 },
{ pergunta: "Como se diz 'trabalho' em inglês?", opcoes: ["Walk", "Work", "World", "Word"], correta: 1 },
{ pergunta: "Como se diz 'família' em inglês?", opcoes: ["Group", "Family", "People", "Team"], correta: 1 },
{ pergunta: "Como se diz 'mãe' em inglês?", opcoes: ["Mother", "Sister", "Aunt", "Girl"], correta: 0 },
{ pergunta: "Como se diz 'pai' em inglês?", opcoes: ["Daddy", "Father", "Brother", "Man"], correta: 1 },
{ pergunta: "Como se diz 'irmão' em inglês?", opcoes: ["Brother", "Friend", "Man", "Boy"], correta: 0 },
{ pergunta: "Como se diz 'irmã' em inglês?", opcoes: ["Girl", "Sister", "Mother", "Lady"], correta: 1 },
{ pergunta: "Como se diz 'chuva' em inglês?", opcoes: ["Snow", "Rain", "Storm", "Wind"], correta: 1 },
{ pergunta: "Como se diz 'vento' em inglês?", opcoes: ["Storm", "Rain", "Wind", "Cloud"], correta: 2 },
{ pergunta: "Como se diz 'cidade' em inglês?", opcoes: ["Country", "Town", "Street", "City"], correta: 3 },
{ pergunta: "Como se diz 'amarelo' em inglês?", opcoes: ["Blue", "Green", "Black", "Yellow"], correta: 3 },
{ pergunta: "Como se diz 'preto' em inglês?", opcoes: ["Black", "White", "Brown", "Red"], correta: 0 },
{ pergunta: "Como se diz 'branco' em inglês?", opcoes: ["Pink", "White", "Gray", "Blue"], correta: 1 },
{ pergunta: "Como se diz 'comer' em inglês?", opcoes: ["Eat", "Drink", "Cook", "Make"], correta: 0 },
{ pergunta: "Como se diz 'beber' em inglês?", opcoes: ["Drink", "Cook", "Eat", "Feel"], correta: 0 },
{ pergunta: "Como se diz 'andar' em inglês?", opcoes: ["Walk", "Work", "Run", "Jump"], correta: 0 },
{ pergunta: "Como se diz 'correr' em inglês?", opcoes: ["Jump", "Run", "Walk", "Fly"], correta: 1 },
{ pergunta: "Como se diz 'céu' em inglês?", opcoes: ["Sky", "Sea", "Sun", "Air"], correta: 0 },
{ pergunta: "Como se diz 'doce' em inglês?", opcoes: ["Sweet", "Sugar", "Candy", "Cake"], correta: 0 }
];
const perguntasInglesMedias = [
{ pergunta: "What is the past form of 'go'?", opcoes: ["Goed", "Went", "Gone", "Go"], correta: 1 },
{ pergunta: "What is the opposite of 'easy'?", opcoes: ["Hard", "Soft", "Slow", "Long"], correta: 0 },
{ pergunta: "What does 'hungry' mean?", opcoes: ["With fear", "With sleep", "With hunger", "With cold"], correta: 2 },
{ pergunta: "Choose the correct article: ____ apple.", opcoes: ["A", "An", "The", "Some"], correta: 1 },
{ pergunta: "Which one is a place?", opcoes: ["Run", "City", "Eat", "Play"], correta: 1 },
{ pergunta: "What is the plural of 'child'?", opcoes: ["Childs", "Children", "Childes", "Childrens"], correta: 1 },
{ pergunta: "What is the meaning of 'always'?", opcoes: ["Never", "Sometimes", "Every time", "Rarely"], correta: 2 },
{ pergunta: "Which word means 'rápido'?", opcoes: ["Slow", "Fast", "Late", "Deep"], correta: 1 },
{ pergunta: "What is the opposite of 'hot'?", opcoes: ["Warm", "Cold", "Cool", "Wet"], correta: 1 },
{ pergunta: "Which verb means 'dormir'?", opcoes: ["Eat", "Sleep", "Read", "Write"], correta: 1 },
{ pergunta: "What is the comparative of 'big'?", opcoes: ["More big", "Bigger", "Most big", "Biggest"], correta: 1 },
{ pergunta: "Complete: She ____ to school every day.", opcoes: ["go", "goes", "went", "gone"], correta: 1 },
{ pergunta: "Which one is a fruit?", opcoes: ["Potato", "Carrot", "Apple", "Pepper"], correta: 2 },
{ pergunta: "What is the opposite of 'before'?", opcoes: ["Late", "After", "Ahead", "Long"], correta: 1 },
{ pergunta: "Which one means 'feliz'?", opcoes: ["Happy", "Sad", "Angry", "Tired"], correta: 0 },
{ pergunta: "Which is a synonym of 'big'?", opcoes: ["Huge", "Small", "Short", "Tiny"], correta: 0 },
{ pergunta: "What does 'borrow' mean?", opcoes: ["Give something", "Take something for a time", "Break something", "Pay something"], correta: 1 },
{ pergunta: "Choose the correct preposition: I live ___ Brazil.", opcoes: ["in", "on", "at", "under"], correta: 0 },
{ pergunta: "Which one means 'perto'?", opcoes: ["Far", "Near", "Down", "Up"], correta: 1 },
{ pergunta: "What is the opposite of 'young'?", opcoes: ["Slow", "Old", "Tall", "Small"], correta: 1 },
{ pergunta: "Which word is a job?", opcoes: ["Teacher", "Table", "Window", "Street"], correta: 0 },
{ pergunta: "What does 'together' mean?", opcoes: ["Separately", "Close to each other", "Fast", "At night"], correta: 1 },
{ pergunta: "What is the superlative of 'tall'?", opcoes: ["Taller", "Tallest", "More tall", "Most tall"], correta: 1 },
{ pergunta: "What does 'cloudy' describe?", opcoes: ["Food", "Weather", "Animals", "Music"], correta: 1 },
{ pergunta: "What does 'dangerous' mean?", opcoes: ["Safe", "Not safe", "Cheap", "Funny"], correta: 1 },
{ pergunta: "Choose the correct: They ____ the movie yesterday.", opcoes: ["watch", "watched", "watching", "watches"], correta: 1 },
{ pergunta: "Which one means 'rádio'?", opcoes: ["TV", "Radio", "Phone", "Speaker"], correta: 1 },
{ pergunta: "What does 'early' mean?", opcoes: ["Not late", "Very late", "Fast", "Far"], correta: 0 },
{ pergunta: "What is the opposite of 'clean'?", opcoes: ["Open", "Dirty", "Big", "Small"], correta: 1 },
{ pergunta: "What is the past of 'take'?", opcoes: ["Toke", "Taken", "Took", "Take"], correta: 2 },
{ pergunta: "Which sentence is correct?", opcoes: ["He are happy", "He is happy", "He am happy", "He be happy"], correta: 1 },
{ pergunta: "Choose the correct verb: She ____ dinner now.", opcoes: ["cook", "cooks", "is cooking", "cooked"], correta: 2 },
{ pergunta: "What does 'finish' mean?", opcoes: ["Start", "End", "Pause", "Continue"], correta: 1 },
{ pergunta: "Which one means 'chuva'?", opcoes: ["Rain", "Snow", "Fog", "Wind"], correta: 0 },
{ pergunta: "What does 'health' refer to?", opcoes: ["Money", "Food", "Body condition", "Clothes"], correta: 2 },
{ pergunta: "Which is a means of transport?", opcoes: ["Car", "Tree", "Plate", "Room"], correta: 0 },
{ pergunta: "What does 'expensive' mean?", opcoes: ["Cheap", "Not cheap", "Easy", "Difficult"], correta: 1 },
{ pergunta: "Which one means 'esporte'?", opcoes: ["Sport", "Spot", "Support", "Short"], correta: 0 },
{ pergunta: "Correct plural: One mouse, two ____.", opcoes: ["Mouses", "Mice", "Mouse", "Mousses"], correta: 1 },
{ pergunta: "Choose the correct word: I need to ____ a letter.", opcoes: ["read", "write", "drink", "drive"], correta: 1 },
{ pergunta: "Which means 'roupas'?", opcoes: ["Clothes", "Clouds", "Clocks", "Classes"], correta: 0 },
{ pergunta: "What does 'strong' mean?", opcoes: ["Weak", "Powerful", "Slow", "Cold"], correta: 1 },
{ pergunta: "What is the opposite of 'long'?", opcoes: ["High", "Short", "Big", "Hot"], correta: 1 },
{ pergunta: "Which one is a month?", opcoes: ["Monday", "June", "Morning", "Winter"], correta: 1 },
{ pergunta: "Choose the correct: She is ____ doctor.", opcoes: ["the", "a", "an", "some"], correta: 2 },
{ pergunta: "What does 'sometimes' mean?", opcoes: ["Always", "Never", "At certain times", "Every day"], correta: 2 },
{ pergunta: "What does 'believe' mean?", opcoes: ["Duvidar", "Acreditar", "Cansar", "Falar"], correta: 1 },
{ pergunta: "Which word is an emotion?", opcoes: ["Table", "Happy", "Street", "Shirt"], correta: 1 },
{ pergunta: "What does 'quiet' mean?", opcoes: ["Noisy", "Silent", "Angry", "Bright"], correta: 1 },
{ pergunta: "Which one is correct?", opcoes: ["She don't like ice cream", "She doesn't like ice cream", "She not like ice cream", "She no like ice cream"], correta: 1 }
];
const perguntasInglesDificeis = [
{ pergunta: "What does the word 'thorough' most nearly mean?", opcoes: ["Quick", "Careful and complete", "Unnecessary", "Simple"], correta: 1 },
{ pergunta: "Choose the correct sentence:", opcoes: ["If I was you, I would study more.", "If I were you, I would study more.", "If I been you, I would study more.", "If I be you, I study more."], correta: 1 },
{ pergunta: "What is the meaning of the phrasal verb 'put off'?", opcoes: ["Cancel", "Postpone", "Repeat", "Allow"], correta: 1 },
{ pergunta: "What does 'scarce' mean?", opcoes: ["Rare", "Fast", "Heavy", "Clear"], correta: 0 },
{ pergunta: "Choose the correct option: She insisted ____ paying the bill.", opcoes: ["on", "at", "for", "to"], correta: 0 },
{ pergunta: "What is the synonym of 'astonished'?", opcoes: ["Bored", "Surprised", "Angry", "Calm"], correta: 1 },
{ pergunta: "What does 'despite' express?", opcoes: ["Cause", "Condition", "Contrast", "Time"], correta: 2 },
{ pergunta: "What does the phrasal verb 'turn down' mean?", opcoes: ["Reduce or refuse", "Create", "Destroy", "Turn around"], correta: 0 },
{ pergunta: "Choose the correct form: The results ____ by tomorrow.", opcoes: ["will release", "will have been released", "are released", "have released"], correta: 1 },
{ pergunta: "What does 'famine' mean?", opcoes: ["Lack of rain", "Extreme hunger", "Disease", "War"], correta: 1 },
{ pergunta: "Which sentence is correct?", opcoes: ["Hardly I had arrived when it started to rain.", "Hardly had I arrived when it started to rain.", "I had hardly arrived when started to rain.", "Hardly arrived I when it rains."], correta: 1 },
{ pergunta: "What is the opposite of 'scarcity'?", opcoes: ["Abundance", "Pain", "Speed", "Intensity"], correta: 0 },
{ pergunta: "Which option contains a metaphor?", opcoes: ["The sun is a golden coin in the sky.", "The sun shines brightly.", "The sun rises every day.", "The sun warmed the air."], correta: 0 },
{ pergunta: "Choose the correct form: It's time we ____ home.", opcoes: ["go", "went", "goes", "had gone"], correto: 1 },
{ pergunta: "What does 'undermine' mean?", opcoes: ["Support", "Weaken", "Organize", "Repair"], correta: 1 },
{ pergunta: "What is the meaning of 'allegedly'?", opcoes: ["Without permission", "Supposedly", "Certainly", "Secretly"], correta: 1 },
{ pergunta: "Choose the correct relative pronoun: The book, ____ I bought yesterday, is excellent.", opcoes: ["that", "what", "which", "who"], correta: 2 },
{ pergunta: "What does 'widespread' mean?", opcoes: ["Rare", "Limited", "Common and extended", "Dangerous"], correta: 2 },
{ pergunta: "What is the best synonym for 'compelling'?", opcoes: ["Weak", "Unimportant", "Convincing", "Fast"], correta: 2 },
{ pergunta: "Choose the correct alternative: She denied ____ the documents.", opcoes: ["to steal", "steal", "stealing", "to stealing"], correta: 2 },
{ pergunta: "What does 'regardless' mean?", opcoes: ["In any case", "Only at night", "With anger", "By accident"], correta: 0 },
{ pergunta: "What does the phrasal verb 'bring up' mean?", opcoes: ["Raise a topic", "Raise a child", "Vomit", "All are possible"], correta: 3 },
{ pergunta: "Choose the correct form: He behaves as if he ____ everything.", opcoes: ["knows", "knew", "known", "knowing"], correta: 1 },
{ pergunta: "What does 'outbreak' refer to?", opcoes: ["A large crowd", "Beginning of something unpleasant", "A peaceful moment", "A festival"], correta: 1 },
{ pergunta: "Which is closest in meaning to 'swift'?", opcoes: ["Slow", "Quick", "Careless", "Heavy"], correta: 1 },
{ pergunta: "What does 'therefore' express?", opcoes: ["Reason/result", "Time", "Contrast", "Condition"], correta: 0 },
{ pergunta: "Choose the correct form: Not only ____ the test, but she also got the highest score.", opcoes: ["she passed", "did she pass", "passed she", "she did pass"], correta: 1 },
{ pergunta: "What is the meaning of 'insight'?", opcoes: ["Anger", "Deep understanding", "Fear", "Confusion"], correta: 1 },
{ pergunta: "What does the phrasal verb 'get along' mean?", opcoes: ["Wear clothes", "Have a good relationship", "Get lost", "Run fast"], correta: 1 },
{ pergunta: "Choose the correct: Had I known, I ____ earlier.", opcoes: ["will leave", "would leave", "would have left", "leave"], correta: 2 },
{ pergunta: "What does 'shortage' mean?", opcoes: ["Lack", "Too much", "Speed", "Delay"], correta: 0 },
{ pergunta: "What does 'straightly' mean?", opcoes: ["Clearly", "Honestly", "Immediately", "Directly"], correta: 3 },
{ pergunta: "Choose the option that is an oxymoron:", opcoes: ["Dark night", "Small house", "Deafening silence", "Cold winter"], correta: 2 },
{ pergunta: "What does 'alleviate' mean?", opcoes: ["Make worse", "Make better or lighter", "Investigate", "Ignore"], correta: 1 },
{ pergunta: "Choose the correct word: His speech was very ____; everyone understood.", opcoes: ["obscure", "clear", "narrow", "fragile"], correta: 1 },
{ pergunta: "What does the idiom 'the last straw' mean?", opcoes: ["The easiest moment", "The final problem before losing patience", "The biggest opportunity", "The shortest explanation"], correta: 1 },
{ pergunta: "Choose the correct tense: By 2030, humans ____ on Mars.", opcoes: ["live", "will be living", "lived", "are living"], correta: 1 },
{ pergunta: "What does 'unprecedented' mean?", opcoes: ["Never happened before", "Very dangerous", "Very small", "Very complicated"], correta: 0 },
{ pergunta: "What is the closest meaning of 'substantial'?", opcoes: ["Large or important", "Cheap", "Rare", "Inactive"], correta: 0 },
{ pergunta: "Choose the correct: The research aims ____ improving public health.", opcoes: ["to", "at", "for", "with"], correta: 1 },
{ pergunta: "What does 'albeit' mean?", opcoes: ["Even though", "Because", "Without", "Before"], correta: 0 },
{ pergunta: "Choose the correct passive structure: The report ____ by experts last week.", opcoes: ["was analyzed", "analyzed", "is analyzing", "has analyzing"], correta: 0 },
{ pergunta: "What does 'feasible' mean?", opcoes: ["Impossible", "Possible", "Dangerous", "Confusing"], correta: 1 },
{ pergunta: "What does 'misleading' mean?", opcoes: ["True", "Not clear and causing wrong ideas", "Expensive", "Friendly"], correta: 1 },
{ pergunta: "Choose the correct verb: She tends ____ late.", opcoes: ["arriving", "to arrive", "arrive", "to arriving"], correta: 1 },
{ pergunta: "What does 'alleviate' mean?", opcoes: ["Increase pain", "Reduce suffering", "Ignore problems", "Explain rules"], correta: 1 },
{ pergunta: "Choose the correct expression: He succeeded ____ great effort.", opcoes: ["because", "due to", "despite", "instead"], correta: 1 },
{ pergunta: "What does 'framework' mean?", opcoes: ["A physical door", "A structured system", "A type of computer", "A mistake"], correta: 1 },
{ pergunta: "Choose the correct: This is the student ____ project won the award.", opcoes: ["whom", "whose", "who's", "that is"], correta: 1 },
{ pergunta: "What does 'nevertheless' express?", opcoes: ["Conclusion", "Contrast", "Time", "Cause"], correta: 1 }
];

const perguntasHistoriaFaceis = [
{ pergunta: "Quem foi o primeiro imperador do Brasil?", opcoes: ["Dom Pedro II", "Dom Pedro I", "Tiradentes", "Getúlio Vargas"], correta: 1 },
{ pergunta: "Em que ano ocorreu a Proclamação da República no Brasil?", opcoes: ["1822", "1889", "1500", "1930"], correta: 1 },
{ pergunta: "Quem descobriu o Brasil?", opcoes: ["Dom Pedro I", "Cristóvão Colombo", "Pedro Álvares Cabral", "Vasco da Gama"], correta: 2 },
{ pergunta: "A escravidão no Brasil foi abolida em:", opcoes: ["1822", "1889", "1888", "1910"], correta: 2 },
{ pergunta: "Qual povo construiu as pirâmides?", opcoes: ["Romanos", "Egípcios", "Astecas", "Gregos"], correta: 1 },
{ pergunta: "Quem foi o líder do movimento Inconfidência Mineira?", opcoes: ["Zumbi", "Tiradentes", "Anchieta", "José Bonifácio"], correta: 1 },
{ pergunta: "O que marcou o ano de 1500 no Brasil?", opcoes: ["Descobrimento", "Independência", "Abolição", "República"], correta: 0 },
{ pergunta: "Quem foi o primeiro presidente do Brasil?", opcoes: ["Deodoro da Fonseca", "Getúlio Vargas", "JK", "Floriano Peixoto"], correta: 0 },
{ pergunta: "A independência do Brasil ocorreu em:", opcoes: ["1500", "1822", "1889", "1930"], correta: 1 },
{ pergunta: "A Roma Antiga é famosa por:", opcoes: ["Pirâmides", "Império poderoso", "Catedrais góticas", "Samurais"], correta: 1 },
{ pergunta: "Quem foi o líder dos Quilombos dos Palmares?", opcoes: ["Zumbi", "Cabral", "Lampião", "Anchieta"], correta: 0 },
{ pergunta: "A Idade Média é conhecida também como:", opcoes: ["Idade da Pedra", "Idade das Trevas", "Idade Moderna", "Idade Contemporânea"], correta: 1 },
{ pergunta: "A Revolução Francesa aconteceu em:", opcoes: ["1789", "1500", "1914", "1815"], correta: 0 },
{ pergunta: "Quem gritou 'Independência ou Morte!'?", opcoes: ["Tiradentes", "Dom Pedro II", "Dom Pedro I", "Cabral"], correta: 2 },
{ pergunta: "O que foi a Segunda Guerra Mundial?", opcoes: ["Um evento esportivo", "Um conflito global", "Um acordo entre países", "Uma revolução agrícola"], correta: 1 },
{ pergunta: "Qual civilização criou a escrita cuneiforme?", opcoes: ["Maias", "Mesopotâmicos", "Gregos", "Egípcios"], correta: 1 },
{ pergunta: "A escravidão no Brasil era baseada no trabalho de:", opcoes: ["Europeus", "Africanos", "Asiáticos", "Índios americanos"], correta: 1 },
{ pergunta: "Quem foi o principal líder da luta pela independência da Índia?", opcoes: ["Mandela", "Gandhi", "Churchill", "Einstein"], correta: 1 },
{ pergunta: "O que foi a Revolução Industrial?", opcoes: ["Mudança agrícola", "Processo de máquinas e fábricas", "Expansão romana", "Descobrimento do Brasil"], correta: 1 },
{ pergunta: "Qual destes é um país que participou da Segunda Guerra Mundial?", opcoes: ["Brasil", "Groenlândia", "Chile", "Bolívia"], correta: 0 },
{ pergunta: "Quem foi Adolf Hitler?", opcoes: ["Rei da França", "Líder nazista", "Imperador chinês", "Faraó"], correta: 1 },
{ pergunta: "O que os portugueses buscavam nas Grandes Navegações?", opcoes: ["Terras para colonizar", "Especiarias e rotas comerciais", "Escravos", "Armas"], correta: 1 },
{ pergunta: "Qual povo era conhecido por seus samurais?", opcoes: ["Egípcios", "Japoneses", "Romanos", "Maias"], correta: 1 },
{ pergunta: "Qual evento marca o início da Idade Contemporânea?", opcoes: ["Revolução Francesa", "Descobrimento da América", "Queda de Constantinopla", "Independência do Brasil"], correta: 0 },
{ pergunta: "Quem comandou o regime militar no Brasil em 1964?", opcoes: ["Militares", "Padres", "Estudantes", "Comerciantes"], correta: 0 },
{ pergunta: "O Tratado de Tordesilhas dividiu o mundo entre:", opcoes: ["França e Inglaterra", "Brasil e Argentina", "Portugal e Espanha", "Roma e Grécia"], correta: 2 },
{ pergunta: "Quem foi responsável pela Abolição da Escravidão no Brasil?", opcoes: ["Dom Pedro I", "Princesa Isabel", "Getúlio Vargas", "Marechal Deodoro"], correta: 1 },
{ pergunta: "O que é um quilombo?", opcoes: ["Um navio português", "Refúgio de escravos fugidos", "Uma arma indígena", "Uma cidade romana"], correta: 1 },
{ pergunta: "Quem foram os aliados na Segunda Guerra Mundial?", opcoes: ["Alemanha, Itália e Japão", "Brasil, EUA e Reino Unido", "França, Roma e Egito", "China, Egito e Índia"], correta: 1 },
{ pergunta: "Qual civilização inventou o alfabeto?", opcoes: ["Fenícios", "Maias", "Egípcios", "Gregos"], correta: 0 },
{ pergunta: "Os bandeirantes eram conhecidos por:", opcoes: ["Desenhar mapas", "Explorar o interior do Brasil", "Construir igrejas", "Governar o país"], correta: 1 },
{ pergunta: "Quem foi o presidente brasileiro durante a Era Vargas?", opcoes: ["JK", "Jânio Quadros", "Getúlio Vargas", "Collor"], correta: 2 },
{ pergunta: "O muro de Berlim caiu em:", opcoes: ["1964", "1980", "1989", "2001"], correta: 2 },
{ pergunta: "A capital do Império Romano era:", opcoes: ["Atenas", "Roma", "Paris", "Moscou"], correta: 1 },
{ pergunta: "Os indígenas brasileiros viviam principalmente da:", opcoes: ["Pecuária", "Agricultura e caça", "Indústria", "Mineradora"], correta: 1 },
{ pergunta: "Quem foi o líder sul-africano que lutou contra o apartheid?", opcoes: ["Mandela", "Gandhi", "Obama", "Hitler"], correta: 0 },
{ pergunta: "Qual continente foi mais afetado pelo tráfico negreiro?", opcoes: ["Europa", "América", "África", "Ásia"], correta: 2 },
{ pergunta: "Os primeiros habitantes das Américas são chamados de:", opcoes: ["Indígenas", "Romanos", "Persas", "Vikings"], correta: 0 },
{ pergunta: "O Titanic afundou em:", opcoes: ["1912", "1945", "1900", "2000"], correta: 0 },
{ pergunta: "Quem escreveu a Lei Áurea?", opcoes: ["D. Pedro II", "Sarney", "Princesa Isabel", "Getúlio Vargas"], correta: 2 },
{ pergunta: "A escravidão no Brasil durou cerca de:", opcoes: ["50 anos", "100 anos", "300 anos", "10 anos"], correta: 2 },
{ pergunta: "Onde surgiram os Jogos Olímpicos?", opcoes: ["Roma", "Grécia", "Egito", "China"], correta: 1 },
{ pergunta: "Quem eram os faraós?", opcoes: ["Governantes do Egito", "Guerreiros japoneses", "Reis ingleses", "Imperadores romanos"], correta: 0 },
{ pergunta: "O que Cabral procurava inicialmente?", opcoes: ["Petróleo", "Ouro", "Índias (especiarias)", "Escravos"], correta: 2 },
{ pergunta: "O que marcou o ano de 1929 no mundo?", opcoes: ["A Grande Depressão", "A queda de Roma", "A criação do Brasil", "A Descoberta da América"], correta: 0 },
{ pergunta: "O que eram as capitanias hereditárias?", opcoes: ["Navios portugueses", "Terras divididas e dadas a donatários", "Cidades indígenas", "Impostos coloniais"], correta: 1 },
{ pergunta: "O Egito Antigo se desenvolveu às margens do:", opcoes: ["Rio Nilo", "Rio Amazonas", "Rio Tigre", "Rio Paraná"], correta: 0 },
{ pergunta: "Quem foi o líder do movimento dos Farrapos?", opcoes: ["Bento Gonçalves", "Zumbi", "Gandhi", "Cabral"], correta: 0 },
{ pergunta: "O que foi a Guerra Fria?", opcoes: ["Conflito direto militar", "Disputa ideológica entre EUA e URSS", "Guerra europeia", "Revolta indígena"], correta: 1 }
];
const perguntasHistoriaMedias = [
{ pergunta: "Qual foi o principal motivo da vinda da família real portuguesa ao Brasil em 1808?", opcoes: ["Fuga da França de Napoleão", "Busca por ouro", "Explorar novas terras", "Enfrentar os indígenas"], correta: 0 },
{ pergunta: "O que representou o Tratado de Tordesilhas?", opcoes: ["Fim da escravidão", "Divisão de terras entre Portugal e Espanha", "Abolição dos impostos", "Criação das capitanias"], correta: 1 },
{ pergunta: "Qual foi a principal consequência da Revolução Francesa?", opcoes: ["Retorno da monarquia", "Ascensão da burguesia", "Expansão romana", "Abolição da religião"], correta: 1 },
{ pergunta: "O que marcou o início da Idade Moderna?", opcoes: ["Descoberta da América", "Revolução Industrial", "Queda de Roma", "Guerra Fria"], correta: 0 },
{ pergunta: "Quem foi o principal articulador da Independência dos EUA?", opcoes: ["Napoleão", "George Washington", "Abraham Lincoln", "Churchill"], correta: 1 },
{ pergunta: "Qual foi a principal causa da Primeira Guerra Mundial?", opcoes: ["Disputa imperialista e alianças militares", "Crise econômica", "Guerra religiosa", "Ataque japonês aos EUA"], correta: 0 },
{ pergunta: "Quem foi responsável pela unificação da Alemanha no século XIX?", opcoes: ["Hitler", "Bismarck", "Kaiser Wilhelm II", "Frederico II"], correta: 1 },
{ pergunta: "Qual cultura antiga se destacou pelo desenvolvimento da democracia?", opcoes: ["Egípcia", "Romana", "Grega", "Maia"], correta: 2 },
{ pergunta: "Qual foi o principal objetivo das Cruzadas?", opcoes: ["Conquistar a África", "Retomar Jerusalém", "Destruir o Islã", "Expandir a Roma"], correta: 1 },
{ pergunta: "A Revolução Industrial começou em:", opcoes: ["França", "Alemanha", "Estados Unidos", "Inglaterra"], correta: 3 },
{ pergunta: "Quem liderou a luta pela independência em grande parte da América do Sul?", opcoes: ["Fidel Castro", "Simón Bolívar", "Tupac Amaru", "San Martín"], correta: 1 },
{ pergunta: "Qual evento deu início à Segunda Guerra Mundial?", opcoes: ["Ataque a Pearl Harbor", "Invasão da Polônia pela Alemanha", "Queda da bolsa de 1929", "Tratado de Versalhes"], correta: 1 },
{ pergunta: "Qual era o nome do sistema econômico vigente no Brasil Colônia?", opcoes: ["Capitalismo", "Mercantilismo", "Feudalismo", "Socialismo"], correta: 1 },
{ pergunta: "Qual foi o principal produto econômico no ciclo do açúcar?", opcoes: ["Algodão", "Café", "Ouro", "Açúcar"], correta: 3 },
{ pergunta: "A Inconfidência Mineira defendia principalmente:", opcoes: ["A volta da monarquia", "Independência de Minas Gerais", "Fim da escravidão", "Expansão do território"], correta: 1 },
{ pergunta: "A Revolução de 1930 no Brasil levou ao poder:", opcoes: ["Jânio Quadros", "Juscelino Kubitschek", "Getúlio Vargas", "Collor"], correta: 2 },
{ pergunta: "O que foi o Iluminismo?", opcoes: ["Movimento artístico medieval", "Movimento intelectual baseado na razão", "Ideologia militarista", "Religião antiga"], correta: 1 },
{ pergunta: "Quem governava o Brasil durante a Guerra do Paraguai?", opcoes: ["Dom Pedro I", "Dom Pedro II", "JK", "Getúlio Vargas"], correta: 1 },
{ pergunta: "A colonização espanhola na América foi marcada pela exploração de:", opcoes: ["Pecuária", "Agricultura familiar", "Metais preciosos", "Indústria"], correta: 2 },
{ pergunta: "A economia mineradora no Brasil provocou:", opcoes: ["Decadência do Rio de Janeiro", "Crescimento de cidades no interior", "Fim da escravidão", "Divisão do país"], correta: 1 },
{ pergunta: "Quem publicou o 'Manifesto Comunista'?", opcoes: ["Adam Smith", "Karl Marx e Engels", "Lenin", "Mussolini"], correta: 1 },
{ pergunta: "A Guerra de Canudos ocorreu em qual estado?", opcoes: ["Bahia", "Pernambuco", "Minas Gerais", "São Paulo"], correta: 0 },
{ pergunta: "O que representou o 'Dia D'?", opcoes: ["A queda de Berlim", "O ataque nuclear ao Japão", "A invasão aliada da Normandia", "O início da guerra"], correta: 2 },
{ pergunta: "Qual império ficou conhecido por suas estradas e administração eficiente?", opcoes: ["Romano", "Árabe", "Persa", "Egípcio"], correta: 0 },
{ pergunta: "O Renascimento teve início em:", opcoes: ["França", "Itália", "Alemanha", "Portugal"], correta: 1 },
{ pergunta: "O fascismo surgiu inicialmente em:", opcoes: ["Alemanha", "Itália", "Rússia", "Espanha"], correta: 1 },
{ pergunta: "Qual país lançou as bombas atômicas na Segunda Guerra?", opcoes: ["Alemanha", "Rússia", "Estados Unidos", "Japão"], correta: 2 },
{ pergunta: "Quem foi responsável pela unificação da Itália?", opcoes: ["Cavour e Garibaldi", "Napoleão", "Mussolini", "João Sem Terra"], correta: 0 },
{ pergunta: "A política do 'café com leite' foi alternância de poder entre:", opcoes: ["RJ e MG", "SP e MG", "SP e PR", "BA e PE"], correta: 1 },
{ pergunta: "A Guerra Fria foi marcada por:", opcoes: ["Batalhas diretas entre EUA e URSS", "Disputa ideológica e corrida armamentista", "Confronto religioso", "Invasões militares"], correta: 1 },
{ pergunta: "O feudalismo era baseado em:", opcoes: ["Riqueza urbana", "Comércio marítimo", "Relações de servidão e terras", "Indústria"], correta: 2 },
{ pergunta: "O que simboliza o 7 de setembro de 1822?", opcoes: ["A Proclamação da República", "A descoberta do Brasil", "A Independência", "O fim da escravidão"], correta: 2 },
{ pergunta: "Qual acontecimento encerrou a Idade Antiga?", opcoes: ["Expansão do Islã", "Queda de Roma", "Descoberta da América", "Revolução Industrial"], correta: 1 },
{ pergunta: "A Guerra dos Farrapos ocorreu principalmente por:", opcoes: ["Questões agrícolas", "Impostos elevados sobre o charque", "Disputa religiosa", "Colonização portuguesa"], correta: 1 },
{ pergunta: "A escravidão foi essencial no Brasil Colônia para:", opcoes: ["Construção de ferrovias", "Trabalho agrícola em larga escala", "Profissões urbanas", "Expansão industrial"], correta: 1 },
{ pergunta: "Qual país iniciou as Grandes Navegações?", opcoes: ["Itália", "Espanha", "França", "Portugal"], correta: 3 },
{ pergunta: "Quem foi responsável pela Abolição da Escravidão no Brasil?", opcoes: ["Dom Pedro II", "Princesa Isabel", "Deodoro", "Getúlio Vargas"], correta: 1 },
{ pergunta: "A Guerra Civil Americana foi travada principalmente por:", opcoes: ["Território", "Escravidão", "Religião", "Economia agrícola"], correta: 1 },
{ pergunta: "Quem foi o primeiro rei da França após a Revolução Francesa?", opcoes: ["Luís XVI", "Luís XVIII", "Napoleão", "Carlos X"], correta: 2 },
{ pergunta: "O Império Maia se destacou pela:", opcoes: ["Metalurgia avançada", "Arquitetura e calendário preciso", "Uso da pólvora", "Cavalaria"], correta: 1 },
{ pergunta: "Qual tratado encerrou a Primeira Guerra Mundial?", opcoes: ["Tratado de Utrecht", "Tratado de Tordesilhas", "Tratado de Versalhes", "Pacto de Varsóvia"], correta: 2 },
{ pergunta: "Os vikings eram povos originários de:", opcoes: ["África", "Escandinávia", "Ásia Menor", "América Central"], correta: 1 },
{ pergunta: "A Revolução Russa ocorreu em:", opcoes: ["1905", "1917", "1939", "1945"], correta: 1 },
{ pergunta: "Qual acontecimento marcou o fim da Segunda Guerra?", opcoes: ["Dia D", "Rendição da Alemanha", "Queda do Muro de Berlim", "Assassinato de Franz Ferdinand"], correta: 1 },
{ pergunta: "O que provocou a Crise de 1929?", opcoes: ["Abolição da escravidão", "Queda da Bolsa de Nova York", "Primeira Guerra Mundial", "Guerra do Pacífico"], correta: 1 },
{ pergunta: "O absolutismo defendia:", opcoes: ["Poder dividido", "Poder total do rei", "Fim da nobreza", "Independência das colônias"], correta: 1 },
{ pergunta: "Quem expandiu o cristianismo pelo Império Romano?", opcoes: ["Júlio César", "Constantino", "Nero", "Marco Aurélio"], correta: 1 },
{ pergunta: "O apartheid ocorreu em:", opcoes: ["Estados Unidos", "Índia", "África do Sul", "Austrália"], correta: 2 },
{ pergunta: "O Muro de Berlim separava:", opcoes: ["Norte e sul da Itália", "Alemanha Oriental e Ocidental", "França e Alemanha", "Polônia e Rússia"], correta: 1 }
];
const perguntasHistoriaDificeis = [
{ pergunta: "Qual foi o principal objetivo da Conferência de Berlim (1884–1885)?", opcoes: ["Reorganizar fronteiras após a Primeira Guerra", "Dividir a África entre potências europeias", "Criar a Liga das Nações", "Negociar o fim da escravidão"], correta: 1 },
{ pergunta: "Qual teórico desenvolveu a ideia do 'Contrato Social' que influenciou revoluções modernas?", opcoes: ["Hobbes", "Rousseau", "Montesquieu", "Voltaire"], correta: 1 },
{ pergunta: "O que caracterizou a economia-mundo segundo Immanuel Wallerstein?", opcoes: ["Multipolaridade cultural", "Divisão entre centro, periferia e semiperiferia", "Autossuficiência agrícola", "Comércio local"], correta: 1 },
{ pergunta: "A Revolução Haitiana (1791) foi marcante porque:", opcoes: ["Gerou o primeiro país socialista", "Foi a única revolução de escravos bem-sucedida na história", "Unificou a América Central", "Criou a primeira monarquia negra"], correta: 1 },
{ pergunta: "Qual acontecimento pode ser visto como o estopim da Primeira Guerra Mundial?", opcoes: ["Assassinato de Franz Ferdinand", "Tratado de Versalhes", "O Holocausto", "Crise de 1929"], correta: 0 },
{ pergunta: "O Território do Sarre, disputado no século XX, era importante devido:", opcoes: ["Indústria naval", "Mineração de carvão", "Petróleo", "Portos estratégicos"], correta: 1 },
{ pergunta: "O Kemalismo foi um movimento político que:", opcoes: ["Restaurou o Império Otomano", "Modernizou e secularizou a Turquia", "Criou o califado árabe", "Aliou a Turquia à URSS"], correta: 1 },
{ pergunta: "O Plano Marshall tinha como objetivo:", opcoes: ["Reconstruir a Europa e conter o avanço do comunismo", "Derrubar o fascismo italiano", "Dominar o Oriente Médio", "Integrar a Alemanha Oriental"], correta: 0 },
{ pergunta: "Qual foi a importância do Edito de Milão (313)?", opcoes: ["Tornou o cristianismo religião oficial", "Garantiu liberdade religiosa no Império Romano", "Expulsou judeus de Roma", "Dividiu o Império Romano"], correta: 1 },
{ pergunta: "A dinastia Qing enfrentou conflitos como:", opcoes: ["Guerra dos 100 anos", "Guerras do Ópio", "Rebelião dos Nika", "Conflito do Sinai"], correta: 1 },
{ pergunta: "O acordo Sykes-Picot (1916) dividiu secretamente:", opcoes: ["A Península Ibérica", "A África Austral", "O Oriente Médio entre França e Reino Unido", "O Cáucaso"], correta: 2 },
{ pergunta: "A Revolução Cultural Chinesa tinha como um de seus objetivos:", opcoes: ["Expandir o budismo", "Eliminar elementos 'burgueses' e reforçar o maoismo", "Unificar a Coreia", "Criar uma democracia popular"], correta: 1 },
{ pergunta: "A teoria do 'Destino Manifesto' justificava:", opcoes: ["O imperialismo europeu na Ásia", "A expansão territorial dos EUA para o Oeste", "A colonização espanhola da América", "A criação da OTAN"], correta: 1 },
{ pergunta: "A Primavera de Praga (1968) buscava:", opcoes: ["Separar a Tchecoslováquia da URSS", "Criar um socialismo mais democrático", "Unificar com a Polônia", "Retornar à monarquia"], correta: 1 },
{ pergunta: "A Pax Romana foi um período de:", opcoes: ["Guerras e invasões", "Estabilidade, construção e expansão controlada", "Queda econômica", "Domínio grego"], correta: 1 },
{ pergunta: "O apartheid foi oficialmente instituído em:", opcoes: ["1948", "1920", "1910", "1965"], correta: 0 },
{ pergunta: "A política de 'Glasnost' de Gorbachev significava:", opcoes: ["Abertura política e transparência", "Expansão militar", "Censura total", "Economia centralizada"], correta: 0 },
{ pergunta: "A Liga Hanseática foi uma:", opcoes: ["Organização militar germânica", "Aliança comercial de cidades do norte da Europa", "Coalizão agrícola medieval", "Liga feudal eslava"], correta: 1 },
{ pergunta: "A dinastia Tokugawa instituiu no Japão:", opcoes: ["Cristianismo oficial", "Período de isolamento (sakoku)", "República parlamentarista", "Industrialização precoce"], correta: 1 },
{ pergunta: "A Revolta dos Boxers ocorreu na:", opcoes: ["Índia", "China", "Coreia", "Indonésia"], correta: 1 },
{ pergunta: "O Tratado de Guadalupe Hidalgo marcou:", opcoes: ["Fim da Guerra México–EUA", "Fim da Guerra Civil", "Independência do Texas", "Início da Guerra Hispano-Americana"], correta: 0 },
{ pergunta: "A política de 'Big Stick' está associada a qual presidente dos EUA?", opcoes: ["Washington", "Lincoln", "Theodore Roosevelt", "Kennedy"], correta: 2 },
{ pergunta: "O Holodomor foi:", opcoes: ["Genocídio japonês na China", "Grande fome na Ucrânia sob Stalin", "Genocídio armênio", "Fome no Camboja"], correta: 1 },
{ pergunta: "A expansão mongol no século XIII chegou até:", opcoes: ["Japão e Índia", "Polônia e Hungria", "Espanha", "África"], correta: 1 },
{ pergunta: "A Batalha de Lepanto (1571) envolveu:", opcoes: ["Império Otomano vs Liga Santa", "França vs Inglaterra", "China vs Mongóis", "Portugal vs Holanda"], correta: 0 },
{ pergunta: "O que foi a 'Noite dos Cristais' (Kristallnacht)?", opcoes: ["Massacre de soldados alemães", "Pogrom contra judeus na Alemanha nazista", "Explosão de minas na Prússia", "Ataque soviético a Berlim"], correta: 1 },
{ pergunta: "A Revolução Iraniana de 1979 resultou na:", opcoes: ["Queda do Xá e criação da república islâmica", "Democracia laica", "Monarquia constitucional", "Integração à URSS"], correta: 0 },
{ pergunta: "A Guerra dos Trinta Anos envolveu inicialmente:", opcoes: ["Estados árabes vs cruzados", "Conflitos religiosos entre protestantes e católicos", "Japão vs Coreia", "Impérios africanos"], correta: 1 },
{ pergunta: "A dinastia carolíngia foi fundada por:", opcoes: ["Carlos Magno", "Pipino, o Breve", "Carlos Martel", "Clóvis"], correta: 1 },
{ pergunta: "A Guerra de Secessão foi vencida pelos:", opcoes: ["Confederados", "Unionistas", "Britânicos", "Texanos"], correta: 1 },
{ pergunta: "Os 'Capitães da Areia' eram grupos de:", opcoes: ["Cangaceiros", "Menores abandonados em Salvador", "Garimpeiros do ouro", "Trabalhadores rurais"], correta: 1 },
{ pergunta: "A guerra Irã-Iraque (1980–1988) começou por:", opcoes: ["Disputa territorial e rivalidade política", "Petróleo da Arábia Saudita", "Expansão soviética", "Conflito religioso europeu"], correta: 0 },
{ pergunta: "O Movimento dos Panteras Negras defendia:", opcoes: ["Pacifismo total", "Autodefesa e direitos civis afro-americanos", "Abolição dos EUA", "Fim da tecnologia"], correta: 1 },
{ pergunta: "O Império Bizantino caiu em 1453 devido à:", opcoes: ["Peste negra", "Conquista otomana de Constantinopla", "Revolta camponesa", "Invasão mongol"], correta: 1 },
{ pergunta: "A Conferência de Yalta definiu:", opcoes: ["O fim da Primeira Guerra", "A reorganização do mundo pós-Segunda Guerra", "A criação da ONU", "A queda de Napoleão"], correta: 1 },
{ pergunta: "A dinastia Safávida era originária de:", opcoes: ["Índia", "Pérsia", "Turquia", "Egito"], correta: 1 },
{ pergunta: "O marechal Tito liderou:", opcoes: ["Grécia", "Iugoslávia", "Romênia", "Hungria"], correta: 1 },
{ pergunta: "A Comuna de Paris (1871) foi:", opcoes: ["Um levante católico", "Um governo socialista revolucionário", "Revolta anti-romana", "Criação da monarquia francesa"], correta: 1 },
{ pergunta: "O Tratado de Nanquim (1842) abriu portos chineses para:", opcoes: ["A Rússia", "O Japão", "A Inglaterra", "A Espanha"], correta: 2 },
{ pergunta: "A Batalha de Stalingrado foi decisiva porque:", opcoes: ["Enfraqueceu fatalmente a Alemanha nazista", "Destruiu Moscou", "Anexou a Polônia", "Fez o Japão se render"], correta: 0 },
{ pergunta: "A Guerra dos Sete Anos foi considerada por muitos historiadores como:", opcoes: ["A primeira guerra global", "Um conflito puramente religioso", "A causa da Revolução Industrial", "Fim da escravidão"], correta: 0 },
{ pergunta: "Os samurais seguiam o código:", opcoes: ["Tengu", "Bushido", "Kamikaze", "Shinto"], correta: 1 },
{ pergunta: "O Império Acádio é importante por:", opcoes: ["Ser o primeiro grande império da história", "Criar a escrita alfabética", "Unificar o Egito", "Inventar o ferro"], correta: 0 },
{ pergunta: "A política de 'Apartação' no Brasil colonial se referia a:", opcoes: ["Isolamento indígena", "Criação de quilombos oficiais", "Separação de mestiços e brancos", "Livramento de escravos mais qualificados"], correta: 3 },
{ pergunta: "O massacre de Nankin ocorreu durante:", opcoes: ["Guerra Sino-Japonesa", "Primeira Guerra Mundial", "Guerra do Vietnã", "Guerra do Golfo"], correta: 0 },
{ pergunta: "Qual evento marcou o início da Idade Contemporânea?", opcoes: ["Segunda Guerra", "Independência dos EUA", "Revolução Francesa", "Queda do Muro de Berlim"], correta: 2 },
{ pergunta: "O Pacto de Varsóvia foi criado em resposta a:", opcoes: ["ONU", "OTAN", "Plano Marshall", "Revolução Francesa"], correta: 1 },
{ pergunta: "Os zulus ficaram famosos por:", opcoes: ["Construções de pedra", "Tática de chifre de búfalo sob Shaka Zulu", "Artilharia pesada", "Unificação árabe"], correta: 1 },
{ pergunta: "A queda do Muro de Berlim ocorreu em:", opcoes: ["1989", "1991", "1975", "1995"], correta: 0 }
];

const perguntasGeografiaFaceis = [
{ pergunta: "Qual é o maior oceano do mundo?", opcoes: ["Atlântico", "Índico", "Pacífico", "Ártico"], correta: 2 },
{ pergunta: "Qual é o maior país do mundo em território?", opcoes: ["China", "Canadá", "Rússia", "EUA"], correta: 2 },
{ pergunta: "Qual é o menor país do mundo?", opcoes: ["Mônaco", "Vaticano", "Malta", "San Marino"], correta: 1 },
{ pergunta: "Qual é o bioma predominante na Amazônia?", opcoes: ["Deserto", "Floresta Tropical", "Savana", "Tundra"], correta: 1 },
{ pergunta: "Qual é o maior rio do Brasil?", opcoes: ["Rio São Francisco", "Rio Amazonas", "Rio Paraná", "Rio Madeira"], correta: 1 },
{ pergunta: "Qual é o maior continente do planeta?", opcoes: ["América", "Europa", "Ásia", "África"], correta: 2 },
{ pergunta: "Qual é o continente onde fica o Brasil?", opcoes: ["África", "Oceania", "América do Sul", "Europa"], correta: 2 },
{ pergunta: "Onde está localizado o deserto do Saara?", opcoes: ["África", "Ásia", "América", "Europa"], correta: 0 },
{ pergunta: "Qual destas é uma ilha?", opcoes: ["Argentina", "Groenlândia", "Peru", "Egito"], correcta: 1 },
{ pergunta: "Qual é o processo responsável por causar terremotos?", opcoes: ["Movimento das placas tectônicas", "Ciclo da água", "Rotação da Terra", "Evaporação"], correta: 0 },
{ pergunta: "Qual desses é um país da América Central?", opcoes: ["Guatemala", "Chile", "Canadá", "Espanha"], correta: 0 },
{ pergunta: "Qual destes é um país europeu?", opcoes: ["Nigéria", "Alemanha", "Japão", "México"], correta: 1 },
{ pergunta: "Qual é o maior deserto do mundo?", opcoes: ["Saara", "Gobi", "Deserto da Antártica", "Kalahari"], correta: 2 },
{ pergunta: "Qual é a capital da França?", opcoes: ["Paris", "Londres", "Roma", "Berlim"], correta: 0 },
{ pergunta: "Qual é a capital do Brasil?", opcoes: ["Rio de Janeiro", "Salvador", "São Paulo", "Brasília"], correta: 3 },
{ pergunta: "Qual é o país mais populoso do mundo?", opcoes: ["Índia", "China", "EUA", "Rússia"], correta: 1 },
{ pergunta: "O que representa um mapa político?", opcoes: ["Relevo", "Fronteiras e países", "Clima", "Vegetação"], correta: 1 },
{ pergunta: "Qual é o bioma onde predominam cactos?", opcoes: ["Floresta Amazônica", "Cerrado", "Caatinga", "Pampa"], correta: 2 },
{ pergunta: "Qual o país conhecido como 'Terra do Sol Nascente'?", opcoes: ["Japão", "China", "Coreia do Sul", "Tailândia"], correta: 0 },
{ pergunta: "Onde se localiza o Monte Everest?", opcoes: ["Himalaia", "Alpes", "Andes", "Montanhas Rochosas"], correta: 0 },
{ pergunta: "Qual é o maior país da América do Sul?", opcoes: ["Chile", "Brasil", "Argentina", "Colômbia"], correta: 1 },
{ pergunta: "Qual é a camada gasosa que envolve a Terra?", opcoes: ["Hidrosfera", "Biosfera", "Atmosfera", "Litosfera"], correta: 2 },
{ pergunta: "Qual destas cidades é brasileira?", opcoes: ["Assunção", "Lima", "Bogotá", "Recife"], correta: 3 },
{ pergunta: "Qual é o clima predominante no Norte do Brasil?", opcoes: ["Polar", "Tropical úmido", "Desértico", "Temperado"], correta: 1 },
{ pergunta: "O Rio Nilo está localizado em qual continente?", opcoes: ["Europa", "Ásia", "África", "Oceania"], correta: 2 },
{ pergunta: "Qual é o maior país da África?", opcoes: ["Nigéria", "Egito", "Argélia", "África do Sul"], correta: 2 },
{ pergunta: "Qual destas cidades fica nos EUA?", opcoes: ["Toronto", "Cidade do México", "New York", "Havana"], correta: 2 },
{ pergunta: "O que indica a rosa dos ventos?", opcoes: ["Escala", "Altitude", "Orientação geográfica", "Clima"], correta: 2 },
{ pergunta: "Qual é o continente que não possui desertos quentes?", opcoes: ["Europa", "Ásia", "África", "América"], correta: 0 },
{ pergunta: "Qual é o maior arquipélago do mundo?", opcoes: ["Filipinas", "Havaí", "Indonésia", "Caribe"], correta: 2 },
{ pergunta: "O Aquífero Guarani está localizado principalmente em:", opcoes: ["Europa", "Oriente Médio", "América do Sul", "África"], correta: 2 },
{ pergunta: "A Linha do Equador divide a Terra em:", opcoes: ["Leste e Oeste", "Norte e Sul", "Trópicos", "Continentes"], correta: 1 },
{ pergunta: "Qual destes é um rio brasileiro?", opcoes: ["Rio Danúbio", "Rio Reno", "Rio Negro", "Rio Mississipi"], correta: 2 },
{ pergunta: "Qual é a principal vegetação dos Pampas?", opcoes: ["Gramíneas", "Floresta úmida", "Cerrado", "Mangue"], correta: 0 },
{ pergunta: "Qual é o nome do continente onde fica Portugal?", opcoes: ["Europa", "Ásia", "América", "África"], correta: 0 },
{ pergunta: "Qual é o clima da maior parte da Antártica?", opcoes: ["Tropical", "Polar", "Desértico quente", "Temperado"], correta: 1 },
{ pergunta: "Qual destas cidades está na Europa?", opcoes: ["Buenos Aires", "Roma", "Sydney", "Tóquio"], correta: 1 },
{ pergunta: "Onde está localizado o Pantanal?", opcoes: ["Centro-Oeste do Brasil", "Interior da Argentina", "Norte do Chile", "México"], correta: 0 },
{ pergunta: "Qual é o rio que corta a cidade de Londres?", opcoes: ["Tâmisa", "Sena", "Danúbio", "Reno"], correta: 0 },
{ pergunta: "Qual é o principal gás da atmosfera?", opcoes: ["Oxigênio", "Nitrogênio", "Gás carbônico", "Hidrogênio"], correta: 1 },
{ pergunta: "O que são favelas?", opcoes: ["Cidades planejadas", "Áreas pobres e irregulares", "Regiões agrícolas", "Parques naturais"], correta: 1 },
{ pergunta: "Qual país tem o maior número de vulcões ativos?", opcoes: ["Indonésia", "Brasil", "Austrália", "Canadá"], correta: 0 },
{ pergunta: "Qual destas opções corresponde a um tipo de relevo?", opcoes: ["Montanha", "Clima", "Vegetação", "Zona térmica"], correta: 0 },
{ pergunta: "A Cordilheira dos Andes está localizada na:", opcoes: ["Ásia", "Europa", "América do Sul", "Oceania"], correta: 2 },
{ pergunta: "Qual é a capital da Argentina?", opcoes: ["Santiago", "Mendoza", "Buenos Aires", "Córdoba"], correta: 2 },
{ pergunta: "Qual destas regiões brasileiras é a mais populosa?", opcoes: ["Sul", "Sudeste", "Norte", "Centro-Oeste"], correta: 1 },
{ pergunta: "O que significa a sigla ONU?", opcoes: ["Organização das Nações Unidas", "Ordem Nacional Unida", "Operação de Navegação Universal", "Ofício Nacional Unido"], correta: 0 },
{ pergunta: "Qual é o bioma mais seco do Brasil?", opcoes: ["Cerrado", "Caatinga", "Mata Atlântica", "Pantanal"], correta: 1 },
{ pergunta: "Qual é o país localizado totalmente dentro da África do Sul?", opcoes: ["Lesoto", "Sudão", "Uganda", "Namíbia"], correta: 0 },
{ pergunta: "Qual destas opções é um continente?", opcoes: ["Prata", "Ásia", "Havaí", "Groenlândia"], correta: 1 }
];
const perguntasGeografiaMedias = [
{ pergunta: "Qual é o nome dado ao movimento das placas que formam a crosta terrestre?", opcoes: ["Deriva continental", "Tectonismo", "Sedimentação", "Erosão"], correta: 1 },
{ pergunta: "Qual país possui o maior número de fusos horários?", opcoes: ["Rússia", "Estados Unidos", "China", "França"], correta: 0 },
{ pergunta: "A Linha Internacional da Data atravessa qual oceano?", opcoes: ["Atlântico", "Pacífico", "Índico", "Ártico"], correta: 1 },
{ pergunta: "O que caracteriza o clima equatorial?", opcoes: ["Seco e frio", "Altas temperaturas e muita chuva", "Quente e seco", "Frio e úmido"], correta: 1 },
{ pergunta: "A Cordilheira dos Andes foi formada por qual processo geológico?", opcoes: ["Soerguimento tectônico", "Vulcanismo", "Intemperismo", "Dobras e falhas"], correta: 3 },
{ pergunta: "Qual é o maior produtor de petróleo do mundo atualmente?", opcoes: ["Estados Unidos", "Arábia Saudita", "Rússia", "Irã"], correta: 0 },
{ pergunta: "O que é um aquífero?", opcoes: ["Lago artificial", "Reserva subterrânea de água", "Tipo de relevo", "Vulcão inativo"], correta: 1 },
{ pergunta: "Qual desses países NÃO faz parte do G7?", opcoes: ["Japão", "Alemanha", "Itália", "China"], correta: 3 },
{ pergunta: "Qual é a maior planície do mundo?", opcoes: ["Pampas", "Sibéria Ocidental", "Planície Amazônica", "Planície Indo-Gangética"], correta: 3 },
{ pergunta: "Qual cidade é conhecida pela maior concentração urbana do mundo?", opcoes: ["Nova York", "Xangai", "Tóquio", "Lagos"], correta: 2 },
{ pergunta: "Qual é o clima predominante no sertão nordestino?", opcoes: ["Tropical úmido", "Semiárido", "Equatorial", "Temperado"], correta: 1 },
{ pergunta: "Qual é o rio mais extenso da Europa?", opcoes: ["Danúbio", "Volga", "Reno", "Tâmisa"], correta: 1 },
{ pergunta: "A desertificação é mais comum em regiões com:", opcoes: ["Baixa pluviosidade", "Alta pluviosidade", "Solos férteis", "Vulcões ativos"], correta: 0 },
{ pergunta: "Qual é o continente com maior quantidade de países?", opcoes: ["Ásia", "África", "Europa", "Oceania"], correta: 1 },
{ pergunta: "O fenômeno El Niño provoca:", opcoes: ["Resfriamento do Pacífico", "Aquecimento anormal do Pacífico", "Aumento de furacões no Atlântico", "Diminuição das chuvas na Ásia"], correta: 1 },
{ pergunta: "Qual é a capital da Austrália?", opcoes: ["Sydney", "Melbourne", "Canberra", "Perth"], correta: 2 },
{ pergunta: "O que é um enclave?", opcoes: ["País dentro de outro", "Ilha isolada", "Cidade costeira", "Área montanhosa"], correta: 0 },
{ pergunta: "Qual é o maior país do Oriente Médio?", opcoes: ["Arábia Saudita", "Irã", "Iraque", "Turquia"], correta: 0 },
{ pergunta: "Qual oceano banha a costa leste da África?", opcoes: ["Pacífico", "Índico", "Atlântico", "Ártico"], correta: 1 },
{ pergunta: "O que representa as curvas de nível em um mapa?", opcoes: ["Vegetação", "Altitudes", "Clima", "População"], correta: 1 },
{ pergunta: "Qual país possui a maior fronteira com o Brasil?", opcoes: ["Bolívia", "Peru", "Argentina", "Venezuela"], correta: 0 },
{ pergunta: "Onde ocorreu o acidente nuclear de 1986?", opcoes: ["Three Mile Island", "Chernobyl", "Fukushima", "Sellafield"], correta: 1 },
{ pergunta: "O clima mediterrâneo é caracterizado por:", opcoes: ["Invernos secos e verões úmidos", "Invernos úmidos e verões secos", "Chuvas o ano inteiro", "Clima frio e seco"], correta: 1 },
{ pergunta: "O Sahel está localizado entre:", opcoes: ["Saara e Savana", "Mediterrâneo e Alpes", "Himalaia e Índia", "Andes e Amazônia"], correta: 0 },
{ pergunta: "Qual é o maior lago de água doce do mundo?", opcoes: ["Lago Vitória", "Lago Baikal", "Lago Michigan", "Lago Tanganica"], correta: 1 },
{ pergunta: "Qual país possui o maior PIB do mundo?", opcoes: ["China", "Estados Unidos", "Japão", "Alemanha"], correta: 1 },
{ pergunta: "A cidade de Istambul está localizada entre quais continentes?", opcoes: ["Europa e Ásia", "Ásia e África", "Europa e África", "África e Oceania"], correta: 0 },
{ pergunta: "Qual fenômeno natural forma os tsunamis?", opcoes: ["Tufões", "Terremotos submarinos", "Secas prolongadas", "Geadas"], correta: 1 },
{ pergunta: "Qual é o maior deserto quente do mundo?", opcoes: ["Saara", "Gobi", "Kalahari", "Atacama"], correta: 0 },
{ pergunta: "Qual país é formado por milhares de ilhas?", opcoes: ["Chile", "Indonésia", "Egito", "Noruega"], correta: 1 },
{ pergunta: "A Floresta Boreal também é chamada de:", opcoes: ["Taiga", "Tundra", "Pampas", "Cerrado"], correta: 0 },
{ pergunta: "O Aquífero Guarani abrange principalmente Brasil e:", opcoes: ["Chile", "Peru", "Bolívia", "Paraguai"], correta: 3 },
{ pergunta: "O que é o Pantanal?", opcoes: ["Um deserto", "Um bioma de savana", "Uma planície alagável", "Uma zona fria"], correta: 2 },
{ pergunta: "Qual é a capital da Índia?", opcoes: ["Nova Délhi", "Mumbai", "Bangalor", "Calcutá"], correta: 0 },
{ pergunta: "O escudo cristalino é formado principalmente por:", opcoes: ["Rochas ígneas e metamórficas", "Solos arenosos", "Sedimentos recentes", "Rochas vulcânicas"], correta: 0 },
{ pergunta: "Qual dessas regiões é conhecida como 'Crescente Fértil'?", opcoes: ["Himalaia", "Norte da África", "Oriente Médio", "Sul da Espanha"], correta: 2 },
{ pergunta: "O Canal do Panamá liga quais oceanos?", opcoes: ["Índico e Ártico", "Atlântico e Pacífico", "Pacífico e Índico", "Atlântico e Índico"], correta: 1 },
{ pergunta: "A Caatinga ocorre exclusivamente em:", opcoes: ["Portugal", "México", "Brasil", "Angola"], correta: 2 },
{ pergunta: "O Monte Kilimanjaro está localizado em:", opcoes: ["Egito", "Tanzânia", "Nigéria", "África do Sul"], correta: 1 },
{ pergunta: "Qual destes países NÃO faz fronteira com o Brasil?", opcoes: ["Suriname", "Colômbia", "Equador", "Uruguai"], correta: 2 },
{ pergunta: "A maior barreira de corais do mundo fica em:", opcoes: ["México", "Austrália", "Brasil", "Índia"], correta: 1 },
{ pergunta: "Qual destes países é conhecido pela formação de ciclones tropicais?", opcoes: ["Madagascar", "Índia", "Espanha", "Egito"], correta: 1 },
{ pergunta: "O que são megalópoles?", opcoes: ["Cidades pequenas", "Conjuntos de grandes áreas urbanas", "Áreas agrícolas", "Regiões montanhosas"], correta: 1 },
{ pergunta: "Qual rio atravessa o deserto do Saara?", opcoes: ["Nilo", "Níger", "Congo", "Zambeze"], correta: 0 },
{ pergunta: "Onde se localiza a Península Ibérica?", opcoes: ["América", "Ásia", "Europa", "África"], correta: 2 },
{ pergunta: "Qual destes países é uma monarquia parlamentarista?", opcoes: ["Estados Unidos", "Japão", "Brasil", "França"], correta: 1 },
{ pergunta: "O Himalaia se formou pelo choque entre:", opcoes: ["Índia e Eurásia", "China e África", "Europa e América", "Índia e Austrália"], correta: 0 },
{ pergunta: "Qual região brasileira possui o menor índice pluviométrico?", opcoes: ["Sul", "Norte", "Nordeste semiárido", "Sudeste"], correta: 2 },
{ pergunta: "Qual destes é um importante gás-estufa?", opcoes: ["Oxigênio", "Nitrogênio", "CO₂", "Hélio"], correta: 2 }
];
const perguntasGeografiaDificeis = [
{ pergunta: "Qual é o nome da teoria que explica a origem dos continentes a partir de uma única massa de terra chamada Pangeia?", opcoes: ["Tectonismo", "Deriva continental", "Orogenia", "Isostasia"], correta: 1 },
{ pergunta: "Qual país possui o maior litoral do mundo?", opcoes: ["Brasil", "Rússia", "Canadá", "Austrália"], correta: 2 },
{ pergunta: "O que é a 'Corrente do Golfo'?", opcoes: ["Corrente de águas frias no Pacífico", "Corrente quente no Atlântico Norte", "Corrente fria no Atlântico Sul", "Corrente quente no Índico"], correta: 1 },
{ pergunta: "Qual é o bioma dominante na região do Sahel?", opcoes: ["Deserto", "Savana", "Floresta tropical", "Tundra"], correta: 1 },
{ pergunta: "Qual placa tectônica está colidindo com a Placa Euroasiática e formando o Himalaia?", opcoes: ["Placa Indiana", "Placa Africana", "Placa Australiana", "Placa Arábica"], correta: 0 },
{ pergunta: "O maior sistema aquífero subterrâneo do mundo é:", opcoes: ["Aquífero Guarani", "Aquífero Alter do Chão", "Aquífero Núbio", "Aquífero Kalahari"], correta: 2 },
{ pergunta: "Qual é o nome do ponto mais profundo dos oceanos?", opcoes: ["Fossa de Tonga", "Fossa de Java", "Fossa das Marianas", "Fossa de Kermadec"], correta: 2 },
{ pergunta: "Qual é o tipo de rocha predominante na crosta continental?", opcoes: ["Basalto", "Granito", "Gnaisse", "Pedra-pomes"], correta: 1 },
{ pergunta: "Qual cidade é considerada a mais fria do mundo?", opcoes: ["Yakutsk", "Moscou", "Reykjavik", "Harbin"], correta: 0 },
{ pergunta: "Qual é o país mais montanhoso do mundo proporcionalmente?", opcoes: ["Nepal", "Suíça", "Peru", "Butão"], correta: 3 },
{ pergunta: "A descolonização da África ocorreu principalmente em qual período?", opcoes: ["Final do século XIX", "Entre 1950 e 1980", "Entre 1800 e 1850", "Após 2000"], correta: 1 },
{ pergunta: "O termo 'cinturão de fogo' refere-se a:", opcoes: ["Região com muitos tornados", "Região com atividade vulcânica intensa", "Área de queimadas na África", "Região com altas temperaturas"], correta: 1 },
{ pergunta: "Qual país europeu tem o maior número de vulcões ativos?", opcoes: ["Grécia", "Itália", "Islândia", "Turquia"], correta: 2 },
{ pergunta: "O processo de laterização ocorre principalmente em:", opcoes: ["Regiões frias", "Regiões desérticas", "Regiões tropicais úmidas", "Regiões temperadas"], correta: 2 },
{ pergunta: "O Estreito de Ormuz é estratégico para o transporte de:", opcoes: ["Soja", "Petrolíferos", "Minérios", "Carvão"], correta: 1 },
{ pergunta: "O que é permafrost?", opcoes: ["Camada de gelo permanente no solo", "Geada passageira", "Solo fértil de clima frio", "Depósito de água subterrânea"], correta: 0 },
{ pergunta: "Qual país africano possui a maior economia do continente?", opcoes: ["Egito", "Nigéria", "África do Sul", "Quênia"], correta: 1 },
{ pergunta: "O maior arquipélago do mundo é:", opcoes: ["Filipinas", "Indonésia", "Japão", "Nova Zelândia"], correta: 1 },
{ pergunta: "A cidade mais alta do mundo é:", opcoes: ["Lhasa", "La Paz", "El Alto", "Quito"], correta: 2 },
{ pergunta: "A ZCIT (Zona de Convergência Intertropical) influencia principalmente:", opcoes: ["Tempestades polares", "Regimes de monções", "Secas tropicais", "Auroras boreais"], correta: 1 },
{ pergunta: "O Mar Cáspio é classificado atualmente como:", opcoes: ["Oceano", "Golfo", "Lago", "Mar Interno"], correta: 2 },
{ pergunta: "Qual desses países NÃO faz parte da OPEP?", opcoes: ["Arábia Saudita", "Venezuela", "México", "Irã"], correta: 2 },
{ pergunta: "Qual é o nome dado ao processo de afundamento gradual de terras costeiras?", opcoes: ["Subsidência", "Transgressão marinha", "Erosão marítima", "Rebaixamento eólico"], correta: 0 },
{ pergunta: "O escudo Báltico está localizado principalmente em:", opcoes: ["Rússia", "Suécia", "Alemanha", "Reino Unido"], correta: 1 },
{ pergunta: "O que explica a formação do deserto do Atacama?", opcoes: ["Ventos fortes", "Sombra orográfica", "Correntes quentes", "Planícies elevadas"], correta: 1 },
{ pergunta: "O maior golfo do mundo é o Golfo de:", opcoes: ["Guiné", "México", "Bengala", "Califórnia"], correta: 2 },
{ pergunta: "Qual bacia hidrográfica possui o maior volume de água escoado?", opcoes: ["Mississípi-Missouri", "Congo", "Amazônica", "Yang-Tsé"], correta: 2 },
{ pergunta: "A fronteira mais militarizada do mundo fica entre:", opcoes: ["Coreia do Norte e Coreia do Sul", "Índia e Paquistão", "Israel e Palestina", "China e Taiwan"], correta: 0 },
{ pergunta: "O maior emissor de CO₂ per capita do mundo é:", opcoes: ["China", "Estados Unidos", "Austrália", "Qatar"], correta: 3 },
{ pergunta: "Qual país possui o maior consumo de água doce?", opcoes: ["Estados Unidos", "China", "Índia", "Brasil"], correta: 1 },
{ pergunta: "O que caracteriza uma corrente fria oceânica?", opcoes: ["Água quente ascendente", "Água fria vinda de altas latitudes", "Água quente vinda do Equador", "Água submarina vulcânica"], correta: 1 },
{ pergunta: "Qual é a principal causa do crescimento urbano nas megalópoles?", opcoes: ["Renda rural alta", "Êxodo rural", "Turismo elevado", "Mudança climática"], correta: 1 },
{ pergunta: "O Canal de Suez encurta a rota entre:", opcoes: ["Europa e Ásia", "América do Sul e África", "Oceania e América do Norte", "Europa e América"], correta: 0 },
{ pergunta: "O clima continental típico apresenta:", opcoes: ["Alta amplitude térmica", "Chuvas abundantes", "Temperatura estável", "Calor constante"], correta: 0 },
{ pergunta: "A maior cadeia montanhosa submarina é:", opcoes: ["Dorsal Mesoatlântica", "Dorsal do Pacífico", "Cadeia de Kermadec", "Cordoaria Indonésia"], correta: 0 },
{ pergunta: "Qual é o país com a menor densidade demográfica do mundo?", opcoes: ["Canadá", "Austrália", "Mongólia", "Groenlândia (Dinamarca)"], correta: 3 },
{ pergunta: "O bioma Tundra é encontrado em:", opcoes: ["Regiões temperadas", "Regiões tropicais", "Altas latitudes", "Ilhas oceânicas"], correta: 2 },
{ pergunta: "O maior produtor de cacau do mundo é:", opcoes: ["Brasil", "Nigéria", "Costa do Marfim", "Indonésia"], correta: 2 },
{ pergunta: "Qual destas cidades está localizada acima do Círculo Polar Ártico?", opcoes: ["Estocolmo", "Anchorage", "Murmansk", "Copenhague"], correta: 2 },
{ pergunta: "A principal consequência da desertificação é:", opcoes: ["Aumento da biodiversidade", "Perda de solos produtivos", "Aumento da umidade", "Resfriamento regional"], correta: 1 },
{ pergunta: "Qual país é o maior produtor mundial de energia eólica?", opcoes: ["Alemanha", "China", "Dinamarca", "Estados Unidos"], correta: 1 },
{ pergunta: "Qual é a maior ilha do mundo (não considerada continente)?", opcoes: ["Groenlândia", "Nova Guiné", "Borneo", "Madagascar"], correta: 0 },
{ pergunta: "Onde se localiza o Mar de Aral, que sofreu grande redução?", opcoes: ["China", "Rússia", "Cazaquistão e Uzbequistão", "Turquia"], correta: 2 },
{ pergunta: "O que são hotspots de biodiversidade?", opcoes: ["Regiões frias e secas", "Áreas extremamente povoadas", "Regiões ricas e ameaçadas", "Cidades altamente poluídas"], correta: 2 },
{ pergunta: "A Conurbação ocorre quando:", opcoes: ["Cidades rurais se formam", "Duas áreas urbanas se juntam", "Ocorre êxodo urbano", "Cidades diminuem"], correta: 1 },
{ pergunta: "Qual é o maior país da Península Arábica?", opcoes: ["Iêmen", "Omã", "Arábia Saudita", "Jordânia"], correta: 2 },
{ pergunta: "A Bacia do Congo é dominada por qual bioma?", opcoes: ["Savanas", "Floresta equatorial", "Deserto", "Tundra"], correta: 1 },
{ pergunta: "A Monção Indiana ocorre devido a:", opcoes: ["Correntes frias", "Diferença de pressão entre mar e continente", "Atividade vulcânica", "Elevação do nível do mar"], correta: 1 },
{ pergunta: "O ponto mais ao sul da América do Sul é:", opcoes: ["Ushuaia", "Ilha Horn", "Cabo das Agulhas", "Punta Arenas"], correta: 1 }
];

const perguntasCienciasFaceis = [
{ pergunta: "Qual órgão é responsável por bombear o sangue pelo corpo?", opcoes: ["Pulmões", "Rins", "Coração", "Fígado"], correta: 2 },
{ pergunta: "Qual é o principal gás que respiramos?", opcoes: ["Oxigênio", "Gás hélio", "Gás carbônico", "Nitrogênio puro"], correta: 0 },
{ pergunta: "A água ferve a quantos graus Celsius?", opcoes: ["50°C", "100°C", "120°C", "150°C"], correta: 1 },
{ pergunta: "Qual planeta é conhecido como 'Planeta Vermelho'?", opcoes: ["Vênus", "Júpiter", "Marte", "Mercúrio"], correta: 2 },
{ pergunta: "Qual é o maior órgão do corpo humano?", opcoes: ["Cérebro", "Pele", "Intestino", "Pulmão"], correta: 1 },
{ pergunta: "O que os seres vivos precisam para sobreviver?", opcoes: ["Água", "Plástico", "Areia", "Aço"], correta: 0 },
{ pergunta: "As plantas produzem seu próprio alimento por qual processo?", opcoes: ["Fotossíntese", "Digestão", "Respiração", "Digestão solar"], correta: 0 },
{ pergunta: "Qual destes animais é um mamífero?", opcoes: ["Cobra", "Golfinho", "Sapo", "Tubarão"], correta: 1 },
{ pergunta: "A camada de ozônio protege a Terra de:", opcoes: ["Ventos solares", "Radiação UV", "Meteoros", "Oxigênio"], correta: 1 },
{ pergunta: "Qual destes é um estado físico da água?", opcoes: ["Gasoso", "Plástico", "Metálico", "Radioativo"], correta: 0 },
{ pergunta: "O que é responsável pela cor verde das plantas?", opcoes: ["Clorofila", "Sal marinho", "Nitrogênio", "Enxofre"], correta: 0 },
{ pergunta: "A Terra gira em torno de qual astro?", opcoes: ["Lua", "Mercúrio", "Sol", "Vênus"], correta: 2 },
{ pergunta: "Qual é o satélite natural da Terra?", opcoes: ["Lua", "Fobos", "Titã", "Europa"], correta: 0 },
{ pergunta: "Qual parte da planta absorve água e minerais?", opcoes: ["Folhas", "Raiz", "Fruto", "Caule"], correta: 1 },
{ pergunta: "Os peixes respiram por meio de:", opcoes: ["Pulmões", "Pele", "Brânquias", "Espiráculos"], correta: 2 },
{ pergunta: "Qual é a força que nos mantém no chão?", opcoes: ["Magnetismo", "Atrito", "Gravidade", "Pressão"], correta: 2 },
{ pergunta: "O que os olhos captam?", opcoes: ["Som", "Luz", "Cheiro", "Calor"], correta: 1 },
{ pergunta: "Qual o nome do processo de transformar água líquida em vapor?", opcoes: ["Solidificação", "Evaporação", "Condensação", "Fusão"], correta: 1 },
{ pergunta: "O que os seres humanos inspiram para viver?", opcoes: ["Gás carbônico", "Hidrogênio", "Oxigênio", "Hélio"], correta: 2 },
{ pergunta: "A aranha é um:", opcoes: ["Inseto", "Aracnídeo", "Anfíbio", "Peixe"], correta: 1 },
{ pergunta: "O sangue circula no corpo humano através de:", opcoes: ["Veias e artérias", "Nervos", "Músculos", "Ossos"], correta: 0 },
{ pergunta: "Qual destes é um animal ovíparo?", opcoes: ["Cachorro", "Gato", "Galinha", "Vaca"], correta: 2 },
{ pergunta: "O que o estômago produz para ajudar na digestão?", opcoes: ["Suco gástrico", "Saliva", "Bile", "Ar"], correta: 0 },
{ pergunta: "O Sol é uma:", opcoes: ["Lua", "Estrela", "Nebulosa", "Galáxia"], correta: 1 },
{ pergunta: "Qual dessas doenças é causada por vírus?", opcoes: ["Covid-19", "Tétano", "Sarna", "Malária"], correta: 0 },
{ pergunta: "A fotossíntese libera qual gás?", opcoes: ["Nitrogênio", "Metano", "Gás carbônico", "Oxigênio"], correta: 3 },
{ pergunta: "Qual destes animais é um herbívoro?", opcoes: ["Leão", "Tigre", "Elefante", "Coruja"], correta: 2 },
{ pergunta: "Onde ocorre a respiração celular?", opcoes: ["Mitocôndria", "Citoplasma", "Cloroplasto", "Núcleo"], correta: 0 },
{ pergunta: "A água que bebemos é composta por:", opcoes: ["H e O", "C e O", "H e N", "N e O"], correta: 0 },
{ pergunta: "Qual destes animais é um invertebrado?", opcoes: ["Girafa", "Caracol", "Cavalo", "Tartaruga"], correta: 1 },
{ pergunta: "O ser humano tem quantos pulmões?", opcoes: ["1", "2", "3", "4"], correta: 1 },
{ pergunta: "O sistema responsável pelos movimentos do corpo é o:", opcoes: ["Digestório", "Muscular", "Circulatório", "Endócrino"], correta: 1 },
{ pergunta: "Qual é o órgão responsável pela filtração do sangue?", opcoes: ["Coração", "Rins", "Fígado", "Estômago"], correta: 1 },
{ pergunta: "Qual desses objetos NÃO é atraído por um ímã?", opcoes: ["Ferro", "Aço", "Níquel", "Plástico"], correta: 3 },
{ pergunta: "Como se chama o bebê da vaca?", opcoes: ["Bezerro", "Filhote", "Cabrito", "Cordeiro"], correta: 0 },
{ pergunta: "O que causa o dia e a noite?", opcoes: ["A translação", "A rotação da Terra", "Movimento da Lua", "Mudança de estações"], correta: 1 },
{ pergunta: "Qual desses astros não emite luz própria?", opcoes: ["Estrela", "Sol", "Planeta", "Cometa"], correta: 2 },
{ pergunta: "O mosquito da dengue transmite qual vírus?", opcoes: ["HIV", "H1N1", "Dengue", "Sarampo"], correta: 2 },
{ pergunta: "O arco-íris acontece por causa da:", opcoes: ["Refração da luz", "Rotação da Terra", "Reflexão do som", "Pressão do ar"], correta: 0 },
{ pergunta: "Qual destes é um animal carnívoro?", opcoes: ["Cavalo", "Girafa", "Lobo", "Coala"], correta: 2 },
{ pergunta: "O que é matéria?", opcoes: ["Tudo que ocupa espaço e tem massa", "Som", "Luz", "Calor"], correta: 0 },
{ pergunta: "As plantas absorvem gás carbônico para produzir:", opcoes: ["Frutas", "Água", "Ossos", "Seu alimento"], correta: 3 },
{ pergunta: "Qual sistema controla as ações involuntárias do corpo?", opcoes: ["Digestório", "Nervoso", "Respiratório", "Urinário"], correta: 1 },
{ pergunta: "Qual planeta é o maior do Sistema Solar?", opcoes: ["Terra", "Júpiter", "Saturno", "Netuno"], correta: 1 },
{ pergunta: "Como se chama o processo de transformar vapor em água líquida?", opcoes: ["Evaporação", "Condensação", "Sublimação", "Fusão"], correta: 1 },
{ pergunta: "Onde se localiza nosso DNA?", opcoes: ["Mitocôndria", "Cérebro", "Núcleo das células", "Pulmões"], correta: 2 },
{ pergunta: "Qual destes é um exemplo de adaptação animal?", opcoes: ["Penas de aves para voar", "Falar inglês", "Construir casas", "Dirigir carros"], correta: 0 },
{ pergunta: "O que os pulmões absorvem do ar?", opcoes: ["Hélio", "Ozônio", "Gás carbônico", "Oxigênio"], correta: 3 },
{ pergunta: "Qual é o maior planeta gasoso?", opcoes: ["Urano", "Júpiter", "Netuno", "Saturno"], correta: 1 }
];
const perguntasCienciasMedias = [
{ pergunta: "Qual é o principal órgão responsável pela produção de insulina?", opcoes: ["Pâncreas", "Fígado", "Rim", "Baço"], correta: 0 },
{ pergunta: "Qual é a função principal dos glóbulos vermelhos?", opcoes: ["Combater infecções", "Transportar oxigênio", "Produzir hormônios", "Filtrar impurezas"], correta: 1 },
{ pergunta: "Qual é o nome da molécula que armazena energia nas células?", opcoes: ["ATP", "DNA", "RNA", "Glicose"], correta: 0 },
{ pergunta: "Qual gás é mais abundante na atmosfera?", opcoes: ["Oxigênio", "Nitrogênio", "Gás carbônico", "Argônio"], correta: 1 },
{ pergunta: "Qual fenômeno explica a formação das estações do ano?", opcoes: ["Rotação da Terra", "Translação da Terra", "Inclinação da Lua", "Magnetismo Solar"], correta: 1 },
{ pergunta: "A camada de ozônio se encontra em qual parte da atmosfera?", opcoes: ["Troposfera", "Estratosfera", "Exosfera", "Ionosfera"], correta: 1 },
{ pergunta: "Os fungos se reproduzem principalmente por:", opcoes: ["Esporos", "Sementes", "Gemas", "Raízes"], correta: 0 },
{ pergunta: "Qual é o nome do pigmento responsável pela cor da pele humana?", opcoes: ["Clorofila", "Hemoglobina", "Melanina", "Caroteno"], correta: 2 },
{ pergunta: "Como se chama o organismo que produz seu próprio alimento?", opcoes: ["Heterótrofo", "Parasita", "Autótrofo", "Decompositor"], correta: 2 },
{ pergunta: "A principal função dos rins é:", opcoes: ["Bombear sangue", "Filtrar o sangue", "Ajudar na digestão", "Regular o batimento cardíaco"], correta: 1 },
{ pergunta: "Qual é a unidade básica da vida?", opcoes: ["Molécula", "Célula", "Tecido", "Órgão"], correta: 1 },
{ pergunta: "O que é fotossíntese?", opcoes: ["Processo de respiração", "Produção de energia pela luz", "Digestão química", "Fermentação"], correta: 1 },
{ pergunta: "O som é transmitido através de:", opcoes: ["Vácuo", "Matéria", "Luz", "Buracos negros"], correta: 1 },
{ pergunta: "O sangue rico em oxigênio é chamado de:", opcoes: ["Pobre", "Arterial", "Venoso", "Plasmático"], correta: 1 },
{ pergunta: "Qual é o maior planeta do Sistema Solar?", opcoes: ["Terra", "Júpiter", "Marte", "Saturno"], correta: 1 },
{ pergunta: "Qual órgão produz a bile?", opcoes: ["Pâncreas", "Fígado", "Estômago", "Baço"], correta: 1 },
{ pergunta: "O que é uma cadeia alimentar?", opcoes: ["Lista de animais", "Sequência de alimentação entre seres vivos", "Mapa de ecossistemas", "Lista de nutrientes"], correta: 1 },
{ pergunta: "Qual destes animais é um vertebrado?", opcoes: ["Caranguejo", "Polvo", "Sapo", "Inseto"], correta: 2 },
{ pergunta: "O que mede a sismologia?", opcoes: ["Vulcões", "Terremotos", "Marés", "Tsunamis"], correta: 1 },
{ pergunta: "Qual o nome do processo onde o calor se espalha pelo ar?", opcoes: ["Condução", "Convecção", "Radiação", "Fusão"], correta: 1 },
{ pergunta: "As baleias são classificadas como:", opcoes: ["Peixes", "Répteis", "Mamíferos", "Anfíbios"], correta: 2 },
{ pergunta: "A água é formada por quais elementos?", opcoes: ["Na e Cl", "H e O", "Fe e O", "C e H"], correta: 1 },
{ pergunta: "Quem desenvolveu a teoria da evolução?", opcoes: ["Einstein", "Darwin", "Newton", "Pasteur"], correta: 1 },
{ pergunta: "Os terremotos geralmente ocorrem devido ao movimento das:", opcoes: ["Nuvens", "Placas tectônicas", "Marés", "Correntes de ar"], correta: 1 },
{ pergunta: "Como se chama o processo de perda de água pelas plantas?", opcoes: ["Fotossíntese", "Transpiração", "Evaporação", "Respiração"], correta: 1 },
{ pergunta: "O DNA é encontrado em qual parte da célula?", opcoes: ["Cloroplasto", "Ribossomo", "Núcleo", "Citoplasma"], correta: 2 },
{ pergunta: "A febre é uma resposta do corpo para:", opcoes: ["Digestão", "Luta contra infecções", "Relaxamento muscular", "Aumentar pressão"], correta: 1 },
{ pergunta: "A velocidade do som é maior em:", opcoes: ["Gases", "Líquidos", "Sólidos", "Vácuo"], correta: 2 },
{ pergunta: "Qual é o nome dado aos animais que vivem na água e na terra?", opcoes: ["Répteis", "Anfíbios", "Aves", "Insetos"], correta: 1 },
{ pergunta: "A eletricidade é medida em:", opcoes: ["Volts", "Watts", "Ohms", "Joules"], correta: 0 },
{ pergunta: "Os seres vivos que decompõem matéria morta são chamados de:", opcoes: ["Predadores", "Decompositores", "Parasitas", "Herbívoros"], correta: 1 },
{ pergunta: "Qual é o planeta mais próximo do Sol?", opcoes: ["Terra", "Marte", "Mercúrio", "Vênus"], correta: 2 },
{ pergunta: "O que acontece com a água quando congela?", opcoes: ["Evapora", "Expandese", "Encolhe", "Perde massa"], correta: 1 },
{ pergunta: "Um eclipse solar ocorre quando:", opcoes: ["A Lua fica atrás da Terra", "A Lua fica entre a Terra e o Sol", "O Sol fica entre a Terra e a Lua", "A Terra passa atrás do Sol"], correta: 1 },
{ pergunta: "O que é um ecossistema?", opcoes: ["Um conjunto de seres vivos e ambiente", "Um tipo de solo", "Um clima", "Um rio"], correta: 0 },
{ pergunta: "Os raios são causados por:", opcoes: ["Calor excessivo", "Descargas elétricas", "Rotação da Terra", "Pressão atmosférica"], correta: 1 },
{ pergunta: "Qual é a função da clorofila?", opcoes: ["Transportar oxigênio", "Captar luz solar", "Produzir hormônios", "Quebrar glicose"], correta: 1 },
{ pergunta: "Qual parte da célula é responsável pela produção de energia?", opcoes: ["Ribossomo", "Mitocôndria", "Lisossomo", "Núcleo"], correta: 1 },
{ pergunta: "A luz se propaga em:", opcoes: ["Ondas", "Linhas retas", "Espirais", "Círculos"], correta: 1 },
{ pergunta: "O ciclo da água NÃO inclui:", opcoes: ["Evaporação", "Condensação", "Precipitação", "Filtragem artificial"], correta: 3 },
{ pergunta: "A hemoglobina está presente:", opcoes: ["Nos glóbulos vermelhos", "No plasma", "Nos glóbulos brancos", "Nos músculos"], correta: 0 },
{ pergunta: "Qual destes materiais é isolante térmico?", opcoes: ["Metal", "Madeira", "Aço", "Alumínio"], correta: 1 },
{ pergunta: "Os vírus são considerados:", opcoes: ["Seres vivos completos", "Aclométricos", "Acelulares", "Reprodutores independentes"], correta: 2 },
{ pergunta: "Qual é a camada mais externa da Terra?", opcoes: ["Manto", "Crosta", "Núcleo externo", "Núcleo interno"], correta: 1 },
{ pergunta: "Qual é a principal função das plaquetas?", opcoes: ["Carregar oxigênio", "Coagulação do sangue", "Combater vírus", "Enviar sinais nervosos"], correta: 1 },
{ pergunta: "O vento é causado pela:", opcoes: ["Rochas quentes", "Diferença de pressão do ar", "Luz solar", "Poluição"], correta: 1 },
{ pergunta: "A energia solar é um tipo de energia:", opcoes: ["Não renovável", "Fóssil", "Renovável", "Mineral"], correta: 2 },
{ pergunta: "Qual elemento químico é essencial para os ossos?", opcoes: ["Carbono", "Cálcio", "Ferro", "Hélio"], correta: 1 },
{ pergunta: "O pulmão esquerdo é menor que o direito porque:", opcoes: ["É defeituoso", "Protege o coração", "Tem menos vasos", "Produz mais ar"], correta: 1 }
];
const perguntasCienciasDificeis = [
{ pergunta: "Qual organela é responsável pela síntese de proteínas?", opcoes: ["Ribossomos", "Mitocôndrias", "Lisossomos", "Complexo de Golgi"], correta: 0 },
{ pergunta: "Qual processo celular resulta na formação de gametas?", opcoes: ["Mitose", "Meiose", "Apopitose", "Fagocitose"], correta: 1 },
{ pergunta: "O grupo de bactérias que vive em condições extremas é denominado:", opcoes: ["Protozoários", "Arqueias", "Cianobactérias", "Actinomicetos"], correta: 1 },
{ pergunta: "Qual molécula atua como principal aceptor final de elétrons na respiração celular?", opcoes: ["CO₂", "H₂O", "O₂", "ATP"], correta: 2 },
{ pergunta: "Qual estrutura controla a entrada e saída de substâncias na célula?", opcoes: ["Citoplasma", "Núcleo", "Membrana plasmática", "Mitocôndria"], correta: 2 },
{ pergunta: "A fotossíntese ocorre principalmente em qual organela?", opcoes: ["Ribossomo", "Cloroplasto", "Lisossomo", "Núcleo"], correta: 1 },
{ pergunta: "As ondas sísmicas P e S se propagam através de:", opcoes: ["Somente líquidos", "Somente sólidos", "Sólidos e líquidos", "Apenas gases"], correta: 2 },
{ pergunta: "Na tabela periódica, qual elemento é o maior contribuinte para o efeito estufa humano?", opcoes: ["CO₂", "CH₄", "N₂O", "O₃"], correta: 0 },
{ pergunta: "Qual é o nome da teoria que explica a origem do universo?", opcoes: ["Criacionismo", "Teoria do Caos", "Big Bang", "Singularidade Forçada"], correta: 2 },
{ pergunta: "Qual parte do neurônio transmite impulsos elétricos?", opcoes: ["Dendritos", "Corpo celular", "Axônio", "Núcleo"], correta: 2 },
{ pergunta: "Quais estruturas são responsáveis pela respiração celular?", opcoes: ["Mitocôndrias", "Cloroplastos", "Ribossomos", "Lisossomos"], correta: 0 },
{ pergunta: "Como se chama a camada parcialmente derretida do manto terrestre?", opcoes: ["Astenosfera", "Litosfera", "Mesosfera", "Crosta"], correta: 0 },
{ pergunta: "Qual é o nome da proteína que transporta oxigênio no sangue?", opcoes: ["Insulina", "Hemoglobina", "Actina", "Amilase"], correta: 1 },
{ pergunta: "Qual destes NÃO é um tipo de RNA?", opcoes: ["mRNA", "tRNA", "sRNA", "rRNA"], correta: 2 },
{ pergunta: "A Ley de Hess está associada a qual área da ciência?", opcoes: ["Biologia", "Química", "Astronomia", "Geologia"], correta: 1 },
{ pergunta: "O pH do sangue humano gira em torno de:", opcoes: ["3.0", "5.5", "7.4", "9.2"], correta: 2 },
{ pergunta: "Qual fenômeno físico explica o arco-íris?", opcoes: ["Difração", "Refração", "Interferência", "Polarização"], correta: 1 },
{ pergunta: "Qual hormônio é produzido pela glândula tireoide?", opcoes: ["Adrenalina", "Insulina", "Tiroxina", "Cortisol"], correta: 2 },
{ pergunta: "O que caracteriza um organismo homeotérmico?", opcoes: ["Vive na água", "Controla temperatura interna", "Não possui coluna vertebral", "Se reproduz assexuadamente"], correta: 1 },
{ pergunta: "O ciclo de Krebs ocorre em qual parte da célula?", opcoes: ["Citoplasma", "Mitocôndria", "Núcleo", "Complexo de Golgi"], correta: 1 },
{ pergunta: "A radiação ultravioleta é prejudicial principalmente por causar:", opcoes: ["Hipertensão", "Mutação no DNA", "Anemia", "Desidratação"], correta: 1 },
{ pergunta: "A teoria celular afirma que:", opcoes: ["A célula é eterna", "Todos os seres vivos são formados por células", "As células surgem espontaneamente", "A célula não possui função estrutural"], correta: 1 },
{ pergunta: "Qual é o nome do processo que converte nitrogênio atmosférico em amônia?", opcoes: ["Fixação biológica", "Fotossíntese", "Nitrificação", "Denitrificação"], correta: 0 },
{ pergunta: "A doença escorbuto é causada pela falta de:", opcoes: ["Vitamina B12", "Vitamina C", "Vitamina D", "Vitamina E"], correta: 1 },
{ pergunta: "Qual é a função dos ribossomos?", opcoes: ["Gerar energia", "Produzir proteínas", "Armazenar água", "Reparar DNA"], correta: 1 },
{ pergunta: "Em qual camada da Terra ocorrem os vulcões?", opcoes: ["Núcleo", "Crosta", "Exosfera", "Astenosfera"], correta: 1 },
{ pergunta: "Qual é a estrutura responsável pelo transporte de seiva elaborada nas plantas?", opcoes: ["Xilema", "Floema", "Estômato", "Caulículo"], correta: 1 },
{ pergunta: "Qual é a unidade usada para medir frequência?", opcoes: ["Joule", "Hertz", "Newton", "Pascal"], correta: 1 },
{ pergunta: "A hemofilia é um tipo de:", opcoes: ["Doença infecciosa", "Doença genética", "Alergia", "Parasita sanguíneo"], correta: 1 },
{ pergunta: "Qual estrutura protege o encéfalo?", opcoes: ["Caixa torácica", "Crânio", "Coluna vertebral", "Pelve"], correta: 1 },
{ pergunta: "O que são mutações genéticas?", opcoes: ["Troca de órgãos", "Alterações no DNA", "Troca de cromossomos", "Fusão celular"], correta: 1 },
{ pergunta: "A teoria da deriva continental foi proposta por:", opcoes: ["Hess", "Wegener", "Newton", "Galileu"], correta: 1 },
{ pergunta: "A energia liberada pelas estrelas é produzida por:", opcoes: ["Fissão nuclear", "Fusão nuclear", "Combustão", "Oxidação"], correta: 1 },
{ pergunta: "Qual destes planetas tem maior densidade?", opcoes: ["Júpiter", "Saturno", "Terra", "Urano"], correta: 2 },
{ pergunta: "Os anticorpos são produzidos por:", opcoes: ["Hemácias", "Linfócitos B", "Plaquetas", "Neurônios"], correta: 1 },
{ pergunta: "O que significa 'ecosistema clímax'?", opcoes: ["Primeira fase sucessional", "Etapa final de estabilidade", "Ambiente destruído", "Área com poucos seres vivos"], correta: 1 },
{ pergunta: "O que a teoria endossimbiótica explica?", opcoes: ["Origem da vida", "Origem das organelas", "Formação dos planetas", "Dinâmica de populações"], correta: 1 },
{ pergunta: "A zona mais profunda dos oceanos é chamada de:", opcoes: ["Nerítica", "Abissal", "Batipelágica", "Afótica"], correta: 1 },
{ pergunta: "Em qual parte do cérebro está o cerebelo?", opcoes: ["Diencéfalo", "Tronco encefálico", "Encéfalo inferior", "Cérebro posterior"], correta: 3 },
{ pergunta: "Qual é a principal característica dos sais minerais?", opcoes: ["São orgânicos", "Não fornecem energia", "São energéticos", "São hormônios"], correta: 1 },
{ pergunta: "O que caracteriza uma reação endotérmica?", opcoes: ["Libera calor", "Absorve calor", "Não troca calor", "Fica neutra"], correta: 1 },
{ pergunta: "Quais são os produtos da respiração celular?", opcoes: ["O₂ + ATP", "CO₂ + H₂O + ATP", "Glicose + água", "CO₂ + glicose"], correta: 1 },
{ pergunta: "Em qual fase da mitose ocorre a separação das cromátides irmãs?", opcoes: ["Metáfase", "Anáfase", "Telófase", "Prófase"], correta: 1 },
{ pergunta: "Qual é o nome da lei que relaciona pressão e volume dos gases?", opcoes: ["Lei de Coulomb", "Lei de Boyle", "Lei de Hess", "Lei de Dalton"], correta: 1 },
{ pergunta: "Os ecossistemas com menor biodiversidade são:", opcoes: ["Florestas equatoriais", "Tundras", "Campos tropicais", "Manguezais"], correta: 1 },
{ pergunta: "O ferro é importante para qual função?", opcoes: ["Visão", "Coagulação", "Transporte de oxigênio", "Memória"], correta: 2 },
{ pergunta: "O efeito estufa natural é:", opcoes: ["Sempre prejudicial", "Essencial para a vida", "Causado apenas por humanos", "O mesmo que aquecimento global"], correta: 1 },
{ pergunta: "Qual gás é liberado na fermentação alcoólica?", opcoes: ["CO₂", "O₂", "H₂", "N₂"], correta: 0 },
{ pergunta: "O permafrost é encontrado em:", opcoes: ["Desertos", "Regiões polares", "Florestas tropicais", "Montanhas jovens"], correta: 1 },
{ pergunta: "A teoria da seleção natural afirma que:", opcoes: ["Todos sobrevivem", "Apenas os mais adaptados sobrevivem", "A evolução é aleatória", "Os mais fracos evoluem mais rápido"], correta: 1 }
];

const perguntasFisicaFaceis = [
{ pergunta: "Qual é a unidade de força no SI?", opcoes: ["Watt", "Pascal", "Newton", "Joule"], correta: 2 },
{ pergunta: "A velocidade é definida como:", opcoes: ["Espaço × tempo", "Espaço ÷ tempo", "Tempo ÷ espaço", "Força ÷ massa"], correta: 1 },
{ pergunta: "Um carro mantém velocidade constante. A força resultante é:", opcoes: ["Maior que zero", "Menor que zero", "Igual a zero", "Dependente da massa"], correta: 2 },
{ pergunta: "A aceleração da gravidade na Terra vale aproximadamente:", opcoes: ["4,9 m/s²", "9,8 m/s²", "15 m/s²", "1 m/s²"], correta: 1 },
{ pergunta: "Energia cinética depende de:", opcoes: ["Apenas da altura", "Apenas da massa", "Massa e velocidade", "Peso e força"], correta: 2 },
{ pergunta: "Qual grandeza mede a oposição à passagem da corrente elétrica?", opcoes: ["Potência", "Tensão", "Resistência", "Carga"], correta: 2 },
{ pergunta: "A unidade de frequência é:", opcoes: ["Newton", "Coulomb", "Hertz", "Pascal"], correta: 2 },
{ pergunta: "Ondas sonoras são classificadas como:", opcoes: ["Transversais", "Longitudinais", "Eletromagnéticas", "Luminosas"], correta: 1 },
{ pergunta: "Qual é a fórmula da velocidade média?", opcoes: ["Δs/Δt", "m·a", "E/t", "F·d"], correta: 0 },
{ pergunta: "A lei de Ohm é expressa por:", opcoes: ["U = R/I", "U = I/R", "U = R·I", "U = P·I"], correta: 2 },
{ pergunta: "Qual fenômeno explica o arco-íris?", opcoes: ["Difração", "Refração", "Reflexão", "Interferência"], correta: 1 },
{ pergunta: "Um corpo está em repouso. Isso significa que sua velocidade é:", opcoes: ["Constante e diferente de zero", "Variável", "Igual a zero", "Indefinida"], correta: 2 },
{ pergunta: "A densidade é calculada por:", opcoes: ["m·V", "m/V", "V/m", "m²·V"], correta: 1 },
{ pergunta: "Qual partícula tem carga negativa?", opcoes: ["Próton", "Nêutron", "Elétron", "Fóton"], correta: 2 },
{ pergunta: "A pressão é definida como:", opcoes: ["Força × área", "Área ÷ força", "Força ÷ área", "Massa × área"], correta: 2 },
{ pergunta: "O som se propaga mais rápido em:", opcoes: ["Sólidos", "Líquidos", "Gases", "Vácuo"], correta: 0 },
{ pergunta: "Qual é a unidade de trabalho (energia) no SI?", opcoes: ["Watt", "Joule", "Newton", "Ampere"], correta: 1 },
{ pergunta: "Um espelho convexo forma imagens sempre:", opcoes: ["Reais e invertidas", "Virtuais e direitas", "Reais e maiores", "Virtuais e invertidas"], correta: 1 },
{ pergunta: "Potência elétrica é definida como:", opcoes: ["I·V", "R·V", "R·I²", "V²·I"], correta: 0 },
{ pergunta: "A luz é um tipo de onda:", opcoes: ["Mecânica", "Longitudinal", "Transversal eletromagnética", "Longitudinal mecânica"], correta: 2 },
{ pergunta: "A lei da inércia foi proposta por:", opcoes: ["Einstein", "Newton", "Galileu", "Hubble"], correta: 1 },
{ pergunta: "A dilatação térmica ocorre devido ao:", opcoes: ["Aumento do peso", "Aumento da energia interna", "Redução da densidade", "Ação da gravidade"], correta: 1 },
{ pergunta: "A unidade de campo elétrico é:", opcoes: ["N/C", "J/kg", "W/m", "A·s"], correta: 0 },
{ pergunta: "A força magnética atua sobre cargas que estão:", opcoes: ["Paradas", "Em movimento", "Neutras", "No vácuo"], correta: 1 },
{ pergunta: "Um corpo em queda livre tem:", opcoes: ["Aceleração constante", "Velocidade constante", "Força resultante zero", "Aceleração variável"], correta: 0 },
{ pergunta: "Fenômeno em que a onda muda de direção ao passar para outro meio:", opcoes: ["Reflexão", "Refração", "Difração", "Interferência"], correta: 1 },
{ pergunta: "O vácuo não permite a propagação de:", opcoes: ["Luz", "Ondas de rádio", "Som", "Micro-ondas"], correta: 2 },
{ pergunta: "O momento linear é dado por:", opcoes: ["m·v", "m·a", "v/a", "F·t"], correta: 0 },
{ pergunta: "A capacidade térmica depende de:", opcoes: ["Massa", "Temperatura", "Volume", "Velocidade"], correta: 0 },
{ pergunta: "O átomo é composto por:", opcoes: ["Somente prótons", "Prótons, nêutrons e elétrons", "Somente elétrons", "Somente nêutrons"], correta: 1 },
{ pergunta: "A força elástica segue a lei:", opcoes: ["Hooke", "Faraday", "Ampere", "Hubble"], correta: 0 },
{ pergunta: "Trabalho nulo ocorre quando:", opcoes: ["Força e deslocamento são perpendiculares", "Força e deslocamento têm mesma direção", "Não há atrito", "A velocidade é zero"], correta: 0 },
{ pergunta: "A energia potencial gravitacional depende de:", opcoes: ["Velocidade", "Altura", "Aceleração", "Força centrípeta"], correta: 1 },
{ pergunta: "Carga elétrica é medida em:", opcoes: ["Coulomb", "Newton", "Watt", "Pascal"], correta: 0 },
{ pergunta: "A força centrípeta aponta para:", opcoes: ["Fora do círculo", "Centro da trajetória", "Sentido contrário ao movimento", "Tangente ao círculo"], correta: 1 },
{ pergunta: "Circuitos em série têm:", opcoes: ["Corrente igual em todos os pontos", "Tensões iguais em todos os pontos", "Resistência zero", "Grande potência"], correta: 0 },
{ pergunta: "O que é calor?", opcoes: ["Forma de energia em trânsito", "Energia encerrada no corpo", "Temperatura", "Trabalho mecânico"], correta: 0 },
{ pergunta: "A lei de Coulomb trata de:", opcoes: ["Força elétrica", "Força magnética", "Força gravitacional", "Potência elétrica"], correta: 0 },
{ pergunta: "Qual partícula é responsável pela carga positiva?", opcoes: ["Elétron", "Nêutron", "Próton", "Glúon"], correta: 2 },
{ pergunta: "A velocidade da luz é aproximadamente:", opcoes: ["300 km/s", "300.000 km/s", "300 m/s", "30.000 km/s"], correta: 1 },
{ pergunta: "A pressão aumenta quando a área:", opcoes: ["Aumenta", "Diminui", "Se mantém", "Não influencia"], correta: 1 },
{ pergunta: "Um corpo flutua quando sua densidade é:", opcoes: ["Maior que o fluido", "Menor que o fluido", "Igual ao fluido", "Independe"], correta: 1 },
{ pergunta: "A energia interna está relacionada a:", opcoes: ["Velocidade do corpo", "Movimento das moléculas", "Pressão externa", "Luz"], correta: 1 },
{ pergunta: "Um espelho plano forma imagens:", opcoes: ["Reais e maiores", "Virtuais e do mesmo tamanho", "Reais e menores", "Virtuais e invertidas"], correta: 1 },
{ pergunta: "A força peso é calculada por:", opcoes: ["m·v", "m·g", "g/v", "F·d"], correta: 1 },
{ pergunta: "O índice de refração depende de:", opcoes: ["Cor da luz", "Velocidade da luz no meio", "Temperatura apenas", "Pressão atmosférica"], correta: 1 },
{ pergunta: "O efeito Doppler ocorre quando:", opcoes: ["Há mudança na amplitude", "Há movimento relativo entre fonte e observador", "Há interferência", "Há reflexão"], correta: 1 },
{ pergunta: "Para eletrizar um corpo por atrito, é necessário:", opcoes: ["Aquecê-lo", "Esfriá-lo", "Friccioná-lo com outro", "Aterramento"], correta: 2 },
{ pergunta: "O transformador elétrico altera:", opcoes: ["Corrente e tensão", "Carga elétrica", "Temperatura", "Polaridade"], correta: 0 },
{ pergunta: "O torque está relacionado a:", opcoes: ["Força linear", "Rotação", "Pressão", "Densidade"], correta: 1 }
];
const perguntasFisicaMedias = [
{ pergunta: "A força centrípeta atua sempre:", opcoes: ["Para o centro da trajetória", "No sentido da velocidade", "Para fora da curva", "Contra o peso"], correta: 0 },
{ pergunta: "A unidade de resistência elétrica é:", opcoes: ["Watt", "Ohm", "Volt", "Ampere"], correta: 1 },
{ pergunta: "A energia cinética depende de:", opcoes: ["Temperatura", "Volume", "Velocidade", "Pressão"], correta: 2 },
{ pergunta: "O atrito estático é:", opcoes: ["Sempre menor que o cinético", "Sempre maior que o cinético", "Igual ao cinético", "Independente da superfície"], correta: 1 },
{ pergunta: "O que a 2ª Lei de Newton relaciona?", opcoes: ["Força e aceleração", "Massa e volume", "Energia e potência", "Velocidade e pressão"], correta: 0 },
{ pergunta: "A pressão aumenta quando:", opcoes: ["A área aumenta", "A força diminui", "A área diminui", "A velocidade aumenta"], correta: 2 },
{ pergunta: "A densidade é a razão entre:", opcoes: ["Massa e volume", "Força e aceleração", "Velocidade e tempo", "Potência e trabalho"], correta: 0 },
{ pergunta: "O que caracteriza o movimento uniformemente variado?", opcoes: ["Velocidade constante", "Aceleração constante", "Força zero", "Inércia nula"], correta: 1 },
{ pergunta: "A unidade de frequência é:", opcoes: ["Hertz", "Newton", "Pascal", "Joule"], correta: 0 },
{ pergunta: "A força peso é calculada por:", opcoes: ["m/v", "m·g", "m+a", "m−g"], correta: 1 },
{ pergunta: "O trabalho é positivo quando a força está:", opcoes: ["Oposta ao deslocamento", "Perpendicular ao deslocamento", "A favor do deslocamento", "Nula"], correta: 2 },
{ pergunta: "O empuxo é causado por:", opcoes: ["Calor", "Densidade da água", "Gravidade", "Pressão do fluido"], correta: 3 },
{ pergunta: "O momento linear depende de:", opcoes: ["Massa e velocidade", "Altura e tempo", "Força e área", "Volume e temperatura"], correta: 0 },
{ pergunta: "A dilatação térmica ocorre por:", opcoes: ["Aumento de energia cinética", "Perda de massa", "Mudança química", "Compressão do ar"], correta: 0 },
{ pergunta: "O vetor deslocamento depende de:", opcoes: ["Distância percorrida", "Posição inicial e final", "Velocidade média", "Energia total"], correta: 1 },
{ pergunta: "A potência elétrica é calculada por:", opcoes: ["V/I", "I·V", "V−I", "I−R"], correta: 1 },
{ pergunta: "A reflexão ocorre quando a luz:", opcoes: ["Muda de meio", "É absorvida", "Retorna ao meio de origem", "Se divide em dois raios"], correta: 2 },
{ pergunta: "O que define uma onda transversal?", opcoes: ["Oscila paralela à propagação", "Oscila perpendicular à propagação", "É mecânica", "É sonora"], correta: 1 },
{ pergunta: "A força de atrito depende de:", opcoes: ["Área de contato", "Coeficiente de atrito e normal", "Velocidade da superfície", "Densidade"], correta: 1 },
{ pergunta: "A energia potencial gravitacional aumenta com:", opcoes: ["Altura", "Massa negativa", "Atrito", "Área"], correta: 0 },
{ pergunta: "O som é uma onda:", opcoes: ["Transversal", "Eletromagnética", "Longitudinal", "Estacionária"], correta: 2 },
{ pergunta: "A lei de Coulomb descreve a força:", opcoes: ["Gravitacional", "Magnética", "Elétrica", "Térmica"], correta: 2 },
{ pergunta: "A carga elementar é:", opcoes: ["1,6×10^-19 C", "3×10^8 m/s", "9,8 m/s²", "6,02×10^23"], correta: 0 },
{ pergunta: "O campo magnético é produzido por:", opcoes: ["Luz", "Corrente elétrica", "Temperatura", "Energia nuclear"], correta: 1 },
{ pergunta: "A resistência equivalente em série é:", opcoes: ["Igual à menor resistência", "Produto das resistências", "Soma das resistências", "Diferença das resistências"], correta: 2 },
{ pergunta: "O calor específico indica:", opcoes: ["A temperatura inicial", "A energia para aquecer 1 g em 1°C", "A densidade do corpo", "A massa total"], correta: 1 },
{ pergunta: "Ondas mecânicas precisam de:", opcoes: ["Vácuo", "Ar", "Luz", "Um meio material"], correta: 3 },
{ pergunta: "O peso varia com:", opcoes: ["A altura", "O planeta", "A massa", "A pressão"], correta: 1 },
{ pergunta: "No MRU a velocidade é:", opcoes: ["Variável", "Constante", "Nula", "Negativa"], correta: 1 },
{ pergunta: "O período de uma onda é o inverso da:", opcoes: ["Amplitude", "Frequência", "Velocidade", "Fase"], correta: 1 },
{ pergunta: "A corrente alternada:", opcoes: ["Não varia no tempo", "Troca de sentido periodicamente", "É igual a corrente contínua", "Não depende de tensão"], correta: 1 },
{ pergunta: "O campo elétrico aponta no sentido:", opcoes: ["Do negativo para o positivo", "Do positivo para o negativo", "Perpendicular às cargas", "Contrário à força"], correta: 1 },
{ pergunta: "A energia mecânica é:", opcoes: ["Cinética + potencial", "Calor total", "Trabalho por tempo", "Deslocamento por massa"], correta: 0 },
{ pergunta: "A lei dos gases ideais relaciona:", opcoes: ["T, P e V", "T, massa, energia", "P, densidade, calor", "Massa e temperatura"], correta: 0 },
{ pergunta: "O impulso corresponde a:", opcoes: ["Força × tempo", "Velocidade × massa", "Força × distância", "Pressão × volume"], correta: 0 },
{ pergunta: "A refração ocorre quando a luz:", opcoes: ["É absorvida", "É refletida", "Muda de meio", "É polarizada"], correta: 2 },
{ pergunta: "O atrito cinético atua:", opcoes: ["Antes do movimento", "Durante o movimento", "Após parar", "Sem contato"], correta: 1 },
{ pergunta: "A velocidade da luz no vácuo é:", opcoes: ["3×10^8 m/s", "9,8 m/s²", "1,6×10^-19 C", "340 m/s"], correta: 0 },
{ pergunta: "O capacitor armazena:", opcoes: ["Energia elétrica", "Força", "Calor", "Momento"], correta: 0 },
{ pergunta: "O campo gravitacional da Terra é:", opcoes: ["Igual ao do Sol", "Nulo", "Radial", "Cúbico"], correta: 2 },
{ pergunta: "A lei da conservação da energia afirma que:", opcoes: ["A energia se perde", "A energia se transforma", "A energia é destruída", "A energia aumenta sozinha"], correta: 1 },
{ pergunta: "A força normal é perpendicular à:", opcoes: ["Velocidade", "Superfície", "Gravidade", "Massa"], correta: 1 },
{ pergunta: "O calor é transferido por:", opcoes: ["Condução, convecção e radiação", "Pressão e volume", "Carga e massa", "Densidade e força"], correta: 0 },
{ pergunta: "A intensidade do campo magnético aumenta com:", opcoes: ["Diminuição da corrente", "Aumento da corrente", "Velocidade do som", "Volume"], correta: 1 },
{ pergunta: "A frequência de uma onda depende de:", opcoes: ["Fonte emissora", "Meio", "Altura", "Amplitude"], correta: 0 },
{ pergunta: "A dilatação dos sólidos depende de:", opcoes: ["Coeficiente de dilatação", "Pressão da água", "Condutividade elétrica", "Polarização"], correta: 0 },
{ pergunta: "O que é força resultante?", opcoes: ["Soma vetorial das forças", "Força maior apenas", "Menor força aplicada", "Força perpendicular"], correta: 0 },
{ pergunta: "O momento de uma força depende de:", opcoes: ["Raio e força", "Energia e massa", "Velocidade", "Calor"], correta: 0 },
{ pergunta: "A velocidade média é:", opcoes: ["ΔS/Δt", "m·g", "P·V", "I·R"], correta: 0 },
{ pergunta: "O campo elétrico de uma carga puntiforme varia com:", opcoes: ["1/r²", "r²", "1/r³", "r³"], correta: 0 }
];
const perguntasFisicaDificeis = [
{ pergunta: "A equação de movimento harmônico simples é:", opcoes: ["x = A cos(ωt + φ)", "F = m * a", "E = m * c²", "v = Δs / Δt"], correta: 0 },
{ pergunta: "O período de um pêndulo simples depende de:", opcoes: ["Comprimento e gravidade", "Massa e altura", "Velocidade inicial e tempo", "Amplitude e massa"], correta: 0 },
{ pergunta: "A frequência angular é dada por:", opcoes: ["ω = 2πf", "f = ω²", "ω = f / 2π", "ω = v / r"], correta: 0 },
{ pergunta: "O que acontece com a energia de um oscilador amortecido?", opcoes: ["Diminui com o tempo", "Permanece constante", "Aumenta com o tempo", "Oscila entre zero e máxima"], correta: 0 },
{ pergunta: "Qual é a condição para ressonância?", opcoes: ["Frequência externa igual à natural do sistema", "Força constante aplicada", "Amplitude zero", "Frequência dupla da natural"], correta: 0 },
{ pergunta: "A velocidade de propagação de uma onda em corda depende de:", opcoes: ["Tensão e densidade linear", "Amplitude e frequência", "Massa do objeto", "Comprimento da corda"], correta: 0 },
{ pergunta: "O teorema de Bernoulli aplica-se a:", opcoes: ["Fluidos incompressíveis em escoamento estacionário", "Corpos rígidos", "Gases ideais em compressão", "Osciladores harmônicos"], correta: 0 },
{ pergunta: "A equação de continuidade dos fluidos diz que:", opcoes: ["A1v1 = A2v2", "pV = nRT", "F = ma", "P = F/A"], correta: 0 },
{ pergunta: "O efeito Doppler descreve:", opcoes: ["Mudança de frequência percebida pelo movimento relativo", "Refringência da luz", "Difração de ondas", "Interferência de ondas"], correta: 0 },
{ pergunta: "A intensidade sonora é proporcional a:", opcoes: ["Quadrado da amplitude da onda", "Amplitude linear", "Frequência", "Comprimento de onda"], correta: 0 },
{ pergunta: "O que é a energia de ligação nuclear?", opcoes: ["Energia necessária para separar núcleos", "Energia de movimento de partículas", "Energia elétrica armazenada", "Energia mecânica"], correta: 0 },
{ pergunta: "A equação de Schrödinger descreve:", opcoes: ["Função de onda de partículas quânticas", "Velocidade de partículas clássicas", "Força gravitacional", "Energia cinética"], correta: 0 },
{ pergunta: "O princípio de incerteza de Heisenberg afirma:", opcoes: ["Não se pode medir posição e momento com precisão absoluta", "Energia total é constante", "Força e aceleração são proporcionais", "Velocidade é constante"], correta: 0 },
{ pergunta: "O que é difração?", opcoes: ["Desvio de ondas ao encontrar obstáculo ou fenda", "Reflexão em espelho", "Absorção de luz", "Polarização"], correta: 0 },
{ pergunta: "O que é interferência construtiva?", opcoes: ["Ondas se somam aumentando a amplitude", "Ondas se anulam", "Ondas se refletem", "Ondas se propagam em direções opostas"], correta: 0 },
{ pergunta: "A lei de Faraday-Lenz indica:", opcoes: ["Corrente induzida se opõe à variação do fluxo magnético", "Força elétrica é proporcional à carga", "Energia é conservada", "Pressão depende da profundidade"], correta: 0 },
{ pergunta: "O que é corrente de Foucault?", opcoes: ["Correntes induzidas em condutores devido a campo magnético variável", "Corrente contínua em fios", "Força magnética", "Fluxo elétrico"], correta: 0 },
{ pergunta: "O que é spin de uma partícula?", opcoes: ["Momento angular intrínseco quântico", "Velocidade de rotação clássica", "Massa multiplicada por velocidade", "Energia cinética"], correta: 0 },
{ pergunta: "O que é efeito Hall?", opcoes: ["Diferença de potencial transversal em condutor com corrente e campo magnético", "Reflexão de ondas", "Difração de luz", "Oscilação de partículas"], correta: 0 },
{ pergunta: "O que é radiação de corpo negro?", opcoes: ["Radiação emitida por um corpo em equilíbrio térmico", "Reflexão de luz", "Condução térmica", "Energia potencial"], correta: 0 },
{ pergunta: "A constante de Planck é usada para:", opcoes: ["Quantizar energia", "Medir força", "Calcular pressão", "Medir massa"], correta: 0 },
{ pergunta: "O que é decaimento radioativo?", opcoes: ["Transformação espontânea de núcleos instáveis", "Aumento de energia cinética", "Movimento de elétrons", "Condução de calor"], correta: 0 },
{ pergunta: "O que mede a Lei de Stefan-Boltzmann?", opcoes: ["Potência irradiada por unidade de área de um corpo negro", "Velocidade de ondas", "Força elétrica", "Energia cinética"], correta: 0 },
{ pergunta: "O que é entropia?", opcoes: ["Medida de desordem em um sistema", "Energia potencial", "Força por área", "Momento linear"], correta: 0 },
{ pergunta: "O que é capacitância?", opcoes: ["Capacidade de armazenar carga elétrica", "Intensidade de corrente", "Resistência elétrica", "Energia cinética"], correta: 0 },
{ pergunta: "A força de Lorentz é:", opcoes: ["F = q(v × B)", "F = m * a", "F = G * m1 * m2 / r²", "F = P / A"], correta: 0 },
{ pergunta: "O que é indutância?", opcoes: ["Propriedade de gerar fem induzida quando corrente varia", "Resistência elétrica", "Energia cinética", "Capacidade de armazenar carga"], correta: 0 },
{ pergunta: "O que é torque magnético?", opcoes: ["τ = μ × B", "τ = r × F", "τ = I * α", "τ = F / A"], correta: 0 },
{ pergunta: "A condição para estabilidade de órbita em mecânica celeste é:", opcoes: ["Força centrípeta igual à força gravitacional", "Energia cinética zero", "Aceleração nula", "Velocidade angular zero"], correta: 0 },
{ pergunta: "O que é efeito fotoelétrico?", opcoes: ["Emissão de elétrons ao incidir luz sobre metal", "Reflexão da luz", "Absorção de calor", "Polarização"], correta: 0 },
{ pergunta: "O que é dualidade onda-partícula?", opcoes: ["Partículas podem se comportar como ondas e vice-versa", "Somente partículas possuem massa", "Somente ondas transferem energia", "Luz é sempre onda"], correta: 0 },
{ pergunta: "O que é momento de inércia?", opcoes: ["Resistência de um corpo à rotação", "Energia cinética", "Força centrípeta", "Velocidade angular"], correta: 0 },
{ pergunta: "O que é précessão de um giroscópio?", opcoes: ["Mudança lenta do eixo de rotação", "Aceleração tangencial", "Força centrípeta", "Oscilação harmônica"], correta: 0 },
{ pergunta: "O que é radiação gama?", opcoes: ["Radiação eletromagnética de alta energia", "Radiação de calor", "Energia cinética", "Luz visível"], correta: 0 },
{ pergunta: "O que é espalhamento Compton?", opcoes: ["Mudança de comprimento de onda da radiação ao interagir com elétron", "Refração da luz", "Interferência de ondas", "Difração"], correta: 0 },
{ pergunta: "O que é spin quântico?", opcoes: ["Momento angular intrínseco das partículas", "Velocidade de rotação", "Momento linear", "Energia cinética"], correta: 0 },
{ pergunta: "O que é radiação de Cherenkov?", opcoes: ["Emissão de luz por partículas em meio com velocidade maior que a luz no meio", "Refração de luz", "Absorção de radiação", "Difração de ondas"], correta: 0 },
{ pergunta: "O que mede a equação de Navier-Stokes?", opcoes: ["Escoamento de fluidos viscosos", "Força centrípeta", "Energia cinética", "Momento linear"], correta: 0 },
{ pergunta: "O que é efeito Zeeman?", opcoes: ["Divisão de linhas espectrais por campo magnético", "Interferência de luz", "Difração de ondas", "Polarização"], correta: 0 },
{ pergunta: "O que é princípio de superposição?", opcoes: ["Soma das amplitudes de ondas sobrepostas", "Soma de forças", "Soma de energias cinéticas", "Soma de momentos lineares"], correta: 0 },
{ pergunta: "O que é velocidade de grupo de uma onda?", opcoes: ["Velocidade de propagação da envelope da onda", "Velocidade das cristas", "Velocidade instantânea", "Velocidade angular"], correta: 0 },
{ pergunta: "O que é comprimento de onda?", opcoes: ["Distância entre duas cristas consecutivas", "Amplitude máxima", "Frequência vezes período", "Energia da onda"], correta: 0 },
{ pergunta: "O que é coerência de uma onda?", opcoes: ["Manutenção de fase constante entre ondas", "Variação de amplitude", "Mudança de direção", "Difração"], correta: 0 },
{ pergunta: "O que é radiação de Hawking?", opcoes: ["Emissão de partículas por buracos negros", "Radiação visível", "Radiação térmica", "Ondas sonoras"], correta: 0 },
{ pergunta: "O que é princípio da incerteza de Heisenberg?", opcoes: ["Não se pode medir posição e momento com precisão absoluta", "Energia é conservada", "Velocidade é constante", "Força é proporcional à massa"], correta: 0 },
{ pergunta: "O que é massa relativística?", opcoes: ["Massa aparente de um corpo quando se aproxima da velocidade da luz", "Massa real", "Massa constante", "Energia cinética"], correta: 0 },
{ pergunta: "O que é dilatação do tempo relativística?", opcoes: ["Tempo medido em movimento parece mais lento", "Tempo absoluto", "Tempo acelerado", "Tempo igual para todos"], correta: 0 },
{ pergunta: "O que é contração do comprimento relativística?", opcoes: ["Corpo em movimento parece menor na direção do movimento", "Corpo aumenta de tamanho", "Corpo permanece igual", "Corpo se distorce lateralmente"], correta: 0 },
{ pergunta: "O que é energia de ponto zero?", opcoes: ["Energia mínima que um sistema quântico pode ter", "Energia cinética", "Energia potencial", "Energia térmica"], correta: 0 }
];

const perguntasQuimicaFaceis = [
{pergunta:"A água é composta por quais elementos?",opcoes:["Hélio e Neônio","Carbono e Hidrogênio","Hidrogênio e Oxigênio","Nitrogênio e Enxofre"],correta:2},
{pergunta:"Qual é o estado físico do vapor?",opcoes:["Sólido","Gasoso","Líquido","Plasma"],correta:1},
{pergunta:"Qual é o símbolo químico do Oxigênio?",opcoes:["O","X","Og","Ox"],correta:0},
{pergunta:"Qual partícula possui carga negativa?",opcoes:["Próton","Nêutron","Elétron","Íon"],correta:2},
{pergunta:"O sal de cozinha é principalmente composto por:",opcoes:["NaCl","H2SO4","CO2","HCl"],correta:0},
{pergunta:"Qual é o pH da água pura aproximadamente?",opcoes:["3","7","10","1"],correta:1},
{pergunta:"Átomos de um mesmo elemento possuem o mesmo:",opcoes:["Número de massa","Número atômico","Número de nêutrons","Volume"],correta:1},
{pergunta:"O gás essencial à respiração humana é:",opcoes:["CO2","CH4","O2","N2"],correta:2},
{pergunta:"A mudança do estado sólido para líquido é chamada de:",opcoes:["Sublimação","Condensação","Fusão","Solidificação"],correta:2},
{pergunta:"Os metais conduzem bem:",opcoes:["Calor e eletricidade","Som e luz","Água e óleo","Gases e vapores"],correta:0},
{pergunta:"Qual é a fórmula da glicose?",opcoes:["C6H12O6","CH4","C2H6","CO"],correta:0},
{pergunta:"O símbolo H representa:",opcoes:["Hélio","Hidrogênio","Háfnio","Mercúrio"],correta:1},
{pergunta:"Qual é o estado físico do gelo?",opcoes:["Gasoso","Líquido","Sólido","Plasma"],correta:2},
{pergunta:"A tabela periódica organiza os elementos por:",opcoes:["Massa","Número atômico","Densidade","Tamanho"],correta:1},
{pergunta:"CO2 é conhecido como:",opcoes:["Monóxido de carbono","Cloro","Dióxido de carbono","Ozônio"],correta:2},
{pergunta:"Qual destes é um gás nobre?",opcoes:["Argônio","Hidrogênio","Nitrogênio","Oxigênio"],correta:0},
{pergunta:"A água ferve a aproximadamente:",opcoes:["0°C","50°C","100°C","200°C"],correta:2},
{pergunta:"Qual elemento é fundamental na formação de compostos orgânicos?",opcoes:["Carbono","Silício","Sódio","Cloro"],correta:0},
{pergunta:"A fórmula do ácido clorídrico é:",opcoes:["HCl","H2O","H2SO4","HNO3"],correta:0},
{pergunta:"Uma mistura homogênea também é chamada de:",opcoes:["Solução","Suspensão","Coloide","Espuma"],correta:0},
{pergunta:"O gás hélio é usado principalmente em:",opcoes:["Balões","Extintores","Combustíveis","Baterias"],correta:0},
{pergunta:"O ponto de fusão é a temperatura em que:",opcoes:["Sólido vira gás","Gás vira sólido","Sólido vira líquido","Líquido vira sólido"],correta:2},
{pergunta:"O símbolo Fe representa:",opcoes:["Ferro","Flúor","Fenol","Frâncio"],correta:0},
{pergunta:"A combustão necessita de:",opcoes:["Água","Areia","Oxigênio","Cloro"],correta:2},
{pergunta:"O Na representa qual elemento?",opcoes:["Níquel","Neônio","Sódio","Nitrato"],correta:2},
{pergunta:"Qual propriedade descreve a quantidade de matéria?",opcoes:["Volume","Temperatura","Massa","Densidade"],correta:2},
{pergunta:"Qual destes é um metal alcalino?",opcoes:["Sódio","Cobre","Mercúrio","Carbono"],correta:0},
{pergunta:"A fórmula da água oxigenada é:",opcoes:["H2O2","H2O","HO","O2H"],correta:0},
{pergunta:"Qual partícula possui carga positiva?",opcoes:["Próton","Nêutron","Elétron","Cátion"],correta:0},
{pergunta:"Qual desses é um ácido forte?",opcoes:["HCl","H2CO3","H2O","NH3"],correta:0},
{pergunta:"O álcool presente em bebidas é:",opcoes:["Metanol","Etanol","Isopropanol","Glicerol"],correta:1},
{pergunta:"A fórmula do amoníaco é:",opcoes:["NH3","NO2","N2O","NH4"],correta:0},
{pergunta:"A corrosão do ferro forma:",opcoes:["Ferrugem","Prata","Bronze","Vidro"],correta:0},
{pergunta:"O cloro é usado para:",opcoes:["Purificar água","Adoçar alimentos","Fabricar vidro","Produzir gasolina"],correta:0},
{pergunta:"Qual destes é um halogênio?",opcoes:["Iodo","Argônio","Cálcio","Hélio"],correta:0},
{pergunta:"O gás que as plantas liberam na fotossíntese é:",opcoes:["CO","O2","H2","N2"],correta:1},
{pergunta:"O símbolo K representa:",opcoes:["Criptônio","Potássio","Prata","Cromo"],correta:1},
{pergunta:"O ácido sulfúrico é representado por:",opcoes:["H2SO4","H2S","HSO3","SO2"],correta:0},
{pergunta:"O termo 'aq' indica que a substância está:",opcoes:["No sólido","No gás","Em solução aquosa","No plasma"],correta:2},
{pergunta:"O número atômico indica a quantidade de:",opcoes:["Prótons","Nêutrons","Elétrons totais","Moléculas"],correta:0},
{pergunta:"Substâncias simples são formadas por:",opcoes:["Um único elemento","Dois elementos","Três elementos","Quatro elementos"],correta:0},
{pergunta:"A evaporação transforma:",opcoes:["Líquido em sólido","Sólido em gás","Líquido em gás","Gás em líquido"],correta:2},
{pergunta:"H2 é a molécula do:",opcoes:["Hélio","Hidrogênio","Háfnio","Hidreto"],correta:1},
{pergunta:"A fórmula do gás ozônio é:",opcoes:["O2","O3","O4","O"],correta:1},
{pergunta:"Qual destas não é uma mistura?",opcoes:["Ouro 24k","Ar","Água salgada","Gasolina"],correta:0},
{pergunta:"A densidade é dada por:",opcoes:["m/v","v/m","m·v","v+m"],correta:0},
{pergunta:"A água é um:",opcoes:["Composto","Elemento","Metal","Gás nobre"],correta:0},
{pergunta:"O pH indica:",opcoes:["Acidez","Densidade","Massa","Molaridade"],correta:0},
{pergunta:"A eletronegatividade mede a:",opcoes:["Atração por elétrons","Massa do átomo","Densidade","Solubilidade"],correta:0},
{pergunta:"Qual destes é combustível?",opcoes:["Álcool","Areia","Sal","Gelo"],correta:0},

];   
const perguntasQuimicaMedias = [
{pergunta:"O que é uma ligação iônica?",opcoes:["Compartilhamento de elétrons","Perda e ganho de elétrons","Força entre moléculas polares","Ligação entre metais"],correta:1},
{pergunta:"A molécula de NH3 possui geometria:",opcoes:["Linear","Angular","Piramidal","Tetraédrica"],correta:2},
{pergunta:"A concentração em mol/L é chamada de:",opcoes:["Densidade","Molaridade","Normalidade","Molalidade"],correta:1},
{pergunta:"Qual força intermolecular é predominante na água?",opcoes:["London","Dipolo induzido","Ligação de hidrogênio","Dipolo permanente"],correta:2},
{pergunta:"O ácido acético é representado por:",opcoes:["HCOOH","CH3COOH","HNO3","HCl"],correta:1},
{pergunta:"O que caracteriza um ácido segundo Arrhenius?",opcoes:["Libera OH-","Libera H+","Diminui o pH","Aumenta o pH"],correta:1},
{pergunta:"A soma de prótons e nêutrons define o:",opcoes:["Número atômico","Coeficiente","Número de massa","Estado físico"],correta:2},
{pergunta:"A ligação entre moléculas apolares ocorre principalmente por:",opcoes:["Dipolo permanente","Ligação de hidrogênio","Forças de London","Forças iônicas"],correta:2},
{pergunta:"Hidrólise é:",opcoes:["Perda de água","Formação de água","Ruptura com água","Reação exotérmica"],correta:2},
{pergunta:"Uma solução saturada é aquela que:",opcoes:["Não dissolve nada","Tem o máximo dissolvido","Dissolve ainda mais soluto","É sempre líquida"],correta:1},
{pergunta:"A reação de combustão completa produz:",opcoes:["CO","CO2 e H2O","C e H2","N2 e H2"],correta:1},
{pergunta:"A oxidação corresponde a:",opcoes:["Ganho de elétrons","Perda de elétrons","Aumento de pH","Formação de sais"],correta:1},
{pergunta:"A polaridade de uma molécula depende de:",opcoes:["Massa","Geometria e eletronegatividade","Estado físico","Coeficiente angular"],correta:1},
{pergunta:"Um catalisador altera:",opcoes:["Energia dos reagentes","Energia dos produtos","Energia de ativação","Equilíbrio químico"],correta:2},
{pergunta:"O que é isotopia?",opcoes:["Átomos iguais que ganham elétrons","Átomos com mesmo Z e diferente A","Átomos com mesmo A e diferente Z","Moléculas iônicas"],correta:1},
{pergunta:"Qual destes é um solvente polar?",opcoes:["Benzeno","Água","Hexano","Tolueno"],correta:1},
{pergunta:"A equação balanceada de combustão do metano é:",opcoes:["CH4 + O2 → CO2 + H2O","CH4 + 2O2 → CO2 + 2H2O","CH4 + O2 → C + H2O","CH4 + 3O2 → H2O"],correta:1},
{pergunta:"O pH é logaritmo inverso da concentração de:",opcoes:["OH-","H+","H2O","Sais"],correta:1},
{pergunta:"A estequiometria estuda:",opcoes:["Temperatura de fusão","Relações de massa na reação","Mudança de estado físico","Velocidade do som"],correta:1},
{pergunta:"O gás responsável pelo efeito estufa em maior quantidade é:",opcoes:["CO2","CH4","N2O","O3"],correta:0},
{pergunta:"O cloro apresenta quantos elétrons na camada de valência?",opcoes:["5","6","7","8"],correta:2},
{pergunta:"A pressão é definida como:",opcoes:["Força/Velocidade","Força/Área","Massa/Volume","Volume/Força"],correta:1},
{pergunta:"O ponto de ebulição aumenta quando a pressão:",opcoes:["Diminui","Aumenta","Oscila","Zera"],correta:1},
{pergunta:"Uma solução tampão:",opcoes:["Varia muito o pH","Mantém o pH estável","É sempre ácida","É sempre básica"],correta:1},
{pergunta:"A fórmula do íon sulfato é:",opcoes:["SO3^2-","SO4^2-","SO2","S2O"],correta:1},
{pergunta:"A curva de solubilidade relaciona soluto com:",opcoes:["Temperatura","Pressão","Massa","Volume"],correta:0},
{pergunta:"A eletrólise consiste na:",opcoes:["Dissolução de metais","Decomposição por corrente elétrica","Aumento de temperatura","Formação de íons por calor"],correta:2},
{pergunta:"O ácido sulfúrico é um ácido:",opcoes:["Monoprótico","Diprótico","Triprótico","Sem prótons"],correta:1},
{pergunta:"O que define uma base forte?",opcoes:["Solubilidade","Alta dissociação","Baixo pH","Cor vermelha"],correta:1},
{pergunta:"As reações endotérmicas:",opcoes:["Liberam calor","Absorvem calor","Não trocam calor","Viramsólidas"],correta:1},
{pergunta:"O número de Avogadro representa:",opcoes:["1 mol de partículas","1 mol de massa","1 mol de volume","1 mol de eletricidade"],correta:0},
{pergunta:"A gasolina é uma mistura:",opcoes:["Homogênea","Heterogênea","Iônica","Metálica"],correta:0},
{pergunta:"O gás responsável pelo buraco da camada de ozônio é:",opcoes:["CO","CO2","CFC","H2"],correta:2},
{pergunta:"Na neutralização, ácido + base formam:",opcoes:["Ácido","Base","Sal e água","CO2"],correta:2},
{pergunta:"A energia de ativação é a:",opcoes:["Energia dos produtos","Energia mínima para reagir","Energia térmica do sistema","Energia de equilíbrio"],correta:1},
{pergunta:"Sais resultam da:",opcoes:["Combustão","Neutralização","Dissociação","Sublimação"],correta:1},
{pergunta:"A fórmula do nitrato é:",opcoes:["NO2^-","NO3^-","N2O","NH4+"],correta:1},
{pergunta:"A dureza da água é causada por íons:",opcoes:["Na+ e K+","Ca2+ e Mg2+","Cl- e Br-","Fe2+ e Fe3+"],correta:1},
{pergunta:"A entalpia é uma grandeza relacionada à:",opcoes:["Energia térmica","Energia mecânica","Carga elétrica","Pressão absoluta"],correta:0},
{pergunta:"A velocidade de reação aumenta com:",opcoes:["Baixa temperatura","Alta temperatura","pH 0","Ausência de colisões"],correta:1},
{pergunta:"A fórmula do ácido nítrico é:",opcoes:["HNO2","HNO3","H3NO","NO3H"],correta:1},
{pergunta:"O carbono tem quantas ligações possíveis?",opcoes:["2","3","4","5"],correta:2},
{pergunta:"O metanol é:",opcoes:["CH3OH","C2H5OH","C3H7OH","C4H9OH"],correta:0},
{pergunta:"Os alcenos possuem ligação:",opcoes:["Simples","Dupla","Tripla","Nenhuma"],correta:1},
{pergunta:"A pressão parcial é a pressão:",opcoes:["Do sistema inteiro","De um componente do gás","Da água","Do recipiente"],correta:1},
{pergunta:"As bases de Arrhenius liberam:",opcoes:["H2","H+","OH-","O2"],correta:2},
{pergunta:"A solubilidade do gás aumenta com:",opcoes:["Aumento da temperatura","Diminuição da pressão","Aumento da pressão","Vácuo"],correta:2},
{pergunta:"A ligação metálica é caracterizada por:",opcoes:["Elétrons livres","Perda de prótons","Ganho de íons","Forças dipolo"],correta:0},
{pergunta:"A fermentação produz:",opcoes:["CO2 e etanol","NH3 e H2O","CO e H2","H2SO4"],correta:0},
];
const perguntasQuimicaDificeis = [
{pergunta:"A constante de equilíbrio Kp é usada quando as substâncias estão no estado:",opcoes:["Gasoso","Líquido","Sólido","Aquoso"],correta:0},
{pergunta:"A reação que possui ΔG negativo é:",opcoes:["Não espontânea","Espontânea","Isotérmica","Adiabática"],correta:1},
{pergunta:"O aumento da entropia está associado a:",opcoes:["Maior ordem","Menor aleatoriedade","Maior desordem","Maior rigidez"],correta:2},
{pergunta:"O potencial padrão de redução indica:",opcoes:["Capacidade de oxidar","Capacidade de reduzir","Capacidade de ionizar","Capacidade de sublimar"],correta:1},
{pergunta:"A teoria de Lewis define ácidos como:",opcoes:["Doadores de elétrons","Receptores de elétrons","Doadores de prótons","Receptores de prótons"],correta:1},
{pergunta:"A energia mínima para uma colisão efetiva é chamada de:",opcoes:["Energia térmica","Energia de ativação","Energia fundamental","Energia atômica"],correta:1},
{pergunta:"O pKa baixo indica um ácido:",opcoes:["Fraco","Neutro","Forte","Instável"],correta:2},
{pergunta:"A variação de entalpia é medida em:",opcoes:["kg","Joules","Litros","Watt"],correta:1},
{pergunta:"A eletronegatividade aumenta:",opcoes:["De cima para baixo","Da esquerda para direita","Da direita para esquerda","De baixo para cima"],correta:1},
{pergunta:"O NO2 apresenta geometria:",opcoes:["Linear","Angular","Tetraédrica","Trigonal"],correta:1},
{pergunta:"Complexos metálicos possuem ligantes que funcionam como:",opcoes:["Ácidos de Lewis","Bases de Arrhenius","Bases de Lewis","Sais dissolvidos"],correta:2},
{pergunta:"A equação de Nernst relaciona potencial com:",opcoes:["Massa","Temperatura","Pressão","Volume"],correta:1},
{pergunta:"O processo que separa substâncias baseado no ponto de ebulição é:",opcoes:["Cristalização","Destilação","Eletrólise","Decantação"],correta:1},
{pergunta:"A hibridização do carbono no etino é:",opcoes:["sp","sp2","sp3","sp3d"],correta:0},
{pergunta:"O benzano apresenta ligações:",opcoes:["Simples","Simples e duplas alternadas","Apenas duplas","Tripla e simples"],correta:1},
{pergunta:"A lei de Henry relaciona solubilidade do gás com:",opcoes:["pH","Pressão parcial","Temperatura do solvente","Volume do gás"],correta:1},
{pergunta:"O calor de formação padrão é definido a:",opcoes:["25°C e 1 atm","50°C e 2 atm","0°C e 1 atm","100°C e 1 atm"],correta:0},
{pergunta:"A isomeria ótica depende de um carbono:",opcoes:["Metálico","Assimétrico","Aromático","Ramificado"],correta:1},
{pergunta:"O fenômeno de quiralidade está ligado à:",opcoes:["Simetria plana","Ausência de espelhamento","Assimetria molecular","Presença de íons"],correta:2},
{pergunta:"As reações de substituição ocorrem principalmente em compostos:",opcoes:["Aromáticos","Alcinos","Alcenos","Sais"],correta:0},
{pergunta:"A energia de ligação aumenta quando a ligação é:",opcoes:["Mais longa","Mais fraca","Mais curta","Mais polar"],correta:2},
{pergunta:"A teoria VSEPR explica:",opcoes:["Velocidade de reação","Geometria molecular","Energia térmica","Forças nucleares"],correta:1},
{pergunta:"O equilíbrio químico é atingido quando:",opcoes:["A reação para","As velocidades se igualam","Os reagentes acabam","Os produtos dominam"],correta:1},
{pergunta:"Em reações endotérmicas, o calor é:",opcoes:["Expelido","Absorvido","Estável","Irradiado"],correta:1},
{pergunta:"O efeito estérico influencia:",opcoes:["Temperatura","Acesso ao sítio reacional","Estado físico","Pressão"],correta:1},
{pergunta:"A constante de velocidade muda com:",opcoes:["pH","Temperatura","Massa molar","Pureza"],correta:1},
{pergunta:"O efeito Tyndall ocorre em:",opcoes:["Soluções","Sistemas aquosos","Coloides","Metais"],correta:2},
{pergunta:"Os complexos octaédricos apresentam quantos ligantes?",opcoes:["2","4","6","8"],correta:2},
{pergunta:"A solubilidade de um sal aumenta em solventes:",opcoes:["Apolares","Polares","Gasosos","Sólidos"],correta:1},
{pergunta:"A lei dos gases ideais ignora:",opcoes:["Temperatura","Interações intermoleculares","Volume","Pressão"],correta:1},
{pergunta:"Os haletos de alquila sofrem principalmente:",opcoes:["Adição","Substituição","Eliminação","Combustão"],correta:2},
{pergunta:"O reagente de Tollens identifica:",opcoes:["Ácidos","Aldeídos","Cetonas","Sais"],correta:1},
{pergunta:"O reagente de Fehling diferencia:",opcoes:["Ácidos e bases","Aldeídos e cetonas","Sais e óxidos","Metais e ametais"],correta:1},
{pergunta:"A cromatografia separa compostos por diferenças de:",opcoes:["pH","Polaridade","Volume","Massa"],correta:1},
{pergunta:"A radioatividade alfa emite:",opcoes:["Elétrons","Prótons","Nêutrons","Núcleos de hélio"],correta:3},
{pergunta:"A radioatividade beta menos emite:",opcoes:["Elétrons","Prótons","Posítrons","Fótons"],correta:0},
{pergunta:"A entropia do universo tende a:",opcoes:["Diminuir","Aumentar","Ficar constante","Oscilar"],correta:1},
{pergunta:"A constante de equilíbrio muda com:",opcoes:["Pressão","Concentração","Temperatura","Volume"],correta:2},
{pergunta:"Os metais de transição possuem orbitais:",opcoes:["s","p","d","f"],correta:2},
{pergunta:"A hibridização do carbono no eteno é:",opcoes:["sp","sp2","sp3","sp3d"],correta:1},
{pergunta:"A eletrólise aquosa do NaCl produz:",opcoes:["Na metálico","Cl2 e H2","HCl líquido","NaOH sólido"],correta:1},
{pergunta:"O potencial eletroquímico depende de:",opcoes:["Massa","Temperatura e concentração","Volume","Densidade"],correta:1},
{pergunta:"A lei de Hess afirma que a entalpia depende apenas:",opcoes:["Da pressão","Dos caminhos da reação","Dos estados inicial e final","Da temperatura"],correta:2},
{pergunta:"A ligação peptídica ocorre entre:",opcoes:["Proteínas e DNA","Dois lipídios","Aminoácidos","Glicerol e ácidos graxos"],correta:2},
{pergunta:"A hidratação de alcenos forma:",opcoes:["Éteres","Ácidos","Álcoois","Aldeídos"],correta:2},
{pergunta:"A eletronegatividade do flúor é a:",opcoes:["Menor","Maior","Igual ao oxigênio","Igual ao hidrogênio"],correta:1},
{pergunta:"O estado de oxidação do oxigênio em H2O2 é:",opcoes:["-2","0","-1","+2"],correta:2},
{pergunta:"O ácido benzoico é classificado como:",opcoes:["Saturado","Aromático","Alifático","Inorgânico"],correta:1},
];

const perguntasBiologiaFaceis = [
{pergunta:"A unidade básica da vida é:",opcoes:["Célula","Átomo","Tecido","DNA"],correta:0},
{pergunta:"Qual organela é responsável pela produção de energia?",opcoes:["Ribossomo","Mitocôndria","Lisossomo","Centríolo"],correta:1},
{pergunta:"Os seres humanos são classificados como:",opcoes:["Autótrofos","Heterótrofos","Quimiossínteticos","Plâncton"],correta:1},
{pergunta:"Qual substância é essencial para a fotossíntese?",opcoes:["Hemoglobina","Clorofila","Insulina","Testosterona"],correta:1},
{pergunta:"Plantas produzem seu próprio alimento por:",opcoes:["Digestão","Fermentação","Fotossíntese","Respiração"],correta:2},
{pergunta:"Qual tecido transporta seiva elaborada?",opcoes:["Floema","Xilema","Epiderme","Córtex"],correta:0},
{pergunta:"O DNA tem formato de:",opcoes:["Espiral dupla","Linear único","Círculo irregular","Quadrado"],correta:0},
{pergunta:"Qual animal é um mamífero?",opcoes:["Sapo","Galinha","Golfinho","Cobra"],correta:2},
{pergunta:"Os pulmões fazem parte de qual sistema?",opcoes:["Digestório","Respiratório","Reprodutor","Locomotor"],correta:1},
{pergunta:"Os fungos se alimentam através de:",opcoes:["Fotossíntese","Absorção","Fermentação solar","Eletrossíntese"],correta:1},
{pergunta:"Qual estrutura controla as funções da célula?",opcoes:["Lisossomo","Núcleo","Ribossomo","Centríolo"],correta:1},
{pergunta:"Qual grupo inclui organismos unicelulares?",opcoes:["Mamíferos","Protozoários","Aves","Répteis"],correta:1},
{pergunta:"O sistema responsável pelo bombeamento de sangue é o:",opcoes:["Nervoso","Respiratório","Circulatório","Digestório"],correta:2},
{pergunta:"As plantas absorvem água principalmente pelas:",opcoes:["Flores","Folhas","Raízes","Sementes"],correta:2},
{pergunta:"O sangue é um tipo de:",opcoes:["Tecido epitelial","Tecido nervoso","Tecido conjuntivo","Tecido muscular"],correta:2},
{pergunta:"O órgão responsável pela digestão química no corpo humano é o:",opcoes:["Estômago","Coração","Pulmão","Rim"],correta:0},
{pergunta:"Insetos respiram por:",opcoes:["Brânquias","Pulmões","Traqueias","Teias"],correta:2},
{pergunta:"O maior órgão do corpo humano é:",opcoes:["Coração","Pele","Pulmão","Fígado"],correta:1},
{pergunta:"A fotossíntese ocorre principalmente nas:",opcoes:["Raízes","Flores","Folhas","Sementes"],correta:2},
{pergunta:"Qual animal é vertebrado?",opcoes:["Caracol","Borboleta","Gato","Polvo"],correta:2},
{pergunta:"A água representa grande parte do corpo humano, cerca de:",opcoes:["5%","30%","60%","95%"],correta:2},
{pergunta:"O grupo dos peixes possui:",opcoes:["Penas","Pelos","Brânquias","Casco"],correta:2},
{pergunta:"Onde ocorre a respiração celular?",opcoes:["Mitocôndria","Núcleo","Cloroplasto","Ribossomo"],correta:0},
{pergunta:"Os carboidratos são usados pelo corpo para:",opcoes:["Energia","Hormônios","Defesa","Estrutura óssea"],correta:0},
{pergunta:"Vegetais produzem oxigênio através da:",opcoes:["Respiração","Fermentação","Fotossíntese","Osmose"],correta:2},
{pergunta:"Os glóbulos vermelhos transportam:",opcoes:["Água","Sal","Oxigênio","Glicose"],correta:2},
{pergunta:"A ecolocação é usada por:",opcoes:["Golfinhos","Aves","Répteis","Aranhas"],correta:0},
{pergunta:"As células musculares têm muitas:",opcoes:["Mitocôndrias","Cloroplastos","Vacuolos","Membranas nucleares"],correta:0},
{pergunta:"A função principal dos rins é:",opcoes:["Bombear sangue","Filtrar o sangue","Produzir oxigênio","Digestão"],correta:1},
{pergunta:"Qual destes organiza o ecossistema?",opcoes:["Átomos","Moléculas","Organismos","Cromossomos"],correta:2},
{pergunta:"O sistema nervoso central é formado por:",opcoes:["Coração e pulmões","Músculos","Cérebro e medula","Rins e fígado"],correta:2},
{pergunta:"Qual é a principal função das folhas?",opcoes:["Absorver água","Reprodução","Fotossíntese","Transportar seiva bruta"],correta:2},
{pergunta:"Os vírus precisam de:",opcoes:["Luz solar para viver","Um hospedeiro para se reproduzir","Água para respirar","Oxigênio para crescer"],correta:1},
{pergunta:"O ser humano é classificado como:",opcoes:["Bípede","Aquático","Herbívoro estrito","Quadrúpede"],correta:0},
{pergunta:"As plantas armazenam glicose na forma de:",opcoes:["Amido","Celulose","Frutose","Lactose"],correta:0},
{pergunta:"As aves são animais:",opcoes:["Com pelos","Com penas","Sem ossos","Com brânquias"],correta:1},
{pergunta:"A célula vegetal possui:",opcoes:["Cloroplastos","Mitocôndrias","Ambos","Nenhum"],correta:2},
{pergunta:"As bactérias são:",opcoes:["Pluricelulares","Unicelulares","Sem DNA","Sem membrana"],correta:1},
{pergunta:"Qual órgão produz a bile?",opcoes:["Pâncreas","Estômago","Fígado","Intestino"],correta:2},
{pergunta:"O grupo dos anfíbios vive:",opcoes:["Só na água","Só na terra","Na água e na terra","Apenas no ar"],correta:2},
{pergunta:"Qual estrutura celular controla a entrada e saída de substâncias?",opcoes:["Parede celular","Centríolo","Membrana plasmática","Vacuolo"],correta:2},
{pergunta:"O esqueleto humano é composto principalmente de:",opcoes:["Lipídios","Água","Ossos","Gases"],correta:2},
{pergunta:"Qual destes é um exemplo de herbívoro?",opcoes:["Leão","Cavalo","Jacaré","Cobra"],correta:1},
{pergunta:"A célula animal não possui:",opcoes:["Mitocôndrias","Cloroplastos","Ribossomos","Citoplasma"],correta:1},
{pergunta:"A principal função do coração é:",opcoes:["Filtrar sangue","Bombear sangue","Produzir hormônios","Digestão"],correta:1},
{pergunta:"A digestão começa na:",opcoes:["Faringe","Estômago","Boca","Intestino"],correta:2},
{pergunta:"Os decompositores são importantes porque:",opcoes:["Produzem fósseis","Transformam matéria orgânica em nutrientes","Criam minerais","Aumentam a fotossíntese"],correta:1},
{pergunta:"O oxigênio é absorvido pelos pulmões nos:",opcoes:["Alvéolos","Bronquíolos","Capilares","Nefrons"],correta:0},
{pergunta:"A clorofila dá às plantas a cor:",opcoes:["Vermelha","Amarela","Verde","Roxa"],correta:2},
{pergunta:"A maior parte da digestão ocorre no:",opcoes:["Intestino grosso","Esôfago","Intestino delgado","Pulmão"],correta:2}
];
const perguntasBiologiaMedias = [
{pergunta:"A membrana plasmática é composta principalmente por:",opcoes:["RNA e proteínas","Lipídios e proteínas","DNA e lipídios","Celulose e proteínas"],correta:1},
{pergunta:"A digestão de lipídios depende da ação da:",opcoes:["Pepsina","Tripsina","Bile","Insulina"],correta:2},
{pergunta:"A fase da mitose onde os cromossomos se alinham no meio da célula é a:",opcoes:["Anáfase","Metáfase","Telófase","Prófase"],correta:1},
{pergunta:"Os neurônios transmitem impulsos por meio de:",opcoes:["Osmose","Potencial de ação","Fagocitose","Plasmólise"],correta:1},
{pergunta:"As mitocôndrias são responsáveis por:",opcoes:["Produção de ATP","Síntese de proteínas","Armazenamento de vitaminas","Divisão celular"],correta:0},
{pergunta:"Os organismos autótrofos produzem seu alimento através de:",opcoes:["Respiração","Fermentação","Fotossíntese","Osmose"],correta:2},
{pergunta:"O transporte passivo ocorre:",opcoes:["Com gasto de ATP","Sem gasto de energia","Com ajuda de enzimas","Somente em rios"],correta:1},
{pergunta:"As proteínas são formadas por unidades chamadas:",opcoes:["Monossacarídeos","Nucleotídeos","Aminoácidos","Lípidos"],correta:2},
{pergunta:"A epiderme vegetal é recoberta por uma camada chamada:",opcoes:["Cutícula","Córtex","Floema","Estoma"],correta:0},
{pergunta:"Os cromossomos são formados por:",opcoes:["Glicídios","Lipídios","DNA e proteínas","Vitaminas"],correta:2},
{pergunta:"A respiração celular aeróbia ocorre na:",opcoes:["Mitocôndria","Cloroplasto","Membrana plasmática","Vacuolo"],correta:0},
{pergunta:"A hemoglobina transporta:",opcoes:["Oxigênio","Sais minerais","Glicose","Triglicerídeos"],correta:0},
{pergunta:"A fotossíntese ocorre nas:",opcoes:["Mitocôndrias","Ribossomos","Cloroplastos","Lisossomos"],correta:2},
{pergunta:"O hormônio insulina regula:",opcoes:["Temperatura","Glicose no sangue","Respiração","Digestão"],correta:1},
{pergunta:"A função do ribossomo é:",opcoes:["Produzir ATP","Sintetizar proteínas","Quebrar moléculas","Produzir lipídios"],correta:1},
{pergunta:"Os artrópodes possuem como característica marcante:",opcoes:["Coluna vertebral","Exoesqueleto","Cordão nervoso dorsal","Respiração pulmonar"],correta:1},
{pergunta:"O tecido muscular responsável por movimentos involuntários é o:",opcoes:["Estriado esquelético","Estriado cardíaco","Liso","Cartilaginoso"],correta:2},
{pergunta:"O principal produto da fotossíntese é:",opcoes:["CO₂","Água","Glicose","Nitrogênio"],correta:2},
{pergunta:"A teoria celular afirma que:",opcoes:["Todos os seres vivos têm parede celular","Todos os seres vivos são formados por células","Apenas plantas possuem células","Vírus são células simplificadas"],correta:1},
{pergunta:"O sistema linfático atua principalmente na:",opcoes:["Respiração","Circulação de glicose","Defesa do organismo","Digestão de proteínas"],correta:2},
{pergunta:"As mitoses sucessivas produzem:",opcoes:["Variabilidade genética","Células idênticas","Gametas","Mutação obrigatória"],correta:1},
{pergunta:"A parte do neurônio responsável por receber estímulos é:",opcoes:["Axônio","Dendrito","Núcleo","Sinapse"],correta:1},
{pergunta:"O tipo de reprodução que não envolve gametas é a:",opcoes:["Sexuada","Assexuada","mista","Clonal"],correta:1},
{pergunta:"O ecossistema é composto por:",opcoes:["Apenas fatores bióticos","Apenas fatores abióticos","Fatores bióticos e abióticos","Apenas humanos"],correta:2},
{pergunta:"As plantas perdem água principalmente por:",opcoes:["Convecção","Evaporação","Transpiração","Irradiação"],correta:2},
{pergunta:"A estrutura que conecta músculos aos ossos é o:",opcoes:["Ligamento","Tendão","Nervo","Cartilagem"],correta:1},
{pergunta:"A unidade estrutural dos cromossomos é o:",opcoes:["Neurônio","Nucleotídeo","Meristema","Estoma"],correta:1},
{pergunta:"O grupo dos cnidários inclui:",opcoes:["Planárias","Águas-vivas","Lulas","Anêmonas terrestres"],correta:1},
{pergunta:"A clorofila absorve principalmente luz:",opcoes:["Verde","Vermelha e azul","Amarela","Roxa"],correta:1},
{pergunta:"O intestino delgado é responsável pela:",opcoes:["Filtração de sangue","Digestão e absorção","Armazenar glicose","Produção de hormônios"],correta:1},
{pergunta:"Os mosquitos são classificados como:",opcoes:["Aracnídeos","Crustáceos","Insetos","Anfíbios"],correta:2},
{pergunta:"A célula vegetal contém uma grande estrutura chamada:",opcoes:["Lisossomo","Vacuolo central","Centríolo","Ribossomo"],correta:1},
{pergunta:"O sistema responsável pela coordenação do corpo é o:",opcoes:["Circulatório","Nervoso","Digestório","Respiratório"],correta:1},
{pergunta:"As plantas absorvem sais minerais através das:",opcoes:["Folhas","Flores","Raízes","Caules"],correta:2},
{pergunta:"A glicólise ocorre:",opcoes:["Nas mitocôndrias","No citoplasma","Nos lisossomos","No núcleo"],correta:1},
{pergunta:"A fermentação ocorre na ausência de:",opcoes:["Glicose","Água","Oxigênio","ATP"],correta:2},
{pergunta:"A unidade funcional dos rins é o:",opcoes:["Ventrículo","Alvéolo","Nefron","Glândula"],correta:2},
{pergunta:"A água é importante nas células porque:",opcoes:["Ocupa espaço","É solvente universal","Produz DNA","Gera energia sozinha"],correta:1},
{pergunta:"O principal gás liberado na fotossíntese é:",opcoes:["CO₂","O₂","N₂","SO₂"],correta:1},
{pergunta:"Os anticorpos são produzidos por:",opcoes:["Neurônios","Plasmócitos","Hemácias","Células musculares"],correta:1},
{pergunta:"O coração humano possui:",opcoes:["2 câmaras","3 câmaras","4 câmaras","5 câmaras"],correta:2},
{pergunta:"A principal função das mitocôndrias é:",opcoes:["Produção de lipídios","Produção de ATP","Armazenamento de proteínas","Digeração celular"],correta:1},
{pergunta:"Os protozoários são organismos:",opcoes:["Pluricelulares","Unicelulares e eucarióticos","Procarióticos","Sem núcleo"],correta:1},
{pergunta:"A membrana celular é formada por:",opcoes:["Fosfolipídios","Celulose","Quitina","Amido"],correta:0},
{pergunta:"O pigmento responsável pela cor das cenouras é:",opcoes:["Clorofila","Caroteno","Melanina","Hemoglobina"],correta:1},
{pergunta:"A respiração anaeróbia produz:",opcoes:["Muito ATP","Pouco ATP","Nenhum ATP","Vitamina C"],correta:1},
{pergunta:"A célula que realiza fagocitose está:",opcoes:["Capturando partículas","Produzindo glicose","Criando anticorpos","Dividindo-se"],correta:0},
{pergunta:"A fotossíntese é dividida em fase clara e:",opcoes:["Fase escura","Fase azul","Fase verde","Fase densa"],correta:0},
{pergunta:"Os cromossomos sexuais humanos são:",opcoes:["AA","XY/XX","YY","XXY sempre"],correta:1}
];
const perguntasBiologiaDificeis = [
{pergunta:"A replicação do DNA em eucariotos ocorre de forma:",opcoes:["Assimétrica e linear","Linear e contínua","Bidirecional e descontínua","Unidirecional e contínua"],correta:3},
{pergunta:"A principal função das enzimas topoisomerases durante a replicação é:",opcoes:["Ligar nucleotídeos","Desfazer pontes de hidrogênio","Evitar superenrolamento do DNA","Catalisar síntese proteica"],correta:3},
{pergunta:"O complexo proteassomal é responsável por:",opcoes:["Modificar lipídios","Degradar proteínas marcadas por ubiquitina","Produzir ATP","Regular osmose"],correta:1},
{pergunta:"Os telômeros são importantes porque:",opcoes:["Impedem mutações","Controlam síntese de ribossomos","Protegem extremidades cromossômicas","Aumentam a expressão gênica"],correta:2},
{pergunta:"A etapa da respiração celular que mais produz ATP é:",opcoes:["Glicólise","Ciclo de Krebs","Fosforilação oxidativa","Fermentação"],correta:2},
{pergunta:"A enzima RNA polimerase III sintetiza principalmente:",opcoes:["mRNA","tRNA","snRNA","rRNA 28S"],correta:1},
{pergunta:"A força seletiva que mantém a estrutura terciária das proteínas inclui:",opcoes:["Ligações peptídicas","Interações hidrofóbicas","Pontes dissulfeto","Ligações fosfodiéster"],correta:2},
{pergunta:"Os vírus retrovirais replicam seu genoma utilizando:",opcoes:["DNA polimerase alfa","Topoisomerase II","Transcriptase reversa","Ligase"],correta:2},
{pergunta:"A fosforilação oxidativa depende diretamente do funcionamento:",opcoes:["Dos lisossomos","Do gradiente de prótons","Do complexo de Golgi","Do citoesqueleto"],correta:2},
{pergunta:"O processo que aumenta a variabilidade genética durante a meiose é:",opcoes:["Replicação","Crossing-over","Metafase II","Citocinese"],correta:1},
{pergunta:"O spliceossomo atua na:",opcoes:["Síntese de DNA","Remoção de íntrons","Polimerização de proteínas","Produção de histonas"],correta:1},
{pergunta:"A fotofosforilação cíclica produz:",opcoes:["ATP","NADPH","Glicose","Água"],correta:0},
{pergunta:"A região do anticorpo que reconhece antígenos é chamada:",opcoes:["Domínio Fc","Cadeia leve","Cadeia pesada","Região variável"],correta:3},
{pergunta:"Os plasmídeos bacterianos são importantes porque:",opcoes:["Realizam fotossíntese","Podem carregar genes de resistência","Realizam respiração celular","Produzem ribossomos"],correta:1},
{pergunta:"A teoria endossimbiótica afirma que as mitocôndrias derivam de:",opcoes:["Arqueas anaeróbias","Bactérias aeróbias","Fungos unicelulares","Clorófitas primitivas"],correta:1},
{pergunta:"O principal produto da fase escura da fotossíntese é:",opcoes:["Oxigênio","NADP+","Glicose","Água"],correta:2},
{pergunta:"O complexo de Golgi participa principalmente da:",opcoes:["Duplicação de DNA","Modificação e exportação de proteínas","Síntese de lipídios","Degradação celular"],correta:1},
{pergunta:"A zona pelúcida está associada ao:",opcoes:["Transporte de oxigênio","Reconhecimento do espermatozoide","Digestão intracelular","Movimento celular"],correta:1},
{pergunta:"A proteína actina forma estruturas como:",opcoes:["Centríolos","Microfilamentos","Microtúbulos","Lisossomos"],correta:1},
{pergunta:"Os anticorpos IgE estão relacionados principalmente a:",opcoes:["Memória imunológica","Reações alérgicas","Proteção placentária","Ativação de linfócitos T"],correta:1},
{pergunta:"A bomba de sódio e potássio transporta:",opcoes:["2 Na+ para dentro e 3 K+ para fora","3 Na+ para fora e 2 K+ para dentro","3 K+ para fora e 2 Na+ para dentro","Ions sem gasto energético"],correta:1},
{pergunta:"O ciclo de Calvin ocorre no:",opcoes:["Estroma","Tilacoide","Citoplasma","Mitocôndria"],correta:0},
{pergunta:"O fuso mitótico é constituído principalmente por:",opcoes:["Microtúbulos","Microfilamentos","Fibra de colágeno","Actina"],correta:0},
{pergunta:"A enzima helicase atua:",opcoes:["Ligando nucleotídeos","Desenrolando o DNA","Estabilizando proteínas","Degradando RNA"],correta:1},
{pergunta:"A apoptose é:",opcoes:["Morte celular acidental","Morte celular programada","Quebra aleatória de proteínas","Erro mitótico"],correta:1},
{pergunta:"O anticorpo IgA está presente em alta concentração em:",opcoes:["Sangue","Linfa","Secreções mucosas","Tecido ósseo"],correta:2},
{pergunta:"A duplicação do centríolo ocorre durante a fase:",opcoes:["G1","S","G2","M"],correta:2},
{pergunta:"O ciclo do nitrogênio depende principalmente de:",opcoes:["Protozoários","Vírus","Bactérias fixadoras","Fungos decompositores"],correta:2},
{pergunta:"A enzima rubisco catalisa a fixação de:",opcoes:["Oxigênio","Hidrogênio","Carbono","Nitrogênio"],correta:2},
{pergunta:"A estrutura que permite comunicação entre células vegetais é:",opcoes:["Centríolo","Plasmodesmo","Estoma","Cutícula"],correta:1},
{pergunta:"Os microtúbulos são compostos por:",opcoes:["Actina","Tubulina","Queratina","Elastina"],correta:1},
{pergunta:"A reação de desaminação ocorre principalmente no:",opcoes:["Estômago","Pâncreas","Fígado","Rim"],correta:2},
{pergunta:"O peroxissomo é responsável por:",opcoes:["Quebra de lipídios complexos","Produção de ATP","Síntese proteica","Formação do fuso mitótico"],correta:0},
{pergunta:"O mRNA maduro contém:",opcoes:["Íntrons e éxons","Apenas íntrons","Apenas éxons","DNA associado"],correta:2},
{pergunta:"Os linfócitos T citotóxicos reconhecem células infectadas através do:",opcoes:["MHC I","MHC II","Anticorpos IgM","Cadeia pesada H1"],correta:0},
{pergunta:"A pressão osmótica é determinada principalmente pela:",opcoes:["Temperatura","Concentração de solutos","pH","Presença de lipídios"],correta:1},
{pergunta:"A telomerase atua:",opcoes:["Degradando proteínas velhas","Sintetizando DNA repetitivo nas extremidades","Estabilizando histonas","Produzindo ATP"],correta:1},
{pergunta:"O gradiente eletroquímico de prótons se forma nos:",opcoes:["Cloroplastos e mitocôndrias","Lisossomos","Peroxissomos","Núcleos"],correta:0},
{pergunta:"A fermentação lática ocorre principalmente em:",opcoes:["Neurônios","Fibras musculares","Hemácias","Células hepáticas"],correta:1},
{pergunta:"Os peptídeos sinalizadores determinam:",opcoes:["Destino proteico","Cor da pele","pH celular","Taxa respiratória"],correta:0},
{pergunta:"A recombinação gênica em anticorpos ocorre por:",opcoes:["RNA polimerase","Splicing alternativo","Rearranjo V(D)J","Mutação espontânea"],correta:2},
{pergunta:"O centrossomo é formado por:",opcoes:["Dois centríolos","Um cromossomo e um fuso","Ribossomos","Dois lisossomos"],correta:0},
{pergunta:"A fase mais longa do ciclo celular é:",opcoes:["G1","G2","S","M"],correta:0},
{pergunta:"A bomba de cálcio do retículo sarcoplasmático é essencial para:",opcoes:["Digestão","Relaxamento muscular","Síntese de ATP","Excreção"],correta:1},
{pergunta:"A via das pentoses fosfato produz:",opcoes:["ATP em grande quantidade","NADPH e ribose","Ácido pirúvico","Glicogênio"],correta:1},
{pergunta:"O transporte ativo secundário depende de:",opcoes:["Gradientes pré-existentes","ATP direto","Ligações peptídicas","Canal de potássio"],correta:0},
{pergunta:"As células-tronco pluripotentes podem gerar:",opcoes:["Apenas um tecido","Qualquer tecido, exceto anexos embrionários","Somente neurônios","Somente células sanguíneas"],correta:1},
{pergunta:"A síntese de proteínas ocorre onde?",opcoes:["Lisossomos","Ribossomos","Peroxissomos","Centríolos"],correta:1},
{pergunta:"O fator que determina a direção do fluxo de água na osmose é:",opcoes:["Pressão atmosférica","Concentração de solutos","Quantidade de ATP","Número de lisossomos"],correta:1},
{pergunta:"A etapa em que os cromossomos começam a se condensar na mitose é:",opcoes:["Prófase","Metáfase","Telófase","Anáfase"],correta:0}
];

const perguntasFilosofiaFaceis = [
{pergunta:"A filosofia surgiu na Grécia Antiga como uma forma de:",opcoes:["Explicar mitos","Buscar explicações racionais","Criar religiões","Criar leis apenas políticas"],correta:1},
{pergunta:"O filósofo conhecido como 'pai da filosofia' é:",opcoes:["Platão","Sócrates","Heráclito","Epicuro"],correta:1},
{pergunta:"A maiêutica é um método criado por:",opcoes:["Aristóteles","Sócrates","Sofistas","Zenão"],correta:1},
{pergunta:"A ética estuda:",opcoes:["As leis naturais","O comportamento moral","A matemática","A biologia"],correta:1},
{pergunta:"Platão afirmava que o mundo verdadeiro era o mundo:",opcoes:["Material","Das Formas ou Ideias","Sensitivo","Mitológico"],correta:1},
{pergunta:"O mito da caverna é uma alegoria criada por:",opcoes:["Aristóteles","Demócrito","Platão","Sócrates"],correta:2},
{pergunta:"Para Aristóteles, a finalidade de tudo é chamada de:",opcoes:["Hylé","Telos","Areté","Mimesis"],correta:1},
{pergunta:"Os sofistas eram conhecidos por:",opcoes:["Defenderem a verdade absoluta","Ensinarem retórica","Desenvolverem física","Criarem religião"],correta:1},
{pergunta:"A palavra filosofia significa:",opcoes:["Amor à ciência","Amor à sabedoria","Sabedoria divina","Pensamento matemático"],correta:1},
{pergunta:"A lógica formal foi organizada principalmente por:",opcoes:["Santo Agostinho","Aristóteles","Sócrates","Sêneca"],correta:1},
{pergunta:"O estoicismo defendia:",opcoes:["Busca pelos prazeres","Domínio das emoções","Rejeição da razão","Negação da virtude"],correta:1},
{pergunta:"Epicuro afirmava que o bem supremo era:",opcoes:["A virtude","O prazer moderado","A força","A fama"],correta:1},
{pergunta:"A dúvida radical é característica do pensamento de:",opcoes:["Descartes","Hobbes","Comte","Kant"],correta:0},
{pergunta:"A frase 'Penso, logo existo' foi formulada por:",opcoes:["Kant","Descartes","Hume","Weber"],correta:1},
{pergunta:"Immanuel Kant defendia que o conhecimento vem de:",opcoes:["Apenas da razão","Apenas dos sentidos","Da razão e da experiência","Da matemática"],correta:2},
{pergunta:"Segundo Platão, só pode governar uma cidade aquele que é:",opcoes:["Forte","Rico","Filósofo","Jurista"],correta:2},
{pergunta:"O iluminismo defendia:",opcoes:["Tradições acima da razão","A razão como guia da sociedade","O poder absoluto do rei","A fé acima da ciência"],correta:1},
{pergunta:"Para os cínicos, a felicidade estava em:",opcoes:["Riqueza","Honestidade","Simplicidade e desapego","Vitórias políticas"],correta:2},
{pergunta:"O empirismo afirma que:",opcoes:["A razão é tudo","A experiência é base do conhecimento","A matemática é o único saber","A linguagem cria o mundo"],correta:1},
{pergunta:"O racionalismo defende que o conhecimento provém principalmente da:",opcoes:["Tradição","Experiência sensorial","Razão","Instinto"],correta:2},
{pergunta:"O 'contrato social' é uma teoria associada a autores como:",opcoes:["Marx e Engels","Hobbes, Locke e Rousseau","Nietzsche e Kant","Agostinho e Tomás"],correta:1},
{pergunta:"O filósofo que dizia que 'o homem é o lobo do homem' era:",opcoes:["Marx","Hobbes","Rousseau","Weber"],correta:1},
{pergunta:"Para Rousseau, o ser humano nasce:",opcoes:["Mau","Bom","Violento","Sem razão"],correta:1},
{pergunta:"Montesquieu defendia a divisão:",opcoes:["Do trabalho","Da alma","Dos poderes do Estado","Da fé"],correta:2},
{pergunta:"A filosofia medieval era muito influenciada por:",opcoes:["Ciência moderna","Mitologia nórdica","Cristianismo","Religião egípcia"],correta:2},
{pergunta:"Santo Agostinho buscou conciliar o cristianismo com:",opcoes:["Platonismo","Materialismo","Estoicismo","Epicurismo"],correta:0},
{pergunta:"São Tomás de Aquino conciliou fé cristã com a obra de:",opcoes:["Sócrates","Aristóteles","Epicuro","Tales"],correta:1},
{pergunta:"O materialismo histórico foi criado por:",opcoes:["Weber","Comte","Marx e Engels","Nietzsche"],correta:2},
{pergunta:"O positivismo foi criado por:",opcoes:["Hegel","Comte","Durkheim","Kant"],correta:1},
{pergunta:"O existencialismo coloca no centro da reflexão:",opcoes:["A razão científica","A essência humana","A liberdade e as escolhas","A realidade divina"],correta:2},
{pergunta:"Søren Kierkegaard é considerado o pai do:",opcoes:["Racionalismo","Positivismo","Existencialismo","Niilismo"],correta:2},
{pergunta:"Nietzsche criticava fortemente a:",opcoes:["Ciência","Moral cristã tradicional","Razão","Lógica"],correta:1},
{pergunta:"Para Nietzsche, o ideal humano é o:",opcoes:["Homem comum","Servo","Super-homem","Sacerdote"],correta:2},
{pergunta:"A dialética hegeliana é fundamentada no movimento:",opcoes:["Tese–Antítese–Síntese","Ordem–Progresso–Razão","Grau–Matéria–Energia","Ser–Nada–Essência"],correta:0},
{pergunta:"O conceito de fato social foi desenvolvido por:",opcoes:["Marx","Durkheim","Aristóteles","Comte"],correta:1},
{pergunta:"O princípio da utilidade está associado a:",opcoes:["Platonismo","Hedonismo antigo","Utilitarismo","Existencialismo cristão"],correta:2},
{pergunta:"O pensador que defendia o 'governo dos melhores' era:",opcoes:["Platão","Hobbes","Voltaire","Mill"],correta:0},
{pergunta:"A fenomenologia foi desenvolvida principalmente por:",opcoes:["Husserl","Freud","Schopenhauer","Agostinho"],correta:0},
{pergunta:"A noção de alienação está associada a:",opcoes:["Aristóteles","Marx","Weber","Epicuro"],correta:1},
{pergunta:"Segundo Weber, a ação social depende de:",opcoes:["Força física","Interpretação de sentido","Origem divina","Hereditariedade"],correta:1},
{pergunta:"A ética utilitarista busca:",opcoes:["Felicidade do maior número","Vitória dos fortes","Equilíbrio das emoções","Dever moral absoluto"],correta:0},
{pergunta:"Para Sartre, o homem está condenado à:",opcoes:["Obediência","Fé","Liberdade","Guerra"],correta:2},
{pergunta:"A teoria das ideias é central na obra de:",opcoes:["Platão","Nietzsche","Aristóteles","Descartes"],correta:0},
{pergunta:"Segundo Aristóteles, a virtude está no:",opcoes:["Excesso","Defeito","Caminho do meio","Instinto"],correta:2},
{pergunta:"Os pré-socráticos buscavam explicações baseadas em:",opcoes:["Mitos religiosos","Razão e natureza","Revelações divinas","Tradição oral"],correta:1},
{pergunta:"Heráclito acreditava que tudo está em:",opcoes:["Imobilidade","Paz","Constante mudança","Repetição eterna"],correta:2},
{pergunta:"Parmênides afirmava que o ser é:",opcoes:["Mutável","Ilusório","Imóvel","Dependente da experiência"],correta:2},
{pergunta:"A physis para os gregos pré-socráticos refere-se à:",opcoes:["Religião","Natureza","Política","Arte"],correta:1}
];
const perguntasFilosofiaMedias = [
{pergunta:"Para Platão, o mundo sensível é:",opcoes:["O verdadeiro mundo das ideias","O mundo que percebemos pelos sentidos","Irrelevante para a filosofia","O mundo das aparências e da perfeição"],correta:1},
{pergunta:"Aristóteles critica Platão porque:",opcoes:["Não acredita na existência de ideias","Acha que o mundo sensível é irreal","Defende a existência de múltiplos deuses","Considera a ética irrelevante"],correta:2},
{pergunta:"A ética de Aristóteles busca:",opcoes:["A felicidade (eudaimonia)","O prazer imediato","A submissão às leis","O poder político"],correta:0},
{pergunta:"O conceito de 'tabula rasa' é de:",opcoes:["Descartes","Locke","Hobbes","Kant"],correta:1},
{pergunta:"Para Descartes, o ponto de partida para o conhecimento é:",opcoes:["A experiência sensível","O ceticismo metódico","A autoridade da igreja","O estudo da natureza"],correta:3},
{pergunta:"O imperativo categórico de Kant afirma que devemos agir:",opcoes:["Segundo nossa vontade","De acordo com regras universais","Para obter prazer","Conforme a tradição"],correta:1},
{pergunta:"Hegel é conhecido por desenvolver a dialética:",opcoes:["Tese-antítese-síntese","Bem-mal-justiça","Causa-efeito-fim","Ser-não-ser-vir-a-ser"],correta:2},
{pergunta:"O existencialismo enfatiza:",opcoes:["A liberdade e responsabilidade individual","A ordem universal","A harmonia da natureza","O determinismo social"],correta:3},
{pergunta:"Nietzsche critica a moral tradicional por:",opcoes:["Valorizar a fraqueza e a submissão","Promover a coragem e a força","Ser incompatível com ciência","Incentivar a solidariedade"],correta:0},
{pergunta:"O contrato social, segundo Rousseau, visa:",opcoes:["Garantir liberdade e igualdade","Aumentar o poder do rei","Proteger apenas os ricos","Impor a religião"],correta:0},
{pergunta:"Para Sócrates, o conhecimento é:",opcoes:["Viver de acordo com a virtude","Acumular riqueza","Seguir tradições","Obter prazer"],correta:3},
{pergunta:"O ceticismo filosófico busca:",opcoes:["Duvidar de tudo para alcançar a verdade","Afirmar dogmaticamente a verdade","Aumentar o poder político","Explicar fenômenos naturais"],correta:1},
{pergunta:"Epicuro defendia que o objetivo da vida era:",opcoes:["O prazer moderado e a ausência de dor","A busca pelo poder","A contemplação do mundo das ideias","A ascese e negação do corpo"],correta:2},
{pergunta:"O utilitarismo propõe que a moralidade deve:",opcoes:["Maximizar a felicidade geral","Seguir regras absolutas","Basear-se em costumes antigos","Evitar qualquer mudança social"],correta:3},
{pergunta:"Para Marx, a história da humanidade é determinada por:",opcoes:["Lutas de classes","Ideias filosóficas","A moral individual","A religião"],correta:0},
{pergunta:"O existencialismo de Sartre afirma que:",opcoes:["O homem está condenado à liberdade","Deus determina todas as ações","A moral é universal","A história é predestinada"],correta:3},
{pergunta:"O método socrático consiste em:",opcoes:["Questionar para chegar à verdade","Ensinar dogmas","Observar a natureza","Escrever tratados longos"],correta:1},
{pergunta:"Para Thomas Hobbes, a natureza humana é:",opcoes:["Egoísta e violenta","Boa e cooperativa","Neutra e passiva","Espiritual e divina"],correta:0},
{pergunta:"O empirismo defende que:",opcoes:["O conhecimento vem da experiência","A razão é a única fonte de conhecimento","A moral é inata","O mundo é ilusão"],correta:2},
{pergunta:"O racionalismo defende que:",opcoes:["A razão é a principal fonte do conhecimento","A experiência é irrelevante","A ética depende do prazer","O mundo é uma projeção da mente"],correta:1},
{pergunta:"Para Kant, o fenômeno é:",opcoes:["O que percebemos pelos sentidos","O mundo das ideias","A moral absoluta","O espírito divino"],correta:0},
{pergunta:"O noumeno, segundo Kant, é:",opcoes:["A realidade como ela é em si mesma","A aparência dos objetos","O bem moral","A experiência empírica"],correta:3},
{pergunta:"O conceito de 'vontade de poder' é de:",opcoes:["Nietzsche","Hegel","Marx","Kant"],correta:0},
{pergunta:"O determinismo filosófico afirma que:",opcoes:["Todos os eventos são causados","O homem é totalmente livre","O prazer é o guia da vida","A ética é relativa"],correta:1},
{pergunta:"O estruturalismo estuda:",opcoes:["As estruturas subjacentes à cultura e à linguagem","A história das ideias","O comportamento animal","A moral religiosa"],correta:0},
{pergunta:"Para Heidegger, a questão central da filosofia é:",opcoes:["O ser","A verdade","A felicidade","A justiça"],correta:2},
{pergunta:"O positivismo defende que o conhecimento válido é:",opcoes:["Científico e verificável","Baseado na fé","Intuitivo","Dogmático"],correta:0},
{pergunta:"O existencialismo cristão de Kierkegaard enfatiza:",opcoes:["A fé e a relação individual com Deus","A ciência como guia moral","O determinismo histórico","A felicidade material"],correta:0},
{pergunta:"A dialética hegeliana busca:",opcoes:["Superar contradições para atingir síntese","Confirmar ideias pré-existentes","Criticar a religião","Promover o individualismo"],correta:1},
{pergunta:"Para Locke, os direitos naturais incluem:",opcoes:["Vida, liberdade e propriedade","Felicidade, prazer e poder","Educação, moral e cultura","Trabalho, riqueza e força"],correta:3},
{pergunta:"O conceito de alienação é de:",opcoes:["Marx","Hobbes","Rousseau","Descartes"],correta:0},
{pergunta:"O pragmatismo avalia ideias segundo:",opcoes:["Suas consequências práticas","Sua verdade absoluta","Sua origem histórica","Sua coerência lógica"],correta:1},
{pergunta:"O niilismo, segundo Nietzsche, é:",opcoes:["A negação de valores tradicionais","A busca pelo prazer","A valorização da razão","A fé inabalável"],correta:0},
{pergunta:"A filosofia do direito de Rousseau baseia-se em:",opcoes:["O contrato social","A força militar","A religião","O comércio"],correta:1},
{pergunta:"O método cartesiano busca:",opcoes:["Fundamentar o conhecimento de forma segura","Maximizar prazer e minimizar dor","Analisar fenômenos históricos","Estabelecer tradições morais"],correta:0},
{pergunta:"O conceito de ethos na filosofia grega se refere a:",opcoes:["Caráter e costumes","Prazer e dor","Poder e riqueza","Conhecimento e ciência"],correta:0},
{pergunta:"A aporia socrática significa:",opcoes:["Estado de dúvida que leva ao conhecimento","Conclusão absoluta","Erro lógico","Felicidade plena"],correta:0},
{pergunta:"O empirismo britânico enfatiza:",opcoes:["Observação e experiência","A razão pura","A moral universal","O espírito divino"],correta:1},
{pergunta:"A metafísica investiga:",opcoes:["A essência da realidade","As leis físicas","A moralidade prática","A linguagem cotidiana"],correta:0},
{pergunta:"O ceticismo cartesiano visa:",opcoes:["Duvidar de tudo para encontrar certeza","Negar a existência do mundo","Aceitar tradições sem questionar","Maximizar prazer"],correta:0},
{pergunta:"A filosofia utilitarista de Bentham valoriza:",opcoes:["O maior prazer para o maior número","A liberdade individual","A verdade absoluta","A tradição"],correta:0},
{pergunta:"O existencialismo enfatiza:",opcoes:["A responsabilidade individual","A harmonia universal","A moral religiosa","O prazer sensorial"],correta:3},
{pergunta:"O idealismo de Berkeley sustenta que:",opcoes:["Só existem ideias e percepções","O mundo material é absoluto","A moral depende do estado","A ciência é inútil"],correta:0},
{pergunta:"Para Epicuro, a ataraxia é:",opcoes:["Estado de tranquilidade e ausência de dor","Poder absoluto","Prazer intenso","Conhecimento absoluto"],correta:0},
{pergunta:"O conceito de super-homem é de:",opcoes:["Nietzsche","Kant","Sartre","Heidegger"],correta:0},
{pergunta:"O existencialismo francês pós-Segunda Guerra Mundial destacou:",opcoes:["Sartre e Camus","Descartes e Locke","Kant e Hegel","Epicuro e Sócrates"],correta:0},
{pergunta:"Para Hume, a causalidade é:",opcoes:["Uma crença baseada em hábito","Um princípio racional","Uma lei divina","Um fenômeno absoluto"],correta:0},
{pergunta:"O pensamento socrático incentiva:",opcoes:["Questionar e refletir","Obedecer sem pensar","Aceitar dogmas","Evitar a razão"],correta:0},
{pergunta:"O materialismo histórico considera:",opcoes:["As condições materiais determinam a história","A moral define a história","A religião guia a história","O destino é divino"],correta:0}
];
const perguntasFilosofiaDificeis = [
{pergunta:"O conceito de 'Dasein' em Heidegger refere-se a:",opcoes:["O ser-no-mundo","A consciência de Deus","O estado de ignorância","A lógica formal"],correta:0},
{pergunta:"A 'morte de Deus', segundo Nietzsche, significa:",opcoes:["A perda de valores absolutos tradicionais","A descrença em todos os deuses","O fim da vida humana","O ceticismo cartesiano"],correta:1},
{pergunta:"A síntese hegeliana surge de:",opcoes:["Tese e antítese","Observação empírica","Experiência individual","Escolha ética"],correta:0},
{pergunta:"O conceito de 'alienação' em Marx refere-se a:",opcoes:["Perda da conexão com o produto do trabalho","A fé religiosa","A contemplação filosófica","A desobediência moral"],correta:1},
{pergunta:"O imperativo hipotético de Kant indica:",opcoes:["Uma ação como meio para um fim","A moral universal","A liberdade absoluta","A felicidade individual"],correta:2},
{pergunta:"O cogito de Descartes significa:",opcoes:["Penso, logo existo","Conheço, logo sou","A dúvida é inútil","A experiência é suprema"],correta:0},
{pergunta:"O utilitarismo clássico de Bentham define moralidade como:",opcoes:["Maximização da felicidade geral","Seguir leis naturais","Obediência à religião","Cultivo da virtude pessoal"],correta:3},
{pergunta:"O niilismo ativo, segundo Nietzsche, é:",opcoes:["A criação de novos valores","Negar toda moralidade","Aceitar dogmas","Busca pelo prazer sensorial"],correta:0},
{pergunta:"O conceito de 'tabula rasa' em Locke defende:",opcoes:["A mente nasce sem ideias","A existência de ideias inatas","A predestinação divina","O determinismo histórico"],correta:1},
{pergunta:"Para Hume, a causalidade é:",opcoes:["Uma relação de hábito mental","Uma lei objetiva do universo","Um imperativo moral","Uma intuição racional"],correta:2},
{pergunta:"A dialética materialista de Marx considera:",opcoes:["Condições materiais determinando a sociedade","Ideias abstratas dominando a história","Ética individual como motor","A religião como único guia"],correta:0},
{pergunta:"A ética da virtude, em Aristóteles, busca:",opcoes:["O equilíbrio e a excelência moral","O prazer imediato","O poder político","A submissão às leis"],correta:1},
{pergunta:"O existencialismo de Sartre enfatiza:",opcoes:["Liberdade e responsabilidade","A harmonia universal","A moral divina","O determinismo histórico"],correta:0},
{pergunta:"Para Kierkegaard, a fé exige:",opcoes:["Um salto para o absurdo","A razão pura","A contemplação do mundo","A obediência cega"],correta:3},
{pergunta:"O empirismo britânico sustenta que:",opcoes:["Todo conhecimento vem da experiência","A razão é suprema","A ética é inata","O mundo material é ilusório"],correta:0},
{pergunta:"A fenomenologia de Husserl busca:",opcoes:["Descrever experiências conscientes","Predizer fenômenos","Estabelecer leis físicas","Avaliar valores morais"],correta:1},
{pergunta:"A moral de escravo, segundo Nietzsche, é:",opcoes:["Valorização da fraqueza e ressentimento","Criação de valores fortes","Busca pelo prazer","Autossuficiência"],correta:0},
{pergunta:"O contratualismo de Hobbes fundamenta-se:",opcoes:["No medo e na necessidade de ordem","Na virtude","Na liberdade absoluta","Na contemplação filosófica"],correta:1},
{pergunta:"A vontade de potência, segundo Nietzsche, indica:",opcoes:["Força criativa do indivíduo","O poder do Estado","Moral tradicional","Prazer material"],correta:0},
{pergunta:"A lógica aristotélica é baseada em:",opcoes:["Silogismos","Experiência sensível","Ética da virtude","Intuição metafísica"],correta:0},
{pergunta:"O racionalismo cartesiano afirma:",opcoes:["A razão é a principal fonte do conhecimento","A experiência é única fonte","O prazer é guia","A moral é absoluta"],correta:1},
{pergunta:"O empirismo, segundo Locke, afirma:",opcoes:["O conhecimento vem da experiência","O conhecimento é inato","A ética é universal","O mundo é ilusão"],correta:0},
{pergunta:"O existencialismo francês pós-Segunda Guerra Mundial destacou:",opcoes:["Sartre e Camus","Descartes e Locke","Kant e Hegel","Epicuro e Sócrates"],correta:0},
{pergunta:"O conceito de alienação em Marx é:",opcoes:["Separação do trabalhador do produto","Submissão ao Estado","Renúncia à moral","Fuga da consciência"],correta:2},
{pergunta:"O pragmatismo de William James prioriza:",opcoes:["Resultados práticos","Ideias abstratas","Valores morais","Beleza estética"],correta:0},
{pergunta:"O niilismo é caracterizado por:",opcoes:["Negação de valores e sentido","Criação de novos valores","Obediência a dogmas","Busca pelo prazer"],correta:0},
{pergunta:"O contratualismo de Rousseau baseia-se:",opcoes:["Na liberdade e igualdade","Na força militar","Na religião","No comércio"],correta:0},
{pergunta:"O método cartesiano visa:",opcoes:["Fundamentar o conhecimento com certeza","Maximizar prazer","Analisar história","Estabelecer tradições"],correta:3},
{pergunta:"O ethos grego significa:",opcoes:["Caráter e costumes","Prazer e dor","Poder e riqueza","Conhecimento e ciência"],correta:0},
{pergunta:"A aporia socrática indica:",opcoes:["Dúvida que leva ao conhecimento","Conclusão absoluta","Erro lógico","Felicidade plena"],correta:0},
{pergunta:"O empirismo britânico defende:",opcoes:["Observação e experiência","Razão pura","Moral universal","Espírito divino"],correta:1},
{pergunta:"A metafísica investiga:",opcoes:["A essência da realidade","Leis físicas","Moralidade prática","Linguagem cotidiana"],correta:0},
{pergunta:"O ceticismo cartesiano busca:",opcoes:["Duvidar de tudo para encontrar certeza","Negar o mundo","Aceitar tradições","Maximizar prazer"],correta:1},
{pergunta:"O utilitarismo de Bentham valoriza:",opcoes:["Maior prazer para maior número","Liberdade individual","Verdade absoluta","Tradição"],correta:0},
{pergunta:"O existencialismo enfatiza:",opcoes:["Responsabilidade individual","Harmonia universal","Moral religiosa","Prazer sensorial"],correta:3},
{pergunta:"O idealismo de Berkeley sustenta:",opcoes:["Só existem ideias e percepções","Mundo material absoluto","Moral depende do Estado","Ciência é inútil"],correta:0},
{pergunta:"Para Epicuro, ataraxia é:",opcoes:["Tranquilidade e ausência de dor","Poder absoluto","Prazer intenso","Conhecimento absoluto"],correta:0},
{pergunta:"O super-homem é um conceito de:",opcoes:["Nietzsche","Kant","Sartre","Heidegger"],correta:0},
{pergunta:"Hegel considera a história como:",opcoes:["Processo dialético","Acúmulo de fatos","Determinação divina","Aleatoriedade"],correta:0},
{pergunta:"Kant distingue fenômeno e noumeno como:",opcoes:["Mundo percebido vs. realidade em si","Moral vs. prazer","Razão vs. experiência","Ética vs. política"],correta:1},
{pergunta:"A ética aristotélica é teleológica porque:",opcoes:["Busca a finalidade da vida","Segue regras absolutas","É baseada em prazer","Depende da lei"],correta:0},
{pergunta:"Sartre afirma que a existência precede:",opcoes:["A essência","O mundo","A ética","A moral"],correta:0},
{pergunta:"O determinismo histórico em Marx indica:",opcoes:["Que as condições materiais moldam a história","Que a moral define a história","Que a religião guia a história","Que o destino é divino"],correta:0},
{pergunta:"O empirismo de Hume sugere que:",opcoes:["Idéias derivam da experiência","Razão é suprema","O mundo é ilusão","Ética é inata"],correta:1},
{pergunta:"O estruturalismo analisa:",opcoes:["Estruturas subjacentes à cultura e linguagem","História das ideias","Comportamento animal","Moral religiosa"],correta:0},
{pergunta:"Kierkegaard enfatiza a fé como:",opcoes:["Escolha subjetiva","Dogma","Razão pura","Virtude ética"],correta:0},
{pergunta:"Nietzsche critica a moral por ser:",opcoes:["Ressentimento e negação da vida","Universal e absoluta","Subjetiva","Abstrata"],correta:0}
];

const perguntasSociologiaFaceis = [
{ pergunta: "O que é Sociologia?", opcoes: ["Estudo da sociedade", "Estudo dos astros", "Estudo da química", "Estudo dos animais"], correta: 0 },
{ pergunta: "Quem é considerado um dos fundadores da Sociologia?", opcoes: ["Karl Marx", "Galileu Galilei", "Albert Einstein", "Isaac Newton"], correta: 0 },
{ pergunta: "O que estuda a Estrutura Social?", opcoes: ["Como a sociedade é organizada", "O funcionamento do corpo humano", "A formação das estrelas", "As espécies animais"], correta: 0 },
{ pergunta: "O que é cultura?", opcoes: ["Conjunto de hábitos e valores de um grupo", "A cor dos objetos", "A altura das pessoas", "O clima do planeta"], correta: 0 },
{ pergunta: "O que é um grupo social?", opcoes: ["Conjunto de pessoas com interação e objetivos comuns", "Um tipo de árvore", "Uma coleção de livros", "Uma equipe de robôs"], correta: 0 },
{ pergunta: "O que é socialização?", opcoes: ["Processo de aprendizado das normas sociais", "Estudo da matemática", "Estudo da física", "Aprender a nadar"], correta: 0 },
{ pergunta: "O que é desvio social?", opcoes: ["Comportamento que foge das normas", "Comer sobremesa antes do almoço", "Dormir cedo", "Estudar muito"], correta: 0 },
{ pergunta: "O que significa norma social?", opcoes: ["Regras de comportamento aceitas na sociedade", "Número de estrelas no céu", "Cor da bandeira", "Altura de edifícios"], correta: 0 },
{ pergunta: "O que é um papel social?", opcoes: ["Função que uma pessoa desempenha na sociedade", "Um tipo de papel reciclável", "Um livro didático", "Um documento oficial"], correta: 0 },
{ pergunta: "O que é status social?", opcoes: ["Posição de uma pessoa na sociedade", "Altura da pessoa", "Idade da pessoa", "Cor favorita"], correta: 0 },
{ pergunta: "O que é mobilidade social?", opcoes: ["Mudança de posição social de uma pessoa", "Trocar de roupa", "Viajar de avião", "Mudar de casa"], correta: 0 },
{ pergunta: "O que é sociedade?", opcoes: ["Conjunto de indivíduos que interagem", "Um planeta", "Um livro", "Uma estrela"], correta: 0 },
{ pergunta: "O que estuda a Sociologia?", opcoes: ["A vida em sociedade", "As células", "O clima", "O espaço"], correta: 0 },
{ pergunta: "O que é instituições sociais?", opcoes: ["Organizações que regulam a vida social", "Equipamentos eletrônicos", "Espécies de animais", "Planetas"], correta: 0 },
{ pergunta: "O que é religião na Sociologia?", opcoes: ["Sistema de crenças compartilhado", "Uma ciência exata", "Uma cor", "Um tipo de comida"], correta: 0 },
{ pergunta: "O que é família na Sociologia?", opcoes: ["Grupo social básico", "Uma empresa", "Um bairro", "Uma escola"], correta: 0 },
{ pergunta: "O que é educação na Sociologia?", opcoes: ["Transmissão de conhecimento e valores", "Altura da árvore", "Velocidade do carro", "Número de páginas do livro"], correta: 0 },
{ pergunta: "O que é política na Sociologia?", opcoes: ["Atividades de organização do poder", "Estudo das plantas", "Estudo do mar", "Composição de músicas"], correta: 0 },
{ pergunta: "O que significa classe social?", opcoes: ["Grupo com mesma posição econômica", "Grupo de animais", "Grupo de plantas", "Grupo de livros"], correta: 0 },
{ pergunta: "O que é desigualdade social?", opcoes: ["Diferenças de oportunidades na sociedade", "Diferença de cores", "Diferença de alturas", "Diferença de estações do ano"], correta: 0 },
{ pergunta: "O que é preconceito?", opcoes: ["Julgar alguém sem conhecer", "Estudar um livro", "Viajar para outro país", "Cuidar do jardim"], correta: 0 },
{ pergunta: "O que é estereótipo?", opcoes: ["Generalização sobre um grupo", "Uma planta rara", "Um tipo de música", "Um filme"], correta: 0 },
{ pergunta: "O que é identidade social?", opcoes: ["Sentimento de pertencimento a um grupo", "Cor de roupa", "Tamanho do sapato", "Altura do prédio"], correta: 0 },
{ pergunta: "O que é mobilização social?", opcoes: ["Ação coletiva para mudança", "Troca de brinquedos", "Caminhar na praia", "Ler um jornal"], correta: 0 },
{ pergunta: "O que é multiculturalismo?", opcoes: ["Convivência de diferentes culturas", "Somente uma cultura", "Estudo de uma cor", "Somente música"], correta: 0 },
{ pergunta: "O que é solidariedade?", opcoes: ["Ajudar os outros voluntariamente", "Estudar sozinho", "Ficar em casa", "Viajar sozinho"], correta: 0 },
{ pergunta: "O que é cidadania?", opcoes: ["Direitos e deveres em sociedade", "Cor do cabelo", "Altura da pessoa", "Número de livros"], correta: 0 },
{ pergunta: "O que é ética na Sociologia?", opcoes: ["Princípios de conduta correta", "Medir a temperatura", "Cantar uma música", "Praticar esporte"], correta: 0 },
{ pergunta: "O que é moral na Sociologia?", opcoes: ["Regras de certo e errado aceitas socialmente", "Uma estação do ano", "Um tipo de fruta", "Um animal"], correta: 0 },
{ pergunta: "O que é grupo primário?", opcoes: ["Grupo de relações íntimas e duradouras", "Grupo de livros", "Grupo de cores", "Grupo de músicas"], correta: 0 },
{ pergunta: "O que é grupo secundário?", opcoes: ["Grupo com relações formais e específicas", "Grupo de flores", "Grupo de planetas", "Grupo de filmes"], correta: 0 },
{ pergunta: "O que é ação social?", opcoes: ["Ação com significado para o outro", "Um exercício físico", "Um desenho", "Uma comida"], correta: 0 },
{ pergunta: "O que é integração social?", opcoes: ["Processo de unir indivíduos à sociedade", "Processo de cozinhar", "Processo de dormir", "Processo de pintar"], correta: 0 },
{ pergunta: "O que é coesão social?", opcoes: ["Força que mantém o grupo unido", "Força de gravidade", "Força de vento", "Força elétrica"], correta: 0 },
{ pergunta: "O que é conflito social?", opcoes: ["Disputa entre grupos ou interesses", "Disputa de futebol", "Disputa de dança", "Disputa de xadrez"], correta: 0 },
{ pergunta: "O que é consenso social?", opcoes: ["Concordância geral em normas ou valores", "Concordar com um amigo", "Acordo de jogo", "Acerto de contas"], correta: 0 },
{ pergunta: "O que é mobilidade vertical?", opcoes: ["Subir ou descer na posição social", "Subir escada", "Trocar de cidade", "Viajar de avião"], correta: 0 },
{ pergunta: "O que é mobilidade horizontal?", opcoes: ["Mudar de posição sem alterar status", "Trocar de camisa", "Trocar de sapato", "Trocar de livro"], correta: 0 },
{ pergunta: "O que é socialização primária?", opcoes: ["Aprendizado inicial na família", "Aprender na escola", "Aprender no trabalho", "Aprender na rua"], correta: 0 },
{ pergunta: "O que é socialização secundária?", opcoes: ["Aprendizado em outros grupos sociais", "Aprender a andar", "Aprender a correr", "Aprender a cozinhar"], correta: 0 },
{ pergunta: "O que é norma formal?", opcoes: ["Regra escrita e oficial", "Regra de amizade", "Regra de jogo", "Regra de etiqueta"], correta: 0 },
{ pergunta: "O que é norma informal?", opcoes: ["Regra não escrita e aceita socialmente", "Regra de matemática", "Regra de física", "Regra de química"], correta: 0 },
{ pergunta: "O que é subcultura?", opcoes: ["Cultura de um grupo dentro da sociedade maior", "Cultura global", "Cultura universal", "Cultura fictícia"], correta: 0 },
{ pergunta: "O que é contracultura?", opcoes: ["Grupo que se opõe à cultura dominante", "Grupo que segue moda", "Grupo que viaja", "Grupo que canta"], correta: 0 },
{ pergunta: "O que é socialização política?", opcoes: ["Aprender sobre participação na sociedade", "Aprender a cozinhar", "Aprender música", "Aprender artes"], correta: 0 },
{ pergunta: "O que é ruralidade?", opcoes: ["Vida no campo e práticas sociais associadas", "Vida na cidade", "Vida no espaço", "Vida nos oceanos"], correta: 0 },
{ pergunta: "O que é urbanização?", opcoes: ["Crescimento das cidades", "Crescimento das plantas", "Crescimento dos rios", "Crescimento dos animais"], correta: 0 },
{ pergunta: "O que é secularização?", opcoes: ["Separação da religião das instituições sociais", "Separação de cores", "Separação de livros", "Separação de roupas"], correta: 0 },
{ pergunta: "O que é socialismo?", opcoes: ["Sistema baseado na propriedade coletiva", "Sistema baseado em esportes", "Sistema baseado em comida", "Sistema baseado em cores"], correta: 0 },
{ pergunta: "O que é capitalismo?", opcoes: ["Sistema baseado em propriedade privada e lucro", "Sistema de cores", "Sistema de esportes", "Sistema de música"], correta: 0 },
{ pergunta: "O que é liberalismo?", opcoes: ["Ideologia que valoriza liberdade individual", "Ideologia de culinária", "Ideologia de música", "Ideologia de esportes"], correta: 0 },
{ pergunta: "O que é democracia?", opcoes: ["Sistema político baseado na participação popular", "Sistema de trânsito", "Sistema de culinária", "Sistema de transporte"], correta: 0 },
{ pergunta: "O que é ditadura?", opcoes: ["Governo com poder concentrado em uma pessoa ou grupo", "Governo de brincadeira", "Governo de esporte", "Governo de festas"], correta: 0 },
];
const perguntasSociologiaMedias = [
{ pergunta: "O que é função social de uma instituição?", opcoes: ["Papel que desempenha na sociedade", "Quantidade de membros", "Cor predominante", "Tamanho físico"], correta: 0 },
{ pergunta: "O que é solidariedade mecânica segundo Durkheim?", opcoes: ["Coesão baseada na semelhança entre indivíduos", "Coesão baseada na lei", "Coesão baseada na economia", "Coesão baseada na política"], correta: 0 },
{ pergunta: "O que é solidariedade orgânica segundo Durkheim?", opcoes: ["Coesão baseada na interdependência entre indivíduos", "Coesão baseada na força militar", "Coesão baseada na religião", "Coesão baseada na tradição"], correta: 0 },
{ pergunta: "Qual é a visão de Karl Marx sobre a sociedade?", opcoes: ["Sociedade baseada em classes e conflitos econômicos", "Sociedade baseada em religião", "Sociedade baseada na tradição", "Sociedade baseada em esportes"], correta: 0 },
{ pergunta: "O que é luta de classes?", opcoes: ["Conflito entre ricos e pobres", "Competição entre esportistas", "Debate sobre cultura", "Disputa por territórios"], correta: 0 },
{ pergunta: "O que é ideologia segundo Marx?", opcoes: ["Conjunto de ideias que justificam a ordem social", "Conjunto de leis", "Conjunto de cores", "Conjunto de músicas"], correta: 0 },
{ pergunta: "O que é ação social segundo Max Weber?", opcoes: ["Comportamento que leva em conta os outros", "Atividade física", "Trabalho manual", "Consumo de alimentos"], correta: 0 },
{ pergunta: "Quais os tipos de ação social Weber?", opcoes: ["Racional com fins, racional com valores, afetiva e tradicional", "Mecânica, orgânica, política, econômica", "Primária, secundária, terciária, quaternária", "Formal, informal, coletiva, individual"], correta: 0 },
{ pergunta: "O que é alienação segundo Marx?", opcoes: ["Distanciamento do trabalhador do produto de seu trabalho", "Distanciamento entre países", "Distanciamento do governo", "Distanciamento dos amigos"], correta: 0 },
{ pergunta: "O que é anomia segundo Durkheim?", opcoes: ["Falta de normas ou regulamentação social", "Tipo de alimentação", "Sistema político", "Princípio econômico"], correta: 0 },
{ pergunta: "O que é capital cultural segundo Bourdieu?", opcoes: ["Conhecimentos, habilidades e educação que dão vantagem social", "Dinheiro acumulado", "Riqueza em imóveis", "Quantidade de amigos"], correta: 0 },
{ pergunta: "O que é habitus segundo Bourdieu?", opcoes: ["Disposições adquiridas que guiam comportamentos", "Forma de habitar a casa", "Tipo de habitação", "Ritual religioso"], correta: 0 },
{ pergunta: "O que é mobilidade social intergeracional?", opcoes: ["Mudança de status entre gerações", "Mudança de status dentro de um dia", "Mudança de posição geográfica", "Mudança de emprego temporária"], correta: 0 },
{ pergunta: "O que é mobilidade social intrageracional?", opcoes: ["Mudança de status ao longo da vida de um indivíduo", "Mudança de casa", "Mudança de escola", "Mudança de bairro"], correta: 0 },
{ pergunta: "O que é estratificação social?", opcoes: ["Divisão da sociedade em camadas ou classes", "Divisão dos livros na biblioteca", "Divisão de cores em bandeiras", "Divisão de países"], correta: 0 },
{ pergunta: "O que é meritocracia?", opcoes: ["Sistema em que o mérito individual define posições sociais", "Sistema de herança familiar", "Sistema de sorteio", "Sistema de votação popular"], correta: 0 },
{ pergunta: "O que é modernização segundo a Sociologia?", opcoes: ["Processo de transformação social e tecnológica", "Processo de envelhecimento", "Processo de diminuição da população", "Processo de imigração"], correta: 0 },
{ pergunta: "O que é secularização?", opcoes: ["Diminuição da influência religiosa na sociedade", "Aumento da religiosidade", "Aumento da natalidade", "Aumento da população urbana"], correta: 0 },
{ pergunta: "O que é burocracia segundo Weber?", opcoes: ["Organização racional baseada em regras e hierarquia", "Grupo familiar", "Movimento cultural", "Sistema econômico informal"], correta: 0 },
{ pergunta: "O que é desigualdade de gênero?", opcoes: ["Diferenças de oportunidades entre homens e mulheres", "Diferença de altura", "Diferença de idade", "Diferença de cor"], correta: 0 },
{ pergunta: "O que é patriarcado?", opcoes: ["Sistema social em que os homens predominam", "Sistema educacional", "Sistema econômico", "Sistema político democrático"], correta: 0 },
{ pergunta: "O que é feminismo?", opcoes: ["Movimento que luta pela igualdade de gênero", "Movimento ambiental", "Movimento esportivo", "Movimento artístico"], correta: 0 },
{ pergunta: "O que é sociedade de consumo?", opcoes: ["Sociedade centrada no consumo de bens e serviços", "Sociedade agrícola", "Sociedade industrial", "Sociedade religiosa"], correta: 0 },
{ pergunta: "O que é globalização?", opcoes: ["Integração econômica, cultural e política entre países", "Separação dos países", "Estudo local da economia", "Redução do comércio internacional"], correta: 0 },
{ pergunta: "O que é multiculturalismo?", opcoes: ["Convivência de diferentes culturas numa mesma sociedade", "Adoção de uma única cultura", "Abolição de culturas", "União de religiões"], correta: 0 },
{ pergunta: "O que é socialização primária?", opcoes: ["Aprendizado inicial de normas na família", "Aprendizado na escola", "Aprendizado no trabalho", "Aprendizado em esportes"], correta: 0 },
{ pergunta: "O que é socialização secundária?", opcoes: ["Aprendizado de normas em outros grupos sociais", "Aprendizado infantil", "Aprendizado individual", "Aprendizado de linguagem"], correta: 0 },
{ pergunta: "O que é grupo de referência?", opcoes: ["Grupo que serve de modelo ou comparação", "Grupo de estudo", "Grupo familiar", "Grupo de amigos"], correta: 0 },
{ pergunta: "O que é status adquirido?", opcoes: ["Status conquistado pelo esforço pessoal", "Status herdado da família", "Status de nascimento", "Status do governo"], correta: 0 },
{ pergunta: "O que é status atribuído?", opcoes: ["Status recebido ao nascer ou sem escolha própria", "Status conquistado no trabalho", "Status escolhido na escola", "Status ganho com esforço"], correta: 0 },
{ pergunta: "O que é controle social?", opcoes: ["Mecanismos que regulam o comportamento na sociedade", "Controle de temperatura", "Controle de trânsito", "Controle de esportes"], correta: 0 },
{ pergunta: "O que é instituição total?", opcoes: ["Lugar que controla todos os aspectos da vida de indivíduos", "Lugar turístico", "Instituição escolar", "Grupo de amigos"], correta: 0 },
{ pergunta: "O que é coesão social?", opcoes: ["Força que mantém a sociedade unida", "Força de gravidade", "Força do vento", "Força elétrica"], correta: 0 },
{ pergunta: "O que é desvio positivo?", opcoes: ["Comportamento que foge da norma mas gera benefício social", "Comportamento negativo", "Comportamento prejudicial", "Comportamento neutro"], correta: 0 },
{ pergunta: "O que é desvio negativo?", opcoes: ["Comportamento que viola normas e prejudica a sociedade", "Comportamento benéfico", "Comportamento neutro", "Comportamento legal"], correta: 0 },
{ pergunta: "O que é opinião pública?", opcoes: ["Conjunto de ideias predominantes na sociedade sobre determinado tema", "Ideias de um grupo pequeno", "Ideias isoladas", "Ideias de livros"], correta: 0 },
{ pergunta: "O que é mídia segundo a Sociologia?", opcoes: ["Veículos de comunicação que influenciam a sociedade", "Aula escolar", "Jogo de esporte", "Livro de literatura"], correta: 0 },
{ pergunta: "O que é mobilização política?", opcoes: ["Ação coletiva para mudar ou influenciar decisões políticas", "Treinamento esportivo", "Festa cultural", "Evento religioso"], correta: 0 },
{ pergunta: "O que é modernidade líquida segundo Bauman?", opcoes: ["Sociedade marcada por instabilidade e mudanças constantes", "Sociedade agrícola", "Sociedade industrial", "Sociedade rural"], correta: 0 },
{ pergunta: "O que é anomia segundo Merton?", opcoes: ["Falta de correspondência entre objetivos sociais e meios disponíveis", "Ausência de leis", "Ausência de governo", "Ausência de população"], correta: 0 },
{ pergunta: "O que é capital social?", opcoes: ["Redes de relacionamento que dão vantagens sociais", "Dinheiro acumulado", "Riqueza em propriedades", "Educação formal"], correta: 0 },
{ pergunta: "O que é socialização profissional?", opcoes: ["Aprendizado de normas e valores do ambiente de trabalho", "Aprendizado infantil", "Aprendizado escolar", "Aprendizado doméstico"], correta: 0 },
{ pergunta: "O que é sociedade de risco segundo Beck?", opcoes: ["Sociedade marcada por riscos produzidos pela própria modernização", "Sociedade segura", "Sociedade agrícola", "Sociedade tradicional"], correta: 0 },
{ pergunta: "O que é cultura de massa?", opcoes: ["Cultura produzida e consumida em larga escala", "Cultura local", "Cultura de elite", "Cultura tradicional"], correta: 0 },
{ pergunta: "O que é estratificação econômica?", opcoes: ["Divisão da sociedade com base na riqueza e renda", "Divisão de cores", "Divisão de religiões", "Divisão de famílias"], correta: 0 },
{ pergunta: "O que é grupo étnico?", opcoes: ["Grupo com origem e características culturais comuns", "Grupo de amigos", "Grupo escolar", "Grupo profissional"], correta: 0 },
{ pergunta: "O que é cultura popular?", opcoes: ["Cultura praticada pelo povo, geralmente tradicional", "Cultura de elite", "Cultura estrangeira", "Cultura científica"], correta: 0 },
{ pergunta: "O que é movimento social?", opcoes: ["Ação coletiva que busca mudanças sociais ou políticas", "Competição esportiva", "Evento cultural", "Reunião familiar"], correta: 0 },
];
const perguntasSociologiaDificeis = [
{pergunta:"A energia total relativística é dada por:",opcoes:["E=mc²","E=mv","E=γmc²","E=1/2mv²"],correta:2},
{pergunta:"A condição para interferência destrutiva é:",opcoes:["Δd=nλ","Δd=λ/4","Δd=(n+1/2)λ","Δd=λ/3"],correta:2},
{pergunta:"A força magnética sobre uma carga é:",opcoes:["qE","qvBsenθ","mv²/r","B/q"],correta:1},
{pergunta:"A energia de um fóton depende de:",opcoes:["m","v","f","r"],correta:2},
{pergunta:"A velocidade orbital correta é:",opcoes:["v=GM/r²","v=r/GM","v=GM","v=√(GM/r)"],correta:3},
{pergunta:"A variação do fluxo magnético gera:",opcoes:["Calor","Força normal","Aumento da pressão","FEM"],correta:3},
{pergunta:"A força nuclear que mantém núcleons unidos é a:",opcoes:["Fraca","Eletrostática","Forte","Magnética"],correta:2},
{pergunta:"A ressonância ocorre quando:",opcoes:["Amplitude é zero","Sistema não oscila","Frequência externa difere da natural","Frequência externa é igual à natural"],correta:3},
{pergunta:"O momento de uma partícula segundo De Broglie é:",opcoes:["p=h/λ","p=λh","p=λ/2","p=λE"],correta:0},
{pergunta:"O fenômeno de mudança de frequência devido ao movimento é:",opcoes:["Hall","Raman","Doppler","Faraday"],correta:2},
{pergunta:"A difração é mais intensa quando:",opcoes:["λ≪a","λ≈0","λ≫a","a→∞"],correta:2},
{pergunta:"A força centrípeta é:",opcoes:["mv²/r","mg","kq/r²","qvB"],correta:0},
{pergunta:"A expressão da energia elástica é:",opcoes:["mg","mv²/r","1/2kx²","qvB"],correta:2},
{pergunta:"A energia cinética relativística é:",opcoes:["1/2mv²","qV","(γ−1)mc²","mc²"],correta:2},
{pergunta:"A luz refrata porque:",opcoes:["Índice muda","Velocidade constante","Frequência muda","Meio é opaco"],correta:0},
{pergunta:"A lei que relaciona fluxo e carga elétrica é:",opcoes:["Gauss","Faraday","Lenz","Kepler"],correta:0},
{pergunta:"A corrente induzida se opõe à variação do fluxo segundo:",opcoes:["Ohm","Lenz","Snell","Hooke"],correta:1},
{pergunta:"A temperatura afeta a velocidade do som porque altera:",opcoes:["Volume","Densidade do ar","Carga elétrica","Índice de refração"],correta:1},
{pergunta:"O índice de refração é:",opcoes:["n=v/c","n=vλ","n=λf","n=c/v"],correta:3},
{pergunta:"A força eletrostática entre cargas é:",opcoes:["GMm/r²","mv²/r","1/2kx²","kq1q2/r²"],correta:3},
{pergunta:"A entropia em sistemas isolados:",opcoes:["Diminui","Oscila","Aumenta","Permanece nula"],correta:2},
{pergunta:"A fórmula do efeito fotoelétrico é:",opcoes:["E=mc²","E=hf−Φ","E=qV","E=1/2mv²"],correta:1},
{pergunta:"O comprimento de onda em uma corda depende de:",opcoes:["Tensão e densidade linear","Carga","Temperatura","Volume"],correta:0},
{pergunta:"O fluxo elétrico mede:",opcoes:["Força total","Campo magnético","Campo elétrico atravessando uma superfície","Velocidade da onda"],correta:2},
{pergunta:"A força de Lorentz é:",opcoes:["qB","q(E+v×B)","mv²/r","kq/r²"],correta:1},
{pergunta:"A terceira lei de Newton afirma que:",opcoes:["F=ma","Toda ação tem reação","Energia se conserva","Impulso é FΔt"],correta:1},
{pergunta:"A radiação térmica aumenta com:",opcoes:["Temperatura²","Temperatura⁴","Massa","Pressão"],correta:1},
{pergunta:"O torque depende de:",opcoes:["Força e distância","Massa","Tempo","Calor"],correta:0},
{pergunta:"O campo magnético ao redor de um fio depende de:",opcoes:["Tensão","Resistência","Corrente","Temperatura"],correta:2},
{pergunta:"A velocidade de escape depende de:",opcoes:["Volume e massa","Massa e raio do planeta","Pressão e densidade","Carga e campo"],correta:1},
{pergunta:"A relação v=λf descreve:",opcoes:["Ondas","Calor","Gravidade","Eletricidade"],correta:0},
{pergunta:"A reflexão interna total ocorre quando:",opcoes:["Ângulo=0","Ângulo menor que crítico","Ângulo maior que crítico","Meio é opaco"],correta:2},
{pergunta:"A força peso é:",opcoes:["mv²/r","mg","qE","mgh"],correta:1},
{pergunta:"A energia interna de um gás depende da:",opcoes:["Temperatura","Pressão","Massa","Carga"],correta:0},
{pergunta:"A lei de Snell relaciona:",opcoes:["Corrente e resistência","Velocidade e massa","Ângulos e índices de refração","Carga e campo"],correta:2},
{pergunta:"Uma onda estacionária possui:",opcoes:["Nodos e ventres","Som apenas","Pressão constante","Campo uniforme"],correta:0},
{pergunta:"A força resultante nula implica:",opcoes:["Movimento variado","Rotação","Equilíbrio","Aumento de energia"],correta:2},
{pergunta:"O trabalho da força peso depende de:",opcoes:["Altitude","Tempo","Carga","Pressão"],correta:0},
{pergunta:"A energia potencial gravitacional é:",opcoes:["GMm/r","−GMm/r","1/2kx²","qV"],correta:1},
{pergunta:"A densidade da água varia com:",opcoes:["Temperatura","Volume","Velocidade","Carga"],correta:0},
{pergunta:"A compressão máxima de uma mola depende de:",opcoes:["Altura e massa","Tempo","Campo elétrico","Pressão"],correta:0},
{pergunta:"A lei dos gases ideais é:",opcoes:["PV=nRT","F=ma","P=F/A","V=λf"],correta:0},
{pergunta:"A resistência equivalente em série é:",opcoes:["R1+R2","1/(1/R1+1/R2)","R1−R2","R1R2"],correta:0},
{pergunta:"A reflexão especular ocorre em:",opcoes:["Superfícies lisas","Superfícies rugosas","Meios opacos","Campos magnéticos"],correta:0},
{pergunta:"A força de atrito depende de:",opcoes:["Massa","Normal e coeficiente","Volume","Carga"],correta:1},
{pergunta:"A temperatura absoluta é medida em:",opcoes:["°C","°F","K","J"],correta:2},
{pergunta:"A energia de ligação nuclear mantém:",opcoes:["Elétrons nas órbitas","Núcleo coeso","Fótons presos","Cargas neutras"],correta:1},
{pergunta:"A capacitância depende de:",opcoes:["Área e distância","Tensão","Resistência","Pressão"],correta:0},
{pergunta:"A força elástica obedece a:",opcoes:["Lei de Hooke","Lei de Coulomb","Lei de Faraday","Lei de Ohm"],correta:0},
{pergunta:"A dilatação temporal ocorre quando:",opcoes:["Velocidade próxima da luz","Baixa velocidade","Temperatura alta","Pressão alta"],correta:0}
];

const perguntasEdFisicaFaceis = [

];
const perguntasEdFisicaMedias = [];
const perguntasEdFisicaDificeis = [];

const perguntasArtesFaceis = [];
const perguntasArtesMedias = [];
const perguntasArtesDificeis = [];

/* ==========================================================
   10. BANCO PRINCIPAL (matéria → dificuldade → lista)
   ========================================================== */
const bancoMaterias = {
    matematica: {
        facil: perguntasMatematicaFaceis,
        media: perguntasMatematicaMedias,
        dificil: perguntasMatematicaDificeis
    },
    portugues: {
        facil: perguntasPortuguesFaceis,
        media: perguntasPortuguesMedias,
        dificil: perguntasPortuguesDificeis
    },
    ingles: {
        facil: perguntasInglesFaceis,
        media: perguntasInglesMedias,
        dificil: perguntasInglesDificeis
    },
    historia: {
        facil: perguntasHistoriaFaceis,
        media: perguntasHistoriaMedias,
        dificil: perguntasHistoriaDificeis
    },
    geografia: {
        facil: perguntasGeografiaFaceis,
        media: perguntasGeografiaMedias,
        dificil: perguntasGeografiaDificeis
    },
    ciencias: {
        facil: perguntasCienciasFaceis,
        media: perguntasCienciasMedias,
        dificil: perguntasCienciasDificeis
    },
    fisica: {
        facil: perguntasFisicaFaceis,
        media: perguntasFisicaMedias,
        dificil: perguntasFisicaDificeis
    },
    quimica: {
        facil: perguntasQuimicaFaceis,
        media: perguntasQuimicaMedias,
        dificil: perguntasQuimicaDificeis
    },
    biologia: {
        facil: perguntasBiologiaFaceis,
        media: perguntasBiologiaMedias,
        dificil: perguntasBiologiaDificeis
    },
    filosofia: {
        facil: perguntasFilosofiaFaceis,
        media: perguntasFilosofiaMedias,
        dificil: perguntasFilosofiaDificeis
    },
    sociologia: {
        facil: perguntasSociologiaFaceis,
        media: perguntasSociologiaMedias,
        dificil: perguntasSociologiaDificeis
    },
    edfisica: {
        facil: perguntasEdFisicaFaceis,
        media: perguntasEdFisicaMedias,
        dificil: perguntasEdFisicaDificeis
    },
    artes: {
        facil: perguntasArtesFaceis,
        media: perguntasArtesMedias,
        dificil: perguntasArtesDificeis
    }
};

/* ==========================================================
   11. FUNÇÕES DO FILTRO (matéria + dificuldade)
   ========================================================== */
function atualizarPerguntasCombinadas() {
    if (!materiaSelecionada || !dificuldadeSelecionada) {
        perguntasQuiz = [];
        return;
    }

    const materia = bancoMaterias[materiaSelecionada];
    if (!materia) {
        perguntasQuiz = [];
        return;
    }

    perguntasQuiz = materia[dificuldadeSelecionada] || [];
    console.log("Matéria:", materiaSelecionada, "Dificuldade:", dificuldadeSelecionada, "Perguntas:", perguntasQuiz.length);
}

function atualizarPerguntasPorMateria() {
    const select = document.getElementById("materiaSelect");
    materiaSelecionada = select ? select.value : null;
    atualizarPerguntasCombinadas();
}

function atualizarPerguntasPorDificuldade() {
    const select = document.getElementById("dificuldadeSelect");
    dificuldadeSelecionada = select ? select.value : null;
    atualizarPerguntasCombinadas();
}

/* associe os eventos (se os selects já existirem no DOM) */
const materiaSelectEl = document.getElementById("materiaSelect");
if (materiaSelectEl) materiaSelectEl.addEventListener("change", atualizarPerguntasPorMateria);
const dificuldadeSelectEl = document.getElementById("dificuldadeSelect");
if (dificuldadeSelectEl) dificuldadeSelectEl.addEventListener("change", atualizarPerguntasPorDificuldade);

/* ==========================================================
   12. MOSTRAR PERGUNTA (quando o boss for derrotado)
   ========================================================== */
function mostrarPerguntaQuiz() {
  if (!perguntasQuiz || perguntasQuiz.length === 0) {
    alert("⚠️ Nenhuma pergunta disponível nesta matéria/dificuldade!");
    return;
  }

  pauseTimer();

  const quizContainer = document.getElementById("quiz-container");
  const perguntaTexto = document.getElementById("quiz-question");
  const opcoesContainer = document.getElementById("quiz-options");

  const perguntaAleatoria = perguntasQuiz[Math.floor(Math.random() * perguntasQuiz.length)];

  perguntaTexto.textContent = perguntaAleatoria.pergunta;
  opcoesContainer.innerHTML = '';

  perguntaAleatoria.opcoes.forEach((opcao, i) => {
    const btn = document.createElement('button');
    btn.textContent = opcao;
    btn.className = 'quiz-option';
    btn.onclick = () => verificarResposta(i === perguntaAleatoria.correta);
    opcoesContainer.appendChild(btn);
  });

  quizContainer.style.display = 'flex';
}

/* ==========================================================
   13. VERIFICAR RESPOSTA
   ========================================================== */
function verificarResposta(correta) {
  const quizContainer = document.getElementById("quiz-container");
  quizContainer.style.display = 'none';

  if (correta) {
    showAlert('✅ Resposta correta! Continue a aventura!');
  } else {
    showAlert('❌ Resposta errada! Você perdeu 3 minutos!');
    timer = Math.max(timer - 180, 0);
    timerDisplay.textContent = formatTime(timer);
  }

  startTimer();
}

/* ==========================================================
   14. QUANDO O BOSS FOR DERROTADO (chama partículas + quiz)
   ========================================================== */
function createBossParticles(element) {
  const rect = element.getBoundingClientRect();
  for (let i = 0; i < 20; i++) {
    const p = document.createElement('div');
    p.className = 'particle';
    p.style.left = `${rect.left + rect.width / 2}px`;
    p.style.top = `${rect.top + rect.height / 2}px`;
    p.style.background = '#E53935';
    p.style.setProperty('--tx', `${Math.random() * 200 - 100}px`);
    p.style.setProperty('--ty', `${Math.random() * 200 - 100}px`);
    particlesContainer.appendChild(p);
    setTimeout(() => p.remove(), 1000);
  }

  setTimeout(() => {
    mostrarPerguntaQuiz();
  }, 800);
}

/* ==========================================================
   15. Inicialização final (garantir selects atualizados)
   ========================================================== */
// atualiza selects se já tiverem valor (útil ao recarregar)
if (materiaSelectEl && materiaSelectEl.value) {
  materiaSelecionada = materiaSelectEl.value;
}
if (dificuldadeSelectEl && dificuldadeSelectEl.value) {
  dificuldadeSelecionada = dificuldadeSelectEl.value;
}
atualizarPerguntasCombinadas();

/* ==========================================================
   16. atualização de raking
   ========================================================== */

/* ==========================================================
   FIM DO SCRIPT
   ========================================================== */

</script>
</body>
</html>
