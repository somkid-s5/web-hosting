-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 10, 2023 at 04:03 AM
-- Server version: 10.6.12-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jeedhost`
--

-- --------------------------------------------------------

--
-- Table structure for table `renewal_request`
--

CREATE TABLE `renewal_request` (
  `renewal_id` int(11) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `request_date` date NOT NULL DEFAULT current_timestamp(),
  `approve_date` date DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `num_months` int(48) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `renewal_request`
--

INSERT INTO `renewal_request` (`renewal_id`, `service_id`, `request_date`, `approve_date`, `status`, `num_months`) VALUES
(22, 54, '2023-10-09', '2023-10-09', 'Approved', 2);

-- --------------------------------------------------------

--
-- Table structure for table `service_request`
--

CREATE TABLE `service_request` (
  `service_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `domain` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `plan` varchar(20) DEFAULT NULL,
  `option_domain` varchar(1) DEFAULT NULL,
  `objective` varchar(50) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `request_date` date DEFAULT NULL,
  `approve_date` date DEFAULT NULL,
  `due_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_request`
--

INSERT INTO `service_request` (`service_id`, `user_id`, `domain`, `username`, `password`, `plan`, `option_domain`, `objective`, `about`, `status`, `request_date`, `approve_date`, `due_date`) VALUES
(1, 15, 'naver.com', 'Sophia', 'NDL72OSI1JD', 'Upgrade', '2', 'test', 'test', 'Pending', '2024-07-11', '2023-10-18', '2024-06-02 21:06:51'),
(2, 16, 'google.com', 'Cecilia', 'ELK15XVT2QB', 'Upgrade', '2', 'test', 'test', 'Pending', '2022-10-18', '2023-07-16', '2023-03-10 01:29:52'),
(3, 8, 'instagram.com', 'William', 'UEK74FGR2SB', 'Advanced', '2', 'test', 'test', 'Disable', '2024-03-10', '2023-07-01', '2023-03-29 01:47:33'),
(4, 43, 'facebook.com', 'Tamara', 'JFC66DOR0PZ', 'Upgrade', '1', 'test', 'test', 'Disable', '2023-07-09', '2024-04-26', '2024-09-18 01:03:15'),
(5, 7, 'naver.com', 'Keane', 'CPQ17NSQ7QO', 'Advanced', '1', 'test', 'test', 'Approved', '2024-09-25', '2024-08-12', '2023-11-18 07:57:04'),
(6, 38, 'cnn.com', 'Hector', 'YJE67XJT7TI', 'Upgrade', '1', 'test', 'test', 'Approved', '2023-03-04', '2023-09-11', '2024-04-03 10:41:18'),
(7, 49, 'walmart.com', 'Ivan', 'CUI34FDD5TF', 'Upgrade', '1', 'test', 'test', 'Pending', '2024-03-23', '2022-12-21', '2024-10-03 01:18:16'),
(8, 6, 'yahoo.com', 'Roth', 'XFT05FLP3EB', 'Upgrade', '2', 'test', 'test', 'Pending', '2022-12-31', '2023-12-25', '2024-09-05 08:56:04'),
(9, 9, 'instagram.com', 'Winifred', 'MFT48PGD4OD', 'Upgrade', '2', 'test', 'test', 'Disable', '2023-07-26', '2024-07-14', '2023-07-10 16:59:55'),
(10, 27, 'reddit.com', 'Micah', 'HMF01QUW8HS', 'Upgrade', '1', 'test', 'test', 'Disable', '2024-06-19', '2023-02-17', '2024-06-17 01:17:13'),
(11, 10, 'naver.com', 'Jakeem', 'VUV14LXU5EI', 'Upgrade', '2', 'test', 'test', 'Approved', '2024-06-13', '2023-04-07', '2024-05-08 19:33:12'),
(12, 44, 'instagram.com', 'Tanisha', 'MKH51RLD4IJ', 'Upgrade', '2', 'test', 'test', 'Approved', '2023-02-24', '2023-12-23', '2024-03-29 01:27:47'),
(13, 45, 'ebay.com', 'Chaney', 'NHU16XTY7CJ', 'Basic', '2', 'test', 'test', 'Pending', '2023-09-21', '2024-05-09', '2024-01-17 17:48:48'),
(14, 30, 'baidu.com', 'Eve', 'MIS08TKP1EW', 'Advanced', '1', 'test', 'test', 'Pending', '2024-05-29', '2024-08-14', '2023-09-13 14:27:21'),
(15, 37, 'yahoo.com', 'Luke', 'OTG14XBN7ED', 'Advanced', '1', 'test', 'test', 'Disable', '2023-12-16', '2023-12-14', '2023-06-28 18:43:17'),
(16, 18, 'zoom.us', 'Rachel', 'PQH93JFC0HZ', 'Upgrade', '1', 'test', 'test', 'Disable', '2024-03-25', '2023-09-16', '2024-04-18 06:44:49'),
(17, 34, 'walmart.com', 'Zeus', 'HVC25TIQ1OF', 'Advanced', '1', 'test', 'test', 'Approved', '2024-03-02', '2023-07-11', '2023-08-23 07:58:41'),
(18, 11, 'netflix.com', 'Akeem', 'JPV23NCR0WP', 'Upgrade', '2', 'test', 'test', 'Approved', '2024-07-02', '2023-04-23', '2023-09-15 13:59:24'),
(19, 28, 'ebay.com', 'Raphael', 'BYD07ILN6MF', 'Upgrade', '1', 'test', 'test', 'Pending', '2023-05-12', '2023-11-12', '2024-07-11 14:09:16'),
(20, 19, 'netflix.com', 'Marny', 'FED58QIP0XB', 'Basic', '1', 'test', 'test', 'Pending', '2023-09-04', '2023-09-23', '2024-03-10 08:34:02'),
(21, 11, 'nytimes.com', 'William', 'QTD62XWH2ZD', 'Upgrade', '2', 'test', 'test', 'Disable', '2023-08-28', '2023-12-26', '2024-09-18 07:01:16'),
(22, 10, 'whatsapp.com', 'Ivan', 'YMW96DHR6KW', 'Advanced', '1', 'test', 'test', 'Disable', '2023-02-05', '2023-09-17', '2023-04-16 11:06:05'),
(23, 34, 'wikipedia.org', 'Uriah', 'XSE80BDW5VW', 'Basic', '1', 'test', 'test', 'Approved', '2024-04-14', '2024-08-16', '2023-04-01 13:19:49'),
(24, 15, 'walmart.com', 'Idona', 'WOH75CWI9VD', 'Basic', '1', 'test', 'test', 'Approved', '2022-10-29', '2023-03-06', '2024-01-26 07:24:02'),
(25, 15, 'nytimes.com', 'Adrian', 'GNE31SRE1HK', 'Upgrade', '2', 'test', 'test', 'Pending', '2023-03-24', '2024-06-11', '2024-07-06 20:21:57'),
(26, 31, 'nytimes.com', 'Nevada', 'FCE77NNP4RF', 'Basic', '2', 'test', 'test', 'Pending', '2024-09-27', '2024-01-06', '2024-09-30 17:58:03'),
(27, 31, 'instagram.com', 'Melyssa', 'EFS91HHH1TI', 'Advanced', '2', 'test', 'test', 'Disable', '2024-05-03', '2023-09-04', '2024-05-29 12:23:28'),
(28, 37, 'walmart.com', 'Anika', 'ERT38KLY1WL', 'Advanced', '2', 'test', 'test', 'Disable', '2023-03-07', '2023-07-28', '2024-10-04 10:46:28'),
(29, 26, 'wikipedia.org', 'Emma', 'RRJ71NGZ1GY', 'Upgrade', '2', 'test', 'test', 'Approved', '2024-01-20', '2023-12-25', '2023-06-15 18:13:35'),
(30, 8, 'google.com', 'Allegra', 'FDK38RDR6CY', 'Basic', '1', 'test', 'test', 'Approved', '2024-09-22', '2024-08-04', '2024-01-20 18:56:02'),
(31, 47, 'zoom.us', 'Hoyt', 'REX83OER2PC', 'Basic', '2', 'test', 'test', 'Pending', '2022-11-14', '2022-12-26', '2024-09-09 14:37:06'),
(32, 2, 'google.com', 'Wing', 'DGH65SIX1CT', 'Upgrade', '2', 'test', 'test', 'Pending', '2023-11-01', '2023-06-03', '2023-06-15 12:27:16'),
(33, 2, 'nytimes.com', 'Kalia', 'MPA35ODK3RD', 'Basic', '1', 'test', 'test', 'Disable', '2023-09-30', '2023-01-06', '2023-05-06 05:09:35'),
(34, 12, 'instagram.com', 'Kareem', 'OAF36CLY0AA', 'Basic', '2', 'test', 'test', 'Disable', '2023-05-14', '2023-07-24', '2024-09-30 02:01:13'),
(35, 3, 'ebay.com', 'Walker', 'ECL37CWW8HS', 'Upgrade', '1', 'test', 'test', 'Approved', '2023-10-13', '2024-07-05', '2024-03-30 05:43:10'),
(36, 25, 'yahoo.com', 'Boris', 'DXS67CYE5JT', 'Basic', '1', 'test', 'test', 'Approved', '2024-09-05', '2023-06-26', '2024-05-23 20:12:03'),
(37, 19, 'youtube.com', 'Yael', 'DPH11BIB8DC', 'Advanced', '1', 'test', 'test', 'Pending', '2024-04-09', '2023-06-29', '2023-10-27 23:12:30'),
(38, 4, 'facebook.com', 'George', 'QLF04TVO3SM', 'Advanced', '2', 'test', 'test', 'Pending', '2024-07-02', '2023-06-13', '2023-04-11 04:38:47'),
(39, 3, 'yahoo.com', 'Germane', 'GQJ43RIT8GK', 'Upgrade', '2', 'test', 'test', 'Disable', '2024-10-03', '2024-05-09', '2024-01-31 13:46:22'),
(40, 49, 'yahoo.com', 'Lana', 'KQL44BDJ5MD', 'Basic', '1', 'test', 'test', 'Disable', '2024-06-09', '2023-12-03', '2024-06-19 22:33:30'),
(41, 12, 'guardian.co.uk', 'Elton', 'VCD97WTW7WB', 'Basic', '1', 'test', 'test', 'Approved', '2023-01-25', '2023-12-09', '2024-08-08 03:07:51'),
(42, 2, 'reddit.com', 'Conan', 'JKR38GNC2BR', 'Basic', '1', 'test', 'test', 'Approved', '2023-08-04', '2023-11-27', '2024-03-08 13:12:49'),
(43, 2, 'netflix.com', 'Sasha', 'HEF59NHZ2SJ', 'Upgrade', '1', 'test', 'test', 'Pending', '2023-02-08', '2024-07-22', '2023-06-29 02:08:35'),
(44, 14, 'guardian.co.uk', 'Ainsley', 'EAX08TKT3XA', 'Upgrade', '1', 'test', 'test', 'Pending', '2024-09-22', '2024-07-14', '2024-06-18 07:34:43'),
(45, 49, 'guardian.co.uk', 'Ashely', 'SIF45DGU6AX', 'Advanced', '2', 'test', 'test', 'Disable', '2023-11-20', '2023-08-21', '2023-08-12 06:47:47'),
(46, 21, 'google.com', 'Beck', 'DJD84GBI3EN', 'Upgrade', '1', 'test', 'test', 'Disable', '2022-12-15', '2023-11-03', '2024-01-07 11:20:52'),
(47, 8, 'twitter.com', 'Macaulay', 'BXW66RRF2DF', 'Advanced', '1', 'test', 'test', 'Approved', '2023-09-15', '2023-05-15', '2024-03-08 19:15:16'),
(48, 25, 'bbc.co.uk', 'Driscoll', 'LCL91UWB3MB', 'Basic', '1', 'test', 'test', 'Approved', '2023-02-15', '2023-09-22', '2024-07-23 17:21:13'),
(49, 22, 'wikipedia.org', 'Tarik', 'YDO64XOQ1KA', 'Advanced', '1', 'test', 'test', 'Pending', '2023-10-25', '2024-06-09', '2024-01-08 02:29:31'),
(50, 5, 'nytimes.com', 'Owen', 'RCH44LIO4XI', 'Upgrade', '1', 'test', 'test', 'Pending', '2023-11-07', '2024-05-23', '2024-07-16 15:18:14'),
(54, 53, 'proexample.com', 'user1', 'user1', 'Basic', '2', 'การศึกษาและการเรียนรู้', 'test test', 'Approved', '2023-10-09', '2023-10-09', '2024-10-09 00:00:00'),
(55, 53, 'user2.jeedhost.com', 'user2', 'user2', 'Advanced', '1', 'การพัฒนาและทดสอบ', 'seftest', 'Approved', '2023-10-09', '2023-10-09', '2023-11-09 07:23:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `activation_code` varchar(36) NOT NULL,
  `active` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `password`, `email`, `role`, `activation_code`, `active`, `created_at`) VALUES
(1, 'admin', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'admin@admin.com', 'admin', 'D6831D69-455F-F8DB-8272-0D9C7177CD84', 1, '2024-04-17 10:08:57'),
(2, 'Suki Frye', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'tellus.faucibus@icloud.net', 'user', 'A04A79F6-917B-305F-E5A5-82BB7D8648EC', 1, '2024-09-24 19:24:11'),
(3, 'Scarlett Good', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'ligula.eu@aol.edu', 'user', '27648B16-1D00-4B8A-545B-885CCE0E4560', 1, '2023-08-02 09:09:45'),
(4, 'Allistair Kane', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'quam@outlook.edu', 'user', '4C624191-DE6D-CC1C-44AD-51115E4186D0', 1, '2024-03-28 08:23:47'),
(5, 'Lee Madden', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'et.rutrum@google.org', 'user', '8568E3EA-E1B7-3030-32C7-DC463A06E0B4', 1, '2022-11-22 20:32:39'),
(6, 'Baker Douglas', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'ac.risus@outlook.couk', 'user', 'B42E2D11-C31C-58D6-D460-6C12CEA3ACD3', 1, '2023-11-25 03:41:26'),
(7, 'Buffy Collier', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'mollis.duis@protonmail.net', 'user', '3E096778-7386-2DDC-5565-087FD3178212', 1, '2023-08-20 08:11:41'),
(8, 'Oren Bradley', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'eleifend.non.dapibus@outlook.org', 'user', '2A30781B-5759-9364-794D-CD37E6035918', 1, '2023-09-20 04:12:18'),
(9, 'Kiayada Hunt', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'ut.molestie@icloud.ca', 'user', '4266885B-E859-8CCA-1194-D534BEBE2178', 1, '2023-12-05 06:54:12'),
(10, 'Justina Gould', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'dui.suspendisse.ac@protonmail.org', 'user', '3018EC36-7E3A-612C-D768-4C65D9E7659D', 1, '2022-11-12 23:30:30'),
(11, 'Fitzgerald Ortiz', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'varius.nam@aol.ca', 'user', '0ED8C476-8EAB-7B5E-B25D-6EA1BD131275', 1, '2023-01-08 15:27:00'),
(12, 'Yvonne Rogers', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'auctor.mauris@outlook.edu', 'user', '91E3B35E-1AE4-C28A-0711-06EDCB3FCC5E', 1, '2024-02-10 20:17:10'),
(13, 'Cynthia Blanchard', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'pede.cras.vulputate@google.edu', 'user', 'AAC296E7-A8F0-D25E-8E91-3686F6126ABB', 1, '2023-08-16 22:07:25'),
(14, 'Britanney Turner', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'erat.neque@google.ca', 'user', 'C25A3E3B-4FC7-D927-7309-77C639BA880D', 1, '2024-05-29 11:08:13'),
(15, 'Genevieve Harrell', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'egestas.fusce@google.net', 'user', '1E609EAA-488A-BCC6-318B-7974926BC9C8', 1, '2024-09-11 00:56:53'),
(16, 'Levi Christian', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'ac.mi@aol.couk', 'user', '135AC5BA-9139-F726-2843-E96D20458FA8', 1, '2023-05-18 03:21:09'),
(17, 'Linus Guthrie', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'mollis@outlook.org', 'user', 'EBCB034C-9C92-C58A-C811-EEBA78847752', 1, '2023-12-08 08:40:22'),
(18, 'Hu Gillespie', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'quis@icloud.net', 'user', 'A1A386DE-D4B6-AD91-F7BA-141AF276FFDE', 1, '2023-03-24 04:24:26'),
(19, 'Igor Hodges', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'orci@protonmail.org', 'user', 'CAE47EE2-9C61-035F-CD1C-328468C35BA4', 1, '2024-04-07 03:22:35'),
(20, 'Keiko Ramsey', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'faucibus@icloud.net', 'user', 'CE071D8B-B76D-65C7-B431-BD074EC82AE1', 1, '2024-03-07 19:54:20'),
(21, 'Ciaran Nixon', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'malesuada@yahoo.org', 'user', 'CDDAF90A-DE54-13D8-56C6-937172EFA18E', 1, '2023-02-10 08:46:06'),
(22, 'Constance Murray', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'euismod.urna@outlook.edu', 'user', 'C5D708E6-9C90-2561-C3AD-86728F02B0D6', 1, '2023-03-20 13:12:57'),
(23, 'Quamar Rodgers', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'eu.arcu@outlook.org', 'user', 'C518EB51-C445-31BD-7746-6BDCFEBD57C9', 1, '2024-06-30 19:49:36'),
(24, 'Oliver Carroll', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'condimentum.eget@protonmail.edu', 'user', '45B5F22B-3292-6898-2D84-9E75A47531FE', 1, '2024-04-18 03:44:57'),
(25, 'Yasir Montoya', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'ante.ipsum.primis@outlook.com', 'user', '9A03F810-A6C2-2249-4916-544658688254', 1, '2023-07-04 20:16:43'),
(26, 'Guinevere Byers', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'semper.rutrum@aol.com', 'user', '713D1432-01DB-51B3-7716-47EE82D71349', 1, '2023-07-30 04:18:47'),
(27, 'Christian Norman', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'lorem.ipsum.dolor@protonmail.edu', 'user', '5B43F6D5-BE81-8E68-8A37-1EE471CC6747', 1, '2023-06-26 02:53:29'),
(28, 'Joshua Murphy', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'mauris@yahoo.org', 'user', 'A03BC63C-503D-83AE-7047-C1920BB472A0', 1, '2024-01-15 18:44:54'),
(29, 'Justine Castillo', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'ipsum.suspendisse@hotmail.com', 'user', '994A7C0D-74B9-9DEF-9BA3-46242B2C87FE', 1, '2024-07-02 09:54:13'),
(30, 'Grant Duran', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'nisi.sem.semper@outlook.ca', 'user', '3627358A-EBAD-899E-64F5-327AA7E6BD9A', 1, '2024-05-27 16:52:53'),
(31, 'Nathan Holland', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'metus.eu@google.couk', 'user', '48286588-A36C-60F8-8B1E-EC7B02B281C1', 1, '2023-11-08 05:26:45'),
(32, 'Randall Frye', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'fusce@google.net', 'user', '124D34F3-622B-2ADD-3921-69A998626B05', 1, '2023-08-21 18:50:14'),
(33, 'Julie Campbell', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'amet@yahoo.com', 'user', 'E81271DA-1D31-8A7B-6598-B46E04C3ECF4', 1, '2024-02-24 10:29:35'),
(34, 'Donovan Lee', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'dictum.ultricies@icloud.couk', 'user', '057B5B08-4BE5-C59F-3577-932A13A6E195', 1, '2023-04-18 18:00:40'),
(35, 'Chiquita Benjamin', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'id@aol.edu', 'user', '85586635-8750-7C41-6E6D-0029A43D2425', 1, '2023-03-11 13:32:08'),
(36, 'George Noble', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'erat.semper.rutrum@aol.edu', 'user', '1DE9D009-E0A2-E488-F5A0-18B151454C72', 1, '2023-02-07 14:30:32'),
(37, 'Cassandra Lambert', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'lobortis.ultrices@outlook.edu', 'user', '7D24590B-6537-9E80-16FD-C31921418098', 1, '2024-02-19 17:25:26'),
(38, 'Helen Ewing', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'eget@yahoo.org', 'user', 'CA361842-AC44-93CE-6596-A935284A3E96', 1, '2023-11-01 06:24:15'),
(39, 'Summer Slater', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'magnis.dis@icloud.edu', 'user', '136D1EFE-E6AE-A638-7556-AD7C8519389E', 1, '2023-10-11 20:01:29'),
(40, 'Kelsey Burgess', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'ligula@icloud.ca', 'user', '6BABDBA6-3712-9CA1-C7B9-1194F8D96129', 1, '2024-01-16 06:55:58'),
(41, 'Imelda Fleming', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'massa@aol.ca', 'user', 'BA597BC5-52B7-23D3-3B7D-56BB21C833B1', 1, '2022-12-16 06:50:42'),
(42, 'Anastasia Taylor', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'ultrices.sit@protonmail.com', 'user', '5FE5DE3E-B4F6-12C9-FFD6-5DD286E44E3E', 1, '2024-05-13 06:32:15'),
(43, 'Reese Gentry', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'tristique.ac@yahoo.net', 'user', 'FE5A55D9-6168-D0E1-BAF8-1BF1828F3A76', 1, '2023-05-31 06:40:05'),
(44, 'Aurelia Mayer', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'sed@aol.ca', 'user', 'EA893350-63CE-77D9-260C-1BFBEA694C22', 1, '2023-04-12 14:21:14'),
(45, 'Luke Hopper', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'egestas@google.net', 'user', 'B2820E36-76FB-AF01-DD26-37801BE16E44', 1, '2023-01-13 22:51:35'),
(46, 'Kaseem Dyer', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'aliquet@icloud.com', 'user', '28C4E660-BCD7-8226-207D-37765669F689', 1, '2022-12-07 02:54:32'),
(47, 'Marvin Blackwell', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'fringilla@protonmail.couk', 'user', '36418547-139E-67D1-19EE-2E13D26A0937', 1, '2024-06-27 15:48:31'),
(48, 'Kevin Clements', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'sem.egestas.blandit@outlook.net', 'user', 'DBA5B922-E301-7EAE-AD93-8A1C6DADB4E6', 1, '2023-02-15 01:35:42'),
(49, 'Kirk Henry', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'proin.vel@hotmail.com', 'user', '7E16E85E-13B5-22C9-E481-358B9F1BD244', 1, '2022-10-29 04:59:31'),
(50, 'Kenyon Day', '$2y$10$ZOgre0JIqWE/XdGnojMTj.cCFPQzByXNqNmPlANe4QM/INQj01/f2', 'aliquam.erat@icloud.couk', 'user', '4D0A7A15-9D8A-88DF-7D77-17C5A2D4AF73', 1, '2023-11-18 19:38:24'),
(53, 'สมศร มาแล้ว', '$2y$10$LSYuDQi2vaCL064QxH/1d.FZ/qp2YIQUJk9pRNbXiVEoZY3YEWJm6', 'asdf2086.g@gmail.com', 'user', '8b04a77c916157ce63fbfeb4b12b37de', 1, '2023-10-09 07:08:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `renewal_request`
--
ALTER TABLE `renewal_request`
  ADD PRIMARY KEY (`renewal_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `service_request`
--
ALTER TABLE `service_request`
  ADD PRIMARY KEY (`service_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `renewal_request`
--
ALTER TABLE `renewal_request`
  MODIFY `renewal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `service_request`
--
ALTER TABLE `service_request`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `renewal_request`
--
ALTER TABLE `renewal_request`
  ADD CONSTRAINT `service_id` FOREIGN KEY (`service_id`) REFERENCES `service_request` (`service_id`) ON DELETE CASCADE;

--
-- Constraints for table `service_request`
--
ALTER TABLE `service_request`
  ADD CONSTRAINT `service_request_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
