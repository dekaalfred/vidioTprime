-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 06, 2025 at 02:51 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xpplg5`
--

-- --------------------------------------------------------

--
-- Table structure for table `database`
--

CREATE TABLE `database` (
  `pasword` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `database`
--

INSERT INTO `database` (`pasword`, `username`) VALUES
('$2y$10$sdUdyEoPcO7STTPG.Up43O8AaFgOVbQwc7.ITfjZ3o.WkTWEaO0hK', 'deka'),
('$2y$10$5sx5JUxb73ot4USKOuadp.VzENlujxmekVA2OikY0ue9LgzWhA7ZS', 'fathan'),
('$2y$10$AA8hubcX0nVxCqCdREkxAezWr6YI6VPx7qLVIKRkY4UICcJl1Ikb2', 'rawr'),
('$2y$10$YGEayaF2KROt/dpqtIdME..P/4iH4nNgefKWlgiydNjLL3r2tJgs6', 'alek'),
('$2y$10$tGL2C4LXqDW8REqe2SU2eOFYq83wIGJYE0KNf8r.Dyd2x94EILkC2', 'erlangga'),
('$2y$10$2O2BFCxGnH/6AJIUT253/ezuUn4NgJGAFvJX7n7HK2Yl1IEhRw87q', 'aw'),
('$2y$10$3KNILxZWLCC.CJtfczT6ZOm057G.92I8Yoa4PB73NSau6NRAUlF9e', 'de');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
