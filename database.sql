-- phpMyAdmin SQL Dump
-- version 4.6.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 03-Set-2017 às 21:34
-- Versão do servidor: 5.7.12
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `painel`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_avisos`
--

CREATE TABLE `aa_avisos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `texto` text CHARACTER SET utf8 NOT NULL,
  `autor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `aa_avisos`
--

INSERT INTO `aa_avisos` (`id`, `titulo`, `texto`, `autor`, `time`) VALUES
(76, 'KPanel Content Manager', '<p>Hello World!</p>', 'Gabriel', '1503363848');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_avisos_visto`
--

CREATE TABLE `aa_avisos_visto` (
  `id` int(11) NOT NULL,
  `aviso_id` int(11) NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_canais`
--

CREATE TABLE `aa_canais` (
  `canal_id` int(11) NOT NULL,
  `canal` varchar(255) CHARACTER SET utf8 NOT NULL,
  `pai` int(11) NOT NULL,
  `diretorio` text CHARACTER SET utf8 NOT NULL,
  `ordem` int(11) NOT NULL,
  `status` enum('true','false') CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `aa_canais`
--

INSERT INTO `aa_canais` (`canal_id`, `canal`, `pai`, `diretorio`, `ordem`, `status`) VALUES
(1, 'Meus Dados', 0, 'Null', 1, 'true'),
(3, 'Administração', 0, 'Null', 2, 'true'),
(5, 'Home', 0, 'Null', 3, 'true'),
(6, 'Moderação', 0, 'Null', 5, 'true'),
(7, 'Noticiário', 0, 'Null', 6, 'true'),
(8, 'Valores', 0, 'Null', 8, 'true'),
(9, 'Configurações', 1, 'configuracoes', 2, 'true'),
(10, 'Uploads', 1, 'uploads', 3, 'true'),
(11, 'Membros da Equipe', 3, 'membros', 5, 'true'),
(12, 'Cargos da Equipe', 3, 'cargos', 3, 'true'),
(13, 'Canais', 3, 'canais', 2, 'true'),
(14, 'Permissões de Cargo', 3, 'permissoes', 4, 'true'),
(16, 'Locução', 0, 'Null', 7, 'true'),
(18, 'Slide', 3, 'slide', 9, 'true'),
(19, 'Banir por IP', 3, 'banir', 7, 'true'),
(20, 'Configurações de Rádio', 3, 'configuracoes_radio', 6, 'true'),
(21, 'Lista Negra', 3, 'adc_lista_negra', 8, 'true'),
(22, 'Tema do Site', 3, 'tema_site', 16, 'true'),
(23, 'Logs', 0, 'Null', 9, 'true'),
(25, 'Tickets', 3, 'tickets', 10, 'true'),
(26, 'Desmarcar Horários', 4, 'desmarcar_horarios', 7, 'true'),
(27, 'Vinhetas', 3, 'vinhetas_add', 11, 'true'),
(28, 'Notícias Postadas', 4, 'noticias', 1, 'true'),
(29, 'Eventos Postados', 4, 'eventos', 2, 'true'),
(30, 'Categoria de Notícias', 4, 'cat_noticias', 3, 'true'),
(31, 'Categoria de Artes', 4, 'cat_artes', 5, 'true'),
(32, 'Categoria de Tópicos', 4, 'cat_topicos', 4, 'true'),
(33, 'Destaques', 4, 'destaques', 7, 'true'),
(34, 'Gerar Moedas', 4, 'gerar_codigo', 8, 'true'),
(35, 'Sites Parceiros', 4, 'parceiros', 9, 'true'),
(86, 'Notificações', 1, 'notificacoes', 1, 'true'),
(37, 'Quartos Parceiros', 4, 'quartos_parceiros', 10, 'true'),
(38, 'Avisos', 3, 'avisos', 1, 'true'),
(39, 'Alertas no Site', 3, 'alerta', 12, 'true'),
(40, 'Notificar Membro', 4, 'notificacao', 12, 'true'),
(41, 'Entrar no Ar', 16, 'entrar_ar', 1, 'true'),
(42, 'Pedidos', 16, 'pedidos', 2, 'true'),
(43, 'Horários', 16, 'horario', 4, 'true'),
(44, 'Vinhetas', 16, 'vinhetas', 42, 'true'),
(45, 'Gerar Presença', 16, 'presenca', 3, 'true'),
(47, 'Tópicos Postados', 6, 'topicos_postados', 1, 'true'),
(48, 'Artes Postadas', 6, 'artes_postadas', 2, 'true'),
(49, 'Comentários em Noticias', 6, 'noticias_comentarios', 3, 'true'),
(50, 'Comentários em Tópicos', 6, 'topicos_comentarios', 5, 'true'),
(51, 'Comentários em Artes', 6, 'artes_comentarios', 5, 'true'),
(52, 'Remover Assinatura', 6, 'assinatura', 6, 'true'),
(53, 'Remover Avatar', 6, 'avatar', 7, 'true'),
(54, 'Presentear Moedas', 4, 'presentear_moedas', 6, 'true'),
(55, 'Usuários Registrados', 6, 'usuarios', 9, 'true'),
(56, 'Presentear Emblemas', 4, 'presentear_emblemas', 6, 'true'),
(57, 'Postar Notícias', 7, 'postar_noticias', 1, 'true'),
(58, 'Postar Eventos', 7, 'postar_eventos', 2, 'true'),
(59, 'Postar Coisas Grátis', 7, 'postar_coisas_gratis', 3, 'true'),
(60, 'Postar Emblemas', 7, 'postar_ultimos_emblemas', 4, 'true'),
(61, 'Categoria', 8, 'valores_cat', 1, 'true'),
(62, 'Valores', 8, 'valores', 2, 'true'),
(63, 'Código de Moedas', 23, 'logs_moedas', 4, 'true'),
(64, 'Moedas Usadas', 23, 'logs_moedas_usadas', 5, 'true'),
(65, 'Presença Gerada', 23, 'logs_presenca', 3, 'true'),
(66, 'Áreas do Painel', 23, 'logs_painel', 1, 'true'),
(67, 'Expulsão de Locutor', 23, 'logs_kick', 2, 'true'),
(4, 'Coordenação', 0, 'Null', 4, 'true'),
(72, 'Quarto do DJ', 16, 'quarto_dj', 5, 'true'),
(73, 'Tema do Painel', 3, 'tema_painel', 17, 'true'),
(74, 'Timeline', 6, 'timeline', 11, 'true'),
(75, 'Top Music', 3, 'top_music', 13, 'true'),
(76, 'Páginas do Site', 3, 'paginas', 14, 'true'),
(77, 'Loja', 4, 'loja', 11, 'true'),
(89, 'Tópicos Postados', 4, 'topicos', 1, 'true'),
(90, 'Artes Postadas', 4, 'artes', 1, 'true'),
(91, 'Comentários em Eventos', 6, 'eventos_comentarios', 4, 'true'),
(92, 'Emblemas', 3, 'emblemas', 9, 'true'),
(93, 'Mensagens', 5, 'mensagens', 1, 'true');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_cargos`
--

CREATE TABLE `aa_cargos` (
  `cargo_id` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `cargo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `icone` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` enum('true','false') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `aa_cargos`
--

INSERT INTO `aa_cargos` (`cargo_id`, `ordem`, `cargo`, `icone`, `status`) VALUES
(1, 1, 'WebMaster', '', 'true'),
(2, 2, 'Diretor', '', 'true'),
(3, 3, 'Administrador de Rádio', '', 'true'),
(4, 3, 'Administrador de Conteúdo', '', 'true'),
(5, 3, 'Administrador de Marketing', '', 'true'),
(6, 1, 'Desenvolvedor', '', 'true'),
(7, 4, 'Supervisor de Rádio', '', 'true'),
(8, 4, 'Supervisor de Conteúdo', '', 'true'),
(9, 4, 'Supervisor de Marketing', '', 'true'),
(10, 5, 'Coordenador de Rádio', '', 'true'),
(11, 5, 'Coordenador de Conteúdo', '', 'true'),
(12, 5, 'Coordenador de Marketing', '', 'true'),
(18, 6, 'Locutor', '', 'true'),
(19, 6, 'Jornalista', '', 'true'),
(20, 6, 'Moderador', '', 'true'),
(21, 6, 'Promotor', '', 'true'),
(22, 6, 'Pixel Artista', '', 'true'),
(23, 6, 'Divulgador', '', 'true'),
(24, 6, 'Sonoplasta', '', 'true'),
(25, 6, 'Marketing', '', 'true'),
(26, 6, 'Suporte de Rádio', '', 'true'),
(27, 1, 'Assessores', '', 'false');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_dados_radio`
--

CREATE TABLE `aa_dados_radio` (
  `ip` varchar(255) CHARACTER SET utf8 NOT NULL,
  `porta` varchar(255) CHARACTER SET utf8 NOT NULL,
  `senha_radio` text CHARACTER SET utf8 NOT NULL,
  `senha_kick` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `aa_dados_radio`
--

INSERT INTO `aa_dados_radio` (`ip`, `porta`, `senha_radio`, `senha_kick`) VALUES
('123', '123', '123', '123');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_horarios`
--

CREATE TABLE `aa_horarios` (
  `id` int(11) NOT NULL,
  `dia` int(11) NOT NULL,
  `hora` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fixo` enum('false','true') CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `aa_horarios`
--

INSERT INTO `aa_horarios` (`id`, `dia`, `hora`, `user_id`, `fixo`) VALUES
(1, 1, 0, 0, 'false'),
(2, 1, 1, 0, 'false'),
(3, 1, 2, 0, 'false'),
(4, 1, 3, 0, 'false'),
(5, 1, 4, 0, 'false'),
(6, 1, 5, 0, 'false'),
(7, 1, 6, 0, 'false'),
(8, 1, 7, 0, 'false'),
(9, 1, 8, 0, 'false'),
(10, 1, 9, 0, 'false'),
(11, 1, 10, 0, 'false'),
(12, 1, 11, 0, 'false'),
(13, 1, 12, 0, 'false'),
(14, 1, 13, 0, 'false'),
(15, 1, 14, 0, 'false'),
(16, 1, 15, 0, 'false'),
(17, 1, 16, 0, 'false'),
(18, 1, 17, 0, 'false'),
(19, 1, 18, 0, 'false'),
(20, 1, 19, 0, 'false'),
(21, 1, 20, 0, 'false'),
(22, 1, 21, 0, 'false'),
(23, 1, 22, 0, 'false'),
(24, 1, 23, 0, 'false'),
(25, 2, 0, 0, 'false'),
(26, 2, 1, 0, 'false'),
(27, 2, 2, 0, 'false'),
(28, 2, 3, 0, 'false'),
(29, 2, 4, 0, 'false'),
(30, 2, 5, 0, 'false'),
(31, 2, 6, 0, 'false'),
(32, 2, 7, 0, 'false'),
(33, 2, 8, 0, 'false'),
(34, 2, 9, 0, 'false'),
(35, 2, 10, 0, 'false'),
(36, 2, 11, 0, 'false'),
(37, 2, 12, 0, 'false'),
(38, 2, 13, 0, 'false'),
(39, 2, 14, 0, 'false'),
(40, 2, 15, 0, 'false'),
(41, 2, 16, 0, 'false'),
(42, 2, 17, 0, 'false'),
(43, 2, 18, 0, 'false'),
(44, 2, 19, 0, 'false'),
(45, 2, 20, 0, 'false'),
(46, 2, 21, 0, 'false'),
(47, 2, 22, 0, 'false'),
(48, 2, 23, 0, 'false'),
(49, 3, 0, 0, 'false'),
(50, 3, 1, 0, 'false'),
(51, 3, 2, 0, 'false'),
(52, 3, 3, 0, 'false'),
(53, 3, 4, 0, 'false'),
(54, 3, 5, 0, 'false'),
(55, 3, 6, 0, 'false'),
(56, 3, 7, 0, 'false'),
(57, 3, 8, 0, 'false'),
(58, 3, 9, 0, 'false'),
(59, 3, 10, 0, 'false'),
(60, 3, 11, 0, 'false'),
(61, 3, 12, 0, 'false'),
(62, 3, 13, 0, 'false'),
(63, 3, 14, 0, 'false'),
(64, 3, 15, 0, 'false'),
(65, 3, 16, 0, 'false'),
(66, 3, 17, 0, 'false'),
(67, 3, 18, 0, 'false'),
(68, 3, 19, 0, 'false'),
(69, 3, 20, 0, 'false'),
(70, 3, 21, 0, 'false'),
(71, 3, 22, 0, 'false'),
(72, 3, 23, 0, 'false'),
(73, 4, 0, 0, 'false'),
(74, 4, 1, 0, 'false'),
(75, 4, 2, 0, 'false'),
(76, 4, 3, 0, 'false'),
(77, 4, 4, 0, 'false'),
(78, 4, 5, 0, 'false'),
(79, 4, 6, 0, 'false'),
(80, 4, 7, 0, 'false'),
(81, 4, 8, 0, 'false'),
(82, 4, 9, 0, 'false'),
(83, 4, 10, 0, 'false'),
(84, 4, 11, 0, 'false'),
(85, 4, 12, 0, 'false'),
(86, 4, 13, 0, 'false'),
(87, 4, 14, 0, 'false'),
(88, 4, 15, 0, 'false'),
(89, 4, 16, 0, 'false'),
(90, 4, 17, 0, 'false'),
(91, 4, 18, 0, 'false'),
(92, 4, 19, 0, 'false'),
(93, 4, 20, 0, 'false'),
(94, 4, 21, 0, 'false'),
(95, 4, 22, 0, 'false'),
(96, 4, 23, 0, 'false'),
(97, 5, 0, 0, 'false'),
(98, 5, 1, 0, 'false'),
(99, 5, 2, 0, 'false'),
(100, 5, 3, 0, 'false'),
(101, 5, 4, 0, 'false'),
(102, 5, 5, 0, 'false'),
(103, 5, 6, 0, 'false'),
(104, 5, 7, 0, 'false'),
(105, 5, 8, 0, 'false'),
(106, 5, 9, 0, 'false'),
(107, 5, 10, 0, 'false'),
(108, 5, 11, 0, 'false'),
(109, 5, 12, 0, 'false'),
(110, 5, 13, 0, 'false'),
(111, 5, 14, 0, 'false'),
(112, 5, 15, 0, 'false'),
(113, 5, 16, 0, 'false'),
(114, 5, 17, 0, 'false'),
(115, 5, 18, 0, 'false'),
(116, 5, 19, 0, 'false'),
(117, 5, 20, 0, 'false'),
(118, 5, 21, 0, 'false'),
(119, 5, 22, 0, 'false'),
(120, 5, 23, 0, 'false'),
(121, 6, 0, 0, 'false'),
(122, 6, 1, 0, 'false'),
(123, 6, 2, 0, 'false'),
(124, 6, 3, 0, 'false'),
(125, 6, 4, 0, 'false'),
(126, 6, 5, 0, 'false'),
(127, 6, 6, 0, 'false'),
(128, 6, 7, 0, 'false'),
(129, 6, 8, 0, 'false'),
(130, 6, 9, 0, 'false'),
(131, 6, 10, 0, 'false'),
(132, 6, 11, 0, 'false'),
(133, 6, 12, 0, 'false'),
(134, 6, 13, 0, 'false'),
(135, 6, 14, 0, 'false'),
(136, 6, 15, 0, 'false'),
(137, 6, 16, 0, 'false'),
(138, 6, 17, 0, 'false'),
(139, 6, 18, 0, 'false'),
(140, 6, 19, 0, 'false'),
(141, 6, 20, 0, 'false'),
(142, 6, 21, 0, 'false'),
(143, 6, 22, 0, 'false'),
(144, 6, 23, 0, 'false'),
(145, 7, 0, 0, 'false'),
(146, 7, 1, 0, 'false'),
(147, 7, 2, 0, 'false'),
(148, 7, 3, 0, 'false'),
(149, 7, 4, 0, 'false'),
(150, 7, 5, 0, 'false'),
(151, 7, 6, 0, 'false'),
(152, 7, 7, 0, 'false'),
(153, 7, 8, 0, 'false'),
(154, 7, 9, 0, 'false'),
(155, 7, 10, 0, 'false'),
(156, 7, 11, 0, 'false'),
(157, 7, 12, 0, 'false'),
(158, 7, 13, 0, 'false'),
(159, 7, 14, 0, 'false'),
(160, 7, 15, 0, 'false'),
(161, 7, 16, 0, 'false'),
(162, 7, 17, 0, 'false'),
(163, 7, 18, 0, 'false'),
(164, 7, 19, 0, 'false'),
(165, 7, 20, 0, 'false'),
(166, 7, 21, 0, 'false'),
(167, 7, 22, 0, 'false'),
(168, 7, 23, 0, 'false'),
(0, 0, 1504494000, 0, 'true');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_ip_ban`
--

CREATE TABLE `aa_ip_ban` (
  `id` int(11) NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8 NOT NULL,
  `motivo` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_ktema`
--

CREATE TABLE `aa_ktema` (
  `tema` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `aa_ktema`
--

INSERT INTO `aa_ktema` (`tema`) VALUES
('293A4A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_lista_negra`
--

CREATE TABLE `aa_lista_negra` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL,
  `motivo` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_locutor_voto`
--

CREATE TABLE `aa_locutor_voto` (
  `id` int(11) NOT NULL,
  `locutor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8 NOT NULL,
  `tipo` enum('true','false') CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_logs_kick`
--

CREATE TABLE `aa_logs_kick` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_logs_moedas`
--

CREATE TABLE `aa_logs_moedas` (
  `id` int(11) NOT NULL,
  `codigo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `valor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `estoque` varchar(255) CHARACTER SET utf8 NOT NULL,
  `autor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_logs_painel`
--

CREATE TABLE `aa_logs_painel` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL,
  `canal` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_logs_presenca`
--

CREATE TABLE `aa_logs_presenca` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL,
  `codigo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_notificacao`
--

CREATE TABLE `aa_notificacao` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL,
  `texto` text CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL,
  `visto` enum('true','false') CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_pedidos`
--

CREATE TABLE `aa_pedidos` (
  `id` int(11) NOT NULL,
  `locutor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `categoria` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mensagem` text CHARACTER SET utf8 NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_permissao`
--

CREATE TABLE `aa_permissao` (
  `per_id` int(11) NOT NULL,
  `cargo_id` int(11) NOT NULL,
  `canal_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `aa_permissao`
--

INSERT INTO `aa_permissao` (`per_id`, `cargo_id`, `canal_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(3, 1, 3),
(11, 1, 10),
(12, 1, 11),
(13, 1, 12),
(14, 1, 13),
(15, 1, 14),
(18, 1, 15),
(19, 2, 2),
(81, 2, 1),
(21, 1, 16),
(22, 1, 17),
(23, 1, 18),
(24, 1, 19),
(25, 1, 20),
(26, 1, 21),
(27, 1, 23),
(28, 1, 25),
(29, 1, 26),
(30, 1, 27),
(31, 1, 22),
(32, 1, 28),
(33, 1, 29),
(34, 1, 30),
(35, 1, 31),
(36, 1, 32),
(37, 1, 33),
(38, 1, 34),
(39, 1, 35),
(40, 1, 36),
(41, 1, 37),
(42, 1, 38),
(43, 1, 39),
(44, 1, 40),
(45, 1, 41),
(46, 1, 42),
(47, 1, 43),
(48, 1, 44),
(49, 1, 45),
(50, 1, 46),
(51, 1, 47),
(52, 1, 48),
(53, 1, 49),
(54, 1, 50),
(55, 1, 51),
(56, 1, 52),
(57, 1, 53),
(58, 1, 54),
(59, 1, 55),
(60, 1, 56),
(61, 1, 57),
(62, 1, 58),
(63, 1, 59),
(64, 1, 60),
(65, 1, 61),
(66, 1, 62),
(67, 1, 63),
(68, 1, 64),
(69, 1, 65),
(70, 1, 66),
(71, 1, 67),
(72, 3, 1),
(73, 3, 9),
(88, 3, 11),
(90, 3, 21),
(91, 3, 38),
(79, 1, 68),
(80, 1, 69),
(82, 2, 3),
(83, 2, 4),
(92, 3, 20),
(86, 3, 3),
(93, 3, 39),
(94, 3, 40),
(95, 3, 27),
(96, 3, 26),
(97, 3, 17),
(98, 3, 69),
(99, 3, 16),
(100, 3, 42),
(101, 3, 41),
(102, 3, 43),
(103, 3, 44),
(104, 3, 45),
(106, 3, 23),
(107, 3, 67),
(108, 3, 66),
(109, 3, 65),
(110, 2, 69),
(111, 2, 6),
(112, 2, 7),
(113, 2, 16),
(114, 2, 23),
(115, 2, 9),
(116, 2, 11),
(117, 2, 17),
(118, 2, 18),
(119, 2, 19),
(120, 2, 20),
(121, 2, 21),
(122, 2, 25),
(123, 2, 27),
(124, 2, 38),
(125, 2, 39),
(472, 4, 1),
(127, 4, 3),
(128, 4, 6),
(129, 4, 7),
(130, 4, 9),
(131, 4, 10),
(132, 4, 11),
(133, 4, 19),
(134, 4, 21),
(135, 4, 25),
(136, 4, 28),
(137, 4, 29),
(138, 4, 23),
(139, 4, 30),
(140, 4, 31),
(141, 4, 32),
(142, 4, 33),
(143, 4, 34),
(144, 4, 36),
(145, 4, 38),
(146, 4, 39),
(147, 4, 40),
(148, 4, 47),
(149, 4, 49),
(150, 4, 48),
(151, 4, 50),
(152, 4, 51),
(153, 4, 52),
(154, 4, 53),
(155, 4, 54),
(156, 4, 55),
(157, 4, 57),
(158, 4, 58),
(159, 4, 59),
(160, 4, 60),
(161, 4, 56),
(162, 4, 62),
(163, 4, 61),
(164, 4, 63),
(165, 4, 64),
(166, 4, 69),
(167, 8, 3),
(168, 7, 1),
(169, 8, 1),
(170, 8, 6),
(171, 8, 7),
(172, 8, 9),
(173, 8, 10),
(174, 8, 11),
(175, 8, 21),
(176, 8, 23),
(177, 7, 3),
(178, 4, 66),
(179, 7, 69),
(180, 8, 28),
(181, 8, 29),
(182, 8, 30),
(183, 8, 31),
(184, 8, 32),
(185, 8, 34),
(186, 8, 38),
(187, 8, 40),
(188, 8, 39),
(189, 8, 33),
(190, 8, 47),
(191, 8, 48),
(192, 8, 49),
(193, 8, 50),
(194, 8, 51),
(195, 8, 63),
(196, 8, 64),
(197, 8, 62),
(198, 8, 61),
(199, 8, 69),
(200, 8, 60),
(201, 8, 59),
(202, 8, 58),
(203, 8, 57),
(204, 7, 16),
(205, 8, 56),
(206, 8, 55),
(207, 8, 55),
(208, 8, 55),
(209, 8, 54),
(210, 8, 52),
(211, 8, 53),
(212, 8, 36),
(213, 11, 1),
(214, 11, 6),
(215, 11, 7),
(216, 11, 69),
(217, 11, 9),
(218, 11, 10),
(219, 11, 11),
(220, 11, 38),
(398, 11, 23),
(222, 11, 47),
(223, 11, 48),
(224, 11, 49),
(225, 11, 50),
(226, 11, 51),
(227, 11, 52),
(228, 11, 53),
(229, 11, 55),
(230, 7, 9),
(231, 11, 56),
(232, 11, 57),
(233, 11, 57),
(234, 11, 58),
(235, 11, 59),
(236, 11, 60),
(237, 11, 62),
(238, 11, 28),
(239, 11, 29),
(240, 7, 11),
(241, 11, 30),
(242, 11, 31),
(243, 11, 32),
(244, 11, 33),
(245, 11, 36),
(246, 11, 40),
(247, 19, 1),
(248, 19, 7),
(249, 19, 10),
(250, 19, 9),
(251, 19, 57),
(252, 19, 58),
(253, 19, 59),
(254, 19, 60),
(255, 19, 62),
(256, 19, 61),
(257, 20, 6),
(258, 20, 9),
(259, 20, 1),
(260, 20, 10),
(261, 20, 47),
(262, 20, 48),
(263, 20, 48),
(264, 20, 49),
(265, 20, 52),
(266, 20, 55),
(267, 20, 50),
(268, 20, 51),
(269, 20, 53),
(270, 20, 56),
(271, 2, 10),
(272, 2, 22),
(273, 2, 47),
(274, 2, 48),
(275, 2, 49),
(276, 2, 50),
(277, 2, 51),
(278, 2, 52),
(279, 2, 53),
(280, 2, 54),
(281, 2, 55),
(282, 2, 56),
(283, 2, 57),
(284, 2, 58),
(285, 2, 59),
(286, 2, 60),
(287, 2, 61),
(288, 2, 62),
(289, 2, 41),
(290, 2, 42),
(291, 2, 43),
(292, 2, 44),
(293, 2, 45),
(294, 2, 63),
(295, 2, 64),
(296, 2, 65),
(297, 2, 66),
(298, 2, 67),
(299, 2, 26),
(300, 2, 28),
(301, 2, 29),
(302, 2, 30),
(303, 2, 31),
(304, 2, 32),
(305, 2, 33),
(306, 2, 34),
(307, 2, 35),
(308, 2, 36),
(309, 2, 37),
(310, 2, 40),
(311, 5, 1),
(312, 5, 3),
(313, 5, 6),
(314, 5, 69),
(315, 5, 23),
(316, 3, 19),
(317, 5, 9),
(318, 5, 10),
(319, 5, 11),
(320, 5, 18),
(321, 5, 19),
(322, 5, 21),
(323, 5, 22),
(324, 5, 25),
(325, 5, 38),
(326, 5, 39),
(327, 5, 56),
(328, 5, 54),
(329, 5, 63),
(330, 5, 64),
(331, 5, 34),
(332, 5, 40),
(333, 5, 35),
(334, 5, 37),
(335, 5, 33),
(336, 5, 66),
(337, 6, 1),
(338, 6, 3),
(339, 6, 23),
(340, 6, 40),
(341, 6, 9),
(342, 6, 10),
(343, 6, 66),
(344, 6, 38),
(345, 6, 69),
(346, 7, 23),
(347, 7, 21),
(348, 7, 27),
(349, 7, 38),
(350, 7, 39),
(351, 7, 41),
(352, 7, 67),
(353, 7, 65),
(354, 7, 26),
(355, 7, 40),
(356, 7, 43),
(357, 7, 42),
(358, 7, 44),
(359, 7, 45),
(360, 9, 1),
(361, 9, 3),
(362, 9, 23),
(363, 9, 10),
(364, 9, 6),
(365, 9, 69),
(366, 9, 9),
(367, 9, 11),
(368, 9, 18),
(369, 9, 38),
(370, 9, 40),
(371, 9, 39),
(372, 9, 54),
(373, 9, 63),
(374, 9, 64),
(375, 9, 21),
(376, 9, 35),
(377, 9, 37),
(378, 9, 56),
(379, 9, 33),
(380, 10, 1),
(381, 10, 16),
(382, 10, 69),
(383, 10, 23),
(384, 10, 9),
(385, 10, 11),
(386, 10, 3),
(387, 10, 27),
(388, 10, 38),
(389, 10, 26),
(390, 10, 40),
(391, 10, 41),
(392, 10, 42),
(393, 10, 43),
(394, 10, 44),
(395, 10, 45),
(396, 10, 65),
(397, 11, 3),
(399, 11, 64),
(400, 12, 1),
(401, 12, 3),
(402, 12, 69),
(403, 12, 23),
(404, 12, 11),
(405, 12, 9),
(406, 12, 10),
(407, 12, 37),
(408, 12, 33),
(409, 12, 64),
(410, 12, 38),
(412, 12, 40),
(413, 18, 1),
(414, 18, 16),
(415, 18, 9),
(416, 18, 41),
(417, 18, 42),
(418, 18, 43),
(419, 18, 44),
(420, 18, 45),
(421, 22, 1),
(422, 22, 9),
(423, 22, 10),
(424, 21, 1),
(425, 21, 9),
(426, 21, 10),
(427, 21, 7),
(428, 21, 58),
(429, 23, 1),
(430, 23, 9),
(431, 24, 1),
(432, 24, 9),
(433, 24, 3),
(434, 24, 27),
(435, 24, 16),
(437, 24, 44),
(438, 25, 1),
(439, 25, 9),
(440, 1, 71),
(441, 2, 71),
(442, 4, 71),
(443, 8, 71),
(444, 11, 71),
(445, 20, 71),
(446, 26, 1),
(447, 26, 16),
(448, 26, 27),
(449, 26, 41),
(450, 26, 67),
(451, 26, 23),
(452, 26, 43),
(453, 26, 42),
(454, 26, 9),
(455, 1, 72),
(456, 2, 72),
(457, 3, 72),
(458, 7, 72),
(459, 10, 72),
(460, 18, 72),
(461, 1, 73),
(462, 1, 74),
(463, 1, 75),
(464, 1, 76),
(475, 1, 77),
(466, 1, 78),
(467, 1, 80),
(468, 1, 81),
(469, 1, 79),
(470, 1, 82),
(471, 1, 83),
(473, 1, 84),
(474, 19, 84),
(476, 1, 86),
(477, 4, 89),
(478, 4, 74),
(479, 1, 89),
(480, 8, 89),
(481, 8, 4),
(482, 8, 74),
(483, 11, 74),
(484, 11, 89),
(485, 1, 90),
(486, 4, 90),
(487, 2, 89),
(488, 8, 90),
(489, 11, 90),
(490, 2, 90),
(491, 6, 86),
(492, 2, 86),
(493, 3, 86),
(494, 4, 86),
(495, 5, 86),
(496, 7, 86),
(497, 8, 86),
(498, 9, 86),
(499, 10, 86),
(500, 11, 86),
(501, 12, 86),
(502, 18, 86),
(503, 19, 86),
(504, 20, 86),
(505, 21, 86),
(506, 22, 86),
(507, 23, 86),
(508, 24, 86),
(509, 25, 86),
(510, 26, 86),
(511, 1, 91),
(512, 2, 91),
(513, 4, 91),
(514, 8, 91),
(515, 11, 91),
(516, 20, 91),
(517, 1, 92),
(518, 3, 92),
(519, 4, 92),
(520, 5, 92),
(521, 1, 93),
(522, 4, 93),
(523, 8, 93),
(524, 11, 93),
(525, 20, 5),
(526, 20, 93);

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_presenca`
--

CREATE TABLE `aa_presenca` (
  `id` int(11) NOT NULL,
  `codigo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_presenca_marcadas`
--

CREATE TABLE `aa_presenca_marcadas` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_quarto_dj`
--

CREATE TABLE `aa_quarto_dj` (
  `url` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `aa_quarto_dj`
--

INSERT INTO `aa_quarto_dj` (`url`) VALUES
('123');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_tickets`
--

CREATE TABLE `aa_tickets` (
  `id` int(11) NOT NULL,
  `autor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `assunto` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mensagem` text CHARACTER SET utf8 NOT NULL,
  `status` enum('true','false','answ','sorted') CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_tickets_resp`
--

CREATE TABLE `aa_tickets_resp` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `autor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `texto` text CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_uploads`
--

CREATE TABLE `aa_uploads` (
  `id` int(11) NOT NULL,
  `url` text CHARACTER SET utf8 NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_usuarios`
--

CREATE TABLE `aa_usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL,
  `senha` varchar(255) CHARACTER SET utf8 NOT NULL,
  `pin` varchar(5) CHARACTER SET utf8 NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 DEFAULT 'default.png',
  `status` enum('true','false') CHARACTER SET utf8 NOT NULL,
  `turno` enum('manha','tarde','noite') CHARACTER SET utf8 NOT NULL,
  `programa` varchar(255) CHARACTER SET utf8 NOT NULL,
  `skype` varchar(255) CHARACTER SET utf8 NOT NULL,
  `twitter` varchar(255) CHARACTER SET utf8 NOT NULL,
  `facebook` varchar(255) CHARACTER SET utf8 NOT NULL,
  `advertencia` enum('0','1','2','3') CHARACTER SET utf8 NOT NULL,
  `banido` enum('false','true') CHARACTER SET utf8 NOT NULL,
  `motivo` text CHARACTER SET utf8 NOT NULL,
  `ultimo_time` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ultimo_ip` varchar(255) CHARACTER SET utf8 NOT NULL,
  `online` enum('true','false') CHARACTER SET utf8 NOT NULL,
  `online_time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `aa_usuarios`
--

INSERT INTO `aa_usuarios` (`id`, `usuario`, `senha`, `pin`, `avatar`, `status`, `turno`, `programa`, `skype`, `twitter`, `facebook`, `advertencia`, `banido`, `motivo`, `ultimo_time`, `ultimo_ip`, `online`, `online_time`) VALUES
(1, 'Admin', '2f297a57a5a743894a0e4a801fc3', '123', 'default.png', 'true', 'tarde', 'Nenhum', 'Nenhum', 'Nenhum', 'Nenhum', '0', 'false', '', '1503969599', '127.0.0.1', 'true', '1503969599');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_usuarios_rel`
--

CREATE TABLE `aa_usuarios_rel` (
  `rel_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cargo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `aa_usuarios_rel`
--

INSERT INTO `aa_usuarios_rel` (`rel_id`, `user_id`, `cargo_id`) VALUES
(19, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_vinhetas`
--

CREATE TABLE `aa_vinhetas` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8 NOT NULL,
  `audio` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `alertas`
--

CREATE TABLE `alertas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `texto` text CHARACTER SET utf8 NOT NULL,
  `autor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `alertas_visto`
--

CREATE TABLE `alertas_visto` (
  `id` int(11) NOT NULL,
  `alerta_id` int(11) NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `artes`
--

CREATE TABLE `artes` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `descricao` text CHARACTER SET utf8 NOT NULL,
  `categoria` varchar(255) CHARACTER SET utf8 NOT NULL,
  `imagem` varchar(255) CHARACTER SET utf8 NOT NULL,
  `autor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `moderado` enum('moderado','pendente') CHARACTER SET utf8 NOT NULL,
  `moderador` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` enum('true','false') CHARACTER SET utf8 NOT NULL DEFAULT 'true',
  `tirinha` enum('true','false') CHARACTER SET utf8 NOT NULL DEFAULT 'false',
  `ip` varchar(255) CHARACTER SET utf8 NOT NULL,
  `width` varchar(255) CHARACTER SET utf8 NOT NULL,
  `height` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `artes_cat`
--

CREATE TABLE `artes_cat` (
  `id` int(11) NOT NULL,
  `categoria` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `artes_cat`
--

INSERT INTO `artes_cat` (`id`, `categoria`) VALUES
(1, 'Tirinhas'),
(2, 'Logomarcas'),
(3, 'Layout'),
(4, 'Animações'),
(5, 'Backgrounds'),
(6, 'Emoctions'),
(7, 'Colantes'),
(8, 'Buttons'),
(9, 'Pixelização'),
(10, 'Resistência');

-- --------------------------------------------------------

--
-- Estrutura da tabela `artes_comentarios`
--

CREATE TABLE `artes_comentarios` (
  `coment_id` int(11) NOT NULL,
  `arte_id` int(11) NOT NULL,
  `autor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `comentario` text CHARACTER SET utf8 NOT NULL,
  `voto` enum('true','false') CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `coisas_gratis`
--

CREATE TABLE `coisas_gratis` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `imagem` text CHARACTER SET utf8 NOT NULL,
  `link` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `destaques`
--

CREATE TABLE `destaques` (
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL,
  `u_motivo` text CHARACTER SET utf8 NOT NULL,
  `membro` varchar(255) CHARACTER SET utf8 NOT NULL,
  `m_motivo` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `destaques`
--

INSERT INTO `destaques` (`usuario`, `u_motivo`, `membro`, `m_motivo`) VALUES
('Destaque 1', 'Motivo destaque 1', 'Destaque 2', 'Motivo destaque 2');

-- --------------------------------------------------------

--
-- Estrutura da tabela `emblemas`
--

CREATE TABLE `emblemas` (
  `id` int(11) NOT NULL,
  `codigo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `imagem` varchar(255) CHARACTER SET utf8 NOT NULL,
  `descricao` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja`
--

CREATE TABLE `loja` (
  `id` int(11) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `vendedor` varchar(255) NOT NULL,
  `comprado` enum('true','false') NOT NULL DEFAULT 'false',
  `comprador` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `status` enum('true','false') NOT NULL DEFAULT 'false'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `moedas`
--

CREATE TABLE `moedas` (
  `id` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  `codigo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `estoque` int(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `moedas_usadas`
--

CREATE TABLE `moedas_usadas` (
  `id` int(11) NOT NULL,
  `codigo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `descricao` varchar(255) CHARACTER SET utf8 NOT NULL,
  `categoria` varchar(255) CHARACTER SET utf8 NOT NULL,
  `imagem` text CHARACTER SET utf8 NOT NULL,
  `autor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `revisado` enum('true','false') CHARACTER SET utf8 NOT NULL,
  `revisador` varchar(255) CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` enum('true','false') CHARACTER SET utf8 NOT NULL,
  `fixo` enum('true','false') CHARACTER SET utf8 NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `texto` text CHARACTER SET utf8 NOT NULL,
  `evento` enum('true','false') CHARACTER SET utf8 NOT NULL,
  `evento_time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias_cat`
--

CREATE TABLE `noticias_cat` (
  `id` int(11) NOT NULL,
  `categoria` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `noticias_cat`
--

INSERT INTO `noticias_cat` (`id`, `categoria`) VALUES
(1, 'Rádio'),
(2, 'Externas'),
(3, 'Colunas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias_comentarios`
--

CREATE TABLE `noticias_comentarios` (
  `coment_id` int(11) NOT NULL,
  `noticia_id` int(11) NOT NULL,
  `autor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `comentario` text CHARACTER SET utf8 NOT NULL,
  `voto` enum('true','false') CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias_visualizacao`
--

CREATE TABLE `noticias_visualizacao` (
  `id` int(11) NOT NULL,
  `id_not` int(11) NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `paginas`
--

CREATE TABLE `paginas` (
  `id` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `icone` varchar(255) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `conteudo` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `status` enum('true','false') NOT NULL DEFAULT 'true'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `paginas`
--

INSERT INTO `paginas` (`id`, `ordem`, `icone`, `titulo`, `conteudo`, `url`, `categoria`, `status`) VALUES
(2359, 0, '', 'Teste', '<p>Teste</p>', '0', '7', 'true'),
(2358, 0, '', 'Teste', '<p>Teste</p>', '0', '6', 'true'),
(2357, 0, '', 'Teste', '<p>Teste</p>', '0', '5', 'true'),
(2356, 0, '', 'Teste', '<p>Teste</p>', '0', '4', 'true'),
(2355, 0, '', 'Teste', '<p>Teste</p>', '0', '3', 'true'),
(2354, 0, '', 'Teste', '<p>Teste</p>', '0', '2', 'true'),
(2353, 0, '', 'Teste', '<p>Teste</p>', '0', '1', 'true');

-- --------------------------------------------------------

--
-- Estrutura da tabela `paginas_cat`
--

CREATE TABLE `paginas_cat` (
  `id` int(11) NOT NULL,
  `categoria` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `paginas_cat`
--

INSERT INTO `paginas_cat` (`id`, `categoria`) VALUES
(1, 'Site'),
(2, 'Jogo'),
(3, 'Fórum'),
(4, 'Notícias'),
(5, 'Rádio'),
(6, 'Usuário'),
(7, 'Fã Center');

-- --------------------------------------------------------

--
-- Estrutura da tabela `parceiros`
--

CREATE TABLE `parceiros` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8 NOT NULL,
  `banner` text CHARACTER SET utf8 NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `quartos_parceiros`
--

CREATE TABLE `quartos_parceiros` (
  `id` int(11) NOT NULL,
  `quarto` varchar(255) CHARACTER SET utf8 NOT NULL,
  `link` text CHARACTER SET utf8 NOT NULL,
  `dono` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `recordes`
--

CREATE TABLE `recordes` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `recordista` varchar(255) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `texto` text NOT NULL,
  `time` varchar(255) NOT NULL,
  `status` enum('true','false') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `slide`
--

CREATE TABLE `slide` (
  `id` int(11) NOT NULL,
  `imagem` text CHARACTER SET utf8 NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `descricao` varchar(255) CHARACTER SET utf8 NOT NULL,
  `url` text CHARACTER SET utf8 NOT NULL,
  `nova_guia` enum('true','false') CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `slide`
--

INSERT INTO `slide` (`id`, `imagem`, `titulo`, `descricao`, `url`, `nova_guia`) VALUES
(62, 'slide-de3b3b621808e6c86068359f02803aa9.png', 'Teste', 'Teste', 'http://google.com.br/', 'true');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tema`
--

CREATE TABLE `tema` (
  `cor_primaria` varchar(255) CHARACTER SET utf8 NOT NULL,
  `cor_secundaria` varchar(255) CHARACTER SET utf8 NOT NULL,
  `cor_terciaria` varchar(255) CHARACTER SET utf8 NOT NULL,
  `background` varchar(255) CHARACTER SET utf8 NOT NULL,
  `rolar` enum('true','false') CHARACTER SET utf8 NOT NULL,
  `repetir` enum('true','false') CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tema`
--

INSERT INTO `tema` (`cor_primaria`, `cor_secundaria`, `cor_terciaria`, `background`, `rolar`, `repetir`) VALUES
('#4646d0', '#db603c', '#32e43a', '#958582', 'true', 'false');

-- --------------------------------------------------------

--
-- Estrutura da tabela `timeline`
--

CREATE TABLE `timeline` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mensagem` text CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` enum('true','false') CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `topicos`
--

CREATE TABLE `topicos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `categoria` varchar(255) CHARACTER SET utf8 NOT NULL,
  `autor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `texto` text CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL,
  `reviver_time` varchar(255) CHARACTER SET utf8 NOT NULL,
  `moderado` enum('moderado','fechado','pendente') CHARACTER SET utf8 NOT NULL DEFAULT 'pendente',
  `moderador` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT 'Nenhum',
  `url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `fixo` enum('true','false') CHARACTER SET utf8 NOT NULL DEFAULT 'false',
  `status` enum('true','false') CHARACTER SET utf8 NOT NULL DEFAULT 'true',
  `ip` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `topicos_cat`
--

CREATE TABLE `topicos_cat` (
  `id` int(11) NOT NULL,
  `categoria` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `topicos_cat`
--

INSERT INTO `topicos_cat` (`id`, `categoria`) VALUES
(1, 'Curiosidades'),
(2, 'Sugestões'),
(3, 'Apresentação'),
(4, 'Dúvidas'),
(5, 'Novidades'),
(6, 'Outros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `topicos_comentarios`
--

CREATE TABLE `topicos_comentarios` (
  `coment_id` int(11) NOT NULL,
  `topico_id` int(11) NOT NULL,
  `autor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `comentario` text CHARACTER SET utf8 NOT NULL,
  `voto` enum('true','false') CHARACTER SET utf8 NOT NULL DEFAULT 'true',
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `top_music`
--

CREATE TABLE `top_music` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `banda` varchar(255) CHARACTER SET utf8 NOT NULL,
  `imagem` varchar(255) CHARACTER SET utf8 NOT NULL,
  `url` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `top_music`
--

INSERT INTO `top_music` (`id`, `titulo`, `banda`, `imagem`, `url`) VALUES
(1, 'Teste', 'Teste', 'topmusic-e6d81251a65aecc8907eac8da4481d36.png', 'https://www.google.com.br/'),
(2, 'Teste', 'Teste', 'topmusic-077c974e928bae3e377cf2587d887c75.png', 'https://www.google.com.br/'),
(3, 'Teste', 'Teste', 'topmusic-5ea0c46683a0b82285686814c74d897c.png', 'https://www.google.com.br/');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tube`
--

CREATE TABLE `tube` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `descricao` varchar(255) CHARACTER SET utf8 NOT NULL,
  `autor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `video` varchar(255) CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` enum('true','false') CHARACTER SET utf8 NOT NULL DEFAULT 'true'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ultimos_emblemas`
--

CREATE TABLE `ultimos_emblemas` (
  `id` int(11) NOT NULL,
  `codigo` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL,
  `senha` varchar(255) CHARACTER SET utf8 NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT 'default.png',
  `background` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT 'default.png',
  `assinatura` text CHARACTER SET utf8 NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8 NOT NULL,
  `twitter` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '@',
  `registro_time` varchar(255) CHARACTER SET utf8 NOT NULL,
  `banido` enum('true','false') CHARACTER SET utf8 NOT NULL DEFAULT 'false',
  `motivo_ban` text CHARACTER SET utf8 NOT NULL,
  `ultimo_ip` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ultimo_time` varchar(255) CHARACTER SET utf8 NOT NULL,
  `moedas` int(11) NOT NULL DEFAULT '0',
  `online` enum('true','false') CHARACTER SET utf8 NOT NULL DEFAULT 'false',
  `online_time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_emblemas`
--

CREATE TABLE `usuarios_emblemas` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 NOT NULL,
  `codigo` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_mensagens`
--

CREATE TABLE `usuarios_mensagens` (
  `id` int(11) NOT NULL,
  `usuario_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `autor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mensagem` text CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `valores`
--

CREATE TABLE `valores` (
  `id` int(11) NOT NULL,
  `mobi` varchar(255) NOT NULL,
  `categoria` int(11) NOT NULL,
  `preco` int(11) NOT NULL,
  `estado` enum('subiu','manteve','caiu') NOT NULL,
  `icone` varchar(255) NOT NULL,
  `valorista` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `valores_cat`
--

CREATE TABLE `valores_cat` (
  `id` int(11) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `icone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aa_avisos`
--
ALTER TABLE `aa_avisos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_avisos_visto`
--
ALTER TABLE `aa_avisos_visto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_canais`
--
ALTER TABLE `aa_canais`
  ADD PRIMARY KEY (`canal_id`);

--
-- Indexes for table `aa_cargos`
--
ALTER TABLE `aa_cargos`
  ADD PRIMARY KEY (`cargo_id`);

--
-- Indexes for table `aa_horarios`
--
ALTER TABLE `aa_horarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_ip_ban`
--
ALTER TABLE `aa_ip_ban`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_lista_negra`
--
ALTER TABLE `aa_lista_negra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_locutor_voto`
--
ALTER TABLE `aa_locutor_voto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_logs_kick`
--
ALTER TABLE `aa_logs_kick`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_logs_moedas`
--
ALTER TABLE `aa_logs_moedas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_logs_painel`
--
ALTER TABLE `aa_logs_painel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_logs_presenca`
--
ALTER TABLE `aa_logs_presenca`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_notificacao`
--
ALTER TABLE `aa_notificacao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_pedidos`
--
ALTER TABLE `aa_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_permissao`
--
ALTER TABLE `aa_permissao`
  ADD PRIMARY KEY (`per_id`);

--
-- Indexes for table `aa_presenca`
--
ALTER TABLE `aa_presenca`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_presenca_marcadas`
--
ALTER TABLE `aa_presenca_marcadas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_tickets`
--
ALTER TABLE `aa_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_tickets_resp`
--
ALTER TABLE `aa_tickets_resp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_uploads`
--
ALTER TABLE `aa_uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_usuarios`
--
ALTER TABLE `aa_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aa_usuarios_rel`
--
ALTER TABLE `aa_usuarios_rel`
  ADD PRIMARY KEY (`rel_id`);

--
-- Indexes for table `aa_vinhetas`
--
ALTER TABLE `aa_vinhetas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alertas`
--
ALTER TABLE `alertas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alertas_visto`
--
ALTER TABLE `alertas_visto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artes`
--
ALTER TABLE `artes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artes_cat`
--
ALTER TABLE `artes_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artes_comentarios`
--
ALTER TABLE `artes_comentarios`
  ADD PRIMARY KEY (`coment_id`);

--
-- Indexes for table `coisas_gratis`
--
ALTER TABLE `coisas_gratis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emblemas`
--
ALTER TABLE `emblemas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loja`
--
ALTER TABLE `loja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moedas`
--
ALTER TABLE `moedas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moedas_usadas`
--
ALTER TABLE `moedas_usadas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `noticias_cat`
--
ALTER TABLE `noticias_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `noticias_comentarios`
--
ALTER TABLE `noticias_comentarios`
  ADD PRIMARY KEY (`coment_id`);

--
-- Indexes for table `noticias_visualizacao`
--
ALTER TABLE `noticias_visualizacao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paginas`
--
ALTER TABLE `paginas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paginas_cat`
--
ALTER TABLE `paginas_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parceiros`
--
ALTER TABLE `parceiros`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quartos_parceiros`
--
ALTER TABLE `quartos_parceiros`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recordes`
--
ALTER TABLE `recordes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slide`
--
ALTER TABLE `slide`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timeline`
--
ALTER TABLE `timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topicos`
--
ALTER TABLE `topicos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topicos_cat`
--
ALTER TABLE `topicos_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topicos_comentarios`
--
ALTER TABLE `topicos_comentarios`
  ADD PRIMARY KEY (`coment_id`);

--
-- Indexes for table `top_music`
--
ALTER TABLE `top_music`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tube`
--
ALTER TABLE `tube`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ultimos_emblemas`
--
ALTER TABLE `ultimos_emblemas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios_emblemas`
--
ALTER TABLE `usuarios_emblemas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios_mensagens`
--
ALTER TABLE `usuarios_mensagens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `valores`
--
ALTER TABLE `valores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `valores_cat`
--
ALTER TABLE `valores_cat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aa_avisos`
--
ALTER TABLE `aa_avisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `aa_avisos_visto`
--
ALTER TABLE `aa_avisos_visto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aa_canais`
--
ALTER TABLE `aa_canais`
  MODIFY `canal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
--
-- AUTO_INCREMENT for table `aa_cargos`
--
ALTER TABLE `aa_cargos`
  MODIFY `cargo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `aa_horarios`
--
ALTER TABLE `aa_horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;
--
-- AUTO_INCREMENT for table `aa_ip_ban`
--
ALTER TABLE `aa_ip_ban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aa_lista_negra`
--
ALTER TABLE `aa_lista_negra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aa_locutor_voto`
--
ALTER TABLE `aa_locutor_voto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aa_logs_kick`
--
ALTER TABLE `aa_logs_kick`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aa_logs_moedas`
--
ALTER TABLE `aa_logs_moedas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aa_logs_painel`
--
ALTER TABLE `aa_logs_painel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aa_logs_presenca`
--
ALTER TABLE `aa_logs_presenca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aa_notificacao`
--
ALTER TABLE `aa_notificacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aa_pedidos`
--
ALTER TABLE `aa_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aa_permissao`
--
ALTER TABLE `aa_permissao`
  MODIFY `per_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=527;
--
-- AUTO_INCREMENT for table `aa_presenca`
--
ALTER TABLE `aa_presenca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aa_presenca_marcadas`
--
ALTER TABLE `aa_presenca_marcadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aa_tickets`
--
ALTER TABLE `aa_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aa_tickets_resp`
--
ALTER TABLE `aa_tickets_resp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aa_uploads`
--
ALTER TABLE `aa_uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aa_usuarios`
--
ALTER TABLE `aa_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `aa_usuarios_rel`
--
ALTER TABLE `aa_usuarios_rel`
  MODIFY `rel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `aa_vinhetas`
--
ALTER TABLE `aa_vinhetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `alertas`
--
ALTER TABLE `alertas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `alertas_visto`
--
ALTER TABLE `alertas_visto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `artes`
--
ALTER TABLE `artes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `artes_cat`
--
ALTER TABLE `artes_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `artes_comentarios`
--
ALTER TABLE `artes_comentarios`
  MODIFY `coment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `coisas_gratis`
--
ALTER TABLE `coisas_gratis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emblemas`
--
ALTER TABLE `emblemas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `loja`
--
ALTER TABLE `loja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `moedas`
--
ALTER TABLE `moedas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `moedas_usadas`
--
ALTER TABLE `moedas_usadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `noticias_cat`
--
ALTER TABLE `noticias_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `noticias_comentarios`
--
ALTER TABLE `noticias_comentarios`
  MODIFY `coment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `noticias_visualizacao`
--
ALTER TABLE `noticias_visualizacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `paginas`
--
ALTER TABLE `paginas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2361;
--
-- AUTO_INCREMENT for table `paginas_cat`
--
ALTER TABLE `paginas_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `parceiros`
--
ALTER TABLE `parceiros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `quartos_parceiros`
--
ALTER TABLE `quartos_parceiros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `recordes`
--
ALTER TABLE `recordes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `slide`
--
ALTER TABLE `slide`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `timeline`
--
ALTER TABLE `timeline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `topicos`
--
ALTER TABLE `topicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `topicos_cat`
--
ALTER TABLE `topicos_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `topicos_comentarios`
--
ALTER TABLE `topicos_comentarios`
  MODIFY `coment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `top_music`
--
ALTER TABLE `top_music`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tube`
--
ALTER TABLE `tube`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `ultimos_emblemas`
--
ALTER TABLE `ultimos_emblemas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuarios_emblemas`
--
ALTER TABLE `usuarios_emblemas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuarios_mensagens`
--
ALTER TABLE `usuarios_mensagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `valores`
--
ALTER TABLE `valores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `valores_cat`
--
ALTER TABLE `valores_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
