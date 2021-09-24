/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP DATABASE IF EXISTS `crud_mvc_smartteam`;
CREATE DATABASE IF NOT EXISTS `crud_mvc_smartteam` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `crud_mvc_smartteam`;

DROP TABLE IF EXISTS `dividas`;
CREATE TABLE IF NOT EXISTS `dividas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `valor` decimal(20,2) NOT NULL,
  `data_vencimento` date NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `titulo` (`titulo`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

DELETE FROM `dividas`;
/*!40000 ALTER TABLE `dividas` DISABLE KEYS */;
/*!40000 ALTER TABLE `dividas` ENABLE KEYS */;

DROP TABLE IF EXISTS `enderecos`;
CREATE TABLE IF NOT EXISTS `enderecos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `logradouro` text NOT NULL,
  `numero_endereco` varchar(100) NOT NULL,
  `complemento_endereco` mediumtext,
  `bairro` text NOT NULL,
  `cidade` text NOT NULL,
  `uf` varchar(2) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `id_usuario` (`usuario_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

DELETE FROM `enderecos`;
/*!40000 ALTER TABLE `enderecos` DISABLE KEYS */;
/*!40000 ALTER TABLE `enderecos` ENABLE KEYS */;

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cpf_cnpj` bigint(20) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `data_nascimento` date NOT NULL,
  `senha` text NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf_cnpj_unique` (`cpf_cnpj`),
  UNIQUE KEY `email_unique` (`email`),
  KEY `email` (`email`),
  KEY `cpf_cnpj` (`cpf_cnpj`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

DELETE FROM `usuarios`;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id`, `cpf_cnpj`, `nome`, `email`, `data_nascimento`, `senha`, `ativo`) VALUES
	(1, 99999999999, 'Novo usuário', 'teste@teste.com.br', '2021-09-23', 'a94dfa704f108e7feefd4635060202c9', 1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
