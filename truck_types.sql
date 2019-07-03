/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.30-MariaDB : Database - etrucking
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

/*Table structure for table `truck_types` */

DROP TABLE IF EXISTS `truck_types`;

CREATE TABLE `truck_types` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `config` varchar(20) DEFAULT NULL,
  `amount` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `jbi_1` int(10) DEFAULT NULL,
  `jbi_2` int(10) DEFAULT NULL,
  `tire` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `truck_types` */

insert  into `truck_types`(`id`,`config`,`amount`,`name`,`jbi_1`,`jbi_2`,`tire`) values (1,'1 - 1',2,'Truk Engkel Tunggal',12,12,4),(2,'1 - 2',2,'Truk Engkel Ganda',16,14,6),(3,'1.1 - 2',3,'Truk Trintin	',18,16,8),(4,'1 - 2.2',3,'Truk Tronton',22,20,10),(5,'1.1 - 2.2',4,'Truk Trinton',30,26,12),(6,'1 - 2 - 2.2',4,'Truk Trailer Engkel',34,28,14),(7,'1 - 2 - 2.2.2',5,'Truk Trailer Engkel',40,32,18),(8,'1 - 2.2 - 2.2',5,'Truk Trailer Tronton',40,32,18),(9,'1 - 2.2 - 2.2.2',6,'Truk Trailer Tronton',43,40,22);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
