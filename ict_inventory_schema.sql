-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2023 at 10:31 AM
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

--
-- Dumping data for table `employee_tbl`
--

INSERT INTO `employee_tbl` (`employee_id`, `lname`, `fname`, `username`, `password`, `unitOffice`, `position`, `type_of_employment`, `sex`, `type_of_account`, `status`) VALUES
('id1', 'Benedicto', 'John Benedict', 'jbenedicto13', '$argon2id$v=19$m=65536,t=4,p=1$b', 'Management Information System Unit', 'Position 1', 'Regular', 'Male', 'Admin', 'Active');

--
-- Dumping data for table `ict_network_hardware_tbl`
--

INSERT INTO `ict_network_hardware_tbl` (`mac_address`, `type_of_hardware`, `brand`, `model`, `serial_number`, `date_of_purchase`, `warranty`, `employee_id`, `status`) VALUES
('243656', 'Equipment', 'ACER', '546', '654656', '2023-03-30', '2025-05-30', 'id1', 'Serviceable'),
('34534523', 'Equipment', 'HP', '234', '5646456', '2023-03-30', '2027-11-30', 'id1', 'Serviceable');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
