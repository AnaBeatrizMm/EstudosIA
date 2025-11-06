-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/11/2025 às 15:34
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
  `dia` varchar(20) NOT NULL,
  `compromisso` varchar(255) DEFAULT NULL,
  `horario` time DEFAULT NULL,
  `notas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agenda`
--

INSERT INTO `agenda` (`id`, `dia`, `compromisso`, `horario`, `notas`) VALUES
(1, 'segunda', 'qwqeqe', '23:03:00', NULL);

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
(3, 13, 14, '2025-10-06 13:41:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `anotacoes`
--

CREATE TABLE `anotacoes` (
  `id` int(11) NOT NULL,
  `conteudo` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `anotacoes`
--

INSERT INTO `anotacoes` (`id`, `conteudo`) VALUES
(4, 'dw<b>dmwkje</b>wkjew<font color=\"#583c3c\"><font size=\"5\">jeknxmnzmxnz,aksjlw</font>qi</font>euwerouw3pr');

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
  `data_comentario` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `data_curtida` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `data` date DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `financas`
--

INSERT INTO `financas` (`id`, `data`, `descricao`, `valor`) VALUES
(2, '2025-11-13', 'GFGFGFGFGFGFGFGFGFGFGFGF', 0.00);

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
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `lida` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `planejamento`
--

CREATE TABLE `planejamento` (
  `id` int(11) NOT NULL,
  `dia` varchar(20) DEFAULT NULL,
  `texto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `planejamento`
--

INSERT INTO `planejamento` (`id`, `dia`, `texto`) VALUES
(1, 'Segunda-feira', 'wkqeoqeqemqe'),
(2, 'Terça-feira', 'werw'),
(3, 'Quarta-feira', 'wewr'),
(4, 'Quinta-feira', 'q'),
(5, 'Sexta-feira', 'w'),
(6, 'Sábado', 'wqe');

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
  `conteudo` text NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `legenda` text DEFAULT NULL,
  `criado_em` datetime DEFAULT current_timestamp(),
  `data_postagem` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `posts`
--

INSERT INTO `posts` (`id`, `usuario_id`, `conteudo`, `imagem`, `legenda`, `criado_em`, `data_postagem`) VALUES
(7, 13, '', '1758596155_download4.jpg', NULL, '2025-09-24 11:35:11', '2025-09-22 23:55:55'),
(8, 13, '', '1758596218_d43c989f-5988-40fe-a97c-abd641010fc8.jpg', NULL, '2025-09-24 11:35:11', '2025-09-22 23:56:58'),
(11, 4, 'Capivaras são tudo de bom!!', NULL, NULL, '2025-09-24 11:35:11', '2025-09-24 09:29:03');

-- --------------------------------------------------------

--
-- Estrutura para tabela `registro_estudo`
--

CREATE TABLE `registro_estudo` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `tempo_estudo` int(11) NOT NULL,
  `data_registro` date NOT NULL,
  `arvore` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `registro_estudo`
--

INSERT INTO `registro_estudo` (`id`, `usuario_id`, `tempo_estudo`, `data_registro`, `arvore`) VALUES
(1, 2, 2, '2025-05-19', '1'),
(2, 2, 4, '2025-05-19', '1'),
(3, 2, 6, '2025-05-19', '3');

-- --------------------------------------------------------

--
-- Estrutura para tabela `solicitacoes_amizade`
--

CREATE TABLE `solicitacoes_amizade` (
  `id` int(11) NOT NULL,
  `id_remetente` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `data_criacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `sugestoes_amizade`
--

CREATE TABLE `sugestoes_amizade` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_sugerido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tarefas`
--

CREATE TABLE `tarefas` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `concluida` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tarefas`
--

INSERT INTO `tarefas` (`id`, `descricao`, `concluida`) VALUES
(3, 'sdsdsd', 1),
(4, 'uyyyyyyyyyyyyyyyyy', 1),
(5, 'yyyyyyyyyyyyyyyy', 1);

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
  `aniversario` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `biografia`, `foto`, `arvore_escolhida`, `ultimo_login`, `token`, `expira_token`, `codigo_verificacao`, `verificado`, `username`, `apelido`, `data_nascimento`, `escola`, `foto_pessoal`, `preferencias`, `tags`, `favoritos`, `data_criacao`, `bio_foto`, `banner`, `aniversario`) VALUES
(4, 'Bia Soares', 'beatriz@gmail.com', '$2y$10$27rg7J1YQ9hSdb59AhTUle94ITQWOuvS6ILvpl7d0MODLB/ExkXbu', 'Study vlogs ', 'imagens/usuarios690caed3a1d22.png', NULL, '2025-08-18 09:19:03', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'meu namorado lindo, peixes, capivara,sobrenatural', '2025-09-24 11:33:45', 'imagens/bio/690caed3a7b65.jpg', 'imagens/usuarios/690caed3a98aa.jpg', '2008-03-17'),
(13, 'Marques', 'ana@gmail.com', '$2y$10$qK9NpLu6OL0OxxbpLGug9e28WLqGG5QFGpgvpxJBXoy4Gfoa51FJS', '', 'imagens/usuarios/68d8225203d96.jpg', NULL, '2025-08-18 09:19:03', NULL, NULL, NULL, 0, '', NULL, NULL, NULL, NULL, NULL, 'Culinária,Programação', '', '2025-09-24 11:33:45', NULL, NULL, NULL),
(14, 'wenderson', 'wenderson.souza@gmail.com', '$2y$10$JTjk3KlPbsViCn9Yd9gjCOoDmmLkOp/TEA3pK2q4XkcTusKZxEzN.', '', 'imagens/usuarios/68d2ab46456c1.jpg', NULL, '2025-08-18 09:19:03', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-24 11:33:45', NULL, NULL, NULL),
(89, 'Usuário Teste 1', 'teste1@email.com', '123456', NULL, NULL, NULL, '2025-09-27 21:37:23', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 21:37:23', NULL, NULL, NULL),
(90, 'Usuário Teste 2', 'teste2@email.com', '123456', NULL, NULL, NULL, '2025-09-27 21:37:23', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 21:37:23', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `verificacoes`
--

CREATE TABLE `verificacoes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `codigo` varchar(6) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `verificacoes`
--

INSERT INTO `verificacoes` (`id`, `user_id`, `codigo`, `criado_em`) VALUES
(8, 34, '686722', '2025-09-12 13:29:48');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_post` (`id_post`),
  ADD KEY `id_usuario` (`id_usuario`);

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
  ADD KEY `id_post` (`id_post`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `financas`
--
ALTER TABLE `financas`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `usuario_id` (`usuario_id`);

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
-- Índices de tabela `registro_estudo`
--
ALTER TABLE `registro_estudo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `solicitacoes_amizade`
--
ALTER TABLE `solicitacoes_amizade`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `sugestoes_amizade`
--
ALTER TABLE `sugestoes_amizade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_sugestao` (`id_usuario`),
  ADD KEY `fk_sugerido` (`id_sugerido`);

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
-- Índices de tabela `verificacoes`
--
ALTER TABLE `verificacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `amizades`
--
ALTER TABLE `amizades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `anotacoes`
--
ALTER TABLE `anotacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `arquivos`
--
ALTER TABLE `arquivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `conteudos`
--
ALTER TABLE `conteudos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `curtidas`
--
ALTER TABLE `curtidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `financas`
--
ALTER TABLE `financas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `planejamento`
--
ALTER TABLE `planejamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `registro_estudo`
--
ALTER TABLE `registro_estudo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tarefas`
--
ALTER TABLE `tarefas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `verificacoes`
--
ALTER TABLE `verificacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD CONSTRAINT `notificacoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
