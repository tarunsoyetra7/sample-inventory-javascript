/*
SQLyog Ultimate v8.55 
MySQL - 5.5.24-log : Database - inventory
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`inventory` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `inventory`;

/*Table structure for table `letter_in_out` */

DROP TABLE IF EXISTS `letter_in_out`;

CREATE TABLE `letter_in_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `letter_user` int(11) DEFAULT NULL,
  `letter_s_name` text,
  `letter_in_out` int(11) DEFAULT NULL,
  `letter_type` int(11) DEFAULT NULL,
  `letter_date` text,
  `letter_id` double DEFAULT NULL,
  `letter_sub` text,
  `letter_add` text,
  `flag` int(11) DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_on` text,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `letter_in_out` */

insert  into `letter_in_out`(`id`,`letter_user`,`letter_s_name`,`letter_in_out`,`letter_type`,`letter_date`,`letter_id`,`letter_sub`,`letter_add`,`flag`,`created_by`,`created_on`,`updated_by`,`updated_on`) values (1,2,'Amit Kumar',1,1,'2019-12-06',1,'t','buvbewuvbue',1,1,'2019-05-19 15:54:21',1,'2019-05-22 13:36:55'),(2,2,'The One',2,1,'2019-12-02',3,'enioeu','bugb3ubg',0,1,'2019-05-19 15:56:08',NULL,NULL),(3,1,'Amit Kumar',1,2,'2019-05-22',456,'time pass','faltu hai',1,1,'2019-05-22 13:57:04',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
