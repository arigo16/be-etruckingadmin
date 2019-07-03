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

 Date: 16/06/2019 16:12:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for vendors
-- ----------------------------
DROP TABLE IF EXISTS `vendors`;
CREATE TABLE `vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `npwp` varchar(45) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `account_bank` varchar(100) DEFAULT NULL,
  `account_bank_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL COMMENT 'FILLED WITH ID USER',
  `updated_by` int(11) DEFAULT NULL COMMENT 'FILLED WITH ID USER',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'FILLED WITH ID USER',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of vendors
-- ----------------------------
BEGIN;
INSERT INTO `vendors` VALUES (1, 'XYZ', '081959010102', 'PT XYZ', 'bbbbb', NULL, NULL, NULL, '2019-06-16 04:39:15', '2019-06-16 04:39:15', NULL, 1, NULL, NULL);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
