/*
Navicat MySQL Data Transfer

Source Server         : @localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : metacoffe

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-03-30 18:59:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for amostras
-- ----------------------------
DROP TABLE IF EXISTS `amostras`;
CREATE TABLE `amostras` (
  `amostra_id` int(11) NOT NULL AUTO_INCREMENT,
  `n_lote` bigint(15) DEFAULT NULL,
  `qtde_sacas` bigint(15) DEFAULT NULL,
  `bebida` varchar(255) DEFAULT NULL,
  `aspecto` varchar(255) DEFAULT NULL,
  `quebra_f13_cata` bigint(15) DEFAULT NULL,
  `defeitos` int(15) DEFAULT NULL,
  `regiao` varchar(255) DEFAULT NULL,
  `safra` varchar(255) DEFAULT NULL,
  `porc_umidade` int(5) DEFAULT NULL,
  `impurezas` int(15) DEFAULT NULL,
  `gpi` int(15) DEFAULT NULL,
  `aproveitamento` decimal(5,2) DEFAULT NULL,
  `f10` int(5) DEFAULT NULL,
  `pva` int(5) DEFAULT NULL,
  `peneiras` int(5) DEFAULT NULL,
  `17_acima` int(5) DEFAULT NULL,
  `13_abaixo` int(5) DEFAULT NULL,
  `14_15_16` int(5) DEFAULT NULL,
  `observacao` text,
  `pessoa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `data` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`amostra_id`),
  KEY `pessoa_id` (`pessoa_id`),
  CONSTRAINT `amostras_ibfk_1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoas` (`pessoa_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of amostras
-- ----------------------------
INSERT INTO `amostras` VALUES ('6', '111', '222', '333', '444', '555', '888', 'Sul de minas', '777', '666', '999', '10', '12.12', '13', '14', '15', '16', '17', '18', '', null, '1', '2017-03-28 15:45:11');

-- ----------------------------
-- Table structure for amostras_imagens
-- ----------------------------
DROP TABLE IF EXISTS `amostras_imagens`;
CREATE TABLE `amostras_imagens` (
  `amostra_imagem_id` int(11) NOT NULL AUTO_INCREMENT,
  `foto` varchar(255) DEFAULT NULL,
  `mimetype` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `amostra_id` int(11) DEFAULT NULL,
  `ordem` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `data` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`amostra_imagem_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of amostras_imagens
-- ----------------------------
INSERT INTO `amostras_imagens` VALUES ('15', '4.jpg', null, null, '6', '1', '1', '2017-03-30 17:33:39');
INSERT INTO `amostras_imagens` VALUES ('16', '150-no-Brasil.jpg', null, null, '6', '2', '1', '2017-03-30 17:34:25');
INSERT INTO `amostras_imagens` VALUES ('17', 'Ground-Coffee-Step-1.jpg', null, null, '6', '3', '1', '2017-03-30 17:35:40');
INSERT INTO `amostras_imagens` VALUES ('18', '1438962147988-cafe-grao.jpg', null, null, '6', '4', '1', '2017-03-30 17:36:24');
INSERT INTO `amostras_imagens` VALUES ('19', 'curiosidades-do-cafe.jpg', null, null, '6', '5', '1', '2017-03-30 17:39:24');

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
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`pessoa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pessoas
-- ----------------------------
INSERT INTO `pessoas` VALUES ('1', 'andre', '85849d421ba0b633ccb5da95a2d3ba6497a16a5d', null, null, null, '1', '1');
INSERT INTO `pessoas` VALUES ('3', 'jose', '458e0ba9ec9d1f9ae4588f60fca1c670c77da0ab', null, null, null, '1', '1');
INSERT INTO `pessoas` VALUES ('10', 'Kah', 'a083e3e5c9f5489e1e06394fb6573e157c97804a', null, null, '1', '1', '1');

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
  `usuario_id` int(11) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`informacao_id`),
  KEY `users_id` (`pessoa_id`),
  CONSTRAINT `pessoas_informacao_ibfk_1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoas` (`pessoa_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pessoas_informacao
-- ----------------------------
INSERT INTO `pessoas_informacao` VALUES ('1', 'F', 'André Aquiles Miareli', null, '', '047.587.666-06', null, '1979-07-25', null, null, null, 'aquiles.android@gmail.com', null, null, null, null, 'a:9:{s:3:\"rua\";s:15:\"Rua Via Láctea\";s:6:\"numero\";s:2:\"40\";s:11:\"complemento\";b:0;s:6:\"bairro\";s:19:\"Jardim das estrelas\";s:6:\"cidade\";s:6:\"Passos\";s:6:\"estado\";s:2:\"MG\";s:3:\"cep\";s:9:\"37904-046\";s:13:\"telefone_fixo\";s:10:\"3535218302\";s:16:\"telefone_celular\";s:15:\"(35) 99705-1442\";}', '', '1', '1', '2017-03-24 14:01:14');
INSERT INTO `pessoas_informacao` VALUES ('5', 'F', 'José da Silva', null, '', '054.154.958-78', null, '1980-07-25', null, null, null, 'jose@gmail.com', null, null, null, null, 'a:9:{s:3:\"rua\";b:0;s:6:\"numero\";b:0;s:11:\"complemento\";b:0;s:6:\"bairro\";b:0;s:6:\"cidade\";b:0;s:6:\"estado\";b:0;s:3:\"cep\";b:0;s:13:\"telefone_fixo\";N;s:16:\"telefone_celular\";N;}', '', '3', '1', '2017-03-25 14:17:16');
INSERT INTO `pessoas_informacao` VALUES ('6', 'F', 'Lucas Silveira Tavares', null, '11153491', '012.374.236-60', null, '1982-10-08', null, null, null, 'lucasalimentos@yahoo.com.br', null, null, null, null, 'a:9:{s:3:\"rua\";b:0;s:6:\"numero\";b:0;s:11:\"complemento\";b:0;s:6:\"bairro\";b:0;s:6:\"cidade\";b:0;s:6:\"estado\";b:0;s:3:\"cep\";b:0;s:13:\"telefone_fixo\";b:0;s:16:\"telefone_celular\";b:0;}', '', '10', '1', '2017-03-27 19:38:28');

-- ----------------------------
-- Table structure for regiao
-- ----------------------------
DROP TABLE IF EXISTS `regiao`;
CREATE TABLE `regiao` (
  `regiao_id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`regiao_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of regiao
-- ----------------------------
INSERT INTO `regiao` VALUES ('1', 'Sul de minas', '1');
INSERT INTO `regiao` VALUES ('2', 'Cerrado de Minas', '1');
INSERT INTO `regiao` VALUES ('3', 'Chapada de Minas', '1');
INSERT INTO `regiao` VALUES ('4', 'Mogiana', '1');
INSERT INTO `regiao` VALUES ('5', 'Centro Oeste de S.P', '1');
INSERT INTO `regiao` VALUES ('6', 'Montanhas do E.S', '1');
INSERT INTO `regiao` VALUES ('7', 'Conilon Capixaba', '1');
INSERT INTO `regiao` VALUES ('8', 'Norte Pioneiro do P.R', '1');
INSERT INTO `regiao` VALUES ('9', 'Planalto da Bahia', '1');
INSERT INTO `regiao` VALUES ('10', 'Cerrado da Bahia', '1');
INSERT INTO `regiao` VALUES ('11', 'Rondônia', '1');

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
