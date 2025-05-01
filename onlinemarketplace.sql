-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 30, 2025 at 04:04 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinemarketplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Clothing'),
(2, 'Shoes'),
(3, 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `listing`
--

DROP TABLE IF EXISTS `listing`;
CREATE TABLE IF NOT EXISTS `listing` (
  `listing_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `listing_price` decimal(8,2) NOT NULL,
  `listing_quantity` int NOT NULL,
  `listing_keywords` varchar(255) DEFAULT NULL,
  `listing_status` enum('Active','Sold','Inactive') NOT NULL DEFAULT 'Active',
  `listing_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`listing_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `listing`
--

INSERT INTO `listing` (`listing_id`, `product_id`, `user_id`, `listing_price`, `listing_quantity`, `listing_keywords`, `listing_status`, `listing_date`) VALUES
(1, 1, 9, 19.99, 20, 'classic,white,tshirt', 'Active', '2025-04-07 08:00:00'),
(2, 2, 10, 49.99, 14, 'slimfit,dark,jeans', 'Active', '2025-04-07 08:10:00'),
(3, 3, 11, 59.99, 18, 'floral,summer,dress', 'Active', '2025-04-07 08:20:00'),
(4, 4, 12, 39.99, 12, 'cozy,knit,sweater', 'Active', '2025-04-07 08:30:00'),
(5, 5, 13, 69.99, 10, 'canvas,sneakers,low-top', 'Active', '2025-04-07 08:40:00'),
(6, 6, 14, 129.99, 10, 'chelsea,leather,boots', 'Active', '2025-04-07 08:50:00'),
(7, 7, 15, 89.99, 12, 'mesh,running,shoes', 'Active', '2025-04-07 09:00:00'),
(8, 8, 16, 29.99, 12, 'slide,sandals,adjustable', 'Active', '2025-04-07 09:10:00'),
(9, 9, 17, 49.99, 8, 'aviator,sunglasses,uv400', 'Active', '2025-04-07 09:20:00'),
(10, 10, 18, 24.99, 9, 'leather,belt,silver', 'Active', '2025-04-07 09:30:00'),
(11, 11, 19, 19.99, 15, 'canvas,tote,bag', 'Active', '2025-04-07 09:40:00'),
(12, 12, 20, 99.99, 6, 'classic,wristwatch,steel', 'Active', '2025-04-07 09:50:00'),
(13, 19, 9, 34.99, 5, 'black,hoodie,classic', 'Active', '2025-04-08 08:00:00'),
(14, 20, 10, 79.99, 4, 'denim,jacket,distressed', 'Active', '2025-04-08 08:10:00'),
(15, 21, 11, 44.99, 6, 'boho,maxi,skirt', 'Active', '2025-04-08 08:20:00'),
(16, 22, 12, 59.99, 3, 'chunky,cardigan,cable-knit', 'Active', '2025-04-08 08:30:00'),
(17, 23, 13, 59.99, 7, 'skate,shoes,high-top', 'Active', '2025-04-08 08:40:00'),
(18, 24, 14, 119.99, 2, 'oxford,dress,shoes', 'Active', '2025-04-08 08:50:00'),
(19, 25, 15, 69.99, 8, 'training,shoes,cross-training', 'Active', '2025-04-08 09:00:00'),
(20, 26, 16, 24.99, 11, 'water-resistant,flip-flops', 'Active', '2025-04-08 09:10:00'),
(21, 27, 17, 59.99, 5, 'oversized,round,sunglasses', 'Active', '2025-04-08 09:20:00'),
(22, 28, 18, 29.99, 9, 'braided,leather,belt', 'Active', '2025-04-08 09:30:00'),
(23, 29, 19, 24.99, 10, 'insulated,water,bottle', 'Active', '2025-04-08 09:40:00'),
(24, 30, 20, 129.99, 4, 'fitness,tracker,watch', 'Active', '2025-04-08 09:50:00'),
(25, 13, 4, 79.99, 1, 'vintage,leather,jacket', 'Active', '2025-04-01 10:00:00'),
(26, 14, 5, 9.99, 2, 'preloved,graphic,tee', 'Active', '2025-04-02 11:00:00'),
(27, 15, 5, 49.99, 1, 'trail,running,shoes', 'Active', '2025-04-03 12:00:00'),
(28, 16, 6, 49.99, 3, 'canvas,sneakers,second-hand', 'Active', '2025-04-04 13:00:00'),
(29, 17, 8, 29.99, 2, 'aviator,sunglasses,pre-owned', 'Active', '2025-04-05 14:00:00'),
(30, 18, 7, 39.99, 2, 'canvas,backpack,used', 'Active', '2025-04-06 15:00:00'),
(31, 31, 4, 89.99, 1, 'moto,leather,jacket', 'Active', '2025-04-08 10:00:00'),
(32, 32, 5, 19.99, 2, 'ecothreads,vintage,hoodie', 'Active', '2025-04-08 10:10:00'),
(33, 33, 7, 49.99, 2, 'marathon,shoes,quickrun', 'Active', '2025-04-08 10:20:00'),
(34, 34, 7, 24.99, 3, 'sole,stride,slip-ons', 'Active', '2025-04-08 10:30:00'),
(35, 35, 8, 79.99, 1, 'leather,tote,bag', 'Active', '2025-04-08 10:40:00'),
(36, 36, 6, 14.99, 2, 'visor,cap,sunguard', 'Active', '2025-04-08 10:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_brand` varchar(50) DEFAULT NULL,
  `product_description` text,
  `product_image` varchar(255) DEFAULT NULL,
  `product_condition` enum('New','Used') DEFAULT 'New',
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `product_brand`, `product_description`, `product_image`, `product_condition`) VALUES
(1, 1, 'Classic White T-Shirt', 'MarketBasics', '100% cotton crew-neck tee', 'classic_white_tshirt.png', 'New'),
(2, 1, 'Slim-Fit Dark Jeans', 'DenimCo', 'Stretch denim with a modern slim cut', 'slim_fit_dark_jeans.png\r\n', 'New'),
(3, 1, 'Floral Summer Dress', 'SunnyFashion', 'Lightweight, breathable fabric', 'floral_summer_dress.png', 'New'),
(4, 1, 'Cozy Knit Sweater', 'KnitStyle', 'Soft acrylic yarn, perfect for cooler days', 'cozy_knit_sweater.png', 'New'),
(5, 2, 'Canvas Low-Top Sneakers', 'StepUp', 'Durable canvas with vulcanized rubber sole', 'canvas_low_top_sneakers.png', 'New'),
(6, 2, 'Chelsea Leather Boots', 'LeatherLux', 'Genuine leather with side-zip closure', 'chelsea_leather_boots.png', 'New'),
(7, 2, 'Mesh Running Shoes', 'FastTrack', 'Breathable mesh upper with responsive sole', 'mesh_running_shoes.png', 'New'),
(8, 2, 'Slide Sandals', 'BeachWalk', 'Adjustable strap with lightweight footbed', 'slide_sandals.png', 'New'),
(9, 3, 'Aviator Sunglasses', 'SunShade', 'UV400 protection in a sleek metal frame', 'aviator_sunglasses.png', 'New'),
(10, 3, 'Genuine Leather Belt', 'BeltMasters', '1.25\" width belt with a classic silver buckle', 'genuine_leather_belt.png', 'New'),
(11, 3, 'Canvas Tote Bag', 'EcoCarry', 'Recycled cotton canvas tote, 15″ × 14″', 'canvas_tote_bag.png', 'New'),
(12, 3, 'Classic Wristwatch', 'TimeKeeper', 'Stainless steel analog watch, water-resistant up to 30 m', 'classic_wristwatch.png', 'New'),
(13, 1, 'Vintage Leather Jacket', 'RetroWear', 'Genuine leather, lightly worn vintage style', 'vintage_leather_jacket.png', 'Used'),
(14, 1, 'Pre-Loved Graphic Tee', 'Tees4U', '100% cotton shirt with retro graphic print', 'pre_loved_graphic_tee.png\r\n', 'Used'),
(15, 2, 'Gently Used Trail Running Shoes', 'TrailBlazer', 'Durable trail shoes with minor wear on the soles', 'gently_used_trail_running_shoes.png', 'Used'),
(16, 2, 'Second-Hand Canvas Sneakers', 'StepUp', 'Canvas sneakers with slight discoloration and soft creases', 'second_hand_canvas_sneakers.png', 'Used'),
(17, 3, 'Pre-Owned Aviator Sunglasses', 'SunShade', 'Slightly worn metal frame with UV400 lenses intact', 'pre_owned_aviator_sunglasses.png', 'Used'),
(18, 3, 'Used Canvas Backpack', 'EcoCarry', 'Canvas backpack with minor scuffs and a few faint stains', 'used_canvas_backpack.png', 'Used'),
(19, 1, 'Classic Black Hoodie', 'MarketBasics', 'Soft cotton–poly blend hoodie with front pouch pocket', 'classic_black_hoodie.png', 'New'),
(20, 1, 'Distressed Denim Jacket', 'DenimCo', 'Vintage-style denim jacket with distressed detailing', 'distressed_denim_jacket.png', 'New'),
(21, 1, 'Boho Maxi Skirt', 'SunnyFashion', 'Flowy skirt with vibrant bohemian print', 'boho_maxi_skirt.png', 'New'),
(22, 1, 'Chunky Cable Knit Cardigan', 'KnitStyle', 'Cozy chunky cardigan with classic cable-knit pattern', 'chunky_cable_knit_cardigan.png', 'New'),
(23, 2, 'High-Top Skate Shoes', 'StepUp', 'Durable canvas high-top shoes made for skateboarding', 'high_top_skate_shoes.png', 'New'),
(24, 2, 'Classic Oxford Dress Shoes', 'LeatherLux', 'Premium leather Oxford shoes with cap-toe detail', 'classic_oxford_dress_shoes.png', 'New'),
(25, 2, 'Lightweight Cross-Training Shoes', 'FastTrack', 'Multi-surface training shoes with cushioned midsole', 'lightweight_cross_training_shoes.png', 'New'),
(26, 2, 'Water-Resistant Flip Flops', 'BeachWalk', 'Slip-on flip flops with quick-dry, water-resistant straps', 'water_resistant_flip_flops.png', 'New'),
(27, 3, 'Oversized Round Sunglasses', 'SunShade', 'Fashionable round-frame sunglasses with 100% UV protection', 'oversized_round_sunglasses.png', 'New'),
(28, 3, 'Braided Leather Belt', 'BeltMasters', 'Hand-woven braided leather belt with brass buckle', 'braided_leather_belt.png', 'New'),
(29, 3, 'Insulated Eco Water Bottle', 'EcoCarry', '316-grade stainless steel insulated water bottle, 20 oz', 'insulated_eco_water_bottle.png', 'New'),
(30, 3, 'Fitness Tracker Watch', 'TimeKeeper', 'Digital smartwatch with heart-rate monitor & step counter', 'fitness_tracker_watch.png', 'New'),
(31, 1, 'Pre-Owned Moto Leather Jacket', 'UrbanEdge', 'Genuine leather moto jacket with rugged accents and light wear', 'pre_owned_moto_leather_jacket.png', 'Used'),
(32, 1, 'Used EcoThreads Vintage Hoodie', 'EcoThreads', 'Soft cotton hoodie with eco-friendly dye; minor fading on cuffs', 'used_ecothreads_vintage_hoodie.png', 'Used'),
(33, 2, 'Gently Used QuickRun Marathon Shoes', 'QuickRun', 'Lightweight running shoes with minor sole wear', 'gently_used_quickrun_marathon_shoes.png', 'Used'),
(34, 2, 'Pre-Owned SoleStride Slip-Ons', 'SoleStride', 'Comfort slip-on shoes with slight scuffs on the toe area', 'pre_owned_solestride_slip_ons.png', 'Used'),
(35, 3, 'Used LuxeLeather Tote Bag', 'LuxeLeather', 'Premium leather tote bag showing faint strap wear', 'used_luxeleather_tote_bag.png', 'Used'),
(36, 3, 'Pre-Owned SunGuard Visor Cap', 'SunGuard', 'Adjustable UV-protective visor cap with minor discoloration', 'pre_owned_sungaurd_visor_cap.png', 'Used');

-- --------------------------------------------------------


--
-- Table structure for table `role`
--
DROP TABLE IF EXISTS `cart`;
CREATE TABLE cart (
  cart_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  listing_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES user(user_id),
  FOREIGN KEY (listing_id) REFERENCES listing(listing_id),
  UNIQUE KEY (user_id, listing_id)
);

----------------------------------------------------------------
--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(6) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'buyer'),
(2, 'seller');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `user_password` char(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_address` varchar(50) NOT NULL,
  `user_phone` varchar(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_first_name` varchar(50) NOT NULL,
  `user_last_name` varchar(50) NOT NULL,
  `user_role_id` int NOT NULL DEFAULT '1',
  `user_creation_date` date NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `role` (`user_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_password`, `user_email`, `user_address`, `user_phone`, `user_first_name`, `user_last_name`, `user_role_id`, `user_creation_date`) VALUES
(1, 'jadams', '$2y$10$QzhYdpqR.6IfiXXgavz1WeiE5oo.onktDYGWBbyE9BV3fYO4g0Eg6', 'jadams@domain.com', '123 Test Avenue, Sulphur, LA', '12312312', 'Jordan', 'Adams', 1, '2025-04-28'),
(2, 'jadams1', '$2y$10$LxDVflnab2ABKF2n1aSabeR9SbaIlLV0LHTcskAU5B.9cJ3tgiT4.', 'jadams@domain.net', '123', '123-123-', 'Jordan', 'A.', 1, '2025-04-29'),
(3, 'jadams2', '$2y$10$Sfi.r3epNarNEQvievPWXe8BIV1B2FU95DkcyiZkZAy5ItZc8aCBm', 'test@test.com', '123 Test Avenue, Sulphur, LA', '123-122-', 'Jordan', 'Adams', 1, '2025-04-29'),
(4, 'alex_merchant', '07119483b3bab88084503d35117b236c', 'alex.merchant@example.com', '123 Market St, Lake Charles, LA 70601', '337-555-0101', 'Alex', 'Merchant', 2, '2025-04-01'),
(5, 'blake_seller', '6a32dcfe87f325946b330beb5ff07cc3', 'blake.seller@example.com', '456 Commerce Blvd, Lake Charles, LA 70601', '337-555-0102', 'Blake', 'Seller', 2, '2025-04-02'),
(6, 'casey_vendor', '8bdc3876cf7b3fa9a05a822c2af4c681', 'casey.vendor@example.com', '789 Fashion Ave, Lake Charles, LA 70601', '337-555-0103', 'Casey', 'Vendor', 2, '2025-04-03'),
(7, 'dana_trader', '1cc1a77e967b075c58349cd87d47249f', 'dana.trader@example.com', '321 Style Rd, Lake Charles, LA 70601', '337-555-0104', 'Dana', 'Trader', 2, '2025-04-04'),
(8, 'evan_dealer', 'c159c2d68fe873c0b599e043d36e9774', 'evan.dealer@example.com', '654 Trendy Ln, Lake Charles, LA 70601', '337-555-0105', 'Evan', 'Dealer', 2, '2025-04-05'),
(9, 'marketbasics', '5ee356105dfc59bb51e5544025623257', 'contact@marketbasics.com', '100 MarketBasics Ave, Lake Charles, LA 70601', '337-555-0301', 'Market', 'Basics', 2, '2025-04-06'),
(10, 'denimco', 'dff130ecd8a579fbba439ef15d0116b3', 'contact@denimco.com', '101 DenimCo Blvd, Lake Charles, LA 70601', '337-555-0302', 'Denim', 'Co', 2, '2025-04-06'),
(11, 'sunnyfashion', '5295b1dc1d54e7640aab1ece18f93634', 'contact@sunnyfashion.com', '102 SunnyFashion Rd, Lake Charles, LA 70601', '337-555-0303', 'Sunny', 'Fashion', 2, '2025-04-06'),
(12, 'knitstyle', 'eba64c0d29bbdaff8f72532c01aaf21d', 'contact@knitstyle.com', '103 KnitStyle Ln, Lake Charles, LA 70601', '337-555-0304', 'Knit', 'Style', 2, '2025-04-06'),
(13, 'stepup', 'c542c2685ac36f0d6bd14228e10d83d7', 'contact@stepup.com', '104 StepUp Cir, Lake Charles, LA 70601', '337-555-0305', 'Step', 'Up', 2, '2025-04-06'),
(14, 'leatherlux', 'db1fa2775f23490cab4643dfd7c8c958', 'contact@leatherlux.com', '105 LeatherLux Pl, Lake Charles, LA 70601', '337-555-0306', 'Leather', 'Lux', 2, '2025-04-06'),
(15, 'fasttrack', '35c1e80d36a030e39af5c8aff717d805', 'contact@fasttrack.com', '106 FastTrack Pkwy, Lake Charles, LA 70601', '337-555-0307', 'Fast', 'Track', 2, '2025-04-06'),
(16, 'beachwalk', '0f30d32e3352ebba5ab5d3d06dfaba05', 'contact@beachwalk.com', '107 BeachWalk Dr, Lake Charles, LA 70601', '337-555-0308', 'Beach', 'Walk', 2, '2025-04-06'),
(17, 'sunshade', '37bf31a3643d99275974ea286a1f23d4', 'contact@sunshade.com', '108 SunShade Way, Lake Charles, LA 70601', '337-555-0309', 'Sun', 'Shade', 2, '2025-04-06'),
(18, 'beltmasters', '90d3e69c813a650c64d99163caacf5fc', 'contact@beltmasters.com', '109 BeltMasters St, Lake Charles, LA 70601', '337-555-0310', 'Belt', 'Masters', 2, '2025-04-06'),
(19, 'ecocarry', '82526f65efd0ad9515f8869f6650852b', 'contact@ecocarry.com', '110 EcoCarry Ave, Lake Charles, LA 70601', '337-555-0311', 'Eco', 'Carry', 2, '2025-04-06'),
(20, 'timekeeper', 'b16e4221522f95a0fb7dafcf1f718f08', 'contact@timekeeper.com', '111 TimeKeeper Blvd, Lake Charles, LA 70601', '337-555-0312', 'Time', 'Keeper', 2, '2025-04-06');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `role` FOREIGN KEY (`user_role_id`) REFERENCES `role` (`role_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
