/*
SQLyog Ultimate v11.52 (64 bit)
MySQL - 5.6.14 : Database - tinynetwork
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `backgrounds` */

CREATE TABLE `backgrounds` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `background_image` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Table structure for table `group_backgrounds` */

CREATE TABLE `group_backgrounds` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned NOT NULL,
  `background_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_background_to_background_id` (`background_id`),
  KEY `group_background_to_group_id` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

/*Table structure for table `groups` */

CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `description` tinytext COLLATE utf8_unicode_ci,
  `creation_date` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `post_comment_likes` */

CREATE TABLE `post_comment_likes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `post_comment_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_comment_likes_to_post_comment_id` (`post_comment_id`),
  CONSTRAINT `post_comments_likes_to_post_comment_id` FOREIGN KEY (`id`) REFERENCES `post_comments` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Table structure for table `post_comments` */

CREATE TABLE `post_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(100) DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `post_id` int(11) unsigned NOT NULL,
  `date` datetime DEFAULT NULL,
  `parent_comment_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `post_comments_to_post_id` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Table structure for table `post_likes` */

CREATE TABLE `post_likes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;

/*Table structure for table `post_pictures` */

CREATE TABLE `post_pictures` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `file_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `posts` */

CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(100) DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned NOT NULL,
  `date` datetime DEFAULT NULL,
  `post_image` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_to_group_id` (`group_id`),
  CONSTRAINT `post_to_group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Table structure for table `publication_comments` */

CREATE TABLE `publication_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(100) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `publication_id` int(11) unsigned NOT NULL,
  `date` datetime DEFAULT NULL,
  `parent_comment_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `publication_comments_to_publication_id` (`publication_id`),
  CONSTRAINT `publication_comments_to_publication_id` FOREIGN KEY (`publication_id`) REFERENCES `publications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `publication_likes` */

CREATE TABLE `publication_likes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `publication_id` int(11) unsigned NOT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `publication_likes_to_publication_id` (`publication_id`),
  KEY `publication_likes_to_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

/*Table structure for table `publications` */

CREATE TABLE `publications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `active` tinyint(1) DEFAULT '1',
  `admin_id` int(11) unsigned NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `content_url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `header_img` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `publication_to_admin` (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `states` */

CREATE TABLE `states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `user_groups` */

CREATE TABLE `user_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `users` */

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` tinytext COLLATE utf8_unicode_ci,
  `state_id` int(30) unsigned NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login_date` datetime DEFAULT NULL,
  `hash` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `device_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `push_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_img` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `active` tinyint(1) DEFAULT '1',
  `registration_date` datetime DEFAULT NULL,
  `is_admin` int(1) DEFAULT '0',
  `fb_accounts` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tw_accounts` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instagram` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `other_urls` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notif_all_posts` tinyint(1) DEFAULT '1',
  `notif_outpost_wall` tinyint(1) DEFAULT '1',
  `notif_group_wall` tinyint(1) DEFAULT '1',
  `notif_comments_on_my_posts` tinyint(1) DEFAULT '1',
  `notif_comments_on_posts_interact` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_to_state` (`state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
