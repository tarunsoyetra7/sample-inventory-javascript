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

/*Table structure for table `authentication` */

DROP TABLE IF EXISTS `authentication`;

CREATE TABLE `authentication` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_field_name` text,
  `a_field_url` text,
  `parent_id` int(11) DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_on` text,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` text,
  `flag` varchar(6) DEFAULT 'true',
  `a_priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `authentication` */

insert  into `authentication`(`a_id`,`a_field_name`,`a_field_url`,`parent_id`,`created_by`,`created_on`,`updated_by`,`updated_on`,`flag`,`a_priority`) values (1,'Dashboard Page Master','add_web_pages.php',0,NULL,NULL,NULL,NULL,'true',0),(2,'Employee Master','add_employee.php',0,NULL,NULL,NULL,NULL,'true',0),(3,'Authentication Master ','authentication_page.php',0,NULL,NULL,NULL,NULL,'true',0),(4,'Profile Setting','edit_employee.php',0,NULL,NULL,NULL,NULL,'true',0),(6,'Storage Management','item_master.php',0,NULL,NULL,NULL,NULL,'true',0),(7,'Ward Master','ward_master.php',0,NULL,NULL,NULL,NULL,'true',0),(9,'Unit Master','unit_master.php',0,NULL,NULL,NULL,NULL,'true',0),(10,'Aawak Jawak Management','letter_in_out.php',0,NULL,NULL,NULL,NULL,'true',0),(11,'Notification Of Aawak Jawak','approve_aj.php',0,NULL,NULL,NULL,NULL,'true',0);

/*Table structure for table `item_detail_master` */

DROP TABLE IF EXISTS `item_detail_master`;

CREATE TABLE `item_detail_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` text,
  `item_unit` int(11) DEFAULT NULL,
  `item_type` int(11) DEFAULT NULL,
  `machine_number` text,
  `item_quantity` double DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_on` text,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `item_detail_master` */

insert  into `item_detail_master`(`id`,`item_name`,`item_unit`,`item_type`,`machine_number`,`item_quantity`,`created_by`,`created_on`,`updated_by`,`updated_on`) values (1,'Lime Powder',1,1,NULL,12,1,'2019-03-27 20:26:23',1,'2019-04-25 14:27:35'),(2,'Acid',1,1,NULL,2,1,'2019-03-27 20:29:55',3,'2019-04-04 16:31:19'),(5,'Phenyl',2,1,NULL,3,1,'2019-03-27 21:53:46',3,'2019-04-04 16:37:19'),(6,'charcoal',1,1,'',2,3,'2019-04-05 14:46:06',1,'2019-05-02 14:06:45'),(7,'Fogging Machine',3,2,'10023',1,1,'2019-04-23 18:24:27',1,'2019-04-23 18:34:49'),(8,'Bricks',3,1,'',60,1,'2019-05-04 13:31:25',1,'2019-05-04 14:37:26');

/*Table structure for table `item_master` */

DROP TABLE IF EXISTS `item_master`;

CREATE TABLE `item_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `ward_id` tinytext,
  `item_date` text,
  `item_quantity` double DEFAULT NULL,
  `in_out_type` int(11) DEFAULT NULL,
  `intake_type` int(11) DEFAULT NULL,
  `intake_name` text,
  `created_by` int(11) DEFAULT NULL,
  `created_on` text,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` text,
  `flag` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `item_master` */

insert  into `item_master`(`id`,`item_id`,`ward_id`,`item_date`,`item_quantity`,`in_out_type`,`intake_type`,`intake_name`,`created_by`,`created_on`,`updated_by`,`updated_on`,`flag`) values (1,1,'0','2019-03-23',1.5,1,1,'Tarun',3,'2019-03-29 20:36:01',NULL,NULL,0),(2,1,'0','2019-03-24',3,1,3,'Amit',3,'2019-03-29 20:44:24',NULL,NULL,1),(3,1,'1','2019-03-24',2.5,2,0,'',3,'2019-03-29 20:45:16',NULL,NULL,0),(4,2,'0','2019-04-03',10,1,2,'Abhi',3,'2019-04-04 16:30:07',NULL,NULL,0),(5,2,'1','2019-04-05',8,2,0,'',3,'2019-04-04 16:31:19',NULL,NULL,0),(6,5,'0','2019-04-01',5,1,3,'ravi',3,'2019-04-04 16:36:18',NULL,NULL,0),(7,5,'4','2019-04-03',2,2,0,'',3,'2019-04-04 16:37:19',NULL,NULL,0),(8,6,'0','2019-04-12',5,1,1,'tarhhh',3,'2019-04-05 15:18:35',NULL,NULL,0),(9,6,'4','2019-04-05',5,2,0,'',3,'2019-04-05 15:19:04',NULL,NULL,0),(10,7,'0','2019-04-07',1,1,2,'main shop',1,'2019-04-23 18:34:49',NULL,NULL,0),(11,1,'1','2019-04-10',6,3,0,'',1,'2019-04-25 14:25:22',NULL,NULL,0),(12,1,'4','2019-04-01',4,3,0,'',1,'2019-04-25 14:27:36',NULL,NULL,0),(13,6,'1','2019-05-09',2,3,0,'',1,'2019-05-02 14:05:43',1,'2019-05-02 14:06:45',0),(14,8,'0','2019-05-01',100,1,1,'Main Store',1,'2019-05-04 13:32:04',NULL,NULL,0),(17,8,'1,3','2019-05-02',80,2,0,'',1,'2019-05-04 13:45:30',NULL,NULL,0),(18,8,'1,3','2019-05-02',40,3,0,'',1,'2019-05-04 14:37:26',NULL,NULL,0);

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

/*Table structure for table `login_status` */

DROP TABLE IF EXISTS `login_status`;

CREATE TABLE `login_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_id` int(11) DEFAULT NULL,
  `login_date_time` text,
  `flag` varchar(6) DEFAULT 'true',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `login_status` */

insert  into `login_status`(`id`,`login_id`,`login_date_time`,`flag`) values (1,1,'2019-03-22 11:50:54','true'),(2,2,'2019-03-22 15:37:53','true'),(3,1,'2019-03-22 15:39:34','true'),(4,1,'2019-03-22 15:42:00','true'),(5,1,'2019-03-22 17:38:36','true'),(6,2,'2019-03-22 18:05:18','true'),(7,2,'2019-03-22 18:06:12','true'),(8,1,'2019-03-22 18:06:37','true'),(9,1,'2019-03-22 18:15:21','true'),(10,1,'2019-03-22 18:17:48','true'),(11,1,'2019-03-22 18:19:10','true'),(12,1,'2019-03-26 17:20:57','true'),(13,2,'2019-03-27 13:38:55','true'),(14,1,'2019-03-27 19:07:19','true'),(15,1,'2019-03-27 19:07:21','true'),(16,1,'2019-03-29 20:27:57','true'),(17,3,'2019-03-29 20:29:49','true'),(18,1,'2019-04-23 17:32:25','true'),(19,2,'2019-05-19 17:14:16','true'),(20,1,'2019-05-22 13:24:56','true');

/*Table structure for table `unit_master` */

DROP TABLE IF EXISTS `unit_master`;

CREATE TABLE `unit_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_sym` text,
  `created_by` int(11) DEFAULT NULL,
  `created_on` text,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `unit_master` */

insert  into `unit_master`(`id`,`unit_sym`,`created_by`,`created_on`,`updated_by`,`updated_on`) values (1,'kg',1,'2019-04-23 17:56:15',1,'2019-04-23 17:56:46'),(2,'litre',1,'2019-04-23 17:56:54',NULL,NULL),(3,'piece',1,'2019-04-23 17:57:02',NULL,NULL);

/*Table structure for table `user_infromation` */

DROP TABLE IF EXISTS `user_infromation`;

CREATE TABLE `user_infromation` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` text,
  `user_pass` text,
  `login_type` varchar(10) DEFAULT 'admin',
  `user_auth` text,
  `delstatus` int(11) NOT NULL DEFAULT '0',
  `profile_ext` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `user_infromation` */

insert  into `user_infromation`(`user_id`,`user_name`,`user_pass`,`login_type`,`user_auth`,`delstatus`,`profile_ext`) values (1,'tarun','soyetra','admin','10,3,1,2,11,4,6,9,7',0,NULL),(2,'abhishek','abhi','admin','11,4',0,''),(3,'ak','theone','admin','3,1,2,4,6,7',0,'');

/*Table structure for table `ward_master` */

DROP TABLE IF EXISTS `ward_master`;

CREATE TABLE `ward_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ward_id` int(11) DEFAULT NULL,
  `ward_name` text,
  `created_by` int(11) DEFAULT NULL,
  `created_on` text,
  `updated_by` int(11) DEFAULT NULL,
  `updated_on` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `ward_master` */

insert  into `ward_master`(`id`,`ward_id`,`ward_name`,`created_by`,`created_on`,`updated_by`,`updated_on`) values (1,1,'Nehru Nagar',1,'2019-03-27 22:10:41',NULL,NULL),(3,2,'Smriti Nagar',1,'2019-03-27 22:12:38',NULL,NULL),(4,3,'Junwani',3,'2019-04-04 16:29:35',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
