-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Out-2020 às 20:39
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto_final_mvc_v2`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `associacao`
--

CREATE TABLE `associacao` (
  `idAssoc` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `morada` varchar(255) NOT NULL,
  `telefone` int(9) NOT NULL,
  `numContribuinte` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `associacao`
--

INSERT INTO `associacao` (`idAssoc`, `nome`, `morada`, `telefone`, `numContribuinte`) VALUES
(1, 'Quinta Grande', 'Quinta Grande', 123456789, 2147483647),
(2, 'Campanario Assoc', 'Campanario', 876879, 7465879),
(7, 'Ponta de Sol', 'Ponta de Sol', 8172574, 7465879),
(23, 'Camacha city', 'Camacha city', 876879, 2147483647),
(24, 'Nogueira', 'Camacha Nogueira', 56456456, 21425482);

-- --------------------------------------------------------

--
-- Estrutura da tabela `associaeventos`
--

CREATE TABLE `associaeventos` (
  `idAssoc` int(11) DEFAULT NULL,
  `idEvento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `associaeventos`
--

INSERT INTO `associaeventos` (`idAssoc`, `idEvento`) VALUES
(1, 11),
(1, 15),
(24, 11);

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos`
--

CREATE TABLE `eventos` (
  `idEvento` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `evento` varchar(255) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `idAssoc` int(11) NOT NULL,
  `dataComeco` date DEFAULT NULL,
  `dataTermino` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `eventos`
--

INSERT INTO `eventos` (`idEvento`, `titulo`, `evento`, `imagem`, `idAssoc`, `dataComeco`, `dataTermino`) VALUES
(1, 'Desporto', 'Football', 'maxresdefaultjpg407285743jpg_698783773.jpg', 1, '2020-10-24', '2020-10-23'),
(11, 'ENTREGA DE PROJETO', 'HOJE ESTA MUITO MAU', '263906jpg_876591735.jpg', 1, '2020-10-24', '2020-10-23'),
(15, 'COD CW', 'BETA ACABOU 1.01', '73311df165f00ccc68d6359219a2ed5ajpg_1992437509.jpg', 1, '2020-10-24', '2020-10-01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagem`
--

CREATE TABLE `imagem` (
  `imagem` varchar(255) NOT NULL,
  `idImagem` int(11) NOT NULL,
  `idAssoc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `imagem`
--

INSERT INTO `imagem` (`imagem`, `idImagem`, `idAssoc`) VALUES
('callofdutyblackopscoldwar1jpg920903174jpg_45543011.jpg', 4, 1),
('24546jpg899375267jpg_822806668.jpg', 5, 1),
('1366x768hdwallpaperanimedesktopn2nfie0xfebt1htwyckvkyddd6ln3dc1ucflmznr6oanime4063614838402applebear1234088462338402160jpg_1717307317.jpg', 6, 1),
('24541jpg_1858605861.jpg', 7, 1),
('24543jpg_1542250709.jpg', 9, 2),
('65938jpg_116868194.jpg', 11, 5),
('107196jpg_80096837.jpg', 13, 1),
('128706copiajpg_814502375.jpg', 15, 2),
('314574png_23792549.png', 18, 7),
('309322png_1400481717.png', 20, 7),
('65938jpg_659262307.jpg', 23, 23),
('24543jpg_2006636295.jpg', 24, 24);

-- --------------------------------------------------------

--
-- Estrutura da tabela `inscricoes`
--

CREATE TABLE `inscricoes` (
  `idEvento` int(11) NOT NULL,
  `idSocio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `inscricoes`
--

INSERT INTO `inscricoes` (`idEvento`, `idSocio`) VALUES
(11, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias`
--

CREATE TABLE `noticias` (
  `idNoticia` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `noticia` text NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `idAssoc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `noticias`
--

INSERT INTO `noticias` (`idNoticia`, `titulo`, `noticia`, `imagem`, `idAssoc`) VALUES
(11, 'COD CW', 'ALPHA 1.0', 'callofdutyblackopscoldwar1jpg60311551jpg_126510886.jpg', 1),
(13, 'IPHONE 12', 'SEM CARREGADOR', '24546jpg_899375267.jpg', 2),
(15, 'COD QUASE SAINDO', 'FINALMENTE!', '567918png_1088041093.png', 7),
(27, 'TOU QUASE ACABANDO', 'FINALMENTE!!!!', '30749jpg_2924313.jpg', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `quotas`
--

CREATE TABLE `quotas` (
  `idQuota` int(11) NOT NULL,
  `idSocio` int(11) NOT NULL,
  `dataComeco` date NOT NULL,
  `dataTermino` date NOT NULL,
  `preco` float NOT NULL,
  `pago` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `quotas`
--

INSERT INTO `quotas` (`idQuota`, `idSocio`, `dataComeco`, `dataTermino`, `preco`, `pago`) VALUES
(1, 7, '2020-10-10', '2020-10-14', 300, 1),
(2, 0, '2020-10-10', '2020-10-14', 500, 0),
(3, 0, '2020-10-10', '2020-10-14', 500, 0),
(4, 0, '2020-10-10', '2020-10-14', 500, 0),
(5, 0, '2020-10-10', '2020-10-14', 500, 0),
(6, 48, '2020-10-10', '2020-10-14', 500, 0),
(8, 43, '2020-10-10', '2020-10-14', 500, 0),
(12, 46, '2020-10-10', '2020-10-14', 6070, 0),
(18, 54, '2020-10-10', '2020-10-14', 545455000, 0),
(19, 7, '2020-10-10', '2020-10-14', 5000, 1),
(20, 7, '2020-10-10', '2020-10-14', 600, 0),
(24, 55, '2020-10-10', '2020-10-14', 500, 0),
(31, 46, '2020-10-10', '2020-10-14', 50000000, 0),
(33, 60, '2020-10-10', '2020-10-14', 500, 0),
(34, 58, '2020-10-10', '2020-10-14', 500, 0),
(41, 7, '2020-10-10', '2020-10-14', 3e16, 1),
(42, 7, '2020-10-10', '2020-10-14', 200, 1),
(54, 60, '2020-10-10', '2020-10-14', 3e16, 0),
(55, 69, '2020-10-10', '2020-10-14', 5000, 0),
(56, 70, '2020-10-10', '2020-10-14', 5000, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `socios`
--

CREATE TABLE `socios` (
  `idSocio` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `socio_permissions` varchar(255) NOT NULL,
  `socio_session_id` varchar(255) NOT NULL,
  `idAssoc` int(11) NOT NULL,
  `imagem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `socios`
--

INSERT INTO `socios` (`idSocio`, `nome`, `email`, `login`, `password`, `socio_permissions`, `socio_session_id`, `idAssoc`, `imagem`) VALUES
(7, 'Francisco', 'guilhermejesus216@gmail.com', 'admin', '$2a$08$nCOvoCSamywf61mEeQO4aecooQnRAHVIzJ.DFa388QeUBRtqmKH4i', 'a:7:{i:0;s:5:\"admin\";i:1;s:12:\"gerir-socios\";i:2;s:11:\"gerir-assoc\";i:3;s:13:\"gerir-eventos\";i:4;s:19:\"gerir-assoc-specify\";i:5;s:6:\"perfil\";i:6;s:14:\"gerir-noticias\";}', 'f3dbec2a19ed64633a2a4d9b2aae3805', 1, '8863jpg_1219111066.jpg'),
(43, 'dercio', 'fiwjnrk@gmail.com', 'dercio', '$2a$08$SZxHn7DKHSWA.Ofq1zEaqeq0M6vAWIt.P4vwFi03.X.nt668xk62y', 'a:2:{i:0;s:11:\"gerir-assoc\";i:1;s:6:\"perfil\";}', '32d96f456309292bfd0a8a352795b6e5', 1, '24543jpg_411116303.jpg'),
(54, 'adm', 'guilhermejesus216@gmail.com', 'adm', '$2a$08$0UH/cQqFkyQpd1WBrB08ke/M/5KxJ7Xxysu4tpxsPo9e2cL4vE2pa', 'a:6:{i:0;s:5:\"admin\";i:1;s:12:\"gerir-socios\";i:2;s:11:\"gerir-assoc\";i:3;s:13:\"gerir-eventos\";i:4;s:19:\"gerir-assoc-specify\";i:5;s:6:\"perfil\";}', '831bd7c1db1e653fcef22ef92afcc89e', 2, '24543jpg_411116303.jpg'),
(55, 'rui', 'rui@gmail.com', 'rui', '$2a$08$kPo9wpU8ENOUwa2fzJk6M.Zja5hjhuehKwtLQ2h37iaCqevadIvG.', 'a:2:{i:0;s:12:\"gerir-socios\";i:1;s:6:\"perfil\";}', '6e0bc03e5c7344cfe56d3a3c232b2075', 1, '24543jpg_411116303.jpg'),
(58, 'marco', 'marco@gmail', 'marco', '$2a$08$KfqrRtAYPN/6hJjVC.T1AOIWyEvVJUX4y1WbNIzFo0BM9qqMuJmmK', 'a:2:{i:0;s:6:\"perfil\";i:1;s:12:\"gerir-socios\";}', 'd19dbe74689d29a82e7188333c17c08f', 1, '24543jpg_411116303.jpg'),
(60, 'dexa', 'dexa@gmail.com', 'dexa', '$2a$08$IunbRR4ruugw5G2WlcHU0etJ.9wXQZlAF6tzgomPmZ5ZO1ZjdGoNG', 'a:6:{i:0;s:5:\"admin\";i:1;s:12:\"gerir-socios\";i:2;s:11:\"gerir-assoc\";i:3;s:13:\"gerir-eventos\";i:4;s:19:\"gerir-assoc-specify\";i:5;s:6:\"perfil\";}', '04568965366372b700ca279090fd8f02', 7, '24543jpg_411116303.jpg'),
(69, 'henry danger', 'henry@gmail.com', 'henry', '$2a$08$0CsqxBtZYh/WsQ6jQXkoRuVSr1EowXgs5.BO3M.5oh00a.0Kkf7Ja', 'a:1:{i:0;s:6:\"perfil\";}', '468fc7286e4db5c225284c71cb638a57', 23, 'walp1539286569543png_1484749743.png'),
(70, 'dipper', 'dipper@gmail.com', 'dipper', '$2a$08$BFsP5LjrJ2NGR..UoOnNtuTQ06AvyvZZK4/b20z7xIisgNHNlRsHi', 'a:1:{i:0;s:6:\"perfil\";}', '9850043900b5a281707890b710c5020f', 24, '401837jpg_1661636762.jpg');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `associacao`
--
ALTER TABLE `associacao`
  ADD PRIMARY KEY (`idAssoc`);

--
-- Índices para tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`idEvento`);

--
-- Índices para tabela `imagem`
--
ALTER TABLE `imagem`
  ADD PRIMARY KEY (`idImagem`);

--
-- Índices para tabela `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`idNoticia`);

--
-- Índices para tabela `quotas`
--
ALTER TABLE `quotas`
  ADD PRIMARY KEY (`idQuota`);

--
-- Índices para tabela `socios`
--
ALTER TABLE `socios`
  ADD PRIMARY KEY (`idSocio`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `associacao`
--
ALTER TABLE `associacao`
  MODIFY `idAssoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `idEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `imagem`
--
ALTER TABLE `imagem`
  MODIFY `idImagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `noticias`
--
ALTER TABLE `noticias`
  MODIFY `idNoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `quotas`
--
ALTER TABLE `quotas`
  MODIFY `idQuota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de tabela `socios`
--
ALTER TABLE `socios`
  MODIFY `idSocio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
