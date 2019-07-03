/*
 Navicat Premium Data Transfer

 Source Server         : etrcuking-staging
 Source Server Type    : MySQL
 Source Server Version : 50714
 Source Host           : 35.197.159.75:3306
 Source Schema         : etrucking

 Target Server Type    : MySQL
 Target Server Version : 50714
 File Encoding         : 65001

 Date: 21/06/2019 15:09:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL COMMENT 'FILLED WITH ID USER',
  `updated_by` int(11) DEFAULT NULL COMMENT 'FILLED WITH ID USER',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'FILLED WITH ID USER',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menus
-- ----------------------------
BEGIN;
INSERT INTO `menus` VALUES (2, 'Data Vendor', '2019-06-21 14:59:25', '2019-06-21 14:59:28', NULL, 1, 1, NULL);
INSERT INTO `menus` VALUES (3, 'Data User', '2019-06-21 15:00:30', '2019-06-21 15:00:32', NULL, 1, 1, NULL);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
