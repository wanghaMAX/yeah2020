-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 2020-03-24 16:39:15
-- 服务器版本： 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aihotel`
--

-- --------------------------------------------------------

--
-- 表的结构 `aboc_ad`
--

CREATE TABLE `aboc_ad` (
  `adid` mediumint(4) NOT NULL,
  `name` char(200) NOT NULL DEFAULT '',
  `width` int(5) NOT NULL DEFAULT '0',
  `height` int(5) NOT NULL DEFAULT '0',
  `price` float(8,2) NOT NULL DEFAULT '0.00',
  `adduser` char(20) NOT NULL DEFAULT '',
  `addtime` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `aboc_ad`
--

INSERT INTO `aboc_ad` (`adid`, `name`, `width`, `height`, `price`, `adduser`, `addtime`) VALUES
(11, 'test_ad1', 200, 100, 90.00, 'aboc', 1251955780);

-- --------------------------------------------------------

--
-- 表的结构 `aboc_ad_order`
--

CREATE TABLE `aboc_ad_order` (
  `orderid` mediumint(6) NOT NULL,
  `adid` mediumint(4) NOT NULL DEFAULT '0',
  `title` char(220) NOT NULL DEFAULT '',
  `class` tinyint(1) NOT NULL DEFAULT '0',
  `url` char(220) NOT NULL DEFAULT '',
  `text` char(254) NOT NULL DEFAULT '',
  `img` char(200) NOT NULL DEFAULT '',
  `code` mediumtext NOT NULL,
  `price` float(8,2) NOT NULL DEFAULT '0.00',
  `bro` int(10) NOT NULL DEFAULT '0',
  `click` int(10) NOT NULL DEFAULT '0',
  `lastclick` int(10) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `startdate` int(10) NOT NULL DEFAULT '0',
  `stopdate` int(10) NOT NULL DEFAULT '0',
  `adduser` char(20) NOT NULL DEFAULT '',
  `addtime` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `aboc_ad_order`
--

INSERT INTO `aboc_ad_order` (`orderid`, `adid`, `title`, `class`, `url`, `text`, `img`, `code`, `price`, `bro`, `click`, `lastclick`, `state`, `startdate`, `stopdate`, `adduser`, `addtime`) VALUES
(75, 11, '11111111111', 2, '11111111111', '', 'upload/2009/09/03/0135540c061df1ff.jpg', '111111111111111', 0.00, 7, 0, 0, 1, 1251907200, 1252598400, 'aboc', 1251956154),
(76, 11, '1111111111111', 2, '11111111111', '1111111111111111111', 'upload/2009/09/03/021239fff43ded26.gif', '', 999.00, 2, 0, 0, 1, 1251907200, 1252598400, 'aboc', 1251958359);

-- --------------------------------------------------------

--
-- 表的结构 `aboc_user`
--

CREATE TABLE `aboc_user` (
  `uid` mediumint(8) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `state` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `aboc_user`
--

INSERT INTO `aboc_user` (`uid`, `username`, `password`, `email`, `state`) VALUES
(6, 'admin', '5eb25783dc93b1b14bbf5e647a26d19a', 'aboc@yiwuku.com', 1);

-- --------------------------------------------------------

--
-- 表的结构 `camerainfo`
--

CREATE TABLE `camerainfo` (
  `cameraid` int(11) NOT NULL,
  `location` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `crowdinfo`
--

CREATE TABLE `crowdinfo` (
  `infoid` int(11) NOT NULL,
  `cameraid` int(11) NOT NULL,
  `peoplecount` text NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `orderinfo`
--

CREATE TABLE `orderinfo` (
  `orderid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `roomid` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `prolevel` int(11) NOT NULL,
  `starttime` datetime NOT NULL,
  `endtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `roominfo`
--

CREATE TABLE `roominfo` (
  `roomid` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `roomnumber` varchar(10) NOT NULL,
  `rent` int(11) NOT NULL,
  `empty` int(11) NOT NULL,
  `roomtype` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `userinfo`
--

CREATE TABLE `userinfo` (
  `userid` int(11) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `feature` text,
  `isvip` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aboc_ad`
--
ALTER TABLE `aboc_ad`
  ADD PRIMARY KEY (`adid`),
  ADD KEY `adid` (`adid`);

--
-- Indexes for table `aboc_ad_order`
--
ALTER TABLE `aboc_ad_order`
  ADD PRIMARY KEY (`orderid`),
  ADD KEY `orderid` (`orderid`,`class`,`startdate`,`stopdate`,`adid`);

--
-- Indexes for table `aboc_user`
--
ALTER TABLE `aboc_user`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `state` (`state`);

--
-- Indexes for table `camerainfo`
--
ALTER TABLE `camerainfo`
  ADD PRIMARY KEY (`cameraid`);

--
-- Indexes for table `crowd_info`
--
ALTER TABLE `crowdinfo`
  ADD PRIMARY KEY (`infoid`),
  ADD KEY `cameraid` (`cameraid`);

--
-- Indexes for table `orderinfo`
--
ALTER TABLE `orderinfo`
  ADD PRIMARY KEY (`orderid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `roomid` (`roomid`);

--
-- Indexes for table `roominfo`
--
ALTER TABLE `roominfo`
  ADD PRIMARY KEY (`roomid`),
  ADD KEY `index_userinfo_userid` (`userid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`userid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `aboc_ad`
--
ALTER TABLE `aboc_ad`
  MODIFY `adid` mediumint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- 使用表AUTO_INCREMENT `aboc_ad_order`
--
ALTER TABLE `aboc_ad_order`
  MODIFY `orderid` mediumint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- 使用表AUTO_INCREMENT `aboc_user`
--
ALTER TABLE `aboc_user`
  MODIFY `uid` mediumint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `camerainfo`
--
ALTER TABLE `camerainfo`
  MODIFY `cameraid` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `crowd_info`
--
ALTER TABLE `crowdinfo`
  MODIFY `infoid` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `orderinfo`
--
ALTER TABLE `orderinfo`
  MODIFY `orderid` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `roominfo`
--
ALTER TABLE `roominfo`
  MODIFY `roomid` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


alter table `crowdinfo` add FOREIGN KEY(cameraid) references camerainfo(cameraid);

alter table `roominfo` add FOREIGN KEY(userid) references userinfo(userid);

alter table `orderinfo` add FOREIGN KEY(userid) references userinfo(userid);

alter table `orderinfo` add FOREIGN KEY(roomid) references roominfo(userid);


