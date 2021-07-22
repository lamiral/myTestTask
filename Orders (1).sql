

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

----------------------------------


CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------



CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `hight_url` varchar(40) NOT NULL,
  `low_url` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


INSERT INTO `images` (`id`, `product_id`, `hight_url`, `low_url`) VALUES
(1, 1, 'images/suchi/id_2_hight.jpg', 'images/suchi/id_2_low.jpg'),
(2, 1, 'images/suchi/id_3_hight.jpg', 'images/suchi/id_3_low.jpg'),
(3, 2, 'images/pizza/id_1_hight.jpg', 'images/pizza/id_1_low.jpg');

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `my_order` (
  `order_id` int(10) NOT NULL,
  `status` varchar(25) NOT NULL,
  `client_name` varchar(25) NOT NULL,
  `client_number` varchar(12) NOT NULL,
  `comment` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


INSERT INTO `my_order` (`order_id`, `status`, `client_name`, `client_number`, `comment`, `date`) VALUES
(1, 'Выполняется', 'Артем', '2131242154', 'somecomment', '0000-00-00');

CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `product_count` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `order_item` (`id`, `product_id`, `order_id`, `product_count`) VALUES
(0, 1, 1, 5);

CREATE TABLE IF NOT EXISTS `Products` (
  `id` int(100) NOT NULL,
  `name` varchar(25) CHARACTER SET utf8 NOT NULL,
  `group_product` varchar(25) CHARACTER SET utf8 NOT NULL,
  `price` int(100) NOT NULL,
  `info` varchar(2500) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_estonian_ci;

INSERT INTO `Products` (`id`, `name`, `group_product`, `price`, `info`) VALUES
(1, 'pizza', 'pizza_group', 100, 'Это пицца, она оч вкусная.'),
(2, 'unagi', 'suchi', 14, 'some info'),
(3, 'magi', 'suchi', 14, 'someinfo about this product');

ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `my_order`
  ADD PRIMARY KEY (`order_id`);

ALTER TABLE `Products`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;

ALTER TABLE `my_order`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;

ALTER TABLE `Products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
