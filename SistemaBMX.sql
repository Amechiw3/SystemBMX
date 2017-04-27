-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: sistemabici
-- ------------------------------------------------------
-- Server version	5.7.14

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
-- Table structure for table `bitacora`
--
CREATE Database sistemabici;
USE sistemabici;

DROP TABLE IF EXISTS `bitacora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bitacora` (
  `idbitacora` bigint(20) NOT NULL AUTO_INCREMENT,
  `idventa` bigint(20) NOT NULL,
  `total` double(15,2) NOT NULL,
  `nuevo` double(15,2) NOT NULL,
  `estado` varchar(5) NOT NULL,
  PRIMARY KEY (`idbitacora`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bitacora`
--

LOCK TABLES `bitacora` WRITE;
/*!40000 ALTER TABLE `bitacora` DISABLE KEYS */;
/*!40000 ALTER TABLE `bitacora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catproductos`
--

DROP TABLE IF EXISTS `catproductos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catproductos` (
  `idcatproducto` bigint(20) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(12) NOT NULL DEFAULT '',
  `estado` enum('Desactivado','Activado') NOT NULL DEFAULT 'Activado',
  PRIMARY KEY (`idcatproducto`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catproductos`
--

LOCK TABLES `catproductos` WRITE;
/*!40000 ALTER TABLE `catproductos` DISABLE KEYS */;
INSERT INTO `catproductos` VALUES (1,'Bielas','Activado'),(2,'Bujes del','Activado'),(3,'Bujes tras','Activado'),(4,'Bujes Free','Activado'),(5,'Cadenas','Activado'),(6,'Cuadros','Activado'),(7,'Cubiertas','Activado'),(8,'Camara','Activado'),(9,'Direcciones','Activado'),(10,'Ejes','Activado'),(11,'Frenos','Activado'),(12,'Horquillas','Activado'),(13,'Llantas','Activado'),(14,'Manillares','Activado'),(15,'Pedales','Activado'),(16,'Pegs','Activado'),(17,'Platos','Activado'),(18,'Potencias','Activado'),(19,'Ruedas','Activado'),(20,'Asiento','Activado');
/*!40000 ALTER TABLE `catproductos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detventas`
--

DROP TABLE IF EXISTS `detventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detventas` (
  `iddetventa` bigint(20) NOT NULL AUTO_INCREMENT,
  `idventa` bigint(20) NOT NULL,
  `idproducto` bigint(20) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` enum('Desactivado','Activado') NOT NULL DEFAULT 'Activado',
  PRIMARY KEY (`iddetventa`),
  KEY `idventa` (`idventa`),
  KEY `idproducto` (`idproducto`),
  CONSTRAINT `detventas_ibfk_1` FOREIGN KEY (`idventa`) REFERENCES `ventas` (`idventa`),
  CONSTRAINT `detventas_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detventas`
--

LOCK TABLES `detventas` WRITE;
/*!40000 ALTER TABLE `detventas` DISABLE KEYS */;
INSERT INTO `detventas` VALUES (1,1,2,2,'Activado'),(2,1,5,1,'Activado'),(3,2,3,1,'Activado'),(4,2,9,1,'Activado'),(5,3,10,1,'Activado'),(6,4,5,2,'Activado'),(7,5,5,13,'Activado');
/*!40000 ALTER TABLE `detventas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `idproducto` bigint(20) NOT NULL AUTO_INCREMENT,
  `producto` varchar(48) NOT NULL,
  `descripcion` varchar(128) NOT NULL,
  `imagen` varchar(32) NOT NULL,
  `precio` double(15,2) NOT NULL,
  `idcatproducto` bigint(20) NOT NULL,
  `estado` enum('Activo','Desactivado') NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idproducto`),
  KEY `idcatproducto` (`idcatproducto`),
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`idcatproducto`) REFERENCES `catproductos` (`idcatproducto`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Barca Canyella','PESO: 0.985 kg\r\nMEDIDA: 175mm\r\nEJE: 0.19mm\r\nCOLOR: Negro','291.png',740.95,1,'Activo'),(2,'Pirate Huesos','PESO: 0.948 kg\r\nMEDIDA: 175mm\r\nEJE: 0.22mm\r\nCOLOR: Negro','271.png',1240.95,1,'Activo'),(3,'Bielas clat Spire','COLOR:  Negro, Cromado \r\n\r\nDETALLE: 175mm, eje 22mm, 910g','292.png',1730.95,1,'Activo'),(4,'Barca Virrei','\r\nPESO: 0.257 kg\r\nCOLOR: Negro','293.png',320.95,2,'Activo'),(5,'Salt Pro','PESO: 0.299 kg\r\nEJE: Macho\r\nPESO: 299gr\r\nRODAMIENTOS: Selados\r\nCOLOR: Azul, Negro, Cromado, Rojo','294.png',490.95,2,'Activo'),(6,'BSD Front Street','Es el buje front street de bsd mejorado. Con una carcasa mas gruesa, con eje reforzado y conos de cromoly.','295.png',840.95,2,'Activo'),(7,'Buje Trasero Odyssey','Buje 48 radios.\r\nPiñón de 9t','296.png',650.00,3,'Activo'),(8,'Federal Freecoaster','Gap ajustable sin desmontarlo\r\nDisponible con driver de 9t y de 10t\r\nEje hueco de 14mm cro-mo','297.png',1940.95,3,'Activo'),(9,'BSD cassette Back Street','Con driver de 9t.\r\nRodamientos sellados.\r\nEje hueco de 14mm, hecho de cro-mo','298.png',1750.00,3,'Activo'),(10,'Eclat Blind','PESO: 0.590 kg\r\nCOLOR: Negro\r\nGÉNERO: Macho, Hembra\r\nREVERSIBLE: Sí\r\nDIENTES: 9','299.png',1790.95,4,'Activo'),(11,'WeThePeople Helix','\r\nPESO: 0.640 kg\r\nCOLOR: Negro\r\nORIENTACIÓN: Derecha, Izquierda\r\nDIENTES: 9','300.png',1590.95,4,'Activo'),(12,'Trebol Bueno','Buje Freecoaster del marca Trebol\r\n\r\nPiñón de 9 dientes','301.png',1440.95,4,'Activo'),(13,'Yaban Mk 918','COLOR: Negro, Lila Anonizado, Rosa, Naranja Anonizado, Rojo, Verde, Azul','302.png',220.00,5,'Activo'),(14,'Pirate Cadenas','\r\nCOLOR: Plateado','303.png',240.95,5,'Activo'),(15,'FlFlyBikes Tractor','COLOR: Negro / Plata','304.png',280.95,5,'Activo'),(16,'Cult cuadro Butter V2','	\r\nSegunda versión del cuadro del mítico Chase Dehart\r\nInvestment cast bridge\r\nEspacio suficiente para cubiertas anchas','305.png',3500.00,6,'Activo'),(17,'WeThePeople Clash 2015','Colores: Negro titán | Negro acido | Azul translúcido | Verde translúcido | Raw','306.png',3590.95,6,'Activo'),(18,'Federal cuadro Bruno','	\r\nEl cuadro de Bruno Hoffmann.\r\nPosiblemente uno de los cuadros mas callejeros y actuales de hoy en día.','307.png',3790.95,6,'Activo'),(19,'Salt Slick','COLOR: Azul, Beige, Blanco, Crema-Negro, Naranja, Negro, Rojo, Verde, Blanco-Negro','308.png',250.95,7,'Activo'),(20,'Éclat Fireball','COLOR:  Negro, Verde, Lila, Goma ','309.png',350.95,7,'Activo'),(21,'Cubiertas Flybikes Rampera','PESO: 0.620 kg, 0.750 kg\r\nMEDIDA: 2,15, 2,35','310.png',340.95,7,'Activo'),(22,'Pirate Brujula','DirecciÃ³n Integrada BrÃºjula.\r\nDiseÃ±o simple y funcional.','311.png',280.95,9,'Activo'),(23,'Salt AM','COLOR:Negro\r\nPRODUCTO: DirecciÃ³n de bolas','489951.png',130.95,9,'Activo'),(24,'WeThePeople Compact','PESO: 104gr\r\nPRODUCTO: Espaciadores 3, 5, 8 y 10mm','663149.png',330.95,9,'Activo'),(25,'Ejes','ATRIBUTOS\r\n8 estrias / 0.19mm, 48 estrias / 0.19mm, Cuadrado / 0.22mm','365747.png',360.95,10,'Activo');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `idusuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `nomusuario` varchar(12) NOT NULL DEFAULT '' COMMENT 'Nombre del usuario',
  `appusuario` varchar(12) NOT NULL COMMENT 'Apellido Paterno del usuario',
  `apmusuario` varchar(12) NOT NULL COMMENT 'Apellido Materno del usuario',
  `usuario` varchar(16) NOT NULL COMMENT 'Usuario usado para login',
  `password` varchar(128) NOT NULL COMMENT 'contraseña usada para login',
  `email` varchar(128) NOT NULL,
  `catusuario` enum('Administrador','Empleado','Cliente') NOT NULL DEFAULT 'Cliente' COMMENT 'categoria (nivel de acceso) para el usuario',
  `idioma` enum('Espanol','English') CHARACTER SET utf8 NOT NULL,
  `estado` enum('Activado','Desactivado') NOT NULL DEFAULT 'Activado',
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Martin','Fierro','Robles','martin','4297f44b13955235245b2497399d7a93','martinfierro97@hotmail.com','Administrador','Espanol','Activado'),(2,'Evelin','Acevedo','Martinez','evelin','3d186804534370c3c817db0563f0e461','evelin_fda@hotmail.com','Administrador','Espanol','Activado'),(3,'Jose Carlos','Dorame','Franco','carlos','4297f44b13955235245b2497399d7a93','carlosdorame@hotmail.com','Administrador','Espanol','Activado'),(4,'Ximena','Torres','Fierro','AnnaBell','7815696ecbf1c96e6894b779456d330e','ximenatorre@hotmail.com','Administrador','English','Activado');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ventas` (
  `idventa` bigint(20) NOT NULL AUTO_INCREMENT,
  `idusuario` bigint(20) NOT NULL,
  `fechaventa` date NOT NULL,
  `totalventa` decimal(15,2) NOT NULL,
  `estado` enum('Activado','Desactivado') NOT NULL DEFAULT 'Activado',
  PRIMARY KEY (`idventa`),
  KEY `idusuario` (`idusuario`),
  CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` VALUES (1,1,'2017-02-12',2972.85,'Activado'),(2,2,'2017-02-11',1970.00,'Activado'),(3,2,'2017-02-17',1790.95,'Activado'),(4,4,'2017-02-01',7181.90,'Activado'),(5,4,'2017-02-23',1510.00,'Activado');
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-24 10:23:01
