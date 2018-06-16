-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2018 at 03:31 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new`
--

-- --------------------------------------------------------

--
-- Table structure for table `td_asmin`
--

CREATE TABLE `td_asmin` (
  `id_am` int(11) NOT NULL,
  `am_fname` varchar(32) NOT NULL,
  `am_lname` varchar(32) NOT NULL,
  `am_username` varchar(32) NOT NULL,
  `am_email` varchar(80) NOT NULL,
  `am_password` varchar(32) NOT NULL,
  `am_state` int(11) NOT NULL,
  `am_type` varchar(5000) NOT NULL,
  `am_lastlogin` int(11) NOT NULL,
  `state_admin` int(11) DEFAULT NULL,
  `admin_lastRes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `td_asmin`
--

INSERT INTO `td_asmin` (`id_am`, `am_fname`, `am_lname`, `am_username`, `am_email`, `am_password`, `am_state`, `am_type`, `am_lastlogin`, `state_admin`, `admin_lastRes`) VALUES
(1, 'مدیریت', '', 'admin', 'info@monix.ir', '3b1426f9c2798db6484b94dccfb0d6ad', 1, '0', 0, 1, 1529059038);

-- --------------------------------------------------------

--
-- Table structure for table `td_department`
--

CREATE TABLE `td_department` (
  `id_dep` int(11) NOT NULL,
  `dep_title` varchar(60) NOT NULL,
  `dep_dicription` varchar(1000) NOT NULL,
  `dep_state` int(11) NOT NULL,
  `dp_setting` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `td_file`
--

CREATE TABLE `td_file` (
  `id_fl` int(11) NOT NULL,
  `fl_filename` varchar(320) NOT NULL,
  `fl_code` varchar(64) NOT NULL,
  `fl_type` varchar(64) NOT NULL,
  `fl_min_path` varchar(120) NOT NULL,
  `fl_full_path` varchar(180) NOT NULL,
  `fl_user_id` int(11) NOT NULL,
  `fl_state` int(11) NOT NULL,
  `fl_timestamp` int(11) NOT NULL,
  `fl_size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `td_personaliz`
--

CREATE TABLE `td_personaliz` (
  `id_Pr` int(11) NOT NULL,
  `pr_key` varchar(64) NOT NULL,
  `pr_value` text NOT NULL,
  `pr_group` varchar(64) NOT NULL,
  `pr_setting` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `td_setting`
--

CREATE TABLE `td_setting` (
  `id_se` int(11) NOT NULL,
  `se_Key` varchar(32) NOT NULL,
  `se_value` text NOT NULL,
  `se_group` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `td_setting`
--

INSERT INTO `td_setting` (`id_se`, `se_Key`, `se_value`, `se_group`) VALUES
(1, 'website_template', 'v1', 'monix'),
(2, 'site_title', 'اسکریپت پشتیبانی مونیکس', 'monix'),
(3, 'mail_stamp', '', 'mail'),
(4, 'SMTP_HOST', '', 'mail'),
(5, 'SMTP_username', '', 'mail'),
(6, 'SMTP_password', '', 'mail'),
(8, 'SMTP_port', '', 'mail'),
(10, 'admin_email', 'info@email.com', 'monix'),
(11, 'min_len_pass', '6', 'monix'),
(12, 'max_len_pass', '32', 'monix'),
(13, 'min_len_username', '3', 'monix'),
(14, 'max_len_username', '16', 'monix'),
(15, 'max_len_name', '32', 'monix'),
(16, 'max_len_dicirption_user', '2000', 'monix'),
(17, 'register_new_user', '1', 'monix'),
(18, 'send_tiket_goust', '1', 'monix'),
(19, 'max_len_file', '1048576', 'monix'),
(20, 'admin_file_name', 'admin', 'monix'),
(21, 'api_key', '{\"api_key\":102465,\"url\":\"http://localhost\",\"state\":1}', 'monix'),
(22, 'api_key', '{\"api_key\":1024655956985,\"url\":\"http://localhost\",\"state\":1}', 'monix'),
(23, 'site_logo', 'Connect/upload\\/pic/site/logo_logo_1.png', 'monix'),
(24, 'fav_logo', 'Connect/upload\\/pic/site/fav_fav_1.jpg', 'monix');

-- --------------------------------------------------------

--
-- Table structure for table `td_tiket`
--

CREATE TABLE `td_tiket` (
  `id_tiket` int(11) NOT NULL,
  `tk_code` varchar(64) COLLATE utf8_persian_ci NOT NULL,
  `tk_title` varchar(150) COLLATE utf8_persian_ci NOT NULL,
  `tk_massage` text COLLATE utf8_persian_ci NOT NULL,
  `tk_olaviat` int(11) NOT NULL,
  `tk_departmen` int(11) NOT NULL,
  `tk_state` int(11) NOT NULL,
  `tk_parent` int(11) NOT NULL,
  `tk_user_id` int(11) NOT NULL,
  `tk_timestamp_in` int(11) NOT NULL,
  `tk_timestamp_res` int(11) NOT NULL,
  `tk_date_in` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tk_date_res` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tk_last_req` int(11) NOT NULL,
  `tk_file` int(11) NOT NULL,
  `tk_ip` varchar(32) COLLATE utf8_persian_ci NOT NULL,
  `tk_email` varchar(64) COLLATE utf8_persian_ci NOT NULL,
  `tk_name` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `code_msg` int(11) NOT NULL,
  `admin_id_res` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `td_user`
--

CREATE TABLE `td_user` (
  `id_user` int(11) NOT NULL,
  `s_full_name` varchar(30) NOT NULL,
  `s_username` varchar(32) NOT NULL,
  `s_password` varchar(32) NOT NULL,
  `s_email` varchar(32) NOT NULL,
  `s_reg_in_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `s_reg_in_time` int(11) NOT NULL,
  `s_lastlog_time` int(11) NOT NULL,
  `s_state` int(11) NOT NULL,
  `s_ip` varchar(60) NOT NULL,
  `s_dicription` varchar(5000) NOT NULL,
  `f2` int(11) NOT NULL,
  `f3` int(11) NOT NULL,
  `f4` int(11) NOT NULL,
  `f5` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `td_user`
--

INSERT INTO `td_user` (`id_user`, `s_full_name`, `s_username`, `s_password`, `s_email`, `s_reg_in_date`, `s_reg_in_time`, `s_lastlog_time`, `s_state`, `s_ip`, `s_dicription`, `f2`, `f3`, `f4`, `f5`) VALUES
(2, 'مونیکس', 'demo', '3b1426f9c2798db6484b94dccfb0d6ad', 'takfashomal@gmail.com', '1395-06-02 22:10:00', 0, 1529058224, 1, '::1', '', 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `td_asmin`
--
ALTER TABLE `td_asmin`
  ADD PRIMARY KEY (`id_am`);

--
-- Indexes for table `td_department`
--
ALTER TABLE `td_department`
  ADD PRIMARY KEY (`id_dep`);

--
-- Indexes for table `td_file`
--
ALTER TABLE `td_file`
  ADD PRIMARY KEY (`id_fl`);

--
-- Indexes for table `td_personaliz`
--
ALTER TABLE `td_personaliz`
  ADD PRIMARY KEY (`id_Pr`);

--
-- Indexes for table `td_setting`
--
ALTER TABLE `td_setting`
  ADD PRIMARY KEY (`id_se`);

--
-- Indexes for table `td_tiket`
--
ALTER TABLE `td_tiket`
  ADD PRIMARY KEY (`id_tiket`);

--
-- Indexes for table `td_user`
--
ALTER TABLE `td_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `td_asmin`
--
ALTER TABLE `td_asmin`
  MODIFY `id_am` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `td_department`
--
ALTER TABLE `td_department`
  MODIFY `id_dep` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `td_file`
--
ALTER TABLE `td_file`
  MODIFY `id_fl` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `td_personaliz`
--
ALTER TABLE `td_personaliz`
  MODIFY `id_Pr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=745;

--
-- AUTO_INCREMENT for table `td_setting`
--
ALTER TABLE `td_setting`
  MODIFY `id_se` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `td_tiket`
--
ALTER TABLE `td_tiket`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `td_user`
--
ALTER TABLE `td_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
