/*
Navicat MySQL Data Transfer

Source Server         : @localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : metacoffe

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-03-28 08:29:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for amostras
-- ----------------------------
DROP TABLE IF EXISTS `amostras`;
CREATE TABLE `amostras` (
  `amostra_id` int(11) NOT NULL AUTO_INCREMENT,
  `n_lote` varchar(255) DEFAULT NULL,
  `qtde_sacas` int(11) DEFAULT NULL,
  `bebida` varchar(255) DEFAULT NULL,
  `aspecto` varchar(255) DEFAULT NULL,
  `quebra_f13_cata` varchar(255) DEFAULT NULL,
  `defeitos` text,
  `regiao` varchar(255) DEFAULT NULL,
  `safra` varchar(255) DEFAULT NULL,
  `porc_umidade` int(255) DEFAULT NULL,
  `impurezas` text,
  `gpi` varchar(255) DEFAULT NULL,
  `aproveitamento` varchar(255) DEFAULT NULL,
  `f10` varchar(255) DEFAULT NULL,
  `pva` varchar(255) DEFAULT NULL,
  `peneiras` varchar(255) DEFAULT NULL,
  `17_acima` varchar(255) DEFAULT NULL,
  `13_abaixo` varchar(255) DEFAULT NULL,
  `14_15_16` varchar(255) DEFAULT NULL,
  `observacao` text,
  `pessoa_id` int(11) DEFAULT NULL,
  `data` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`amostra_id`),
  KEY `pessoa_id` (`pessoa_id`),
  CONSTRAINT `amostras_ibfk_1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoas` (`pessoa_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of amostras
-- ----------------------------

-- ----------------------------
-- Table structure for amostras_fotos
-- ----------------------------
DROP TABLE IF EXISTS `amostras_fotos`;
CREATE TABLE `amostras_fotos` (
  `amostras_fotos_id` int(11) NOT NULL AUTO_INCREMENT,
  `foto` varchar(255) DEFAULT NULL,
  `amostra_id` int(11) DEFAULT NULL,
  `data` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`amostras_fotos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of amostras_fotos
-- ----------------------------

-- ----------------------------
-- Table structure for pessoas
-- ----------------------------
DROP TABLE IF EXISTS `pessoas`;
CREATE TABLE `pessoas` (
  `pessoa_id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(55) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `bloqueado` int(1) DEFAULT NULL,
  `vender` tinyint(1) DEFAULT NULL,
  `comprar` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`pessoa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pessoas
-- ----------------------------
INSERT INTO `pessoas` VALUES ('1', 'andre', '85849d421ba0b633ccb5da95a2d3ba6497a16a5d', null, null, '1', '1');
INSERT INTO `pessoas` VALUES ('3', 'jose', '458e0ba9ec9d1f9ae4588f60fca1c670c77da0ab', null, null, null, '1');
INSERT INTO `pessoas` VALUES ('10', 'Kah', 'a083e3e5c9f5489e1e06394fb6573e157c97804a', null, null, null, '1');

-- ----------------------------
-- Table structure for pessoas_informacao
-- ----------------------------
DROP TABLE IF EXISTS `pessoas_informacao`;
CREATE TABLE `pessoas_informacao` (
  `informacao_id` int(11) NOT NULL AUTO_INCREMENT,
  `tpPessoa` enum('F','J') DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `razao_social` varchar(255) DEFAULT NULL,
  `rg` varchar(255) DEFAULT NULL,
  `cpf` varchar(50) DEFAULT NULL,
  `cnpj` varchar(60) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `data_fundacao` date DEFAULT NULL,
  `inscricao_estadual` varchar(40) DEFAULT NULL,
  `inscricao_municipal` varchar(40) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefone_fixo` varchar(255) DEFAULT NULL,
  `telefone_celular` varchar(255) DEFAULT NULL,
  `skype` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `endereco` text,
  `observacao` text,
  `pessoa_id` int(11) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`informacao_id`),
  KEY `users_id` (`pessoa_id`),
  CONSTRAINT `pessoas_informacao_ibfk_1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoas` (`pessoa_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pessoas_informacao
-- ----------------------------
INSERT INTO `pessoas_informacao` VALUES ('1', 'F', 'André Aquiles Miareli', null, '', '047.587.666-06', null, '1979-07-25', null, null, null, 'aquiles.android@gmail.com', null, null, null, null, 'a:9:{s:3:\"rua\";s:15:\"Rua Via Láctea\";s:6:\"numero\";s:2:\"40\";s:11:\"complemento\";b:0;s:6:\"bairro\";s:19:\"Jardim das estrelas\";s:6:\"cidade\";s:6:\"Passos\";s:6:\"estado\";s:2:\"MG\";s:3:\"cep\";s:9:\"37904-046\";s:13:\"telefone_fixo\";s:10:\"3535218302\";s:16:\"telefone_celular\";s:15:\"(35) 99705-1442\";}', '', '1', '2017-03-24 14:01:14');
INSERT INTO `pessoas_informacao` VALUES ('5', 'F', 'José da Silva', null, '', '054.154.958-78', null, '1980-07-25', null, null, null, 'jose@gmail.com', null, null, null, null, 'a:9:{s:3:\"rua\";b:0;s:6:\"numero\";b:0;s:11:\"complemento\";b:0;s:6:\"bairro\";b:0;s:6:\"cidade\";b:0;s:6:\"estado\";b:0;s:3:\"cep\";b:0;s:13:\"telefone_fixo\";N;s:16:\"telefone_celular\";N;}', '', '3', '2017-03-25 14:17:16');
INSERT INTO `pessoas_informacao` VALUES ('6', 'F', 'Lucas Silveira Tavares', null, '11153491', '012.374.236-60', null, '1982-10-08', null, null, null, 'lucasalimentos@yahoo.com.br', null, null, null, null, 'a:9:{s:3:\"rua\";b:0;s:6:\"numero\";b:0;s:11:\"complemento\";b:0;s:6:\"bairro\";b:0;s:6:\"cidade\";b:0;s:6:\"estado\";b:0;s:3:\"cep\";b:0;s:13:\"telefone_fixo\";b:0;s:16:\"telefone_celular\";b:0;}', '', '10', '2017-03-27 19:38:28');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `admin` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('1', 'admin@admin.com', '10470c3b4b1fed12c3baac014be15fac67c6e815', '1');
