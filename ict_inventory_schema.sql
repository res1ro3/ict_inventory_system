-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2023 at 10:06 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

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
  `generic_name` varchar(128) NOT NULL,
  `employee_id` varchar(128) NOT NULL,
  `unit` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `specifications` varchar(32) NOT NULL,
  `brand` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_tbl`
--

CREATE TABLE `employee_tbl` (
  `employee_id` varchar(128) NOT NULL,
  `lname` varchar(64) NOT NULL,
  `fname` varchar(64) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `unitOffice` varchar(128) NOT NULL,
  `position` varchar(128) NOT NULL,
  `type_of_employment` varchar(128) NOT NULL,
  `sex` varchar(32) NOT NULL,
  `type_of_account` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_tbl`
--

INSERT INTO `employee_tbl` (`employee_id`, `lname`, `fname`, `username`, `password`, `unitOffice`, `position`, `type_of_employment`, `sex`, `type_of_account`) VALUES
('id1', 'Benedicto', 'John Benedict', 'jbenedicto13', '12345678', 'Management Information System Unit', 'Position 1', 'Type of Employment 1', 'Male', 'Admin'),
('id2', 'Dela Cruz', 'Juan', 'Juan234', 'Juan234', 'Management Information System Unit', 'Position 1', 'Type of Employment 1', 'Male', 'Admin'),
('id3', 'Salvi', 'Pedro', 'PedroS', '12345678', 'Management Information System Unit', 'Position 1', 'Type of Employment 1', 'Male', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `ict_network_hardware_tbl`
--

CREATE TABLE `ict_network_hardware_tbl` (
  `mac_address` varchar(32) NOT NULL,
  `type_of_hardware` varchar(32) NOT NULL,
  `brand` varchar(64) NOT NULL,
  `model` varchar(64) NOT NULL,
  `serial_number` varchar(128) NOT NULL,
  `date_of_purchase` varchar(32) NOT NULL,
  `warranty` varchar(32) NOT NULL,
  `employee_id` varchar(128) NOT NULL,
  `status` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ict_transfer_tbl`
--

CREATE TABLE `ict_transfer_tbl` (
  `transfer_id` varchar(64) NOT NULL,
  `employee_id_new` varchar(128) NOT NULL,
  `employee_id_old` varchar(128) NOT NULL,
  `date_transferred` varchar(32) NOT NULL,
  `mac_address` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Management Information System Unit');

-- --------------------------------------------------------

--
-- Table structure for table `resource_sharing_tbl`
--

CREATE TABLE `resource_sharing_tbl` (
  `resource_share_id` varchar(32) NOT NULL,
  `mac_address` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `employee_id` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services_tbl`
--

CREATE TABLE `services_tbl` (
  `services_id` varchar(32) NOT NULL,
  `type_of_services` varchar(32) NOT NULL,
  `mac_address` varchar(32) NOT NULL,
  `generic_name` varchar(128) NOT NULL,
  `date_received` varchar(32) NOT NULL,
  `date_returned` varchar(32) NOT NULL,
  `description_of_service` varchar(256) NOT NULL,
  `action_done` varchar(256) NOT NULL,
  `recommendation` varchar(256) NOT NULL,
  `ict_resources` varchar(64) NOT NULL,
  `type_of_ict` varchar(32) NOT NULL,
  `employee_id` varchar(128) NOT NULL,
  `processed_by` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `software_tbl`
--

CREATE TABLE `software_tbl` (
  `software_id` varchar(32) NOT NULL,
  `software_name` varchar(64) NOT NULL,
  `date_developed_purchased` varchar(32) NOT NULL,
  `employee_id` varchar(128) NOT NULL,
  `type_of_software` varchar(64) NOT NULL,
  `type_of_subscription` varchar(64) NOT NULL,
  `manufacturer` varchar(64) NOT NULL,
  `type_developed` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplies_tools_tbl`
--

CREATE TABLE `supplies_tools_tbl` (
  `supply_tools_id` varchar(64) NOT NULL,
  `type_of_supply_tools` varchar(64) NOT NULL,
  `employee_id` varchar(128) NOT NULL,
  `unit` varchar(32) NOT NULL,
  `quantity` int(11) NOT NULL,
  `specifications_remarks` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessories_tbl`
--
ALTER TABLE `accessories_tbl`
  ADD PRIMARY KEY (`generic_name`),
  ADD KEY `fk_accessories_employee_id` (`employee_id`);

--
-- Indexes for table `employee_tbl`
--
ALTER TABLE `employee_tbl`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `ict_network_hardware_tbl`
--
ALTER TABLE `ict_network_hardware_tbl`
  ADD PRIMARY KEY (`mac_address`),
  ADD KEY `employee_id` (`employee_id`) USING BTREE;

--
-- Indexes for table `ict_transfer_tbl`
--
ALTER TABLE `ict_transfer_tbl`
  ADD PRIMARY KEY (`transfer_id`),
  ADD KEY `fk_transfer_old_employee_id` (`employee_id_new`),
  ADD KEY `fk_transfer_new_employee_id` (`employee_id_old`),
  ADD KEY `fk_transfer_mac_address` (`mac_address`);

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
  ADD KEY `fk_resource_employee_id` (`employee_id`);

--
-- Indexes for table `services_tbl`
--
ALTER TABLE `services_tbl`
  ADD PRIMARY KEY (`services_id`),
  ADD KEY `fk_services_employee_id` (`employee_id`),
  ADD KEY `fk_services_generic_name` (`generic_name`),
  ADD KEY `mac_address` (`mac_address`) USING BTREE;

--
-- Indexes for table `software_tbl`
--
ALTER TABLE `software_tbl`
  ADD PRIMARY KEY (`software_id`),
  ADD KEY `fk_software_employee_id` (`employee_id`);

--
-- Indexes for table `supplies_tools_tbl`
--
ALTER TABLE `supplies_tools_tbl`
  ADD KEY `fk_supply_employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `office_tbl`
--
ALTER TABLE `office_tbl`
  MODIFY `office_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accessories_tbl`
--
ALTER TABLE `accessories_tbl`
  ADD CONSTRAINT `fk_accessories_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employee_tbl` (`employee_Id`);

--
-- Constraints for table `ict_network_hardware_tbl`
--
ALTER TABLE `ict_network_hardware_tbl`
  ADD CONSTRAINT `fk_ict_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employee_tbl` (`employee_Id`);

--
-- Constraints for table `ict_transfer_tbl`
--
ALTER TABLE `ict_transfer_tbl`
  ADD CONSTRAINT `fk_transfer_mac_address` FOREIGN KEY (`mac_address`) REFERENCES `employee_tbl` (`employee_Id`),
  ADD CONSTRAINT `fk_transfer_new_employee_id` FOREIGN KEY (`employee_id_old`) REFERENCES `employee_tbl` (`employee_Id`),
  ADD CONSTRAINT `fk_transfer_old_employee_id` FOREIGN KEY (`employee_id_new`) REFERENCES `employee_tbl` (`employee_Id`);

--
-- Constraints for table `resource_sharing_tbl`
--
ALTER TABLE `resource_sharing_tbl`
  ADD CONSTRAINT `fk_resource_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employee_tbl` (`employee_Id`),
  ADD CONSTRAINT `fk_resource_mac_address` FOREIGN KEY (`mac_address`) REFERENCES `ict_network_hardware_tbl` (`mac_address`);

--
-- Constraints for table `services_tbl`
--
ALTER TABLE `services_tbl`
  ADD CONSTRAINT `fk_services_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employee_tbl` (`employee_Id`),
  ADD CONSTRAINT `fk_services_generic_name` FOREIGN KEY (`generic_name`) REFERENCES `accessories_tbl` (`generic_name`),
  ADD CONSTRAINT `fk_services_mac_address` FOREIGN KEY (`mac_address`) REFERENCES `ict_network_hardware_tbl` (`mac_address`);

--
-- Constraints for table `software_tbl`
--
ALTER TABLE `software_tbl`
  ADD CONSTRAINT `fk_software_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employee_tbl` (`employee_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
