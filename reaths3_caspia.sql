-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 21, 2014 at 03:00 PM
-- Server version: 5.5.35-33.0-log
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `reaths3_caspia`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `answer_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `answer_content` varchar(2000) NOT NULL,
  `answer_creatorID` bigint(20) NOT NULL,
  `answer_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `answer_votes` bigint(20) NOT NULL,
  PRIMARY KEY (`answer_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) COLLATE cp1251_bulgarian_ci NOT NULL,
  PRIMARY KEY (`category_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 COLLATE=cp1251_bulgarian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `question_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `question_creatorID` bigint(20) NOT NULL,
  `question_title` varchar(100) NOT NULL,
  `question_content` varchar(2000) NOT NULL,
  `question_tags` varchar(200) NOT NULL,
  `question_categoryID` tinyint(3) unsigned NOT NULL,
  `question_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `question_views` bigint(20) NOT NULL,
  `question_votes` bigint(20) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `tag_name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL,
  `user_password` varchar(64) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_rank` tinyint(1) NOT NULL,
  `user_avatar` varchar(1000) NOT NULL,
  `user_xp` bigint(20) NOT NULL,
  `user_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
