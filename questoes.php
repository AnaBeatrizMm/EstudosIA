<?php
session_start();
include('conexao.php');

$avatar = 'imagens/usuarios/default.jpg'; 
if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $sql = "SELECT nome, foto FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $usuario_id);
    $stmt->execute();
    $stmt->bind_result($nome_usuario, $foto_usuario);
    $stmt->fetch();
    $stmt->close();

    if (!empty($foto_usuario) && file_exists($foto_usuario)) {
        $avatar = $foto_usuario;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Questões Diárias</title>
<link rel="icon" type="image/png" href="/anotacoes/imagens/icon site.png" sizes="612x612">
<link rel="stylesheet" href="estilo.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{
  font-family:'Roboto',sans-serif;
  background:#2a5c55;
  color: #2c2c54;
  line-height:1.6;
}

/* Header */
header {
  position: fixed; top:0; left:0; width:100%; height:70px;
  background:#ffffffcc; display:flex; justify-content:space-between; align-items:center;
  padding:0 2rem; box-shadow:0 2px 5px rgba(0,0,0,0.1); z-index:1000;
}
    header .logo img{height:450px;width:auto;display:block; margin-left: -85px;}


nav ul{list-style:none; display:flex; align-items:center; gap:20px; margin:0;}
nav ul li a{ text-decoration:none; color:black;  padding:5px 10px; border-radius:8px; transition:.3s;}

.avatar{width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid #3f7c72;}

main{
  margin-top:90px;
  display:flex;
  justify-content:center;
  align-items:flex-start;
  padding:2rem;
}

/* Quiz */
.quiz{
  background:white;
  max-width:600px;
  width:100%;
  padding:2.5rem;
  border-radius:25px;
  box-shadow:0 8px 20px rgba(0,0,0,0.12);
}

.pergunta{
  font-size:1.6rem;
  font-weight:bold;
  color:#2a5c55;
  margin-bottom:2rem;
  text-align:center;
}

.alternativas{
  display:flex;
  flex-direction:column;
  gap:15px;
  margin-bottom:25px;
}

.alternativa{
  background:#3f7c72;
  color:white;
  padding:14px;
  border-radius:15px;
  cursor:pointer;
  transition:all 0.3s ease, transform 0.2s;
  text-align:center;
  font-size:1.1rem;
  border:2px solid #bdebe3;
}
.alternativa:hover{
  background:#2a5c55;
  transform:scale(1.03);
}
.alternativa.correta{background:#4CAF50 !important;}
.alternativa.errada{background:#E53935 !important;}

.resultado{text-align:center;font-weight:bold;font-size:1.2rem;margin-top:12px;}
.correto{color:#2e7d32;}
.errado{color:#c62828;}

button{
  display:block;
  margin:0 auto;
  margin-top:20px;
  padding:12px 30px;
  border:none;
  border-radius:30px;
  background:#3f7c72;
  color:white;
  font-size:1.1rem;
  cursor:pointer;
  transition:.3s, transform 0.2s;
  box-shadow:0 4px 10px rgba(0,0,0,0.08);
}
button:hover{
  background:#2a5c55;
  transform:scale(1.05);
}
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

<header>
  <div class="logo"><img src="/imagens/logoatual.png" alt="Logo"></div>
  <nav>
    <ul>
        <li><a href="/inicio.php">Voltar</a></li>
    </ul>
  </nav>
</header>

<main>
  <div class="quiz">
    <div class="pergunta"></div>
    <div class="alternativas"></div>
    <div class="resultado"></div>
    <button onclick="proximaQuestao()">Próxima questão</button>
  </div>
</main>

<script>
let questoes=[];
let indice=0;
let acertos=0;
let bloqueado=false;

fetch("questoes.json")
.then(r=>r.json())
.then(data=>{questoes=data;carregarQuestao();})
.catch(err=>{document.querySelector(".quiz").innerHTML="<h2>Erro ao carregar questões 😢</h2>";console.error(err);});

function carregarQuestao(){
  if(!questoes.length) return;
  const q=questoes[indice];
  document.querySelector(".pergunta").textContent=q.pergunta;
  const alternativasDiv=document.querySelector(".alternativas");
  alternativasDiv.innerHTML="";
  document.querySelector(".resultado").innerHTML="";
  bloqueado=false;

  q.alternativas.forEach((alt,i)=>{
    const btn=document.createElement("div");
    btn.classList.add("alternativa");
    btn.textContent=alt;
    btn.onclick=()=>verificarResposta(i,btn);
    alternativasDiv.appendChild(btn);
  });
}

function verificarResposta(i,btn){
  if(bloqueado) return;
  bloqueado=true;
  const q=questoes[indice];
  const alternativas=document.querySelectorAll(".alternativa");
  const resultadoDiv=document.querySelector(".resultado");

  if(i===q.correta){
    acertos++;
    btn.classList.add("correta");
    resultadoDiv.innerHTML="<span class='correto'>✅ Resposta correta!</span>";
  } else {
    btn.classList.add("errada");
    alternativas[q.correta].classList.add("correta");
    resultadoDiv.innerHTML="<span class='errado'>❌ Resposta errada!</span>";
  }
}

function proximaQuestao(){
  indice++;
  if(indice<questoes.length){
    carregarQuestao();
  } else {
    document.querySelector(".quiz").innerHTML=`<h2 style="text-align:center;">Você acertou ${acertos} de ${questoes.length} questões!</h2>`;
  }
}
</script>

</body>
</html>
