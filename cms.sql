-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2022. Sze 20. 20:13
-- Kiszolgáló verziója: 10.4.24-MariaDB
-- PHP verzió: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `cms`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `data`
--

CREATE TABLE `data` (
  `key` varchar(16) NOT NULL,
  `value` mediumtext NOT NULL,
  `pageid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `data`
--

INSERT INTO `data` (`key`, `value`, `pageid`) VALUES
('ADAT', 'Ez egy adat', 2),
('AUTHOR', 'Kis Balázs', 1),
('CONTACTDATA', 'MŰKÖDIK!!!!', 6);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `user` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `login`
--

INSERT INTO `login` (`id`, `user`, `password`) VALUES
(1, 'root', '0fd90bcc17275c68bb01c53fd52d5e754410b367a387d5a20f8a29c7d3530bec');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `url` varchar(32) NOT NULL,
  `title` varchar(32) NOT NULL DEFAULT 'Cím',
  `parent` int(11) DEFAULT NULL,
  `template` varchar(128) NOT NULL DEFAULT 'index.html',
  `class` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `page`
--

INSERT INTO `page` (`id`, `url`, `title`, `parent`, `template`, `class`) VALUES
(1, ' ', 'CMS Index', NULL, 'index.html', 'IndexPage'),
(2, 'about', 'Rólunk', 1, 'about.html', NULL),
(3, 'admin', 'Admin oldal', NULL, 'admin.html', 'AdminPage'),
(4, 'adminlogin', 'Belépés az admin felületre', 3, 'login.html', 'LoginPage'),
(5, 'admindata', 'Adatok adminisztrálása', 3, 'data.html', 'DataPage'),
(6, 'contact', 'Kapcsolat', 1, 'contact.html', NULL);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`key`),
  ADD KEY `DATA_PAGE_FK` (`pageid`);

--
-- A tábla indexei `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`);

--
-- A tábla indexei `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`),
  ADD KEY `PAGE_PAGE_PARENT_FK` (`parent`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `DATA_PAGE_FK` FOREIGN KEY (`pageid`) REFERENCES `page` (`id`);

--
-- Megkötések a táblához `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `PAGE_PAGE_PARENT_FK` FOREIGN KEY (`parent`) REFERENCES `page` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
