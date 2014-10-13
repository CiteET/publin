-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Oct 10, 2014 at 12:51 AM
-- Server version: 5.5.38
-- PHP Version: 5.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `list_authors`
--

CREATE TABLE `list_authors` (
`id` int(11) unsigned NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `academic_title` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `webpage` text COLLATE utf8_bin,
  `contact` text COLLATE utf8_bin,
  `text` text COLLATE utf8_bin
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Dumping data for table `list_authors`
--

INSERT INTO `list_authors` (`id`, `user_id`, `last_name`, `first_name`, `academic_title`, `webpage`, `contact`, `text`) VALUES
(1, 4, 'Doof', 'Hans', 'Dr.', 'www.google.de', '00815/3334402', 'Hier könnte meine Biografie oder anderes stehen, wenn ich nicht ein so unglaublich fauler Doktor wäre.'),
(2, NULL, 'Dumm', 'Fritz', 'Prof. Dr.', NULL, NULL, NULL),
(3, NULL, 'Dämlich', 'Gerhard', '', NULL, NULL, NULL),
(4, 5, 'Mustermann', 'Max', 'Dr.', 'www.mustermann.de', '00815/40923', 'Ich muss immer als Beispiel für alles dienen.'),
(5, NULL, 'Schmidt', 'Fritz', 'Dr. PhD', 'www.fritz.de', NULL, 'Ich hab so eine tolle Biographie, die verrate ich euch gar nicht.');

-- --------------------------------------------------------

--
-- Table structure for table `list_key_terms`
--

CREATE TABLE `list_key_terms` (
`id` int(11) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=8 ;

--
-- Dumping data for table `list_key_terms`
--

INSERT INTO `list_key_terms` (`id`, `name`) VALUES
(1, 'Semantic Web'),
(2, 'Sensor Networks'),
(3, 'Nonsense'),
(4, 'E-Commerce'),
(5, 'Testing'),
(6, '3D Architecture'),
(7, 'Biography');

-- --------------------------------------------------------

--
-- Table structure for table `list_publications`
--

CREATE TABLE `list_publications` (
`id` int(11) unsigned NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `study_field_id` int(11) DEFAULT NULL,
  `title` text COLLATE utf8_bin,
  `abstract` text COLLATE utf8_bin,
  `year` int(4) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='authors and key terms can be found in other tables, joined by rel_... tables' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `list_publications`
--

INSERT INTO `list_publications` (`id`, `type_id`, `study_field_id`, `title`, `abstract`, `year`, `month`, `date_added`) VALUES
(2, 2, 3, 'Die unendlich unglaubliche Geschichte des Dr. Doof', 'Eine Geschichte über das Leben des Dr. Doof, der ein sehr ereignisreiches Leben hatte. Um mehr darüber zu erfahren, muss das Buch jedoch gekauft werden, denn mehr Text für den Abstract fällt mir gerade leider nicht ein.', 2014, 5, '2014-10-07 20:51:08'),
(3, 6, 1, 'Perspektivische Tests in einer Testumgebung - perspektivisch betrachtet.', 'Ganz ehrlich, wer erwartet hier einen sinnvollen Abstract? Das sind Testdaten! Da war ich sogar zu faul die auf Englisch zu übersetzen. Ja, unglaublich gute Arbeitsmoral, ich weiß.', 2012, 3, '2014-10-07 20:51:15'),
(4, 1, 2, 'Ausnahmsweise mal ein kurzer TItel', 'Hier gibt es keinen Abstract!', 2012, 5, '2014-10-07 21:08:36'),
(5, 1, 1, 'Computer und ihre Bedeutung für den Bauchnabel', 'Computer sind etwas faszinierendes. Bauchnabel erstmal nicht so. Aber vielleicht liegen die Details im Verborgenen? DIese Arbeit widmet sich der Bedeutung von Computern für unsere Bauchnabel.', 2013, 1, '2014-10-07 22:25:43');

-- --------------------------------------------------------

--
-- Table structure for table `list_references`
--

CREATE TABLE `list_references` (
`id` int(11) unsigned NOT NULL,
  `text` text COLLATE utf8_bin,
  `publication_id` int(11) DEFAULT NULL,
  `external_url` text COLLATE utf8_bin
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `list_references`
--

INSERT INTO `list_references` (`id`, `text`, `publication_id`, `external_url`) VALUES
(1, 'Referenz auf vorhandene Arbeit', 2, NULL),
(2, 'Referenz auf externe Arbeit', NULL, 'www.externe-arbeit.de');

-- --------------------------------------------------------

--
-- Table structure for table `list_study_fields`
--

CREATE TABLE `list_study_fields` (
`id` int(11) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='contains a list of all known study fields' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `list_study_fields`
--

INSERT INTO `list_study_fields` (`id`, `name`) VALUES
(1, 'Informatik'),
(2, 'Medizin'),
(3, 'Geschichte');

-- --------------------------------------------------------

--
-- Table structure for table `list_types`
--

CREATE TABLE `list_types` (
`id` int(11) unsigned NOT NULL,
  `name` varchar(20) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10 ;

--
-- Dumping data for table `list_types`
--

INSERT INTO `list_types` (`id`, `name`) VALUES
(1, 'article'),
(2, 'book'),
(3, 'inproceedings'),
(4, 'incollection'),
(5, 'techreport'),
(6, 'masterthesis'),
(7, 'phdthesis'),
(8, 'unpublished'),
(9, 'misc');

-- --------------------------------------------------------

--
-- Table structure for table `list_users`
--

CREATE TABLE `list_users` (
`id` int(11) unsigned NOT NULL,
  `name` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `admin` tinyint(1) DEFAULT '0',
  `mail` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `date_register` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='contains a list of all registered users' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `list_users`
--

INSERT INTO `list_users` (`id`, `name`, `admin`, `mail`, `date_register`, `date_last_login`) VALUES
(1, 'Arne', 1, 'lol@web.de', '2014-09-16 23:52:58', NULL),
(2, 'Hannes', 0, 'hannes@lol.de', '2014-09-16 23:53:18', NULL),
(3, 'Björn', 0, 'kohl@lol.de', '2014-09-16 23:55:31', NULL),
(4, 'Doofi', 0, 'doofi@google.de', '2014-10-07 16:28:26', '2014-10-07 16:28:26'),
(5, 'mäxx', 0, 'admin@mustermann.de', '2014-10-07 17:52:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rel_publ_to_authors`
--

CREATE TABLE `rel_publ_to_authors` (
`id` int(11) unsigned NOT NULL,
  `publication_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='joins the authors to a publication' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `rel_publ_to_authors`
--

INSERT INTO `rel_publ_to_authors` (`id`, `publication_id`, `author_id`, `priority`) VALUES
(1, 2, 1, 1),
(2, 2, 2, 3),
(3, 2, 3, 2),
(4, 3, 4, 1),
(5, 3, 1, 2),
(6, 5, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rel_publ_to_key_terms`
--

CREATE TABLE `rel_publ_to_key_terms` (
`id` int(11) unsigned NOT NULL,
  `publication_id` int(11) DEFAULT NULL,
  `key_term_id` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='joins the key terms to a publication' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `rel_publ_to_key_terms`
--

INSERT INTO `rel_publ_to_key_terms` (`id`, `publication_id`, `key_term_id`) VALUES
(1, 3, 6),
(2, 3, 3),
(3, 2, 3),
(5, 5, 5),
(6, 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `rel_publ_to_references`
--

CREATE TABLE `rel_publ_to_references` (
`id` int(11) unsigned NOT NULL,
  `publication_id` int(11) DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rel_publ_to_references`
--

INSERT INTO `rel_publ_to_references` (`id`, `publication_id`, `reference_id`) VALUES
(1, 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `list_authors`
--
ALTER TABLE `list_authors`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_key_terms`
--
ALTER TABLE `list_key_terms`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_publications`
--
ALTER TABLE `list_publications`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_references`
--
ALTER TABLE `list_references`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_study_fields`
--
ALTER TABLE `list_study_fields`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_types`
--
ALTER TABLE `list_types`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_users`
--
ALTER TABLE `list_users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rel_publ_to_authors`
--
ALTER TABLE `rel_publ_to_authors`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rel_publ_to_key_terms`
--
ALTER TABLE `rel_publ_to_key_terms`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rel_publ_to_references`
--
ALTER TABLE `rel_publ_to_references`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `list_authors`
--
ALTER TABLE `list_authors`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `list_key_terms`
--
ALTER TABLE `list_key_terms`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `list_publications`
--
ALTER TABLE `list_publications`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `list_references`
--
ALTER TABLE `list_references`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `list_study_fields`
--
ALTER TABLE `list_study_fields`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `list_types`
--
ALTER TABLE `list_types`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `list_users`
--
ALTER TABLE `list_users`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `rel_publ_to_authors`
--
ALTER TABLE `rel_publ_to_authors`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `rel_publ_to_key_terms`
--
ALTER TABLE `rel_publ_to_key_terms`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `rel_publ_to_references`
--
ALTER TABLE `rel_publ_to_references`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;