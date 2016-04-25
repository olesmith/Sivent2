-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 25, 2016 at 02:36 AM
-- Server version: 10.0.20-MariaDB-0+deb8u1
-- PHP Version: 5.6.14-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sivent2`
--

-- --------------------------------------------------------

--
-- Table structure for table `1__1_Areas`
--

CREATE TABLE IF NOT EXISTS `1__1_Areas` (
`ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT '2',
  `Event` int(11) DEFAULT '1',
  `Name` varchar(256) DEFAULT NULL,
  `Name_UK` varchar(256) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `1__1_Areas`
--

INSERT INTO `1__1_Areas` (`ID`, `CTime`, `MTime`, `ATime`, `Unit`, `Event`, `Name`, `Name_UK`) VALUES
(1, 1459417829, 1459417829, 1459418372, 2, 1, 'Ecossistema/Cultura Livre', 'Ecosystems/Free Culture'),
(2, 1459417843, 1459417843, 1459418372, 2, 1, 'TI Verde com Solu&ccedil;&otilde;es Livres', 'Green IT with Free Solutions'),
(3, 1459417856, 1459417856, 1459418372, 2, 1, 'Governo e Software P&uacute;blico Livre', 'Government and Public Software'),
(4, 1459417868, 1459417868, 1459418372, 2, 1, 'Neg&oacute;cios, Produtos e Servi&ccedil;os Livres', 'Comercial Products and Services'),
(5, 1459417881, 1459417881, 1459418372, 2, 1, 'Projetos e Ferramentas Livres', 'Projects and Tools'),
(6, 1459417896, 1459417896, 1459418372, 2, 1, 'Educa&ccedil;&atilde;o e Inclus&atilde;o Digital', 'Education and Digital Inclusion'),
(7, 1459417918, 1459417918, 1459418372, 2, 1, 'Trilha Web Livre', 'Free Web'),
(8, 1459417930, 1459417930, 1459418372, 2, 1, 'Trilha Desenvolvimento Livre', 'Development'),
(9, 1459417948, 1459417948, 1459418372, 2, 1, 'Redes e Telecomunica&ccedil;&otilde;es Livres', 'Free Networks and Telecommunications'),
(10, 1459417962, 1459417966, 1459418372, 2, 1, 'Seguran&ccedil;a da Informa&ccedil;&atilde;o', 'Information and Security'),
(11, 1459417978, 1459417978, 1459418372, 2, 1, 'Rob&oacute;tica Livre', 'Robotics');

-- --------------------------------------------------------

--
-- Table structure for table `1__1_Caravaneers`
--

CREATE TABLE IF NOT EXISTS `1__1_Caravaneers` (
`ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT '2',
  `Event` int(11) DEFAULT '1',
  `Friend` int(11) DEFAULT NULL,
  `Name` varchar(256) DEFAULT NULL,
  `Email` varchar(256) DEFAULT NULL,
  `Status` enum('0','1','2','3','4') DEFAULT NULL,
  `Registration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `1__1_Collaborations`
--

CREATE TABLE IF NOT EXISTS `1__1_Collaborations` (
`ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT '2',
  `Event` int(11) DEFAULT '1',
  `Name` varchar(256) DEFAULT NULL,
  `TimeLoad` int(11) DEFAULT '20',
  `CertText` varchar(256) DEFAULT NULL,
  `Name_UK` varchar(256) DEFAULT NULL,
  `Inscriptions` enum('0','1','2') DEFAULT '2'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `1__1_Collaborations`
--

INSERT INTO `1__1_Collaborations` (`ID`, `CTime`, `MTime`, `ATime`, `Unit`, `Event`, `Name`, `TimeLoad`, `CertText`, `Name_UK`, `Inscriptions`) VALUES
(1, 1458947585, 1458947585, 1461299809, 2, 1, 'Membro do Comit&ecirc; Organizador', 20, NULL, NULL, '2'),
(2, 1458947617, 1458947617, 1461299809, 2, 1, 'Coordenador(a) do Batismo Digital', 20, NULL, NULL, '2'),
(3, 1458947635, 1458947635, 1461299809, 2, 1, 'Coordenador(a) do Install Fest', 20, NULL, NULL, '2'),
(4, 1458947755, 1458947755, 1461299809, 2, 1, 'Coordenador(a) do Tem&aacute;rio', 20, NULL, NULL, '2'),
(5, 1458947779, 1458947779, 1461299809, 2, 1, 'Coordenador(a) Geral do Evento', 20, NULL, NULL, '1'),
(6, 1458947795, 1458947795, 1461299809, 2, 1, 'Design Gr&aacute;fico de Material de Divulga&ccedil;&atilde;o', 20, NULL, NULL, '2'),
(7, 1458947807, 1458947807, 1461299809, 2, 1, 'Cria&ccedil;&atilde;o e Manuten&ccedil;&atilde;o do Site do Evento', 20, NULL, NULL, '2'),
(8, 1458947832, 1458947832, 1461299809, 2, 1, 'Coordenador(a) de Infraestrutura', 20, NULL, NULL, '2'),
(9, 1458947841, 1458947841, 1461299809, 2, 1, 'Coordenador(a) de Patroc&iacute;nio', 20, NULL, NULL, '2'),
(10, 1458947855, 1460082679, 1461299809, 2, 1, 'Manuten&ccedil;&atilde;o do Sistema de Inscri&ccedil;&otilde;es e Submiss&otilde;es', 20, NULL, NULL, '2'),
(11, 1458947863, 1461033315, 1461299809, 2, 1, 'Mes&aacute;rio', 20, NULL, NULL, '2'),
(12, 1458947887, 1458947887, 1461299809, 2, 1, 'Design Gr&aacute;fico do Material de Certifica&ccedil;&atilde;o', 20, NULL, NULL, '2'),
(13, 1460082648, 1460082648, 1461299809, 2, 1, 'Gerenciamento e Desenvolvimento do Sistema de Inscri&ccedil;&otilde;es e Submiss&otilde;es ', 20, NULL, NULL, '2'),
(14, 1461033981, 1461033981, 1461299809, 2, 1, 'Coordenador(a) de Credenciamento', 20, NULL, NULL, '2');

-- --------------------------------------------------------

--
-- Table structure for table `1__1_Collaborators`
--

CREATE TABLE IF NOT EXISTS `1__1_Collaborators` (
`ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT '2',
  `Event` int(11) DEFAULT '1',
  `Friend` int(11) DEFAULT NULL,
  `Collaboration` int(11) DEFAULT NULL,
  `TimeLoad` int(11) DEFAULT NULL,
  `Homologated` enum('0','1','2') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `1__1_Datas`
--

CREATE TABLE IF NOT EXISTS `1__1_Datas` (
`ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT '2',
  `Event` int(11) DEFAULT NULL,
  `SortOrder` int(11) DEFAULT NULL,
  `Type` enum('0','1','2','3','4','5','6','7','8') DEFAULT NULL,
  `Pertains` enum('0','1') DEFAULT '1',
  `SqlKey` varchar(256) DEFAULT NULL,
  `SqlDef` varchar(256) DEFAULT NULL,
  `SqlDefault` varchar(256) DEFAULT NULL,
  `Text` varchar(256) DEFAULT NULL,
  `Text_UK` varchar(256) DEFAULT NULL,
  `Title` varchar(256) DEFAULT NULL,
  `Title_UK` varchar(256) DEFAULT NULL,
  `Compulsory` enum('0','1','2') DEFAULT '1',
  `Friend` enum('0','1','2','3') DEFAULT '2',
  `CSS` varchar(64) DEFAULT NULL,
  `Width` varchar(64) DEFAULT '10',
  `Height` varchar(64) DEFAULT '1',
  `SValues` varchar(2096) DEFAULT NULL,
  `SValues_UK` varchar(2096) DEFAULT NULL,
  `Extensions` varchar(256) DEFAULT NULL,
  `DataGroup` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `1__1_GroupDatas`
--

CREATE TABLE IF NOT EXISTS `1__1_GroupDatas` (
`ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT '2',
  `Event` int(11) DEFAULT NULL,
  `SortOrder` int(11) DEFAULT NULL,
  `Pertains` enum('0','1') DEFAULT '1',
  `Text` varchar(256) DEFAULT NULL,
  `Text_UK` varchar(256) DEFAULT NULL,
  `Friend` enum('0','1','2','3') DEFAULT '1',
  `Singular` enum('0','1','2') DEFAULT '1',
  `Plural` enum('0','1','2') DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `1__1_Inscriptions`
--

CREATE TABLE IF NOT EXISTS `1__1_Inscriptions` (
`ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT '2',
  `Event` int(11) DEFAULT '1',
  `Friend` int(11) DEFAULT NULL,
  `Homologated` enum('0','1','2') DEFAULT '1',
  `Score` varchar(256) DEFAULT NULL,
  `Selected` enum('0','1','2') DEFAULT '1',
  `Certificate` enum('0','1','2') DEFAULT '1',
  `Certificate_Generated` int(11) DEFAULT NULL,
  `Certificate_Mailed` int(11) DEFAULT NULL,
  `Comment` text,
  `Collaborations` enum('0','1','2') DEFAULT '1',
  `Collaborations_Activity` varchar(256) DEFAULT NULL,
  `Certificate_CH` varchar(8) DEFAULT NULL,
  `Name` varchar(256) DEFAULT NULL,
  `SortName` varchar(256) DEFAULT NULL,
  `Email` varchar(256) DEFAULT NULL,
  `Code` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `1__1_Submissions`
--

CREATE TABLE IF NOT EXISTS `1__1_Submissions` (
`ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT '2',
  `Event` int(11) DEFAULT '1',
  `Friend` int(11) DEFAULT NULL,
  `Author1` varchar(256) DEFAULT NULL,
  `Author2` varchar(256) DEFAULT NULL,
  `Author3` varchar(256) DEFAULT NULL,
  `Title` varchar(256) DEFAULT NULL,
  `Title_UK` varchar(256) DEFAULT NULL,
  `Type` enum('0','1','2','3') DEFAULT '1',
  `Area` int(11) DEFAULT NULL,
  `Level` enum('0','1','2','3') DEFAULT '1',
  `Need_Projector` enum('0','1','2') DEFAULT '2',
  `Need_Computer` enum('0','1','2') DEFAULT '1',
  `Need_Other` varchar(256) DEFAULT NULL,
  `Status` enum('0','1','2','3') DEFAULT '1',
  `Summary` varchar(1048) DEFAULT NULL,
  `File` varchar(256) DEFAULT NULL,
  `File_OrigName` varchar(256) DEFAULT NULL,
  `File_Contents` mediumblob,
  `File_Time` int(11) DEFAULT NULL,
  `File_Size` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `1__Certificates`
--

CREATE TABLE IF NOT EXISTS `1__Certificates` (
`ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT NULL,
  `Event` int(11) DEFAULT NULL,
  `Friend` int(11) DEFAULT NULL,
  `Inscription` int(11) DEFAULT NULL,
  `Name` varchar(256) DEFAULT NULL,
  `Code` varchar(64) DEFAULT NULL,
  `Type` enum('0','1','2','3','4') DEFAULT '1',
  `Generated` int(11) DEFAULT NULL,
  `Mailed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `1__Events`
--

CREATE TABLE IF NOT EXISTS `1__Events` (
`ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT '2',
  `Name` varchar(256) DEFAULT NULL,
  `Name_UK` varchar(256) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Title_UK` varchar(255) DEFAULT NULL,
  `AnnouncementLink` varchar(256) DEFAULT 'http://aslgo.org.br/comunidades/49-psl-go.html',
  `Date` int(11) DEFAULT NULL,
  `StartDate` int(11) DEFAULT NULL,
  `EndDate` int(11) DEFAULT NULL,
  `EditDate` int(11) DEFAULT NULL,
  `Announcement` varchar(256) DEFAULT NULL,
  `Announcement_OrigName` varchar(256) DEFAULT NULL,
  `Announcement_Contents` mediumblob,
  `Announcement_Time` int(11) DEFAULT NULL,
  `Announcement_Size` int(11) DEFAULT NULL,
  `Status` enum('0','1','2','3') DEFAULT '2',
  `State` enum('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30') DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Fax` varchar(255) DEFAULT NULL,
  `Url` varchar(255) DEFAULT 'http://aslgo.org.br/comunidades/49-psl-go.html',
  `Email` varchar(255) DEFAULT 'mail@aslgo.org.br',
  `City` varchar(256) DEFAULT 'Goi&acirc;nia',
  `Area` varchar(256) DEFAULT NULL,
  `ZIP` varchar(256) DEFAULT NULL,
  `HtmlIcon1` varchar(256) DEFAULT NULL,
  `HtmlIcon1_OrigName` varchar(256) DEFAULT NULL,
  `HtmlIcon1_Contents` mediumblob,
  `HtmlIcon1_Time` int(11) DEFAULT NULL,
  `HtmlIcon1_Size` int(11) DEFAULT NULL,
  `HtmlIcon2` varchar(256) DEFAULT NULL,
  `HtmlIcon2_OrigName` varchar(256) DEFAULT NULL,
  `HtmlIcon2_Contents` mediumblob,
  `HtmlIcon2_Time` int(11) DEFAULT NULL,
  `HtmlIcon2_Size` int(11) DEFAULT NULL,
  `LatexIcon1` varchar(256) DEFAULT NULL,
  `LatexIcon1_OrigName` varchar(256) DEFAULT NULL,
  `LatexIcon1_Contents` mediumblob,
  `LatexIcon1_Time` int(11) DEFAULT NULL,
  `LatexIcon1_Size` int(11) DEFAULT NULL,
  `LatexIcon2` varchar(256) DEFAULT NULL,
  `LatexIcon2_OrigName` varchar(256) DEFAULT NULL,
  `LatexIcon2_Contents` mediumblob,
  `LatexIcon2_Time` int(11) DEFAULT NULL,
  `LatexIcon2_Size` int(11) DEFAULT NULL,
  `Auth` enum('0','1','2') DEFAULT '2',
  `Secure` enum('0','1','2','3') DEFAULT '2',
  `Port` varchar(8) DEFAULT '465',
  `Host` varchar(256) DEFAULT 'smtp.gmail.com',
  `User` varchar(256) DEFAULT 'siga.ime.ufg@gmail.com',
  `Password` varchar(256) DEFAULT 'Sipe.Ime.2013',
  `FromEmail` varchar(256) DEFAULT 'siga.ime.ufg@gmail.com',
  `FromName` varchar(256) DEFAULT 'SiVent2:SistemadeGerenciamentodeEventos',
  `ReplyTo` varchar(256) DEFAULT 'siga.ime.ufg@gmail.com',
  `BCCEmail` varchar(256) DEFAULT 'siga.ime.ufg@gmail.com',
  `HtmlLogoHeight` int(11) DEFAULT NULL,
  `HtmlLogoWidth` int(11) DEFAULT NULL,
  `Certificates` enum('0','1','2') DEFAULT NULL,
  `Certificates_Published` enum('0','1','2') DEFAULT NULL,
  `EventStart` int(11) DEFAULT NULL,
  `EventEnd` int(11) DEFAULT NULL,
  `Collaborations` enum('0','1','2') DEFAULT NULL,
  `Collaborations_Inscriptions` enum('0','1','2') DEFAULT NULL,
  `Collaborations_StartDate` int(11) DEFAULT NULL,
  `Collaborations_EndDate` int(11) DEFAULT NULL,
  `Caravans` enum('0','1','2') DEFAULT NULL,
  `Caravans_StartDate` int(11) DEFAULT NULL,
  `Caravans_EndDate` int(11) DEFAULT NULL,
  `Caravans_Min` int(11) DEFAULT NULL,
  `Caravans_Max` int(11) DEFAULT NULL,
  `Submissions` enum('0','1','2') DEFAULT NULL,
  `Submissions_StartDate` int(11) DEFAULT NULL,
  `Submissions_Inscriptions` enum('0','1','2') DEFAULT NULL,
  `Submissions_EndDate` int(11) DEFAULT NULL,
  `Submissions_Public` enum('0','1','2') DEFAULT NULL,
  `Certificates_CH` varchar(8) DEFAULT '10',
  `Certificates_Watermark` varchar(256) DEFAULT '10',
  `Certificates_Watermark_OrigName` varchar(256) DEFAULT NULL,
  `Certificates_Watermark_Contents` mediumblob,
  `Certificates_Watermark_Time` int(11) DEFAULT NULL,
  `Certificates_Watermark_Size` int(11) DEFAULT NULL,
  `Certificates_Signature_1` varchar(256) DEFAULT '10',
  `Certificates_Signature_1_OrigName` varchar(256) DEFAULT NULL,
  `Certificates_Signature_1_Contents` mediumblob,
  `Certificates_Signature_1_Time` int(11) DEFAULT NULL,
  `Certificates_Signature_1_Size` int(11) DEFAULT NULL,
  `Certificates_Signature_1_Text1` varchar(256) DEFAULT NULL,
  `Certificates_Signature_1_Text2` varchar(256) DEFAULT NULL,
  `Certificates_Signature_2` varchar(256) DEFAULT '10',
  `Certificates_Signature_2_OrigName` varchar(256) DEFAULT NULL,
  `Certificates_Signature_2_Contents` mediumblob,
  `Certificates_Signature_2_Time` int(11) DEFAULT NULL,
  `Certificates_Signature_2_Size` int(11) DEFAULT NULL,
  `Certificates_Signature_2_Text1` varchar(256) DEFAULT NULL,
  `Certificates_Signature_2_Text2` varchar(256) DEFAULT NULL,
  `Certificates_Signature_3` varchar(256) DEFAULT '10',
  `Certificates_Signature_3_OrigName` varchar(256) DEFAULT NULL,
  `Certificates_Signature_3_Contents` mediumblob,
  `Certificates_Signature_3_Time` int(11) DEFAULT NULL,
  `Certificates_Signature_3_Size` int(11) DEFAULT NULL,
  `Certificates_Signature_3_Text1` varchar(256) DEFAULT NULL,
  `Certificates_Signature_3_Text2` varchar(256) DEFAULT NULL,
  `Certificates_Latex` text
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `1__Events`
--

INSERT INTO `1__Events` (`ID`, `CTime`, `MTime`, `ATime`, `Unit`, `Name`, `Name_UK`, `Title`, `Title_UK`, `AnnouncementLink`, `Date`, `StartDate`, `EndDate`, `EditDate`, `Announcement`, `Announcement_OrigName`, `Announcement_Contents`, `Announcement_Time`, `Announcement_Size`, `Status`, `State`, `Address`, `Phone`, `Fax`, `Url`, `Email`, `City`, `Area`, `ZIP`, `HtmlIcon1`, `HtmlIcon1_OrigName`, `HtmlIcon1_Contents`, `HtmlIcon1_Time`, `HtmlIcon1_Size`, `HtmlIcon2`, `HtmlIcon2_OrigName`, `HtmlIcon2_Contents`, `HtmlIcon2_Time`, `HtmlIcon2_Size`, `LatexIcon1`, `LatexIcon1_OrigName`, `LatexIcon1_Contents`, `LatexIcon1_Time`, `LatexIcon1_Size`, `LatexIcon2`, `LatexIcon2_OrigName`, `LatexIcon2_Contents`, `LatexIcon2_Time`, `LatexIcon2_Size`, `Auth`, `Secure`, `Port`, `Host`, `User`, `Password`, `FromEmail`, `FromName`, `ReplyTo`, `BCCEmail`, `HtmlLogoHeight`, `HtmlLogoWidth`, `Certificates`, `Certificates_Published`, `EventStart`, `EventEnd`, `Collaborations`, `Collaborations_Inscriptions`, `Collaborations_StartDate`, `Collaborations_EndDate`, `Caravans`, `Caravans_StartDate`, `Caravans_EndDate`, `Caravans_Min`, `Caravans_Max`, `Submissions`, `Submissions_StartDate`, `Submissions_Inscriptions`, `Submissions_EndDate`, `Submissions_Public`, `Certificates_CH`, `Certificates_Watermark`, `Certificates_Watermark_OrigName`, `Certificates_Watermark_Contents`, `Certificates_Watermark_Time`, `Certificates_Watermark_Size`, `Certificates_Signature_1`, `Certificates_Signature_1_OrigName`, `Certificates_Signature_1_Contents`, `Certificates_Signature_1_Time`, `Certificates_Signature_1_Size`, `Certificates_Signature_1_Text1`, `Certificates_Signature_1_Text2`, `Certificates_Signature_2`, `Certificates_Signature_2_OrigName`, `Certificates_Signature_2_Contents`, `Certificates_Signature_2_Time`, `Certificates_Signature_2_Size`, `Certificates_Signature_2_Text1`, `Certificates_Signature_2_Text2`, `Certificates_Signature_3`, `Certificates_Signature_3_OrigName`, `Certificates_Signature_3_Contents`, `Certificates_Signature_3_Time`, `Certificates_Signature_3_Size`, `Certificates_Signature_3_Text1`, `Certificates_Signature_3_Text2`, `Certificates_Latex`) VALUES
(1, 1458648823, 1461346861, 1461346861, 2, 'FLISOL-GYN', 'FLISOL-GYN', 'FLISOL, Goi&acirc;nia', 'FLISOL, Goi&acirc;nia', 'http://aslgo.org.br/comunidades/49-psl-go.htm', 20160322, 20160322, 20160419, 20160419, NULL, NULL, NULL, NULL, NULL, '3', '9', NULL, NULL, NULL, 'http://aslgo.org.br/comunidades/49-psl-go.html', 'mail@aslgo.org.br', 'Goi&acirc;nia', 'Itatiaia', '74001-970', 'Uploads/2/Events/HtmlIcon1_1.png', 'flisol.png', NULL, NULL, NULL, 'Uploads/2/Events/HtmlIcon2_1.png', 'flisol.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', '465', 'smtp.gmail.com', 'siga.ime.ufg@gmail.com', 'your-password-here', 'siga.ime.ufg@gmail.com', 'SiVent2: Sistema de Gerenciamento de Eventos', 'siga.ime.ufg@gmail.com', 'siga.ime.ufg@gmail.com', 100, 150, '2', '2', 20160416, 20160416, '2', '1', NULL, NULL, '1', NULL, NULL, NULL, NULL, '2', NULL, '1', NULL, '1', '8', 'Uploads/2/Events/Certificates_Watermark_1.jpg', 'Flisol2015.Gyn.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '&#92;vspace{5.5cm}\r\n\r\n&#92;begin{huge}\r\nCertificamos que:\r\n\r\n&#92;begin{center}&#92;Huge{&#92;textbf{#Friend_Name}}&#92;end{center}\r\n\r\nparticipou do &#92;textbf{FLISOL}, Festival Latinoamericano de Instala&ccedil;&atilde;o de Software Livre,realizado na &#92;textbf{Faculdade FATESG}, Goi&acirc;nia-GO, no dia &#92;textit{16 de Abril de 2016}, \r\ncom carga hor&aacute;ria de &#92;textbf{#Inscription_Certificate_CH horas}.\r\n&#92;end{huge}\r\n\r\n &#92;vspace{1cm}');

-- --------------------------------------------------------

--
-- Table structure for table `1__Friends`
--

CREATE TABLE IF NOT EXISTS `1__Friends` (
`ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Language` varchar(4) DEFAULT NULL,
  `Name` varchar(256) DEFAULT NULL,
  `TextName` varchar(256) DEFAULT NULL,
  `Email` varchar(256) DEFAULT NULL,
  `Password` varchar(256) DEFAULT NULL,
  `RecoverCode` varchar(20) DEFAULT NULL,
  `RecoverMTime` int(11) DEFAULT NULL,
  `CondEmail` varchar(256) DEFAULT NULL,
  `ConfirmCode` varchar(256) DEFAULT NULL,
  `ConfirmDate` varchar(256) DEFAULT NULL,
  `Titulation` enum('0','1','2','3','4','5','6') DEFAULT NULL,
  `Institution` varchar(256) DEFAULT NULL,
  `Phone` varchar(32) DEFAULT NULL,
  `Cell` varchar(32) DEFAULT NULL,
  `Address` varchar(256) DEFAULT NULL,
  `Lattes` varchar(256) DEFAULT NULL,
  `Profile_Coordinator` enum('0','1','2') DEFAULT NULL,
  `Profile_Friend` enum('0','1','2') DEFAULT NULL,
  `Profile_Admin` enum('0','1','2') DEFAULT NULL,
  `NickName` varchar(256) DEFAULT NULL,
  `Curriculum` varchar(256) DEFAULT NULL,
  `Unit` int(11) DEFAULT '2'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `1__Friends`
--

INSERT INTO `1__Friends` (`ID`, `CTime`, `MTime`, `ATime`, `Language`, `Name`, `TextName`, `Email`, `Password`, `RecoverCode`, `RecoverMTime`, `CondEmail`, `ConfirmCode`, `ConfirmDate`, `Titulation`, `Institution`, `Phone`, `Cell`, `Address`, `Lattes`, `Profile_Coordinator`, `Profile_Friend`, `Profile_Admin`, `NickName`, `Curriculum`, `Unit`) VALUES
(1, 1433549097, 1433549097, 1458874977, 'PT', 'Ole Peter Smith', 'Ole Peter Smith', 'ole.ufg@gmail.com', '312ba9fc90866c31f0f233582601e801', '16283791071439324899', 1460392324, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', '2', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `1__Permissions`
--

CREATE TABLE IF NOT EXISTS `1__Permissions` (
`ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT '2',
  `Event` int(11) DEFAULT NULL,
  `User` int(11) DEFAULT NULL,
  `Comment` varchar(256) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `1__Permissions`
--

INSERT INTO `1__Permissions` (`ID`, `CTime`, `MTime`, `ATime`, `Unit`, `Event`, `User`, `Comment`) VALUES
(1, 1458820125, 1458820125, 1458873945, 2, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `1__Sessions`
--

CREATE TABLE IF NOT EXISTS `1__Sessions` (
`ID` int(11) NOT NULL,
  `Login` varchar(55) DEFAULT NULL,
  `LoginID` int(11) DEFAULT NULL,
  `LoginName` varchar(255) DEFAULT NULL,
  `SID` varchar(55) DEFAULT NULL,
  `IP` varchar(55) DEFAULT NULL,
  `CTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Authenticated` enum('0','1','2') DEFAULT NULL,
  `LastAuthenticationAttempt` int(11) DEFAULT NULL,
  `LastAuthenticationSuccess` int(11) DEFAULT NULL,
  `NAuthenticationAttempts` int(11) DEFAULT NULL,
  `SULoginID` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1626 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `1__Sponsors`
--

CREATE TABLE IF NOT EXISTS `1__Sponsors` (
`ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT '2',
  `Event` int(11) DEFAULT NULL,
  `Initials` varchar(256) DEFAULT NULL,
  `Name` varchar(256) DEFAULT NULL,
  `URL` varchar(255) DEFAULT NULL,
  `Text` varchar(255) DEFAULT NULL,
  `Logo` varchar(256) DEFAULT NULL,
  `Logo_OrigName` varchar(256) DEFAULT NULL,
  `Logo_Contents` mediumblob,
  `Logo_Time` int(11) DEFAULT NULL,
  `Logo_Size` int(11) DEFAULT NULL,
  `Place` enum('0','1','2','3') DEFAULT NULL,
  `Height` int(11) DEFAULT '100',
  `Width` int(11) DEFAULT '150',
  `Level` enum('0','1','2','3') DEFAULT NULL,
  `Value` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Units`
--

CREATE TABLE IF NOT EXISTS `Units` (
`ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Status` enum('0','1','2') DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `State` enum('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30') DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Fax` varchar(255) DEFAULT NULL,
  `Url` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `City` varchar(256) DEFAULT NULL,
  `Area` varchar(256) DEFAULT NULL,
  `ZIP` varchar(256) DEFAULT NULL,
  `HtmlIcon1` varchar(256) DEFAULT NULL,
  `HtmlIcon1_OrigName` varchar(256) DEFAULT NULL,
  `HtmlIcon1_Contents` mediumblob,
  `HtmlIcon1_Time` int(11) DEFAULT NULL,
  `HtmlIcon1_Size` int(11) DEFAULT NULL,
  `HtmlIcon2` varchar(256) DEFAULT NULL,
  `HtmlIcon2_OrigName` varchar(256) DEFAULT NULL,
  `HtmlIcon2_Contents` mediumblob,
  `HtmlIcon2_Time` int(11) DEFAULT NULL,
  `HtmlIcon2_Size` int(11) DEFAULT NULL,
  `LatexIcon1` varchar(256) DEFAULT NULL,
  `LatexIcon1_OrigName` varchar(256) DEFAULT NULL,
  `LatexIcon1_Contents` mediumblob,
  `LatexIcon1_Time` int(11) DEFAULT NULL,
  `LatexIcon1_Size` int(11) DEFAULT NULL,
  `LatexIcon2` varchar(256) DEFAULT NULL,
  `LatexIcon2_OrigName` varchar(256) DEFAULT NULL,
  `LatexIcon2_Contents` mediumblob,
  `LatexIcon2_Time` int(11) DEFAULT NULL,
  `LatexIcon2_Size` int(11) DEFAULT NULL,
  `Auth` enum('0','1','2') DEFAULT NULL,
  `Secure` enum('0','1','2','3') DEFAULT NULL,
  `Port` varchar(8) DEFAULT '465',
  `Host` varchar(256) DEFAULT 'smtp.gmail.com',
  `User` varchar(256) DEFAULT 'foo@gmail.com',
  `Password` varchar(256) DEFAULT NULL,
  `FromEmail` varchar(256) DEFAULT NULL,
  `FromName` varchar(256) DEFAULT NULL,
  `ReplyTo` varchar(256) DEFAULT NULL,
  `BCCEmail` varchar(256) DEFAULT NULL,
  `MailHead` varchar(4096) DEFAULT 'Prezado(a)#Name',
  `MailTail` varchar(4096) DEFAULT 'Atenciosamente,#Department#Institution',
  `MailHead_UK` varchar(4096) DEFAULT 'Dear#Name',
  `MailTail_UK` varchar(4096) DEFAULT 'Regards,#Department#Institution',
  `Register_Subject` text,
  `Register_Body` text,
  `Register_Subject_UK` text,
  `Register_Body_UK` text,
  `Confirm_Subject` text,
  `Confirm_Body` text,
  `Confirm_Subject_UK` text,
  `Confirm_Body_UK` text,
  `Confirm_Resend_Subject` text,
  `Confirm_Resend_Body` text,
  `Confirm_Resend_Subject_UK` text,
  `Confirm_Resend_Body_UK` text,
  `Password_Reset_Subject` text,
  `Password_Reset_Body` text,
  `Password_Reset_Subject_UK` text,
  `Password_Reset_Body_UK` text,
  `Password_Changed_Subject` text,
  `Password_Changed_Body` text,
  `Password_Changed_Subject_UK` text,
  `Password_Changed_Body_UK` text,
  `Email_Change_Subject` text,
  `Email_Change_Body` text,
  `Email_Change_Subject_UK` text,
  `Email_Change_Body_UK` text,
  `Email_Changed_Subject` text,
  `Email_Changed_Body` text,
  `Email_Changed_Subject_UK` text,
  `Email_Changed_Body_UK` text,
  `Email_Created_Subject` text,
  `Email_Created_Body` text,
  `Email_Created_Subject_UK` text,
  `Email_Created_Body_UK` text
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Units`
--

INSERT INTO `Units` (`ID`, `CTime`, `MTime`, `ATime`, `Status`, `Name`, `Title`, `State`, `Address`, `Phone`, `Fax`, `Url`, `Email`, `City`, `Area`, `ZIP`, `HtmlIcon1`, `HtmlIcon1_OrigName`, `HtmlIcon1_Contents`, `HtmlIcon1_Time`, `HtmlIcon1_Size`, `HtmlIcon2`, `HtmlIcon2_OrigName`, `HtmlIcon2_Contents`, `HtmlIcon2_Time`, `HtmlIcon2_Size`, `LatexIcon1`, `LatexIcon1_OrigName`, `LatexIcon1_Contents`, `LatexIcon1_Time`, `LatexIcon1_Size`, `LatexIcon2`, `LatexIcon2_OrigName`, `LatexIcon2_Contents`, `LatexIcon2_Time`, `LatexIcon2_Size`, `Auth`, `Secure`, `Port`, `Host`, `User`, `Password`, `FromEmail`, `FromName`, `ReplyTo`, `BCCEmail`, `MailHead`, `MailTail`, `MailHead_UK`, `MailTail_UK`, `Register_Subject`, `Register_Body`, `Register_Subject_UK`, `Register_Body_UK`, `Confirm_Subject`, `Confirm_Body`, `Confirm_Subject_UK`, `Confirm_Body_UK`, `Confirm_Resend_Subject`, `Confirm_Resend_Body`, `Confirm_Resend_Subject_UK`, `Confirm_Resend_Body_UK`, `Password_Reset_Subject`, `Password_Reset_Body`, `Password_Reset_Subject_UK`, `Password_Reset_Body_UK`, `Password_Changed_Subject`, `Password_Changed_Body`, `Password_Changed_Subject_UK`, `Password_Changed_Body_UK`, `Email_Change_Subject`, `Email_Change_Body`, `Email_Change_Subject_UK`, `Email_Change_Body_UK`, `Email_Changed_Subject`, `Email_Changed_Body`, `Email_Changed_Subject_UK`, `Email_Changed_Body_UK`, `Email_Created_Subject`, `Email_Created_Body`, `Email_Created_Subject_UK`, `Email_Created_Body_UK`) VALUES
(1, 1433549097, 1461104154, 1461104154, '2', 'Instituto de Matem&aacute;tica e Esta&iacute;stica', 'Universidade Federal de Goi&aacute;s', '9', 'Campus Samambaia, Caixa Postal 131', '(55)(62) 3521-1208', '(55)(62) 3521-1208', 'http://www.mat.ufg.br', 'secmat@mat.ufg.br', 'Goi&acirc;nia', 'Itatiaia', '74001-970', 'Uploads/Units/HtmlIcon1_1.png', 'ufg.png', NULL, NULL, NULL, 'Uploads/Units/HtmlIcon2_1.png', 'ufg.png', NULL, NULL, NULL, 'Uploads/Units/LatexIcon1_1.png', 'ufg.png', NULL, NULL, NULL, 'Uploads/Units/LatexIcon2_1.png', 'ufg.png', NULL, NULL, NULL, '2', '2', '465', 'smtp.gmail.com', 'siga.ime.ufg@gmail.com', 'your-password-here', 'siga.ime.ufg@gmail.com', 'SiVent2: Sistema de Gerenciamento de Eventos', 'siga.ime.ufg@gmail.com', 'siga.ime.ufg@gmail.com', 'Prezado(a) #Name', 'Atenciosamente,\r\n#ApplicationName,\r\n#Unit_Title', 'Dear #Name', 'Regards,\r\n#ApplicationName,\r\n#Unit_Title', '#ApplicationName: C&oacute;digo de Confirma&ccedil;a&otilde; de Cadastro, #Unit_Title', 'Recebemos uma solicita&ccedil;&atilde;o de cadastro em #ApplicationName, #Unit_Title, #Institution. Para completar o cadastro, precisamos verificar que voc&ecirc; controla este email. Para neste fim, por favor acesse o link:\r\n\r\n#ConfirmLink\r\n\r\nVoc&ecirc; tamb&eacute;m pode confirmar seu cadastro, atrav&eacute;s do link:\r\n\r\n#ConfirmLinkForm\r\n\r\ninformando seu email como login no sistema junto com o c&oacute;digo de confirma&ccedil;&atilde;o abaixo:\r\n\r\nUsu&aacute;rio: #Email\r\nCode de Confirma&ccedil;&atilde;o: #ConfirmCode\r\n\r\nPara reenviar sua senha, por favor acesse:\r\n\r\n#ResendCodeLink', '#ApplicationName: Registration Confirmation Code, #Unit_Title', 'We have received a solicitation of registration in #ApplicationName, #Unit_Title, #Institution.  In order to complete your registration, we need to confirm that you controle this email addres. To do that, please access the link:\r\n\r\n#ConfirmLink\r\n\r\nYou may also complete your registration, acessing:\r\n\r\n#ConfirmLinkForm\r\n\r\nproviding the following information:\r\n\r\nUser: #Email\r\nConfirmation Code: #ConfirmCode\r\n\r\nIf needed, you may have the current confirmation code resent, please use:\r\n\r\n#ResendCodeLink', '#ApplicationName: Cadastro confirmado, #Unit_Title', 'Enviamos este email para confirmar seu cadastro no #ApplicationName, #Unit_Title, #Institution.\r\nPara acessar seu cadastro, por favor utilize o link\r\n\r\n#LoginLink\r\n\r\nUtilizando o Credencial:\r\n\r\nUsu&aacute;rio: #Email,\r\n\r\ne a senha cadastrado no in&iacute;cio deste cadastro.\r\n\r\nSe voc&ecirc; n&atilde;o est&aacute; conseguindo efetuar login, por favor, tente recuparar sua senha, acessando:\r\n\r\n#RecoverPasswordLink.', '#ApplicationName: Registration confirmed, #Unit_Title', 'We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Title, #Institution. \r\n\r\nPlease, access your registration, using the following link:\r\n\r\n#Href\r\n\r\nUsing as Login:\r\n\r\nUser: #Email,\r\n\r\nalong with the password used initiating this registration.\r\n\r\nIf you are unable to Login, please try to recover your password, acessing:\r\n\r\n#Href2.', '#ApplicationName: Reenvio de C&oacute;digo de Confirma&ccedil;&atilde;o, #Unit_Title', 'Recebemos uma solicita&ccedil;&atilde;o de reenvio de do c&oacute;digo de confirma&ccedil;&atilde;o. Para completar o cadastro, por favor acesse o link:\r\n\r\n#ConfirmLink\r\n\r\nVoc&ecirc; tamb&eacute;m pode confirmar seu cadastro, atrav&eacute;s do link:\r\n\r\n#ConfirmLinkForm\r\n\r\ninformando seu email como login no sistema junto com o c&oacute;digo de confirma&ccedil;&atilde;o abaixo:\r\n\r\nUsu&aacute;rio: #Email\r\nCode de Confirma&ccedil;&atilde;o: #ConfirmCode\r\n\r\nPara reenviar sua senha, por favor acesse:\r\n\r\n#ResendCodeLink', '#ApplicationName: Resending Confirmation Code, #Unit_Title', 'We have received a solicitation to resend your confirmation code.  In order to complete your registration, please access the link:\r\n\r\n#ConfirmLink\r\n\r\nYou may also complete your registration, acessing:\r\n\r\n#ConfirmLinkForm\r\n\r\nproviding the following information:\r\n\r\nUser: #Email\r\nConfirmation Code: #ConfirmCode\r\n\r\nIf needed, you may have the current confirmation code resent, please use:\r\n\r\n#ResendCodeLink', '#ApplicationName: Recupera&ccedil;&atilde;o de Senha, #Unit_Title', 'Recebemos uma solicita&ccedil;&atilde;o de recuperar a senha do login (email) #Email. Em baixo inlcuimos um c&oacute;digo gerado aleat&oacute;riamente, permitindo a altera&ccedil;&atilde;o da senha, por favor acesse este link:\r\n\r\n#RecoverLink\r\n\r\nAo completar a altera&ccedil;&atilde;o, voc&ecirc; receber&aacute; um email informativo pelo sistema.', '#ApplicationName: Password Recovery, #Unit_Title', 'We have received a solicitation to recover login to the account (email) #Email. Below we include a randomnly generated code, permitting you to change the password accessing:\r\n\r\n#RecoverLink\r\n\r\nCompleting the alteration, you will receive an informative email by the system.', '#ApplicationName: Recupera&ccedil;&atilde;o de Senha, #Unit_Title', 'Informamos que sua senha de acesso foi alterada conforme solicitado no sistema:\r\n\r\nUsu&aacute;rio: #Email\r\nSenha:  #NewPassword\r\n\r\nPara acessar o sistema, acesse:\r\n\r\n#LoginLink', '#ApplicationName: Password Recovery, #Unit_Title', 'We hereby informa that, as solicited in our system, yoiur password has been reset:\r\n\r\nUsu&aacute;rio: #Email\r\nSenha:  #NewPassword\r\n\r\nPlease use this link to access the system:\r\n\r\n#LoginLink', '#ApplicationName: Cadastro confirmado, #Unit_Title', 'Enviamos este email, para confirmar seu cadastro do #ApplicationName, #Unit_Title, #Institution.\r\nPara acessar seu cadastro, por favor utilize o link\r\n\r\n#Href\r\n\r\nUtilizando o Credencial:\r\n\r\nUsu&aacute;rio: #Email\r\n\r\nSe voc&ecirc; n&atilde;o est&aacute; conseguindo efetuar login, por favor, tente recuparar sua senha, acessando:\r\n\r\n#Href2.', '#ApplicationName: Registration confirmed, #Unit_Title', 'We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Title, #Institution. \r\n\r\nPlease, access your registration, using the following link:\r\n\r\n#Href\r\n\r\nUsing as Login:\r\n\r\nUsu&aacute;rio: #Email\r\n\r\nIf you are unable to Login, please to recover your password, acessing:\r\n\r\n#Href2.', '#ApplicationName: Cadastro confirmado, #Unit_Title', 'Enviamos este email, para confirmar seu cadastro do #ApplicationName, #Unit_Title, #Institution.\r\nPara acessar seu cadastro, por favor utilize o link\r\n\r\n#Href\r\n\r\nUtilizando o Credencial:\r\n\r\nUsu&aacute;rio: #Email\r\n\r\nSe voc&ecirc; n&atilde;o est&aacute; conseguindo efetuar login, por favor, tente recuparar sua senha, acessando:\r\n\r\n#Href2.', '#ApplicationName: Registration confirmed, #Unit_Title', 'We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Title, #Institution. \r\n\r\nPlease, access your registration, using the following link:\r\n\r\n#Href\r\n\r\nUsing as Login:\r\n\r\nUsu&aacute;rio: #Email\r\n\r\nIf you are unable to Login, please to recover your password, acessing:\r\n\r\n#Href2.', '#ApplicationName: Cadastro confirmado, #Unit_Title', 'Enviamos este email, para confirmar seu cadastro do #ApplicationName, #Unit_Title, #Institution.\r\nPara acessar seu cadastro, por favor utilize o link\r\n\r\n#Href\r\n\r\nUtilizando o Credencial:\r\n\r\nUsu&aacute;rio: #Email\r\n\r\nSe voc&ecirc; n&atilde;o est&aacute; conseguindo efetuar login, por favor, tente recuparar sua senha, acessando:\r\n\r\n#Href2.', '#ApplicationName: Registration confirmed, #Unit_Title', 'We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Title, #Institution. \r\n\r\nPlease, access your registration, using the following link:\r\n\r\n#Href\r\n\r\nUsing as Login:\r\n\r\nUsu&aacute;rio: #Email\r\n\r\nIf you are unable to Login, please to recover your password, acessing:\r\n\r\n#Href2.');

-- --------------------------------------------------------

--
-- Table structure for table `__Table__`
--

CREATE TABLE IF NOT EXISTS `__Table__` (
`ID` int(11) NOT NULL,
  `Name` varchar(256) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `__Table__`
--

INSERT INTO `__Table__` (`ID`, `Name`, `Time`) VALUES
(1, '2__Sessions', 1458475182),
(3, '1__Events', 1460751549),
(4, '1__Sessions', 1458475182),
(5, '1__2016__03__Logs', 1458475184),
(6, '1__Friends', 1460985435),
(7, 'Units', 1461043400),
(8, '2__Events', 1461340373),
(9, '2__2016__03__Logs', 1458475184),
(10, '2__Friends', 1461247360),
(11, '2__1_Datas', 1458475184),
(12, '2__1_GroupDatas', 1458475184),
(13, '2__1_Inscriptions', 1461252571),
(14, '2__Sponsors', 1459410748),
(15, '1__Sponsors', 1458815872),
(16, '2__Permissions', 1458820882),
(17, '2__2016__04__Logs', 1458475184),
(18, '1__2016__04__Logs', 1458475184),
(19, '2__1_Collaborations', 1460082645),
(20, '2__1_Collaborators', 1460083479),
(21, '2__1_Submissions', 1460082130),
(22, '2__1_Caravaneers', 1460082131),
(23, '__Sponsors', 1458815872),
(24, '2__0_Inscriptions', 1460751549),
(25, '1__1_Datas', 1458475184),
(26, '1__1_GroupDatas', 1458475184),
(27, '1__1_Inscriptions', 1460751549),
(28, '1__Permissions', 1458820882),
(29, '2__Certificates', 1461262663);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `1__1_Areas`
--
ALTER TABLE `1__1_Areas`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `1__1_Caravaneers`
--
ALTER TABLE `1__1_Caravaneers`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `1__1_Collaborations`
--
ALTER TABLE `1__1_Collaborations`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `1__1_Collaborators`
--
ALTER TABLE `1__1_Collaborators`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `1__1_Datas`
--
ALTER TABLE `1__1_Datas`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `1__1_GroupDatas`
--
ALTER TABLE `1__1_GroupDatas`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `1__1_Inscriptions`
--
ALTER TABLE `1__1_Inscriptions`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `1__1_Submissions`
--
ALTER TABLE `1__1_Submissions`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `1__Certificates`
--
ALTER TABLE `1__Certificates`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `1__Events`
--
ALTER TABLE `1__Events`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `1__Friends`
--
ALTER TABLE `1__Friends`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `1__Permissions`
--
ALTER TABLE `1__Permissions`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `1__Sessions`
--
ALTER TABLE `1__Sessions`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `1__Sponsors`
--
ALTER TABLE `1__Sponsors`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Units`
--
ALTER TABLE `Units`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `__Table__`
--
ALTER TABLE `__Table__`
 ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `1__1_Areas`
--
ALTER TABLE `1__1_Areas`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `1__1_Caravaneers`
--
ALTER TABLE `1__1_Caravaneers`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `1__1_Collaborations`
--
ALTER TABLE `1__1_Collaborations`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `1__1_Collaborators`
--
ALTER TABLE `1__1_Collaborators`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `1__1_Datas`
--
ALTER TABLE `1__1_Datas`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `1__1_GroupDatas`
--
ALTER TABLE `1__1_GroupDatas`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `1__1_Inscriptions`
--
ALTER TABLE `1__1_Inscriptions`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `1__1_Submissions`
--
ALTER TABLE `1__1_Submissions`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `1__Certificates`
--
ALTER TABLE `1__Certificates`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `1__Events`
--
ALTER TABLE `1__Events`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `1__Friends`
--
ALTER TABLE `1__Friends`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `1__Permissions`
--
ALTER TABLE `1__Permissions`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `1__Sessions`
--
ALTER TABLE `1__Sessions`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1626;
--
-- AUTO_INCREMENT for table `1__Sponsors`
--
ALTER TABLE `1__Sponsors`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Units`
--
ALTER TABLE `Units`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `__Table__`
--
ALTER TABLE `__Table__`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
