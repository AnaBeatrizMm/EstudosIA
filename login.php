<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login | EstudosIA</title>
  <style>
    @font-face { font-family: 'SimpleHandmade'; src: url(/fonts/SimpleHandmade.ttf); }
    :root{
      --accent:#3f7c72ff;
      --accent-2:#bdebe3ff;
      --bg:#fff;
      --muted:#666;
      --radius:18px;
      --dur:650ms;
      --easing:cubic-bezier(.22,.9,.13,1);
      --input-gap:16px; /* ajuste aqui o espaçamento entre inputs */
    }
    *{ box-sizing:border-box; margin:0; padding:0; font-family:"Segoe UI", Arial, sans-serif; }
    html,body{ height:100%; background:var(--bg); color:#000; }

    /* header parecido com o seu */
    header{
      position:fixed; top:0; left:0; width:100%; height:70px;
      background:#ffffff85; display:flex; align-items:center; justify-content:space-between;
      padding:0 24px; box-shadow:0 2px 5px rgba(0,0,0,.08); z-index:999;
    }
    header .logo img{ max-height:100%; display:block; margin-left:-90px; }
    nav ul{ list-style:none; display:flex; gap:30px; margin-right:40px; }
    nav ul li a{ text-decoration:none; color:#000; transition:color .2s; }
    nav ul li a:hover{ color:var(--accent); }

    /* área central */
    .wrap{ min-height:100vh; display:flex; align-items:center; justify-content:center; padding:100px 20px 60px; }
    .box{
      width:920px; height:540px; border-radius:var(--radius); background:#fff;
      box-shadow:0 20px 50px rgba(0,0,0,0.12); position:relative; overflow:hidden;
    }

    /* painéis (login + register) - cada um ocupa 50% */
    .panel{
      position:absolute; top:0; height:100%; width:50%;
      padding:44px; display:flex; flex-direction:column; justify-content:center; gap:10px;
      transition: transform var(--dur) var(--easing), opacity var(--dur) var(--easing);
      will-change: transform;
    }
    .panel h2{ font-family:'SimpleHandmade'; color:var(--accent); font-size:2.1rem; text-align:center; }
    .panel p.small{ text-align:center; color:var(--muted); margin-bottom:8px; }

    /* FORM - agora com gap controlado por --input-gap */
    .panel form{
      display:flex;
      flex-direction:column;
      gap: var(--input-gap);
      margin-top: 6px;
    }

    .panel input{
      width:100%; padding:12px 14px; border-radius:10px; border:1px solid #ddd; font-size:1rem;
    }
    .panel input:focus{ box-shadow:0 6px 18px rgba(63,124,114,0.08); border-color:var(--accent); outline:none; }

    .btn{
      width:100%; padding:12px; border-radius:28px; border:0; background:var(--accent); color:#fff; font-weight:700; cursor:pointer;
    }
    .btn:hover{ transform:translateY(-3px); background:#1e3834ff; }

    .aux{ text-align:center; margin-top:10px; color:var(--muted); }
    .aux a{ color:var(--accent); text-decoration:none; cursor:pointer; font-weight:600; }

    /* POSIÇÕES INICIAIS */
    .login { left:0; transform:translateX(0); opacity:1; }
    /* register começa "fora" à direita (invisível) */
    .register { left:50%; transform:translateX(100%); opacity:0; }

    /* OVERLAY: ocupa a metade direita inicialmente (left:50%) */
    .overlay{
      position:absolute; top:0; left:50%; width:50%; height:100%;
      background: linear-gradient(135deg,var(--accent),var(--accent-2));
      display:flex; align-items:center; justify-content:center; flex-direction:column;
      color:#fff; text-align:center; padding:40px;
      transition: transform var(--dur) var(--easing);
      pointer-events:none; /* não bloquear cliques nos forms */
      will-change: transform;
    }
    .overlay h3{ font-family:'SimpleHandmade'; font-size:1.9rem; margin-bottom:8px; }
    .overlay p{ max-width:280px; color:rgba(255,255,255,.95); }

    /* ESTADO ATIVO: quando o usuário clicou em "Cadastre-se" */
    .box.active .login { transform:translateX(-100%); opacity:0; }
    .box.active .overlay { transform: translateX(-100%); } /* overlay vai para a esquerda */
    .box.active .register { transform:translateX(0); opacity:1; }

    /* pequenas responsividades */
    @media (max-width:980px){
      .box{ width:92%; height:760px; border-radius:14px; }
      .panel{ position:relative; width:100%; left:0; transform:none; padding:28px; }
      .login, .register { left:0; transform:none; opacity:1; }
      .overlay{ position:relative; left:0; width:100%; height:200px; margin-top:18px; transform:none; pointer-events:none; }
      .box.active .overlay { transform:none; }
    }

    /* preferência de movimento reduzido */
    @media (prefers-reduced-motion: reduce){
      .panel, .overlay { transition: none; }
    }
.mensagem-sucesso {
  position: absolute; /* fica sobre o box */
  top: 20%;           /* ajusta a altura da mensagem, mais pra cima */
  left: 50%;
  transform: translate(-50%, -20px);
  background: #4CAF50;
  color: white;
  padding: 18px 28px;
  border-radius: 10px;
  font-size: 18px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  opacity: 0;
  transition: all 0.5s ease;
  z-index: 9999;
}

.mensagem-sucesso.show {
  opacity: 1;
  transform: translate(-50%, 0);
}
.mensagem-erro {
  position: absolute;
  top: 20%;
  left: 50%;
  transform: translate(-50%, -20px);
  background: #e74c3c; /* vermelho */
  color: white;
  padding: 18px 28px;
  border-radius: 10px;
  font-size: 18px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  opacity: 0;
  transition: all 0.5s ease;
  z-index: 9999;
}

.mensagem-erro.show {
  opacity: 1;
  transform: translate(-50%, 0);
}
  </style>
</head>
<body>
  <header>
    <div class="logo"><img src="/imagens/logoatual.png" alt="EstudosIA"></div>
    <nav>
      <ul>
        <li><a href="/index.php">Voltar a página de abertura</a></li>
      </ul>
    </nav>
  </header>

  <main class="wrap">
    <?php $startInRegister = isset($_GET['fromCadastro']) ? 'active' : ''; ?>
<div id="box" class="box <?php echo $startInRegister; ?>">
      <!-- LOGIN (esquerda inicialmente) -->
      <section class="panel login" aria-label="Login">
        <h2>Entrar</h2>
        <p class="small">Use seu e-mail e senha para acessar</p>
<form action="processa_login.php" method="POST">
    <input type="email" name="email" placeholder="Email" required />
    <div class="input-group">
      <input type="password" id="senha" name="senha" placeholder="Senha" required />
    </div>
    <button class="btn" type="submit">Entrar</button>
    <div style="text-align:center; margin-top:10px;">
  <a href="google_login.php" class="btn" style="background: #32363dff;text-decoration:none;width:100%; height: 50px;align-items:center; justify-content:center;text-align:center;">
    <img src="/imagens/google-removebg-preview.png" style="height:30px; vertical-align:middle; margin-right:8px;">
    Entrar com Google
  </a>
</div>
</form>

        <div class="aux">Esqueceu a senha? <a href="/recuperar.php">Recuperar</a></div>
        <div class="aux">Não tem conta? <a id="toRegister">Cadastre-se</a></div>
      </section>

      <!-- REGISTER (chega pela direita quando ativado) -->
      <section class="panel register" aria-label="Cadastro">
        <h2>Cadastrar</h2>
        <p class="small">Crie sua conta e comece a estudar com IA</p>
<form action="processa_cadastro.php" method="POST">
    <input type="text" name="nome" placeholder="Nome completo" required />
    <input type="email" name="email" placeholder="Email" required />
    <input type="password" name="senha" placeholder="Senha" required />
    <input type="password" name="senha2" placeholder="Confirmar senha" required />
    <button class="btn" type="submit">Registrar</button>
    
</form>
<div style="text-align:center; margin-top:10px;">
  <a href="google_login.php" class="btn" style="background: #32363dff;text-decoration:none;width:100%; height: 50px;align-items:center; justify-content:center;text-align:center;">
    <img src="/imagens/google-removebg-preview.png" style="height:30px; vertical-align:middle; margin-right:8px;">
    Cadastrar-se com Google
  </a>
</div>
        <div class="aux">Já tem conta? <a id="toLogin">Entrar</a></div>
      </section>

      <!-- OVERLAY (parte azul) — inicia à direita, ao ativar move-se para a esquerda -->
      <div class="overlay" aria-hidden="true">
        <h3 id="overlayTitle">Bem-vindo de volta!</h3>
        <p id="overlayText">Se já é nosso aluno, faça login para continuar seus estudos com ferramentas inteligentes.</p>
      </div>
    </div>
  </main>

  <script>
    (function(){
      const box = document.getElementById('box');
      const toRegister = document.getElementById('toRegister');
      const toLogin = document.getElementById('toLogin');
      const overlayTitle = document.getElementById('overlayTitle');
      const overlayText = document.getElementById('overlayText');

      function setOverlayText(showingRegister){
        if(showingRegister){
          overlayTitle.textContent = 'Olá, novo amigo!';
          overlayText.textContent = 'Cadastre-se e comece a organizar seus estudos com o poder da IA.';
        } else {
          overlayTitle.textContent = 'Bem-vindo de volta!';
          overlayText.textContent = 'Se já é nosso aluno, faça login para continuar seus estudos com ferramentas inteligentes.';
        }
      }

      toRegister.addEventListener('click', () => {
        box.classList.add('active');
        setOverlayText(true);
      });
      toLogin.addEventListener('click', () => {
        box.classList.remove('active');
        setOverlayText(false);
      });

      document.addEventListener('keydown', (e) => {
        if(e.key === 'Escape') {
          box.classList.remove('active');
          setOverlayText(false);
        }
      });
    })();
  </script>
<script>
(function(){
  const box = document.getElementById('box');
  const toRegister = document.getElementById('toRegister');
  const toLogin = document.getElementById('toLogin');
  const overlayTitle = document.getElementById('overlayTitle');
  const overlayText = document.getElementById('overlayText');

  function setOverlayText(showingRegister){
    if(showingRegister){
      overlayTitle.textContent = 'Olá, novo amigo!';
      overlayText.textContent = 'Cadastre-se e comece a organizar seus estudos com o poder da IA.';
    } else {
      overlayTitle.textContent = 'Bem-vindo de volta!';
      overlayText.textContent = 'Se já é nosso aluno, faça login para continuar seus estudos com ferramentas inteligentes.';
    }
  }

  toRegister.addEventListener('click', () => {
    box.classList.add('active');
    setOverlayText(true);
  });
  toLogin.addEventListener('click', () => {
    box.classList.remove('active');
    setOverlayText(false);
  });

  document.addEventListener('keydown', (e) => {
    if(e.key === 'Escape') {
      box.classList.remove('active');
      setOverlayText(false);
    }
  });

window.addEventListener('load', () => {
  const box = document.getElementById('box');

  // mensagem de sucesso
  const sucesso = localStorage.getItem('mensagemSucesso');
  if (sucesso) {
    const msgDiv = document.getElementById('mensagemSucesso');
    msgDiv.textContent = sucesso;
    msgDiv.classList.add('show');
    setTimeout(() => msgDiv.classList.remove('show'), 4000);
    localStorage.removeItem('mensagemSucesso');
  }

  // só anima de volta para login se veio do cadastro
  if (box.classList.contains('active')) {
    setTimeout(() => {
      box.classList.remove('active');
      setOverlayText(false);
    }, 200); // anima suavemente
  }
});
window.addEventListener('load', () => {
  const sucesso = localStorage.getItem('mensagemSucesso');
  if (sucesso) {
    const msgDiv = document.getElementById('mensagemSucesso');
    msgDiv.textContent = sucesso;
    msgDiv.classList.add('show');

    setTimeout(() => {
      msgDiv.classList.remove('show');
    }, 4000); // desaparece após 4s

    localStorage.removeItem('mensagemSucesso');
  }
 // mensagem de erro
 const erro = localStorage.getItem('mensagemErro');
  if (erro) {
    const msgDiv = document.getElementById('mensagemErro');
    msgDiv.textContent = erro;
    msgDiv.classList.add('show');
    setTimeout(() => msgDiv.classList.remove('show'), 4000);
    localStorage.removeItem('mensagemErro');
  }
});
})();
</script>
<div id="mensagemSucesso" class="mensagem-sucesso"></div>
<div id="mensagemErro" class="mensagem-erro"></div>
</body>
</html>
