-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2023 at 10:02 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nwf_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `categoryType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `categoryLink` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `categoryName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `categoryDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `categoryDateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `categoryDateUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `userID`, `categoryType`, `categoryLink`, `categoryName`, `categoryDescription`, `categoryDateCreated`, `categoryDateUpdated`) VALUES
(46, 44, 'test1', 'all', 'test1', 'dfgdgdffdg', '2022-08-19 13:38:34', '2022-08-19 11:38:34'),
(47, 44, 'dfgdgf', 'dfgfd', 'gdfg', 'dfgdfgdfg', '2022-08-19 14:59:46', '2022-08-19 12:59:46'),
(48, 44, 'dfgdgf', 'dfgfd', 'gdfg', 'dfgdfgdfg', '2022-08-19 15:01:26', '2022-08-19 13:01:26'),
(49, 44, 'dfgdf', 'dfgdfdfgdf', 'dfgdf', 'dfgdfg', '2022-08-19 15:04:07', '2022-08-19 13:04:07'),
(50, 44, '1111111111', 'sdfsdf', 'sdfsd', 'sdfsdf', '2022-08-19 15:07:53', '2022-08-19 13:07:53');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `pageID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `pageName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pageTitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pageContent` text COLLATE utf8_unicode_ci NOT NULL,
  `pageLanguage` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '''DE''',
  `PageMetaTitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `PageMetaDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `PageMetaKeywords` text COLLATE utf8_unicode_ci NOT NULL,
  `pageStatus` int(11) NOT NULL DEFAULT 0,
  `pageDateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `pageDateUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`pageID`, `userID`, `pageName`, `pageTitle`, `pageContent`, `pageLanguage`, `PageMetaTitle`, `PageMetaDescription`, `PageMetaKeywords`, `pageStatus`, `pageDateCreated`, `pageDateUpdated`) VALUES
(22, 55, 'about', 'ABOUT US', '<h2><strong>Abous Us</strong></h2>\r\n\r\n<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos veniam optio dolorem. Mollitia, perferendis officia. Dignissimos pariatur quidem quos commodi a! Error soluta velit at recusandae quae esse illo magni earum asperiores id, itaque vel sint, voluptatibus magnam cupiditate quis eum adipisci dignissimos minima ipsam sapiente cumque nostrum necessitatibus nihil. Impedit at beatae dicta doloribus quasi natus amet illo mollitia ad tempora rem asperiores, laboriosam saepe, unde, molestias dolore. Ea facilis recusandae optio, doloribus, architecto voluptatum voluptatibus, minus aliquam excepturi tempore omnis culpa nam incidunt vero natus labore nobis aspernatur exercitationem! Nobis illo a in, laborum voluptate dolorum aliquid repudiandae.</p>\r\n', 'EN', '', '', '', 1, '2020-04-10 13:04:03', '2022-06-29 10:29:28'),
(26, 55, 'home', 'HOME', '<h2><strong>HOME</strong></h2>\r\n\r\n<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta, unde magni. Magni saepe expedita autem quam inventore veritatis eum omnis! Sapiente a vel, maxime fugit in dolor, est accusantium libero, nesciunt perferendis inventore! Molestias assumenda magnam eius praesentium dolor ipsa excepturi libero quia eaque? Nobis exercitationem repudiandae perferendis. Inventore recusandae, corrupti commodi ab eveniet nesciunt cum. Corporis cum cupiditate est ullam debitis laudantium ipsam reprehenderit similique, molestiae explicabo officiis itaque totam, quaerat, minus dolore sed et tempore eveniet beatae! Voluptas nemo ex numquam esse autem officia illo, voluptatibus hic modi, error, laboriosam rem. Dignissimos, id accusantium numquam delectus ullam iusto?</p>\r\n', 'EN', '', '', '', 1, '2020-04-13 13:43:10', '2022-06-29 10:29:43'),
(31, 55, 'contact', 'CONTACT', '<p><span style=\"font-size:2em;\"><i class=\"fas fa-map-marker-alt\"></i></span><br />\r\n<span style=\"font-size:20px;\">company<br />\r\naddress,<br />\r\npostalcode city,<br />\r\nCountry<br />\r\n<br />\r\n<i class=\"fas fa-phone-square-alt\"></i> <strong class=\"pl-1\">Tel: </strong><a href=\"tel:+00 000 00 00 00\">+00 000 00 00 00</a><br />\r\n<i class=\"fas fa-phone-square-alt\"></i> <strong class=\"pl-1\">Tel: </strong><a href=\"tel:+00 000 00 00 00\">+00 000 00 00 00</a><br />\r\n<i class=\"fas fa-envelope\"></i> <small class=\"pl-1\"><strong>E-Mail:</strong> <a href=\"mailto:office@company.com\">office@company.com</a></small></span></p>\r\n', 'EN', '', '', '', 1, '2020-04-13 17:15:46', '2022-06-29 10:29:37');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `servicesID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `servicesTitle` varchar(250) COLLATE utf8_swedish_ci NOT NULL,
  `servicesDescription` text COLLATE utf8_swedish_ci NOT NULL,
  `servicesImage` varchar(250) COLLATE utf8_swedish_ci NOT NULL,
  `servicesStatus` int(11) NOT NULL DEFAULT 0,
  `servicesDateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `servicesDateUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `translationID` int(11) NOT NULL,
  `translationCode` int(11) NOT NULL,
  `languageCode` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `translationText` text COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`translationID`, `translationCode`, `languageCode`, `translationText`) VALUES
(1, 911, 'al', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Odio, maiores esse. Eius, optio. Corporis aperiam quisquam, pariatur corrupti minus similique aut culpa molestiae dignissimos, vero mollitia perspiciatis doloribus animi consequuntur consectetur id dolorem eaque enim quibusdam aspernatur molestias quia quasi ex? Nobis vel modi libero cum maxime earum. Optio, unde?'),
(2, 911, 'en', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit debitis quos laborum nulla, maiores illum cumque aliquid incidunt culpa mollitia!'),
(3, 154, 'al', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Odio, maiores esse. Eius, optio. Corporis aperiam quisquam, pariatur corrupti minus similique aut culpa molestiae dignissimos, vero mollitia perspiciatis doloribus animi consequuntur consectetur id dolorem eaque enim quibusdam aspernatur molestias quia quasi ex? Nobis vel modi libero cum maxime earum. Optio, unde?'),
(4, 154, 'en', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit debitis quos laborum nulla, maiores illum cumque aliquid incidunt culpa mollitia!'),
(5, 111, 'en', 'This text is in english language'),
(6, 111, 'al', 'Ky esht text ne gjuhen shqipe');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `userName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userEmail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userPassword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userRole` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `userDateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `userDateUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `userName`, `userEmail`, `userPassword`, `userRole`, `userDateCreated`, `userDateUpdated`) VALUES
(1, 'admin', 'admin@company.com', '$2y$10$FlriGmoMyGPm1E6qpvwjFePyESQeRhVH9yyWDELsVPiTp4e9JiWr.', 'admin', '2019-12-28 18:58:35', '2022-06-29 10:41:42'),
(33, 'support', 'support@company.com', '$2y$10$FlriGmoMyGPm1E6qpvwjFePyESQeRhVH9yyWDELsVPiTp4e9JiWr.', 'default', '2019-11-26 20:19:44', '2022-06-29 10:42:30'),
(55, 'nesho', 'ademi.neshat@gmail.com', '$2y$10$EIc7mYel10zCUUG/uU9wnOWTLz9t6v5ACXViziAYDo89pIxZben0S', 'admin', '2022-04-21 22:03:45', '2022-12-14 12:09:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`pageID`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`servicesID`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`translationID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `pageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `servicesID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `translationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
