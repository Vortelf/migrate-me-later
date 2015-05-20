/*
Navicat MySQL Data Transfer

Source Server         : OAUTH_LOCALHOST
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : oauth

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2015-03-01 00:01:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for access_requests
-- ----------------------------
DROP TABLE IF EXISTS `access_requests`;
CREATE TABLE `access_requests` (
  `auth_code` varchar(32) NOT NULL DEFAULT '',
  `client_id` varchar(32) NOT NULL DEFAULT '',
  `scope` varchar(255) NOT NULL DEFAULT '',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `redirect_uri` varchar(255) DEFAULT NULL,
  `TTL` datetime DEFAULT NULL,
  PRIMARY KEY (`auth_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of access_requests
-- ----------------------------

-- ----------------------------
-- Table structure for applications
-- ----------------------------
DROP TABLE IF EXISTS `applications`;
CREATE TABLE `applications` (
  `aid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `application_name` varchar(64) NOT NULL DEFAULT '',
  `client_id` varchar(32) NOT NULL DEFAULT '',
  `client_secret` varchar(32) NOT NULL DEFAULT '',
  `redirect_uri` varchar(250) NOT NULL DEFAULT '',
  `status` enum('development','pending','approved','rejected') NOT NULL DEFAULT 'development',
  `notes` tinytext,
  PRIMARY KEY (`aid`),
  UNIQUE KEY `client_id` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1023 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of applications
-- ----------------------------
INSERT INTO `applications` VALUES ('1337', 'Oldbelix', 'Ru19lQzS1hpAuwTLQLSoFKHU3GbiBhH2', 'pL454RFUGMiuOflhAuCfActTTCL87rPu', '', 'development', null);

-- ----------------------------
-- Table structure for scopes
-- ----------------------------
DROP TABLE IF EXISTS `scopes`;
CREATE TABLE `scopes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('read','update') NOT NULL DEFAULT 'read',
  `scope` varchar(64) NOT NULL DEFAULT '',
  `description` varchar(100) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of scopes
-- ----------------------------
INSERT INTO `scopes` VALUES ('1', 'read', 'email', 'Your Email Address');
INSERT INTO `scopes` VALUES ('2', 'read', 'name', 'Your Full Name');
INSERT INTO `scopes` VALUES ('3', 'read', 'phone_number', 'Your Phone Number');
INSERT INTO `scopes` VALUES ('4', 'read', 'age', 'Your Age');
INSERT INTO `scopes` VALUES ('5', 'read', 'date_of_birth', 'Your Date Of Birth');
INSERT INTO `scopes` VALUES ('8', 'update', 'username', 'Your Username');
INSERT INTO `scopes` VALUES ('9', 'update', 'email', 'Your Email Address');
INSERT INTO `scopes` VALUES ('10', 'update', 'phone_number', 'Your Phone Number');

-- ----------------------------
-- Table structure for tokens
-- ----------------------------
DROP TABLE IF EXISTS `tokens`;
CREATE TABLE `tokens` (
  `token` varchar(64) NOT NULL DEFAULT '',
  `auth_code` varchar(32) NOT NULL DEFAULT '',
  `client_id` varchar(32) NOT NULL DEFAULT '',
  `type` enum('access','refresh') NOT NULL DEFAULT 'access',
  `scope` varchar(64) NOT NULL DEFAULT '',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `TTL` datetime NOT NULL,
  PRIMARY KEY (`token`),
  UNIQUE KEY `auth_code` (`auth_code`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tokens
-- ----------------------------
INSERT INTO `tokens` VALUES ('16f8eb5f5e84e84c937e5751e2d8b62a54e888f053b83d1d3e2c7dd94562e477', '10db5a23b612aacbc0dddda46712bd4e', 'Ru19lQzS1hpAuwTLQLSoFKHU3GbiBhH2', 'access', 'read:name,email:update:phone_number', '2015-05-20 09:17:50', '2016-05-20 09:22:50');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `USERNAME` varchar(50) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `FIRSTNAME` varchar(30) NOT NULL,
  `LASTNAME` varchar(30) NOT NULL,
  `DATE_OF_BIRTH` date NOT NULL,
  `PHONENUMBER` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`EMAIL`),
  UNIQUE KEY `USERNAME` (`USERNAME`),
  UNIQUE KEY `EMAIL` (`EMAIL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('azgaze', 'azgaze@abv.bg', 'd97425def4ec02af978a13b4b842f2a7', 'Bai', 'Ganio', '1900-01-01', '0123456789');
INSERT INTO `users` VALUES ('Vortelf', 'george.velev1177@gmail.com', '547dbf92612f76f9a12929359b6b96ad', 'George', 'Velev', '1997-04-18', null);
INSERT INTO `users` VALUES ('hristo', 'hristo.dachev97@gmail.com', '9c08bd90e02a02d25abe50d6e1e7baea', 'Hristo', 'Dachev', '1997-11-13', '0878718903');
INSERT INTO `users` VALUES ('Momchilcho', 'momodota2@gmail.com', '8646b7c64b2e952f17ce136829ba3378', 'Momchil', 'Angelov', '1994-12-30', '0878718903');
