-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2020 at 10:33 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `example`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customer_id` varchar(11) NOT NULL,
  `contact_name` text NOT NULL,
  `contact_number` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`id`, `created_at`, `modifed_at`, `customer_id`, `contact_name`, `contact_number`) VALUES
(1, '2020-11-15 16:57:29', '2020-11-15 16:57:29', 'C11233', 'Mr John Doe', '7784051');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customer_id` varchar(11) NOT NULL,
  `customer_type` text NOT NULL,
  `date_of_birth` date NOT NULL,
  `date_incorp` date NOT NULL,
  `registration_no` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `created_at`, `modified_at`, `customer_id`, `customer_type`, `date_of_birth`, `date_incorp`, `registration_no`) VALUES
(1, '2020-11-15 16:57:29', '2020-11-15 16:57:29', 'C11233', 'Individual', '1987-07-19', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `log_error`
--

CREATE TABLE `log_error` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `message` text NOT NULL,
  `error_code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log_error`
--

INSERT INTO `log_error` (`id`, `created_at`, `message`, `error_code`) VALUES
(1, '2020-11-15 16:58:41', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(2, '2020-11-15 16:58:57', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(3, '2020-11-15 16:58:58', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(4, '2020-11-15 16:59:01', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(5, '2020-11-15 16:59:06', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(6, '2020-11-15 16:59:07', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(7, '2020-11-15 16:59:31', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(8, '2020-11-15 16:59:32', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(9, '2020-11-15 16:59:36', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(10, '2020-11-15 16:59:37', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(11, '2020-11-15 16:59:38', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(12, '2020-11-15 17:03:37', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(13, '2020-11-15 17:04:26', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(14, '2020-11-15 17:05:34', '', ''),
(15, '2020-11-15 17:06:14', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(16, '2020-11-15 17:06:16', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(17, '2020-11-15 17:06:52', 'No file was found', '400 Bad Request'),
(18, '2020-11-15 17:06:57', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(19, '2020-11-15 17:07:24', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(20, '2020-11-15 17:07:29', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(21, '2020-11-15 17:07:30', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(22, '2020-11-15 17:07:32', 'Extension not allowed, please choose a xml.', '415 Unsupported Media Type'),
(23, '2020-11-15 17:07:57', 'No file was found', '400 Bad Request');

-- --------------------------------------------------------

--
-- Table structure for table `mailing_address`
--

CREATE TABLE `mailing_address` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customer_id` varchar(11) NOT NULL,
  `address_line1` text NOT NULL,
  `address_line2` text NOT NULL,
  `town_city` text NOT NULL,
  `country` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mailing_address`
--

INSERT INTO `mailing_address` (`id`, `created_at`, `modifed_at`, `customer_id`, `address_line1`, `address_line2`, `town_city`, `country`) VALUES
(1, '2020-11-15 16:57:29', '2020-11-15 16:57:29', 'C11233', '21', 'Downing Street', 'London', 'England');

-- --------------------------------------------------------

--
-- Table structure for table `shares_details`
--

CREATE TABLE `shares_details` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customer_id` varchar(11) NOT NULL,
  `num_shares` int(11) NOT NULL,
  `share_price` decimal(10,2) NOT NULL,
  `balance` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shares_details`
--

INSERT INTO `shares_details` (`id`, `created_at`, `modifed_at`, `customer_id`, `num_shares`, `share_price`, `balance`) VALUES
(1, '2020-11-15 16:57:29', '2020-11-15 19:12:19', 'C11233', 10, '30.00', '300');

-- --------------------------------------------------------

--
-- Table structure for table `xml_details`
--

CREATE TABLE `xml_details` (
  `id` int(11) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `doc_name` text NOT NULL,
  `doc_date` timestamp NULL DEFAULT NULL,
  `doc_ref` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xml_details`
--

INSERT INTO `xml_details` (`id`, `uploaded_at`, `doc_name`, `doc_date`, `doc_ref`) VALUES
(1, '2020-11-15 16:57:29', 'McShares_2018.xml', '2013-10-14 08:16:33', 'SH1310140001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`);

--
-- Indexes for table `log_error`
--
ALTER TABLE `log_error`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mailing_address`
--
ALTER TABLE `mailing_address`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`);

--
-- Indexes for table `shares_details`
--
ALTER TABLE `shares_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xml_details`
--
ALTER TABLE `xml_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `log_error`
--
ALTER TABLE `log_error`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `mailing_address`
--
ALTER TABLE `mailing_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shares_details`
--
ALTER TABLE `shares_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xml_details`
--
ALTER TABLE `xml_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
