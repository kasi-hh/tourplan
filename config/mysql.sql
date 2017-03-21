/*
SQLyog Ultimate v12.3.2 (64 bit)
MySQL - 5.5.23 : Database - schuchardt
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`schuchardt` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `schuchardt`;

/*Table structure for table `personen` */

DROP TABLE IF EXISTS `personen`;

CREATE TABLE `personen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `strasse` char(100) NOT NULL,
  `plz` char(10) NOT NULL,
  `ort` char(100) NOT NULL,
  `aufenthalt` int(10) unsigned NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `personen` */

/*Table structure for table `tourdaten` */

DROP TABLE IF EXISTS `tourdaten`;

CREATE TABLE `tourdaten` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `plan_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `num` int(10) unsigned NOT NULL,
  `reisezeit` int(10) unsigned NOT NULL,
  `reisezeit_text` char(50) NOT NULL,
  `entfernung` int(10) unsigned NOT NULL,
  `entfernung_text` char(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_gruppe_num` (`plan_id`,`num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tourdaten` */

/*Table structure for table `tourplan` */

DROP TABLE IF EXISTS `tourplan`;

CREATE TABLE `tourplan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bezeichnung` char(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `tourplan` */

insert  into `tourplan`(`id`,`bezeichnung`) values 
(1,'Montag'),
(2,'Dienstag'),
(3,'Mittwoch'),
(4,'Donnerstag'),
(5,'Freitag'),
(6,'Samstag'),
(7,'Sonntag');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
