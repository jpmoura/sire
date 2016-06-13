-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: bdreserva
-- ------------------------------------------------------
-- Server version	5.5.49-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tb_alocacao`
--

DROP TABLE IF EXISTS `tb_alocacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_alocacao` (
  `aloId` int(11) NOT NULL AUTO_INCREMENT,
  `usuId` int(11) NOT NULL,
  `equId` int(11) NOT NULL,
  `aloData` varchar(10) NOT NULL,
  `aloAula` varchar(10) NOT NULL,
  PRIMARY KEY (`aloId`),
  KEY `usuId` (`usuId`),
  KEY `equId` (`equId`),
  CONSTRAINT `tb_alocacao_ibfk_3` FOREIGN KEY (`usuId`) REFERENCES `tb_usuario` (`usuId`),
  CONSTRAINT `tb_alocacao_ibfk_4` FOREIGN KEY (`equId`) REFERENCES `tb_equipamento` (`equId`)
) ENGINE=InnoDB AUTO_INCREMENT=13258 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_equipamento`
--

DROP TABLE IF EXISTS `tb_equipamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_equipamento` (
  `equId` int(11) NOT NULL AUTO_INCREMENT,
  `tipoId` int(11) NOT NULL,
  `equNome` varchar(50) NOT NULL,
  `equDescricao` varchar(100) NOT NULL,
  `equStatus` tinytext NOT NULL,
  PRIMARY KEY (`equId`),
  KEY `tipoId` (`tipoId`),
  CONSTRAINT `tb_equipamento_ibfk_1` FOREIGN KEY (`tipoId`) REFERENCES `tb_tipo` (`tipoId`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_horario`
--

DROP TABLE IF EXISTS `tb_horario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_horario` (
  `horId` tinyint(4) NOT NULL AUTO_INCREMENT,
  `horNumAulaManha` int(11) NOT NULL,
  `horNumAulaTarde` int(11) NOT NULL,
  `horNumAulaNoite` int(11) NOT NULL,
  `horNumDias` int(11) NOT NULL,
  PRIMARY KEY (`horId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_tipo`
--

DROP TABLE IF EXISTS `tb_tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_tipo` (
  `tipoId` int(11) NOT NULL,
  `tipoNome` varchar(20) NOT NULL,
  PRIMARY KEY (`tipoId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_usuario`
--

DROP TABLE IF EXISTS `tb_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_usuario` (
  `usuId` int(11) NOT NULL AUTO_INCREMENT,
  `usuNome` varchar(50) NOT NULL,
  `usuTelefone` varchar(15) DEFAULT NULL,
  `usuCelular` varchar(15) DEFAULT NULL,
  `usuLogin` varchar(20) NOT NULL,
  `usuSenha` varchar(40) NOT NULL,
  `usuEmail` varchar(50) DEFAULT NULL,
  `usuNivel` tinyint(11) NOT NULL,
  PRIMARY KEY (`usuId`)
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-12 23:23:26
