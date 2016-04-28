-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2016-04-28 03:40:50
-- 伺服器版本: 10.1.9-MariaDB
-- PHP 版本： 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `ckan_mapping`
--
CREATE DATABASE IF NOT EXISTS `ckan_mapping` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ckan_mapping`;

-- --------------------------------------------------------

--
-- 資料表結構 `dataset`
--

CREATE TABLE `dataset` (
  `did` int(10) NOT NULL,
  `oid` int(10) NOT NULL,
  `d_data_fname` varchar(20) NOT NULL,
  `d_name` varchar(50) NOT NULL,
  `d_url` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `organizations`
--

CREATE TABLE `organizations` (
  `oid` int(10) NOT NULL,
  `o_oid` varchar(50) NOT NULL,
  `o_organ_fname` varchar(50) NOT NULL COMMENT '相似機關主要名稱',
  `o_name` varchar(50) NOT NULL,
  `o_dataset_url` mediumtext NOT NULL,
  `o_city` varchar(20) NOT NULL,
  `o_packages` int(10) NOT NULL COMMENT '資料集數量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `dataset`
--
ALTER TABLE `dataset`
  ADD UNIQUE KEY `did` (`did`);

--
-- 資料表索引 `organizations`
--
ALTER TABLE `organizations`
  ADD UNIQUE KEY `oid` (`oid`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `dataset`
--
ALTER TABLE `dataset`
  MODIFY `did` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=790;
--
-- 使用資料表 AUTO_INCREMENT `organizations`
--
ALTER TABLE `organizations`
  MODIFY `oid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
