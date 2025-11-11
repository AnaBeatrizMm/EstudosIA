<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Batalha do Cavaleiro - Jogo de Aventura</title>

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
      <li><a href="cronometro.php">Voltar</a></li>
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
      <!-- Nenhum jogador cadastrado ainda -->
    </tbody>
  </table>
</div>


<script>
/* ==========================================================
   ⚔️ CRONÔMETRO GAMIFICADO — SCRIPT COMPLETO E OTIMIZADO
   Estrutura:
   1. VARIÁVEIS GLOBAIS
   2. CONTROLE DO TEMPO
   3. CENÁRIO E CLIMA
   4. INIMIGOS E BOSS
   5. ATAQUE AUTOMÁTICO E COMBATE
   6. PARTÍCULAS E EFEITOS
   7. LOOP PRINCIPAL E EVENTOS
   ========================================================== */

/* =============== 1. VARIÁVEIS GLOBAIS =============== */
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
const BOSS_INTERVAL_SECONDS = 5; // a cada 10 minutos
const BOSS_ON_START = false;       // true = boss aparece logo ao iniciar

/* =============== 2. CONTROLE DO TEMPO =============== */
function formatTime(seconds) {
  const m = Math.floor(seconds / 60);
  const s = seconds % 60;
  return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
}

function updateTimer() {
  timer++;
  timerDisplay.textContent = formatTime(timer);
  distance += 5;
  distanceDisplay.textContent = `${distance}m`;
  updateWeatherAndScenery();
}

function startTimer() {
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

/* =============== 3. CENÁRIO E CLIMA =============== */
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

/* =============== 4. INIMIGOS E BOSS =============== */
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
    </div>
  `;
  return d;
}

function showBossAlert() {
  const alert = document.createElement('div');
  alert.className = 'boss-alert';
  alert.textContent = '⚠️ UM BOSS SURGIU! PREPARE-SE!';
  document.body.appendChild(alert);
  setTimeout(() => { alert.remove(); }, 3000);
}

/* =============== 5. ATAQUE AUTOMÁTICO E COMBATE =============== */
function updateEnemies() {
  if (!isRunning) return;

  const kRect = knight.getBoundingClientRect();
  const knightCenterX = kRect.left + kRect.width / 2;
  const knightCenterY = kRect.top + kRect.height / 2;
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
    const eCenterY = eRect.top + eRect.height / 2;
    const dx = eCenterX - knightCenterX;
    const dy = eCenterY - knightCenterY;
    const distance = Math.sqrt(dx * dx + dy * dy);

    const PROXIMITY = enemy.isBoss ? 200 : 140;
    if (distance < PROXIMITY) {
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

/* =============== 6. PARTÍCULAS E EFEITOS =============== */
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
    const colors = ['#FF0000', '#FF4500', '#FFD700'];
    p.style.background = colors[Math.floor(Math.random() * colors.length)];
    particlesContainer.appendChild(p);
    setTimeout(() => p.remove(), 1200);
  }
}

/* =============== 7. LOOP PRINCIPAL E EVENTOS =============== */
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
    s.style.opacity = currentWeather === 'Noite'
      ? (Math.random() > 0.5 ? '1' : '0.5')
      : '0';
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
   🧩 SISTEMA DE PERGUNTAS (aparece ao derrotar o Boss)
   ========================================================== */

/* Perguntas de exemplo — você pode adicionar quantas quiser */
  // === 📘 Matemática — Fáceis ===
const perguntasMatematicaFaceis = [
  { pergunta: "Quanto é 7 × 8?", opcoes: ["54", "56", "64", "58"], correta: 1 },
  { pergunta: "Quanto é 9 + 6?", opcoes: ["13", "14", "15", "16"], correta: 2 },
  { pergunta: "Qual é o dobro de 12?", opcoes: ["22", "24", "26", "30"], correta: 1 },
  { pergunta: "Quanto é 100 ÷ 4?", opcoes: ["20", "25", "30", "40"], correta: 1 },
  { pergunta: "Qual é o resultado de 5²?", opcoes: ["10", "15", "20", "25"], correta: 3 },
  { pergunta: "Qual é a metade de 10?", opcoes: ["2", "4", "5", "6"], correta: 2 },
  { pergunta: "Quanto é 15 + 28?", opcoes: ["42", "43", "41", "44"], correta: 1 },
  { pergunta: "Se 2 + x = 7, o valor de x é:", opcoes: ["3", "4", "5", "6"], correta: 2 },
  { pergunta: "Qual é o sucessor de 999?", opcoes: ["1000", "998", "1001", "9999"], correta: 0 },
  { pergunta: "Quanto é 18 ÷ 3?", opcoes: ["5", "6", "7", "8"], correta: 1 },
  { pergunta: "Qual é o triplo de 11?", opcoes: ["22", "33", "44", "30"], correta: 1 },
  { pergunta: "Se um número é par, ele é divisível por:", opcoes: ["3", "5", "2", "7"], correta: 2 },
  { pergunta: "Quanto é 1/2 + 1/2?", opcoes: ["1", "2", "1/2", "3/2"], correta: 0 },
  { pergunta: "Qual número vem depois de 499?", opcoes: ["498", "500", "501", "600"], correta: 1 },
  { pergunta: "Qual é o quadrado de 9?", opcoes: ["18", "27", "36", "81"], correta: 3 },
  { pergunta: "Qual é o resultado de 8 × 5?", opcoes: ["35", "40", "45", "50"], correta: 1 },
  { pergunta: "O número 15 é:", opcoes: ["Ímpar", "Par", "Primo", "Decimal"], correta: 0 },
  { pergunta: "Se João tem 5 balas e ganha mais 3, ele fica com:", opcoes: ["6", "7", "8", "9"], correta: 2 },
  { pergunta: "Qual é o valor de 20% de 50?", opcoes: ["5", "8", "10", "12"], correta: 2 },
  { pergunta: "Quanto é 0 + 0?", opcoes: ["0", "1", "2", "Nenhum"], correta: 0 },
  { pergunta: "Quanto é 6 + 7?", opcoes: ["11", "12", "13", "14"], correta: 2 },
  { pergunta: "Qual é a metade de 8?", opcoes: ["2", "3", "4", "5"], correta: 2 },
  { pergunta: "Qual é o resultado de 3 × 5?", opcoes: ["8", "12", "15", "18"], correta: 2 },
  { pergunta: "Quanto é 9 − 4?", opcoes: ["3", "4", "5", "6"], correta: 2 },
  { pergunta: "Quanto é 10 + 25?", opcoes: ["33", "34", "35", "36"], correta: 2 },
  { pergunta: "Qual número vem antes de 50?", opcoes: ["49", "51", "48", "47"], correta: 0 },
  { pergunta: "Quanto é 12 ÷ 3?", opcoes: ["3", "4", "5", "6"], correta: 1 },
  { pergunta: "Se Ana tem 4 maçãs e ganha mais 3, ela tem:", opcoes: ["6", "7", "8", "9"], correta: 1 },
  { pergunta: "Qual é o dobro de 9?", opcoes: ["16", "17", "18", "19"], correta: 2 },
  { pergunta: "Quanto é 5 × 5?", opcoes: ["10", "15", "20", "25"], correta: 3 },
  { pergunta: "Se 10% de 50 é igual a:", opcoes: ["2", "3", "4", "5"], correta: 3 },
  { pergunta: "Quanto é 2 + 2 × 2?", opcoes: ["6", "8", "4", "10"], correta: 0 },
  { pergunta: "Quanto é 20 ÷ 5?", opcoes: ["2", "3", "4", "5"], correta: 3 },
  { pergunta: "Qual número é par?", opcoes: ["13", "15", "18", "21"], correta: 2 },
  { pergunta: "Qual é o quadrado de 4?", opcoes: ["8", "12", "16", "20"], correta: 2 },
  { pergunta: "Se um ano tem 12 meses, quantos meses há em 3 anos?", opcoes: ["24", "30", "33", "36"], correta: 3 },
  { pergunta: "Quanto é 14 + 9?", opcoes: ["21", "22", "23", "24"], correta: 2 },
  { pergunta: "Quanto é 3 × 9?", opcoes: ["18", "24", "27", "30"], correta: 2 },
  { pergunta: "Qual é o resultado de 25 ÷ 5?", opcoes: ["4", "5", "6", "7"], correta: 1 },
  { pergunta: "Se um dia tem 24 horas, quantas horas tem 2 dias?", opcoes: ["36", "40", "44", "48"], correta: 3 },
  { pergunta: "Quanto é 7 + 5?", opcoes: ["11", "12", "13", "14"], correta: 1 },
  { pergunta: "Quanto é 30 − 12?", opcoes: ["15", "16", "17", "18"], correta: 1 },
  { pergunta: "Se uma dúzia tem 12 ovos, meia dúzia tem:", opcoes: ["4", "5", "6", "8"], correta: 2 },
  { pergunta: "Quanto é 100 − 25?", opcoes: ["65", "70", "75", "80"], correta: 2 },
  { pergunta: "Se 1 real vale 100 centavos, quanto vale 2 reais?", opcoes: ["150", "200", "250", "300"], correta: 1 },
  { pergunta: "Qual número é ímpar?", opcoes: ["8", "10", "11", "12"], correta: 2 },
  { pergunta: "Quanto é 9 × 3?", opcoes: ["18", "27", "30", "33"], correta: 1 },
  { pergunta: "Se uma pizza tem 8 fatias e você come 2, sobram:", opcoes: ["4", "5", "6", "7"], correta: 2 },
  { pergunta: "Quanto é 4 + 4 + 4?", opcoes: ["10", "11", "12", "13"], correta: 2 },
  { pergunta: "Qual é o antecessor de 101?", opcoes: ["99", "100", "102", "103"], correta: 1 }
];
  // === 📘 Matemática — Médias ===
const perguntasMatematicaMedias = [

  { pergunta: "Qual é 25% de 200?", opcoes: ["25", "40", "50", "100"], correta: 2 },
  { pergunta: "Um produto custa R$100 e tem desconto de 20%. Qual o novo preço?", opcoes: ["R$70", "R$75", "R$80", "R$85"], correta: 2 },
  { pergunta: "A fração 4/8 pode ser simplificada para:", opcoes: ["1/4", "1/2", "2/4", "3/4"], correta: 1 },
  { pergunta: "Se 2 kg de arroz custam R$10, quanto custam 5 kg?", opcoes: ["R$15", "R$20", "R$25", "R$30"], correta: 2 },
  { pergunta: "Uma loja vendeu 80 produtos em um mês. Se aumentou as vendas em 25%, quantos produtos vendeu no mês seguinte?", opcoes: ["90", "95", "100", "105"], correta: 2 },
  { pergunta: "Um número dividido por 5 tem como resultado 9. O número é:", opcoes: ["40", "45", "50", "55"], correta: 1 },
  { pergunta: "Qual é o valor da expressão: (6 + 2) × 3?", opcoes: ["18", "24", "27", "30"], correta: 0 },
  { pergunta: "Resolva: (10 − 4) × (5 + 1)", opcoes: ["30", "32", "34", "36"], correta: 3 },
  { pergunta: "Em uma sala há 12 meninos e 8 meninas. A razão entre meninos e meninas é:", opcoes: ["2/3", "3/2", "1/2", "2/1"], correta: 1 },
  { pergunta: "A razão entre 8 e 4 é:", opcoes: ["1/2", "2", "4", "8"], correta: 1 },
  { pergunta: "Em uma receita, 3 ovos fazem 12 bolos. Quantos bolos 5 ovos fazem?", opcoes: ["18", "19", "20", "21"], correta: 2 },
  { pergunta: "A proporção 2/3 = x/6 tem como solução:", opcoes: ["3", "4", "2", "6"], correta: 1 },
  { pergunta: "Se um produto de R$80 tem 10% de desconto, ele passa a custar:", opcoes: ["R$70", "R$72", "R$74", "R$76"], correta: 1 },
  { pergunta: "Qual é o resultado de (3² + 4²)?", opcoes: ["12", "24", "25", "26"], correta: 2 },
  { pergunta: "Se 20% de um número é 40, o número é:", opcoes: ["100", "150", "200", "250"], correta: 2 },
  { pergunta: "Uma viagem de 300 km é feita em 5 horas. Qual é a velocidade média?", opcoes: ["40 km/h", "50 km/h", "55 km/h", "60 km/h"], correta: 1 },
  { pergunta: "Se um número é 3 vezes maior que 12, ele é:", opcoes: ["24", "30", "36", "40"], correta: 2 },
  { pergunta: "Em 2x + 6 = 10, o valor de x é:", opcoes: ["1", "2", "3", "4"], correta: 1 },
  { pergunta: "O quadrado de 5 somado ao dobro de 4 é:", opcoes: ["25", "33", "34", "35"], correta: 2 },
  { pergunta: "A soma dos ângulos internos de um quadrado é:", opcoes: ["180°", "270°", "360°", "540°"], correta: 2 },
  { pergunta: "Qual é 25% de 200?", opcoes: ["25", "40", "50", "100"], correta: 2 },
  { pergunta: "Um produto custa R$100 e tem desconto de 20%. Qual o novo preço?", opcoes: ["R$70", "R$75", "R$80", "R$85"], correta: 2 },
  { pergunta: "A fração 4/8 pode ser simplificada para:", opcoes: ["1/4", "1/2", "2/4", "3/4"], correta: 1 },
  { pergunta: "Se 2 kg de arroz custam R$10, quanto custam 5 kg?", opcoes: ["R$15", "R$20", "R$25", "R$30"], correta: 2 },
  { pergunta: "Uma loja vendeu 80 produtos em um mês. Se aumentou as vendas em 25%, quantos produtos vendeu no mês seguinte?", opcoes: ["90", "95", "100", "105"], correta: 2 },
  { pergunta: "Um número dividido por 5 tem como resultado 9. O número é:", opcoes: ["40", "45", "50", "55"], correta: 1 },
  { pergunta: "Qual é o valor da expressão (6 + 2) × 3?", opcoes: ["18", "24", "27", "30"], correta: 0 },
  { pergunta: "Resolva: (10 − 4) × (5 + 1)", opcoes: ["30", "32", "34", "36"], correta: 3 },
  { pergunta: "Em uma sala há 12 meninos e 8 meninas. A razão entre meninos e meninas é:", opcoes: ["2/3", "3/2", "1/2", "2/1"], correta: 1 },
  { pergunta: "A razão entre 8 e 4 é:", opcoes: ["1/2", "2", "4", "8"], correta: 1 },
  { pergunta: "Em uma receita, 3 ovos fazem 12 bolos. Quantos bolos 5 ovos fazem?", opcoes: ["18", "19", "20", "21"], correta: 2 },
  { pergunta: "A proporção 2/3 = x/6 tem como solução:", opcoes: ["3", "4", "2", "6"], correta: 1 },
  { pergunta: "Se um produto de R$80 tem 10% de desconto, ele passa a custar:", opcoes: ["R$70", "R$72", "R$74", "R$76"], correta: 1 },
  { pergunta: "Qual é o resultado de (3² + 4²)?", opcoes: ["12", "24", "25", "26"], correta: 2 },
  { pergunta: "Se 20% de um número é 40, o número é:", opcoes: ["100", "150", "200", "250"], correta: 2 },
  { pergunta: "Uma viagem de 300 km é feita em 5 horas. Qual é a velocidade média?", opcoes: ["40 km/h", "50 km/h", "55 km/h", "60 km/h"], correta: 1 },
  { pergunta: "Se um número é 3 vezes maior que 12, ele é:", opcoes: ["24", "30", "36", "40"], correta: 2 },
  { pergunta: "Em 2x + 6 = 10, o valor de x é:", opcoes: ["1", "2", "3", "4"], correta: 1 },
  { pergunta: "O quadrado de 5 somado ao dobro de 4 é:", opcoes: ["25", "33", "34", "35"], correta: 2 },
  { pergunta: "A soma dos ângulos internos de um quadrado é:", opcoes: ["180°", "270°", "360°", "540°"], correta: 2 },
  { pergunta: "Se 3/4 de um número é 24, qual é o número?", opcoes: ["28", "30", "32", "36"], correta: 2 },
  { pergunta: "Qual é o resultado de 5³?", opcoes: ["25", "75", "100", "125"], correta: 3 },
  { pergunta: "O perímetro de um quadrado com lado 6 cm é:", opcoes: ["18 cm", "20 cm", "22 cm", "24 cm"], correta: 3 },
  { pergunta: "Uma loja tem 15 funcionários. Se 1/3 são mulheres, quantos são homens?", opcoes: ["5", "8", "10", "12"], correta: 2 },
  { pergunta: "Se 6x = 48, então x é:", opcoes: ["6", "7", "8", "9"], correta: 2 },
  { pergunta: "Qual é o número que somado com 15 resulta em 40?", opcoes: ["20", "22", "25", "30"], correta: 2 },
  { pergunta: "O triplo de 7 somado a 5 é:", opcoes: ["25", "26", "27", "28"], correta: 0 },
  { pergunta: "Uma bicicleta custa R$800 e tem acréscimo de 15%. O novo valor é:", opcoes: ["R$860", "R$880", "R$920", "R$940"], correta: 2 },
  { pergunta: "A média aritmética de 8, 10 e 14 é:", opcoes: ["10", "11", "12", "13"], correta: 2 },
  { pergunta: "Em uma urna há 5 bolas vermelhas e 15 azuis. A probabilidade de tirar uma vermelha é:", opcoes: ["1/3", "1/4", "1/2", "2/3"], correta: 0 }

];

// === 📘 Matemática — Geometria ===
const perguntasMatematicaGeometria = [
  { pergunta: "Qual é a soma dos ângulos internos de um triângulo?", opcoes: ["90°", "120°", "180°", "360°"], correta: 2 },
  { pergunta: "Um quadrado tem lados de 5 cm. Qual é seu perímetro?", opcoes: ["10 cm", "15 cm", "20 cm", "25 cm"], correta: 2 },
  { pergunta: "A área de um retângulo é dada por:", opcoes: ["base + altura", "base × altura", "base ÷ altura", "base²"], correta: 1 },
  { pergunta: "Um triângulo equilátero possui:", opcoes: ["1 lado igual", "2 lados iguais", "3 lados iguais", "lados diferentes"], correta: 2 },
  { pergunta: "O perímetro de um triângulo com lados 3 cm, 4 cm e 5 cm é:", opcoes: ["10 cm", "11 cm", "12 cm", "13 cm"], correta: 1 },
  { pergunta: "O raio de um círculo mede 7 cm. O diâmetro mede:", opcoes: ["3,5 cm", "7 cm", "10 cm", "14 cm"], correta: 3 },
  { pergunta: "A área de um quadrado com lado 6 cm é:", opcoes: ["12 cm²", "24 cm²", "36 cm²", "48 cm²"], correta: 2 },
  { pergunta: "Quantos lados tem um hexágono?", opcoes: ["5", "6", "7", "8"], correta: 1 },
  { pergunta: "A figura com quatro lados e quatro ângulos iguais é chamada de:", opcoes: ["Trapézio", "Retângulo", "Paralelogramo", "Triângulo"], correta: 1 },
  { pergunta: "O que é o raio de um círculo?", opcoes: ["A metade do diâmetro", "A circunferência", "A soma dos lados", "O centro do quadrado"], correta: 0 },
  { pergunta: "Quantos graus tem um ângulo reto?", opcoes: ["45°", "60°", "90°", "120°"], correta: 2 },
  { pergunta: "Um losango tem:", opcoes: ["Todos os lados iguais", "Dois lados iguais", "Lados diferentes", "Apenas um ângulo reto"], correta: 0 },
  { pergunta: "O volume de um cubo é calculado por:", opcoes: ["lado²", "lado³", "4 × lado", "lado ÷ 3"], correta: 1 },
  { pergunta: "Em um triângulo retângulo, o lado oposto ao ângulo de 90° é chamado de:", opcoes: ["base", "altura", "hipotenusa", "cateto"], correta: 2 },
  { pergunta: "O perímetro de um retângulo de 8 m de base e 4 m de altura é:", opcoes: ["12 m", "20 m", "24 m", "32 m"], correta: 2 },
  { pergunta: "Qual é a área de um triângulo de base 10 cm e altura 4 cm?", opcoes: ["10 cm²", "20 cm²", "30 cm²", "40 cm²"], correta: 1 },
  { pergunta: "Um polígono com 8 lados é um:", opcoes: ["Pentágono", "Hexágono", "Heptágono", "Octógono"], correta: 3 },
  { pergunta: "O ângulo de 180° é chamado de:", opcoes: ["Agudo", "Reto", "Obtuso", "Raso"], correta: 3 },
  { pergunta: "A área de um círculo é calculada por:", opcoes: ["2πr", "πr²", "πr³", "r²"], correta: 1 },
  { pergunta: "Quantos vértices tem um cubo?", opcoes: ["6", "8", "10", "12"], correta: 1 },
  { pergunta: "Quantos lados tem um hexágono?", opcoes: ["4", "5", "6", "8"], correta: 2 },
  { pergunta: "Quantos lados tem um hexágono?", opcoes: ["4", "5", "6", "8"], correta: 2 },
  { pergunta: "Qual é a soma dos ângulos internos de um triângulo?", opcoes: ["90°", "120°", "180°", "270°"], correta: 2 },
  { pergunta: "Quantos graus tem um ângulo reto?", opcoes: ["45°", "60°", "90°", "180°"], correta: 2 },
  { pergunta: "Um quadrado tem lados medindo 5 cm. Seu perímetro é:", opcoes: ["10 cm", "15 cm", "20 cm", "25 cm"], correta: 2 },
  { pergunta: "O diâmetro de uma circunferência é o:", opcoes: ["raio", "metade do raio", "dobro do raio", "centro"], correta: 2 },
  { pergunta: "Um triângulo equilátero tem:", opcoes: ["3 lados iguais", "2 lados iguais", "1 lado maior", "nenhum lado igual"], correta: 0 },
  { pergunta: "O perímetro de um retângulo com lados 4 cm e 6 cm é:", opcoes: ["10 cm", "16 cm", "20 cm", "24 cm"], correta: 2 },
  { pergunta: "A área de um quadrado de lado 8 cm é:", opcoes: ["32 cm²", "48 cm²", "56 cm²", "64 cm²"], correta: 3 },
  { pergunta: "A área de um triângulo é dada por:", opcoes: ["base × altura", "(base × altura) ÷ 2", "lado × lado", "base + altura"], correta: 1 },
  { pergunta: "Qual é o nome do polígono com 8 lados?", opcoes: ["Hexágono", "Pentágono", "Heptágono", "Octógono"], correta: 3 },
  { pergunta: "Um círculo com raio de 3 cm tem diâmetro de:", opcoes: ["3 cm", "6 cm", "9 cm", "12 cm"], correta: 1 },
  { pergunta: "Quantos vértices tem um cubo?", opcoes: ["6", "8", "10", "12"], correta: 1 },
  { pergunta: "O volume de um cubo é dado por:", opcoes: ["lado²", "lado³", "lado⁴", "2 × lado³"], correta: 1 },
  { pergunta: "Um retângulo tem área 24 cm² e base 6 cm. Sua altura é:", opcoes: ["2 cm", "3 cm", "4 cm", "5 cm"], correta: 2 },
  { pergunta: "Quantas faces tem um prisma triangular?", opcoes: ["4", "5", "6", "7"], correta: 1 },
  { pergunta: "A soma dos ângulos internos de um quadrado é:", opcoes: ["180°", "270°", "360°", "540°"], correta: 2 },
  { pergunta: "Qual é o nome do polígono com 10 lados?", opcoes: ["Decágono", "Nonágono", "Hexágono", "Heptágono"], correta: 0 },
  { pergunta: "Um círculo tem raio de 7 cm. O diâmetro mede:", opcoes: ["7 cm", "10 cm", "12 cm", "14 cm"], correta: 3 },
  { pergunta: "O retângulo é um:", opcoes: ["quadrilátero", "triângulo", "pentágono", "hexágono"], correta: 0 },
  { pergunta: "O triângulo com um ângulo de 90° é chamado de:", opcoes: ["Equilátero", "Isósceles", "Retângulo", "Obtusângulo"], correta: 2 },
  { pergunta: "A área de um círculo é calculada por:", opcoes: ["2πr", "πr²", "r²/π", "πr"], correta: 1 },
  { pergunta: "Quantos lados tem um pentágono regular?", opcoes: ["4", "5", "6", "7"], correta: 1 },
  { pergunta: "Qual é a medida de cada ângulo interno de um quadrado?", opcoes: ["45°", "60°", "90°", "120°"], correta: 2 },
  { pergunta: "O triângulo que tem dois lados iguais é chamado de:", opcoes: ["Equilátero", "Isósceles", "Escaleno", "Obtusângulo"], correta: 1 },
  { pergunta: "A base de um triângulo mede 10 cm e sua altura 6 cm. A área é:", opcoes: ["20 cm²", "25 cm²", "30 cm²", "35 cm²"], correta: 2 },
  { pergunta: "O perímetro de um círculo é chamado de:", opcoes: ["Área", "Raio", "Circunferência", "Diâmetro"], correta: 2 },
  { pergunta: "A soma dos ângulos internos de um pentágono é:", opcoes: ["360°", "540°", "720°", "900°"], correta: 1 },
  { pergunta: "Um triângulo com lados 3 cm, 4 cm e 5 cm é:", opcoes: ["Equilátero", "Isósceles", "Retângulo", "Obtusângulo"], correta: 2 },
  { pergunta: "Um cubo tem todas as arestas medindo 2 cm. Seu volume é:", opcoes: ["4 cm³", "6 cm³", "8 cm³", "12 cm³"], correta: 2 },
  { pergunta: "Quantos lados tem um dodecágono?", opcoes: ["10", "11", "12", "13"], correta: 2 }
];

// === 📘 Matemática — Algébricas ===
const perguntasMatematicaAlgebricas = [
  { pergunta: "Resolva: 3x + 5 = 11. O valor de x é:", opcoes: ["1", "2", "3", "4"], correta: 1 },
  { pergunta: "Resolva: 2x − 4 = 10. O valor de x é:", opcoes: ["5", "6", "7", "8"], correta: 1 },
  { pergunta: "Qual é o valor de x na equação x/3 = 9?", opcoes: ["12", "18", "21", "27"], correta: 1 },
  { pergunta: "Resolva: 5x = 45. O valor de x é:", opcoes: ["5", "7", "8", "9"], correta: 3 },
  { pergunta: "Se x = 2, qual é o valor de 3x² + 4x − 5?", opcoes: ["15", "17", "19", "21"], correta: 1 },
  { pergunta: "A equação x² = 25 tem como soluções:", opcoes: ["x = 25", "x = 5", "x = ±5", "x = −5"], correta: 2 },
  { pergunta: "Resolva: 2x + 3 = x + 7. O valor de x é:", opcoes: ["2", "3", "4", "5"], correta: 0 },
  { pergunta: "Se 3x − 9 = 0, então x é igual a:", opcoes: ["1", "2", "3", "4"], correta: 2 },
  { pergunta: "Na expressão 2(a + b), o resultado é:", opcoes: ["2a + b", "a + 2b", "2a + 2b", "a + b + 2"], correta: 2 },
  { pergunta: "Resolva: (x − 2)(x + 2) = 0. As raízes são:", opcoes: ["2 e −2", "4 e −4", "0 e 2", "−2 e 0"], correta: 0 },
  { pergunta: "Se x = 3, o valor de x³ é:", opcoes: ["6", "9", "27", "81"], correta: 2 },
  { pergunta: "A expressão 2x + 3x é equivalente a:", opcoes: ["5x", "6x", "x⁵", "x⁶"], correta: 0 },
  { pergunta: "Qual o valor de x na equação 4x − 2 = 10?", opcoes: ["2", "3", "4", "5"], correta: 2 },
  { pergunta: "Qual o valor de x na equação x² − 9 = 0?", opcoes: ["x = 9", "x = ±3", "x = 3", "x = −3"], correta: 1 },
  { pergunta: "Se x = 2 e y = 3, o valor de 2x + 3y é:", opcoes: ["10", "11", "12", "13"], correta: 1 },
  { pergunta: "O discriminante (Δ) da equação x² − 4x + 4 = 0 é:", opcoes: ["0", "4", "8", "16"], correta: 0 },
  { pergunta: "Em um sistema: x + y = 10 e x − y = 4, o valor de x é:", opcoes: ["6", "7", "8", "9"], correta: 0 },
  { pergunta: "A equação x² − 16 = 0 tem soluções:", opcoes: ["x = 4", "x = −4", "x = ±4", "x = 8"], correta: 2 },
  { pergunta: "Se 5x + 2 = 17, o valor de x é:", opcoes: ["2", "3", "4", "5"], correta: 2 },
  { pergunta: "Se x = −2, o valor de x³ + 4x² é:", opcoes: ["0", "4", "8", "−8"], correta: 2 },
  { pergunta: "Se 2x = 10, então x é igual a:", opcoes: ["2", "3", "4", "5"], correta: 3 },
  { pergunta: "Se x + 3 = 8, o valor de x é:", opcoes: ["3", "4", "5", "6"], correta: 2 },
  { pergunta: "Resolva: 3x = 18", opcoes: ["4", "5", "6", "7"], correta: 2 },
  { pergunta: "Se 4x + 2 = 10, então x é:", opcoes: ["1", "2", "3", "4"], correta: 1 },
  { pergunta: "Em 2x − 4 = 10, x é:", opcoes: ["5", "6", "7", "8"], correta: 2 },
  { pergunta: "A expressão 2(x + 3) é equivalente a:", opcoes: ["2x + 3", "2x + 6", "x + 6", "x + 3"], correta: 1 },
  { pergunta: "Se x = 4, o valor de 3x + 2 é:", opcoes: ["10", "12", "14", "20"], correta: 2 },
  { pergunta: "Se x = 5, qual o valor de x²?", opcoes: ["10", "15", "20", "25"], correta: 3 },
  { pergunta: "O valor de x na equação x/3 = 9 é:", opcoes: ["9", "18", "21", "27"], correta: 1 },
  { pergunta: "Em 5x − 10 = 15, x é igual a:", opcoes: ["3", "4", "5", "6"], correta: 2 },
  { pergunta: "Se x + y = 10 e y = 4, então x =", opcoes: ["4", "5", "6", "7"], correta: 2 },
  { pergunta: "Resolva: 7x = 35", opcoes: ["4", "5", "6", "7"], correta: 1 },
  { pergunta: "Na equação x − 8 = 12, x é:", opcoes: ["18", "19", "20", "21"], correta: 2 },
  { pergunta: "Se 3x + 5 = 20, então 2x é:", opcoes: ["6", "8", "10", "12"], correta: 3 },
  { pergunta: "Simplifique: 4x + 3x", opcoes: ["7x", "12x", "x²", "x³"], correta: 0 },
  { pergunta: "Em x² = 49, x é:", opcoes: ["6", "7", "8", "9"], correta: 1 },
  { pergunta: "Se (x + 2) = 5, então x =", opcoes: ["2", "3", "4", "5"], correta: 1 },
  { pergunta: "Em 9x = 81, x é:", opcoes: ["8", "9", "10", "11"], correta: 1 },
  { pergunta: "O valor de x na equação 2x + 8 = 20 é:", opcoes: ["5", "6", "7", "8"], correta: 2 },
  { pergunta: "Resolva: 10x = 100", opcoes: ["8", "9", "10", "11"], correta: 2 },
  { pergunta: "A soma de (2x + 3x) é:", opcoes: ["4x", "5x", "6x", "7x"], correta: 1 },
  { pergunta: "Se 2x − 4 = 0, então x =", opcoes: ["1", "2", "3", "4"], correta: 1 },
  { pergunta: "Em x² = 64, x é igual a:", opcoes: ["6", "7", "8", "9"], correta: 2 },
  { pergunta: "Resolva a equação: x² − 9 = 0", opcoes: ["x = 3", "x = −3", "x = ±3", "x = 9"], correta: 2 },
  { pergunta: "A raiz da equação x² = 16 é:", opcoes: ["2", "3", "±4", "8"], correta: 2 },
  { pergunta: "Se (x − 1)(x + 1) = 0, então x =", opcoes: ["1 ou −1", "0 ou 1", "1", "−1"], correta: 0 },
  { pergunta: "O valor de x na equação 3x − 9 = 0 é:", opcoes: ["2", "3", "4", "5"], correta: 1 },
  { pergunta: "Na equação 5x + 15 = 0, x é:", opcoes: ["−5", "−4", "−3", "−2"], correta: 2 },
  { pergunta: "Resolva: x² − 4x = 0", opcoes: ["x=0 ou x=4", "x=1 ou x=2", "x=−4 ou 0", "x=2 ou 3"], correta: 0 },
  { pergunta: "O valor de x em x³ = 27 é:", opcoes: ["2", "3", "4", "5"], correta: 1 }
];

// === 📘 Matemática — Raciocínio Lógico ===
const perguntasMatematicaLogico = [
  { pergunta: "Qual número completa a sequência: 2, 4, 8, 16, ___?", opcoes: ["18", "24", "30", "32"], correta: 3 },
  { pergunta: "Qual número falta: 1, 1, 2, 3, 5, 8, ___?", opcoes: ["10", "11", "12", "13"], correta: 3 },
  { pergunta: "Se 3 gatos pegam 3 ratos em 3 minutos, quantos ratos 6 gatos pegam em 6 minutos?", opcoes: ["6", "9", "12", "18"], correta: 3 },
  { pergunta: "Complete a sequência: 5, 10, 20, 40, ___", opcoes: ["60", "70", "80", "90"], correta: 2 },
  { pergunta: "Qual número é diferente dos demais: 3, 5, 7, 9, 11?", opcoes: ["3", "5", "7", "9"], correta: 3 },
  { pergunta: "Se todos os cães são animais e alguns animais são gatos, então:", opcoes: ["todos os gatos são cães", "alguns cães são gatos", "nenhum gato é cão", "todos os animais são cães"], correta: 2 },
  { pergunta: "Complete: 1, 4, 9, 16, 25, ___", opcoes: ["30", "35", "36", "40"], correta: 2 },
  { pergunta: "Se um trem anda 60 km em 1 hora, quantos km andará em 2 horas e meia?", opcoes: ["120 km", "130 km", "140 km", "150 km"], correta: 3 },
  { pergunta: "João tem o dobro da idade de Pedro. Se Pedro tem 10 anos, João tem:", opcoes: ["15", "18", "20", "25"], correta: 2 },
  { pergunta: "Complete: 100, 90, 80, 70, ___", opcoes: ["60", "65", "75", "85"], correta: 0 },
  { pergunta: "Se 2 + 3 = 10 e 3 + 4 = 21, então 4 + 5 = ?", opcoes: ["25", "30", "35", "45"], correta: 1 },
  { pergunta: "Qual número completa a sequência: 11, 13, 17, 19, ___", opcoes: ["21", "23", "25", "27"], correta: 1 },
  { pergunta: "Em uma sequência lógica, cada número é o triplo do anterior. Se começa com 2, o quarto termo é:", opcoes: ["8", "12", "18", "54"], correta: 3 },
  { pergunta: "Se 5x = 20, então x + 10 é igual a:", opcoes: ["12", "14", "16", "20"], correta: 3 },
  { pergunta: "Complete: 3, 6, 12, 24, ___", opcoes: ["36", "40", "46", "48"], correta: 3 },
  { pergunta: "Em um padrão, a cada passo soma-se 7. Se o primeiro número é 2, o quinto é:", opcoes: ["23", "28", "30", "35"], correta: 1 },
  { pergunta: "Qual número não pertence à sequência: 2, 4, 6, 8, 11?", opcoes: ["2", "6", "8", "11"], correta: 3 },
  { pergunta: "Se A = 1, B = 2, C = 3... Qual número corresponde à letra F?", opcoes: ["5", "6", "7", "8"], correta: 1 },
  { pergunta: "Se o dobro de um número é 14, qual é o triplo desse número?", opcoes: ["18", "19", "20", "21"], correta: 3 },
  { pergunta: "Qual é o próximo termo da sequência: 10, 20, 40, 80, ___", opcoes: ["90", "100", "120", "160"], correta: 3 },
  { pergunta: "Qual número completa a sequência: 2, 4, 8, 16, ___?", opcoes: ["18", "24", "30", "32"], correta: 3 },
  { pergunta: "Qual número completa a sequência: 2, 4, 8, 16, ___?", opcoes: ["18", "24", "30", "32"], correta: 3 },
  { pergunta: "Qual número falta: 1, 1, 2, 3, 5, 8, ___?", opcoes: ["10", "11", "12", "13"], correta: 3 },
  { pergunta: "Se 3 gatos pegam 3 ratos em 3 minutos, quantos ratos 6 gatos pegam em 6 minutos?", opcoes: ["6", "9", "12", "18"], correta: 3 },
  { pergunta: "Complete a sequência: 5, 10, 20, 40, ___", opcoes: ["60", "70", "80", "90"], correta: 2 },
  { pergunta: "Qual número é diferente dos demais: 3, 5, 7, 9, 11?", opcoes: ["3", "5", "7", "9"], correta: 3 },
  { pergunta: "Complete: 1, 4, 9, 16, 25, ___", opcoes: ["30", "35", "36", "40"], correta: 2 },
  { pergunta: "Se um trem anda 60 km em 1 hora, quantos km andará em 2 horas e meia?", opcoes: ["120 km", "130 km", "140 km", "150 km"], correta: 3 },
  { pergunta: "João tem o dobro da idade de Pedro. Se Pedro tem 10 anos, João tem:", opcoes: ["15", "18", "20", "25"], correta: 2 },
  { pergunta: "Complete: 100, 90, 80, 70, ___", opcoes: ["60", "65", "75", "85"], correta: 0 },
  { pergunta: "Se 2 + 3 = 10 e 3 + 4 = 21, então 4 + 5 = ?", opcoes: ["25", "30", "35", "45"], correta: 1 },
  { pergunta: "Qual número completa a sequência: 11, 13, 17, 19, ___", opcoes: ["21", "23", "25", "27"], correta: 1 },
  { pergunta: "Em uma sequência lógica, cada número é o triplo do anterior. Se começa com 2, o quarto termo é:", opcoes: ["8", "12", "18", "54"], correta: 3 },
  { pergunta: "Se 5x = 20, então x + 10 é igual a:", opcoes: ["12", "14", "16", "20"], correta: 3 },
  { pergunta: "Complete: 3, 6, 12, 24, ___", opcoes: ["36", "40", "46", "48"], correta: 3 },
  { pergunta: "Em um padrão, a cada passo soma-se 7. Se o primeiro número é 2, o quinto é:", opcoes: ["23", "28", "30", "35"], correta: 1 },
  { pergunta: "Qual número não pertence à sequência: 2, 4, 6, 8, 11?", opcoes: ["2", "6", "8", "11"], correta: 3 },
  { pergunta: "Se A = 1, B = 2, C = 3... Qual número corresponde à letra F?", opcoes: ["5", "6", "7", "8"], correta: 1 },
  { pergunta: "Se o dobro de um número é 14, qual é o triplo desse número?", opcoes: ["18", "19", "20", "21"], correta: 3 },
  { pergunta: "Qual é o próximo termo da sequência: 10, 20, 40, 80, ___", opcoes: ["90", "100", "120", "160"], correta: 3 },
  { pergunta: "Se um número multiplicado por 3 resulta em 27, qual é o número?", opcoes: ["6", "7", "8", "9"], correta: 3 },
  { pergunta: "Na sequência 1, 3, 6, 10, 15, o próximo termo é:", opcoes: ["18", "19", "20", "21"], correta: 2 },
  { pergunta: "Qual é o próximo número: 2, 6, 12, 20, ___?", opcoes: ["28", "30", "32", "34"], correta: 0 },
  { pergunta: "Se 10 + 10 = 1010 e 20 + 20 = 2040, então 30 + 30 =", opcoes: ["3060", "3030", "6010", "6060"], correta: 0 },
  { pergunta: "Qual número completa a sequência: 4, 8, 16, 32, 64, ___", opcoes: ["96", "100", "120", "128"], correta: 3 },
  { pergunta: "Se o avô de João tem o dobro da idade de seu pai, que tem 40 anos, o avô tem:", opcoes: ["70", "75", "80", "85"], correta: 2 },
  { pergunta: "Se 7x = 49, então x + 3 é:", opcoes: ["8", "9", "10", "12"], correta: 2 },
  { pergunta: "A sequência 2, 5, 10, 17, 26 é formada por:", opcoes: ["adição de números ímpares", "adição de números pares", "multiplicação por 2", "subtração de 1"], correta: 0 },
  { pergunta: "Se 3x − 6 = 0, então 2x = ?", opcoes: ["2", "4", "6", "8"], correta: 3 },
  { pergunta: "Se cada pessoa em uma sala aperta a mão das outras 4 pessoas, quantos apertos ocorrem ao todo?", opcoes: ["8", "10", "12", "20"], correta: 1 },
  { pergunta: "Complete a sequência: 9, 18, 36, 72, ___", opcoes: ["90", "108", "120", "144"], correta: 3 }


];


/* Cria o container da pergunta (invisível por padrão) */
const quizContainer = document.createElement('div');
quizContainer.id = 'quiz-container';
quizContainer.style.display = 'none';
quizContainer.innerHTML = `
  <div class="quiz-box">
    <h2 id="quiz-question"></h2>
    <div id="quiz-options"></div>
  </div>
`;
document.body.appendChild(quizContainer);

/* Mostra pergunta aleatória quando o Boss é derrotado */
function mostrarPerguntaQuiz() {
  pauseTimer(); // congela o jogo

  const perguntaAleatoria = perguntasQuiz[Math.floor(Math.random() * perguntasQuiz.length)];
  const perguntaTexto = document.getElementById('quiz-question');
  const opcoesContainer = document.getElementById('quiz-options');

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

/* Verifica resposta e aplica efeito */
function verificarResposta(correta) {
  quizContainer.style.display = 'none';

  if (correta) {
    alert('✅ Resposta correta! Continue a aventura!');
  } else {
    alert('❌ Resposta errada! Você perdeu 3 minutos!');
    timer = Math.max(timer - 180, 0); // remove 3 minutos (180s)
    timerDisplay.textContent = formatTime(timer);
  }

  startTimer(); // volta o jogo
}

/* Chama o quiz automaticamente ao derrotar um Boss */
function createBossParticles(element) {
  // mantém as partículas originais
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
    const colors = ['#FF0000', '#FF4500', '#FFD700'];
    p.style.background = colors[Math.floor(Math.random() * colors.length)];
    particlesContainer.appendChild(p);
    setTimeout(() => p.remove(), 1200);
  }

  // 🔹 adiciona a chamada do quiz logo após o boss morrer
  setTimeout(() => {
    mostrarPerguntaQuiz();
  }, 1200);
}

</script>



</body>
</html>
