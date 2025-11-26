-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/11/2025 às 02:04
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

--
-- Despejando dados para a tabela `agenda`
--

INSERT INTO `agenda` (`id`, `usuario_id`, `dia`, `compromisso`, `horario`, `notas`, `data_criacao`) VALUES
(2, 94, 'segunda', 'Estudar', '11:32', NULL, '2025-11-25 22:32:54'),
(3, 92, 'segunda', 'Estudar', '23:53', NULL, '2025-11-26 00:53:24');

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
(4, 93, 13, '2025-11-07 08:39:53'),
(5, 94, 4, '2025-11-25 22:19:47'),
(6, 14, 4, '2025-11-25 22:19:51'),
(7, 94, 14, '2025-11-25 22:20:56'),
(8, 94, 13, '2025-11-25 22:22:37');

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

--
-- Despejando dados para a tabela `anotacoes`
--

INSERT INTO `anotacoes` (`id`, `usuario_id`, `conteudo`, `data_criacao`) VALUES
(1, 94, 'Preciso estudar <font color=\"#d91c1c\"><b>matemática </b></font>para a prova.', '2025-11-25 22:34:49');

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

--
-- Despejando dados para a tabela `arquivos`
--

INSERT INTO `arquivos` (`id`, `nome_original`, `nome_servidor`, `tamanho`, `data_envio`) VALUES
(14, 'Atividade_Persona_Profissional_2025_Elegante_20251126_001909_0de473_20251126_003924_6eccfd.pdf', 'Atividade_Persona_Profissional_2025_Elegante_20251126_001909_0de473_20251126_003924_6eccfd_20251126_004856_281a37.pdf', 4440, '2025-11-25 20:48:56'),
(15, 'Atividade_Persona_Profissional_2025_Elegante.pdf', 'Atividade_Persona_Profissional_2025_Elegante_20251126_012927_ffb2be.pdf', 4440, '2025-11-25 21:29:27'),
(16, 'Atividade_Persona_Profissional_2025_Elegante_20251126_001909_0de473.pdf', 'Atividade_Persona_Profissional_2025_Elegante_20251126_001909_0de473_20251126_014343_a184cb.pdf', 4440, '2025-11-25 21:43:43');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chat_grupo`
--

CREATE TABLE `chat_grupo` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `arquivo` varchar(500) DEFAULT NULL,
  `resposta_para` int(11) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chat_grupo`
--

INSERT INTO `chat_grupo` (`id`, `user_id`, `mensagem`, `arquivo`, `resposta_para`, `data_envio`) VALUES
(1, 4, 'sdafsaefsd', NULL, NULL, '2025-11-17 11:19:18'),
(2, 4, 'dghdhgdgf', NULL, 1, '2025-11-17 11:19:22');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chat_grupo_animes`
--

CREATE TABLE `chat_grupo_animes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `arquivo` varchar(500) DEFAULT NULL,
  `resposta_para` int(11) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `chat_grupo_comida`
--

CREATE TABLE `chat_grupo_comida` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `arquivo` varchar(500) DEFAULT NULL,
  `resposta_para` int(11) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `chat_grupo_costura`
--

CREATE TABLE `chat_grupo_costura` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `arquivo` varchar(500) DEFAULT NULL,
  `resposta_para` int(11) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `chat_grupo_desenhos`
--

CREATE TABLE `chat_grupo_desenhos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `arquivo` varchar(500) DEFAULT NULL,
  `resposta_para` int(11) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chat_grupo_desenhos`
--

INSERT INTO `chat_grupo_desenhos` (`id`, `user_id`, `mensagem`, `arquivo`, `resposta_para`, `data_envio`) VALUES
(1, 4, 'ddsfgsfg', NULL, NULL, '2025-11-17 11:24:02');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chat_grupo_filmes`
--

CREATE TABLE `chat_grupo_filmes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `arquivo` varchar(500) DEFAULT NULL,
  `resposta_para` int(11) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `chat_grupo_jogos`
--

CREATE TABLE `chat_grupo_jogos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `arquivo` varchar(500) DEFAULT NULL,
  `resposta_para` int(11) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `chat_grupo_musica`
--

CREATE TABLE `chat_grupo_musica` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `arquivo` varchar(500) DEFAULT NULL,
  `resposta_para` int(11) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chat_grupo_musica`
--

INSERT INTO `chat_grupo_musica` (`id`, `user_id`, `mensagem`, `arquivo`, `resposta_para`, `data_envio`) VALUES
(2, 94, '0000', NULL, NULL, '2025-11-25 20:42:43');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chat_grupo_pintura`
--

CREATE TABLE `chat_grupo_pintura` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `arquivo` varchar(500) DEFAULT NULL,
  `resposta_para` int(11) DEFAULT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chat_grupo_pintura`
--

INSERT INTO `chat_grupo_pintura` (`id`, `user_id`, `mensagem`, `arquivo`, `resposta_para`, `data_envio`) VALUES
(1, 4, 'fsdsafsadg', NULL, NULL, '2025-11-17 11:28:51'),
(2, 4, 'dggsfdrhg', NULL, 1, '2025-11-17 11:28:55');

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
(3, 45, 94, 'Podemos comentar em posts.', '2025-11-25 22:28:09');

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
(3, 29, 4, '2025-10-06 13:47:49'),
(8, 41, 13, '2025-11-25 19:19:44'),
(9, 40, 13, '2025-11-25 19:20:05'),
(10, 39, 13, '2025-11-25 19:20:12'),
(11, 38, 13, '2025-11-25 19:22:07'),
(14, 44, 94, '2025-11-25 22:27:26');

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `data_evento` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `eventos`
--

INSERT INTO `eventos` (`id`, `titulo`, `data_evento`, `hora_inicio`, `hora_fim`, `usuario_id`) VALUES
(2, 'fsf', '2025-09-01', '03:33:00', '03:33:00', 0),
(6, 'dddd', '2025-09-30', '03:33:00', '03:33:00', 0),
(7, 'dsdsa', '2025-09-30', '04:55:00', '05:55:00', 0),
(8, 'ffff', '2025-09-30', '03:33:00', '03:33:00', 0),
(9, '3r3r3', '2025-09-30', '13:11:00', '14:13:00', 0),
(10, 'adda', '2025-09-30', '14:13:00', '15:15:00', 0),
(11, 'www', '2025-09-23', '06:36:00', '14:15:00', 0),
(12, '333', '2025-09-23', '03:33:00', '06:06:00', 0),
(13, '333333', '2025-09-16', '03:33:00', '05:35:00', 0),
(14, '666', '2025-09-26', '06:59:00', '10:02:00', 0),
(15, '333', '2025-09-26', '03:33:00', '04:04:00', 0),
(16, '3333', '2025-09-12', '13:18:00', '15:20:00', 0),
(17, 'ffffggr', '2025-09-06', '06:59:00', '08:55:00', 0),
(18, 'dwddw', '2025-09-05', '03:45:00', '06:59:00', 0),
(19, '55555', '2025-10-31', '05:55:00', '07:59:00', 0),
(20, 'alla', '2025-11-12', '12:00:00', '13:00:00', 13),
(21, 'estudar', '2025-11-26', '11:00:00', '12:00:00', 94),
(22, 'ler', '2025-11-26', '12:00:00', '13:00:00', 94),
(23, 'ler', '2025-11-26', '12:00:00', '14:00:00', 94),
(24, 'ler', '2025-11-26', '12:00:00', '14:00:00', 94),
(25, 'ler', '2025-11-26', '17:00:00', '18:00:00', 94),
(26, 'kk', '2025-11-21', '20:00:00', '22:00:00', 94),
(27, '/~;', '2025-11-26', '22:00:00', '00:00:00', 92);

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

--
-- Despejando dados para a tabela `financas`
--

INSERT INTO `financas` (`id`, `usuario_id`, `data`, `descricao`, `valor`, `data_criacao`) VALUES
(1, 94, '2025-11-13', 'Camiseta', 36.90, '2025-11-25 22:33:17');

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
(6, 1, 'Você recebeu uma solicitação de amizade', 'amizade', 8, 0, '2025-11-07 17:52:24'),
(7, 1, 'Você recebeu uma solicitação de amizade', 'amizade', 9, 0, '2025-11-26 01:53:31'),
(9, 89, 'Você recebeu uma solicitação de amizade', 'amizade', 11, 0, '2025-11-26 01:53:35'),
(10, 90, 'Você recebeu uma solicitação de amizade', 'amizade', 12, 0, '2025-11-26 01:53:37'),
(11, 92, 'Você recebeu uma solicitação de amizade', 'amizade', 13, 0, '2025-11-26 01:53:41'),
(12, 93, 'Você recebeu uma solicitação de amizade', 'amizade', 14, 0, '2025-11-26 01:53:43');

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

--
-- Despejando dados para a tabela `planejamento`
--

INSERT INTO `planejamento` (`id`, `usuario_id`, `dia`, `texto`, `data_criacao`) VALUES
(1, 94, 'Segunda-feira', 'Estudar', '2025-11-25 22:33:48'),
(2, 94, 'Terça-feira', 'Ler', '2025-11-25 22:33:48');

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
(2, 13, 2, 'tcc E ENEM', '2025-11-07 13:54:58'),
(4, 94, 3, 'portugues', '2025-11-25 23:18:20'),
(5, 94, 1, 'prova', '2025-11-26 00:29:00'),
(6, 92, 7, ',kmj', '2025-11-26 00:55:11');

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
(44, 94, 'Dá para postar imagem!', 'imagens/posts/69262d168745f.jpg', '2025-11-25 22:26:30', '2025-11-25 19:26:30'),
(45, 94, 'Olá, bem vindo(a) ao nosso site!', '', '2025-11-25 22:26:58', '2025-11-25 19:26:58');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ranking`
--

CREATE TABLE `ranking` (
  `id` int(10) NOT NULL,
  `nome_usuario` varchar(100) NOT NULL,
  `distancia` int(11) NOT NULL,
  `inimigos_derrotados` int(11) NOT NULL,
  `tempo_jogado` time NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ranking`
--

INSERT INTO `ranking` (`id`, `nome_usuario`, `distancia`, `inimigos_derrotados`, `tempo_jogado`, `criado_em`) VALUES
(21, 'JogadorTeste', 0, 0, '00:00:00', '2025-11-25 15:06:51'),
(22, 'JogadorTeste', 0, 0, '00:00:00', '2025-11-25 15:11:08'),
(23, 'JogadorTeste', 0, 0, '00:00:00', '2025-11-25 15:11:23'),
(24, 'JogadorTeste', 0, 0, '00:00:00', '2025-11-25 15:14:40'),
(25, 'JogadorTeste', 0, 0, '00:00:00', '2025-11-25 15:15:14'),
(26, 'JogadorTeste', 0, 0, '00:00:00', '2025-11-25 15:15:38'),
(27, 'JogadorTeste', 0, 0, '00:00:00', '2025-11-25 15:18:55'),
(28, 'JogadorTeste', 0, 0, '00:00:00', '2025-11-25 15:19:09');

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
(8, 13, 1, 'pendente', '2025-11-07 10:52:24'),
(9, 14, 1, 'pendente', '2025-11-25 18:53:31'),
(11, 14, 89, 'pendente', '2025-11-25 18:53:35'),
(12, 14, 90, 'pendente', '2025-11-25 18:53:37'),
(13, 14, 92, 'pendente', '2025-11-25 18:53:41'),
(14, 14, 93, 'pendente', '2025-11-25 18:53:43');

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

--
-- Despejando dados para a tabela `tarefas`
--

INSERT INTO `tarefas` (`id`, `descricao`, `concluida`, `usuario_id`, `data_criacao`) VALUES
(1, 'Ler', 1, 94, '2025-11-25 22:35:14'),
(3, 'Almoçar', 1, 94, '2025-11-25 22:35:38'),
(4, './;.~/.,', 1, 92, '2025-11-26 00:54:23');

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
(4, 'Bia Soares', 'beatriz@gmail.com', '$2y$10$27rg7J1YQ9hSdb59AhTUle94ITQWOuvS6ILvpl7d0MODLB/ExkXbu', 'Study vlogs ', 'imagens/usuarios69262b73517d2.png', NULL, '2025-08-18 09:19:03', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'meu namorado lindo, peixes, capivara,sobrenatural', '2025-09-24 11:33:45', 'imagens/bio/691346961a3e7.jpg', 'imagens/usuarios/691346961a5cb.jpg', '2008-03-17', 'default.png', 0),
(13, 'Marques', 'ana@gmail.com', '$2y$10$zPWncJg1miTRLlP.xPZk9efuZPyqymZu793GKnPDUc3fBeQpLdB6.', 'AnaBanana', 'imagens/usuarios690de51c81de3.png', NULL, '2025-08-18 09:19:03', NULL, NULL, NULL, 0, '', NULL, NULL, NULL, NULL, NULL, 'Culinária,Programação', 'Gatos, Stardew Valley, Café, Uva Verde', '2025-09-24 11:33:45', 'imagens/bio/690de50df02b6.jpg', 'imagens/usuarios/690de50df1ed4.jpg', '2007-10-10', 'default.png', 0),
(14, 'wenderson', 'wenderson.souza@gmail.com', '$2y$10$fHkWIhI0Y.bf4pq1v.iRH.KVfYELfUVBvW8z2/4K2sMvpDiGEz6Gm', '', 'imagens/usuarios69262beb44d49.png', NULL, '2025-10-06 08:46:56', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '2025-09-24 11:33:45', '', 'imagens/usuarios/6926286ba4611.jpg', '0000-00-00', 'default.png', 0),
(89, 'Usuário Teste 1', 'teste1@email.com', '$2y$10$mhwR8xWl79e89JPhVYO4WuImgdM/SUfxi/nNh7i9ljY4zbq7E0Owe', NULL, NULL, NULL, '2025-09-27 21:37:23', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 21:37:23', NULL, NULL, NULL, 'default.png', 0),
(90, 'Usuário Teste 2', 'teste2@email.com', '$2y$10$vvB3M3xD06TLnXv6Br/i8u7/O0yHOMQJRd2eXpyaYbc3taxaJ9Of.', NULL, NULL, NULL, '2025-09-27 21:37:23', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 21:37:23', NULL, NULL, NULL, 'default.png', 0),
(92, 'Ana Marques', 'anabeatrizmarquescezar@gmail.com', '', NULL, NULL, NULL, '2025-11-06 11:34:45', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-06 11:34:45', NULL, NULL, NULL, 'default.png', 0),
(93, 'Ana Beatriz', 'beatrizava@gmail.com', '$2y$10$znQAINvoqEDoaKmq9N9k6u2Q0Zy2uN2WqMI7xjFErHOKk5qJkhIS.', NULL, 'imagens/usuarios/default.jpg', NULL, '2025-11-07 05:16:28', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-07 05:16:28', NULL, NULL, NULL, 'default.png', 0),
(94, 'Apresentação', 'testetcc@gmail.com', '$2y$10$G45FTjsMiCbYBIy17Hg2H.8whZUuBhyLPZhhlN/VqvC0roGfRb8Tm', 'Sua biografia', 'imagens/usuarios69262ac0e7d68.png', NULL, '2025-11-25 19:14:26', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Favorito 1, Favorito 2, Favorito 3', '2025-11-25 19:14:26', 'imagens/bio/69262ac0e8080.jfif', 'imagens/usuarios/69262ac0e824e.jpg', '2025-11-25', 'default.png', 0);

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
  ADD KEY `user_id` (`user_id`),
  ADD KEY `resposta_para` (`resposta_para`);

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
  ADD KEY `user_id` (`user_id`),
  ADD KEY `resposta_para` (`resposta_para`);

--
-- Índices de tabela `chat_grupo_desenhos`
--
ALTER TABLE `chat_grupo_desenhos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `resposta_para` (`resposta_para`);

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
  ADD KEY `user_id` (`user_id`),
  ADD KEY `resposta_para` (`resposta_para`);

--
-- Índices de tabela `chat_grupo_musica`
--
ALTER TABLE `chat_grupo_musica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `resposta_para` (`resposta_para`);

--
-- Índices de tabela `chat_grupo_pintura`
--
ALTER TABLE `chat_grupo_pintura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `resposta_para` (`resposta_para`);

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
-- Índices de tabela `ranking`
--
ALTER TABLE `ranking`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `amizades`
--
ALTER TABLE `amizades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `anotacoes`
--
ALTER TABLE `anotacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `arquivos`
--
ALTER TABLE `arquivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `chat_grupo`
--
ALTER TABLE `chat_grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `chat_grupo_animes`
--
ALTER TABLE `chat_grupo_animes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `chat_grupo_comida`
--
ALTER TABLE `chat_grupo_comida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `chat_grupo_costura`
--
ALTER TABLE `chat_grupo_costura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `chat_grupo_desenhos`
--
ALTER TABLE `chat_grupo_desenhos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `chat_grupo_filmes`
--
ALTER TABLE `chat_grupo_filmes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `chat_grupo_jogos`
--
ALTER TABLE `chat_grupo_jogos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `chat_grupo_musica`
--
ALTER TABLE `chat_grupo_musica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `chat_grupo_pintura`
--
ALTER TABLE `chat_grupo_pintura`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `financas`
--
ALTER TABLE `financas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `planejamento`
--
ALTER TABLE `planejamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `planos`
--
ALTER TABLE `planos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de tabela `ranking`
--
ALTER TABLE `ranking`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `solicitacoes_amizade`
--
ALTER TABLE `solicitacoes_amizade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `tarefas`
--
ALTER TABLE `tarefas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tempos`
--
ALTER TABLE `tempos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

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
  ADD CONSTRAINT `chat_grupo_animes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `chat_grupo_animes_ibfk_2` FOREIGN KEY (`resposta_para`) REFERENCES `chat_grupo_animes` (`id`);

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
  ADD CONSTRAINT `chat_grupo_costura_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `chat_grupo_costura_ibfk_2` FOREIGN KEY (`resposta_para`) REFERENCES `chat_grupo_costura` (`id`);

--
-- Restrições para tabelas `chat_grupo_desenhos`
--
ALTER TABLE `chat_grupo_desenhos`
  ADD CONSTRAINT `chat_grupo_desenhos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `chat_grupo_desenhos_ibfk_2` FOREIGN KEY (`resposta_para`) REFERENCES `chat_grupo_desenhos` (`id`);

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
  ADD CONSTRAINT `chat_grupo_jogos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `chat_grupo_jogos_ibfk_2` FOREIGN KEY (`resposta_para`) REFERENCES `chat_grupo_jogos` (`id`);

--
-- Restrições para tabelas `chat_grupo_musica`
--
ALTER TABLE `chat_grupo_musica`
  ADD CONSTRAINT `chat_grupo_musica_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `chat_grupo_musica_ibfk_2` FOREIGN KEY (`resposta_para`) REFERENCES `chat_grupo_musica` (`id`);

--
-- Restrições para tabelas `chat_grupo_pintura`
--
ALTER TABLE `chat_grupo_pintura`
  ADD CONSTRAINT `chat_grupo_pintura_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `chat_grupo_pintura_ibfk_2` FOREIGN KEY (`resposta_para`) REFERENCES `chat_grupo_pintura` (`id`);

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
