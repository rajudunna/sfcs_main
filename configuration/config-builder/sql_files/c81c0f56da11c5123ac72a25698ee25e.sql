-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3366
-- Generation Time: Jan 21, 2018 at 03:28 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wms`
--

-- --------------------------------------------------------

--
-- Table structure for table `approval_status_log`
--

CREATE TABLE `approval_status_log` (
  `id` int(11) NOT NULL,
  `do_itm_app_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `approval_status_log`
--

INSERT INTO `approval_status_log` (`id`, `do_itm_app_id`, `created_at`, `updated_at`, `status`, `remarks`) VALUES
(1, 2, '2018-01-18 18:21:04', '2018-01-18 18:21:04', 'reserve', 'updated at the stage of scan in central werehouse..'),
(2, 2, '2018-01-18 18:22:31', '2018-01-18 18:22:31', 'receive', 'updated at the Final receive by requisted wh..'),
(3, 19, '2018-01-18 18:31:31', '2018-01-18 18:31:31', 'approved', 'updated at the Final receive by requisted warehouse..'),
(4, 20, '2018-01-18 18:31:51', '2018-01-18 18:31:51', 'approved', 'updated at the Final receive by requisted warehouse..'),
(5, 19, '2018-01-18 18:34:38', '2018-01-18 18:34:38', 'reserve', 'updated at the stage of scan in central werehouse..'),
(6, 20, '2018-01-18 18:37:06', '2018-01-18 18:37:06', 'reserve', 'updated at the stage of scan in central werehouse..'),
(7, 18, '2018-01-18 06:17:36', '2018-01-18 06:17:36', 'approved', 'Insert into do approvals table..'),
(8, 13, '2018-01-18 06:31:14', '2018-01-18 06:31:14', 'approved', 'Insert into do approvals table..'),
(9, 20, '2018-01-18 06:32:51', '2018-01-18 06:32:51', 'approved', 'Insert into do approvals table..'),
(10, 21, '2018-01-18 06:33:23', '2018-01-18 06:33:23', 'approved', 'Insert into do approvals table..'),
(11, 21, '2018-01-18 06:52:25', '2018-01-18 06:52:25', 'reserve', 'updated at the stage of scan in central werehouse..'),
(12, 21, '2018-01-18 06:59:37', '2018-01-18 06:59:37', 'security_out', 'Updated approvals table with security out status..'),
(13, 18, '2018-01-18 07:24:13', '2018-01-18 07:24:13', 'security_out', 'Updated approvals table with security out status..'),
(14, 18, '2018-01-18 07:30:18', '2018-01-18 07:30:19', 'security_out', 'Updated approvals table with security out status..'),
(15, 16, '2018-01-18 07:34:22', '2018-01-18 07:34:22', 'security_out', 'Updated approvals table with security out status..'),
(16, 17, '2018-01-18 07:34:22', '2018-01-18 07:34:22', 'security_out', 'Updated approvals table with security out status..'),
(17, 18, '2018-01-18 07:34:22', '2018-01-18 07:34:22', 'security_out', 'Updated approvals table with security out status..'),
(18, 16, '2018-01-18 07:36:09', '2018-01-18 07:36:09', 'security_in', 'Updated approvals table with security in status..'),
(19, 17, '2018-01-18 07:36:10', '2018-01-18 07:36:10', 'security_in', 'Updated approvals table with security in status..'),
(20, 18, '2018-01-18 07:36:10', '2018-01-18 07:36:10', 'security_in', 'Updated approvals table with security in status..'),
(21, 21, '2018-01-19 01:03:52', '2018-01-19 01:03:52', 'reserve', 'updated at the stage of scan in central werehouse..'),
(22, 20, '2018-01-19 02:07:13', '2018-01-19 02:07:13', 'reserve', 'updated at the stage of scan in central werehouse..'),
(23, 3, '2018-01-19 02:34:23', '2018-01-19 02:34:23', 'receive', 'updated at the Final receive by requisted warehouse..'),
(24, 2, '2018-01-19 02:35:59', '2018-01-19 02:35:59', 'receive', 'updated at the Final receive by requisted warehouse..'),
(25, 22, '2018-01-19 21:19:18', '2018-01-19 21:19:18', 'approved', 'Insert into do approvals table..'),
(26, 23, '2018-01-19 21:19:18', '2018-01-19 21:19:18', 'approved', 'Insert into do approvals table..'),
(27, 22, '2018-01-19 21:26:03', '2018-01-19 21:26:03', 'reserve', 'updated at the stage of scan in central werehouse..'),
(28, 23, '2018-01-19 21:26:11', '2018-01-19 21:26:11', 'reserve', 'updated at the stage of scan in central werehouse..'),
(29, 22, '2018-01-19 21:29:12', '2018-01-19 21:29:12', 'security_out', 'Updated approvals table with security out status..'),
(30, 23, '2018-01-19 21:29:12', '2018-01-19 21:29:12', 'security_out', 'Updated approvals table with security out status..'),
(31, 22, '2018-01-19 21:30:12', '2018-01-19 21:30:12', 'security_in', 'Updated approvals table with security in status..'),
(32, 23, '2018-01-19 21:30:12', '2018-01-19 21:30:12', 'security_in', 'Updated approvals table with security in status..');

-- --------------------------------------------------------

--
-- Table structure for table `do`
--

CREATE TABLE `do` (
  `do_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `do_seq_no` varchar(10) NOT NULL,
  `schedule` varchar(40) NOT NULL,
  `from_wh_id` int(11) NOT NULL,
  `to_wh_id` int(11) NOT NULL,
  `type` enum('DO','RO') DEFAULT NULL,
  `item_code` varchar(40) NOT NULL,
  `do_ro_type` varchar(3) NOT NULL,
  `transcation_reson_id` varchar(3) NOT NULL,
  `status` enum('open','inprogress','close') NOT NULL,
  `approval_status` enum('approved','partially_approved','rejected') DEFAULT NULL,
  `security_status` enum('security_out','security_in') DEFAULT NULL,
  `m3_message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `do`
--

INSERT INTO `do` (`do_id`, `created_at`, `updated_at`, `do_seq_no`, `schedule`, `from_wh_id`, `to_wh_id`, `type`, `item_code`, `do_ro_type`, `transcation_reson_id`, `status`, `approval_status`, `security_status`, `m3_message`) VALUES
(1, '2018-01-12 07:18:53', '2018-01-12 07:18:53', 'D9000001', '121', 9, 2, 'DO', '', 'I01', 'A', 'open', '', 'security_out', ''),
(2, '2018-01-12 07:31:04', '2018-01-12 07:31:04', 'D407000002', '112121', 9, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(3, '2018-01-12 07:31:57', '2018-01-19 18:51:22', 'D407000003', '112121', 9, 2, 'DO', '', 'I01', 'A', 'close', NULL, NULL, '0'),
(4, '2018-01-12 07:42:11', '2018-01-12 07:42:11', 'D407000004', '112121', 9, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(5, '2018-01-12 07:43:50', '2018-01-12 07:43:50', 'R207000001', '112121', 18, 2, 'RO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(6, '2018-01-12 07:44:55', '2018-01-12 07:44:55', 'D407000005', '121221', 9, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(7, '2018-01-12 07:45:50', '2018-01-12 07:45:50', 'R407000001', '110001', 9, 2, 'RO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(8, '2018-01-12 08:32:36', '2018-01-12 08:32:36', 'R207000002', '10001', 18, 2, 'RO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(9, '2018-01-12 08:38:55', '2018-01-12 08:38:55', 'D207000001', '100', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(10, '2018-01-12 08:40:25', '2018-01-12 08:40:25', 'D207000002', '100', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(11, '2018-01-12 08:40:27', '2018-01-12 08:40:27', 'D207000003', '100', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(12, '2018-01-12 08:40:27', '2018-01-12 08:40:27', 'D207000004', '100', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(13, '2018-01-12 08:40:27', '2018-01-12 08:40:27', 'D207000005', '100', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(14, '2018-01-12 08:40:27', '2018-01-12 08:40:27', 'D207000006', '100', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(17, '2018-01-12 08:43:56', '2018-01-12 08:43:56', 'D207000007', '100', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(18, '2018-01-12 09:40:24', '2018-01-19 18:39:07', 'D407000006', '11111', 9, 2, 'DO', '', 'I01', 'A', 'inprogress', NULL, NULL, 'HTTP/1.0 200 OK\r\nCache-Control: no-cache, private\r\nContent-Type:  application/json\r\nDate:          Fri, 19 Jan 2018 18:39:07 GMT\r\n\r\n{\"error\":\"mvxAccess() returned: 8 NOK            2000001661038\"}'),
(19, '2018-01-12 09:43:19', '2018-01-19 18:40:39', 'D407000007', '11111', 9, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, 'HTTP/1.0 200 OK\r\nCache-Control: no-cache, private\r\nContent-Type:  application/json\r\nDate:          Fri, 19 Jan 2018 18:40:39 GMT\r\n\r\n{\"error\":\"mvxAccess() returned: 8 NOK            2000001661039\"}'),
(20, '2018-01-12 09:52:13', '2018-01-19 19:28:55', 'D407000008', '11111', 9, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, 'HTTP/1.0 200 OK\r\nCache-Control: no-cache, private\r\nContent-Type:  application/json\r\nDate:          Fri, 19 Jan 2018 19:26:47 GMT\r\n\r\n{\"error\":\"internal server error0\"}'),
(21, '2018-01-12 09:53:39', '2018-01-12 09:53:39', 'D407000009', '11111', 9, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(22, '2018-01-12 09:55:47', '2018-01-12 09:55:47', 'D407000010', '11111', 9, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(23, '2018-01-12 09:57:22', '2018-01-19 21:43:51', 'D407000011', '11111', 9, 2, 'DO', '', 'I01', 'A', 'close', NULL, NULL, '0'),
(24, '2018-01-12 09:58:57', '2018-01-12 09:59:18', 'D407000012', '11111', 9, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, 'HTTP/1.0 200 OK\r\nCache-Control: no-cache, private\r\nContent-Type:  application/json\r\nDate:          Fri, 12 Jan 2018 09:59:18 GMT\r\n\r\n{\"error\":\"internal server error0\"}'),
(25, '2018-01-13 07:00:12', '2018-01-13 07:00:33', 'D407000013', '1234', 9, 2, 'DO', '', 'I11', 'AA3', 'open', NULL, NULL, 'HTTP/1.0 200 OK\r\nCache-Control: no-cache, private\r\nContent-Type:  application/json\r\nDate:          Sat, 13 Jan 2018 07:00:33 GMT\r\n\r\n{\"error\":\"internal server error0\"}'),
(26, '2018-01-13 07:00:14', '2018-01-13 07:00:35', 'D407000014', '1234', 9, 2, 'DO', '', 'I11', 'AA3', 'open', NULL, NULL, 'HTTP/1.0 200 OK\r\nCache-Control: no-cache, private\r\nContent-Type:  application/json\r\nDate:          Sat, 13 Jan 2018 07:00:35 GMT\r\n\r\n{\"error\":\"internal server error0\"}'),
(27, '2018-01-13 07:00:29', '2018-01-13 07:00:50', 'D407000015', '1234', 9, 2, 'DO', '', 'I11', 'AA3', 'open', NULL, NULL, 'HTTP/1.0 200 OK\r\nCache-Control: no-cache, private\r\nContent-Type:  application/json\r\nDate:          Sat, 13 Jan 2018 07:00:50 GMT\r\n\r\n{\"error\":\"internal server error0\"}'),
(28, '2018-01-13 09:05:23', '2018-01-13 09:05:45', 'D207000008', '10000001', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, 'HTTP/1.0 200 OK\r\nCache-Control: no-cache, private\r\nContent-Type:  application/json\r\nDate:          Sat, 13 Jan 2018 09:05:45 GMT\r\n\r\n{\"error\":\"internal server error0\"}'),
(29, '2018-01-13 09:23:54', '2018-01-13 09:24:16', 'R407000002', 'SDS65', 9, 2, 'RO', '', 'I23', 'AA1', 'open', NULL, NULL, 'HTTP/1.0 200 OK\r\nCache-Control: no-cache, private\r\nContent-Type:  application/json\r\nDate:          Sat, 13 Jan 2018 09:24:16 GMT\r\n\r\n{\"error\":\"internal server error0\"}'),
(30, '2018-01-13 09:39:26', '2018-01-13 09:39:48', 'D207000009', '125MKL', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, 'HTTP/1.0 200 OK\r\nCache-Control: no-cache, private\r\nContent-Type:  application/json\r\nDate:          Sat, 13 Jan 2018 09:39:48 GMT\r\n\r\n{\"error\":\"internal server error0\"}'),
(31, '2018-01-18 02:33:33', '2018-01-18 02:38:22', 'D207000010', 'test0101', 18, 2, 'DO', '', 'N01', 'A', 'inprogress', NULL, NULL, '0'),
(32, '2018-01-18 18:31:09', '2018-01-18 18:34:38', 'D407000016', '1000121', 9, 2, 'DO', '', 'I01', 'A', 'inprogress', NULL, NULL, '0'),
(33, '2018-01-18 06:30:40', '2018-01-18 06:52:25', 'D407000017', '123456', 9, 2, 'DO', '', 'I08', 'AA2', 'inprogress', NULL, NULL, '0'),
(34, '2018-01-18 23:48:58', '2018-01-18 23:49:20', 'D207000011', '11111', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, 'HTTP/1.0 200 OK\r\nCache-Control: no-cache, private\r\nContent-Type:  application/json\r\nDate:          Thu, 18 Jan 2018 23:49:20 GMT\r\n\r\n{\"error\":\"internal server error0\"}'),
(35, '2018-01-19 00:17:42', '2018-01-19 00:17:45', 'D207000012', '11111', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, 'HTTP/1.0 200 OK\r\nCache-Control: no-cache, private\r\nContent-Type:  application/json\r\nDate:          Fri, 19 Jan 2018 00:17:45 GMT\r\n\r\n{\"MSGN\":\"0001661027\"}'),
(36, '2018-01-19 00:26:18', '2018-01-19 00:26:19', 'D207000013', '111', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, ''),
(37, '2018-01-19 00:27:28', '2018-01-19 00:27:29', 'D207000014', '111', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, ''),
(38, '2018-01-19 00:28:26', '2018-01-19 00:28:27', 'D207000015', '111', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, ''),
(39, '2018-01-19 00:29:31', '2018-01-19 00:29:31', 'D207000016', '111', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(40, '2018-01-19 00:30:25', '2018-01-19 00:30:25', 'D207000017', '111', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(41, '2018-01-19 00:30:47', '2018-01-19 00:30:47', 'D207000018', '111', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(42, '2018-01-19 00:33:40', '2018-01-19 00:33:40', 'D207000019', '1111', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0'),
(43, '2018-01-19 00:36:16', '2018-01-19 00:36:17', 'D207000020', '1111', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, ''),
(44, '2018-01-19 00:37:21', '2018-01-19 00:37:22', 'D207000021', '1111', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, ''),
(45, '2018-01-19 00:42:08', '2018-01-19 00:42:08', 'D207000022', '1111', 18, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0001661037'),
(46, '2018-01-19 19:54:41', '2018-01-19 19:57:01', 'D407000018', '12321', 9, 2, 'DO', '', 'I01', 'A', 'open', NULL, NULL, 'HTTP/1.0 200 OK\r\nCache-Control: no-cache, private\r\nContent-Type:  application/json\r\nDate:          Fri, 19 Jan 2018 19:57:01 GMT\r\n\r\n{\"error\":\"mvxAccess() returned: 8 NOK            2000001661054\"}'),
(47, '2018-01-19 21:10:13', '2018-01-19 21:26:03', 'D207000023', '451236', 18, 2, 'DO', '', 'I01', 'AA2', 'inprogress', NULL, NULL, '0001661056'),
(48, '2018-01-19 23:19:07', '2018-01-20 01:21:53', 'DN52000001', '1112121', 121, 123, 'DO', '', 'I01', 'AA2', 'open', NULL, NULL, '0001661057'),
(49, '2018-01-20 01:26:34', '2018-01-20 01:26:58', 'DN52000002', '1111111', 121, 123, 'DO', '', 'I01', 'AA2', 'open', NULL, NULL, '0001661058'),
(50, '2018-01-20 01:30:52', '2018-01-20 01:31:11', 'DN52000003', '1111111', 121, 123, 'DO', '', 'I01', 'AA2', 'open', NULL, NULL, '0001661059'),
(51, '2018-01-20 01:38:03', '2018-01-20 01:38:33', 'D407000019', '112122', 9, 2, 'DO', '', 'I01', 'AA2', 'open', NULL, NULL, 'HTTP/1.0 200 OK\r\nCache-Control: no-cache, private\r\nContent-Type:  application/json\r\nDate:          Sat, 20 Jan 2018 01:38:33 GMT\r\n\r\n{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"       \",\"error\":\"mvxAccess() returned: 8 NOK            2000001661061\",\"Get_Last_Error\":\"NOK            2000001661061\"}'),
(52, '2018-01-20 02:18:30', '2018-01-20 02:20:57', 'DN51000001', '11212121', 120, 123, 'DO', '', 'I01', 'AA2', 'open', NULL, NULL, '0001661062'),
(53, '2018-01-21 01:23:22', '2018-01-21 01:25:39', 'DN51000002', '1111121', 120, 123, 'DO', '', 'I01', 'A', 'open', NULL, NULL, '0001661063');

-- --------------------------------------------------------

--
-- Table structure for table `do_items`
--

CREATE TABLE `do_items` (
  `do_items_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `do_id` int(11) NOT NULL,
  `item_code` varchar(40) NOT NULL,
  `style` varchar(40) NOT NULL,
  `item_description` text NOT NULL,
  `color` varchar(40) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` enum('open','reserve','sin','sout','closed') NOT NULL,
  `service_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `do_items`
--

INSERT INTO `do_items` (`do_items_id`, `created_at`, `updated_at`, `do_id`, `item_code`, `style`, `item_description`, `color`, `quantity`, `status`, `service_status`) VALUES
(1, '2018-01-12 07:31:57', '2018-01-12 07:31:57', 3, 'OM1FAB0001 0005', '', '8867/Anesoft TKT160/2500m Thread', '', 10, 'open', 0),
(2, '2018-01-12 07:31:57', '2018-01-19 02:35:59', 3, 'QC1FAB0001 0001', '', 'AP_mills/90\" Fabric', '', 10, 'closed', 0),
(3, '2018-01-12 07:42:12', '2018-01-12 07:42:12', 4, 'OM1FAB0001 0005', '', '8867/Anesoft TKT160/2500m Thread', '', 10, 'open', 0),
(4, '2018-01-12 07:42:12', '2018-01-12 07:42:12', 4, 'QC1FAB0001 0001', '', 'AP_mills/90\" Fabric', '', 10, 'open', 0),
(5, '2018-01-12 07:43:50', '2018-01-12 07:43:50', 5, 'OM1FAB0001 0005', '', '8867/Anesoft TKT160/2500m Thread', '', 10, 'open', 0),
(6, '2018-01-12 07:44:55', '2018-01-12 07:44:55', 6, 'OM1FAB0001 0005', '', '8867/Anesoft TKT160/2500m Thread', '', 10, 'open', 0),
(7, '2018-01-12 07:44:55', '2018-01-12 07:44:55', 6, 'QC1FAB0001 0001', '', 'AP_mills/90\" Fabric', '', 10, 'open', 0),
(8, '2018-01-12 07:45:50', '2018-01-12 07:45:50', 7, 'OM1FAB0001 0005', '', '8867/Anesoft TKT160/2500m Thread', '', 10, 'open', 0),
(9, '2018-01-12 07:45:50', '2018-01-12 07:45:50', 7, 'QC1FAB0001 0001', '', 'AP_mills/90\" Fabric', '', 10, 'open', 0),
(10, '2018-01-12 08:32:36', '2018-01-12 08:32:36', 8, 'OM1FAB0001 0005', '', '8867/Anesoft TKT160/2500m Thread', '', 10, 'open', 0),
(11, '2018-01-12 08:32:36', '2018-01-12 08:32:36', 8, 'QC1FAB0001 0001', '', 'AP_mills/90\" Fabric', '', 10, 'open', 0),
(12, '2018-01-12 08:43:56', '2018-01-12 08:43:56', 17, 'OM1FAB0001 0005', '', '8867/Anesoft TKT160/2500m Thread', '', 10, 'open', 0),
(13, '2018-01-12 09:40:24', '2018-01-12 09:40:24', 18, 'OM1FAB0001 0005', '', '8867/Anesoft TKT160/2500m Thread', '', 10, 'open', 0),
(14, '2018-01-12 09:40:24', '2018-01-18 06:31:14', 18, 'QC1FAB0001 0001', '', 'AP_mills/90\" Fabric', '', 10, 'sout', 0),
(15, '2018-01-12 09:43:19', '2018-01-12 09:43:19', 19, 'OM1FAB0001 0005', '', '8867/Anesoft TKT160/2500m Thread', '', 10, 'open', 0),
(16, '2018-01-12 09:43:19', '2018-01-12 09:43:19', 19, 'QC1FAB0001 0001', '', 'AP_mills/90\" Fabric', '', 10, 'open', 0),
(17, '2018-01-12 09:52:13', '2018-01-12 09:52:13', 20, 'OM1FAB0001 0005', '', '8867/Anesoft TKT160/2500m Thread', '', 10, 'open', 0),
(18, '2018-01-12 09:52:13', '2018-01-12 09:52:13', 20, 'QC1FAB0001 0001', '', 'AP_mills/90\" Fabric', '', 10, 'open', 0),
(19, '2018-01-12 09:53:39', '2018-01-12 09:53:39', 21, 'OM1FAB0001 0005', '', '8867/Anesoft TKT160/2500m Thread', '', 10, 'open', 0),
(20, '2018-01-12 09:53:39', '2018-01-12 09:53:39', 21, 'QC1FAB0001 0001', '', 'AP_mills/90\" Fabric', '', 10, 'open', 0),
(21, '2018-01-12 09:55:47', '2018-01-12 09:55:47', 22, 'OM1FAB0001 0005', '', '8867/Anesoft TKT160/2500m Thread', '', 10, 'open', 0),
(22, '2018-01-12 09:55:47', '2018-01-12 09:55:47', 22, 'QC1FAB0001 0001', '', 'AP_mills/90\" Fabric', '', 10, 'open', 0),
(23, '2018-01-12 09:57:22', '2018-01-12 09:57:22', 23, 'OM1FAB0001 0005', '', '8867/Anesoft TKT160/2500m Thread', '', 10, 'open', 0),
(24, '2018-01-12 09:57:22', '2018-01-19 02:34:23', 23, 'QC1FAB0001 0001', '', 'AP_mills/90\" Fabric', '', 10, 'closed', 0),
(25, '2018-01-12 09:58:57', '2018-01-12 09:58:57', 24, 'OM1FAB0001 0005', '', '8867/Anesoft TKT160/2500m Thread', '', 10, 'open', 0),
(26, '2018-01-12 09:58:57', '2018-01-12 09:58:57', 24, 'QC1FAB0001 0001', '', 'AP_mills/90\" Fabric', '', 10, 'open', 0),
(27, '2018-01-13 07:00:12', '2018-01-13 07:00:12', 25, 'CK1FAB0058 0001', '', 'LPSJ561412/B/59** Solid Fabric', '', 10, 'open', 0),
(28, '2018-01-13 07:00:14', '2018-01-13 07:00:14', 26, 'CK1FAB0058 0001', '', 'LPSJ561412/B/59** Solid Fabric', '', 10, 'open', 0),
(29, '2018-01-13 07:00:29', '2018-01-13 07:00:29', 27, 'CK1FAB0058 0001', '', 'LPSJ561412/B/59** Solid Fabric', '', 10, 'open', 0),
(30, '2018-01-13 09:23:54', '2018-01-13 09:23:54', 29, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 0),
(31, '2018-01-13 09:39:26', '2018-01-13 09:39:26', 30, 'CK1FAB0055 0001', '', '1753/140cm-Tricot Fabric', '', 15, 'open', 0),
(32, '2018-01-18 02:33:33', '2018-01-18 07:36:09', 31, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'sin', 0),
(33, '2018-01-18 02:33:33', '2018-01-18 07:36:09', 31, 'MS3PKG0617', '', 'MSBRA1130B-LH Hanger', '', 10, 'sin', 0),
(34, '2018-01-18 18:31:09', '2018-01-18 06:32:51', 32, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'sout', 0),
(35, '2018-01-18 18:31:09', '2018-01-18 18:37:06', 32, 'CK1FAB0055 0001', '', '1753/140cm-Tricot Fabric', '', 10, 'reserve', 0),
(36, '2018-01-18 06:30:40', '2018-01-19 01:03:52', 33, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 15, 'reserve', 0),
(37, '2018-01-18 06:30:40', '2018-01-18 06:30:40', 33, 'MS3PKG0617', '', 'MSBRA1130B-LH Hanger', '', 15, 'open', 0),
(38, '2018-01-18 06:30:40', '2018-01-18 06:30:40', 33, 'CK1FAB0055 0001', '', '1753/140cm-Tricot Fabric', '', 15, 'open', 0),
(39, '2018-01-18 23:48:58', '2018-01-18 23:48:58', 34, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 0),
(40, '2018-01-18 23:48:58', '2018-01-18 23:48:58', 34, 'CK1FAB0058 0001', '', 'LPSJ561412/B/59** Solid Fabric', '', 10, 'open', 0),
(41, '2018-01-19 00:17:42', '2018-01-19 00:17:42', 35, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 0),
(42, '2018-01-19 00:26:18', '2018-01-19 00:26:18', 36, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 0),
(43, '2018-01-19 00:27:28', '2018-01-19 00:27:28', 37, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 0),
(44, '2018-01-19 00:28:26', '2018-01-19 00:28:26', 38, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 0),
(45, '2018-01-19 00:29:31', '2018-01-19 00:29:31', 39, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 0),
(46, '2018-01-19 00:30:25', '2018-01-19 00:30:25', 40, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 0),
(47, '2018-01-19 00:30:47', '2018-01-19 00:30:47', 41, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 0),
(48, '2018-01-19 00:33:40', '2018-01-19 00:33:40', 42, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 0),
(49, '2018-01-19 00:36:16', '2018-01-19 00:36:16', 43, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 0),
(50, '2018-01-19 00:37:21', '2018-01-19 18:44:47', 45, 'CK1FAB0058 0001', '', 'LPSJ561412/B/59** Solid Fabric', '', 10, 'open', 1),
(51, '2018-01-19 00:42:08', '2018-01-19 00:42:08', 45, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 1),
(52, '2018-01-19 19:54:41', '2018-01-19 19:54:41', 46, 'BE1FAB0001 0005', '', 'MPSJ019209/60\" Fabric', '', 10, 'open', 0),
(53, '2018-01-19 19:54:41', '2018-01-19 19:54:41', 46, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 0),
(54, '2018-01-19 19:54:41', '2018-01-19 20:37:08', 45, 'CK1FAB0055 0001', '', '1753/140cm-Tricot Fabric', '', 10, 'open', 1),
(55, '2018-01-19 21:10:13', '2018-01-19 21:30:12', 47, 'BE1FAB0001 0005', '', 'MPSJ019209/60\" Fabric', '', 10, 'sin', 1),
(56, '2018-01-19 21:10:13', '2018-01-19 21:16:58', 47, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 20, 'open', 1),
(57, '2018-01-19 21:10:13', '2018-01-19 21:16:58', 47, 'CK1FAB0058 0001', '', 'LPSJ561412/B/59** Solid Fabric', '', 10, 'open', 1),
(58, '2018-01-19 21:10:13', '2018-01-19 21:16:59', 47, 'MS2THR0014 0004', '', 'AP_mills/90\" Fabric', '', 40, 'open', 1),
(59, '2018-01-19 23:19:07', '2018-01-20 01:21:53', 48, 'BE1FAB0001 0005', '', 'MPSJ019209/60\" Fabric', '', 10, 'open', 1),
(60, '2018-01-19 23:19:07', '2018-01-19 23:19:07', 48, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 0),
(61, '2018-01-19 23:19:07', '2018-01-19 23:19:07', 48, 'CK1FAB0055 0001', '', '1753/140cm-Tricot Fabric', '', 10, 'open', 0),
(62, '2018-01-20 01:26:34', '2018-01-20 01:26:58', 49, 'BE1FAB0001 0005', '', 'MPSJ019209/60\" Fabric', '', 10, 'open', 1),
(63, '2018-01-20 01:26:34', '2018-01-20 01:26:34', 49, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 0),
(64, '2018-01-20 01:26:34', '2018-01-20 01:26:34', 49, 'CK1FAB0055 0001', '', '1753/140cm-Tricot Fabric', '', 10, 'open', 0),
(65, '2018-01-20 01:30:52', '2018-01-20 01:31:11', 50, 'BE1FAB0001 0005', '', 'MPSJ019209/60\" Fabric', '', 10, 'open', 1),
(66, '2018-01-20 01:30:52', '2018-01-20 01:31:12', 50, 'CK1FAB0054 0001', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 1),
(67, '2018-01-20 01:30:52', '2018-01-20 01:31:13', 50, 'CK1FAB0055 0001', '', '1753/140cm-Tricot Fabric', '', 10, 'open', 1),
(68, '2018-01-20 01:38:03', '2018-01-20 01:38:03', 51, 'BE1FAB0001 0005', '', 'MPSJ019209/60\" Fabric', '', 10, 'open', 0),
(69, '2018-01-20 02:18:30', '2018-01-20 02:20:57', 52, 'K50912S7TH2 004', '', 'MPSJ019209/60\" Fabric', '', 10, 'open', 1),
(70, '2018-01-20 02:18:30', '2018-01-20 02:20:58', 52, 'K50912S7TH3 002', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 1),
(71, '2018-01-20 02:18:30', '2018-01-20 02:20:58', 52, 'K50912S7TH4 002', '', '1753/140cm-Tricot Fabric', '', 10, 'open', 1),
(72, '2018-01-21 01:23:22', '2018-01-21 01:25:39', 53, 'K50912S7TH2 004', '', 'MPSJ019209/60\" Fabric', '', 10, 'open', 1),
(73, '2018-01-21 01:23:22', '2018-01-21 01:25:39', 53, 'K50912S7TH3 002', '', 'H0082/118cm Stabilized Tricot Lining Fabric', '', 10, 'open', 1),
(74, '2018-01-21 01:23:22', '2018-01-21 01:25:40', 53, 'K50912S7TH4 002', '', '1753/140cm-Tricot Fabric', '', 10, 'open', 1);

-- --------------------------------------------------------

--
-- Table structure for table `do_items_approval`
--

CREATE TABLE `do_items_approval` (
  `do_itm_app_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `do_id` int(11) NOT NULL,
  `do_items_id` int(11) NOT NULL,
  `lot_no` varchar(40) NOT NULL,
  `roll_id` int(11) NOT NULL,
  `shade_group` varchar(40) DEFAULT NULL,
  `approved_qty` int(11) NOT NULL,
  `reserve_qty` int(11) NOT NULL,
  `receive_qty` int(11) NOT NULL,
  `status` enum('approved','reserve','security_out','security_in','receive') NOT NULL,
  `m3_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `do_items_approval`
--

INSERT INTO `do_items_approval` (`do_itm_app_id`, `created_at`, `updated_at`, `do_id`, `do_items_id`, `lot_no`, `roll_id`, `shade_group`, `approved_qty`, `reserve_qty`, `receive_qty`, `status`, `m3_status`) VALUES
(1, '2018-01-15 01:01:42', '2018-01-18 18:22:31', 3, 2, '1709080860', 14, NULL, 5, 5, 5, 'receive', 0),
(2, '2018-01-15 01:01:42', '2018-01-19 02:35:59', 3, 2, '1709273191', 31, 'B', 5, 5, 5, 'receive', 0),
(3, '2018-01-15 01:11:15', '2018-01-19 02:34:23', 23, 24, '1709080860', 15, NULL, 5, 0, 5, 'receive', 0),
(4, '2018-01-17 00:39:21', '2018-01-17 00:39:21', 4, 4, '1709080860', 16, NULL, 5, 0, 0, 'approved', 0),
(5, '2018-01-17 00:39:21', '2018-01-17 00:39:21', 4, 4, '1709080860', 17, NULL, 5, 0, 0, 'reserve', 0),
(6, '2018-01-18 00:49:06', '2018-01-18 00:49:06', 6, 7, '1709080860', 14, NULL, 6, 0, 0, 'approved', 0),
(7, '2018-01-18 00:49:06', '2018-01-18 00:49:06', 6, 7, '1709080860', 18, NULL, 3, 0, 0, 'approved', 0),
(8, '2018-01-18 00:49:06', '2018-01-18 01:03:25', 6, 7, '1709080860', 19, NULL, 1, 1, 0, 'reserve', 0),
(9, '2018-01-18 00:52:42', '2018-01-18 00:52:42', 7, 9, '1709080860', 20, NULL, 2, 0, 0, 'approved', 0),
(10, '2018-01-18 00:52:43', '2018-01-18 00:52:43', 7, 9, '1709273191', 30, 'A', 8, 0, 0, 'approved', 0),
(11, '2018-01-18 00:58:13', '2018-01-18 00:58:13', 8, 11, '1709080860', 21, NULL, 5, 0, 0, 'security_out', 0),
(12, '2018-01-18 00:58:13', '2018-01-18 00:58:13', 8, 11, '1709273191', 31, 'B', 5, 0, 0, 'security_out', 0),
(13, '2018-01-18 01:00:20', '2018-01-18 01:07:45', 18, 14, '1709080860', 22, NULL, 10, 10, 0, 'security_out', 0),
(14, '2018-01-18 01:13:36', '2018-01-18 01:13:36', 22, 22, '1709080860', 19, NULL, 5, 0, 0, 'approved', 0),
(15, '2018-01-18 01:13:36', '2018-01-18 01:13:36', 22, 22, '1709273191', 33, 'A', 5, 0, 0, 'approved', 0),
(16, '2018-01-18 02:35:13', '2018-01-18 02:38:22', 31, 32, '1709081745', 39, 'A', 10, 10, 0, 'security_in', 0),
(17, '2018-01-18 02:39:44', '2018-01-18 02:41:57', 31, 33, '1708310245', 44, NULL, 5, 5, 0, 'security_in', 0),
(18, '2018-01-18 02:39:44', '2018-01-18 02:42:23', 31, 33, '1708310245', 45, NULL, 5, 5, 0, 'security_in', 0),
(19, '2018-01-18 18:31:31', '2018-01-18 18:34:38', 32, 34, '1709081745', 39, 'A', 10, 0, 0, 'approved', 0),
(20, '2018-01-18 18:31:51', '2018-01-19 02:07:13', 32, 35, '1709081746', 40, 'B', 10, 10, 0, 'reserve', 0),
(21, '2018-01-18 06:33:23', '2018-01-19 01:03:52', 33, 36, '1709081745', 39, 'A', 15, 15, 0, 'reserve', 0),
(22, '2018-01-19 21:19:17', '2018-01-19 21:26:03', 47, 55, '1709222465', 97, 'B', 5, 5, 0, 'security_in', 0),
(23, '2018-01-19 21:19:17', '2018-01-19 21:26:11', 47, 55, '1709222465', 98, 'C', 5, 5, 0, 'security_in', 0);

-- --------------------------------------------------------

--
-- Table structure for table `do_types`
--

CREATE TABLE `do_types` (
  `do_type` varchar(3) NOT NULL,
  `description` varchar(50) NOT NULL,
  `transaction_type` int(10) NOT NULL,
  `dispatch_policy` varchar(10) NOT NULL,
  `company` int(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `do_types`
--

INSERT INTO `do_types` (`do_type`, `description`, `transaction_type`, `dispatch_policy`, `company`, `created_at`, `updated_at`) VALUES
('ABC', 'HELLO', 0, 'ABCD', 1234, '2018-01-21 00:24:14', '2018-01-21 00:24:14'),
('I01', 'BAI-Normal Manual DO                    ', 51, 'I01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('I05', 'BAI-External Subcontract DO for RM      ', 51, 'I05', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('I08', 'BAI-DO After Put-away - Through DOP     ', 51, 'I08', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('I11', 'BAI- DO - Liability Transfer RM-Open PO ', 51, 'I11', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('I23', 'BAI-W/O material reuse                  ', 51, 'I23', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('I30', 'BAI-No picklist document print          ', 51, 'I30', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('N01', 'BIA - Normal DO                         ', 51, 'N01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('N04', 'BIA - External subcontract DO for RM    ', 51, 'N04', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('N06', 'BIA-DO for GRN at a Different Location  ', 51, 'N06', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('N09', 'BIA- DO - Liability Transfer RM- Open PO', 51, 'N09', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('N10', 'BIA - DO For Factory Change RM          ', 51, 'N10', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('N13', 'BIA - Finish Good Liability/Writeoff DO ', 51, 'N13', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('N20', 'BIA-Blank Garment Transfer to RM WH     ', 51, 'N20', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('N23', 'BIA-W/O material reuse                  ', 51, 'N23', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('N30', 'BIA-No picklist document print          ', 51, 'N30', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P01', 'BIAI - Normal DO                        ', 51, 'P01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P04', 'BIAI - External subcontract DO for RM   ', 51, 'P04', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P09', 'BIAI- DO - Liability Trfr. RM- Open PO  ', 51, 'P09', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P10', 'BIAI - DO For Factory Change RM         ', 51, 'P10', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P13', 'BIAI - Finish Good Liability/Writeoff DO', 51, 'P13', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P23', 'BIAI-W/O material reuse                 ', 51, 'P23', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P27', 'BIAI - Writeoff reuse DO                ', 51, 'P01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P28', 'BIAI RM writeoff reuse                  ', 51, 'P27', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P30', 'BIAI-No picklist document print         ', 51, 'P30', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Sa', 'Se', 0, 'Sc', 0, '2018-01-20 22:42:05', '2018-01-20 22:42:05'),
('Sb', 'Hello', 0, 'Sb', 12, '2018-01-20 23:46:40', '2018-01-20 23:46:40'),
('U01', 'BUL - Normal DO                         ', 51, 'U01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('U04', 'BUL - External subcontract DO for RM    ', 51, 'U04', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('U06', 'BUL-DO for GRN at a Different Location  ', 51, 'U06', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('U09', 'BUL- DO - Liability Transfer RM-Open PO ', 51, 'U09', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('U10', 'BUL - DO For Factory Change RM          ', 51, 'U10', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('U13', 'BUL - Finish Good Liability/Writeoff DO ', 51, 'U13', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('U20', 'BUL-Blank Garment Transfer to RM WH     ', 51, 'U20', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('U23', 'BUL-W/O material reuse                  ', 51, 'U22', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z01', 'BIA - WMS NMF=6 Manual Receipt          ', 51, 'Z01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z02', 'BIA - WMS NMF=6 Auto Receipt            ', 51, 'Z03', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z03', 'BIA - WMS NMF=6 Excess Retain           ', 51, 'Z01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z04', 'BIA - WMS NMF=6 Factory Change          ', 51, 'Z01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z05', 'BIA - WMS NMF=6 Factory Change          ', 51, 'Z01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z11', 'BIA INDIA - WMS NMF=6 Manual Receipt    ', 51, 'Z01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z12', 'BIA INDIA - WMS NMF=6 Auto Receipt      ', 51, 'Z03', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z13', 'BIA INDIA - WMS NMF=6 Excess Retain     ', 51, 'Z01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z14', 'BIA INDIA - WMS NMF=6 Factory Change    ', 51, 'Z01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z15', 'BIA INDIA- WMS NMF=6 Factory Change     ', 51, 'Z01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z21', 'BEL - WMS NMF=6 Manual Receipt          ', 51, 'Z01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z22', 'BEL - WMS NMF=6 Auto Receipt            ', 51, 'Z03', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z23', 'BEL - WMS NMF=6 Excess Retain           ', 51, 'Z01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z24', 'BEL - WMS NMF=6 Factory Change          ', 51, 'Z01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z25', 'BEL - WMS NMF=6 Factory Change          ', 51, 'Z01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z31', 'BEL INDIA - WMS NMF=6 Manual Receipt    ', 51, 'Z01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z32', 'BEL INDIA - WMS NMF=6 Auto Receipt      ', 51, 'Z03', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z33', 'BEL INDIA - WMS NMF=6 Excess Retain     ', 51, 'Z01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z34', 'BEL INDIA - WMS NMF=6 Factory Change    ', 51, 'Z01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z35', 'BEL INDIA- WMS NMF=6 Factory Change     ', 51, 'Z01', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `service_log`
--

CREATE TABLE `service_log` (
  `id` int(11) NOT NULL,
  `request` text NOT NULL,
  `response` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_log`
--

INSERT INTO `service_log` (`id`, `request`, `response`, `created_at`, `updated_at`) VALUES
(1, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_keys=PNLS&request_param_keys=REPN&request_param_keys=PUOS&request_param_keys=WHLO&request_param_values=200&request_param_values=9354728+++&request_param_values=2&request', '{\"error\":\"internal server error0\"}', '2018-01-13 11:22:24', '2018-01-13 11:22:24'),
(2, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_keys=PNLS&request_param_keys=REPN&request_param_keys=PUOS&request_param_keys=WHLO&request_param_values=200&request_param_values=9354728+++&request_param_values=2&request', '{\"error\":\"internal server error0\"}', '2018-01-13 11:22:46', '2018-01-13 11:22:46'),
(3, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_keys=PNLS&request_param_keys=REPN&request_param_keys=PUOS&request_param_keys=WHLO&request_param_values=200&request_param_values=9355593+++&request_param_values=2&request', '{\"error\":\"internal server error0\"}', '2018-01-13 11:23:07', '2018-01-13 11:23:07'),
(4, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_keys=PNLS&request_param_keys=REPN&request_param_keys=PUOS&request_param_keys=WHLO&request_param_values=200&request_param_values=9355593+++&request_param_values=2&request', '{\"error\":\"internal server error0\"}', '2018-01-13 11:23:28', '2018-01-13 11:23:28'),
(5, 'request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=ITNO&request_param_keys=ORCA&request_param_keys=RIDN&request_param_keys=RIDL&request_param_keys=RIDX&request_param_keys=WHSL&request_param_keys=BANO&request_param_keys=ALQT&request_param_v', '{\"error\":\"internal server error0\"}', '2018-01-15 00:10:49', '2018-01-15 00:10:49'),
(6, 'request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=ITNO&request_param_keys=ORCA&request_param_keys=RIDN&request_param_keys=RIDL&request_param_keys=RIDX&request_param_keys=WHSL&request_param_keys=BANO&request_param_keys=ALQT&request_param_v', '{\"error\":\"internal server error0\"}', '2018-01-15 00:11:05', '2018-01-15 00:11:05'),
(7, 'request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=ITNO&request_param_keys=ORCA&request_param_keys=RIDN&request_param_keys=RIDL&request_param_keys=RIDX&request_param_keys=WHSL&request_param_keys=BANO&request_param_keys=ALQT&request_param_v', '{\"error\":\"internal server error0\"}', '2018-01-17 00:38:06', '2018-01-17 00:38:06'),
(8, 'request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=ITNO&request_param_keys=ORCA&request_param_keys=RIDN&request_param_keys=RIDL&request_param_keys=RIDX&request_param_keys=WHSL&request_param_keys=BANO&request_param_keys=ALQT&request_param_v', '{\"error\":\"internal server error0\"}', '2018-01-17 00:38:10', '2018-01-17 00:38:10'),
(9, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=', '{\"error\":\"internal server error0\"}', '2018-01-17 23:28:14', '2018-01-17 23:28:14'),
(10, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"error\":\"internal server error0\"}', '2018-01-18 06:15:04', '2018-01-18 06:15:04'),
(11, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=', '{\"error\":\"internal server error0\"}', '2018-01-18 06:28:00', '2018-01-18 06:28:00'),
(12, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"error\":\"internal server error0\"}', '2018-01-18 06:35:49', '2018-01-18 06:35:49'),
(13, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"error\":\"internal server error0\"}', '2018-01-18 23:49:20', '2018-01-18 23:49:20'),
(14, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"MSGN\":\"0001661027\"}', '2018-01-19 00:17:45', '2018-01-19 00:17:45'),
(15, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"MSGN\":\"0001661028\"}', '2018-01-19 00:26:19', '2018-01-19 00:26:19'),
(16, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"MSGN\":\"0001661029\"}', '2018-01-19 00:27:29', '2018-01-19 00:27:29'),
(17, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"MSGN\":\"0001661030\"}', '2018-01-19 00:28:27', '2018-01-19 00:28:27'),
(18, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"MSGN\":\"0001661031\"}', '2018-01-19 00:29:32', '2018-01-19 00:29:32'),
(19, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"MSGN\":\"0001661032\"}', '2018-01-19 00:30:26', '2018-01-19 00:30:26'),
(20, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"MSGN\":\"0001661033\"}', '2018-01-19 00:30:51', '2018-01-19 00:30:51'),
(21, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"MSGN\":\"0001661034\"}', '2018-01-19 00:33:40', '2018-01-19 00:33:40'),
(22, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"MSGN\":\"0001661035\"}', '2018-01-19 00:36:16', '2018-01-19 00:36:16'),
(23, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"MSGN\":\"0001661036\"}', '2018-01-19 00:37:22', '2018-01-19 00:37:22'),
(24, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"MSGN\":\"0001661037\"}', '2018-01-19 00:42:08', '2018-01-19 00:42:08'),
(25, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"error\":\"internal server error0\"}', '2018-01-19 03:52:15', '2018-01-19 03:52:15'),
(26, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"error\":\"internal server error0\"}', '2018-01-19 03:54:15', '2018-01-19 03:54:15'),
(27, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"error\":\"internal server error0\"}', '2018-01-19 03:55:14', '2018-01-19 03:55:14'),
(28, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"error\":\"internal server error0\"}', '2018-01-19 18:17:07', '2018-01-19 18:17:07'),
(29, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"error\":\"internal server error0\"}', '2018-01-19 18:20:33', '2018-01-19 18:20:33'),
(30, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"error\":\"mvxAccess() returned: 8 NOK            2000001661038\"}', '2018-01-19 18:39:07', '2018-01-19 18:39:07'),
(31, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"error\":\"mvxAccess() returned: 8 NOK            2000001661039\"}', '2018-01-19 18:40:39', '2018-01-19 18:40:39'),
(32, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"status\":\"ok\"}', '2018-01-19 18:44:47', '2018-01-19 18:44:47'),
(33, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"error\":\"mvxAccess() returned: 8 NOK            Receiving number is invalid - check your receipt documents\"}', '2018-01-19 18:52:42', '2018-01-19 18:52:42'),
(34, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"status\":\"ok\"}', '2018-01-19 18:53:54', '2018-01-19 18:53:54'),
(35, 'request_param_keys=REPN&request_param_keys=RESP&request_param_keys=TRDT&request_param_keys=RPQA&request_param_keys=WHSL&request_param_keys=BANO&request_param_values=4791972001&request_param_values=SFCSFFM3UA&request_param_values=20180111&request_param_val', '{\"error\":\"internal server error0\"}', '2018-01-19 18:58:01', '2018-01-19 18:58:01'),
(36, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"error\":\"internal server error0\"}', '2018-01-19 18:58:11', '2018-01-19 18:58:11'),
(37, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"error\":\"internal server error0\"}', '2018-01-19 19:26:47', '2018-01-19 19:26:47'),
(38, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"error\":\"mvxAccess() returned: 8 NOK            2000001661044\"}', '2018-01-19 19:28:09', '2018-01-19 19:28:09'),
(39, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"error\":\"mvxAccess() returned: 8 NOK            2000001661045\"}', '2018-01-19 19:28:55', '2018-01-19 19:28:55'),
(40, 'request_param_keys=REPN&request_param_keys=RESP&request_param_keys=TRDT&request_param_keys=RPQA&request_param_keys=WHSL&request_param_keys=BANO&request_param_values=4791972001&request_param_values=SFCSFFM3UA&request_param_values=20180111&request_param_val', '{\"error\":\"mvxAccess() returned: 8 NOK            Receiving number is invalid - check your receipt documents\"}', '2018-01-19 19:29:16', '2018-01-19 19:29:16'),
(41, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"error\":\"internal server error0\"}', '2018-01-19 19:56:22', '2018-01-19 19:56:22'),
(42, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"error\":\"mvxAccess() returned: 8 NOK            2000001661054\"}', '2018-01-19 19:57:01', '2018-01-19 19:57:01'),
(43, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"status\":\"ok\"}', '2018-01-19 19:57:50', '2018-01-19 19:57:50'),
(44, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_keys=PNLS&request_param_keys=REPN&request_param_keys=PUOS&request_param_keys=WHLO&request_param_values=200&request_param_values=4305383&request_param_values=2&request_pa', '{\"error\":\"mvxAccess() returned: 8 NOK            Invalid input of data\"}', '2018-01-19 19:58:54', '2018-01-19 19:58:54'),
(45, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"status\":\"ok\"}', '2018-01-19 20:03:49', '2018-01-19 20:03:49'),
(46, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"error\":\"internal server error0\"}', '2018-01-19 20:05:01', '2018-01-19 20:05:01'),
(47, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"status\":\"ok\"}', '2018-01-19 20:07:11', '2018-01-19 20:07:11'),
(48, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"status\":\"ok\"}', '2018-01-19 20:08:21', '2018-01-19 20:08:21'),
(49, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"status\":\"ok\"}', '2018-01-19 20:08:42', '2018-01-19 20:08:42'),
(50, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"status\":\"ok\"}', '2018-01-19 20:08:58', '2018-01-19 20:08:58'),
(51, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"error\":\"mvxAccess() returned: 8 NOK            Incorrect date\"}', '2018-01-19 20:10:05', '2018-01-19 20:10:05'),
(52, 'request_param_keys=REPN&request_param_keys=RESP&request_param_keys=TRDT&request_param_keys=RPQA&request_param_keys=WHSL&request_param_keys=BANO&request_param_values=4791972001&request_param_values=SFCSFFM3UA&request_param_values=20180111&request_param_val', '{\"error\":\"mvxAccess() returned: 8 NOK            Location must be entered\"}', '2018-01-19 20:24:56', '2018-01-19 20:24:56'),
(53, 'request_param_keys=REPN&request_param_keys=RESP&request_param_keys=TRDT&request_param_keys=RPQA&request_param_keys=WHSL&request_param_keys=BANO&request_param_values=4791972001&request_param_values=SFCSFFM3UA&request_param_values=20180111&request_param_val', '{\"error\":\"mvxAccess() returned: 8 NOK            Location N73 does not exist\"}', '2018-01-19 20:25:08', '2018-01-19 20:25:08'),
(54, 'request_param_keys=REPN&request_param_keys=RESP&request_param_keys=TRDT&request_param_keys=RPQA&request_param_keys=WHSL&request_param_keys=BANO&request_param_values=4791972001&request_param_values=SFCSFFM3UA&request_param_values=20180111&request_param_val', '{\"error\":\"mvxAccess() returned: 8 NOK            Location N73 does not exist\"}', '2018-01-19 20:27:59', '2018-01-19 20:27:59'),
(55, 'request_param_keys=REPN&request_param_keys=RESP&request_param_keys=TRDT&request_param_keys=RPQA&request_param_keys=WHSL&request_param_keys=BANO&request_param_values=4791972001&request_param_values=SFCSFFM3UA&request_param_values=20180111&request_param_val', '{\"status\":\"ok\"}', '2018-01-19 20:30:32', '2018-01-19 20:30:32'),
(56, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"error\":\"internal server error0\"}', '2018-01-19 20:34:14', '2018-01-19 20:34:14'),
(57, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"error\":\"internal server error0\"}', '2018-01-19 20:34:49', '2018-01-19 20:34:49'),
(58, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"error\":\"mvxAccess() returned: 8 NOK            Receiving number is invalid - check your receipt documents\"}', '2018-01-19 20:36:21', '2018-01-19 20:36:21'),
(59, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"error\":\"internal server error0\"}', '2018-01-19 20:36:38', '2018-01-19 20:36:38'),
(60, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"status\":\"ok\"}', '2018-01-19 20:37:08', '2018-01-19 20:37:08'),
(61, 'request_param_keys=CONO&request_param_keys=MSGN&request_param_keys=PRFL&request_param_values=200&request_param_values=1&request_param_values=%2AEXE&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MHS850MI&trans_name=PrcWhsTran', '{\"error\":\"mvxAccess() returned: 8 NOK            Order type  does not exist\"}', '2018-01-19 20:37:09', '2018-01-19 20:37:09'),
(62, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"error\":\"internal server error0\"}', '2018-01-19 21:13:45', '2018-01-19 21:13:45'),
(63, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"MSGN\":\"0001661056\"}', '2018-01-19 21:16:56', '2018-01-19 21:16:56'),
(64, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"status\":\"ok\"}', '2018-01-19 21:16:58', '2018-01-19 21:16:58'),
(65, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"status\":\"ok\"}', '2018-01-19 21:16:58', '2018-01-19 21:16:58'),
(66, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"status\":\"ok\"}', '2018-01-19 21:16:59', '2018-01-19 21:16:59'),
(67, 'request_param_keys=CONO&request_param_keys=MSGN&request_param_keys=PRFL&request_param_values=200&request_param_values=0001661056&request_param_values=%2AEXE&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MHS850MI&trans_name=P', '{\"error\":\"mvxAccess() returned: 8 NOK            You do not have authorization for warehouse 207\"}', '2018-01-19 21:17:01', '2018-01-19 21:17:01'),
(68, 'request_param_keys=CONO&request_param_keys=MSGN&request_param_keys=PRFL&request_param_values=200&request_param_values=0&request_param_values=%2AEXE&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MHS850MI&trans_name=PrcWhsTran', '{\"error\":\"internal server error0\"}', '2018-01-19 22:46:18', '2018-01-19 22:46:18'),
(69, 'request_param_keys=CONO&request_param_keys=MSGN&request_param_keys=PRFL&request_param_values=200&request_param_values=0&request_param_values=%2AEXE&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MHS850MI&trans_name=PrcWhsTran', '{\"error\":\"internal server error0\"}', '2018-01-19 22:46:55', '2018-01-19 22:46:55'),
(70, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=', '{\"error\":\"internal server error0\"}', '2018-01-19 23:11:43', '2018-01-19 23:11:43'),
(71, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=', '{\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-19 23:11:56', '2018-01-19 23:11:56'),
(72, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-19 23:14:23', '2018-01-19 23:14:23'),
(73, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-19 23:14:46', '2018-01-19 23:14:46'),
(74, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"TRDT\",\"Get_Last_Message_ID\":\"XDT0001\",\"error\":\"mvxAccess() returned: 8 NOK            Incorrect date\",\"Get_Last_Error\":\"NOK            Incorrect date\"}', '2018-01-19 23:15:02', '2018-01-19 23:15:02'),
(75, 'request_param_keys=CONO&request_param_keys=MSGN&request_param_keys=PRFL&request_param_values=200&request_param_values=0&request_param_values=%2AEXE&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MHS850MI&trans_name=PrcWhsTran', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"WMS3703\",\"error\":\"mvxAccess() returned: 8 NOK            Message number 0 does not exist\",\"Get_Last_Error\":\"NOK            Message number 0 does not exist\"}', '2018-01-19 23:22:05', '2018-01-19 23:22:05'),
(76, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_v', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"TRDT\",\"Get_Last_Message_ID\":\"XDT0001\",\"error\":\"mvxAccess() returned: 8 NOK            Incorrect date\",\"Get_Last_Error\":\"NOK            Incorrect date\"}', '2018-01-19 23:26:19', '2018-01-19 23:26:19'),
(77, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\",\"PNLI\":\"16\"}', '2018-01-19 23:26:30', '2018-01-19 23:26:30'),
(78, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"error\":\"internal server error0\"}', '2018-01-20 01:20:49', '2018-01-20 01:20:49'),
(79, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"MSGN\":\"0001661057\",\"Get_Last_Error\":\"\"}', '2018-01-20 01:21:53', '2018-01-20 01:21:53'),
(80, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-20 01:21:53', '2018-01-20 01:21:53'),
(81, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-20 01:21:54', '2018-01-20 01:21:54'),
(82, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-20 01:23:16', '2018-01-20 01:23:16'),
(83, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-20 01:23:16', '2018-01-20 01:23:16'),
(84, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\",\"PNLI\":\"16\"}', '2018-01-20 01:24:17', '2018-01-20 01:24:17'),
(85, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\",\"PNLI\":\"16\"}', '2018-01-20 01:24:26', '2018-01-20 01:24:26'),
(86, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-20 01:24:38', '2018-01-20 01:24:38'),
(87, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-20 01:24:39', '2018-01-20 01:24:39'),
(88, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\",\"PNLI\":\"16\"}', '2018-01-20 01:26:05', '2018-01-20 01:26:05'),
(89, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"MSGN\":\"0001661058\",\"Get_Last_Error\":\"\"}', '2018-01-20 01:26:58', '2018-01-20 01:26:58'),
(90, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-20 01:26:58', '2018-01-20 01:26:58'),
(91, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-20 01:26:59', '2018-01-20 01:26:59'),
(92, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\",\"PNLI\":\"16\"}', '2018-01-20 01:30:33', '2018-01-20 01:30:33'),
(93, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=2001&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\",\"PNLI\":\"16\"}', '2018-01-20 01:30:49', '2018-01-20 01:30:49'),
(94, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=2001&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\",\"PNLI\":\"16\"}', '2018-01-20 01:31:01', '2018-01-20 01:31:01'),
(95, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_k', '{\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"MSGN\":\"0001661059\",\"Get_Last_Error\":\"\"}', '2018-01-20 01:31:11', '2018-01-20 01:31:11'),
(96, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-20 01:31:12', '2018-01-20 01:31:12'),
(97, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_k', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-20 01:31:13', '2018-01-20 01:31:13'),
(98, 'request_param_keys=CONO&request_param_keys=MSGN&request_param_keys=PRFL&request_param_values=200&request_param_values=0001661059&request_param_values=%2AEXE&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MHS850MI&trans_name=P', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"XIT0102\",\"error\":\"mvxAccess() returned: 8 NOK            Item BE1FAB0001 0005 does not exist in the warehouse\",\"Get_Last_Error\":\"NOK            Item BE1FAB0001 0005 does not exist in', '2018-01-20 01:31:14', '2018-01-20 01:31:14'),
(99, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=2001&request_param_values=1089dgfg890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"WPU0803\",\"error\":\"mvxAccess() returned: 8 NOK            Purchase order number 1089dgf does not exist\",\"Get_Last_Error\":\"NOK            Purchase order number 1089dgf does not exist\"}', '2018-01-20 01:31:22', '2018-01-20 01:31:22'),
(100, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=2001&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\",\"PNLI\":\"16\"}', '2018-01-20 01:31:43', '2018-01-20 01:31:43'),
(101, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=20044&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&hos', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\",\"PNLI\":\"16\"}', '2018-01-20 01:31:52', '2018-01-20 01:31:52'),
(102, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=10.', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\",\"PNLI\":\"16\"}', '2018-01-20 01:31:59', '2018-01-20 01:31:59'),
(103, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=20044&request_param_values=1089890&request_param_values=17&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&hos', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\",\"PNLI\":\"17\"}', '2018-01-20 01:32:11', '2018-01-20 01:32:11'),
(104, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=155&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"WPN0103\",\"error\":\"mvxAccess() returned: 8 NOK            Purchase order line 155 does not exist\",\"Get_Last_Error\":\"NOK            Purchase order line 155 does not exist\"}', '2018-01-20 01:32:33', '2018-01-20 01:32:33'),
(105, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\",\"PNLI\":\"16\"}', '2018-01-20 01:32:49', '2018-01-20 01:32:49'),
(106, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS200MI&trans_name=GetLine', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\",\"PNLI\":\"16\"}', '2018-01-20 01:37:37', '2018-01-20 01:37:37'),
(107, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_keys=TRTP&request_param_keys=RESP&request_param_keys=RSCD&request_param_keys=RORN&request_param_keys=BRE2&request_param_keys=RPDT&request_param_keys=RORC&request_param_values=%2APND&request_param_values=200&request_param_values=407&request_param_values=SFCS&request_param_values=1&request_param_values=ORDERS&request_param_values=ACO&request_param_values=BE1FAB0001+0005&request_param_values=10&request_param_values=D407000019&request_param_values=I01&request_param_values=SFCSFFM3UA&request_param_values=AA2&request_param_values=&request_param_values=&request_param_values=20180120&request_param_values=0&response_param_keys=MSGN&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MHS850MI&trans_name=AddDO', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"       \",\"error\":\"mvxAccess() returned: 8 NOK            2000001661060\",\"Get_Last_Error\":\"NOK            2000001661060\"}', '2018-01-20 01:38:16', '2018-01-20 01:38:16'),
(108, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_keys=TRTP&request_param_keys=RESP&request_param_keys=RSCD&request_param_keys=RORN&request_param_keys=BRE2&request_param_keys=RPDT&request_param_keys=RORC&request_param_values=%2APND&request_param_values=200&request_param_values=407&request_param_values=SFCS&request_param_values=1&request_param_values=ORDERS&request_param_values=ACO&request_param_values=BE1FAB0001+0005&request_param_values=10&request_param_values=D407000019&request_param_values=I01&request_param_values=SFCSFFM3UA&request_param_values=AA2&request_param_values=&request_param_values=&request_param_values=20180120&request_param_values=0&response_param_keys=MSGN&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MHS850MI&trans_name=AddDO', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"       \",\"error\":\"mvxAccess() returned: 8 NOK            2000001661061\",\"Get_Last_Error\":\"NOK            2000001661061\"}', '2018-01-20 01:38:33', '2018-01-20 01:38:33'),
(109, 'request_param_keys=CONO&request_param_keys=TRNR&request_param_values=200&request_param_values=DN52000001&response_param_keys=TRNR&response_param_keys=PONR&response_param_keys=POSX&response_param_keys=ITNO&response_param_keys=TRQT&response_param_keys=RSCD&response_param_keys=TRSH&response_param_keys=BRE2&response_param_keys=BREF&response_param_keys=ALUN&response_param_keys=RORN&response_param_keys=RORL&response_param_keys=RESP&response_param_keys=BREM&response_param_keys=RGDT&response_param_keys=RGTM&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MDBREADMI&trans_name=LstMGLINE00', '{\"error\":\"internal server error0\"}', '2018-01-20 01:59:40', '2018-01-20 01:59:40'),
(110, 'request_param_keys=CONO&request_param_keys=TRNR&request_param_values=200&request_param_values=DN52000001&response_param_keys=TRNR&response_param_keys=PONR&response_param_keys=POSX&response_param_keys=ITNO&response_param_keys=TRQT&response_param_keys=RSCD&response_param_keys=TRSH&response_param_keys=BRE2&response_param_keys=BREF&response_param_keys=ALUN&response_param_keys=RORN&response_param_keys=RORL&response_param_keys=RESP&response_param_keys=BREM&response_param_keys=RGDT&response_param_keys=RGTM&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MDBREADMI&trans_name=LstMGLINE00', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"XO_1092\",\"error\":\"mvxAccess() returned: 8 NOK            You are not authorized to the user profile %s (CPF2217).\",\"Get_Last_Error\":\"NOK            You are not authorized to the user profile %s (CPF2217).\"}', '2018-01-20 02:01:03', '2018-01-20 02:01:03'),
(111, 'request_param_keys=CONO&request_param_keys=TRNR&request_param_values=200&request_param_values=DO000001&response_param_keys=TRNR&response_param_keys=PONR&response_param_keys=POSX&response_param_keys=ITNO&response_param_keys=TRQT&response_param_keys=RSCD&response_param_keys=TRSH&response_param_keys=BRE2&response_param_keys=BREF&response_param_keys=ALUN&response_param_keys=RORN&response_param_keys=RORL&response_param_keys=RESP&response_param_keys=BREM&response_param_keys=RGDT&response_param_keys=RGTM&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MDBREADMI&trans_name=LstMGLINE00', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"XO_1092\",\"error\":\"mvxAccess() returned: 8 NOK            You are not authorized to the user profile %s (CPF2217).\",\"Get_Last_Error\":\"NOK            You are not authorized to the user profile %s (CPF2217).\"}', '2018-01-20 02:05:55', '2018-01-20 02:05:55'),
(112, 'request_param_keys=CONO&request_param_keys=TRNR&request_param_values=200&request_param_values=DO000001&response_param_keys=TRNR&response_param_keys=PONR&response_param_keys=POSX&response_param_keys=ITNO&response_param_keys=TRQT&response_param_keys=RSCD&response_param_keys=TRSH&response_param_keys=BRE2&response_param_keys=BREF&response_param_keys=ALUN&response_param_keys=RORN&response_param_keys=RORL&response_param_keys=RESP&response_param_keys=BREM&response_param_keys=RGDT&response_param_keys=RGTM&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MDBREADMI&trans_name=LstMGLINE00', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"XO_1092\",\"error\":\"mvxAccess() returned: 8 NOK            You are not authorized to the user profile %s (CPF2217).\",\"Get_Last_Error\":\"NOK            You are not authorized to the user profile %s (CPF2217).\"}', '2018-01-20 02:06:11', '2018-01-20 02:06:11'),
(113, 'request_param_keys=CONO&request_param_keys=TRNR&request_param_values=200&request_param_values=DO000001&response_param_keys=TRNR&response_param_keys=PONR&response_param_keys=POSX&response_param_keys=ITNO&response_param_keys=TRQT&response_param_keys=RSCD&response_param_keys=TRSH&response_param_keys=BRE2&response_param_keys=BREF&response_param_keys=ALUN&response_param_keys=RORN&response_param_keys=RORL&response_param_keys=RESP&response_param_keys=BREM&response_param_keys=RGDT&response_param_keys=RGTM&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MDBREADMI&trans_name=LstMGLINE00', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"XO_1092\",\"error\":\"mvxAccess() returned: 8 NOK            You are not authorized to the user profile %s (CPF2217).\",\"Get_Last_Error\":\"NOK            You are not authorized to the user profile %s (CPF2217).\"}', '2018-01-20 02:06:23', '2018-01-20 02:06:23');
INSERT INTO `service_log` (`id`, `request`, `response`, `created_at`, `updated_at`) VALUES
(114, 'request_param_keys=CONO&request_param_keys=TRNR&request_param_values=200&request_param_values=DO000002&response_param_keys=TRNR&response_param_keys=PONR&response_param_keys=POSX&response_param_keys=ITNO&response_param_keys=TRQT&response_param_keys=RSCD&response_param_keys=TRSH&response_param_keys=BRE2&response_param_keys=BREF&response_param_keys=ALUN&response_param_keys=RORN&response_param_keys=RORL&response_param_keys=RESP&response_param_keys=BREM&response_param_keys=RGDT&response_param_keys=RGTM&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MDBREADMI&trans_name=LstMGLINE00', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"XO_1092\",\"error\":\"mvxAccess() returned: 8 NOK            You are not authorized to the user profile %s (CPF2217).\",\"Get_Last_Error\":\"NOK            You are not authorized to the user profile %s (CPF2217).\"}', '2018-01-20 02:14:59', '2018-01-20 02:14:59'),
(115, 'request_param_keys=CONO&request_param_keys=TRNR&request_param_values=200&request_param_values=DO000002&response_param_keys=TRNR&response_param_keys=PONR&response_param_keys=POSX&response_param_keys=ITNO&response_param_keys=TRQT&response_param_keys=RSCD&response_param_keys=TRSH&response_param_keys=BRE2&response_param_keys=BREF&response_param_keys=ALUN&response_param_keys=RORN&response_param_keys=RORL&response_param_keys=RESP&response_param_keys=BREM&response_param_keys=RGDT&response_param_keys=RGTM&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MDBREADMI&trans_name=LstMGLINE00', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"XO_1092\",\"error\":\"mvxAccess() returned: 8 NOK            You are not authorized to the user profile %s (CPF2217).\",\"Get_Last_Error\":\"NOK            You are not authorized to the user profile %s (CPF2217).\"}', '2018-01-20 02:15:05', '2018-01-20 02:15:05'),
(116, 'request_param_keys=CONO&request_param_keys=TRNR&request_param_keys=E0PA&request_param_keys=E0PB&request_param_values=200&request_param_values=DO000002&request_param_values=SFCS&request_param_values=1&response_param_keys=TRNR&response_param_keys=PONR&response_param_keys=POSX&response_param_keys=ITNO&response_param_keys=TRQT&response_param_keys=RSCD&response_param_keys=TRSH&response_param_keys=BRE2&response_param_keys=BREF&response_param_keys=ALUN&response_param_keys=RORN&response_param_keys=RORL&response_param_keys=RESP&response_param_keys=BREM&response_param_keys=RGDT&response_param_keys=RGTM&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MDBREADMI&trans_name=LstMGLINE00', '{\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"error\":\"mvxAccess() returned: 7 Field E0PA not found in LstMGLINE00 transaction\",\"Get_Last_Error\":\"Field E0PA not found in LstMGLINE00 transaction\"}', '2018-01-20 02:16:47', '2018-01-20 02:16:47'),
(117, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_keys=TRTP&request_param_keys=RESP&request_param_keys=RSCD&request_param_keys=RORN&request_param_keys=BRE2&request_param_keys=RPDT&request_param_keys=RORC&request_param_values=%2APND&request_param_values=200&request_param_values=N51&request_param_values=SFCS&request_param_values=1&request_param_values=ORDERS&request_param_values=N54&request_param_values=K50912S7TH2+004&request_param_values=10&request_param_values=DN51000001&request_param_values=I01&request_param_values=SFCSFFM3UA&request_param_values=AA2&request_param_values=&request_param_values=&request_param_values=20180120&request_param_values=0&response_param_keys=MSGN&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MHS850MI&trans_name=AddDO', '{\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"MSGN\":\"0001661062\",\"Get_Last_Error\":\"\"}', '2018-01-20 02:20:57', '2018-01-20 02:20:57'),
(118, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_keys=BRE2&request_param_keys=RPDT&request_param_keys=RORC&request_param_keys=MSGN&request_param_values=%2APND&request_param_values=200&request_param_values=N51&request_param_values=SFCS&request_param_values=1&request_param_values=ORDERS&request_param_values=N54&request_param_values=K50912S7TH3+002&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=0&request_param_values=0001661062&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MHS850MI&trans_name=AddDO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-20 02:20:57', '2018-01-20 02:20:57'),
(119, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_keys=BRE2&request_param_keys=RPDT&request_param_keys=RORC&request_param_keys=MSGN&request_param_values=%2APND&request_param_values=200&request_param_values=N51&request_param_values=SFCS&request_param_values=1&request_param_values=ORDERS&request_param_values=N54&request_param_values=K50912S7TH4+002&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=0&request_param_values=0001661062&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MHS850MI&trans_name=AddDO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-20 02:20:58', '2018-01-20 02:20:58'),
(120, 'request_param_keys=CONO&request_param_keys=MSGN&request_param_keys=PRFL&request_param_values=200&request_param_values=0001661062&request_param_values=%2AEXE&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MHS850MI&trans_name=PrcWhsTran', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-20 02:21:00', '2018-01-20 02:21:00'),
(121, 'request_param_keys=CONO&request_param_keys=TRNR&request_param_values=200&request_param_values=DN51000001&response_param_keys=TRNR&response_param_keys=PONR&response_param_keys=POSX&response_param_keys=ITNO&response_param_keys=TRQT&response_param_keys=RSCD&response_param_keys=TRSH&response_param_keys=BRE2&response_param_keys=BREF&response_param_keys=ALUN&response_param_keys=RORN&response_param_keys=RORL&response_param_keys=RESP&response_param_keys=BREM&response_param_keys=RGDT&response_param_keys=RGTM&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MDBREADMI&trans_name=LstMGLINE00', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"XO_1092\",\"error\":\"mvxAccess() returned: 8 NOK            You are not authorized to the user profile %s (CPF2217).\",\"Get_Last_Error\":\"NOK            You are not authorized to the user profile %s (CPF2217).\"}', '2018-01-20 02:22:02', '2018-01-20 02:22:02'),
(122, 'request_param_keys=CONO&request_param_keys=TRNR&request_param_values=200&request_param_values=DN51000001&response_param_keys=TRNR&response_param_keys=PONR&response_param_keys=POSX&response_param_keys=ITNO&response_param_keys=TRQT&response_param_keys=RSCD&response_param_keys=TRSH&response_param_keys=BRE2&response_param_keys=BREF&response_param_keys=ALUN&response_param_keys=RORN&response_param_keys=RORL&response_param_keys=RESP&response_param_keys=BREM&response_param_keys=RGDT&response_param_keys=RGTM&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MDBREADMI&trans_name=LstMGLINE00', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"XO_1092\",\"error\":\"mvxAccess() returned: 8 NOK            You are not authorized to the user profile %s (CPF2217).\",\"Get_Last_Error\":\"NOK            You are not authorized to the user profile %s (CPF2217).\"}', '2018-01-20 02:22:08', '2018-01-20 02:22:08'),
(123, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS200MI&trans_name=GetLine', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\",\"PNLI\":\"16\"}', '2018-01-20 03:23:06', '2018-01-20 03:23:06'),
(124, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=500&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS200MI&trans_name=GetLine', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"WPN0103\",\"error\":\"mvxAccess() returned: 8 NOK            Purchase order line 500 does not exist\",\"Get_Last_Error\":\"NOK            Purchase order line 500 does not exist\"}', '2018-01-20 03:23:29', '2018-01-20 03:23:29'),
(125, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=500&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS200MI&trans_name=GetLine', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"WPN0103\",\"error\":\"mvxAccess() returned: 8 NOK            Purchase order line 500 does not exist\",\"Get_Last_Error\":\"NOK            Purchase order line 500 does not exist\"}', '2018-01-20 03:23:45', '2018-01-20 03:23:45'),
(126, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS200MI&trans_name=GetLine', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\",\"PNLI\":\"16\"}', '2018-01-20 03:26:44', '2018-01-20 03:26:44'),
(127, 'request_param_keys=REPN&request_param_keys=RESP&request_param_keys=TRDT&request_param_keys=RPQA&request_param_keys=WHSL&request_param_keys=BANO&request_param_values=4791972001&request_param_values=SFCSFFM3UA&request_param_values=20180111&request_param_values=30&request_param_values=02T1-TRAPR&request_param_values=4791972001&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS320MI&trans_name=PutawayPO', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"REPN\",\"Get_Last_Message_ID\":\"PP31014\",\"error\":\"mvxAccess() returned: 8 NOK            Receiving number is invalid - check your receipt documents\",\"Get_Last_Error\":\"NOK            Receiving number is invalid - check your receipt documents\"}', '2018-01-20 03:30:56', '2018-01-20 03:30:56'),
(128, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=2018011112312&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=0&request_param_values=0&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"TRDT\",\"Get_Last_Message_ID\":\"XDT0001\",\"error\":\"mvxAccess() returned: 8 NOK            Incorrect date\",\"Get_Last_Error\":\"NOK            Incorrect date\"}', '2018-01-20 03:35:09', '2018-01-20 03:35:09'),
(129, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=2018011112312&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=0&request_param_values=0&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"TRDT\",\"Get_Last_Message_ID\":\"XDT0001\",\"error\":\"mvxAccess() returned: 8 NOK            Incorrect date\",\"Get_Last_Error\":\"NOK            Incorrect date\"}', '2018-01-20 03:35:31', '2018-01-20 03:35:31'),
(130, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=2018011&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=0&request_param_values=0&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"TRDT\",\"Get_Last_Message_ID\":\"XDT0001\",\"error\":\"mvxAccess() returned: 8 NOK            Incorrect date\",\"Get_Last_Error\":\"NOK            Incorrect date\"}', '2018-01-20 03:36:14', '2018-01-20 03:36:14'),
(131, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=0&request_param_values=0&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-20 03:36:24', '2018-01-20 03:36:24'),
(132, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=0&request_param_values=0&request_param_values=&request_param_values=4791972001&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\"}', '2018-01-20 03:38:16', '2018-01-20 03:38:16'),
(133, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS200MI&trans_name=GetLine', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"Get_Last_Error\":\"\",\"PNLI\":\"16\"}', '2018-01-20 03:49:00', '2018-01-20 03:49:00'),
(134, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=0&request_param_values=0&request_param_values=&request_param_values=4791972001&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"error\":\"internal server error0\"}', '2018-01-20 04:06:39', '2018-01-20 04:06:39'),
(135, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=0&request_param_values=0&request_param_values=&request_param_values=4791972001&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 04:12:14', '2018-01-20 04:12:14'),
(136, 'request_param_keys=CONO&request_param_keys=PUNO&request_param_keys=PNLI&request_param_values=200&request_param_values=1089890&request_param_values=16&response_param_keys=CONO&response_param_keys=PUNO&response_param_keys=PNLI&response_param_keys=GRMT&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS200MI&trans_name=GetLine', '{\"CONO\":\"200\",\"PUNO\":\"1089890\",\"GRMT\":\"DPA\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             200108989016 0  C68637D5PB7 001                                        0.00             PCSHDPP-SLF ADSIVE150G W\\/OUT CUT              BALN75209999LAN09464                         HDPP-SLF ADSIVE150G W\\/OUT CUT L 12\'\' X W 10.5\'\'+ 2\\\" Flap \\/                                                    0.0169           0.00   0.00   0.00   0.0000           0.00   0.00   0.00   PCS0    0    76.86            020150204  4548.00          0.00             0.00             0.00                       0.00             0.00             0.00             0.00                       32114120  BIA900464 BIAINT0066DPA      0                           0 201501062563294360          0     0  5                              0.00   ROALOC                                          \",\"Get_Last_Error\":\"\",\"PNLI\":\"16\"}', '2018-01-20 04:12:48', '2018-01-20 04:12:48'),
(137, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=0&request_param_values=0&request_param_values=&request_param_values=4791972001&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 04:13:37', '2018-01-20 04:13:37'),
(138, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=%22%22&request_param_values=%22%22&request_param_values=%22%22&request_param_values=4791972001&request_param_values=%22%22&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"RJQA\",\"Get_Last_Message_ID\":\"XNU0006\",\"get_Transaction\":\"NOK            Incorrect syntax                                                                                                                                                                                                                                 XNU0006 RJQA      \",\"error\":\"mvxAccess() returned: 8 NOK            Incorrect syntax\",\"Get_Last_Error\":\"NOK            Incorrect syntax\"}', '2018-01-20 04:19:07', '2018-01-20 04:19:07'),
(139, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=%22%22&request_param_values=+&request_param_values=%22%22&request_param_values=4791972001&request_param_values=%22%22&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 04:19:48', '2018-01-20 04:19:48'),
(140, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=+&request_param_values=+&request_param_values=+&request_param_values=4791972001&request_param_values=+&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 04:20:17', '2018-01-20 04:20:17'),
(141, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=0&request_param_values=0&request_param_values=+&request_param_values=4791972001&request_param_values=+&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 04:20:57', '2018-01-20 04:20:57'),
(142, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=0&request_param_values=&request_param_values=+&request_param_values=4791972001&request_param_values=+&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 04:23:33', '2018-01-20 04:23:33'),
(143, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=0&request_param_values=sdasdasdas&request_param_values=+&request_param_values=4791972001&request_param_values=+&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"RJQA\",\"Get_Last_Message_ID\":\"XNU0006\",\"get_Transaction\":\"NOK            Incorrect syntax                                                                                                                                                                                                                                 XNU0006 RJQA      \",\"error\":\"mvxAccess() returned: 8 NOK            Incorrect syntax\",\"Get_Last_Error\":\"NOK            Incorrect syntax\"}', '2018-01-20 04:23:44', '2018-01-20 04:23:44'),
(144, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=0&request_param_values=&request_param_values=+&request_param_values=4791972001&request_param_values=+&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 04:23:52', '2018-01-20 04:23:52'),
(145, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=0+&request_param_values=&request_param_values=+&request_param_values=4791972001&request_param_values=+&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 04:24:05', '2018-01-20 04:24:05'),
(146, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=3&request_param_values=10&request_param_values=3&request_param_values=20&request_param_values=4791972001R&request_param_values=4791972001&request_param_values=02T1-TRAPR&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 04:26:25', '2018-01-20 04:26:25'),
(147, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=3&request_param_values=10&request_param_values=3&request_param_values=20&request_param_values=4791972001R&request_param_values=4791972001&request_param_values=02T1-TRAPR&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 04:26:39', '2018-01-20 04:26:39'),
(148, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=3&request_param_values=10&request_param_values=3&request_param_values=20&request_param_values=4791972001R&request_param_values=4791972001&request_param_values=02T1-TRAPR&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 04:32:05', '2018-01-20 04:32:05'),
(149, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 04:35:37', '2018-01-20 04:35:37'),
(150, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 04:35:41', '2018-01-20 04:35:41'),
(151, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 04:35:44', '2018-01-20 04:35:44'),
(152, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 19:43:20', '2018-01-20 19:43:20'),
(153, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=2018011111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"Get_Last_Error_Code\":\"\",\"Get_Last_Bad_Field\":\"TRDT\",\"Get_Last_Message_ID\":\"XDT0001\",\"get_Transaction\":\"NOK            Incorrect date                                                                                                                                                                                                                                   XDT0001 TRDT      \",\"error\":\"mvxAccess() returned: 8 NOK            Incorrect date\",\"Get_Last_Error\":\"NOK            Incorrect date\"}', '2018-01-20 19:44:02', '2018-01-20 19:44:02'),
(154, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 19:46:22', '2018-01-20 19:46:22'),
(155, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 19:46:53', '2018-01-20 19:46:53'),
(156, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 19:47:12', '2018-01-20 19:47:12'),
(157, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"error\":\"internal server error0\"}', '2018-01-20 20:27:08', '2018-01-20 20:27:08'),
(158, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 20:28:49', '2018-01-20 20:28:49'),
(159, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 20:30:33', '2018-01-20 20:30:33'),
(160, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"error\":\"internal server error500\"}', '2018-01-20 20:45:27', '2018-01-20 20:45:27'),
(161, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"error\":\"internal server error500\"}', '2018-01-20 20:48:15', '2018-01-20 20:48:15'),
(162, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"error\":\"internal server error0\"}', '2018-01-20 21:03:37', '2018-01-20 21:03:37'),
(163, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"error\":\"internal server error500\"}', '2018-01-20 21:04:41', '2018-01-20 21:04:41'),
(164, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"error\":\"internal server error500\"}', '2018-01-20 21:04:44', '2018-01-20 21:04:44'),
(165, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"error\":\"internal server error0\"}', '2018-01-20 21:13:21', '2018-01-20 21:13:21'),
(166, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"error\":\"internal server error500\"}', '2018-01-20 21:16:52', '2018-01-20 21:16:52'),
(167, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 21:25:55', '2018-01-20 21:25:55'),
(168, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 21:28:57', '2018-01-20 21:28:57'),
(169, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 21:31:38', '2018-01-20 21:31:38'),
(170, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-20 21:44:10', '2018-01-20 21:44:10'),
(171, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"error\":\"internal server error0\"}', '2018-01-20 22:17:44', '2018-01-20 22:17:44');
INSERT INTO `service_log` (`id`, `request`, `response`, `created_at`, `updated_at`) VALUES
(172, 'request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=ITNO&request_param_keys=ORCA&request_param_keys=RIDN&request_param_keys=RIDL&request_param_keys=RIDX&request_param_keys=WHSL&request_param_keys=BANO&request_param_keys=ALQT&request_param_values=101&request_param_values=SN4&request_param_values=ITEMCODE20170107&request_param_values=513&request_param_values=DONUMBER12&request_param_values=125456&request_param_values=123&request_param_values=VIZAG&request_param_values=LOTNUMBER1426&request_param_values=800&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MMS120MI&trans_name=Allocate', '{\"error\":\"internal server error0\"}', '2018-01-20 22:21:15', '2018-01-20 22:21:15'),
(173, 'request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=ITNO&request_param_keys=ORCA&request_param_keys=RIDN&request_param_keys=RIDL&request_param_keys=RIDX&request_param_keys=WHSL&request_param_keys=BANO&request_param_keys=ALQT&request_param_values=101&request_param_values=SN4&request_param_values=ITEMCODE20170107&request_param_values=513&request_param_values=DONUMBER12&request_param_values=125456&request_param_values=123&request_param_values=VIZAG&request_param_values=LOTNUMBER1426&request_param_values=800&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MMS120MI&trans_name=Allocate', '{\"error\":\"internal server error0\"}', '2018-01-20 22:21:28', '2018-01-20 22:21:28'),
(174, 'request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=ITNO&request_param_keys=ORCA&request_param_keys=RIDN&request_param_keys=RIDL&request_param_keys=RIDX&request_param_keys=WHSL&request_param_keys=BANO&request_param_keys=ALQT&request_param_values=101&request_param_values=SN4&request_param_values=ITEMCODE20170107&request_param_values=513&request_param_values=DONUMBER12&request_param_values=125456&request_param_values=123&request_param_values=VIZAG&request_param_values=LOTNUMBER1426&request_param_values=800&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MMS120MI&trans_name=Allocate', '{\"error\":\"internal server error0\"}', '2018-01-20 22:23:08', '2018-01-20 22:23:08'),
(175, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"error\":\"internal server error0\"}', '2018-01-20 22:30:14', '2018-01-20 22:30:14'),
(176, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"error\":\"internal server error0\"}', '2018-01-20 22:32:34', '2018-01-20 22:32:34'),
(177, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"error\":\"internal server error0\"}', '2018-01-20 23:24:08', '2018-01-20 23:24:08'),
(178, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"error\":\"internal server error0\"}', '2018-01-21 00:15:15', '2018-01-21 00:15:15'),
(179, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"error\":\"internal server error0\"}', '2018-01-21 00:22:21', '2018-01-21 00:22:21'),
(180, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":null,\"error\":\"mvxAccess() returned: 7 mvxRecv() got exception: null\",\"Get_Last_Error\":\"mvxRecv() got exception: null\"}', '2018-01-21 01:14:54', '2018-01-21 01:14:54'),
(181, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-21 01:14:56', '2018-01-21 01:14:56'),
(182, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-21 01:15:04', '2018-01-21 01:15:04'),
(183, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-21 01:15:13', '2018-01-21 01:15:13'),
(184, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-21 01:16:12', '2018-01-21 01:16:12'),
(185, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-21 01:16:21', '2018-01-21 01:16:21'),
(186, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-21 01:16:41', '2018-01-21 01:16:41'),
(187, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"error\":\"init() returned: 7 The remote server returned: NOK       Logon failed.\"}', '2018-01-21 01:18:40', '2018-01-21 01:18:40'),
(188, 'request_param_keys=REPN&request_param_keys=TRDT&request_param_keys=RESP&request_param_keys=QCRA&request_param_keys=AQTY&request_param_keys=SCRE&request_param_keys=RJQA&request_param_keys=RBAN&request_param_keys=ABAN&request_param_keys=RWHS&request_param_values=4791972001&request_param_values=20180111&request_param_values=SFCSFFM3UA&request_param_values=1&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=479197200112341234&request_param_values=&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=PPS310MI&trans_name=QualityInspPO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-21 01:19:31', '2018-01-21 01:19:31'),
(189, 'request_param_keys=CONO&request_param_keys=TRNR&request_param_values=200&request_param_values=DN51000001&response_param_keys=TRNR&response_param_keys=PONR&response_param_keys=POSX&response_param_keys=ITNO&response_param_keys=TRQT&response_param_keys=RSCD&response_param_keys=TRSH&response_param_keys=BRE2&response_param_keys=BREF&response_param_keys=ALUN&response_param_keys=RORN&response_param_keys=RORL&response_param_keys=RESP&response_param_keys=BREM&response_param_keys=RGDT&response_param_keys=RGTM&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MDBREADMI&trans_name=LstMGLINE00', '{\"Get_Last_Error_Code\":\"01\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"XRE0103\",\"get_Transaction\":\"NOK          01Record does not exist                                                                                                                                                                                                                            XRE0103           \",\"error\":\"mvxAccess() returned: 8 NOK          01Record does not exist\",\"Get_Last_Error\":\"NOK          01Record does not exist\"}', '2018-01-21 01:20:58', '2018-01-21 01:20:58'),
(190, 'request_param_keys=CONO&request_param_keys=TRNR&request_param_values=200&request_param_values=DN51000001&response_param_keys=TRNR&response_param_keys=PONR&response_param_keys=POSX&response_param_keys=ITNO&response_param_keys=TRQT&response_param_keys=RSCD&response_param_keys=TRSH&response_param_keys=BRE2&response_param_keys=BREF&response_param_keys=ALUN&response_param_keys=RORN&response_param_keys=RORL&response_param_keys=RESP&response_param_keys=BREM&response_param_keys=RGDT&response_param_keys=RGTM&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MDBREADMI&trans_name=LstMGLINE00', '{\"Get_Last_Error_Code\":\"01\",\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"XRE0103\",\"get_Transaction\":\"NOK          01Record does not exist                                                                                                                                                                                                                            XRE0103           \",\"error\":\"mvxAccess() returned: 8 NOK          01Record does not exist\",\"Get_Last_Error\":\"NOK          01Record does not exist\"}', '2018-01-21 01:22:23', '2018-01-21 01:22:23'),
(191, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RIDN&request_param_keys=TRTP&request_param_keys=RESP&request_param_keys=RSCD&request_param_keys=RORN&request_param_keys=BRE2&request_param_keys=RPDT&request_param_keys=RORC&request_param_values=%2APND&request_param_values=200&request_param_values=N51&request_param_values=SFCS&request_param_values=1&request_param_values=ORDERS&request_param_values=N54&request_param_values=K50912S7TH2+004&request_param_values=10&request_param_values=DN51000002&request_param_values=I01&request_param_values=SFCSFFM3UA&request_param_values=A&request_param_values=&request_param_values=&request_param_values=20180121&request_param_values=0&response_param_keys=MSGN&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MHS850MI&trans_name=AddDO', '{\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"MSGN\":\"0001661063\",\"get_Transaction\":\"OK             2000001661063     \",\"Get_Last_Error\":\"\"}', '2018-01-21 01:25:39', '2018-01-21 01:25:39'),
(192, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_keys=BRE2&request_param_keys=RPDT&request_param_keys=RORC&request_param_keys=MSGN&request_param_values=%2APND&request_param_values=200&request_param_values=N51&request_param_values=SFCS&request_param_values=1&request_param_values=ORDERS&request_param_values=N54&request_param_values=K50912S7TH3+002&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=0&request_param_values=0001661063&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MHS850MI&trans_name=AddDO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             2000001661063     \",\"Get_Last_Error\":\"\"}', '2018-01-21 01:25:39', '2018-01-21 01:25:39'),
(193, 'request_param_keys=PRMD&request_param_keys=CONO&request_param_keys=WHLO&request_param_keys=E0PA&request_param_keys=E0PB&request_param_keys=E065&request_param_keys=CUNO&request_param_keys=ITNO&request_param_keys=DLQT&request_param_keys=RORN&request_param_keys=BRE2&request_param_keys=RPDT&request_param_keys=RORC&request_param_keys=MSGN&request_param_values=%2APND&request_param_values=200&request_param_values=N51&request_param_values=SFCS&request_param_values=1&request_param_values=ORDERS&request_param_values=N54&request_param_values=K50912S7TH4+002&request_param_values=10&request_param_values=&request_param_values=&request_param_values=&request_param_values=0&request_param_values=0001661063&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MHS850MI&trans_name=AddDO', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             2000001661063     \",\"Get_Last_Error\":\"\"}', '2018-01-21 01:25:40', '2018-01-21 01:25:40'),
(194, 'request_param_keys=CONO&request_param_keys=MSGN&request_param_keys=PRFL&request_param_values=200&request_param_values=0001661063&request_param_values=%2AEXE&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MHS850MI&trans_name=PrcWhsTran', '{\"STATUS\":\"ok\",\"Get_Last_Error_Code\":null,\"Get_Last_Bad_Field\":\"\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"OK             \",\"Get_Last_Error\":\"\"}', '2018-01-21 01:25:51', '2018-01-21 01:25:51'),
(195, 'request_param_keys=CONO&request_param_keys=TRNR&request_param_values=200&request_param_values=DN51000002&response_param_keys=TRNR&response_param_keys=PONR&response_param_keys=POSX&response_param_keys=ITNO&response_param_keys=TRQT&response_param_keys=RSCD&response_param_keys=TRSH&response_param_keys=BRE2&response_param_keys=BREF&response_param_keys=ALUN&response_param_keys=RORN&response_param_keys=RORL&response_param_keys=RESP&response_param_keys=BREM&response_param_keys=RGDT&response_param_keys=RGTM&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MDBREADMI&trans_name=LstMGLINE00', '{\"POSX\":\"0\",\"BRE2\":\"\",\"RGDT\":\"20180120\",\"RSCD\":\"A\",\"TRNR\":\"DN51000002\",\"PONR\":\"1\",\"TRQT\":\"10.000000\",\"BREM\":\"\",\"RGTM\":\"172606\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"REP            DN510000021    0 K50912S7TH2 00410.000000        A  22                                                     0     SFCSFFM3UA                    20180120  172606\",\"Get_Last_Error\":\"\",\"ITNO\":\"K50912S7TH2 004\",\"BREF\":\"\",\"RORL\":\"0\",\"TRSH\":\"22\",\"Get_Last_Error_Code\":null,\"RESP\":\"SFCSFFM3UA\",\"Get_Last_Bad_Field\":\"\",\"ALUN\":\"\",\"RORN\":\"\"}', '2018-01-21 01:27:21', '2018-01-21 01:27:21'),
(196, 'request_param_keys=CONO&request_param_keys=TRNR&request_param_values=200&request_param_values=DN51000002&response_param_keys=TRNR&response_param_keys=PONR&response_param_keys=POSX&response_param_keys=ITNO&response_param_keys=TRQT&response_param_keys=RSCD&response_param_keys=TRSH&response_param_keys=BRE2&response_param_keys=BREF&response_param_keys=ALUN&response_param_keys=RORN&response_param_keys=RORL&response_param_keys=RESP&response_param_keys=BREM&response_param_keys=RGDT&response_param_keys=RGTM&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MDBREADMI&trans_name=LstMGLINE00', '{\"error\":\"internal server error0\"}', '2018-01-21 01:29:42', '2018-01-21 01:29:42'),
(197, 'request_param_keys=CONO&request_param_keys=TRNR&request_param_values=200&request_param_values=DN51000002&response_param_keys=TRNR&response_param_keys=PONR&response_param_keys=POSX&response_param_keys=ITNO&response_param_keys=TRQT&response_param_keys=RSCD&response_param_keys=TRSH&response_param_keys=BRE2&response_param_keys=BREF&response_param_keys=ALUN&response_param_keys=RORN&response_param_keys=RORL&response_param_keys=RESP&response_param_keys=BREM&response_param_keys=RGDT&response_param_keys=RGTM&host=10.227.38.36&port=46800&username=SFCSFFM3UA&password=Alert%40123&api_id=MDBREADMI&trans_name=LstMGLINE00', '{\"POSX\":\"0\",\"BRE2\":\"\",\"RGDT\":\"20180120\",\"RSCD\":\"A\",\"TRNR\":\"DN51000002\",\"PONR\":\"1\",\"TRQT\":\"10.000000\",\"BREM\":\"\",\"RGTM\":\"172606\",\"Get_Last_Message_ID\":\"\",\"get_Transaction\":\"REP            DN510000021    0 K50912S7TH2 00410.000000        A  22                                                     0     SFCSFFM3UA                    20180120  172606\",\"Get_Last_Error\":\"\",\"ITNO\":\"K50912S7TH2 004\",\"BREF\":\"\",\"RORL\":\"0\",\"TRSH\":\"22\",\"Get_Last_Error_Code\":null,\"RESP\":\"SFCSFFM3UA\",\"Get_Last_Bad_Field\":\"\",\"ALUN\":\"\",\"RORN\":\"\"}', '2018-01-21 01:32:03', '2018-01-21 01:32:03');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_reason`
--

CREATE TABLE `transaction_reason` (
  `transaction_reason_id` varchar(10) NOT NULL,
  `name` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `company` int(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction_reason`
--

INSERT INTO `transaction_reason` (`transaction_reason_id`, `name`, `description`, `company`, `created_at`, `updated_at`) VALUES
('A         ', 'DD-Passed ', 'Delivery Dead Line Passed               ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('AA1       ', 'Stk no abl', 'Stk was not avlbl DO problem            ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('AA2       ', 'Stk no abl', 'Stk was not avlbl REC problem           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('AA3       ', 'Excs RM no', 'Excess RM workflow not followed         ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('AA4       ', 'line cls i', 'Wrong instruction to force close the RM ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('AA5       ', 'Pilferage/', 'Pilferage / loss                        ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('AA6       ', 'Sample RM ', 'Sample RM W/O                           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('B         ', 'Over Capac', 'Over Capacity                           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('B71       ', 'B71 - Bana', 'B71 - Banana Republic/ Woven Men\'s      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('B72       ', 'B72 - Bana', 'B72 - Banana Republic/ Woven Women\'s    ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('B73       ', 'B73 - Bana', 'B73 - Banana Republic/ Denim Men\'s      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('B74       ', 'B74 - Bana', 'B74 - Banana Republic/ Denim Women\'s    ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('B75       ', 'B75 - Bana', 'B75 - Banana Republic/ Factory Stores Me', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('B76       ', 'B76 - Bana', 'B76-Banana Republic/Factory Stores Women', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('BC1       ', 'LID Adjust', 'LID Adjustment - BCB                    ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('BCC       ', 'BIA - CUST', 'BIA - CUSTOMER CANCELED - ORDER QTY     ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('BCL       ', 'BIA- CUSTO', 'BIA- CUSTOMER LIABILITY                 ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('BE1       ', 'Essentials', 'Essentials Stock Adjustment             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('BI1       ', 'BIA Stock ', 'BIA Stock Adjustment                    ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('BIA       ', 'BIA - SAMP', 'BIA - SAMPLE SEWING ITEM                ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('BL1       ', 'BLI Stock ', 'BLI Stock Adjustment                    ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('BL2       ', 'BLI-LID RM', 'BLI-LID RM Transfer to M3               ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('BL3       ', 'Manual Sto', 'Manual Stock Adjustment                 ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('BLS       ', 'Brdx Ltd S', 'Brandix Limited Samples                 ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('BOH       ', 'BIA - CUST', 'BIA - CUSTOMER ON-HOLD ORDER QTY        ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('BW1       ', 'BCW Stock ', 'BCW Stock Adjustment                    ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('C         ', 'Material R', 'Material Reject                         ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('C03       ', 'CORE/Women', 'CORE/Womens                             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('C04       ', 'CK/KNIT ME', 'CK/KNIT MENS UNDERWEAR                  ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('C05       ', 'CK/KNIT WO', 'CK/KNIT WOMENS UNDERWEAR                ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('C08       ', 'CK/SALESME', 'CK/SALESMEN SAMPLE/KNIT MEN\'S UNDERWEAR ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('C09       ', 'CK/SALESME', 'CK/SALESMEN SAMPLE/KNIT WOMENS UNDERWEAR', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('CC1       ', 'BCCT Tst R', 'BCCT Test Returns                       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('CNL       ', 'BTL - Orde', 'BTL - Order Cancelled                   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('COB       ', 'BTL - Cust', 'BTL - Customer Order Booking            ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('CPR       ', 'BTL - Repe', 'BTL - Repeat Print Color Sample         ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('CPS       ', 'BTL - Prin', 'BTL - Print Color Sample                ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('CR        ', 'BTL - Colo', 'BTL - Color Sample                      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('CS        ', 'BTL - Colo', 'BTL - Color Sample                      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D         ', 'D-change  ', 'Design Change (Tech Pack)               ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D03       ', 'DBA/ DIM/ ', 'DBA/ DIM/ MENS                          ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D04       ', 'DBA/ LOVAB', 'DBA/ LOVABLE/ FILA/ MENS                ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D07       ', 'Decathlon/', 'Decathlon/Circular/Natural/Girls        ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D08       ', 'Decathlon/', 'Decathlon/Natimeo/Domyos/Boy\'s          ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D09       ', 'Decathlon/', 'Decathlon/Circular/Natural/Ladies       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D11       ', 'DBA/ NUR D', 'DBA/ NUR DIE/ MENS                      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D12       ', 'DBA/ BELLI', 'DBA/ BELLINDA/MENS                      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D15       ', 'Decathlon/', 'Decathlon/Stratermic/Quechua/Mens       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D17       ', 'Decathlon/', 'Decathlon/Circular/Kipsta/Mens?         ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D18       ', 'Decathlon/', 'Decathlon/Natimeo/TriBord               ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D20       ', 'Decathlon/', 'Decathlon/Stratermic/Queshua Ladies     ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D21       ', 'Decathlon/', 'Decathlon/Circular/Fleece/Ladies        ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D22       ', 'DBA/ DIM/ ', 'DBA/ DIM/ LADIES                        ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D23       ', 'Decathlon/', 'Decathlon/Warp/Kalenji/Ladies?????      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D24       ', 'Decathlon/', 'Decathlon/Warp/Kalenji/Mens             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D25       ', 'Decathlon/', 'Decathlon/Warp/Wedze/Ladies             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D26       ', 'Decathlon/', 'Decathlon/Warp/Domyos/Ladies            ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D27       ', 'Decathlon/', 'Decathlon/Warp/Btwin/Mens               ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D28       ', 'DBA/ABANDE', 'DBA/ABANDERADO/MENS                     ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D29       ', 'DBA/PLAYBO', 'DBA/PLAYBOY/MENS                        ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D36       ', 'Decathlon/', 'Decathlon/Circular/Fleece/Mens          ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D39       ', 'Decathlon/', 'Decathlon/Circulr/Synthtic/Domyos/Ladies', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('D42       ', 'Decathlon/', 'Decathlon/Circulr/Synthtic/Kalnji/Mens  ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('DCS       ', 'Dyes & Che', 'Dyes & Chemical Sales                   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('DEN       ', 'BTL - New ', 'BTL - New Development Sample            ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('DEP       ', 'BTL - Repe', 'BTL - Repeat Development Sample         ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('DO        ', 'BTL - DO  ', 'BTL - DO                                ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('DR2       ', 'BTL - Cuto', 'BTL - Cutover updates                   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('DRP       ', 'BTL - INQ ', 'BTL - INQ Drop                          ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('E         ', 'Line Drop ', 'Line Drop (Design)                      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('E01       ', 'BEL - GARM', 'BEL - GARMENT                           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('E02       ', 'BEL - FABR', 'BEL - FABRIC                            ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('E03       ', 'EXPRESS EF', 'EXPRESS EFO MEN?S                       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('ENG       ', 'Engineerin', 'Engineering Department                  ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('F         ', 'FOB-not me', 'FOB Price not meet to the target        ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('FG1       ', 'One schedu', 'One schedule divided to multiple schedul', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('FG2       ', 'Quantity c', 'Quantity changes in between existing sch', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('FG3       ', 'Quantity c', 'Quantity changes in existing and new sch', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('FL1       ', 'FILA Mens ', 'FILA Mens                               ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('FRE       ', 'FR Exclude', 'FR Exclude orders (Do not select this)  ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('G         ', 'Short Ship', 'Short Shipment                          ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('G71       ', 'G71 - GAP/', 'G71 - GAP/ Woven Men\'s                  ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('G72       ', 'G72 - GAP/', 'G72 - GAP/ Woven Women\'s                ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('G73       ', 'G73 - GAP/', 'G73 - GAP/ Woven Maternity              ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('G74       ', 'G74 - GAP/', 'G74 - GAP/ Denim Men\'s                  ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('G75       ', 'G75 - GAP/', 'G75 - GAP/ Denim Women\'s                ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('G76       ', 'G76 - GAP/', 'G76 - GAP/ Denim Maternity              ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('G77       ', 'G77 - GAP/', 'G77 - GAP/ Denim Kids Boys              ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('G78       ', 'G78 - GAP/', 'G78 - GAP/ Denim Kids Girls             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('H         ', 'QA - Rejec', 'Quality Assurance Rejections            ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('H03       ', 'H & M /Lad', 'H & M /Ladies  3708                     ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('H21       ', 'Hanes Bran', 'Hanes Brands Inc/Ladies/Canadelle       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('HLD       ', 'BTL -  Hol', 'BTL -  Hold                             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('IN1       ', 'BTL - Inqu', 'BTL - Inquiry Pre Procurement           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('IN2       ', 'BTL - Inqu', 'BTL - Inquiry Post Procurement Pre Plan ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('IN3       ', 'BTL - Inqu', 'BTL - Inquiry Post Planning Pre Quote   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('INQ       ', 'BTL - Inqu', 'BTL - Inquiry                           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('JO        ', 'BTL - Job ', 'BTL - Job Order                         ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('K01       ', 'KOHL\'S/Lad', 'KOHL\'S/Ladies Wear                      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('K02       ', 'Cotton On/', 'Cotton On/Active Womens?                ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('K03       ', 'BCW - SEWI', 'BCW - SEWING TRIM                       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('K04       ', 'Cotton On/', 'Cotton On/Coar Mens                     ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('K05       ', 'Cotton On/', 'Cotton On/Coar Mens                     ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('L00       ', 'L/B FROM M', 'LIABILITY TRANSFER FROM MFG WAREHOUSE   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('L01       ', 'L/B ADD TO', 'LIABILITY ADD TO BAL                    ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('L02       ', 'L/B FROM B', 'LIABILITY FROM BAL                      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('L03       ', 'L/B ADD TO', 'LIABILITY ADD TO LIABILITY WAREHOUSE    ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('L04       ', 'BLI - PACK', 'BLI - PACKING TRIM                      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('L05       ', 'LBI/Caciqu', 'LBI/Cacique/Cotton Logo                 ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('L16       ', 'LBI/Synthe', 'LBI/Synthetic Core                      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('L17       ', 'LBI/Synthe', 'LBI/Synthetic Novelty                   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('L18       ', 'LBI/Satin ', 'LBI/Satin Core                          ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('L58       ', 'LBI/LBI-No', 'LBI/LBI-Non CMI                         ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('LD1       ', 'BTL - Labd', 'BTL - Labdip First Submission           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('LD2       ', 'BTL - Labd', 'BTL - Labdip Second Submission          ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('LD3       ', 'BTL - Labd', 'BTL - Labdip Third Submission           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('LD4       ', 'BTL - Labd', 'BTL - Labdip Fourth Submission          ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('LD5       ', 'BTL - Labd', 'BTL - Labdip Fifth Submission           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('LD6       ', 'BTL - Labd', 'BTL - Labdip Sixth Submission           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('LD7       ', 'BTL - Labd', 'BTL - Labdip Seventh Submission         ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('LD8       ', 'BTL - Labd', 'BTL - Labdip Eighth Submission          ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('LD9       ', 'BTL - Labd', 'BTL - Labdip Ninth Submission           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('LDN       ', 'BTL - Appr', 'BTL - Approved Labdip                   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('LDR       ', 'BTL - Re-S', 'BTL - Re-Submission of Labdip           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('LIA       ', 'FG Liab - ', 'FG Liability - BEL                      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('LIB       ', 'BTL - Liab', 'BTL - Liability Quantity                ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M01       ', 'M&S/boys w', 'M&S/boys wear                           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M04       ', 'M&S/T14 - ', 'M&S/T14 - Men\'s / Authentic             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M05       ', 'M&S/T14 - ', 'M&S/T14 - Men\'s / Outstanding Valu      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M18       ', 'M&S/T61 - ', 'M&S/T61 - Ladies\' Underwear Outstanding ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M19       ', 'M&S/T61 - ', 'M&S/T61 - Ladies\' Underwear Authentic   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M20       ', 'M&S/T14 - ', 'M&S/T14 - Men\'s / Autograph             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M22       ', 'M&S T71 Ki', 'M&S T71 Kids Underwear                  ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M23       ', 'T71 - Boys', 'T71 - Boys Underwear - Autograph        ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M24       ', 'T71 - Boys', 'T71 - Boys Underwear - Authentic        ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M25       ', 'T71 - Boys', 'T71 - Boys Underwear - Outstanding Value', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M27       ', 'T71 - Girl', 'T71 - Girls Underwear - Authentic       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M28       ', 'T71 - Girl', 'T71 - Girls Underwear -Outstanding Value', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M34       ', 'M&S/T61 - ', 'M&S/T61 - Single Hanging Knicker        ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M35       ', 'T71 - Boys', 'T71 - Boys Underwear - Base Layer       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M37       ', 'T71 - Boys', 'T71 - Boys Underwear - Skin Kind        ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M38       ', 'T71 - Girl', 'T71 - Girls Underwear - Skin Kind       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M39       ', 'T71 - Boys', 'T71 - Boys Underwear - Thermal          ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M40       ', 'T71 - Girl', 'T71 - Girls Underwear - Thermal         ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M43       ', 'T71 - Boys', 'T71 - Boys Underwear - Super Fine       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M44       ', 'T71 - Girl', 'T71 - Girls Underwear - Super Fine      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M46       ', 'M&S/T14 - ', 'M&S/T14 - Men\'s / Heatgen               ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M48       ', 'M&S/T33 - ', 'M&S/T33 - Ladies Shape wear             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M49       ', 'T76-Boys S', 'T76-Boys School Wear - Base Layer       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M53       ', 'M&S/T14 - ', 'M&S/T14 - Mens / M&S Man Rigid          ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M54       ', 'M&S/T14 - ', 'M&S/T14 - Mens / M&S Man Stretch        ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M55       ', 'T76 - Girl', 'T76 - Girls School Wear - Base Layer    ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M71       ', 'M&S-T17-Me', 'M&S-T17-Menswear                        ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('M77       ', 'T57  Ladie', 'T57  Ladies Wear Casual Bottoms         ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('MAC       ', 'Machine Ma', 'Machine Maintenance                     ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('MEC       ', 'Mechanical', 'Mechanical Dept                         ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('MNT       ', 'Maintenanc', 'Maintenance                             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('NA        ', 'Not Applic', 'Not Applicable                          ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('NRQ       ', 'BTL -  New', 'BTL -  New Development Requisition      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('O71       ', 'O71 - Old ', 'O71 - Old Navy/ Woven Men\'s             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('O72       ', 'O72 - Old ', 'O72 - Old Navy/ Woven Women\'s           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('O73       ', 'O73 - Old ', 'O73 - Old Navy/ Denim Women\'s           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('O74       ', 'O74 - Old ', 'O74 - Old Navy/ Kids                    ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('OB1       ', 'Opening Ba', 'Opening Balance - BAI                   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('OBK       ', 'O/B Koggal', 'Opening Balance - Koggala               ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('OBN       ', 'O/B Nivith', 'Opening Balance - Nivithigala           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('OBP       ', 'O/B PTK Ra', 'Opening Balance - PTK Rambukkana        ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('OBR       ', 'O/B Ratmal', 'Opening Balance - Ratmalana             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P03       ', 'PVH/TH/KNI', 'PVH/TH/KNIT UNDERWEAR/MEN\'S             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P04       ', 'PVH/IZOD/K', 'PVH/IZOD/KNIT UNDERWEAR/MEN\'S           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P05       ', 'PVH/VH/KNI', 'PVH/VH/KNIT UNDERWEAR/MEN\'S             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P08       ', 'PVH/MK/KNI', 'PVH/MK/KNIT UNDERWEAR/MEN\'S             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P10       ', 'PVH/CHAPS/', 'PVH/CHAPS/Woven Mens Underwear          ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P11       ', 'PVH/SAMPLE', 'PVH/SAMPLES/KNIT UNDERWEAR/MEN\'S        ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P12       ', 'PVH/TH/WOV', 'PVH/TH/WOVEN UNDERWEAR/MEN\'S            ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('P13       ', 'PVH/IZOD/W', 'PVH/IZOD/WOVEN UNDERWEAR/MEN\'S          ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('PRO       ', 'Product De', 'Product Develop                         ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('REJ       ', 'BTL Custom', 'BTL Customer Return                     ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('RM1       ', 'BRL sendin', 'BRL Sending Goods                       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('RM2       ', 'Returned t', 'Returned to Supplier                    ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('RM3       ', 'Reject Reu', 'Reject Reuse                            ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('SEW       ', 'Sewing Dep', 'Sewing Department                       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('ST1       ', 'BEL-Stock ', 'BEL-Stock value adjustments             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('ST2       ', 'BIA-Stock ', 'BIA-Stock value adjustments             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('ST3       ', 'BCW-Stock ', 'BCW-Stock value adjustments             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('T01       ', 'BTL - Shad', 'BTL - Shade Variation                   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('T02       ', 'BTL - Stoc', 'BTL - Stock Adjustment                  ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('T71       ', 'TKO/ Woven', 'TKO/ Woven Menswear                     ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('TLF       ', 'BTL - Left', 'BTL - Leftover Reclassification         ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('UN2       ', 'UNIQLO CO ', 'UNIQLO CO LTD Women\'s                   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V03       ', 'VSD/PINK  ', 'VSD/PINK                                ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V05       ', 'VSD/VSI/Si', 'VSD/VSI/Signature Cotton                ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V07       ', 'VSD/VSI/Yo', 'VSD/VSI/Young Glamour                   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V13       ', 'VSS/PINK  ', 'VSS/PINK                                ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V17       ', 'VSS/VSI/Si', 'VSS/VSI/Signature Cotton                ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V19       ', 'VSS/VSI/Yo', 'VSS/VSI/Young Glamour                   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V27       ', 'VSI/VSD/BB', 'VSI/VSD/BBV                             ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V56       ', 'VS Apparel', 'VS Apparel/ 2x2 Modal Rib/VSD           ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V60       ', 'VS Apparel', 'VS ApparelDream tees/VSD                ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V62       ', 'VS Apparel', 'VS Apparel/DS Bottoms/VSD               ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V63       ', 'VS Apparel', 'VS Apparel/DS Bottoms/VSS               ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V64       ', 'VS Apparel', 'VS Apparel/DS Tops/VSD                  ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V66       ', 'VS Apparel', 'VS Apparel/Fleece/VSD                   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V67       ', 'VS Apparel', 'VS Apparel/Fleece/VSS                   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V68       ', 'VS Apparel', 'VS Apparel/Tencel/VSD                   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V69       ', 'VS Apparel', 'VS Apparel/Tencel/VSS                   ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V70       ', 'VS Apparel', 'VS Apparel/Yoga/VSD                     ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V71       ', 'VS Apparel', 'VS Apparel/Yoga/VSS                     ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V72       ', 'VS SLEEP/V', 'VS SLEEP/VSD/Casual                     ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V73       ', 'VS SLEEP/V', 'VS SLEEP/VSD/Dressy (N)                 ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V74       ', 'VS SLEEP/V', 'VS SLEEP/VSD/Dressy                     ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V75       ', 'VS SLEEP/V', 'VS SLEEP/VSS/Casual                     ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V77       ', 'VS SLEEP/V', 'VS SLEEP/VSS/Dressy                     ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V79       ', 'VS SLEEP/V', 'VS SLEEP/VSD/SWIM                       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V80       ', 'VS SLEEP/V', 'VS SLEEP/VSS/SWIM                       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V81       ', 'VS Apparel', 'VS Apparel/Light Weight Modal/VSD       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V85       ', 'VS SLEEP/V', 'VS SLEEP/VSD/Mayfair                    ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V87       ', 'VS SLEEP/V', 'VS SLEEP/VSS/Mayfair                    ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V88       ', 'VS Apparel', 'VS Apparel/Heavy Weight Modal/VSD       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V91       ', 'VS APPAREL', 'VS APPAREL/VSD/CVC                      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('V96       ', 'VSS/VSI Se', 'VSS/VSI Seamless                        ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('VO        ', 'BTL - Vend', 'BTL - Vendor Order                      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('W00       ', 'W/O FROM M', 'WRITE OFF FROM MFG WAREHOUSE            ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('W01       ', 'W/O ADD TO', 'WRITE OFF - ADD TO BAL                  ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('W02       ', 'W/O FROM B', 'WRITE OFF FROM BAL                      ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('W03       ', 'W/O TO LIA', 'WRITE OFF - ADD TO LIABILITY WAREHOUSE  ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('W04       ', 'RE W/O FRO', 'WRITE OFF RESERVE FROM BAL              ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('W05       ', 'W/O REUSE ', 'WRITE OFF REUSE - ADD BACK TO BAL       ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('Z91       ', '31MAR16_ST', '31MAR16_Stock Adjustment                ', 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(40) NOT NULL,
  `password` varchar(52) NOT NULL,
  `wh_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_do_map`
--

CREATE TABLE `user_do_map` (
  `user_do_map_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `do_items_id` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_tran_res_map`
--

CREATE TABLE `user_tran_res_map` (
  `user_tran_res_map_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `trans_res_id` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `wh_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `wh_code` varchar(10) NOT NULL,
  `wh_name` varchar(255) NOT NULL,
  `company` int(10) NOT NULL,
  `factory` varchar(4) NOT NULL,
  `division` int(10) NOT NULL,
  `communication_address` varchar(10) NOT NULL,
  `wh_type` varchar(10) NOT NULL,
  `country` varchar(10) NOT NULL,
  `object_access_group` varchar(10) NOT NULL,
  `mdm_host` varchar(40) NOT NULL,
  `mdm_username` varchar(40) NOT NULL,
  `mdm_password` varchar(40) NOT NULL,
  `mdm_db` varchar(40) NOT NULL,
  `mdm_port` varchar(11) NOT NULL,
  `sfcs_host` varchar(40) NOT NULL,
  `sfcs_username` varchar(40) NOT NULL,
  `sfcs_password` varchar(40) NOT NULL,
  `sfcs_db` varchar(40) NOT NULL,
  `sfcs_port` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`wh_id`, `created_at`, `updated_at`, `wh_code`, `wh_name`, `company`, `factory`, `division`, `communication_address`, `wh_type`, `country`, `object_access_group`, `mdm_host`, `mdm_username`, `mdm_password`, `mdm_db`, `mdm_port`, `sfcs_host`, `sfcs_username`, `sfcs_password`, `sfcs_db`, `sfcs_port`) VALUES
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ACO', 'ACO - BEL COS Plant India           ', 200, 'ACO', 145, '145', '10', 'IN ', 'BAIACO    ', '', '', '', '', '', '192.168.0.110', 'baiall', 'baiall', 'bai_rm_pj1', 3321),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'AIN', 'AIN - Apparel India                 ', 200, 'AIN', 145, '145', '10', 'IN ', 'BAIAIN    ', '', '', '', '', '', '', '', '', '', 0),
(4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'GI1', 'GI1 - BAI General Item Plant 1      ', 200, 'AIN', 145, '145', '50', 'IN ', 'BAIGI1    ', '', '', '', '', '', '', '', '', '', 0),
(5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'AIP', 'AIP - Apparel India Plant 2         ', 200, 'AIP', 145, '145', '10', 'IN ', 'BAIAIP    ', '', '', '', '', '', '', '', '', '', 0),
(6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'GI2', 'GI2 - BAI General Item Plant 2      ', 200, 'AIP', 145, '145', '50', 'IN ', 'BAIGI2    ', '', '', '', '', '', '', '', '', '', 0),
(7, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'AIS', 'AIS - Apparel India Subcon          ', 200, 'AIS', 145, '145', '10', 'IN ', 'BAIAIS    ', '', '', '', '', '', '', '', '', '', 0),
(8, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ASI', 'BEL SI                              ', 200, 'ASI', 145, '145', '10', 'IN ', '          ', '', '', '', '', '', '', '', '', '', 0),
(9, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '407', 'BAI-Brandix Apparel India           ', 200, 'BAI', 145, '145', '50', 'IN ', 'BEL407    ', '', '', '', '', '', '192.168.0.110', 'baiall', 'baiall', 'bai_rm_pj1', 3307),
(10, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '408', 'BAI - Subcontract WH                ', 200, 'BAI', 145, '145', '40', 'IN ', '          ', '', '', '', '', '', '', '', '', '', 0),
(11, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '104', 'BEL-Brandix Essentials Ltd (A/c BAL)', 200, 'BAL', 110, '140', '20', 'SL ', 'BEL104    ', '', '', '', '', '', '', '', '', '', 0),
(12, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '107', 'BAI -(Brandix Apparel India Limited)', 200, 'BAL', 110, '145', '20', 'IN ', 'BAI107    ', '', '', '', '', '', '', '', '', '', 0),
(13, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '108', 'AIS Apparel India Subcon (A/c BAL)  ', 200, 'BAL', 110, '145', '25', 'IN ', 'BAI108    ', '', '', '', '', '', '', '', '', '', 0),
(14, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '114', 'BEL- Sample Purchasing WH           ', 200, 'BAL', 110, '140', '30', 'SL ', 'BEL114    ', '', '', '', '', '', '', '', '', '', 0),
(15, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '117', 'BAI -Sample Purchasing WH           ', 200, 'BAL', 110, '145', '30', 'IN ', 'BAI117    ', '', '', '', '', '', '', '', '', '', 0),
(16, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '144', 'BEL- RM Liability Warehouse         ', 200, 'BAL', 110, '140', 'LI', 'SL ', 'BEL144    ', '', '', '', '', '', '', '', '', '', 0),
(17, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '147', 'BAI- RM Liability Warehouse         ', 200, 'BAL', 110, '145', 'LI', 'IN ', 'BAI147    ', '', '', '', '', '', '', '', '', '', 0),
(18, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '207', 'BAI2-(Brandix Apparel India Limited)', 200, 'BAL', 110, '145', '20', 'IN ', 'BAI207    ', '', '', '', '', '', '192.168.0.110', 'baiall', 'baiall', 'bai_rm_pj1', 3309),
(19, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'A51', 'BAI Apparel India (A/c BAL)         ', 200, 'BAL', 110, '145', '25', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(20, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'A70', 'A70 - COS Material & Purchase       ', 200, 'BAL', 110, '145', '20', 'IN ', 'BAIA70    ', '', '', '', '', '', '', '', '', '', 0),
(21, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'AL2', 'BAI2- RM Liability Warehouse        ', 200, 'BAL', 110, '145', 'LI', 'IN ', 'BAIAL2    ', '', '', '', '', '', '', '', '', '', 0),
(22, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'AL3', 'BAI- 108 Liability Warehouse (Sub)  ', 200, 'BAL', 110, '145', 'LI', 'IN ', 'BAIAL3    ', '', '', '', '', '', '', '', '', '', 0),
(23, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'AS2', 'BAI2 -Sample Purchasing WH          ', 200, 'BAL', 110, '145', '30', 'IN ', 'BAIAS2    ', '', '', '', '', '', '', '', '', '', 0),
(24, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'AW1', 'BAI- RM Write Off Warehouse         ', 200, 'BAL', 110, '145', 'WO', 'IN ', 'BAIAW1    ', '', '', '', '', '', '', '', '', '', 0),
(25, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'AW2', 'BAI2- RM Write Off Warehouse        ', 200, 'BAL', 110, '145', 'WO', 'IN ', 'BAIAW2    ', '', '', '', '', '', '', '', '', '', 0),
(26, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'AW3', 'BAI- 108 - Write Off Warehouse (Sub)', 200, 'BAL', 110, '145', 'WO', 'IN ', 'BAIAW3    ', '', '', '', '', '', '', '', '', '', 0),
(27, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'C50', 'BEC-Brandix Essentials Cen (A/c BAL)', 200, 'BAL', 110, '141', '20', 'SL ', 'BEC50     ', '', '', '', '', '', '', '', '', '', 0),
(28, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'C52', 'CHA - Hambanthota(A/c BAL)          ', 200, 'BAL', 110, '141', '25', 'SL ', 'BEC52     ', '', '', '', '', '', '', '', '', '', 0),
(29, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'C53', 'CKA - Kahawatte (A/c BAL)           ', 200, 'BAL', 110, '141', '25', 'SL ', 'BEC53     ', '', '', '', '', '', '', '', '', '', 0),
(30, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'C55', 'CNV - Nivithigala(A/c BAL)          ', 200, 'BAL', 110, '141', '25', 'SL ', 'BEC55     ', '', '', '', '', '', '', '', '', '', 0),
(31, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'C57', 'CRK - Rambukkana (A/c BAL)          ', 200, 'BAL', 110, '141', '20', 'SL ', 'BEC57     ', '', '', '', '', '', '', '', '', '', 0),
(32, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'C58', 'CSS - Subcontract (A/c BAL)         ', 200, 'BAL', 110, '141', '25', 'SL ', 'BEC58     ', '', '', '', '', '', '', '', '', '', 0),
(33, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'C59', 'CAN - Anuradhapura (A/c BAL)        ', 200, 'BAL', 110, '141', '25', 'SL ', 'BEC59     ', '', '', '', '', '', '', '', '', '', 0),
(34, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CL0', 'BEC- C50 Liability Warehouse        ', 200, 'BAL', 110, '141', 'LI', 'SL ', 'BECL0     ', '', '', '', '', '', '', '', '', '', 0),
(35, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CL1', 'BEC- RM Liability Warehouse         ', 200, 'BAL', 110, '141', 'LI', 'SL ', 'BECL1     ', '', '', '', '', '', '', '', '', '', 0),
(36, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CL2', 'BEC- C52 Liability Warehouse        ', 200, 'BAL', 110, '141', 'LI', 'SL ', 'BECL2     ', '', '', '', '', '', '', '', '', '', 0),
(37, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CL3', 'BEC- C53 Liability Warehouse        ', 200, 'BAL', 110, '141', 'LI', 'SL ', 'BECL3     ', '', '', '', '', '', '', '', '', '', 0),
(38, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CL5', 'BEC- C55 Liability Warehouse        ', 200, 'BAL', 110, '141', 'LI', 'SL ', 'BECL5     ', '', '', '', '', '', '', '', '', '', 0),
(39, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CL7', 'BEC- C57 Liability Warehouse        ', 200, 'BAL', 110, '141', 'LI', 'SL ', 'BECL7     ', '', '', '', '', '', '', '', '', '', 0),
(40, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CL8', 'BEC- C58 Liability Warehouse        ', 200, 'BAL', 110, '141', 'LI', 'SL ', 'BECL8     ', '', '', '', '', '', '', '', '', '', 0),
(41, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CL9', 'BEC- C59 Liability Warehouse        ', 200, 'BAL', 110, '141', 'LI', 'SL ', 'BECL9     ', '', '', '', '', '', '', '', '', '', 0),
(42, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CS1', 'BEC - Sample Purchasing WH          ', 200, 'BAL', 110, '141', '30', 'SL ', 'BECS1     ', '', '', '', '', '', '', '', '', '', 0),
(43, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CW0', 'BEC- C50 - Write-Off Warehouse      ', 200, 'BAL', 110, '141', 'WO', 'SL ', 'BECW0     ', '', '', '', '', '', '', '', '', '', 0),
(44, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CW1', 'BEC - RM Write-Off Warehouse        ', 200, 'BAL', 110, '141', 'WO', 'SL ', 'BECW1     ', '', '', '', '', '', '', '', '', '', 0),
(45, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CW2', 'BEC- C52 - Write-Off Warehouse (Ham)', 200, 'BAL', 110, '141', 'WO', 'SL ', 'BECW2     ', '', '', '', '', '', '', '', '', '', 0),
(46, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CW3', 'BEC- C53 - Write-Off Warehouse (Kah)', 200, 'BAL', 110, '141', 'WO', 'SL ', 'BECW3     ', '', '', '', '', '', '', '', '', '', 0),
(47, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CW5', 'BEC- C55 - Write Off Warehouse (Niv)', 200, 'BAL', 110, '141', 'WO', 'SL ', 'BECW5     ', '', '', '', '', '', '', '', '', '', 0),
(48, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CW7', 'BEC- C57 - Write Off Warehouse (Ram)', 200, 'BAL', 110, '141', 'WO', 'SL ', 'BECW7     ', '', '', '', '', '', '', '', '', '', 0),
(49, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CW8', 'BEC- C58 - Write Off Warehouse (Sub)', 200, 'BAL', 110, '141', 'WO', 'SL ', 'BECW8     ', '', '', '', '', '', '', '', '', '', 0),
(50, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CW9', 'BEC- C59 - Write Off Warehouse (Anu)', 200, 'BAL', 110, '141', 'WO', 'SL ', 'BECW9     ', '', '', '', '', '', '', '', '', '', 0),
(51, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'E1L', 'BEL- E59 Liability Warehouse (Bat1) ', 200, 'BAL', 110, '140', 'LI', 'SL ', 'BELE1L    ', '', '', '', '', '', '', '', '', '', 0),
(52, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'E1W', 'BEL- E59 - Write Off Warehouse(Bat1)', 200, 'BAL', 110, '140', 'WO', 'SL ', 'BELE1W    ', '', '', '', '', '', '', '', '', '', 0),
(53, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'E2L', 'BEL- E61 Liability Warehouse (Bat2) ', 200, 'BAL', 110, '140', 'LI', 'SL ', 'BELE2L    ', '', '', '', '', '', '', '', '', '', 0),
(54, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'E2W', 'BEL- E61 - Write Off Warehouse(Bat2)', 200, 'BAL', 110, '140', 'WO', 'SL ', 'BELE2W    ', '', '', '', '', '', '', '', '', '', 0),
(55, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'E51', 'EDV Essentials Devon (A/c BAL)      ', 200, 'BAL', 110, '140', '25', 'SL ', 'BELE51    ', '', '', '', '', '', '', '', '', '', 0),
(56, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'E52', 'EHA Essentials Hambanthota(A/c BAL) ', 200, 'BAL', 110, '140', '25', 'SL ', 'BELE52    ', '', '', '', '', '', '', '', '', '', 0),
(57, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'E53', 'EKA Essentials Kahawatte (A/c BAL)  ', 200, 'BAL', 110, '140', '25', 'SL ', 'BELE53    ', '', '', '', '', '', '', '', '', '', 0),
(58, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'E54', 'EKG Essentials Koggala (A/c BAL)    ', 200, 'BAL', 110, '140', '20', 'SL ', 'BELE54    ', '', '', '', '', '', '', '', '', '', 0),
(59, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'E55', 'ENV Essentials Nivithigala (A/c BAL)', 200, 'BAL', 110, '140', '25', 'SL ', 'BELE55    ', '', '', '', '', '', '', '', '', '', 0),
(60, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'E56', 'EPG Essentials Polgahawela (A/c BAL)', 200, 'BAL', 110, '140', '25', 'SL ', 'BELE56    ', '', '', '', '', '', '', '', '', '', 0),
(61, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'E57', 'ERK Essentials Rambukkana (A/c BAL) ', 200, 'BAL', 110, '140', '20', 'SL ', 'BELE57    ', '', '', '', '', '', '', '', '', '', 0),
(62, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'E58', 'ESS Essentials Subcontract (A/c BAL)', 200, 'BAL', 110, '140', '25', 'SL ', 'BELE58    ', '', '', '', '', '', '', '', '', '', 0),
(63, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'E59', 'EBA Essentials Batticaloa1 (A/c BAL)', 200, 'BAL', 110, '140', '25', 'SL ', 'BELE59    ', '', '', '', '', '', '', '', '', '', 0),
(64, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'E61', 'EBC Essentials Batticaloa2 (A/c BAL)', 200, 'BAL', 110, '140', '25', 'SL ', 'BELE61    ', '', '', '', '', '', '', '', '', '', 0),
(65, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'E70', 'BEL COS Matrial & Purchase SL       ', 200, 'BAL', 110, '140', '20', 'SL ', 'BELE70    ', '', '', '', '', '', '', '', '', '', 0),
(66, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EL1', 'BEL- E51 Liability Warehouse (Dev)  ', 200, 'BAL', 110, '140', 'LI', 'SL ', 'BELEL1    ', '', '', '', '', '', '', '', '', '', 0),
(67, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EL2', 'BEL- E52 Liability Warehouse (Ham)  ', 200, 'BAL', 110, '140', 'LI', 'SL ', 'BELEL2    ', '', '', '', '', '', '', '', '', '', 0),
(68, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EL3', 'BEL- E52 Liability Warehouse (Kah)  ', 200, 'BAL', 110, '140', 'LI', 'SL ', 'BELEL3    ', '', '', '', '', '', '', '', '', '', 0),
(69, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EL4', 'BEL- E54 Liability Warehouse (Kog)  ', 200, 'BAL', 110, '140', 'LI', 'SL ', 'BELEL4    ', '', '', '', '', '', '', '', '', '', 0),
(70, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EL5', 'BEL- E55 Liability Warehouse (Niv)  ', 200, 'BAL', 110, '140', 'LI', 'SL ', 'BELEL5    ', '', '', '', '', '', '', '', '', '', 0),
(71, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EL6', 'BEL- E56 Liability Warehouse (Pol)  ', 200, 'BAL', 110, '140', 'LI', 'SL ', 'BELEL6    ', '', '', '', '', '', '', '', '', '', 0),
(72, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EL7', 'BEL- E57 Liability Warehouse (Ram)  ', 200, 'BAL', 110, '140', 'LI', 'SL ', 'BELEL7    ', '', '', '', '', '', '', '', '', '', 0),
(73, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EL8', 'BEL- E58 Liability Warehouse (Sub)  ', 200, 'BAL', 110, '140', 'LI', 'SL ', 'BELEL8    ', '', '', '', '', '', '', '', '', '', 0),
(74, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EW0', 'BEL- 104 - Write Off Warehouse      ', 200, 'BAL', 110, '140', 'WO', 'SL ', 'BELEW0    ', '', '', '', '', '', '', '', '', '', 0),
(75, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EW1', 'BEL- E51 - Write Off Warehouse (Dev)', 200, 'BAL', 110, '140', 'WO', 'SL ', 'BELEW1    ', '', '', '', '', '', '', '', '', '', 0),
(76, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EW2', 'BEL- E52 - Write Off Warehouse (Ham)', 200, 'BAL', 110, '140', 'WO', 'SL ', 'BELEW2    ', '', '', '', '', '', '', '', '', '', 0),
(77, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EW3', 'BEL- E53 - Write Off Warehouse (Kah)', 200, 'BAL', 110, '140', 'WO', 'SL ', 'BELEW3    ', '', '', '', '', '', '', '', '', '', 0),
(78, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EW4', 'BEL- E54 - Write Off Warehouse (Kog)', 200, 'BAL', 110, '140', 'WO', 'SL ', 'BELEW4    ', '', '', '', '', '', '', '', '', '', 0),
(79, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EW5', 'BEL- E55 - Write Off Warehouse (Niv)', 200, 'BAL', 110, '140', 'WO', 'SL ', 'BELEW5    ', '', '', '', '', '', '', '', '', '', 0),
(80, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EW6', 'BEL- E56 - Write Off Warehouse (Pol)', 200, 'BAL', 110, '140', 'WO', 'SL ', 'BELEW6    ', '', '', '', '', '', '', '', '', '', 0),
(81, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EW7', 'BEL- E57 - Write Off Warehouse (Ram)', 200, 'BAL', 110, '140', 'WO', 'SL ', 'BELEW7    ', '', '', '', '', '', '', '', '', '', 0),
(82, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EW8', 'BEL- E58 - Write Off Warehouse (Sub)', 200, 'BAL', 110, '140', 'WO', 'SL ', 'BELEW8    ', '', '', '', '', '', '', '', '', '', 0),
(83, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'J51', 'J51 - BCB -BAL RM Purchasing WH     ', 200, 'BAL', 110, '125', '20', 'BD ', 'BCWJ51    ', '', '', '', '', '', '', '', '', '', 0),
(84, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'J71', 'J71 - BCB -BAL RM Subcon RM WH      ', 200, 'BAL', 110, '125', '20', 'BD ', 'BCWJ71    ', '', '', '', '', '', '', '', '', '', 0),
(85, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'JL1', 'JL1 - BCB -BAL RM Liability WH      ', 200, 'BAL', 110, '125', 'LI', 'BD ', 'BCWJL1    ', '', '', '', '', '', '', '', '', '', 0),
(86, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'JS1', 'JS1-BCB-Sample Purch WH             ', 200, 'BAL', 110, '125', '30', 'BD ', 'BCWJS1    ', '', '', '', '', '', '', '', '', '', 0),
(87, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'JW1', 'JW1 - BCB -BAL RM Write-off WH      ', 200, 'BAL', 110, '125', 'WO', 'BD ', 'BCWJW1    ', '', '', '', '', '', '', '', '', '', 0),
(88, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K50', 'K50 - BCW ? Rathmalana RM WH        ', 200, 'BAL', 110, '120', '20', 'SL ', 'BCWK50    ', '', '', '', '', '', '', '', '', '', 0),
(89, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K51', 'K51 - BCW - Brandix Center WH       ', 200, 'BAL', 110, '120', '20', 'SL ', 'BCWK51    ', '', '', '', '', '', '', '', '', '', 0),
(90, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K52', 'K52 - BCW -Rideegama RM WH          ', 200, 'BAL', 110, '120', '20', 'SL ', 'BCWK52    ', '', '', '', '', '', '', '', '', '', 0),
(91, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K53', 'K53 - BCW -Avissawella Purchasing WH', 200, 'BAL', 110, '120', '20', 'SL ', 'BCWK53    ', '', '', '', '', '', '', '', '', '', 0),
(92, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K54', 'K54 - BCW -Hanwella RM WH           ', 200, 'BAL', 110, '120', '20', 'SL ', 'BCWK54    ', '', '', '', '', '', '', '', '', '', 0),
(93, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K55', 'K55 - BCW -Girithale RM WH          ', 200, 'BAL', 110, '120', '20', 'SL ', 'BCWK55    ', '', '', '', '', '', '', '', '', '', 0),
(94, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K56', 'K56 - BCW -Seeduwa RM WH            ', 200, 'BAL', 110, '120', '20', 'SL ', 'BCWK56    ', '', '', '', '', '', '', '', '', '', 0),
(95, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K71', 'K71 - BCW -Rathmalana Subcon RM WH  ', 200, 'BAL', 110, '120', '20', 'SL ', 'BCWK71    ', '', '', '', '', '', '', '', '', '', 0),
(96, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K73', 'K73 - BCW -Avissawella Subcon RM WH ', 200, 'BAL', 110, '120', '20', 'SL ', 'BCWK73    ', '', '', '', '', '', '', '', '', '', 0),
(97, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'KL0', 'KL0 - BCW - Rathmalana Liability WH ', 200, 'BAL', 110, '120', 'LI', 'SL ', 'BCWKL0    ', '', '', '', '', '', '', '', '', '', 0),
(98, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'KL1', 'KL1-BCW- Brandix Center Liability WH', 200, 'BAL', 110, '120', 'LI', 'SL ', 'BCWKL1    ', '', '', '', '', '', '', '', '', '', 0),
(99, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'KL2', 'KL2 - BCW -Rideegama Liability WH   ', 200, 'BAL', 110, '120', 'LI', 'SL ', 'BCWKL2    ', '', '', '', '', '', '', '', '', '', 0),
(100, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'KL3', 'KL3 - BCW -Avissawella Liability WH ', 200, 'BAL', 110, '120', 'LI', 'SL ', 'BCWKL3    ', '', '', '', '', '', '', '', '', '', 0),
(101, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'KL4', 'KL4 - BCW -Hanwella Liability WH    ', 200, 'BAL', 110, '120', 'LI', 'SL ', 'BCWKL4    ', '', '', '', '', '', '', '', '', '', 0),
(102, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'KL5', 'KL5 - BCW -Girithale Liability WH   ', 200, 'BAL', 110, '120', 'LI', 'SL ', 'BCWKL5    ', '', '', '', '', '', '', '', '', '', 0),
(103, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'KL6', 'KL6 - BCW -Seeduwa Liability WH     ', 200, 'BAL', 110, '120', 'LI', 'SL ', 'BCWKL6    ', '', '', '', '', '', '', '', '', '', 0),
(104, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'KS0', 'KS0-BCW-Ekala Sample Purch WH       ', 200, 'BAL', 110, '120', '30', 'SL ', 'BCWKS0    ', '', '', '', '', '', '', '', '', '', 0),
(105, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'KW0', 'KW0 - BCW - Rathmalana Write-off WH ', 200, 'BAL', 110, '120', 'WO', 'SL ', 'BCWKW0    ', '', '', '', '', '', '', '', '', '', 0),
(106, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'KW1', 'KW1 - BCW - Brandix Center WO WH    ', 200, 'BAL', 110, '120', 'WO', 'SL ', 'BCWKW1    ', '', '', '', '', '', '', '', '', '', 0),
(107, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'KW2', 'KW2 - BCW -Rideegama Write-off WH   ', 200, 'BAL', 110, '120', 'WO', 'SL ', 'BCWKW2    ', '', '', '', '', '', '', '', '', '', 0),
(108, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'KW3', 'KW3 - BCW -Avissawella Write-off WH ', 200, 'BAL', 110, '120', 'WO', 'SL ', 'BCWKW3    ', '', '', '', '', '', '', '', '', '', 0),
(109, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'KW4', 'KW4 - BCW -Hanwella Write-off WH    ', 200, 'BAL', 110, '120', 'WO', 'SL ', 'BCWKW4    ', '', '', '', '', '', '', '', '', '', 0),
(110, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'KW5', 'KW5 - BCW -Girithale Write-off WH   ', 200, 'BAL', 110, '120', 'WO', 'SL ', 'BCWKW5    ', '', '', '', '', '', '', '', '', '', 0),
(111, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'KW6', 'KW6 - BCW -Seeduwa Write-off WH     ', 200, 'BAL', 110, '120', 'WO', 'SL ', 'BCWKW6    ', '', '', '', '', '', '', '', '', '', 0),
(112, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'L51', 'L51-BLI-Wathupitiwala Purch WH      ', 200, 'BAL', 110, '146', '20', 'SL ', 'BLIL51    ', '', '', '', '', '', '', '', '', '', 0),
(113, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'L61', 'L61-BLI-Wathupitiwala Sub Con Pur WH', 200, 'BAL', 110, '146', '25', 'SL ', 'BLIL51    ', '', '', '', '', '', '', '', '', '', 0),
(114, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'L71', 'L71 - BLI- Quantum Sub Con Pur WH   ', 200, 'BAL', 110, '146', '20', 'IN ', 'BLIL71    ', '', '', '', '', '', '', '', '', '', 0),
(115, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'LL1', 'LL1-BLI-Wathupitiwala Liability WH  ', 200, 'BAL', 110, '146', 'LI', 'SL ', 'BLILL1    ', '', '', '', '', '', '', '', '', '', 0),
(116, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'LLA', 'LLA - BLI- Quantum Liability WH     ', 200, 'BAL', 110, '146', 'LI', 'IN ', 'BLILLA    ', '', '', '', '', '', '', '', '', '', 0),
(117, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'LS1', 'LS1-BLI-Biyagama Sample Purch WH    ', 200, 'BAL', 110, '146', '30', 'SL ', 'BLILS1    ', '', '', '', '', '', '', '', '', '', 0),
(118, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'LW1', 'LW1-BLI-WathupitiwalaWrite-off WH   ', 200, 'BAL', 110, '146', 'WO', 'SL ', 'BLILW1    ', '', '', '', '', '', '', '', '', '', 0),
(119, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'LWA', 'LWA - BLI- Quantum Write-off WH     ', 200, 'BAL', 110, '146', 'WO', 'IN ', 'BLILWA    ', '', '', '', '', '', '', '', '', '', 0),
(120, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N51', 'N51 - BASL - Mirigama Purch -1 WH   ', 200, 'BAL', 110, '130', '20', 'SL ', 'BIAN51    ', '', '', '', '', '', '192.168.0.110', 'baiall', 'baiall', 'bai_rm_pj1', 3321),
(121, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N52', 'N52 - BASL - Welisara Purch WH      ', 200, 'BAL', 110, '130', '20', 'SL ', 'BIAN52    ', '', '', '', '', '', '192.168.0.110', 'baiall', 'baiall', 'bai_rm_pj1', 3321),
(122, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N53', 'N53 - BASL - Minuwangoda Purch WH   ', 200, 'BAL', 110, '130', '20', 'SL ', 'BIAN53    ', '', '', '', '', '', '', '', '', '', 0),
(123, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N54', 'N54 - Devon Sub                     ', 200, 'BAL', 110, '130', '20', 'SL ', 'BIAN54    ', '', '', '', '', '', '192.168.0.110', 'baiall', 'baiall', 'bai_rm_pj1', 3321),
(124, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N55', 'N55 - BASL- Katunayake Purch WH     ', 200, 'BAL', 110, '130', '20', 'SL ', 'BIAN55    ', '', '', '', '', '', '', '', '', '', 0),
(125, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N56', 'N56 - BIA - Anuradhapura WH         ', 200, 'BAL', 110, '130', '25', 'SL ', 'BIAN56    ', '', '', '', '', '', '', '', '', '', 0),
(126, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N57', 'N57 - BASL - Polonnaruwa WH         ', 200, 'BAL', 110, '130', '20', 'SL ', 'BIAN57    ', '', '', '', '', '', '', '', '', '', 0),
(127, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N58', 'N58 - BIA - EGDC-2  (BFF)           ', 200, 'BAL', 110, '130', '25', 'SL ', 'BIAN58    ', '', '', '', '', '', '', '', '', '', 0),
(128, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N59', 'N59 - BASL- Avissawella Purch WH    ', 200, 'BAL', 110, '130', '20', 'SL ', 'BIAN59    ', '', '', '', '', '', '', '', '', '', 0),
(129, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N60', 'N60 - BIA - EI Centralised Purch WH ', 200, 'BAL', 110, '130', '20', 'SL ', 'BIAN60    ', '', '', '', '', '', '', '', '', '', 0),
(130, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N61', 'N61 - BASL - Mirigama Sub Con WH    ', 200, 'BAL', 110, '130', '25', 'SL ', 'BIAN61    ', '', '', '', '', '', '', '', '', '', 0),
(131, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N62', 'N62 - BASL- Welisara Sub Con WH     ', 200, 'BAL', 110, '130', '25', 'SL ', 'BIAN62    ', '', '', '', '', '', '', '', '', '', 0),
(132, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N63', 'N63 - BASL - Minuwangoda - Sub Cn WH', 200, 'BAL', 110, '130', '25', 'SL ', 'BIAN63    ', '', '', '', '', '', '', '', '', '', 0),
(133, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N64', 'N64 - BASL - Himaco Sub WH          ', 200, 'BAL', 110, '130', '25', 'SL ', 'BIAN64    ', '', '', '', '', '', '', '', '', '', 0),
(134, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N65', 'N65 - BASL - EI Sub Con WH          ', 200, 'BAL', 110, '130', '25', 'SL ', 'BIAN65    ', '', '', '', '', '', '', '', '', '', 0),
(135, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N67', 'N67 - BASL -Polonnaruwa Sub Con WH  ', 200, 'BAL', 110, '130', '25', 'SL ', 'BIAN67    ', '', '', '', '', '', '', '', '', '', 0),
(136, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N69', 'N69 - BASL - Avissawella - Sub Cn WH', 200, 'BAL', 110, '130', '25', 'SL ', 'BIAN69    ', '', '', '', '', '', '', '', '', '', 0),
(137, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N71', 'N71 - BIA - Punani WH               ', 200, 'BAL', 110, '130', '20', 'SL ', 'BIAN71    ', '', '', '', '', '', '', '', '', '', 0),
(138, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N72', 'N72 - BIA - Batticaloa WH           ', 200, 'BAL', 110, '130', '20', 'SL ', 'BIAN72    ', '', '', '', '', '', '', '', '', '', 0),
(139, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N73', 'N73 - BASL - Mirigama Purch -2 WH   ', 200, 'BAL', 110, '130', '20', 'SL ', 'BIAN73    ', '', '', '', '', '', '', '', '', '', 0),
(140, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N74', 'N74 - BASL - Welisara-2  WH         ', 200, 'BAL', 110, '130', '20', 'SL ', 'BIAN74    ', '', '', '', '', '', '', '', '', '', 0),
(141, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N75', 'Expo Global Distribution Centre (Pvt', 200, 'BAL', 110, '130', '20', 'SL ', 'BIAN75    ', '', '', '', '', '', '', '', '', '', 0),
(142, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N77', 'N77 - BASL- Avissawella Purch WH    ', 200, 'BAL', 110, '130', '20', 'SL ', 'BIAN77    ', '', '', '', '', '', '', '', '', '', 0),
(143, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N81', 'N81 - BASL -BB WH                   ', 200, 'BAL', 110, '130', '25', 'SL ', 'BIAN81    ', '', '', '', '', '', '', '', '', '', 0),
(144, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N82', 'N82 - BASL - Sub Con WH             ', 200, 'BAL', 110, '130', '25', 'SL ', 'BIAN82    ', '', '', '', '', '', '', '', '', '', 0),
(145, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N83', 'N83 - BASL - Sub Con WH             ', 200, 'BAL', 110, '130', '25', 'SL ', 'BIAN83    ', '', '', '', '', '', '', '', '', '', 0),
(146, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N84', 'N84 - BIA - Uknits -  BBSub Con WH  ', 200, 'BAL', 110, '130', '25', 'SL ', 'BIAN84    ', '', '', '', '', '', '', '', '', '', 0),
(147, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N85', 'N85 - BIA - Uknits - Sub Con WH     ', 200, 'BAL', 110, '130', '25', 'SL ', 'BIAN85    ', '', '', '', '', '', '', '', '', '', 0),
(148, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N87', 'N87 Avissawella II (SUB)            ', 200, 'BAL', 110, '130', '25', 'SL ', 'BIAN87    ', '', '', '', '', '', '', '', '', '', 0),
(149, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NL1', 'NL1 - BASL - Mirigama Liability WH  ', 200, 'BAL', 110, '130', 'LI', 'SL ', 'BIANL1    ', '', '', '', '', '', '', '', '', '', 0),
(150, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NL2', 'NL2 - BASL - Welisara Liability WH  ', 200, 'BAL', 110, '130', 'LI', 'SL ', 'BIANL2    ', '', '', '', '', '', '', '', '', '', 0),
(151, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NL3', 'NL3 - BASL- Minuwangoda Liability WH', 200, 'BAL', 110, '130', 'LI', 'SL ', 'BIANL3    ', '', '', '', '', '', '', '', '', '', 0),
(152, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NL4', 'NL4 - BIA - Himaco Liability WH     ', 200, 'BAL', 110, '130', 'LI', 'SL ', 'BIANL4    ', '', '', '', '', '', '', '', '', '', 0),
(153, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NL5', 'NL5 - BASL - Katunayake Liability WH', 200, 'BAL', 110, '130', 'LI', 'SL ', 'BIANL5    ', '', '', '', '', '', '', '', '', '', 0),
(154, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NL6', 'NL6 - BIA - Paliyagoda Liability WH ', 200, 'BAL', 110, '130', 'LI', 'SL ', 'BIANL6    ', '', '', '', '', '', '', '', '', '', 0),
(155, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NL7', 'NL7 - BIA - Polonnaruwa Liability WH', 200, 'BAL', 110, '130', 'LI', 'SL ', 'BIANL7    ', '', '', '', '', '', '', '', '', '', 0),
(156, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NL8', 'NL8 -BASL-Liability WH              ', 200, 'BAL', 110, '130', 'LI', 'SL ', 'BIANL8    ', '', '', '', '', '', '', '', '', '', 0),
(157, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NL9', 'NL9-BASL Avissawella I  Liability WH', 200, 'BAL', 110, '130', 'LI', 'SL ', 'BIANL9    ', '', '', '', '', '', '', '', '', '', 0),
(158, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NLA', 'NLA - BASL- Batticaloa LI WH        ', 200, 'BAL', 110, '130', 'LI', 'SL ', 'BIANLA    ', '', '', '', '', '', '', '', '', '', 0),
(159, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NLB', 'NLB - BASL -Meerigama II-LIABLITY WH', 200, 'BAL', 110, '130', 'LI', 'SL ', 'BIANLB    ', '', '', '', '', '', '', '', '', '', 0),
(160, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NLC', 'NLC - BASL - Welisara -2  LIB WH    ', 200, 'BAL', 110, '130', 'LI', 'SL ', 'BIANLC    ', '', '', '', '', '', '', '', '', '', 0),
(161, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NLD', 'NLD-BASL Avissawella II Liability WH', 200, 'BAL', 110, '130', 'LI', 'SL ', 'BIANLD    ', '', '', '', '', '', '', '', '', '', 0),
(162, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NS1', 'NS1 - BASL - Sample Purch WH        ', 200, 'BAL', 110, '130', '30', 'SL ', 'BIANS1    ', '', '', '', '', '', '', '', '', '', 0),
(163, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NS2', 'NS2 - BASL - Sample Purch WH        ', 200, 'BAL', 110, '130', '30', 'SL ', 'BIANS2    ', '', '', '', '', '', '', '', '', '', 0),
(164, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NS3', 'NS3 - BASL - Sample Purch WH        ', 200, 'BAL', 110, '130', '30', 'SL ', 'BIANS3    ', '', '', '', '', '', '', '', '', '', 0),
(165, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NW1', 'NW1 - BASL - Mirigama Write-off WH  ', 200, 'BAL', 110, '130', 'WO', 'SL ', 'BIANW1    ', '', '', '', '', '', '', '', '', '', 0),
(166, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NW2', 'NW2 - BASL - Welisara Write-off WH  ', 200, 'BAL', 110, '130', 'WO', 'SL ', 'BIANW2    ', '', '', '', '', '', '', '', '', '', 0),
(167, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NW3', 'NW3 - BASL- Minuwangoda Write-off WH', 200, 'BAL', 110, '130', 'WO', 'SL ', 'BIANW3    ', '', '', '', '', '', '', '', '', '', 0),
(168, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NW4', 'NW4 - BIA - Himaco Write-off WH     ', 200, 'BAL', 110, '130', 'WO', 'SL ', 'BIANW4    ', '', '', '', '', '', '', '', '', '', 0),
(169, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NW5', 'NW5 - BASL - Katunayake Write-off WH', 200, 'BAL', 110, '130', 'WO', 'SL ', 'BIANW5    ', '', '', '', '', '', '', '', '', '', 0),
(170, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NW6', 'NW6 - BIA - Paliyagoda Write-off WH ', 200, 'BAL', 110, '130', 'WO', 'SL ', 'BIANW6    ', '', '', '', '', '', '', '', '', '', 0),
(171, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NW7', 'NW7 - BIA - Polonnaruwa Write-off WH', 200, 'BAL', 110, '130', 'WO', 'SL ', 'BIANW7    ', '', '', '', '', '', '', '', '', '', 0),
(172, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NW8', 'NW8 -BASL-Write off WH              ', 200, 'BAL', 110, '130', 'WO', 'SL ', 'BIANW8    ', '', '', '', '', '', '', '', '', '', 0),
(173, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NW9', 'NW9 - BASL -Avissawella Write-off WH', 200, 'BAL', 110, '130', 'WO', 'SL ', 'BIANW9    ', '', '', '', '', '', '', '', '', '', 0),
(174, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NWA', 'NWA - BASL- Batticaloa Purch WH     ', 200, 'BAL', 110, '130', 'WO', 'SL ', 'BIANWA    ', '', '', '', '', '', '', '', '', '', 0),
(175, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NWB', 'NWB - BASL- merigama II- Purch WH   ', 200, 'BAL', 110, '130', 'WO', 'SL ', 'BIANWB    ', '', '', '', '', '', '', '', '', '', 0),
(176, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NWC', 'NWC - BASL - Welisara -2  W/H  WH   ', 200, 'BAL', 110, '130', 'WO', 'SL ', 'BIANWC    ', '', '', '', '', '', '', '', '', '', 0),
(177, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NWD', 'NWD-BASL Avissawella II Writeoff WH ', 200, 'BAL', 110, '130', 'WO', 'SL ', 'BIANWD    ', '', '', '', '', '', '', '', '', '', 0),
(178, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'P51', 'P51 - BIAI - Purch WH               ', 200, 'BAL', 110, '131', '20', 'IN ', 'BIAIP51   ', '', '', '', '', '', '', '', '', '', 0),
(179, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'P61', 'P61 - BIAI - Sub Con WH             ', 200, 'BAL', 110, '131', '25', 'IN ', 'BIAIP61   ', '', '', '', '', '', '', '', '', '', 0),
(180, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'PL1', 'PL1 - BIAI - Liability WH           ', 200, 'BAL', 110, '131', 'LI', 'IN ', 'BIAIPL1   ', '', '', '', '', '', '', '', '', '', 0),
(181, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'PS1', 'PS1 - BIAI -Sample Purch WH         ', 200, 'BAL', 110, '131', '30', 'IN ', 'BIAIPS1   ', '', '', '', '', '', '', '', '', '', 0),
(182, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'PW1', 'PW1 - BIAI-Write-off WH             ', 200, 'BAL', 110, '131', 'WO', 'IN ', 'BIAIPW1   ', '', '', '', '', '', '', '', '', '', 0),
(183, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Q51', 'Q51-Quantum India Purch WH          ', 200, 'BAL', 110, '180', '20', 'IN ', 'QCIQ51    ', '', '', '', '', '', '', '', '', '', 0),
(184, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Q61', 'Q61-Quantum India Sub Con Pur WH    ', 200, 'BAL', 110, '180', '25', 'IN ', 'QCIQ61    ', '', '', '', '', '', '', '', '', '', 0),
(185, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'QL1', 'QL1-QCI-Quantum India Liability WH  ', 200, 'BAL', 110, '180', 'LI', 'IN ', '          ', '', '', '', '', '', '', '', '', '', 0),
(186, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'QS1', 'QS1-QCI-Quantum India Sample WH     ', 200, 'BAL', 110, '180', '30', 'IN ', '          ', '', '', '', '', '', '', '', '', '', 0),
(187, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'QW1', 'QW1-QCI-Quantum India Write off WH  ', 200, 'BAL', 110, '180', 'WO', 'IN ', '          ', '', '', '', '', '', '', '', '', '', 0),
(188, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'SUR', 'SUR - Brandix Reverse logistics     ', 200, 'BAL', 110, '        ', 'SU', 'SL ', 'BRLSUR    ', '', '', '', '', '', '', '', '', '', 0),
(189, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'TEM', 'Dummy Warehouse for Security        ', 200, 'BAL', 110, '        ', 'DU', 'SL ', 'TEMP      ', '', '', '', '', '', '', '', '', '', 0),
(190, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'U51', 'U51 - Brandix Uknits - Purch WH     ', 200, 'BAL', 110, '135', '20', 'SL ', 'UKNU51    ', '', '', '', '', '', '', '', '', '', 0),
(191, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'U52', 'U52 - Brandix Uknits -  BB WH       ', 200, 'BAL', 110, '135', '25', 'SL ', 'UKNU52    ', '', '', '', '', '', '', '', '', '', 0),
(192, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'U53', 'U53 - Brandix Uknits -  Sub Con WH  ', 200, 'BAL', 110, '135', '25', 'SL ', 'UKNU53    ', '', '', '', '', '', '', '', '', '', 0),
(193, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'U54', 'U54 -BUL- Polonnaruwa Purch WH      ', 200, 'BAL', 110, '135', '20', 'SL ', 'UKNU54    ', '', '', '', '', '', '', '', '', '', 0),
(194, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'U55', 'U55 - BUL Punani WH                 ', 200, 'BAL', 110, '135', '25', 'SL ', 'UKNU55    ', '', '', '', '', '', '', '', '', '', 0),
(195, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'U56', 'U56 -BUL- Batticaloa Purch WH       ', 200, 'BAL', 110, '135', '20', 'SL ', 'UKNU56    ', '', '', '', '', '', '', '', '', '', 0),
(196, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'U64', 'U64 - BUL Polonnaruwa Sub Con WH    ', 200, 'BAL', 110, '135', '25', 'SL ', 'UKNU64    ', '', '', '', '', '', '', '', '', '', 0),
(197, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'UL1', 'UL1 - Brandix Uknits - Liability WH ', 200, 'BAL', 110, '135', 'LI', 'SL ', 'UKNUL1    ', '', '', '', '', '', '', '', '', '', 0),
(198, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'UL2', 'UL2 -BUL Polonnaruwa- Liability WH  ', 200, 'BAL', 110, '135', 'LI', 'SL ', 'UKNUL2    ', '', '', '', '', '', '', '', '', '', 0),
(199, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'UL6', 'UL6 - Brandix Uknits BT-Liability WH', 200, 'BAL', 110, '135', 'LI', 'SL ', 'UKNUL6    ', '', '', '', '', '', '', '', '', '', 0),
(200, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'US1', 'US1 - Brandix Uknits Sample Purch WH', 200, 'BAL', 110, '135', '30', 'SL ', 'UKNUS1    ', '', '', '', '', '', '', '', '', '', 0),
(201, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'UW1', 'UW1 - Brandix Uknits - Write-off WH ', 200, 'BAL', 110, '135', 'WO', 'SL ', 'UKNUW1    ', '', '', '', '', '', '', '', '', '', 0),
(202, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'UW2', 'UW2 -BUL Polonnaruwa-Write-off WH   ', 200, 'BAL', 110, '135', 'WO', 'SL ', 'UKNUW2    ', '', '', '', '', '', '', '', '', '', 0),
(203, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'UW6', 'UW6 - Brandix Uknits BT-Write-off WH', 200, 'BAL', 110, '135', 'WO', 'SL ', 'UKNUW6    ', '', '', '', '', '', '', '', '', '', 0),
(204, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '401', 'BEL- Koggala Prod.WH                ', 200, 'BAW', 140, '140', '10', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(205, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '402', 'BEL-Mathara Prod.WH                 ', 200, 'BAW', 140, '140', '10', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(206, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '403', 'BEL-Polgahawela Prod.WH             ', 200, 'BAW', 140, '140', '10', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(207, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '406', 'BEL - Subcontract WH                ', 200, 'BAW', 140, '140', '40', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(208, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '450', 'BEL-General Items.WH                ', 200, 'BAW', 140, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(209, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G00', 'BEL- Rathmalana General Item WH     ', 200, 'BAW', 140, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(210, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G02', 'BEL- Ekala Central General Item WH  ', 200, 'BAW', 140, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(211, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G11', 'BEC- Ekala Central General Item WH  ', 200, 'BAW', 140, '141', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(212, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '60', 'Brandix College of Clothing Techno  ', 200, 'BCT', 160, '        ', '10', 'SL ', 'BCCT060   ', '', '', '', '', '', '', '', '', '', 0),
(213, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '405', 'BEH-Hambanthota Prod.WH             ', 200, 'BEH', 140, '140', '10', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(214, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '50', 'Brandix Finishing Limited           ', 200, 'BFL', 150, '3323', '10', 'SL ', 'BFL050    ', '', '', '', '', '', '', '', '', '', 0),
(215, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'GI3', 'BI3- Bi3 General Item WH            ', 200, 'BI3', 400, '400', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(216, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '70', 'Brandix Textiles Ltd                ', 200, 'BTL', 170, '170', '10', 'SL ', 'BTL70     ', '', '', '', '', '', '', '', '', '', 0),
(217, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CAN', 'Essentials Central Anuradhapura     ', 200, 'CAN', 141, '141', '10', 'SL ', 'BECAN     ', '', '', '', '', '', '', '', '', '', 0),
(218, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CHA', 'Central Essentials Hambanthota      ', 200, 'CHA', 141, '        ', '10', 'SL ', 'BECHA     ', '', '', '', '', '', '', '', '', '', 0),
(219, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G12', 'BEC- Hambanthota General Item WH    ', 200, 'CHA', 141, '141', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(220, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G14', 'BEC- Hambanthota/Ekala General It WH', 200, 'CHA', 141, '141', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(221, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CKA', 'Central Essentials Kahawatte        ', 200, 'CKA', 141, '        ', '10', 'SL ', 'BECKA     ', '', '', '', '', '', '', '', '', '', 0),
(222, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G13', 'BEC- Kahawaththa General Item WH    ', 200, 'CKA', 141, '141', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(223, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G15', 'BEC- Kahawaththa/Ekala General It WH', 200, 'CKA', 141, '141', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(224, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CNV', 'Central Essentials Nivithigala      ', 200, 'CNV', 141, '        ', '10', 'SL ', 'BECNV     ', '', '', '', '', '', '', '', '', '', 0),
(225, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CRK', 'Essentials Central Rambukkana       ', 200, 'CRK', 141, '        ', '10', 'SL ', 'BECRK     ', '', '', '', '', '', '', '', '', '', 0),
(226, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G17', 'BEC- Rabukkana General Item WH      ', 200, 'CRK', 141, '141', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(227, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G18', 'BEC- Rabukkana/Ekala General Item WH', 200, 'CRK', 141, '141', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(228, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'CSS', 'Essentials Central Subcon           ', 200, 'CSS', 141, '        ', '10', 'SL ', 'BECSS     ', '', '', '', '', '', '', '', '', '', 0),
(229, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EBA', 'EBA - Essentials Batticaloa 1       ', 200, 'EBA', 140, '140', '10', 'SL ', 'BELEBA    ', '', '', '', '', '', '', '', '', '', 0),
(230, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EBC', 'EBC - Essentials Batticaloa 2       ', 200, 'EBC', 140, '140', '10', 'SL ', 'BELEBC    ', '', '', '', '', '', '', '', '', '', 0),
(231, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ECO', 'ECO - BEL COS Plant SL              ', 200, 'ECO', 140, '140', '10', 'SL ', 'BELECO    ', '', '', '', '', '', '', '', '', '', 0),
(232, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '404', 'EDC-Nivithigala Prod.WH             ', 200, 'EDC', 140, '140', '10', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(233, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '409', 'EDC - Rambukkana Prod.WH            ', 200, 'EDC', 140, '140', '10', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(234, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '410', 'EDC - Subcontract WH                ', 200, 'EDC', 140, '140', '40', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(235, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EDV', 'EDV - Essentials Devon              ', 200, 'EDV', 140, '140', '10', 'SL ', 'BELEDV    ', '', '', '', '', '', '', '', '', '', 0),
(236, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G01', 'BEL- Matara General Item WH         ', 200, 'EDV', 140, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(237, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EHA', 'EHA - Essentials Hambanthota        ', 200, 'EHA', 140, '140', '10', 'SL ', 'BELEHA    ', '', '', '', '', '', '', '', '', '', 0),
(238, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EKA', 'EKA - Essentials Kahawatte          ', 200, 'EKA', 140, '140', '10', 'SL ', 'BELEKA    ', '', '', '', '', '', '', '', '', '', 0),
(239, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EKG', 'EKG - Essentials Koggala Prod.WH    ', 200, 'EKG', 140, '140', '10', 'SL ', 'BELEKG    ', '', '', '', '', '', '', '', '', '', 0),
(240, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G03', 'BEL- Koggala/Ekala General Item WH  ', 200, 'EKG', 140, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(241, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G04', 'BEL- Koggala General Item WH        ', 200, 'EKG', 140, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(242, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ENV', 'ENV - Essentials Nivithigala        ', 200, 'ENV', 140, '140', '10', 'SL ', 'BELENV    ', '', '', '', '', '', '', '', '', '', 0),
(243, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G05', 'BEL- Nivithigala General Item WH    ', 200, 'ENV', 140, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(244, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G07', 'BEL-Nivitigala/Ekala General Item WH', 200, 'ENV', 140, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(245, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'EPG', 'EPG - Essentials Polgahawela        ', 200, 'EPG', 140, '140', '10', 'SL ', 'BELEPG    ', '', '', '', '', '', '', '', '', '', 0),
(246, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G06', 'BEL- Polgahawela General Item WH    ', 200, 'EPG', 140, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(247, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ERK', 'ERK - Essentials Rambukkana         ', 200, 'ERK', 140, '140', '10', 'SL ', 'BELERK    ', '', '', '', '', '', '', '', '', '', 0),
(248, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ESS', 'ESS - Essentials Subcon Sri Lanka   ', 200, 'ESS', 140, '140', '10', 'SL ', 'BELESS    ', '', '', '', '', '', '', '', '', '', 0),
(249, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'J01', 'J01-BCB Production/H&M Purchasing WH', 200, 'J01', 125, '125', '70', 'BD ', 'BCWJ01    ', '', '', '', '', '', '', '', '', '', 0),
(250, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'JLB', 'JLB-BCB H&M Liability WH            ', 200, 'J01', 125, '125', 'LI', 'BD ', 'BCWJLB    ', '', '', '', '', '', '', '', '', '', 0),
(251, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'JSB', 'JSB-BCB H&M Sample Purchasing WH    ', 200, 'J01', 125, '125', '30', 'BD ', 'BCWJSB    ', '', '', '', '', '', '', '', '', '', 0),
(252, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'JWB', 'JWB-BCB H&M Write-off WH            ', 200, 'J01', 125, '125', 'WO', 'BD ', 'BCWJWB    ', '', '', '', '', '', '', '', '', '', 0),
(253, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'J11', 'J11 -BCB Washing RM WH              ', 200, 'J11', 125, '125', '50', 'BD ', 'BCWJ11    ', '', '', '', '', '', '', '', '', '', 0),
(254, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'J21', 'J21-BCB -Subcon Prod/H&M Purch WH   ', 200, 'J21', 125, '125', '10', 'BD ', 'BCWJ21    ', '', '', '', '', '', '', '', '', '', 0),
(255, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K01', 'K01 - BCW - Rathmalana - Prod WH    ', 200, 'K01', 120, '120', '10', 'SL ', 'BCWK01    ', '', '', '', '', '', '', '', '', '', 0),
(256, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K02', 'K02 - BCW - Rideegama - Prod WH     ', 200, 'K02', 120, '120', '10', 'SL ', 'BCWK02    ', '', '', '', '', '', '', '', '', '', 0),
(257, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K03', 'K03 - BCW - Avissawella Prod WH     ', 200, 'K03', 120, '120', '10', 'SL ', 'BCWK03    ', '', '', '', '', '', '', '', '', '', 0),
(258, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K04', 'K04 - Favourite Hanwella Prod WH    ', 200, 'K04', 120, '120', '10', 'SL ', 'BCWK04    ', '', '', '', '', '', '', '', '', '', 0),
(259, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K05', 'K05 - BCW - Girithale - Prod WH     ', 200, 'K05', 120, '120', '10', 'SL ', 'BCWK05    ', '', '', '', '', '', '', '', '', '', 0),
(260, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K06', 'K06 - BCW - Seeduwa - Prod WH       ', 200, 'K06', 120, '120', '10', 'SL ', 'BCWK06    ', '', '', '', '', '', '', '', '', '', 0),
(261, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K21', 'K21 - BCW -Subcon Rathmalana Prod WH', 200, 'K21', 120, '120', '10', 'SL ', 'BCWK21    ', '', '', '', '', '', '', '', '', '', 0),
(262, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'K23', 'K23 - BCW-Subcon Avissawella Prod WH', 200, 'K23', 120, '120', '10', 'SL ', 'BCWK23    ', '', '', '', '', '', '', '', '', '', 0),
(263, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'L01', 'L01-BLI-Wathupitiwala Prod WH       ', 200, 'L01', 146, '146', '10', 'SL ', 'BLIL01    ', '', '', '', '', '', '', '', '', '', 0),
(264, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'L11', 'L11-BLI-Wathupitiwala Sub Con Prd WH', 200, 'L11', 146, '146', '40', 'SL ', 'BLIL01    ', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `warehouse` (`wh_id`, `created_at`, `updated_at`, `wh_code`, `wh_name`, `company`, `factory`, `division`, `communication_address`, `wh_type`, `country`, `object_access_group`, `mdm_host`, `mdm_username`, `mdm_password`, `mdm_db`, `mdm_port`, `sfcs_host`, `sfcs_username`, `sfcs_password`, `sfcs_db`, `sfcs_port`) VALUES
(265, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'L21', 'L21 ? BLI- Quantum Sub Con Prod WH  ', 200, 'L21', 146, '146', '40', 'IN ', 'BLIL21    ', '', '', '', '', '', '', '', '', '', 0),
(266, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G31', 'BIA- Meerigama General Item WH      ', 200, 'N01', 130, '130', '50', 'SL ', 'BIAG31    ', '', '', '', '', '', '', '', '', '', 0),
(267, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N01', 'N01 - BASL - Mirigama Prod WH       ', 200, 'N01', 130, '130', '10', 'SL ', 'BIAN01    ', '', '', '', '', '', '', '', '', '', 0),
(268, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G32', 'BIA- Welisara General Item WH       ', 200, 'N02', 130, '130', '50', 'SL ', 'BIAG32    ', '', '', '', '', '', '', '', '', '', 0),
(269, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N02', 'N02 - BASL - Welisara Prod WH       ', 200, 'N02', 130, '130', '10', 'SL ', 'BIAN02    ', '', '', '', '', '', '', '', '', '', 0),
(270, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G33', 'BIA- Minuwangoda General Item WH    ', 200, 'N03', 130, '130', '50', 'SL ', 'BIAG33    ', '', '', '', '', '', '', '', '', '', 0),
(271, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N03', 'N03 - BASL - Minuwangoda Prod WH    ', 200, 'N03', 130, '130', '10', 'SL ', 'BIAN03    ', '', '', '', '', '', '', '', '', '', 0),
(272, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N04', 'N04 - BIA - Himaco Prod WH          ', 200, 'N04', 130, '130', '10', 'SL ', 'BIAN04    ', '', '', '', '', '', '', '', '', '', 0),
(273, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G35', 'BIA- Katunayaka General Item WH     ', 200, 'N05', 130, '130', '50', 'SL ', 'BIAG35    ', '', '', '', '', '', '', '', '', '', 0),
(274, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N05', 'N05 - BASL- Katunayake Prod WH      ', 200, 'N05', 130, '130', '10', 'SL ', 'BIAN05    ', '', '', '', '', '', '', '', '', '', 0),
(275, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N06', 'N06 - BASL- Anuradhapura Prod WH    ', 200, 'N06', 130, '130', '10', 'SL ', 'BIAN06    ', '', '', '', '', '', '', '', '', '', 0),
(276, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N07', 'N07 - BASL - Polonnaruwa Prod WH    ', 200, 'N07', 130, '130', '10', 'SL ', 'BIAN07    ', '', '', '', '', '', '', '', '', '', 0),
(277, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N08', 'N08 - BIA - Girithale Prod WH       ', 200, 'N08', 130, '130', '10', 'SL ', 'BIAN08    ', '', '', '', '', '', '', '', '', '', 0),
(278, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G39', 'BIA- Awissawella General Item WH    ', 200, 'N09', 130, '130', '50', 'SL ', 'BIAG39    ', '', '', '', '', '', '', '', '', '', 0),
(279, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N09', 'N09 - BASL - Avissawella I Prod WH  ', 200, 'N09', 130, '130', '10', 'SL ', 'BIAN09    ', '', '', '', '', '', '', '', '', '', 0),
(280, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N11', 'N11 -BASL - Meerigama Sub Con Prd WH', 200, 'N11', 130, '130', '40', 'SL ', 'BIAN11    ', '', '', '', '', '', '', '', '', '', 0),
(281, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N12', 'N12 - BIA - Welisara Sub Con Prod WH', 200, 'N12', 130, '130', '40', 'SL ', 'BIAN12    ', '', '', '', '', '', '', '', '', '', 0),
(282, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N13', 'N13 -BASL-Minuwangoda Sub Con Prd WH', 200, 'N13', 130, '130', '40', 'SL ', 'BIAN13    ', '', '', '', '', '', '', '', '', '', 0),
(283, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N14', 'N14 - BASL- Himaco Sub Con Prod WH  ', 200, 'N14', 130, '130', '40', 'SL ', 'BIAN14    ', '', '', '', '', '', '', '', '', '', 0),
(284, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N15', 'N15 - BASL - EI Sub Con Prod WH     ', 200, 'N15', 130, '130', '40', 'SL ', 'BIAN15    ', '', '', '', '', '', '', '', '', '', 0),
(285, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N17', 'N17 - BASL -Polonnaruwa Sub Con     ', 200, 'N17', 130, '130', '40', 'SL ', 'BIAN17    ', '', '', '', '', '', '', '', '', '', 0),
(286, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N19', 'N19 -BASL-Avissawella Sub Con Prd WH', 200, 'N19', 130, '130', '40', 'SL ', 'BIAN19    ', '', '', '', '', '', '', '', '', '', 0),
(287, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N21', 'N21 - BIA - Punani Prod WH          ', 200, 'N21', 130, '130', '10', 'SL ', 'BIAN21    ', '', '', '', '', '', '', '', '', '', 0),
(288, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N22', 'N22 - BIA -Batticaloa Prod WH       ', 200, 'N22', 130, '130', '10', 'SL ', 'BIAN22    ', '', '', '', '', '', '', '', '', '', 0),
(289, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N23', 'N23 - BASL - Mirigama II Prod WH    ', 200, 'N23', 130, '130', '10', 'SL ', 'BIAN23    ', '', '', '', '', '', '', '', '', '', 0),
(290, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N27', 'N27 - BASL - Avissavella II -Prod WH', 200, 'N27', 130, '130', '10', 'SL ', 'BIAN27    ', '', '', '', '', '', '', '', '', '', 0),
(291, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N31', 'N31 - BASL - BB Prod WH             ', 200, 'N31', 130, '130', '40', 'SL ', 'BIAN31    ', '', '', '', '', '', '', '', '', '', 0),
(292, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N32', 'N32 -BASL - Sub Con Prod WH         ', 200, 'N32', 130, '130', '40', 'SL ', 'BIAN32    ', '', '', '', '', '', '', '', '', '', 0),
(293, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N33', 'N33-BASL-Polonnaruwa WH-2           ', 200, 'N33', 130, '130', '40', 'SL ', 'BIAN33    ', '', '', '', '', '', '', '', '', '', 0),
(294, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N34', 'N34 - BASL - (BB SUB)               ', 200, 'N34', 130, '130', '40', 'SL ', 'BIAN34    ', '', '', '', '', '', '', '', '', '', 0),
(295, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N35', 'N35 - BASL -(SUB)                   ', 200, 'N35', 130, '130', '40', 'SL ', 'BIAN35    ', '', '', '', '', '', '', '', '', '', 0),
(296, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'N37', 'N37 - BASL - Avissavlla (SUB)       ', 200, 'N37', 130, '130', '40', 'SL ', 'BIAN37    ', '', '', '', '', '', '', '', '', '', 0),
(297, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '30', 'Ocean India (Pvt) Ltd.              ', 200, 'OCI', 530, '530', '10', 'IN ', '          ', '', '', '', '', '', '', '', '', '', 0),
(298, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'P01', 'P01- BIAI -India Prod WH            ', 200, 'P01', 131, '131', '10', 'IN ', 'BIAIP01   ', '', '', '', '', '', '', '', '', '', 0),
(299, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'P11', 'P11-BIAI - India Sub Con Prod       ', 200, 'P11', 131, '131', '40', 'IN ', 'BIAIP11   ', '', '', '', '', '', '', '', '', '', 0),
(300, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'P90', 'P90 - BIAI General Item WH          ', 200, 'P90', 131, '131', '50', 'IN ', 'BIAIP90   ', '', '', '', '', '', '', '', '', '', 0),
(301, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Q01', 'Q01-Quantum India Prod WH           ', 200, 'Q01', 180, '180', '10', 'IN ', 'QCIQ01    ', '', '', '', '', '', '', '', '', '', 0),
(302, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Q11', 'Q11-Quantum India Sub Con Prd WH    ', 200, 'Q11', 180, '180', '40', 'IN ', '          ', '', '', '', '', '', '', '', '', '', 0),
(303, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Q90', 'Q90-Quantum India General Itm WH    ', 200, 'Q90', 180, '180', '50', 'IN ', 'QCIQ90    ', '', '', '', '', '', '', '', '', '', 0),
(304, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G21', 'BUL- UKNITS General Item WH         ', 200, 'U01', 135, '131', '50', 'SL ', 'BULG21    ', '', '', '', '', '', '', '', '', '', 0),
(305, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'U01', 'U01 - Brandix Uknits Prod WH        ', 200, 'U01', 135, '135', '10', 'SL ', 'UKNU01    ', '', '', '', '', '', '', '', '', '', 0),
(306, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'U02', 'U02 - Brandix Uknits BB Prod WH     ', 200, 'U02', 135, '135', '10', 'SL ', 'UKNU02    ', '', '', '', '', '', '', '', '', '', 0),
(307, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'U03', 'U03 - Brandix Uknits Sub Con Prod WH', 200, 'U03', 135, '135', '40', 'SL ', 'UKNU03    ', '', '', '', '', '', '', '', '', '', 0),
(308, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G24', 'BUL- Polonnaaruwa General Item WH   ', 200, 'U04', 135, '131', '50', 'SL ', 'BULG24    ', '', '', '', '', '', '', '', '', '', 0),
(309, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'G25', 'BUL-Polonnaruwa/Ratmalan GI WH      ', 200, 'U04', 135, '131', '50', 'SL ', 'BULG24    ', '', '', '', '', '', '', '', '', '', 0),
(310, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'U04', 'U04 - BUL Polonnaruwa Prod WH       ', 200, 'U04', 135, '135', '10', 'SL ', 'UKNU04    ', '', '', '', '', '', '', '', '', '', 0),
(311, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'U05', 'U05 - BUL Punani Prod WH            ', 200, 'U05', 135, '135', '10', 'SL ', 'UKNU05    ', '', '', '', '', '', '', '', '', '', 0),
(312, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'U06', 'U06-BUL Batticaloa Prod WH          ', 200, 'U06', 135, '135', '10', 'SL ', 'UKNU06    ', '', '', '', '', '', '', '', '', '', 0),
(313, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'U14', 'U14 -BUL Polonnaruwa Sub Con Prod WH', 200, 'U14', 135, '135', '40', 'SL ', 'UKNU14    ', '', '', '', '', '', '', '', '', '', 0),
(314, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z00', 'Z00-BASL BAL GItem WH               ', 200, 'X00', 120, '110', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(315, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W01', 'W01-BIA-OEM-Uknits GI WH            ', 200, 'X01', 120, '130', '50', 'SL ', 'BIAW01    ', '', '', '', '', '', '', '', '', '', 0),
(316, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z01', 'Z01-BASL FF-Mirigama II GItem WH    ', 200, 'X01', 120, '130', '50', 'SL ', 'BIAZ01    ', '', '', '', '', '', '', '', '', '', 0),
(317, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W02', 'W02-BIA-OEM-Polonnaruwa GI WH       ', 200, 'X02', 120, '130', '50', 'SL ', 'BIAW02    ', '', '', '', '', '', '', '', '', '', 0),
(318, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z02', 'Z02-BASL AL-Polonnaruwa GItem WH    ', 200, 'X02', 120, '130', '50', 'SL ', 'BIAZ02    ', '', '', '', '', '', '', '', '', '', 0),
(319, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z19', 'Z19-BASL AL-Polonnaruwa GItem WH    ', 200, 'X02', 120, '130', '50', 'SL ', 'BIAZ19    ', '', '', '', '', '', '', '', '', '', 0),
(320, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W03', 'W03-BIA-OEM-Welisara GI WH          ', 200, 'X03', 120, '130', '50', 'SL ', 'BIAW03    ', '', '', '', '', '', '', '', '', '', 0),
(321, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z03', 'Z03-BASL FF-Welisara General Item WH', 200, 'X03', 120, '130', '50', 'SL ', 'BIAZ03    ', '', '', '', '', '', '', '', '', '', 0),
(322, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z16', 'Z16-BASL FF-Front End GItem WH      ', 200, 'X03', 120, '130', '50', 'SL ', 'BIAZ16    ', '', '', '', '', '', '', '', '', '', 0),
(323, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z17', 'Z17-BASL FF-Central GItem WH        ', 200, 'X03', 120, '130', '50', 'SL ', 'BIAZ17    ', '', '', '', '', '', '', '', '', '', 0),
(324, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z18', 'Z18-BASL FF-Sample GItem WH         ', 200, 'X03', 120, '130', '50', 'SL ', 'BIAZ18    ', '', '', '', '', '', '', '', '', '', 0),
(325, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z21', 'Z21-BIA-Welisara-BCIP Lean Gen It WH', 200, 'X03', 120, '130', '50', 'SL ', 'BIAZ21    ', '', '', '', '', '', '', '', '', '', 0),
(326, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W04', 'W04-BIA-OEM-Minuwangoda GIWH        ', 200, 'X04', 120, '130', '50', 'SL ', 'BIAW04    ', '', '', '', '', '', '', '', '', '', 0),
(327, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z04', 'Z04-BASL FF-Minuwangoda GItem WH    ', 200, 'X04', 120, '130', '50', 'SL ', 'BIAZ04    ', '', '', '', '', '', '', '', '', '', 0),
(328, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W05', 'W05-BIA-OEM-Katunayaka GI WH        ', 200, 'X05', 120, '130', '50', 'SL ', 'BIAW05    ', '', '', '', '', '', '', '', '', '', 0),
(329, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z05', 'Z05-BASL AL-Katunayake GItem WH     ', 200, 'X05', 120, '130', '50', 'SL ', 'BIAZ05    ', '', '', '', '', '', '', '', '', '', 0),
(330, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W06', 'W06-BIA-OEM-Mirigama GI WH          ', 200, 'X06', 120, '130', '50', 'SL ', 'BIAW06    ', '', '', '', '', '', '', '', '', '', 0),
(331, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z06', 'Z06-BASL FF-Mirigama General Item WH', 200, 'X06', 120, '130', '50', 'SL ', 'BIAZ06    ', '', '', '', '', '', '', '', '', '', 0),
(332, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W07', 'W07-BIA-OEM-Avissawella GI WH       ', 200, 'X07', 120, '130', '50', 'SL ', 'BIAW07    ', '', '', '', '', '', '', '', '', '', 0),
(333, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z07', 'Z07-BASL FF-Avissavella I GItem WH  ', 200, 'X07', 120, '130', '50', 'SL ', 'BIAZ07    ', '', '', '', '', '', '', '', '', '', 0),
(334, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W08', 'W08-BIA-OEM-Batticaloa GI WH        ', 200, 'X08', 120, '130', '50', 'SL ', 'BIAW08    ', '', '', '', '', '', '', '', '', '', 0),
(335, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z08', 'Z08-BASL AL-Batticaloa GItem WH     ', 200, 'X08', 120, '130', '50', 'SL ', 'BIAZ08    ', '', '', '', '', '', '', '', '', '', 0),
(336, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z20', 'Z20-BASL AL-Batticaloa GItem WH     ', 200, 'X08', 120, '130', '50', 'SL ', 'BIAZ20    ', '', '', '', '', '', '', '', '', '', 0),
(337, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W09', 'W09-BIA-OEM-Awissawella II GI WH    ', 200, 'X09', 120, '130', '50', 'SL ', 'BIAW09    ', '', '', '', '', '', '', '', '', '', 0),
(338, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z09', 'Z09-BASL FF-Avissavella II GItem WH ', 200, 'X09', 120, '130', '50', 'SL ', 'BIAZ09    ', '', '', '', '', '', '', '', '', '', 0),
(339, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z10', 'Z10-BASL Welisara-Centre GItem WH   ', 200, 'X10', 120, '130', '50', 'SL ', 'BIAZ10    ', '', '', '', '', '', '', '', '', '', 0),
(340, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z11', 'Z11-BASL Central-Central GItem WH   ', 200, 'X11', 120, '130', '50', 'SL ', 'BIAZ11    ', '', '', '', '', '', '', '', '', '', 0),
(341, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z12', 'Z12-BASL AL-Front End GItem WH      ', 200, 'X12', 120, '130', '50', 'SL ', 'BIAZ12    ', '', '', '', '', '', '', '', '', '', 0),
(342, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z13', 'Z13-BASL AL-Sample GItem WH         ', 200, 'X13', 120, '130', '50', 'SL ', 'BIAZ13    ', '', '', '', '', '', '', '', '', '', 0),
(343, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z14', 'Z14-BASL AL-Central GItem WH        ', 200, 'X14', 120, '130', '50', 'SL ', 'BIAZ14    ', '', '', '', '', '', '', '', '', '', 0),
(344, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z22', 'Z22-BASL DC-Front End GItem WH      ', 200, 'X22', 120, '130', '50', 'SL ', 'BIAZ22    ', '', '', '', '', '', '', '', '', '', 0),
(345, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z23', 'Z23-BASL DC-Central GItem WH        ', 200, 'X23', 120, '130', '50', 'SL ', 'BIAZ23    ', '', '', '', '', '', '', '', '', '', 0),
(346, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z24', 'Z24-BASL DC-Sample GItem WH         ', 200, 'X24', 120, '130', '50', 'SL ', 'BIAZ24    ', '', '', '', '', '', '', '', '', '', 0),
(347, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W26', 'W26-BEL-OEM-Ratmalana GI WH         ', 200, 'X26', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(348, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z26', 'Z26-BEL-Ratmalana General Item WH   ', 200, 'X26', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(349, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W27', 'W27-BEL-OEM-Ekala Central GI WH     ', 200, 'X27', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(350, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z27', 'Z27-BEL-Ekala Central Gen Item WH   ', 200, 'X27', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(351, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W28', 'W28-BEL-OEM-Koggala GI WH           ', 200, 'X28', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(352, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z28', 'Z28-BEL-Koggala General Item WH     ', 200, 'X28', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(353, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z41', 'Z41-BEL-Koggala/ Seeduwa GI WH      ', 200, 'X28', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(354, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W29', 'W29-BEL-OEM-Mathara GI WH           ', 200, 'X29', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(355, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z29', 'Z29-BEL-Mathara General Items WH    ', 200, 'X29', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(356, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W30', 'W30-BEL-OEM-Nivithigala GI WH       ', 200, 'X30', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(357, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z30', 'Z30-BEL-Nivithigala General Items WH', 200, 'X30', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(358, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z42', 'Z42-BEL-Nivithigala/Ekala GI WH     ', 200, 'X30', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(359, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W31', 'W31-BEL-OEM-Polgahawela GI WH       ', 200, 'X31', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(360, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z31', 'Z31-BEL-Polgahawela General Items WH', 200, 'X31', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(361, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W32', 'W32-BEL-OEM-Kahawaththa GI WH       ', 200, 'X32', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(362, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z32', 'Z32-BEL-Kahawaththa General Items WH', 200, 'X32', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(363, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z43', 'Z43-BEL-Kahawaththa/Ekala GI WH     ', 200, 'X32', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(364, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W33', 'W33-BEL-OEM-Hambanthota GI WH       ', 200, 'X33', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(365, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z33', 'Z33-BEL-Hambanthota General Items WH', 200, 'X33', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(366, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z44', 'Z44-BEL-Hambanthota/Ekala GI WH     ', 200, 'X33', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(367, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W34', 'W34-BEL-OEM-Rabukkana GI WH         ', 200, 'X34', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(368, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z34', 'Z34-BEL-Rabukkana General Items WH  ', 200, 'X34', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(369, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z45', 'Z45-BEL-Rabukkana/ Seeduwa GI WH    ', 200, 'X34', 120, '140', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(370, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z35', 'Z35-BEL-Batticaloa1 General Items WH', 200, 'X35', 120, '140', '50', 'SL ', 'BELZ35    ', '', '', '', '', '', '', '', '', '', 0),
(371, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z36', 'Z36-BEL-Batticaloa2 General Items WH', 200, 'X36', 120, '140', '50', 'SL ', 'BELZ36    ', '', '', '', '', '', '', '', '', '', 0),
(372, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W51', 'W51-BCW-OEM-Rathmalana GI WH        ', 200, 'X51', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(373, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z51', 'Z51-BCW-Rathmalana General Item WH  ', 200, 'X51', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(374, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z66', 'Z66-BCW-Rathmalana/Ekala Gen Item WH', 200, 'X51', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(375, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W52', 'W52-BCW-OEM-Seethawaka GI WH        ', 200, 'X52', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(376, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z52', 'Z52-BCW-Seethawaka General Item WH  ', 200, 'X52', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(377, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z67', 'Z67-BCW-Seethawaka/Seeduwa GI WH    ', 200, 'X52', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(378, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W53', 'W53-BCW-OEM-Girithale GIWH          ', 200, 'X53', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(379, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z53', 'Z53-BCW-Girithale General Item WH   ', 200, 'X53', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(380, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z68', 'Z68-BCW-Girithale/Ekala Gen Item WH ', 200, 'X53', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(381, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z54', 'Z54-BCW-Katunayaka General Item WH  ', 200, 'X54', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(382, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z69', 'Z69-BCW-Katunayaka/Ekala Gen Item WH', 200, 'X54', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(383, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W55', 'W55-BCW-OEM-Ekala GI WH             ', 200, 'X55', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(384, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z55', 'Z55-BCW-Ekala General Item WH       ', 200, 'X55', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(385, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z56', 'Z56-BCW-JaEla General Item WH       ', 200, 'X56', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(386, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z70', 'Z70-BCW-JaEla/Ekala Gen Item WH     ', 200, 'X56', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(387, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W57', 'W57-BCW-OEM-Rideegama GI WH         ', 200, 'X57', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(388, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z57', 'Z57-BCW-Rideegama General Item WH   ', 200, 'X57', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(389, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z71', 'Z71-BCW-Rideegama/Rathmalana GI WH  ', 200, 'X57', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(390, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W58', 'W58-BCW-OEM-Hanwella GI WH          ', 200, 'X58', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(391, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z58', 'Z58-BCW-Hanwella General Item WH    ', 200, 'X58', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(392, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z72', 'Z72-BCW-Hanwella/ Seeduwa GI WH     ', 200, 'X58', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(393, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W59', 'W59-BCW-OEM-Seeduwa GI WH           ', 200, 'X59', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(394, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z59', 'Z59-BCW-Seeduwa General Item WH     ', 200, 'X59', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(395, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W60', 'W60-BCW-BFL-OEM-Ratmalana GI WH     ', 200, 'X60', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(396, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z60', 'Z60-BCW-BFL-Ratmalana General Itm WH', 200, 'X60', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(397, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W61', 'W61-BCW-OEM-BFS Avissawella GI WH   ', 200, 'X61', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(398, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z61', 'Z61-BCW-BFS Avissawella Gen Itm WH  ', 200, 'X61', 120, '120', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(399, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z62', 'Z62-BFL-Ratmalana General Itm WH    ', 200, 'X62', 150, '150', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(400, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W76', 'W76-BLI-OEM-Wathupitiwala1 GI WH    ', 200, 'X76', 120, '146', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(401, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z76', 'Z76-BLI-Wathupitiwala1 Gen Item WH  ', 200, 'X76', 120, '146', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(402, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W77', 'W77-BLI-OEM-Biyagama GI WH          ', 200, 'X77', 120, '146', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(403, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z77', 'Z77-BLI-Biyagama General Item WH    ', 200, 'X77', 120, '146', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(404, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W78', 'W78-BLI-OEM-Wathupitiwala2 GI WH    ', 200, 'X78', 120, '146', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(405, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z78', 'Z78-BLI-Wathupitiwala2 Gen Item WH  ', 200, 'X78', 120, '146', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(406, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W79', 'W79-BLI-OEM-Wathupitiwala3 GI WH    ', 200, 'X79', 120, '146', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(407, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z79', 'Z79-BLI-Wathupitiwala3 Gen Item WH  ', 200, 'X79', 120, '146', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(408, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z80', 'Z80-BLI-Wathupitiwala Suprt Gen I WH', 200, 'X80', 120, '146', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0),
(409, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X01', 'X01-BIA-OEM-Uknits GI WH            ', 200, 'X91', 120, '121', '50', 'SL ', 'BIAX01    ', '', '', '', '', '', '', '', '', '', 0),
(410, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X02', 'X02-BIA-OEM-Polonnaruwa GI WH       ', 200, 'X91', 120, '121', '50', 'SL ', 'BIAX02    ', '', '', '', '', '', '', '', '', '', 0),
(411, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X03', 'X03-BIA-OEM-Welisara GI WH          ', 200, 'X91', 120, '121', '50', 'SL ', 'BIAX03    ', '', '', '', '', '', '', '', '', '', 0),
(412, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X04', 'X04-BIA-OEM-Minuwangoda GIWH        ', 200, 'X91', 120, '121', '50', 'SL ', 'BIAX04    ', '', '', '', '', '', '', '', '', '', 0),
(413, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X05', 'X05-BIA-OEM-Katunayaka GI WH        ', 200, 'X91', 120, '121', '50', 'SL ', 'BIAX05    ', '', '', '', '', '', '', '', '', '', 0),
(414, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X06', 'X06-BIA-OEM-Mirigama GI WH          ', 200, 'X91', 120, '121', '50', 'SL ', 'BIAX06    ', '', '', '', '', '', '', '', '', '', 0),
(415, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X07', 'X07-BIA-OEM-Avissawella GI WH       ', 200, 'X91', 120, '121', '50', 'SL ', 'BIAX07    ', '', '', '', '', '', '', '', '', '', 0),
(416, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X08', 'X08-BIA-OEM-Batticaloa GI WH        ', 200, 'X91', 120, '121', '50', 'SL ', 'BIAX08    ', '', '', '', '', '', '', '', '', '', 0),
(417, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X09', 'X09-BIA-OEM-Avissawella II GI WH    ', 200, 'X91', 120, '121', '50', 'SL ', 'BIAX09    ', '', '', '', '', '', '', '', '', '', 0),
(418, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X26', 'X26-BEL-OEM-Ratmalana GI WH         ', 200, 'X91', 120, '121', '50', 'SL ', 'BELX26    ', '', '', '', '', '', '', '', '', '', 0),
(419, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X27', 'X27-BEL-OEM-Ekala Central GI WH     ', 200, 'X91', 120, '121', '50', 'SL ', 'BELZ27    ', '', '', '', '', '', '', '', '', '', 0),
(420, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X28', 'X28-BEL-OEM-Koggala GI WH           ', 200, 'X91', 120, '121', '50', 'SL ', 'BELX28    ', '', '', '', '', '', '', '', '', '', 0),
(421, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X29', 'X29-BEL-OEM-Mathara GI WH           ', 200, 'X91', 120, '121', '50', 'SL ', 'BELZ29    ', '', '', '', '', '', '', '', '', '', 0),
(422, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X30', 'X30-BEL-OEM-Nivithigala GI WH       ', 200, 'X91', 120, '121', '50', 'SL ', 'BELX30    ', '', '', '', '', '', '', '', '', '', 0),
(423, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X31', 'X31-BEL-OEM-Polgahawela GI WH       ', 200, 'X91', 120, '121', '50', 'SL ', 'BELZ31    ', '', '', '', '', '', '', '', '', '', 0),
(424, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X32', 'X32-BEL-OEM-Kahawaththa GI WH       ', 200, 'X91', 120, '121', '50', 'SL ', 'BELX32    ', '', '', '', '', '', '', '', '', '', 0),
(425, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X33', 'X33-BEL-OEM-Hambanthota GI WH       ', 200, 'X91', 120, '121', '50', 'SL ', 'BELZ33    ', '', '', '', '', '', '', '', '', '', 0),
(426, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X34', 'X34-BEL-OEM-Rambukkana GI WH        ', 200, 'X91', 120, '121', '50', 'SL ', 'BELX34    ', '', '', '', '', '', '', '', '', '', 0),
(427, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X51', 'X51-BCW-OEM-Rathmalana GI WH        ', 200, 'X91', 120, '121', '50', 'SL ', 'BCWX51    ', '', '', '', '', '', '', '', '', '', 0),
(428, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X52', 'X52-BCW-OEM-Seethawaka GI WH        ', 200, 'X91', 120, '121', '50', 'SL ', 'BCWZ52    ', '', '', '', '', '', '', '', '', '', 0),
(429, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X53', 'X53-BCW-OEM-Girithale GIWH          ', 200, 'X91', 120, '121', '50', 'SL ', 'BCWX53    ', '', '', '', '', '', '', '', '', '', 0),
(430, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X55', 'X55-BCW-OEM-Ekala GI WH             ', 200, 'X91', 120, '121', '50', 'SL ', 'BCWX55    ', '', '', '', '', '', '', '', '', '', 0),
(431, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X57', 'X57-BCW-OEM-Rideegama GI WH         ', 200, 'X91', 120, '121', '50', 'SL ', 'BCWX57    ', '', '', '', '', '', '', '', '', '', 0),
(432, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X58', 'X58-BCW-OEM-Hanwella GI WH          ', 200, 'X91', 120, '121', '50', 'SL ', 'BCWZ58    ', '', '', '', '', '', '', '', '', '', 0),
(433, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X59', 'X59-BCW-OEM-Seeduwa GI WH           ', 200, 'X91', 120, '121', '50', 'SL ', 'BCWX59    ', '', '', '', '', '', '', '', '', '', 0),
(434, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X60', 'X60-BCW-BFL-OEM-Ratmalana GI WH     ', 200, 'X91', 120, '121', '50', 'SL ', 'BCWZ60    ', '', '', '', '', '', '', '', '', '', 0),
(435, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X61', 'X61-BCW-OEM-BFS Avissawella GI WH   ', 200, 'X91', 120, '121', '50', 'SL ', 'BCWZ61    ', '', '', '', '', '', '', '', '', '', 0),
(436, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X76', 'X76-BLI-OEM-Wathupitiwala1 GI WH    ', 200, 'X91', 120, '121', '50', 'SL ', 'BLIX76    ', '', '', '', '', '', '', '', '', '', 0),
(437, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X77', 'X77-BLI-OEM-Biyagama GI WH          ', 200, 'X91', 120, '121', '50', 'SL ', 'BLIX77    ', '', '', '', '', '', '', '', '', '', 0),
(438, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X79', 'X76-BLI-OEM-Wathupitiwala3 GI WH    ', 200, 'X91', 120, '121', '50', 'SL ', 'BLIX79    ', '', '', '', '', '', '', '', '', '', 0),
(439, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'X80', 'X80-CMY-OEM-Katunayake GI WH        ', 200, 'X91', 120, '121', '50', 'SL ', 'CMYX80    ', '', '', '', '', '', '', '', '', '', 0),
(440, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z91', 'Z91-Expo Global Distribution Centre ', 200, 'X91', 120, '121', '50', 'SL ', 'CMYZ91    ', '', '', '', '', '', '', '', '', '', 0),
(441, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Z92', 'Z92-CMY-CENTRAL MACHINE YARD GI WH  ', 200, 'X91', 120, '121', '50', 'SL ', '          ', '', '', '', '', '', '', '', '', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approval_status_log`
--
ALTER TABLE `approval_status_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `do`
--
ALTER TABLE `do`
  ADD PRIMARY KEY (`do_id`);

--
-- Indexes for table `do_items`
--
ALTER TABLE `do_items`
  ADD PRIMARY KEY (`do_items_id`);

--
-- Indexes for table `do_items_approval`
--
ALTER TABLE `do_items_approval`
  ADD PRIMARY KEY (`do_itm_app_id`);

--
-- Indexes for table `do_types`
--
ALTER TABLE `do_types`
  ADD PRIMARY KEY (`do_type`);

--
-- Indexes for table `service_log`
--
ALTER TABLE `service_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_reason`
--
ALTER TABLE `transaction_reason`
  ADD PRIMARY KEY (`transaction_reason_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_do_map`
--
ALTER TABLE `user_do_map`
  ADD PRIMARY KEY (`user_do_map_id`),
  ADD KEY `do_items_id` (`do_items_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_tran_res_map`
--
ALTER TABLE `user_tran_res_map`
  ADD PRIMARY KEY (`user_tran_res_map_id`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`wh_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approval_status_log`
--
ALTER TABLE `approval_status_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `do`
--
ALTER TABLE `do`
  MODIFY `do_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `do_items`
--
ALTER TABLE `do_items`
  MODIFY `do_items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `do_items_approval`
--
ALTER TABLE `do_items_approval`
  MODIFY `do_itm_app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `service_log`
--
ALTER TABLE `service_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_do_map`
--
ALTER TABLE `user_do_map`
  MODIFY `user_do_map_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_tran_res_map`
--
ALTER TABLE `user_tran_res_map`
  MODIFY `user_tran_res_map_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouse`
--
ALTER TABLE `warehouse`
  MODIFY `wh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=442;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
