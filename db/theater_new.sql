-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2015 at 08:07 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `theater_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `is_sync` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `parent_id`, `path`, `display_order`, `status`, `is_sync`) VALUES
(1, 'Pop-Corn', 0, 'Pop-Corn', 0, 'Active', '0'),
(6, 'Pizza', 0, 'Pizza', 0, 'Active', '0'),
(7, 'Puff', 0, 'Puff', 0, 'Active', '0'),
(8, 'sandwich', 0, 'sandwich', 0, 'Active', '0'),
(9, 'burger', 0, 'burger', 0, 'Active', '0'),
(10, 'chocolate', 0, 'chocolate', 0, 'Active', '0'),
(11, 'juice', 0, 'juice', 0, 'Active', '0'),
(12, 'Cold-Drinks', 0, 'Cold-Drinks', 0, 'Active', '0'),
(17, 'Fruits', 0, 'Fruits', 0, 'Inactive', '0');

-- --------------------------------------------------------

--
-- Table structure for table `ci_cookies`
--

CREATE TABLE IF NOT EXISTS `ci_cookies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cookie_id` varchar(255) DEFAULT NULL,
  `netid` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `orig_page_requested` varchar(120) DEFAULT NULL,
  `php_session_id` varchar(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('6d00db5199790f9d6ae74ef03d180a0e', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36', 1441258777, 'a:7:{s:9:"user_data";s:0:"";s:8:"username";s:7:"bhushan";s:7:"user_id";s:2:"18";s:9:"user_type";s:8:"operator";s:10:"company_id";s:1:"2";s:12:"is_logged_in";b:1;s:14:"total_quantity";i:0;}'),
('6952a7649d7faa4d6ec0881dad28ce4e', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0', 1441259993, 'a:18:{s:9:"user_data";s:0:"";s:8:"username";s:5:"admin";s:7:"user_id";s:1:"1";s:9:"user_type";s:11:"super_admin";s:10:"company_id";i:0;s:12:"is_logged_in";b:1;s:17:"category_selected";N;s:22:"search_string_selected";N;s:5:"order";N;s:10:"order_type";N;s:12:"redirect_url";s:54:"http://localhost/theater/admin/products/ingredients/35";s:17:"products_selected";N;s:13:"flash_message";s:0:"";s:13:"user_selected";N;s:16:"company_selected";N;s:17:"material_selected";N;s:14:"total_quantity";i:4;s:12:"uom_selected";N;}');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `is_sync` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `status`, `is_sync`) VALUES
(2, 'theater 1', 'Active', '0'),
(3, 'Food On Seats', 'Active', '0');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `contact` int(12) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fb_id` varchar(255) NOT NULL,
  `google_id` varchar(255) NOT NULL,
  `is_sync` enum('1','0') NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE IF NOT EXISTS `ingredients` (
  `ingredients_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `uom` varchar(255) NOT NULL,
  `cost` int(11) NOT NULL,
  `is_sync` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`ingredients_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `inventory_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `qua` decimal(10,2) NOT NULL,
  `uom` enum('LTR','KG') NOT NULL DEFAULT 'KG',
  `total_cost` decimal(10,2) NOT NULL,
  PRIMARY KEY (`inventory_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `name`, `qua`, `uom`, `total_cost`) VALUES
(2, 'CocaCola', '1.00', 'LTR', '450.00'),
(3, 'Pepsi', '4.00', 'KG', '600.00'),
(4, 'Cheese Corn', '6.00', 'KG', '110.00'),
(5, 'PineApple', '5.00', 'LTR', '4.00'),
(6, 'product12', '4.00', 'KG', '400.00'),
(7, 'Veg. Pizza', '1.00', 'KG', '100.00'),
(8, 'Sprite', '1.00', 'LTR', '30.00'),
(9, 'Red Bull', '1.00', 'LTR', '110.00');

-- --------------------------------------------------------

--
-- Table structure for table `item_row_material`
--

CREATE TABLE IF NOT EXISTS `item_row_material` (
  `item_row_material_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `uom` enum('KG','GM','LTR') NOT NULL DEFAULT 'KG',
  `qty` decimal(12,2) NOT NULL,
  `cost` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `is_sync` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_row_material_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `item_row_material`
--

INSERT INTO `item_row_material` (`item_row_material_id`, `name`, `description`, `uom`, `qty`, `cost`, `status`, `is_sync`) VALUES
(2, 'Cheese Corn', '<p>Cheese Corn</p>\r\n', 'KG', '20.65', '10.00', 'Active', '0'),
(4, 'PineApple', '<p>PineApple</p>\r\n', 'LTR', '21.40', '1.00', 'Active', '0');

-- --------------------------------------------------------

--
-- Table structure for table `item_row_material_purchase`
--

CREATE TABLE IF NOT EXISTS `item_row_material_purchase` (
  `item_row_material_purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_quantity` decimal(10,2) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `datetime` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`item_row_material_purchase_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `item_row_material_purchase`
--

INSERT INTO `item_row_material_purchase` (`item_row_material_purchase_id`, `user_id`, `total_quantity`, `total_amount`, `datetime`, `status`) VALUES
(1, 1, '2.00', '240.00', '1441088302', 'Active'),
(2, 1, '3.00', '320.00', '1441170209', 'Active'),
(3, 1, '2.00', '220.00', '1441171230', 'Active'),
(4, 1, '2.00', '220.00', '1441172997', 'Active'),
(5, 1, '1.00', '100.00', '1441183900', 'Active'),
(6, 1, '2.00', '60.00', '1441183918', 'Active'),
(7, 1, '1.00', '100.00', '1441190088', 'Active'),
(8, 1, '1.00', '100.00', '1441190090', 'Active'),
(9, 1, '1.00', '100.00', '1441190095', 'Active'),
(10, 1, '1.00', '100.00', '1441190097', 'Active'),
(11, 1, '1.00', '100.00', '1441190103', 'Active'),
(12, 1, '1.00', '100.00', '1441190140', 'Active'),
(13, 1, '1.00', '200.00', '1441190147', 'Active'),
(14, 1, '1.00', '100.00', '1441190246', 'Active'),
(15, 1, '1.00', '100.00', '1441190335', 'Active'),
(16, 1, '1.00', '100.00', '1441190430', 'Active'),
(17, 1, '1.00', '100.00', '1441190491', 'Active'),
(18, 1, '3.00', '300.00', '1441190554', 'Active'),
(19, 1, '3.00', '300.00', '1441190810', 'Active'),
(20, 1, '4.00', '300.00', '1441259909', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `item_row_material_purchase_details`
--

CREATE TABLE IF NOT EXISTS `item_row_material_purchase_details` (
  `item_row_material_purchase_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_row_material_purchase_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cost` decimal(12,2) NOT NULL,
  `qty` decimal(12,2) NOT NULL,
  `uom` varchar(255) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `datetime` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`item_row_material_purchase_details_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `item_row_material_purchase_details`
--

INSERT INTO `item_row_material_purchase_details` (`item_row_material_purchase_details_id`, `item_row_material_purchase_id`, `products_id`, `name`, `cost`, `qty`, `uom`, `total`, `datetime`, `status`) VALUES
(1, 1, 11, 'Margerita', '120.00', '2.00', 'KG', '240.00', '1441088302', 'Active'),
(2, 2, 11, 'Margerita', '120.00', '1.00', 'KG', '120.00', '1441170209', 'Active'),
(3, 3, 11, 'Margerita', '120.00', '1.00', 'KG', '120.00', '1441171230', 'Active'),
(4, 3, 18, 'Veg. Pizza', '100.00', '1.00', 'KG', '100.00', '1441171230', 'Active'),
(5, 4, 11, 'Margerita', '120.00', '1.00', 'KG', '120.00', '1441172997', 'Active'),
(6, 4, 18, 'Veg. Pizza', '100.00', '1.00', 'KG', '100.00', '1441172997', 'Active'),
(7, 5, 9, 'product12', '100.00', '1.00', 'KG', '100.00', '1441183900', 'Active'),
(8, 6, 26, 'Pepsi', '30.00', '2.00', 'LTR', '60.00', '1441183918', 'Active'),
(9, 7, 9, 'product12', '100.00', '1.00', 'KG', '100.00', '1441190088', 'Active'),
(10, 8, 9, 'product12', '100.00', '1.00', 'KG', '100.00', '1441190090', 'Active'),
(11, 9, 9, 'product12', '100.00', '1.00', 'KG', '100.00', '1441190095', 'Active'),
(12, 10, 9, 'product12', '100.00', '1.00', 'KG', '100.00', '1441190097', 'Active'),
(13, 11, 9, 'product12', '100.00', '1.00', 'KG', '100.00', '1441190104', 'Active'),
(14, 12, 9, 'product12', '100.00', '1.00', 'KG', '100.00', '1441190140', 'Active'),
(15, 13, 10, 'this cat', '200.00', '1.00', 'KG', '200.00', '1441190147', 'Active'),
(16, 14, 9, 'product12', '100.00', '1.00', 'KG', '100.00', '1441190247', 'Active'),
(17, 15, 9, 'product12', '100.00', '1.00', 'KG', '100.00', '1441190335', 'Active'),
(18, 17, 9, 'product12', '100.00', '1.00', 'KG', '100.00', '1441190491', 'Active'),
(19, 18, 9, 'product12', '100.00', '3.00', 'KG', '300.00', '1441190554', 'Active'),
(20, 19, 9, 'product12', '100.00', '3.00', 'KG', '300.00', '1441190810', 'Active'),
(21, 20, 17, 'Cheese Corn', '60.00', '1.00', 'KG', '60.00', '1441259909', 'Active'),
(22, 20, 18, 'Veg. Pizza', '100.00', '1.00', 'KG', '100.00', '1441259909', 'Active'),
(23, 20, 27, 'Sprite', '30.00', '1.00', 'LTR', '30.00', '1441259909', 'Active'),
(24, 20, 28, 'Red Bull', '110.00', '1.00', 'LTR', '110.00', '1441259910', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `operator`
--

CREATE TABLE IF NOT EXISTS `operator` (
  `operator_id` int(11) NOT NULL AUTO_INCREMENT,
  `pos_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` int(12) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `is_sync` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`operator_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `total_amount` int(11) NOT NULL,
  `datetime` int(11) NOT NULL DEFAULT '0',
  `pos_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `status` enum('Pending','Approved','Delivered') NOT NULL DEFAULT 'Pending',
  `flag` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `payment_mode` enum('cash','debit card') NOT NULL DEFAULT 'cash',
  `discount` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `grand_amount` int(11) NOT NULL,
  `is_sync` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=115 ;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `total_amount`, `datetime`, `pos_id`, `customer_id`, `status`, `flag`, `user_id`, `payment_mode`, `discount`, `quantity`, `grand_amount`, `is_sync`) VALUES
(51, 250, 1439893832, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 250, '0'),
(50, 260, 1439795228, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 260, '0'),
(49, 390, 1439795225, 0, 0, 'Pending', '', '18', 'cash', 0, 4, 390, '0'),
(43, 210, 1438239714, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210, '0'),
(44, 250, 1438601540, 0, 0, 'Pending', '', '18', 'cash', 0, 4, 250, '0'),
(45, 200, 1438682613, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 200, '0'),
(46, 200, 1438784261, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 200, '0'),
(47, 300, 1439187385, 0, 0, 'Pending', '', '18', 'cash', 0, 4, 300, '0'),
(48, 390, 1439562215, 0, 0, 'Pending', '', '18', 'cash', 0, 4, 390, '0'),
(52, 220, 1440673231, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(53, 30, 1440765444, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 30, '0'),
(54, 110, 1440765455, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 110, '0'),
(55, 30, 1440765571, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 30, '0'),
(56, 120, 1440765610, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 120, '0'),
(57, 30, 1440765650, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 30, '0'),
(58, 30, 1440765688, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 30, '0'),
(59, 30, 1440765800, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 30, '0'),
(60, 30, 1440766093, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 30, '0'),
(61, 30, 1440766940, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 30, '0'),
(62, 30, 1440767002, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 30, '0'),
(63, 110, 1440767027, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 110, '0'),
(64, 120, 1441011933, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 120, '0'),
(65, 150, 1441012027, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 150, '0'),
(66, 30, 1441012041, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 30, '0'),
(67, 50, 1441012087, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 50, '0'),
(68, 50, 1441012198, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 50, '0'),
(69, 50, 1441012737, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 50, '0'),
(70, 50, 1441012963, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 50, '0'),
(71, 50, 1441014032, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 50, '0'),
(72, 50, 1441014319, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 50, '0'),
(73, 50, 1441022843, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 50, '0'),
(74, 150, 1441022946, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 150, '0'),
(75, 200, 1441022985, 0, 0, 'Pending', '', '18', 'cash', 0, 4, 200, '0'),
(76, 100, 1441023017, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 100, '0'),
(77, 250, 1441101658, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 250, '0'),
(78, 280, 1441101849, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 280, '0'),
(79, 280, 1441102215, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 280, '0'),
(80, 280, 1441102219, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 280, '0'),
(81, 560, 1441102321, 0, 0, 'Pending', '', '18', 'cash', 0, 6, 560, '0'),
(82, 560, 1441102348, 0, 0, 'Pending', '', '18', 'cash', 0, 6, 560, '0'),
(83, 560, 1441102352, 0, 0, 'Pending', '', '18', 'cash', 0, 6, 560, '0'),
(84, 560, 1441102901, 0, 0, 'Pending', '', '18', 'cash', 0, 6, 560, '0'),
(85, 250, 1441111209, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 250, '0'),
(86, 250, 1441111211, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 250, '0'),
(87, 250, 1441111218, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 250, '0'),
(88, 250, 1441111280, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 250, '0'),
(89, 80, 1441173024, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 80, '0'),
(90, 50, 1441178683, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 50, '0'),
(91, 220, 1441255880, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(92, 220, 1441255887, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(93, 220, 1441256352, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(94, 220, 1441256354, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(95, 220, 1441256365, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(96, 220, 1441256371, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(97, 220, 1441256399, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(98, 220, 1441256438, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(99, 220, 1441256743, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(100, 220, 1441256947, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(101, 220, 1441257053, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(102, 220, 1441257137, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(103, 440, 1441257842, 0, 0, 'Pending', '', '18', 'cash', 0, 4, 440, '0'),
(104, 340, 1441258045, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 340, '0'),
(105, 340, 1441258475, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 340, '0'),
(106, 340, 1441258491, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 340, '0'),
(107, 220, 1441258586, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(108, 340, 1441258652, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 340, '0'),
(109, 220, 1441258731, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(110, 220, 1441258783, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(111, 220, 1441258887, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 220, '0'),
(112, 280, 1441258962, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 280, '0'),
(113, 360, 1441259241, 0, 0, 'Pending', '', '18', 'cash', 0, 7, 360, '0'),
(114, 460, 1441259304, 0, 0, 'Pending', '', '18', 'cash', 0, 4, 460, '0');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE IF NOT EXISTS `order_detail` (
  `order_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `datetime` int(11) NOT NULL DEFAULT '0',
  `is_sync` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_detail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=239 ;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`order_detail_id`, `order_id`, `customer_id`, `product_id`, `product_title`, `quantity`, `cost`, `datetime`, `is_sync`) VALUES
(124, 51, 0, 19, 'Aloo Mutter', 1, 30, 1439893832, '0'),
(123, 51, 0, 12, 'Italian', 1, 100, 1439893832, '0'),
(122, 51, 0, 11, 'Margerita', 1, 120, 1439893832, '0'),
(121, 50, 0, 28, 'Red Bull', 1, 110, 1439795228, '0'),
(120, 50, 0, 19, 'Aloo Mutter', 1, 30, 1439795228, '0'),
(119, 50, 0, 11, 'Margerita', 1, 120, 1439795228, '0'),
(118, 49, 0, 19, 'Aloo Mutter', 1, 30, 1439795225, '0'),
(117, 48, 0, 19, 'Aloo Mutter', 1, 30, 1439562215, '0'),
(116, 48, 0, 11, 'Margerita', 3, 360, 1439562215, '0'),
(115, 47, 0, 18, 'veg. pizza', 2, 200, 1439187385, '0'),
(114, 47, 0, 11, 'margerita', 2, 100, 1439187385, '0'),
(105, 43, 0, 11, 'margerita', 1, 50, 1438239714, '0'),
(106, 43, 0, 18, 'veg. pizza', 1, 100, 1438239714, '0'),
(107, 43, 0, 12, 'italian', 1, 60, 1438239714, '0'),
(108, 44, 0, 11, 'margerita', 3, 150, 1438601540, '0'),
(109, 44, 0, 18, 'veg. pizza', 1, 100, 1438601540, '0'),
(110, 45, 0, 11, 'margerita', 2, 100, 1438682613, '0'),
(111, 45, 0, 18, 'veg. pizza', 1, 100, 1438682613, '0'),
(112, 46, 0, 11, 'margerita', 2, 100, 1438784261, '0'),
(113, 46, 0, 18, 'veg. pizza', 1, 100, 1438784261, '0'),
(125, 52, 0, 11, 'Margerita', 1, 120, 1440673231, '0'),
(126, 52, 0, 12, 'Italian', 1, 100, 1440673231, '0'),
(127, 53, 0, 25, 'CocaCola', 1, 30, 1440765444, '0'),
(128, 54, 0, 28, 'Red Bull', 1, 110, 1440765455, '0'),
(129, 55, 0, 26, 'Pepsi', 1, 30, 1440765571, '0'),
(130, 56, 0, 11, 'Margerita', 1, 120, 1440765610, '0'),
(131, 57, 0, 25, 'CocaCola', 1, 30, 1440765650, '0'),
(132, 58, 0, 25, 'CocaCola', 1, 30, 1440765688, '0'),
(133, 59, 0, 25, 'CocaCola', 1, 30, 1440765800, '0'),
(134, 60, 0, 25, 'CocaCola', 1, 30, 1440766093, '0'),
(135, 61, 0, 26, 'Pepsi', 1, 30, 1440766940, '0'),
(136, 62, 0, 25, 'CocaCola', 1, 30, 1440767002, '0'),
(137, 63, 0, 28, 'Red Bull', 1, 110, 1440767027, '0'),
(138, 64, 0, 11, 'Margerita', 1, 120, 1441011933, '0'),
(139, 65, 0, 11, 'Margerita', 1, 120, 1441012027, '0'),
(140, 66, 0, 25, 'CocaCola', 1, 30, 1441012041, '0'),
(141, 67, 0, 33, 'Cocktail', 1, 50, 1441012087, '0'),
(142, 68, 0, 33, 'Cocktail', 1, 50, 1441012198, '0'),
(143, 69, 0, 33, 'Cocktail', 1, 50, 1441012737, '0'),
(144, 70, 0, 33, 'Cocktail', 1, 50, 1441012963, '0'),
(145, 71, 0, 33, 'Cocktail', 1, 50, 1441014032, '0'),
(146, 72, 0, 33, 'Cocktail', 1, 50, 1441014319, '0'),
(147, 73, 0, 33, 'Cocktail', 1, 50, 1441022843, '0'),
(148, 74, 0, 33, 'Cocktail', 3, 150, 1441022946, '0'),
(149, 75, 0, 33, 'Cocktail', 4, 200, 1441022985, '0'),
(150, 76, 0, 33, 'Cocktail', 2, 100, 1441023017, '0'),
(151, 77, 0, 11, 'Margerita', 1, 120, 1441101658, '0'),
(152, 77, 0, 19, 'Aloo Mutter', 1, 30, 1441101658, '0'),
(153, 77, 0, 12, 'Italian', 1, 100, 1441101658, '0'),
(154, 78, 0, 11, 'Margerita', 1, 120, 1441101849, '0'),
(155, 78, 0, 12, 'Italian', 1, 100, 1441101849, '0'),
(156, 78, 0, 13, 'Butter PopCorn', 1, 60, 1441101849, '0'),
(157, 79, 0, 11, 'Margerita', 1, 120, 1441102215, '0'),
(158, 79, 0, 12, 'Italian', 1, 100, 1441102215, '0'),
(159, 79, 0, 13, 'Butter PopCorn', 1, 60, 1441102215, '0'),
(160, 80, 0, 11, 'Margerita', 1, 120, 1441102219, '0'),
(161, 80, 0, 12, 'Italian', 1, 100, 1441102219, '0'),
(162, 80, 0, 13, 'Butter PopCorn', 1, 60, 1441102219, '0'),
(163, 81, 0, 11, 'Margerita', 2, 240, 1441102321, '0'),
(164, 81, 0, 12, 'Italian', 2, 200, 1441102321, '0'),
(165, 81, 0, 13, 'Butter PopCorn', 2, 120, 1441102321, '0'),
(166, 82, 0, 11, 'Margerita', 2, 240, 1441102348, '0'),
(167, 82, 0, 12, 'Italian', 2, 200, 1441102348, '0'),
(168, 82, 0, 13, 'Butter PopCorn', 2, 120, 1441102348, '0'),
(169, 83, 0, 11, 'Margerita', 2, 240, 1441102352, '0'),
(170, 83, 0, 12, 'Italian', 2, 200, 1441102352, '0'),
(171, 83, 0, 13, 'Butter PopCorn', 2, 120, 1441102352, '0'),
(172, 84, 0, 11, 'Margerita', 2, 240, 1441102901, '0'),
(173, 84, 0, 12, 'Italian', 2, 200, 1441102901, '0'),
(174, 84, 0, 13, 'Butter PopCorn', 2, 120, 1441102901, '0'),
(175, 85, 0, 11, 'Margerita', 1, 120, 1441111209, '0'),
(176, 85, 0, 19, 'Aloo Mutter', 1, 30, 1441111209, '0'),
(177, 85, 0, 12, 'Italian', 1, 100, 1441111209, '0'),
(178, 86, 0, 11, 'Margerita', 1, 120, 1441111211, '0'),
(179, 86, 0, 19, 'Aloo Mutter', 1, 30, 1441111211, '0'),
(180, 86, 0, 12, 'Italian', 1, 100, 1441111211, '0'),
(181, 87, 0, 11, 'Margerita', 1, 120, 1441111218, '0'),
(182, 87, 0, 19, 'Aloo Mutter', 1, 30, 1441111218, '0'),
(183, 87, 0, 12, 'Italian', 1, 100, 1441111218, '0'),
(184, 88, 0, 11, 'Margerita', 1, 120, 1441111280, '0'),
(185, 88, 0, 19, 'Aloo Mutter', 1, 30, 1441111280, '0'),
(186, 88, 0, 12, 'Italian', 1, 100, 1441111280, '0'),
(187, 89, 0, 15, 'Cheese Puff', 2, 80, 1441173024, '0'),
(188, 90, 0, 33, 'Cocktail', 1, 50, 1441178683, '0'),
(189, 91, 0, 11, 'Margerita', 1, 120, 1441255880, '0'),
(190, 91, 0, 12, 'Italian', 1, 100, 1441255881, '0'),
(191, 92, 0, 11, 'Margerita', 1, 120, 1441255887, '0'),
(192, 92, 0, 12, 'Italian', 1, 100, 1441255887, '0'),
(193, 93, 0, 11, 'Margerita', 1, 120, 1441256352, '0'),
(194, 93, 0, 12, 'Italian', 1, 100, 1441256352, '0'),
(195, 94, 0, 11, 'Margerita', 1, 120, 1441256354, '0'),
(196, 94, 0, 12, 'Italian', 1, 100, 1441256354, '0'),
(197, 95, 0, 11, 'Margerita', 1, 120, 1441256365, '0'),
(198, 95, 0, 12, 'Italian', 1, 100, 1441256365, '0'),
(199, 96, 0, 11, 'Margerita', 1, 120, 1441256371, '0'),
(200, 96, 0, 12, 'Italian', 1, 100, 1441256371, '0'),
(201, 97, 0, 11, 'Margerita', 1, 120, 1441256399, '0'),
(202, 97, 0, 12, 'Italian', 1, 100, 1441256399, '0'),
(203, 98, 0, 12, 'Italian', 1, 100, 1441256438, '0'),
(204, 98, 0, 11, 'Margerita', 1, 120, 1441256438, '0'),
(205, 99, 0, 11, 'Margerita', 1, 120, 1441256743, '0'),
(206, 99, 0, 12, 'Italian', 1, 100, 1441256743, '0'),
(207, 100, 0, 11, 'Margerita', 1, 120, 1441256947, '0'),
(208, 100, 0, 12, 'Italian', 1, 100, 1441256947, '0'),
(209, 101, 0, 11, 'Margerita', 1, 120, 1441257053, '0'),
(210, 101, 0, 12, 'Italian', 1, 100, 1441257053, '0'),
(211, 102, 0, 11, 'Margerita', 1, 120, 1441257137, '0'),
(212, 102, 0, 12, 'Italian', 1, 100, 1441257137, '0'),
(213, 103, 0, 11, 'Margerita', 2, 240, 1441257842, '0'),
(214, 103, 0, 12, 'Italian', 2, 200, 1441257842, '0'),
(215, 104, 0, 11, 'Margerita', 2, 240, 1441258045, '0'),
(216, 104, 0, 12, 'Italian', 1, 100, 1441258045, '0'),
(217, 105, 0, 11, 'Margerita', 2, 240, 1441258475, '0'),
(218, 105, 0, 12, 'Italian', 1, 100, 1441258475, '0'),
(219, 106, 0, 11, 'Margerita', 2, 240, 1441258491, '0'),
(220, 106, 0, 12, 'Italian', 1, 100, 1441258491, '0'),
(221, 107, 0, 11, 'Margerita', 1, 120, 1441258586, '0'),
(222, 107, 0, 12, 'Italian', 1, 100, 1441258586, '0'),
(223, 108, 0, 11, 'Margerita', 2, 240, 1441258652, '0'),
(224, 108, 0, 12, 'Italian', 1, 100, 1441258652, '0'),
(225, 109, 0, 11, 'Margerita', 1, 120, 1441258731, '0'),
(226, 109, 0, 12, 'Italian', 1, 100, 1441258731, '0'),
(227, 110, 0, 11, 'Margerita', 1, 120, 1441258783, '0'),
(228, 110, 0, 12, 'Italian', 1, 100, 1441258783, '0'),
(229, 111, 0, 11, 'Margerita', 1, 120, 1441258887, '0'),
(230, 111, 0, 12, 'Italian', 1, 100, 1441258887, '0'),
(231, 112, 0, 11, 'Margerita', 1, 120, 1441258962, '0'),
(232, 112, 0, 13, 'Butter PopCorn', 1, 60, 1441258962, '0'),
(233, 112, 0, 12, 'Italian', 1, 100, 1441258962, '0'),
(234, 113, 0, 14, 'Simple Corn', 4, 200, 1441259241, '0'),
(235, 113, 0, 13, 'Butter PopCorn', 2, 120, 1441259241, '0'),
(236, 113, 0, 15, 'Cheese Puff', 1, 40, 1441259241, '0'),
(237, 114, 0, 11, 'Margerita', 3, 360, 1441259304, '0'),
(238, 114, 0, 12, 'Italian', 1, 100, 1441259304, '0');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `products_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `price` decimal(11,2) NOT NULL,
  `qty` decimal(11,2) NOT NULL,
  `uom` int(11) NOT NULL,
  `is_group` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `product_type` enum('RM','FG','BOTH') NOT NULL DEFAULT 'RM',
  PRIMARY KEY (`products_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`products_id`, `uid`, `category_id`, `title`, `images`, `description`, `status`, `price`, `qty`, `uom`, `is_group`, `product_type`) VALUES
(11, 1, 6, 'Margerita', 'pizza-1.jpg', '<p>pizzaaaaaa</p>\r\n', 'Active', '120.00', '5.00', 1, 'YES', 'FG'),
(12, 1, 6, 'Italian', 'italian-pizza.jpg', '<p>pizzaaaa</p>\r\n', 'Active', '100.00', '0.00', 1, 'YES', 'FG'),
(13, 1, 1, 'Butter PopCorn', 'masala-pop-corn.jpg', '<p>popcorn</p>\r\n', 'Active', '60.00', '0.00', 1, 'YES', 'FG'),
(9, 1, 4, 'product12', 'de46ab437f78d93459ef3831ee275073.png', '<p>product</p>\r\n', 'Inactive', '100.00', '1016.00', 1, 'YES', 'RM'),
(10, 1, 4, 'this cat', 'tiger-figurine-sandicast-ss40115.jpg', '<p>yummyyyyyy</p>\r\n', 'Inactive', '200.00', '1.00', 1, 'YES', 'RM'),
(14, 1, 1, 'Simple Corn', 'simple-popcorn.jpg', '<p>popcorn</p>\r\n', 'Active', '50.00', '0.00', 1, 'YES', 'FG'),
(15, 1, 7, 'Cheese Puff', 'cheese-puff.jpg', '<p>puffyyyy</p>\r\n', 'Active', '40.00', '100.00', 1, 'YES', 'FG'),
(16, 1, 7, 'Veg. Puff', 'veg-puff.png', '<p>puffyyyyyy</p>\r\n', 'Active', '25.00', '0.00', 1, 'YES', 'RM'),
(17, 1, 1, 'Cheese Corn', 'cheese-popcorn1.jpg', '<p>sweer</p>\r\n', 'Active', '60.00', '1.00', 1, 'YES', 'RM'),
(18, 1, 6, 'Veg. Pizza', 'veg-pizza.jpg', '<p>veg.pizza</p>\r\n', 'Active', '100.00', '3.00', 1, 'YES', 'RM'),
(19, 1, 8, 'Aloo Mutter', 'aloosandwich.jpg', '<p>Allo Mutter</p>\r\n', 'Active', '30.00', '0.00', 1, 'NO', 'RM'),
(20, 1, 8, 'American CLub', 'american-club.jpg', '<p>American Club</p>\r\n', 'Active', '50.00', '0.00', 1, 'NO', 'RM'),
(21, 1, 8, 'Vegitable', 'vegitable.jpg', '<p>veg. sandwich</p>\r\n', 'Active', '25.00', '0.00', 1, 'NO', 'RM'),
(22, 1, 8, 'Cheese Sandwich', 'cheese.jpg', '<p>Cheese Sandwich</p>\r\n', 'Active', '60.00', '0.00', 1, 'NO', 'RM'),
(23, 1, 9, 'Aloo Tikki', 'alootikki.jpg', '<p>Aloo Tikki Burger</p>\r\n', 'Active', '40.00', '0.00', 1, 'NO', 'RM'),
(24, 1, 9, 'Veg. Burger', 'veg-burger.png', '<p>veg burger</p>\r\n', 'Active', '40.00', '0.00', 1, 'NO', 'RM'),
(25, 1, 12, 'CocaCola', 'cocacola.jpg', '<p>Coca Cola Drink</p>\r\n', 'Active', '30.00', '0.00', 2, 'NO', 'RM'),
(26, 1, 12, 'Pepsi', 'pepsi.jpg', '<p>pepsi</p>\r\n', 'Active', '30.00', '2.00', 2, 'NO', 'RM'),
(27, 1, 12, 'Sprite', 'sprite.jpg', '<p>sprite</p>\r\n', 'Active', '30.00', '1.00', 2, 'NO', 'RM'),
(28, 1, 12, 'Red Bull', 'red_bull.jpg', '<p>Red Bull</p>\r\n', 'Active', '110.00', '1.00', 2, 'NO', 'RM'),
(29, 1, 11, 'Apple', 'apple-juice.jpg', '<p>Apple juice</p>\r\n', 'Active', '40.00', '0.00', 2, 'NO', 'RM'),
(30, 1, 11, 'Orange', 'orange.jpg', '<p>Orange juice</p>\r\n', 'Active', '35.00', '0.00', 2, 'NO', 'RM'),
(31, 1, 11, 'PineApple', 'pineapple-juice-250x250.jpg', '<p>Pineapple</p>\r\n', 'Active', '35.00', '0.00', 2, 'NO', 'RM'),
(32, 1, 11, 'Watermalon', 'Watermelon_juice.jpg', '<p>Watermalon</p>\r\n', 'Active', '30.00', '0.00', 1, 'NO', 'RM'),
(33, 1, 11, 'Cocktail', 'cocktail.jpg', '<p>Cocktail</p>\r\n', 'Active', '50.00', '0.00', 2, 'NO', 'FG'),
(35, 1, 1, 'Cheez butter masala pop-corn', 'fc8f8f90774eff245751cf6a546c8c20.jpg', '<p>Cheez butter masala pop-corn</p>\r\n', 'Active', '50.00', '0.00', 4, 'NO', 'FG');

-- --------------------------------------------------------

--
-- Table structure for table `product_ingredients`
--

CREATE TABLE IF NOT EXISTS `product_ingredients` (
  `product_ingredients_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `material_name` varchar(255) NOT NULL,
  `material_qua` decimal(11,2) NOT NULL,
  `uom` varchar(255) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `is_sync` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_ingredients_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `product_ingredients`
--

INSERT INTO `product_ingredients` (`product_ingredients_id`, `product_id`, `material_name`, `material_qua`, `uom`, `cost`, `is_sync`) VALUES
(25, 33, 'cocacola', '2.00', 'LTR', '400.00', '0'),
(29, 33, 'Cheese Corn', '10.00', 'KG', '100.00', '0'),
(30, 35, 'Cheese Corn', '1.00', 'KG', '10.00', '0');

-- --------------------------------------------------------

--
-- Table structure for table `uom`
--

CREATE TABLE IF NOT EXISTS `uom` (
  `uom_id` int(11) NOT NULL AUTO_INCREMENT,
  `uom` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`uom_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `uom`
--

INSERT INTO `uom` (`uom_id`, `uom`, `status`) VALUES
(1, 'KG', 'Active'),
(2, 'LTR', 'Active'),
(3, 'ML', 'Active'),
(4, 'GM', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `primary_email` varchar(255) NOT NULL,
  `phone` int(12) NOT NULL,
  `user_type` enum('super_admin','admin','operator','customer') NOT NULL DEFAULT 'admin',
  `joining_date` date NOT NULL,
  `end_date` date NOT NULL DEFAULT '0000-00-00',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `is_sync` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `parent_user_id`, `company_id`, `username`, `password`, `firstname`, `lastname`, `primary_email`, `phone`, `user_type`, `joining_date`, `end_date`, `status`, `is_sync`) VALUES
(1, 0, 0, 'admin', '0192023a7bbd73250516f069df18b500', 'admin', 'admin', 'admin@mail.com', 0, 'super_admin', '2015-02-25', '0000-00-00', 'Active', '0'),
(16, 0, 2, 'abcd', '827ccb0eea8a706c4c34a16891f84e7b', 'abcd', 'abcd', 'abcd@mail.com', 1234567890, 'admin', '2015-03-01', '2015-03-30', 'Active', '0'),
(17, 0, 2, 'mayank', '827ccb0eea8a706c4c34a16891f84e7b', 'mayank', 'patel', 'mayank@mail.com', 1234567890, 'operator', '2015-03-01', '2015-03-19', 'Active', '0'),
(18, 0, 2, 'bhushan', '0192023a7bbd73250516f069df18b500', 'bhushan', 'sonar', 'bhushan@mail.com', 1234567890, 'operator', '2015-03-02', '2015-03-18', 'Active', '0'),
(19, 0, 2, 'viralcs', 'f5012b0e3bdc86ea3381031ce9d4edbd', 'Viral', 'Patel', 'viral_cs@yahoo.com', 2147483647, 'admin', '2015-09-09', '2015-12-11', 'Active', '0');

-- --------------------------------------------------------

--
-- Table structure for table `user_role_extended`
--

CREATE TABLE IF NOT EXISTS `user_role_extended` (
  `user_role_extended_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `parent_user_id` int(11) NOT NULL,
  `user_type` enum('super_admin','admin','operator','customer') NOT NULL DEFAULT 'admin',
  `is_sync` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_role_extended_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user_role_extended`
--

INSERT INTO `user_role_extended` (`user_role_extended_id`, `user_id`, `parent_user_id`, `user_type`, `is_sync`) VALUES
(1, 1, 0, 'super_admin', '0'),
(5, 16, 1, 'admin', '0'),
(6, 17, 16, 'admin', '0'),
(7, 18, 16, 'operator', '0'),
(8, 19, 1, 'admin', '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
