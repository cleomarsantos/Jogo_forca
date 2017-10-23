-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 01-Jun-2016 às 08:27
-- Versão do servidor: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jogo_forca`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `palavra`
--

CREATE TABLE IF NOT EXISTS `palavra` (
  `id` int(11) NOT NULL,
  `id_tema` int(11) NOT NULL,
  `texto` varchar(30) NOT NULL,
  `tipo` enum('p','f') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `palavra`
--

INSERT INTO `palavra` (`id`, `id_tema`, `texto`, `tipo`) VALUES
(1, 1, 'GUARDA SOL', 'p'),
(2, 2, 'PIPOCA', 'p'),
(3, 2, 'PIRATAS DO CARIBE', 'f'),
(4, 2, 'REFRIGERANTE', 'p'),
(7, 1, 'BRONZEADOR', 'p'),
(8, 1, 'MARESIA', 'p'),
(9, 4, 'CANETA', 'p'),
(10, 4, 'CELULAR', 'p'),
(11, 4, 'ANEL', 'p'),
(12, 3, 'GELADEIRA', 'p'),
(13, 3, 'FOGAO', 'p'),
(14, 3, 'MICROONDAS', 'p');

-- --------------------------------------------------------

--
-- Estrutura da tabela `score`
--

CREATE TABLE IF NOT EXISTS `score` (
  `id` int(11) NOT NULL,
  `jogador` varchar(25) NOT NULL,
  `pontos` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `score`
--

INSERT INTO `score` (`id`, `jogador`, `pontos`) VALUES
(1, 'Josnel', 350),
(2, 'Bruno', 100),
(3, 'Testando', 100),
(4, 'Bruno', 900);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tema`
--

CREATE TABLE IF NOT EXISTS `tema` (
  `id` int(11) NOT NULL,
  `tema` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tema`
--

INSERT INTO `tema` (`id`, `tema`) VALUES
(1, 'PRAIA'),
(2, 'CINEMA'),
(3, 'COZINHA'),
(4, 'OBJETOS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `palavra`
--
ALTER TABLE `palavra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `palavra`
--
ALTER TABLE `palavra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `score`
--
ALTER TABLE `score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tema`
--
ALTER TABLE `tema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
