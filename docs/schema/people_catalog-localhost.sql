-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 15 Lip 2017, 18:49
-- Wersja serwera: 10.1.21-MariaDB
-- Wersja PHP: 7.1.1

--
-- pauluZ Export (config)
--
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `people_catalog`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cat_city`
--

CREATE TABLE `cat_city` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cat_company`
--

CREATE TABLE `cat_company` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cat_company_office`
--

CREATE TABLE `cat_company_office` (
  `id` int(11) NOT NULL,
  `cat_company_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cat_person`
--

CREATE TABLE `cat_person` (
  `id` int(11) NOT NULL,
  `cat_city_id` int(11) DEFAULT NULL,
  `cat_company_office_id` int(11) DEFAULT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `birth` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `cat_city`
--
ALTER TABLE `cat_city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cat_company`
--
ALTER TABLE `cat_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cat_company_office`
--
ALTER TABLE `cat_company_office`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_company_id` (`cat_company_id`);

--
-- Indexes for table `cat_person`
--
ALTER TABLE `cat_person`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_city_id` (`cat_city_id`),
  ADD KEY `cat_company_office_id` (`cat_company_office_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `cat_city`
--
ALTER TABLE `cat_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `cat_company`
--
ALTER TABLE `cat_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `cat_company_office`
--
ALTER TABLE `cat_company_office`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `cat_person`
--
ALTER TABLE `cat_person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `cat_company_office`
--
ALTER TABLE `cat_company_office`
  ADD CONSTRAINT `FK_D726E8B34A793127` FOREIGN KEY (`cat_company_id`) REFERENCES `cat_company` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `cat_person`
--
ALTER TABLE `cat_person`
  ADD CONSTRAINT `FK_EADB3403AB1DE0F9` FOREIGN KEY (`cat_city_id`) REFERENCES `cat_city` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_EADB3403E5F379B7` FOREIGN KEY (`cat_company_office_id`) REFERENCES `cat_company_office` (`id`) ON DELETE SET NULL;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
