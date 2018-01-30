-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 28, 2018 at 01:44 PM
-- Server version: 10.1.26-MariaDB-0+deb9u1
-- PHP Version: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sivent2`
--

-- --------------------------------------------------------

--
-- Table structure for table `1__1_Areas`
--

CREATE TABLE `1__1_Areas` (
  `ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT '2',
  `Event` int(11) DEFAULT '1',
  `Name` varchar(256) DEFAULT NULL,
  `Name_UK` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `1__1_Caravaneers` (
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

CREATE TABLE `1__1_Collaborations` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `1__1_Collaborators` (
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

CREATE TABLE `1__1_Datas` (
  `ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT '1',
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
  `Friend` enum('0','1','2','3') DEFAULT '3',
  `CSS` varchar(64) DEFAULT NULL,
  `Width` varchar(64) DEFAULT '10',
  `Height` varchar(64) DEFAULT '1',
  `SValues` varchar(2096) DEFAULT NULL,
  `SValues_UK` varchar(2096) DEFAULT NULL,
  `Extensions` varchar(256) DEFAULT NULL,
  `DataGroup` int(11) DEFAULT NULL,
  `SqlSearch` enum('0','1','2') DEFAULT '1',
  `Assessor` enum('0','1','2','3') DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `1__1_GroupDatas`
--

CREATE TABLE `1__1_GroupDatas` (
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

CREATE TABLE `1__1_Inscriptions` (
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

CREATE TABLE `1__1_Submissions` (
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
-- Table structure for table `1__2018__01__Logs`
--

CREATE TABLE `1__2018__01__Logs` (
  `ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Debug` int(11) DEFAULT NULL,
  `IP` varchar(16) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL,
  `Month` int(11) DEFAULT NULL,
  `Date` int(11) DEFAULT NULL,
  `Profile` varchar(16) DEFAULT NULL,
  `Login` int(11) DEFAULT NULL,
  `ModuleName` varchar(255) DEFAULT NULL,
  `Action` varchar(255) DEFAULT NULL,
  `POST_Edit` int(11) DEFAULT NULL,
  `POST_Update` int(11) DEFAULT NULL,
  `POST_Transfer` int(11) DEFAULT NULL,
  `POST_Save` int(11) DEFAULT NULL,
  `Message` varchar(1024) DEFAULT NULL,
  `Unit` int(11) DEFAULT NULL,
  `Class` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `1__2018__01__Logs`
--

INSERT INTO `1__2018__01__Logs` (`ID`, `CTime`, `MTime`, `ATime`, `Debug`, `IP`, `Year`, `Month`, `Date`, `Profile`, `Login`, `ModuleName`, `Action`, `POST_Edit`, `POST_Update`, `POST_Transfer`, `POST_Save`, `Message`, `Unit`, `Class`) VALUES
(1, 1517153601, 1517153601, 1517153601, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN State SET DEFAULT &#039;9&#039;&lt;BR&gt;Alter 1__Events: State default =&gt; 9', 1, NULL),
(2, 1517153601, 1517153601, 1517153601, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Address SET DEFAULT &#039;Campus Samambaia, Caixa Postal 131&#039;&lt;BR&gt;Alter 1__Events: Address default =&gt; Campus Samambaia, Caixa Postal 131', 1, NULL),
(3, 1517153601, 1517153601, 1517153601, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Phone SET DEFAULT &#039;(55)(62) 3521-1208&#039;&lt;BR&gt;Alter 1__Events: Phone default =&gt; (55)(62) 3521-1208', 1, NULL),
(4, 1517153601, 1517153601, 1517153601, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Fax SET DEFAULT &#039;(55)(62) 3521-1208&#039;&lt;BR&gt;Alter 1__Events: Fax default =&gt; (55)(62) 3521-1208', 1, NULL),
(5, 1517153601, 1517153601, 1517153601, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Url SET DEFAULT &#039;http://www.mat.ufg.br&#039;&lt;BR&gt;Alter 1__Events: Url default =&gt; http://www.mat.ufg.br', 1, NULL),
(6, 1517153601, 1517153601, 1517153601, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Email SET DEFAULT &#039;secmat@mat.ufg.br&#039;&lt;BR&gt;Alter 1__Events: Email default =&gt; secmat@mat.ufg.br', 1, NULL),
(7, 1517153602, 1517153602, 1517153602, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Area SET DEFAULT &#039;Itatiaia&#039;&lt;BR&gt;Alter 1__Events: Area default =&gt; Itatiaia', 1, NULL),
(8, 1517153602, 1517153602, 1517153602, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN ZIP SET DEFAULT &#039;74001-970&#039;&lt;BR&gt;Alter 1__Events: ZIP default =&gt; 74001-970', 1, NULL),
(9, 1517153602, 1517153602, 1517153602, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Password SET DEFAULT &#039;your-password-here&#039;&lt;BR&gt;Alter 1__Events: Password default =&gt; your-password-here', 1, NULL),
(10, 1517153602, 1517153602, 1517153602, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN FromName SET DEFAULT &#039;SiVent2: Sistema de Gerenciamento de Eventos&#039;&lt;BR&gt;Alter 1__Events: FromName default =&gt; SiVent2: Sistema de Gerenciamento de Eventos', 1, NULL),
(11, 1517153602, 1517153602, 1517153602, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Unit SET DEFAULT &#039;1&#039;&lt;BR&gt;Alter 1__Events: Unit default =&gt; 1', 1, NULL),
(12, 1517153603, 1517153603, 1517153603, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Certificates SET DEFAULT &#039;1&#039;&lt;BR&gt;Alter 1__Events: Certificates default =&gt; 1', 1, NULL),
(13, 1517153603, 1517153603, 1517153603, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Certificates_Published SET DEFAULT &#039;1&#039;&lt;BR&gt;Alter 1__Events: Certificates_Published default =&gt; 1', 1, NULL),
(14, 1517153603, 1517153603, 1517153603, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN TimeLoad SET DEFAULT &#039;10&#039;&lt;BR&gt;Alter 1__Events: TimeLoad default =&gt; 10', 1, NULL),
(15, 1517153609, 1517153609, 1517153609, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Collaborations SET DEFAULT &#039;1&#039;&lt;BR&gt;Alter 1__Events: Collaborations default =&gt; 1', 1, NULL),
(16, 1517153609, 1517153609, 1517153609, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Collaborations_Inscriptions SET DEFAULT &#039;1&#039;&lt;BR&gt;Alter 1__Events: Collaborations_Inscriptions default =&gt; 1', 1, NULL),
(17, 1517153609, 1517153609, 1517153609, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Caravans SET DEFAULT &#039;1&#039;&lt;BR&gt;Alter 1__Events: Caravans default =&gt; 1', 1, NULL),
(18, 1517153610, 1517153610, 1517153610, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Caravans_Min SET DEFAULT &#039;20&#039;&lt;BR&gt;Alter 1__Events: Caravans_Min default =&gt; 20', 1, NULL),
(19, 1517153610, 1517153610, 1517153610, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Caravans_Max SET DEFAULT &#039;40&#039;&lt;BR&gt;Alter 1__Events: Caravans_Max default =&gt; 40', 1, NULL),
(20, 1517153611, 1517153611, 1517153611, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Submissions SET DEFAULT &#039;1&#039;&lt;BR&gt;Alter 1__Events: Submissions default =&gt; 1', 1, NULL),
(21, 1517153612, 1517153612, 1517153612, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Submissions_Inscriptions SET DEFAULT &#039;1&#039;&lt;BR&gt;Alter 1__Events: Submissions_Inscriptions default =&gt; 1', 1, NULL),
(22, 1517153612, 1517153612, 1517153612, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Submissions_Public SET DEFAULT &#039;1&#039;&lt;BR&gt;Alter 1__Events: Submissions_Public default =&gt; 1', 1, NULL),
(23, 1517153616, 1517153616, 1517153616, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SiVent2', 1, NULL),
(24, 1517153616, 1517153616, 1517153616, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN State SET DEFAULT &#039;9&#039;&lt;BR&gt;Alter Units: State default =&gt; 9', 1, NULL),
(25, 1517153616, 1517153616, 1517153616, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Auth SET DEFAULT &#039;2&#039;&lt;BR&gt;Alter Units: Auth default =&gt; 2', 1, NULL),
(26, 1517153617, 1517153617, 1517153617, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Secure SET DEFAULT &#039;2&#039;&lt;BR&gt;Alter Units: Secure default =&gt; 2', 1, NULL),
(27, 1517153621, 1517153621, 1517153621, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Sponsors` ALTER COLUMN Unit SET DEFAULT &#039;1&#039;&lt;BR&gt;Alter 1__Sponsors: Unit default =&gt; 1', 1, NULL),
(28, 1517153621, 1517153621, 1517153621, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Sponsors` ALTER COLUMN Event SET DEFAULT &#039;1&#039;&lt;BR&gt;Alter 1__Sponsors: Event default =&gt; 1', 1, NULL),
(29, 1517153621, 1517153621, 1517153621, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Sponsors` ALTER COLUMN Place SET DEFAULT &#039;1&#039;&lt;BR&gt;Alter 1__Sponsors: Place default =&gt; 1', 1, NULL),
(30, 1517153621, 1517153621, 1517153621, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, 'Events', 'Download', NULL, NULL, NULL, NULL, 'ALTER TABLE `1__1_Datas` ALTER COLUMN Unit SET DEFAULT &#039;1&#039;&lt;BR&gt;Alter 1__1_Datas: Unit default =&gt; 1', 1, NULL),
(31, 1517153622, 1517153622, 1517153622, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, 'Events', 'Download', NULL, NULL, NULL, NULL, 'ALTER TABLE `1__1_Datas` ALTER COLUMN Friend SET DEFAULT &#039;3&#039;&lt;BR&gt;Alter 1__1_Datas: Friend default =&gt; 3', 1, NULL),
(32, 1517153625, 1517153625, 1517153625, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, 'Events', 'Download', NULL, NULL, NULL, NULL, 'MyMod_Handle', 1, NULL),
(33, 1517153951, 1517153951, 1517153951, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SiVent2', 1, NULL),
(34, 1517153952, 1517153952, 1517153952, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, 'Events', 'Download', NULL, NULL, NULL, NULL, 'MyMod_Handle', 1, NULL),
(35, 1517153952, 1517153952, 1517153952, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, 'Events', 'Download', NULL, NULL, NULL, NULL, 'MyMod_Handle', 1, NULL),
(36, 1517154104, 1517154104, 1517154104, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` CHANGE Sivent2URL Sivent2URL VARCHAR(256)&lt;BR&gt;Alter 1__Events: Sivent2URL length =&gt; VARCHAR(256)', 1, NULL),
(37, 1517154104, 1517154104, 1517154104, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Address SET DEFAULT &#039;MyAddress&#039;&lt;BR&gt;Alter 1__Events: Address default =&gt; MyAddress', 1, NULL),
(38, 1517154104, 1517154104, 1517154104, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Phone SET DEFAULT &#039;(++55)(DD) 1234-5678&#039;&lt;BR&gt;Alter 1__Events: Phone default =&gt; (++55)(DD) 1234-5678', 1, NULL),
(39, 1517154104, 1517154104, 1517154104, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Fax SET DEFAULT &#039;(++55)(DD) 1234-5678&#039;&lt;BR&gt;Alter 1__Events: Fax default =&gt; (++55)(DD) 1234-5678', 1, NULL),
(40, 1517154104, 1517154104, 1517154104, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Url SET DEFAULT &#039;http://www.mysite.com.br&#039;&lt;BR&gt;Alter 1__Events: Url default =&gt; http://www.mysite.com.br', 1, NULL),
(41, 1517154104, 1517154104, 1517154104, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Email SET DEFAULT &#039;my-org-email@somewhere.com&#039;&lt;BR&gt;Alter 1__Events: Email default =&gt; my-org-email@somewhere.com', 1, NULL),
(42, 1517154104, 1517154104, 1517154104, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN City SET DEFAULT &#039;My City&#039;&lt;BR&gt;Alter 1__Events: City default =&gt; My City', 1, NULL),
(43, 1517154104, 1517154104, 1517154104, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN Area SET DEFAULT &#039;My Area&#039;&lt;BR&gt;Alter 1__Events: Area default =&gt; My Area', 1, NULL),
(44, 1517154104, 1517154104, 1517154104, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN ZIP SET DEFAULT &#039;NNNNN-MMM&#039;&lt;BR&gt;Alter 1__Events: ZIP default =&gt; NNNNN-MMM', 1, NULL),
(45, 1517154104, 1517154104, 1517154104, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN User SET DEFAULT &#039;your-email-here@gmail.com&#039;&lt;BR&gt;Alter 1__Events: User default =&gt; your-email-here@gmail.com', 1, NULL),
(46, 1517154104, 1517154104, 1517154104, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN FromEmail SET DEFAULT &#039;your-email-here@gmail.com&#039;&lt;BR&gt;Alter 1__Events: FromEmail default =&gt; your-email-here@gmail.com', 1, NULL),
(47, 1517154104, 1517154104, 1517154104, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN ReplyTo SET DEFAULT &#039;your-email-here@gmail.com&#039;&lt;BR&gt;Alter 1__Events: ReplyTo default =&gt; your-email-here@gmail.com', 1, NULL),
(48, 1517154104, 1517154104, 1517154104, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `1__Events` ALTER COLUMN BCCEmail SET DEFAULT &#039;your-email-here@gmail.com&#039;&lt;BR&gt;Alter 1__Events: BCCEmail default =&gt; your-email-here@gmail.com', 1, NULL),
(49, 1517154104, 1517154104, 1517154104, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SiVent2', 1, NULL),
(50, 1517154105, 1517154105, 1517154105, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Register_PT SET DEFAULT &#039;0 &#039;&lt;BR&gt;Alter Units: Register_PT default =&gt; 0 ', 1, NULL),
(51, 1517154105, 1517154105, 1517154105, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Register_UK SET DEFAULT &#039;0 &#039;&lt;BR&gt;Alter Units: Register_UK default =&gt; 0 ', 1, NULL),
(52, 1517154105, 1517154105, 1517154105, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Confirm_PT SET DEFAULT &#039;0 &#039;&lt;BR&gt;Alter Units: Confirm_PT default =&gt; 0 ', 1, NULL),
(53, 1517154105, 1517154105, 1517154105, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Confirm_UK SET DEFAULT &#039;0 &#039;&lt;BR&gt;Alter Units: Confirm_UK default =&gt; 0 ', 1, NULL),
(54, 1517154105, 1517154105, 1517154105, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Confirm_Resend_PT SET DEFAULT &#039;0 &#039;&lt;BR&gt;Alter Units: Confirm_Resend_PT default =&gt; 0 ', 1, NULL),
(55, 1517154105, 1517154105, 1517154105, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Confirm_Resend_UK SET DEFAULT &#039;0 &#039;&lt;BR&gt;Alter Units: Confirm_Resend_UK default =&gt; 0 ', 1, NULL),
(56, 1517154105, 1517154105, 1517154105, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Password_Reset_PT SET DEFAULT &#039;0 &#039;&lt;BR&gt;Alter Units: Password_Reset_PT default =&gt; 0 ', 1, NULL),
(57, 1517154105, 1517154105, 1517154105, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Password_Reset_UK SET DEFAULT &#039;0 &#039;&lt;BR&gt;Alter Units: Password_Reset_UK default =&gt; 0 ', 1, NULL),
(58, 1517154105, 1517154105, 1517154105, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Password_Changed_PT SET DEFAULT &#039;0 &#039;&lt;BR&gt;Alter Units: Password_Changed_PT default =&gt; 0 ', 1, NULL),
(59, 1517154105, 1517154105, 1517154105, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Password_Changed_UK SET DEFAULT &#039;0 &#039;&lt;BR&gt;Alter Units: Password_Changed_UK default =&gt; 0 ', 1, NULL),
(60, 1517154105, 1517154105, 1517154105, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Email_Created_PT SET DEFAULT &#039;0 &#039;&lt;BR&gt;Alter Units: Email_Created_PT default =&gt; 0 ', 1, NULL),
(61, 1517154105, 1517154105, 1517154105, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Email_Created_UK SET DEFAULT &#039;0 &#039;&lt;BR&gt;Alter Units: Email_Created_UK default =&gt; 0 ', 1, NULL),
(62, 1517154105, 1517154105, 1517154105, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Email_Change_PT SET DEFAULT &#039;0 &#039;&lt;BR&gt;Alter Units: Email_Change_PT default =&gt; 0 ', 1, NULL),
(63, 1517154105, 1517154105, 1517154105, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Email_Change_UK SET DEFAULT &#039;0 &#039;&lt;BR&gt;Alter Units: Email_Change_UK default =&gt; 0 ', 1, NULL),
(64, 1517154105, 1517154105, 1517154105, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Email_Changed_PT SET DEFAULT &#039;0 &#039;&lt;BR&gt;Alter Units: Email_Changed_PT default =&gt; 0 ', 1, NULL),
(65, 1517154105, 1517154105, 1517154105, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALTER TABLE `Units` ALTER COLUMN Email_Changed_UK SET DEFAULT &#039;0 &#039;&lt;BR&gt;Alter Units: Email_Changed_UK default =&gt; 0 ', 1, NULL),
(66, 1517154106, 1517154106, 1517154106, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, 'Events', 'Download', NULL, NULL, NULL, NULL, 'MyMod_Handle', 1, NULL),
(67, 1517154107, 1517154107, 1517154107, 5, '127.0.0.1', 2018, 201801, 20180128, 'Public', NULL, 'Events', 'Download', NULL, NULL, NULL, NULL, 'MyMod_Handle', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `1__Certificates`
--

CREATE TABLE `1__Certificates` (
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

CREATE TABLE `1__Events` (
  `ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT '1',
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
  `State` enum('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30') DEFAULT '9',
  `Address` varchar(255) DEFAULT 'MyAddress',
  `Phone` varchar(255) DEFAULT '(++55)(DD) 1234-5678',
  `Fax` varchar(255) DEFAULT '(++55)(DD) 1234-5678',
  `Url` varchar(255) DEFAULT 'http://www.mysite.com.br',
  `Email` varchar(255) DEFAULT 'my-org-email@somewhere.com',
  `City` varchar(256) DEFAULT 'My City',
  `Area` varchar(256) DEFAULT 'My Area',
  `ZIP` varchar(256) DEFAULT 'NNNNN-MMM',
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
  `User` varchar(256) DEFAULT 'your-email-here@gmail.com',
  `Password` varchar(256) DEFAULT 'your-password-here',
  `FromEmail` varchar(256) DEFAULT 'your-email-here@gmail.com',
  `FromName` varchar(256) DEFAULT 'SiVent2: Sistema de Gerenciamento de Eventos',
  `ReplyTo` varchar(256) DEFAULT 'your-email-here@gmail.com',
  `BCCEmail` varchar(256) DEFAULT 'your-email-here@gmail.com',
  `HtmlLogoHeight` int(11) DEFAULT NULL,
  `HtmlLogoWidth` int(11) DEFAULT NULL,
  `Certificates` enum('0','1','2') DEFAULT '1',
  `Certificates_Published` enum('0','1','2') DEFAULT '1',
  `EventStart` int(11) DEFAULT NULL,
  `EventEnd` int(11) DEFAULT NULL,
  `Collaborations` enum('0','1','2') DEFAULT '1',
  `Collaborations_Inscriptions` enum('0','1','2') DEFAULT '1',
  `Collaborations_StartDate` int(11) DEFAULT NULL,
  `Collaborations_EndDate` int(11) DEFAULT NULL,
  `Caravans` enum('0','1','2') DEFAULT '1',
  `Caravans_StartDate` int(11) DEFAULT NULL,
  `Caravans_EndDate` int(11) DEFAULT NULL,
  `Caravans_Min` int(11) DEFAULT '20',
  `Caravans_Max` int(11) DEFAULT '40',
  `Submissions` enum('0','1','2') DEFAULT '1',
  `Submissions_StartDate` int(11) DEFAULT NULL,
  `Submissions_Inscriptions` enum('0','1','2') DEFAULT '1',
  `Submissions_EndDate` int(11) DEFAULT NULL,
  `Submissions_Public` enum('0','1','2') DEFAULT '1',
  `TimeLoad` varchar(8) DEFAULT '10',
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
  `Certificates_Latex` text,
  `Sivent2URL` varchar(256) DEFAULT NULL,
  `Online` enum('0','1','2') DEFAULT '1',
  `Online_Message` varchar(256) DEFAULT 'Temporarily Offline due to system maintainance',
  `Initials` varchar(64) DEFAULT NULL,
  `Inscriptions_Public` enum('0','1','2') DEFAULT '1',
  `Site` varchar(256) DEFAULT NULL,
  `Updated_From` int(11) DEFAULT NULL,
  `Certificates_Latex_Sep_Vertical` double DEFAULT '3.5',
  `Certificates_Latex_Sep_Horisontal` double DEFAULT '2',
  `Certificates_Latex_UK` text,
  `Visible` enum('0','1','2') DEFAULT '1',
  `Place` varchar(256) DEFAULT NULL,
  `Place_Address` varchar(256) DEFAULT NULL,
  `Place_Site` varchar(256) DEFAULT NULL,
  `Info` text,
  `Schedule_Public` enum('0','1','2') DEFAULT '1',
  `Selection` enum('0','1','2') DEFAULT '1',
  `Payments` enum('0','1','2') DEFAULT '1',
  `Payments_Type` enum('0','1') DEFAULT '1',
  `Payments_URL` varchar(64) DEFAULT NULL,
  `Payments_Info` varchar(256) DEFAULT NULL,
  `Payments_Institution` varchar(64) DEFAULT NULL,
  `Payments_Name` varchar(64) DEFAULT NULL,
  `Payments_Agency` varchar(64) DEFAULT NULL,
  `Payments_Operation` varchar(64) DEFAULT NULL,
  `Payments_Account` varchar(64) DEFAULT NULL,
  `Payments_Variation` varchar(64) DEFAULT NULL,
  `Certificates_Collaborations_Latex` text,
  `Certificates_Collaborations_Latex_UK` text,
  `Caravans_Timeload` int(11) DEFAULT '10',
  `Caravans_Coord_Timeload` int(11) DEFAULT '20',
  `Certificates_Caravans_Latex` text,
  `Certificates_Caravaneers_Latex` text,
  `Certificates_Caravaneers_Latex_UK` text,
  `Submissions_NAuthors` int(11) DEFAULT '3',
  `Certificates_Submissions_Latex` text,
  `Certificates_Submissions_Latex_UK` text,
  `Certificates_Submissions_TimeLoad` varchar(8) DEFAULT '2',
  `Proceedings` enum('0','1','2') DEFAULT '1',
  `Proceedings_DocType` enum('0','1','2','3') DEFAULT '1',
  `Proceedings_DocType_Options` varchar(256) DEFAULT 'a4paper',
  `Proceedings_Preamble` text,
  `Proceedings_Postamble` text,
  `Assessments` enum('0','1','2') DEFAULT '1',
  `Assessments_StartDate` int(11) DEFAULT NULL,
  `Assessments_EndDate` int(11) DEFAULT NULL,
  `PreInscriptions_StartDate` int(11) DEFAULT NULL,
  `PreInscriptions_EndDate` int(11) DEFAULT NULL,
  `PreInscriptions_MustHavePaid` enum('0','1','2') DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `1__Events`
--

INSERT INTO `1__Events` (`ID`, `CTime`, `MTime`, `ATime`, `Unit`, `Name`, `Name_UK`, `Title`, `Title_UK`, `AnnouncementLink`, `Date`, `StartDate`, `EndDate`, `EditDate`, `Announcement`, `Announcement_OrigName`, `Announcement_Contents`, `Announcement_Time`, `Announcement_Size`, `Status`, `State`, `Address`, `Phone`, `Fax`, `Url`, `Email`, `City`, `Area`, `ZIP`, `HtmlIcon1`, `HtmlIcon1_OrigName`, `HtmlIcon1_Contents`, `HtmlIcon1_Time`, `HtmlIcon1_Size`, `HtmlIcon2`, `HtmlIcon2_OrigName`, `HtmlIcon2_Contents`, `HtmlIcon2_Time`, `HtmlIcon2_Size`, `LatexIcon1`, `LatexIcon1_OrigName`, `LatexIcon1_Contents`, `LatexIcon1_Time`, `LatexIcon1_Size`, `LatexIcon2`, `LatexIcon2_OrigName`, `LatexIcon2_Contents`, `LatexIcon2_Time`, `LatexIcon2_Size`, `Auth`, `Secure`, `Port`, `Host`, `User`, `Password`, `FromEmail`, `FromName`, `ReplyTo`, `BCCEmail`, `HtmlLogoHeight`, `HtmlLogoWidth`, `Certificates`, `Certificates_Published`, `EventStart`, `EventEnd`, `Collaborations`, `Collaborations_Inscriptions`, `Collaborations_StartDate`, `Collaborations_EndDate`, `Caravans`, `Caravans_StartDate`, `Caravans_EndDate`, `Caravans_Min`, `Caravans_Max`, `Submissions`, `Submissions_StartDate`, `Submissions_Inscriptions`, `Submissions_EndDate`, `Submissions_Public`, `TimeLoad`, `Certificates_Watermark`, `Certificates_Watermark_OrigName`, `Certificates_Watermark_Contents`, `Certificates_Watermark_Time`, `Certificates_Watermark_Size`, `Certificates_Signature_1`, `Certificates_Signature_1_OrigName`, `Certificates_Signature_1_Contents`, `Certificates_Signature_1_Time`, `Certificates_Signature_1_Size`, `Certificates_Signature_1_Text1`, `Certificates_Signature_1_Text2`, `Certificates_Signature_2`, `Certificates_Signature_2_OrigName`, `Certificates_Signature_2_Contents`, `Certificates_Signature_2_Time`, `Certificates_Signature_2_Size`, `Certificates_Signature_2_Text1`, `Certificates_Signature_2_Text2`, `Certificates_Signature_3`, `Certificates_Signature_3_OrigName`, `Certificates_Signature_3_Contents`, `Certificates_Signature_3_Time`, `Certificates_Signature_3_Size`, `Certificates_Signature_3_Text1`, `Certificates_Signature_3_Text2`, `Certificates_Latex`, `Sivent2URL`, `Online`, `Online_Message`, `Initials`, `Inscriptions_Public`, `Site`, `Updated_From`, `Certificates_Latex_Sep_Vertical`, `Certificates_Latex_Sep_Horisontal`, `Certificates_Latex_UK`, `Visible`, `Place`, `Place_Address`, `Place_Site`, `Info`, `Schedule_Public`, `Selection`, `Payments`, `Payments_Type`, `Payments_URL`, `Payments_Info`, `Payments_Institution`, `Payments_Name`, `Payments_Agency`, `Payments_Operation`, `Payments_Account`, `Payments_Variation`, `Certificates_Collaborations_Latex`, `Certificates_Collaborations_Latex_UK`, `Caravans_Timeload`, `Caravans_Coord_Timeload`, `Certificates_Caravans_Latex`, `Certificates_Caravaneers_Latex`, `Certificates_Caravaneers_Latex_UK`, `Submissions_NAuthors`, `Certificates_Submissions_Latex`, `Certificates_Submissions_Latex_UK`, `Certificates_Submissions_TimeLoad`, `Proceedings`, `Proceedings_DocType`, `Proceedings_DocType_Options`, `Proceedings_Preamble`, `Proceedings_Postamble`, `Assessments`, `Assessments_StartDate`, `Assessments_EndDate`, `PreInscriptions_StartDate`, `PreInscriptions_EndDate`, `PreInscriptions_MustHavePaid`) VALUES
(1, 1458648823, 1461346861, 1461346861, 2, 'FLISOL-GYN', 'FLISOL-GYN', 'FLISOL, Goi&acirc;nia', 'FLISOL, Goi&acirc;nia', 'http://aslgo.org.br/comunidades/49-psl-go.htm', 20160322, 20160322, 20160419, 20160419, NULL, NULL, NULL, NULL, NULL, '3', '9', NULL, NULL, NULL, 'http://aslgo.org.br/comunidades/49-psl-go.html', 'mail@aslgo.org.br', 'Goi&acirc;nia', 'Itatiaia', '74001-970', 'Uploads/2/Events/HtmlIcon1_1.png', 'flisol.png', NULL, NULL, NULL, 'Uploads/2/Events/HtmlIcon2_1.png', 'flisol.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', '465', 'smtp.gmail.com', 'siga.ime.ufg@gmail.com', 'your-password-here', 'siga.ime.ufg@gmail.com', 'SiVent2: Sistema de Gerenciamento de Eventos', 'siga.ime.ufg@gmail.com', 'siga.ime.ufg@gmail.com', 100, 150, '2', '2', 20160416, 20160416, '2', '1', NULL, NULL, '1', NULL, NULL, NULL, NULL, '2', NULL, '1', NULL, '1', '8', 'Uploads/2/Events/Certificates_Watermark_1.jpg', 'Flisol2015.Gyn.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '&#92;vspace{5.5cm}\r\n\r\n&#92;begin{huge}\r\nCertificamos que:\r\n\r\n&#92;begin{center}&#92;Huge{&#92;textbf{#Friend_Name}}&#92;end{center}\r\n\r\nparticipou do &#92;textbf{FLISOL}, Festival Latinoamericano de Instala&ccedil;&atilde;o de Software Livre,realizado na &#92;textbf{Faculdade FATESG}, Goi&acirc;nia-GO, no dia &#92;textit{16 de Abril de 2016}, \r\ncom carga hor&aacute;ria de &#92;textbf{#Inscription_Certificate_CH horas}.\r\n&#92;end{huge}\r\n\r\n &#92;vspace{1cm}', NULL, '1', 'Temporarily Offline due to system maintainance', NULL, '1', NULL, NULL, 3.5, 2, NULL, '1', NULL, NULL, NULL, NULL, '1', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 20, NULL, NULL, NULL, 3, NULL, NULL, '2', '1', '1', 'a4paper', NULL, NULL, '1', NULL, NULL, NULL, NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `1__Friends`
--

CREATE TABLE `1__Friends` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `1__Friends`
--

INSERT INTO `1__Friends` (`ID`, `CTime`, `MTime`, `ATime`, `Language`, `Name`, `TextName`, `Email`, `Password`, `RecoverCode`, `RecoverMTime`, `CondEmail`, `ConfirmCode`, `ConfirmDate`, `Titulation`, `Institution`, `Phone`, `Cell`, `Address`, `Lattes`, `Profile_Coordinator`, `Profile_Friend`, `Profile_Admin`, `NickName`, `Curriculum`, `Unit`) VALUES
(1, 1433549097, 1433549097, 1458874977, 'PT', 'My Adminstrator', 'My Adminstrator', 'admin-email@somewhere.com', '25d55ad283aa400af464c76d713c07ad', '16283791071439324899', 1460392324, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2', '2', '2', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `1__Permissions`
--

CREATE TABLE `1__Permissions` (
  `ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT '2',
  `Event` int(11) DEFAULT NULL,
  `User` int(11) DEFAULT NULL,
  `Comment` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `1__Permissions`
--

INSERT INTO `1__Permissions` (`ID`, `CTime`, `MTime`, `ATime`, `Unit`, `Event`, `User`, `Comment`) VALUES
(1, 1458820125, 1458820125, 1458873945, 2, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `1__Sessions`
--

CREATE TABLE `1__Sessions` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `1__Sponsors`
--

CREATE TABLE `1__Sponsors` (
  `ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT '1',
  `Event` int(11) DEFAULT '1',
  `Initials` varchar(256) DEFAULT NULL,
  `Name` varchar(256) DEFAULT NULL,
  `URL` varchar(255) DEFAULT NULL,
  `Text` varchar(255) DEFAULT NULL,
  `Logo` varchar(256) DEFAULT NULL,
  `Logo_OrigName` varchar(256) DEFAULT NULL,
  `Logo_Contents` mediumblob,
  `Logo_Time` int(11) DEFAULT NULL,
  `Logo_Size` int(11) DEFAULT NULL,
  `Place` enum('0','1','2','3') DEFAULT '1',
  `Height` int(11) DEFAULT '100',
  `Width` int(11) DEFAULT '150',
  `Level` enum('0','1','2','3') DEFAULT NULL,
  `Value` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `MailTypes`
--

CREATE TABLE `MailTypes` (
  `ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Unit` int(11) DEFAULT NULL,
  `Language` varchar(4) DEFAULT NULL,
  `Name` varchar(256) DEFAULT NULL,
  `Subject` text,
  `Body` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `MailTypes`
--

INSERT INTO `MailTypes` (`ID`, `CTime`, `MTime`, `ATime`, `Unit`, `Language`, `Name`, `Subject`, `Body`) VALUES
(1, 1517153622, 1517153622, 1517153622, 1, 'PT', 'Register', '#ApplicationName: CÃ³digo de ConfirmaÃ§Ã£o,  #Unit_Name, #Unit_Title', 'Recebemos uma solicitaÃ§Ã£o de cadastro em #ApplicationName, #Unit_Name, #Unit_Title. Para completar o cadastro, precisamos verificar que vocÃª controla este email. Para neste fim, por favor acesse o link:\n\n#ConfirmLink\n\nVocÃª tambÃ©m pode confirmar seu cadastro, atravÃ©s do link:\n\n#ConfirmLinkForm\n\ninformando seu email como login no sistema junto com o cÃ³digo de confirmaÃ§Ã£o abaixo:\n\nUsuÃ¡rio: #Email\nCode de ConfirmaÃ§Ã£o: #ConfirmCode\n\nPara reenviar sua senha, por favor acesse:\n\n#ResendCodeLink\n'),
(2, 1517153622, 1517153622, 1517153622, 1, 'UK', 'Register', '#ApplicationName: Registration Confirmation Code, #Unit_Title', 'We have received a solicitation of registration in #ApplicationName, #Unit_Title, #Institution. In order to complete your registration, we need to confirm that you controle this email addres. To do that, please access the link:\r\n\r\n#ConfirmLink\r\n\r\nYou may also complete your registration, acessing:\r\n\r\n#ConfirmLinkForm\r\n\r\nproviding the following information:\r\n\r\nUser: #Email\r\nConfirmation Code: #ConfirmCode\r\n\r\nIf needed, you may have the current confirmation code resent, please use:\r\n\r\n#ResendCodeLink'),
(3, 1517153622, 1517153622, 1517153622, 1, 'PT', 'Confirm', '#ApplicationName: Cadastro confirmado, #Unit_Name, #Unit_Title', 'Enviamos este email para confirmar seu cadastro no #ApplicationName, #Unit_Name, #Unit_Title.\n\nPara acessar seu cadastro, por favor utilize o link\n\n#LoginLink\n\nUtilizando o Credencial:\n\nUsuÃ¡rio: #Email\n\ne a senha cadastrado no inÃ­cio deste cadastro.\n\nSe vocÃª nÃ£o estÃ¡ conseguindo efetuar login, por favor, tente recuparar sua senha, acessando:\n\n#RecoverPasswordLink\n'),
(4, 1517153622, 1517153622, 1517153622, 1, 'UK', 'Confirm', '#ApplicationName: Registration confirmed, #Unit_Title', 'We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Title, #Institution. \r\n\r\nPlease, access your registration, using the following link:\r\n\r\n#Href\r\n\r\nUsing as Login:\r\n\r\nUser: #Email,\r\n\r\nalong with the password used initiating this registration.\r\n\r\nIf you are unable to Login, please try to recover your password, acessing:\r\n\r\n#Href2.'),
(5, 1517153622, 1517153622, 1517153622, 1, 'PT', 'Confirm_Resend', '#ApplicationName: Reenvio de CÃ³digo de ConfirmaÃ§Ã£o, #Unit_Name, #Unit_Title', 'Recebemos uma solicitaÃ§Ã£o de reenvio de do cÃ³digo de confirmaÃ§Ã£o. Para completar o cadastro, por favor acesse o link:\n\n#ConfirmLink\n\nVocÃª tambÃ©m pode confirmar seu cadastro, atravÃ©s do link:\n\n#ConfirmLinkForm,\n\ninformando seu email como login no sistema junto com o cÃ³digo de confirmaÃ§Ã£o abaixo:\n\nUsuÃ¡rio: #Email\nCode de ConfirmaÃ§Ã£o: #ConfirmCode\n\nPara reenviar sua senha, por favor acesse:\n\n#ResendCodeLink\n\n'),
(6, 1517153622, 1517153622, 1517153622, 1, 'UK', 'Confirm_Resend', '#ApplicationName: Resending Confirmation Code, #Unit_Title', 'We have received a solicitation to resend your confirmation code. In order to complete your registration, please access the link:\r\n\r\n#ConfirmLink\r\n\r\nYou may also complete your registration, acessing:\r\n\r\n#ConfirmLinkForm\r\n\r\nproviding the following information:\r\n\r\nUser: #Email\r\nConfirmation Code: #ConfirmCode\r\n\r\nIf needed, you may have the current confirmation code resent, please use:\r\n\r\n#ResendCodeLink'),
(7, 1517153622, 1517153622, 1517153622, 1, 'PT', 'Password_Reset', '#ApplicationName: RecuperaÃ§Ã£o de Senha, #Unit_Name, #Unit_Title', 'Recebemos uma solicitaÃ§Ã£o de recuperar a senha do login (email) #Email. Em baixo inlcuimos um cÃ³digo gerado aleatÃ³riamente, permitindo a alteraÃ§Ã£o da senha, por favor acesse este link:\n\n#RecoverLink\n\nAo completar a alteraÃ§Ã£o, vocÃª receberÃ¡ um email informativo pelo sistema.\n\n'),
(8, 1517153622, 1517153622, 1517153622, 1, 'UK', 'Password_Reset', '#ApplicationName: Password Recovery, #Unit_Title', 'We have received a solicitation to recover login to the account (email) #Email. Below we include a randomnly generated code, permitting you to change the password accessing:\r\n\r\n#RecoverLink\r\n\r\nCompleting the alteration, you will receive an informative email by the system.'),
(9, 1517153622, 1517153622, 1517153622, 1, 'PT', 'Password_Changed', '#ApplicationName: Senha alterada, #Unit_Name, #Unit_Title', 'Informamos que sua senha foi alterada:\n\nUsuÃ¡rio: #Email\nSenha: #NewPassword\n\nPor favor, acesse seu cadastro, utilizando o seguinte link:\n\n#LoginLink'),
(10, 1517153622, 1517153622, 1517153622, 1, 'UK', 'Password_Changed', '#ApplicationName: Password Recovery, #Unit_Title', 'We hereby informa that, as solicited in our system, yoiur password has been reset:\r\n\r\nUsu&aacute;rio: #Email\r\nSenha: #NewPassword\r\n\r\nPlease use this link to access the system:\r\n\r\n#LoginLink'),
(11, 1517153623, 1517153623, 1517153623, 1, 'PT', 'Email_Created', '#ApplicationName: Cadastro de UsÃ¡rio Efetuada, #Unit_Name, #Unit_Title', 'Enviamos este email, para confirmar seu cadastro do #ApplicationName, #Unit_Name, #Unit_Title.\n\nPara acessar seu cadastro, por favor utilize o link:\n\n#LoginLink\n\nUtilizando os Credencias:\n\nUsuÃ¡rio: #Email\nSenha: #Password\n\nSe vocÃª nÃ£o estÃ¡ conseguindo efetuar login, por favor, tente recuparar sua senha, acessando:\n\n#RecoverLoginLink.\n\nRecomandamos a alteraÃ§Ã£o da senha no primeiro acesso ao sistema'),
(12, 1517153623, 1517153623, 1517153623, 1, 'UK', 'Email_Created', '#ApplicationName: Registration confirmed, #Unit_Title', 'We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Title, #Institution. \r\n\r\nPlease, access your registration, using the following link:\r\n\r\n#Href\r\n\r\nUsing as Login:\r\n\r\nUsu&aacute;rio: #Email\r\n\r\nIf you are unable to Login, please to recover your password, acessing:\r\n\r\n#Href2.'),
(13, 1517153623, 1517153623, 1517153623, 1, 'PT', 'Email_Change', '#ApplicationName: AlteraÃ§Ã£o de EndereÃ§o EletrÃ´nico, #Unit_Name, #Unit_Title', 'Prezado(a) #Name\n\nRecebemos um pedido de alteraÃ§Ã£o de email (utilizado como login em #ApplicationName).\n\nPara proseguir com este alteraÃ§Ã£o, efetue login no #ApplicationName, acesse o link Alterar Email no menu esquerdo, e preenche os dados:\n\nEmail: #Email\nNovo Email: #NewEmail\nCÃ³digo de ConfirmaÃ§Ã£o: #RecoverCode\n\nAtenciosamente,'),
(14, 1517153623, 1517153623, 1517153623, 1, 'UK', 'Email_Change', '#ApplicationName: Registration confirmed, #Unit_Title', 'We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Title, #Institution. \r\n\r\nPlease, access your registration, using the following link:\r\n\r\n#Href\r\n\r\nUsing as Login:\r\n\r\nUsu&aacute;rio: #Email\r\n\r\nIf you are unable to Login, please to recover your password, acessing:\r\n\r\n#Href2.'),
(15, 1517153623, 1517153623, 1517153623, 1, 'UK', 'Email_Change', '#ApplicationName: Registration confirmed, #Unit_Title', 'We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Title, #Institution. \r\n\r\nPlease, access your registration, using the following link:\r\n\r\n#Href\r\n\r\nUsing as Login:\r\n\r\nUsu&aacute;rio: #Email\r\n\r\nIf you are unable to Login, please to recover your password, acessing:\r\n\r\n#Href2.'),
(16, 1517153623, 1517153623, 1517153623, 1, 'PT', 'Email_Changed', '#ApplicationName: AlteraÃ§Ã£o de EndereÃ§o EletrÃ´nico, #Unit_Name, #Unit_Title', 'Prezado(a) #Name\n\nConforme solicitado, o pedido de alteraÃ§Ã£o de email (login) foi efetuado:\n\nEmail Antigo: #OldEmail\nNovo Email: #Email\n\nAtenciosamente,'),
(17, 1517153623, 1517153623, 1517153623, 1, 'PT', 'Email_Changed', '#ApplicationName: AlteraÃ§Ã£o de EndereÃ§o EletrÃ´nico, #Unit_Name, #Unit_Title', 'Prezado(a) #Name\n\nConforme solicitado, o pedido de alteraÃ§Ã£o de email (login) foi efetuado:\n\nEmail Antigo: #OldEmail\nNovo Email: #Email\n\nAtenciosamente,'),
(18, 1517153624, 1517153624, 1517153624, 1, 'UK', 'Email_Changed', '#ApplicationName: Registration confirmed, #Unit_Title', 'We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Title, #Institution. \r\n\r\nPlease, access your registration, using the following link:\r\n\r\n#Href\r\n\r\nUsing as Login:\r\n\r\nUsu&aacute;rio: #Email\r\n\r\nIf you are unable to Login, please to recover your password, acessing:\r\n\r\n#Href2.');

-- --------------------------------------------------------

--
-- Table structure for table `Units`
--

CREATE TABLE `Units` (
  `ID` int(11) NOT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL,
  `Status` enum('0','1','2') DEFAULT '2',
  `Name` varchar(255) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `State` enum('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30') DEFAULT '9',
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
  `Auth` enum('0','1','2') DEFAULT '2',
  `Secure` enum('0','1','2','3') DEFAULT '2',
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
  `Email_Created_Body_UK` text,
  `Online` enum('0','1','2') DEFAULT '1',
  `Online_Message` varchar(256) DEFAULT 'Temporarily Offline due to system maintainance',
  `Initials` varchar(64) DEFAULT NULL,
  `Register_PT` int(11) DEFAULT '0',
  `Register_UK` int(11) DEFAULT '0',
  `Confirm_PT` int(11) DEFAULT '0',
  `Confirm_UK` int(11) DEFAULT '0',
  `Confirm_Resend_PT` int(11) DEFAULT '0',
  `Confirm_Resend_UK` int(11) DEFAULT '0',
  `Password_Reset_PT` int(11) DEFAULT '0',
  `Password_Reset_UK` int(11) DEFAULT '0',
  `Password_Changed_PT` int(11) DEFAULT '0',
  `Password_Changed_UK` int(11) DEFAULT '0',
  `Email_Created_PT` int(11) DEFAULT '0',
  `Email_Created_UK` int(11) DEFAULT '0',
  `Email_Change_PT` int(11) DEFAULT '0',
  `Email_Change_UK` int(11) DEFAULT '0',
  `Email_Changed_PT` int(11) DEFAULT '0',
  `Email_Changed_UK` int(11) DEFAULT '0',
  `Sivent2URL` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Units`
--

INSERT INTO `Units` (`ID`, `CTime`, `MTime`, `ATime`, `Status`, `Name`, `Title`, `State`, `Address`, `Phone`, `Fax`, `Url`, `Email`, `City`, `Area`, `ZIP`, `HtmlIcon1`, `HtmlIcon1_OrigName`, `HtmlIcon1_Contents`, `HtmlIcon1_Time`, `HtmlIcon1_Size`, `HtmlIcon2`, `HtmlIcon2_OrigName`, `HtmlIcon2_Contents`, `HtmlIcon2_Time`, `HtmlIcon2_Size`, `LatexIcon1`, `LatexIcon1_OrigName`, `LatexIcon1_Contents`, `LatexIcon1_Time`, `LatexIcon1_Size`, `LatexIcon2`, `LatexIcon2_OrigName`, `LatexIcon2_Contents`, `LatexIcon2_Time`, `LatexIcon2_Size`, `Auth`, `Secure`, `Port`, `Host`, `User`, `Password`, `FromEmail`, `FromName`, `ReplyTo`, `BCCEmail`, `MailHead`, `MailTail`, `MailHead_UK`, `MailTail_UK`, `Register_Subject`, `Register_Body`, `Register_Subject_UK`, `Register_Body_UK`, `Confirm_Subject`, `Confirm_Body`, `Confirm_Subject_UK`, `Confirm_Body_UK`, `Confirm_Resend_Subject`, `Confirm_Resend_Body`, `Confirm_Resend_Subject_UK`, `Confirm_Resend_Body_UK`, `Password_Reset_Subject`, `Password_Reset_Body`, `Password_Reset_Subject_UK`, `Password_Reset_Body_UK`, `Password_Changed_Subject`, `Password_Changed_Body`, `Password_Changed_Subject_UK`, `Password_Changed_Body_UK`, `Email_Change_Subject`, `Email_Change_Body`, `Email_Change_Subject_UK`, `Email_Change_Body_UK`, `Email_Changed_Subject`, `Email_Changed_Body`, `Email_Changed_Subject_UK`, `Email_Changed_Body_UK`, `Email_Created_Subject`, `Email_Created_Body`, `Email_Created_Subject_UK`, `Email_Created_Body_UK`, `Online`, `Online_Message`, `Initials`, `Register_PT`, `Register_UK`, `Confirm_PT`, `Confirm_UK`, `Confirm_Resend_PT`, `Confirm_Resend_UK`, `Password_Reset_PT`, `Password_Reset_UK`, `Password_Changed_PT`, `Password_Changed_UK`, `Email_Created_PT`, `Email_Created_UK`, `Email_Change_PT`, `Email_Change_UK`, `Email_Changed_PT`, `Email_Changed_UK`, `Sivent2URL`) VALUES
(1, 1433549097, 1461104154, 1461104154, '2', 'My Organization Name', 'My Organization Title', '9', 'MyAddress', '(++55)(DD) 1234-5678', '(++55)(DD) 1234-5678', 'http://www.mysite.com.br', 'my-org-email@somewhere.com', 'My City', 'My Area', 'NNNNN-MMM', 'Uploads/Units/HtmlIcon1_1.png', 'ufg.png', NULL, NULL, NULL, 'Uploads/Units/HtmlIcon2_1.png', 'ufg.png', NULL, NULL, NULL, 'Uploads/Units/LatexIcon1_1.png', 'ufg.png', NULL, NULL, NULL, 'Uploads/Units/LatexIcon2_1.png', 'ufg.png', NULL, NULL, NULL, '2', '2', '465', 'smtp.gmail.com', 'your-email-here@gmail.com', 'your-password-here', 'your-email-here@gmail.com', 'SiVent2: Sistema de Gerenciamento de Eventos', 'your-email-here@gmail.com', 'your-email-here@gmail.com', 'Prezado(a) #Name', 'Atenciosamente,\r\n#ApplicationName,\r\n#Unit_Title', 'Dear #Name', 'Regards,\r\n#ApplicationName,\r\n#Unit_Title', '#ApplicationName: C&oacute;digo de Confirma&ccedil;a&otilde; de Cadastro, #Unit_Title', 'Recebemos uma solicita&ccedil;&atilde;o de cadastro em #ApplicationName, #Unit_Title, #Institution. Para completar o cadastro, precisamos verificar que voc&ecirc; controla este email. Para neste fim, por favor acesse o link:\r\n\r\n#ConfirmLink\r\n\r\nVoc&ecirc; tamb&eacute;m pode confirmar seu cadastro, atrav&eacute;s do link:\r\n\r\n#ConfirmLinkForm\r\n\r\ninformando seu email como login no sistema junto com o c&oacute;digo de confirma&ccedil;&atilde;o abaixo:\r\n\r\nUsu&aacute;rio: #Email\r\nCode de Confirma&ccedil;&atilde;o: #ConfirmCode\r\n\r\nPara reenviar sua senha, por favor acesse:\r\n\r\n#ResendCodeLink', '#ApplicationName: Registration Confirmation Code, #Unit_Title', 'We have received a solicitation of registration in #ApplicationName, #Unit_Title, #Institution.  In order to complete your registration, we need to confirm that you controle this email addres. To do that, please access the link:\r\n\r\n#ConfirmLink\r\n\r\nYou may also complete your registration, acessing:\r\n\r\n#ConfirmLinkForm\r\n\r\nproviding the following information:\r\n\r\nUser: #Email\r\nConfirmation Code: #ConfirmCode\r\n\r\nIf needed, you may have the current confirmation code resent, please use:\r\n\r\n#ResendCodeLink', '#ApplicationName: Cadastro confirmado, #Unit_Title', 'Enviamos este email para confirmar seu cadastro no #ApplicationName, #Unit_Title, #Institution.\r\nPara acessar seu cadastro, por favor utilize o link\r\n\r\n#LoginLink\r\n\r\nUtilizando o Credencial:\r\n\r\nUsu&aacute;rio: #Email,\r\n\r\ne a senha cadastrado no in&iacute;cio deste cadastro.\r\n\r\nSe voc&ecirc; n&atilde;o est&aacute; conseguindo efetuar login, por favor, tente recuparar sua senha, acessando:\r\n\r\n#RecoverPasswordLink.', '#ApplicationName: Registration confirmed, #Unit_Title', 'We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Title, #Institution. \r\n\r\nPlease, access your registration, using the following link:\r\n\r\n#Href\r\n\r\nUsing as Login:\r\n\r\nUser: #Email,\r\n\r\nalong with the password used initiating this registration.\r\n\r\nIf you are unable to Login, please try to recover your password, acessing:\r\n\r\n#Href2.', '#ApplicationName: Reenvio de C&oacute;digo de Confirma&ccedil;&atilde;o, #Unit_Title', 'Recebemos uma solicita&ccedil;&atilde;o de reenvio de do c&oacute;digo de confirma&ccedil;&atilde;o. Para completar o cadastro, por favor acesse o link:\r\n\r\n#ConfirmLink\r\n\r\nVoc&ecirc; tamb&eacute;m pode confirmar seu cadastro, atrav&eacute;s do link:\r\n\r\n#ConfirmLinkForm\r\n\r\ninformando seu email como login no sistema junto com o c&oacute;digo de confirma&ccedil;&atilde;o abaixo:\r\n\r\nUsu&aacute;rio: #Email\r\nCode de Confirma&ccedil;&atilde;o: #ConfirmCode\r\n\r\nPara reenviar sua senha, por favor acesse:\r\n\r\n#ResendCodeLink', '#ApplicationName: Resending Confirmation Code, #Unit_Title', 'We have received a solicitation to resend your confirmation code.  In order to complete your registration, please access the link:\r\n\r\n#ConfirmLink\r\n\r\nYou may also complete your registration, acessing:\r\n\r\n#ConfirmLinkForm\r\n\r\nproviding the following information:\r\n\r\nUser: #Email\r\nConfirmation Code: #ConfirmCode\r\n\r\nIf needed, you may have the current confirmation code resent, please use:\r\n\r\n#ResendCodeLink', '#ApplicationName: Recupera&ccedil;&atilde;o de Senha, #Unit_Title', 'Recebemos uma solicita&ccedil;&atilde;o de recuperar a senha do login (email) #Email. Em baixo inlcuimos um c&oacute;digo gerado aleat&oacute;riamente, permitindo a altera&ccedil;&atilde;o da senha, por favor acesse este link:\r\n\r\n#RecoverLink\r\n\r\nAo completar a altera&ccedil;&atilde;o, voc&ecirc; receber&aacute; um email informativo pelo sistema.', '#ApplicationName: Password Recovery, #Unit_Title', 'We have received a solicitation to recover login to the account (email) #Email. Below we include a randomnly generated code, permitting you to change the password accessing:\r\n\r\n#RecoverLink\r\n\r\nCompleting the alteration, you will receive an informative email by the system.', '#ApplicationName: Recupera&ccedil;&atilde;o de Senha, #Unit_Title', 'Informamos que sua senha de acesso foi alterada conforme solicitado no sistema:\r\n\r\nUsu&aacute;rio: #Email\r\nSenha:  #NewPassword\r\n\r\nPara acessar o sistema, acesse:\r\n\r\n#LoginLink', '#ApplicationName: Password Recovery, #Unit_Title', 'We hereby informa that, as solicited in our system, yoiur password has been reset:\r\n\r\nUsu&aacute;rio: #Email\r\nSenha:  #NewPassword\r\n\r\nPlease use this link to access the system:\r\n\r\n#LoginLink', '#ApplicationName: Cadastro confirmado, #Unit_Title', 'Enviamos este email, para confirmar seu cadastro do #ApplicationName, #Unit_Title, #Institution.\r\nPara acessar seu cadastro, por favor utilize o link\r\n\r\n#Href\r\n\r\nUtilizando o Credencial:\r\n\r\nUsu&aacute;rio: #Email\r\n\r\nSe voc&ecirc; n&atilde;o est&aacute; conseguindo efetuar login, por favor, tente recuparar sua senha, acessando:\r\n\r\n#Href2.', '#ApplicationName: Registration confirmed, #Unit_Title', 'We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Title, #Institution. \r\n\r\nPlease, access your registration, using the following link:\r\n\r\n#Href\r\n\r\nUsing as Login:\r\n\r\nUsu&aacute;rio: #Email\r\n\r\nIf you are unable to Login, please to recover your password, acessing:\r\n\r\n#Href2.', '#ApplicationName: Cadastro confirmado, #Unit_Title', 'Enviamos este email, para confirmar seu cadastro do #ApplicationName, #Unit_Title, #Institution.\r\nPara acessar seu cadastro, por favor utilize o link\r\n\r\n#Href\r\n\r\nUtilizando o Credencial:\r\n\r\nUsu&aacute;rio: #Email\r\n\r\nSe voc&ecirc; n&atilde;o est&aacute; conseguindo efetuar login, por favor, tente recuparar sua senha, acessando:\r\n\r\n#Href2.', '#ApplicationName: Registration confirmed, #Unit_Title', 'We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Title, #Institution. \r\n\r\nPlease, access your registration, using the following link:\r\n\r\n#Href\r\n\r\nUsing as Login:\r\n\r\nUsu&aacute;rio: #Email\r\n\r\nIf you are unable to Login, please to recover your password, acessing:\r\n\r\n#Href2.', '#ApplicationName: Cadastro confirmado, #Unit_Title', 'Enviamos este email, para confirmar seu cadastro do #ApplicationName, #Unit_Title, #Institution.\r\nPara acessar seu cadastro, por favor utilize o link\r\n\r\n#Href\r\n\r\nUtilizando o Credencial:\r\n\r\nUsu&aacute;rio: #Email\r\n\r\nSe voc&ecirc; n&atilde;o est&aacute; conseguindo efetuar login, por favor, tente recuparar sua senha, acessando:\r\n\r\n#Href2.', '#ApplicationName: Registration confirmed, #Unit_Title', 'We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Title, #Institution. \r\n\r\nPlease, access your registration, using the following link:\r\n\r\n#Href\r\n\r\nUsing as Login:\r\n\r\nUsu&aacute;rio: #Email\r\n\r\nIf you are unable to Login, please to recover your password, acessing:\r\n\r\n#Href2.', '1', 'Temporarily Offline due to system maintainance', NULL, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 17, 18, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `__Index__`
--

CREATE TABLE `__Index__` (
  `ID` int(11) NOT NULL,
  `Module` varchar(256) DEFAULT NULL,
  `Sql_Table` varchar(256) DEFAULT NULL,
  `Item` int(11) DEFAULT NULL,
  `Name` varchar(256) DEFAULT NULL,
  `CTime` int(11) DEFAULT NULL,
  `MTime` int(11) DEFAULT NULL,
  `ATime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `__Index__`
--

INSERT INTO `__Index__` (`ID`, `Module`, `Sql_Table`, `Item`, `Name`, `CTime`, `MTime`, `ATime`) VALUES
(1, 'Units', 'Units', 1, 'My Organization Name', NULL, 0, 1517154107),
(2, 'Units', 'Units', 1, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Events', '1__Events', 1, 'FLISOL-GYN', 1517153952, 1517153952, 1517154107);

-- --------------------------------------------------------

--
-- Table structure for table `__Table__`
--

CREATE TABLE `__Table__` (
  `ID` int(11) NOT NULL,
  `Name` varchar(256) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `__Table__`
--

INSERT INTO `__Table__` (`ID`, `Name`, `Time`) VALUES
(1, '2__Sessions', 1458475182),
(3, '1__Events', 1517154084),
(4, '1__Sessions', 1458475182),
(5, '1__2016__03__Logs', 1458475184),
(6, '1__Friends', 1460985435),
(7, 'Units', 1517154084),
(8, '2__Events', 1461340373),
(9, '2__2016__03__Logs', 1458475184),
(10, '2__Friends', 1461247360),
(11, '2__1_Datas', 1458475184),
(12, '2__1_GroupDatas', 1458475184),
(13, '2__1_Inscriptions', 1461252571),
(14, '2__Sponsors', 1459410748),
(15, '1__Sponsors', 1491062954),
(16, '2__Permissions', 1458820882),
(17, '2__2016__04__Logs', 1458475184),
(18, '1__2016__04__Logs', 1458475184),
(19, '2__1_Collaborations', 1460082645),
(20, '2__1_Collaborators', 1460083479),
(21, '2__1_Submissions', 1460082130),
(22, '2__1_Caravaneers', 1460082131),
(23, '__Sponsors', 1458815872),
(24, '2__0_Inscriptions', 1460751549),
(25, '1__1_Datas', 1489862030),
(26, '1__1_GroupDatas', 1458475184),
(27, '1__1_Inscriptions', 1460751549),
(28, '1__Permissions', 1458820882),
(29, '2__Certificates', 1461262663),
(30, 'MailTypes', 1475294720),
(31, '1__2018__01__Logs', 1457777584);

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
-- Indexes for table `1__2018__01__Logs`
--
ALTER TABLE `1__2018__01__Logs`
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
-- Indexes for table `MailTypes`
--
ALTER TABLE `MailTypes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Units`
--
ALTER TABLE `Units`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `__Index__`
--
ALTER TABLE `__Index__`
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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `1__1_Caravaneers`
--
ALTER TABLE `1__1_Caravaneers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `1__1_Collaborations`
--
ALTER TABLE `1__1_Collaborations`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
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
-- AUTO_INCREMENT for table `1__2018__01__Logs`
--
ALTER TABLE `1__2018__01__Logs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `1__Certificates`
--
ALTER TABLE `1__Certificates`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `1__Events`
--
ALTER TABLE `1__Events`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `1__Friends`
--
ALTER TABLE `1__Friends`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `1__Permissions`
--
ALTER TABLE `1__Permissions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `1__Sessions`
--
ALTER TABLE `1__Sessions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1626;
--
-- AUTO_INCREMENT for table `1__Sponsors`
--
ALTER TABLE `1__Sponsors`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `MailTypes`
--
ALTER TABLE `MailTypes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `Units`
--
ALTER TABLE `Units`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `__Index__`
--
ALTER TABLE `__Index__`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `__Table__`
--
ALTER TABLE `__Table__`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
