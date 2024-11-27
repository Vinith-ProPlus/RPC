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
-- Database: `builderssupply_tmp`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `ProductID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Slug` varchar(160) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ProductName` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ProductType` enum('Simple','Variable') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Simple',
  `ProductCode` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Stages` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `HSNSAC` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `SCID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `UID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `TaxType` enum('Exclude','Include') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Exclude',
  `TaxID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PRate` double DEFAULT '0',
  `SRate` double DEFAULT '0',
  `MinQty` double DEFAULT '0',
  `MaxQty` double NOT NULL DEFAULT '0',
  `RelatedProducts` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `Decimals` enum('auto','0','1','2','3','4','5','6','7','8','9') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'auto',
  `Description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `ShortDescription` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `Attributes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `Images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `ProductBrochure` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `VideoURL` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `gallery` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `ActiveStatus` enum('Active','Inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Active',
  `DFlag` int DEFAULT '0',
  `CreatedOn` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `UpdatedOn` timestamp NULL DEFAULT NULL,
  `UpdatedBy` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DeletedOn` timestamp NULL DEFAULT NULL,
  `DeletedBy` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB ;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`ProductID`, `Slug`, `ProductName`, `ProductType`, `ProductCode`, `Stages`, `HSNSAC`, `CID`, `SCID`, `UID`, `TaxType`, `TaxID`, `PRate`, `SRate`, `MinQty`, `MaxQty`, `RelatedProducts`, `Decimals`, `Description`, `ShortDescription`, `Attributes`, `Images`, `ProductBrochure`, `VideoURL`, `gallery`, `ActiveStatus`, `DFlag`, `CreatedOn`, `CreatedBy`, `UpdatedOn`, `UpdatedBy`, `DeletedOn`, `DeletedBy`) VALUES
('P2024-0000051', 'ultratech-opc-cement-50kg', 'Ultratech OPC Cement 50kg', 'Simple', 'RPC CU6877', 'a:1:{i:0;s:14:\"SG2024-0000001\";}', '2523', 'PC2023-0000001', 'PSC2024-0000035', 'UOM2023-0000003', 'Include', 'TX2024-0000004', 480, 460, 0, 0, 'N;', 'auto', '<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Ultratech cement is a top-quality building material. It is strong, durable, and reliable. Perfect for construction projects. Ultratech cement is known for its high quality. It lasts a long time. It&#39;s a reliable choice for all construction projects, ensuring long-lasting performance. Builders and architects trust it. With Ultratech cement, you can trust that your structures will stand strong against the test of time. It is &nbsp;great for residential and commercial use. Ultratech cement is made using advanced technology. It&#39;s innovative and reliable. Choose Ultratech cement for your next project. You&#39;ll be satisfied with the results. Get Ultratech cement from RPC Builders Supply.</span></span></p>', '<p>RPC is mainly engaged in the field of manufacturing and wholesaling trading of various types of Construction Materials since 2015. Various products range consists of RPC BUILDER SUPPLY, RPC BLUE METALS, RPC CONSTRUCTION SOLUTIONS, RPC DESIGNER &amp; CONSTRUCTION PLANNING and Robotics Bricks and Blocks. These products are widely appreciated for their high purity, user-friendliness, longevity, and low rates. Additionally, we are also offering Architectural and Construction Services to our valued clients. We always maintain on the flawless design of the manufacturing process, verifying quality standards as per customer&#39;s specification, choice of quality raw materials, good workmanship and quality control at all stages of our manufacturing process. We are engaged in offering Ultratech OPC Cement to our clients. Our range of all products is widely appreciated by our clients.</p>', 'a:3:{s:14:\"AT2024-0000005\";a:2:{s:11:\"isVariation\";b:0;s:4:\"data\";a:0:{}}s:14:\"AT2024-0000006\";a:2:{s:11:\"isVariation\";b:0;s:4:\"data\";a:0:{}}s:14:\"AT2024-0000004\";a:2:{s:11:\"isVariation\";b:0;s:4:\"data\";a:0:{}}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'https://youtube.com/shorts/Lz8ljTvDrf4?si=bLq-M4xJN8Q1Xycx', 'a:2:{s:19:\"Ide5155d0-059ad1-a3\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000051/gallery/bfe3ef1d826841a2d32f6848135829d2.jpg\";s:8:\"fileName\";s:36:\"bfe3ef1d826841a2d32f6848135829d2.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Ide5155d0-059ad1-a3\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Id0f4127e-f7c7d3-ca\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000051/gallery/11a4ddeafc140bc44e1e526a6464ae7b.jpg\";s:8:\"fileName\";s:36:\"11a4ddeafc140bc44e1e526a6464ae7b.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Id0f4127e-f7c7d3-ca\";s:5:\"pType\";s:12:\"main-gallery\";}}}', 'Active', 0, '2024-11-26 05:08:30', 'U2023-0000002', NULL, NULL, NULL, NULL),
('P2024-0000062', 'chettinad-opc', 'Chettinad OPC', 'Simple', 'RPC CC6891', 'a:1:{i:0;s:14:\"SG2024-0000001\";}', NULL, 'PC2023-0000001', 'PSC2024-0000036', 'UOM2023-0000003', 'Exclude', 'TX2024-0000004', 500, 420, 0, 0, 'N;', 'auto', '<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Chettinad OPC (Ordinary Portland Cement) is a popular cement brand in India, known for its high-quality and durability. Here are some key features and benefits:</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Key Features:</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">1. High compressive strength</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">2. Excellent durability and resistance to chemical attacks</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">3. Suitable for general construction, including buildings, bridges, and roads</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">4. Meets IS 269:2015 standards</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Benefits:</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">1. Ensures strong and durable structures</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">2. Resistant to cracking and shrinkage</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">3. Easy to mix and apply</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">4. Cost-effective</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Applications:</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">1. Building foundations</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">2. Bridge construction</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">3. Road construction</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">4. General concrete works</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">5. Masonry works</span></span></p>', '<p>RPC is mainly engaged in the field of manufacturing and wholesaling trading of various types of Construction Materials since 2015. Various products range consists of RPC BUILDER SUPPLY, RPC BLUE METALS, RPC CONSTRUCTION SOLUTIONS, RPC DESIGNER &amp; CONSTRUCTION PLANNING and Robotics Bricks and Blocks. These products are widely appreciated for their high purity, user-friendliness, longevity, and low rates. Additionally, we are also offering Architectural and Construction Services to our valued clients. We always maintain on the flawless design of the manufacturing process, verifying quality standards as per customer&#39;s specification, choice of quality raw materials, good workmanship and quality control at all stages of our manufacturing process. We are engaged in offering Chettinad OPC Cement to our clients. Our range of all products is widely appreciated by our clients.</p>', 'a:0:{}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', NULL, 'a:6:{s:19:\"If751eee4-27f271-bb\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000062/gallery/142e2ff5e3503bea24511b23ea4b4797.jpg\";s:8:\"fileName\";s:36:\"142e2ff5e3503bea24511b23ea4b4797.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"If751eee4-27f271-bb\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I7fa0f8c9-5b9148-d7\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000062/gallery/88458f333c0067b699bc61f82d6bf0a6.jpg\";s:8:\"fileName\";s:36:\"88458f333c0067b699bc61f82d6bf0a6.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I7fa0f8c9-5b9148-d7\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I1795f5a6-ed7147-4c\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000062/gallery/00e9273bd6e04e25402d87cec32d9ff8.jpg\";s:8:\"fileName\";s:36:\"00e9273bd6e04e25402d87cec32d9ff8.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I1795f5a6-ed7147-4c\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I990ca4c6-50463f-a3\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000062/gallery/ce5d4f13ecb0c74e40baeaa7bf3cd1af.jpg\";s:8:\"fileName\";s:36:\"ce5d4f13ecb0c74e40baeaa7bf3cd1af.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I990ca4c6-50463f-a3\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I7ca696b9-2348bb-e6\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000062/gallery/36ccc9e31b69fac4da9c143ad786393f.jpg\";s:8:\"fileName\";s:36:\"36ccc9e31b69fac4da9c143ad786393f.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I7ca696b9-2348bb-e6\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I4d39dcd2-6079d7-42\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000062/gallery/1037143da930b58c1c1a5ab3db70ebe3.jpg\";s:8:\"fileName\";s:36:\"1037143da930b58c1c1a5ab3db70ebe3.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I4d39dcd2-6079d7-42\";s:5:\"pType\";s:12:\"main-gallery\";}}}', 'Active', 0, '2024-11-26 05:42:20', 'U2023-0000002', NULL, NULL, NULL, NULL),
('P2024-0000063', 'chettinad-ppc', 'Chettinad PPC', 'Simple', 'RPC CC6892', 'a:1:{i:0;s:14:\"SG2024-0000001\";}', '2523', 'PC2023-0000001', 'PSC2024-0000036', 'UOM2023-0000003', 'Exclude', 'TX2024-0000004', 530, 410, 0, 0, 'N;', 'auto', '<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">Chettinad PPC (Portland Pozzolana Cement) is a popular cement brand in India, known for its high-quality and durability. Here are some key features and benefits:</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">Key Features:</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">1. Blended cement with fly ash and limestone</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">2. High compressive strength</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">3. Enhanced durability and resistance to chemical attacks</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">4. Suitable for general construction, including buildings, bridges, and roads</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">5. Meets IS 1489:1991 standards</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">Benefits:</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">1. Improved workability and finish</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">2. Reduced heat of hydration</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">3. Increased resistance to sulfate and chloride attacks</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">4. Environmentally friendly (utilizes industrial waste)</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">5. Cost-effective</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">Applications:</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">1. Building foundations</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">2. Bridge construction</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">3. Road construction</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">4. General concrete works</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">5. Masonry works</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">6. Marine structures</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">7. High-rise buildings</span></span></span></span></p>', '<p>RPC is mainly engaged in the field of manufacturing and wholesaling trading of various types of Construction Materials since 2015. Various products range consists of RPC BUILDER SUPPLY, RPC BLUE METALS, RPC CONSTRUCTION SOLUTIONS, RPC DESIGNER &amp; CONSTRUCTION PLANNING and Robotics Bricks and Blocks. These products are widely appreciated for their high purity, user-friendliness, longevity, and low rates. Additionally, we are also offering Architectural and Construction Services to our valued clients. We always maintain on the flawless design of the manufacturing process, verifying quality standards as per customer&#39;s specification, choice of quality raw materials, good workmanship and quality control at all stages of our manufacturing process. We are engaged in offering Chettinad PPC cement&nbsp; to our clients. Our range of all products is widely appreciated by our clients.</p>', 'a:3:{s:14:\"AT2024-0000006\";a:2:{s:11:\"isVariation\";b:0;s:4:\"data\";a:0:{}}s:14:\"AT2024-0000005\";a:2:{s:11:\"isVariation\";b:0;s:4:\"data\";a:0:{}}s:14:\"AT2024-0000004\";a:2:{s:11:\"isVariation\";b:0;s:4:\"data\";a:0:{}}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'https://youtu.be/9u0t91ZPH74?si=Zs_VD0wnJGYenQbV', 'a:5:{s:19:\"I2b61d899-ef662b-75\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000063/gallery/03a5a4cc73bb8696af65de55900264dd.jpg\";s:8:\"fileName\";s:36:\"03a5a4cc73bb8696af65de55900264dd.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I2b61d899-ef662b-75\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Ib00bf203-99d7f1-bd\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000063/gallery/f65017599e6bb16d5c26017a9bc9810f.jpg\";s:8:\"fileName\";s:36:\"f65017599e6bb16d5c26017a9bc9810f.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Ib00bf203-99d7f1-bd\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I67d992b2-f3fec5-92\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000063/gallery/6634eb9d9f0d450f9b93a8fccd93be6f.jpg\";s:8:\"fileName\";s:36:\"6634eb9d9f0d450f9b93a8fccd93be6f.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I67d992b2-f3fec5-92\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Iee381792-b65cbf-9c\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000063/gallery/f22e25a479a7efc36c5fe510d2c24320.jpg\";s:8:\"fileName\";s:36:\"f22e25a479a7efc36c5fe510d2c24320.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Iee381792-b65cbf-9c\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I00268777-f97363-23\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000063/gallery/686110a19b46f3b3fafdb525bc391198.jpg\";s:8:\"fileName\";s:36:\"686110a19b46f3b3fafdb525bc391198.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I00268777-f97363-23\";s:5:\"pType\";s:12:\"main-gallery\";}}}', 'Active', 0, '2024-11-26 05:45:37', 'U2023-0000002', NULL, NULL, NULL, NULL),
('P2024-0000065', 'chetinad-supercrete', 'Chetinad Supercrete', 'Simple', 'RPC CC6894', 'a:1:{i:0;s:14:\"SG2024-0000001\";}', NULL, 'PC2023-0000001', 'PSC2024-0000036', 'UOM2023-0000003', 'Exclude', 'TX2024-0000004', 560, 520, 0, 0, 'N;', 'auto', '<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Chettinad Super Crete Cement is a premium cement brand from Chettinad Cement Corporation, designed for high-performance concrete applications. Here are its key features and benefits:</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Key Features:</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">1. High-strength cement (53 Grade)</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">2. Blended cement with superior quality fly ash and limestone</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">3. Enhanced durability and resistance to chemical attacks</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">4. Improved workability and finish</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">5. Low heat of hydration</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">6. Meets IS 12269:2013 standards</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Benefits:</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">1. High compressive strength (up to 60 MPa)</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">2. Excellent durability and longevity</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">3. Improved resistance to sulfate, chloride, and silica attacks</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">4. Reduced shrinkage and cracking</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">5. Enhanced concrete workability and finish</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">6. Suitable for high-rise buildings, bridges, and infrastructure projects</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Applications:</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">1. High-rise buildings</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">2. Bridges and flyovers</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">3. Infrastructure projects (roads, highways, etc.)</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">4. Industrial structures (warehouses, factories, etc.)</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">5. Marine structures</span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">6. Precast concrete applications</span></span></p>', '<p>RPC is mainly engaged in the field of manufacturing and wholesaling trading of various types of Construction Materials since 2015. Various products range consists of RPC BUILDER SUPPLY, RPC BLUE METALS, RPC CONSTRUCTION SOLUTIONS, RPC DESIGNER &amp; CONSTRUCTION PLANNING and Robotics Bricks and Blocks. These products are widely appreciated for their high purity, user-friendliness, longevity, and low rates. Additionally, we are also offering Architectural and Construction Services to our valued clients. We always maintain on the flawless design of the manufacturing process, verifying quality standards as per customer&#39;s specification, choice of quality raw materials, good workmanship and quality control at all stages of our manufacturing process. We are engaged in offering Chetinad Supercrete Cement to our clients. Our range of all products is widely appreciated by our clients.</p>', 'a:3:{s:14:\"AT2024-0000006\";a:2:{s:11:\"isVariation\";b:0;s:4:\"data\";a:0:{}}s:14:\"AT2024-0000004\";a:2:{s:11:\"isVariation\";b:0;s:4:\"data\";a:0:{}}s:14:\"AT2024-0000005\";a:2:{s:11:\"isVariation\";b:0;s:4:\"data\";a:0:{}}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'a:2:{s:9:\"isDeleted\";i:1;s:4:\"data\";a:0:{}}', 'https://youtu.be/9u0t91ZPH74?si=Zs_VD0wnJGYenQbV', 'a:4:{s:19:\"I24d1186a-30d315-67\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000065/gallery/fcce938fa185f2835f97ce2c6ea69003.jpg\";s:8:\"fileName\";s:36:\"fcce938fa185f2835f97ce2c6ea69003.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I24d1186a-30d315-67\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I68a4ccf6-dc80a5-cf\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000065/gallery/46b108f0ddc2964567c2116fd3c8d77a.webp\";s:8:\"fileName\";s:37:\"46b108f0ddc2964567c2116fd3c8d77a.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I68a4ccf6-dc80a5-cf\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I6921b832-ad474e-6f\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000065/gallery/35af4a128b45f73b19285b4097ada203.jpg\";s:8:\"fileName\";s:36:\"35af4a128b45f73b19285b4097ada203.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I6921b832-ad474e-6f\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I4f91c92a-a750a0-62\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000065/gallery/896edf66c68b5abb3029616adbd38956.webp\";s:8:\"fileName\";s:37:\"896edf66c68b5abb3029616adbd38956.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I4f91c92a-a750a0-62\";s:5:\"pType\";s:12:\"main-gallery\";}}}', 'Active', 0, '2024-11-26 05:48:40', 'U2023-0000002', NULL, NULL, NULL, NULL),
('P2024-0000067', 'chetinad-maxcrete', 'Chetinad Maxcrete', 'Simple', 'RPC CC6895', 'a:1:{i:0;s:14:\"SG2024-0000001\";}', '2523', 'PC2023-0000001', 'PSC2425-0000024', 'UOM2023-0000003', 'Exclude', 'TX2024-0000004', 520, 500, 0, 0, 'N;', 'auto', '<p>Chettinad Maxcrete Cement is a premium-grade cement that attains a remarkable setting pace of 53 MPa within 28 days, making it an excellent choice for RCC and pre-stressed concrete of higher grades. It is also well-suited for cement grouts and instant plugging mortars.</p>', '<p>RPC is mainly engaged in the field of manufacturing and wholesaling trading of various types of Construction Materials since 2015. Various products range consists of RPC BUILDER SUPPLY, RPC BLUE METALS, RPC CONSTRUCTION SOLUTIONS, RPC DESIGNER &amp; CONSTRUCTION PLANNING and Robotics Bricks and Blocks. These products are widely appreciated for their high purity, user-friendliness, longevity, and low rates. Additionally, we are also offering Architectural and Construction Services to our valued clients. We always maintain on the flawless design of the manufacturing process, verifying quality standards as per customer&#39;s specification, choice of quality raw materials, good workmanship and quality control at all stages of our manufacturing process. We are engaged in offering Chetinad Maxcrete Cement to our clients. Our range of all products is widely appreciated by our clients.</p>', 'a:0:{}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'https://youtu.be/9u0t91ZPH74?si=Zs_VD0wnJGYenQbV', 'a:4:{s:19:\"Ie0d1f72d-cbd2fb-bc\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000067/gallery/fff6d016f4dce91057d009d4eac8142e.webp\";s:8:\"fileName\";s:37:\"fff6d016f4dce91057d009d4eac8142e.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Ie0d1f72d-cbd2fb-bc\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I9b4d0c7d-6a514c-4f\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000067/gallery/36343ea474918a993e38fdd8ce4a44c7.webp\";s:8:\"fileName\";s:37:\"36343ea474918a993e38fdd8ce4a44c7.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I9b4d0c7d-6a514c-4f\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I2e771799-07c0da-6a\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000067/gallery/3bdc01b45347042f0c8b75efdc245b30.jpg\";s:8:\"fileName\";s:36:\"3bdc01b45347042f0c8b75efdc245b30.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I2e771799-07c0da-6a\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Iaac7be35-949001-c9\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000067/gallery/a3da7deb28dfee47ed970ac36f22f7ce.jpg\";s:8:\"fileName\";s:36:\"a3da7deb28dfee47ed970ac36f22f7ce.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Iaac7be35-949001-c9\";s:5:\"pType\";s:12:\"main-gallery\";}}}', 'Active', 0, '2024-11-26 06:03:28', 'U2023-0000002', NULL, NULL, NULL, NULL),
('P2024-0000070', 'kcp-rapid-cement-50kg', 'KCP Rapid Cement 50kg', 'Simple', 'RPC CK7000', 'a:1:{i:0;s:14:\"SG2024-0000001\";}', '2523', 'PC2023-0000001', 'PSC2024-0000037', 'UOM2023-0000003', 'Exclude', 'TX2024-0000004', 500, 420, 0, 0, 'N;', 'auto', '<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">KCP Rapid Cement is a specialty cement from KCP Limited, designed for rapid construction and high-performance applications. Here are its key features and benefits:</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">Key Features:</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">1. Rapid-setting cement (sets in 15-20 minutes)</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">2. High early strength development</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">3. Improved durability and resistance to chemical attacks</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">4. Low heat of hydration</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">5. Meets IS 8041:1990 standards</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">Benefits:</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">1. Faster construction and reduced project timelines</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">2. Increased productivity and efficiency</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">3. Improved concrete workability and finish</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">4. Enhanced durability and longevity</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">5. Suitable for critical infrastructure projects</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">Applications:</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">1. Rapid repair and maintenance works</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">2. High-speed railway projects</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">3. Expressway construction</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">4. Bridge repair and construction</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">5. Industrial flooring and pavements</span></span></span></h1>\n\n<h1><span style=\"font-size:24pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\"><span style=\"font-size:12.0pt\">6. Precast concrete applications</span></span></span></h1>', '<p>RPC is mainly engaged in the field of manufacturing and wholesaling trading of various types of Construction Materials since 2015. Various products range consists of RPC BUILDER SUPPLY, RPC BLUE METALS, RPC CONSTRUCTION SOLUTIONS, RPC DESIGNER &amp; CONSTRUCTION PLANNING and Robotics Bricks and Blocks. These products are widely appreciated for their high purity, user-friendliness, longevity, and low rates. Additionally, we are also offering Architectural and Construction Services to our valued clients. We always maintain on the flawless design of the manufacturing process, verifying quality standards as per customer&#39;s specification, choice of quality raw materials, good workmanship and quality control at all stages of our manufacturing process. We are engaged in offering<strong> KCP Radip Cement</strong> to our clients. Our range of all products is widely appreciated by our clients.</p>', 'a:3:{s:14:\"AT2024-0000006\";a:2:{s:11:\"isVariation\";b:0;s:4:\"data\";a:0:{}}s:14:\"AT2024-0000004\";a:2:{s:11:\"isVariation\";b:0;s:4:\"data\";a:0:{}}s:14:\"AT2024-0000005\";a:2:{s:11:\"isVariation\";b:0;s:4:\"data\";a:0:{}}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'https://youtu.be/9u0t91ZPH74?si=Zs_VD0wnJGYenQbV', 'a:5:{s:19:\"I832d8c1b-91b75d-40\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000070/gallery/72723c992df66a9ee11376cd6ab9c4ad.jpeg\";s:8:\"fileName\";s:37:\"72723c992df66a9ee11376cd6ab9c4ad.jpeg\";s:3:\"ext\";s:4:\"jpeg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I832d8c1b-91b75d-40\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I749b28ad-f739d0-be\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000070/gallery/837e5862d98849d566c9256c75bbdaf4.png\";s:8:\"fileName\";s:36:\"837e5862d98849d566c9256c75bbdaf4.png\";s:3:\"ext\";s:3:\"png\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I749b28ad-f739d0-be\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Ia8294319-35d446-52\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000070/gallery/263121453266ce602a9930995969577f.png\";s:8:\"fileName\";s:36:\"263121453266ce602a9930995969577f.png\";s:3:\"ext\";s:3:\"png\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Ia8294319-35d446-52\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I95a8c5c6-eb59ca-b3\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000070/gallery/d109928b010700a38a19626429f07e33.jpeg\";s:8:\"fileName\";s:37:\"d109928b010700a38a19626429f07e33.jpeg\";s:3:\"ext\";s:4:\"jpeg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I95a8c5c6-eb59ca-b3\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Id06491af-eac5dc-e6\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000070/gallery/972de8a9022024a2c877fd79b227fed0.png\";s:8:\"fileName\";s:36:\"972de8a9022024a2c877fd79b227fed0.png\";s:3:\"ext\";s:3:\"png\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Id06491af-eac5dc-e6\";s:5:\"pType\";s:12:\"main-gallery\";}}}', 'Active', 0, '2024-11-26 06:15:00', 'U2023-0000002', NULL, NULL, NULL, NULL),
('P2024-0000317', 'ultratech-super-cement-50-kg', 'Ultratech Super Cement - 50 KG', 'Simple', NULL, 'a:1:{i:0;s:14:\"SG2024-0000001\";}', NULL, 'PC2023-0000001', 'PSC2024-0000035', 'UOM2023-0000003', 'Include', 'TX2023-0000001', 370, 350, 0, 0, 'N;', 'auto', '<ul>\n	<li>UltraTech Super is designed to provide rapid construction, quick removal of shuttering/form work, sustainable construction, higher coverage, and smoother finishing to your work.</li>\n	<li>Since it is a blended cement, it has a lower carbon footprint than OPC 53. It is a sustainable product which helps in reduction of emissions from carbon dioxide and greenhouse gases. While being sustainable, it is also a durable cement that provides the best quality work.&nbsp;</li>\n	<li>UltraTech Super is appropriate for use in all phases and types of construction. From foundation, footing, brickwork, stonemasonry, block walls, concrete in slab, beam, or column, plastering, to tile laying.&nbsp;</li>\n</ul>', '<p>UltraTech Super is designed to provide rapid construction, quick removal of shuttering/form work, sustainable construction, higher coverage, and smoother finishing to your work.</p>', 'a:1:{s:14:\"AT2023-0000002\";a:2:{s:11:\"isVariation\";b:0;s:4:\"data\";a:0:{}}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'a:2:{s:9:\"isDeleted\";i:1;s:4:\"data\";a:0:{}}', NULL, 'a:0:{}', 'Active', 0, '2024-11-26 05:19:24', 'U2023-0000002', NULL, NULL, NULL, NULL),
('P2024-0000332', 'rmc-m10pcc', 'RMC M10(PCC)', 'Simple', 'RPC RMC6826', 'a:1:{i:0;s:14:\"SG2024-0000001\";}', '38245010', 'PC2024-0000005', 'PSC2024-0000134', 'UOM2024-0000006', 'Include', 'TX2023-0000002', 5200, 5300, 0, 0, 'N;', 'auto', '<p>We can supply ready mix concrete with VSI quality used materials for design mix of concrete.<br />\nOn time delivery<br />\nSuperior quality of mix&nbsp;<br />\nEconomical in cost<br />\nHigher retention time with good workability<br />\nof concrete<br />\nHigher Compressive strength&nbsp;<br />\nConsistency of mix is maintained.<br />\n<br />\nSupplying Areas&nbsp;</p>\n\n<ul>\n	<li>Erode</li>\n	<li>Karur</li>\n	<li>Namakkal</li>\n	<li>Dharapuram&nbsp;</li>\n	<li>Kangeyam</li>\n	<li>Sivagiri</li>\n	<li>Pallipalayam</li>\n	<li>Bhavani</li>\n</ul>', '<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">RMC M10 (Plain Cement Concrete) is a type of Ready-Mix Concrete (RMC) with a specific mix design. Here&#39;s an overview:</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">Mix Design:</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">- Grade: M10</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">- Type: Plain Cement Concrete (PCC)</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">- Composition:</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">&nbsp;&nbsp;&nbsp; - Cement: Ordinary Portland Cement (OPC)</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">&nbsp;&nbsp;&nbsp; - Fine Aggregate: Sand</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">&nbsp;&nbsp;&nbsp; - Coarse Aggregate: None (or limited)</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">&nbsp;&nbsp;&nbsp; - Water: Potable water</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">&nbsp;&nbsp;&nbsp; - Admixtures: None (or minimal)</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">Properties:</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">- Compressive Strength: 10 MPa (1450 psi) at 28 days</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">- Workability: Low to moderate</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">- Durability: Moderate</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">- Slump Value: 25-50 mm</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">Applications:</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">- Foundations (shallow)</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">- Footings</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">- Pavements (light traffic)</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">- Floorings (residential)</span></span></span></span></p>\n\n<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\"><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">- Non-structural elements (e.g., sidewalks, patios)</span></span></span></span></p>', 'a:0:{}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'https://youtu.be/BVj9bh7I3Dk', 'a:6:{s:19:\"I9675e25f-7cdcef-ad\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000332/gallery/fbfcf9bf2fc02e2f901721290155a772.jpg\";s:8:\"fileName\";s:36:\"fbfcf9bf2fc02e2f901721290155a772.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I9675e25f-7cdcef-ad\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I07ec48ea-13e83f-cf\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000332/gallery/05066fc33c0703f51cea9956436679bf.jpg\";s:8:\"fileName\";s:36:\"05066fc33c0703f51cea9956436679bf.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I07ec48ea-13e83f-cf\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I5a82e7d2-9e4812-0e\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000332/gallery/a724667666882fdd0d6f711d5ea8778d.webp\";s:8:\"fileName\";s:37:\"a724667666882fdd0d6f711d5ea8778d.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I5a82e7d2-9e4812-0e\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Iaefc30fc-2c5405-97\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000332/gallery/a6d2c5dd3301bf3c6fc82443e49eb125.jpg\";s:8:\"fileName\";s:36:\"a6d2c5dd3301bf3c6fc82443e49eb125.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Iaefc30fc-2c5405-97\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Ic4570693-3f69b5-a3\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000332/gallery/bc75d5fc08e97cdb17812e86ae00d22e.jpg\";s:8:\"fileName\";s:36:\"bc75d5fc08e97cdb17812e86ae00d22e.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Ic4570693-3f69b5-a3\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I5e9f6e55-ea1235-e5\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000332/gallery/4bccc4e693275be6760d1f253ba6d086.webp\";s:8:\"fileName\";s:37:\"4bccc4e693275be6760d1f253ba6d086.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I5e9f6e55-ea1235-e5\";s:5:\"pType\";s:12:\"main-gallery\";}}}', 'Active', 0, '2024-11-26 06:23:13', 'U2023-0000002', NULL, NULL, NULL, NULL);
INSERT INTO `tbl_products` (`ProductID`, `Slug`, `ProductName`, `ProductType`, `ProductCode`, `Stages`, `HSNSAC`, `CID`, `SCID`, `UID`, `TaxType`, `TaxID`, `PRate`, `SRate`, `MinQty`, `MaxQty`, `RelatedProducts`, `Decimals`, `Description`, `ShortDescription`, `Attributes`, `Images`, `ProductBrochure`, `VideoURL`, `gallery`, `ActiveStatus`, `DFlag`, `CreatedOn`, `CreatedBy`, `UpdatedOn`, `UpdatedBy`, `DeletedOn`, `DeletedBy`) VALUES
('P2024-0000333', 'rmc-m75', 'RMC M7.5', 'Simple', 'RPC RMC6827', 'a:1:{i:0;s:14:\"SG2024-0000001\";}', '38245010', 'PC2024-0000005', 'PSC2024-0000134', 'UOM2024-0000009', 'Include', 'TX2023-0000002', 3900, 3900, 0, 0, 'N;', 'auto', '<p>We can supply ready mix concrete with VSI quality used materials for design mix of concrete.<br />\nOn time delivery<br />\nSuperior quality of mix&nbsp;<br />\nEconomical in cost<br />\nHigher retention time with good workability<br />\nof concrete<br />\nHigher Compressive strength&nbsp;<br />\nConsistency of mix is maintained.<br />\n<br />\nSupplying Areas&nbsp;</p>\n\n<ul>\n	<li>Erode</li>\n	<li>Karur</li>\n	<li>Namakkal</li>\n	<li>Dharapuram&nbsp;</li>\n	<li>Kangeyam</li>\n	<li>Sivagiri</li>\n	<li>Pallipalayam</li>\n	<li>Bhavani</li>\n</ul>', '<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">RMC M7.5 PCC Mix Proportion:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Cement: 1 part</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Sand: 4-5 parts</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Water: 0.45-0.55 parts</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Admixtures (optional): As recommended by manufacturer</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Note: Mix proportions may vary depending on regional availability of materials and specific project requirements.</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Considerations:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- M7.5 is a relatively low-strength mix, suitable for non-structural applications.</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- May require additional cement content for improved durability.</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Not suitable for high-traffic or load-bearing applications.</span></span></p>', 'a:0:{}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'https://youtu.be/BVj9bh7I3Dk', 'a:6:{s:19:\"If642e79e-c51b06-1e\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000333/gallery/4d2d52fc9bbc8532ba16b97cfc200d28.webp\";s:8:\"fileName\";s:37:\"4d2d52fc9bbc8532ba16b97cfc200d28.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"If642e79e-c51b06-1e\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Idfe15b25-ec459d-40\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000333/gallery/06b74c1516e4483b8d492ea9db9a3092.webp\";s:8:\"fileName\";s:37:\"06b74c1516e4483b8d492ea9db9a3092.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Idfe15b25-ec459d-40\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I8361ae13-89fa28-c6\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000333/gallery/53a932591bda44399413c8d3dd8ebceb.webp\";s:8:\"fileName\";s:37:\"53a932591bda44399413c8d3dd8ebceb.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I8361ae13-89fa28-c6\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Iaffb1413-283955-c8\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000333/gallery/92cbf0a67dc161240664ea277c6ce04f.webp\";s:8:\"fileName\";s:37:\"92cbf0a67dc161240664ea277c6ce04f.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Iaffb1413-283955-c8\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I5611bdbb-bd5f69-27\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000333/gallery/40caae6821a6fe580072463a98c23bb5.webp\";s:8:\"fileName\";s:37:\"40caae6821a6fe580072463a98c23bb5.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I5611bdbb-bd5f69-27\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"If8b17b4d-d57819-fa\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000333/gallery/97106a589fefe914545cc2dd5e91fabd.webp\";s:8:\"fileName\";s:37:\"97106a589fefe914545cc2dd5e91fabd.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"If8b17b4d-d57819-fa\";s:5:\"pType\";s:12:\"main-gallery\";}}}', 'Active', 0, '2024-11-26 06:26:10', 'U2023-0000002', NULL, NULL, NULL, NULL),
('P2024-0000334', 'rmc-m15', 'RMC M15', 'Simple', 'RPC RMC6828', 'a:1:{i:0;s:14:\"SG2024-0000001\";}', '38245010', 'PC2024-0000005', 'PSC2024-0000134', 'UOM2024-0000009', 'Include', 'TX2023-0000002', 4900, 4900, 0, 0, 'N;', 'auto', '<p>We can supply ready mix concrete with VSI quality used materials for design mix of concrete.<br />\nOn time delivery<br />\nSuperior quality of mix&nbsp;<br />\nEconomical in cost<br />\nHigher retention time with good workability<br />\nof concrete<br />\nHigher Compressive strength&nbsp;<br />\nConsistency of mix is maintained.<br />\n<br />\nSupplying Areas&nbsp;</p>\n\n<ul>\n	<li>Erode</li>\n	<li>Karur</li>\n	<li>Namakkal</li>\n	<li>Dharapuram&nbsp;</li>\n	<li>Kangeyam</li>\n	<li>Sivagiri</li>\n	<li>Pallipalayam</li>\n	<li>Bhavani</li>\n</ul>', '<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">RMC M15 (Plain Cement Concrete) is a type of Ready-Mix Concrete with a specific mix design, characterized by:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Mix Design:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Grade: M15</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Type: Plain Cement Concrete (PCC)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Composition:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Cement: Ordinary Portland Cement (OPC)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Fine Aggregate: Sand</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Coarse Aggregate: 10-20 mm crushed aggregate</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Water: Potable water</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Admixtures: None (or minimal)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Properties:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Compressive Strength: 15 MPa (2175 psi) at 28 days</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Workability: Moderate</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Durability: Moderate to high</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Slump Value: 50-75 mm</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Applications:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Foundations (medium-depth)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Footings</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Pavements (medium-traffic)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Floorings (commercial, medium-traffic)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Beams and columns (small-scale)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Structural elements (residential buildings)</span></span></p>', 'a:0:{}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'https://youtu.be/BVj9bh7I3Dk', 'a:4:{s:19:\"Ia9ce3969-b44c57-24\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000334/gallery/0814e0b67f1ca18d7cd1bef283472125.jpg\";s:8:\"fileName\";s:36:\"0814e0b67f1ca18d7cd1bef283472125.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Ia9ce3969-b44c57-24\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I968c0d2f-da49b0-49\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000334/gallery/737db67ca3a73e7d58ce709d1f1860ef.webp\";s:8:\"fileName\";s:37:\"737db67ca3a73e7d58ce709d1f1860ef.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I968c0d2f-da49b0-49\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I5fd4d525-c09868-14\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000334/gallery/02adddc9a6351224bcd7ec4eb25cd9d4.webp\";s:8:\"fileName\";s:37:\"02adddc9a6351224bcd7ec4eb25cd9d4.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I5fd4d525-c09868-14\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Ib5d3b217-eb20c2-44\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000334/gallery/0e3c91faf599e5beb9591f53654a85bc.jpg\";s:8:\"fileName\";s:36:\"0e3c91faf599e5beb9591f53654a85bc.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Ib5d3b217-eb20c2-44\";s:5:\"pType\";s:12:\"main-gallery\";}}}', 'Active', 0, '2024-11-26 06:28:36', 'U2023-0000002', NULL, NULL, NULL, NULL),
('P2024-0000335', 'rmc-m20', 'RMC M20', 'Simple', 'RPC RMC6829', 'a:1:{i:0;s:14:\"SG2024-0000002\";}', '38245010', 'PC2024-0000005', 'PSC2024-0000134', 'UOM2024-0000006', 'Include', 'TX2023-0000002', 4200, 4200, 0, 0, 'N;', 'auto', '<p>We can supply ready mix concrete with VSI quality used materials for design mix of concrete.<br />\nOn time delivery<br />\nSuperior quality of mix&nbsp;<br />\nEconomical in cost<br />\nHigher retention time with good workability<br />\nof concrete<br />\nHigher Compressive strength&nbsp;<br />\nConsistency of mix is maintained.<br />\n<br />\nSupplying Areas&nbsp;</p>\n\n<ul>\n	<li>Erode</li>\n	<li>Karur</li>\n	<li>Namakkal</li>\n	<li>Dharapuram&nbsp;</li>\n	<li>Kangeyam</li>\n	<li>Sivagiri</li>\n	<li>Pallipalayam</li>\n	<li>Bhavani</li>\n	<li>Tiruppur etc</li>\n</ul>', '<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">RMC M20 (Plain Cement Concrete) is a type of Ready-Mix Concrete with a specific mix design, characterized by:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Mix Design:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Grade: M20</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Type: Plain Cement Concrete (PCC)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Composition:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Cement: Ordinary Portland Cement (OPC) or Portland Pozzolana Cement (PPC)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Fine Aggregate: Sand</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Coarse Aggregate: 20-40 mm crushed aggregate</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Water: Potable water</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp; &nbsp;&nbsp;- Admixtures: None (or minimal)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Properties:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Compressive Strength: 20 MPa (2900 psi) at 28 days</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Workability: High</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Durability: High</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Slump Value: 75-100 mm</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Applications:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- High-rise buildings</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Infrastructure projects (bridges, flyovers, etc.)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Heavy-traffic pavements</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Industrial floorings</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Structural elements (columns, beams, etc.)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Foundation for heavy machinery</span></span></p>', 'a:0:{}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'https://youtu.be/BVj9bh7I3Dk', 'a:4:{s:19:\"I4434629f-7289a1-94\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000335/gallery/8d1c8272824c87ec88d140ac403dd1d0.jpg\";s:8:\"fileName\";s:36:\"8d1c8272824c87ec88d140ac403dd1d0.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I4434629f-7289a1-94\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I5867ce83-000531-ba\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000335/gallery/1dbbd0aa1f0cf4f5dd4c3306ba01693d.webp\";s:8:\"fileName\";s:37:\"1dbbd0aa1f0cf4f5dd4c3306ba01693d.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I5867ce83-000531-ba\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Ie4bc4b2f-91a81a-21\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000335/gallery/0856d9872f7a02640cb302ec725b6454.webp\";s:8:\"fileName\";s:37:\"0856d9872f7a02640cb302ec725b6454.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Ie4bc4b2f-91a81a-21\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I66b3e6cf-b68ae4-fd\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000335/gallery/da823170297bb12099c962f0baf4e3c7.png\";s:8:\"fileName\";s:36:\"da823170297bb12099c962f0baf4e3c7.png\";s:3:\"ext\";s:3:\"png\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I66b3e6cf-b68ae4-fd\";s:5:\"pType\";s:12:\"main-gallery\";}}}', 'Active', 0, '2024-11-26 06:31:40', 'U2023-0000002', NULL, NULL, NULL, NULL),
('P2024-0000336', 'rpc-m25', 'RPC M25', 'Simple', 'RPC RMC6830', 'a:1:{i:0;s:14:\"SG2024-0000002\";}', '38245010', 'PC2024-0000005', 'PSC2024-0000134', 'UOM2024-0000009', 'Include', 'TX2023-0000002', 3500, 3500, 0, 0, 'N;', 'auto', '<p>We can supply ready mix concrete with VSI quality used materials for design mix of concrete.<br />\nOn time delivery<br />\nSuperior quality of mix&nbsp;<br />\nEconomical in cost<br />\nHigher retention time with good workability<br />\nof concrete<br />\nHigher Compressive strength&nbsp;<br />\nConsistency of mix is maintained.<br />\n<br />\nSupplying Areas&nbsp;</p>\n\n<ul>\n	<li>Erode</li>\n	<li>Karur</li>\n	<li>Namakkal</li>\n	<li>Dharapuram&nbsp;</li>\n	<li>Kangeyam</li>\n	<li>Sivagiri</li>\n	<li>Pallipalayam</li>\n	<li>Bhavani</li>\n</ul>', '<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Mix Design:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Grade: M25</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Type: Ready-Mix Concrete (RMC)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Composition:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Cement: Ordinary Portland Cement (OPC) or Portland Pozzolana Cement (PPC)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Fine Aggregate: Sand</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Coarse Aggregate: 20-40 mm crushed aggregate</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Water: Potable water</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Admixtures: Retarding, air-entraining, or superplasticizing agents</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Properties:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Compressive Strength: 25 MPa (3625 psi) at 28 days</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Workability: High</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Durability: High</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Slump Value: 100-120 mm</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Applications:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- High-rise buildings (above 10 floors)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Infrastructure projects (bridges, flyovers, highways)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Heavy-traffic pavements</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Industrial floorings</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Structural elements (columns, beams, etc.)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Foundation for heavy machinery</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Specialized applications (nuclear power plants, etc.)</span></span></p>', 'a:0:{}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'https://youtu.be/BVj9bh7I3Dk', 'a:5:{s:19:\"I00d46eef-4947df-70\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000336/gallery/48d2e2f1c80b203c75ac519626cecd45.jpg\";s:8:\"fileName\";s:36:\"48d2e2f1c80b203c75ac519626cecd45.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I00d46eef-4947df-70\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Ic82d31a1-2cfd24-0d\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000336/gallery/0cd29e1cf4ecbc731741e56620d559a1.webp\";s:8:\"fileName\";s:37:\"0cd29e1cf4ecbc731741e56620d559a1.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Ic82d31a1-2cfd24-0d\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I1f995b18-5f645f-77\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000336/gallery/2d5b76a275d9757ab57106e09b59487c.webp\";s:8:\"fileName\";s:37:\"2d5b76a275d9757ab57106e09b59487c.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I1f995b18-5f645f-77\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I9a976567-95e12e-0e\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000336/gallery/e8854b223340601b09e206c549658680.webp\";s:8:\"fileName\";s:37:\"e8854b223340601b09e206c549658680.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I9a976567-95e12e-0e\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I6af1f40d-72986d-cf\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000336/gallery/b91a2c2562bd955ff8e9ea4ac2350880.webp\";s:8:\"fileName\";s:37:\"b91a2c2562bd955ff8e9ea4ac2350880.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I6af1f40d-72986d-cf\";s:5:\"pType\";s:12:\"main-gallery\";}}}', 'Active', 0, '2024-11-26 06:34:07', 'U2023-0000002', NULL, NULL, NULL, NULL),
('P2024-0000337', 'rmc-m30', 'RMC M30', 'Simple', 'RPC RMC6831', 'a:1:{i:0;s:14:\"SG2024-0000002\";}', '38245010', 'PC2024-0000005', 'PSC2024-0000134', 'UOM2024-0000009', 'Include', 'TX2023-0000002', 3800, 3800, 0, 0, 'N;', 'auto', '<p>We can supply ready mix concrete with VSI quality used materials for design mix of concrete.<br />\nOn time delivery<br />\nSuperior quality of mix&nbsp;<br />\nEconomical in cost<br />\nHigher retention time with good workability<br />\nof concrete<br />\nHigher Compressive strength&nbsp;<br />\nConsistency of mix is maintained.<br />\n<br />\nSupplying Areas&nbsp;</p>\n\n<ul>\n	<li>Erode</li>\n	<li>Karur</li>\n	<li>Namakkal</li>\n	<li>Dharapuram&nbsp;</li>\n	<li>Kangeyam</li>\n	<li>Sivagiri</li>\n	<li>Pallipalayam</li>\n	<li>Bhavani</li>\n</ul>', '<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">RMC M30 (Ready-Mix Concrete) is a high-strength concrete mix design, characterized by:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Mix Design:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Grade: M30</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Type: Ready-Mix Concrete (RMC)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Composition:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Cement: High-strength Ordinary Portland Cement (OPC) or Portland Pozzolana Cement (PPC)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Fine Aggregate: Sand</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Coarse Aggregate: 20-40 mm crushed aggregate</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Water: Potable water</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Admixtures: Retarding, air-entraining, or superplasticizing agents</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Properties:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Compressive Strength: 30 MPa (4350 psi) at 28 days</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Workability: High</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Durability: High</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Slump Value: 120-150 mm</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Applications:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- High-rise buildings (above 20 floors)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Infrastructure projects (highways, bridges, flyovers)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Heavy-traffic pavements</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Industrial floorings</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Structural elements (columns, beams, etc.)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Foundation for heavy machinery</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Specialized applications (nuclear power plants, etc.)</span></span></p>', 'a:0:{}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'https://youtu.be/BVj9bh7I3Dk', 'a:5:{s:19:\"Idf7fd932-814562-a0\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000337/gallery/c96e69d8452185bde614df786af8012d.jpg\";s:8:\"fileName\";s:36:\"c96e69d8452185bde614df786af8012d.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Idf7fd932-814562-a0\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Ie1d10be6-c29c51-80\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000337/gallery/375cc6ae11750c66bf2fa63c056426b7.webp\";s:8:\"fileName\";s:37:\"375cc6ae11750c66bf2fa63c056426b7.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Ie1d10be6-c29c51-80\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Ie42a0621-75eb45-87\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000337/gallery/1effff0cf9863aef8c2b7e57a7d85e08.webp\";s:8:\"fileName\";s:37:\"1effff0cf9863aef8c2b7e57a7d85e08.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Ie42a0621-75eb45-87\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"If7094dce-adb47a-4d\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000337/gallery/e04dedc8ae906e0900b75d5b6b679f49.webp\";s:8:\"fileName\";s:37:\"e04dedc8ae906e0900b75d5b6b679f49.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"If7094dce-adb47a-4d\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Ieef60bd6-53572b-ad\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000337/gallery/810dafb974d7715ef5d6f61e6ee7d3e2.jpg\";s:8:\"fileName\";s:36:\"810dafb974d7715ef5d6f61e6ee7d3e2.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Ieef60bd6-53572b-ad\";s:5:\"pType\";s:12:\"main-gallery\";}}}', 'Active', 0, '2024-11-26 06:48:54', 'U2023-0000002', NULL, NULL, NULL, NULL),
('P2024-0000338', 'rmc-m4050designmix', 'RMC M40-50(Designmix)', 'Simple', 'RPC RMC6832', 'a:1:{i:0;s:14:\"SG2024-0000002\";}', '38245010', 'PC2024-0000005', 'PSC2024-0000134', 'UOM2024-0000006', 'Include', 'TX2023-0000002', 6000, 6000, 0, 0, 'N;', 'auto', '<p>We can supply ready mix concrete with VSI quality used materials for design mix of concrete.<br />\nOn time delivery<br />\nSuperior quality of mix&nbsp;<br />\nEconomical in cost<br />\nHigher retention time with good workability<br />\nof concrete<br />\nHigher Compressive strength&nbsp;<br />\nConsistency of mix is maintained.<br />\n<br />\nSupplying Areas&nbsp;</p>\n\n<ul>\n	<li>Erode</li>\n	<li>Karur</li>\n	<li>Namakkal</li>\n	<li>Dharapuram&nbsp;</li>\n	<li>Kangeyam</li>\n	<li>Sivagiri</li>\n	<li>Pallipalayam</li>\n	<li>Bhavani</li>\n</ul>', '<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">RMC M40-50 (Design Mix) is a high-performance, specialized concrete mix design, characterized by:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Mix Design:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Grade: M40-50</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Type: Design Mix (customized)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Composition:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Cement: High-strength Ordinary Portland Cement (OPC) or Portland Pozzolana Cement (PPC)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Fine Aggregate: Sand (selected grades)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Coarse Aggregate: 20-40 mm crushed aggregate (selected grades)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Water: Potable water</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">&nbsp;&nbsp;&nbsp; - Admixtures: Advanced retarding, air-entraining, or superplasticizing agents</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Properties:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Compressive Strength: 40-50 MPa (5800-7250 psi) at 28 days</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Workability: High</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Durability: Extremely high</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Slump Value: 150-180 mm</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">Applications:</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- High-rise buildings (above 30 floors)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Complex infrastructure projects (long-span bridges, high-speed rail)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Heavy-traffic pavements</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Industrial floorings (high-bay warehouses)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Structural elements (columns, beams, etc.)</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Foundation for heavy machinery</span></span></p>\n\n<p><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;\">- Specialized applications (nuclear power plants, etc.)</span></span></p>', 'a:0:{}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'a:2:{s:9:\"isDeleted\";i:0;s:4:\"data\";a:0:{}}', 'https://youtu.be/BVj9bh7I3Dk', 'a:3:{s:19:\"Id843c4fc-3255c5-53\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000338/gallery/8289eb3140f0994b5ed698daf4ada8ba.jpg\";s:8:\"fileName\";s:36:\"8289eb3140f0994b5ed698daf4ada8ba.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Id843c4fc-3255c5-53\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"Ib8a279b0-fa6654-a3\";a:4:{s:10:\"uploadPath\";s:90:\"uploads/master/product/products/P2024-0000338/gallery/10b6d1ed8842ec3a9dbf4930694d31bc.jpg\";s:8:\"fileName\";s:36:\"10b6d1ed8842ec3a9dbf4930694d31bc.jpg\";s:3:\"ext\";s:3:\"jpg\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"Ib8a279b0-fa6654-a3\";s:5:\"pType\";s:12:\"main-gallery\";}}s:19:\"I76f20d11-4b2656-5b\";a:4:{s:10:\"uploadPath\";s:91:\"uploads/master/product/products/P2024-0000338/gallery/4456cf3a2cd6417403c0a8f98f7f5f06.webp\";s:8:\"fileName\";s:37:\"4456cf3a2cd6417403c0a8f98f7f5f06.webp\";s:3:\"ext\";s:4:\"webp\";s:9:\"referData\";a:3:{s:6:\"isTemp\";i:0;s:5:\"imgID\";s:19:\"I76f20d11-4b2656-5b\";s:5:\"pType\";s:12:\"main-gallery\";}}}', 'Active', 0, '2024-11-26 06:50:30', 'U2023-0000002', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products_variation`
--

CREATE TABLE `tbl_products_variation` (
  `VariationID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `UUID` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ProductID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `Title` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PRate` double DEFAULT '0',
  `SRate` double DEFAULT '0',
  `Images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `Attributes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `CombinationID` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `DFlag` int DEFAULT '0',
  `CreatedOn` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `UpdatedOn` timestamp NULL DEFAULT NULL,
  `UpdatedBy` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DeletedOn` timestamp NULL DEFAULT NULL,
  `DeletedBy` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_save_status`
--

CREATE TABLE `tbl_product_save_status` (
  `UserID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Percentage` double DEFAULT '0'
) ENGINE=InnoDB ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tmp_table_log`
--

CREATE TABLE `tbl_tmp_table_log` (
  `TranDate` date DEFAULT NULL,
  `TableName` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendors`
--

CREATE TABLE `tbl_vendors` (
  `VendorID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `VendorName` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `VendorCoName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `VendorCoWebsite` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `Reference` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `GSTNo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PCategories` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `VendorType` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `MobileNumber1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `MobileNumber2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `PostalCode` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CityID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `TalukID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DistrictID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `StateID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CountryID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Logo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `CreatedOn` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB ;

--
-- Dumping data for table `tbl_vendors`
--

INSERT INTO `tbl_vendors` (`VendorID`, `VendorName`, `VendorCoName`, `VendorCoWebsite`, `Reference`, `GSTNo`, `PCategories`, `VendorType`, `Email`, `MobileNumber1`, `MobileNumber2`, `Address`, `PostalCode`, `CityID`, `TalukID`, `DistrictID`, `StateID`, `CountryID`, `Logo`, `CreatedOn`) VALUES
('V2425-00000006', NULL, NULL, NULL, NULL, NULL, NULL, 'ST2023-0000003', NULL, '9876543210', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-03 09:59:15'),
('V2425-00000033', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '9876543208', '8326282738', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-16 10:50:54'),
('V2425-00000145', NULL, NULL, NULL, NULL, NULL, NULL, 'ST2023-0000004', NULL, '9629398901', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:38:43'),
('V2425-00000146', NULL, NULL, NULL, NULL, NULL, NULL, 'ST2023-0000002', NULL, '3834427722', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-26 11:12:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendors_service_locations`
--

CREATE TABLE `tbl_vendors_service_locations` (
  `SNo` int NOT NULL,
  `VendorID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ServiceBy` enum('District','PostalCode','Radius') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'PostalCode',
  `Range` int DEFAULT NULL,
  `PostalCodeID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DistrictID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `StateID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreatedOn` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB ;

--
-- Dumping data for table `tbl_vendors_service_locations`
--

INSERT INTO `tbl_vendors_service_locations` (`SNo`, `VendorID`, `ServiceBy`, `Range`, `PostalCodeID`, `DistrictID`, `StateID`, `CreatedOn`) VALUES
(72, 'V2425-00000146', 'District', NULL, NULL, 'DT2023-00000514', 'S2020-00000035', '2024-04-26 11:12:32'),
(73, 'V2425-00000146', 'District', NULL, NULL, 'DT2023-00000490', 'S2020-00000035', '2024-04-26 11:12:33'),
(75, 'V2425-00000145', 'PostalCode', NULL, 'PC2023-0015249', 'DT2023-00000497', 'S2020-00000035', '2024-04-26 11:38:43'),
(76, 'V2425-00000145', 'PostalCode', NULL, 'PC2023-0015246', 'DT2023-00000497', 'S2020-00000035', '2024-04-26 11:38:43'),
(77, 'V2425-00000145', 'PostalCode', NULL, 'PC2023-0015281', 'DT2023-00000497', 'S2020-00000035', '2024-04-26 11:38:43'),
(78, 'V2425-00000145', 'PostalCode', NULL, 'PC2023-0015260', 'DT2023-00000497', 'S2020-00000035', '2024-04-26 11:38:43'),
(79, 'V2425-00000145', 'PostalCode', NULL, 'PC2023-0015248', 'DT2023-00000497', 'S2020-00000035', '2024-04-26 11:38:43'),
(80, 'V2425-00000145', 'PostalCode', NULL, 'PC2023-0015242', 'DT2023-00000497', 'S2020-00000035', '2024-04-26 11:38:43'),
(81, 'V2425-00000145', 'PostalCode', NULL, 'PC2023-0015262', 'DT2023-00000497', 'S2020-00000035', '2024-04-26 11:38:43'),
(82, 'V2425-00000145', 'PostalCode', NULL, 'PC2023-0015264', 'DT2023-00000497', 'S2020-00000035', '2024-04-26 11:38:43'),
(83, 'V2425-00000145', 'PostalCode', NULL, 'PC2023-0015285', 'DT2023-00000497', 'S2020-00000035', '2024-04-26 11:38:43'),
(84, 'V2425-00000145', 'PostalCode', NULL, 'PC2023-0015252', 'DT2023-00000497', 'S2020-00000035', '2024-04-26 11:38:43'),
(87, 'V2425-00000006', 'District', NULL, NULL, 'DT2023-00000497', 'S2020-00000035', '2024-05-03 09:59:15'),
(88, 'V2425-00000006', 'District', NULL, NULL, 'DT2023-00000500', 'S2020-00000035', '2024-05-03 09:59:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendors_stock_point`
--

CREATE TABLE `tbl_vendors_stock_point` (
  `SNo` int NOT NULL,
  `UUID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `VendorID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PointName` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CompleteAddress` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `Latitude` double DEFAULT NULL,
  `Longitude` double DEFAULT NULL,
  `Address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `PostalID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CityID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `TalukID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DistrictID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `StateID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CountryID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `MapData` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `CreatedOn` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB ;

--
-- Dumping data for table `tbl_vendors_stock_point`
--

INSERT INTO `tbl_vendors_stock_point` (`SNo`, `UUID`, `VendorID`, `PointName`, `CompleteAddress`, `Latitude`, `Longitude`, `Address`, `PostalID`, `CityID`, `TalukID`, `DistrictID`, `StateID`, `CountryID`, `MapData`, `CreatedOn`) VALUES
(34, '42b36693d210', 'V2425-00000146', 'point chennai', 'Haddows Road ,27, Nungambakkam,Chennai, Tamil Nadu, India-600034', 13.06588898876915, 80.24765230715275, 'Haddows Road, 27', 'PC2023-0014888', 'CI2023-0113492', 'T2023-00007855', 'DT2023-00000490', 'S2020-00000035', 'C2020-00000101', 'O:8:\"stdClass\":11:{s:4:\"name\";s:2:\"27\";s:6:\"street\";s:2:\"27\";s:14:\"isoCountryCode\";s:2:\"IN\";s:7:\"country\";s:5:\"India\";s:10:\"postalCode\";s:6:\"600034\";s:18:\"administrativeArea\";s:10:\"Tamil Nadu\";s:21:\"subAdministrativeArea\";s:0:\"\";s:8:\"locality\";s:7:\"Chennai\";s:11:\"subLocality\";s:12:\"Nungambakkam\";s:12:\"thoroughfare\";s:12:\"Haddows Road\";s:15:\"subThoroughfare\";s:2:\"27\";}', '2024-04-26 11:07:55'),
(35, '6126482066b4', 'V2425-00000145', '', '130/C, Ganapathy,Coimbatore, Tamil Nadu, India-641006', 11.048244649642545, 76.98839586228132, '130/C, Ganapathy', 'PC2023-0015242', 'CI2023-0115371', 'T2023-00007978', 'DT2023-00000497', 'S2020-00000035', 'C2020-00000101', 'O:8:\"stdClass\":11:{s:4:\"name\";s:5:\"130/C\";s:6:\"street\";s:5:\"130/C\";s:14:\"isoCountryCode\";s:2:\"IN\";s:7:\"country\";s:5:\"India\";s:10:\"postalCode\";s:6:\"641006\";s:18:\"administrativeArea\";s:10:\"Tamil Nadu\";s:21:\"subAdministrativeArea\";s:0:\"\";s:8:\"locality\";s:10:\"Coimbatore\";s:11:\"subLocality\";s:9:\"Ganapathy\";s:12:\"thoroughfare\";s:0:\"\";s:15:\"subThoroughfare\";s:0:\"\";}', '2024-04-26 11:37:50'),
(37, '5636e834a036', 'V2425-00000006', '', '1010, Nesavalar Colony,Perundurai, Tamil Nadu, India-638053', 11.27983045614075, 77.5742332264781, '1010, Nesavalar Colony', 'PC2023-0015387', 'CI2023-0115955', 'T2023-00007998', 'DT2023-00000500', 'S2020-00000035', 'C2020-00000101', 'O:8:\"stdClass\":11:{s:4:\"name\";s:4:\"1010\";s:6:\"street\";s:4:\"1010\";s:14:\"isoCountryCode\";s:2:\"IN\";s:7:\"country\";s:5:\"India\";s:10:\"postalCode\";s:6:\"638053\";s:18:\"administrativeArea\";s:10:\"Tamil Nadu\";s:21:\"subAdministrativeArea\";s:0:\"\";s:8:\"locality\";s:10:\"Perundurai\";s:11:\"subLocality\";s:16:\"Nesavalar Colony\";s:12:\"thoroughfare\";s:0:\"\";s:15:\"subThoroughfare\";s:0:\"\";}', '2024-05-03 09:58:53'),
(41, '696a66870044', 'V2425-00000323', '', 'State Highway 83A ,3MF2+X2W, ,Mullipuram, Tamil Nadu, India-638108', 11.075259080651824, 77.64989331364632, 'State Highway 83A, 3MF2+X2W', 'PC2023-0015741', 'CI2023-0118210', 'T2023-00008066', 'DT2023-00000500', 'S2020-00000035', 'C2020-00000101', 'O:8:\"stdClass\":11:{s:4:\"name\";s:8:\"3MF2+X2W\";s:6:\"street\";s:8:\"3MF2+X2W\";s:14:\"isoCountryCode\";s:2:\"IN\";s:7:\"country\";s:5:\"India\";s:10:\"postalCode\";s:6:\"638108\";s:18:\"administrativeArea\";s:10:\"Tamil Nadu\";s:21:\"subAdministrativeArea\";s:0:\"\";s:8:\"locality\";s:10:\"Mullipuram\";s:11:\"subLocality\";s:0:\"\";s:12:\"thoroughfare\";s:17:\"State Highway 83A\";s:15:\"subThoroughfare\";s:0:\"\";}', '2024-05-22 11:48:47');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendors_supply`
--

CREATE TABLE `tbl_vendors_supply` (
  `DetailID` int NOT NULL,
  `VendorID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PCID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PSCID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreatedOn` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB ;

--
-- Dumping data for table `tbl_vendors_supply`
--

INSERT INTO `tbl_vendors_supply` (`DetailID`, `VendorID`, `PCID`, `PSCID`, `CreatedOn`) VALUES
(299, 'V2425-00000005', 'PC2024-0000007', 'PSC2024-0000002', '2024-04-10 17:19:23'),
(300, 'V2425-00000005', 'PC2024-0000007', 'PSC2024-0000003', '2024-04-10 17:19:23'),
(301, 'V2425-00000005', 'PC2024-0000007', 'PSC2024-0000004', '2024-04-10 17:19:23'),
(302, 'V2425-00000005', 'PC2024-0000007', 'PSC2024-0000005', '2024-04-10 17:19:23'),
(303, 'V2425-00000005', 'PC2024-0000007', 'PSC2024-0000006', '2024-04-10 17:19:23'),
(304, 'V2425-00000005', 'PC2024-0000007', 'PSC2024-0000007', '2024-04-10 17:19:23'),
(305, 'V2425-00000005', 'PC2024-0000007', 'PSC2024-0000008', '2024-04-10 17:19:23'),
(306, 'V2425-00000005', 'PC2024-0000007', 'PSC2024-0000009', '2024-04-10 17:19:23'),
(307, 'V2425-00000005', 'PC2024-0000007', 'PSC2024-0000010', '2024-04-10 17:19:23'),
(308, 'V2425-00000005', 'PC2024-0000007', 'PSC2024-0000011', '2024-04-10 17:19:23'),
(309, 'V2425-00000005', 'PC2024-0000007', 'PSC2024-0000015', '2024-04-10 17:19:23'),
(310, 'V2425-00000005', 'PC2024-0000007', 'PSC2024-0000016', '2024-04-10 17:19:23'),
(311, 'V2425-00000005', 'PC2024-0000007', 'PSC2024-0000017', '2024-04-10 17:19:23'),
(312, 'V2425-00000005', 'PC2024-0000007', 'PSC2024-0000082', '2024-04-10 17:19:23'),
(313, 'V2425-00000005', 'PC2024-0000014', 'PSC2024-0000136', '2024-04-10 17:19:23'),
(314, 'V2425-00000005', 'PC2024-0000014', 'PSC2024-0000137', '2024-04-10 17:19:23'),
(315, 'V2425-00000005', 'PC2024-0000014', 'PSC2024-0000138', '2024-04-10 17:19:23'),
(316, 'V2425-00000005', 'PC2024-0000014', 'PSC2024-0000139', '2024-04-10 17:19:23'),
(317, 'V2425-00000005', 'PC2024-0000014', 'PSC2024-0000140', '2024-04-10 17:19:23'),
(318, 'V2425-00000005', 'PC2024-0000014', 'PSC2024-0000141', '2024-04-10 17:19:23'),
(319, 'V2425-00000005', 'PC2024-0000014', 'PSC2024-0000142', '2024-04-10 17:19:23'),
(320, 'V2425-00000005', 'PC2024-0000014', 'PSC2024-0000143', '2024-04-10 17:19:23'),
(389, 'V2425-00000007', 'PC2023-0000001', 'PSC2023-0000001', '2024-04-12 03:10:15'),
(390, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000034', '2024-04-12 03:10:15'),
(391, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000035', '2024-04-12 03:10:15'),
(392, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000036', '2024-04-12 03:10:15'),
(393, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000037', '2024-04-12 03:10:15'),
(394, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000038', '2024-04-12 03:10:15'),
(395, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000039', '2024-04-12 03:10:15'),
(396, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000040', '2024-04-12 03:10:15'),
(397, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000041', '2024-04-12 03:10:15'),
(398, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000042', '2024-04-12 03:10:15'),
(399, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000043', '2024-04-12 03:10:15'),
(400, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000044', '2024-04-12 03:10:15'),
(401, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000045', '2024-04-12 03:10:15'),
(402, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000046', '2024-04-12 03:10:15'),
(403, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000047', '2024-04-12 03:10:15'),
(404, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000048', '2024-04-12 03:10:15'),
(405, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000049', '2024-04-12 03:10:15'),
(406, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000050', '2024-04-12 03:10:15'),
(407, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000051', '2024-04-12 03:10:15'),
(408, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000052', '2024-04-12 03:10:15'),
(409, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000053', '2024-04-12 03:10:15'),
(410, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000054', '2024-04-12 03:10:15'),
(411, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000055', '2024-04-12 03:10:15'),
(412, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000056', '2024-04-12 03:10:15'),
(413, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000057', '2024-04-12 03:10:15'),
(414, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000080', '2024-04-12 03:10:15'),
(415, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000133', '2024-04-12 03:10:15'),
(416, 'V2425-00000007', 'PC2023-0000001', 'PSC2024-0000134', '2024-04-12 03:10:15'),
(417, 'V2425-00000007', 'PC2024-0000006', 'PSC2024-0000014', '2024-04-12 03:10:15'),
(418, 'V2425-00000007', 'PC2024-0000006', 'PSC2024-0000023', '2024-04-12 03:10:15'),
(419, 'V2425-00000007', 'PC2024-0000006', 'PSC2024-0000024', '2024-04-12 03:10:15'),
(420, 'V2425-00000007', 'PC2024-0000006', 'PSC2024-0000025', '2024-04-12 03:10:15'),
(421, 'V2425-00000007', 'PC2024-0000006', 'PSC2024-0000026', '2024-04-12 03:10:15'),
(422, 'V2425-00000007', 'PC2024-0000006', 'PSC2024-0000027', '2024-04-12 03:10:15'),
(423, 'V2425-00000007', 'PC2024-0000006', 'PSC2024-0000028', '2024-04-12 03:10:15'),
(424, 'V2425-00000007', 'PC2024-0000006', 'PSC2024-0000029', '2024-04-12 03:10:15'),
(425, 'V2425-00000007', 'PC2024-0000006', 'PSC2024-0000030', '2024-04-12 03:10:15'),
(426, 'V2425-00000007', 'PC2024-0000006', 'PSC2024-0000061', '2024-04-12 03:10:15'),
(427, 'V2425-00000007', 'PC2024-0000006', 'PSC2024-0000083', '2024-04-12 03:10:15'),
(428, 'V2425-00000007', 'PC2024-0000006', 'PSC2024-0000084', '2024-04-12 03:10:15'),
(645, 'V2425-00000033', 'PC2024-0000013', 'PSC2024-0000135', '2024-04-16 10:50:54'),
(646, 'V2425-00000033', 'PC2024-0000013', 'PSC2024-0000144', '2024-04-16 10:50:54'),
(879, 'V2425-00000146', 'PC2024-0000032', 'PSC2024-0000151', '2024-04-26 11:07:53'),
(881, 'V2425-00000145', 'PC2024-0000031', 'PSC2024-0000150', '2024-04-26 11:38:46'),
(941, 'V2425-00000006', 'PC2024-0000007', 'PSC2024-0000002', '2024-05-03 09:59:19'),
(942, 'V2425-00000006', 'PC2024-0000007', 'PSC2024-0000003', '2024-05-03 09:59:19'),
(943, 'V2425-00000006', 'PC2024-0000007', 'PSC2024-0000004', '2024-05-03 09:59:19'),
(944, 'V2425-00000006', 'PC2024-0000007', 'PSC2024-0000005', '2024-05-03 09:59:19'),
(945, 'V2425-00000006', 'PC2024-0000007', 'PSC2024-0000006', '2024-05-03 09:59:19'),
(946, 'V2425-00000006', 'PC2024-0000007', 'PSC2024-0000007', '2024-05-03 09:59:19'),
(947, 'V2425-00000006', 'PC2024-0000007', 'PSC2024-0000008', '2024-05-03 09:59:19'),
(948, 'V2425-00000006', 'PC2024-0000007', 'PSC2024-0000009', '2024-05-03 09:59:19'),
(949, 'V2425-00000006', 'PC2024-0000007', 'PSC2024-0000010', '2024-05-03 09:59:19'),
(950, 'V2425-00000006', 'PC2024-0000007', 'PSC2024-0000011', '2024-05-03 09:59:19'),
(951, 'V2425-00000006', 'PC2024-0000007', 'PSC2024-0000015', '2024-05-03 09:59:19'),
(952, 'V2425-00000006', 'PC2024-0000007', 'PSC2024-0000016', '2024-05-03 09:59:19'),
(953, 'V2425-00000006', 'PC2024-0000007', 'PSC2024-0000017', '2024-05-03 09:59:19'),
(954, 'V2425-00000006', 'PC2024-0000007', 'PSC2024-0000082', '2024-05-03 09:59:19'),
(1000, 'V2425-00000323', 'PC2024-0000010', 'PSC2024-0000018', '2024-05-22 11:48:16'),
(1001, 'V2425-00000323', 'PC2024-0000010', 'PSC2024-0000019', '2024-05-22 11:48:16'),
(1002, 'V2425-00000323', 'PC2024-0000010', 'PSC2024-0000020', '2024-05-22 11:48:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendors_vehicle`
--

CREATE TABLE `tbl_vendors_vehicle` (
  `SNo` int NOT NULL,
  `VendorID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `VehicleID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `UUID` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `VNumber` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `VType` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `VBrand` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `VModel` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `VLength` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `VDepth` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `VWidth` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `VCapacity` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreatedOn` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendors_vehicle_images`
--

CREATE TABLE `tbl_vendors_vehicle_images` (
  `SNo` int NOT NULL,
  `SLNo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `VendorID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `VehicleID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `UUID` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ImgID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gImage` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `CreatedOn` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB ;

-- --------------------------------------------------------

--
-- Table structure for table `temp_vendors`
--

CREATE TABLE `temp_vendors` (
  `VendorCoName` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `VendorName` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `MobileNumber1` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `VendorType` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DistrictName` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `VendorStockPointCount` int DEFAULT NULL,
  `StockPointNames` text COLLATE utf8mb4_general_ci,
  `Products` text COLLATE utf8mb4_general_ci,
  `FullProductNames` text COLLATE utf8mb4_general_ci,
  `ProductVendorType` text COLLATE utf8mb4_general_ci,
  `CreatedOn` datetime DEFAULT NULL,
  `ActiveStatus` tinyint DEFAULT NULL,
  `VendorID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `isApproved` tinyint DEFAULT NULL
) ENGINE=InnoDB ;

--
-- Dumping data for table `temp_vendors`
--

INSERT INTO `temp_vendors` (`VendorCoName`, `VendorName`, `MobileNumber1`, `VendorType`, `DistrictName`, `VendorStockPointCount`, `StockPointNames`, `Products`, `FullProductNames`, `ProductVendorType`, `CreatedOn`, `ActiveStatus`, `VendorID`, `isApproved`) VALUES
('New Arungarai Amman', 'New Arungarai Amman', '9655236162', 'Manufacturers', 'Karur', 1, 'stock point 1', 'Aggregates 12mm,Aggregates 20mm,Aggregates 40mm,Aggregates 6 mm,Aggregates Over 20mm,Boulders Rough Stone,Crusher Powder or Crusher Dust,GSB,M Sand,P-Sand,Sludge,Wet mix', 'Aggregates 12mm - WholeSale - Manufacturers,Aggregates 20mm - WholeSale - Manufacturers,Aggregates 40mm - WholeSale - Manufacturers,Aggregates 6 mm - WholeSale - Manufacturers,Aggregates Over 20mm - WholeSale - Manufacturers,Boulders Rough Stone - WholeSale - Manufacturers,Crusher Powder or Crusher Dust - WholeSale - Manufacturers,GSB - Both - Manufacturers,M Sand - WholeSale - Manufacturers,P-Sand - WholeSale - Manufacturers,Sludge - Both - Manufacturers,Wet mix - WholeSale - Manufacturers', 'Aggregates 12mm - Manufacturers,Aggregates 20mm - Manufacturers,Aggregates 40mm - Manufacturers,Aggregates 6 mm - Manufacturers,Aggregates Over 20mm - Manufacturers,Boulders Rough Stone - Manufacturers,Crusher Powder or Crusher Dust - Manufacturers,GSB - Manufacturers,M Sand - Manufacturers,P-Sand - Manufacturers,Sludge - Manufacturers,Wet mix - Manufacturers', '2024-01-09 04:35:11', 1, 'V2024-00000014', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_ledger_4Qz3zz5Z`
--

CREATE TABLE `tmp_ledger_4Qz3zz5Z` (
  `TranNo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `TranDate` date DEFAULT NULL,
  `LedgerType` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `LedgerID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `LedgerName` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `Debit` double DEFAULT '0',
  `Credit` double DEFAULT '0',
  `CreatedOn` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB ;

--
-- Dumping data for table `tmp_ledger_4Qz3zz5Z`
--

INSERT INTO `tmp_ledger_4Qz3zz5Z` (`TranNo`, `TranDate`, `LedgerType`, `LedgerID`, `LedgerName`, `Description`, `Debit`, `Credit`, `CreatedOn`) VALUES
('ODR2425-00000002', '2024-04-10', 'Customer', 'CU2425-00000041', 'Bharanidaran', 'Order #ODR2425-00000002.', 21440, 0, '2024-04-09 18:30:00'),
('ODR2425-00000003', '2024-04-10', 'Customer', 'CU2425-00000041', 'Bharanidaran', 'Order #ODR2425-00000003.', 7970.2, 0, '2024-04-09 18:30:00'),
('ODR2425-00000005', '2024-04-17', 'Customer', 'CU2425-00000041', 'Bharanidaran', 'Order #ODR2425-00000005.', 5700, 0, '2024-04-16 18:30:00'),
('ODR2425-00000006', '2024-04-17', 'Customer', 'CU2425-00000041', 'Bharanidaran', 'Order #ODR2425-00000006.', 2000, 0, '2024-04-16 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_ledger_FpM6jKR9`
--

CREATE TABLE `tmp_ledger_FpM6jKR9` (
  `TranNo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `TranDate` date DEFAULT NULL,
  `LedgerType` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `LedgerID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `LedgerName` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `Debit` double DEFAULT '0',
  `Credit` double DEFAULT '0',
  `CreatedOn` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB ;

--
-- Dumping data for table `tmp_ledger_FpM6jKR9`
--

INSERT INTO `tmp_ledger_FpM6jKR9` (`TranNo`, `TranDate`, `LedgerType`, `LedgerID`, `LedgerName`, `Description`, `Debit`, `Credit`, `CreatedOn`) VALUES
('ODR2425-00000002', '2024-04-10', 'Customer', 'CU2425-00000041', 'Bharanidaran', 'Order #ODR2425-00000002.', 21440, 0, '2024-04-09 18:30:00'),
('ODR2425-00000003', '2024-04-10', 'Customer', 'CU2425-00000041', 'Bharanidaran', 'Order #ODR2425-00000003.', 7970.2, 0, '2024-04-09 18:30:00'),
('ODR2425-00000005', '2024-04-17', 'Customer', 'CU2425-00000041', 'Bharanidaran', 'Order #ODR2425-00000005.', 5700, 0, '2024-04-16 18:30:00'),
('ODR2425-00000006', '2024-04-17', 'Customer', 'CU2425-00000041', 'Bharanidaran', 'Order #ODR2425-00000006.', 2000, 0, '2024-04-16 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_ledger_s8MXeIpX`
--

CREATE TABLE `tmp_ledger_s8MXeIpX` (
  `TranNo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `TranDate` date DEFAULT NULL,
  `LedgerType` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `LedgerID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `LedgerName` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `Debit` double DEFAULT '0',
  `Credit` double DEFAULT '0',
  `CreatedOn` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB ;

--
-- Dumping data for table `tmp_ledger_s8MXeIpX`
--

INSERT INTO `tmp_ledger_s8MXeIpX` (`TranNo`, `TranDate`, `LedgerType`, `LedgerID`, `LedgerName`, `Description`, `Debit`, `Credit`, `CreatedOn`) VALUES
('ODR2425-00000002', '2024-04-10', 'Customer', 'CU2425-00000041', 'Bharanidaran', 'Order #ODR2425-00000002.', 21440, 0, '2024-04-09 18:30:00'),
('ODR2425-00000003', '2024-04-10', 'Customer', 'CU2425-00000041', 'Bharanidaran', 'Order #ODR2425-00000003.', 7970.2, 0, '2024-04-09 18:30:00'),
('ODR2425-00000005', '2024-04-17', 'Customer', 'CU2425-00000041', 'Bharanidaran', 'Order #ODR2425-00000005.', 5700, 0, '2024-04-16 18:30:00'),
('ODR2425-00000006', '2024-04-17', 'Customer', 'CU2425-00000041', 'Bharanidaran', 'Order #ODR2425-00000006.', 2000, 0, '2024-04-16 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_ledger_TdJhe0C1`
--

CREATE TABLE `tmp_ledger_TdJhe0C1` (
  `TranNo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `TranDate` date DEFAULT NULL,
  `LedgerType` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `LedgerID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `LedgerName` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `Debit` double DEFAULT '0',
  `Credit` double DEFAULT '0',
  `CreatedOn` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB ;

--
-- Dumping data for table `tmp_ledger_TdJhe0C1`
--

INSERT INTO `tmp_ledger_TdJhe0C1` (`TranNo`, `TranDate`, `LedgerType`, `LedgerID`, `LedgerName`, `Description`, `Debit`, `Credit`, `CreatedOn`) VALUES
('ODR2425-00000002', '2024-04-10', 'Customer', 'CU2425-00000041', 'Bharanidaran', 'Order #ODR2425-00000002.', 21440, 0, '2024-04-09 18:30:00'),
('ODR2425-00000003', '2024-04-10', 'Customer', 'CU2425-00000041', 'Bharanidaran', 'Order #ODR2425-00000003.', 7970.2, 0, '2024-04-09 18:30:00'),
('ODR2425-00000005', '2024-04-17', 'Customer', 'CU2425-00000041', 'Bharanidaran', 'Order #ODR2425-00000005.', 5700, 0, '2024-04-16 18:30:00'),
('ODR2425-00000006', '2024-04-17', 'Customer', 'CU2425-00000041', 'Bharanidaran', 'Order #ODR2425-00000006.', 2000, 0, '2024-04-16 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_order_due_rpt_4h749p`
--

CREATE TABLE `tmp_order_due_rpt_4h749p` (
  `OrderID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderNo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `LedgerName` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreditDays` int DEFAULT '0',
  `OrderValue` double DEFAULT '0',
  `PaidAmount` double DEFAULT '0',
  `BalanceAmount` double DEFAULT '0',
  `DaysOutstanding` int DEFAULT '0'
) ENGINE=InnoDB ;

--
-- Dumping data for table `tmp_order_due_rpt_4h749p`
--

INSERT INTO `tmp_order_due_rpt_4h749p` (`OrderID`, `OrderNo`, `OrderDate`, `LedgerName`, `CreditDays`, `OrderValue`, `PaidAmount`, `BalanceAmount`, `DaysOutstanding`) VALUES
('ODR2425-00000001', 'RPC/2425/ODR-1', '2024-04-10', 'Nikhil K', 30, 15175, 0, 15175, 146),
('ODR2425-00000004', 'RPC/2425/ODR-4', '2024-04-17', 'Praba', 30, 16107.2, 10000, 6107.200000000001, 139),
('ODR2425-00000007', 'RPC/2425/ODR-7', '2024-05-08', 'rpc retail', 30, 9040, 0, 9040, 118),
('ODR2425-00000008', 'RPC/2425/ODR-8', '2024-05-08', 'rpc retail', 30, 3633.6, 0, 3633.6, 118),
('ODR2425-00000009', 'RPC/2425/ODR-9', '2024-05-13', 'MobileTeam', 30, 8400, 0, 8400, 113),
('ODR2425-00000012', 'RPC/2425/ODR-12', '2024-05-23', 'rpcsoftware', 30, 7885.3, 0, 7885.3, 103),
('ODR2425-00000014', 'RPC/2425/ODR-14', '2024-05-23', 'Praba', 30, 1716, 0, 1716, 103),
('ODR2425-00000016', 'RPC/2425/ODR-16', '2024-05-30', 'sai subha', 30, 872.8, 0, 872.8, 96),
('ODR2425-00000019', 'RPC/2425/ODR-19', '2024-06-11', 'Bharanidaran Gopalakrishnan', 30, 71065.6, 0, 71065.6, 84),
('ODR2425-00000021', 'RPC/2425/ODR-21', '2024-07-20', 'RPC BS', 30, 69800, 0, 69800, 45),
('ODR2425-00000022', 'RPC/2425/ODR-22', '2024-08-16', 'Sai subha', 30, 10818.4, 0, 10818.4, 18),
('ODR2425-00000024', 'RPC/2425/ODR-24', '2024-08-17', 'rpc retail', 30, 4410.4, 0, 4410.4, 17),
('ODR2425-00000025', 'RPC/2425/ODR-25', '2024-08-29', 'rpc retail', 30, 5058.4, 0, 5058.4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_order_due_rpt_5TIJ3p`
--

CREATE TABLE `tmp_order_due_rpt_5TIJ3p` (
  `OrderID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderNo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `LedgerName` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreditDays` int DEFAULT '0',
  `OrderValue` double DEFAULT '0',
  `PaidAmount` double DEFAULT '0',
  `BalanceAmount` double DEFAULT '0',
  `DaysOutstanding` int DEFAULT '0'
) ENGINE=InnoDB ;

--
-- Dumping data for table `tmp_order_due_rpt_5TIJ3p`
--

INSERT INTO `tmp_order_due_rpt_5TIJ3p` (`OrderID`, `OrderNo`, `OrderDate`, `LedgerName`, `CreditDays`, `OrderValue`, `PaidAmount`, `BalanceAmount`, `DaysOutstanding`) VALUES
('ODR2425-00000001', 'RPC/2425/ODR-1', '2024-04-10', 'Nikhil K', 30, 15175, 0, 15175, 187),
('ODR2425-00000004', 'RPC/2425/ODR-4', '2024-04-17', 'Praba', 30, 16107.2, 10000, 6107.200000000001, 180),
('ODR2425-00000007', 'RPC/2425/ODR-7', '2024-05-08', 'rpc retail', 30, 9040, 0, 9040, 159),
('ODR2425-00000008', 'RPC/2425/ODR-8', '2024-05-08', 'rpc retail', 30, 3633.6, 0, 3633.6, 159),
('ODR2425-00000009', 'RPC/2425/ODR-9', '2024-05-13', 'MobileTeam', 30, 8400, 0, 8400, 154),
('ODR2425-00000012', 'RPC/2425/ODR-12', '2024-05-23', 'rpcsoftware', 30, 7885.3, 0, 7885.3, 144),
('ODR2425-00000014', 'RPC/2425/ODR-14', '2024-05-23', 'Praba', 30, 1716, 0, 1716, 144),
('ODR2425-00000016', 'RPC/2425/ODR-16', '2024-05-30', 'sai subha', 30, 872.8, 0, 872.8, 137),
('ODR2425-00000019', 'RPC/2425/ODR-19', '2024-06-11', 'Bharanidaran Gopalakrishnan', 30, 71065.6, 0, 71065.6, 125),
('ODR2425-00000021', 'RPC/2425/ODR-21', '2024-07-20', 'RPC BS', 30, 69800, 0, 69800, 86),
('ODR2425-00000022', 'RPC/2425/ODR-22', '2024-08-16', 'Sai subha', 30, 10818.4, 0, 10818.4, 59),
('ODR2425-00000024', 'RPC/2425/ODR-24', '2024-08-17', 'rpc retail', 30, 4410.4, 0, 4410.4, 58),
('ODR2425-00000025', 'RPC/2425/ODR-25', '2024-08-29', 'rpc retail', 30, 5058.4, 0, 5058.4, 46),
('ODR2425-00000026', 'RPC/2425/ODR-26', '2024-09-12', 'Praba', 30, 1311.6, 0, 1311.6, 32),
('ODR2425-00000027', 'RPC/2425/ODR-27', '2024-09-12', 'Praba', 30, 246.8, 0, 246.8, 32),
('ODR2425-00000028', 'RPC/2425/ODR-28', '2024-09-12', 'Praba', 30, 2718.21, 0, 2718.21, 32);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_order_due_rpt_5Xlz3P`
--

CREATE TABLE `tmp_order_due_rpt_5Xlz3P` (
  `OrderID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderNo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `LedgerName` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreditDays` int DEFAULT '0',
  `OrderValue` double DEFAULT '0',
  `PaidAmount` double DEFAULT '0',
  `BalanceAmount` double DEFAULT '0',
  `DaysOutstanding` int DEFAULT '0'
) ENGINE=InnoDB ;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_order_due_rpt_8SDz5R`
--

CREATE TABLE `tmp_order_due_rpt_8SDz5R` (
  `OrderID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderNo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `LedgerName` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreditDays` int DEFAULT '0',
  `OrderValue` double DEFAULT '0',
  `PaidAmount` double DEFAULT '0',
  `BalanceAmount` double DEFAULT '0',
  `DaysOutstanding` int DEFAULT '0'
) ENGINE=InnoDB ;

--
-- Dumping data for table `tmp_order_due_rpt_8SDz5R`
--

INSERT INTO `tmp_order_due_rpt_8SDz5R` (`OrderID`, `OrderNo`, `OrderDate`, `LedgerName`, `CreditDays`, `OrderValue`, `PaidAmount`, `BalanceAmount`, `DaysOutstanding`) VALUES
('ODR2425-00000001', 'RPC/2425/ODR-1', '2024-04-10', 'Nikhil K', 30, 15175, 0, 15175, 111),
('ODR2425-00000004', 'RPC/2425/ODR-4', '2024-04-17', 'Praba', 30, 16107.2, 10000, 6107.200000000001, 104),
('ODR2425-00000007', 'RPC/2425/ODR-7', '2024-05-08', 'rpc retail', 30, 9040, 0, 9040, 83),
('ODR2425-00000008', 'RPC/2425/ODR-8', '2024-05-08', 'rpc retail', 30, 3633.6, 0, 3633.6, 83),
('ODR2425-00000009', 'RPC/2425/ODR-9', '2024-05-13', 'MobileTeam', 30, 8400, 0, 8400, 78),
('ODR2425-00000012', 'RPC/2425/ODR-12', '2024-05-23', 'rpcsoftware', 30, 7885.3, 0, 7885.3, 68),
('ODR2425-00000014', 'RPC/2425/ODR-14', '2024-05-23', 'Praba', 30, 1716, 0, 1716, 68),
('ODR2425-00000016', 'RPC/2425/ODR-16', '2024-05-30', 'sai subha', 30, 872.8, 0, 872.8, 61),
('ODR2425-00000019', 'RPC/2425/ODR-19', '2024-06-11', 'Bharanidaran Gopalakrishnan', 30, 71065.6, 0, 71065.6, 49),
('ODR2425-00000021', 'RPC/2425/ODR-21', '2024-07-20', 'RPC BS', 30, 69800, 0, 69800, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_order_due_rpt_BVcufk`
--

CREATE TABLE `tmp_order_due_rpt_BVcufk` (
  `OrderID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderNo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `LedgerName` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreditDays` int DEFAULT '0',
  `OrderValue` double DEFAULT '0',
  `PaidAmount` double DEFAULT '0',
  `BalanceAmount` double DEFAULT '0',
  `DaysOutstanding` int DEFAULT '0'
) ENGINE=InnoDB ;

--
-- Dumping data for table `tmp_order_due_rpt_BVcufk`
--

INSERT INTO `tmp_order_due_rpt_BVcufk` (`OrderID`, `OrderNo`, `OrderDate`, `LedgerName`, `CreditDays`, `OrderValue`, `PaidAmount`, `BalanceAmount`, `DaysOutstanding`) VALUES
('ODR2425-00000001', 'RPC/2425/ODR-1', '2024-04-10', 'Nikhil K', 30, 15175, 0, 15175, 146),
('ODR2425-00000004', 'RPC/2425/ODR-4', '2024-04-17', 'Praba', 30, 16107.2, 10000, 6107.200000000001, 139),
('ODR2425-00000007', 'RPC/2425/ODR-7', '2024-05-08', 'rpc retail', 30, 9040, 0, 9040, 118),
('ODR2425-00000008', 'RPC/2425/ODR-8', '2024-05-08', 'rpc retail', 30, 3633.6, 0, 3633.6, 118),
('ODR2425-00000009', 'RPC/2425/ODR-9', '2024-05-13', 'MobileTeam', 30, 8400, 0, 8400, 113),
('ODR2425-00000012', 'RPC/2425/ODR-12', '2024-05-23', 'rpcsoftware', 30, 7885.3, 0, 7885.3, 103),
('ODR2425-00000014', 'RPC/2425/ODR-14', '2024-05-23', 'Praba', 30, 1716, 0, 1716, 103),
('ODR2425-00000016', 'RPC/2425/ODR-16', '2024-05-30', 'sai subha', 30, 872.8, 0, 872.8, 96),
('ODR2425-00000019', 'RPC/2425/ODR-19', '2024-06-11', 'Bharanidaran Gopalakrishnan', 30, 71065.6, 0, 71065.6, 84),
('ODR2425-00000021', 'RPC/2425/ODR-21', '2024-07-20', 'RPC BS', 30, 69800, 0, 69800, 45),
('ODR2425-00000022', 'RPC/2425/ODR-22', '2024-08-16', 'Sai subha', 30, 10818.4, 0, 10818.4, 18),
('ODR2425-00000024', 'RPC/2425/ODR-24', '2024-08-17', 'rpc retail', 30, 4410.4, 0, 4410.4, 17),
('ODR2425-00000025', 'RPC/2425/ODR-25', '2024-08-29', 'rpc retail', 30, 5058.4, 0, 5058.4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_order_due_rpt_e09kwd`
--

CREATE TABLE `tmp_order_due_rpt_e09kwd` (
  `OrderID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderNo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `LedgerName` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreditDays` int DEFAULT '0',
  `OrderValue` double DEFAULT '0',
  `PaidAmount` double DEFAULT '0',
  `BalanceAmount` double DEFAULT '0',
  `DaysOutstanding` int DEFAULT '0'
) ENGINE=InnoDB ;

--
-- Dumping data for table `tmp_order_due_rpt_e09kwd`
--

INSERT INTO `tmp_order_due_rpt_e09kwd` (`OrderID`, `OrderNo`, `OrderDate`, `LedgerName`, `CreditDays`, `OrderValue`, `PaidAmount`, `BalanceAmount`, `DaysOutstanding`) VALUES
('ODR2425-00000001', 'RPC/2425/ODR-1', '2024-04-10', 'Nikhil K', 30, 15175, 0, 15175, 186),
('ODR2425-00000004', 'RPC/2425/ODR-4', '2024-04-17', 'Praba', 30, 16107.2, 10000, 6107.200000000001, 179),
('ODR2425-00000007', 'RPC/2425/ODR-7', '2024-05-08', 'rpc retail', 30, 9040, 0, 9040, 158),
('ODR2425-00000008', 'RPC/2425/ODR-8', '2024-05-08', 'rpc retail', 30, 3633.6, 0, 3633.6, 158),
('ODR2425-00000009', 'RPC/2425/ODR-9', '2024-05-13', 'MobileTeam', 30, 8400, 0, 8400, 153),
('ODR2425-00000012', 'RPC/2425/ODR-12', '2024-05-23', 'rpcsoftware', 30, 7885.3, 0, 7885.3, 143),
('ODR2425-00000014', 'RPC/2425/ODR-14', '2024-05-23', 'Praba', 30, 1716, 0, 1716, 143),
('ODR2425-00000016', 'RPC/2425/ODR-16', '2024-05-30', 'sai subha', 30, 872.8, 0, 872.8, 136),
('ODR2425-00000019', 'RPC/2425/ODR-19', '2024-06-11', 'Bharanidaran Gopalakrishnan', 30, 71065.6, 0, 71065.6, 124),
('ODR2425-00000021', 'RPC/2425/ODR-21', '2024-07-20', 'RPC BS', 30, 69800, 0, 69800, 85),
('ODR2425-00000022', 'RPC/2425/ODR-22', '2024-08-16', 'Sai subha', 30, 10818.4, 0, 10818.4, 58),
('ODR2425-00000024', 'RPC/2425/ODR-24', '2024-08-17', 'rpc retail', 30, 4410.4, 0, 4410.4, 57),
('ODR2425-00000025', 'RPC/2425/ODR-25', '2024-08-29', 'rpc retail', 30, 5058.4, 0, 5058.4, 45),
('ODR2425-00000026', 'RPC/2425/ODR-26', '2024-09-12', 'Praba', 30, 1311.6, 0, 1311.6, 31),
('ODR2425-00000027', 'RPC/2425/ODR-27', '2024-09-12', 'Praba', 30, 246.8, 0, 246.8, 31),
('ODR2425-00000028', 'RPC/2425/ODR-28', '2024-09-12', 'Praba', 30, 2718.21, 0, 2718.21, 31);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_order_due_rpt_e8Xtmh`
--

CREATE TABLE `tmp_order_due_rpt_e8Xtmh` (
  `OrderID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderNo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `LedgerName` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreditDays` int DEFAULT '0',
  `OrderValue` double DEFAULT '0',
  `PaidAmount` double DEFAULT '0',
  `BalanceAmount` double DEFAULT '0',
  `DaysOutstanding` int DEFAULT '0'
) ENGINE=InnoDB ;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_order_due_rpt_mIb39A`
--

CREATE TABLE `tmp_order_due_rpt_mIb39A` (
  `OrderID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderNo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `LedgerName` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreditDays` int DEFAULT '0',
  `OrderValue` double DEFAULT '0',
  `PaidAmount` double DEFAULT '0',
  `BalanceAmount` double DEFAULT '0',
  `DaysOutstanding` int DEFAULT '0'
) ENGINE=InnoDB ;

--
-- Dumping data for table `tmp_order_due_rpt_mIb39A`
--

INSERT INTO `tmp_order_due_rpt_mIb39A` (`OrderID`, `OrderNo`, `OrderDate`, `LedgerName`, `CreditDays`, `OrderValue`, `PaidAmount`, `BalanceAmount`, `DaysOutstanding`) VALUES
('ODR2425-00000001', 'RPC/2425/ODR-1', '2024-04-10', 'Nikhil K', 30, 15175, 0, 15175, 97),
('ODR2425-00000004', 'RPC/2425/ODR-4', '2024-04-17', 'Praba', 30, 16107.2, 10000, 6107.200000000001, 90),
('ODR2425-00000007', 'RPC/2425/ODR-7', '2024-05-08', 'rpc retail', 30, 9040, 0, 9040, 69),
('ODR2425-00000008', 'RPC/2425/ODR-8', '2024-05-08', 'rpc retail', 30, 3633.6, 0, 3633.6, 69),
('ODR2425-00000009', 'RPC/2425/ODR-9', '2024-05-13', 'MobileTeam', 30, 8400, 0, 8400, 64),
('ODR2425-00000012', 'RPC/2425/ODR-12', '2024-05-23', 'rpcsoftware', 30, 7885.3, 0, 7885.3, 54),
('ODR2425-00000014', 'RPC/2425/ODR-14', '2024-05-23', 'Praba', 30, 1716, 0, 1716, 54),
('ODR2425-00000016', 'RPC/2425/ODR-16', '2024-05-30', 'sai subha', 30, 872.8, 0, 872.8, 47),
('ODR2425-00000019', 'RPC/2425/ODR-19', '2024-06-11', 'Bharanidaran Gopalakrishnan', 30, 71065.6, 0, 71065.6, 35);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_order_due_rpt_nafUsG`
--

CREATE TABLE `tmp_order_due_rpt_nafUsG` (
  `OrderID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderNo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `LedgerName` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreditDays` int DEFAULT '0',
  `OrderValue` double DEFAULT '0',
  `PaidAmount` double DEFAULT '0',
  `BalanceAmount` double DEFAULT '0',
  `DaysOutstanding` int DEFAULT '0'
) ENGINE=InnoDB ;

--
-- Dumping data for table `tmp_order_due_rpt_nafUsG`
--

INSERT INTO `tmp_order_due_rpt_nafUsG` (`OrderID`, `OrderNo`, `OrderDate`, `LedgerName`, `CreditDays`, `OrderValue`, `PaidAmount`, `BalanceAmount`, `DaysOutstanding`) VALUES
('ODR2425-00000001', 'RPC/2425/ODR-1', '2024-04-10', 'Nikhil K', 30, 15175, 0, 15175, 97),
('ODR2425-00000004', 'RPC/2425/ODR-4', '2024-04-17', 'Praba', 30, 16107.2, 10000, 6107.200000000001, 90),
('ODR2425-00000007', 'RPC/2425/ODR-7', '2024-05-08', 'rpc retail', 30, 9040, 0, 9040, 69),
('ODR2425-00000008', 'RPC/2425/ODR-8', '2024-05-08', 'rpc retail', 30, 3633.6, 0, 3633.6, 69),
('ODR2425-00000009', 'RPC/2425/ODR-9', '2024-05-13', 'MobileTeam', 30, 8400, 0, 8400, 64),
('ODR2425-00000012', 'RPC/2425/ODR-12', '2024-05-23', 'rpcsoftware', 30, 7885.3, 0, 7885.3, 54),
('ODR2425-00000014', 'RPC/2425/ODR-14', '2024-05-23', 'Praba', 30, 1716, 0, 1716, 54),
('ODR2425-00000016', 'RPC/2425/ODR-16', '2024-05-30', 'sai subha', 30, 872.8, 0, 872.8, 47),
('ODR2425-00000019', 'RPC/2425/ODR-19', '2024-06-11', 'Bharanidaran Gopalakrishnan', 30, 71065.6, 0, 71065.6, 35);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_order_due_rpt_qRc2Se`
--

CREATE TABLE `tmp_order_due_rpt_qRc2Se` (
  `OrderID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderNo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `LedgerName` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreditDays` int DEFAULT '0',
  `OrderValue` double DEFAULT '0',
  `PaidAmount` double DEFAULT '0',
  `BalanceAmount` double DEFAULT '0',
  `DaysOutstanding` int DEFAULT '0'
) ENGINE=InnoDB ;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_order_due_rpt_r4nxlp`
--

CREATE TABLE `tmp_order_due_rpt_r4nxlp` (
  `OrderID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderNo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `LedgerName` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreditDays` int DEFAULT '0',
  `OrderValue` double DEFAULT '0',
  `PaidAmount` double DEFAULT '0',
  `BalanceAmount` double DEFAULT '0',
  `DaysOutstanding` int DEFAULT '0'
) ENGINE=InnoDB ;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_order_due_rpt_rWXSJW`
--

CREATE TABLE `tmp_order_due_rpt_rWXSJW` (
  `OrderID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderNo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `LedgerName` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreditDays` int DEFAULT '0',
  `OrderValue` double DEFAULT '0',
  `PaidAmount` double DEFAULT '0',
  `BalanceAmount` double DEFAULT '0',
  `DaysOutstanding` int DEFAULT '0'
) ENGINE=InnoDB ;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_order_due_rpt_SUHSqq`
--

CREATE TABLE `tmp_order_due_rpt_SUHSqq` (
  `OrderID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderNo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `LedgerName` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreditDays` int DEFAULT '0',
  `OrderValue` double DEFAULT '0',
  `PaidAmount` double DEFAULT '0',
  `BalanceAmount` double DEFAULT '0',
  `DaysOutstanding` int DEFAULT '0'
) ENGINE=InnoDB ;

--
-- Dumping data for table `tmp_order_due_rpt_SUHSqq`
--

INSERT INTO `tmp_order_due_rpt_SUHSqq` (`OrderID`, `OrderNo`, `OrderDate`, `LedgerName`, `CreditDays`, `OrderValue`, `PaidAmount`, `BalanceAmount`, `DaysOutstanding`) VALUES
('ODR2425-00000001', 'RPC/2425/ODR-1', '2024-04-10', 'Nikhil K', 30, 15175, 0, 15175, 97),
('ODR2425-00000004', 'RPC/2425/ODR-4', '2024-04-17', 'Praba', 30, 16107.2, 10000, 6107.200000000001, 90),
('ODR2425-00000007', 'RPC/2425/ODR-7', '2024-05-08', 'rpc retail', 30, 9040, 0, 9040, 69),
('ODR2425-00000008', 'RPC/2425/ODR-8', '2024-05-08', 'rpc retail', 30, 3633.6, 0, 3633.6, 69),
('ODR2425-00000009', 'RPC/2425/ODR-9', '2024-05-13', 'MobileTeam', 30, 8400, 0, 8400, 64),
('ODR2425-00000012', 'RPC/2425/ODR-12', '2024-05-23', 'rpcsoftware', 30, 7885.3, 0, 7885.3, 54),
('ODR2425-00000014', 'RPC/2425/ODR-14', '2024-05-23', 'Praba', 30, 1716, 0, 1716, 54),
('ODR2425-00000016', 'RPC/2425/ODR-16', '2024-05-30', 'sai subha', 30, 872.8, 0, 872.8, 47),
('ODR2425-00000019', 'RPC/2425/ODR-19', '2024-06-11', 'Bharanidaran Gopalakrishnan', 30, 71065.6, 0, 71065.6, 35);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_order_due_rpt_VnQNez`
--

CREATE TABLE `tmp_order_due_rpt_VnQNez` (
  `OrderID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderNo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `LedgerName` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreditDays` int DEFAULT '0',
  `OrderValue` double DEFAULT '0',
  `PaidAmount` double DEFAULT '0',
  `BalanceAmount` double DEFAULT '0',
  `DaysOutstanding` int DEFAULT '0'
) ENGINE=InnoDB ;

--
-- Dumping data for table `tmp_order_due_rpt_VnQNez`
--

INSERT INTO `tmp_order_due_rpt_VnQNez` (`OrderID`, `OrderNo`, `OrderDate`, `LedgerName`, `CreditDays`, `OrderValue`, `PaidAmount`, `BalanceAmount`, `DaysOutstanding`) VALUES
('ODR2425-00000001', 'RPC/2425/ODR-1', '2024-04-10', 'Nikhil K', 30, 15175, 0, 15175, 146),
('ODR2425-00000004', 'RPC/2425/ODR-4', '2024-04-17', 'Praba', 30, 16107.2, 10000, 6107.200000000001, 139),
('ODR2425-00000007', 'RPC/2425/ODR-7', '2024-05-08', 'rpc retail', 30, 9040, 0, 9040, 118),
('ODR2425-00000008', 'RPC/2425/ODR-8', '2024-05-08', 'rpc retail', 30, 3633.6, 0, 3633.6, 118),
('ODR2425-00000009', 'RPC/2425/ODR-9', '2024-05-13', 'MobileTeam', 30, 8400, 0, 8400, 113),
('ODR2425-00000012', 'RPC/2425/ODR-12', '2024-05-23', 'rpcsoftware', 30, 7885.3, 0, 7885.3, 103),
('ODR2425-00000014', 'RPC/2425/ODR-14', '2024-05-23', 'Praba', 30, 1716, 0, 1716, 103),
('ODR2425-00000016', 'RPC/2425/ODR-16', '2024-05-30', 'sai subha', 30, 872.8, 0, 872.8, 96),
('ODR2425-00000019', 'RPC/2425/ODR-19', '2024-06-11', 'Bharanidaran Gopalakrishnan', 30, 71065.6, 0, 71065.6, 84),
('ODR2425-00000021', 'RPC/2425/ODR-21', '2024-07-20', 'RPC BS', 30, 69800, 0, 69800, 45),
('ODR2425-00000022', 'RPC/2425/ODR-22', '2024-08-16', 'Sai subha', 30, 10818.4, 0, 10818.4, 18),
('ODR2425-00000024', 'RPC/2425/ODR-24', '2024-08-17', 'rpc retail', 30, 4410.4, 0, 4410.4, 17),
('ODR2425-00000025', 'RPC/2425/ODR-25', '2024-08-29', 'rpc retail', 30, 5058.4, 0, 5058.4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_order_due_rpt_yNt7T4`
--

CREATE TABLE `tmp_order_due_rpt_yNt7T4` (
  `OrderID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderNo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `LedgerName` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `CreditDays` int DEFAULT '0',
  `OrderValue` double DEFAULT '0',
  `PaidAmount` double DEFAULT '0',
  `BalanceAmount` double DEFAULT '0',
  `DaysOutstanding` int DEFAULT '0'
) ENGINE=InnoDB ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `tbl_products_variation`
--
ALTER TABLE `tbl_products_variation`
  ADD PRIMARY KEY (`VariationID`);

--
-- Indexes for table `tbl_product_save_status`
--
ALTER TABLE `tbl_product_save_status`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `tbl_vendors`
--
ALTER TABLE `tbl_vendors`
  ADD PRIMARY KEY (`VendorID`);

--
-- Indexes for table `tbl_vendors_service_locations`
--
ALTER TABLE `tbl_vendors_service_locations`
  ADD PRIMARY KEY (`SNo`);

--
-- Indexes for table `tbl_vendors_stock_point`
--
ALTER TABLE `tbl_vendors_stock_point`
  ADD PRIMARY KEY (`SNo`);

--
-- Indexes for table `tbl_vendors_supply`
--
ALTER TABLE `tbl_vendors_supply`
  ADD PRIMARY KEY (`DetailID`);

--
-- Indexes for table `tbl_vendors_vehicle`
--
ALTER TABLE `tbl_vendors_vehicle`
  ADD PRIMARY KEY (`SNo`);

--
-- Indexes for table `tbl_vendors_vehicle_images`
--
ALTER TABLE `tbl_vendors_vehicle_images`
  ADD PRIMARY KEY (`SNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_vendors_service_locations`
--
ALTER TABLE `tbl_vendors_service_locations`
  MODIFY `SNo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=498;

--
-- AUTO_INCREMENT for table `tbl_vendors_stock_point`
--
ALTER TABLE `tbl_vendors_stock_point`
  MODIFY `SNo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `tbl_vendors_supply`
--
ALTER TABLE `tbl_vendors_supply`
  MODIFY `DetailID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1711;

--
-- AUTO_INCREMENT for table `tbl_vendors_vehicle`
--
ALTER TABLE `tbl_vendors_vehicle`
  MODIFY `SNo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_vendors_vehicle_images`
--
ALTER TABLE `tbl_vendors_vehicle_images`
  MODIFY `SNo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
