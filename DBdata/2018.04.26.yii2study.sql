-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 年 04 月 26 日 14:33
-- 服务器版本: 5.5.48-log
-- PHP 版本: 5.6.22

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `yii2study`
--

-- --------------------------------------------------------


--
-- 表的结构 `ys_auth_assignment`
--

CREATE TABLE IF NOT EXISTS `ys_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ys_auth_item`
--

CREATE TABLE IF NOT EXISTS `ys_auth_item` (
  `name` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `rule_name` varchar(64) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- 表的结构 `ys_auth_item_child`
--

CREATE TABLE IF NOT EXISTS `ys_auth_item_child` (
  `parent` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `child` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- 表的结构 `ys_auth_rule`
--

CREATE TABLE IF NOT EXISTS `ys_auth_rule` (
  `name` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ys_menu`
--

CREATE TABLE IF NOT EXISTS `ys_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ys_migration`
--

CREATE TABLE IF NOT EXISTS `ys_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `ys_migration`
--

INSERT INTO `ys_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1524556384),
('m140506_102106_rbac_init', 1524556416),
('m140602_111327_create_menu_table', 1524556387),
('m160312_050000_create_user', 1524556387),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1524556416);

-- --------------------------------------------------------

--
-- 表的结构 `ys_user`
--

CREATE TABLE IF NOT EXISTS `ys_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32)  NOT NULL,
  `auth_key` varchar(32)  NOT NULL,
  `password_hash` varchar(255)  NOT NULL,
  `password_reset_token` varchar(255)  DEFAULT NULL,
  `email` varchar(255)  NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=1 ;

--
-- 限制导出的表
--

--
-- 限制表 `ys_auth_assignment`
--
ALTER TABLE `ys_auth_assignment`
  ADD CONSTRAINT `ys_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `ys_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `ys_auth_item`
--
ALTER TABLE `ys_auth_item`
  ADD CONSTRAINT `ys_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `ys_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `ys_auth_item_child`
--
ALTER TABLE `ys_auth_item_child`
  ADD CONSTRAINT `ys_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ys_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ys_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `ys_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `ys_menu`
--
ALTER TABLE `ys_menu`
  ADD CONSTRAINT `ys_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ys_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
