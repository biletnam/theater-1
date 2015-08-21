-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2015 at 04:27 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `theater`
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
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `parent_id`, `path`, `display_order`, `status`) VALUES
(1, 'Pop-Corn', 0, 'Pop-Corn', 0, 'Active'),
(6, 'Pizza', 0, 'Pizza', 0, 'Active'),
(4, 'cat1', 0, 'cat1', 0, 'Inactive'),
(7, 'Puff', 0, 'Puff', 0, 'Active'),
(8, 'sandwich', 0, 'sandwich', 0, 'Active'),
(9, 'burger', 0, 'burger', 0, 'Active'),
(10, 'chocolate', 0, 'chocolate', 0, 'Active'),
(11, 'juice', 0, 'juice', 0, 'Active'),
(12, 'Cold-Drinks', 0, 'Cold-Drinks', 0, 'Active'),
(17, 'Fruits', 0, 'Fruits', 0, 'Inactive');

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
('11a3b53f2298ed5142297d8898f9f763', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0', 1439209586, 'a:7:{s:9:"user_data";s:0:"";s:8:"username";s:7:"bhushan";s:7:"user_id";s:2:"18";s:9:"user_type";s:8:"operator";s:10:"company_id";s:1:"2";s:12:"is_logged_in";b:1;s:14:"total_quantity";i:0;}'),
('cdea2705ffeeeb3769dd4ebf19a59ee4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36', 1439206711, 'a:14:{s:9:"user_data";s:0:"";s:8:"username";s:5:"admin";s:7:"user_id";s:1:"1";s:9:"user_type";s:11:"super_admin";s:10:"company_id";i:0;s:12:"is_logged_in";b:1;s:17:"products_selected";N;s:22:"search_string_selected";N;s:5:"order";N;s:10:"order_type";N;s:12:"redirect_url";s:39:"http://localhost/theater/admin/products";s:13:"flash_message";s:0:"";s:17:"category_selected";N;s:23:"flash:old:flash_message";s:3:"add";}');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `status`) VALUES
(2, 'theater 1', 'Active');

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
  `google_id` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_row_material`
--

CREATE TABLE IF NOT EXISTS `item_row_material` (
  `item_row_material_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `uom` enum('KG','GM') NOT NULL DEFAULT 'KG',
  `cost` int(11) NOT NULL,
  PRIMARY KEY (`item_row_material_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `item_row_material`
--

INSERT INTO `item_row_material` (`item_row_material_id`, `name`, `description`, `image`, `quantity`, `uom`, `cost`) VALUES
(1, 'material 1', '<p>material1</p>\r\n', 'Chrysanthemum12.jpg', 12, 'GM', 321);

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
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `total_amount`, `datetime`, `pos_id`, `customer_id`, `status`, `flag`, `user_id`, `payment_mode`, `discount`, `quantity`, `grand_amount`) VALUES
(1, 250, 2147483647, 0, 0, 'Pending', '', '18', 'cash', 10, 4, 225),
(2, 50, 1434107047, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 50),
(3, 400, 1434109074, 0, 0, 'Pending', '', '18', 'cash', 0, 6, 400),
(4, 50, 1434345418, 0, 0, 'Pending', '', '18', 'cash', 0, 1, 50),
(5, 210, 1434345540, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(6, 350, 1435044443, 0, 0, 'Pending', '', '18', 'cash', 0, 6, 350),
(7, 120, 1435044461, 0, 0, 'Pending', '', '18', 'cash', 10, 2, 108),
(8, 150, 1435818631, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 150),
(9, 200, 1435820300, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 200),
(10, 60, 1437141371, 0, 0, 'Pending', '', '18', 'cash', 10, 1, 54),
(11, 220, 1437141487, 0, 0, 'Pending', '', '18', 'cash', 0, 4, 220),
(12, 160, 1437142151, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 160),
(13, 210, 1437456047, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(14, 210, 1437456056, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(15, 150, 1437461331, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 150),
(16, 150, 1437461444, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 150),
(17, 150, 1437461503, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 150),
(18, 150, 1437461538, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 150),
(19, 210, 1437461808, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(20, 150, 1437462110, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 150),
(21, 150, 1437462128, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 150),
(22, 210, 1437463857, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(23, 210, 1437463860, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(24, 210, 1437463862, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(25, 210, 1437463865, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(26, 210, 1437463866, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(27, 210, 1437463867, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(28, 210, 1437463873, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(29, 210, 1437463882, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(30, 210, 1437463886, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(31, 210, 1437463888, 0, 0, 'Pending', '', '18', 'debit card', 0, 3, 210),
(32, 210, 1437463889, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(33, 210, 1437463890, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(34, 210, 1437463890, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(35, 210, 1437464029, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(36, 210, 1437464030, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(37, 210, 1437464030, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(38, 210, 1437464031, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(39, 210, 1437464033, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(40, 210, 1437464038, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(41, 150, 1437543083, 0, 0, 'Pending', '', '18', 'cash', 0, 2, 150),
(42, 1000, 1437549458, 0, 0, 'Pending', '', '18', 'cash', 10, 11, 900),
(43, 210, 1438239714, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 210),
(44, 250, 1438601540, 0, 0, 'Pending', '', '18', 'cash', 0, 4, 250),
(45, 200, 1438682613, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 200),
(46, 200, 1438784261, 0, 0, 'Pending', '', '18', 'cash', 0, 3, 200),
(47, 300, 1439187385, 0, 0, 'Pending', '', '18', 'cash', 0, 4, 300);

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
  PRIMARY KEY (`order_detail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=116 ;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`order_detail_id`, `order_id`, `customer_id`, `product_id`, `product_title`, `quantity`, `cost`, `datetime`) VALUES
(115, 47, 0, 18, 'veg. pizza', 2, 200, 1439187385),
(114, 47, 0, 11, 'margerita', 2, 100, 1439187385),
(105, 43, 0, 11, 'margerita', 1, 50, 1438239714),
(106, 43, 0, 18, 'veg. pizza', 1, 100, 1438239714),
(107, 43, 0, 12, 'italian', 1, 60, 1438239714),
(108, 44, 0, 11, 'margerita', 3, 150, 1438601540),
(109, 44, 0, 18, 'veg. pizza', 1, 100, 1438601540),
(110, 45, 0, 11, 'margerita', 2, 100, 1438682613),
(111, 45, 0, 18, 'veg. pizza', 1, 100, 1438682613),
(112, 46, 0, 11, 'margerita', 2, 100, 1438784261),
(113, 46, 0, 18, 'veg. pizza', 1, 100, 1438784261);

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
  `price` int(11) NOT NULL,
  `is_group` varchar(255) NOT NULL,
  `flag` enum('RM',' FG') NOT NULL DEFAULT 'RM',
  PRIMARY KEY (`products_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`products_id`, `uid`, `category_id`, `title`, `images`, `description`, `status`, `price`, `is_group`, `flag`) VALUES
(11, 1, 6, 'Margerita', 'pizza-1.jpg', '<p>pizzaaaaaa</p>\r\n', 'Active', 120, 'YES', 'RM'),
(12, 1, 6, 'Italian', 'italian-pizza.jpg', '<p>pizzaaaa</p>\r\n', 'Active', 100, 'YES', 'RM'),
(13, 1, 1, 'Butter PopCorn', 'masala-pop-corn.jpg', '<p>popcorn</p>\r\n', 'Active', 60, 'YES', 'RM'),
(9, 1, 4, 'product12', 'tiger-figurine-sandicast-ss40114.jpg', '<p>product</p>\r\n', 'Inactive', 12345, 'YES', 'RM'),
(10, 1, 4, 'this cat', 'tiger-figurine-sandicast-ss40115.jpg', '<p>yummyyyyyy</p>\r\n', 'Inactive', 200, 'YES', 'RM'),
(14, 1, 1, 'Simple Corn', 'simple-popcorn.jpg', '<p>popcorn</p>\r\n', 'Active', 50, 'YES', 'RM'),
(15, 1, 7, 'Cheese Puff', 'cheese-puff.jpg', '<p>puffyyyy</p>\r\n', 'Active', 40, 'YES', 'RM'),
(16, 1, 7, 'Veg. Puff', 'veg-puff.png', '<p>puffyyyyyy</p>\r\n', 'Active', 25, 'YES', 'RM'),
(17, 1, 1, 'Cheese Corn', 'cheese-popcorn1.jpg', '<p>sweer</p>\r\n', 'Active', 60, 'YES', 'RM'),
(18, 1, 6, 'Veg. Pizza', 'veg-pizza.jpg', '<p>veg.pizza</p>\r\n', 'Active', 100, 'YES', 'RM'),
(19, 1, 8, 'Aloo Mutter', 'aloosandwich.jpg', '<p>Allo Mutter</p>\r\n', 'Active', 30, '', 'RM'),
(20, 1, 8, 'American CLub', 'american-club.jpg', '<p>American Club</p>\r\n', 'Active', 50, '', 'RM'),
(21, 1, 8, 'Vegitable', 'vegitable.jpg', '<p>veg. sandwich</p>\r\n', 'Active', 25, '', 'RM'),
(22, 1, 8, 'Cheese Sandwich', 'cheese.jpg', '<p>Cheese Sandwich</p>\r\n', 'Active', 60, '', 'RM'),
(23, 1, 9, 'Aloo Tikki', 'alootikki.jpg', '<p>Aloo Tikki Burger</p>\r\n', 'Active', 40, '', 'RM'),
(24, 1, 9, 'Veg. Burger', 'veg-burger.png', '<p>veg burger</p>\r\n', 'Active', 40, '', 'RM'),
(25, 1, 12, 'CocaCola', 'cocacola.jpg', '<p>Coca Cola Drink</p>\r\n', 'Active', 30, '', 'RM'),
(26, 1, 12, 'Pepsi', 'pepsi.jpg', '<p>pepsi</p>\r\n', 'Active', 30, '', 'RM'),
(27, 1, 12, 'Sprite', 'sprite.jpg', '<p>sprite</p>\r\n', 'Active', 30, '', 'RM'),
(28, 1, 12, 'Red Bull', 'red_bull.jpg', '<p>Red Bull</p>\r\n', 'Active', 110, '', 'RM'),
(29, 1, 11, 'Apple', 'apple-juice.jpg', '<p>Apple juice</p>\r\n', 'Active', 40, '', 'RM'),
(30, 1, 11, 'Orange', 'orange.jpg', '<p>Orange juice</p>\r\n', 'Active', 35, '', 'RM'),
(31, 1, 11, 'PineApple', 'pineapple-juice-250x250.jpg', '<p>Pineapple</p>\r\n', 'Active', 35, '', 'RM'),
(32, 1, 11, 'Watermalon', 'Watermelon_juice.jpg', '<p>Watermalon</p>\r\n', 'Active', 30, '', 'RM'),
(33, 1, 11, 'Cocktail', 'cocktail.jpg', '<p>Cocktail</p>\r\n', 'Active', 50, '', 'RM');

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
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `parent_user_id`, `company_id`, `username`, `password`, `firstname`, `lastname`, `primary_email`, `phone`, `user_type`, `joining_date`, `end_date`, `status`) VALUES
(1, 0, 0, 'admin', '0192023a7bbd73250516f069df18b500', 'admin', 'admin', 'admin@mail.com', 0, 'super_admin', '2015-02-25', '0000-00-00', 'Active'),
(16, 0, 2, 'abcd', '827ccb0eea8a706c4c34a16891f84e7b', 'abcd', 'abcd', 'abcd@mail.com', 1234567890, 'admin', '2015-03-01', '2015-03-30', 'Active'),
(17, 0, 2, 'mayank', '827ccb0eea8a706c4c34a16891f84e7b', 'mayank', 'patel', 'mayank@mail.com', 1234567890, 'operator', '2015-03-01', '2015-03-19', 'Active'),
(18, 0, 2, 'bhushan', '0192023a7bbd73250516f069df18b500', 'bhushan', 'sonar', 'bhushan@mail.com', 1234567890, 'operator', '2015-03-02', '2015-03-18', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `user_role_extended`
--

CREATE TABLE IF NOT EXISTS `user_role_extended` (
  `user_role_extended_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `parent_user_id` int(11) NOT NULL,
  `user_type` enum('super_admin','admin','operator','customer') NOT NULL DEFAULT 'admin',
  PRIMARY KEY (`user_role_extended_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user_role_extended`
--

INSERT INTO `user_role_extended` (`user_role_extended_id`, `user_id`, `parent_user_id`, `user_type`) VALUES
(1, 1, 0, 'super_admin'),
(5, 16, 1, 'admin'),
(6, 17, 16, 'admin'),
(7, 18, 16, 'operator');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
