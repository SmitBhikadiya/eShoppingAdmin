-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2022 at 09:43 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eshopping`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminuser`
--

CREATE TABLE `adminuser` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `createdDate` datetime NOT NULL,
  `modifiedDate` datetime NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `adminuser`
--

INSERT INTO `adminuser` (`id`, `email`, `password`, `username`, `createdDate`, `modifiedDate`, `status`) VALUES
(1, 'admin123@gmail.com', '$2y$10$B7UJi7F5h9Ta8e5t.RfK3.8F5vdKEypE/3gBz.tGMDKOjWZtXggYG', 'Admin123', '2022-04-05 11:40:12', '2022-04-05 11:40:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `productName` varchar(100) NOT NULL,
  `productColorId` int(11) NOT NULL,
  `productSizeId` int(11) NOT NULL,
  `productImage` text NOT NULL,
  `unitPrize` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subTotal` int(11) NOT NULL,
  `createdDate` datetime DEFAULT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `productId`, `userId`, `productName`, `productColorId`, `productSizeId`, `productImage`, `unitPrize`, `quantity`, `subTotal`, `createdDate`, `modifiedDate`, `status`) VALUES
(33, 3, 1, 'cricket bat', 2, 2, 'product_165278027299.png', 20, 1, 20, '2022-05-23 10:08:37', NULL, 0),
(34, 4, 1, 'supreme jeans', 7, 2, 'product_1653054867477.png', 1099, 3, 3297, '2022-05-23 10:08:38', '2022-05-25 12:44:25', 0),
(35, 5, 1, 'sneakers', 7, 11, 'product_165305496919.png', 1599, 5, 7995, '2022-05-23 10:08:40', '2022-05-25 13:08:04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `catName` varchar(50) NOT NULL,
  `catDesc` varchar(150) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `catName`, `catDesc`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 'men', 'brand new and used clothes for men', '2022-04-11 12:09:11', '2022-04-11 10:47:02', 0),
(2, 'women', 'testing', '2022-04-13 17:44:35', '2022-04-11 12:21:29', 0),
(3, 'kids', 'kids related item to be listed under this category', NULL, '2022-04-13 15:05:36', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `city` varchar(50) NOT NULL,
  `stateId` int(11) NOT NULL,
  `countryId` int(11) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `city`, `stateId`, `countryId`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 'rajkot city', 1, 1, '2022-04-07 13:11:58', '2022-04-07 11:11:03', 0),
(2, 'scrumcaps', 3, 2, '2022-04-07 13:09:14', '2022-04-07 11:11:25', 0),
(3, 'mumbai', 2, 1, '2022-04-07 12:38:06', '2022-04-07 11:45:30', 0),
(4, 'hrandses', 3, 2, '2022-04-11 12:23:12', '2022-04-07 13:12:15', 1),
(5, 'new pune', 2, 1, '2022-04-11 09:10:45', '2022-04-11 09:10:18', 0),
(6, 'vadodara', 1, 1, NULL, '2022-04-11 12:23:47', 0),
(7, 'test', 4, 5, NULL, '2022-04-13 17:25:07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `country` varchar(50) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 'india', '2022-04-07 13:01:35', '2022-04-07 11:08:30', 0),
(2, 'brazill', '2022-05-13 18:39:38', '2022-04-07 11:08:33', 1),
(3, 'us', '2022-05-13 18:39:42', '2022-04-11 12:24:12', 1),
(4, 'south korea', '2022-05-13 18:39:35', '2022-04-13 17:22:32', 1),
(5, 'china', NULL, '2022-04-13 17:22:40', 0),
(6, 'thailand', '2022-05-13 18:39:31', '2022-04-13 17:22:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `stripeId` varchar(150) NOT NULL,
  `couponCode` varchar(10) NOT NULL,
  `couponExpiry` datetime NOT NULL,
  `discountAmount` int(11) NOT NULL,
  `requireAmountForApplicable` int(11) NOT NULL,
  `maximumTotalUsage` int(11) NOT NULL,
  `createdDate` datetime NOT NULL,
  `modifiedDate` datetime NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `stripeId`, `couponCode`, `couponExpiry`, `discountAmount`, `requireAmountForApplicable`, `maximumTotalUsage`, `createdDate`, `modifiedDate`, `status`) VALUES
(1, 'GsiJrFkI', 'DIWALI50', '2022-05-04 02:33:00', 599, 1000, 100, '2022-05-17 16:58:13', '2022-05-18 14:55:24', 0),
(2, 'ZlAElP66', 'HOLI2022', '2022-05-26 14:58:00', 1001, 3000, 15, '2022-05-18 14:59:03', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `homebanners`
--

CREATE TABLE `homebanners` (
  `id` int(11) NOT NULL,
  `bannerName` varchar(100) NOT NULL,
  `bannerDesc` varchar(250) NOT NULL,
  `bannerImageURL` text NOT NULL,
  `createdDate` datetime NOT NULL,
  `modifiedDate` datetime NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `homebanners`
--

INSERT INTO `homebanners` (`id`, `bannerName`, `bannerDesc`, `bannerImageURL`, `createdDate`, `modifiedDate`, `status`) VALUES
(2, 'first', 'testing', 'banner_165293687633.png', '2022-05-19 10:24:43', '2022-05-19 10:39:34', 0),
(5, 'First Banner', 'fvdnf', 'banner_1652936645502.png', '2022-05-19 10:34:05', '2022-05-19 10:39:39', 0),
(6, 'Third Banner', 'Testing', 'banner_1652956789151.png', '2022-05-19 16:09:49', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orderaddress`
--

CREATE TABLE `orderaddress` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `addressType` tinyint(2) NOT NULL,
  `streetName` varchar(50) NOT NULL,
  `cityId` int(11) NOT NULL,
  `countryId` int(11) NOT NULL,
  `stateId` int(11) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderaddress`
--

INSERT INTO `orderaddress` (`id`, `orderId`, `addressType`, `streetName`, `cityId`, `countryId`, `stateId`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 1, 0, 'ganesh', 3, 1, 2, NULL, '2022-05-18 13:51:47', 0),
(2, 1, 1, 'ramdev', 1, 1, 1, NULL, '2022-05-18 13:51:47', 0),
(3, 2, 0, 'ganesh', 3, 1, 2, NULL, '2022-05-18 13:54:29', 0),
(4, 2, 1, 'ramdev', 1, 1, 1, NULL, '2022-05-18 13:54:29', 0),
(5, 3, 0, 'ganesh', 3, 1, 2, NULL, '2022-05-20 19:27:49', 0),
(6, 3, 1, 'ramdev', 1, 1, 1, NULL, '2022-05-20 19:27:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orderlist`
--

CREATE TABLE `orderlist` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `productStripeId` varchar(150) NOT NULL,
  `productName` varchar(50) NOT NULL,
  `productImage` text NOT NULL,
  `productSize` varchar(50) NOT NULL,
  `productColor` varchar(50) NOT NULL,
  `productColorCode` varchar(50) NOT NULL,
  `unitPrice` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subTotal` int(11) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderlist`
--

INSERT INTO `orderlist` (`id`, `orderId`, `productId`, `productStripeId`, `productName`, `productImage`, `productSize`, `productColor`, `productColorCode`, `unitPrice`, `quantity`, `subTotal`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 1, 1, 'prod_LfulhPs8gKBBz4', 'car', 'product_1652533468195.png', '124 x 50', 'blue', '#0000ff', 1299, 1, 1299, NULL, '2022-05-18 13:51:47', 0),
(2, 1, 2, 'prod_LgJUafLHQeUBJy', 'abc t-shirt', 'product_1652442054348.png', 'm', 'grey', '#7a7a7a', 200, 2, 400, NULL, '2022-05-18 13:51:47', 0),
(3, 2, 1, 'prod_LfulhPs8gKBBz4', 'car', 'product_1652533468195.png', '124 x 50', 'blue', '#0000ff', 1299, 1, 1299, NULL, '2022-05-18 13:54:29', 0),
(4, 2, 2, 'prod_LgJUafLHQeUBJy', 'abc t-shirt', 'product_1652442054348.png', 'm', 'grey', '#7a7a7a', 200, 3, 600, NULL, '2022-05-18 13:54:29', 0),
(5, 3, 1, 'prod_LfulhPs8gKBBz4', 'car', 'product_1652533468195.png', '124 x 50', 'blue', '#0000ff', 1299, 4, 5196, NULL, '2022-05-20 19:27:49', 0),
(6, 3, 2, 'prod_LgJUafLHQeUBJy', 'abc t-shirt', 'product_1652442054348.png', 'xxxll', 'grey', '#7a7a7a', 200, 1, 200, NULL, '2022-05-20 19:27:49', 0),
(7, 3, 3, 'prod_LhmP5mgEgxWcBJ', 'cricket bat', 'product_165278027299.png', 'l', 'red', '#ff0000', 20, 3, 60, NULL, '2022-05-20 19:27:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `checkoutId` varchar(150) DEFAULT '',
  `subTotal` int(11) NOT NULL,
  `taxStripeId` varchar(150) NOT NULL,
  `couponStripeId` varchar(150) DEFAULT '',
  `total` int(11) NOT NULL,
  `orderStatus` tinyint(2) NOT NULL,
  `payment` tinyint(4) NOT NULL DEFAULT 0,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `userId`, `checkoutId`, `subTotal`, `taxStripeId`, `couponStripeId`, `total`, `orderStatus`, `payment`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 1, 'cs_test_b1kqotkhJA7j254VrXbv5tfTjY7AC2MXMzJPUqkzsL8WljAN9eqmFPlZ1v', 1699, 'txr_1KyyGdSH3d6vW3Ey8RMoDWoi', '', 1784, 1, 1, '2022-05-18 13:52:48', '2022-05-18 13:51:47', 0),
(2, 1, 'cs_test_b1FUeD177Y99LexKepHghIBLjBBtkRA3OBpgeqDxTsZQJMolAk1NVW06tv', 1899, 'txr_1KyyGVSH3d6vW3EyxLHo7DYm', 'GsiJrFkI', 1326, 0, 1, '2022-05-18 13:54:57', '2022-05-18 13:54:29', 0),
(3, 1, 'cs_test_b1c9KPSv1OP1wK2ktWCWz855eKCRAPwPD7Ig5WHkYzdNUWeRrVX8w9HUoH', 5456, 'txr_1KyyGdSH3d6vW3Ey8RMoDWoi', 'ZlAElP66', 4678, 0, 1, '2022-05-20 19:28:23', '2022-05-20 19:27:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `productcolor`
--

CREATE TABLE `productcolor` (
  `id` int(11) NOT NULL,
  `colorName` varchar(50) NOT NULL,
  `colorCode` varchar(50) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productcolor`
--

INSERT INTO `productcolor` (`id`, `colorName`, `colorCode`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 'navy', '#031159', '2022-04-11 15:38:31', '2022-04-11 15:37:59', 0),
(2, 'red', '#ff0000', NULL, '2022-04-11 15:38:46', 0),
(4, 'orange', '#ff571f', '2022-04-18 10:25:19', '2022-04-11 15:39:22', 0),
(5, 'grey', '#7a7a7a', '2022-04-18 10:24:47', '2022-04-12 11:39:24', 0),
(6, 'pink', '#f500c8', '2022-04-18 10:23:45', '2022-04-12 14:38:55', 0),
(7, 'blue', '#0000ff', NULL, '2022-04-13 15:51:10', 0),
(8, 'jasmine', '#baf2bb', '2022-04-26 11:04:35', '2022-04-25 18:46:13', 1),
(9, 'black', '#000000', '2022-04-26 11:05:01', '2022-04-26 11:04:52', 1),
(10, 'green', '#1fc309', '2022-04-26 11:35:54', '2022-04-26 11:35:30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `productreview`
--

CREATE TABLE `productreview` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `productRate` int(11) NOT NULL,
  `review` varchar(255) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productreview`
--

INSERT INTO `productreview` (`id`, `userId`, `productId`, `productRate`, `review`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 1, 3, 3, 'We offer the following delivery options for 24c ours over the world. Deliveries are not made on Saturdays, Sundays, or on public holidays. A specific time slot cannot be specified with any of our delivery options. Please refer to the Terms and Condition', NULL, '2022-05-20 14:59:46', 0),
(2, 1, 2, 3, 'not made on Saturdays, Sundays, or on public holidays. A specific time slot cannot be specified with any of our delivery options. Please refer to the Terms and Conditions of Sale.', NULL, '2022-05-20 15:01:32', 0),
(3, 1, 1, 5, 'We offer the following delivery options for 24c ours over the world. Deliveries are not made on Saturdays, Sundays or on public holidays. A specific time slot cannot be specified with any of our delivery ops', NULL, '2022-05-20 15:28:03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `stripeId` varchar(150) NOT NULL,
  `stripePriceId` varchar(150) NOT NULL,
  `productName` varchar(50) NOT NULL,
  `productDesc` varchar(150) NOT NULL,
  `productPrice` int(11) NOT NULL,
  `productSizeIds` varchar(100) NOT NULL,
  `productColorIds` varchar(100) NOT NULL,
  `productImages` text NOT NULL,
  `totalQuantity` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `subCategoryId` int(11) NOT NULL,
  `isTrending` tinyint(2) NOT NULL DEFAULT 0,
  `SKU` varchar(50) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `stripeId`, `stripePriceId`, `productName`, `productDesc`, `productPrice`, `productSizeIds`, `productColorIds`, `productImages`, `totalQuantity`, `categoryId`, `subCategoryId`, `isTrending`, `SKU`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 'prod_LfulhPs8gKBBz4', 'price_1KyYwGSH3d6vW3EypRMJpyi8', 'car', 'car toy for kids', 1299, '8', '7', 'product_1652533468195.png,product_1652533468985.png,product_1652533468316.png,product_1652350085281.png', 2, 3, 3, 1, 'prod1', '2022-05-14 18:34:28', '2022-05-12 15:38:07', 0),
(2, 'prod_LgJUafLHQeUBJy', 'price_1KywrcSH3d6vW3EynugcWF9O', 'abc t-shirt', 't-shirt for men', 200, '7,5,2', '5', 'product_1652442054348.png,product_1652442054618.png,product_1652442054869.png', 0, 1, 1, 1, 'prod2', '2022-05-13 17:11:13', '2022-05-13 17:10:54', 0),
(3, 'prod_LhmP5mgEgxWcBJ', 'price_1L0MqiSH3d6vW3EyGnwkrXdZ', 'cricket bat', 'made in india', 20, '2', '2,1', 'product_165278027299.png,product_1652780272891.png,product_1652780272855.png,product_1652780272530.png', 5, 3, 3, 1, 'prod113', NULL, '2022-05-17 15:07:53', 0),
(4, 'prod_LiyEyVs2HPVx1V', 'price_1L1WHhSH3d6vW3EyKUlGYEYv', 'supreme jeans', 'just for testing', 1099, '2,1', '7,5,1', 'product_1653054867477.png,product_1653054867911.png,product_1653054867297.png', 12, 1, 2, 1, 'prod114', NULL, '2022-05-20 19:24:30', 0),
(5, 'prod_LiyFlSrHMjQtoH', 'price_1L1WJLSH3d6vW3EyuGfs20JA', 'sneakers', 'special sneakers for women', 1599, '11,10', '7,6,5', 'product_165305496919.png,product_1653054969819.png,product_1653054969180.png', 15, 2, 4, 1, 'prod116', NULL, '2022-05-20 19:26:10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `productsize`
--

CREATE TABLE `productsize` (
  `id` int(11) NOT NULL,
  `size` varchar(50) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productsize`
--

INSERT INTO `productsize` (`id`, `size`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 'xll', '2022-04-11 15:36:12', '2022-04-11 15:05:01', 0),
(2, 'l', '2022-04-11 15:37:38', '2022-04-11 15:37:31', 0),
(5, 'xxxll', '2022-04-12 09:34:49', '2022-04-12 09:34:25', 0),
(7, 'm', NULL, '2022-04-13 15:53:16', 0),
(8, '124 x 50', NULL, '2022-04-13 17:42:02', 0),
(9, 'large', '2022-04-21 13:54:33', '2022-04-21 13:54:18', 1),
(10, '7', NULL, '2022-04-21 13:54:40', 0),
(11, '8', NULL, '2022-04-21 13:54:47', 0),
(12, '9', '2022-04-21 13:55:24', '2022-04-21 13:54:54', 1);

-- --------------------------------------------------------

--
-- Table structure for table `servicetax`
--

CREATE TABLE `servicetax` (
  `id` int(11) NOT NULL,
  `stripeId` varchar(150) NOT NULL,
  `tax` int(11) NOT NULL,
  `countryId` int(11) NOT NULL,
  `stateId` int(11) NOT NULL,
  `modifiedDate` datetime NOT NULL,
  `createdDate` datetime NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `servicetax`
--

INSERT INTO `servicetax` (`id`, `stripeId`, `tax`, `countryId`, `stateId`, `modifiedDate`, `createdDate`, `status`) VALUES
(2, 'txr_1KyyGVSH3d6vW3EyxLHo7DYm', 2, 1, 1, '0000-00-00 00:00:00', '2022-05-13 18:40:41', 0),
(3, 'txr_1KyyGdSH3d6vW3Ey8RMoDWoi', 5, 5, 4, '0000-00-00 00:00:00', '2022-05-13 18:40:50', 0),
(4, 'txr_1KyyIKSH3d6vW3EyBLVYau8S', 1, 1, 2, '0000-00-00 00:00:00', '2022-05-13 18:42:35', 0);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `state` varchar(50) NOT NULL,
  `countryId` int(11) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `state`, `countryId`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 'gujarat', 1, '2022-04-11 09:07:56', '2022-04-07 11:08:43', 0),
(2, 'maharashtra', 1, '2022-04-11 12:24:01', '2022-04-07 11:08:47', 0),
(3, 'olivia', 2, '2022-04-11 09:08:10', '2022-04-07 11:08:57', 0),
(4, 'sanghai', 5, NULL, '2022-04-13 17:24:35', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `subCatName` varchar(50) NOT NULL,
  `subCatDesc` varchar(150) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `categoryId`, `subCatName`, `subCatDesc`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 1, 't-shirt', 'made by using 100% quality fabric', '2022-04-11 14:21:09', '2022-04-11 11:06:03', 0),
(2, 1, 'jeans', '80% fire proof', '2022-04-11 12:01:46', '2022-04-11 11:52:36', 0),
(3, 3, 'toys', 'plastic toys for kids', NULL, '2022-04-13 15:18:21', 0),
(4, 2, 'shoes', 'shoes for women', NULL, '2022-04-21 13:53:21', 0),
(5, 3, 'jeans', 'testing', NULL, '2022-04-25 18:46:50', 0);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `reviewerName` varchar(100) NOT NULL,
  `reviewerProfession` varchar(100) NOT NULL,
  `reviewerImage` text DEFAULT NULL,
  `review` varchar(250) NOT NULL,
  `createdDate` datetime NOT NULL,
  `modifiedDate` datetime NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `reviewerName`, `reviewerProfession`, `reviewerImage`, `review`, `createdDate`, `modifiedDate`, `status`) VALUES
(1, 'John Cley', 'Cyclist', 'testi_1652957507660.png', 'lorem ipsum suffered alteration in aome from, by injected humor\r\n                                , or randomized words which don\'t look even slightly\r\n                                believable.There are many varation of passenger randomized words', '2022-05-19 11:41:45', '2022-05-19 16:21:47', 0),
(2, 'John Cena', 'Wrestler', 'testi_1652957472931.png', 'lorem ipsum suffered alteration in aome from, by injected humor\r\n                                , or randomized words which don\'t look even slightly\r\n                                believable.There are many varation of passenger randomized words', '2022-05-19 11:43:14', '2022-05-19 16:21:51', 0),
(3, 'Ratan Tata', 'Businessmen', NULL, 'lorem ipsum suffered alteration in aome from, by injected humor\r\n                                , or randomized words which don\'t look even slightly\r\n                                believable.There are many varation of passenger randomized words\r\n ', '2022-05-19 11:43:59', '2022-05-19 11:44:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `useraddress`
--

CREATE TABLE `useraddress` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `addressType` tinyint(2) NOT NULL,
  `streetname` varchar(50) NOT NULL,
  `cityId` int(11) NOT NULL,
  `stateId` int(11) NOT NULL,
  `countryId` int(11) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `useraddress`
--

INSERT INTO `useraddress` (`id`, `userId`, `addressType`, `streetname`, `cityId`, `stateId`, `countryId`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 1, 0, 'ganesh', 3, 2, 1, '2022-04-28 09:36:07', '2022-04-22 12:41:08', 0),
(2, 1, 1, 'ramdev', 1, 1, 1, '2022-04-28 09:36:07', '2022-04-22 12:41:08', 0),
(5, 5, 0, 'tramba village', 7, 4, 5, '2022-04-25 18:20:39', '2022-04-25 15:51:13', 0),
(6, 5, 1, 'tramba village', 7, 4, 5, '2022-04-25 16:44:47', '2022-04-25 15:51:26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender` tinyint(2) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `interestList` varchar(100) DEFAULT NULL,
  `otp` varchar(12) DEFAULT NULL,
  `otpexpiry` datetime DEFAULT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `firstname`, `lastname`, `gender`, `mobile`, `phone`, `interestList`, `otp`, `otpexpiry`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 'smit@1234', 'sssmit7648@gmail.com', '$2y$10$gPwjJSHoUye4NcGZSbLvKOEoNujIz.2BbgLtSMcGaoW70QQmGdG2S', 'Smit', 'Bhikadiya', 0, '7096794625', '123457', 'jeans, black', '835967', '2022-05-24 18:55:01', '2022-05-24 16:07:31', '2022-04-12 12:02:14', 0),
(5, 'smit@123', 'sbhikadiya892@rku.ac.in', '$2y$10$UeP7IcxJlOgPFImoQkR4t.D4GWCfN2n63Uada2QwUPanq/grfVxNC', 'Smit', 'Bhikadiya', 0, '6458967456', '654334', NULL, '375269', '2022-05-23 18:11:24', '2022-04-25 16:44:47', '2022-04-21 17:14:04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `modifiedDate` datetime NOT NULL,
  `createdDate` datetime NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `userId`, `productId`, `modifiedDate`, `createdDate`, `status`) VALUES
(2, 1, 5, '2022-05-25 13:08:07', '2022-05-25 13:07:46', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminuser`
--
ALTER TABLE `adminuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productId` (`productId`),
  ADD KEY `userID__` (`userId`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stateid` (`stateId`),
  ADD KEY `countryid` (`countryId`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homebanners`
--
ALTER TABLE `homebanners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderaddress`
--
ALTER TABLE `orderaddress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cityid3` (`cityId`),
  ADD KEY `countryid3` (`countryId`),
  ADD KEY `stateid3` (`stateId`),
  ADD KEY `orderid3` (`orderId`);

--
-- Indexes for table `orderlist`
--
ALTER TABLE `orderlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productid2` (`productId`),
  ADD KEY `orderid2` (`orderId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid1` (`userId`);

--
-- Indexes for table `productcolor`
--
ALTER TABLE `productcolor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productreview`
--
ALTER TABLE `productreview`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productId12` (`productId`),
  ADD KEY `userId12` (`userId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category1` (`categoryId`),
  ADD KEY `subcategory` (`subCategoryId`);

--
-- Indexes for table `productsize`
--
ALTER TABLE `productsize`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servicetax`
--
ALTER TABLE `servicetax`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countryId___` (`countryId`),
  ADD KEY `stateId___` (`stateId`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`countryId`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`categoryId`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `useraddress`
--
ALTER TABLE `useraddress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cityid` (`cityId`),
  ADD KEY `country` (`countryId`),
  ADD KEY `state` (`stateId`),
  ADD KEY `userid` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminuser`
--
ALTER TABLE `adminuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `homebanners`
--
ALTER TABLE `homebanners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orderaddress`
--
ALTER TABLE `orderaddress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `productcolor`
--
ALTER TABLE `productcolor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `productreview`
--
ALTER TABLE `productreview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `productsize`
--
ALTER TABLE `productsize`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `servicetax`
--
ALTER TABLE `servicetax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `useraddress`
--
ALTER TABLE `useraddress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `productId` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `userID__` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `countryid` FOREIGN KEY (`countryId`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `stateid` FOREIGN KEY (`stateId`) REFERENCES `states` (`id`);

--
-- Constraints for table `orderaddress`
--
ALTER TABLE `orderaddress`
  ADD CONSTRAINT `cityid3` FOREIGN KEY (`cityId`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `countryid3` FOREIGN KEY (`countryId`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `orderid3` FOREIGN KEY (`orderId`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `stateid3` FOREIGN KEY (`stateId`) REFERENCES `states` (`id`);

--
-- Constraints for table `orderlist`
--
ALTER TABLE `orderlist`
  ADD CONSTRAINT `orderid2` FOREIGN KEY (`orderId`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `productid2` FOREIGN KEY (`productId`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `userid1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `productreview`
--
ALTER TABLE `productreview`
  ADD CONSTRAINT `productId12` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `userId12` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `category1` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `subcategory` FOREIGN KEY (`subCategoryId`) REFERENCES `subcategory` (`id`);

--
-- Constraints for table `servicetax`
--
ALTER TABLE `servicetax`
  ADD CONSTRAINT `countryId___` FOREIGN KEY (`countryId`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `stateId___` FOREIGN KEY (`stateId`) REFERENCES `states` (`id`);

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `country_id` FOREIGN KEY (`countryId`) REFERENCES `countries` (`id`);

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `category` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`);

--
-- Constraints for table `useraddress`
--
ALTER TABLE `useraddress`
  ADD CONSTRAINT `cityid` FOREIGN KEY (`cityId`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `country` FOREIGN KEY (`countryId`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `state` FOREIGN KEY (`stateId`) REFERENCES `states` (`id`),
  ADD CONSTRAINT `userid` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
