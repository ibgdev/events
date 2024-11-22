-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 22, 2024 at 08:50 AM
-- Server version: 8.0.40-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `places_dispo` int NOT NULL,
  `organiser_id` int NOT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `type`, `description`, `date`, `location`, `places_dispo`, `organiser_id`, `img`) VALUES
(1, 'Tech Expo 2024', 'tech', 'Discover the latest in tech innovation.', '2024-12-05', 'Tunis', 200, 2, 'https://www-res.cablelabs.com/wp-content/uploads/2024/08/19093252/techexpo-2024.jpg'),
(2, 'AI Summit 2024', 'tech', 'Exploring AI advancements and opportunities.', '2024-12-15', 'Sfax', 150, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQHdyctoo4gjRs60qk4RhtJcsnAyuJO-zRYJw&s'),
(3, 'Future Tech Forum', 'tech', 'Discussing the future of technology.', '2025-01-10', 'Sousse', 300, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSsBWUV1322JAUDC89z88HMSoBHGV3pHhuy4g&s'),
(4, 'Startup Showcase', 'tech', 'Spotlight on emerging tech startups.', '2025-01-25', 'Tunis', 250, 2, 'https://websummit.com/wp-media/2023/09/Felix-Choi-CMO-WiredCompany-at-Startup-Showcase-Stage.jpg'),
(5, 'Robotics Expo', 'tech', 'Showcasing cutting-edge robotics.', '2025-02-05', 'Monastir', 180, 2, 'https://mir-s3-cdn-cf.behance.net/project_modules/1400/2ce26037701195.57492a44ba1d2.png'),
(6, 'TechFest 2025', 'tech', 'Tech festival for innovators and enthusiasts.', '2025-02-20', 'Gabès', 350, 2, 'https://disrupt-b2b.fr/wp-content/uploads/2024/02/Succes-pour-la-1ere-edition-de-techfest-qui-revient-en-2025-salon.jpg'),
(7, 'Cloud Conference', 'tech', 'Cloud computing trends and strategies.', '2025-03-10', 'Tunis', 220, 2, 'https://calendar.boussiasevents.gr/wp-content/uploads/2022/08/840x560-10.jpg'),
(8, 'Green Tech Expo', 'tech', 'Sustainable technology advancements.', '2025-03-25', 'Sousse', 170, 2, 'https://ait.ac.th/wp-content/uploads/2024/11/green-tech-expo-2024-4.jpg'),
(9, 'VR/AR Summit', 'tech', 'Virtual and augmented reality showcase.', '2025-04-05', 'Tunis', 400, 2, 'https://content.arborxr.com/2021/07/ArborXR-Events-VRARA-Global-Summit-2021.jpg'),
(10, 'FinTech Forum', 'tech', 'FinTech trends and innovations.', '2025-04-20', 'Sfax', 200, 2, 'https://fintechlatvia.eu/wp-content/uploads/2022/09/fintech-forums-5.jpg'),
(11, 'Mobile World Congress', 'tech', 'Mobile technology and developments.', '2025-05-05', 'Tunis', 500, 2, 'https://i0.wp.com/www.gsma.com/newsroom/wp-content/uploads//postshowimage_PR.png?fit=650%2C320&ssl=1'),
(12, 'Cybersecurity Meet', 'tech', 'Insights into cybersecurity trends.', '2025-05-20', 'Monastir', 120, 2, 'https://itknowledgezone.com/wp-content/uploads/2022/06/Five-Ways-to-Ensure-Robust-Cyber-Security-in-a-Digital-First-Environment.jpg'),
(13, 'TechBridge 2025', 'tech', 'Bridging the gap between tech and business.', '2025-06-10', 'Gabès', 300, 2, 'https://www.fraunhofer.org/en/Research/Programs/fraunhofer-techbridge-program/jcr:content/stage/stageParsys/stage_slide/image.img.jpg/1562948096375/1500-cropped-AdobeStock-65922076-2.jpg'),
(14, 'AI & Ethics Forum', 'tech', 'Discussing ethics in AI.', '2025-06-25', 'Sousse', 100, 2, 'https://pbs.twimg.com/media/GFFM_AVWcAAw7yX.png'),
(15, 'Blockchain Expo', 'tech', 'Exploring blockchain technology.', '2025-07-05', 'Tunis', 250, 2, 'https://agcdn-1d97e.kxcdn.com/wp-content/uploads/2020/09/alphagamma-Blockchain-Expo-opportunites.jpg'),
(16, 'Data Science Summit', 'tech', 'Big data and analytics conference.', '2025-07-10', 'Sfax', 200, 2, 'https://i.ytimg.com/vi/gac9YxJ9VwM/maxresdefault.jpg'),
(17, 'Innovation Week 2025', 'tech', 'A week of tech innovation and inspiration.', '2025-07-15', 'Gabès', 300, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSjPUKl4ABt6JGh10r2q9fxdWHripOHi0ZhQA&s'),
(18, 'Tech for Good', 'tech', 'Using technology for social impact.', '2025-07-20', 'Sousse', 150, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQvE8HmJTfLeueH7JDfqh50Z-you1PFmb_uqQ&s'),
(19, 'Quantum Computing Forum', 'tech', 'Quantum computing and its applications.', '2025-07-25', 'Tunis', 100, 2, 'https://thequantuminsider.com/wp-content/uploads/2024/09/hudson_forum_2024.jpg'),
(20, 'November TechFest', 'tech', 'A tech fest to close the year with innovations.', '2024-11-20', 'Tunis', 400, 2, 'https://evessio.s3.amazonaws.com/customer/b4289942-d924-4d3d-9044-2b4131d4ae91/event/75408676-2d2d-4e17-b1af-7fb6c43334bd/media/14660699-node_emap_Techfest_Awards_Nov_23-31_Large.jpg'),
(21, 'AI Winter Conference', 'tech', 'Exploring AI applications for the coming year.', '2024-11-25', 'Sfax', 300, 2, 'https://i.ytimg.com/vi/sgbd6eAj-OE/maxresdefault.jpg'),
(22, 'Global Tech Leaders Meetup', 'tech', 'Network with global tech leaders.', '2024-11-30', 'Sousse', 250, 2, 'https://cdn.prod.website-files.com/5e9996a6531fea7d1003b18e/651dc04e2abe644937adec32_Mike%20Butcher%20Jonas%20Andrulis%20WeAreDevelopers.jpg'),
(23, 'Summer Music Festival\"', 'Music', ' grand celebration of music...\" describes the event', '2024-11-28', 'Nabeul', 500, 1, 'https://thailandknowhow.com/wp-content/uploads/2024/02/Bangkok-Music-Festivals-2024.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `num_places` int NOT NULL,
  `reservation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `phone` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phone`) VALUES
(1, 'admin', 'admin@admin.re', 'admin.re.2025', '26044125'),
(2, 'ibrahim ghorbali', 'ibrahimghorbali605@gmail.com', '1234', '94569131'),
(3, 'Wissem ltaif', 'wissemltaif@gmail.com', 'wiss123', '99784562'),
(10, 'Wissal belhadjamor', 'belhadjamorwissal@gmail.com', 'wissal1234', '58741369');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organiser_id` (`organiser_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`organiser_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
