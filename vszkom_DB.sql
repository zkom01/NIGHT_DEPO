-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Počítač: 172.17.0.1:3306
-- Vytvořeno: Pon 04. kvě 2026, 22:25
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
-- Databáze: `vszkom_DB`
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
(1, 'Katedra strategického managementu (KSM)'),
(2, 'Institut interpersonální komunikace (IIK)'),
(3, 'Fakulta digitálního marketingu (FDM)'),
(4, 'Kolej organizační psychologie (KOP)'),
(5, 'Katedra krizového řízení (KKR)'),
(6, 'Ústav mediálních studií (UMS)'),
(7, 'Fakulta projektového vedení (FPV)'),
(8, 'Kolej rétoriky a vyjednávání (KRV)'),
(9, 'Katedra lidských zdrojů (KLZ)'),
(10, 'Institut firemní kultury (IFK)'),
(11, 'Fakulta datové analytiky v obchodu (FDAO)'),
(12, 'Katedra etiky v podnikání (KEP)');

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
(4, 1, 'IMG_69f2932a73c3d3.34897208.png'),
(5, 1, 'IMG_69f2941dc1c271.50034637.png');

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
(1, 'Jakub', 'Svoboda', 22, 'Expert na krizovou komunikaci a PR strategie.', 3),
(2, 'Tereza', 'Novotná', 19, 'Specialistka na datovou analytiku a SQL reporting.', 6),
(3, 'Lukáš', 'Dvořák', 26, 'Projektový manažer se zaměřením na agilní metodiky.', 11),
(4, 'Martin', 'Černý', 23, 'Analytik trhu a expert na konkurenční strategie.', 11),
(5, 'Jan', 'Kučera', 26, 'Specialista na firemní kulturu a interní procesy.', 1),
(6, 'Alena', 'Veselá', 20, 'Kreativní copywriterka a mediální analytička.', 4),
(7, 'Eliška', 'Krejčí', 20, 'Lídr týmu se zkušenostmi v neziskovém sektoru.', 4),
(8, 'Filip', 'Marek', 21, 'Expert na logistiku a řízení dodavatelských řetězců.', 10),
(9, 'Lucie', 'Blažková', 20, 'Tlumočnice a specialistka na mezinárodní obchod.', 1),
(10, 'Karolína', 'Králová', 25, 'HR manažerka se zaměřením na nábor talentů.', 12),
(11, 'Marek', 'Beneš', 25, 'Inovátor v oblasti digitálního marketingu a SEO.', 7),
(12, 'Jiří', 'Horák', 20, 'Specialista na event management a networking.', 9),
(13, 'Štěpán', 'Němec', 23, 'Analytik rizik v bankovním sektoru.', 1),
(14, 'David', 'Pospíšil', 23, 'UX/UI designér se zaměřením na psychologii uživatele.', 2),
(15, 'Adéla', 'Pokorná', 19, 'Koordinátorka vzdělávacích kurzů pro management.', 4),
(16, 'Petra', 'Háková', 21, 'Statistička se zájmem o prediktivní modelování.', 4),
(17, 'Veronika', 'Jelínková', 23, 'Konzultantka v oblasti společenské odpovědnosti firem.', 7),
(18, 'Zuzana', 'Růžičková', 24, 'Účetní auditorka s certifikací pro mezinárodní standardy.', 10),
(19, 'Matěj', 'Zeman', 19, 'Specialista na e-commerce a prodejní kanály.', 6),
(20, 'Hana', 'Kolářová', 19, 'Mediátorka konfliktů v pracovním prostředí.', 12),
(21, 'Pavel', 'Urban', 20, 'Právní asistent se zaměřením na obchodní právo.', 3),
(22, 'Tomáš', 'Kratochvíl', 22, 'Tester softwarových řešení pro správu dat.', 3),
(23, 'Adam', 'Čermák', 19, 'Ekonomický analytik a specialista na makrotrendy.', 7),
(24, 'Michal', 'Liška', 26, 'Obchodní zástupce s vynikajícími výsledky v B2B.', 11),
(25, 'Robert', 'Navrátil', 24, 'Strategický nákupčí pro technologické korporace.', 11),
(26, 'Monika', 'Šimková', 21, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 9),
(27, 'Petr', 'Konečný', 24, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 12),
(28, 'Václav', 'Malý', 21, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 10),
(29, 'Kryštof', 'Holub', 25, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 11),
(30, 'Dominik', 'Staněk', 24, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 3),
(31, 'Ondřej', 'Doležal', 21, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 5),
(32, 'Barbora', 'Štěpánková', 22, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 1),
(33, 'Kateřina', 'Kadlecová', 21, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 4),
(34, 'Jana', 'Fialová', 26, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 5),
(35, 'Richard', 'Sedláček', 26, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 12),
(36, 'Patrik', 'Vávra', 20, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 9),
(37, 'Tobiáš', 'Tůma', 24, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 6),
(38, 'Šimon', 'Bláha', 26, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 5),
(39, 'Vít', 'Švec', 22, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 8),
(40, 'Lenka', 'Procházková', 24, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 9),
(41, 'Denisa', 'Machová', 26, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 10),
(42, 'Jakub', 'Kalous', 24, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 8),
(43, 'Marian', 'Kopecký', 22, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 12),
(44, 'Kristián', 'Beran', 20, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 12),
(45, 'Sára', 'Soukupová', 22, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 11),
(46, 'Nikolas', 'Dušek', 25, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 7),
(47, 'Elena', 'Hrušková', 23, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 12),
(48, 'Klára', 'Tichá', 22, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 4),
(49, 'Erik', 'Vlček', 24, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 8),
(50, 'Beáta', 'Nováková', 19, 'Student zaměřený na moderní management a rozvoj měkkých dovedností.', 3),
(55, 'Harry', 'Potter', 8512, 'dwfesvdfcg', 8),
(56, 'Draco', 'Malfoy', 852, 'wdfesgyrdxtfgc', 1);

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
  `role` enum('user','admin','super_admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `user`
--

INSERT INTO `user` (`id`, `first_name`, `second_name`, `email`, `heslo`, `role`) VALUES
(1, 'Zdeněk', 'Komárek ', 'zkom@zkom.cz', '$2y$12$5azNgLarF/.Bm8lUNpeVFuTbV57BF0hxZzcfVcbWZFp3DnW2kM9O.', 'super_admin'),
(2, 'Eda', 'Eda', 'edzk@seznam.cz', '$2y$12$5Tx1vaG6/Vt2WOrqV3vYleqBVMmYqAlNvtA84qxvu4UPacSGcZDui', 'admin');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pro tabulku `image`
--
ALTER TABLE `image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pro tabulku `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT pro tabulku `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
