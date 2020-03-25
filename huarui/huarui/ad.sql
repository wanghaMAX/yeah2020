/*
MySQL Data Transfer
Source Host: localhost
Source Database: ad
Target Host: localhost
Target Database: ad
Date: 2009-9-3 14:38:05
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for aboc_ad
-- ----------------------------
DROP TABLE IF EXISTS `aboc_ad`;
CREATE TABLE `aboc_ad` (
  `adid` mediumint(4) NOT NULL AUTO_INCREMENT,
  `name` char(200) NOT NULL DEFAULT '',
  `width` int(5) NOT NULL DEFAULT '0',
  `height` int(5) NOT NULL DEFAULT '0',
  `price` float(8,2) NOT NULL DEFAULT '0.00',
  `adduser` char(20) NOT NULL DEFAULT '',
  `addtime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`adid`),
  KEY `adid` (`adid`)
) ENGINE=MyISAM AUTO_INCREMENT=12;

-- ----------------------------
-- Table structure for aboc_ad_order
-- ----------------------------
DROP TABLE IF EXISTS `aboc_ad_order`;
CREATE TABLE `aboc_ad_order` (
  `orderid` mediumint(6) NOT NULL AUTO_INCREMENT,
  `adid` mediumint(4) NOT NULL DEFAULT '0',
  `title` char(220) NOT NULL DEFAULT '',
  `class` tinyint(1) NOT NULL DEFAULT '0',
  `url` char(220) NOT NULL DEFAULT '',
  `text` char(254) NOT NULL DEFAULT '',
  `img` char(200) NOT NULL DEFAULT '',
  `code` mediumtext NOT NULL,
  `price` float(8,2) NOT NULL DEFAULT '0.00',
  `bro` int(10) NOT NULL DEFAULT '0',
  `click` int(10) NOT NULL DEFAULT '0',
  `lastclick` int(10) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `startdate` int(10) NOT NULL DEFAULT '0',
  `stopdate` int(10) NOT NULL DEFAULT '0',
  `adduser` char(20) NOT NULL DEFAULT '',
  `addtime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`orderid`),
  KEY `orderid` (`orderid`,`class`,`startdate`,`stopdate`,`adid`)
) ENGINE=MyISAM AUTO_INCREMENT=77;

-- ----------------------------
-- Table structure for aboc_user
-- ----------------------------
DROP TABLE IF EXISTS `aboc_user`;
CREATE TABLE `aboc_user` (
  `uid` mediumint(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `state` (`state`)
) ENGINE=MyISAM AUTO_INCREMENT=7 ;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `aboc_ad` VALUES ('11', '测试广告位1', '200', '100', '90.00', 'aboc', '1251955780');
INSERT INTO `aboc_ad_order` VALUES ('75', '11', '11111111111', '2', '11111111111', '', 'upload/2009/09/03/0135540c061df1ff.jpg', '111111111111111', '0.00', '7', '0', '0', '1', '1251907200', '1252598400', 'aboc', '1251956154');
INSERT INTO `aboc_ad_order` VALUES ('76', '11', '1111111111111', '2', '11111111111', '1111111111111111111', 'upload/2009/09/03/021239fff43ded26.gif', '', '999.00', '2', '0', '0', '1', '1251907200', '1252598400', 'aboc', '1251958359');
INSERT INTO `aboc_user` VALUES ('6', 'admin', '5eb25783dc93b1b14bbf5e647a26d19a', 'aboc@yiwuku.com', '1');
