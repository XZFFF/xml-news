-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 2019-04-14 12:55:47
-- 服务器版本： 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `xml_news`
--
CREATE DATABASE IF NOT EXISTS `xml_news` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `xml_news`;

-- --------------------------------------------------------

--
-- 表的结构 `lists`
--

DROP TABLE IF EXISTS `lists`;
CREATE TABLE `lists` (
  `id` int(11) NOT NULL COMMENT '栏目id',
  `name` varchar(255) NOT NULL COMMENT '栏目名称',
  `sort` int(11) NOT NULL COMMENT '栏目权重，从大到小排序',
  `is_show` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='新闻栏目表';

-- --------------------------------------------------------

--
-- 表的结构 `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL COMMENT '新闻id',
  `lists_id` int(11) NOT NULL COMMENT '所属栏目id',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `author` varchar(64) NOT NULL COMMENT '作者',
  `summary` text NOT NULL COMMENT '摘要',
  `content` text NOT NULL COMMENT '内容',
  `publish_time` datetime NOT NULL COMMENT '发布时间，排序从近到远',
  `is_show` tinyint(1) NOT NULL COMMENT '是否发布'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='新闻表';

-- --------------------------------------------------------

--
-- 表的结构 `views`
--

DROP TABLE IF EXISTS `views`;
CREATE TABLE `views` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `view_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='浏览表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `lists`
--
ALTER TABLE `lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '栏目id', AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '新闻id', AUTO_INCREMENT=21;
--
-- 使用表AUTO_INCREMENT `views`
--
ALTER TABLE `views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;