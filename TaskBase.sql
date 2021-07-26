CREATE DATABASE IF NOT EXISTS TaskTable;

CREATE TABLE IF NOT EXISTS `products`
(
	`product_id` int(10) 	 NOT NULL AUTO_INCREMENT PRIMARY KEY , 
	`name`		 varchar(25) NOT NULL,
	`group`		 varchar(25) NOT NULL,
	`price`		 int(10)	 NOT NULL,
	`info`		 text 		 NOT NULL
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `products_images`
(	
	`image_id`	 int(10)	NOT NULL  AUTO_INCREMENT,
	`product_id` int(10)	NOT NULL ,
	FOREIGN KEY (`product_id`)  REFERENCES products(`product_id`) ON DELETE CASCADE,
	`hight_url`  varchar(40) NOT NULL,
	`low_url`	 varchar(40) NOT NULL

)ENGINE=InnoDB;
	
CREATE TABLE IF NOT EXISTS `orders`
(
  `order_id` 		int(10) 	NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `status`   		varchar(25) NOT NULL,
  `client_name` 	varchar(25) NOT NULL,
  `client_number` 	varchar(12) NOT NULL,
  `comment` 		text 	    NOT NULL,
  `date` 			DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `orders_items`
(
  `id`            int(10) 	NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `product_id`    int(10) 	NOT NULL,
  `order_id`      int(10) 	NOT NULL,
   FOREIGN KEY (`order_id`) REFERENCES orders(`order_id`) ON DELETE CASCADE,
  `product_count` int(10) 	NOT NULL
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `clients`
(
  `id` 		 int(11) 	 NOT NULL,
  `number` 	 int(11) 	 NOT NULL,
  `password` varchar(25) NOT NULL
)ENGINE=InnoDB;