<?php
$usuario_id = intval($_SESSION['usuario_id'] ?? 0);
if($usuario_id){
    $stmt = $conn->prepare("UPDATE usuarios SET last_online = NOW() WHERE id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->close();
}
?>
<?php
session_start();
include 'conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Buscar dados do usuário
$sql = "SELECT nome, foto FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    $nome_usuario = $usuario['nome'];

    // Usa a foto do usuário ou o default se não houver
    if (!empty($usuario['foto']) && file_exists($usuario['foto'])) {
        $foto = $usuario['foto'];
    } else {
        $foto = 'imagens/usuarios/default.jpg';
    }
} else {
    $nome_usuario = "Usuário";
    $foto = 'imagens/usuarios/default.jpg';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estudos IA</title>
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
        @font-face {
      font-family: 'HelloMorgan';
      src: url(/fonts/HelloMorgan.ttf);
    }
    @font-face {
      font-family: 'Jojoba';
      src: url(/fonts/Jojoba.otf);
    }
    @font-face {
      font-family: 'KGMissKindergarten';
      src: url(/fonts/KGMissKindergarten.ttf);
    }
    @font-face {
      font-family: 'Papernotes';
      src: url(/fonts/Papernotes.otf);
    }
    @font-face {
      font-family: 'RougeVintage';
      src: url(/fonts/RougeVintage.ttf);
    }
    @font-face {
      font-family: 'SimpleHandmade';
      src: url(/fonts/SimpleHandmade.ttf);
    }
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Roboto',sans-serif;background:white;color:#333;line-height:1.6;}

    /* Header */
    header {
      position: fixed; top:0; left:0; width:100%; height:70px;
      background:#ffffffcc; display:flex; justify-content:space-between; align-items:center;
      padding:0 2rem; box-shadow:0 2px 5px rgba(0,0,0,0.1); z-index:1000;
    }
    header .logo img{height:450px;width:auto;display:block; margin-left: -85px;}

    /* Navegação */
    nav{display:flex; align-items:center; gap:20px;}
nav .search-bar {
  position: relative;
  display: flex;
  align-items: center;
}
nav .search-bar input {
  width: 260px;
  max-width: 40vw;
  padding: 8px 40px 8px 12px;
  border: 1px solid #ddd;
  border-radius: 999px;
  font-size: 14px;
}
nav .search-bar button {
  position: absolute;
  right: 8px;
  background: none;
  border: none;
  color: #747a80;
  cursor: pointer;
  font-size: 14px;
}
nav .search-bar button:hover {
  color: #3f7c72;
}
/* comportamento em telas menores */
@media (max-width: 620px) {
  nav .search-bar input { width: 140px; max-width: 60vw; padding-right:36px; }
  nav .search-bar i { right: 8px; }
}
.search-bar { position: relative; }
.suggestions {
  position: absolute;
  top: 110%;
  left: 0;
  right: 0;
  background: white;
  border: 1px solid #ccc;
  border-radius: 8px;
  max-height: 200px;
  overflow-y: auto;
  display: none;
  z-index: 1000;
  list-style: none;
  padding: 0;
  margin: 0;
}
.suggestions li {
  padding: 8px 12px;
  cursor: pointer;
  transition: background .2s;
}
.suggestions li:hover {
  background: #f0f0f0;
}
.notification {
  position: relative;
}
.notif-dropdown {
  display: none;
  position: absolute;
  right: 0;
  top: 120%;
  background: white;
  border: 1px solid #ddd;
  border-radius: 8px;
  width: 250px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.15);
  padding: 0.5rem;
  z-index: 2000;
}
.notif-dropdown p {
  font-size: 14px;
  margin: 0.5rem 0;
}
.notification.active .notif-dropdown {
  display: block;
}

    nav ul{list-style:none; display:flex; align-items:center; gap:20px; margin:0;}
    nav ul li a{ text-decoration:none; color:#333; font-weight:500;
      display:flex; align-items:center; gap:8px; padding:5px 10px; border-radius:8px; transition:.3s;}
    nav ul li a:hover{background:#f0f0f0;}

    .avatar{width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid #3f7c72;}

    /* Banner */
    /* Banner */
.banner {
  margin-top: 5%;
  width: 100%;
  height: 50vh; /* altura fixa */
  background: #3f7c72;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0 2rem; /* tirei o padding vertical */
  overflow: hidden; /* corta excesso caso a imagem/texto passe do limite */
}
    .banner-conteudo {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 90%;
  max-width: 1200px;
  gap: 1.5rem;
  flex-wrap: wrap;
}
    .banner-texto {
  color: white;
  max-width: 800px;
  text-align: center;
}
    .banner-texto h1 {
  font-family: 'SimpleHandmade';
  font-size: 4.5rem;
  margin-bottom: 1rem;
}
.banner-texto p {
  font-size: 1.2rem;
  margin-bottom: 1.5rem;
}

.banner .btn {
  background: white;
  color: #3f7c72;
  font-weight: bold;
  padding: 0.8rem 1.5rem;
  border-radius: 25px;
  text-decoration: none;
  transition: .3s;
}

.banner .btn:hover {
  background: #bdebe3;
  color: #2a5c55;
}

.banner-img img {
  width: 500px;
  max-width: 100%;
  border-radius: 15px;
  object-fit: cover; /* garante que a imagem não "empurre" o banner */
}
    /* Cards */
    section{padding:4rem 2rem;margin:0 auto;}
    section h2{text-align:center;color:#3f7c72;margin-bottom:2rem;font-size:3rem;font-family: 'SimpleHandmade';}
    /* substitua sua regra .cards atual por este bloco */
.cards {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* 3 por linha em telas grandes */
  gap: 1.5rem;
  align-items: start;
}

/* responsividade: 2 colunas em larguras intermediárias */
@media (max-width: 1000px) {
  .cards {
    grid-template-columns: repeat(2, 1fr);
  }
}
/* 1 coluna em mobile estreito */
@media (max-width: 620px) {
  .cards {
    grid-template-columns: 1fr;
  }
}
    .card{background:#fff;border-radius:20px;padding:2rem;text-align:center;
      box-shadow:0 4px 10px rgba(0,0,0,0.1);border:1px solid #bdebe3;
      transition:.3s;text-decoration:none;color:inherit;}
    .card:hover{transform:translateY(-5px);box-shadow:0 6px 15px rgba(0,0,0,0.15);}
    .card i{font-size:2rem;color:#3f7c72;margin-bottom:1rem;}
    .card h3{color:#3f7c72;margin-bottom:1rem;}

    /* Cronômetro */
    .cronometro-icone{position:fixed;bottom:20px;right:20px;background:#3f7c72;color:white;
      padding:1rem;border-radius:50%;font-size:2rem;display:flex;justify-content:center;align-items:center;
      box-shadow:0 4px 10px rgba(0,0,0,0.15);transition:.3s;text-decoration:none;z-index:1000;}
    .cronometro-icone:hover{background:#2a5c55;}

/* Botão flutuante da rede social */
.social-float {
  position: fixed;
  bottom: 20px;
  left: 20px;
  z-index: 1000;
}

.social-mini {
  background: #fff;
  border-radius: 12px;
  padding: 8px 18px;
  display: flex;
  align-items: center;
  box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  cursor: pointer;
}

.social-mini .mini-avatar img {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  object-fit: cover;
  margin-right: 10px;
}

.social-mini .title {
  font-weight: bold;
  color: #2a5c55;
  font-size: 18px;
}

.social-mini .sub {
  font-size: 15px;
  color: #666;
}

/* Backdrop do painel */
.social-panel-backdrop {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
  z-index: 2000;
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Painel principal com tudo integrado */
.social-panel {
  background: #fff;
  width: 90%;
  max-width: 1000px;
  height: 90%;
  border-radius: 12px;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  position: relative;
}

/* Título integrado no painel */
.social-panel .panel-header {
  background: #3f7c72;
  color: white;
  padding: 15px 20px;
  font-size: 1.2rem;
  font-weight: bold;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Botão de fechar dentro do header */
.social-panel .panel-header button {
  background: #fff;
  color: #3f7c72;
  border: none;
  padding: 5px 10px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: bold;
  transition: 0.3s;
}

.social-panel .panel-header button:hover {
  background: #e0f5f3;
}

/* Iframe ocupa todo o painel abaixo do header */
.social-panel .iframe-wrap {
  flex: 1 1 auto;
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.social-panel iframe {
  width: 100%;
  height: 100%;
  border: none;
}

    /* Footer */
    footer{background:#3f7c72;color:white;text-align:center;padding:2rem;margin-top:3rem;}
    /* Barra toda */
::-webkit-scrollbar {
  width: 12px; /* largura da barra vertical */
  height: 12px; /* altura da barra horizontal */
}

/* Fundo da barra */
::-webkit-scrollbar-track {
  background: #f0f0f0; /* cor do fundo da barra */
  border-radius: 10px;
}

/* Parte que se move (thumb) */
::-webkit-scrollbar-thumb {
  background: #3f7c72; /* cor do "polegar" */
  border-radius: 10px;
  border: 3px solid #f0f0f0; /* dá efeito de espaçamento */
}

/* Thumb ao passar o mouse */
::-webkit-scrollbar-thumb:hover {
  background: #2a5c55;
}
  </style>
</head>
<body>

<!-- Header -->
<header>
  <div class="logo"><img src="/imagens/logoatual.png" alt="Logo"></div>
  <nav>
<div class="search-bar">
  <input type="text" id="searchInput" placeholder="Pesquisar...">
  <i class="fa fa-search" id="searchBtn"></i>
  <ul id="searchSuggestions" class="suggestions"></ul>
</div>

<div class="notification" id="notifBtn">
  <i class="fa-solid fa-bell"></i>
  <div class="notif-dropdown" id="notifDropdown">
    <p>Carregando...</p>
  </div>
</div>
    <ul>
      <li>
        <a href="/editar_usuario.php" class="user-link">
          <img src="<?php echo htmlspecialchars($foto); ?>" alt="Foto do usuário" class="avatar">
<p><?php echo htmlspecialchars($nome_usuario); ?></p>
        </a>
      </li>
      <li><a href="/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Sair</a></li>
    </ul>
  </nav>
</header>

<!-- Banner -->
<section class="banner">
  <div class="banner-conteudo">
    <div class="banner-texto">
      <h1>Conheça nossa IA!</h1>
      <p>Feita para estudantes como você.<br>
        Aqui, cada pergunta vira uma oportunidade de aprendizado.</p>
      <a href="/resposta.html" class="btn">Conferir</a>
    </div>
    <div class="banner-img">
      <img src="https://i.pinimg.com/originals/a0/ce/6b/a0ce6ba41bf31c32fbced60d9070b0fe.gif" alt="Robôzinho IA">
    </div>
  </div>
</section>

<!-- Funções -->
<section id="funcoes">
  <h2>Funções Principais</h2>
  <div class="cards">
    <a href="/anotacoes/index.php" class="card"><i class="fa-solid fa-pen-to-square"></i><h3>Anotações</h3><p>Crie e organize suas anotações.</p></a>
    <a href="flashcard.html/index.html" class="card"><i class="fa-solid fa-clone"></i><h3>Flashcards</h3><p>Revise conteúdos com cartões interativos.</p></a>
    <a href="/Plano_estudos/plano_estudos.php" class="card"><i class="fa-solid fa-calendar-days"></i><h3>Plano de Estudos</h3><p>Monte seu cronograma personalizado.</p></a>
    <a href="/arquivos/upload_pdf.php" class="card"><i class="fa-solid fa-folder"></i><h3>Arquivos</h3><p>Organize e acesse seus arquivos de estudo.</p></a>
    <a href="calendario.html" class="card"><i class="fa-solid fa-calendar"></i><h3>Calendário</h3><p>Acompanhe compromissos e provas.</p></a>
    <a href="questoes.php" class="card"><i class="fa-solid fa-question-circle"></i><h3>Questões Diárias</h3><p>Pratique com desafios novos todos os dias.</p></a>
  </div>
</section>
<!-- Rede Social -->
<div class="social-float">
  <button class="social-mini" onclick="window.location.href='redesocial.php'" title="Abrir Rede Social">
    <div class="mini-avatar" aria-hidden="true">
      <img src="/videos/Robo_dormindo.gif" alt="Vídeo usuário" class="avatar-video">
    </div>
    <div class="mini-info">
      <div class="title">Rede Social</div>
      <div class="sub">Ver publicações e interagir</div>
    </div>
  </button>
</div>
<!-- Cronômetro -->
<a href="/Cronometro_Raking/cronometro.php" class="cronometro-icone" title="Ir para Cronômetro">
  <i class="fa-solid fa-stopwatch"></i>
</a>

<!-- Footer -->
<footer>
  <p>&copy; 2025 Estudos IA. Todos os direitos reservados.</p>
</footer>

<script>
  // Rede social painel toggle
  const socialMini = document.getElementById('socialMini');
  const socialBackdrop = document.getElementById('socialBackdrop');
  const socialClose = document.getElementById('socialClose');

  socialMini.addEventListener('click', () => {
    socialBackdrop.style.display = 'block';
  });
  socialClose.addEventListener('click', () => {
    socialBackdrop.style.display = 'none';
  });
</script>
<script>
  const notifBtn = document.getElementById("notifBtn");
  notifBtn.addEventListener("click", () => {
    notifBtn.classList.toggle("active");

    if (notifBtn.classList.contains("active")) {
      fetch("notificacoes.php")
        .then(res => res.text())
        .then(html => {
          document.getElementById("notifDropdown").innerHTML = html;
        })
        .catch(() => {
          document.getElementById("notifDropdown").innerHTML = "<p>Erro ao carregar.</p>";
        });
    }
  });
</script>
<script>
  // Rotas do site (palavra -> página)
  const paginas = {
    "anotações": "/anotacoes/index.php",
    "anotacoes": "/anotacoes/index.php",
    "flashcards": "/flashcard.html/index.html",
    "plano": "/Plano_estudos/plano_estudos.php",
    "plano de estudos": "/Plano_estudos/plano_estudos.php",
    "arquivos": "/arquivos/db.php",
    "calendario": "calendario.html",
    "calendário": "calendario.html",
    "questões": "questoes.php",
    "questoes": "questoes.php",
    "rede social": "redesocial.php",
    "cronômetro": "cronometro.php",
    "cronometro": "cronometro.php"
  };

  const input = document.getElementById("searchInput");
  const btn = document.getElementById("searchBtn");
  const suggestions = document.getElementById("searchSuggestions");

  // Filtrar sugestões
  function atualizarSugestoes() {
    const termo = input.value.trim().toLowerCase();
    suggestions.innerHTML = "";
    if (termo === "") {
      suggestions.style.display = "none";
      return;
    }

    const resultados = Object.keys(paginas).filter(p => p.includes(termo));
    resultados.forEach(r => {
      const li = document.createElement("li");
      li.textContent = r;
      li.addEventListener("click", () => {
        input.value = r;
        navegar();
      });
      suggestions.appendChild(li);
    });

    suggestions.style.display = resultados.length ? "block" : "none";
  }

  function navegar() {
    const termo = input.value.trim().toLowerCase();
    if (paginas[termo]) {
      window.location.href = paginas[termo];
    } else {
      alert("Página não encontrada. Tente: Anotações, Flashcards, Plano de Estudos...");
    }
  }

  input.addEventListener("input", atualizarSugestoes);
  btn.addEventListener("click", navegar);
  input.addEventListener("keypress", e => {
    if (e.key === "Enter") {
      navegar();
    }
  });

  // Fechar sugestões ao clicar fora
  document.addEventListener("click", e => {
    if (!input.contains(e.target) && !suggestions.contains(e.target)) {
      suggestions.style.display = "none";
    }
  });
</script>
</body>
</html>
