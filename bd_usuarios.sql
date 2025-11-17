-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/11/2025 às 14:16
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
  `usuario_id` int(11) NOT NULL,
  `dia` varchar(20) NOT NULL,
  `compromisso` text DEFAULT NULL,
  `horario` varchar(50) DEFAULT NULL,
  `notas` text DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `usuario_id` int(11) NOT NULL,
  `conteudo` longtext DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Estrutura para tabela `chat_grupo`
--

CREATE TABLE `chat_grupo` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `resposta_para` int(11) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chat_grupo`
--

INSERT INTO `chat_grupo` (`id`, `user_id`, `mensagem`, `arquivo`, `resposta_para`, `data_envio`) VALUES
(13, 4, 'oie', NULL, NULL, '2025-11-17 08:46:11'),
(14, 4, 'bom dia', NULL, 13, '2025-11-17 08:46:18'),
(15, 4, 'oie', NULL, NULL, '2025-11-17 08:49:28'),
(16, 4, 'tipo', NULL, 15, '2025-11-17 08:49:37'),
(17, 13, 'oie', NULL, NULL, '2025-11-17 08:59:16'),
(18, 13, 'bom dia', NULL, 13, '2025-11-17 08:59:30'),
(19, 13, 'opiupiuop', 'uploads_chat/691b0f06563ef-wallpaper.jpg', NULL, '2025-11-17 09:03:18'),
(20, 13, 'eita', 'uploads_chat/691b0fc52946a-Apresentação De Davi Riguetti (ダヴィ・リゲッティによるプレゼンテーション).mp4', NULL, '2025-11-17 09:06:29');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chat_grupo_animes`
--

CREATE TABLE `chat_grupo_animes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `resposta_para` int(11) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chat_grupo_animes`
--

INSERT INTO `chat_grupo_animes` (`id`, `user_id`, `mensagem`, `arquivo`, `resposta_para`, `data_envio`) VALUES
(1, 13, 'wedwqfrwet', NULL, NULL, '2025-11-17 09:30:10'),
(2, 13, 'hgfghfgh', NULL, 1, '2025-11-17 09:30:14');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chat_grupo_comida`
--

CREATE TABLE `chat_grupo_comida` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `resposta_para` int(11) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chat_grupo_comida`
--

INSERT INTO `chat_grupo_comida` (`id`, `user_id`, `mensagem`, `arquivo`, `resposta_para`, `data_envio`) VALUES
(6, 13, 'hghjghk', NULL, NULL, '2025-11-17 09:42:52');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chat_grupo_costura`
--

CREATE TABLE `chat_grupo_costura` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `resposta_para` int(11) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chat_grupo_costura`
--

INSERT INTO `chat_grupo_costura` (`id`, `user_id`, `mensagem`, `arquivo`, `resposta_para`, `data_envio`) VALUES
(1, 13, '56', NULL, NULL, '2025-11-17 09:42:58');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chat_grupo_desenhos`
--

CREATE TABLE `chat_grupo_desenhos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `resposta_para` int(11) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chat_grupo_desenhos`
--

INSERT INTO `chat_grupo_desenhos` (`id`, `user_id`, `mensagem`, `arquivo`, `resposta_para`, `data_envio`) VALUES
(2, 13, 'dfdfdf', NULL, 1, '2025-11-17 09:25:48');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chat_grupo_filmes`
--

CREATE TABLE `chat_grupo_filmes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `resposta_para` int(11) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chat_grupo_filmes`
--

INSERT INTO `chat_grupo_filmes` (`id`, `user_id`, `mensagem`, `arquivo`, `resposta_para`, `data_envio`) VALUES
(3, 13, 'thtjhyj', NULL, NULL, '2025-11-17 09:20:12'),
(4, 13, 'hthtth', NULL, 3, '2025-11-17 09:20:17');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chat_grupo_jogos`
--

CREATE TABLE `chat_grupo_jogos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `resposta_para` int(11) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chat_grupo_jogos`
--

INSERT INTO `chat_grupo_jogos` (`id`, `user_id`, `mensagem`, `arquivo`, `resposta_para`, `data_envio`) VALUES
(1, 13, 'ewewrwr', NULL, NULL, '2025-11-17 09:15:49'),
(3, 13, 'dwdw', 'uploads/1763381763_WhatsApp Image 2025-11-12 at 11.51.54.jpeg', NULL, '2025-11-17 09:16:03');

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
(3, 41, 4, 'poiiu', '2025-11-17 12:02:21');

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
(2, 25, 4, '2025-10-06 11:33:09'),
(3, 29, 4, '2025-10-06 13:47:49');

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
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(4, 90, 'Você recebeu uma solicitação de amizade', 'amizade', 6, 0, '2025-11-07 15:04:40'),
(6, 1, 'Você recebeu uma solicitação de amizade', 'amizade', 8, 0, '2025-11-07 17:52:24');

-- --------------------------------------------------------

--
-- Estrutura para tabela `planejamento`
--

CREATE TABLE `planejamento` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `dia` varchar(20) NOT NULL,
  `texto` text DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

--
-- Despejando dados para a tabela `planos`
--

INSERT INTO `planos` (`id`, `usuario_id`, `semana`, `atividades`, `criado_em`) VALUES
(2, 13, 2, 'tcc E ENEM', '2025-11-07 13:54:58');

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
(25, 13, 'y', 'imagens/posts/68e3a39c30c11.jfif', '2025-10-06 11:10:20', '2025-10-06 08:10:20'),
(29, 4, 'Uma tarde do hora com a best. #capiamigas', 'imagens/posts/68e3c87f3d01e.webp', '2025-10-06 13:47:43', '2025-10-06 10:47:43'),
(30, 4, 'Eu e minha bebezona da boca inchada querida. #airmandadedasanabeatrizes', 'imagens/posts/68e3c92381944.webp', '2025-10-06 13:50:27', '2025-10-06 10:50:27'),
(38, 13, 'Eu hoje de madrugada mexendo no tcc', 'imagens/posts/690df2ebc9a1a.jpg', '2025-11-07 13:23:55', '2025-11-07 10:23:55'),
(39, 4, 'vou me matar', '', '2025-11-12 14:38:02', '2025-11-12 11:38:02'),
(40, 4, 'g', '', '2025-11-12 15:18:55', '2025-11-12 12:18:55'),
(41, 4, 'y', '', '2025-11-12 15:28:38', '2025-11-12 12:28:38');

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
(6, 13, 90, 'pendente', '2025-11-07 08:04:40'),
(8, 13, 1, 'pendente', '2025-11-07 10:52:24');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tarefas`
--

CREATE TABLE `tarefas` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `concluida` tinyint(1) DEFAULT 0,
  `usuario_id` int(11) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tempos`
--

CREATE TABLE `tempos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tempo` varchar(20) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(4, 'Bia Soares', 'beatriz@gmail.com', '$2y$10$27rg7J1YQ9hSdb59AhTUle94ITQWOuvS6ILvpl7d0MODLB/ExkXbu', 'Study vlogs ', 'imagens/usuarios6913469619ece.png', NULL, '2025-08-18 09:19:03', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'meu namorado lindo, peixes, capivara,sobrenatural', '2025-09-24 11:33:45', 'imagens/bio/691346961a3e7.jpg', 'imagens/usuarios/691346961a5cb.jpg', '2008-03-17', 'default.png', 0),
(13, 'Marques', 'ana@gmail.com', '$2y$10$zPWncJg1miTRLlP.xPZk9efuZPyqymZu793GKnPDUc3fBeQpLdB6.', 'AnaBanana', 'imagens/usuarios690de51c81de3.png', NULL, '2025-08-18 09:19:03', NULL, NULL, NULL, 0, '', NULL, NULL, NULL, NULL, NULL, 'Culinária,Programação', 'Gatos, Stardew Valley, Café, Uva Verde', '2025-09-24 11:33:45', 'imagens/bio/690de50df02b6.jpg', 'imagens/usuarios/690de50df1ed4.jpg', '2007-10-10', 'default.png', 0),
(14, 'wenderson', 'wenderson.souza@gmail.com', '$2y$10$JTjk3KlPbsViCn9Yd9gjCOoDmmLkOp/TEA3pK2q4XkcTusKZxEzN.', '', 'imagens/usuarios/68d2ab46456c1.jpg', NULL, '2025-10-06 08:46:56', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-24 11:33:45', NULL, NULL, NULL, 'default.png', 0),
(89, 'Usuário Teste 1', 'teste1@email.com', '$2y$10$mhwR8xWl79e89JPhVYO4WuImgdM/SUfxi/nNh7i9ljY4zbq7E0Owe', NULL, NULL, NULL, '2025-09-27 21:37:23', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 21:37:23', NULL, NULL, NULL, 'default.png', 0),
(90, 'Usuário Teste 2', 'teste2@email.com', '$2y$10$vvB3M3xD06TLnXv6Br/i8u7/O0yHOMQJRd2eXpyaYbc3taxaJ9Of.', NULL, NULL, NULL, '2025-09-27 21:37:23', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 21:37:23', NULL, NULL, NULL, 'default.png', 0),
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
-- Índices de tabela `chat_grupo`
--
ALTER TABLE `chat_grupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `resposta_para` (`resposta_para`);

--
-- Índices de tabela `chat_grupo_animes`
--
ALTER TABLE `chat_grupo_animes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `chat_grupo_comida`
--
ALTER TABLE `chat_grupo_comida`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `resposta_para` (`resposta_para`);

--
-- Índices de tabela `chat_grupo_costura`
--
ALTER TABLE `chat_grupo_costura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `chat_grupo_desenhos`
--
ALTER TABLE `chat_grupo_desenhos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `chat_grupo_filmes`
--
ALTER TABLE `chat_grupo_filmes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `resposta_para` (`resposta_para`);

--
-- Índices de tabela `chat_grupo_jogos`
--
ALTER TABLE `chat_grupo_jogos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- Índices de tabela `tempos`
--
ALTER TABLE `tempos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_tempo` (`id_usuario`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `amizades`
--
ALTER TABLE `amizades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `anotacoes`
--
ALTER TABLE `anotacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `arquivos`
--
ALTER TABLE `arquivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `chat_grupo`
--
ALTER TABLE `chat_grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `chat_grupo_animes`
--
ALTER TABLE `chat_grupo_animes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `chat_grupo_comida`
--
ALTER TABLE `chat_grupo_comida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `chat_grupo_costura`
--
ALTER TABLE `chat_grupo_costura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `chat_grupo_desenhos`
--
ALTER TABLE `chat_grupo_desenhos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `chat_grupo_filmes`
--
ALTER TABLE `chat_grupo_filmes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `chat_grupo_jogos`
--
ALTER TABLE `chat_grupo_jogos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `conteudos`
--
ALTER TABLE `conteudos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `curtidas`
--
ALTER TABLE `curtidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `financas`
--
ALTER TABLE `financas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `planejamento`
--
ALTER TABLE `planejamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `planos`
--
ALTER TABLE `planos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `solicitacoes_amizade`
--
ALTER TABLE `solicitacoes_amizade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tarefas`
--
ALTER TABLE `tarefas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tempos`
--
ALTER TABLE `tempos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `chat_grupo`
--
ALTER TABLE `chat_grupo`
  ADD CONSTRAINT `chat_grupo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `chat_grupo_ibfk_2` FOREIGN KEY (`resposta_para`) REFERENCES `chat_grupo` (`id`);

--
-- Restrições para tabelas `chat_grupo_animes`
--
ALTER TABLE `chat_grupo_animes`
  ADD CONSTRAINT `chat_grupo_animes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `chat_grupo_comida`
--
ALTER TABLE `chat_grupo_comida`
  ADD CONSTRAINT `chat_grupo_comida_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `chat_grupo_comida_ibfk_2` FOREIGN KEY (`resposta_para`) REFERENCES `chat_grupo_comida` (`id`);

--
-- Restrições para tabelas `chat_grupo_costura`
--
ALTER TABLE `chat_grupo_costura`
  ADD CONSTRAINT `chat_grupo_costura_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `chat_grupo_filmes`
--
ALTER TABLE `chat_grupo_filmes`
  ADD CONSTRAINT `chat_grupo_filmes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `chat_grupo_filmes_ibfk_2` FOREIGN KEY (`resposta_para`) REFERENCES `chat_grupo_filmes` (`id`);

--
-- Restrições para tabelas `chat_grupo_jogos`
--
ALTER TABLE `chat_grupo_jogos`
  ADD CONSTRAINT `chat_grupo_jogos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`);

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
