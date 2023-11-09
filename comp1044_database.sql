-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2023 at 10:12 AM
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
-- Database: `comp1044_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_ID` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `contact_no` int(11) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_ID`, `first_name`, `last_name`, `contact_no`, `email`) VALUES
(411326, 'Joe', 'Biden', 345671234, 'jb@mail.com'),
(433453, 'Mustafa ', 'Fadlelbari', 1133179275, 'efymf5@nottingham.edu.my'),
(435698, 'Jason', 'Todd', 123456789, 'jtodd@gmail.com'),
(449264, 'James', 'Bond', 987654321, 'James@mail.com'),
(473873, 'Carolina Pei Qian', 'Lee', 7585785, 'hello@world.com'),
(490803, 'Aben', 'Rayev', 1345676543, 'asd5@nottingham.edu.my'),
(498841, 'Mar', 'Zallan', 123456761, 'adfd7@nottingham.edu.my');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservation_ID` int(11) NOT NULL,
  `customer_ID` int(11) NOT NULL,
  `reservation_date` date NOT NULL,
  `pick_up_date` date NOT NULL,
  `pick_up_location` varchar(100) NOT NULL,
  `return_date` date NOT NULL,
  `vehicle_ID` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_ID`, `customer_ID`, `reservation_date`, `pick_up_date`, `pick_up_location`, `return_date`, `vehicle_ID`) VALUES
(142620, 411326, '2023-04-25', '2023-06-01', 'Unmc', '2023-06-03', 'LMB210'),
(158136, 498841, '2023-04-25', '2023-04-26', 'Semenyih', '2023-05-05', 'LMB210'),
(159861, 449264, '2023-04-25', '2023-05-05', 'Kajang', '2023-05-07', 'RPB100'),
(162556, 473873, '2023-04-24', '2023-05-03', 'Tawau', '2023-05-08', 'JMW300'),
(178339, 433453, '2023-04-25', '2023-04-25', 'Unmc', '2023-04-29', 'FSR200'),
(182858, 498841, '2023-04-25', '2023-04-26', 'Kajang', '2023-05-06', 'MGR320'),
(189950, 435698, '2023-04-25', '2023-05-01', 'Unmc', '2023-05-04', 'RPB100'),
(194414, 473873, '2023-04-24', '2023-04-28', 'Tawau', '2023-04-29', 'BCW110'),
(225176, 433453, '2023-04-25', '2023-04-25', 'Unmc', '2023-04-28', 'RSG310'),
(271923, 490803, '2023-04-25', '2023-04-26', 'Penang', '2023-04-30', 'JSC130'),
(288490, 490803, '2023-04-25', '2023-05-02', 'Penang', '2023-05-07', 'FSR200');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_ID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `contact_no` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_ID`, `username`, `password`, `first_name`, `last_name`, `contact_no`, `email`, `position`) VALUES
(1, 'Timothy_Hopkins', '56789', 'Timothy', 'Hopkins', 2147483647, 'Timmy@gmail.com', 'CEO'),
(4, 'Jamison_Johnson', '100-dollar/bills', 'Jamison', 'Johnson', 2147483647, 'JohnJamy@gmail.com', 'Accountant'),
(10, 'Janson_Doyle', '3ggs-R-great', 'Janson', 'Doyle', 375637281, 'JansonDoyle11@gmail.com', 'Finance Manager'),
(13, 'Bobby_Lee', 'hello_world', 'Bobby', 'Lee', 2147483647, 'BobLee@gmail.com', 'Sales Representative');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `car_vehicle_ID` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `price_per_day` int(11) NOT NULL,
  `color` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `photo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`car_vehicle_ID`, `model`, `price_per_day`, `color`, `category`, `photo`) VALUES
('BCW110', 'Bentley Continental Flying Spur', 4800, 'White', 'Luxurious Car', 'CarIMG/luxurious/bentley_white.png'),
('FSR200', 'Ferrari F430 Scuderia', 6000, 'Red', 'Sports Car', 'CarIMG/sports/ferrari_red.png'),
('JMW300', 'Jaguar MK 2', 2200, 'White', 'Classics Car', 'CarIMG/classics/jaguar_mk2.png'),
('JSC130', 'Jaguar S Type', 1350, 'Champagne', 'Luxurious Car', 'CarIMG/luxurious/jaguar_s.png'),
('LMB210', 'Lamborghini Murcielago LP640', 7000, 'Matte Black', 'Sports Car', 'CarIMG/sports/lamborghini.png'),
('LSB230', 'Lexus SC430', 1600, 'Black', 'Sports Car', 'CarIMG/sports/lexus_sc430.png'),
('MBS120', 'Mercedes Benz CLS 350', 1350, 'Silver', 'Luxurious Car', 'CarIMG/luxurious/mercedez_silver.png'),
('MGR320', 'MG TD ', 2500, 'Red', 'Classics Car', 'CarIMG/classics/mg_td.png'),
('PBW220', 'Porsche Boxster', 2800, 'White', 'Sports Car', 'CarIMG/sports/porsche.png'),
('RPB100', 'Rolls Royce Phantom', 9800, 'Blue', 'Luxurious Car', 'CarIMG/luxurious/rolls_royce_blue.png'),
('RSG310', 'Rolls Royce Silver Spirit Limousine', 3200, 'Georgian Silver', 'Classics Car', 'CarIMG/classics/rolls_silver_spirit.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_ID`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_ID`),
  ADD KEY `foreignkey2` (`vehicle_ID`),
  ADD KEY `foreignkey` (`customer_ID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_ID`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`car_vehicle_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `foreignkey` FOREIGN KEY (`customer_ID`) REFERENCES `customer` (`customer_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foreignkey2` FOREIGN KEY (`vehicle_ID`) REFERENCES `vehicle` (`car_vehicle_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
