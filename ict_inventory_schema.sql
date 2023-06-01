-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2023 at 09:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ict_inventory_schema`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessories_tbl`
--

CREATE TABLE `accessories_tbl` (
  `accessories_id` int(8) NOT NULL,
  `generic_name` varchar(128) NOT NULL,
  `employee_id` int(8) NOT NULL,
  `unit` varchar(128) NOT NULL,
  `quantity` int(11) NOT NULL,
  `specifications` varchar(32) NOT NULL,
  `brand` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accessories_tbl`
--

INSERT INTO `accessories_tbl` (`accessories_id`, `generic_name`, `employee_id`, `unit`, `quantity`, `specifications`, `brand`) VALUES
(2, 'HDMI', 3, 'Office of the Regional Director', 3, 'HDMI v1', 'No Brand'),
(3, 'Headset', 2, 'Administrative Division', 4, 'HQ Sound', 'Logitech');

-- --------------------------------------------------------

--
-- Table structure for table `brand_tbl`
--

CREATE TABLE `brand_tbl` (
  `brand_id` int(16) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand_tbl`
--

INSERT INTO `brand_tbl` (`brand_id`, `name`) VALUES
(1, 'HP'),
(2, 'Dell'),
(8, 'Acer'),
(9, 'Cisco'),
(10, 'Starlink'),
(11, 'Starbooks'),
(12, 'Ferrari'),
(13, 'Bugatti'),
(14, 'BMW'),
(15, 'Intel'),
(16, 'Microsoft'),
(17, 'Linux'),
(19, 'Brand X');

-- --------------------------------------------------------

--
-- Table structure for table `employee_tbl`
--

CREATE TABLE `employee_tbl` (
  `employee_id` int(8) NOT NULL,
  `lname` varchar(64) NOT NULL,
  `fname` varchar(64) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `unitOffice` varchar(128) NOT NULL,
  `position` varchar(128) NOT NULL,
  `type_of_employment` varchar(128) NOT NULL,
  `sex` varchar(32) NOT NULL,
  `type_of_account` varchar(32) NOT NULL,
  `status` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_tbl`
--

INSERT INTO `employee_tbl` (`employee_id`, `lname`, `fname`, `username`, `password`, `unitOffice`, `position`, `type_of_employment`, `sex`, `type_of_account`, `status`) VALUES
(1, 'Super', 'Admin', 'Super', '$argon2id$v=19$m=65536,t=4,p=1$anYwMVF5RVpNNXBNamhZMQ$/I62hirjTRTl94ZMrqqPhMUfTbfGSCGZfqM8eSVm3p0', 'Office of the Regional Director', 'Position 1', 'Regular', 'Male', 'Super Admin', 'Active'),
(2, 'Yumeko', 'Jabami', 'Yumeko', '$argon2id$v=19$m=65536,t=4,p=1$cnlBeTJWWnhBY1lPQVVkeQ$4SLG8GSuGfOq5d8Pef9VE1LX+K6gcCmJreUtq5AjxoE', 'Office of the Regional Director', 'Position 1', 'Regular', 'Female', 'Admin', 'Active'),
(3, 'Uzumaki', 'Naruto', 'Naruto', '$argon2id$v=19$m=65536,t=4,p=1$bFBaYi9tWlRCWDlmbnA3OA$X2Qa86AQXgIec/9tY9SUsbB92QmHMAlkq3hLARlbrCY', 'Administrative Division', 'Position 2', 'Regular', 'Male', 'Ordinary User', 'Active'),
(4, 'Dela Cruz', 'Juan', 'Juan', '$argon2id$v=19$m=65536,t=4,p=1$bnBSMTFZOWhUUHN4TXNFSg$xHeKJCeapBz6jauNfwH8BzxVoNOS2IbLL2u39GpK638', 'Technical Division', 'Position 3', 'COS', 'Male', 'Ordinary User', 'Active'),
(5, 'Benedicto', 'John Benedict', 'jbenedicto13', '$argon2id$v=19$m=65536,t=4,p=1$elIudnNpc0lDWUtnRTNZOA$sbNew1mIyaYFSCgreHTwKgOfut6Kki8xoA/1SWtSiPk', 'Office of the Regional Director', 'Position 1', 'Regular', 'Male', 'Admin', 'Active'),
(6, 'Admin', 'Admin', 'Admin', '$argon2id$v=19$m=65536,t=4,p=1$bDBBWVh0bG43ZzVsOEMvSw$utx9DnuyQGRpUzpTMqYIhRywuy0XTMPLypY20qvtYug', 'Office of the Regional Director', 'Position 2', 'Regular', 'Female', 'Admin', 'Active'),
(8, 'Manalang', 'Paulo', 'paulo123456', '$argon2id$v=19$m=65536,t=4,p=1$WTYyLnh1MDhRalk1M0Z2Sg$EBKO5X/8Gx93Z2f7YURQ2LbKkW2nzvoprlh1vhF49C8', 'Office of the Regional Director', '', 'COS', 'Male', 'Admin', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `ict_network_hardware_tbl`
--

CREATE TABLE `ict_network_hardware_tbl` (
  `hardware_id` int(8) NOT NULL,
  `mac_address` varchar(32) NOT NULL,
  `type_of_hardware` varchar(32) NOT NULL,
  `brand` varchar(64) NOT NULL,
  `model` varchar(64) NOT NULL,
  `serial_number` varchar(128) NOT NULL,
  `date_of_purchase` varchar(32) NOT NULL,
  `warranty` varchar(32) NOT NULL,
  `employee_id` int(8) NOT NULL,
  `status` varchar(32) NOT NULL,
  `owner_name` varchar(64) NOT NULL,
  `specifications` varchar(256) NOT NULL,
  `cost` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ict_network_hardware_tbl`
--

INSERT INTO `ict_network_hardware_tbl` (`hardware_id`, `mac_address`, `type_of_hardware`, `brand`, `model`, `serial_number`, `date_of_purchase`, `warranty`, `employee_id`, `status`, `owner_name`, `specifications`, `cost`) VALUES
(1, '78-9F-BD-88-5E-A1', 'Desktop', 'Acer', 'Model A', 'sdfe4w23dsf', '2023-05-25', '2024-05-25', 5, 'Serviceable', '3', 'Specs here', 45000),
(2, '68-9F-BD-88-5E-A0', 'Laptop', 'Dell', 'Model B', 'sdfe4w23dsg', '2023-05-25', '2024-05-25', 2, 'Non-Serviceable', '2', '8GB RAM, Ryzen 7', 100000),
(3, '43-F8-6A-1T-2S-3A', 'Printer', 'HP', 'Printer X', 'p4r56i7n0t3e1r', '2023-05-25', '2024-05-25', 2, 'Serviceable', '8', 'High Quality Laser Printer, With Washing Machine', 30000);

-- --------------------------------------------------------

--
-- Table structure for table `ict_transfer_tbl`
--

CREATE TABLE `ict_transfer_tbl` (
  `transfer_id` int(8) NOT NULL,
  `employee_id_new` int(8) NOT NULL,
  `employee_id_old` int(8) NOT NULL,
  `ict_id` int(8) NOT NULL,
  `ict_type` varchar(32) NOT NULL,
  `date_transferred` varchar(32) NOT NULL,
  `new_owner` varchar(128) NOT NULL,
  `old_owner` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ict_transfer_tbl`
--

INSERT INTO `ict_transfer_tbl` (`transfer_id`, `employee_id_new`, `employee_id_old`, `ict_id`, `ict_type`, `date_transferred`, `new_owner`, `old_owner`) VALUES
(51, 2, 8, 3, '', '2023-06-01', '', ''),
(52, 5, 2, 1, '', '2023-06-01', '', ''),
(53, 4, 2, 3, '', '2023-06-01', '', ''),
(54, 3, 2, 2, '', '2023-06-01', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `office_tbl`
--

CREATE TABLE `office_tbl` (
  `office_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `office_tbl`
--

INSERT INTO `office_tbl` (`office_id`, `name`) VALUES
(2, 'Office of the Regional Director'),
(3, 'Administrative Division'),
(4, 'Technical Division'),
(5, 'Cashier'),
(6, 'SETUP Unit'),
(7, 'CLHRDC'),
(8, 'CEST Unit'),
(9, 'RSTL'),
(10, 'Scholarship Unit'),
(11, 'Conference');

-- --------------------------------------------------------

--
-- Table structure for table `resource_sharing_tbl`
--

CREATE TABLE `resource_sharing_tbl` (
  `resource_share_id` varchar(32) NOT NULL,
  `mac_address` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `employee_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services_tbl`
--

CREATE TABLE `services_tbl` (
  `services_id` int(8) NOT NULL,
  `type_of_services` varchar(32) NOT NULL,
  `ICT_ID` varchar(64) NOT NULL,
  `date_received` varchar(32) NOT NULL,
  `date_returned` varchar(32) NOT NULL,
  `description_of_service` varchar(256) NOT NULL,
  `action_done` varchar(256) NOT NULL,
  `remarks` varchar(256) NOT NULL,
  `recommendation` varchar(256) NOT NULL,
  `type_of_ict` varchar(32) NOT NULL,
  `employee_id` int(8) NOT NULL,
  `processed_by` varchar(128) NOT NULL,
  `service_status` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services_tbl`
--

INSERT INTO `services_tbl` (`services_id`, `type_of_services`, `ICT_ID`, `date_received`, `date_returned`, `description_of_service`, `action_done`, `remarks`, `recommendation`, `type_of_ict`, `employee_id`, `processed_by`, `service_status`) VALUES
(27, 'Repair', '1', '2023-05-25', '', '123123123', 'Erase the RAM with pencil eraser', 'asdasdasd', 'Clean the unit', 'Hardware', 1, 'MIS Unit', 'Pending'),
(29, 'Repair', '1', '2023-05-26', '2023-05-27', 'qwerty', 'dasdasd', 'asdasdasd', 'asdasdasd', 'Hardware', 1, 'MIS Unit', 'Finished'),
(30, 'Repair', '2', '2023-05-29', '', 'aas', 'dasdassdasd', 'asda', 'asdasd', 'Hardware', 1, 'MIS Unit', 'Pending'),
(33, 'Repair', '1', '2023-05-29', '', 'asd', 'asdasdasd', 'qweqweqwe', '12341231', 'Hardware', 1, 'MIS Unit', 'Pending'),
(34, 'Installation', '2', '2023-05-31', '2023-05-31', 'Install Photoshop', 'Install Photoshop', 'Install Photoshop', 'Install Photoshop', 'Software', 1, 'MIS Unit', 'Finished'),
(36, 'Maintenance', '3', '2023-05-31', '', 'asd', 'asd', 'q2312', '123123', 'Hardware', 1, 'MIS Unit', 'Pending'),
(37, 'Repair', '2', '2023-05-31', '', 'Can\'t Open', 'Can\'t Open', 'Can\'t Open', 'Can\'t Open', 'Software', 1, 'MIS Unit', 'Pending'),
(41, 'Repair', '3', '2023-06-01', '', 'asdasd', 'asdasd', '123412', 'asdasd', 'Accessories', 1, 'MIS Unit', 'On Going'),
(42, 'Repair', '2', '2023-06-08', '2023-06-04', 'asd123123123', 'asdasdasd', 'asdasdasdasd', 'as123123123', 'Accessories', 1, '123123123123', 'Finished');

-- --------------------------------------------------------

--
-- Table structure for table `software_tbl`
--

CREATE TABLE `software_tbl` (
  `software_id` int(8) NOT NULL,
  `software_name` varchar(64) NOT NULL,
  `date_developed_purchased` varchar(32) NOT NULL,
  `employee_id` int(8) NOT NULL,
  `type_of_software` varchar(64) NOT NULL,
  `type_of_subscription` varchar(64) NOT NULL,
  `manufacturer` varchar(64) NOT NULL,
  `type_developed` varchar(64) NOT NULL,
  `owner_name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `software_tbl`
--

INSERT INTO `software_tbl` (`software_id`, `software_name`, `date_developed_purchased`, `employee_id`, `type_of_software`, `type_of_subscription`, `manufacturer`, `type_developed`, `owner_name`) VALUES
(2, 'Photoshop 2023', '2023-10-10', 3, 'Editing', 'Yearly', 'Adobe', 'Lorem Ipsum', 'JB'),
(3, 'Illustrator', '2023-05-31', 4, 'Editing', 'Monthly', 'Adobe', '', ''),
(4, 'asd', '2023-05-31', 5, 'Productivity', 'Monthly', 'asdasd', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `supplies_tools_tbl`
--

CREATE TABLE `supplies_tools_tbl` (
  `supply_tools_id` varchar(64) NOT NULL,
  `type_of_supply_tools` varchar(64) NOT NULL,
  `employee_id` int(8) NOT NULL,
  `unit` varchar(32) NOT NULL,
  `quantity` int(11) NOT NULL,
  `specifications_remarks` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `type_of_hardware_tbl`
--

CREATE TABLE `type_of_hardware_tbl` (
  `type_of_hardware_id` int(8) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type_of_hardware_tbl`
--

INSERT INTO `type_of_hardware_tbl` (`type_of_hardware_id`, `name`) VALUES
(1, 'Desktop'),
(2, 'Laptop'),
(3, 'Printer'),
(4, 'Scanner'),
(5, 'NAS'),
(6, 'CCTV'),
(7, 'Server'),
(8, 'Router'),
(9, 'Switch'),
(10, 'Firewall'),
(11, 'Conference Microphone System');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessories_tbl`
--
ALTER TABLE `accessories_tbl`
  ADD PRIMARY KEY (`accessories_id`),
  ADD KEY `fk_employee_id` (`employee_id`);

--
-- Indexes for table `brand_tbl`
--
ALTER TABLE `brand_tbl`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `employee_tbl`
--
ALTER TABLE `employee_tbl`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `ict_network_hardware_tbl`
--
ALTER TABLE `ict_network_hardware_tbl`
  ADD PRIMARY KEY (`hardware_id`),
  ADD KEY `fk_employee_id_hardware` (`employee_id`);

--
-- Indexes for table `ict_transfer_tbl`
--
ALTER TABLE `ict_transfer_tbl`
  ADD PRIMARY KEY (`transfer_id`),
  ADD KEY `fk_employee_id_old` (`employee_id_old`),
  ADD KEY `fk_employee_id_new` (`employee_id_new`);

--
-- Indexes for table `office_tbl`
--
ALTER TABLE `office_tbl`
  ADD PRIMARY KEY (`office_id`);

--
-- Indexes for table `resource_sharing_tbl`
--
ALTER TABLE `resource_sharing_tbl`
  ADD KEY `fk_resource_mac_address` (`mac_address`),
  ADD KEY `fk_employee_id_` (`employee_id`);

--
-- Indexes for table `services_tbl`
--
ALTER TABLE `services_tbl`
  ADD PRIMARY KEY (`services_id`),
  ADD KEY `fk_employee_id_service` (`employee_id`);

--
-- Indexes for table `software_tbl`
--
ALTER TABLE `software_tbl`
  ADD PRIMARY KEY (`software_id`),
  ADD KEY `fk_employee_id_software` (`employee_id`);

--
-- Indexes for table `supplies_tools_tbl`
--
ALTER TABLE `supplies_tools_tbl`
  ADD KEY `fk_employee_id_supplies` (`employee_id`);

--
-- Indexes for table `type_of_hardware_tbl`
--
ALTER TABLE `type_of_hardware_tbl`
  ADD PRIMARY KEY (`type_of_hardware_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessories_tbl`
--
ALTER TABLE `accessories_tbl`
  MODIFY `accessories_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `brand_tbl`
--
ALTER TABLE `brand_tbl`
  MODIFY `brand_id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `employee_tbl`
--
ALTER TABLE `employee_tbl`
  MODIFY `employee_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ict_network_hardware_tbl`
--
ALTER TABLE `ict_network_hardware_tbl`
  MODIFY `hardware_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ict_transfer_tbl`
--
ALTER TABLE `ict_transfer_tbl`
  MODIFY `transfer_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `office_tbl`
--
ALTER TABLE `office_tbl`
  MODIFY `office_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `services_tbl`
--
ALTER TABLE `services_tbl`
  MODIFY `services_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `software_tbl`
--
ALTER TABLE `software_tbl`
  MODIFY `software_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `type_of_hardware_tbl`
--
ALTER TABLE `type_of_hardware_tbl`
  MODIFY `type_of_hardware_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accessories_tbl`
--
ALTER TABLE `accessories_tbl`
  ADD CONSTRAINT `fk_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employee_tbl` (`employee_id`);

--
-- Constraints for table `ict_network_hardware_tbl`
--
ALTER TABLE `ict_network_hardware_tbl`
  ADD CONSTRAINT `fk_employee_id_hardware` FOREIGN KEY (`employee_id`) REFERENCES `employee_tbl` (`employee_id`);

--
-- Constraints for table `ict_transfer_tbl`
--
ALTER TABLE `ict_transfer_tbl`
  ADD CONSTRAINT `fk_employee_id_new` FOREIGN KEY (`employee_id_new`) REFERENCES `employee_tbl` (`employee_id`),
  ADD CONSTRAINT `fk_employee_id_old` FOREIGN KEY (`employee_id_old`) REFERENCES `employee_tbl` (`employee_id`);

--
-- Constraints for table `resource_sharing_tbl`
--
ALTER TABLE `resource_sharing_tbl`
  ADD CONSTRAINT `fk_employee_id_` FOREIGN KEY (`employee_id`) REFERENCES `employee_tbl` (`employee_id`),
  ADD CONSTRAINT `fk_resource_mac_address` FOREIGN KEY (`mac_address`) REFERENCES `ict_network_hardware_tbl` (`mac_address`);

--
-- Constraints for table `services_tbl`
--
ALTER TABLE `services_tbl`
  ADD CONSTRAINT `fk_employee_id_service` FOREIGN KEY (`employee_id`) REFERENCES `employee_tbl` (`employee_id`);

--
-- Constraints for table `software_tbl`
--
ALTER TABLE `software_tbl`
  ADD CONSTRAINT `fk_employee_id_software` FOREIGN KEY (`employee_id`) REFERENCES `employee_tbl` (`employee_id`);

--
-- Constraints for table `supplies_tools_tbl`
--
ALTER TABLE `supplies_tools_tbl`
  ADD CONSTRAINT `fk_employee_id_supplies` FOREIGN KEY (`employee_id`) REFERENCES `employee_tbl` (`employee_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
