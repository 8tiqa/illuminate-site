-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 08, 2015 at 12:25 ش
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_illuminate`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_discuss`
--

CREATE TABLE IF NOT EXISTS `tb_discuss` (
`ID` int(11) NOT NULL,
  `topic` varchar(100) NOT NULL,
  `details` varchar(50000) NOT NULL,
  `posted_by` varchar(20) NOT NULL,
  `posted_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_discuss`
--

INSERT INTO `tb_discuss` (`ID`, `topic`, `details`, `posted_by`, `posted_on`) VALUES
(1, 'Hijab', 'What are the requirements for Muslim women''s dress? ', 'atiqa', '2015-01-04 03:00:00'),
(2, ' Quranic verses on Hijab', 'What does Quran inform us about the hijab of men and women in Islam?', 'atiqa', '2015-01-04 10:00:00'),
(7, 'Ablution', 'Can you please quote the Sunnah of performing wudhu?', 'zaryab', '2015-01-06 18:44:01'),
(8, 'Quranic verses on Mehr', 'Please quote me few verses where Quran speaks about Mehr.', 'atiqa', '2015-01-06 18:45:44');

-- --------------------------------------------------------

--
-- Table structure for table `tb_post`
--

CREATE TABLE IF NOT EXISTS `tb_post` (
`ID` int(11) NOT NULL,
  `D_ID` int(11) NOT NULL,
  `reply` varchar(50000) NOT NULL,
  `posted_by` varchar(20) NOT NULL,
  `posted_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `likes` int(11) NOT NULL DEFAULT '0',
  `flags` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_post`
--

INSERT INTO `tb_post` (`ID`, `D_ID`, `reply`, `posted_by`, `posted_on`, `likes`, `flags`) VALUES
(1, 1, 'In the Quran, God states: "Say tothe believing men that they should lower their gaze and guard theirmodesty...And say to the believing women that they should lower theirgaze and guard their modesty; that they should not display their beautyand adornments except what (must ordinarily) appear thereof; that theyshould draw their veils over their bosoms and not display their beautyexcept to their husbands, their fathers...(a list of exceptions)"[Chapter 24, verses 30-31]', 'zaryab', '2015-01-04 04:08:00', 4, 0),
(2, 1, 'Also, "O Prophet! Tell thy wives anddaughters, and the believing women, that they should cast their outergarments over their persons...that they should be known and notmolested." [Chapter 33, verse 59] ', 'zaryab', '2015-01-04 05:10:00', 0, 0),
(3, 1, 'Also, Are there any requirements for a Muslim male''s attire?', 'atiqa', '2015-01-04 07:00:00', 1, 0),
(4, 1, '1) A Muslim man must always be covered from the navel to theknees. 2) A Muslim man should similarly not wear tight, sheer,revealing, or eye-catching clothing. In addition, a Muslim man isprohibited from wearing silk clothing (except for medical reasons) orgold jewelry. A Muslim woman may wear silk or gold. ', 'zaryab', '2015-01-04 13:00:00', 1, 0),
(5, 1, 'JazakAllah khayrun', 'atiqa', '2015-01-06 20:42:11', 0, 0),
(6, 1, 'Wa iyyaka Khayrun', 'zaryab', '2015-01-06 20:45:59', 0, 0),
(7, 2, 'In the Quran, God states: "Say to the believing men that they should lower their gaze and guard theirmodesty...And say to the believing women that they should lower their gaze and guard their modesty; that they should not display their beauty and adornments except what (must ordinarily) appear thereof; that they should draw their veils over their bosoms and not display their beauty except to their husbands, their fathers...(a list of exceptions)"[Chapter 24, verses 30-31]', 'zaryab', '2015-01-06 20:47:06', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(16) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dob` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`username`, `password`, `email`, `dob`) VALUES
('ammar', 'amaar', 'ammar@gmail.com', '1992-03-04'),
('atiqa', 'atiqa', '12beseazafar@seecs.edu.pk', '1993-02-08'),
('tasneemkausar', 'tasneem', 'tasneem@gmail.com', '1992-03-03'),
('zaryab', 'zaryab', '12besezkhan@seecs.edu.pk', '1994-04-09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_discuss`
--
ALTER TABLE `tb_discuss`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tb_post`
--
ALTER TABLE `tb_post`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
 ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_discuss`
--
ALTER TABLE `tb_discuss`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tb_post`
--
ALTER TABLE `tb_post`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
