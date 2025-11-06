<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cadernos</title>
  <style>
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
        @font-face {
      font-family: 'SimpleHandmade';
      src: url(/fonts/SimpleHandmade.ttf);
    }
    * {
      box-sizing: border-box;
    }

    body {
      font-family:'Roboto',sans-serif;
      background-color: #2a5c55;
      color: #ffffff;
      margin: 0;
      padding-top: 90px; /* altura da navbar */
    }

    h1 {
      color: #ffffff;
      font-size: 45px;
      margin-bottom: 40px;
      text-align: center;
      font-family: 'SimpleHandmade';
    }

    .cadernos-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
      padding: 0 20px 40px;
      
    }

    .caderno {
      width: 250px;
      text-decoration: none;
      color: #ffffff;
      transition: transform 0.3s;
      font-family: 'SimpleHandmade';
    }

    .caderno img {
      width: 100%;
      height: auto;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      border: 3px solid #ffffffd2;
      display: block;
      
    }

    .caderno:hover {
      transform: scale(1.05);
    }

    .caderno span {
      display: block;
      margin-top: 10px;
      font-weight: bold;
      font-size: 25px;
      text-align: center;
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


    .user-menu {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      color: #4a69bd;
      font-weight: 700;
      font-size: 16px;
      transition: color 0.3s ease;
    }

    .user-info:hover {
      color: #2c2c54;
    }

    .user-info img {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #4a69bd;
      box-shadow: 0 2px 6px rgba(74,105,189,0.5);
      display: block;
    }

    .logout {
      font-weight: 700;
      color: #c0392b;
      text-decoration: none;
      padding: 8px 14px;
      border-radius: 8px;
      border: 2px solid transparent;
      transition: background-color 0.3s ease, color 0.3s ease;
      font-size: 15px;
      user-select: none;
      cursor: pointer;
    }

    .logout:hover {
      background-color: #c0392b;
      color: #fff;
      border-color: #c0392b;
    }

    /* Botão voltar */
    .btn-voltar {
      display: inline-block;
      margin: 20px 0 30px 40px;
      padding: 10px 20px;
      background-color: #2c2c54;
      color: #ffffff;
      font-size: 16px;
      text-decoration: none;
      border-radius: 10px;
      border: none;
      transition: background-color 0.3s;
      user-select: none;
      cursor: pointer;
      text-align: center;
    }

    .btn-voltar:hover {
      background-color: #4a69bd;
    }

    /* Responsividade */
    @media (max-width: 600px) {
      nav.topo-nav {
        flex-direction: column;
        align-items: flex-start;
        padding: 16px 20px;
        height: auto;
      }

      .user-menu {
        gap: 10px;
        width: 100%;
        justify-content: flex-end;
      }

      .btn-voltar {
        margin-left: 20px;
      }
    }
  </style>
</head>

<body>

<header>
  <div class="logo"><img src="/imagens/logoatual.png" alt="Logo"></div>
  <nav>
    <ul>
        <li><a href="/inicio.php">Voltar ao Início</a></li>
    </ul>
  </nav>
</header>

  <h1>Armário dos Cadernos</h1>

  <div class="cadernos-container">
    <a class="caderno" href="agenda.php">
      <img src="/anotacoes/imagens/309561a566d949a44d7277cd8ffab713.jpg" alt="Caderno Agenda" />
      <span>Agenda</span>
    </a>
    <a class="caderno" href="financias.php">
      <img src="/anotacoes/imagens/882fc562350cf5717e4999b7303e7646.jpg" alt="Caderno Finanças" />
      <span>Finanças</span>
    </a>
    <a class="caderno" href="planejamento.php">
      <img src="/anotacoes/imagens/913353af28362c1811781fca866741f5.jpg" alt="Caderno Planejamento" />
      <span>Planejamento</span>
    </a>
    <a class="caderno" href="anotacoes.php">
      <img src="/anotacoes/imagens/d3d044dd74dcff0d1467b984ac14a9b4.png" alt="Caderno Anotações" />
      <span>Anotações</span>
    </a>
    <a class="caderno" href="tarefas.php">
      <img src="/anotacoes/imagens/imagem caderno.jpg" alt="Caderno Tarefas" />
      <span>Tarefas</span>
    </a>
  </div>

</body>
</html>
