/*
Navicat MySQL Data Transfer

Source Server         : XAMPP
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : do_es

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2013-05-02 14:09:59
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `banip`
-- ----------------------------
DROP TABLE IF EXISTS `banip`;
CREATE TABLE `banip` (
  `ip` varchar(50) NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of banip
-- ----------------------------

-- ----------------------------
-- Table structure for `clanes`
-- ----------------------------
DROP TABLE IF EXISTS `clanes`;
CREATE TABLE `clanes` (
  `clanID` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tagNombre` varchar(255) NOT NULL,
  PRIMARY KEY (`clanID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of clanes
-- ----------------------------

-- ----------------------------
-- Table structure for `cuentas`
-- ----------------------------
DROP TABLE IF EXISTS `cuentas`;
CREATE TABLE `cuentas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(20) CHARACTER SET utf8 NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `servidor` int(2) NOT NULL DEFAULT '1',
  `fecha_nacimiento` varchar(50) CHARACTER SET utf8 NOT NULL,
  `pais` varchar(50) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Brasil',
  `empresa` varchar(5) CHARACTER SET utf8 NOT NULL COMMENT 'VRU,EIC,MMO',
  `premium` int(1) NOT NULL DEFAULT '1' COMMENT '0: No, Premium | 1: Si, Premium',
  `fecha_creacion` varchar(50) CHARACTER SET utf8 NOT NULL,
  `experiencia` bigint(255) NOT NULL DEFAULT '0',
  `nivel` int(11) NOT NULL DEFAULT '1',
  `jackpot` double(50,2) NOT NULL DEFAULT '0.00',
  `creditos` bigint(255) NOT NULL DEFAULT '2500000',
  `uridium` bigint(255) NOT NULL DEFAULT '500000',
  `energia_extra` int(50) NOT NULL DEFAULT '0',
  `nave` int(11) NOT NULL DEFAULT '1',
  `gfx` int(11) NOT NULL DEFAULT '1',
  `vants` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '3/3-25-25-25,3/4-25-25-25-25,3/3-25-25-25',
  `skylab` int(50) NOT NULL DEFAULT '-1',
  `tecnofabrica` int(50) NOT NULL DEFAULT '-1',
  `ciudad` varchar(50) CHARACTER SET utf8 NOT NULL,
  `edad` int(11) NOT NULL,
  `sexo` int(2) NOT NULL DEFAULT '0' COMMENT '0: Masculino | 1: Femenino',
  `intereses` varchar(20) CHARACTER SET utf8 NOT NULL,
  `mensaje_estado` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ficheros` int(50) NOT NULL DEFAULT '0',
  `pi` int(50) NOT NULL DEFAULT '0',
  `habilidades` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '-1',
  `clan` int(11) NOT NULL DEFAULT '0',
  `estado` int(11) NOT NULL DEFAULT '0' COMMENT '0: Desconectado | 1: Conectado',
  `acceso` int(11) NOT NULL DEFAULT '0' COMMENT '0: Usuario normal | 1: Moderador | 2: Super Moderador | 3: Administrador',
  `rango` int(11) NOT NULL DEFAULT '1' COMMENT '1: Piloto espacial bÃ¡sico',
  `honor` bigint(255) NOT NULL DEFAULT '0',
  `bono_reparacion` int(11) NOT NULL DEFAULT '0',
  `bono_teleportacion` int(11) NOT NULL DEFAULT '0',
  `llaves` int(11) NOT NULL DEFAULT '0',
  `puertas_alfa` int(11) NOT NULL DEFAULT '0',
  `puertas_beta` int(11) NOT NULL DEFAULT '0',
  `puertas_delta` int(11) NOT NULL DEFAULT '0',
  `puertas_omega` int(11) NOT NULL DEFAULT '0',
  `mapa` int(11) NOT NULL DEFAULT '1' COMMENT 'mapID',
  `pos` varchar(11) CHARACTER SET utf8 NOT NULL DEFAULT '0|0',
  `hp` bigint(255) NOT NULL DEFAULT '4000',
  `hpMax` bigint(255) NOT NULL DEFAULT '4000',
  `escudo` bigint(255) NOT NULL DEFAULT '0',
  `escudoMax` bigint(255) NOT NULL DEFAULT '0',
  `vel` int(11) NOT NULL DEFAULT '320',
  `carga` bigint(255) NOT NULL DEFAULT '100',
  `cargaMax` bigint(255) NOT NULL DEFAULT '100',
  `config` int(11) NOT NULL DEFAULT '1',
  `configs` varchar(50) COLLATE utf8_spanish_ci NOT NULL DEFAULT '1|2',
  `slot4` varchar(999) CHARACTER SET utf8 NOT NULL DEFAULT '-1' COMMENT 'Slot para el Lanzamisiles. ej: <id_lanzamisil>,<estado> (0:Desac|1:Activado)',
  `mun1` varchar(999) CHARACTER SET utf8 NOT NULL DEFAULT '5000|2000|500|200|500|100' COMMENT 'LCB-10(x1)|MCB-25(x2)|MCB-50(x3)|UCB-100(x4)|SAB-50(roba escudo)|RSB-75(x5)',
  `mun2` varchar(999) CHARACTER SET utf8 NOT NULL DEFAULT '1000|500|500|250|25|25|25|15|15|15|15|15|15|15' COMMENT 'R-310|PLT-2026|PLT-2021|PLT-3030|PLD-8|DCR-250|WIZ-X|ACM-01|SMB-01|ISH-01|EMP-01|EMPM-01|SABM-01|DDM-01',
  `mun3` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '0;0|0|0;0|0|0' COMMENT 'Lanzamisil seleccionado. ej: <id_mun_misil>,<cantidad>',
  `invisible` int(11) NOT NULL DEFAULT '0' COMMENT '0: Visible | 1: Invisible',
  `titulo` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '-1',
  `lastIP` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ultimaConexion` varchar(255) CHARACTER SET utf8 NOT NULL,
  `slot2` varchar(999) COLLATE utf8_spanish_ci NOT NULL DEFAULT '-1',
  `slot3` varchar(999) COLLATE utf8_spanish_ci NOT NULL DEFAULT '-1',
  `inventario` longtext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of cuentas
-- ----------------------------

-- ----------------------------
-- Table structure for `experiencias`
-- ----------------------------
DROP TABLE IF EXISTS `experiencias`;
CREATE TABLE `experiencias` (
  `nivel` int(11) NOT NULL,
  `nave` bigint(255) NOT NULL DEFAULT '-1',
  `vant` bigint(255) NOT NULL DEFAULT '-1',
  `pet` bigint(255) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`nivel`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of experiencias
-- ----------------------------
INSERT INTO `experiencias` VALUES ('1', '0', '0', '0');
INSERT INTO `experiencias` VALUES ('2', '10000', '100', '8000');
INSERT INTO `experiencias` VALUES ('3', '20000', '200', '64000');
INSERT INTO `experiencias` VALUES ('4', '40000', '400', '216000');
INSERT INTO `experiencias` VALUES ('5', '80000', '800', '512000');
INSERT INTO `experiencias` VALUES ('6', '160000', '1600', '1000000');
INSERT INTO `experiencias` VALUES ('7', '320000', '-1', '1728000');
INSERT INTO `experiencias` VALUES ('8', '640000', '-1', '2744000');
INSERT INTO `experiencias` VALUES ('9', '1280000', '-1', '4096000');
INSERT INTO `experiencias` VALUES ('10', '2560000', '-1', '8000000');
INSERT INTO `experiencias` VALUES ('11', '5120000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('12', '10240000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('13', '20480000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('14', '40960000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('15', '81920000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('16', '163840000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('17', '327680000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('18', '655360000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('19', '1310720000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('20', '2147483647', '-1', '-1');
INSERT INTO `experiencias` VALUES ('21', '5242880000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('22', '10485760000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('23', '20971520000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('24', '41943040000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('25', '83886080000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('26', '167772160000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('27', '335544320000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('28', '671088640000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('29', '1342177280000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('30', '2684354560000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('31', '5368709120000', '-1', '-1');
INSERT INTO `experiencias` VALUES ('32', '10737418240000', '-1', '-1');

-- ----------------------------
-- Table structure for `mapas`
-- ----------------------------
DROP TABLE IF EXISTS `mapas`;
CREATE TABLE `mapas` (
  `mapid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `music` int(11) NOT NULL DEFAULT '0',
  `scaleFactor` int(11) NOT NULL DEFAULT '-1',
  `neighbours` varchar(255) NOT NULL,
  `starfield` varchar(11) NOT NULL DEFAULT 'true' COMMENT 'true/false',
  `backgrounds` varchar(255) NOT NULL COMMENT 'typeID,layer,pFactor|',
  `lensflares` varchar(255) NOT NULL COMMENT 'id,x,y,pFactor,star|',
  `planets` varchar(255) NOT NULL COMMENT 'typeID,x,y,pFactor,layer|',
  `aliens` varchar(255) NOT NULL,
  PRIMARY KEY (`mapid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mapas
-- ----------------------------
INSERT INTO `mapas` VALUES ('1', '1-1', '0', '-1', '2', 'true', '1,0,10', '1,310,408,10,true', '1,400,400,6,1|2,450,450,5,2', '|1,25');
INSERT INTO `mapas` VALUES ('2', '1-2', '0', '-1', '', 'true', '', '', '', '|2,15|1,10');
INSERT INTO `mapas` VALUES ('3', '1-3', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('4', '1-4', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('5', '2-1', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('6', '2-2', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('7', '2-3', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('8', '2-4', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('9', '3-1', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('10', '3-2', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('11', '3-3', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('12', '3-4', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('13', '4-1', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('14', '4-2', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('15', '4-3', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('16', '4-4', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('17', '1-5', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('18', '1-6', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('19', '1-7', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('20', '1-8', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('21', '2-5', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('22', '2-6', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('23', '2-7', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('24', '2-8', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('25', '3-5', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('26', '3-6', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('27', '3-7', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('28', '3-8', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('29', '4-5', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('42', '???', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('51', 'GG', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('52', 'GG', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('53', 'GG', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('54', 'GG NC', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('55', 'GG', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('56', 'Galaxy Gate 6', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('57', 'GG Y4', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('61', 'Invasion', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('62', 'Invasion', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('63', 'Invasion', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('64', 'Invasion', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('65', 'Invasion', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('66', 'Invasion', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('67', 'Invasion', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('68', 'Invasion', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('69', 'Invasion', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('81', 'TDM I', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('82', 'TDM II>', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('91', '5-1', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('92', '5-2', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('93', '5-3', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('200', 'Lord of War', '0', '-1', '', 'true', '', '', '', '');
INSERT INTO `mapas` VALUES ('255', '0-1', '0', '-1', '', 'true', '', '', '', '');

-- ----------------------------
-- Table structure for `naves`
-- ----------------------------
DROP TABLE IF EXISTS `naves`;
CREATE TABLE `naves` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `velocidad` int(11) NOT NULL,
  `carga` int(11) NOT NULL,
  `lasers` int(11) NOT NULL,
  `generadores` int(11) NOT NULL,
  `vida` bigint(255) NOT NULL,
  `baterias` int(11) NOT NULL,
  `misiles` int(11) NOT NULL,
  `extras` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of naves
-- ----------------------------
INSERT INTO `naves` VALUES ('1', 'Phoenix', '320', '100', '1', '1', '4000', '0', '100', '1');
INSERT INTO `naves` VALUES ('2', 'Yamato', '340', '200', '2', '2', '8000', '0', '200', '1');
INSERT INTO `naves` VALUES ('3', 'Leonov', '380', '1000', '6', '6', '160000', '0', '300', '1');
INSERT INTO `naves` VALUES ('4', 'Defcom', '280', '300', '3', '5', '12000', '0', '400', '2');
INSERT INTO `naves` VALUES ('5', 'Liberator', '300', '400', '4', '6', '16000', '0', '500', '2');
INSERT INTO `naves` VALUES ('6', 'Piranha', '320', '500', '5', '7', '32000', '0', '600', '2');
INSERT INTO `naves` VALUES ('7', 'Nostromo', '340', '600', '6', '8', '64000', '0', '700', '2');
INSERT INTO `naves` VALUES ('8', 'Vengeance', '360', '1000', '10', '10', '180000', '0', '800', '2');
INSERT INTO `naves` VALUES ('9', 'Bigboy', '260', '700', '7', '15', '128000', '0', '900', '3');
INSERT INTO `naves` VALUES ('10', 'Goliath K2', '300', '1500', '15', '15', '256000', '0', '1600', '3');

-- ----------------------------
-- Table structure for `npcs`
-- ----------------------------
DROP TABLE IF EXISTS `npcs`;
CREATE TABLE `npcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `gfx` int(11) NOT NULL DEFAULT '1',
  `pv` int(20) NOT NULL DEFAULT '800',
  `esc` int(20) NOT NULL DEFAULT '0',
  `exp` int(20) NOT NULL DEFAULT '0',
  `hon` int(20) NOT NULL DEFAULT '0',
  `cre` int(20) NOT NULL DEFAULT '0',
  `uri` int(20) NOT NULL DEFAULT '0',
  `xenomit` int(20) NOT NULL DEFAULT '0',
  `prometium` int(20) NOT NULL DEFAULT '0',
  `terbium` int(20) NOT NULL DEFAULT '0',
  `endurium` int(20) NOT NULL DEFAULT '0',
  `prometid` int(20) NOT NULL DEFAULT '0',
  `duranium` int(20) NOT NULL DEFAULT '0',
  `promerium` int(20) NOT NULL DEFAULT '0',
  `dmg` varchar(255) NOT NULL DEFAULT 'D10,20',
  `IA` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of npcs
-- ----------------------------
INSERT INTO `npcs` VALUES ('1', '-=[ Streuner ]=-', '84', '800', '400', '400', '2', '400', '1', '0', '10', '0', '10', '0', '0', '0', 'D10,20', '0');
INSERT INTO `npcs` VALUES ('2', '-=[ Lordakia ]=-', '71', '2000', '2000', '800', '4', '800', '2', '0', '20', '20', '20', '0', '0', '0', 'D80,100', '1');
INSERT INTO `npcs` VALUES ('3', '-=[ Saimon ]=-', '75', '6000', '3000', '1600', '8', '1600', '4', '0', '40', '40', '40', '2', '2', '0', 'D200,250', '1');
INSERT INTO `npcs` VALUES ('4', '-=[ Mordon ]=-', '73', '20000', '10000', '3200', '16', '6400', '8', '0', '80', '80', '80', '8', '8', '1', 'D300,390', '0');
INSERT INTO `npcs` VALUES ('5', '-=[ Devolarium ]=-', '72', '100000', '100000', '6400', '32', '51200', '16', '0', '100', '100', '100', '16', '16', '2', 'D1000,1200', '1');
INSERT INTO `npcs` VALUES ('6', '-=[ Sibelon ]=-', '74', '200000', '200000', '12800', '64', '102400', '32', '0', '200', '200', '200', '32', '32', '4', 'D2400,2650', '1');
INSERT INTO `npcs` VALUES ('7', '-=[ Sibelonit ]=-', '76', '40000', '40000', '3200', '16', '12800', '12', '0', '100', '100', '100', '8', '8', '1', 'D1000,1500', '1');
INSERT INTO `npcs` VALUES ('8', '-=[ Lordakium ]=-', '77', '300000', '200000', '25600', '128', '204800', '64', '0', '300', '300', '300', '64', '64', '8', 'D3150,3600', '2');
INSERT INTO `npcs` VALUES ('9', '-=[ Kristallin ]=-', '78', '50000', '40000', '6400', '32', '12800', '16', '0', '100', '100', '100', '16', '16', '1', 'D1500,1650', '1');
INSERT INTO `npcs` VALUES ('10', '-=[ Kristallon ]=-', '79', '400000', '300000', '51200', '256', '409600', '128', '0', '300', '300', '300', '128', '128', '16', 'D4050,5000', '2');
INSERT INTO `npcs` VALUES ('11', '-=[ StreuneR ]=-', '85', '20000', '10000', '3200', '16', '6400', '8', '0', '80', '80', '80', '8', '8', '0', 'D400,900', '0');
INSERT INTO `npcs` VALUES ('12', '-=[ Protegit ]=-', '81', '50000', '40000', '6400', '32', '12800', '16', '0', '100', '100', '100', '16', '16', '2', 'D1300,1500', '3');
INSERT INTO `npcs` VALUES ('13', '-=[ Cubikon ]=-', '80', '1600000', '1200000', '512000', '4096', '1638400', '1024', '64', '1200', '1200', '1200', '512', '512', '64', 'D0,0', '4');
INSERT INTO `npcs` VALUES ('14', '..::{ Boss Streuner }::..', '84', '3200', '1600', '1600', '8', '1600', '4', '0', '40', '10', '40', '0', '0', '0', 'D100,120', '2');
INSERT INTO `npcs` VALUES ('15', '..::{ Boss Lordakia }::..', '71', '8000', '8000', '3200', '16', '3200', '8', '1', '80', '80', '80', '10', '0', '1', 'D295,350', '1');
INSERT INTO `npcs` VALUES ('16', '..::{ Boss Saimon }::..', '75', '24000', '12000', '6400', '32', '6400', '16', '2', '160', '160', '160', '8', '8', '1', 'D600,720', '1');
INSERT INTO `npcs` VALUES ('17', '..::{ Boss Mordon }::..', '73', '80000', '40000', '12800', '64', '25600', '32', '4', '320', '320', '320', '32', '32', '8', 'D1300,1500', '1');
INSERT INTO `npcs` VALUES ('18', '..::{ Boss Devolarium }::..', '72', '400000', '400000', '25600', '128', '204800', '64', '8', '400', '400', '400', '64', '64', '8', 'D4100,4650', '1');
INSERT INTO `npcs` VALUES ('19', '..::{ Boss Sibelon }::..', '74', '800000', '800000', '51200', '256', '409600', '128', '16', '800', '800', '800', '128', '128', '16', 'D9100,12350', '1');
INSERT INTO `npcs` VALUES ('20', '..::{ Boss Sibelonit }::..', '76', '160000', '160000', '12800', '64', '51200', '48', '8', '400', '400', '400', '32', '32', '4', 'D3175,4350', '1');
INSERT INTO `npcs` VALUES ('21', '..::{ Boss Lordakium }::..', '77', '1200000', '800000', '102400', '512', '819200', '256', '32', '1200', '1200', '1200', '256', '256', '32', 'D10000,16000', '2');
INSERT INTO `npcs` VALUES ('22', '..::{ Boss Kristallin }::..', '78', '200000', '160000', '25600', '128', '51200', '64', '8', '400', '400', '400', '64', '64', '4', 'D3600,4700', '1');
INSERT INTO `npcs` VALUES ('23', '..::{ Boss Kristallon }::.', '79', '1600000', '1200000', '204800', '1024', '1638400', '512', '64', '1200', '1200', '1200', '512', '512', '64', 'D15000,20000', '2');
INSERT INTO `npcs` VALUES ('24', '..::{ Boss StreuneR }::..', '85', '80000', '40000', '12800', '64', '25600', '32', '4', '320', '320', '320', '32', '32', '0', 'D1500,2000', '2');
INSERT INTO `npcs` VALUES ('25', '«¤( UberStreuner )¤»', '84', '6400', '3200', '3200', '16', '3200', '8', '0', '80', '20', '80', '0', '0', '0', 'D160,270', '0');
INSERT INTO `npcs` VALUES ('26', '«¤( UberLordakia )¤»', '71', '16000', '16000', '6400', '32', '6400', '16', '2', '160', '160', '160', '20', '0', '2', 'D500,700', '1');
INSERT INTO `npcs` VALUES ('27', '«¤( UberSaimon )¤»', '75', '48000', '24000', '12800', '64', '12800', '32', '4', '320', '320', '320', '16', '16', '2', 'D1200,1440', '1');
INSERT INTO `npcs` VALUES ('28', '«¤( UberMordon )¤»', '73', '160000', '80000', '25600', '128', '51200', '64', '8', '640', '640', '640', '64', '64', '16', 'D2600,3100', '1');
INSERT INTO `npcs` VALUES ('29', '«¤( UberDevolarium )¤»', '72', '800000', '800000', '51200', '246', '409600', '128', '16', '800', '800', '800', '128', '128', '16', 'D8200,9300', '1');
INSERT INTO `npcs` VALUES ('30', '«¤( UberSibelon )¤»', '74', '1600000', '1600000', '102400', '512', '819200', '146', '32', '1600', '1600', '1600', '246', '246', '32', 'D18200,24700', '1');
INSERT INTO `npcs` VALUES ('31', '«¤( UberSibelonit )¤»', '76', '320000', '320000', '25600', '128', '102400', '96', '16', '800', '800', '800', '64', '64', '8', 'D6350,8700', '1');
INSERT INTO `npcs` VALUES ('32', '«¤( UberLordakium )¤»', '77', '2400000', '1600000', '204800', '1024', '1638400', '512', '64', '2400', '2400', '2400', '512', '512', '64', 'D20000,31000', '2');
INSERT INTO `npcs` VALUES ('33', '«¤( UberKristallin )¤»', '78', '400000', '320000', '51200', '246', '102400', '128', '16', '800', '800', '800', '128', '128', '8', 'D7200,9400', '1');
INSERT INTO `npcs` VALUES ('34', '«¤( UberKristallon )¤»', '79', '3200000', '2400000', '409600', '2048', '3276800', '1024', '128', '2400', '2400', '2400', '1024', '1024', '128', 'D30000,45000', '0');
INSERT INTO `npcs` VALUES ('35', '«¤( UberStreuneR )¤»', '85', '160000', '80000', '25600', '128', '51200', '64', '8', '640', '640', '640', '64', '64', '0', 'D3000,4000', '0');

-- ----------------------------
-- Table structure for `objetos`
-- ----------------------------
DROP TABLE IF EXISTS `objetos`;
CREATE TABLE `objetos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `gfx` int(50) NOT NULL DEFAULT '0',
  `efectos` text NOT NULL,
  `uridiums` double(255,1) NOT NULL DEFAULT '-1.0',
  `creditos` int(255) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`),
  KEY `1` (`id`),
  KEY `2` (`nombre`),
  KEY `3` (`tipo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of objetos
-- ----------------------------
INSERT INTO `objetos` VALUES ('1', 'LF-1', 'laser', '1', 'D40', '-1.0', '10000');
INSERT INTO `objetos` VALUES ('2', 'MP-1', 'laser', '2', 'D60', '-1.0', '40000');
INSERT INTO `objetos` VALUES ('3', 'LF-2', 'laser', '3', 'D100', '5000.0', '-1');
INSERT INTO `objetos` VALUES ('4', 'LF-3', 'laser', '4', 'D150', '10000.0', '-1');
INSERT INTO `objetos` VALUES ('5', 'HST-1', 'laser', '11', 'HM3', '-1.0', '500000');
INSERT INTO `objetos` VALUES ('6', 'HST-2', 'laser', '12', 'HM5', '15000.0', '-1');
INSERT INTO `objetos` VALUES ('7', 'LCB-10', 'battery', '1', '', '-1.0', '10');
INSERT INTO `objetos` VALUES ('8', 'MCB-25', 'battery', '2', '', '0.5', '-1');
INSERT INTO `objetos` VALUES ('9', 'MCB-50', 'battery', '3', '', '1.0', '-1');
INSERT INTO `objetos` VALUES ('10', 'UCB-100', 'battery', '4', '', '2.5', '-1');
INSERT INTO `objetos` VALUES ('11', 'SAB-50', 'battery', '5', '', '1.0', '-1');
INSERT INTO `objetos` VALUES ('12', 'RSB-75', 'battery', '6', '', '5.0', '-1');
INSERT INTO `objetos` VALUES ('13', 'R-310', 'rocket', '1', 'D1000', '-1.0', '100');
INSERT INTO `objetos` VALUES ('14', 'PLT-2026', 'rocket', '2', 'D2000', '-1.0', '500');
INSERT INTO `objetos` VALUES ('15', 'PLT-2021', 'rocket', '3', 'D4000', '5.0', '-1');
INSERT INTO `objetos` VALUES ('16', 'PLD-8', 'rocket', '4', 'DIS3', '100.0', '-1');
INSERT INTO `objetos` VALUES ('17', 'PLT-3030', 'rocket', '5', 'D6000', '7.0', '-1');
INSERT INTO `objetos` VALUES ('18', 'ACM-1', 'rocket', '11', 'DM20', '100.0', '-1');
INSERT INTO `objetos` VALUES ('19', 'HSTRM-01', 'rocket', '50', 'D5000', '25.0', '-1');
INSERT INTO `objetos` VALUES ('20', 'UBR-100', 'rocket', '51', 'D8000', '30.0', '-1');
INSERT INTO `objetos` VALUES ('21', 'ECO-10', 'rocket', '52', 'D2400', '-1.0', '1500');
INSERT INTO `objetos` VALUES ('22', 'G3N-1010', 'generator', '1', 'V2', '-1.0', '2000');
INSERT INTO `objetos` VALUES ('23', 'G3N-2010', 'generator', '2', 'V3', '-1.0', '4000');
INSERT INTO `objetos` VALUES ('24', 'G3N-3210', 'generator', '3', 'V4', '-1.0', '8000');
INSERT INTO `objetos` VALUES ('25', 'G3N-3310', 'generator', '4', 'V5', '-1.0', '16000');
INSERT INTO `objetos` VALUES ('26', 'G3N-6900', 'generator', '5', 'V7', '1000.0', '-1');
INSERT INTO `objetos` VALUES ('27', 'G3N-7900', 'generator', '6', 'V10', '2000.0', '-1');
INSERT INTO `objetos` VALUES ('28', 'SG3N-A01', 'generator', '7', 'E1000|40', '-1.0', '8000');
INSERT INTO `objetos` VALUES ('29', 'SG3N-A02', 'generator', '8', 'E2000|50', '-1.0', '16000');
INSERT INTO `objetos` VALUES ('30', 'SG3N-B01', 'generator', '9', 'E4000|70', '2500.0', '-1');
INSERT INTO `objetos` VALUES ('31', 'SG3N-A03', 'generator', '10', 'E5000|60', '-1.0', '256000');
INSERT INTO `objetos` VALUES ('32', 'SG3N-B02', 'generator', '11', 'E10000|80', '10000.0', '-1');
INSERT INTO `objetos` VALUES ('33', 'LF-4', 'laser', '0', 'D200', '50000.0', '-1');

-- ----------------------------
-- Table structure for `portales`
-- ----------------------------
DROP TABLE IF EXISTS `portales`;
CREATE TABLE `portales` (
  `ID` int(11) NOT NULL,
  `factionID` int(11) NOT NULL COMMENT '1: MMO 2: EIC 3:VRU',
  `keyPortal` int(11) NOT NULL COMMENT 'swfID',
  `mapID` int(11) NOT NULL,
  `posX` int(11) NOT NULL DEFAULT '0',
  `posY` int(11) NOT NULL DEFAULT '0',
  `factionScrap` int(11) NOT NULL DEFAULT '0' COMMENT '1: MMO 2: EIC 3:VRU',
  `toMapID` int(11) NOT NULL,
  `toPos` varchar(255) NOT NULL,
  `reqNivel` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `id` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of portales
-- ----------------------------
INSERT INTO `portales` VALUES ('1', '1', '1', '1', '18500', '11500', '0', '2', '2000|2000', '1');
INSERT INTO `portales` VALUES ('2', '1', '1', '2', '2000', '2000', '0', '1', '18500|11500', '1');
INSERT INTO `portales` VALUES ('3', '1', '1', '2', '18500', '11500', '0', '3', '858|940', '1');
INSERT INTO `portales` VALUES ('4', '1', '1', '2', '18500', '2000', '0', '4', '858|940', '1');
INSERT INTO `portales` VALUES ('5', '1', '1', '3', '1261', '11841', '0', '2', '858|940', '1');
INSERT INTO `portales` VALUES ('6', '1', '1', '3', '19564', '11731', '0', '4', '19564|11731', '1');
INSERT INTO `portales` VALUES ('7', '1', '1', '3', '19411', '1038', '0', '7', '19411|1038', '1');
INSERT INTO `portales` VALUES ('8', '1', '1', '4', '1117', '1115', '0', '2', '858|940', '1');
INSERT INTO `portales` VALUES ('9', '1', '1', '4', '19618', '1065', '0', '3', '858|940', '1');
INSERT INTO `portales` VALUES ('10', '1', '1', '4', '19591', '12051', '0', '12', '858|940', '1');
INSERT INTO `portales` VALUES ('11', '1', '1', '4', '19469', '6978', '0', '13', '858|940', '1');

-- ----------------------------
-- Table structure for `rangos`
-- ----------------------------
DROP TABLE IF EXISTS `rangos`;
CREATE TABLE `rangos` (
  `id` int(11) unsigned NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `porcentaje` double(11,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rangos
-- ----------------------------
INSERT INTO `rangos` VALUES ('1', 'Piloto Básico', '20.00');
INSERT INTO `rangos` VALUES ('2', 'Piloto', '12.39');
INSERT INTO `rangos` VALUES ('3', 'Jefe Piloto', '10.00');
INSERT INTO `rangos` VALUES ('4', 'Sargento Básico', '9.00');
INSERT INTO `rangos` VALUES ('5', 'Sargento', '8.00');
INSERT INTO `rangos` VALUES ('6', 'Sargento Mayor', '7.00');
INSERT INTO `rangos` VALUES ('7', 'Teniente Básico', '6.00');
INSERT INTO `rangos` VALUES ('8', 'Teniente', '5.00');
INSERT INTO `rangos` VALUES ('9', 'Teniente Mayor', '4.50');
INSERT INTO `rangos` VALUES ('10', 'Capitán Básico', '4.00');
INSERT INTO `rangos` VALUES ('11', 'Capitán', '3.50');
INSERT INTO `rangos` VALUES ('12', 'Capitán Bayor', '3.00');
INSERT INTO `rangos` VALUES ('13', 'Mayor Básico', '2.50');
INSERT INTO `rangos` VALUES ('14', 'Mayor', '2.00');
INSERT INTO `rangos` VALUES ('15', 'Jefe Mayor', '1.50');
INSERT INTO `rangos` VALUES ('16', 'Coronel Básico', '1.00');
INSERT INTO `rangos` VALUES ('17', 'Coronel', '0.50');
INSERT INTO `rangos` VALUES ('18', 'Coronel Bayor', '0.10');
INSERT INTO `rangos` VALUES ('19', 'General Básico', '0.01');
INSERT INTO `rangos` VALUES ('20', 'General', '0.00');
INSERT INTO `rangos` VALUES ('99', 'Administrador', '0.00');
INSERT INTO `rangos` VALUES ('21', 'Administrador', '0.00');
INSERT INTO `rangos` VALUES ('22', 'Deshonorable', '0.00');

-- ----------------------------
-- Table structure for `servidores`
-- ----------------------------
DROP TABLE IF EXISTS `servidores`;
CREATE TABLE `servidores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT '1: Activado | 0: Desactivado',
  `idioma` varchar(50) NOT NULL DEFAULT 'Español',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of servidores
-- ----------------------------
INSERT INTO `servidores` VALUES ('1', 'Servidor 1', '1', 'Brasil');

-- ----------------------------
-- Table structure for `settings`
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `userID` int(11) NOT NULL,
  `SET` varchar(255) NOT NULL DEFAULT '1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|0|0|1|1|0|0|1|1|1|1',
  `MINIMAP_SCALE` varchar(255) NOT NULL DEFAULT '11',
  `DISPLAY_PLAYER_NAMES` varchar(255) NOT NULL DEFAULT '1',
  `DISPLAY_CHAT` varchar(255) NOT NULL DEFAULT '1',
  `PLAY_MUSIC` varchar(255) NOT NULL DEFAULT '0',
  `PLAY_SFX` varchar(255) NOT NULL DEFAULT '1',
  `BAR_STATUS` varchar(255) NOT NULL DEFAULT '1',
  `WINDOW_SETTINGS` varchar(255) NOT NULL DEFAULT '0,9,4,1,1,232,3,1,3,780,388,1,5,5,5,0,10,5,288,0,13,187,50,0,20,5,402,1,22,347,188,0,23,458,1,1,24,284,25,0',
  `AUTO_REFINEMENT` varchar(255) NOT NULL DEFAULT '0',
  `QUICKSLOT_STOP_ATTACK` varchar(255) NOT NULL DEFAULT '1',
  `DOUBLECLICK_ATTACK` varchar(255) NOT NULL DEFAULT '1',
  `AUTO_START` varchar(255) NOT NULL DEFAULT '0',
  `DISPLAY_NOTIFICATIONS` varchar(255) NOT NULL DEFAULT '1',
  `SHOW_DRONES` varchar(255) NOT NULL DEFAULT '1',
  `DISPLAY_WINDOW_BACKGROUND` varchar(255) NOT NULL DEFAULT '1',
  `ALWAYS_DRAGGABLE_WINDOWS` varchar(255) NOT NULL DEFAULT '1',
  `PRELOAD_USER_SHIPS` varchar(255) NOT NULL DEFAULT '0',
  `QUALITY_PRESETTING` varchar(255) NOT NULL DEFAULT '3',
  `QUALITY_CUSTOMIZED` varchar(255) NOT NULL DEFAULT '0',
  `QUALITY_BACKGROUND` varchar(255) NOT NULL DEFAULT '3',
  `QUALITY_POIZONE` varchar(255) NOT NULL DEFAULT '3',
  `QUALITY_SHIP` varchar(255) NOT NULL DEFAULT '3',
  `QUALITY_ENGINE` varchar(255) NOT NULL DEFAULT '3',
  `QUALITY_COLLECTABLE` varchar(255) NOT NULL DEFAULT '3',
  `QUALITY_ATTACK` varchar(255) NOT NULL DEFAULT '3',
  `QUALITY_EFFECT` varchar(255) NOT NULL DEFAULT '3',
  `QUALITY_EXPLOSION` varchar(255) NOT NULL DEFAULT '3',
  `QUICKBAR_SLOT` varchar(255) NOT NULL DEFAULT '-1,-1,-1,-1,-1,-1,-1,-1,-1,-1',
  `SLOTMENU_POSITION` varchar(255) NOT NULL DEFAULT '313,451',
  `SLOTMENU_ORDER` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userID` (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of settings
-- ----------------------------

-- ----------------------------
-- Table structure for `skylabs`
-- ----------------------------
DROP TABLE IF EXISTS `skylabs`;
CREATE TABLE `skylabs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gen_prometium` int(11) NOT NULL DEFAULT '1',
  `prometium` int(11) NOT NULL DEFAULT '0',
  `gen_endurium` int(11) NOT NULL DEFAULT '1',
  `endurium` int(11) NOT NULL DEFAULT '0',
  `gen_terbium` int(11) NOT NULL DEFAULT '1',
  `terbium` int(11) NOT NULL DEFAULT '0',
  `transporte` int(11) NOT NULL DEFAULT '1',
  `almacen` int(11) NOT NULL DEFAULT '1',
  `mod_solar` int(11) NOT NULL DEFAULT '1',
  `mod_base` int(11) NOT NULL DEFAULT '1',
  `gen_prometid` int(11) NOT NULL DEFAULT '1',
  `prometid` int(11) NOT NULL DEFAULT '0',
  `gen_duranium` int(11) NOT NULL DEFAULT '1',
  `duranium` int(11) NOT NULL DEFAULT '0',
  `gen_promerium` int(11) NOT NULL DEFAULT '1',
  `promerium` int(11) NOT NULL DEFAULT '0',
  `mod_xeno` int(11) NOT NULL DEFAULT '1',
  `gen_seprom` int(11) NOT NULL,
  `seprom` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of skylabs
-- ----------------------------
INSERT INTO `skylabs` VALUES ('2', '1', '0', '1', '0', '1', '0', '1', '1', '1', '1', '1', '0', '1', '0', '1', '0', '1', '0', '0');

-- ----------------------------
-- Table structure for `useronline`
-- ----------------------------
DROP TABLE IF EXISTS `useronline`;
CREATE TABLE `useronline` (
  `timestamp` int(15) NOT NULL DEFAULT '0',
  `ip` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`timestamp`,`ip`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of useronline
-- ----------------------------

-- ----------------------------
-- Table structure for `vants`
-- ----------------------------
DROP TABLE IF EXISTS `vants`;
CREATE TABLE `vants` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `ranuras` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of vants
-- ----------------------------
INSERT INTO `vants` VALUES ('1', 'Flax', '1');
INSERT INTO `vants` VALUES ('2', 'Iris', '2');
