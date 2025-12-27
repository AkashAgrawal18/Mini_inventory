<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-12-27 15:58:32 --> Severity: Warning --> mysqli::real_connect(): (HY000/1049): Unknown database 'mini_db' C:\xampp\htdocs\mini_inventory\system\database\drivers\mysqli\mysqli_driver.php 211
ERROR - 2025-12-27 15:58:32 --> Unable to connect to the database
ERROR - 2025-12-27 16:40:27 --> 404 Page Not Found: Welcome/get_products
ERROR - 2025-12-27 16:40:54 --> 404 Page Not Found: Welcome/get_products
ERROR - 2025-12-27 21:19:22 --> Severity: Notice --> Undefined property: Welcome::$Product_model C:\xampp\htdocs\mini_inventory\application\controllers\Welcome.php 25
ERROR - 2025-12-27 21:19:22 --> Severity: error --> Exception: Call to a member function count_products() on null C:\xampp\htdocs\mini_inventory\application\controllers\Welcome.php 25
ERROR - 2025-12-27 21:19:25 --> Severity: Notice --> Undefined property: Welcome::$Product_model C:\xampp\htdocs\mini_inventory\application\controllers\Welcome.php 25
ERROR - 2025-12-27 21:19:25 --> Severity: error --> Exception: Call to a member function count_products() on null C:\xampp\htdocs\mini_inventory\application\controllers\Welcome.php 25
ERROR - 2025-12-27 21:19:33 --> Severity: Notice --> Undefined property: Welcome::$Product_model C:\xampp\htdocs\mini_inventory\application\controllers\Welcome.php 25
ERROR - 2025-12-27 21:19:33 --> Severity: error --> Exception: Call to a member function count_products() on null C:\xampp\htdocs\mini_inventory\application\controllers\Welcome.php 25
ERROR - 2025-12-27 21:20:07 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\mini_inventory\application\controllers\Welcome.php 29
ERROR - 2025-12-27 21:37:52 --> Severity: Notice --> Undefined property: Welcome::$Product_model C:\xampp\htdocs\mini_inventory\application\controllers\Welcome.php 85
ERROR - 2025-12-27 21:37:52 --> Severity: error --> Exception: Call to a member function delete_product() on null C:\xampp\htdocs\mini_inventory\application\controllers\Welcome.php 85
ERROR - 2025-12-27 21:41:49 --> Query error: Duplicate entry 'P1' for key 'product_code' - Invalid query: INSERT INTO `products` (`product_code`, `product_name`, `category`, `price`, `stock_quantity`) VALUES ('P1', 'Product1', 'Cate1', '100', '100')
