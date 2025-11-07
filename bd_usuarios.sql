-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/11/2025 às 12:27
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_usuarios`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agenda`
--

CREATE TABLE `agenda` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `dia` varchar(20) NOT NULL,
  `compromisso` varchar(255) DEFAULT NULL,
  `horario` time DEFAULT NULL,
  `notas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agenda`
--

INSERT INTO `agenda` (`id`, `usuario_id`, `dia`, `compromisso`, `horario`, `notas`) VALUES
(3, 1, 'segunda', 'Estudar', '09:09:00', NULL),
(4, 1, 'terca', 'Ler', '15:00:00', NULL),
(5, 1, 'quarta', 'Oração', '22:30:00', NULL),
(6, 4, 'segunda', 'Estudar Inglês', '20:00:00', NULL),
(7, 4, 'terca', 'Ler \"O alpinista\"', '13:00:00', NULL),
(8, 4, 'quarta', 'Dentista', '16:30:00', NULL),
(9, 4, 'quinta', 'Costureira', '17:00:00', NULL),
(10, 4, 'sexta', 'Crochê', '15:00:00', NULL),
(11, 4, 'sabado', 'Chorar', '20:00:00', NULL),
(12, 4, 'domingo', 'Enem', '12:00:00', NULL),
(13, 4, 'notas', NULL, NULL, 'Uma semana feliz.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `amizades`
--

CREATE TABLE `amizades` (
  `id` int(11) NOT NULL,
  `id_usuario1` int(11) NOT NULL,
  `id_usuario2` int(11) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `amizades`
--

INSERT INTO `amizades` (`id`, `id_usuario1`, `id_usuario2`, `data_criacao`) VALUES
(1, 4, 13, '2025-10-06 11:12:37'),
(3, 13, 14, '2025-10-06 13:41:15'),
(4, 93, 13, '2025-11-07 08:39:53');

-- --------------------------------------------------------

--
-- Estrutura para tabela `anotacoes`
--

CREATE TABLE `anotacoes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `conteudo` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `anotacoes`
--

INSERT INTO `anotacoes` (`id`, `usuario_id`, `conteudo`) VALUES
(3, 4, '<font color=\"#ff0000\" size=\"5\"><b>Matemática</b></font><div><font size=\"5\" color=\"#363030\">1+1=2</font></div><div><font size=\"5\" color=\"#363030\">2+2=4</font></div>');

-- --------------------------------------------------------

--
-- Estrutura para tabela `arquivos`
--

CREATE TABLE `arquivos` (
  `id` int(11) NOT NULL,
  `nome_original` varchar(255) NOT NULL,
  `nome_servidor` varchar(255) NOT NULL,
  `tamanho` int(11) NOT NULL,
  `data_envio` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `conteudo` text NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `comentarios`
--

INSERT INTO `comentarios` (`id`, `id_post`, `id_usuario`, `conteudo`, `data_criacao`) VALUES
(1, 25, 13, 'oii', '2025-10-06 11:10:26'),
(2, 25, 4, 'Você está linda minha ebezona da boca inchada', '2025-10-06 11:33:40');

-- --------------------------------------------------------

--
-- Estrutura para tabela `conteudos`
--

CREATE TABLE `conteudos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `conteudos`
--

INSERT INTO `conteudos` (`id`, `titulo`, `descricao`, `link`, `criado_em`) VALUES
(1, 'Anotações', 'Crie e organize suas anotações.', 'anotacoes.php', '2025-09-28 00:35:28'),
(2, 'Flashcards', 'Revise conteúdos com cartões interativos.', 'flashcards.php', '2025-09-28 00:35:28'),
(3, 'Plano de Estudos', 'Monte seu cronograma personalizado.', 'plano_estudos.php', '2025-09-28 00:35:28');

-- --------------------------------------------------------

--
-- Estrutura para tabela `curtidas`
--

CREATE TABLE `curtidas` (
  `id` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `curtidas`
--

INSERT INTO `curtidas` (`id`, `id_post`, `id_usuario`, `data_criacao`) VALUES
(1, 25, 13, '2025-10-06 11:10:23'),
(2, 25, 4, '2025-10-06 11:33:09');

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `data_evento` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `eventos`
--

INSERT INTO `eventos` (`id`, `titulo`, `data_evento`, `hora_inicio`, `hora_fim`) VALUES
(2, 'fsf', '2025-09-01', '03:33:00', '03:33:00'),
(6, 'dddd', '2025-09-30', '03:33:00', '03:33:00'),
(7, 'dsdsa', '2025-09-30', '04:55:00', '05:55:00'),
(8, 'ffff', '2025-09-30', '03:33:00', '03:33:00'),
(9, '3r3r3', '2025-09-30', '13:11:00', '14:13:00'),
(10, 'adda', '2025-09-30', '14:13:00', '15:15:00'),
(11, 'www', '2025-09-23', '06:36:00', '14:15:00'),
(12, '333', '2025-09-23', '03:33:00', '06:06:00'),
(13, '333333', '2025-09-16', '03:33:00', '05:35:00'),
(14, '666', '2025-09-26', '06:59:00', '10:02:00'),
(15, '333', '2025-09-26', '03:33:00', '04:04:00'),
(16, '3333', '2025-09-12', '13:18:00', '15:20:00'),
(17, 'ffffggr', '2025-09-06', '06:59:00', '08:55:00'),
(18, 'dwddw', '2025-09-05', '03:45:00', '06:59:00'),
(19, '55555', '2025-10-31', '05:55:00', '07:59:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `financas`
--

CREATE TABLE `financas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `tipo` enum('Entrada','Saída') NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `financas`
--

INSERT INTO `financas` (`id`, `usuario_id`, `data`, `descricao`, `valor`, `tipo`, `data_registro`) VALUES
(1, 1, '2025-11-20', 'Livro de Matemática', 29.90, 'Entrada', '2025-11-07 10:34:49'),
(2, 1, '2025-11-24', 'Cinema', 50.00, 'Entrada', '2025-11-07 10:35:16'),
(3, 4, '2025-11-10', 'Pagar a costureira', 30.00, 'Entrada', '2025-11-07 11:12:45'),
(4, 4, '2025-11-20', 'Vestido shain', 130.00, 'Entrada', '2025-11-07 11:13:01'),
(5, 4, '2025-11-29', 'Maio', 29.90, 'Entrada', '2025-11-07 11:13:21');

-- --------------------------------------------------------

--
-- Estrutura para tabela `lancamentos`
--

CREATE TABLE `lancamentos` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `tipo` enum('Entrada','Saída') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `id` int(11) NOT NULL,
  `id_remetente` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `conteudo` text NOT NULL,
  `data_envio` datetime DEFAULT current_timestamp(),
  `lida` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `mensagem` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `referencia_id` int(11) DEFAULT NULL,
  `lida` tinyint(1) DEFAULT 0,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `notificacoes`
--

INSERT INTO `notificacoes` (`id`, `usuario_id`, `mensagem`, `tipo`, `referencia_id`, `lida`, `data_criacao`) VALUES
(1, 1, 'enviou uma solicitação de amizade', 'amizade', 1, 0, '2025-11-06 20:17:46'),
(3, 13, 'Você recebeu uma solicitação de amizade', 'amizade', 5, 0, '2025-11-07 13:01:14');

-- --------------------------------------------------------

--
-- Estrutura para tabela `planejamento`
--

CREATE TABLE `planejamento` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `dia` varchar(50) NOT NULL,
  `texto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `planejamento`
--

INSERT INTO `planejamento` (`id`, `usuario_id`, `dia`, `texto`) VALUES
(1, 1, 'Segunda-feira', 'Ler '),
(2, 1, 'Terça-feira', 'Dentista'),
(3, 1, 'Quarta-feira', 'Costureira'),
(4, 1, 'Quinta-feira', 'Chorar'),
(5, 4, 'Segunda-feira', 'Ler'),
(6, 4, 'Terça-feira', 'Dentista'),
(7, 4, 'Quarta-feira', 'Costureira'),
(8, 4, 'Quinta-feira', 'Cozinhar uma receita do Tik Tok'),
(9, 4, 'Sexta-feira', 'Estudar Inglês'),
(10, 4, 'Sábado', 'Sair para jantar'),
(11, 4, 'Domingo', 'Enem');

-- --------------------------------------------------------

--
-- Estrutura para tabela `planos`
--

CREATE TABLE `planos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `semana` int(11) NOT NULL,
  `atividades` text NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `conteudo` text DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_postagem` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `posts`
--

INSERT INTO `posts` (`id`, `usuario_id`, `conteudo`, `imagem`, `data_criacao`, `data_postagem`) VALUES
(2, 1, 'oi', NULL, '2025-10-01 23:27:00', '2025-10-03 10:25:53'),
(3, 2, 'oi', NULL, '2025-10-01 23:33:33', '2025-10-03 10:25:53'),
(4, 2, NULL, NULL, '2025-10-01 23:33:46', '2025-10-03 10:25:53'),
(5, 2, 'oi', 'uploads/1759361801_Png ♡.jpeg', '2025-10-01 23:36:41', '2025-10-03 10:25:53'),
(6, 2, 'oi', 'uploads/1759361889_Png ♡.jpeg', '2025-10-01 23:38:09', '2025-10-03 10:25:53'),
(7, 2, 'oi', 'uploads/1759361901_Png ♡.jpeg', '2025-10-01 23:38:21', '2025-10-03 10:25:53'),
(8, 2, 'oi', 'uploads/1759361930_Png ♡.jpeg', '2025-10-01 23:38:50', '2025-10-03 10:25:53'),
(9, 2, 'd', 'uploads/1759361945_honk shoe.jpeg', '2025-10-01 23:39:05', '2025-10-03 10:25:53'),
(10, 2, 'd', 'uploads/1759362007_honk shoe.jpeg', '2025-10-01 23:40:07', '2025-10-03 10:25:53'),
(11, 2, 'fsf', 'uploads/1759362018_Slakkj.jpeg', '2025-10-01 23:40:18', '2025-10-03 10:25:53'),
(12, 3, 'sou rebelde', NULL, '2025-10-02 00:52:43', '2025-10-03 10:25:53'),
(21, 13, 'qafs, que ódio', '', '2025-10-06 10:44:35', '2025-10-06 07:44:35'),
(25, 13, 'y', 'imagens/posts/68e3a39c30c11.jfif', '2025-10-06 11:10:20', '2025-10-06 08:10:20');

-- --------------------------------------------------------

--
-- Estrutura para tabela `solicitacoes_amizade`
--

CREATE TABLE `solicitacoes_amizade` (
  `id` int(11) NOT NULL,
  `de_usuario_id` int(11) NOT NULL,
  `para_usuario_id` int(11) NOT NULL,
  `status` enum('pendente','aceita','recusada') DEFAULT 'pendente',
  `criado_em` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `solicitacoes_amizade`
--

INSERT INTO `solicitacoes_amizade` (`id`, `de_usuario_id`, `para_usuario_id`, `status`, `criado_em`) VALUES
(1, 13, 89, 'pendente', '2025-11-07 05:26:34'),
(2, 13, 92, 'pendente', '2025-11-07 05:26:40'),
(3, 13, 93, 'pendente', '2025-11-07 05:26:43'),
(5, 89, 13, 'pendente', '2025-11-07 06:01:13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tarefas`
--

CREATE TABLE `tarefas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `descricao` varchar(255) NOT NULL,
  `concluida` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tarefas`
--

INSERT INTO `tarefas` (`id`, `usuario_id`, `descricao`, `concluida`) VALUES
(2, 1, 'Tarefa do TCC', 0),
(3, 1, 'Assistir documentário \"Paris is Burning\"', 0),
(4, 1, 'Fazer o banco de dados', 1),
(5, 4, 'Ler', 0),
(6, 4, 'Fazer tarefa de matemática', 1),
(7, 4, 'Resolver os meus adereços de formatura', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `biografia` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `arvore_escolhida` int(11) DEFAULT NULL,
  `ultimo_login` datetime DEFAULT current_timestamp(),
  `token` varchar(255) DEFAULT NULL,
  `expira_token` datetime DEFAULT NULL,
  `codigo_verificacao` varchar(10) DEFAULT NULL,
  `verificado` tinyint(4) DEFAULT 0,
  `username` varchar(50) DEFAULT NULL,
  `apelido` varchar(50) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `escola` varchar(100) DEFAULT NULL,
  `foto_pessoal` varchar(255) DEFAULT NULL,
  `preferencias` text DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `favoritos` text DEFAULT NULL,
  `data_criacao` datetime DEFAULT current_timestamp(),
  `bio_foto` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `aniversario` date DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'default.png',
  `online` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `biografia`, `foto`, `arvore_escolhida`, `ultimo_login`, `token`, `expira_token`, `codigo_verificacao`, `verificado`, `username`, `apelido`, `data_nascimento`, `escola`, `foto_pessoal`, `preferencias`, `tags`, `favoritos`, `data_criacao`, `bio_foto`, `banner`, `aniversario`, `avatar`, `online`) VALUES
(1, 'Ana Marques Cezar', 'anacezar@gmail.com', '$2y$10$tRGB685hxsuEW8mdF/xllOowNZKDibI3FduI1L2sUolsXidbLJ6JO', NULL, 'imagens/usuarios/default.jpg', NULL, '2025-11-06 10:43:13', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-06 10:43:13', NULL, NULL, NULL, 'default.png', 0),
(4, 'Bia Soares', 'beatriz@gmail.com', '$2y$10$27rg7J1YQ9hSdb59AhTUle94ITQWOuvS6ILvpl7d0MODLB/ExkXbu', 'Study vlogs ', 'imagens/usuarios690dcb04900f9.png', NULL, '2025-08-18 09:19:03', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'meu namorado lindo, peixes, capivara,sobrenatural', '2025-09-24 11:33:45', 'imagens/bio/690dcb049041c.jpg', 'imagens/usuarios/690dcb04905e1.jpg', '2008-03-17', 'default.png', 0),
(13, 'Marques', 'ana@gmail.com', '$2y$10$zPWncJg1miTRLlP.xPZk9efuZPyqymZu793GKnPDUc3fBeQpLdB6.', 'AnaBanana', 'imagens/usuarios/68d8225203d96.jpg', NULL, '2025-08-18 09:19:03', NULL, NULL, NULL, 0, '', NULL, NULL, NULL, NULL, NULL, 'Culinária,Programação', 'Gatos, Stardew Valley, Café, Uva Verde', '2025-09-24 11:33:45', 'imagens/bio/68e3a32fb59ab.jfif', 'imagens/usuarios/68e3a32fb5b51.jfif', '2007-10-10', 'default.png', 0),
(14, 'wenderson', 'wenderson.souza@gmail.com', '$2y$10$JTjk3KlPbsViCn9Yd9gjCOoDmmLkOp/TEA3pK2q4XkcTusKZxEzN.', '', 'imagens/usuarios/68d2ab46456c1.jpg', NULL, '2025-10-06 08:46:56', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-24 11:33:45', NULL, NULL, NULL, 'default.png', 0),
(89, 'Usuário Teste 1', 'teste1@email.com', '$2y$10$mhwR8xWl79e89JPhVYO4WuImgdM/SUfxi/nNh7i9ljY4zbq7E0Owe', NULL, NULL, NULL, '2025-09-27 21:37:23', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 21:37:23', NULL, NULL, NULL, 'default.png', 0),
(90, 'Usuário Teste 2', 'teste2@email.com', '123456', NULL, NULL, NULL, '2025-09-27 21:37:23', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 21:37:23', NULL, NULL, NULL, 'default.png', 0),
(92, 'Ana Marques', 'anabeatrizmarquescezar@gmail.com', '', NULL, NULL, NULL, '2025-11-06 11:34:45', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-06 11:34:45', NULL, NULL, NULL, 'default.png', 0),
(93, 'Ana Beatriz', 'beatrizava@gmail.com', '$2y$10$znQAINvoqEDoaKmq9N9k6u2Q0Zy2uN2WqMI7xjFErHOKk5qJkhIS.', NULL, 'imagens/usuarios/default.jpg', NULL, '2025-11-07 05:16:28', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-07 05:16:28', NULL, NULL, NULL, 'default.png', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `amizades`
--
ALTER TABLE `amizades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_pair` (`id_usuario1`,`id_usuario2`);

--
-- Índices de tabela `anotacoes`
--
ALTER TABLE `anotacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `arquivos`
--
ALTER TABLE `arquivos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `conteudos`
--
ALTER TABLE `conteudos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `curtidas`
--
ALTER TABLE `curtidas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_curtida` (`id_post`,`id_usuario`);

--
-- Índices de tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `financas`
--
ALTER TABLE `financas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `lancamentos`
--
ALTER TABLE `lancamentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_remetente` (`id_remetente`),
  ADD KEY `id_destinatario` (`id_destinatario`);

--
-- Índices de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`usuario_id`);

--
-- Índices de tabela `planejamento`
--
ALTER TABLE `planejamento`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `planos`
--
ALTER TABLE `planos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `solicitacoes_amizade`
--
ALTER TABLE `solicitacoes_amizade`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tarefas`
--
ALTER TABLE `tarefas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `amizades`
--
ALTER TABLE `amizades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `anotacoes`
--
ALTER TABLE `anotacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `arquivos`
--
ALTER TABLE `arquivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `conteudos`
--
ALTER TABLE `conteudos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `curtidas`
--
ALTER TABLE `curtidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `financas`
--
ALTER TABLE `financas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `lancamentos`
--
ALTER TABLE `lancamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `planejamento`
--
ALTER TABLE `planejamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `planos`
--
ALTER TABLE `planos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `solicitacoes_amizade`
--
ALTER TABLE `solicitacoes_amizade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tarefas`
--
ALTER TABLE `tarefas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD CONSTRAINT `notificacoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `planos`
--
ALTER TABLE `planos`
  ADD CONSTRAINT `planos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
