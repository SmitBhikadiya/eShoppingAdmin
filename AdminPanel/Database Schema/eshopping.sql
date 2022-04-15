-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2022 at 05:54 AM
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
(2, 'brazill', '2022-04-07 13:11:42', '2022-04-07 11:08:33', 0),
(3, 'us', NULL, '2022-04-11 12:24:12', 0),
(4, 'south korea', NULL, '2022-04-13 17:22:32', 0),
(5, 'china', NULL, '2022-04-13 17:22:40', 0),
(6, 'thailand', NULL, '2022-04-13 17:22:55', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orderaddress`
--

CREATE TABLE `orderaddress` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
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

INSERT INTO `orderaddress` (`id`, `orderId`, `streetName`, `cityId`, `countryId`, `stateId`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 1, 'shivam', 3, 1, 2, '2022-04-12 15:07:21', '2022-04-12 15:07:21', 0),
(2, 2, 'Satyam Society, Shanti nagar', 5, 1, 2, '2022-04-13 07:34:03', '2022-04-13 07:34:03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orderlist`
--

CREATE TABLE `orderlist` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `productName` varchar(50) NOT NULL,
  `productImage` text NOT NULL,
  `productSize` varchar(50) NOT NULL,
  `productColor` varchar(50) NOT NULL,
  `productColorCode` varchar(50) NOT NULL,
  `unitPrice` int(11) NOT NULL,
  `qunatity` int(11) NOT NULL,
  `subTotal` int(11) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderlist`
--

INSERT INTO `orderlist` (`id`, `orderId`, `productId`, `productName`, `productImage`, `productSize`, `productColor`, `productColorCode`, `unitPrice`, `qunatity`, `subTotal`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 1, 2, 'polo tshirt black', 'blackandwhite.jpg,fullsleevetshirt.jpg', 'xl', 'green', '#00ff00', 299, 1, 299, '2022-04-12 15:04:55', '2022-04-12 15:04:55', 0),
(2, 1, 1, 'Signature T-shirt', 'product_1649754686373.png,product_1649754686824.png', 'l', 'blue', '#0000ff', 599, 2, 1198, '2022-04-12 15:08:10', '2022-04-12 15:08:10', 0),
(3, 2, 5, 'jeans', 'product_1649827927705.png', 'Xl', 'navy blue', '#031159', 799, 1, 799, '2022-04-13 07:32:39', '2022-04-13 07:32:39', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `totalPrice` int(11) NOT NULL,
  `totalQuantity` int(11) NOT NULL,
  `orderStatus` tinyint(2) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `userId`, `totalPrice`, `totalQuantity`, `orderStatus`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 1, 1497, 3, 1, '2022-04-13 09:44:12', '2022-04-12 15:04:20', 0),
(2, 1, 799, 1, 2, '2022-04-13 17:54:22', '2022-04-13 07:30:50', 0);

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
(1, 'navy blue', '#031159', '2022-04-11 15:38:31', '2022-04-11 15:37:59', 0),
(2, 'red', '#ff0000', NULL, '2022-04-11 15:38:46', 0),
(4, 'yellow', '#fbff1f', '2022-04-12 11:39:49', '2022-04-11 15:39:22', 0),
(5, 'green', '#1fbd00', '2022-04-12 11:39:37', '2022-04-12 11:39:24', 0),
(6, 'black', '#000000', NULL, '2022-04-12 14:38:55', 0),
(7, 'blue', '#0000ff', NULL, '2022-04-13 15:51:10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `productreview`
--

CREATE TABLE `productreview` (
  `id` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `productRate` int(11) NOT NULL,
  `review` varchar(150) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `productName` varchar(50) NOT NULL,
  `productDesc` varchar(150) NOT NULL,
  `productPrice` int(11) NOT NULL,
  `productSizeIds` varchar(100) NOT NULL,
  `productColorIds` varchar(100) NOT NULL,
  `productImages` text NOT NULL,
  `totalQuantity` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `subCategoryId` int(11) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `productName`, `productDesc`, `productPrice`, `productSizeIds`, `productColorIds`, `productImages`, `totalQuantity`, `categoryId`, `subCategoryId`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 't-shirt', 'full sleeve t-shirt', 293, '2,1', '2,1', 'product_1649834498744.png,product_1649834498793.png', 10, 1, 1, '2022-04-13 12:51:38', '2022-04-12 10:59:15', 0),
(2, 'polo t-shirt', 'for testing', 597, '2', '6,2', 'product_1649908382608.png', 11, 1, 1, '2022-04-14 09:23:02', '2022-04-12 11:38:45', 0),
(3, 'blacky shine', 'this is for testing', 898, '4,2', '1', 'product_1649747082428.png', 45, 1, 2, '2022-04-12 14:37:02', '2022-04-12 12:34:42', 0),
(4, 'abc', 'for testing', 1299, '4,2', '1', 'product_1649754686373.png,product_1649754686824.png', 13, 1, 2, '2022-04-12 14:59:53', '2022-04-12 14:40:36', 1),
(5, 'jeans', '100% dustproof', 799, '5,2', '1', 'product_1649827927850.png,product_1649827927705.png', 15, 1, 2, '2022-04-13 11:02:25', '2022-04-13 11:02:07', 0),
(6, 'remote super car', 'this is a remote car for kids', 248, '8', '5,2', 'product_1649852044962.png', 15, 3, 3, NULL, '2022-04-13 17:44:04', 0);

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
(8, '124 x 50', NULL, '2022-04-13 17:42:02', 0);

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
(3, 3, 'toys', 'plastic toys for kids', NULL, '2022-04-13 15:18:21', 0);

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(16) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender` tinyint(2) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `interestList` varchar(100) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `firstname`, `lastname`, `gender`, `mobile`, `phone`, `interestList`, `modifiedDate`, `createdDate`, `status`) VALUES
(1, 'smit', 'smit@gmail.com', '1234567890', 'S', 'D', 0, '7096794624', '12345', 'jeans, black', '2022-04-12 16:11:32', '2022-04-12 12:02:14', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminuser`
--
ALTER TABLE `adminuser`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `orderaddress`
--
ALTER TABLE `orderaddress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderid3` (`orderId`),
  ADD KEY `cityid3` (`cityId`),
  ADD KEY `countryid3` (`countryId`),
  ADD KEY `stateid3` (`stateId`);

--
-- Indexes for table `orderlist`
--
ALTER TABLE `orderlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderid2` (`orderId`),
  ADD KEY `productid2` (`productId`);

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
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminuser`
--
ALTER TABLE `adminuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- AUTO_INCREMENT for table `orderaddress`
--
ALTER TABLE `orderaddress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `productcolor`
--
ALTER TABLE `productcolor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `productreview`
--
ALTER TABLE `productreview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `productsize`
--
ALTER TABLE `productsize`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `useraddress`
--
ALTER TABLE `useraddress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `category1` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `subcategory` FOREIGN KEY (`subCategoryId`) REFERENCES `subcategory` (`id`);

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
