-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 26, 2024 at 09:35 PM
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
  `img` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `type`, `description`, `date`, `location`, `places_dispo`, `organiser_id`, `img`) VALUES
(1, 'DevFest', 'Tech', 'DevFest is an annual distribution of IT knowledge.', '2024-12-14', 'Sousse', 700, 1, 'https://img.evbuc.com/https%3A%2F%2Fcdn.evbuc.com%2Fimages%2F872949259%2F194330602208%2F1%2Foriginal.20241012-100015?crop=focalpoint&fit=crop&w=1000&auto=format%2Ccompress&q=75&sharp=10&fp-x=0.979166666667&fp-y=0.442379182156&s=2e241171c584042996db7308ac1b52bc'),
(2, 'TechMeet', 'Tech', 'A grand celebration of tech innovation.', '2024-11-28', 'Tunis', 500, 2, 'https://img.evbuc.com/https%3A%2F%2Fcdn.evbuc.com%2Fimages%2F900455993%2F2500791969791%2F1%2Foriginal.png?w=600&auto=format%2Ccompress&q=75&sharp=10&rect=0%2C0%2C940%2C470&s=b6fe57b0c031b9e6d1fb79108f28d5b4'),
(3, 'CodeRush', 'Tech', 'A hackathon for developers to code and compete.', '2025-01-15', 'Sfax', 500, 3, 'https://careers.spriteera.com/assets/img1-BIZZLbds.png'),
(4, 'WebDev Summit', 'Tech', 'Explore the latest trends in web development.', '2025-03-10', 'Tunis', 350, 1, 'https://media2.dev.to/dynamic/image/width=1280,height=720,fit=cover,gravity=auto,format=auto/https%3A%2F%2Fdev-to-uploads.s3.amazonaws.com%2Fuploads%2Farticles%2Fhqwlkvpf19p93aphjy5r.png'),
(5, 'AI Expo', 'Tech', 'Discover the advancements in AI technology.', '2025-04-22', 'Sousse', 600, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcStgB1pF7e0cWnZh3Yg4RsUR8l295arOpZVTmXW9rvZMDmbWzNfK--KZbxFTs_Dh-t7tGA&usqp=CAU'),
(6, 'Blockchain Conference', 'Tech', 'Learn about the future of blockchain technologies.', '2025-05-15', 'Monastir', 450, 3, 'https://agcdn-1d97e.kxcdn.com/wp-content/uploads/2022/06/alphagamma-Blockchain-Futurist-Conference-2022-opportunities.jpeg'),
(8, 'Digital Transformation Expo', 'Tech', 'Understanding the impact of digital transformation on industries.', '2025-07-25', 'Sfax', 700, 2, 'https://kantaracreative.com/wp-content/uploads/2023/01/2-1-1024x681.jpg'),
(9, 'TechTalks', 'Tech', 'A series of talks with industry leaders in the tech world.', '2025-08-14', 'Sousse', 300, 3, 'https://static1.squarespace.com/static/5a7bdcbadc2b4a82bfcff024/t/5a908da8ec212d9451774b45/1519422894977/TechTalks+color_b.jpg?format=1500w'),
(10, 'Music Fest', 'Musical', 'A live music event featuring top international artists.', '2025-09-05', 'Tunis', 1200, 13, 'https://www.datocms-assets.com/66357/1703582519-mdlbeast2022_1203_141406-4453_pd-1.webp?auto=format&fit=max&w=3840&q=75'),
(11, 'GameOn', 'Fun', 'A gaming event with tournaments and multiplayer fun.', '2025-10-10', 'Sfax', 800, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcREICYPSN8CezqslgeigFIJsADR5VUxZ8Mafw&s'),
(12, 'ArtFusion', 'Fun', 'A creative fun-filled event celebrating the arts.', '2025-11-05', 'Monastir', 600, 3, 'https://i.ytimg.com/vi/8sNhZJebmPQ/maxresdefault.jpg'),
(13, 'FoodFest', 'Fun', 'A food lover\'s dream festival with international cuisine.', '2025-12-15', 'Tunis', 1000, 13, 'https://elements-resized.envatousercontent.com/elements-cover-images/3a2198f9-6820-4c92-a8de-dbb1ee129b6b?w=433&cf_fit=scale-down&q=85&format=auto&s=bafa7543f8830daf3ed155be04a59f140e69c03b11cebc5b0ae0f410bd4502e4'),
(14, 'FunFair', 'Fun', 'A day filled with games, food, and laughter.', '2025-05-10', 'Monastir', 1000, 3, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS6PX61Jgo1hZjFhQdz8ScTFLNIlgwLcZ7ebA&s'),
(15, 'TechJam', 'Tech', 'A musical event with a tech twist and programming challenges.', '2025-01-01', 'Tunis', 450, 1, 'https://avatars.githubusercontent.com/u/57932711?s=280&v=4'),
(16, 'CodeNight', 'Tech', 'An overnight event for tech enthusiasts to work and collaborate.', '2025-02-21', 'Sfax', 500, 2, 'https://codenight.et/big-banner.png'),
(17, 'Musical Madness', 'Musical', 'An exciting music and light show event.', '2025-03-05', 'Tunis', 700, 3, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS3RbUX24u2vn1MNsj1TndjP76FSntGTh3R8JW5A1QlfxCCMfAVSom4xbGN3j2gV1Tp4vQ&usqp=CAU'),
(18, 'GuitarFest', 'Musical', 'A music festival for guitar lovers and enthusiasts.', '2025-04-12', 'Sousse', 800, 2, 'https://i.ytimg.com/vi/izAroJTeA8Q/hq720.jpg?sqp=-oaymwE7CK4FEIIDSFryq4qpAy0IARUAAAAAGAElAADIQj0AgKJD8AEB-AH-CYAC0AWKAgwIABABGDQgEyh_MA8=&rs=AOn4CLBy4lBglC7sOyD6t2vnhGP790X0Lw'),
(19, 'Tech and Fun Expo', 'Tech', 'Combining technology with fun activities and competitions.', '2025-06-22', 'Sfax', 600, 2, 'https://www.ringling.edu/wp-content/uploads/2023/11/112223-IAAPARecap-scaled.jpg'),
(21, 'Electronica china', 'Tech', 'electronica China is the important event of its kind to showcase the entire range of electronic components from technologies ', '2024-11-30', 'Sousse', 800, 13, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRoizTREMw9ul5-ZVC5bRhwVnB03KwPLdSzSw&s');

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
  `phone` varchar(11) NOT NULL,
  `org` binary(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phone`, `org`) VALUES
(1, 'Admin', 'admin@admin.re', '1234', '26044125', 0x31),
(2, 'ibrahim ghorbali', 'ibrahimghorbali605@gmail.com', '1234', '94569131', 0x31),
(3, 'Wissem ltaif', 'wissemltaif@gmail.com', 'wiss123', '99784562', 0x31),
(10, 'Wissal belhadjamor', 'belhadjamorwissal@gmail.com', 'wissal1234', '58741369', 0x30),
(11, 'Mariem Ben Ayada', 'mariemmimi@gmail.com', 'mariem123', '25147369', 0x30),
(12, 'Lina mahjoub', 'mahjoulina1010@gmail.com', 'lina123', '99784503', 0x30),
(13, 'mabrouk ghorbali', 'ghorbalimabrou@gmail.com', '123', '94569131', 0x31),
(14, 'Amira Ghorbali', 'amiraghorbali@hotmail.com', '123', '28745693', 0x30);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
