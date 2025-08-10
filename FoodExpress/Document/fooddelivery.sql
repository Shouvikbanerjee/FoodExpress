-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2025 at 05:57 PM
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
-- Database: `fooddelivery`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `phone`, `password`) VALUES
(1, 'Shouvik Banerjee', 'banerjeeshouvik29@gmail.com', '78965661300', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `contact_message`
--

CREATE TABLE `contact_message` (
  `id` int(11) NOT NULL,
  `name` varchar(70) NOT NULL,
  `email` varchar(70) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_partner`
--

CREATE TABLE `delivery_partner` (
  `dp_id` int(11) NOT NULL,
  `p_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_partner`
--

INSERT INTO `delivery_partner` (`dp_id`, `p_name`, `email`, `phone`, `address`, `password`) VALUES
(1, 'Shouvik banerjee', 'banerjeeshouvik29@gmail.com', '987456310', 'burdwan\r\n', '1234'),
(4, 'Arya Pyne', 'arya@gmail.com', '7896541230', 'burdwan', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_status_map`
--

CREATE TABLE `delivery_status_map` (
  `id` int(11) NOT NULL,
  `dp_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `delivery_status` enum('Pending','Accepted','Cancelled','Completed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_status_map`
--

INSERT INTO `delivery_status_map` (`id`, `dp_id`, `order_id`, `delivery_status`) VALUES
(15, 1, 32, 'Completed'),
(16, 1, 33, 'Completed'),
(17, 1, 56, 'Completed'),
(18, 1, 63, 'Completed'),
(19, 1, 65, 'Completed'),
(20, 1, 68, 'Accepted'),
(21, 1, 69, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `res_id`, `name`, `price`, `description`, `image`) VALUES
(1, 1, 'Cheeseburger', 150, 'A juicy grilled beef patty topped with melted cheese, lettuce, and tomato, served in a toasted bun.', 'uploads/1754753111_cheeseburger.jpeg'),
(2, 1, ' Egg Biryani', 200, 'Boiled eggs simmered with basmati rice and spices, enhanced with caramelized onions, fresh herbs, and a hint of saffron.', 'uploads/1754753119_eggbiryani.jpeg'),
(3, 1, 'Butter Chicken', 120, 'A creamy tomato-based Indian curry made with tender chicken pieces, butter, and aromatic spices.', 'uploads/1754753126_butterchicken.jpeg'),
(4, 1, 'Margherita Pizza', 200, 'A classic Italian pizza topped with fresh mozzarella, ripe tomatoes, and fragrant basil leaves.\r\n\r\n', 'uploads/1754753147_pizzamargherita.jpeg'),
(5, 1, 'Masala Dosa', 130, 'A crispy South Indian rice crepe stuffed with spiced potato filling, served with chutney and sambar.', 'uploads/1754753157_masaladosa.webp'),
(7, 1, 'Mutton Biryani', 140, 'Tender pieces of mutton cooked in a rich blend of spices, layered with fragrant basmati rice, and slow-cooked to absorb all the delicious flavors.', 'uploads/1754753166_mutton biryani.jpeg'),
(8, 2, 'Paneer Butter Masala', 160, 'Soft cubes of paneer simmered in a rich and creamy tomato-based gravy, infused with butter, aromatic spices, and a hint of fenugreek.', 'uploads/1754753190_pannerbuttermasala.jpeg'),
(9, 2, ' Chicken Tikka Masala', 180, 'Tender chicken pieces marinated in yogurt and spices, grilled and cooked in a creamy tomato sauce rich with Indian spices.', 'uploads/1754753199_chickentikkamasala.jpeg'),
(13, 2, 'Mutton Biryani', 200, 'Tender pieces of mutton cooked in a rich blend of spices, layered with fragrant basmati rice, and slow-cooked to absorb all the delicious flavors.', 'uploads/1754753205_mutton biryani.jpeg'),
(15, 4, 'Mutton Seekh Roll', 160, 'Juicy minced mutton seekh kebabs, seasoned with aromatic spices, rolled in a paratha with onions and chutneys. ', 'uploads/1754753055_muttonseekhroll.jpeg'),
(17, 4, 'Chicken Kathi Roll', 160, 'Spiced grilled chicken wrapped in a soft paratha with fresh onions, chutneys, and a squeeze of tangy lemon.', 'uploads/1754753072_chickenkathiroll.jpeg'),
(18, 4, 'Chicken Shawarma Roll', 180, 'Sliced marinated chicken, garlic sauce, pickles, and veggies wrapped in warm flatbread. A popular Middle Eastern street food packed with flavor.', 'uploads/1754753079_chickenshawarmaroll.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dp_id` int(11) NOT NULL,
  `address` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_status` enum('Pending','Accepted','Cancelled','Completed','Out for Delivery') NOT NULL,
  `price` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_id`, `res_id`, `item_id`, `user_id`, `dp_id`, `address`, `quantity`, `order_status`, `price`, `date`) VALUES
(32, 1, 1, 2, 1, 'burdwan', 1, 'Completed', '150', '2025-08-08 15:59:29'),
(33, 1, 1, 2, 1, 'burdwan', 1, 'Completed', '150', '2025-08-08 16:06:58'),
(56, 1, 1, 2, 1, 'Durgapur, West Bengal, India', 1, 'Completed', '150', '2025-08-10 06:29:57'),
(63, 1, 1, 2, 1, 'West Bengal, India', 1, 'Completed', '150', '2025-08-10 14:22:41'),
(65, 1, 4, 2, 1, 'West Bengal, India', 1, 'Completed', '200', '2025-08-10 14:22:50'),
(69, 1, 7, 2, 1, 'West Bengal, India', 1, 'Completed', '140', '2025-08-10 14:50:24');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `res_id` int(11) NOT NULL,
  `restaurantname` varchar(50) NOT NULL,
  `ownername` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`res_id`, `restaurantname`, `ownername`, `email`, `phone`, `address`, `password`) VALUES
(1, 'Adda', 'Shouvik banerjee', 'banerjeeshouvik29@gmail.com', '9749497770', 'burdwan', '1234'),
(2, 'Abar Khabo', 'Arya Pyne', 'arya@gmail.com', '7896541230', 'kamarpara', '1234'),
(3, 'Khai Khai', 'Subho Das', 'ggg@gmail.com', '987456310', 'Bankura More', '1234'),
(4, 'Canteen ( C2 )', 'Ayantika Pyne', 'shouvikbanerjee488@gmail.com', '987456310', 'katwa', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `phone`, `address`, `password`) VALUES
(2, 'Shouvik banerjee', 'banerjeeshouvik29@gmail.com', '9749497770', 'West Bengal, India', '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `contact_message`
--
ALTER TABLE `contact_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_partner`
--
ALTER TABLE `delivery_partner`
  ADD PRIMARY KEY (`dp_id`);

--
-- Indexes for table `delivery_status_map`
--
ALTER TABLE `delivery_status_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`res_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_message`
--
ALTER TABLE `contact_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `delivery_partner`
--
ALTER TABLE `delivery_partner`
  MODIFY `dp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `delivery_status_map`
--
ALTER TABLE `delivery_status_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
