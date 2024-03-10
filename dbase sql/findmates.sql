-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2021 at 11:21 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `findmates`
--

-- --------------------------------------------------------

--
-- Table structure for table `eventcategory`
--

CREATE TABLE `eventcategory` (
  `categoryId` int(11) NOT NULL,
  `categoryName` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `eventId` int(11) NOT NULL,
  `postDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ev_host` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `eventTitle` varchar(80) NOT NULL,
  `eventVenue` varchar(80) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `minFee` int(11) NOT NULL,
  `maxFee` int(11) NOT NULL,
  `eventImage` text,
  `eventDescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventId`, `postDate`, `ev_host`, `category`, `eventTitle`, `eventVenue`, `startDate`, `endDate`, `minFee`, `maxFee`, `eventImage`, `eventDescription`) VALUES
(1, '2021-09-28 11:06:55', 1, 'Conference', 'Students Conference 2021 (UCON)', 'National Museum Posta - Dar es Salaam', '2021-10-21 15:00:00', '2021-09-29 22:00:00', 5000, 20000, 'assets/imgs/events_pictures/1.jpg', 'Liberty Sparks Students Conference (UCon)is a premium physical event that brings together talented students and professionals from various countries in Africa to learn, exchange ideas, share strategies, and celebrate for the promising, freer, and prosperous society.\r\n\r\nThe UCon serves as the foundation of reforms and changes in our community.\r\n\r\n2021 Students Conference(UCon) is set to educate and inspire the new young generation toward a freer and more prosperous society and help promote Liberty Sparks&#039; principles.\r\n\r\nLiberty Sparks is proud to announce that our 2021 Top Students Conference (Uhuru Con) is scheduled to take place on November 13.\r\n\r\nThe one-day Uhuru Con will occur at The National Museum, offering various speakers.\r\n\r\nRegistration for the Uhuru Con includes free books, admission to our refreshment, and networking session.'),
(2, '2021-09-28 11:27:02', 2, 'Festival or Party', 'Traditional Music festival', 'Uhuru national stadium Dar-es-salaam', '2021-10-22 10:00:00', '2021-10-02 23:59:00', 5000, 100000, 'assets/imgs/events_pictures/2.jpg', 'The music festival emerged in England in the 18th century as an extension of urban concert life into a form of seasonal cultural festivity structured around a schedule of music performances or concerts. Liberty Sparks Students Conference (UCon)is a premium physical event that brings together talented students and professionals from various countries in Africa to learn, exchange ideas, share strategies, and celebrate for the promising, freer, and prosperous society.\r\n\r\nThe UCon serves as the foundation of reforms and changes in our community.\r\n\r\n2021 Students Conference(UCon) is set to educate and inspire the new young generation toward a freer and more prosperous society and help promote Liberty Sparks&#039; principles.\r\n\r\nLiberty Sparks is proud to announce that our 2021 Top Students Conference (Uhuru Con) is scheduled to take place on November 13.\r\n\r\nThe one-day Uhuru Con will occur at The National Museum, offering various speakers.\r\n\r\nRegistration for the Uhuru Con includes free books, admission to our refreshment, and networking session.'),
(3, '2021-10-01 13:40:03', 2, 'Festival or Party', 'UDOM graduation ceremony 2021', 'University of Dodoma, Chimwaga Hall University of Dodoma, Chimwaga Hall', '2021-11-01 09:00:00', '2021-11-01 18:00:00', 0, 150000, 'assets/imgs/events_pictures/3.jpg', 'Karibuni katika sherehe ya kuhitimu masomo mwaka 2021 katika chuo kikuu cha dodoma'),
(4, '2021-10-01 13:55:53', 1, 'Festival or Party', 'Global Rejoice Gospel Awards | Gospel Ministry Celebration Concert', 'Feel Free Church - Dar-es-salaam', '2021-10-25 09:00:00', '2021-10-03 22:00:00', 0, 0, 'assets/imgs/events_pictures/4.jpeg', 'These Awards are being given in recognition of the hard work and efforts being done by Musicians, Pastors, Music Directors, Music Producers, Sound Engineers, Medias, Christian Organizations, Gospel Institutions, Presenters, Bloggers and Event Organizers. The bigger picture Of GRG Awards Is to appreciate and acknowledge the contributions Done by People serving with the Gospel Ministry in making sure The Gospel Of Jesus Christ spreads in Tanzania and beyond .\r\n\r\nThe Award Ceremony is prepared and organized by United Zion One and Tanzania Gospel Musicians Institution (CHAMWITA)\r\n\r\n&quot;GLOBAL REJOICE GOSPEL AWARDS , FOR GOD AND NATIONS&quot;.'),
(5, '2021-10-06 12:35:59', 3, 'Game or Competition', 'New renovated universal dancing competion', 'Jamhuri stadium, Dodoma', '2021-10-15 10:00:00', '2021-10-09 22:00:00', 5000, 30000, 'assets/imgs/events_pictures/5.jpg', 'World of Dance is an American reality competition television series executive produced by Jennifer Lopez. The first two seasons were hosted by Jenna Dewan. The third season saw a change in hosts, as Scott Evans hosted season three and four.[1] The series features dance performers, including solo acts and larger groups, representing any style of dance, competing for a grand prize of $1 million.[2] The contestants are scored by judges Jennifer Lopez, Ne-Yo, and Derek Hough.\r\n\r\nThe series was created in partnership with the World of Dance enterprise, which produces dance competitions and dance lifestyle events in more than 25 countries, spanning the U.S., Europe, South America, and Asia. Videos captured from these events have driven more than 1 billion views online.\r\n\r\nThe series premiered on NBC on May 30, 2017. The fourth season premiered on May 26, 2020.[3]\r\n\r\nIn March 2021, the series was canceled after four seasons.\r\n\r\n\r\nSeason 2\r\n\r\nWhile the format for season two remained relatively unchanged, there were a few slight alterations. Season 2 received a 16-episode order,[5] six more than the ten-episode first season. Additionally, this season, a fourth category, Junior Team, was added for acts under 18 with 5 or more members. The qualifier rounds are cut down from a two minutes to a one-minute routine. The Duels routines are cut down from two minutes to 75 seconds. The top three highest-scoring acts in The Cut from each division will move on to The Divisional Final, in season one it was just the top two. The Cut, Divisional and World Final rounds are cut down from a two minutes to a &#039;90 seconds&#039;-routine. In The Cut and Divisional Final guest celebrities are assigned as mentors to each division. On World Final there are intermezzo shows. Season two by Les Twins, Keone &amp; Mari (actually Mariel) Madrid, Kinjaz and Derek Hough.\r\n\r\n\r\nOriginal host Jenna Dewan left after the conclusion of season two which left the position open. Access Live co-host, Scott Evans took over as host in the third season. The required qualifier score to enter the duels increased from 80 to 85. The duels feature a redemption round where the Top 2 eliminated acts (in each division) with the highest score compete head to head for a second chance to advance to The Cuts. In the redemption, the 2 acts compete back to back to the same music. Afterwards, the judges vote to decide which act will advance.\r\n\r\nIn the Divisional Final, the judges pick one more act to advance to the World Final as a wild card.[6] In the World Final, each act performs once instead of twice.\r\n\r\nThe guest judge is removed this season.');

-- --------------------------------------------------------

--
-- Table structure for table `event_mates`
--

CREATE TABLE `event_mates` (
  `id` int(11) NOT NULL,
  `forumId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_mates`
--

INSERT INTO `event_mates` (`id`, `forumId`, `userId`) VALUES
(11, 1, 4),
(22, 1, 3),
(24, 3, 1),
(31, 2, 3),
(32, 4, 3),
(33, 3, 3),
(34, 4, 4),
(35, 5, 4),
(36, 3, 4),
(37, 2, 4),
(38, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_tags`
--

CREATE TABLE `event_tags` (
  `tag_id` int(11) NOT NULL,
  `tagdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `eventId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `status` varchar(6) NOT NULL DEFAULT 'Unread'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_tags`
--

INSERT INTO `event_tags` (`tag_id`, `tagdate`, `eventId`, `userId`, `status`) VALUES
(2, '2021-10-06 15:07:51', 5, 2, 'Unread'),
(3, '2021-10-06 15:07:51', 5, 4, 'Unread'),
(4, '2021-10-06 15:07:51', 5, 1, 'Read');

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE `forums` (
  `forumId` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  `hostId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forums`
--

INSERT INTO `forums` (`forumId`, `eventId`, `hostId`) VALUES
(1, 2, 2),
(2, 1, 1),
(3, 3, 2),
(4, 4, 1),
(5, 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `invitation`
--

CREATE TABLE `invitation` (
  `ivitesId` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  `receiverId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `messageId` int(11) NOT NULL,
  `forumId` int(11) NOT NULL,
  `postDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userId` int(11) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`messageId`, `forumId`, `postDate`, `userId`, `message`) VALUES
(1, 1, '2021-10-01 12:35:32', 1, 'Niaje wazee wa traditional songs'),
(2, 1, '2021-10-01 12:36:24', 4, 'Oy inakuaje'),
(3, 1, '2021-10-01 12:36:46', 2, 'Naona mna moto sio poa'),
(4, 1, '2021-10-01 12:37:11', 2, 'Karibuni nyote itakuwa bonge paaarty'),
(5, 2, '2021-10-01 12:45:36', 1, 'Everybody say yeeeeeeeaaaaaaaaaaaaaaa'),
(6, 2, '2021-10-01 12:45:54', 4, 'Yeaaaaaaaaaaaaaaa'),
(7, 2, '2021-10-01 12:46:13', 2, 'Mbna mna moto saaaaan'),
(8, 2, '2021-10-01 12:46:37', 4, 'Vp lakin msosi upoo?'),
(9, 2, '2021-10-01 12:53:07', 1, 'Msosi uhakika yan'),
(10, 2, '2021-10-01 12:53:19', 1, 'Ama nene'),
(11, 1, '2021-10-01 13:10:28', 1, 'Tunakujaaaaaaaa'),
(12, 2, '2021-10-01 13:10:44', 2, 'Nami nakujaaaaaaaaaaaa'),
(13, 1, '2021-10-01 13:11:22', 4, 'Namimi mniesabu nitakuwepoooooo'),
(14, 1, '2021-10-01 13:18:44', 1, 'hey'),
(15, 1, '2021-10-01 13:19:50', 2, 'oy wazee'),
(16, 1, '2021-10-01 14:43:25', 4, 'Ooooooooooy'),
(17, 1, '2021-10-01 14:43:39', 1, 'Nambie mazeeeeee'),
(18, 1, '2021-10-01 14:43:54', 4, 'Oy fidon unazngua'),
(19, 1, '2021-10-01 14:45:40', 2, 'inakuaje wazeeeeee'),
(23, 1, '2021-10-06 12:25:09', 3, 'Oy niaje wadau'),
(28, 2, '2021-10-12 07:54:57', 1, 'usije');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `requestId` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` int(11) NOT NULL,
  `regDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userType` int(1) NOT NULL,
  `fname` varchar(32) NOT NULL,
  `lname` varchar(32) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `address` text NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `bio` text NOT NULL,
  `picture` text,
  `password` varchar(75) NOT NULL,
  `tag` varchar(3) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `regDate`, `userType`, `fname`, `lname`, `gender`, `address`, `mobile`, `email`, `bio`, `picture`, `password`, `tag`) VALUES
(1, '2021-09-27 12:23:26', 1, 'Fidon', 'Takakwa', 'M', 'Dodoma, Sabasaba', '0713529019', 'fidonamos@gmail.com', 'Student at UDOM | BSc in computer', 'assets/imgs/profile_pictures/1.jpg', '$2y$10$2LW5KDtxv3LTVlx0QYXcD.X.ZSuzq7YXGlgmFpMYr5fDDvpKhSA9i', 'No'),
(2, '2021-09-28 11:22:55', 2, 'Tudumishe music group', NULL, NULL, 'Makulu dodoma', '0757645342', 'tupendane@gmail.com', 'We&#039;re group of musicians specialized in traditional songs.', 'assets/imgs/profile_pictures/2.jpg', '$2y$10$a5IHDr66zMKwM8Q.4Wbws.i05JEm8LRjzvTUSRAWsEiEfpW3jiXya', 'No'),
(3, '2021-09-30 07:11:29', 1, 'Fadhili', 'Masudi', 'M', 'dar es salaam', '0653565159', 'fadhilimansoor54@gmail.com', 'hey there am using findmate ', 'assets/imgs/profile_pictures/default_m.png', '$2y$10$htfI7gMdaDkwKBxyy4T90.JmTMZdbEishS7V/AJ6AjtN2cGXU9rJ6', 'No'),
(4, '2021-09-30 07:18:25', 1, 'Selafina', 'Mahawi', 'F', 'morogoro,malinyi', '0785065274', 'finahchurchgirl2014@gmail', 'Am at kilosa i want to go Mikumi National Park i need somebody to join me.', 'assets/imgs/profile_pictures/4.jpg', '$2y$10$muo6iPPCQOdukBMp5ahoyOF.NHk3I3tVfawnkGCxOFLbta65jAQTO', 'No');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eventcategory`
--
ALTER TABLE `eventcategory`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`eventId`);

--
-- Indexes for table `event_mates`
--
ALTER TABLE `event_mates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_tags`
--
ALTER TABLE `event_tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`forumId`);

--
-- Indexes for table `invitation`
--
ALTER TABLE `invitation`
  ADD PRIMARY KEY (`ivitesId`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageId`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`requestId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eventcategory`
--
ALTER TABLE `eventcategory`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `eventId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event_mates`
--
ALTER TABLE `event_mates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `event_tags`
--
ALTER TABLE `event_tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `forums`
--
ALTER TABLE `forums`
  MODIFY `forumId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invitation`
--
ALTER TABLE `invitation`
  MODIFY `ivitesId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `messageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `requestId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
