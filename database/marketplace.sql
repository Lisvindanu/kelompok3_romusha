-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 05, 2024 at 09:53 PM
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

--
-- Dumping data for table `otp_token`
--

INSERT INTO `otp_token` (`id`, `expires_at`, `otp`, `user_id`) VALUES
(55, '2024-12-06 01:23:59.034808', '167175', 35);

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

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `amount`, `canceled_at`, `confirmed_at`, `created_at`, `reason`, `status`, `purchase_id`) VALUES
(1, 100000, NULL, '2024-11-14 03:30:47.842000', '2024-08-26 14:03:30.961000', NULL, 'confirmed', 1),
(2, 200000, NULL, '2024-11-14 03:30:53.132000', '2024-11-14 03:21:02.882000', NULL, 'confirmed', 2),
(3, 200000, NULL, '2024-11-14 03:30:56.914000', '2024-11-14 03:21:28.172000', NULL, 'confirmed', 2),
(4, 200000, NULL, '2024-11-14 03:31:10.347000', '2024-11-14 03:23:40.892000', NULL, 'confirmed', 2),
(5, 200000, NULL, '2024-11-14 03:31:13.508000', '2024-11-14 03:23:45.263000', NULL, 'confirmed', 1),
(6, 200000, NULL, '2024-11-14 03:31:16.242000', '2024-11-14 03:24:21.978000', NULL, 'confirmed', 1);

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
  `updated_at` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `created_at`, `name`, `price`, `quantity`, `updated_at`) VALUES
(1, '2024-11-19 03:39:45.056000', 'Ps Vita', 1200000, 10, '2024-11-19 03:39:45.056000');

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

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `created_at`, `quantity`, `total_price`, `product_id`, `user_id`) VALUES
(1, '2024-08-26 14:03:14.901503', 2, 600000, 1, 1),
(2, '2024-11-14 03:17:46.463419', 2, 200000, 1, 1),
(3, '2024-11-14 03:23:10.001490', 2, 200000, 1, 1),
(4, '2024-11-19 03:38:14.062093', 2, 2400000, 1, 1);

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

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `expires_at`, `token`, `username`, `user_id`, `sub`) VALUES
(1, '2024-11-14 04:05:30.586041', 'eyJzdWIiOiJhNmRiOGEzYy00MjNiLTRjMTMtOTc4My00MzZjZTE0NjJlMTciLCJ1c2VybmFtZSI6IkRhbnUifQ==', 'Danu', 6, 'a6db8a3c-423b-4c13-9783-436ce1462e17'),
(2, '2024-11-14 04:05:34.620660', 'eyJzdWIiOiJkNWE2NTJkYi05N2IwLTQ2ZjktOTdmMC0wMDNkZDg2OWM5ZDMiLCJ1c2VybmFtZSI6IkRhbnUifQ==', 'Danu', 6, 'd5a652db-97b0-46f9-97f0-003dd869c9d3'),
(3, '2024-11-14 04:07:28.122706', 'eyJzdWIiOiIzNzJiZTgyYS04MzA3LTQwOWItODZiNC1iMzI3YzYwMDhlM2QiLCJ1c2VybmFtZSI6IkRhbnUifQ==', 'Danu', 6, '372be82a-8307-409b-86b4-b327c6008e3d'),
(5, '2024-11-14 04:13:40.520502', 'eyJzdWIiOiIyNWNjY2Y2NS0wYmNhLTQ1NmItODE0MC0yODg4MThkMTgwMzciLCJ1c2VybmFtZSI6IkRhbnUifQ==', 'Danu', 6, '25cccf65-0bca-456b-8140-288818d18037'),
(6, '2024-11-14 04:15:10.541292', 'eyJzdWIiOiI1NmViMGMwOS00MTgxLTRmZjItYTkyOC04MWI1MzIxYTYyNmQiLCJ1c2VybmFtZSI6IkRhbnUifQ==', 'Danu', 6, '56eb0c09-4181-4ff2-a928-81b5321a626d'),
(7, '2024-11-14 04:25:23.483884', 'eyJzdWIiOiIzNGI1ZjYxYS00OTMxLTRmMTktOWVmMS02MWJmODk5NjhmODciLCJ1c2VybmFtZSI6IkRhbnUifQ==', 'Danu', 6, '34b5f61a-4931-4f19-9ef1-61bf89968f87'),
(9, '2024-11-14 04:28:31.647991', 'eyJzdWIiOiJmYmQzZTMzNy00MzI1LTQwNDAtOGYwMy1jYmZiNzUyY2FiMDEiLCJ1c2VybmFtZSI6IkRhbnVLdW4ifQ==', 'DanuKun', 1, 'fbd3e337-4325-4040-8f03-cbfb752cab01'),
(10, '2024-11-14 04:28:36.582267', 'eyJzdWIiOiIzNTUwMmVlYy00Zjg3LTQ5YzktYTc4YS0xMTA0N2NlMjZmODciLCJ1c2VybmFtZSI6IkRhbnVLdW4ifQ==', 'DanuKun', 1, '35502eec-4f87-49c9-a78a-11047ce26f87'),
(12, '2024-11-14 04:29:12.913082', 'eyJzdWIiOiI4NzM1NDg0Yi0yNzk2LTQ2MjYtYjIwNy1iMzE3ZDZmYTY5MWUiLCJ1c2VybmFtZSI6IkRhbnVLdW4ifQ==', 'DanuKun', 1, '8735484b-2796-4626-b207-b317d6fa691e'),
(13, '2024-11-14 04:30:12.884361', 'eyJzdWIiOiJhNGE5MDEwOC02ZDJkLTRmNjYtYWVkZS1hNTEwYTFiOTAyZjEiLCJ1c2VybmFtZSI6IkRhbnVLdW4ifQ==', 'DanuKun', 1, 'a4a90108-6d2d-4f66-aede-a510a1b902f1'),
(14, '2024-11-19 02:25:56.108964', 'eyJzdWIiOiI5OWQzYmUxZi0wOTRiLTQ1YTUtOGQ4Yy02MDFlODI2NTE3YTQiLCJ1c2VybmFtZSI6InNhdyJ9', 'saw', 13, '99d3be1f-094b-45a5-8d8c-601e826517a4'),
(15, '2024-11-19 03:09:33.982194', 'eyJzdWIiOiJlZTMwZWQ1ZC1lMGIwLTQyYjctODM5Zi01NmViMGYyNjMyZTUiLCJ1c2VybmFtZSI6InNhdyJ9', 'saw', 13, 'ee30ed5d-e0b0-42b7-839f-56eb0f2632e5'),
(16, '2024-11-19 04:17:44.979289', 'eyJzdWIiOiI4YmQ3NzhkNS05NzI3LTRhZjMtYTgzMC1hNjlhODZlNTc0MTYiLCJ1c2VybmFtZSI6InNhdyJ9', 'saw', 13, '8bd778d5-9727-4af3-a830-a69a86e57416'),
(17, '2024-11-19 04:19:16.840638', 'eyJzdWIiOiI5ZjZiOTNlZC00MGFmLTQxZTctYmMxNS1mNTBiNzIxOGUyNmQiLCJ1c2VybmFtZSI6InNhdyJ9', 'saw', 13, '9f6b93ed-40af-41e7-bc15-f50b7218e26d'),
(18, '2024-11-19 04:36:17.466489', 'eyJzdWIiOiI5NGJkMDdlMi1lYjdkLTQ5MmYtYmU4ZS00MmNkZjgxNjgxYzUiLCJ1c2VybmFtZSI6InNhdyJ9', 'saw', 13, '94bd07e2-eb7d-492f-be8e-42cdf81681c5'),
(20, '2024-11-24 21:35:43.081155', 'eyJzdWIiOiIxMmM1ZTQ4Ny04MjdhLTRkOWQtYmM0Mi05Mzk5NjllNTRkN2UiLCJ1c2VybmFtZSI6InNhdyJ9', 'saw', 13, '12c5e487-827a-4d9d-bc42-939969e54d7e'),
(21, '2024-11-24 21:35:52.279828', 'eyJzdWIiOiJjZjYxZTBjNS00NmVlLTQ3ZGYtODZlOC1mZGUyMGY2MjhhMTEiLCJ1c2VybmFtZSI6InNhdyJ9', 'saw', 13, 'cf61e0c5-46ee-47df-86e8-fde20f628a11'),
(22, '2024-11-24 21:43:00.099145', 'eyJzdWIiOiI3ZjA3MzIyNi1hNzQ3LTRiZjgtOGQ0Yy04MTE4M2ZhNTVmMDMiLCJ1c2VybmFtZSI6InNhdyJ9', 'saw', 13, '7f073226-a747-4bf8-8d4c-81183fa55f03'),
(23, '2024-11-24 22:08:08.123401', 'eyJzdWIiOiI2MDkzMmM1YS1hMGE5LTQ2MTMtODVkMS00MGIyYjUyYjRmZTQiLCJ1c2VybmFtZSI6InNhdyJ9', 'saw', 13, '60932c5a-a0a9-4613-85d1-40b2b52b4fe4'),
(24, '2024-11-24 22:13:02.042355', 'eyJzdWIiOiI5MTYzMmNjZC0zYTBkLTQxNTEtODUwMi04MWRjNmNjMDM5YmUiLCJ1c2VybmFtZSI6InNhdyJ9', 'saw', 13, '91632ccd-3a0d-4151-8502-81dc6cc039be'),
(25, '2024-11-24 22:16:33.080209', 'eyJzdWIiOiI5NzFjOTMzOC0yZjc5LTRlYzAtYjgzYi1hNmVkYjc0MWUyZjEiLCJ1c2VybmFtZSI6InNhdyJ9', 'saw', 13, '971c9338-2f79-4ec0-b83b-a6edb741e2f1'),
(26, '2024-11-25 02:12:54.480120', 'eyJzdWIiOiI3OGZjMTVlMS05OTMyLTQ2NzAtYTdkNi1mOWExOGQxNzY4OWQiLCJ1c2VybmFtZSI6Ik5hcnV0b29vbyJ9', 'Narutoooo', 19, '78fc15e1-9932-4670-a7d6-f9a18d17689d'),
(27, '2024-11-25 05:01:20.021502', 'eyJzdWIiOiJiOGVhZTZjZC05MTcxLTQ2ODItOWZmYi0wOWUwODRmZDIwODIiLCJ1c2VybmFtZSI6Ik5hcnV0b29vbyJ9', 'Narutoooo', 19, 'b8eae6cd-9171-4682-9ffb-09e084fd2082'),
(28, '2024-11-25 05:01:55.360809', 'eyJzdWIiOiJlMTRlYzY2OC04YTQ2LTQ4M2EtYmU1Yi0xZTRiOTYyMDRlN2MiLCJ1c2VybmFtZSI6Ik5hcnV0b29vbyJ9', 'Narutoooo', 19, 'e14ec668-8a46-483a-be5b-1e4b96204e7c'),
(29, '2024-11-25 05:04:58.537726', 'eyJzdWIiOiJiYjEyNDljYy03YzMzLTRmZGItYjUxYi0zYWUxMTc0ODRmNjQiLCJ1c2VybmFtZSI6Ik5hcnV0b29vbyJ9', 'Narutoooo', 19, 'bb1249cc-7c33-4fdb-b51b-3ae117484f64'),
(30, '2024-11-25 05:08:19.212799', 'eyJzdWIiOiI4NDkzNjEzNS0yM2E1LTQ3NTUtODdkMS1mMGFjM2EzNzgwY2QiLCJ1c2VybmFtZSI6InNhdyJ9', 'saw', 13, '84936135-23a5-4755-87d1-f0ac3a3780cd'),
(31, '2024-11-25 05:14:45.438131', 'eyJzdWIiOiI1Y2E4NjQ4My03YzVmLTQzYmEtYjExOS1hNGMwYjg3ZDdlYWYiLCJ1c2VybmFtZSI6Ik5hcnV0b29vbyJ9', 'Narutoooo', 19, '5ca86483-7c5f-43ba-b119-a4c0b87d7eaf'),
(32, '2024-11-25 05:45:54.625858', 'eyJzdWIiOiJiY2M0NzFiOC1hYTQ1LTQwMDEtYjc4My00NTQwMDk3NzA5ZTkiLCJ1c2VybmFtZSI6Ik5hcnV0b29vbyJ9', 'Narutoooo', 19, 'bcc471b8-aa45-4001-b783-4540097709e9'),
(33, '2024-11-25 06:12:55.761845', 'eyJzdWIiOiI0ODIzYjQ5My0wNzgwLTQ3ZTctYTZjYS1kMzg2MWNkNTRmN2EiLCJ1c2VybmFtZSI6Ik5hcnV0b29vbyJ9', 'Narutoooo', 19, '4823b493-0780-47e7-a6ca-d3861cd54f7a'),
(34, '2024-11-25 06:13:16.496702', 'eyJzdWIiOiIwOTNlY2Q4Zi1iOGYyLTQ1YTItYWM0YS05NzY1OGRiZGM2YmMiLCJ1c2VybmFtZSI6Ik5hcnV0b29vbyJ9', 'Narutoooo', 19, '093ecd8f-b8f2-45a2-ac4a-97658dbdc6bc'),
(35, '2024-11-25 08:31:57.902759', 'eyJzdWIiOiIxNjNkNTkyOC1iMzc5LTRhMWQtYTY2NS04ZjJkNDliMTdmMmEiLCJ1c2VybmFtZSI6IkJoYWRyaWthSXNNYWlBaWRpIn0=', 'BhadrikaIsMaiAidi', 23, '163d5928-b379-4a1d-a665-8f2d49b17f2a'),
(36, '2024-11-25 08:49:39.505011', 'eyJzdWIiOiJjMGExYzQ2NS05NDIzLTRlY2MtYTQyOS1mOWU0OWQ3NGQ5NjUiLCJ1c2VybmFtZSI6IkJhbmdEemlrcmkifQ==', 'BangDzikri', 24, 'c0a1c465-9423-4ecc-a429-f9e49d74d965'),
(37, '2024-11-25 08:49:47.030866', 'eyJzdWIiOiJkNWEyMjdlNS04ZjU4LTRhNTItYWQzOS00ZGQ5Y2E0MmQwZDEiLCJ1c2VybmFtZSI6IkJhbmdEemlrcmkifQ==', 'BangDzikri', 24, 'd5a227e5-8f58-4a52-ad39-4dd9ca42d0d1'),
(38, '2024-11-25 08:49:57.695775', 'eyJzdWIiOiJjZTFhOTkxOC1iYWQ2LTRjMTktOTA4NC1jNDgyNzZkOTIzMWUiLCJ1c2VybmFtZSI6IkJhbmdEemlrcmkifQ==', 'BangDzikri', 24, 'ce1a9918-bad6-4c19-9084-c48276d9231e'),
(39, '2024-11-25 09:22:23.450389', 'eyJzdWIiOiI2MzMxZmY5Yi1jZjkxLTQ2YWItYjY0Ny1hMjBlYThjNGE1YjQiLCJ1c2VybmFtZSI6IkFndW5nIEFsZmF0YWgifQ==', 'Agung Alfatah', 25, '6331ff9b-cf91-46ab-b647-a20ea8c4a5b4'),
(40, '2024-11-25 09:28:46.557309', 'eyJzdWIiOiI0ZDRhNmRlMy1lNzQ0LTQ0MDItOThlNy1mNzI3YjZmYWM5MGYiLCJ1c2VybmFtZSI6IkFndW5nIEFsZmF0YWgifQ==', 'Agung Alfatah', 25, '4d4a6de3-e744-4402-98e7-f727b6fac90f'),
(41, '2024-11-25 09:28:46.557309', 'eyJzdWIiOiIyMTgzODJiMC01MWEzLTQ2NmYtOWMwMy0zZjQ2MmI3NmMwNTAiLCJ1c2VybmFtZSI6IkFndW5nIEFsZmF0YWgifQ==', 'Agung Alfatah', 25, '218382b0-51a3-466f-9c03-3f462b76c050'),
(42, '2024-11-25 09:28:46.557309', 'eyJzdWIiOiIxOTFhMmFlZC0wNzg0LTRmOGItODkyOC1lZmM1NDJmNTNiMzMiLCJ1c2VybmFtZSI6IkFndW5nIEFsZmF0YWgifQ==', 'Agung Alfatah', 25, '191a2aed-0784-4f8b-8928-efc542f53b33'),
(43, '2024-11-27 23:20:55.477583', 'eyJzdWIiOiJmOWI0ZTcwZC1hOGE2LTQyYTctOWI5YS0wZWExMTE0YTQwNWYiLCJ1c2VybmFtZSI6IkppdGEifQ==', 'Jita', 27, 'f9b4e70d-a8a6-42a7-9b9a-0ea1114a405f'),
(44, '2024-11-28 18:50:49.203556', 'eyJzdWIiOiIyODYwNzg4ZS00MTE4LTRjNmYtYjM4Zi03Yzc2ZmRlYTA1ZTkiLCJ1c2VybmFtZSI6IkFndW5nIEFsZmF0YWgifQ==', 'Agung Alfatah', 25, '2860788e-4118-4c6f-b38f-7c76fdea05e9'),
(45, '2024-12-05 07:16:52.498192', 'eyJzdWIiOiI0NWYzNDYwYS05MTFhLTRiZjMtYjllZS01NzdkM2YxMjYzMzYiLCJ1c2VybmFtZSI6IkFndW5nIEFsZmF0YWgifQ==', 'Agung Alfatah', 25, '45f3460a-911a-4bf3-b9ee-577d3f126336'),
(46, '2024-12-05 07:16:59.539690', 'eyJzdWIiOiJkNjIxYWY1MC0zNjY0LTRhY2EtOGMyNS0wYzgxNWY3MTE2MTMiLCJ1c2VybmFtZSI6IkFndW5nIEFsZmF0YWgifQ==', 'Agung Alfatah', 25, 'd621af50-3664-4aca-8c25-0c815f711613'),
(47, '2024-12-05 07:27:16.369399', 'eyJzdWIiOiJhNmY4ZGYzMy01MmRjLTQ4ODgtYTNiNS0wOGU0Yzc3OGQ0NmIiLCJ1c2VybmFtZSI6IkFndW5nIEFsZmF0YWgifQ==', 'Agung Alfatah', 25, 'a6f8df33-52dc-4888-a3b5-08e4c778d46b'),
(48, '2024-12-05 07:28:18.711312', 'eyJzdWIiOiIyMzhhNmMxMC0wNTA5LTRhNGItOWJhNy1hMWFjZjY0ZWVlMDgiLCJ1c2VybmFtZSI6IkFndW5nIEFsZmF0YWgifQ==', 'Agung Alfatah', 25, '238a6c10-0509-4a4b-9ba7-a1acf64eee08'),
(64, '2024-12-06 00:40:06.075882', 'eyJzdWIiOiJmODk4Yzc0Ni1iOWJhLTRhZjItOTFmMS0yOTg3ZWY0NThmMjQiLCJ1c2VybmFtZSI6IkFuYXBoeWdvbiJ9', 'Anaphygon', 35, 'f898c746-b9ba-4af2-91f1-2987ef458f24'),
(65, '2024-12-06 01:11:49.275405', 'eyJzdWIiOiI4ZjIwYWRlNi0zYTVkLTQ2MDUtYThiNi03ZDVkNDVmMzg3NDciLCJ1c2VybmFtZSI6IkFuYXBoeWdvbiJ9', 'Anaphygon', 35, '8f20ade6-3a5d-4605-a8b6-7d5d45f38747');

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
  `google_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created_at`, `email`, `password`, `username`, `google_id`) VALUES
(1, '2024-08-26 14:02:51.702154', 'DanuKun@Gmail.com', '$2a$10$KhKJsv9pf0ceeLlCfhg.VukKF/qvwvKhOAyPXOU1xsHeEuekkhVXG', 'DanuKun', NULL),
(2, '2024-11-14 02:27:14.147712', 'Kaka@Gmail.com', '$2a$10$QTuu5VyFDGebuYHMuPft3.1SQVm2RCZjojtqOFYBcyhNgCn3qtBPO', 'Kaka', NULL),
(3, '2024-11-14 02:28:21.928221', 'Kakaa@Gmail.com', '$2a$10$g.fhBRrNBAnT1OQJc.YghuVXx2j8ZuQxNUfi1wgZB7h.ZGEPfgtve', 'Kaaka', NULL),
(4, '2024-11-14 02:30:12.383193', 'Kakaaa@Gmail.com', '$2a$10$AavCUXfXghDwdgC19hL1TOGMxSXKM8Zyijj786JU3HZGAWvqc.8v.', 'Kaaaka', NULL),
(5, '2024-11-14 02:47:11.987847', 'RajaIblis@Gmail.com', '$2a$10$BDxXM3anKhrV9Qn9IQQQNuGkJSplyvPT86mPRxpFQt6q15Q8pNJRO', 'RajaIblis', NULL),
(6, '2024-11-14 02:59:31.960014', 'DanuRajaIblis@Gmail.com', '$2a$10$s0MlJk.yt1QHwIg0/OIoIeiXSX4Gvv1x.6VejF7nK.2AX1AkjY1LK', 'Danu', NULL),
(7, '2024-11-14 04:06:10.513529', 'test@example.com', '$2a$10$a7ojWxrmTgbXQ5kggKodje1I7wVh6OsSwvvednL9QqItjz464A2Xq', 'testUser', NULL),
(8, '2024-11-14 04:06:28.319226', 'tests@example.com', '', 'testsUser', NULL),
(9, '2024-11-14 04:08:29.419421', 'testes@example.com', '', 'testesUser', NULL),
(10, '2024-11-14 04:11:53.368982', 'tewstes@example.com', '', 'tewstesUser', NULL),
(11, '2024-11-19 01:07:53.395530', 's@Gmail.com', '$2a$10$tcCDjRXvtIJvs2vqPngW0OZs12mDTTOLVnYmDim791qnP9icDYrMy', 's', NULL),
(12, '2024-11-19 01:13:34.561014', 'sw@Gmail.com', '$2a$10$uhWKpdQ9NkY9NrMcP9CU7.NLqSrzYCrEEELS0Lpl3p4fr4hkezkl.', 'sw', NULL),
(13, '2024-11-19 01:21:44.740535', 'saw@Gmail.com', '$2a$10$VeeLKd34l.fmHDp5Ur3C0.S8nTlhsqfDwp6K5W37MAXmxVad2bkKS', 'saw', NULL),
(14, '2024-11-19 01:24:43.455370', 'tewdstes@example.com', '$2a$10$Rn/U4Ta8milHHzAagV6rmenIFwEZM07dyGtImnMLzVIb5uq4I0buC', 'tewdstesUser', NULL),
(15, '2024-11-24 23:37:52.423350', 'kakangksung@gmail.com', '$2a$10$5JL78Uum.c98TIGh2AGKvueR0wc6F7Ab/VgPAINVbhOWkNp2H4ATe', 'kakangksung', NULL),
(16, '2024-11-24 23:38:32.812223', 'asss@gmail.com', '$2a$10$P2XIzcUfwjLxvNMCakVhmO6TwcXFBXb9OplaDpIejiLlIDPlQKXJ6', 'asss', NULL),
(17, '2024-11-24 23:39:52.797034', 'qqqgacor@gmail.com', '$2a$10$uKEnvM76gXafh4f/r7v2tOirkAcRYVN12GLjK.4rtW5i/Px3Ioe16', 'Lisv', NULL),
(18, '2024-11-25 00:12:13.731011', 'qweqweqwe@gmail.com', '$2a$10$O.scbo3cWFDG129iIMzOw.XfmG0ZRzjFHM4ayEGFcn83b/l2tV8Vu', 'wqeqweqwe', NULL),
(19, '2024-11-25 00:28:30.594088', 'Narutoooo@gmail.com', '$2a$10$Ae3piEa5vGnSk2bi0ipgkuLOBfrIs2WJ1qRiyiywuE3aX8NPLPX4O', 'Narutoooo', NULL),
(20, '2024-11-25 00:51:58.660985', 'lisvindanu25@gmail.com', '$2a$10$Flj1N5o.skpv9dOOzE6a3OIb60a61Qt/t1HdpaI3myEEa5Acq0862', 'LISVINDANU', NULL),
(21, '2024-11-25 01:01:37.220031', 'DanuGanteng@gmail.com', '$2a$10$JElnS9N4PIbTQZfS1NKKmefwDYTo8pFKq5pk8xUk6HZ1PP2X8P9dC', 'DanuGanteng', NULL),
(22, '2024-11-25 04:00:02.110116', 'qqwww@gmail.com', '$2a$10$UuL5FfOmATlMn/7Rqy6AiebZvQXX8sPye/RB15C1AyUCEYds4akBy', 'qqwww', NULL),
(23, '2024-11-25 07:31:19.066946', 'BhadrikaIsMaiAidi@gmail.com', '$2a$10$eE8dlpOZkyp4wxT6HXNaJe1woTZtf1SyLR9EZbSLGbBFDtIsc2sHW', 'BhadrikaIsMaiAidi', NULL),
(24, '2024-11-25 07:49:22.776759', 'BangDzikri@gmail.com', '$2a$10$pIXOyJpJMJqq2QyPGxB2Ye.p80dDl3xBXpo70coNefBNfvRq0Jk72', 'BangDzikri', NULL),
(25, '2024-11-25 08:21:48.955422', 'Agung.Alfatah43@gmail.com', '$2a$10$xqSEzbVI9EbKn.Anq2PfaOdAEA/oO3NaY6nzC9bnvQZkCpRB75Q.K', 'Agung Alfatah', NULL),
(26, '2024-11-27 22:19:37.795747', 'Kanjut@gmail.com', '$2a$10$nxoGrYVU6YZGPERiZn0VAep3A3k2Rp1r/Y9v.aSpz5oFDq9auWwtG', 'Kanjut', NULL),
(27, '2024-11-27 22:20:36.969846', 'jita@gmail.com', '$2a$10$y89N8o7oJNJczMl3aESvYu2NYFzgMb03de7vrCnFewCxEo/XaMoP.', 'Jita', NULL),
(28, '2024-11-28 18:32:59.425720', 'qq@gmail.com', '$2a$10$PD6xaAqmazkpS91E/mjV9.9pGTX3dK.zIgZzTV.ZgVG3YAE5E51/a', 'qq', NULL),
(29, '2024-11-28 19:08:18.895104', 'kakaNaruto@gmail.com', '$2a$10$oTwOv0CBAlXAxY4ZLATatu54D7lS4TMjKVgtlOrrFPoDTngnNV3l2', 'KakaNaruto', NULL),
(30, '2024-12-01 14:21:47.129987', 'Ewok@jelek.com', '$2a$10$fTs3jd60RlJ0JWAK/7mrrO2e9eSM3F9GF/w.aBDG2Sg7le23Pvn1u', 'Ewok', NULL),
(31, '2024-12-05 05:17:30.065854', 'qw@Gmail.com', '$2a$10$x2ZZRG3GaYeYB5zXgtju9uEXjRbOQBVAxRAyos4a64PiLUbXzNlwC', 'qw', NULL),
(34, '2024-12-05 23:38:44.003353', 'Anaphygson@protonmail.com', '$2a$10$FCsLEWJqDmXULFmXSEygCO2E97/cNpuRm9soqrrVe.SoluhSKsbR2', 'Anaphygonku', NULL),
(35, '2024-12-05 23:39:02.226295', 'Anaphygon@protonmail.com', '$2a$10$AGRSf1cvzWwfVE0BqGs2zuSfS94zNKMvN/wYWNTzCqY23zgNj5xPC', 'Anaphygon', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKojjfjcwuims3swikm1hlaofan` (`purchase_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otp_token`
--
ALTER TABLE `otp_token`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

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
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
