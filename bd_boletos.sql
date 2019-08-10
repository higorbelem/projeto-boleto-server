-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 10-Ago-2019 às 01:42
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

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `editar-sacado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editar-sacado` (`dialogMode` INTEGER, `idSacado` INTEGER, `idCedente` INTEGER, `nome` VARCHAR(50), `documento` VARCHAR(20), `email` VARCHAR(70), `queryAddCasas` TEXT, `queryEditCasas` TEXT)  exit_proc:BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
 	BEGIN
    		ROLLBACK;
    		RESIGNAL;
  	END;

        SET autocommit=0;
	START TRANSACTION;

        IF (dialogMode = 0) THEN
            INSERT INTO `sacado` (`nome`,`documento`,`avalista`,`avalista-documento`,`email`) VALUES (nome,documento,'0','0',email);
            
	    SET @idSacadoTemp = (SELECT LAST_INSERT_ID());
            INSERT INTO `cedentes-sacado` (`id-cedente`, `id-sacado`) VALUES (idCedente,@idSacadoTemp);
        ELSE 
            IF (dialogMode = 1) THEN
                UPDATE `sacado` SET `nome` = nome,`documento` = documento,`email` = email WHERE `id` = idSacado;
                SET @idSacadoTemp = idSacado;
            ELSE   
                SELECT "erro" as 'return-value';
                ROLLBACK;
		LEAVE exit_proc;
            END IF;
        END IF; 

        IF (queryAddCasas IS NOT NULL) THEN
            SET @query_as_string = (SELECT REPLACE(queryAddCasas,'id_sacado_temp_subst',@idSacadoTemp));
            PREPARE statement_1 FROM @query_as_string;
            EXECUTE statement_1;
            DEALLOCATE PREPARE statement_1;
        END IF;

        IF (queryEditCasas IS NOT NULL) THEN
            SET @query_as_string = (SELECT REPLACE(queryEditCasas,'id_sacado_temp_subst',@idSacadoTemp));
            PREPARE statement_1 FROM @query_as_string;
            EXECUTE statement_1;
            DEALLOCATE PREPARE statement_1;
        END IF;

        SELECT "ok" as 'return-value';
        COMMIT;
    END$$

DROP PROCEDURE IF EXISTS `teste`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `teste` (`teste` VARCHAR(10240))  BEGIN
        DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;
        START TRANSACTION;
		
        SET @query_as_string = teste;
        PREPARE statement_1 FROM @query_as_string;
        EXECUTE statement_1;
        DEALLOCATE PREPARE statement_1;
        
    END$$

DROP PROCEDURE IF EXISTS `transac`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `transac` (`idCasaParam` INTEGER, `idMedidorParam` INTEGER, `medicaoParam` INTEGER)  BEGIN
        DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;
        START TRANSACTION;
    
        SET @medicao = (SELECT `medicao` FROM `medicoes` WHERE `id` = (SELECT max(`id`) FROM `medicoes` WHERE `casa-id` = idCasaParam));
    
        IF (medicaoParam < @medicao) THEN
            SELECT "menor" as 'return-value';
            ROLLBACK;
        ELSE
            IF (@medicao IS NULL) THEN
                INSERT INTO `medicoes`(`casa-id`, `medidor-id`, `data-medicao`,`data-referencia`, `medicao`) VALUES (idCasaParam, idMedidorParam, CONVERT_TZ(NOW(),'-03:00',@@global.time_zone), DATE_SUB(CONVERT_TZ(CURDATE(),'-03:00',@@global.time_zone),INTERVAL 1 MONTH), medicaoParam);
            ELSE
                INSERT INTO `medicoes`(`casa-id`, `medidor-id`, `data-medicao`,`data-referencia`, `medicao`, `medicao-anterior`) VALUES (idCasaParam, idMedidorParam, CONVERT_TZ(NOW(),'-03:00',@@global.time_zone), DATE_SUB(CONVERT_TZ(CURDATE(),'-03:00',@@global.time_zone),INTERVAL 1 MONTH), medicaoParam, @medicao);
            END IF;
            SELECT "ok" as 'return-value';
            COMMIT;
        END IF;
    END$$

DROP PROCEDURE IF EXISTS `usp_test_transaction`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `usp_test_transaction` ()  BEGIN
  DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;
  START TRANSACTION;

  -- whatever DML operations and SELECT statements you want to perform go here

  IF (1=1) THEN
    COMMIT;
  ELSE
    ROLLBACK;
  END IF;
END$$

DELIMITER ;

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
  `valor-maximo-hidrometro` int(11) NOT NULL,
  `dia-vencimento` varchar(2) NOT NULL,
  `cep` varchar(15) NOT NULL,
  `excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sacado-id` (`sacado-id`),
  KEY `cedente-id` (`cedente-id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `casas`
--

INSERT INTO `casas` (`id`, `sacado-id`, `cedente-id`, `numero`, `rua`, `bairro`, `cidade`, `UF`, `referencia`, `num-hidrometro`, `valor-maximo-hidrometro`, `dia-vencimento`, `cep`, `excluido`) VALUES
(2, 5, 7, '123', 'rua de nada', 'bairro asdasasdas', 'cidade itabuna', 'BA', 'casa', '123', 5000, '21', '45612322', 0),
(3, 5, 7, '123', 'dsffsdfas', 'asdfasdfa', 'sdfadsf', 'sd', 'asdfasdfasfd', 'asdf', 5000, '15', '54646546', 0),
(5, 11, 7, '239', 'potamiano', 'são caetano', 'itabuna', 'ba', 'prox. paty', '123456', 5000, '05', '45607-035', 0),
(6, 11, 7, 'ad', 'rua pestana', 'asd', 'asd', 'as', 'a', 'asd', 5000, '15', '12345-678', 0),
(60, 62, 7, '123', 'rua afsdiasd', 'bairrp asdasd ', 'qwe', 'qw', 'qwe', '123', 100, '12', '123123', 0),
(61, 62, 7, '123', 'qwe', 'qwe', 'qwe', 'qw', 'qwe', '13', 100, '23', '123', 0);

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
  `valor-minimo` double NOT NULL,
  `esgoto` float NOT NULL,
  `email` varchar(70) NOT NULL,
  `logo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cedentes`
--

INSERT INTO `cedentes` (`id`, `senha`, `nome`, `uso-banco`, `use-santander`, `cnpj`, `informacoes`, `contato`, `UF`, `cidade`, `bairro`, `rua`, `numero`, `cep`, `valor-por-metro-cubico`, `valor-minimo`, `esgoto`, `email`, `logo`) VALUES
(7, '123', 'Cedente 1', '123', 1, '00000000000001', 'adada', '0800 400 2135', 'BA', 'Itabuna', 'Centro', 'Adolfo Maron', '256', '45607-256', 3.5, 10, 45, 'higorbelemdeoliveira@hotmail.com', 'http://localhost/projeto-boletos-server/imgs/logos/logo-cedente-7.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cedentes-sacado`
--

DROP TABLE IF EXISTS `cedentes-sacado`;
CREATE TABLE IF NOT EXISTS `cedentes-sacado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id-cedente` int(11) NOT NULL,
  `id-sacado` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id-sacado` (`id-sacado`),
  KEY `id-cedente` (`id-cedente`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cedentes-sacado`
--

INSERT INTO `cedentes-sacado` (`id`, `id-cedente`, `id-sacado`) VALUES
(1, 7, 5),
(2, 7, 11),
(42, 7, 62);

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
  `codigo-empresa` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cedente-id` (`cedente-id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas`
--

INSERT INTO `contas` (`id`, `cedente-id`, `banco`, `cip`, `conta`, `convenio`, `modalidade`, `agencia`, `codigo-empresa`) VALUES
(1, 7, '341', '123', '123-1', '123', '123', '1111-1', '00000000000000000001'),
(2, 7, '341', '123', '321-1', '123123', '2312', '2222-2', '00000000000000000002'),
(3, 7, '001', '1123123', '12345678-1', '1231231', '123', '1234-1', '00000000000000000003'),
(4, 7, '237', '123123', '159-7', '123123', '123123', '1545-1', '00000000000000000004');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas-auxiliares`
--

DROP TABLE IF EXISTS `contas-auxiliares`;
CREATE TABLE IF NOT EXISTS `contas-auxiliares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cedente-id` int(11) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(20) NOT NULL,
  `tipo` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cedente-id` (`cedente-id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas-auxiliares`
--

INSERT INTO `contas-auxiliares` (`id`, `cedente-id`, `cpf`, `nome`, `senha`, `tipo`) VALUES
(1, 7, '00000000001', 'fulanin medidor', '123', 'medidor'),
(2, 7, '00000000002', 'cara da visualização', '123', 'visualizador');

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
  `medicao-anterior` int(11) NOT NULL DEFAULT '0',
  `data-referencia` date NOT NULL DEFAULT '2000-01-01',
  `boleto-gerado` tinyint(1) NOT NULL DEFAULT '0',
  `data-boleto-gerado` datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
  `carteira-selecionada` varchar(5) NOT NULL DEFAULT '-1',
  `conta-selecionada-index` int(11) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`),
  KEY `medidor-id` (`medidor-id`),
  KEY `casa-id` (`casa-id`),
  KEY `conta-selecionada-index` (`conta-selecionada-index`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `medicoes`
--

INSERT INTO `medicoes` (`id`, `casa-id`, `medidor-id`, `data-medicao`, `medicao`, `medicao-anterior`, `data-referencia`, `boleto-gerado`, `data-boleto-gerado`, `carteira-selecionada`, `conta-selecionada-index`) VALUES
(7, 2, 1, '2019-08-05 19:21:58', 3, 0, '2019-07-05', 1, '2019-08-05 19:23:04', '16', 3),
(8, 3, 1, '2019-08-05 19:22:03', 5, 0, '2019-07-05', 1, '2019-08-05 19:23:04', '16', 3),
(9, 5, 1, '2019-08-05 19:22:07', 10, 0, '2019-07-05', 1, '2019-08-05 19:23:04', '16', 3),
(10, 6, 1, '2019-08-05 19:22:12', 2, 0, '2019-07-05', 1, '2019-08-05 19:23:04', '16', 3),
(11, 60, 1, '2019-08-05 19:22:18', 7, 0, '2019-07-05', 1, '2019-08-05 19:23:04', '16', 3),
(12, 61, 1, '2019-08-05 19:22:23', 7, 0, '2019-07-05', 1, '2019-08-05 19:23:04', '16', 3),
(13, 5, 1, '2019-08-05 19:44:21', 10, 10, '2019-07-05', 1, '2019-08-05 19:44:32', '16', 3);

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `medicoes-remessa`
--

INSERT INTO `medicoes-remessa` (`id`, `medicoes-id`, `remessa-id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 2),
(4, 7, 3),
(5, 8, 3),
(6, 9, 3),
(7, 10, 3),
(8, 11, 3),
(9, 12, 3),
(10, 13, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `medidor`
--

DROP TABLE IF EXISTS `medidor`;
CREATE TABLE IF NOT EXISTS `medidor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cedente-id` int(11) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `cedente-id` (`cedente-id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `medidor`
--

INSERT INTO `medidor` (`id`, `cedente-id`, `cpf`, `nome`, `senha`) VALUES
(1, 7, '00000000001', 'Medidor fulano', '123');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `remessa`
--

INSERT INTO `remessa` (`id`, `data`, `arquivo-remessa`, `arquivo-retorno`, `enviado`, `data-envio`) VALUES
(1, '2019-08-01 22:58:58', '01REMESSA01COBRANCA       12341123456781000000CEDENTE 1                     001BANCODOBRASIL  1908010000055                      1231231                                                                                                                                                                                                                                                                  000001\r\n7020000000000000112341123456781123123111                       123123100000119080000       1230000000     160111908     15081900000000050750010000 05N010819000100000000000000000000000000000000000000000000000000000000000100007168074598HIGOR BELEM                             ASD, AD                                 ASD         12345678ASD                                                         000002\r\n9                                                                                                                                                                                                                                                                                                                                                                                                         000003\r\n', '', 0, '2000-01-01 00:00:00'),
(2, '2019-08-01 23:30:06', '01REMESSA01COBRANCA       12341123456781000000CEDENTE 1                     001BANCODOBRASIL  1908010000055                      1231231                                                                                                                                                                                                                                                                  000001\r\n7020000000000000112341123456781123123111                       123123100000219080000       1230000000     160121908     05081900000000050750010000 05N010819000100000000000000000000000000000000000000000000000000000000000100007168074598HIGOR BELEM                             POTAMIANO, 239                          SAO CAETANO 45607035ITABUNA                                                     000002\r\n7020000000000000112341123456781123123111                       123123100000319080000       1230000000     160131908     05081900000000005080010000 05N010819000100000000000000000000000000000000000000000000000000000000000100007168074598HIGOR BELEM                             POTAMIANO, 239                          SAO CAETANO 45607035ITABUNA                                                     000003\r\n9                                                                                                                                                                                                                                                                                                                                                                                                         000004\r\n', '', 0, '2000-01-01 00:00:00'),
(3, '2019-08-05 19:28:10', '01REMESSA01COBRANCA       12341123456781000000CEDENTE 1                     001BANCODOBRASIL  1908050000055                      1231231                                                                                                                                                                                                                                                                  000001\r\n7020000000000000112341123456781123123111                       123123100001019080000       1230000000     1601101908    15081900000000010150010000 05N050819000100000000000000000000000000000000000000000000000000000000000100007168074598HIGOR BELEM                             ASD, AD                                 ASD         12345678ASD                                                         000002\r\n7020000000000000112341123456781123123162                       123123100001119080000       1230000000     1601111908    12081900000000035520010000 05N050819000100000000000000000000000000000000000000000000000000000000000100000012312312FULANIN EDITO                           RUA AFSDIASD, 123                       BAIRRP ASDAS00123123QWE                                                         000003\r\n7020000000000000112341123456781123123162                       123123100001219080000       1230000000     1601121908    23081900000000035520010000 05N050819000100000000000000000000000000000000000000000000000000000000000100000012312312FULANIN EDITO                           QWE, 123                                QWE         00000123QWE                                                         000004\r\n702000000000000011234112345678112312315                        123123100000719080000       1230000000     160171908     21081900000000015220010000 05N050819000100000000000000000000000000000000000000000000000000000000000100007168074598THALLES                                 RUA DE NADA, 123                        BAIRRO ASDAS45612322CIDADE ITABUNA                                              000005\r\n702000000000000011234112345678112312315                        123123100000819080000       1230000000     160181908     15081900000000025380010000 05N050819000100000000000000000000000000000000000000000000000000000000000100007168074598THALLES                                 DSFFSDFAS, 123                          ASDFASDFA   54646546SDFADSF                                                     000006\r\n7020000000000000112341123456781123123111                       123123100000919080000       1230000000     160191908     05081900000000050750010000 05N050819000100000000000000000000000000000000000000000000000000000000000100007168074598HIGOR BELEM                             POTAMIANO, 239                          SAO CAETANO 45607035ITABUNA                                                     000007\r\n9                                                                                                                                                                                                                                                                                                                                                                                                         000008\r\n', '', 0, '2019-08-05 19:28:59'),
(4, '2019-08-05 19:44:36', '01REMESSA01COBRANCA       12341123456781000000CEDENTE 1                     001BANCODOBRASIL  1908050000055                      1231231                                                                                                                                                                                                                                                                  000001\r\n7020000000000000112341123456781123123111                       123123100001319080000       1230000000     1601131908    05081900000000000000010000 05N050819000100000000000000000000000000000000000000000000000000000000000100007168074598HIGOR BELEM                             POTAMIANO, 239                          SAO CAETANO 45607035ITABUNA                                                     000002\r\n9                                                                                                                                                                                                                                                                                                                                                                                                         000003\r\n', '', 0, '2000-01-01 00:00:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sacado`
--

INSERT INTO `sacado` (`id`, `nome`, `documento`, `avalista`, `avalista-documento`, `email`) VALUES
(5, 'Thalles', '07168074598', '123', '123', 'higorbelemdeoliveira@gmail.com'),
(11, 'higor belem', '071.680.745-98', 'asdasd', 'adad', 'higorbelemdeoliveira@hotmail.com'),
(62, 'fulanin edito', '12312312', '0', '0', 'fuanin@nada');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `visualizadores`
--

INSERT INTO `visualizadores` (`id`, `cedente-id`, `cpf`, `nome`, `senha`) VALUES
(1, 7, '12312', 'asdas', 'asdas');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
