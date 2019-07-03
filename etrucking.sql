/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80016
 Source Host           : localhost:3306
 Source Schema         : etrucking

 Target Server Type    : MySQL
 Target Server Version : 80016
 File Encoding         : 65001

 Date: 21/06/2019 17:40:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for drivers
-- ----------------------------
DROP TABLE IF EXISTS `drivers`;
CREATE TABLE `drivers` (
  `id` int(18) NOT NULL AUTO_INCREMENT,
  `driver_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(18) DEFAULT NULL,
  `updated_by` int(18) DEFAULT NULL,
  `deleted_by` int(18) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of drivers
-- ----------------------------
BEGIN;
INSERT INTO `drivers` VALUES (1, 'Kris', 'kris', '$2y$10$pGKkVl5PUU.HPWAJ.DtHReW88KQPfCTUnHDZYiebP433pDtT/cYyi', '081818181', 'kris@gmail.com', '2019-06-21 09:32:52', '2019-06-21 09:48:34', NULL, 1, 1, NULL);
INSERT INTO `drivers` VALUES (11, 'Ujang', 'ujang', '$2y$10$tep4kOQ8bQqJ/I4IA.ku5.cmMzWU9CiVba40kftyu/XSIJa2iIqJW', '08181818181', 'ujang@gmail.com', '2019-06-21 09:34:04', '2019-06-21 09:34:04', NULL, 1, NULL, NULL);
INSERT INTO `drivers` VALUES (12, 'Bambang', 'bambang', '$2y$10$WUa.MnUopD1cE4pihg3SnODKr4nICgpkd92fstRATLFqrCgKTcg4m', '08181818182', 'bambang@gmail.com', '2019-06-21 09:37:42', '2019-06-21 09:37:42', NULL, 1, NULL, NULL);
INSERT INTO `drivers` VALUES (13, 'Hanaf', 'hanif', '$2y$10$fxlu686wxDpfTwl.LfIQpuJb.UOsMpukVYpXadiCYbDcZZ7zW.rSe', '08181811', 'hanif@gmail.com', '2019-06-21 17:02:09', '2019-06-21 17:07:20', NULL, 1, 1, NULL);
COMMIT;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menus
-- ----------------------------
BEGIN;
INSERT INTO `menus` VALUES (2, 'Data Vendor', '2019-06-21 14:59:25', '2019-06-21 14:59:28', NULL, 1, 1, NULL);
INSERT INTO `menus` VALUES (3, 'Data User', '2019-06-21 15:00:30', '2019-06-21 15:00:32', NULL, 1, 1, NULL);
INSERT INTO `menus` VALUES (5, 'Data truck', '2019-06-21 08:45:58', '2019-06-21 08:46:13', '2019-06-21 08:46:13', 1, NULL, 1);
COMMIT;

-- ----------------------------
-- Table structure for role_menus
-- ----------------------------
DROP TABLE IF EXISTS `role_menus`;
CREATE TABLE `role_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(18) DEFAULT NULL,
  `updated_by` int(18) DEFAULT NULL,
  `deleted_by` int(18) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role_menus
-- ----------------------------
BEGIN;
INSERT INTO `role_menus` VALUES (1, 5, 2, '2019-06-21 16:22:56', '2019-06-21 16:22:58', NULL, 1, NULL, NULL);
INSERT INTO `role_menus` VALUES (2, 5, 3, '2019-06-21 16:23:12', '2019-06-21 16:23:15', NULL, 1, NULL, NULL);
INSERT INTO `role_menus` VALUES (3, 10, 3, '2019-06-21 16:45:43', '2019-06-21 16:45:43', NULL, 1, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roles
-- ----------------------------
BEGIN;
INSERT INTO `roles` VALUES (5, 'Superadmin', '2019-06-21 16:12:50', '2019-06-21 16:12:50', NULL, 1, NULL, NULL);
INSERT INTO `roles` VALUES (6, 'Vendor', '2019-06-21 16:15:31', '2019-06-21 16:15:31', NULL, 1, NULL, NULL);
INSERT INTO `roles` VALUES (10, 'Driver', '2019-06-21 16:45:43', '2019-06-21 16:45:43', NULL, 1, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for user_roles
-- ----------------------------
DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL COMMENT 'FILLED WITH ID USER',
  `updated_by` int(11) DEFAULT NULL COMMENT 'FILLED WITH ID USER',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'FILLED WITH ID USER',
  PRIMARY KEY (`id`,`role_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_roles
-- ----------------------------
BEGIN;
INSERT INTO `user_roles` VALUES (1, '1', 5, '2019-06-21 16:14:31', '2019-06-21 16:14:33', NULL, 1, NULL, NULL);
INSERT INTO `user_roles` VALUES (2, '1', 6, '2019-06-21 16:15:52', '2019-06-21 16:15:55', NULL, 1, NULL, NULL);
INSERT INTO `user_roles` VALUES (3, '7', 5, '2019-06-21 09:34:57', '2019-06-21 09:34:57', NULL, 0, NULL, NULL);
INSERT INTO `user_roles` VALUES (4, '8', 5, '2019-06-21 09:36:33', '2019-06-21 09:36:33', NULL, 0, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_role_id` int(11) DEFAULT NULL COMMENT 'user_role_id = 0 for client mobile apps',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_phone` varchar(13) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_image` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_bank` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_bank_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL COMMENT 'FILLED WITH ID USER',
  `updated_by` int(11) DEFAULT NULL COMMENT 'FILLED WITH ID USER',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'FILLED WITH ID USER',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (1, 1, 'admin', 'admin@gmail.com', 'admin', '8181281', '$2y$12$a9UAXyy0B2HkeOfQXDj/keLClnbGaojVXRN6uP3.qljo8uo25lkgO', NULL, NULL, NULL, NULL, NULL, '2019-06-21 09:24:33', '2019-06-21 09:24:35', NULL, 99, NULL, NULL);
INSERT INTO `users` VALUES (6, 1, 'Admin2', 'admin2@gmail.com', 'admin2', '', '$2y$10$us3FUceEKXdhI78G3SFpN.svob6doYcaxO2zSlOFjhJMBZ14/TuCe', '', '', '', '', '', '2019-06-21 02:26:15', '2019-06-21 02:26:15', NULL, 1, NULL, NULL);
INSERT INTO `users` VALUES (7, 5, 'Admin3', 'admin3@gmail.com', 'admin3', '', '$2y$10$OC.zSEZWQoSJJo.q1dSzeesFuPKLEuFfDi9jevuNZANnVL3.1cl0G', '', '', '', '', '', '2019-06-21 09:34:57', '2019-06-21 09:34:57', NULL, 1, NULL, NULL);
INSERT INTO `users` VALUES (8, 5, 'Admin4', 'admin4@gmail.com', 'admin4', '', '$2y$10$OevuXYCVY30a6pDYANCkiOlUMWFJ2xZM7ZURMcGvX6L5bBElqfON2', '', '', '', '', '', '2019-06-21 09:36:33', '2019-06-21 09:36:33', NULL, 1, NULL, NULL);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
