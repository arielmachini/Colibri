DROP DATABASE IF EXISTS `bdUsuarios`;

CREATE DATABASE `bdUsuarios`
	CHARACTER SET utf8
	COLLATE utf8_general_ci;

USE `bdUsuarios`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permiso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ID_PERMISO_IND` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `permiso` WRITE;
/*!40000 ALTER TABLE `permiso` DISABLE KEYS */;
INSERT INTO `permiso` VALUES (7,'Usuarios'),(8,'Roles'),(9,'Permisos'),(11,'Salir'),(12,'Ingresar');
/*!40000 ALTER TABLE `permiso` ENABLE KEYS */;
UNLOCK TABLES;

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ID_ROL_IND` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (7,'Usuario registrado'),(8,'Administrador');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol_permiso` (
  `id_rol` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL,
  PRIMARY KEY (`id_rol`,`id_permiso`),
  UNIQUE KEY `ID_ROL_PERMISO_IND` (`id_permiso`,`id_rol`),
  KEY `FKASO_ROL_IND` (`id_rol`),
  KEY `FKASO_PER_idx` (`id_permiso`),
  CONSTRAINT `fk_rol_permiso_permiso` FOREIGN KEY (`id_permiso`) REFERENCES `permiso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rol_permiso_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `rol_permiso` WRITE;
/*!40000 ALTER TABLE `rol_permiso` DISABLE KEYS */;
INSERT INTO `rol_permiso` VALUES (7,7),(7,11),(8,7),(8,8),(8,9),(8,11);
/*!40000 ALTER TABLE `rol_permiso` ENABLE KEYS */;
UNLOCK TABLES;

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UN_USUARIO` (`email`,`nombre`),
  UNIQUE KEY `ID_USUARIO_IND` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_rol` (
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_rol`),
  UNIQUE KEY `ID_USUARIO_ROL_IND` (`id_rol`,`id_usuario`),
  KEY `FKVIN_USU_IND` (`id_usuario`),
  KEY `FKVIN_ROL_idx` (`id_rol`),
  CONSTRAINT `fk_usuario_rol_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_rol_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;