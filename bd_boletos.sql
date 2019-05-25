-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 25-Maio-2019 às 20:21
-- Versão do servidor: 5.7.26
-- versão do PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd_boletos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `casas`
--

DROP TABLE IF EXISTS `casas`;
CREATE TABLE IF NOT EXISTS `casas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sacado-id` int(11) NOT NULL,
  `cedente-id` int(11) NOT NULL,
  `numero` varchar(5) NOT NULL,
  `rua` varchar(30) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `cidade` varchar(30) NOT NULL,
  `UF` varchar(2) NOT NULL,
  `num-hidrometro` varchar(30) NOT NULL,
  `dia-vencimento` varchar(2) NOT NULL,
  `cep` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sacado-id` (`sacado-id`),
  KEY `cedente-id` (`cedente-id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `casas`
--

INSERT INTO `casas` (`id`, `sacado-id`, `cedente-id`, `numero`, `rua`, `bairro`, `cidade`, `UF`, `num-hidrometro`, `dia-vencimento`, `cep`) VALUES
(2, 5, 7, '123', 'rua de nada', 'bairro asdasasdas', 'cidade itabuna', 'BA', '123', '21', '456123');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cedentes`
--

DROP TABLE IF EXISTS `cedentes`;
CREATE TABLE IF NOT EXISTS `cedentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `senha` varchar(10) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `uso-banco` varchar(50) NOT NULL,
  `use-santander` tinyint(1) NOT NULL,
  `endereco` varchar(50) NOT NULL,
  `praca` varchar(50) NOT NULL,
  `cnpj` varchar(14) NOT NULL,
  `informacoes` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cedentes`
--

INSERT INTO `cedentes` (`id`, `senha`, `nome`, `uso-banco`, `use-santander`, `endereco`, `praca`, `cnpj`, `informacoes`) VALUES
(7, '123', 'Cedente 1', '123', 1, 'rua algo, 265', 'bairro bla', '123', 'adada');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas`
--

DROP TABLE IF EXISTS `contas`;
CREATE TABLE IF NOT EXISTS `contas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cedente-id` int(11) NOT NULL,
  `banco` varchar(5) NOT NULL,
  `cip` varchar(20) NOT NULL,
  `conta` varchar(20) NOT NULL,
  `convenio` varchar(20) NOT NULL,
  `modalidade` varchar(20) NOT NULL,
  `agencia` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cedente-id` (`cedente-id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas`
--

INSERT INTO `contas` (`id`, `cedente-id`, `banco`, `cip`, `conta`, `convenio`, `modalidade`, `agencia`) VALUES
(1, 7, '341', '123', '213', '123', '123', '123'),
(2, 7, '341', '123', '3213', '123123', '2312', '312321');

-- --------------------------------------------------------

--
-- Estrutura da tabela `medicoes`
--

DROP TABLE IF EXISTS `medicoes`;
CREATE TABLE IF NOT EXISTS `medicoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `casa-id` int(11) NOT NULL,
  `medidor-id` int(11) NOT NULL,
  `data-medicao` datetime NOT NULL,
  `medicao` int(11) NOT NULL,
  `boleto-gerado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `medidor-id` (`medidor-id`),
  KEY `casa-id` (`casa-id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `medicoes`
--

INSERT INTO `medicoes` (`id`, `casa-id`, `medidor-id`, `data-medicao`, `medicao`, `boleto-gerado`) VALUES
(1, 2, 1, '2019-05-21 07:00:00', 120, 0),
(2, 2, 1, '2019-05-07 00:00:00', 500, 0),
(3, 2, 1, '2019-05-22 18:00:00', 500, 0),
(4, 2, 1, '2019-04-22 11:00:00', 400, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `medidor`
--

DROP TABLE IF EXISTS `medidor`;
CREATE TABLE IF NOT EXISTS `medidor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cpf` varchar(11) NOT NULL,
  `cedente-id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `cedente-id` (`cedente-id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `medidor`
--

INSERT INTO `medidor` (`id`, `cpf`, `cedente-id`, `nome`, `senha`) VALUES
(1, '123', 7, 'Medidor fulano', '123');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sacado`
--

DROP TABLE IF EXISTS `sacado`;
CREATE TABLE IF NOT EXISTS `sacado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `documento` varchar(20) NOT NULL,
  `avalista` varchar(20) NOT NULL,
  `avalista-documento` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sacado`
--

INSERT INTO `sacado` (`id`, `nome`, `documento`, `avalista`, `avalista-documento`, `email`) VALUES
(5, 'Sacado 1', '123', '123', '123', 'asdasd@adasd.com');

-- --------------------------------------------------------

--
-- Estrutura da tabela `visualizadores`
--

DROP TABLE IF EXISTS `visualizadores`;
CREATE TABLE IF NOT EXISTS `visualizadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cedente-id` int(11) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cedente-id` (`cedente-id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
