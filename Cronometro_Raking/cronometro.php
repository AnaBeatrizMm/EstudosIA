<?php
// cronometro.php

// === CONFIGURAÇÃO BANCO ===
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'bd_usuarios';

// Conexão
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    die("Falha na conexão: " . $mysqli->connect_error);
}

// --- Usuário logado (exemplo) ---
session_start();
$usuario_id = $_SESSION['id'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // --- Aceitar sugestão de amizade ---
    if ($action === 'aceitar') {
        $idSugerido = intval($_POST['id']);
        $resp = ['ok' => false, 'msg' => 'Erro'];

        // Verifica se já existe relação
        $stmt = $mysqli->prepare("
            SELECT id FROM relacoes 
            WHERE (id_usuario1 = ? AND id_usuario2 = ?) OR (id_usuario1 = ? AND id_usuario2 = ?)
            LIMIT 1
        ");
        $stmt->bind_param("iiii", $usuario_id, $idSugerido, $idSugerido, $usuario_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($row = $res->fetch_assoc()) {
            $stmtUp = $mysqli->prepare("UPDATE relacoes SET tipo='amizade', status='aceito' WHERE id=?");
            $stmtUp->bind_param("i", $row['id']);
            $resp['ok'] = $stmtUp->execute();
            $resp['msg'] = $resp['ok'] ? "Amizade aceita!" : "Erro ao atualizar";
        } else {
            $stmtIns = $mysqli->prepare("INSERT INTO relacoes (id_usuario1, id_usuario2, tipo, status, criado_em) VALUES (?, ?, 'amizade', 'aceito', CURRENT_TIMESTAMP())");
            $stmtIns->bind_param("ii", $usuario_id, $idSugerido);
            $resp['ok'] = $stmtIns->execute();
            $resp['msg'] = $resp['ok'] ? "Amizade criada!" : "Erro ao inserir";
        }

        header('Content-Type: application/json');
        echo json_encode($resp);
        exit;
    }


    // Aceitar sugestão
    if ($action === 'aceitar') {
        $idSugerido = intval($_POST['id']);
        $resp = ['ok' => false, 'msg' => 'Erro'];

        $stmt = $mysqli->prepare("
            SELECT id FROM relacoes 
            WHERE (id_usuario1 = ? AND id_usuario2 = ?) OR (id_usuario1 = ? AND id_usuario2 = ?)
            LIMIT 1
        ");
        $stmt->bind_param("iiii", $usuario_id, $idSugerido, $idSugerido, $usuario_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($row = $res->fetch_assoc()) {
            $stmtUp = $mysqli->prepare("UPDATE relacoes SET tipo='amizade', status='aceito' WHERE id=?");
            $stmtUp->bind_param("i", $row['id']);
            $resp['ok'] = $stmtUp->execute();
            $resp['msg'] = $resp['ok'] ? "Amizade aceita!" : "Erro ao atualizar";
        } else {
            $stmtIns = $mysqli->prepare("INSERT INTO relacoes (id_usuario1,id_usuario2,tipo,status) VALUES (?,?, 'amizade','aceito')");
            $stmtIns->bind_param("ii", $usuario_id, $idSugerido);
            $resp['ok'] = $stmtIns->execute();
            $resp['msg'] = $resp['ok'] ? "Amizade criada!" : "Erro ao inserir";
        }

        header('Content-Type: application/json');
        echo json_encode($resp);
        exit;
    }

    // Salvar tempo
    if ($action === 'salvar_tempo') {
        $tempoStr = $_POST['tempo'] ?? '';
        $resp = ['ok' => false];

        $stmt = $mysqli->prepare("INSERT INTO tempos (id_usuario, tempo) VALUES (?, ?)");
        $stmt->bind_param("is", $usuario_id, $tempoStr);
        $resp['ok'] = $stmt->execute();

        header('Content-Type: application/json');
        echo json_encode($resp);
        exit;
    }

    if ($action === 'excluir_tempo') {
        $id = intval($_POST['id']);
        $stmt = $mysqli->prepare("DELETE FROM tempos WHERE id=? AND id_usuario=?");
        $stmt->bind_param("ii", $id, $usuario_id);
        $stmt->execute();
        echo json_encode(['ok' => true]);
        exit;
    }

    if ($action === 'excluir_todos') {
        $stmt = $mysqli->prepare("DELETE FROM tempos WHERE id_usuario=?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        echo json_encode(['ok' => true]);
        exit;
    }
}

// --- Buscar tempos do usuário ---
$tempos = [];
$stmtT = $mysqli->prepare("SELECT id, tempo, criado_em FROM tempos WHERE id_usuario=? ORDER BY criado_em DESC");
$stmtT->bind_param("i", $usuario_id);
$stmtT->execute();
$resT = $stmtT->get_result();
if ($resT) $tempos = $resT->fetch_all(MYSQLI_ASSOC);

// --- Buscar amizades e sugestões (igual ao seu código acima) ---
// ...

// --- Função para caminho da foto ---
function foto($f) {
    if (!$f) return '/videos/default.png';
    return (str_starts_with($f, '/') || preg_match('#^https?://#',$f)) ? $f : "/".ltrim($f,'/');
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Cronômetro + Amizades</title>
<link rel="icon" type="image/png" href="/anotacoes/imagens/icon site.png" sizes="612x612">
<link rel="stylesheet" href="estilo.css">
<style>
body{font-family:Arial,sans-serif;background:#f4fdfb;margin:0;padding:20px;text-align:center;}
.robo{max-width:380px;width:80%;margin:10px auto;display:block;}
.cronometro{margin:20px 0;}
#tempo{font-size:2.6rem;color:#3f7c72;padding:10px 20px;background:#fff;border-radius:12px;border:1px solid #bdebe3;}
.cronobtn{background:#3f7c72;color:#fff;border:none;padding:8px 12px;margin:5px;border-radius:10px;cursor:pointer;}
.cronobtn:hover{background:#2a5c55}

/* Wrapper centraliza o robô e serve de referência para o painel */
.wrapper {
  position: relative;
  display: inline-block; /* conteúdo centralizado horizontalmente */
}

/* Robô centralizado */
.robo {
  display: block;
  max-width: 380px;
  width: 80%;
}

/* Painel lateral esquerdo do robô */
.painel {
    position: fixed;        /* fixo na tela */
    left: 120px;             /* distância da borda esquerda da tela */
    top: 25%;               /* centraliza verticalmente */
    transform: translateY(-50%); /* ajusta exatamente no meio vertical */
    
    width: 260px;
    max-height: 80vh;
    overflow: auto;
    background: #fff;
    border-radius: 12px;
    padding: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.12);
    border: 1px solid #e6f3ef;
    text-align: left;
    z-index: 10;
}

/* Títulos do painel */
.painel h4 {
    margin: 6px 0;
    font-size: 1rem;
    color: #3f7c72;
    border-bottom: 1px solid #eee;
    padding-bottom: 4px;
}

/* Lista de usuários */
.lista {
    list-style: none;
    margin: 0;
    padding: 0;
}

/* Cada usuário na lista */
.usuario {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 6px 0;
}

/* Foto do usuário */
.usuario img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #3f7c72;
}

/* Nome do usuário */
.nome {
    flex: 1;
    font-size: 0.95rem;
}

/* Botão de ação do usuário */
.usuario button {
    background: #3f7c72;
    color: #fff;
    border: none;
    padding: 5px 8px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.8rem;
}

.usuario button:hover {
    background: #2a5c55;
}

/* Mensagem quando a lista está vazia */
.empty {
    font-size: 0.85rem;
    color: #777;
    margin: 6px 0;
}

/* Painel de melhores tempos do usuário */
.painel-tempos {
  position: fixed;
  right: 120px;
  top: 25%;
  transform: translateY(-50%);
  width: 260px;
  max-height: 80vh;
  overflow: auto;
  background: #fff;
  border-radius: 12px;
  padding: 12px;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
  border: 1px solid #e6f3ef;
  text-align: left;
  z-index: 10;
  font-family: "Poppins", sans-serif;
}

/* Título do painel */
.painel-tempos h4 {
  margin: 6px 0 10px 0;
  font-size: 1rem;
  color: #3f7c72;
  border-bottom: 1px solid #eee;
  padding-bottom: 6px;
}

/* Tabela de tempos */
#tabelaTempos {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.9rem;
}

#tabelaTempos th,
#tabelaTempos td {
  padding: 6px 4px;
  text-align: center;
  border-bottom: 1px solid #eee;
}

#tabelaTempos th {
  color: #3f7c72;
  font-weight: 600;
  background: #f4fdfa;
}

#tabelaTempos tr:hover {
  background: #f8fffc;
}

/* Botão Excluir individual */
.excluirBtn {
  background: #3f7c72;
  color: white;
  border: none;
  padding: 5px 10px;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.2s ease, transform 0.2s ease;
}

.excluirBtn:hover {
  background: #2a5c55;
  transform: scale(1.05);
}

/* Botão Excluir Todos */
#excluirTodosBtn {
  margin-top: 10px;
  width: 100%;
  background: #2a5c55;
  color: white;
  border: none;
  padding: 8px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 0.9rem;
  font-weight: 600;
  transition: background 0.2s ease, transform 0.2s ease;
}

#excluirTodosBtn:hover {
  background: #2a5c55;
  transform: scale(1.03);
}

#verRankingBtn {
  background-color: #3f7c72;
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 6px;
  cursor: pointer;
  font-size: 0.9rem;
  transition: background-color 0.2s ease;
  width: 100%;
  margin-top: 8px;
}

#verRankingBtn:hover {
  background-color: #2d5e56;
}

header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 70px;
      background: #ffffffcc;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 2rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      z-index: 1000;
    }

    header .logo img {
      height: 450px;
      width: auto;
      display: block;
      margin-left: -85px;
    }

    nav ul {
      list-style: none;
      display: flex;
      align-items: center;
      gap: 20px;
      margin: 0;
      margin-right: 50px;
    }

    nav ul li a {
      text-decoration: none;
      color: black;
      padding: 5px 10px;
      border-radius: 8px;
      transition: .3s;
    }
</style>
</head>
<body>
<header>
    <div class="logo"><img src="/imagens/logoatual.png" alt="Logo"></div>
    <nav>
      <ul>
        <li><a href="/inicio.php">Voltar</a></li>
      </ul>
    </nav>
  </header>
<img class="robo" src="/videos/Robo_dormindo.gif" alt="Robo Dormindo">

<div class="cronometro">
  <div id="tempo">00:00:00</div><br>
  <button class="cronobtn" id="startBtn">Iniciar</button>
  <button class="cronobtn" id="stopBtn">Parar</button>
  <button class="cronobtn" id="resetBtn">Resetar</button>
  <button class="cronobtn" id="salvarBtn">Salvar Tempo</button>
</div>

<div class="painel">
  <!-- Sugestões -->
  <h4>Lista de Sugestões</h4>
  <ul class="lista" id="lista-sug">
    <?php if(!empty($sugestoes)): ?>
      <?php foreach($sugestoes as $s): ?>
        <li class="usuario" data-id="<?= $s['id'] ?>">
          <img src="<?= foto($s['foto'] ?? '') ?>">
          <div class="nome"><?= htmlspecialchars($s['nome'] ?? '') ?></div>
          <button class="aceitarBtn" data-id="<?= $s['id'] ?>">Aceitar</button>
        </li>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="empty">Nenhuma sugestão.</div>
    <?php endif; ?>
  </ul>

  <!-- Amizades -->
  <h4>Amizades</h4>
  <ul class="lista" id="lista-amigos">
    <?php if(!empty($amizades)): ?>
      <?php foreach($amizades as $a): ?>
        <li class="usuario">
          <img src="<?= foto($a['foto'] ?? '') ?>">
          <div class="nome"><?= htmlspecialchars($a['nome'] ?? '') ?></div>
        </li>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="empty">Nenhum amigo ainda.</div>
    <?php endif; ?>
  </ul>
</div>

<div class="painel-tempos">
  <h4>Melhores Tempos</h4>
  <table id="tabelaTempos">
    <thead>
      <tr>
        <th>Tempo</th>
        <th>Data</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $res = $mysqli->query("SELECT id, tempo, DATE_FORMAT(criado_em, '%d/%m/%y') AS data_simplificada 
                              FROM tempos 
                              WHERE id_usuario=$usuario_id 
                              ORDER BY criado_em DESC LIMIT 10");
      while($row = $res->fetch_assoc()):
      ?>
      <tr data-id="<?= $row['id'] ?>">
        <td><?= htmlspecialchars($row['tempo']) ?></td>
        <td><?= $row['data_simplificada'] ?></td>
        <td><button class="excluirBtn">Excluir</button></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <button id="excluirTodosBtn">Excluir Todos</button>
  <button onclick="location.href= 'Raking.php'" id="verRankingBtn">Modo Ranking</button>
</div>


<script>
let seg = 0, timer = null;
const tempo = document.getElementById('tempo');

// Formatar tempo HH:MM:SS
function fmt(s) {
  let h = Math.floor(s / 3600);
  let m = Math.floor((s % 3600) / 60);
  let ss = s % 60;
  return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(ss).padStart(2, '0')}`;
}

// Atualização do cronômetro
function tick() {
  seg++;
  tempo.textContent = fmt(seg);
}

// Botões principais
document.getElementById('startBtn').onclick = () => {
  if (!timer) timer = setInterval(tick, 1000); // velocidade 2x mais rápida
};
document.getElementById('stopBtn').onclick = () => {
  clearInterval(timer);
  timer = null;
};
document.getElementById('resetBtn').onclick = () => {
  clearInterval(timer);
  timer = null;
  seg = 0;
  tempo.textContent = fmt(seg);
};

// ---- SALVAR TEMPO ----
document.getElementById('salvarBtn').onclick = async () => {
  const fd = new FormData();
  fd.append('action', 'salvar_tempo');
  fd.append('tempo', tempo.textContent);

  const r = await fetch(location.href, { method: 'POST', body: fd });
  const d = await r.json();

  if (d.ok) {
    const tabela = document.querySelector('#tabelaTempos tbody');
    const agora = new Date();
    const dia = String(agora.getDate()).padStart(2, '0');
    const mes = String(agora.getMonth() + 1).padStart(2, '0');
    const ano = String(agora.getFullYear()).slice(2);

    const novaLinha = document.createElement('tr');
    novaLinha.dataset.id = d.id;
    novaLinha.innerHTML = `
      <td>${tempo.textContent}</td>
      <td>${dia}/${mes}/${ano}</td>
      <td><button class="excluirBtn">Excluir</button></td>
    `;
    tabela.prepend(novaLinha);

    // Ativa botão de exclusão do novo tempo
    novaLinha.querySelector('.excluirBtn').onclick = () => excluirTempo(d.id, novaLinha);
  }
};

// ---- EXCLUIR TEMPO ----
async function excluirTempo(id, linha) {
  const fd = new FormData();
  fd.append('action', 'excluir_tempo');
  fd.append('id', id);
  const r = await fetch(location.href, { method: 'POST', body: fd });
  const d = await r.json();
  if (d.ok && linha) linha.remove();
}

// ---- EXCLUIR TODOS OS TEMPOS ----
document.getElementById('excluirTodosBtn').onclick = async () => {
  const fd = new FormData();
  fd.append('action', 'excluir_todos');
  const r = await fetch(location.href, { method: 'POST', body: fd });
  const d = await r.json();
  if (d.ok) document.querySelectorAll('#tabelaTempos tbody tr').forEach(tr => tr.remove());
};

// ---- ACEITAR AMIZADE ----
document.querySelectorAll('.aceitarBtn').forEach(btn => {
  btn.onclick = async () => {
    const id = btn.dataset.id;
    btn.disabled = true;
    btn.textContent = '...';
    const fd = new FormData();
    fd.append('action', 'aceitar');
    fd.append('id', id);
    const r = await fetch(location.href, { method: 'POST', body: fd });
    const d = await r.json();
    if (d.ok) {
      const li = btn.closest('.usuario');
      btn.remove();
      document.getElementById('lista-amigos').appendChild(li);
    } else {
      btn.disabled = false;
      btn.textContent = 'Aceitar';
    }
    // Botão para ir ao ranking
document.getElementById('verRankingBtn').onclick = () => {
  window.location.href = '/Cronometro_Raking/Raking.php'; // 🔗 redireciona para a página desejada
};


  };
});

</script>
</body>
</html>