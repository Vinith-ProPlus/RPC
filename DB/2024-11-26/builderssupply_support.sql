-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 26, 2024 at 02:29 PM
-- Server version: 8.0.37
-- PHP Version: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `builderssupply_support`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attachment`
--

CREATE TABLE `tbl_attachment` (
  `AttachmentID` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `ReferID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Module` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `UploadDir` mediumtext COLLATE utf8mb4_general_ci,
  `UploadFileName` mediumtext COLLATE utf8mb4_general_ci,
  `UploadFileExt` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `UploadUrl` mediumtext COLLATE utf8mb4_general_ci,
  `FileSize` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `DFlag` int DEFAULT '0',
  `UserID` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedOn` timestamp NULL DEFAULT NULL,
  `DeletedOn` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB ;

--
-- Dumping data for table `tbl_attachment`
--

INSERT INTO `tbl_attachment` (`AttachmentID`, `ReferID`, `Module`, `UploadDir`, `UploadFileName`, `UploadFileExt`, `UploadUrl`, `FileSize`, `DFlag`, `UserID`, `CreatedOn`, `UpdatedOn`, `DeletedOn`) VALUES
('SA2425-00000111', 'SD2425-00000086', 'Support', 'uploads/support/S2425-00000034/', '740fc995fd5567ed50103aa0d448d998.jpg', 'jpg', 'uploads/support/S2425-00000034/740fc995fd5567ed50103aa0d448d998.jpg', '54365', 0, 'U2425-0000004', '2024-04-10 04:08:51', NULL, NULL),
('SA2425-00000112', 'SD2425-00000086', 'Support', 'uploads/support/S2425-00000034/', '1291f86d7d15f0bbe28462256eea415f.jpg', 'jpg', 'uploads/support/S2425-00000034/1291f86d7d15f0bbe28462256eea415f.jpg', '158080', 0, 'U2425-0000004', '2024-04-10 04:08:51', NULL, NULL),
('SA2425-00000113', 'SD2425-00000086', 'Support', 'uploads/support/S2425-00000034/', 'dacf7096873eed223c3b7a0dbc6d835a.jpg', 'jpg', 'uploads/support/S2425-00000034/dacf7096873eed223c3b7a0dbc6d835a.jpg', '4224', 0, 'U2425-0000004', '2024-04-10 04:08:51', NULL, NULL),
('SA2425-00000114', 'SD2425-00000086', 'Support', 'uploads/support/S2425-00000034/', '53c7eb07d1f78f9f991f371b24233c9c.jpg', 'jpg', 'uploads/support/S2425-00000034/53c7eb07d1f78f9f991f371b24233c9c.jpg', '54365', 0, 'U2425-0000004', '2024-04-10 04:08:51', NULL, NULL),
('SA2425-00000115', 'SD2425-00000087', 'Support', 'uploads/support/S2425-00000034/', '5edf22ad2d66673aff462df994da723f.jpg', 'jpg', 'uploads/support/S2425-00000034/5edf22ad2d66673aff462df994da723f.jpg', '175322', 0, 'U2425-0000004', '2024-04-10 04:13:56', NULL, NULL),
('SA2425-00000116', 'SD2425-00000087', 'Support', 'uploads/support/S2425-00000034/', '85ffd799b703941ba9999b844ce7bc7f.jpg', 'jpg', 'uploads/support/S2425-00000034/85ffd799b703941ba9999b844ce7bc7f.jpg', '203820', 0, 'U2425-0000004', '2024-04-10 04:13:56', NULL, NULL),
('SA2425-00000117', 'SD2425-00000089', 'Support', 'uploads/support/S2425-00000035/', '5e1895d71f8794360bd13cbc22b2c204.jpg', 'jpg', 'uploads/support/S2425-00000035/5e1895d71f8794360bd13cbc22b2c204.jpg', '32410', 0, 'U2425-0000008', '2024-04-10 04:50:19', NULL, NULL),
('SA2425-00000118', 'SD2425-00000089', 'Support', 'uploads/support/S2425-00000035/', '3e5fad6fe8ceffe2804c1930a3636454.png', 'png', 'uploads/support/S2425-00000035/3e5fad6fe8ceffe2804c1930a3636454.png', '13088', 0, 'U2425-0000008', '2024-04-10 04:50:19', NULL, NULL),
('SA2425-00000119', 'SD2425-00000089', 'Support', 'uploads/support/S2425-00000035/', '07f897f45fc75869197c320fad697f3d.jpg', 'jpg', 'uploads/support/S2425-00000035/07f897f45fc75869197c320fad697f3d.jpg', '35603', 0, 'U2425-0000008', '2024-04-10 04:50:19', NULL, NULL),
('SA2425-00000120', 'SD2425-00000090', 'Support', 'uploads/support/S2425-00000035/', '60ef73ad3d2838287647205c0ee129d4.jpg', 'jpg', 'uploads/support/S2425-00000035/60ef73ad3d2838287647205c0ee129d4.jpg', '32410', 0, 'U2425-0000008', '2024-04-10 04:50:44', NULL, NULL),
('SA2425-00000121', 'SD2425-00000090', 'Support', 'uploads/support/S2425-00000035/', '3002bb83fa8914c13030d80d0025a8a5.jpg', 'jpg', 'uploads/support/S2425-00000035/3002bb83fa8914c13030d80d0025a8a5.jpg', '35603', 0, 'U2425-0000008', '2024-04-10 04:50:44', NULL, NULL),
('SA2425-00000122', 'SD2425-00000091', 'Support', 'uploads/support/S2425-00000036/', '98db6dc312d3a886e479b8c087bf2190.jpg', 'jpg', 'uploads/support/S2425-00000036/98db6dc312d3a886e479b8c087bf2190.jpg', '541206', 0, 'U2425-0000023', '2024-04-11 13:27:38', NULL, NULL),
('SA2425-00000123', 'SD2425-00000100', 'Support', 'uploads/support/S2425-00000041/', '3adffb3fd38b8526219390e61bc97a03.jpg', 'jpg', 'uploads/support/S2425-00000041/3adffb3fd38b8526219390e61bc97a03.jpg', '122239', 0, 'U2425-0000403', '2024-05-23 06:16:55', NULL, NULL),
('SA2425-00000124', 'SD2425-00000104', 'Support', 'uploads/support/S2425-00000041/', '1a1a64eb4de2014c79fef579d75a326e.png', 'png', 'uploads/support/S2425-00000041/1a1a64eb4de2014c79fef579d75a326e.png', '6262', 0, 'U2023-0000001', '2024-05-23 08:58:28', NULL, NULL),
('SA2425-00000125', 'SD2425-00000109', 'Support', 'uploads/support/S2425-00000042/', 'fe1029f21b6e48193c417c22697437ef.JPG', 'JPG', 'uploads/support/S2425-00000042/fe1029f21b6e48193c417c22697437ef.JPG', '612342', 0, 'U2023-0000001', '2024-05-23 09:26:34', NULL, NULL),
('SA2425-00000126', 'SD2425-00000111', 'Support', 'uploads/support/S2425-00000043/', '37ebe4ef4e49c7cbc57e1aa5abd2f72b.JPG', 'JPG', 'uploads/support/S2425-00000043/37ebe4ef4e49c7cbc57e1aa5abd2f72b.JPG', '612342', 0, 'U2023-0000001', '2024-05-23 09:41:22', NULL, NULL),
('SA2425-00000127', 'SD2425-00000113', 'Support', 'uploads/support/S2425-00000043/', '2494e9fcb1474a60e17b496e09207fd7.jpg', 'jpg', 'uploads/support/S2425-00000043/2494e9fcb1474a60e17b496e09207fd7.jpg', '355188', 0, 'U2425-0000076', '2024-05-23 10:22:35', NULL, NULL),
('SA2425-00000128', 'SD2425-00000115', 'Support', 'uploads/support/S2425-00000045/', '9b89eeeec97463a440e2226283cbb28a.jpg', 'jpg', 'uploads/support/S2425-00000045/9b89eeeec97463a440e2226283cbb28a.jpg', '67455', 0, 'U2425-0001420', '2024-09-12 06:40:45', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chat`
--

CREATE TABLE `tbl_chat` (
  `ChatID` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `sendFrom` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sendTo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Status` enum('Active','Deleted','Blocked') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Active',
  `isRead` int NOT NULL DEFAULT '0',
  `isAdminRead` int NOT NULL DEFAULT '0',
  `LastMessage` longtext COLLATE utf8mb4_general_ci,
  `LastMessageOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `senderLastSeenOn` timestamp NULL DEFAULT NULL,
  `adminLastSeenOn` timestamp NULL DEFAULT NULL,
  `isAdminChat` tinyint(1) NOT NULL DEFAULT '0',
  `CreatedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DeletedOn` timestamp NULL DEFAULT NULL,
  `BlockedOn` timestamp NULL DEFAULT NULL,
  `BlockedBy` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreatedBy` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `UpdatedOn` timestamp NULL DEFAULT NULL,
  `DeletedBy` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB ;

--
-- Dumping data for table `tbl_chat`
--

INSERT INTO `tbl_chat` (`ChatID`, `sendFrom`, `sendTo`, `Status`, `isRead`, `isAdminRead`, `LastMessage`, `LastMessageOn`, `senderLastSeenOn`, `adminLastSeenOn`, `isAdminChat`, `CreatedOn`, `DeletedOn`, `BlockedOn`, `BlockedBy`, `CreatedBy`, `UpdatedOn`, `DeletedBy`) VALUES
('C2024-0000000028', 'U2425-0001602', 'Admin', 'Active', 1, 0, 'sent a attachment file', '2024-11-19 04:18:21', '2024-11-19 04:18:23', '2024-11-11 07:51:29', 1, '2024-11-05 12:46:04', NULL, NULL, NULL, NULL, NULL, NULL),
('C2024-0000000029', 'U2425-0001598', 'Admin', 'Active', 0, 1, 'sent products links', '2024-11-11 09:34:49', '2024-11-09 09:53:28', '2024-11-11 09:34:50', 1, '2024-11-09 07:41:49', NULL, NULL, NULL, NULL, NULL, NULL),
('C2024-0000000030', 'U2425-0000035', 'Admin', 'Active', 1, 1, 'hii', '2024-11-14 09:04:20', '2024-11-14 09:04:31', '2024-11-14 09:04:20', 1, '2024-11-12 06:01:14', NULL, NULL, NULL, NULL, NULL, NULL),
('C2024-0000000031', 'U2425-0001791', 'Admin', 'Active', 1, 1, 'sent a attachment file', '2024-11-12 06:42:34', '2024-11-12 06:42:34', '2024-11-13 07:51:36', 1, '2024-11-12 06:40:33', NULL, NULL, NULL, NULL, NULL, NULL),
('C2024-0000000032', 'U2425-0000813', 'Admin', 'Active', 1, 0, NULL, '2024-11-13 07:17:30', '2024-11-13 08:00:58', NULL, 0, '2024-11-13 07:17:30', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chat_message`
--

CREATE TABLE `tbl_chat_message` (
  `SLNO` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `ChatID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `SendFrom` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `SendTo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Message` longtext COLLATE utf8mb4_general_ci,
  `Attachments` longtext COLLATE utf8mb4_general_ci,
  `Type` enum('Text','Attachment','Products','Quotation','Html') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Text',
  `Status` enum('Sent','Delivered','Read','Deleted') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Sent',
  `CreatedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DeliveredOn` timestamp NULL DEFAULT NULL,
  `ReadOn` timestamp NULL DEFAULT NULL,
  `DeletedOn` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB ;

--
-- Dumping data for table `tbl_chat_message`
--

INSERT INTO `tbl_chat_message` (`SLNO`, `ChatID`, `SendFrom`, `SendTo`, `Message`, `Attachments`, `Type`, `Status`, `CreatedOn`, `DeliveredOn`, `ReadOn`, `DeletedOn`) VALUES
('CM2024-000000000000001', 'C2024-0000000001', 'Admin', 'U2425-0001602', '<p><strong>Suggest me the best cement?</strong><br/>\nHere are some of the most popular types and brands of cement known for their quality and performance:</p><br/>\n1. UltraTech Cement<br/>2. ACC Cement<br/>', NULL, 'Text', 'Sent', '2024-11-04 13:06:00', '2024-11-04 13:06:00', NULL, NULL),
('CM2024-000000000000002', 'C2024-0000000001', 'U2425-0001602', 'Admin', 'Suggest me the best cement?', NULL, 'Text', 'Sent', '2024-11-04 13:06:01', '2024-11-04 13:06:01', NULL, NULL),
('CM2024-000000000000003', 'C2024-0000000001', 'U2425-0001602', 'Admin', 'hi admin', NULL, 'Text', 'Sent', '2024-11-04 13:06:10', '2024-11-04 13:06:10', NULL, NULL),
('CM2024-000000000000004', 'C2024-0000000002', 'Admin', 'U2425-0001791', '<p>Sure, Choose Hink brick.</p>', NULL, 'Text', 'Sent', '2024-11-04 13:58:50', '2024-11-04 13:58:50', NULL, NULL),
('CM2024-000000000000005', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'Help to choose the best brand in bricks?', NULL, 'Text', 'Sent', '2024-11-04 13:58:51', '2024-11-04 13:58:51', NULL, NULL),
('CM2024-000000000000006', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'Please vaandhuru', NULL, 'Text', 'Sent', '2024-11-04 13:59:06', '2024-11-04 13:59:06', NULL, NULL),
('CM2024-000000000000007', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'jj', '{}', 'Text', 'Sent', '2024-11-04 14:03:19', '2024-11-04 14:03:19', NULL, NULL),
('CM2024-000000000000008', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'vandhuchaa', NULL, 'Text', 'Sent', '2024-11-04 14:03:52', '2024-11-04 14:03:52', NULL, NULL),
('CM2024-000000000000009', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'deivameee vandhuru', NULL, 'Text', 'Sent', '2024-11-04 14:15:08', '2024-11-04 14:15:08', NULL, NULL),
('CM2024-000000000000010', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'hhhh', NULL, 'Text', 'Sent', '2024-11-04 14:17:13', '2024-11-04 14:17:13', NULL, NULL),
('CM2024-000000000000011', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'jj', NULL, 'Text', 'Sent', '2024-11-04 14:21:03', '2024-11-04 14:21:03', NULL, NULL),
('CM2024-000000000000012', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'hhh', NULL, 'Text', 'Sent', '2024-11-04 14:21:33', '2024-11-04 14:21:33', NULL, NULL),
('CM2024-000000000000013', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'hi', '{}', 'Text', 'Sent', '2024-11-04 14:23:47', '2024-11-04 14:23:47', NULL, NULL),
('CM2024-000000000000014', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'hello', '{}', 'Text', 'Sent', '2024-11-04 14:24:19', '2024-11-04 14:24:19', NULL, NULL),
('CM2024-000000000000015', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'karthi', NULL, 'Text', 'Sent', '2024-11-04 14:24:44', '2024-11-04 14:24:44', NULL, NULL),
('CM2024-000000000000016', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'hi', '{}', 'Text', 'Sent', '2024-11-04 14:52:41', '2024-11-04 14:52:41', NULL, NULL),
('CM2024-000000000000017', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'welcome', '{}', 'Text', 'Sent', '2024-11-04 14:53:04', '2024-11-04 14:53:04', NULL, NULL),
('CM2024-000000000000018', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'hi', '{}', 'Text', 'Sent', '2024-11-04 14:56:27', '2024-11-04 14:56:27', NULL, NULL),
('CM2024-000000000000019', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'hi', '{}', 'Text', 'Sent', '2024-11-04 14:56:55', '2024-11-04 14:56:55', NULL, NULL),
('CM2024-000000000000020', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'ddddkikik', NULL, 'Text', 'Sent', '2024-11-04 14:57:19', '2024-11-04 14:57:19', NULL, NULL),
('CM2024-000000000000021', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'sent a attachment file', '', 'Attachment', 'Sent', '2024-11-04 14:57:33', '2024-11-04 14:57:33', NULL, NULL),
('CM2024-000000000000022', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'msg received', NULL, 'Text', 'Sent', '2024-11-04 14:58:41', '2024-11-04 14:58:41', NULL, NULL),
('CM2024-000000000000023', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'giv mee', NULL, 'Text', 'Sent', '2024-11-04 14:58:57', '2024-11-04 14:58:57', NULL, NULL),
('CM2024-000000000000024', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'sent a attachment file', '', 'Attachment', 'Sent', '2024-11-04 15:00:31', '2024-11-04 15:00:31', NULL, NULL),
('CM2024-000000000000025', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'cv sen mee', NULL, 'Text', 'Sent', '2024-11-04 15:00:59', '2024-11-04 15:00:59', NULL, NULL),
('CM2024-000000000000026', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'sent a attachment file', '', 'Attachment', 'Sent', '2024-11-04 15:04:39', '2024-11-04 15:04:39', NULL, NULL),
('CM2024-000000000000027', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'it\'s mee', NULL, 'Text', 'Sent', '2024-11-04 15:05:06', '2024-11-04 15:05:06', NULL, NULL),
('CM2024-000000000000028', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'sent a attachment file', '', 'Attachment', 'Sent', '2024-11-04 15:10:41', '2024-11-04 15:10:41', NULL, NULL),
('CM2024-000000000000029', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'sent a attachment file', 'uploads/chat/C2024-0000000002/8583056b3085864fd7a5bbb209bfcffe.pdf', 'Attachment', 'Sent', '2024-11-04 15:10:59', '2024-11-04 15:10:59', NULL, NULL),
('CM2024-000000000000030', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'Sent Product Details', '[{\"ProductID\":\"P2024-0000003\",\"ProductName\":\"M Sand\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000003/7XDm23zV8c_20240109140231.png\",\"Description\":\"\\n\\tRPC  M sand is produced by crushing the hard granite, a rock which helps to provide an aggregate construction material for clients. RPC-M Sand is manufacturing this product by introducing the world‘s best crusher technology - Vertical Shaft Impactor (VSI Technology)from Finland.\\n\\tThis Rock-on-Rock technology makes RPC  M-sand more cubical which gives more strength and bonding when applied with allied building materials.\\n\\n\\n1. VSI quality\\n2. Higher durability\\n3. Higher Concrete Strength\\n4. Zone – II (IS:383 Code Standard)\\n5. PWD Approved Quality\\n6. Less Water Absorption property\\n7. Lesser Slit Content\\n8. Economic for use\\n9. Eco-friendly product \"},{\"ProductID\":\"P2024-0000004\",\"ProductName\":\"P-Sand\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000004/mabXCBgHBh_20240109140526.png\",\"Description\":\"1.VSI quality\\n2. PWD Approved quality\\n3.Zone-IV (IS:383 code Standard)\\n4. Free of Slit and Clay Particles\\n5. Higher unit weight\\n6. Lesser binder content required for plastering \"}]', 'Products', 'Sent', '2024-11-04 15:11:24', '2024-11-04 15:11:24', NULL, NULL),
('CM2024-000000000000031', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'dfg', '{}', 'Text', 'Sent', '2024-11-04 15:12:37', '2024-11-04 15:12:37', NULL, NULL),
('CM2024-000000000000032', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'vetrivel', NULL, 'Text', 'Sent', '2024-11-04 15:21:39', '2024-11-04 15:21:39', NULL, NULL),
('CM2024-000000000000033', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'sample mesge', NULL, 'Text', 'Sent', '2024-11-04 15:24:29', '2024-11-04 15:24:29', NULL, NULL),
('CM2024-000000000000034', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'ddmhutuf', NULL, 'Text', 'Sent', '2024-11-04 15:25:44', '2024-11-04 15:25:44', NULL, NULL),
('CM2024-000000000000035', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'okkmm', NULL, 'Text', 'Sent', '2024-11-04 15:27:22', '2024-11-04 15:27:22', NULL, NULL),
('CM2024-000000000000036', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'Hello there', NULL, 'Text', 'Sent', '2024-11-04 15:38:52', '2024-11-04 15:38:52', NULL, NULL),
('CM2024-000000000000037', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'kikljn', NULL, 'Text', 'Sent', '2024-11-04 15:40:59', '2024-11-04 15:40:59', NULL, NULL),
('CM2024-000000000000038', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'ikuhjui', '{}', 'Text', 'Sent', '2024-11-04 15:42:57', '2024-11-04 15:42:57', NULL, NULL),
('CM2024-000000000000039', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'uytuytu', '{}', 'Text', 'Sent', '2024-11-04 15:43:13', '2024-11-04 15:43:13', NULL, NULL),
('CM2024-000000000000040', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'hi', '{}', 'Text', 'Sent', '2024-11-04 15:43:27', '2024-11-04 15:43:27', NULL, NULL),
('CM2024-000000000000041', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'hi', '{}', 'Text', 'Sent', '2024-11-04 15:49:26', '2024-11-04 15:49:26', NULL, NULL),
('CM2024-000000000000042', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'hi', '{}', 'Text', 'Sent', '2024-11-04 15:50:16', '2024-11-04 15:50:16', NULL, NULL),
('CM2024-000000000000043', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'hi', '{}', 'Text', 'Sent', '2024-11-04 16:11:17', '2024-11-04 16:11:17', NULL, NULL),
('CM2024-000000000000044', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'hi', '{}', 'Text', 'Sent', '2024-11-04 16:11:45', '2024-11-04 16:11:45', NULL, NULL),
('CM2024-000000000000045', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'hi', '{}', 'Text', 'Sent', '2024-11-04 16:12:05', '2024-11-04 16:12:05', NULL, NULL),
('CM2024-000000000000046', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'welcome', '{}', 'Text', 'Sent', '2024-11-04 16:12:18', '2024-11-04 16:12:18', NULL, NULL),
('CM2024-000000000000047', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'hello', '{}', 'Text', 'Sent', '2024-11-04 16:13:10', '2024-11-04 16:13:10', NULL, NULL),
('CM2024-000000000000048', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'hi', '{}', 'Text', 'Sent', '2024-11-04 16:17:24', '2024-11-04 16:17:24', NULL, NULL),
('CM2024-000000000000049', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'hello', '{}', 'Text', 'Sent', '2024-11-04 16:19:27', '2024-11-04 16:19:27', NULL, NULL),
('CM2024-000000000000050', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'sdfasdf', '{}', 'Text', 'Sent', '2024-11-04 16:20:15', '2024-11-04 16:20:15', NULL, NULL),
('CM2024-000000000000051', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'fasdfsdf', '{}', 'Text', 'Sent', '2024-11-04 16:24:05', '2024-11-04 16:24:05', NULL, NULL),
('CM2024-000000000000052', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'gseufjksdhfgsd', '{}', 'Text', 'Sent', '2024-11-04 16:28:26', '2024-11-04 16:28:26', NULL, NULL),
('CM2024-000000000000053', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'Good evening', NULL, 'Text', 'Sent', '2024-11-04 16:31:27', '2024-11-04 16:31:27', NULL, NULL),
('CM2024-000000000000054', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'hvjrfvj', NULL, 'Text', 'Sent', '2024-11-04 16:32:53', '2024-11-04 16:32:53', NULL, NULL),
('CM2024-000000000000055', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'khfgddghfhg', NULL, 'Text', 'Sent', '2024-11-04 16:34:12', '2024-11-04 16:34:12', NULL, NULL),
('CM2024-000000000000056', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'miless', NULL, 'Text', 'Sent', '2024-11-04 16:35:20', '2024-11-04 16:35:20', NULL, NULL),
('CM2024-000000000000057', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'set etgo', NULL, 'Text', 'Sent', '2024-11-04 16:35:39', '2024-11-04 16:35:39', NULL, NULL),
('CM2024-000000000000058', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'merabuddy', NULL, 'Text', 'Sent', '2024-11-04 16:36:51', '2024-11-04 16:36:51', NULL, NULL),
('CM2024-000000000000059', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'comeee have', NULL, 'Text', 'Sent', '2024-11-04 16:38:41', '2024-11-04 16:38:41', NULL, NULL),
('CM2024-000000000000060', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'here we hapart', NULL, 'Text', 'Sent', '2024-11-04 16:40:25', '2024-11-04 16:40:25', NULL, NULL),
('CM2024-000000000000061', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'myselff', NULL, 'Text', 'Sent', '2024-11-04 16:41:25', '2024-11-04 16:41:25', NULL, NULL),
('CM2024-000000000000062', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'wevare', NULL, 'Text', 'Sent', '2024-11-04 16:42:15', '2024-11-04 16:42:15', NULL, NULL),
('CM2024-000000000000063', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'doll', NULL, 'Text', 'Sent', '2024-11-04 16:43:08', '2024-11-04 16:43:08', NULL, NULL),
('CM2024-000000000000064', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'citadel', NULL, 'Text', 'Sent', '2024-11-04 16:45:43', '2024-11-04 16:45:43', NULL, NULL),
('CM2024-000000000000065', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'buny', NULL, 'Text', 'Sent', '2024-11-04 16:46:39', '2024-11-04 16:46:39', NULL, NULL),
('CM2024-000000000000066', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'bakery', NULL, 'Text', 'Sent', '2024-11-04 16:48:00', '2024-11-04 16:48:00', NULL, NULL),
('CM2024-000000000000067', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'thankuuu', NULL, 'Text', 'Sent', '2024-11-04 16:48:24', '2024-11-04 16:48:24', NULL, NULL),
('CM2024-000000000000068', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'let\'s tomomorwo', NULL, 'Text', 'Sent', '2024-11-04 16:48:49', '2024-11-04 16:48:49', NULL, NULL),
('CM2024-000000000000069', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'hi', '{}', 'Text', 'Sent', '2024-11-04 21:45:54', '2024-11-04 21:45:54', NULL, NULL),
('CM2024-000000000000070', 'C2024-0000000002', 'Admin', 'U2425-0001791', 'Sent Product Details', '[{\"ProductID\":\"P2024-0000004\",\"ProductName\":\"P-Sand\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000004/mabXCBgHBh_20240109140526.png\",\"Description\":\"1.VSI quality\\n2. PWD Approved quality\\n3.Zone-IV (IS:383 code Standard)\\n4. Free of Slit and Clay Particles\\n5. Higher unit weight\\n6. Lesser binder content required for plastering \"}]', 'Products', 'Sent', '2024-11-04 21:58:05', '2024-11-04 21:58:05', NULL, NULL),
('CM2024-000000000000071', 'C2024-0000000002', 'Admin', 'U2425-0001791', NULL, '{}', 'Text', 'Sent', '2024-11-04 22:07:08', '2024-11-04 22:07:08', NULL, NULL),
('CM2024-000000000000072', 'C2024-0000000002', 'Admin', 'U2425-0001791', NULL, '{}', 'Text', 'Sent', '2024-11-04 22:07:15', '2024-11-04 22:07:15', NULL, NULL),
('CM2024-000000000000073', 'C2024-0000000002', 'Admin', 'U2425-0001791', NULL, '{}', 'Text', 'Sent', '2024-11-04 22:15:51', '2024-11-04 22:15:51', NULL, NULL),
('CM2024-000000000000074', 'C2024-0000000001', 'Admin', 'U2425-0001602', 'jol', '{}', 'Text', 'Sent', '2024-11-04 22:23:12', '2024-11-04 22:23:12', NULL, NULL),
('CM2024-000000000000075', 'C2024-0000000003', 'Admin', 'U2425-0001598', '<p><strong>Best cement brand ?</strong></p>\r\n\r\n<p>Chettinad</p>', NULL, 'Text', 'Sent', '2024-11-05 04:28:10', '2024-11-05 04:28:10', NULL, NULL),
('CM2024-000000000000076', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'Best cement brand ?', NULL, 'Text', 'Sent', '2024-11-05 04:28:12', '2024-11-05 04:28:12', NULL, NULL),
('CM2024-000000000000077', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'hello hiii admin', NULL, 'Text', 'Sent', '2024-11-05 04:30:23', '2024-11-05 04:30:23', NULL, NULL),
('CM2024-000000000000078', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'please reply', NULL, 'Text', 'Sent', '2024-11-05 04:31:06', '2024-11-05 04:31:06', NULL, NULL),
('CM2024-000000000000079', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/089f5f42931843bb58a212907b446fbd.pdf', 'Attachment', 'Sent', '2024-11-05 04:32:26', '2024-11-05 04:32:26', NULL, NULL),
('CM2024-000000000000080', 'C2024-0000000003', 'Admin', 'U2425-0001598', 'sent a attachment file', 'uploads/chat/C2024-0000000003/e3bdeb10231e984b5036456e692782a0.jpg', 'Attachment', 'Sent', '2024-11-05 04:33:24', '2024-11-05 04:33:24', NULL, NULL),
('CM2024-000000000000081', 'C2024-0000000003', 'Admin', 'U2425-0001598', NULL, '{}', 'Text', 'Sent', '2024-11-05 04:33:41', '2024-11-05 04:33:41', NULL, NULL),
('CM2024-000000000000082', 'C2024-0000000003', 'Admin', 'U2425-0001598', 'sent a attachment file', 'uploads/chat/C2024-0000000003/3e72a77e531712d11576a2f7866b56b2.jpeg', 'Attachment', 'Sent', '2024-11-05 04:36:52', '2024-11-05 04:36:52', NULL, NULL),
('CM2024-000000000000083', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'hey', NULL, 'Text', 'Sent', '2024-11-05 04:38:48', '2024-11-05 04:38:48', NULL, NULL),
('CM2024-000000000000084', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'bzhs', NULL, 'Text', 'Sent', '2024-11-05 04:42:36', '2024-11-05 04:42:36', NULL, NULL),
('CM2024-000000000000085', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'h', NULL, 'Text', 'Sent', '2024-11-05 04:43:03', '2024-11-05 04:43:03', NULL, NULL),
('CM2024-000000000000086', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'hiii', NULL, 'Text', 'Sent', '2024-11-05 04:43:31', '2024-11-05 04:43:31', NULL, NULL),
('CM2024-000000000000087', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'hsh', NULL, 'Text', 'Sent', '2024-11-05 04:44:02', '2024-11-05 04:44:02', NULL, NULL),
('CM2024-000000000000088', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/7d9162a3cc22c9ec707ec9492198c629.jpg', 'Attachment', 'Sent', '2024-11-05 04:44:40', '2024-11-05 04:44:40', NULL, NULL),
('CM2024-000000000000089', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/c1a256408701dc12483f8ce2312c6cd8.pdf', 'Attachment', 'Sent', '2024-11-05 04:49:00', '2024-11-05 04:49:00', NULL, NULL),
('CM2024-000000000000090', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/42c426665eb26222b1ebca191a438587.pdf', 'Attachment', 'Sent', '2024-11-05 04:49:45', '2024-11-05 04:49:45', NULL, NULL),
('CM2024-000000000000091', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/e12348d90d531c73eaaeb646a673efef.jpg', 'Attachment', 'Sent', '2024-11-05 04:53:51', '2024-11-05 04:53:51', NULL, NULL),
('CM2024-000000000000092', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'hs', NULL, 'Text', 'Sent', '2024-11-05 04:55:20', '2024-11-05 04:55:20', NULL, NULL),
('CM2024-000000000000093', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'naveen', NULL, 'Text', 'Sent', '2024-11-05 04:59:25', '2024-11-05 04:59:25', NULL, NULL),
('CM2024-000000000000094', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'hilll', NULL, 'Text', 'Sent', '2024-11-05 05:02:13', '2024-11-05 05:02:13', NULL, NULL),
('CM2024-000000000000095', 'C2024-0000000003', 'U2425-0001598', 'Admin', NULL, NULL, 'Text', 'Sent', '2024-11-05 05:02:56', '2024-11-05 05:02:56', NULL, NULL),
('CM2024-000000000000096', 'C2024-0000000003', 'U2425-0001598', 'Admin', NULL, NULL, 'Text', 'Sent', '2024-11-05 05:03:02', '2024-11-05 05:03:02', NULL, NULL),
('CM2024-000000000000097', 'C2024-0000000003', 'U2425-0001598', 'Admin', NULL, NULL, 'Text', 'Sent', '2024-11-05 05:03:25', '2024-11-05 05:03:25', NULL, NULL),
('CM2024-000000000000098', 'C2024-0000000003', 'U2425-0001598', 'Admin', NULL, NULL, 'Text', 'Sent', '2024-11-05 05:04:12', '2024-11-05 05:04:12', NULL, NULL),
('CM2024-000000000000099', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'g', NULL, 'Text', 'Sent', '2024-11-05 05:04:45', '2024-11-05 05:04:45', NULL, NULL),
('CM2024-000000000000100', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/527cb9624bbecc89e4f2923324b2f16f.jpg', 'Attachment', 'Sent', '2024-11-05 05:05:56', '2024-11-05 05:05:56', NULL, NULL),
('CM2024-000000000000101', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/7159204026a1b83bbde4f13070b2ac79.pdf', 'Attachment', 'Sent', '2024-11-05 05:07:38', '2024-11-05 05:07:38', NULL, NULL),
('CM2024-000000000000102', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/3b8ac84d517962d243d70aba9a551179.pdf', 'Attachment', 'Sent', '2024-11-05 05:09:08', '2024-11-05 05:09:08', NULL, NULL),
('CM2024-000000000000103', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/8e48bf2d6a1f31900828808fc95d27e7.jpg', 'Attachment', 'Sent', '2024-11-05 05:11:20', '2024-11-05 05:11:20', NULL, NULL),
('CM2024-000000000000104', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/b1ec7fd081edd2e61041dbe7f3c2c57f.jpg', 'Attachment', 'Sent', '2024-11-05 05:11:50', '2024-11-05 05:11:50', NULL, NULL),
('CM2024-000000000000105', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/ad4930da0b1cad7ae65c7e680c01bfcb.jpg', 'Attachment', 'Sent', '2024-11-05 05:13:38', '2024-11-05 05:13:38', NULL, NULL),
('CM2024-000000000000106', 'C2024-0000000003', 'Admin', 'U2425-0001598', 'sent a attachment file', 'uploads/chat/C2024-0000000003/d2f923b824e800442c8538b185a098c0.jpeg', 'Attachment', 'Sent', '2024-11-05 05:23:16', '2024-11-05 05:23:16', NULL, NULL),
('CM2024-000000000000107', 'C2024-0000000003', 'Admin', 'U2425-0001598', NULL, NULL, 'Text', 'Sent', '2024-11-05 05:23:26', '2024-11-05 05:23:26', NULL, NULL),
('CM2024-000000000000108', 'C2024-0000000003', 'Admin', 'U2425-0001598', NULL, NULL, 'Text', 'Sent', '2024-11-05 05:24:19', '2024-11-05 05:24:19', NULL, NULL),
('CM2024-000000000000109', 'C2024-0000000003', 'Admin', 'U2425-0001598', NULL, NULL, 'Text', 'Sent', '2024-11-05 05:25:40', '2024-11-05 05:25:40', NULL, NULL),
('CM2024-000000000000110', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/df3fed78a1605e7383a34e5d5bf66614.pdf', 'Attachment', 'Sent', '2024-11-05 05:26:04', '2024-11-05 05:26:04', NULL, NULL),
('CM2024-000000000000111', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'h', NULL, 'Text', 'Sent', '2024-11-05 05:26:27', '2024-11-05 05:26:27', NULL, NULL),
('CM2024-000000000000112', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/113623943e80b3f4bef6bcd467a51af6.jpg', 'Attachment', 'Sent', '2024-11-05 05:27:03', '2024-11-05 05:27:03', NULL, NULL),
('CM2024-000000000000113', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'hiii', NULL, 'Text', 'Sent', '2024-11-05 05:27:12', '2024-11-05 05:27:12', NULL, NULL),
('CM2024-000000000000114', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'hshshshsbs', NULL, 'Text', 'Sent', '2024-11-05 05:27:22', '2024-11-05 05:27:22', NULL, NULL),
('CM2024-000000000000115', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'hiiii', NULL, 'Text', 'Sent', '2024-11-05 05:27:30', '2024-11-05 05:27:30', NULL, NULL),
('CM2024-000000000000116', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/b34c0f8faded51330509f0ddf27174df.pdf', 'Attachment', 'Sent', '2024-11-05 05:27:53', '2024-11-05 05:27:53', NULL, NULL),
('CM2024-000000000000117', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'hi', NULL, 'Text', 'Sent', '2024-11-05 05:28:26', '2024-11-05 05:28:26', NULL, NULL),
('CM2024-000000000000118', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'd', NULL, 'Text', 'Sent', '2024-11-05 05:28:29', '2024-11-05 05:28:29', NULL, NULL),
('CM2024-000000000000119', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'fr', NULL, 'Text', 'Sent', '2024-11-05 05:28:33', '2024-11-05 05:28:33', NULL, NULL),
('CM2024-000000000000120', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'dns', NULL, 'Text', 'Sent', '2024-11-05 05:28:37', '2024-11-05 05:28:37', NULL, NULL),
('CM2024-000000000000121', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'uzhdhsh', NULL, 'Text', 'Sent', '2024-11-05 05:28:41', '2024-11-05 05:28:41', NULL, NULL),
('CM2024-000000000000122', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sbshsj', NULL, 'Text', 'Sent', '2024-11-05 05:28:50', '2024-11-05 05:28:50', NULL, NULL),
('CM2024-000000000000123', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'jdhs', NULL, 'Text', 'Sent', '2024-11-05 05:28:54', '2024-11-05 05:28:54', NULL, NULL),
('CM2024-000000000000124', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sss', NULL, 'Text', 'Sent', '2024-11-05 05:28:58', '2024-11-05 05:28:58', NULL, NULL),
('CM2024-000000000000125', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'jsj', NULL, 'Text', 'Sent', '2024-11-05 05:29:01', '2024-11-05 05:29:01', NULL, NULL),
('CM2024-000000000000126', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sjj', NULL, 'Text', 'Sent', '2024-11-05 05:29:06', '2024-11-05 05:29:06', NULL, NULL),
('CM2024-000000000000127', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'jsh', NULL, 'Text', 'Sent', '2024-11-05 05:29:09', '2024-11-05 05:29:09', NULL, NULL),
('CM2024-000000000000128', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'jj', NULL, 'Text', 'Sent', '2024-11-05 05:29:12', '2024-11-05 05:29:12', NULL, NULL),
('CM2024-000000000000129', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'us', NULL, 'Text', 'Sent', '2024-11-05 05:29:16', '2024-11-05 05:29:16', NULL, NULL),
('CM2024-000000000000130', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'vishak ppl', NULL, 'Text', 'Sent', '2024-11-05 05:29:23', '2024-11-05 05:29:23', NULL, NULL),
('CM2024-000000000000131', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/b96c3de33c4eaad20217e28e9e3c184f.pdf', 'Attachment', 'Sent', '2024-11-05 05:35:25', '2024-11-05 05:35:25', NULL, NULL),
('CM2024-000000000000132', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/9c430a9ed744a090e08ae187d3f4dccc.pdf', 'Attachment', 'Sent', '2024-11-05 05:35:43', '2024-11-05 05:35:43', NULL, NULL),
('CM2024-000000000000133', 'C2024-0000000003', 'Admin', 'U2425-0001598', 'Sent Product Details', '[{\"ProductID\":\"P2024-0000229\",\"ProductName\":\"Prime Gold 16mm Steel\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000229/1lVUj7hBFm_20240208153003.png\",\"Description\":\"Prime Gold is a Compared to plain mild steel bars, Prime gold TMT bars offer significantly higher strength, flexibility, and corrosion resistance. The use of the best TMT bars ensures improved structural stability and reduced maintenance requirements.\"},{\"ProductID\":\"P2024-0000306\",\"ProductName\":\"JR 20mm Steel\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000306/gwxrMyxgEA_20240207144535.png\",\"Description\":\"Resists fire: Withstands temperatures up to 500 degrees Celsius. Resists corrosion: The TMT process gives the bar superior strength and good anti-corrosive properties. Earthquake resistance: The soft ferrite-pearlite core enables the bar to bear dynamic and seismic loading.\"}]', 'Products', 'Sent', '2024-11-05 05:36:57', '2024-11-05 05:36:57', NULL, NULL),
('CM2024-000000000000134', 'C2024-0000000002', 'Admin', 'U2425-0001791', NULL, NULL, 'Text', 'Sent', '2024-11-05 05:37:35', '2024-11-05 05:37:35', NULL, NULL),
('CM2024-000000000000135', 'C2024-0000000003', 'Admin', 'U2425-0001598', 'ghtnjm', NULL, 'Text', 'Sent', '2024-11-05 05:44:00', '2024-11-05 05:44:00', NULL, NULL),
('CM2024-000000000000136', 'C2024-0000000001', 'U2425-0001602', 'Admin', 'hw r u', NULL, 'Text', 'Sent', '2024-11-05 05:45:56', '2024-11-05 05:45:56', NULL, NULL),
('CM2024-000000000000137', 'C2024-0000000001', 'U2425-0001602', 'Admin', 'msg', NULL, 'Text', 'Sent', '2024-11-05 05:46:41', '2024-11-05 05:46:41', NULL, NULL),
('CM2024-000000000000138', 'C2024-0000000001', 'U2425-0001602', 'Admin', 'jack', NULL, 'Text', 'Sent', '2024-11-05 05:47:17', '2024-11-05 05:47:17', NULL, NULL),
('CM2024-000000000000139', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/0ccb80e417036ea7561a00250338bca6.pdf', 'Attachment', 'Sent', '2024-11-05 05:59:24', '2024-11-05 05:59:24', NULL, NULL),
('CM2024-000000000000140', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'helo', NULL, 'Text', 'Sent', '2024-11-05 05:59:33', '2024-11-05 05:59:33', NULL, NULL),
('CM2024-000000000000141', 'C2024-0000000003', 'U2425-0001598', 'Admin', 's', NULL, 'Text', 'Sent', '2024-11-05 06:00:11', '2024-11-05 06:00:11', NULL, NULL),
('CM2024-000000000000142', 'C2024-0000000003', 'U2425-0001598', 'Admin', ':)', NULL, 'Text', 'Sent', '2024-11-05 06:00:37', '2024-11-05 06:00:37', NULL, NULL),
('CM2024-000000000000143', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/3bb64610ce79365cff6fd111d67ca0d5.pdf', 'Attachment', 'Sent', '2024-11-05 06:04:57', '2024-11-05 06:04:57', NULL, NULL),
('CM2024-000000000000144', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/178e1569a058965022c283545205f849.jpeg', 'Attachment', 'Sent', '2024-11-05 06:05:23', '2024-11-05 06:05:23', NULL, NULL),
('CM2024-000000000000145', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'hello admin', NULL, 'Text', 'Sent', '2024-11-05 06:09:59', '2024-11-05 06:09:59', NULL, NULL),
('CM2024-000000000000146', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'hiii adminnn gaaru', NULL, 'Text', 'Sent', '2024-11-05 06:10:11', '2024-11-05 06:10:11', NULL, NULL),
('CM2024-000000000000147', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'hi', '{}', 'Text', 'Sent', '2024-11-05 06:12:20', '2024-11-05 06:12:20', NULL, NULL),
('CM2024-000000000000148', 'C2024-0000000003', 'U2425-0001598', 'Admin', NULL, '{}', 'Text', 'Sent', '2024-11-05 06:12:35', '2024-11-05 06:12:35', NULL, NULL),
('CM2024-000000000000149', 'C2024-0000000003', 'U2425-0001598', 'Admin', NULL, '{}', 'Text', 'Sent', '2024-11-05 06:12:43', '2024-11-05 06:12:43', NULL, NULL),
('CM2024-000000000000150', 'C2024-0000000003', 'U2425-0001598', 'Admin', NULL, '{}', 'Text', 'Sent', '2024-11-05 06:12:57', '2024-11-05 06:12:57', NULL, NULL),
('CM2024-000000000000151', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/c0073dff015030f6fa1fb5cecd190f4a.jpeg', 'Attachment', 'Sent', '2024-11-05 06:13:13', '2024-11-05 06:13:13', NULL, NULL),
('CM2024-000000000000152', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/f1461eac060ce7bb4adcb639bd98dad7.pdf', 'Attachment', 'Sent', '2024-11-05 06:13:23', '2024-11-05 06:13:23', NULL, NULL),
('CM2024-000000000000153', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/fc0ddddce72fc629f585b4b26e26087b.jpeg', 'Attachment', 'Sent', '2024-11-05 06:14:25', '2024-11-05 06:14:25', NULL, NULL),
('CM2024-000000000000154', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/862fddc4ab324e37337b59d41df8db43.jpg', 'Attachment', 'Sent', '2024-11-05 06:14:42', '2024-11-05 06:14:42', NULL, NULL),
('CM2024-000000000000155', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'keloooo', NULL, 'Text', 'Sent', '2024-11-05 06:14:53', '2024-11-05 06:14:53', NULL, NULL),
('CM2024-000000000000156', 'C2024-0000000001', 'U2425-0001602', 'Admin', 'ggh', NULL, 'Text', 'Sent', '2024-11-05 06:16:28', '2024-11-05 06:16:28', NULL, NULL),
('CM2024-000000000000157', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'likkkk', NULL, 'Text', 'Sent', '2024-11-05 06:17:36', '2024-11-05 06:17:36', NULL, NULL),
('CM2024-000000000000158', 'C2024-0000000003', 'U2425-0001598', 'Admin', NULL, '{}', 'Text', 'Sent', '2024-11-05 06:18:13', '2024-11-05 06:18:13', NULL, NULL),
('CM2024-000000000000159', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/6ce8aac7a0ac199ff8286dde33cecf55.docx', 'Attachment', 'Sent', '2024-11-05 06:19:33', '2024-11-05 06:19:33', NULL, NULL),
('CM2024-000000000000160', 'C2024-0000000003', 'U2425-0001598', 'Admin', '!@#!@$@#%$^%', '{}', 'Text', 'Sent', '2024-11-05 06:20:21', '2024-11-05 06:20:21', NULL, NULL),
('CM2024-000000000000161', 'C2024-0000000003', 'U2425-0001598', 'Admin', '!@#!@$@#%$^%', '{}', 'Text', 'Sent', '2024-11-05 06:20:21', '2024-11-05 06:20:21', NULL, NULL),
('CM2024-000000000000162', 'C2024-0000000003', 'U2425-0001598', 'Admin', '!@#!@$@#%$^%', '{}', 'Text', 'Sent', '2024-11-05 06:20:22', '2024-11-05 06:20:22', NULL, NULL),
('CM2024-000000000000163', 'C2024-0000000003', 'U2425-0001598', 'Admin', '!@#!@$@#%$^%', '{}', 'Text', 'Sent', '2024-11-05 06:20:23', '2024-11-05 06:20:23', NULL, NULL),
('CM2024-000000000000164', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'kill', NULL, 'Text', 'Sent', '2024-11-05 06:20:28', '2024-11-05 06:20:28', NULL, NULL),
('CM2024-000000000000165', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'Hellooo admin good', NULL, 'Text', 'Sent', '2024-11-05 06:20:57', '2024-11-05 06:20:57', NULL, NULL),
('CM2024-000000000000166', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'Hlooooo admineeee', NULL, 'Text', 'Sent', '2024-11-05 06:21:16', '2024-11-05 06:21:16', NULL, NULL),
('CM2024-000000000000167', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'helloooo', NULL, 'Text', 'Sent', '2024-11-05 06:22:03', '2024-11-05 06:22:03', NULL, NULL),
('CM2024-000000000000168', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'ki', '{}', 'Text', 'Sent', '2024-11-05 06:22:05', '2024-11-05 06:22:05', NULL, NULL),
('CM2024-000000000000169', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'jh', '{}', 'Text', 'Sent', '2024-11-05 06:23:03', '2024-11-05 06:23:03', NULL, NULL),
('CM2024-000000000000170', 'C2024-0000000003', 'U2425-0001598', 'Admin', ',ljgh', '{}', 'Text', 'Sent', '2024-11-05 06:23:11', '2024-11-05 06:23:11', NULL, NULL),
('CM2024-000000000000171', 'C2024-0000000003', 'U2425-0001598', 'Admin', '!@!#!@$', '{}', 'Text', 'Sent', '2024-11-05 06:23:27', '2024-11-05 06:23:27', NULL, NULL),
('CM2024-000000000000172', 'C2024-0000000003', 'U2425-0001598', 'Admin', '!@#@@!4', '{}', 'Text', 'Sent', '2024-11-05 06:23:40', '2024-11-05 06:23:40', NULL, NULL),
('CM2024-000000000000173', 'C2024-0000000003', 'U2425-0001598', 'Admin', '!@#@@!4', '{}', 'Text', 'Sent', '2024-11-05 06:23:41', '2024-11-05 06:23:41', NULL, NULL),
('CM2024-000000000000174', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'veggr', NULL, 'Text', 'Sent', '2024-11-05 06:36:11', '2024-11-05 06:36:11', NULL, NULL),
('CM2024-000000000000175', 'C2024-0000000002', 'U2425-0001791', 'Admin', 'yjnyn', NULL, 'Text', 'Sent', '2024-11-05 06:36:17', '2024-11-05 06:36:17', NULL, NULL),
('CM2024-000000000000179', 'C2024-0000000003', 'U2425-0001598', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000003/9ac55f9de5c6fdd94f5debac99cad684.pdf', 'Attachment', 'Sent', '2024-11-05 06:43:52', '2024-11-05 06:43:52', NULL, NULL),
('CM2024-000000000000180', 'C2024-0000000003', 'U2425-0001598', 'Admin', '!@#@!#@$sdvcjsdnvdskjvndsvkdsnvk', '{}', 'Text', 'Sent', '2024-11-05 06:44:04', '2024-11-05 06:44:04', NULL, NULL),
('CM2024-000000000000188', 'C2024-0000000005', 'Admin', 'U2425-0001791', '<p><strong>Best cement brand ?</strong></p>\r\n\r\n<p>Chettinad</p>', NULL, 'Text', 'Sent', '2024-11-05 06:58:16', '2024-11-05 06:58:16', NULL, NULL),
('CM2024-000000000000189', 'C2024-0000000005', 'U2425-0001791', 'Admin', 'Best cement brand ?', NULL, 'Text', 'Sent', '2024-11-05 06:58:18', '2024-11-05 06:58:18', NULL, NULL),
('CM2024-000000000000190', 'C2024-0000000005', 'U2425-0001791', 'Admin', 'hii admin I need some help', NULL, 'Text', 'Sent', '2024-11-05 06:58:35', '2024-11-05 06:58:35', NULL, NULL),
('CM2024-000000000000191', 'C2024-0000000006', 'U2425-0000813', 'Admin', 'Best cement brand ?', NULL, 'Text', 'Sent', '2024-11-05 06:58:37', '2024-11-05 06:58:37', NULL, NULL),
('CM2024-000000000000192', 'C2024-0000000006', 'Admin', 'U2425-0000813', '<p><strong>Best cement brand ?</strong></p>\r\n\r\n<p>Chettinad</p>', NULL, 'Html', 'Sent', '2024-11-05 06:58:39', '2024-11-05 06:58:39', NULL, NULL),
('CM2024-000000000000193', 'C2024-0000000005', 'U2425-0001791', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000005/9e34c29e4cff91a13f38498e1e933137.pdf', 'Attachment', 'Sent', '2024-11-05 06:58:56', '2024-11-05 06:58:56', NULL, NULL),
('CM2024-000000000000194', 'C2024-0000000005', 'U2425-0001791', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000005/6dcf089783580f74edbcdaebf25c3970.jpeg', 'Attachment', 'Sent', '2024-11-05 06:59:22', '2024-11-05 06:59:22', NULL, NULL),
('CM2024-000000000000195', 'C2024-0000000006', 'Admin', 'U2425-0000813', 'Tell us your problem, and we’ll provide the solution', NULL, 'Text', 'Sent', '2024-11-05 07:01:47', '2024-11-05 07:01:47', NULL, NULL),
('CM2024-000000000000196', 'C2024-0000000007', 'Admin', 'U2425-0001791', '<p><strong>Do you provide tiles for the home?</strong></p>\n\n<p>Yes</p>\n\n<p>&nbsp;</p>', NULL, 'Text', 'Sent', '2024-11-05 07:03:21', '2024-11-05 07:03:21', NULL, NULL),
('CM2024-000000000000197', 'C2024-0000000007', 'U2425-0001791', 'Admin', 'Do you provide tiles for home?', NULL, 'Text', 'Sent', '2024-11-05 07:03:22', '2024-11-05 07:03:22', NULL, NULL),
('CM2024-000000000000198', 'C2024-0000000007', 'U2425-0001791', 'Admin', 'Hii admin I need some assist', NULL, 'Text', 'Sent', '2024-11-05 07:04:10', '2024-11-05 07:04:10', NULL, NULL),
('CM2024-000000000000199', 'C2024-0000000007', 'Admin', 'U2425-0001791', 'Yess', NULL, 'Text', 'Sent', '2024-11-05 07:05:18', '2024-11-05 07:05:18', NULL, NULL),
('CM2024-000000000000200', 'C2024-0000000007', 'U2425-0001791', 'Admin', 'Can you suggest me some best tile brand', NULL, 'Text', 'Sent', '2024-11-05 07:05:35', '2024-11-05 07:05:35', NULL, NULL),
('CM2024-000000000000204', 'C2024-0000000010', 'U2425-0000813', 'Admin', 'Best cement brand ?', NULL, 'Text', 'Sent', '2024-11-05 07:23:44', '2024-11-05 07:23:44', NULL, NULL),
('CM2024-000000000000205', 'C2024-0000000010', 'Admin', 'U2425-0000813', '<p><strong>Best cement brand ?</strong><br>Chettinad</p>', NULL, 'Html', 'Sent', '2024-11-05 07:23:47', '2024-11-05 07:23:47', NULL, NULL),
('CM2024-000000000000206', 'C2024-0000000010', 'Admin', 'U2425-0000813', 'Tell us your problem, and we’ll provide the solution', NULL, 'Text', 'Sent', '2024-11-05 07:25:05', '2024-11-05 07:25:05', NULL, NULL),
('CM2024-000000000000207', 'C2024-0000000010', 'U2425-0000813', 'Admin', 'I need 10kg chettinad cements', '{}', 'Text', 'Sent', '2024-11-05 07:26:06', '2024-11-05 07:26:06', NULL, NULL),
('CM2024-000000000000208', 'C2024-0000000009', 'U2425-0001602', 'Admin', 'Best cement brand ?', NULL, 'Text', 'Sent', '2024-11-05 07:36:26', '2024-11-05 07:36:26', NULL, NULL),
('CM2024-000000000000209', 'C2024-0000000009', 'Admin', 'U2425-0001602', '<p><strong>Best cement brand ?</strong><br>Chettinad</p>', NULL, 'Text', 'Sent', '2024-11-05 07:36:32', '2024-11-05 07:36:32', NULL, NULL),
('CM2024-000000000000210', 'C2024-0000000011', 'U2425-0000813', 'Admin', 'VSI Quality M-Sand', NULL, 'Text', 'Sent', '2024-11-05 07:37:55', '2024-11-05 07:37:55', NULL, NULL),
('CM2024-000000000000211', 'C2024-0000000011', 'Admin', 'U2425-0000813', '<p><strong>VSI Quality M-Sand</strong><br />\r\nAvailable</p>', NULL, 'Html', 'Sent', '2024-11-05 07:37:57', '2024-11-05 07:37:57', NULL, NULL),
('CM2024-000000000000212', 'C2024-0000000011', 'Admin', 'U2425-0000813', 'Tell us your problem, and we’ll provide the solution', NULL, 'Text', 'Sent', '2024-11-05 07:43:43', '2024-11-05 07:43:43', NULL, NULL),
('CM2024-000000000000213', 'C2024-0000000011', 'U2425-0000813', 'Admin', 'Hi', '{}', 'Text', 'Sent', '2024-11-05 07:44:03', '2024-11-05 07:44:03', NULL, NULL),
('CM2024-000000000000214', 'C2024-0000000011', 'U2425-0000813', 'Admin', 'I need UltraTech cements of 20Kg', '{}', 'Text', 'Sent', '2024-11-05 07:44:37', '2024-11-05 07:44:37', NULL, NULL),
('CM2024-000000000000215', 'C2024-0000000011', 'Admin', 'U2425-0000813', 'Kindly share your location', NULL, 'Text', 'Sent', '2024-11-05 07:45:40', '2024-11-05 07:45:40', NULL, NULL),
('CM2024-000000000000216', 'C2024-0000000011', 'U2425-0000813', 'Admin', 'Coimbatore', '{}', 'Text', 'Sent', '2024-11-05 07:47:13', '2024-11-05 07:47:13', NULL, NULL),
('CM2024-000000000000217', 'C2024-0000000011', 'Admin', 'U2425-0000813', 'Sent Product Details', '[{\"ProductID\":\"P2024-0000058\",\"ProductName\":\"Dalmia Future Today Cement 50kg\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000058/yddVdcEk1B_20240127165404.png\",\"Description\":\"Dalmia Cement is manufactured in state-of-the-art plants using premium Portland cement clinkers, combined with high-purity gypsum, silica-rich slag, and highly-reactive fly ash.\"},{\"ProductID\":\"P2024-0000053\",\"ProductName\":\"Ultratech Plus Concrete\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000053/iB4gaxfSgb_20240210125046.png\",\"Description\":\"Dampness poses the primary threat to the structural integrity of your home, permeating its various components—roof, walls, and foundation—gradually weakening them from within and shortening its lifespan. Once inside, dampness spreads swiftly and is incredibly challenging to eliminate. Safeguarding your home against this menace requires constructing the entire structure with UltraTech Weather Plus, a reliable solution that effectively repels water, ensuring comprehensive protection against dampness.\"},{\"ProductID\":\"P2024-0000195\",\"ProductName\":\"BERGER-HS TILE ADHESIVE PLUS (20KG)\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000195/MRSkQiwV4t_20240120171317.png\",\"Description\":\"\"}]', 'Products', 'Sent', '2024-11-05 07:48:10', '2024-11-05 07:48:10', NULL, NULL),
('CM2024-000000000000218', 'C2024-0000000011', 'U2425-0000813', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000011/9c10822ef611ed606d8bd9bcac76f756.png', 'Attachment', 'Sent', '2024-11-05 07:50:23', '2024-11-05 07:50:23', NULL, NULL),
('CM2024-000000000000220', 'C2024-0000000011', 'U2425-0000813', 'Admin', 'Add Dalmia future in qty of 2', '{}', 'Text', 'Sent', '2024-11-05 07:53:24', '2024-11-05 07:53:24', NULL, NULL),
('CM2024-000000000000221', 'C2024-0000000013', 'U2425-0001602', 'Admin', 'Best cement brand ?', NULL, 'Text', 'Sent', '2024-11-05 10:09:11', '2024-11-05 10:09:11', NULL, NULL),
('CM2024-000000000000222', 'C2024-0000000013', 'Admin', 'U2425-0001602', '<p><strong>Best cement brand ?</strong><br>Chettinad</p>', NULL, 'Text', 'Sent', '2024-11-05 10:09:26', '2024-11-05 10:09:26', NULL, NULL),
('CM2024-000000000000223', 'C2024-0000000014', 'Admin', 'U2425-0001602', '<p><strong>Best cement brand ?</strong><br>Chettinad</p>', NULL, 'Text', 'Sent', '2024-11-05 10:20:24', '2024-11-05 10:20:24', NULL, NULL),
('CM2024-000000000000224', 'C2024-0000000015', 'U2425-0001602', 'Admin', 'Best cement brand ?', NULL, 'Text', 'Sent', '2024-11-05 10:26:37', '2024-11-05 10:26:37', NULL, NULL),
('CM2024-000000000000225', 'C2024-0000000016', 'Admin', 'U2425-0001791', '<p><strong>Do you provide tiles for the home?</strong></p>\n\n<p>Yes</p>\n\n<p>&nbsp;</p>', NULL, 'Text', 'Sent', '2024-11-05 10:29:20', '2024-11-05 10:29:20', NULL, NULL),
('CM2024-000000000000226', 'C2024-0000000016', 'U2425-0001791', 'Admin', 'Do you provide tiles for home?', NULL, 'Text', 'Sent', '2024-11-05 10:29:22', '2024-11-05 10:29:22', NULL, NULL),
('CM2024-000000000000227', 'C2024-0000000017', 'U2425-0001791', 'Admin', 'Do you provide tiles for home?', NULL, 'Text', 'Sent', '2024-11-05 10:31:15', '2024-11-05 10:31:15', NULL, NULL),
('CM2024-000000000000228', 'C2024-0000000017', 'Admin', 'U2425-0001791', '<p><strong>Do you provide tiles for the home?</strong></p>\n\n<p>Yes</p>\n\n<p>&nbsp;</p>', NULL, 'Text', 'Sent', '2024-11-05 10:31:17', '2024-11-05 10:31:17', NULL, NULL),
('CM2024-000000000000229', 'C2024-0000000018', 'U2425-0001602', 'Admin', 'Best cement brand ?', NULL, 'Text', 'Sent', '2024-11-05 10:44:38', '2024-11-05 10:44:38', NULL, NULL),
('CM2024-000000000000230', 'C2024-0000000018', 'Admin', 'U2425-0001602', '<p><strong>Best cement brand ?</strong><br>Chettinad</p>', NULL, 'Text', 'Sent', '2024-11-05 10:44:41', '2024-11-05 10:44:41', NULL, NULL),
('CM2024-000000000000231', 'C2024-0000000019', 'U2425-0001791', 'Admin', 'Help to choose the best brand in bricks?', NULL, 'Text', 'Sent', '2024-11-05 10:49:56', '2024-11-05 10:49:56', NULL, NULL),
('CM2024-000000000000232', 'C2024-0000000019', 'Admin', 'U2425-0001791', '<p>Sure, Choose Hink brick.</p>', NULL, 'Text', 'Sent', '2024-11-05 10:49:59', '2024-11-05 10:49:59', NULL, NULL),
('CM2024-000000000000233', 'C2024-0000000021', 'Admin', 'U2425-0001602', 'Tell us your problem, and we\'ll provide the solution', NULL, 'Text', 'Sent', '2024-11-05 11:48:03', '2024-11-05 11:48:03', NULL, NULL),
('CM2024-000000000000234', 'C2024-0000000022', 'Admin', 'U2425-0001602', 'Tell us your problem, and we\'ll provide the solution', NULL, 'Text', 'Sent', '2024-11-05 11:50:51', '2024-11-05 11:50:51', NULL, NULL),
('CM2024-000000000000235', 'C2024-0000000024', 'U2425-0000813', 'Admin', 'VSI Quality M-Sand', NULL, 'Text', 'Sent', '2024-11-05 12:15:31', '2024-11-05 12:15:31', NULL, NULL),
('CM2024-000000000000236', 'C2024-0000000024', 'Admin', 'U2425-0000813', '<p><strong>VSI Quality M-Sand</strong><br />\r\nAvailable</p>', NULL, 'Html', 'Sent', '2024-11-05 12:15:33', '2024-11-05 12:15:33', NULL, NULL),
('CM2024-000000000000237', 'C2024-0000000024', 'Admin', 'U2425-0000813', 'Tell us your problem, and we’ll provide the solution', NULL, 'Text', 'Sent', '2024-11-05 12:16:37', '2024-11-05 12:16:37', NULL, NULL),
('CM2024-000000000000238', 'C2024-0000000023', 'U2425-0001602', 'Admin', 'Best cement brand ?', NULL, 'Text', 'Sent', '2024-11-05 12:29:09', '2024-11-05 12:29:09', NULL, NULL),
('CM2024-000000000000239', 'C2024-0000000023', 'Admin', 'U2425-0001602', '<p><strong>Best cement brand ?</strong><br>Chettinad</p>', NULL, 'Text', 'Sent', '2024-11-05 12:29:12', '2024-11-05 12:29:12', NULL, NULL),
('CM2024-000000000000240', 'C2024-0000000025', 'Admin', 'U2425-0001602', 'Tell us your problem, and we\'ll provide the solution', NULL, 'Text', 'Sent', '2024-11-05 12:31:18', '2024-11-05 12:31:18', NULL, NULL),
('CM2024-000000000000241', 'C2024-0000000025', 'U2425-0001602', 'Admin', 'Help to choose the best brand in bricks?', NULL, 'Text', 'Sent', '2024-11-05 12:31:18', '2024-11-05 12:31:18', NULL, NULL),
('CM2024-000000000000242', 'C2024-0000000025', 'Admin', 'U2425-0001602', '<p>Sure, Choose Hink brick.</p>', NULL, 'Text', 'Sent', '2024-11-05 12:31:53', '2024-11-05 12:31:53', NULL, NULL),
('CM2024-000000000000243', 'C2024-0000000026', 'U2425-0001602', 'Admin', 'Help to choose the best brand in bricks?', NULL, 'Text', 'Sent', '2024-11-05 12:34:06', '2024-11-05 12:34:06', NULL, NULL),
('CM2024-000000000000244', 'C2024-0000000026', 'Admin', 'U2425-0001602', '<p>Sure, Choose Hink brick.</p>', NULL, 'Text', 'Sent', '2024-11-05 12:34:09', '2024-11-05 12:34:09', NULL, NULL),
('CM2024-000000000000245', 'C2024-0000000026', 'Admin', 'U2425-0001602', 'Tell us your problem, and we\'ll provide the solution', NULL, 'Text', 'Sent', '2024-11-05 12:34:11', '2024-11-05 12:34:11', NULL, NULL),
('CM2024-000000000000246', 'C2024-0000000027', 'U2425-0001602', 'Admin', 'Best cement brand ?', NULL, 'Text', 'Sent', '2024-11-05 12:42:47', '2024-11-05 12:42:47', NULL, NULL),
('CM2024-000000000000247', 'C2024-0000000027', 'Admin', 'U2425-0001602', '<p><strong>Best cement brand ?</strong><br>Chettinad</p>', NULL, 'Text', 'Sent', '2024-11-05 12:42:50', '2024-11-05 12:42:50', NULL, NULL),
('CM2024-000000000000248', 'C2024-0000000027', 'Admin', 'U2425-0001602', NULL, NULL, 'Text', 'Sent', '2024-11-05 12:42:52', '2024-11-05 12:42:52', NULL, NULL),
('CM2024-000000000000249', 'C2024-0000000028', 'U2425-0001602', 'Admin', 'Help to choose the best brand in bricks?', NULL, 'Text', 'Sent', '2024-11-05 12:47:45', '2024-11-05 12:47:45', NULL, NULL),
('CM2024-000000000000250', 'C2024-0000000028', 'Admin', 'U2425-0001602', '<p>Sure, Choose Hink brick.</p>', NULL, 'Text', 'Sent', '2024-11-05 12:47:47', '2024-11-05 12:47:47', NULL, NULL),
('CM2024-000000000000251', 'C2024-0000000028', 'Admin', 'U2425-0001602', 'info.rpcbuildersupply@gmail.com \n 7845327703', NULL, 'Text', 'Sent', '2024-11-05 12:47:49', '2024-11-05 12:47:49', NULL, NULL),
('CM2024-000000000000252', 'C2024-0000000028', 'U2425-0001602', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000028/fea6647daec73449f4fc5755be2fa568.jpg', 'Attachment', 'Sent', '2024-11-05 12:51:59', '2024-11-05 12:51:59', NULL, NULL),
('CM2024-000000000000253', 'C2024-0000000028', 'Admin', 'U2425-0001602', 'Quotation Sent', 'uploads/quotations/RPC-2425-QTN-91.pdf', 'Quotation', 'Sent', '2024-11-09 07:12:52', '2024-11-09 07:12:52', NULL, NULL),
('CM2024-000000000000254', 'C2024-0000000028', 'Admin', 'U2425-0001602', 'Quotation Sent', 'uploads/quotations/RPC-2425-QTN-92.pdf', 'Quotation', 'Sent', '2024-11-09 07:21:37', '2024-11-09 07:21:37', NULL, NULL),
('CM2024-000000000000255', 'C2024-0000000029', 'U2425-0001598', 'Admin', 'Help to choose the best brand in bricks?', NULL, 'Text', 'Sent', '2024-11-09 07:45:26', '2024-11-09 07:45:26', NULL, NULL),
('CM2024-000000000000256', 'C2024-0000000029', 'Admin', 'U2425-0001598', '<p>Sure, Choose Hink brick.</p>', NULL, 'Html', 'Sent', '2024-11-09 07:45:29', '2024-11-09 07:45:29', NULL, NULL),
('CM2024-000000000000257', 'C2024-0000000029', 'U2425-0001598', 'Admin', 'hi', '{}', 'Text', 'Sent', '2024-11-09 07:47:09', '2024-11-09 07:47:09', NULL, NULL),
('CM2024-000000000000258', 'C2024-0000000029', 'U2425-0001598', 'Admin', 'hello', '{}', 'Text', 'Sent', '2024-11-09 07:54:15', '2024-11-09 07:54:15', NULL, NULL),
('CM2024-000000000000259', 'C2024-0000000028', 'Admin', 'U2425-0001602', 'Quotation Sent', 'uploads/quotations/RPC-2425-QTN-93.pdf', 'Quotation', 'Sent', '2024-11-09 08:06:07', '2024-11-09 08:06:07', NULL, NULL);
INSERT INTO `tbl_chat_message` (`SLNO`, `ChatID`, `SendFrom`, `SendTo`, `Message`, `Attachments`, `Type`, `Status`, `CreatedOn`, `DeliveredOn`, `ReadOn`, `DeletedOn`) VALUES
('CM2024-000000000000260', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'Sent Product Details', '[{\"ProductID\":\"P2024-0000226\",\"ProductName\":\"Prime Gold 8mm Steel\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000226/TVbCxdfhlD_20240208150754.png\",\"Description\":\"Prime Gold is a Compared to plain mild steel bars, Prime gold TMT bars offer significantly higher strength, flexibility, and corrosion resistance. The use of the best TMT bars ensures improved structural stability and reduced maintenance requirements\"},{\"ProductID\":\"P2024-0000299\",\"ProductName\":\"Suryadeva 16mm Steel\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000299/ebY2JZ4ZrS_20240209145140.png\",\"Description\":\"Suryadev also follows IS 1786 standards for TMT bars and the IS 2830 standards for the MS Billets. Suryadev TMT undergo a comprehensive 10-step quality control process and have industry-leading physical and chemical properties. They are resistant to extreme heat, corrosion, and seismic pressure.\"},{\"ProductID\":\"P2024-0000202\",\"ProductName\":\"CONPLAST SD110 20 KG\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000202/p9lp4uxaQD_20240122144821.png\",\"Description\":\"Conplast SD110 is a brown liquid which has been formulated for optimum performance as a cement saver under manufacturing conditions encountered in Concrete blocks. Improved formulation helps in both cement dispersion and compaction, maximising the strength obtained from the cement used.\\n\\n \\n\\n Cement saving - strength, density and yield maintained with less cement.  Increased strengths - higher strength without additional cement  Minimises the risk of segregation and bleeding and assists in the production of a dense, close textured surface, improving durability.  Reduction in breakages - reduced breakages through increased ‘green strength’.  Improved production - production cycle time can be reduced allowing more blocks to be produced in a given period.\"},{\"ProductID\":\"P2425-0000043\",\"ProductName\":\"Myk - 793- Epoxy Filler 3.75kg Platinum\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2425-0000043/0bucE2hesX_20240831173318.png\",\"Description\":\"Myk Epoxy Filler 3.75kg Platinum is a high-performance, two-component epoxy filler designed to provide exceptional strength and durability for a variety of construction and repair applications. Here’s a comprehensive description:\\n\\nProduct Overview:\\n\\nMyk Epoxy Filler 3.75kg Platinum is formulated to deliver superior bonding and filling capabilities. With its platinum color, it offers both functionality and an aesthetically pleasing finish, making it suitable for industrial, commercial, and residential use.\\n\\nKey Features:\\n\\n\\n\\tColor: Platinum, providing a modern, sleek appearance that complements a variety of surfaces and finishes.\\n\\tHigh Mechanical Strength: Delivers excellent structural integrity and resistance to physical stress, making it ideal for high-traffic areas and heavy-duty applications.\\n\\tSuperior Adhesion: Bonds strongly to a wide range of substrates, including concrete, metal, wood, and masonry.\\n\\tVersatile Application: Suitable for filling cracks, gaps, and voids, as well as for surface repairs and general maintenance.\\n\\tSmooth Finish: Once cured, the filler provides a smooth, even surface that can be easily sanded, painted, or finished as required.\\n\\tEasy Mixing and Application: The two-component system is straightforward to mix and apply, ensuring reliable performance and ease of use.\\n\\n\\nApplications:\\n\\n\\n\\tSurface Repairs: Ideal for repairing and restoring damaged or worn surfaces, including concrete floors, walls, and structural elements.\\n\\tFilling Gaps and Voids: Effective for filling cracks, holes, and gaps in various substrates to create a seamless surface.\\n\\tGeneral Maintenance: Suitable for maintenance tasks where a durable, high-strength filler is needed.\\n\\n\\nUsage Instructions:\\n\\n\\n\\tPreparation: Ensure the surface to be repaired is clean, dry, and free of any loose material or contaminants.\\n\\tMixing: Combine the two components of Myk Epoxy Filler according to the manufacturer\'s instructions. Mix thoroughly until a uniform consistency and color are achieved.\\n\\tApplication: Apply the mixed filler to the prepared surface using appropriate tools, such as a trowel or putty knife. Smooth the surface to achieve the desired finish.\\n\\tCuring: Allow the filler to cure as per the product’s specifications. Full curing times may vary based on environmental conditions such as temperature and humidity.\\n\\n\\nStorage:\\n\\n\\n\\tConditions: Store in a cool, dry place, away from direct sunlight and moisture.\\n\\tPackaging: Keep containers tightly sealed when not in use to prevent contamination and premature curing.\\n\\n\\nSafety:\\n\\n\\n\\tPrecautions: Follow standard safety guidelines, including wearing protective gloves, eyewear, and ensuring adequate ventilation during application.\\n\\tHandling: Avoid contact with skin and eyes. In case of accidental contact, rinse thoroughly with water and seek medical attention if necessary.\\n\\n\\nTechnical Specifications:\\n\\n\\n\\tPackaging Size: 3.75kg\\n\\tComponent Ratio: As per manufacturer\'s instructions.\\n\\tApplication Tools: Trowel, putty knife, or similar tools.\\n\\n\\nMyk Epoxy Filler 3.75kg Platinum offers a reliable, high-strength solution for a wide range of repair and maintenance tasks, providing both durability and a high-quality finish.\\n\\n\\n\"},{\"ProductID\":\"P2024-0000029\",\"ProductName\":\"Porotherm Bricks\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000029/pSVz5vdngl_20240109153632.png\",\"Description\":\"Porotherm clay bricks are horizontally or vertically perforated clay bricks are manufactured in variety of sizes and the term Porotherm is used due to its desired thermal insulation characteristics.\\n\\nThe perforation of the clay brick provides an exception walling system which facilitates thermal insulation resulting in cooler interiors in hot seasons and warm interior conditions in cold seasons.\\n\\nThe porotherm clay bricks are easy to use, economical, environmentally friendly, and it can be used for the construction of both non-load bearing walls and load bearing walls.\\n\\nPorotherm Clay Blocks are light in weight, energy efficient, fire and sound proof, easy to install, eco-friendly, recyclable product, higher strength to weight ratio, seismic resistance, precision breakages product and used for non-load bearing partition walls.\\n\\nProperties of Porotherm Bricks\\nThe compressive strength is greater than 3.5MPa\\nHigh thermal and sound insulation.\\nLow weight.\\n\\nHigh fire resistance\\nDensity range from 694 to 783 kg/m3\\nLarge in size but light in weight results in low dead load\\nWater absorption is around 15%\"},{\"ProductID\":\"P2024-0000325\",\"ProductName\":\"Berger-HS Power Plasticizer-20L\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000325/9dDxDIHAAv_20240131122153.png\",\"Description\":\"\"}]', 'Products', 'Sent', '2024-11-09 09:43:25', '2024-11-09 09:43:25', NULL, NULL),
('CM2024-000000000000261', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'Sent Product Details', '[{\"ProductID\":\"P2024-0000029\",\"ProductName\":\"Porotherm Bricks\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000029/pSVz5vdngl_20240109153632.png\",\"Description\":\"Porotherm clay bricks are horizontally or vertically perforated clay bricks are manufactured in variety of sizes and the term Porotherm is used due to its desired thermal insulation characteristics.\\n\\nThe perforation of the clay brick provides an exception walling system which facilitates thermal insulation resulting in cooler interiors in hot seasons and warm interior conditions in cold seasons.\\n\\nThe porotherm clay bricks are easy to use, economical, environmentally friendly, and it can be used for the construction of both non-load bearing walls and load bearing walls.\\n\\nPorotherm Clay Blocks are light in weight, energy efficient, fire and sound proof, easy to install, eco-friendly, recyclable product, higher strength to weight ratio, seismic resistance, precision breakages product and used for non-load bearing partition walls.\\n\\nProperties of Porotherm Bricks\\nThe compressive strength is greater than 3.5MPa\\nHigh thermal and sound insulation.\\nLow weight.\\n\\nHigh fire resistance\\nDensity range from 694 to 783 kg/m3\\nLarge in size but light in weight results in low dead load\\nWater absorption is around 15%\"},{\"ProductID\":\"P2024-0000325\",\"ProductName\":\"Berger-HS Power Plasticizer-20L\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000325/9dDxDIHAAv_20240131122153.png\",\"Description\":\"\"}]', 'Products', 'Sent', '2024-11-09 09:44:05', '2024-11-09 09:44:05', NULL, NULL),
('CM2024-000000000000262', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'Quotation Sent', 'uploads/quotations/RPC-2425-QTN-100.pdf', 'Quotation', 'Sent', '2024-11-09 10:26:59', '2024-11-09 10:26:59', NULL, NULL),
('CM2024-000000000000263', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'Quotation Sent', 'uploads/quotations/RPC-2425-QTN-100.pdf', 'Quotation', 'Sent', '2024-11-09 10:27:49', '2024-11-09 10:27:49', NULL, NULL),
('CM2024-000000000000264', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'Quotation Sent', 'uploads/quotations/RPC-2425-QTN-101.pdf', 'Quotation', 'Sent', '2024-11-09 10:32:52', '2024-11-09 10:32:52', NULL, NULL),
('CM2024-000000000000265', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'Quotation Sent', 'uploads/quotations/RPC-2425-QTN-105.pdf', 'Quotation', 'Sent', '2024-11-11 06:18:27', '2024-11-11 06:18:27', NULL, NULL),
('CM2024-000000000000266', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'hi', NULL, 'Text', 'Sent', '2024-11-11 06:18:34', '2024-11-11 06:18:34', NULL, NULL),
('CM2024-000000000000267', 'C2024-0000000028', 'Admin', 'U2425-0001602', 'sent a attachment file', 'uploads/chat/C2024-0000000028/adc3be5fecdc3550c0ae5006dfb16212.jpg', 'Attachment', 'Sent', '2024-11-11 06:36:02', '2024-11-11 06:36:02', NULL, NULL),
('CM2024-000000000000268', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'Quotation Sent', 'uploads/quotations/RPC-2425-QTN-109.pdf', 'Quotation', 'Sent', '2024-11-11 06:58:37', '2024-11-11 06:58:37', NULL, NULL),
('CM2024-000000000000269', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'hi', NULL, 'Text', 'Sent', '2024-11-11 07:01:18', '2024-11-11 07:01:18', NULL, NULL),
('CM2024-000000000000270', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'hellopdr', NULL, 'Text', 'Sent', '2024-11-11 07:01:27', '2024-11-11 07:01:27', NULL, NULL),
('CM2024-000000000000271', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'df', NULL, 'Text', 'Sent', '2024-11-11 07:02:28', '2024-11-11 07:02:28', NULL, NULL),
('CM2024-000000000000272', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'dfdsdscasd', NULL, 'Text', 'Sent', '2024-11-11 07:02:29', '2024-11-11 07:02:29', NULL, NULL),
('CM2024-000000000000273', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'dfdsdscasdasa', NULL, 'Text', 'Sent', '2024-11-11 07:02:29', '2024-11-11 07:02:29', NULL, NULL),
('CM2024-000000000000274', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'dfdsdscasdasassadsad', NULL, 'Text', 'Sent', '2024-11-11 07:02:30', '2024-11-11 07:02:30', NULL, NULL),
('CM2024-000000000000275', 'C2024-0000000029', 'Admin', 'U2425-0001598', 's', NULL, 'Text', 'Sent', '2024-11-11 07:02:33', '2024-11-11 07:02:33', NULL, NULL),
('CM2024-000000000000276', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'ss', NULL, 'Text', 'Sent', '2024-11-11 07:02:33', '2024-11-11 07:02:33', NULL, NULL),
('CM2024-000000000000277', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'ss', NULL, 'Text', 'Sent', '2024-11-11 07:02:33', '2024-11-11 07:02:33', NULL, NULL),
('CM2024-000000000000278', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'ss', NULL, 'Text', 'Sent', '2024-11-11 07:02:34', '2024-11-11 07:02:34', NULL, NULL),
('CM2024-000000000000279', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'ss', NULL, 'Text', 'Sent', '2024-11-11 07:02:35', '2024-11-11 07:02:35', NULL, NULL),
('CM2024-000000000000280', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'd', NULL, 'Text', 'Sent', '2024-11-11 07:02:36', '2024-11-11 07:02:36', NULL, NULL),
('CM2024-000000000000281', 'C2024-0000000029', 'Admin', 'U2425-0001598', 's', NULL, 'Text', 'Sent', '2024-11-11 07:02:38', '2024-11-11 07:02:38', NULL, NULL),
('CM2024-000000000000282', 'C2024-0000000029', 'Admin', 'U2425-0001598', 's', NULL, 'Text', 'Sent', '2024-11-11 07:02:39', '2024-11-11 07:02:39', NULL, NULL),
('CM2024-000000000000283', 'C2024-0000000029', 'Admin', 'U2425-0001598', 's', NULL, 'Text', 'Sent', '2024-11-11 07:02:40', '2024-11-11 07:02:40', NULL, NULL),
('CM2024-000000000000284', 'C2024-0000000029', 'Admin', 'U2425-0001598', 's', NULL, 'Text', 'Sent', '2024-11-11 07:02:41', '2024-11-11 07:02:41', NULL, NULL),
('CM2024-000000000000285', 'C2024-0000000029', 'Admin', 'U2425-0001598', 's', NULL, 'Text', 'Sent', '2024-11-11 07:02:42', '2024-11-11 07:02:42', NULL, NULL),
('CM2024-000000000000286', 'C2024-0000000029', 'Admin', 'U2425-0001598', 's', NULL, 'Text', 'Sent', '2024-11-11 07:02:43', '2024-11-11 07:02:43', NULL, NULL),
('CM2024-000000000000287', 'C2024-0000000029', 'Admin', 'U2425-0001598', 's', NULL, 'Text', 'Sent', '2024-11-11 07:02:44', '2024-11-11 07:02:44', NULL, NULL),
('CM2024-000000000000288', 'C2024-0000000029', 'Admin', 'U2425-0001598', 's', NULL, 'Text', 'Sent', '2024-11-11 07:02:46', '2024-11-11 07:02:46', NULL, NULL),
('CM2024-000000000000289', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'ss', NULL, 'Text', 'Sent', '2024-11-11 07:02:46', '2024-11-11 07:02:46', NULL, NULL),
('CM2024-000000000000290', 'C2024-0000000029', 'Admin', 'U2425-0001598', 's', NULL, 'Text', 'Sent', '2024-11-11 07:02:47', '2024-11-11 07:02:47', NULL, NULL),
('CM2024-000000000000291', 'C2024-0000000029', 'Admin', 'U2425-0001598', 's', NULL, 'Text', 'Sent', '2024-11-11 07:02:48', '2024-11-11 07:02:48', NULL, NULL),
('CM2024-000000000000292', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'sent a attachment file', 'uploads/chat/C2024-0000000029/95d244b8bbb8688aac729fc141959055.pdf', 'Attachment', 'Sent', '2024-11-11 07:02:55', '2024-11-11 07:02:55', NULL, NULL),
('CM2024-000000000000293', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'sent a attachment file', 'uploads/chat/C2024-0000000029/8b0c1df093b9498d746925199898fa64.pdf', 'Attachment', 'Sent', '2024-11-11 07:03:06', '2024-11-11 07:03:06', NULL, NULL),
('CM2024-000000000000294', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'sent a attachment file', 'uploads/chat/C2024-0000000029/79c498b82edb3ddf21a070d3a66efec7.pdf', 'Attachment', 'Sent', '2024-11-11 07:03:15', '2024-11-11 07:03:15', NULL, NULL),
('CM2024-000000000000295', 'C2024-0000000029', 'Admin', 'U2425-0001598', 'Sent Product Details', '[{\"ProductID\":\"P2425-0000056\",\"ProductName\":\"Myk Unsanded Grout 688(Silver shadow 1kg)\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2425-0000056/2ID06VAZ8n_20240831191050.png\",\"Description\":\"Myk Unsanded Grout 688 (Silver Shadow 1kg) is a premium, cement-based grout designed for filling narrow joints between tiles. The Silver Shadow color provides a sleek, subtle finish that complements a wide range of tile designs, making it a popular choice for both residential and commercial projects. Here’s a full description:\\n\\nProduct Overview:\\n\\n\\n\\tBrand: Myk\\n\\tProduct Name: Unsanded Grout 688\\n\\tColor: Silver Shadow (Shade 688)\\n\\tWeight: 1 kg\\n\\tType: Cement-based, unsanded grout\\n\\n\\nKey Features:\\n\\n\\n\\tSmooth Finish: The unsanded formula is ideal for joints less than 1/8 inch (3mm) wide. It provides a smooth, fine texture that is perfect for delicate tiles like polished marble, glass, or porcelain, ensuring no scratching or damage occurs during application.\\n\\tSilver Shadow Color: The Silver Shadow shade is a soft, neutral gray that complements various tile colors and styles, adding a contemporary and elegant touch to tiled surfaces.\\n\\tColor Consistency: Formulated for consistent color throughout the application, ensuring a uniform, professional finish that enhances the overall appearance of the tiled surface.\\n\\tShrinkage Resistance: Designed to minimize shrinkage as it cures, helping to maintain the integrity of the grout lines and preventing cracks or gaps.\\n\\tMold and Mildew Resistance: Contains anti-microbial additives to resist mold and mildew growth, making it suitable for damp areas like bathrooms, kitchens, and other moisture-prone spaces.\\n\\tDurable Bond: Provides strong adhesion and durability, ensuring the grout lines remain intact even in high-traffic areas.\\n\\tEase of Application: The fine, smooth texture of the grout allows for easy application, ensuring that even the smallest joints are completely filled without any voids.\\n\\tVersatile Use: Suitable for a wide range of tile materials, including ceramic, porcelain, glass, and natural stone. It can be used on both walls and floors in various settings.\\n\\n\\nApplication Areas:\\n\\n\\n\\tResidential: Ideal for bathrooms, kitchens, backsplashes, and other tiled areas where a smooth, refined finish is desired.\\n\\tCommercial: Suitable for high-traffic areas in hotels, restaurants, offices, and other commercial environments.\\n\\tDIY Projects: Perfect for homeowners working on tiling projects where precision and a high-quality finish are important.\\n\\n\\n \"},{\"ProductID\":\"P2024-0000309\",\"ProductName\":\"Master Tile 25(20kg)\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000309/DzMEINFAgf_20240125144525.png\",\"Description\":\"MasterTile 25 is a grey cementitious powder containing performance enhancing polymers and other specialty additives. This versatile, easy-to\\u0002handle, cement-based adhesive is perfect for fixing ceramic tiles, quarry tiles and similar materials. It provides strong adhesion to cement/sand screeds, to in-situ/pre-cast and aerated concrete, and brickwork. For external wall application use MasterTile 30\\n\\n \\n\\nWater resistant – suitable for wet areas High adhesive bond strength – suitable for larger tiles Easy to use – just add water on site\\n\\n \\n\\n \"},{\"ProductID\":\"P2024-0000213\",\"ProductName\":\"CONPLAST SP430 G(230KG)\",\"ProductImage\":\"https://builderssupply.in/uploads/master/product/products/P2024-0000213/KY5TfXlPAm_20240122193932.png\",\"Description\":\"RPC is mainly engaged in the field of manufacturing and wholesaling trading of various types of Construction Materials since 2015. Various products range consists of RPC BUILDER SUPPLY, RPC BLUE METALS, RPC CONSTRUCTION SOLUTIONS, RPC DESIGNER & CONSTRUCTION PLANNING and Robotics Bricks and Blocks. These products are widely appreciated for their high purity, user-friendliness, longevity, and low rates. Additionally, we are also offering Architectural and Construction Services to our valued clients. We always maintain on the flawless design of the manufacturing process, verifying quality standards as per customer\'s specification, choice of quality raw materials, good workmanship and quality control at all stages of our manufacturing process. We are engaged in offering CONPLAST SP430 G(230KG) to our clients. Our range of all products is widely appreciated by our clients.\"}]', 'Products', 'Sent', '2024-11-11 09:34:49', '2024-11-11 09:34:49', NULL, NULL),
('CM2024-000000000000296', 'C2024-0000000030', 'U2425-0000035', 'Admin', 'Best cement brand ?', NULL, 'Text', 'Sent', '2024-11-12 06:01:30', '2024-11-12 06:01:30', NULL, NULL),
('CM2024-000000000000297', 'C2024-0000000030', 'Admin', 'U2425-0000035', '<p><strong>Best cement brand ?</strong><br>Chettinad</p>', NULL, 'Html', 'Sent', '2024-11-12 06:01:34', '2024-11-12 06:01:34', NULL, NULL),
('CM2024-000000000000298', 'C2024-0000000031', 'U2425-0001791', 'Admin', 'Best cement brand ?', NULL, 'Text', 'Sent', '2024-11-12 06:41:11', '2024-11-12 06:41:11', NULL, NULL),
('CM2024-000000000000299', 'C2024-0000000031', 'Admin', 'U2425-0001791', '<p><strong>Best cement brand ?</strong><br>Chettinad</p>', NULL, 'Text', 'Sent', '2024-11-12 06:41:14', '2024-11-12 06:41:14', NULL, NULL),
('CM2024-000000000000300', 'C2024-0000000031', 'Admin', 'U2425-0001791', 'Tell us your problem, and we\'ll provide the solution', NULL, 'Text', 'Sent', '2024-11-12 06:41:15', '2024-11-12 06:41:15', NULL, NULL),
('CM2024-000000000000301', 'C2024-0000000031', 'U2425-0001791', 'Admin', 'hello admin', NULL, 'Text', 'Sent', '2024-11-12 06:41:23', '2024-11-12 06:41:23', NULL, NULL),
('CM2024-000000000000302', 'C2024-0000000031', 'U2425-0001791', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000031/e9cfebd3af9dbbd2c00619b5d19dfd25.jpg', 'Attachment', 'Sent', '2024-11-12 06:41:51', '2024-11-12 06:41:51', NULL, NULL),
('CM2024-000000000000303', 'C2024-0000000031', 'U2425-0001791', 'Admin', 'can you solve me this onee', NULL, 'Text', 'Sent', '2024-11-12 06:42:00', '2024-11-12 06:42:00', NULL, NULL),
('CM2024-000000000000304', 'C2024-0000000031', 'U2425-0001791', 'Admin', 'please help me to sort out of this', NULL, 'Text', 'Sent', '2024-11-12 06:42:14', '2024-11-12 06:42:14', NULL, NULL),
('CM2024-000000000000305', 'C2024-0000000031', 'U2425-0001791', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000031/f90127b7cee0fc932cd8c7028a629c0f.pdf', 'Attachment', 'Sent', '2024-11-12 06:42:34', '2024-11-12 06:42:34', NULL, NULL),
('CM2024-000000000000306', 'C2024-0000000030', 'U2425-0000035', 'Admin', 'vsi quality m sand', NULL, 'Text', 'Sent', '2024-11-14 09:03:38', '2024-11-14 09:03:38', NULL, NULL),
('CM2024-000000000000307', 'C2024-0000000030', 'Admin', 'U2425-0000035', 'hii', NULL, 'Text', 'Sent', '2024-11-14 09:04:20', '2024-11-14 09:04:20', NULL, NULL),
('CM2024-000000000000308', 'C2024-0000000028', 'U2425-0001602', 'Admin', 'ffg', NULL, 'Text', 'Sent', '2024-11-19 04:18:02', '2024-11-19 04:18:02', NULL, NULL),
('CM2024-000000000000309', 'C2024-0000000028', 'U2425-0001602', 'Admin', 'sent a attachment file', 'uploads/chat/C2024-0000000028/f1241e1bdcba2fb3834070d62f970e00.pdf', 'Attachment', 'Sent', '2024-11-19 04:18:23', '2024-11-19 04:18:23', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_support`
--

CREATE TABLE `tbl_support` (
  `SupportID` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `UserID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Subject` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `SupportType` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `TicketFor` enum('Vendor','Customer') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Priority` enum('Low','Medium','High') COLLATE utf8mb4_general_ci DEFAULT 'Low',
  `Status` enum('New','Opened','Closed') COLLATE utf8mb4_general_ci DEFAULT 'New',
  `DFlag` int DEFAULT '0',
  `CreatedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedOn` timestamp NULL DEFAULT NULL,
  `DeletedOn` timestamp NULL DEFAULT NULL,
  `CreatedBy` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `UpdatedBy` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DeletedBy` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB ;

--
-- Dumping data for table `tbl_support`
--

INSERT INTO `tbl_support` (`SupportID`, `UserID`, `Subject`, `SupportType`, `TicketFor`, `Priority`, `Status`, `DFlag`, `CreatedOn`, `UpdatedOn`, `DeletedOn`, `CreatedBy`, `UpdatedBy`, `DeletedBy`) VALUES
('S2425-00000034', 'U2425-0000004', 'No products available', 'ST2023-00004', 'Customer', 'Low', 'New', 0, '2024-04-10 04:08:51', NULL, NULL, 'U2425-0000004', NULL, NULL),
('S2425-00000035', 'U2425-0000008', 'not authorized', 'ST2023-00002', 'Vendor', 'Low', 'New', 0, '2024-04-10 04:49:39', NULL, NULL, 'U2425-0000008', NULL, NULL),
('S2425-00000036', 'U2425-0000023', 'test support', 'ST2023-00004', 'Customer', 'High', 'New', 0, '2024-04-11 13:27:38', NULL, NULL, 'U2425-0000023', NULL, NULL),
('S2425-00000037', 'U2425-0000010', 'long time one images loading', 'ST2023-00003', 'Vendor', 'High', 'Closed', 0, '2024-04-12 05:27:38', '2024-04-12 05:28:04', NULL, 'U2023-0000002', 'U2023-0000002', NULL),
('S2425-00000038', 'U2425-0000016', 'Billing problem', 'ST2023-00002', 'Customer', 'Medium', 'Closed', 0, '2024-04-12 05:30:29', '2024-04-12 05:31:46', NULL, 'U2023-0000002', 'U2023-0000002', NULL),
('S2425-00000039', 'U2425-0000028', 'Technical side issuse', 'ST2023-00003', 'Vendor', 'Medium', 'Closed', 0, '2024-04-12 10:32:31', '2024-04-12 10:34:18', NULL, 'U2023-0000002', 'U2023-0000002', NULL),
('S2425-00000040', 'U2425-0000265', 'Log in failed', 'ST2023-00003', 'Customer', 'Medium', 'New', 0, '2024-05-23 05:31:45', NULL, NULL, 'U2425-0000265', NULL, NULL),
('S2425-00000041', 'U2425-0000403', 'approved vendor', 'ST2023-00003', 'Vendor', 'Low', 'Opened', 0, '2024-05-23 06:16:55', '2024-05-23 08:59:32', NULL, 'U2425-0000403', NULL, NULL),
('S2425-00000042', 'U2425-0000406', 'service issue', 'ST2023-00004', 'Vendor', 'High', 'Opened', 0, '2024-05-23 09:21:03', '2024-05-23 09:26:34', NULL, 'U2425-0000406', NULL, NULL),
('S2425-00000043', 'U2425-0000076', 'order not received', 'ST2023-00004', 'Customer', 'High', 'Opened', 0, '2024-05-23 09:40:19', '2024-05-23 09:41:23', NULL, 'U2425-0000076', NULL, NULL),
('S2425-00000044', 'U2425-0000021', 'receipt error', 'ST2023-00003', 'Vendor', 'Medium', 'Opened', 0, '2024-08-15 11:43:08', NULL, NULL, 'U2023-0000002', NULL, NULL),
('S2425-00000045', 'U2425-0001420', 'Login issue', 'ST2023-00003', 'Customer', 'High', 'Opened', 0, '2024-09-12 06:40:45', '2024-09-12 06:42:11', NULL, 'U2425-0001420', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_support_details`
--

CREATE TABLE `tbl_support_details` (
  `SLNO` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `UserID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `SupportID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Description` longtext COLLATE utf8mb4_general_ci,
  `DeliveryStatus` int NOT NULL DEFAULT '0',
  `ReadStatus` int NOT NULL DEFAULT '0',
  `DFlag` int DEFAULT '0',
  `CreatedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedOn` timestamp NULL DEFAULT NULL,
  `DeletedOn` timestamp NULL DEFAULT NULL,
  `CreatedBy` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `UpdatedBy` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DeletedBy` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB ;

--
-- Dumping data for table `tbl_support_details`
--

INSERT INTO `tbl_support_details` (`SLNO`, `UserID`, `SupportID`, `Description`, `DeliveryStatus`, `ReadStatus`, `DFlag`, `CreatedOn`, `UpdatedOn`, `DeletedOn`, `CreatedBy`, `UpdatedBy`, `DeletedBy`) VALUES
('SD2425-00000086', 'U2425-0000004', 'S2425-00000034', 'No products available in my location what to do', 0, 0, 0, '2024-04-10 04:08:51', NULL, NULL, 'U2425-0000004', NULL, NULL),
('SD2425-00000087', 'U2425-0000004', 'S2425-00000034', 'Is there any advancements in this issue?', 0, 0, 0, '2024-04-10 04:13:56', NULL, NULL, 'U2425-0000004', NULL, NULL),
('SD2425-00000088', 'U2425-0000008', 'S2425-00000035', 'not authorized', 0, 0, 0, '2024-04-10 04:49:39', NULL, NULL, 'U2425-0000008', NULL, NULL),
('SD2425-00000089', 'U2425-0000008', 'S2425-00000035', 'fixed', 0, 0, 0, '2024-04-10 04:50:19', NULL, NULL, 'U2425-0000008', NULL, NULL),
('SD2425-00000090', 'U2425-0000008', 'S2425-00000035', 'hello', 0, 0, 0, '2024-04-10 04:50:44', NULL, NULL, 'U2425-0000008', NULL, NULL),
('SD2425-00000091', 'U2425-0000023', 'S2425-00000036', NULL, 0, 0, 0, '2024-04-11 13:27:38', NULL, NULL, 'U2425-0000023', NULL, NULL),
('SD2425-00000092', 'U2425-0000023', 'S2425-00000036', 'test', 0, 0, 0, '2024-04-11 13:34:47', NULL, NULL, 'U2425-0000023', NULL, NULL),
('SD2425-00000093', 'U2023-0000002', 'S2425-00000037', 'Images not preview', 0, 0, 0, '2024-04-12 05:27:38', NULL, NULL, 'U2023-0000002', NULL, NULL),
('SD2425-00000094', 'U2023-0000002', 'S2425-00000038', 'Billing page loaded in few hours', 0, 0, 0, '2024-04-12 05:30:29', NULL, NULL, 'U2023-0000002', NULL, NULL),
('SD2425-00000095', 'U2023-0000002', 'S2425-00000038', 'Ok.sir i will update you check sir', 0, 0, 0, '2024-04-12 05:31:05', NULL, NULL, 'U2023-0000002', NULL, NULL),
('SD2425-00000096', 'U2023-0000002', 'S2425-00000039', 'very slow in the website', 0, 0, 0, '2024-04-12 10:32:31', NULL, NULL, 'U2023-0000002', NULL, NULL),
('SD2425-00000097', 'U2023-0000002', 'S2425-00000039', 'wifi speed issuse', 0, 0, 0, '2024-04-12 10:33:33', NULL, NULL, 'U2023-0000002', NULL, NULL),
('SD2425-00000098', 'U2425-0000004', 'S2425-00000034', NULL, 0, 0, 0, '2024-04-13 07:31:20', NULL, NULL, 'U2425-0000004', NULL, NULL),
('SD2425-00000099', 'U2425-0000265', 'S2425-00000040', 'Login issue', 0, 0, 0, '2024-05-23 05:31:45', NULL, NULL, 'U2425-0000265', NULL, NULL),
('SD2425-00000100', 'U2425-0000403', 'S2425-00000041', 'dummy discription', 0, 0, 0, '2024-05-23 06:16:55', NULL, NULL, 'U2425-0000403', NULL, NULL),
('SD2425-00000101', 'U2425-0000403', 'S2425-00000041', 'hloo', 0, 0, 0, '2024-05-23 06:17:10', NULL, NULL, 'U2425-0000403', NULL, NULL),
('SD2425-00000102', 'U2023-0000001', 'S2425-00000041', 'sollunga enna problem?', 0, 0, 0, '2024-05-23 08:57:15', NULL, NULL, 'U2023-0000001', NULL, NULL),
('SD2425-00000103', 'U2425-0000403', 'S2425-00000041', 'testingg', 0, 0, 0, '2024-05-23 08:57:52', NULL, NULL, 'U2425-0000403', NULL, NULL),
('SD2425-00000104', 'U2023-0000001', 'S2425-00000041', 'testing reply from admin', 0, 0, 0, '2024-05-23 08:58:28', NULL, NULL, 'U2023-0000001', NULL, NULL),
('SD2425-00000105', 'U2023-0000001', 'S2425-00000041', 'testing reply from admin', 0, 0, 0, '2024-05-23 08:59:32', NULL, NULL, 'U2023-0000001', NULL, NULL),
('SD2425-00000106', 'U2425-0000406', 'S2425-00000042', 'test', 0, 0, 0, '2024-05-23 09:21:03', NULL, NULL, 'U2425-0000406', NULL, NULL),
('SD2425-00000107', 'U2023-0000001', 'S2425-00000042', 'test reply', 0, 0, 0, '2024-05-23 09:21:56', NULL, NULL, 'U2023-0000001', NULL, NULL),
('SD2425-00000108', 'U2425-0000406', 'S2425-00000042', 'hi', 0, 0, 0, '2024-05-23 09:25:09', NULL, NULL, 'U2425-0000406', NULL, NULL),
('SD2425-00000109', 'U2023-0000001', 'S2425-00000042', 'test 1', 0, 0, 0, '2024-05-23 09:26:34', NULL, NULL, 'U2023-0000001', NULL, NULL),
('SD2425-00000110', 'U2425-0000076', 'S2425-00000043', 'test', 0, 0, 0, '2024-05-23 09:40:19', NULL, NULL, 'U2425-0000076', NULL, NULL),
('SD2425-00000111', 'U2023-0000001', 'S2425-00000043', 'test', 0, 0, 0, '2024-05-23 09:41:22', NULL, NULL, 'U2023-0000001', NULL, NULL),
('SD2425-00000112', 'U2425-0000076', 'S2425-00000043', 'test', 0, 0, 0, '2024-05-23 09:50:59', NULL, NULL, 'U2425-0000076', NULL, NULL),
('SD2425-00000113', 'U2425-0000076', 'S2425-00000043', 'rr', 0, 0, 0, '2024-05-23 10:22:35', NULL, NULL, 'U2425-0000076', NULL, NULL),
('SD2425-00000114', 'U2023-0000002', 'S2425-00000044', 'Qquotation & Receipt error', 0, 0, 0, '2024-08-15 11:43:08', NULL, NULL, 'U2023-0000002', NULL, NULL),
('SD2425-00000115', 'U2425-0001420', 'S2425-00000045', 'unable to login the user app', 0, 0, 0, '2024-09-12 06:40:45', NULL, NULL, 'U2425-0001420', NULL, NULL),
('SD2425-00000116', 'U2023-0000002', 'S2425-00000045', 'Its working fine. Praba', 0, 0, 0, '2024-09-12 06:42:11', NULL, NULL, 'U2023-0000002', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_attachment`
--
ALTER TABLE `tbl_attachment`
  ADD PRIMARY KEY (`AttachmentID`),
  ADD KEY `AttachmentID` (`AttachmentID`,`ReferID`,`Module`);

--
-- Indexes for table `tbl_chat`
--
ALTER TABLE `tbl_chat`
  ADD PRIMARY KEY (`ChatID`);

--
-- Indexes for table `tbl_chat_message`
--
ALTER TABLE `tbl_chat_message`
  ADD PRIMARY KEY (`SLNO`);

--
-- Indexes for table `tbl_support`
--
ALTER TABLE `tbl_support`
  ADD PRIMARY KEY (`SupportID`),
  ADD KEY `SupportID` (`SupportID`,`UserID`,`Subject`,`Priority`,`Status`,`CreatedBy`,`UpdatedBy`,`DeletedBy`);

--
-- Indexes for table `tbl_support_details`
--
ALTER TABLE `tbl_support_details`
  ADD PRIMARY KEY (`SLNO`),
  ADD KEY `SLNO` (`SLNO`,`UserID`,`SupportID`,`CreatedBy`,`UpdatedBy`,`DeletedBy`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
