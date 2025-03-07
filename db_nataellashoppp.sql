-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2025 at 02:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_nataellashoppp`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `admin_telp` varchar(100) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`admin_id`, `admin_name`, `username`, `password`, `admin_telp`, `admin_email`, `admin_address`) VALUES
(1, 'Admin Qt (˶˃ ᵕ ˂˶)', 'admin', '202cb962ac59075b964b07152d234b70', '+6281211224662', 'irdiangela@gmail.com', 'Jl Kebenaran I No. 17');

-- --------------------------------------------------------

--
-- Table structure for table `tb_category`
--

CREATE TABLE `tb_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(25) NOT NULL,
  `category_image` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_category`
--

INSERT INTO `tb_category` (`category_id`, `category_name`, `category_image`) VALUES
(-1, 'Others', '1.png'),
(1, 'Academia', '3.png'),
(2, 'Winter', '5.png'),
(3, 'Boho', '4.png'),
(4, 'Streetwear', '2.png'),
(5, 'Y2K', '5.png'),
(6, 'Downtown Girl', '4.png'),
(7, 'Old Money', '3.png'),
(8, 'Preppy Style', '2.png'),
(9, 'Soft Girl', '1.png');

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer`
--

CREATE TABLE `tb_customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `customer_phone` varchar(15) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `customer_password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_customer`
--

INSERT INTO `tb_customer` (`customer_id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `customer_password`) VALUES
(1, 'Rebecca', 'beka@gmail.com', '08123456789', 'lalaland', '$2y$10$tTLGzbOfUq4wXZ.vrMhpveyCcyR2CDmBfedRQc9ATRt920CNIB8Qu'),
(5, 'nata', 'ayciezzz@gmail.com', '08135792468', 'Jl Moniyan No. 24', '$2y$10$JHl9x8EigHs.bfvBqjwS8eOsnukDsSASXTL7Yd4m6JX6.pkd3aVcu'),
(6, 'Ayciez', 'ayciezzz@gmail.com', '08123456789', 'Sakura Street', '$2y$10$.yaG31zHEpaenlEeOhpGXuO8aagjYnvIsetdJ1lPG/cB4VAmfUFq6');

-- --------------------------------------------------------

--
-- Table structure for table `tb_order`
--

CREATE TABLE `tb_order` (
  `order_id` int(11) NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_id` int(11) NOT NULL,
  `shipping_method` varchar(10) NOT NULL,
  `shipping_address` text NOT NULL,
  `payment_proof` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_order`
--

INSERT INTO `tb_order` (`order_id`, `total_price`, `order_status`, `product_id`, `quantity`, `date_created`, `customer_id`, `shipping_method`, `shipping_address`, `payment_proof`) VALUES
(71, 800000.00, 'Processing Your Order 🔃', NULL, NULL, '2025-03-01 06:51:29', 5, 'Grab Exp', 'Jl Moniyan No. 24', 'upload/1740811889_pizza.jpg'),
(74, 1470000.00, 'Processing Your Order 🔃', NULL, NULL, '2025-03-06 13:10:15', 6, 'JNE', 'Sakura Street', 'upload/1741266615_1740807112_Noir Familia_.jpeg'),
(75, 300000.00, 'Processing Your Order 🔃', NULL, NULL, '2025-03-06 13:11:11', 6, 'Grab Exp', 'Sakura Street', 'upload/1741266671_1741266313_1740807112_Noir Familia_.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_order_detail`
--

CREATE TABLE `tb_order_detail` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_order_detail`
--

INSERT INTO `tb_order_detail` (`order_detail_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(14, 71, 8, 1, 800000.00),
(17, 74, 13, 2, 735000.00),
(18, 75, 6, 1, 300000.00);

-- --------------------------------------------------------

--
-- Table structure for table `tb_product`
--

CREATE TABLE `tb_product` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_description` text NOT NULL,
  `product_image` varchar(100) NOT NULL,
  `product_status` tinyint(1) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_product`
--

INSERT INTO `tb_product` (`product_id`, `category_id`, `product_name`, `product_price`, `product_description`, `product_image`, `product_status`, `date_created`, `stock`) VALUES
(3, 1, 'Dark Academia', 750000, 'How do you like your coffee?', 'produk1731683787.jpeg', 1, '2024-11-15 15:16:27', 100),
(6, 3, 'Boho Outfit', 300000, '💚🤎', 'produk1731757512.jpeg', 1, '2024-11-16 11:45:12', 99),
(7, 6, 'Downtown Girl', 500000, 'Walk the walk', 'produk1731758666.jpeg', 1, '2024-11-16 12:04:26', 100),
(8, 7, 'Old Money Outfit', 800000, 'I will take this city 💸💰', 'produk1731758925.jpeg', 1, '2024-11-16 12:08:45', 100),
(9, 8, 'Preppy Style', 400000, 'The weather is fine 🌤', 'produk1731759088.jpeg', 1, '2024-11-16 12:11:28', 100),
(10, 9, 'Soft Girl Vibe', 550000, 'Goodluck Babe 🍭', 'produk1731759172.jpeg', 1, '2024-11-16 12:12:52', 100),
(11, 4, 'Streetwear Outfit', 650000, 'Ride or Die 🏍💨', 'produk1731759354.jpeg', 1, '2024-11-16 12:15:54', 100),
(12, 5, 'Y2K Baddie Outfit', 450000, 'GURLLL 🕺💃', 'produk1731759695.jpeg', 1, '2024-11-16 12:21:35', 100),
(13, 2, 'Winter Outfit', 735000, 'Ready to meet the snowflakes outside 🧤🧣❄❄❄', 'produk1740684437.jpg', 1, '2025-02-26 03:01:16', 98);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tb_customer`
--
ALTER TABLE `tb_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tb_order_detail`
--
ALTER TABLE `tb_order_detail`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tb_product`
--
ALTER TABLE `tb_product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_id` (`product_id`,`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tb_customer`
--
ALTER TABLE `tb_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_order`
--
ALTER TABLE `tb_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `tb_order_detail`
--
ALTER TABLE `tb_order_detail`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_order_detail`
--
ALTER TABLE `tb_order_detail`
  ADD CONSTRAINT `tb_order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `tb_order` (`order_id`),
  ADD CONSTRAINT `tb_order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tb_product` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
