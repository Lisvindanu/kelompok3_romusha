-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 14, 2024 at 11:55 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marketplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
                            `id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `api_keys`
--

INSERT INTO `api_keys` (`id`) VALUES
    ('secret');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
                              `id` bigint NOT NULL,
                              `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
                          `id` bigint NOT NULL,
                          `name` varchar(255) NOT NULL,
                          `category_id` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
                             `id` bigint NOT NULL,
                             `last_updated` datetime(6) NOT NULL,
                             `quantity` int NOT NULL,
                             `product_id` bigint NOT NULL,
                             `user_id` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otp_token`
--

CREATE TABLE `otp_token` (
                             `id` bigint NOT NULL,
                             `expires_at` datetime(6) DEFAULT NULL,
                             `otp` varchar(255) DEFAULT NULL,
                             `user_id` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
                                         `id` bigint NOT NULL,
                                         `expires_at` datetime(6) NOT NULL,
                                         `token` varchar(255) NOT NULL,
                                         `user_id` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
                            `id` bigint NOT NULL,
                            `amount` bigint NOT NULL,
                            `canceled_at` datetime(6) DEFAULT NULL,
                            `confirmed_at` datetime(6) DEFAULT NULL,
                            `created_at` datetime(6) NOT NULL,
                            `reason` varchar(255) DEFAULT NULL,
                            `status` varchar(255) NOT NULL,
                            `purchase_id` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
                            `id` bigint NOT NULL,
                            `created_at` datetime(6) NOT NULL,
                            `name` varchar(255) NOT NULL,
                            `price` bigint NOT NULL,
                            `quantity` int NOT NULL,
                            `updated_at` datetime(6) NOT NULL,
                            `category_id` bigint NOT NULL,
                            `genre_id` bigint DEFAULT NULL,
                            `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
                            `id` bigint NOT NULL,
                            `created_at` datetime(6) NOT NULL,
                            `quantity` int NOT NULL,
                            `total_price` bigint NOT NULL,
                            `product_id` bigint NOT NULL,
                            `user_id` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
                          `id` bigint NOT NULL,
                          `expires_at` datetime(6) NOT NULL,
                          `token` varchar(255) NOT NULL,
                          `username` varchar(255) NOT NULL,
                          `user_id` bigint NOT NULL,
                          `sub` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
                         `id` bigint NOT NULL,
                         `created_at` datetime(6) DEFAULT NULL,
                         `email` varchar(255) NOT NULL,
                         `password` varchar(255) DEFAULT NULL,
                         `username` varchar(255) DEFAULT NULL,
                         `google_id` varchar(255) DEFAULT NULL,
                         `is_otp_verified` bit(1) DEFAULT NULL,
                         `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

-- Reset auto-increment for all tables to start from 1
ALTER TABLE categories AUTO_INCREMENT = 1;
ALTER TABLE genres AUTO_INCREMENT = 1;
ALTER TABLE inventory AUTO_INCREMENT = 1;
ALTER TABLE otp_token AUTO_INCREMENT = 1;
ALTER TABLE password_reset_tokens AUTO_INCREMENT = 1;
ALTER TABLE payments AUTO_INCREMENT = 1;
ALTER TABLE products AUTO_INCREMENT = 1;
ALTER TABLE purchase AUTO_INCREMENT = 1;
ALTER TABLE tokens AUTO_INCREMENT = 1;
ALTER TABLE users AUTO_INCREMENT = 1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `UKt8o6pivur7nn124jehx7cygw5` (`name`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `UKpe1a9woik1k97l87cieguyhh4` (`name`),
    ADD KEY `FK7sykxw6ipq2yr9y232oya5djp` (`category_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FKq2yge7ebtfuvwufr6lwfwqy9l` (`product_id`),
    ADD KEY `FK6s70ikopm646wy54vwowsnp6d` (`user_id`);

--
-- Indexes for table `otp_token`
--
ALTER TABLE `otp_token`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `UKp95e57dijmnw22xv6hiypih4g` (`user_id`,`otp`),
    ADD UNIQUE KEY `UKjo6dcptokd4wslvipwkiw8aid` (`user_id`,`otp`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `UK71lqwbwtklmljk3qlsugr1mig` (`token`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FKojjfjcwuims3swikm1hlaofan` (`purchase_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FKog2rp4qthbtt2lfyhfo32lsw9` (`category_id`),
    ADD KEY `FK1w6wsbg6w189oop2bl38v0hjk` (`genre_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FKsfqpk5xjv93po29vn4fmy5exq` (`product_id`),
    ADD KEY `FKoj7ky1v8cf4ibkk0s7alikp52` (`user_id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `UKna3v9f8s7ucnj16tylrs822qj` (`token`),
    ADD UNIQUE KEY `UKdh3mmlp0osglrb2btpcaxa9co` (`sub`),
    ADD KEY `FK2dylsfo39lgjyqml2tbe0b0ss` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `UKr43af9ap4edm43mmtq01oddj6` (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `genres`
--
ALTER TABLE `genres`
    ADD CONSTRAINT `FK7sykxw6ipq2yr9y232oya5djp` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
    ADD CONSTRAINT `FK6s70ikopm646wy54vwowsnp6d` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    ADD CONSTRAINT `FKq2yge7ebtfuvwufr6lwfwqy9l` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
    ADD CONSTRAINT `FKojjfjcwuims3swikm1hlaofan` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
    ADD CONSTRAINT `FK1w6wsbg6w189oop2bl38v0hjk` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`),
    ADD CONSTRAINT `FKog2rp4qthbtt2lfyhfo32lsw9` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
    ADD CONSTRAINT `FKoj7ky1v8cf4ibkk0s7alikp52` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    ADD CONSTRAINT `FKsfqpk5xjv93po29vn4fmy5exq` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
    ADD CONSTRAINT `FK2dylsfo39lgjyqml2tbe0b0ss` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
