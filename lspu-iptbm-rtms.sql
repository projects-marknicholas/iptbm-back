-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2025 at 05:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lspu-iptbm-rtms`
--

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `id` int(11) NOT NULL,
  `record_id` varchar(255) NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `technology` varchar(255) NOT NULL,
  `ip_type` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `date_of_filing` datetime NOT NULL,
  `application_no` varchar(255) NOT NULL,
  `abstract` varchar(10000) NOT NULL,
  `inventors` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`id`, `record_id`, `banner_image`, `technology`, `ip_type`, `year`, `date_of_filing`, `application_no`, `abstract`, `inventors`, `status`, `created_at`) VALUES
(9, 'e1e2e0db07ef951a82ccfce04617cde4', '1739516534_67aeea763f5cd.jpg', 'Information Technology', 'Patent', '2024', '2025-02-14 00:00:00', '2024-00567', '&lt;p&gt;&lt;strong&gt;&lt;em&gt;&lt;u&gt;Information Technology&lt;/u&gt;&lt;/em&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;A novel solar panel design that enhances energy conversion efficiency through the use of nanomaterials and adaptive surface coatings.&lt;/p&gt;', 'Ana Lopez, Miguel Cruz, Carla Reyes', 'Live', '2025-02-14 15:02:14'),
(10, '979c190241a482c39ec420b92050df65', '1739516695_67aeeb17dd696.jpg', 'Renewable Energy', 'Patent', '2023', '2023-01-01 00:00:00', '2023-00981', '&lt;p&gt;&lt;strong&gt;&lt;em&gt;&lt;u&gt;&lt;s&gt;Renewable Energy&lt;/s&gt;&lt;/u&gt;&lt;/em&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 12px; font-family: Helvetica, sans-serif;&quot;&gt;A genetically engineered bacterial strain for bioremediation of heavy metal pollutants in wastewater treatment facilities.&lt;/span&gt;&lt;/p&gt;', 'Juan Dela Cruz, Maria Santos, Jose Ramos', 'Finished', '2025-02-14 15:04:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
