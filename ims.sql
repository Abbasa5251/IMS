DROP DATABASE IF EXISTS `ims`;
CREATE DATABASE `ims`;


CREATE TABLE `user` (
    `user_id` smallint(3) AUTO_INCREMENT NOT NULL,
    `role_id` smallint(2) NOT NULL,
    `user_name` varchar(255) NOT NULL,
    `user_first_name` varchar(100) NOT NULL,
    `user_last_name` varchar(100) NOT NULL,
    `user_email` varchar(255) NOT NULL,
    `user_password` varchar(255) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`user_id`),
    FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON UPDATE CASCADE ON DELETE CASCADE
);


INSERT INTO user (`role_id`, `user_name`, `user_email`, `user_first_name`, `user_last_name`, `user_password`) VALUES 
(1, 'admin', 'test@test.com', 'Abbas', 'Anandwala', 'admin'),
(2, 'test', 'test@test.com', 'John', 'Doe', 'test');


CREATE TABLE `role` (
    `role_id` smallint(2) AUTO_INCREMENT NOT NULL,
    `role_name` varchar(50) NOT NULL,
    PRIMARY KEY (`role_id`)
);

INSERT INTO `role` (`role_name`) VALUES 
('Admin'),
('User');

CREATE TABLE `customer` (
    `customer_id` int AUTO_INCREMENT NOT NULL,
    `customer_name` varchar(50) NOT NULL,
    `customer_address` varchar(125) NOT NULL,
    `customer_number` varchar(15) NOT NULL UNIQUE,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`customer_id`)
);

INSERT INTO `customer` (`customer_name`, `customer_address`, `customer_number`) VALUES 
('Ramesh Jha', 'Baramati', '9867451325'),
('Sarang Sharma', 'Satara', '7846598975'),
('Virendra Singh', 'Pune', '7865465642');


-- +-------------+----------------+------------------+-----------------+
-- | customer_id | customer_name  | customer_address | customer_number |
-- +-------------+----------------+------------------+-----------------+
-- |           1 | Ramesh Jha     | Baramati         | 9867451325      |
-- |           2 | Sarang Sharma  | Satara           | 7846598975      |
-- |           3 | Virendra Singh | Pune             | 7865465642      |
-- +-------------+----------------+------------------+-----------------+


CREATE TABLE `product` (
    `product_id` int AUTO_INCREMENT NOT NULL,
    `product_name` varchar(50) NOT NULL,
    `product_unit_price` int NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`product_id`)
);

INSERT INTO `product` (`product_name`, `product_unit_price`) VALUES 
('Nike Airmax Shoe', '9999'),
('Adidas Yeezy', '8999'),
('Reebok Running Zig', '6599');


-- +------------+--------------------+--------------------+
-- | product_id | product_name       | product_unit_price |
-- +------------+--------------------+--------------------+
-- |          1 | Nike Airmax Shoe   |               9999 |
-- |          2 | Adidas Yeezy       |               8999 |
-- |          3 | Reebok Running Zig |               6599 |
-- +------------+--------------------+--------------------+


CREATE TABLE `order` (
    `order_id` int NOT NULL AUTO_INCREMENT,
    `customer_id` int NOT NULL,
    `product_id` int NOT NULL,
    `quantity` int NOT NULL,
    `amount`float NOT NULL,
    `paid` BOOLEAN NOT NULL DEFAULT false,
    `order_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`order_id`),
    FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON UPDATE CASCADE ON DELETE CASCADE
);

ALTER TABLE `order` AUTO_INCREMENT=1001;

INSERT INTO `order` (`customer_id`, `product_id`, `quantity`, `amount`) VALUES 
(2, 1, 2, 19998);

INSERT INTO `order` (`customer_id`, `product_id`, `quantity`, `amount`) VALUES 
(3, 2, 1, 8999);

-- SELECT `order_id`, `customer_name`, `amount`, DATE_FORMAT(`order_date`,'%y-%m-%d %h:%m') as `order_date`, `order_date` as 'date' FROM `order` JOIN `customer` ON `customer`.`customer_id`=`order`.`customer_id` ORDER BY 'date';
