-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Počítač: 172.17.0.1:3306
-- Vytvořeno: Čtv 23. dub 2026, 22:51
-- Verze serveru: 11.4.10-MariaDB-ubu2204-log
-- Verze PHP: 8.3.26 

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `DB_night_depo`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `college`
--

CREATE TABLE `college` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `college`
--

INSERT INTO `college` (`id`, `name`) VALUES
(1, 'Nebelvír'),
(2, 'Zmijozel'),
(3, 'Havraspár'),
(4, 'Mrzimor'),
(5, 'Krásnohůlky'),
(6, 'Kruval'),
(7, 'Hornatý had'),
(8, 'Pukwudgie'),
(9, 'Mahoutokoro'),
(10, 'Uagadou'),
(11, 'Kastelobruxo');

-- --------------------------------------------------------

--
-- Struktura tabulky `image`
--

CREATE TABLE `image` (
  `image_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `image`
--

INSERT INTO `image` (`image_id`, `user_id`, `image_name`) VALUES
(1, 1, 'IMG_69ea84176eaba4.37427349.png');

-- --------------------------------------------------------

--
-- Struktura tabulky `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `second_name` varchar(60) NOT NULL,
  `age` int(11) NOT NULL,
  `life` text DEFAULT NULL,
  `college_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `student`
--

INSERT INTO `student` (`id`, `first_name`, `second_name`, `age`, `life`, `college_id`) VALUES
(1, 'Harry', 'Potter', 11, 'Chlapec, který přežil.', 1),
(2, 'Hermiona', 'Grangerová', 12, 'Nejchytřejší čarodějka svého věku.', 1),
(3, 'Ron', 'Weasley', 11, 'Věrný kamarád a milovník šachu.', 1),
(4, 'Draco', 'Malfoy', 12, 'Ambiciózní student ze Zmijozelu.', 2),
(5, 'Neville', 'Longbottom', 11, 'Nenápadný hrdina s velkým srdcem.', 1),
(6, 'Luna', 'Láskorádová', 13, 'Snílek, který vidí věci jinak.', 3),
(7, 'Ginny', 'Weasleyová', 10, 'Odvážná a talentovaná čarodějka.', 1),
(8, 'Cedric', 'Diggory', 14, 'Spravedlivý reprezentant Mrzimoru.', 1),
(9, 'Cho', 'Changová', 13, 'Hráčka famfrpálu za Havraspár.', 3),
(10, 'Pansy', 'Parkinsonová', 12, 'Věrná společnice Draca Malfoye.', 2),
(11, 'George', 'Weasley', 14, 'Vtipálek a milovník žertíků.', 1),
(12, 'Fred', 'Weasley', 14, 'Dvojče George, mistr zábavy.', 1),
(13, 'Seamus', 'Finnigan', 11, 'Specialista na explozivní kouzla.', 1),
(14, 'Dean', 'Thomas', 11, 'Velký fanoušek famfrpálu.', 1),
(15, 'Parvati', 'Patilová', 12, 'Sestra Padmy, ráda tančí.', 1),
(16, 'Padma', 'Patilová', 12, 'Pilná studentka Havraspáru.', 3),
(17, 'Lavender', 'Brownová', 12, 'Milovnice věštění z čajových lístků.', 1),
(18, 'Susan', 'Bonesová', 11, 'Nenápadná, ale pilná studentka.', 4),
(19, 'Justin', 'Finch-Fletchley', 11, 'Student z mudlovské rodiny.', 4),
(20, 'Hannah', 'Abbottová', 11, 'Přátelská studentka Mrzimoru.', 1),
(21, 'Ernie', 'Macmillan', 11, 'Velmi hrdý student Mrzimoru.', 4),
(22, 'Terry', 'Boot', 12, 'Zvědavý student Havraspáru.', 3),
(23, 'Anthony', 'Goldstein', 12, 'Rozvážný student Havraspáru.', 3),
(24, 'Michael', 'Corner', 12, 'Sportovně založený student.', 3),
(25, 'Blaise', 'Zabini', 12, 'Elegantní student ze Zmijozelu.', 2),
(26, 'Millicent', 'Bulstrodeová', 12, 'Silná a odhodlaná studentka.', 2),
(27, 'Gregory', 'Goyle', 12, 'Silák a pomocník Malfoye.', 2),
(28, 'Vincent', 'Crabbe', 12, 'Hrubý silák ze Zmijozelu.', 2),
(29, 'Colin', 'Creevey', 10, 'Velký obdivovatel Harryho Pottera.', 1),
(30, 'Dennis', 'Creevey', 10, 'Mladší bratr Colina.', 1),
(31, 'Oliver', 'Wood', 15, 'Kapitán nebelvírského týmu.', 1),
(32, 'Angelina', 'Johnsonová', 14, 'Rychlá střelkyně famfrpálu.', 1),
(33, 'Katie', 'Bellová', 13, 'Talentovaná hráčka famfrpálu.', 1),
(34, 'Alicia', 'Spinnetová', 14, 'Zkušená hráčka týmu.', 1),
(35, 'Marcus', 'Flint', 15, 'Kapitán zmijozelského týmu.', 2),
(36, 'Adrian', 'Pucey', 14, 'Hráč famfrpálu za Zmijozel.', 2),
(37, 'Terence', 'Higgs', 14, 'Chytač zmijozelského týmu.', 2),
(38, 'Roger', 'Davies', 15, 'Kapitán havraspárského týmu.', 3),
(39, 'Zacharias', 'Smith', 13, 'Namyšlený student Mrzimoru.', 4),
(40, 'Leanne', 'Smithová', 13, 'Kamarádka Katie Bellové.', 1),
(41, 'Demelza', 'Robinsová', 13, 'Hráčka nebelvírského týmu.', 1),
(42, 'Jimmy', 'Peakes', 12, 'Odrážeč v nebelvírském týmu.', 1),
(43, 'Ritchie', 'Coote', 12, 'Druhý odrážeč nebelvírského týmu.', 1),
(44, 'Cormac', 'McLaggen', 15, 'Arogantní brankář Nebelvíru.', 1),
(45, 'Romilda', 'Vaneová', 13, 'Fanynka, která se zajímá o Harryho.', 1),
(46, 'Nigel', 'Wolpert', 11, 'Mladý a aktivní student.', 1),
(47, 'Eloise', 'Midgenová', 12, 'Studentka s komplexem z pleti.', 3),
(48, 'Leanne', 'Bellová', 12, 'Spolužačka z nižších ročníků.', 1),
(49, 'Euan', 'Abercrombie', 11, 'Vystrašený student prvního ročníku.', 1),
(50, 'Orla', 'Quirkeová', 11, 'Studentka první ročníku.', 3),
(51, 'aaa', 'aaa', 55, 'aaaa', 11);

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `second_name` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `heslo` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `user`
--

INSERT INTO `user` (`id`, `first_name`, `second_name`, `email`, `heslo`, `role`) VALUES
(1, 'Eda', 'Eda', 'komarek.zdenek@seznam.cz', '$2y$12$BjuDLclNqZ09mlVEEtS5CedFfloVlTo2g8Mq9sOJiAR2ttRx2qsZG', 'admin'),
(2, 'eda', 'user', 'edzk@seznam.cz', '$2y$12$UKUi4Phan8WT/utlnVHjMes.X8UAcKYA8oAbBpM35TE1xxMozZeyC', 'user');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `college`
--
ALTER TABLE `college`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `FK_ImageUser` (`user_id`);

--
-- Indexy pro tabulku `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_StudentCollege` (`college_id`);

--
-- Indexy pro tabulku `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `college`
--
ALTER TABLE `college`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pro tabulku `image`
--
ALTER TABLE `image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT pro tabulku `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT pro tabulku `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_ImageUser` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK_StudentCollege` FOREIGN KEY (`college_id`) REFERENCES `college` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
