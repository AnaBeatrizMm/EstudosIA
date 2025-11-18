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

      <!-- =====================================================
     🎯 FILTRO DE DIFICULDADE
====================================================== -->
<div class="info-item">
    <label>Dificuldade:</label>
    <select id="dificuldadeSelect">
        <option value="">-- selecione --</option>
        <option value="facil">Fácil</option>
        <option value="media">Média</option>
        <option value="dificil">Difícil</option>
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
      <div class="info-item">
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
const BOSS_INTERVAL_SECONDS = 600; // boss a cada 10 minutos (600s)
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
    alert("📘 Escolha uma MATÉRIA antes de iniciar o jogo!");
    return;
  }
  if (!dificuldadeSelecionada) {
    alert("🎯 Escolha a DIFICULDADE antes de iniciar o jogo!");
    return;
  }
  if (!perguntasQuiz || perguntasQuiz.length === 0) {
    alert("⚠️ Esta combinação não possui perguntas! Adicione perguntas primeiro.");
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
{ pergunta: "Qual é o símbolo químico do hidrogênio?", opcoes: ["H", "He", "Hg", "Ho"], correta: 0 },
{ pergunta: "Qual é o estado físico da água à temperatura ambiente?", opcoes: ["Sólido", "Líquido", "Gasoso", "Plasma"], correta: 1 },
{ pergunta: "O que forma uma molécula de água?", opcoes: ["2 H e 1 O", "1 H e 2 O", "2 H e 2 O", "1 H e 1 O"], correta: 0 },
{ pergunta: "Qual elemento é mais abundante no ar?", opcoes: ["Oxigênio", "Nitrogênio", "Carbono", "Hélio"], correta: 1 },
{ pergunta: "Qual gás é essencial para a respiração humana?", opcoes: ["Nitrogênio", "Oxigênio", "Dióxido de carbono", "Hidrogênio"], correta: 1 },
{ pergunta: "Qual é a fórmula química do sal de cozinha?", opcoes: ["NaCl", "KCl", "NaOH", "HCl"], correta: 0 },
{ pergunta: "Qual é a unidade básica da matéria?", opcoes: ["Molécula", "Átomo", "Elemento", "Íon"], correta: 1 },
{ pergunta: "Qual é o pH neutro da água?", opcoes: ["0", "7", "14", "1"], correta: 1 },
{ pergunta: "Qual elemento é líquido à temperatura ambiente?", opcoes: ["Mercúrio", "Ouro", "Ferro", "Hélio"], correta: 0 },
{ pergunta: "O que caracteriza um elemento químico?", opcoes: ["Mesmo número de prótons", "Mesma massa", "Mesmo número de elétrons", "Mesmo ponto de fusão"], correta: 0 },
{ pergunta: "Qual é o símbolo químico do ouro?", opcoes: ["Au", "Ag", "Gd", "Ga"], correta: 0 },
{ pergunta: "Qual elemento é essencial para combustão?", opcoes: ["Oxigênio", "Nitrogênio", "Hidrogênio", "Carbono"], correta: 0 },
{ pergunta: "O que é um composto químico?", opcoes: ["Átomos diferentes ligados", "Átomos iguais livres", "Um único elemento", "Mistura física"], correta: 0 },
{ pergunta: "Qual gás é liberado na fotossíntese?", opcoes: ["Oxigênio", "Dióxido de carbono", "Nitrogênio", "Hidrogênio"], correta: 0 },
{ pergunta: "Qual é a fórmula da água oxigenada?", opcoes: ["H2O2", "H2O", "HO", "O2H"], correta: 0 },
{ pergunta: "Qual gás é mais leve que o ar?", opcoes: ["Hélio", "Oxigênio", "Dióxido de carbono", "Nitrogênio"], correta: 0 },
{ pergunta: "O que é um ácido segundo Brønsted-Lowry?", opcoes: ["Doa prótons", "Recebe prótons", "Libera elétrons", "Recebe elétrons"], correta: 0 },
{ pergunta: "O que é uma base segundo Brønsted-Lowry?", opcoes: ["Recebe prótons", "Doa prótons", "Libera elétrons", "Recebe elétrons"], correta: 0 },
{ pergunta: "Qual elemento tem número atômico 6?", opcoes: ["Carbono", "Nitrogênio", "Oxigênio", "Hélio"], correta: 0 },
{ pergunta: "O que é um íon positivo?", opcoes: ["Cátion", "Ânion", "Neutrônio", "Isótopo"], correta: 0 },
{ pergunta: "O que é um íon negativo?", opcoes: ["Ânion", "Cátion", "Neutrônio", "Isótopo"], correta: 0 },
{ pergunta: "Qual elemento é gás nobre?", opcoes: ["Hélio", "Oxigênio", "Nitrogênio", "Carbono"], correta: 0 },
{ pergunta: "Qual é o principal componente do gás carbônico?", opcoes: ["Carbono e oxigênio", "Carbono e hidrogênio", "Oxigênio e nitrogênio", "Hidrogênio e oxigênio"], correta: 0 },
{ pergunta: "Qual elemento forma a camada protetora nos óxidos metálicos?", opcoes: ["Oxigênio", "Nitrogênio", "Carbono", "Hidrogênio"], correta: 0 },
{ pergunta: "O que é solução saturada?", opcoes: ["Não dissolve mais soluto", "Dissolve muito soluto", "Não contém soluto", "Contém apenas solvente"], correta: 0 },
{ pergunta: "Qual é o solvente universal?", opcoes: ["Água", "Álcool", "Éter", "Acetona"], correta: 0 },
{ pergunta: "O que é eletronegatividade?", opcoes: ["Capacidade de atrair elétrons", "Capacidade de doar prótons", "Massa de elétrons", "Energia de ligação"], correta: 0 },
{ pergunta: "Qual ligação é formada pelo compartilhamento de elétrons?", opcoes: ["Covalente", "Iônica", "Metalica", "Van der Waals"], correta: 0 },
{ pergunta: "Qual ligação envolve transferência de elétrons?", opcoes: ["Iônica", "Covalente", "Metalica", "Hydrogen bond"], correta: 0 },
{ pergunta: "Qual é o gás da combustão completa de carbono?", opcoes: ["Dióxido de carbono", "Monóxido de carbono", "Oxigênio", "Nitrogênio"], correta: 0 },
{ pergunta: "Qual elemento tem símbolo 'Na'?", opcoes: ["Sódio", "Níquel", "Nióbio", "Nitrogênio"], correta: 0 },
{ pergunta: "Qual é o pH do suco de limão?", opcoes: ["Ácido (~2)", "Neutro (~7)", "Básico (~12)", "Neutro (~5)"], correta: 0 },
{ pergunta: "O que é uma mistura homogênea?", opcoes: ["Não distinguível a olho nu", "Separa-se facilmente", "Tem fases visíveis", "Não se dissolve"], correta: 0 },
{ pergunta: "O que é uma mistura heterogênea?", opcoes: ["Fases visíveis", "Não separável", "Mesma composição uniforme", "Solvente único"], correta: 0 },
{ pergunta: "Qual elemento é fundamental para a vida e presente nas proteínas?", opcoes: ["Nitrogênio", "Ouro", "Mercúrio", "Hélio"], correta: 0 },
{ pergunta: "Qual gás é liberado na respiração celular?", opcoes: ["Dióxido de carbono", "Oxigênio", "Hélio", "Nitrogênio"], correta: 0 },
{ pergunta: "Qual elemento tem número atômico 1?", opcoes: ["Hidrogênio", "Hélio", "Carbono", "Lítio"], correta: 0 },
{ pergunta: "Qual é a fórmula do ácido sulfúrico?", opcoes: ["H2SO4", "HCl", "HNO3", "H2CO3"], correta: 0 },
{ pergunta: "Qual é a fórmula do metano?", opcoes: ["CH4", "C2H6", "CO2", "H2O"], correta: 0 },
{ pergunta: "Qual elemento tem símbolo 'Fe'?", opcoes: ["Ferro", "Flúor", "Fósforo", "Frâncio"], correta: 0 },
{ pergunta: "O que é um isotopo?", opcoes: ["Átomos do mesmo elemento com diferente número de nêutrons", "Átomos com elétrons extras", "Moléculas diferentes", "Elementos diferentes"], correta: 0 },
{ pergunta: "O que é uma reação de neutralização?", opcoes: ["Ácido + base → sal + água", "Ácido + ácido → água", "Base + base → sal", "Sal + água → ácido"], correta: 0 },
{ pergunta: "O que é combustão?", opcoes: ["Reação com oxigênio liberando energia", "Reação com água", "Reação de precipitação", "Reação de neutralização"], correta: 0 },
{ pergunta: "Qual gás é inerte em reações químicas?", opcoes: ["Hélio", "Oxigênio", "Nitrogênio", "Cloro"], correta: 0 },
{ pergunta: "O que é solubilidade?", opcoes: ["Capacidade de dissolver soluto", "Energia de ligação", "Número de elétrons", "Temperatura de fusão"], correta: 0 },
{ pergunta: "O que caracteriza um metal alcalino?", opcoes: ["Reatividade alta e 1 elétron na camada externa", "Ponto de fusão alto", "Baixa densidade e gás nobre", "É líquido"], correta: 0 },
{ pergunta: "O que é uma reação endotérmica?", opcoes: ["Absorve energia do ambiente", "Libera energia", "Não troca energia", "Libera gás"], correta: 0 },
{ pergunta: "O que é uma reação exotérmica?", opcoes: ["Libera energia", "Absorve energia", "Não troca energia", "Libera luz apenas"], correta: 0 }
];
const perguntasQuimicaMedias = [
{ pergunta: "Qual é o número atômico do oxigênio?", opcoes: ["6", "7", "8", "9"], correta: 2 },
{ pergunta: "O que é um íon?", opcoes: ["Átomo com elétrons extras ou faltantes", "Molécula neutra", "Elemento instável", "Núcleo sem prótons"], correta: 0 },
{ pergunta: "Qual é a unidade de massa atômica?", opcoes: ["Grama", "Mol", "u (uma unidade de massa atômica)", "Joule"], correta: 2 },
{ pergunta: "Qual ligação ocorre entre átomos com diferença de eletronegatividade muito grande?", opcoes: ["Covalente polar", "Covalente apolar", "Iônica", "Metálica"], correta: 2 },
{ pergunta: "O que caracteriza uma molécula polar?", opcoes: ["Distribuição desigual de elétrons", "Distribuição uniforme de elétrons", "Átomos iguais", "Presença de hidrogênio apenas"], correta: 0 },
{ pergunta: "Qual é a fórmula do ácido nítrico?", opcoes: ["HNO3", "H2SO4", "HCl", "H3PO4"], correta: 0 },
{ pergunta: "O que é uma reação de oxidação?", opcoes: ["Perda de elétrons", "Ganho de elétrons", "Perda de prótons", "Ganho de nêutrons"], correta: 0 },
{ pergunta: "O que é uma reação de redução?", opcoes: ["Ganho de elétrons", "Perda de elétrons", "Ganho de prótons", "Perda de nêutrons"], correta: 0 },
{ pergunta: "O que é um ácido de Arrhenius?", opcoes: ["Libera H+ em solução aquosa", "Libera OH-", "Libera elétrons", "Libera neutrons"], correta: 0 },
{ pergunta: "O que é uma base de Arrhenius?", opcoes: ["Libera OH- em solução aquosa", "Libera H+", "Libera elétrons", "Libera prótons"], correta: 0 },
{ pergunta: "Qual elemento é mais eletronegativo?", opcoes: ["Flúor", "Oxigênio", "Nitrogênio", "Carbono"], correta: 0 },
{ pergunta: "O que mede a massa molar de uma substância?", opcoes: ["Massa de 1 mol", "Número de elétrons", "Número de átomos", "Energia"], correta: 0 },
{ pergunta: "O que é um composto covalente?", opcoes: ["Compartilha elétrons entre átomos", "Transfere elétrons", "Conduz eletricidade", "É metálico"], correta: 0 },
{ pergunta: "O que é um composto iônico?", opcoes: ["Transferência de elétrons", "Compartilhamento de elétrons", "Apenas hidrogênio", "Molécula neutra"], correta: 0 },
{ pergunta: "Qual gás é mais solúvel em água?", opcoes: ["CO2", "O2", "N2", "H2"], correta: 0 },
{ pergunta: "Qual é o principal gás responsável pelo efeito estufa?", opcoes: ["CO2", "O2", "N2", "H2"], correta: 0 },
{ pergunta: "O que é ligação metálica?", opcoes: ["Elétrons livres entre átomos metálicos", "Elétrons compartilhados", "Elétrons transferidos", "Sem elétrons"], correta: 0 },
{ pergunta: "Qual é a unidade de concentração molar?", opcoes: ["mol/L", "g/L", "mol/m³", "g/mol"], correta: 0 },
{ pergunta: "O que é um radical livre?", opcoes: ["Espécie com elétron desemparelhado", "Molécula neutra", "Molécula estável", "Átomo com prótons extras"], correta: 0 },
{ pergunta: "O que é uma reação de substituição?", opcoes: ["Um átomo substitui outro em uma molécula", "Átomos se combinam", "Moléculas se separam", "Átomos perdem elétrons"], correta: 0 },
{ pergunta: "O que é uma reação de adição?", opcoes: ["Moléculas se unem a insaturadas", "Moléculas se separam", "Átomos substituem outros", "Moléculas liberam energia"], correta: 0 },
{ pergunta: "O que é uma reação de eliminação?", opcoes: ["Perda de átomos de uma molécula", "Ganho de elétrons", "Formação de íons", "Ganho de prótons"], correta: 0 },
{ pergunta: "Qual é a configuração eletrônica do oxigênio?", opcoes: ["1s² 2s² 2p⁴", "1s² 2s² 2p²", "1s² 2s² 2p⁶", "1s² 2s²"], correta: 0 },
{ pergunta: "O que é um composto orgânico?", opcoes: ["Contém carbono e geralmente hidrogênio", "Não contém carbono", "Contém apenas metais", "Contém apenas oxigênio"], correta: 0 },
{ pergunta: "O que é um hidrocarboneto saturado?", opcoes: ["Apenas ligações simples", "Possui ligações duplas", "Possui ligações triplas", "Não possui carbono"], correta: 0 },
{ pergunta: "O que é um hidrocarboneto insaturado?", opcoes: ["Possui ligações duplas ou triplas", "Apenas ligações simples", "Não possui carbono", "Possui oxigênio"], correta: 0 },
{ pergunta: "O que é uma reação de combustão completa?", opcoes: ["Produz CO2 e H2O", "Produz CO e H2", "Não libera energia", "Produz O2 e CO"], correta: 0 },
{ pergunta: "O que é uma reação de combustão incompleta?", opcoes: ["Produz CO e H2O", "Produz CO2 e H2O", "Não libera energia", "Produz apenas O2"], correta: 0 },
{ pergunta: "O que é um pH ácido?", opcoes: ["Menor que 7", "Maior que 7", "Igual a 7", "Igual a 0"], correta: 0 },
{ pergunta: "O que é um pH básico?", opcoes: ["Maior que 7", "Menor que 7", "Igual a 7", "Igual a 0"], correta: 0 },
{ pergunta: "O que é uma solução tampão?", opcoes: ["Mantém o pH quase constante", "Aumenta o pH rapidamente", "Reduz a densidade", "É uma solução de água apenas"], correta: 0 },
{ pergunta: "O que é ponto de fusão?", opcoes: ["Temperatura em que sólido se torna líquido", "Temperatura de ebulição", "Temperatura ambiente", "Temperatura de decomposição"], correta: 0 },
{ pergunta: "O que é ponto de ebulição?", opcoes: ["Temperatura em que líquido se torna gás", "Temperatura de fusão", "Temperatura ambiente", "Temperatura de decomposição"], correta: 0 },
{ pergunta: "O que é entalpia?", opcoes: ["Energia total de um sistema", "Energia cinética apenas", "Energia potencial apenas", "Energia liberada por átomo"], correta: 0 },
{ pergunta: "O que é entropia?", opcoes: ["Medida de desordem de um sistema", "Energia liberada", "Energia cinética", "Energia potencial"], correta: 0 },
{ pergunta: "O que é uma reação exotérmica?", opcoes: ["Libera energia para o ambiente", "Absorve energia", "Não troca energia", "Libera apenas luz"], correta: 0 },
{ pergunta: "O que é uma reação endotérmica?", opcoes: ["Absorve energia do ambiente", "Libera energia", "Não troca energia", "Libera apenas luz"], correta: 0 },
{ pergunta: "O que é constante de equilíbrio?", opcoes: ["Razão entre produtos e reagentes em equilíbrio", "Temperatura de fusão", "Ponto de ebulição", "Energia cinética"], correta: 0 },
{ pergunta: "O que é eletrólise?", opcoes: ["Separação de compostos usando corrente elétrica", "Reação de combustão", "Reação de neutralização", "Reação de precipitação"], correta: 0 },
{ pergunta: "O que é uma reação redox?", opcoes: ["Envolve oxidação e redução simultâneas", "Envolve apenas oxidação", "Envolve apenas redução", "Envolve neutralização"], correta: 0 },
{ pergunta: "O que é uma molécula aromática?", opcoes: ["Contém anel de carbono conjugado", "Possui apenas ligações simples", "Não contém carbono", "É iônica"], correta: 0 },
{ pergunta: "O que é isomeria estrutural?", opcoes: ["Mesma fórmula molecular, diferentes ligações", "Mesma fórmula e mesma estrutura", "Moléculas diferentes", "Mesma massa molar"], correta: 0 },
{ pergunta: "O que é isomeria espacial?", opcoes: ["Mesma fórmula, diferentes disposições espaciais", "Mesma fórmula e estrutura", "Moléculas diferentes", "Mesma massa molar"], correta: 0 },
{ pergunta: "O que é uma molécula polar?", opcoes: ["Distribuição desigual de elétrons", "Distribuição uniforme", "Não contém carbono", "É iônica"], correta: 0 },
{ pergunta: "O que é uma molécula apolar?", opcoes: ["Distribuição uniforme de elétrons", "Distribuição desigual", "Contém oxigênio", "É ácida"], correta: 0 },
{ pergunta: "O que é um ligante em química de coordenação?", opcoes: ["Espécie que doa elétrons para metal central", "Metal central", "Átomo neutro", "Reagente orgânico"], correta: 0 },
{ pergunta: "O que é quiralidade?", opcoes: ["Moléculas não sobreponíveis à sua imagem no espelho", "Moléculas lineares", "Moléculas planas", "Moléculas aromáticas"], correta: 0 }
];
const perguntasQuimicaDificeis = [
{ pergunta: "O que é número de oxidação?", opcoes: ["Carga aparente de um átomo em um composto", "Número de prótons no núcleo", "Número de elétrons no átomo neutro", "Massa do átomo"], correta: 0 },
{ pergunta: "O que é constante de acidez Ka?", opcoes: ["Mede a força de um ácido em solução", "Mede a solubilidade de um sal", "Mede a densidade de um ácido", "Mede a energia liberada"], correta: 0 },
{ pergunta: "O que é constante de basicidade Kb?", opcoes: ["Mede a força de uma base", "Mede a densidade de uma base", "Mede a solubilidade de um ácido", "Mede a concentração de elétrons"], correta: 0 },
{ pergunta: "O que é efeito indutivo?", opcoes: ["Deslocamento de densidade eletrônica ao longo da cadeia", "Transferência de calor", "Mudança de pH", "Liberação de energia"], correta: 0 },
{ pergunta: "O que é efeito mesomérico?", opcoes: ["Delocalização de elétrons em ligações π", "Transferência de prótons", "Liberação de calor", "Atração de íons"], correta: 0 },
{ pergunta: "O que é um ligante quelante?", opcoes: ["Ligante que forma dois ou mais enlaces com o metal", "Ligante neutro simples", "Molécula iônica", "Elemento metálico"], correta: 0 },
{ pergunta: "O que é a regra de Hund?", opcoes: ["Distribuição de elétrons em orbitais degenerados", "Número de oxidação", "Energia de ligação", "Entalpia de formação"], correta: 0 },
{ pergunta: "O que é spin quântico do elétron?", opcoes: ["Momento angular intrínseco", "Carga do elétron", "Massa do elétron", "Energia do elétron"], correta: 0 },
{ pergunta: "O que é configuração eletrônica em estado excitado?", opcoes: ["Elétrons ocupam orbitais de energia superior", "Elétrons estão nos níveis mais baixos", "Elétrons são removidos", "Átomo neutro"], correta: 0 },
{ pergunta: "O que é efeito fotoquímico?", opcoes: ["Reações iniciadas por luz", "Reações térmicas", "Reações ácido-base", "Reações iônicas"], correta: 0 },
{ pergunta: "O que é potencial padrão de redução?", opcoes: ["Tendência de uma substância ser reduzida", "Energia de ligação", "Ponto de fusão", "Densidade de solução"], correta: 0 },
{ pergunta: "O que é eletroquímica?", opcoes: ["Estudo da relação entre eletricidade e reações químicas", "Estudo de gases", "Estudo de ligações covalentes", "Estudo de termodinâmica apenas"], correta: 0 },
{ pergunta: "O que é lei de Hess?", opcoes: ["ΔH total é soma das entalpias parciais", "Energia cinética é constante", "Potencial elétrico é zero", "Número de oxidação se conserva"], correta: 0 },
{ pergunta: "O que é entalpia padrão de formação?", opcoes: ["ΔH da formação de 1 mol de substância a partir dos elementos", "ΔH de combustão", "Energia de ligação", "Energia cinética"], correta: 0 },
{ pergunta: "O que é energia de ligação?", opcoes: ["Energia necessária para quebrar 1 mol de ligação química", "Energia térmica", "Energia cinética", "Energia potencial"], correta: 0 },
{ pergunta: "O que é química de coordenação?", opcoes: ["Estudo de complexos metálicos e ligantes", "Estudo de ácidos e bases", "Estudo de reações redox", "Estudo de combustão"], correta: 0 },
{ pergunta: "O que é número de coordenação?", opcoes: ["Número de ligantes ao redor do metal", "Número de elétrons livres", "Número de átomos no composto", "Número de nêutrons"], correta: 0 },
{ pergunta: "O que é teoria VSEPR?", opcoes: ["Previsão da geometria molecular com base na repulsão de pares de elétrons", "Energia de ligação", "Acidez de moléculas", "Número de oxidação"], correta: 0 },
{ pergunta: "O que é regra de Octeto?", opcoes: ["Átomos tendem a completar 8 elétrons na camada de valência", "Átomos sempre formam cátions", "Elétrons permanecem livres", "Átomos tendem a 2 elétrons apenas"], correta: 0 },
{ pergunta: "O que é isomeria tautomérica?", opcoes: ["Mudança de posição de hidrogênio e dupla ligação", "Isômeros espaciais", "Moléculas iônicas", "Isótopos de carbono"], correta: 0 },
{ pergunta: "O que é efeito de ressonância?", opcoes: ["Distribuição de elétrons em estruturas equivalentes", "Transferência de prótons", "Liberação de energia", "Reação redox"], correta: 0 },
{ pergunta: "O que é constante de equilíbrio químico Kc?", opcoes: ["Razão de concentrações de produtos e reagentes em equilíbrio", "Densidade de solução", "Energia liberada", "Número de oxidação"], correta: 0 },
{ pergunta: "O que é potencial de ionização?", opcoes: ["Energia necessária para remover um elétron de um átomo neutro", "Energia de ligação", "Energia térmica", "Energia cinética"], correta: 0 },
{ pergunta: "O que é afinidade eletrônica?", opcoes: ["Energia liberada ao adicionar um elétron a um átomo neutro", "Energia de fusão", "Energia de ligação", "Energia cinética"], correta: 0 },
{ pergunta: "O que é efeito Zeigler-Natta?", opcoes: ["Catálise para polimerização de olefinas", "Reação redox", "Combustão", "Reação ácido-base"], correta: 0 },
{ pergunta: "O que é ligação de hidrogênio?", opcoes: ["Interação dipolo-dipolo envolvendo H ligado a F, O ou N", "Ligação covalente simples", "Ligação iônica", "Ligação metálica"], correta: 0 },
{ pergunta: "O que é regra de Markovnikov?", opcoes: ["H adiciona ao carbono com mais H na adição a alcenos", "H adiciona ao carbono com menos H", "Oxigênio adiciona ao carbono", "Nitrogênio adiciona ao carbono"], correta: 0 },
{ pergunta: "O que é reação de Friedel-Crafts?", opcoes: ["Alquilação ou acilação em aromáticos", "Oxidação de álcoois", "Redução de aldeídos", "Neutralização ácido-base"], correta: 0 },
{ pergunta: "O que é reação de Diels-Alder?", opcoes: ["Ciclização 4+2 de dieno e dienófilo", "Oxidação de ácidos", "Substituição eletrofílica", "Reação de neutralização"], correta: 0 },
{ pergunta: "O que é química quântica?", opcoes: ["Estudo de comportamento eletrônico baseado na mecânica quântica", "Estudo de gases ideais", "Reações ácido-base", "Combustão"], correta: 0 },
{ pergunta: "O que é espectroscopia de RMN?", opcoes: ["Identificação estrutural de compostos orgânicos via núcleos magnéticos", "Medida de pH", "Medida de densidade", "Cálculo de massa molar"], correta: 0 },
{ pergunta: "O que é espectroscopia de IR?", opcoes: ["Identificação de grupos funcionais por vibrações moleculares", "Medida de densidade", "Energia de ligação", "Número de oxidação"], correta: 0 },
{ pergunta: "O que é efeito termoquímico de reação?", opcoes: ["ΔH da reação", "Energia cinética", "Número de oxidação", "pH"], correta: 0 },
{ pergunta: "O que é reação de oxidação de um álcool primário?", opcoes: ["Forma aldeído ou ácido carboxílico", "Forma cetona", "Forma alcano", "Forma éter"], correta: 0 },
{ pergunta: "O que é reação de oxidação de um álcool secundário?", opcoes: ["Forma cetona", "Forma aldeído", "Forma ácido", "Forma alcano"], correta: 0 },
{ pergunta: "O que é regra de Le Chatelier?", opcoes: ["Sistema em equilíbrio reage para contrariar alterações", "Energia é conservada", "Pressão aumenta a reação", "pH muda"], correta: 0 },
{ pergunta: "O que é energia livre de Gibbs?", opcoes: ["Energia que determina espontaneidade de uma reação", "Energia cinética", "Energia de ligação", "Entalpia apenas"], correta: 0 },
{ pergunta: "O que é ligação π?", opcoes: ["Sobreposição lateral de orbitais p", "Ligação σ simples", "Ligação iônica", "Ligação metálica"], correta: 0 },
{ pergunta: "O que é ligação σ?", opcoes: ["Sobreposição axial de orbitais", "Ligação π lateral", "Ligação iônica", "Ligação de hidrogênio"], correta: 0 },
{ pergunta: "O que é regra de Baldwin?", opcoes: ["Favorece fechamento de anéis em cicloadições", "Regra de octeto", "Lei de Hess", "Regra de Markovnikov"], correta: 0 },
{ pergunta: "O que é efeito de mesomeria negativa?", opcoes: ["Retira densidade eletrônica de um átomo", "Adiciona densidade", "Libera energia", "Aumenta massa"], correta: 0 },
{ pergunta: "O que é efeito de mesomeria positiva?", opcoes: ["Aumenta densidade eletrônica em átomo adjacente", "Diminui densidade", "Libera calor", "Não altera elétrons"], correta: 0 },
{ pergunta: "O que é química organometálica?", opcoes: ["Estudo de compostos com ligações C-metal", "Estudo de gases nobres", "Reações redox", "Combustão"], correta: 0 },
{ pergunta: "O que é espectrometria de massa?", opcoes: ["Determinação de massa e estrutura molecular", "Medida de pH", "Medida de densidade", "Energia de ligação"], correta: 0 },
{ pergunta: "O que é reação de Claisen?", opcoes: ["Condensação entre ésteres", "Substituição eletrofílica", "Oxidação de álcoois", "Neutralização"], correta: 0 },
{ pergunta: "O que é regra de Saytzeff?", opcoes: ["Formação do alceno mais substituído", "Formação do menos substituído", "Formação de álcool", "Formação de éter"], correta: 0 },
{ pergunta: "O que é efeito inductivo negativo?", opcoes: ["Retira densidade eletrônica", "Aumenta densidade", "Libera energia", "Não altera elétrons"], correta: 0 },
{ pergunta: "O que é efeito inductivo positivo?", opcoes: ["Doa densidade eletrônica", "Retira densidade", "Libera energia", "Não altera elétrons"], correta: 0 }
];

const perguntasBiologiaFaceis = [
{ pergunta: "Qual é a unidade básica da vida?", opcoes: ["Célula", "Molécula", "Organelo", "Átomo"], correta: 0 },
{ pergunta: "Qual é o material genético presente na maioria das células?", opcoes: ["DNA", "RNA", "Proteína", "Lipídios"], correta: 0 },
{ pergunta: "Qual organela é responsável pela produção de energia?", opcoes: ["Mitocôndria", "Cloroplasto", "Ribossomo", "Lisossomo"], correta: 0 },
{ pergunta: "Qual célula realiza fotossíntese?", opcoes: ["Plantas e algas", "Bactérias", "Fungos", "Animais"], correta: 0 },
{ pergunta: "Qual gás é liberado na fotossíntese?", opcoes: ["Oxigênio", "Dióxido de carbono", "Nitrogênio", "Hidrogênio"], correta: 0 },
{ pergunta: "Qual é a função do núcleo celular?", opcoes: ["Armazenar o DNA", "Produzir energia", "Digestão celular", "Transporte de moléculas"], correta: 0 },
{ pergunta: "Qual é a função do ribossomo?", opcoes: ["Síntese de proteínas", "Produção de energia", "Fotossíntese", "Armazenamento de lipídios"], correta: 0 },
{ pergunta: "Qual organela é responsável pela digestão celular?", opcoes: ["Lisossomo", "Mitocôndria", "Cloroplasto", "Núcleo"], correta: 0 },
{ pergunta: "Qual molécula transporta oxigênio no sangue?", opcoes: ["Hemoglobina", "Insulina", "Colágeno", "Clorofila"], correta: 0 },
{ pergunta: "Qual tecido conecta músculos aos ossos?", opcoes: ["Tendão", "Ligamento", "Cartilagem", "Epitélio"], correta: 0 },
{ pergunta: "Qual é a função das raízes nas plantas?", opcoes: ["Absorver água e minerais", "Realizar fotossíntese", "Produzir sementes", "Armazenar glicose"], correta: 0 },
{ pergunta: "Qual é a principal função das folhas?", opcoes: ["Fotossíntese", "Respiração celular", "Proteção", "Reprodução"], correta: 0 },
{ pergunta: "Qual célula do sangue combate infecções?", opcoes: ["Glóbulo branco", "Glóbulo vermelho", "Plaqueta", "Hematócrito"], correta: 0 },
{ pergunta: "Qual célula transporta oxigênio no sangue?", opcoes: ["Glóbulo vermelho", "Glóbulo branco", "Plaqueta", "Neurônio"], correta: 0 },
{ pergunta: "Qual é a função das plaquetas?", opcoes: ["Coagulação do sangue", "Transporte de oxigênio", "Defesa do corpo", "Produção de energia"], correta: 0 },
{ pergunta: "Qual é a função do sistema esquelético?", opcoes: ["Sustentação e proteção", "Digestão", "Transporte de oxigênio", "Síntese de proteínas"], correta: 0 },
{ pergunta: "Qual é a função do sistema muscular?", opcoes: ["Movimento", "Digestão", "Respiração", "Proteção"], correta: 0 },
{ pergunta: "Qual é a função do sistema respiratório?", opcoes: ["Troca gasosa", "Digestão", "Proteção contra infecções", "Transporte de hormônios"], correta: 0 },
{ pergunta: "Qual é a função do sistema circulatório?", opcoes: ["Transporte de sangue e nutrientes", "Produção de enzimas", "Digestão", "Fotossíntese"], correta: 0 },
{ pergunta: "Qual é a função do sistema nervoso?", opcoes: ["Coordenação e controle", "Digestão", "Respiração", "Produção de energia"], correta: 0 },
{ pergunta: "Qual é a função do sistema digestório?", opcoes: ["Digestão e absorção de nutrientes", "Produção de hormônios", "Filtragem do sangue", "Respiração"], correta: 0 },
{ pergunta: "Qual é a função dos rins?", opcoes: ["Filtrar o sangue e excretar urina", "Produzir hormônios digestivos", "Transportar oxigênio", "Produzir energia"], correta: 0 },
{ pergunta: "Qual é a função do fígado?", opcoes: ["Desintoxicação e metabolismo", "Produção de insulina", "Transporte de oxigênio", "Contração muscular"], correta: 0 },
{ pergunta: "Qual é a função do coração?", opcoes: ["Bombear sangue", "Filtrar toxinas", "Produzir hormônios", "Digestão"], correta: 0 },
{ pergunta: "Qual é a função da medula óssea?", opcoes: ["Produção de células sanguíneas", "Produção de insulina", "Digestão", "Transporte de oxigênio"], correta: 0 },
{ pergunta: "Qual organela contém clorofila?", opcoes: ["Cloroplasto", "Mitocôndria", "Ribossomo", "Lisossomo"], correta: 0 },
{ pergunta: "O que é respiração celular?", opcoes: ["Produção de energia (ATP) a partir de glicose", "Fotossíntese", "Divisão celular", "Digestão"], correta: 0 },
{ pergunta: "O que é fotossíntese?", opcoes: ["Produção de glicose a partir de luz, CO2 e água", "Respiração celular", "Divisão celular", "Excreção"], correta: 0 },
{ pergunta: "O que é reprodução sexuada?", opcoes: ["Combinação de material genético de dois indivíduos", "Clonagem", "Divisão celular simples", "Polinização apenas"], correta: 0 },
{ pergunta: "O que é reprodução assexuada?", opcoes: ["Um indivíduo origina outro geneticamente igual", "Combinação genética de dois indivíduos", "Fecundação", "Polinização"], correta: 0 },
{ pergunta: "Qual é a molécula que transporta informação genética?", opcoes: ["DNA", "RNA", "Proteína", "Lipídio"], correta: 0 },
{ pergunta: "Qual é a função do RNA mensageiro (mRNA)?", opcoes: ["Levar informação do DNA para síntese de proteínas", "Produzir energia", "Transportar oxigênio", "Digestão de nutrientes"], correta: 0 },
{ pergunta: "O que são enzimas?", opcoes: ["Proteínas que aceleram reações químicas", "Carboidratos de reserva", "Lipídios de membrana", "Ácidos nucleicos"], correta: 0 },
{ pergunta: "O que é homeostase?", opcoes: ["Manutenção do equilíbrio interno do organismo", "Reprodução celular", "Digestão", "Respiração"], correta: 0 },
{ pergunta: "O que são hormônios?", opcoes: ["Mensageiros químicos do corpo", "Enzimas digestivas", "Células sanguíneas", "Receptores nervosos"], correta: 0 },
{ pergunta: "O que é fototropismo?", opcoes: ["Crescimento de plantas em direção à luz", "Movimento de animais", "Divisão celular", "Respiração das folhas"], correta: 0 },
{ pergunta: "O que é gravitropismo?", opcoes: ["Crescimento das plantas em resposta à gravidade", "Movimento em direção à luz", "Fotossíntese", "Respiração celular"], correta: 0 },
{ pergunta: "O que são vacúolos?", opcoes: ["Armazenamento de substâncias na célula", "Produção de energia", "Síntese de proteínas", "Digestão de nutrientes"], correta: 0 },
{ pergunta: "O que é parede celular?", opcoes: ["Estrutura rígida que envolve células vegetais", "Membrana plasmática", "Mitocôndria", "Lisossomo"], correta: 0 },
{ pergunta: "O que é membrana plasmática?", opcoes: ["Barreira seletiva da célula", "Parede rígida da célula", "Organelo de produção de energia", "Armazenamento"], correta: 0 },
{ pergunta: "O que é endocitose?", opcoes: ["Entrada de partículas na célula", "Saída de partículas da célula", "Síntese de proteínas", "Fotossíntese"], correta: 0 },
{ pergunta: "O que é exocitose?", opcoes: ["Saída de partículas da célula", "Entrada de partículas na célula", "Respiração celular", "Divisão celular"], correta: 0 },
{ pergunta: "O que é mitose?", opcoes: ["Divisão celular para crescimento e reparo", "Reprodução sexuada", "Fotossíntese", "Respiração celular"], correta: 0 },
{ pergunta: "O que é meiose?", opcoes: ["Divisão celular para formação de gametas", "Divisão celular somática", "Divisão bacteriana", "Respiração celular"], correta: 0 },
{ pergunta: "Qual célula produz gametas masculinos?", opcoes: ["Espermatozoide", "Óvulo", "Glóbulo branco", "Célula somática"], correta: 0 },
{ pergunta: "Qual célula produz gametas femininos?", opcoes: ["Óvulo", "Espermatozoide", "Glóbulo branco", "Célula somática"], correta: 0 },
{ pergunta: "O que é DNA?", opcoes: ["Molécula que carrega informação genética", "Molécula de energia", "Molécula de transporte", "Molécula estrutural"], correta: 0 },
{ pergunta: "O que é RNA?", opcoes: ["Molécula que copia informação do DNA", "Molécula de energia", "Molécula de transporte de oxigênio", "Molécula de reserva"], correta: 0 }
];
const perguntasBiologiaMedias = [
{ pergunta: "O que é osmose?", opcoes: ["Movimento de água através de membrana semipermeável", "Movimento de soluto da água", "Transporte ativo de íons", "Divisão celular"], correta: 0 },
{ pergunta: "O que é difusão facilitada?", opcoes: ["Movimento de moléculas com auxílio de proteínas de membrana", "Movimento de água", "Transporte ativo de íons", "Fotossíntese"], correta: 0 },
{ pergunta: "Qual é a função dos lisossomos?", opcoes: ["Digestão intracelular de macromoléculas", "Produção de energia", "Síntese de proteínas", "Transporte de moléculas"], correta: 0 },
{ pergunta: "O que é fagocitose?", opcoes: ["Engolfamento de partículas sólidas pela célula", "Engolfamento de líquidos", "Produção de energia", "Síntese de proteínas"], correta: 0 },
{ pergunta: "O que é pinocitose?", opcoes: ["Engolfamento de líquidos pela célula", "Engolfamento de partículas sólidas", "Produção de energia", "Síntese de proteínas"], correta: 0 },
{ pergunta: "Qual é a função dos cloroplastos?", opcoes: ["Fotossíntese", "Respiração celular", "Digestão celular", "Síntese de proteínas"], correta: 0 },
{ pergunta: "O que é ATP?", opcoes: ["Molécula de energia da célula", "Molécula de informação genética", "Molécula estrutural", "Molécula de transporte de oxigênio"], correta: 0 },
{ pergunta: "Qual organela sintetiza proteínas?", opcoes: ["Ribossomos", "Mitocôndrias", "Lisossomos", "Peroxissomos"], correta: 0 },
{ pergunta: "O que é respiração aeróbica?", opcoes: ["Produção de ATP usando oxigênio", "Produção de ATP sem oxigênio", "Fotossíntese", "Fermentação"], correta: 0 },
{ pergunta: "O que é respiração anaeróbica?", opcoes: ["Produção de ATP sem oxigênio", "Produção de ATP com oxigênio", "Fotossíntese", "Síntese de proteínas"], correta: 0 },
{ pergunta: "O que é fermentação?", opcoes: ["Produção de energia na ausência de oxigênio", "Respiração aeróbica", "Divisão celular", "Fotossíntese"], correta: 0 },
{ pergunta: "O que é clorofila?", opcoes: ["Pigmento que absorve luz para fotossíntese", "Enzima digestiva", "Molécula de transporte", "Hormônio"], correta: 0 },
{ pergunta: "O que é tecido epitelial?", opcoes: ["Revestimento e proteção do corpo", "Tecido de sustentação", "Tecido nervoso", "Tecido muscular"], correta: 0 },
{ pergunta: "O que é tecido muscular?", opcoes: ["Responsável pelo movimento", "Revestimento", "Proteção", "Armazenamento"], correta: 0 },
{ pergunta: "O que é tecido nervoso?", opcoes: ["Transmissão de impulsos elétricos", "Movimento", "Digestão", "Proteção"], correta: 0 },
{ pergunta: "O que é tecido conjuntivo?", opcoes: ["Sustentação e preenchimento", "Movimento", "Transmissão de impulsos", "Revestimento"], correta: 0 },
{ pergunta: "Qual é a função da hemoglobina?", opcoes: ["Transporte de oxigênio no sangue", "Defesa contra patógenos", "Coagulação", "Produção de energia"], correta: 0 },
{ pergunta: "O que são anticorpos?", opcoes: ["Proteínas que combatem antígenos", "Moléculas de energia", "Células nervosas", "Hormônios"], correta: 0 },
{ pergunta: "O que é sistema imunológico?", opcoes: ["Defesa do organismo contra infecções", "Sistema circulatório", "Sistema digestivo", "Sistema nervoso"], correta: 0 },
{ pergunta: "O que é fotossíntese?", opcoes: ["Produção de glicose a partir de CO2 e luz", "Respiração celular", "Fermentação", "Transporte de água"], correta: 0 },
{ pergunta: "O que é transpiração?", opcoes: ["Perda de água pelas folhas", "Absorção de nutrientes", "Produção de energia", "Divisão celular"], correta: 0 },
{ pergunta: "O que é estômato?", opcoes: ["Abertura na folha que permite troca gasosa", "Organelo celular", "Célula de defesa", "Tecido de sustentação"], correta: 0 },
{ pergunta: "O que é plasmodesmo?", opcoes: ["Conexão entre células vegetais", "Organelo de digestão", "Molécula de energia", "Transporte sanguíneo"], correta: 0 },
{ pergunta: "O que é citoplasma?", opcoes: ["Região entre membrana e núcleo", "DNA da célula", "Organelo de energia", "Parede celular"], correta: 0 },
{ pergunta: "O que é membrana nuclear?", opcoes: ["Barreira que envolve o núcleo", "Organelo de digestão", "Mitocôndria", "Ribossomo"], correta: 0 },
{ pergunta: "O que são organelas membranosas?", opcoes: ["Estruturas envolvidas por membrana", "Células completas", "Moléculas de energia", "Tecido"], correta: 0 },
{ pergunta: "O que é cromatina?", opcoes: ["Complexo de DNA e proteínas no núcleo", "Organelo de energia", "Célula sanguínea", "Tecido nervoso"], correta: 0 },
{ pergunta: "O que é cromossomo?", opcoes: ["Estrutura que contém DNA condensado", "Ribossomo", "Lisossomo", "Mitocôndria"], correta: 0 },
{ pergunta: "O que é ciclo celular?", opcoes: ["Sequência de eventos de crescimento e divisão celular", "Fotossíntese", "Transporte de oxigênio", "Respiração"], correta: 0 },
{ pergunta: "O que é interfase?", opcoes: ["Fase de crescimento e preparação para divisão celular", "Divisão celular", "Fotossíntese", "Respiração"], correta: 0 },
{ pergunta: "O que é mitose?", opcoes: ["Divisão celular somática", "Divisão celular de gametas", "Fotossíntese", "Fermentação"], correta: 0 },
{ pergunta: "O que é meiose?", opcoes: ["Divisão celular para formação de gametas", "Divisão somática", "Fotossíntese", "Respiração"], correta: 0 },
{ pergunta: "O que é gameta?", opcoes: ["Célula reprodutiva", "Célula somática", "Célula muscular", "Célula nervosa"], correta: 0 },
{ pergunta: "O que é zigoto?", opcoes: ["Célula formada pela fusão de gametas", "Gameta masculino", "Gameta feminino", "Célula somática"], correta: 0 },
{ pergunta: "O que é hereditariedade?", opcoes: ["Transmissão de características genéticas", "Produção de energia", "Digestão", "Respiração"], correta: 0 },
{ pergunta: "O que é gene?", opcoes: ["Segmento de DNA que codifica proteína", "Molécula de energia", "Organelo celular", "Tecido"], correta: 0 },
{ pergunta: "O que é alelo?", opcoes: ["Forma alternativa de um gene", "Célula somática", "Molécula de RNA", "Organelo"], correta: 0 },
{ pergunta: "O que é genótipo?", opcoes: ["Conjunto de genes de um indivíduo", "Aparência externa", "Célula somática", "Organelo"], correta: 0 },
{ pergunta: "O que é fenótipo?", opcoes: ["Aparência ou característica observável", "Conjunto de genes", "Célula somática", "Organelo"], correta: 0 },
{ pergunta: "O que é mutação?", opcoes: ["Alteração na sequência de DNA", "Divisão celular", "Fotossíntese", "Respiração"], correta: 0 },
{ pergunta: "O que é seleção natural?", opcoes: ["Processo que favorece indivíduos adaptados", "Mutação genética", "Divisão celular", "Fotossíntese"], correta: 0 },
{ pergunta: "O que é evolução?", opcoes: ["Mudança nas populações ao longo do tempo", "Mutação individual", "Divisão celular", "Respiração"], correta: 0 },
{ pergunta: "O que é ecossistema?", opcoes: ["Conjunto de seres vivos e ambiente", "Apenas animais", "Apenas plantas", "Apenas microrganismos"], correta: 0 },
{ pergunta: "O que é cadeia alimentar?", opcoes: ["Sequência de transferência de energia entre organismos", "Sequência de reprodução", "Ciclo de divisão celular", "Fotossíntese"], correta: 0 },
{ pergunta: "O que é biodiversidade?", opcoes: ["Variedade de seres vivos em um ambiente", "Número de ecossistemas", "Produção de energia", "Transporte de nutrientes"], correta: 0 },
{ pergunta: "O que é fototropismo?", opcoes: ["Crescimento de plantas em direção à luz", "Crescimento de plantas para a gravidade", "Transporte de água", "Fotossíntese"], correta: 0 },
{ pergunta: "O que é gravitropismo?", opcoes: ["Crescimento das plantas em resposta à gravidade", "Crescimento para a luz", "Fotossíntese", "Respiração"], correta: 0 }
];
const perguntasBiologiaDificeis = [
{ pergunta: "O que é epigenética?", opcoes: ["Alterações na expressão gênica sem mudança na sequência de DNA", "Mutação de nucleotídeos", "Transcrição de RNA", "Síntese proteica"], correta: 0 },
{ pergunta: "O que é transcrição gênica?", opcoes: ["Síntese de RNA a partir do DNA", "Divisão celular", "Síntese de proteínas", "Mutação genética"], correta: 0 },
{ pergunta: "O que é tradução gênica?", opcoes: ["Síntese de proteínas a partir do RNA mensageiro", "Síntese de DNA", "Divisão celular", "Mutação genética"], correta: 0 },
{ pergunta: "O que são introns?", opcoes: ["Segmentos de RNA não codificantes removidos durante processamento", "Exons codificantes", "Genes reguladores", "RNA ribossomal"], correta: 0 },
{ pergunta: "O que são exons?", opcoes: ["Segmentos codificantes do RNA", "Introns", "RNA transportador", "DNA repetitivo"], correta: 0 },
{ pergunta: "O que é splicing alternativo?", opcoes: ["Produção de diferentes RNAs mensageiros a partir de um mesmo gene", "Divisão celular", "Mutação genética", "Fotossíntese"], correta: 0 },
{ pergunta: "O que é operon?", opcoes: ["Conjunto de genes regulados juntos em procariontes", "Gene isolado em eucariotos", "RNA mensageiro", "Proteína enzimática"], correta: 0 },
{ pergunta: "O que é DNA plasmidial?", opcoes: ["DNA extracromossômico em bactérias", "DNA nuclear", "RNA ribossomal", "Mitocôndria"], correta: 0 },
{ pergunta: "O que é recombinação genética?", opcoes: ["Troca de segmentos de DNA entre moléculas", "Mutação pontual", "Transcrição", "Fotossíntese"], correta: 0 },
{ pergunta: "O que é polimorfismo genético?", opcoes: ["Variabilidade na sequência de DNA entre indivíduos", "Mutação letal", "Transcrição genética", "Fotossíntese"], correta: 0 },
{ pergunta: "O que é genoma?", opcoes: ["Conjunto completo de DNA de um organismo", "Somente genes ativos", "RNA celular", "Proteínas expressas"], correta: 0 },
{ pergunta: "O que é proteoma?", opcoes: ["Conjunto completo de proteínas de um organismo ou célula", "Conjunto de genes", "Conjunto de RNA", "Conjunto de lipídios"], correta: 0 },
{ pergunta: "O que é transcriptoma?", opcoes: ["Conjunto de todos os RNAs de uma célula", "Conjunto de proteínas", "Conjunto de genes", "Conjunto de organelas"], correta: 0 },
{ pergunta: "O que é metilação do DNA?", opcoes: ["Adição de grupos metil que regulam expressão gênica", "Mutação de nucleotídeo", "Transcrição", "Síntese proteica"], correta: 0 },
{ pergunta: "O que é acetilação de histonas?", opcoes: ["Modificação de proteínas que facilita expressão gênica", "Mutação genética", "Replicação de DNA", "Transcrição de RNA"], correta: 0 },
{ pergunta: "O que é CRISPR-Cas9?", opcoes: ["Sistema de edição genética", "Reação enzimática digestiva", "Transcrição de RNA", "Produção de ATP"], correta: 0 },
{ pergunta: "O que é apoptose?", opcoes: ["Morte celular programada", "Divisão celular", "Mutação genética", "Transcrição"], correta: 0 },
{ pergunta: "O que é autofagia?", opcoes: ["Processo de degradação de componentes celulares", "Produção de energia", "Divisão celular", "Fotossíntese"], correta: 0 },
{ pergunta: "O que são telômeros?", opcoes: ["Extremidades dos cromossomos que protegem o DNA", "Genes codificantes", "RNA mensageiro", "Ribossomos"], correta: 0 },
{ pergunta: "O que é telomerase?", opcoes: ["Enzima que alonga telômeros", "Proteína estrutural", "RNA regulador", "Ligase"], correta: 0 },
{ pergunta: "O que é oncogene?", opcoes: ["Gene que pode causar câncer quando ativado", "Gene de defesa", "RNA mensageiro", "Proteína estrutural"], correta: 0 },
{ pergunta: "O que é supressor tumoral?", opcoes: ["Gene que inibe crescimento celular descontrolado", "Gene oncogênico", "RNA mensageiro", "Proteína enzimática"], correta: 0 },
{ pergunta: "O que é ciclo de Krebs?", opcoes: ["Ciclo de reações para produção de ATP na respiração aeróbica", "Fotossíntese", "Divisão celular", "Fermentação"], correta: 0 },
{ pergunta: "O que é cadeia transportadora de elétrons?", opcoes: ["Sequência de proteínas que transfere elétrons e gera ATP", "Fotossíntese", "Respiração anaeróbica", "Fermentação"], correta: 0 },
{ pergunta: "O que é quimiosmose?", opcoes: ["Movimento de prótons que gera ATP", "Movimento de glicose", "Divisão celular", "Transcrição"], correta: 0 },
{ pergunta: "O que é transporte ativo?", opcoes: ["Movimento de substâncias contra o gradiente de concentração usando energia", "Difusão simples", "Osmose", "Difusão facilitada"], correta: 0 },
{ pergunta: "O que é transporte passivo?", opcoes: ["Movimento de substâncias a favor do gradiente sem gastar energia", "Movimento contra gradiente", "Endocitose", "Exocitose"], correta: 0 },
{ pergunta: "O que é fotofosforilação?", opcoes: ["Produção de ATP na fotossíntese usando luz", "Respiração celular", "Fermentação", "Divisão celular"], correta: 0 },
{ pergunta: "O que é quimiossíntese?", opcoes: ["Produção de energia química por bactérias a partir de substâncias inorgânicas", "Fotossíntese", "Respiração aeróbica", "Fermentação"], correta: 0 },
{ pergunta: "O que é microbioma?", opcoes: ["Conjunto de microrganismos que habitam um organismo", "Tecido muscular", "Célula somática", "Organelo celular"], correta: 0 },
{ pergunta: "O que é endossimbiose?", opcoes: ["Teoria de origem de mitocôndrias e cloroplastos", "Mutação genética", "Divisão celular", "Transcrição"], correta: 0 },
{ pergunta: "O que é quimerismo genético?", opcoes: ["Presença de células com genótipos diferentes em um mesmo organismo", "Mutação de gametas", "Transcrição de RNA", "Fotossíntese"], correta: 0 },
{ pergunta: "O que é poliploidia?", opcoes: ["Organismo com mais de dois conjuntos de cromossomos", "Organismo haploide", "Divisão celular somática", "Transcrição genética"], correta: 0 },
{ pergunta: "O que é homeostase?", opcoes: ["Manutenção do equilíbrio interno em organismos complexos", "Divisão celular", "Fotossíntese", "Mutação genética"], correta: 0 },
{ pergunta: "O que é barreira hematoencefálica?", opcoes: ["Estrutura que protege o cérebro filtrando substâncias do sangue", "Membrana celular", "Tecido muscular", "Organelo celular"], correta: 0 },
{ pergunta: "O que são neurotransmissores?", opcoes: ["Moléculas que transmitem sinais entre neurônios", "Hormônios digestivos", "Células sanguíneas", "Proteínas estruturais"], correta: 0 },
{ pergunta: "O que é sinapse?", opcoes: ["Conexão entre neurônios onde ocorre transmissão de sinais", "Divisão celular", "Fotossíntese", "Transcrição gênica"], correta: 0 },
{ pergunta: "O que é imunidade adaptativa?", opcoes: ["Resposta específica e memorizada do sistema imunológico", "Resposta geral inata", "Produção de ATP", "Divisão celular"], correta: 0 },
{ pergunta: "O que é imunidade inata?", opcoes: ["Resposta imediata e não específica do organismo", "Resposta adaptativa", "Produção de proteínas", "Divisão celular"], correta: 0 },
{ pergunta: "O que são células-tronco?", opcoes: ["Células indiferenciadas que podem se tornar diferentes tipos celulares", "Células nervosas", "Células musculares", "Glóbulos vermelhos"], correta: 0 },
{ pergunta: "O que é apoptose?", opcoes: ["Morte celular programada essencial para desenvolvimento e equilíbrio", "Divisão celular", "Mutação genética", "Transcrição"], correta: 0 },
{ pergunta: "O que é autofagia?", opcoes: ["Degradação de componentes celulares para reciclagem", "Produção de energia", "Divisão celular", "Fotossíntese"], correta: 0 },
{ pergunta: "O que são telômeros?", opcoes: ["Regiões protetoras nas extremidades dos cromossomos", "Genes codificantes", "RNA mensageiro", "Ribossomos"], correta: 0 },
{ pergunta: "O que é senescência celular?", opcoes: ["Perda de capacidade de divisão celular", "Crescimento celular", "Divisão rápida", "Fotossíntese"], correta: 0 },
{ pergunta: "O que é mutação somática?", opcoes: ["Mutação em células não germinativas", "Mutação em gametas", "Mutação hereditária", "Mutação de organelos"], correta: 0 },
{ pergunta: "O que é mutação germinativa?", opcoes: ["Mutação em células reprodutivas que pode ser passada à descendência", "Mutação somática", "Mutação estrutural", "Mutação enzimática"], correta: 0 },
{ pergunta: "O que é epistasia?", opcoes: ["Interação de genes onde um gene mascara efeito de outro", "Mutação pontual", "Transcrição gênica", "Síntese proteica"], correta: 0 },
{ pergunta: "O que é pleiotropia?", opcoes: ["Um gene afeta múltiplas características fenotípicas", "Mutação somática", "Transcrição gênica", "Síntese proteica"], correta: 0 },
{ pergunta: "O que é poligenia?", opcoes: ["Múltiplos genes contribuem para uma característica", "Um gene único determina característica", "Transcrição de RNA", "Divisão celular"], correta: 0 }
];

const perguntasFilosofiaFaceis = [
{ pergunta: "Quem é considerado o pai da Filosofia ocidental?", opcoes: ["Sócrates", "Platão", "Aristóteles", "Descartes"], correta: 0 },
{ pergunta: "O que significa 'Filosofia' em grego?", opcoes: ["Amor à sabedoria", "Ciência da natureza", "Estudo da política", "Arte de pensar"], correta: 0 },
{ pergunta: "Quem foi aluno de Sócrates?", opcoes: ["Platão", "Aristóteles", "Epicuro", "Heráclito"], correta: 0 },
{ pergunta: "Quem foi aluno de Platão?", opcoes: ["Aristóteles", "Sócrates", "Demócrito", "Tomás de Aquino"], correta: 0 },
{ pergunta: "O que é ética?", opcoes: ["Estudo do que é certo e errado", "Estudo da natureza", "Estudo da arte", "Estudo da lógica"], correta: 0 },
{ pergunta: "O que é metafísica?", opcoes: ["Estudo do ser e da realidade", "Estudo da política", "Estudo da matemática", "Estudo da arte"], correta: 0 },
{ pergunta: "O que é epistemologia?", opcoes: ["Estudo do conhecimento", "Estudo do ser", "Estudo da moral", "Estudo da lógica"], correta: 0 },
{ pergunta: "O que é lógica?", opcoes: ["Estudo do raciocínio correto", "Estudo da ética", "Estudo da política", "Estudo da arte"], correta: 0 },
{ pergunta: "Quem escreveu 'A República'?", opcoes: ["Platão", "Aristóteles", "Sócrates", "Epicuro"], correta: 0 },
{ pergunta: "Quem escreveu 'Ética a Nicômaco'?", opcoes: ["Aristóteles", "Platão", "Sócrates", "Descartes"], correta: 0 },
{ pergunta: "Quem disse 'Só sei que nada sei'?", opcoes: ["Sócrates", "Platão", "Aristóteles", "Epicuro"], correta: 0 },
{ pergunta: "O que é materialismo?", opcoes: ["Doutrina que afirma que só a matéria existe", "Estudo do espírito", "Estudo da lógica", "Estudo da política"], correta: 0 },
{ pergunta: "O que é idealismo?", opcoes: ["Doutrina que valoriza a mente ou ideias sobre a matéria", "Estudo da ética", "Estudo da lógica", "Estudo da política"], correta: 0 },
{ pergunta: "O que é empirismo?", opcoes: ["Teoria de que o conhecimento vem da experiência", "Teoria das ideias inatas", "Estudo da política", "Estudo da arte"], correta: 0 },
{ pergunta: "O que é racionalismo?", opcoes: ["Teoria de que o conhecimento vem da razão", "Teoria da experiência sensorial", "Estudo da política", "Estudo da arte"], correta: 0 },
{ pergunta: "Quem escreveu 'Discurso do Método'?", opcoes: ["Descartes", "Platão", "Aristóteles", "Kant"], correta: 0 },
{ pergunta: "Quem é considerado filósofo iluminista?", opcoes: ["Voltaire", "Sócrates", "Aristóteles", "Epicuro"], correta: 0 },
{ pergunta: "O que é existencialismo?", opcoes: ["Filosofia que enfatiza a liberdade e a existência humana", "Doutrina sobre conhecimento", "Estudo da natureza", "Estudo da ética"], correta: 0 },
{ pergunta: "Quem escreveu 'Assim Falou Zaratustra'?", opcoes: ["Nietzsche", "Kant", "Hegel", "Voltaire"], correta: 0 },
{ pergunta: "Quem é filósofo da dialética?", opcoes: ["Hegel", "Epicuro", "Descartes", "Sartre"], correta: 0 },
{ pergunta: "O que é utilitarismo?", opcoes: ["Doutrina que avalia ações pelo benefício coletivo", "Estudo da lógica", "Estudo da arte", "Estudo da ética individual"], correta: 0 },
{ pergunta: "Quem é autor do utilitarismo clássico?", opcoes: ["Bentham", "Kant", "Aristóteles", "Sócrates"], correta: 0 },
{ pergunta: "O que é deontologia?", opcoes: ["Doutrina ética baseada em deveres", "Estudo do prazer", "Estudo da experiência", "Estudo da política"], correta: 0 },
{ pergunta: "Quem escreveu 'Fundamentação da Metafísica dos Costumes'?", opcoes: ["Kant", "Nietzsche", "Platão", "Aristóteles"], correta: 0 },
{ pergunta: "O que é niilismo?", opcoes: ["Doutrina que nega valores absolutos", "Estudo da ética", "Estudo da política", "Estudo da lógica"], correta: 0 },
{ pergunta: "O que é estoicismo?", opcoes: ["Filosofia que valoriza a virtude e o controle das emoções", "Estudo da política", "Estudo da arte", "Estudo da lógica"], correta: 0 },
{ pergunta: "Quem foi filósofo estoico?", opcoes: ["Sêneca", "Nietzsche", "Kant", "Platão"], correta: 0 },
{ pergunta: "O que é epicurismo?", opcoes: ["Filosofia que busca prazer moderado e ausência de dor", "Estudo da lógica", "Estudo da política", "Estudo da ética kantiana"], correta: 0 },
{ pergunta: "Quem foi filósofo epicurista?", opcoes: ["Epicuro", "Aristóteles", "Sócrates", "Voltaire"], correta: 0 },
{ pergunta: "O que é filosofia política?", opcoes: ["Estudo do poder, leis e sociedade", "Estudo da ética individual", "Estudo da lógica", "Estudo da arte"], correta: 0 },
{ pergunta: "O que é filosofia moral?", opcoes: ["Estudo do certo e do errado", "Estudo da estética", "Estudo da política", "Estudo da lógica"], correta: 0 },
{ pergunta: "O que é estética?", opcoes: ["Estudo da beleza e da arte", "Estudo da política", "Estudo da lógica", "Estudo do dever"], correta: 0 },
{ pergunta: "O que é sofismo?", opcoes: ["Ensino de retórica e argumentação persuasiva", "Estudo da ética", "Estudo da lógica", "Estudo da política"], correta: 0 },
{ pergunta: "Quem eram os sofistas?", opcoes: ["Professores da Grécia Antiga especializados em retórica", "Filosofos iluministas", "Filósofos medievais", "Filósofos da Renascença"], correta: 0 },
{ pergunta: "O que é paradoxo?", opcoes: ["Afirmação aparentemente contraditória", "Teoria ética", "Princípio lógico", "Estudo do ser"], correta: 0 },
{ pergunta: "O que é niilismo?", opcoes: ["Negação de valores e significados universais", "Doutrina do dever", "Estudo da lógica", "Estudo da ética"], correta: 0 },
{ pergunta: "O que é filosofia da ciência?", opcoes: ["Estudo dos fundamentos e métodos científicos", "Estudo da política", "Estudo da arte", "Estudo do prazer"], correta: 0 },
{ pergunta: "O que é ceticismo?", opcoes: ["Dúvida sistemática sobre o conhecimento", "Acreditar em tudo", "Aceitar dogmas", "Estudo da estética"], correta: 0 },
{ pergunta: "Quem foi filósofo cético famoso?", opcoes: ["Pirro de Élis", "Aristóteles", "Platão", "Sêneca"], correta: 0 },
{ pergunta: "O que é determinismo?", opcoes: ["Doutrina que acredita que tudo é causalmente determinado", "Liberdade absoluta", "Estudo da ética", "Estudo da arte"], correta: 0 },
{ pergunta: "O que é liberdade segundo Sartre?", opcoes: ["Capacidade de escolher apesar das circunstâncias", "Predestinação", "Determinismo", "Felicidade garantida"], correta: 0 },
{ pergunta: "O que é filosofia existencialista?", opcoes: ["Estudo da existência humana, liberdade e responsabilidade", "Estudo da política", "Estudo da estética", "Estudo da lógica"], correta: 0 },
{ pergunta: "Quem disse 'o homem está condenado a ser livre'?", opcoes: ["Sartre", "Nietzsche", "Kant", "Aristóteles"], correta: 0 },
{ pergunta: "O que é filosofia analítica?", opcoes: ["Abordagem que enfatiza lógica e linguagem", "Estudo da ética", "Estudo da política", "Estudo da estética"], correta: 0 },
{ pergunta: "Quem é considerado fundador da filosofia analítica?", opcoes: ["Frege", "Kant", "Nietzsche", "Platão"], correta: 0 },
{ pergunta: "O que é filosofia continental?", opcoes: ["Tradição filosófica europeia centrada em história, cultura e crítica", "Estudo da lógica formal", "Estudo da matemática", "Estudo da física"], correta: 0 },
{ pergunta: "O que é dialética socrática?", opcoes: ["Método de diálogo para chegar à verdade", "Debate sobre política", "Estudo da ética", "Estudo da estética"], correta: 0 },
{ pergunta: "O que é pensamento crítico?", opcoes: ["Análise racional e reflexiva de ideias", "Aceitação de dogmas", "Crença cega", "Estudo da estética"], correta: 0 },
{ pergunta: "O que é teleologia?", opcoes: ["Estudo do propósito ou finalidade nas coisas", "Estudo da lógica", "Estudo da estética", "Estudo da política"], correta: 0 },
{ pergunta: "O que é pragmatismo?", opcoes: ["Teoria que valoriza consequências práticas do conhecimento", "Estudo da lógica formal", "Estudo da estética", "Estudo da ética kantiana"], correta: 0 },
{ pergunta: "Quem foi filósofo pragmatista famoso?", opcoes: ["William James", "Kant", "Nietzsche", "Platão"], correta: 0 },
{ pergunta: "O que é filosofia da mente?", opcoes: ["Estudo da consciência e experiência mental", "Estudo da ética", "Estudo da política", "Estudo da estética"], correta: 0 },
{ pergunta: "O que é fenomenologia?", opcoes: ["Estudo da experiência subjetiva e consciência", "Estudo da ética", "Estudo da política", "Estudo da estética"], correta: 0 },
{ pergunta: "Quem fundou a fenomenologia?", opcoes: ["Edmund Husserl", "Nietzsche", "Kant", "Platão"], correta: 0 }
];
const perguntasFilosofiaMedias = [
{ pergunta: "O que é ética utilitarista?", opcoes: ["Avaliação moral baseada na maximização da felicidade", "Estudo da lógica formal", "Busca da virtude individual", "Estudo da estética"], correta: 0 },
{ pergunta: "Quem é autor do utilitarismo clássico?", opcoes: ["Jeremy Bentham", "Immanuel Kant", "Aristóteles", "Jean-Jacques Rousseau"], correta: 0 },
{ pergunta: "O que é ética deontológica?", opcoes: ["Avaliação moral baseada no dever e regras", "Maximização da felicidade", "Busca do prazer", "Estudo da política"], correta: 0 },
{ pergunta: "Quem foi filósofo deontológico famoso?", opcoes: ["Immanuel Kant", "Aristóteles", "Epicuro", "Nietzsche"], correta: 0 },
{ pergunta: "O que é ética das virtudes?", opcoes: ["Avaliação moral baseada em características do caráter", "Regras universais", "Consequências das ações", "Estudo da estética"], correta: 0 },
{ pergunta: "Quem propôs a ética das virtudes?", opcoes: ["Aristóteles", "Platão", "Kant", "Bentham"], correta: 0 },
{ pergunta: "O que é contrato social?", opcoes: ["Ideia de que a sociedade se forma por acordo entre indivíduos", "Teoria da evolução", "Estudo da lógica formal", "Estudo da estética"], correta: 0 },
{ pergunta: "Quem escreveu 'O Contrato Social'?", opcoes: ["Jean-Jacques Rousseau", "John Locke", "Montesquieu", "Kant"], correta: 0 },
{ pergunta: "Quem defendeu o empirismo britânico?", opcoes: ["John Locke", "Descartes", "Kant", "Platão"], correta: 0 },
{ pergunta: "O que é racionalismo cartesiano?", opcoes: ["Doutrina que privilegia a razão como fonte de conhecimento", "Doutrina que privilegia a experiência", "Doutrina política", "Estudo da estética"], correta: 0 },
{ pergunta: "Quem disse 'Penso, logo existo'?", opcoes: ["René Descartes", "Kant", "Aristóteles", "Platão"], correta: 0 },
{ pergunta: "O que é criticismo kantiano?", opcoes: ["Teoria que busca limites e possibilidades do conhecimento", "Teoria do prazer", "Teoria da virtude", "Teoria da política"], correta: 0 },
{ pergunta: "Quem é autor da 'Crítica da Razão Pura'?", opcoes: ["Immanuel Kant", "Hegel", "Nietzsche", "Voltaire"], correta: 0 },
{ pergunta: "O que é idealismo alemão?", opcoes: ["Filosofia que valoriza a mente e ideias como realidade central", "Estudo da ética", "Estudo da política", "Estudo da lógica formal"], correta: 0 },
{ pergunta: "Quem é filósofo do idealismo alemão?", opcoes: ["Hegel", "Kant", "Nietzsche", "Aristóteles"], correta: 0 },
{ pergunta: "O que é materialismo histórico?", opcoes: ["Teoria que explica a história pelas condições materiais e econômicas", "Estudo da ética", "Estudo da estética", "Teoria da lógica"], correta: 0 },
{ pergunta: "Quem propôs o materialismo histórico?", opcoes: ["Karl Marx", "Hegel", "Nietzsche", "Rousseau"], correta: 0 },
{ pergunta: "O que é alienação na perspectiva marxista?", opcoes: ["Perda de controle do trabalhador sobre o produto do seu trabalho", "Falta de virtude individual", "Erro lógico", "Falta de prazer"], correta: 0 },
{ pergunta: "O que é dialética hegeliana?", opcoes: ["Processo de desenvolvimento através de tese, antítese e síntese", "Processo de maximização do prazer", "Estudo da ética", "Estudo da política"], correta: 0 },
{ pergunta: "O que é historicismo?", opcoes: ["Interpretação de fenômenos considerando seu contexto histórico", "Teoria da lógica", "Estudo da estética", "Ética utilitarista"], correta: 0 },
{ pergunta: "O que é fenomenologia?", opcoes: ["Estudo da experiência consciente e da percepção", "Teoria da história", "Estudo da política", "Ética das virtudes"], correta: 0 },
{ pergunta: "Quem fundou a fenomenologia?", opcoes: ["Edmund Husserl", "Nietzsche", "Kant", "Aristóteles"], correta: 0 },
{ pergunta: "O que é existencialismo?", opcoes: ["Filosofia que enfoca liberdade, responsabilidade e existência individual", "Estudo da política", "Estudo da ética utilitarista", "Estudo da estética"], correta: 0 },
{ pergunta: "Quem é autor de 'O Ser e o Nada'?", opcoes: ["Jean-Paul Sartre", "Nietzsche", "Kant", "Hegel"], correta: 0 },
{ pergunta: "O que é niilismo?", opcoes: ["Negação de valores absolutos e sentido da vida", "Estudo da política", "Estudo da lógica formal", "Estudo da ética"], correta: 0 },
{ pergunta: "Quem é autor do niilismo moderno?", opcoes: ["Friedrich Nietzsche", "Kant", "Aristóteles", "Platão"], correta: 0 },
{ pergunta: "O que é hermenêutica?", opcoes: ["Arte e ciência da interpretação de textos", "Estudo da lógica formal", "Estudo da política", "Estudo da estética"], correta: 0 },
{ pergunta: "Quem é considerado filósofo hermeneuta moderno?", opcoes: ["Hans-Georg Gadamer", "Nietzsche", "Kant", "Sartre"], correta: 0 },
{ pergunta: "O que é filosofia analítica?", opcoes: ["Abordagem que enfatiza clareza, lógica e linguagem", "Estudo da ética utilitarista", "Estudo da política", "Estudo da estética"], correta: 0 },
{ pergunta: "Quem é fundador da filosofia analítica?", opcoes: ["Gottlob Frege", "Nietzsche", "Kant", "Aristóteles"], correta: 0 },
{ pergunta: "O que é pragmatismo?", opcoes: ["Filosofia que valoriza resultados práticos do pensamento", "Estudo da lógica formal", "Estudo da estética", "Estudo da ética kantiana"], correta: 0 },
{ pergunta: "Quem é filósofo pragmatista famoso?", opcoes: ["William James", "Aristóteles", "Kant", "Hegel"], correta: 0 },
{ pergunta: "O que é pós-modernismo?", opcoes: ["Corrente que questiona verdades universais e narrativas totalizantes", "Estudo da ética utilitarista", "Estudo da lógica formal", "Estudo da política"], correta: 0 },
{ pergunta: "Quem é filósofo pós-moderno?", opcoes: ["Michel Foucault", "Nietzsche", "Kant", "Aristóteles"], correta: 0 },
{ pergunta: "O que é crítica da razão?", opcoes: ["Investigar limites e possibilidades do conhecimento humano", "Estudo da política", "Estudo da estética", "Estudo da ética utilitarista"], correta: 0 },
{ pergunta: "Quem é autor da crítica da razão pura?", opcoes: ["Immanuel Kant", "Hegel", "Nietzsche", "Descartes"], correta: 0 },
{ pergunta: "O que é determinismo?", opcoes: ["Teoria de que eventos são causados por fatores anteriores", "Liberdade absoluta", "Estudo da estética", "Estudo da política"], correta: 0 },
{ pergunta: "O que é liberdade positiva segundo Rousseau?", opcoes: ["Capacidade de agir segundo a vontade coletiva e racional", "Liberdade irrestrita", "Determinismo", "Ética utilitarista"], correta: 0 },
{ pergunta: "O que é liberdade negativa?", opcoes: ["Ausência de coerção externa", "Liberdade interna", "Estudo da ética", "Estudo da lógica"], correta: 0 },
{ pergunta: "O que é teoria crítica?", opcoes: ["Filosofia que busca criticar e transformar a sociedade", "Estudo da estética", "Estudo da lógica formal", "Estudo da ética"], correta: 0 },
{ pergunta: "Quem é filósofo da teoria crítica?", opcoes: ["Theodor Adorno", "Nietzsche", "Kant", "Aristóteles"], correta: 0 },
{ pergunta: "O que é filosofia da linguagem?", opcoes: ["Estudo do significado, uso e função da linguagem", "Estudo da ética", "Estudo da política", "Estudo da estética"], correta: 0 },
{ pergunta: "O que é devir em filosofia?", opcoes: ["Processo de mudança contínua e transformação", "Estado permanente", "Estudo da ética", "Estudo da lógica"], correta: 0 },
{ pergunta: "O que é ontologia?", opcoes: ["Estudo do ser e da existência", "Estudo da estética", "Estudo da política", "Estudo da ética"], correta: 0 },
{ pergunta: "O que é fenomenologia transcendental?", opcoes: ["Estudo da experiência pura antes de interpretações", "Estudo da política", "Estudo da estética", "Estudo da ética"], correta: 0 },
{ pergunta: "Quem desenvolveu a fenomenologia transcendental?", opcoes: ["Edmund Husserl", "Kant", "Nietzsche", "Aristóteles"], correta: 0 },
{ pergunta: "O que é devir eterno?", opcoes: ["Conceito de Nietzsche sobre repetição e mudança infinita", "Estado estático", "Estudo da ética", "Estudo da política"], correta: 0 },
{ pergunta: "O que é diferença entre ética e moral?", opcoes: ["Ética é reflexão, moral são regras praticadas", "Moral é reflexão, ética são regras praticadas", "São iguais", "Nenhuma relação"], correta: 0 },
{ pergunta: "O que é autêntico em Sartre?", opcoes: ["Viver de acordo com escolhas livres conscientes", "Seguir costumes", "Obedecer regras", "Evitar responsabilidade"], correta: 0 }
];
const perguntasFilosofiaDificeis = [
{ pergunta: "O que é niilismo ativo segundo Nietzsche?", opcoes: ["Criação de novos valores diante da ausência de valores absolutos", "Negação passiva da moral", "Aceitação da moral tradicional", "Obediência a dogmas"], correta: 0 },
{ pergunta: "O que é niilismo passivo segundo Nietzsche?", opcoes: ["Aceitação da falta de sentido e valores sem criar novos", "Criação de novos valores", "Estudo da lógica formal", "Filosofia moral"], correta: 0 },
{ pergunta: "O que é vontade de poder segundo Nietzsche?", opcoes: ["Impulso fundamental de crescimento e afirmação da vida", "Desejo de riqueza", "Busca de prazer", "Determinação ética"], correta: 0 },
{ pergunta: "O que é eterno retorno segundo Nietzsche?", opcoes: ["Ideia de repetição infinita de eventos e vida", "Fim absoluto do mundo", "Estudo da ética", "Filosofia política"], correta: 0 },
{ pergunta: "O que é Übermensch (Além-do-homem)?", opcoes: ["Indivíduo que cria seus próprios valores e supera limitações humanas", "Homem comum", "Pessoa moralmente passiva", "Seguidor de dogmas"], correta: 0 },
{ pergunta: "O que é perspectivismo?", opcoes: ["Teoria de que o conhecimento depende do ponto de vista", "Conhecimento absoluto", "Verdade universal", "Estudo da lógica formal"], correta: 0 },
{ pergunta: "O que é dialética materialista?", opcoes: ["Método de análise da realidade baseado na luta de contrários e na matéria", "Estudo da ética", "Estudo da estética", "Estudo da política"], correta: 0 },
{ pergunta: "Quem desenvolveu a dialética materialista?", opcoes: ["Karl Marx e Friedrich Engels", "Hegel", "Nietzsche", "Kant"], correta: 0 },
{ pergunta: "O que é superestrutura na teoria marxista?", opcoes: ["Instituições e ideias derivadas da base econômica", "Classe dominante", "Organização política autônoma", "Fenômeno natural"], correta: 0 },
{ pergunta: "O que é infraestrutura na teoria marxista?", opcoes: ["Base econômica da sociedade, produção e relações de produção", "Ideias filosóficas", "Instituições políticas", "Cultura e arte"], correta: 0 },
{ pergunta: "O que é alienação segundo Marx?", opcoes: ["Separação do trabalhador do produto, processo, espécie e outros humanos", "Falta de virtude pessoal", "Erro lógico", "Negação da política"], correta: 0 },
{ pergunta: "O que é historicismo dialético?", opcoes: ["Análise da história como resultado de contradições materiais", "Estudo da ética", "Estudo da estética", "Estudo da lógica"], correta: 0 },
{ pergunta: "O que é fenomenologia existencial?", opcoes: ["Análise da experiência concreta e liberdade humana", "Estudo da política", "Estudo da estética", "Estudo da ética"], correta: 0 },
{ pergunta: "Quem é autor da fenomenologia existencial?", opcoes: ["Maurice Merleau-Ponty", "Nietzsche", "Kant", "Hegel"], correta: 0 },
{ pergunta: "O que é diferença entre ser-em-si e ser-para-si?", opcoes: ["Ser-em-si é objeto, ser-para-si é consciência reflexiva", "Ser-para-si é objeto, ser-em-si é consciência", "São iguais", "Nenhuma relação"], correta: 0 },
{ pergunta: "Quem propôs ser-em-si e ser-para-si?", opcoes: ["Jean-Paul Sartre", "Hegel", "Nietzsche", "Kant"], correta: 0 },
{ pergunta: "O que é má-fé em Sartre?", opcoes: ["Autonegativação de responsabilidade para evitar liberdade", "Autenticidade", "Obediência a regras", "Aceitação do destino"], correta: 0 },
{ pergunta: "O que é angústia existencial?", opcoes: ["Sensação diante da liberdade absoluta e responsabilidade", "Medo físico", "Ansiedade social", "Estudo da ética"], correta: 0 },
{ pergunta: "O que é transcendentalismo kantiano?", opcoes: ["Estudo das condições que tornam possível o conhecimento", "Estudo da ética utilitarista", "Estudo da política", "Estudo da estética"], correta: 0 },
{ pergunta: "O que é imperativo categórico?", opcoes: ["Regra moral universal válida independentemente das circunstâncias", "Máxima condicional", "Busca de prazer", "Norma social"], correta: 0 },
{ pergunta: "O que é imperativo hipotético?", opcoes: ["Regra moral válida se se deseja certo resultado", "Regra universal", "Norma ética absoluta", "Estudo da estética"], correta: 0 },
{ pergunta: "Quem propôs imperativo categórico?", opcoes: ["Immanuel Kant", "Nietzsche", "Aristóteles", "Hegel"], correta: 0 },
{ pergunta: "O que é espírito objetivo segundo Hegel?", opcoes: ["Instituições, leis e moralidade da sociedade", "Consciência individual", "Desejo humano", "Fenômeno natural"], correta: 0 },
{ pergunta: "O que é espírito subjetivo segundo Hegel?", opcoes: ["Consciência e vontade do indivíduo", "Instituições coletivas", "Economia", "História universal"], correta: 0 },
{ pergunta: "O que é espírito absoluto segundo Hegel?", opcoes: ["Síntese final de cultura, arte, religião e filosofia", "Consciência individual", "Economia", "Ética kantiana"], correta: 0 },
{ pergunta: "O que é alienação hegeliana?", opcoes: ["Separação do indivíduo de sua essência espiritual", "Separação econômica", "Estudo da lógica formal", "Estudo da política"], correta: 0 },
{ pergunta: "O que é superação (Aufhebung) na dialética hegeliana?", opcoes: ["Processo que preserva e transforma contradições", "Destruição de opostos", "Negação do ser", "Estudo da ética"], correta: 0 },
{ pergunta: "O que é historicismo hegeliano?", opcoes: ["Visão da história como progresso da razão", "Estudo da estética", "Estudo da lógica formal", "Estudo da política"], correta: 0 },
{ pergunta: "O que é crítica da modernidade segundo Foucault?", opcoes: ["Análise de poder, disciplina e controle social", "Estudo da ética", "Estudo da lógica formal", "Estudo da estética"], correta: 0 },
{ pergunta: "O que é biopoder em Foucault?", opcoes: ["Controle e regulação da vida por instituições", "Poder político absoluto", "Força física", "Estudo da ética"], correta: 0 },
{ pergunta: "O que é governo de si segundo Foucault?", opcoes: ["Prática de autodisciplina e cuidado pessoal", "Domínio sobre outros", "Controle estatal", "Estudo da estética"], correta: 0 },
{ pergunta: "O que é diferença entre poder disciplinar e soberano?", opcoes: ["Disciplinar molda indivíduos, soberano impõe leis", "Soberano molda indivíduos, disciplinar impõe leis", "São iguais", "Nenhuma relação"], correta: 0 },
{ pergunta: "O que é genealogia segundo Foucault?", opcoes: ["Estudo histórico das práticas e conceitos de poder", "Estudo da ética", "Estudo da estética", "Estudo da lógica"], correta: 0 },
{ pergunta: "O que é hermenêutica do sujeito?", opcoes: ["Análise de como os indivíduos constroem a si mesmos", "Estudo da lógica formal", "Estudo da política", "Estudo da ética"], correta: 0 },
{ pergunta: "O que é diferença entre ético e moral segundo Foucault?", opcoes: ["Ético refere-se à conduta pessoal, moral à normas sociais", "Moral é pessoal, ético é coletivo", "São iguais", "Nenhuma relação"], correta: 0 },
{ pergunta: "O que é pós-estruturalismo?", opcoes: ["Corrente que questiona estruturas fixas e significados universais", "Estudo da ética utilitarista", "Estudo da estética", "Estudo da política"], correta: 0 },
{ pergunta: "Quem é filósofo pós-estruturalista?", opcoes: ["Jacques Derrida", "Hegel", "Nietzsche", "Kant"], correta: 0 },
{ pergunta: "O que é desconstrução?", opcoes: ["Método de análise que revela ambiguidades e contradições em textos", "Estudo da ética", "Estudo da política", "Estudo da estética"], correta: 0 },
{ pergunta: "Quem desenvolveu a desconstrução?", opcoes: ["Jacques Derrida", "Foucault", "Nietzsche", "Hegel"], correta: 0 },
{ pergunta: "O que é ética da responsabilidade segundo Hans Jonas?", opcoes: ["Reflexão sobre consequências futuras das ações humanas", "Ética utilitarista", "Ética kantiana", "Ética aristotélica"], correta: 0 },
{ pergunta: "O que é diferença entre devir e ser?", opcoes: ["Devir é mudança contínua, ser é estabilidade conceitual", "Ser é mudança, devir é estático", "São iguais", "Nenhuma relação"], correta: 0 },
{ pergunta: "O que é diferença entre subjetivo e objetivo?", opcoes: ["Subjetivo depende da percepção do indivíduo, objetivo existe independentemente", "Objetivo depende do indivíduo, subjetivo é universal", "São iguais", "Nenhuma relação"], correta: 0 },
{ pergunta: "O que é diferença entre verdade formal e verdade material?", opcoes: ["Formal é lógica, material refere-se à realidade concreta", "Formal é ética, material é política", "São iguais", "Nenhuma relação"], correta: 0 },
{ pergunta: "O que é diferença entre essência e existência?", opcoes: ["Essência é o que algo é, existência é o fato de ser", "Existência é o que algo é, essência é o fato de ser", "São iguais", "Nenhuma relação"], correta: 0 },
{ pergunta: "O que é diferença entre devir e eterno?", opcoes: ["Devir é mudança, eterno é repetição infinita", "Eterno é mudança, devir é constante", "São iguais", "Nenhuma relação"], correta: 0 },
{ pergunta: "O que é diferença entre liberdade positiva e negativa?", opcoes: ["Positiva é agir conforme a razão, negativa é ausência de coerção", "Negativa é agir conforme a razão, positiva é ausência de coerção", "São iguais", "Nenhuma relação"], correta: 0 },
{ pergunta: "O que é diferença entre poder e autoridade?", opcoes: ["Poder é capacidade de influenciar, autoridade é reconhecimento legítimo", "Autoridade é capacidade de influenciar, poder é reconhecimento", "São iguais", "Nenhuma relação"], correta: 0 },
{ pergunta: "O que é ética do cuidado?", opcoes: ["Filosofia que prioriza relações, empatia e responsabilidades interpessoais", "Ética utilitarista", "Ética kantiana", "Ética aristotélica"], correta: 0 },
{ pergunta: "Quem propôs a ética do cuidado?", opcoes: ["Carol Gilligan", "Aristóteles", "Kant", "Nietzsche"], correta: 0 }
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
{ pergunta: "O que é conflito de interesses segundo Marx?", opcoes: ["Disputa entre diferentes classes sociais por recursos e poder", "Discussão familiar", "Competição esportiva", "Debate acadêmico"], correta: 0 },
{ pergunta: "O que é ideologia dominante?", opcoes: ["Conjunto de ideias que justificam a posição de poder na sociedade", "Ideias populares", "Ideias infantis", "Ideias religiosas"], correta: 0 },
{ pergunta: "O que é reificação segundo Marx?", opcoes: ["Tratamento de relações sociais como coisas objetivas", "Criação de objetos artísticos", "Construção de edifícios", "Produção industrial"], correta: 0 },
{ pergunta: "O que é racionalização segundo Weber?", opcoes: ["Substituição de tradições por eficiência, regras e cálculo", "Organização familiar", "Planejamento agrícola", "Estudo filosófico"], correta: 0 },
{ pergunta: "O que é dominação legal-racional segundo Weber?", opcoes: ["Autoridade baseada em regras e leis impessoais", "Dominação familiar", "Dominação religiosa", "Dominação cultural"], correta: 0 },
{ pergunta: "O que é dominação tradicional segundo Weber?", opcoes: ["Autoridade baseada em costumes e tradições", "Dominação científica", "Dominação política moderna", "Dominação econômica"], correta: 0 },
{ pergunta: "O que é dominação carismática segundo Weber?", opcoes: ["Autoridade baseada no carisma pessoal do líder", "Autoridade legal", "Autoridade tradicional", "Autoridade militar"], correta: 0 },
{ pergunta: "O que é socialização política avançada?", opcoes: ["Processo contínuo de aprendizado e participação em diferentes contextos políticos", "Aprender regras de trânsito", "Estudar geografia", "Participar de esportes"], correta: 0 },
{ pergunta: "O que é ação social racional com fins?", opcoes: ["Comportamento orientado por objetivos e meios planejados", "Comportamento afetivo", "Comportamento tradicional", "Comportamento irracional"], correta: 0 },
{ pergunta: "O que é ação social racional com valores?", opcoes: ["Comportamento orientado por crenças éticas ou morais", "Comportamento afetivo", "Comportamento tradicional", "Comportamento irracional"], correta: 0 },
{ pergunta: "O que é ação social afetiva?", opcoes: ["Comportamento guiado por emoções", "Comportamento racional", "Comportamento legal", "Comportamento burocrático"], correta: 0 },
{ pergunta: "O que é ação social tradicional?", opcoes: ["Comportamento baseado em hábitos e costumes", "Comportamento racional", "Comportamento legal", "Comportamento carismático"], correta: 0 },
{ pergunta: "O que é alienação econômica?", opcoes: ["Separação do trabalhador do controle sobre seu trabalho e seus frutos", "Separação familiar", "Separação cultural", "Separação política"], correta: 0 },
{ pergunta: "O que é função social da religião segundo Durkheim?", opcoes: ["Promover coesão e integração social", "Ensinar ciência", "Controlar economia", "Definir leis"], correta: 0 },
{ pergunta: "O que é função latente de uma instituição?", opcoes: ["Consequência não planejada ou não intencional", "Função principal", "Função econômica", "Função política"], correta: 0 },
{ pergunta: "O que é função manifesta de uma instituição?", opcoes: ["Consequência planejada e intencional", "Consequência acidental", "Consequência indireta", "Consequência simbólica"], correta: 0 },
{ pergunta: "O que é anomia estrutural segundo Merton?", opcoes: ["Desconexão entre objetivos culturais e meios institucionais disponíveis", "Ausência de leis", "Desorganização familiar", "Fracasso escolar"], correta: 0 },
{ pergunta: "O que é conformidade segundo Merton?", opcoes: ["Aceitação de objetivos culturais e meios legitimados", "Rebeldia social", "Desvio positivo", "Desvio negativo"], correta: 0 },
{ pergunta: "O que é inovação segundo Merton?", opcoes: ["Aceitar objetivos culturais mas usar meios ilegítimos", "Seguir tradições", "Aceitar normas religiosas", "Rebeldia política"], correta: 0 },
{ pergunta: "O que é ritualismo segundo Merton?", opcoes: ["Cumprir regras sem perseguir objetivos culturais", "Criar regras novas", "Desobedecer regras", "Ignorar regras"], correta: 0 },
{ pergunta: "O que é retraimento segundo Merton?", opcoes: ["Abandono de objetivos e meios socialmente aceitos", "Sucesso social", "Aceitação de normas", "Inovação cultural"], correta: 0 },
{ pergunta: "O que é rebeldia segundo Merton?", opcoes: ["Substituição de objetivos e meios culturais por novos", "Aceitação de normas", "Conformidade social", "Ritualismo social"], correta: 0 },
{ pergunta: "O que é capital simbólico segundo Bourdieu?", opcoes: ["Prestígio, reconhecimento ou honra que um indivíduo possui", "Dinheiro", "Educação formal", "Propriedade"], correta: 0 },
{ pergunta: "O que é violência simbólica segundo Bourdieu?", opcoes: ["Dominação exercida de forma invisível através da cultura", "Violência física", "Violência verbal", "Conflito econômico"], correta: 0 },
{ pergunta: "O que é campo social segundo Bourdieu?", opcoes: ["Espaço social de disputa de poder e recursos simbólicos", "Campo agrícola", "Campo esportivo", "Campo geográfico"], correta: 0 },
{ pergunta: "O que é estratificação multidimensional?", opcoes: ["Divisão da sociedade por classe, status e poder", "Divisão por idade", "Divisão por gênero", "Divisão por cor"], correta: 0 },
{ pergunta: "O que é interdependência funcional?", opcoes: ["Relação entre partes da sociedade que dependem umas das outras", "Dependência econômica", "Dependência afetiva", "Dependência política"], correta: 0 },
{ pergunta: "O que é reprodução social segundo Bourdieu?", opcoes: ["Manutenção das desigualdades sociais através de instituições e cultura", "Mudança social", "Abolição de normas", "Criação de leis"], correta: 0 },
{ pergunta: "O que é laicidade do Estado?", opcoes: ["Separação entre religião e instituições governamentais", "Predominância religiosa", "Monarquia religiosa", "Sociedade religiosa"], correta: 0 },
{ pergunta: "O que é socialização digital?", opcoes: ["Processo de aprendizado das normas e comportamentos na internet", "Aprender na escola", "Aprender em casa", "Aprender no trabalho"], correta: 0 },
{ pergunta: "O que é sociedade em rede segundo Castells?", opcoes: ["Sociedade organizada em fluxos de informação e comunicação digital", "Sociedade rural", "Sociedade industrial", "Sociedade tradicional"], correta: 0 },
{ pergunta: "O que é sociedade de risco segundo Beck?", opcoes: ["Sociedade onde riscos são produzidos pelo próprio desenvolvimento tecnológico e econômico", "Sociedade segura", "Sociedade agrícola", "Sociedade pacífica"], correta: 0 },
{ pergunta: "O que é desvio estatístico?", opcoes: ["Comportamento que foge da média social mas não prejudica a sociedade", "Desvio negativo", "Desvio positivo", "Conformidade"], correta: 0 },
{ pergunta: "O que é modernidade reflexiva segundo Beck?", opcoes: ["Sociedade que constantemente analisa e modifica seus próprios riscos e estruturas", "Sociedade agrícola", "Sociedade tradicional", "Sociedade industrial"], correta: 0 },
{ pergunta: "O que é sociedade pós-industrial?", opcoes: ["Sociedade baseada em serviços e informação, não apenas na produção industrial", "Sociedade agrícola", "Sociedade tradicional", "Sociedade rural"], correta: 0 },
{ pergunta: "O que é normatividade social?", opcoes: ["Conjunto de regras e expectativas que orientam o comportamento social", "Normas de trânsito", "Regras de esporte", "Leis físicas"], correta: 0 },
{ pergunta: "O que é teoria crítica da sociedade?", opcoes: ["Análise que busca identificar e transformar desigualdades e dominação", "Análise matemática", "Análise histórica", "Análise econômica simples"], correta: 0 },
{ pergunta: "O que é hegemonia cultural segundo Gramsci?", opcoes: ["Domínio ideológico de uma classe sobre a sociedade", "Domínio militar", "Domínio econômico", "Domínio científico"], correta: 0 },
{ pergunta: "O que é sociedade de controle segundo Deleuze?", opcoes: ["Sociedade caracterizada por vigilância contínua e modulação do comportamento", "Sociedade livre", "Sociedade agrícola", "Sociedade industrial"], correta: 0 },
{ pergunta: "O que é globalização econômica?", opcoes: ["Integração mundial de mercados e capital", "Integração cultural", "Integração religiosa", "Integração esportiva"], correta: 0 },
{ pergunta: "O que é modernização reflexiva?", opcoes: ["Processo em que a sociedade repensa e ajusta suas estruturas constantemente", "Processo de industrialização", "Processo agrícola", "Processo de urbanização"], correta: 0 },
{ pergunta: "O que é precarização do trabalho?", opcoes: ["Diminuição de direitos e condições de trabalho seguras", "Aumento de salários", "Estabilidade laboral", "Trabalho voluntário"], correta: 0 },
{ pergunta: "O que é mobilidade social intrageracional?", opcoes: ["Mudança de status social ao longo da vida de um indivíduo", "Mudança entre gerações", "Mudança geográfica", "Mudança cultural"], correta: 0 },
{ pergunta: "O que é risco social?", opcoes: ["Possibilidade de danos ou desvantagens na vida social devido a decisões ou eventos", "Risco físico", "Risco econômico isolado", "Risco ambiental"], correta: 0 },
{ pergunta: "O que é sociedade pós-moderna?", opcoes: ["Sociedade marcada por fragmentação, diversidade e incerteza", "Sociedade industrial", "Sociedade agrícola", "Sociedade moderna tradicional"], correta: 0 },
{ pergunta: "O que é sociedade de vigilância?", opcoes: ["Sociedade na qual os indivíduos são constantemente monitorados", "Sociedade agrícola", "Sociedade tradicional", "Sociedade industrial"], correta: 0 },
{ pergunta: "O que é teoria da ação comunicativa segundo Habermas?", opcoes: ["Sociedade baseada em diálogo racional e entendimento mútuo", "Sociedade de conflito", "Sociedade agrícola", "Sociedade industrial"], correta: 0 },
{ pergunta: "O que é desinstitucionalização?", opcoes: ["Enfraquecimento ou perda de função de instituições sociais", "Criação de novas leis", "Fortalecimento político", "Aumento populacional"], correta: 0 },
{ pergunta: "O que é efeito bola de neve social?", opcoes: ["Processo em que pequenas mudanças se acumulam gerando grandes consequências", "Acúmulo de neve literal", "Pequenas ações isoladas", "Processo econômico planejado"], correta: 0 },
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
    alert('✅ Resposta correta! Continue a aventura!');
  } else {
    alert('❌ Resposta errada! Você perdeu 3 minutos!');
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
   FIM DO SCRIPT
   ========================================================== */

</script>
</body>
</html>
