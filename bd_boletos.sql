-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 15-Jun-2019 às 22:27
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
  `referencia` varchar(50) NOT NULL,
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

INSERT INTO `casas` (`id`, `sacado-id`, `cedente-id`, `numero`, `rua`, `bairro`, `cidade`, `UF`, `referencia`, `num-hidrometro`, `dia-vencimento`, `cep`) VALUES
(2, 5, 7, '123', 'rua de nada', 'bairro asdasasdas', 'cidade itabuna', 'BA', 'casa', '123', '21', '456123');

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
  `cnpj` varchar(14) NOT NULL,
  `informacoes` text NOT NULL,
  `contato` varchar(20) NOT NULL,
  `UF` varchar(2) NOT NULL,
  `cidade` varchar(30) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `rua` varchar(30) NOT NULL,
  `numero` varchar(5) NOT NULL,
  `cep` varchar(15) NOT NULL,
  `valor-por-metro-cubico` double NOT NULL,
  `esgoto` float NOT NULL,
  `email` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cedentes`
--

INSERT INTO `cedentes` (`id`, `senha`, `nome`, `uso-banco`, `use-santander`, `cnpj`, `informacoes`, `contato`, `UF`, `cidade`, `bairro`, `rua`, `numero`, `cep`, `valor-por-metro-cubico`, `esgoto`, `email`) VALUES
(7, '123', 'Cedente 1', '123', 1, '123', 'adada', '0800 400 2135', 'BA', 'Itabuna', 'Centro', 'Adolfo Maron', '256', '45607-256', 3.5, 45, 'higorbelemdeoliveira@hotmail.com');

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas`
--

INSERT INTO `contas` (`id`, `cedente-id`, `banco`, `cip`, `conta`, `convenio`, `modalidade`, `agencia`) VALUES
(1, 7, '341', '123', '123-1', '123', '123', '111-1'),
(2, 7, '341', '123', '321-1', '123123', '2312', '222-2'),
(3, 7, '001', '1123123', '12345678-1', '123123', '123', '1234-1'),
(4, 7, '237', '123123', '159-1', '123123', '123123', '154-1');

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
  `medicao-anterior` int(11) NOT NULL,
  `boleto-gerado` tinyint(1) NOT NULL,
  `data-boleto-gerado` datetime NOT NULL,
  `carteira-selecionada` varchar(5) NOT NULL,
  `conta-selecionada-index` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `medidor-id` (`medidor-id`),
  KEY `casa-id` (`casa-id`),
  KEY `conta-selecionada-index` (`conta-selecionada-index`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `medicoes`
--

INSERT INTO `medicoes` (`id`, `casa-id`, `medidor-id`, `data-medicao`, `medicao`, `medicao-anterior`, `boleto-gerado`, `data-boleto-gerado`, `carteira-selecionada`, `conta-selecionada-index`) VALUES
(1, 2, 1, '2019-05-28 07:00:00', 43, 37, 1, '2019-06-15 18:53:08', '16', 3),
(2, 2, 1, '2019-04-28 07:00:00', 37, 30, 1, '2019-06-15 18:53:08', '16', 3),
(3, 2, 1, '2019-03-28 07:00:00', 30, 21, 1, '2019-06-15 18:53:08', '16', 3),
(4, 2, 1, '2019-02-28 07:00:00', 21, 16, 1, '2019-06-15 18:53:08', '16', 3),
(5, 2, 1, '2019-01-28 07:00:00', 16, 7, 1, '2019-06-15 18:53:08', '16', 3),
(6, 2, 1, '2018-12-28 07:00:00', 7, 0, 1, '2019-06-15 18:53:08', '16', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `medicoes-remessa`
--

DROP TABLE IF EXISTS `medicoes-remessa`;
CREATE TABLE IF NOT EXISTS `medicoes-remessa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `medicoes-id` int(11) NOT NULL,
  `remessa-id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `medicoes-id` (`medicoes-id`),
  KEY `remessa-id` (`remessa-id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `medicoes-remessa`
--

INSERT INTO `medicoes-remessa` (`id`, `medicoes-id`, `remessa-id`) VALUES
(85, 6, 39),
(84, 5, 39),
(83, 4, 39),
(82, 3, 39),
(81, 2, 39),
(80, 1, 39);

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
(1, '123456789', 7, 'Medidor fulano', '123');

-- --------------------------------------------------------

--
-- Estrutura da tabela `remessa`
--

DROP TABLE IF EXISTS `remessa`;
CREATE TABLE IF NOT EXISTS `remessa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` datetime NOT NULL,
  `arquivo-remessa` text NOT NULL,
  `arquivo-retorno` text NOT NULL,
  `enviado` tinyint(1) NOT NULL,
  `data-envio` datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `remessa`
--

INSERT INTO `remessa` (`id`, `data`, `arquivo-remessa`, `arquivo-retorno`, `enviado`, `data-envio`) VALUES
(39, '2019-06-15 19:20:24', '01REMESSA01COBRANCA       12341123456781000000CEDENTE 1                     001BANCODOBRASIL  1906150000055                      0123123                                                                                                                                                                                                                                                                  000001\r\n701000000000001231234112345678101231235                        123123123123119060000       1230000000     160111906     21061900000000030450010000 05N280519000000000000000000000000000000000000000000000000000000000000000100000000000123SACADO 1                                RUA DE NADA, 123                        BAIRRO ASDAS00456123CIDADE ITABUNA                                              000002\r\n701000000000001231234112345678101231235                        123123123123219060000       1230000000     160121906     21051900000000035530010000 05N280419000000000000000000000000000000000000000000000000000000000000000100000000000123SACADO 1                                RUA DE NADA, 123                        BAIRRO ASDAS00456123CIDADE ITABUNA                                              000003\r\n701000000000001231234112345678101231235                        123123123123319060000       1230000000     160131906     21041900000000045680010000 05N280319000000000000000000000000000000000000000000000000000000000000000100000000000123SACADO 1                                RUA DE NADA, 123                        BAIRRO ASDAS00456123CIDADE ITABUNA                                              000004\r\n701000000000001231234112345678101231235                        123123123123419060000       1230000000     160141906     21031900000000025380010000 05N280219000000000000000000000000000000000000000000000000000000000000000100000000000123SACADO 1                                RUA DE NADA, 123                        BAIRRO ASDAS00456123CIDADE ITABUNA                                              000005\r\n701000000000001231234112345678101231235                        123123123123519060000       1230000000     160151906     21021900000000045680010000 05N280119000000000000000000000000000000000000000000000000000000000000000100000000000123SACADO 1                                RUA DE NADA, 123                        BAIRRO ASDAS00456123CIDADE ITABUNA                                              000006\r\n701000000000001231234112345678101231235                        123123123123619060000       1230000000     160161906     21011800000000035530010000 05N281218000000000000000000000000000000000000000000000000000000000000000100000000000123SACADO 1                                RUA DE NADA, 123                        BAIRRO ASDAS00456123CIDADE ITABUNA                                              000007\r\n9                                                                                                                                                                                                                                                                                                                                                                                                         000008\r\n', '', 0, '2000-01-01 00:00:00');

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
  `email` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sacado`
--

INSERT INTO `sacado` (`id`, `nome`, `documento`, `avalista`, `avalista-documento`, `email`) VALUES
(5, 'Sacado 1', '123', '123', '123', 'higorbelemdeoliveira@gmail.com');

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
