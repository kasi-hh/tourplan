/*
SQLyog Ultimate v12.3.2 (64 bit)
MySQL - 5.6.23-log : Database - schuchardt
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`schuchardt` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `schuchardt`;

/*Table structure for table `adressen` */

DROP TABLE IF EXISTS `adressen`;

CREATE TABLE `adressen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `strasse` char(100) NOT NULL,
  `plz` char(10) DEFAULT NULL,
  `ort` char(100) NOT NULL,
  `telefon` char(20) DEFAULT NULL,
  `besonderheiten` text,
  `aufenthalt` int(10) unsigned DEFAULT '0',
  `rollator` int(1) unsigned DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

/*Data for the table `adressen` */

insert  into `adressen`(`id`,`name`,`strasse`,`plz`,`ort`,`telefon`,`besonderheiten`,`aufenthalt`,`rollator`,`ts`) values 
(2,'Beisemann','Ringstr. 20','53902','Bad Münstereifel (Maulbach)','02257 95 92 629','',5,0,'2017-03-29 11:52:48'),
(3,'Esser','Bonnerstr. 7','53913','Swisttal  (Miel)','02226 49 85','',0,0,'2017-03-29 11:05:03'),
(4,'Fleischer','Auf der Lehmwiese 14','53340','Meckenheim  (Merl)','02225  66 66','0225 6666   anrufen',0,0,'2017-03-29 11:05:42'),
(5,'Gödicker','Münstereifeler Str. 3','53505','Berg Freisheim','0157  590 87 86 0','',0,0,'2017-03-29 11:05:59'),
(6,'Gollenbeck','Euskirchenerweg 49','53359','Rheinbach','','',0,0,'2017-03-29 11:06:30'),
(7,'Heide','Turmblick 21','53359','Rheinbach','02226  162 75','',0,0,'2017-03-29 11:07:10'),
(8,'Justen','Windthorst Weg  4','53359','Rheinbach','02226  72 57','02226 7257  anrufen',0,0,'2017-03-29 11:07:26'),
(9,'Kirstein','Fritz Knoll Ring 27','53359','Rheinbach','0177   80 42 555','',0,0,'2017-03-29 11:07:41'),
(10,'Körbs','Dederichsgraben 3','53359','Rheinbach','','Rollator',0,1,'2017-04-13 16:45:34'),
(11,'Kuhnke','Im Ruhrfeld 41','53340','Meckenheim','02225 6563','',0,0,'2017-03-29 11:08:31'),
(12,'Küppers','Bruckner Weg 2','53359','Rheinbach','','Rollator',0,1,'2017-04-13 16:45:36'),
(13,'Lanzerath','Naturfreundeweg 6','53505','Berg','02643  10 93','',0,0,'2017-03-29 13:18:34'),
(14,'Löwer','Tombergerstr. 37','53359','Rheinbach  (Wormersdorf)','02225  13 714','Rollator',0,1,'2017-04-13 16:45:38'),
(15,'Meller','Am Junkersgarten 10','53913','Swisttal  (Buschhoven)','','',0,0,'2017-03-29 13:19:40'),
(16,'Meusel','Am  Erstdorfer Bach 6','53340','Meckenheim','','',0,0,'2017-03-29 13:20:06'),
(17,'Molis','Breslauer Str. 21','53913','Swisttal  (Morenhoven)','02226  79 69','vorne sitzen',0,0,'2017-03-29 13:22:18'),
(18,'Nußbaum','Talweg 4','53359','Rheinbach  (Merzbach)','02226  90 39 313','Rollator',0,1,'2017-04-13 16:45:41'),
(19,'Richter','Dederichsgraben 3','53359','Rheinbach','02226  13 490','',0,0,'2017-03-29 11:14:26'),
(20,'Scharrer','Sassestr. 1','53359','Rheinbach','','',0,0,'2017-03-29 11:14:31'),
(21,'Schröder','Zur Alten Kirche 12','53902','Bad Münstereifel  (Houverath)','','',0,0,'2017-03-29 13:23:19'),
(22,'Schwind','Grevelsberger Weg 7','53343','Wachtberg  (Vilip)','0228  32 54 38','HL     -   Stock',0,0,'2017-03-29 13:23:46'),
(23,'Segler','Eichenstr. 23','53359','Rheinbach  (Ramershoven)','','',0,0,'2017-03-29 13:24:17'),
(24,'Stolpmann','Neugartenstr. 24','53359','Rheinbach','02226  90 92 63','',0,0,'2017-03-29 11:14:20'),
(25,'Wentland','Breslauer Str.18','53359','Rheinbach','02226  89 19 100','rückwärts',0,0,'2017-04-13 16:46:02');

/*Table structure for table `tourdaten` */

DROP TABLE IF EXISTS `tourdaten`;

CREATE TABLE `tourdaten` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `plan_id` int(10) unsigned NOT NULL,
  `adresse_id` int(10) unsigned NOT NULL,
  `num` int(10) unsigned NOT NULL,
  `origin` char(200) DEFAULT NULL,
  `destination` char(200) DEFAULT NULL,
  `distance_text` char(100) DEFAULT NULL,
  `distance_value` int(11) DEFAULT NULL,
  `duration_text` char(100) DEFAULT NULL,
  `duration_value` int(11) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uni_gruppe_num` (`plan_id`,`num`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

/*Data for the table `tourdaten` */

insert  into `tourdaten`(`id`,`plan_id`,`adresse_id`,`num`,`origin`,`destination`,`distance_text`,`distance_value`,`duration_text`,`duration_value`,`ts`) values 
(17,2,2,1,NULL,'Ringstr. 20, Maulbach',NULL,NULL,NULL,NULL,'2017-03-24 18:35:55'),
(18,2,4,2,NULL,'Auf der Lehmwiese 14, 53340 Meckenheim, Deutschland','340 km',339594,'3 Stunden, 26 Minuten',12362,'2017-03-24 18:36:00'),
(19,1,3,1,NULL,'Bonnerstr. 7, Miel',NULL,NULL,NULL,NULL,'2017-03-28 23:01:16'),
(20,1,7,2,NULL,'Turmblick 21, 53359 Rheinbach, Deutschland','6,6 km',6621,'10 Minuten',588,'2017-03-28 23:01:24'),
(21,1,8,3,NULL,'Windthorstweg 4, 53359 Rheinbach, Deutschland','1,1 km',1095,'4 Minuten',228,'2017-03-28 23:01:52'),
(22,1,9,4,NULL,'Fritz-Knoll-Ring 27, 53359 Rheinbach, Deutschland','2,4 km',2371,'5 Minuten',313,'2017-03-28 23:02:00'),
(23,1,9,5,NULL,'Fritz-Knoll-Ring 27, 53359 Rheinbach, Deutschland','1 m',0,'1 Minute',0,'2017-03-28 23:02:01'),
(24,1,17,6,NULL,'Breslauer Str. 21, 53913 Swisttal, Deutschland','6,8 km',6796,'10 Minuten',572,'2017-03-29 10:26:18'),
(25,1,3,7,NULL,'Bonner Str. 7, 53913 Swisttal, Deutschland','4,5 km',4501,'6 Minuten',387,'2017-03-29 10:37:58'),
(26,2,2,3,NULL,'Ringstraße 20-22, 70736 Fellbach, Deutschland','338 km',338292,'3 Stunden, 24 Minuten',12237,'2017-03-29 10:46:38'),
(27,2,7,4,NULL,'Turmblick 21, 53359 Rheinbach, Deutschland','342 km',342270,'3 Stunden, 30 Minuten',12622,'2017-03-29 10:48:17'),
(28,2,9,5,NULL,'Fritz-Knoll-Ring 27, 53359 Rheinbach, Deutschland','1,3 km',1340,'4 Minuten',249,'2017-03-29 10:48:28'),
(29,2,2,6,NULL,'Ringstraße 20, 53902 Bad Münstereifel, Deutschland','11,9 km',11877,'14 Minuten',832,'2017-03-29 10:48:35'),
(30,2,18,7,NULL,'Talweg 4, 53359 Rheinbach, Deutschland','6,9 km',6891,'9 Minuten',566,'2017-03-29 10:48:56'),
(31,3,25,1,NULL,'Breslauer Str.18, Rheinbach',NULL,NULL,NULL,NULL,'2017-03-29 10:50:34'),
(32,3,2,2,NULL,'Ringstraße 20, 53902 Bad Münstereifel, Deutschland','9,7 km',9665,'13 Minuten',760,'2017-03-29 10:50:44'),
(33,3,13,3,NULL,'Naturfreundeweg 6, 53505 Berg, Deutschland','3,6 km',3587,'8 Minuten',453,'2017-03-29 10:51:08'),
(34,3,18,4,NULL,'Talweg 4, 53359 Rheinbach, Deutschland','8,6 km',8643,'12 Minuten',706,'2017-03-29 10:51:18'),
(35,3,10,5,NULL,'Dederichsgraben 3, 53359 Rheinbach, Deutschland','3,1 km',3058,'5 Minuten',299,'2017-03-29 10:51:28'),
(36,3,25,6,NULL,'Breslauer Str. 18, 53359 Rheinbach, Deutschland','0,4 km',376,'1 Minute',69,'2017-03-29 10:51:35'),
(37,1,7,8,NULL,'Turmblick 21, 53359 Rheinbach, Deutschland','6,6 km',6621,'10 Minuten',588,'2017-03-29 17:41:15'),
(38,4,15,1,NULL,'Am Junkersgarten 10,53913 Swisttal  (Buschhoven)',NULL,NULL,NULL,NULL,'2017-03-29 17:52:28'),
(39,4,9,2,NULL,'Fritz-Knoll-Ring 27, 53359 Rheinbach, Deutschland','8,9 km',8883,'12 Minuten',744,'2017-03-29 17:52:44'),
(40,4,24,3,NULL,'Neugartenstraße 24, 53359 Rheinbach, Deutschland','2,1 km',2089,'5 Minuten',297,'2017-03-29 17:52:57'),
(41,4,7,4,NULL,'Turmblick 21, 53359 Rheinbach, Deutschland','0,7 km',708,'3 Minuten',152,'2017-03-29 17:53:07'),
(42,4,12,5,NULL,'Brucknerweg 2, 53359 Rheinbach, Deutschland','1,0 km',1047,'3 Minuten',184,'2017-03-29 17:53:19'),
(43,4,25,6,NULL,'Breslauer Str. 18, 53359 Rheinbach, Deutschland','0,6 km',620,'2 Minuten',100,'2017-03-29 17:53:27'),
(44,5,3,1,NULL,'Bonnerstr. 7,53913 Swisttal  (Miel)',NULL,NULL,NULL,NULL,'2017-03-30 10:45:11'),
(45,5,17,2,NULL,'Breslauer Str. 21, 53913 Swisttal, Deutschland','4,5 km',4478,'6 Minuten',387,'2017-03-30 10:45:22'),
(46,5,23,3,NULL,'Eichenstraße 23, 53359 Rheinbach, Deutschland','4,6 km',4615,'6 Minuten',387,'2017-03-30 10:45:32'),
(47,5,14,4,NULL,'Tomberger Str. 37, 53359 Rheinbach, Deutschland','5,7 km',5679,'9 Minuten',519,'2017-03-30 10:45:42'),
(48,5,20,5,NULL,'Sassestraße 1, 53359 Rheinbach, Deutschland','5,9 km',5888,'10 Minuten',570,'2017-03-30 10:45:55'),
(49,5,12,6,NULL,'Brucknerweg 2, 53359 Rheinbach, Deutschland','1,5 km',1456,'4 Minuten',255,'2017-03-30 10:46:10'),
(50,5,19,7,NULL,'Dederichsgraben 3, 53359 Rheinbach, Deutschland','0,4 km',433,'1 Minute',71,'2017-03-30 10:46:17'),
(51,5,25,8,NULL,'Breslauer Str. 18, 53359 Rheinbach, Deutschland','0,4 km',376,'1 Minute',69,'2017-03-30 10:46:23'),
(52,1,5,9,NULL,'Münstereifeler Str. 3, 53505 Berg, Deutschland','11,1 km',11078,'16 Minuten',974,'2017-04-05 15:28:20');

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
