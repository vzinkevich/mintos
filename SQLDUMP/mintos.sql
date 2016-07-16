-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2016 at 12:36 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mintos`
--

CREATE DATABASE IF NOT EXISTS `mintos`;
-- --------------------------------------------------------

--
-- Table structure for table `investment`
--

CREATE TABLE `mintos`.`investment` (
  `id` int(11) NOT NULL,
  `investor_key` int(11) NOT NULL,
  `loan_key` int(11) NOT NULL,
  `amount` double NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `investment`
--

INSERT INTO `mintos`.`investment` (`id`, `investor_key`, `loan_key`, `amount`) VALUES
(1, 3, 4, 1),
(2, 3, 1, 12),
(3, 3, 2, 2),
(4, 1, 3, 20),
(5, 1, 2, 12.5),
(6, 1, 1, 9),
(7, 1, 4, 14.24);

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `mintos`.`loan` (
  `id` int(11) NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `available_for_investments` double NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `loan`
--

INSERT INTO `mintos`.`loan` (`id`, `amount`, `available_for_investments`) VALUES
(1, 1000, 979),
(2, 1000, 985.5),
(3, 100, 80),
(4, 33333, 33317.76);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `mintos`.`user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_general_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `moneyAvailable` double DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `mintos`.`user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `moneyAvailable`) VALUES
(1, 'qweqwe', 'qweqwe', 'qweqwe@qweqwe.ee', 'qweqwe@qweqwe.ee', 1, 'eaxgi492f2g400o44ssc08g0ckkwosg', '$2y$13$edKUrjWxdpzm.VCIhFbYL.xYN7VTI64nxHZhnZY8dHchNgmwvWy2S', '2016-07-16 12:29:44', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 36.16),
(2, 'asdasd', 'asdasd', 'zasd@qwe.gfh', 'zasd@qwe.gfh', 1, 'dbltv8qk7lwk4gs8o8cwwckgs0swwks', '$2y$13$nuBtOPicsXMyvh7APZe4LeWutRfLN0mICuQM09FoYjB6RZtIPGiCW', '2016-07-15 22:26:50', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 100),
(3, 'aaa', 'aaa', 'sdfsdf@qwe.lb', 'sdfsdf@qwe.lb', 1, 'ba38p5ehy144oswo80oow4wk8ocgkkw', '$2y$13$VKInBplj3Coja./Xnmj9Meh8pLzdTvvrRJGWG8n5MfNePsaaTFUye', '2016-07-16 12:19:55', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 5),
(4, 'zxczxc', 'zxczxc', 'asdad@asd.tt', 'asdad@asd.tt', 1, '9vbq6tp0wvksswogkw40o888w8kosss', '$2y$13$uCrzgvVMC.Ccs1QxT4YfY.26sVdLEPpLQELDvqnWb8sfsYbNZ7.yG', '2016-07-16 01:49:30', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 45),
(5, 'erer', 'erer', 'asdad@asd.ttee', 'asdad@asd.ttee', 1, '5rggmb4kty80o44ggs84cs8ww8kwcsk', '$2y$13$BqxSBP0xuc6iT225xo2hQ.zkegPWznbWkR5mN8g.EMdXdl6BNFkuO', '2016-07-16 01:51:30', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 1000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `investment`
--
ALTER TABLE `mintos`.`investment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investor` (`investor_key`),
  ADD KEY `loan` (`loan_key`);

--
-- Indexes for table `loan`
--
ALTER TABLE `mintos`.`loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `mintos`.`user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `investment`
--
ALTER TABLE `mintos`.`investment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `mintos`.`loan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `mintos`.`user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
