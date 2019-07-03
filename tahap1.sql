/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.7.14-google-log : Database - etrucking
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`etrucking` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `etrucking`;

/*Table structure for table `menus` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `menus` */

/*Table structure for table `user_roles` */

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL COMMENT 'FILLED WITH ID USER',
  `updated_by` int(11) DEFAULT NULL COMMENT 'FILLED WITH ID USER',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'FILLED WITH ID USER',
  PRIMARY KEY (`id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user_roles` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_role_id` int(11) DEFAULT NULL COMMENT 'user_role_id = 0 for client mobile apps',
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 NOT NULL,
  `user_phone` varchar(13) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `user_image` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_bank` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_bank_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL COMMENT 'FILLED WITH ID USER',
  `updated_by` int(11) DEFAULT NULL COMMENT 'FILLED WITH ID USER',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'FILLED WITH ID USER',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`user_role_id`,`name`,`email`,`username`,`user_phone`,`password`,`user_image`,`company_name`,`bank_name`,`account_bank`,`account_bank_name`,`vendor_id`,`created_at`,`updated_at`,`deleted_at`,`created_by`,`updated_by`,`deleted_by`) values (1,1,'Alvian','aalviian@gmail.com','aalviian',NULL,'$2y$10$5Xb551gL1mmU5fEE2dQUJ.2ERpaoaAkeOVtart4uBk4wkDa44nZNq',NULL,NULL,NULL,NULL,NULL,NULL,'2019-06-13 04:46:44','2019-06-14 03:01:32',NULL,0,NULL,NULL),(2,1,'Admin','admin@gmail.com','admin','','$2y$10$/CtgaZawUj2nudzrRfbnlOx4ZOVhyTikrHhhszv4tUuoIfrga4Rja','','','','','',NULL,'2019-06-15 01:51:17','2019-06-15 01:51:17',NULL,0,NULL,NULL);

/*Table structure for table `vendors` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `vendors` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
