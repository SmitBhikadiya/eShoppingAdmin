-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2022 at 06:24 AM
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
(4, 'hrandses', 3, 2, '2022-04-11 09:07:09', '2022-04-07 13:12:15', 0),
(5, 'new pune', 2, 1, '2022-04-11 09:10:45', '2022-04-11 09:10:18', 0);

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
(2, 'brazill', '2022-04-07 13:11:42', '2022-04-07 11:08:33', 0);

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

-- --------------------------------------------------------

--
-- Table structure for table `productimages`
--

CREATE TABLE `productimages` (
  `id` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `imageURL` varchar(150) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `productImageIds` varchar(100) NOT NULL,
  `totalQuantity` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `subCategoryId` int(11) NOT NULL,
  `modifiedDate` datetime DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(2, 'maharashtra', 1, NULL, '2022-04-07 11:08:47', 0),
(3, 'olivia', 2, '2022-04-11 09:08:10', '2022-04-07 11:08:57', 0);

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
-- Indexes for table `productcolor`
--
ALTER TABLE `productcolor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productimages`
--
ALTER TABLE `productimages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product` (`productId`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `productcolor`
--
ALTER TABLE `productcolor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productimages`
--
ALTER TABLE `productimages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productreview`
--
ALTER TABLE `productreview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productsize`
--
ALTER TABLE `productsize`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `useraddress`
--
ALTER TABLE `useraddress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `productimages`
--
ALTER TABLE `productimages`
  ADD CONSTRAINT `product` FOREIGN KEY (`productId`) REFERENCES `products` (`id`);

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
