-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 17, 2014 at 08:12 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `b89`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `u_email` varchar(200) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `date` varchar(200) NOT NULL,
  `text` longtext NOT NULL,
  `chat_hash` text NOT NULL,
  `ip` varchar(200) NOT NULL,
  `display` int(11) NOT NULL,
  `archived` int(2) NOT NULL,
  `report` int(2) NOT NULL,
  `reporter` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;


-- --------------------------------------------------------

--
-- Table structure for table `forgot`
--

CREATE TABLE IF NOT EXISTS `forgot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `key` varchar(200) NOT NULL,
  `exptime` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `gen_contact`
--

CREATE TABLE IF NOT EXISTS `gen_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `sub` varchar(200) NOT NULL,
  `msg` longtext NOT NULL,
  `ip` varchar(200) NOT NULL,
  `time` varchar(200) NOT NULL,
  `read` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `reported_links`
--

CREATE TABLE IF NOT EXISTS `reported_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `site` varchar(20) NOT NULL,
  `code` text NOT NULL,
  `time` varchar(200) NOT NULL,
  `ip` varchar(200) NOT NULL,
  `csrf_token` varchar(200) NOT NULL,
  `email` text NOT NULL,
  `total_count` int(2) NOT NULL,
  `report_generated` int(2) NOT NULL,
  `month` varchar(20) NOT NULL,
  `year` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;
-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(200) NOT NULL,
  `csrf_token` varchar(200) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7576 ;


-- --------------------------------------------------------

--
-- Table structure for table `site_news`
--

CREATE TABLE IF NOT EXISTS `site_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(200) NOT NULL,
  `month` varchar(200) NOT NULL,
  `year` varchar(200) NOT NULL,
  `updated` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `news` text NOT NULL,
  `news_type` int(2) NOT NULL,
  `hash` varchar(500) NOT NULL,
  `time` varchar(200) NOT NULL,
  `show` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` varchar(15) NOT NULL,
  `type` varchar(200) NOT NULL,
  `response_to` varchar(200) NOT NULL,
  `response_by` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `priority` int(2) NOT NULL,
  `read` int(2) NOT NULL,
  `question` text NOT NULL,
  `category` varchar(200) NOT NULL,
  `text` longtext NOT NULL,
  `time` varchar(200) NOT NULL,
  `closed` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `url_table`
--

CREATE TABLE IF NOT EXISTS `url_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` longtext NOT NULL,
  `site` varchar(20) NOT NULL,
  `code` text CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `u_email` varchar(200) NOT NULL,
  `create_time` varchar(100) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `hash` text NOT NULL,
  `archived` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `url_visit`
--

CREATE TABLE IF NOT EXISTS `url_visit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `site` text NOT NULL,
  `code` varchar(500) NOT NULL,
  `email` varchar(200) NOT NULL,
  `csrf_token` varchar(20) NOT NULL,
  `ip` varchar(200) NOT NULL,
  `expire_time` int(11) NOT NULL,
  `month` varchar(20) NOT NULL,
  `year` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1481 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) CHARACTER SET utf8 NOT NULL,
  `pass` tinytext NOT NULL,
  `fname` varchar(200) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `uname` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type` varchar(200) NOT NULL,
  `hash` text NOT NULL,
  `ip` varchar(200) NOT NULL,
  `urefcode` varchar(20) NOT NULL,
  `ref` varchar(20) NOT NULL,
  `active` int(2) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`,`uname`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_chart`
--

CREATE TABLE IF NOT EXISTS `user_chart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `month_year` varchar(200) NOT NULL,
  `valid_link` int(11) NOT NULL,
  `invalid_link` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_reports`
--

CREATE TABLE IF NOT EXISTS `user_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(200) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `report_type` int(2) NOT NULL,
  `report_title` text NOT NULL,
  `report_text` longtext NOT NULL,
  `time` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_report_count`
--

CREATE TABLE IF NOT EXISTS `user_report_count` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `count` int(2) NOT NULL,
  `deactivated` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vul_report`
--

CREATE TABLE IF NOT EXISTS `vul_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `title` varchar(200) NOT NULL,
  `msg` longtext NOT NULL,
  `level` varchar(10) NOT NULL,
  `date` varchar(200) NOT NULL,
  `vul_id` varchar(11) NOT NULL,
  `ip` varchar(200) NOT NULL,
  `read` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `vul_reporters`
--

CREATE TABLE IF NOT EXISTS `vul_reporters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bug_id` varchar(200) NOT NULL,
  `reporter` varchar(200) NOT NULL,
  `pic` text NOT NULL,
  `fb` varchar(200) NOT NULL,
  `twt` varchar(200) NOT NULL,
  `gplus` varchar(200) NOT NULL,
  `li` varchar(200) NOT NULL,
  `pers_web` varchar(200) NOT NULL,
  `text` longtext NOT NULL,
  `time` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
