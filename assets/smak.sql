-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2019 at 06:14 PM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smak`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `image` varchar(30) NOT NULL DEFAULT 'blank.jpg',
  `content` longtext NOT NULL,
  `popup` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `title`, `link`, `date`, `image`, `content`, `popup`) VALUES
(2, 'mencoba mengganti judul artikel', 'mencoba-mengganti-judul-artikel', '2019-12-06', '4.jpg', '<p>ganti content, Cashback&nbsp;<strong>Mobil Daihatsu Malang&nbsp;</strong>dan informasi lainnya mengenai mobil Daihatsu&nbsp;di Malang&nbsp;dan Jawa Timur, anda bisa menghubungi&nbsp;<strong>Daihatsu Malang (Edwin Kurniawan)</strong>&nbsp;berikut :</p>\r\n', 0),
(3, 'dan aku adalah kamu', 'dan-aku-adalah-kamu', '2019-12-08', 'logo.jpg', '<p>with result.name for example equal to string &quot;Add&quot;. When I click on this button, I have an error that says that Add is not defined. Since this functioncall works perfect with a numeric parameter, I assume that it has something to do with the symbols &quot;&quot; in the string. Did anyone had this problem before?</p>\r\n', 0),
(4, 'artikel yang pop up', 'artikel-yang-pop-up', '2019-12-10', 'student.jpg', '<p>Pasti kamu pernah kan punya pengalaman nunggu paket kiriman barang sambil harap-harap cemas apakah barang sampai atau tidak ke rumah. Perasaan kesal dan khawatir pasti bercampur aduk jadi satu. Kini Kamu tidak perlu khawatir lagi! Dengan Anteraja, kamu bisa mengetahui sejauh mana proses pengiriman paket kamu berjalan. Yaitu dengan melakukan cek resi pengiriman barang yang sedang dikirim.</p>\r\n\r\n<p><img alt="" src="http://localhost/smak/assets/img/picture/sekolah.jpg" style="height:676px; width:1000px" /></p>\r\n\r\n<p>Cek Resi merupakan salah satu layanan yang kami berikan untuk memudahkan kamu dalam melacak pengiriman. Tidak perlu lagi bertanya-tanya atau kebingungan karena memikirkan dimana keberadaan paketmu. Untuk melakukan cek resi caranya sangat mudah. Kamu hanya perlu memasukkan nomor resi di kolom yang telah disediakan. Tidak hanya nomor resi saja, kami juga membantu kamu yang hanya memiliki informasi kode booking maupun nomor invoice, sebab di kolom lacak pengiriman ini kamu juga bisa memasukkan nomor kode booking ataupun nomor invoice dari ecommerce tempat kamu berbelanja.</p>\r\n\r\n<p>Jadi, ngga perlu khawatir lagi kan nunggu barang kesayangan sampai ke rumah. Pakai Anteraja, #pastibawahepi!</p>\r\n', 0);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `image` varchar(30) NOT NULL DEFAULT 'blank.jpg',
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `location` varchar(50) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `title`, `link`, `image`, `startDate`, `endDate`, `location`, `description`) VALUES
(1, 'mencoba ganti kegiatan', 'mencoba-ganti-kegiatan', 'sekolah.jpg', '2019-11-21 21:19:00', '2019-12-24 09:48:00', 'gallery nganu', '<p>Pass the string into funtion&nbsp;<strong>Strip_text(&quot;Long text with html tag or without html tag&quot;, 15)</strong>&nbsp;Then this function will return the first 15 character from the html string without html tags. When string less than 15 character then return the full string other wise it will return the 15 character with $lastString parameter string.</p>\r\n\r\n<p>I know how to use the substr function but this will happy end a string halfway through a word. I want the string to end at the end of a word how would I go about doing this? Would it involve regular expression? Any help very much appreciated.</p>\r\n\r\n<p>This is what I have so far. Just the SubStr...</p>\r\n'),
(2, 'mencoba membuat kegiatan', 'mencoba-membuat-kegiatan', '5.jpg', '2019-12-09 07:29:00', '2019-12-10 06:15:00', 'arab konoloh', '<p>Cada par&aacute;metro de esta funci&oacute;n utiliza la zona horaria predeterminada a menos que se especifique una en ese par&aacute;metro. Se ha de tener cuidado de no usar diferentes zonas horarias en cada par&aacute;metro a menos que sea esa la intenci&oacute;n. V&eacute;ase la funci&oacute;n&nbsp;<a href="https://www.php.net/manual/es/function.date-default-timezone-get.php">date_default_timezone_get()</a>&nbsp;para las diferentes maneras de definir la zona horaria predeterminada.</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `file` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `file`) VALUES
(9, '1.jpg'),
(10, '2.jpg'),
(11, '3.jpg'),
(12, '4.jpg'),
(13, '5.jpg'),
(14, '6.jpg'),
(15, 'logo.jpg'),
(16, 'sekolah.jpg'),
(17, 'MR_ricki.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `file` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `file`) VALUES
(1, '1.jpg'),
(2, 'logo.jpg'),
(3, '2.jpg'),
(4, '3.jpg'),
(5, '4.jpg'),
(6, '5.jpg'),
(7, '6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `structure`
--

CREATE TABLE `structure` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `position` varchar(20) NOT NULL,
  `photo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `structure`
--

INSERT INTO `structure` (`id`, `name`, `nip`, `position`, `photo`) VALUES
(1, 'Novian Dwi Syahrizal', '130533608242', 'kepala sekolah', 'MR_ricki1.jpg'),
(2, 'ali ngabalin', '12301203120', 'kurikulum', '2.jpg'),
(3, 'abu dahabi', '19045', 'tukang kebon', 'student.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `testi`
--

CREATE TABLE `testi` (
  `id` int(11) NOT NULL,
  `photo` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `year` int(4) NOT NULL,
  `home` varchar(15) NOT NULL,
  `testimoni` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testi`
--

INSERT INTO `testi` (`id`, `photo`, `name`, `year`, `home`, `testimoni`) VALUES
(2, '4.jpg', 'novian dwi syahrizal', 2012, 'gresik', 'Bootstrap’s form controls expand on our Rebooted form styles with classes. Use these classes to opt into their customized displays for a more consistent rendering across browsers and devices.'),
(3, 'sekolah.jpg', 'ali ngabalin', 2083, 'nang kono', 'Be sure to use an appropriate type attribute on all inputs (e.g., email for email address or number for numerical information) to take advantage of newer input controls like email verification, number selection, and more.'),
(5, '2.jpg', 'suparman', 9000, 'mars', 'suangar kon bro');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `type`) VALUES
(1, 'admin', '$2y$10$SsBpMtJ/NUostTkhf8smE.qm8luU0jRU5co96lSUqjVlGeFfNUX8e', 0),
(2, 'pokez', '$2y$10$IQ08ismGOKK2BU7gYkKpveW4x4aZx1va9ostY/OT.h9W1YNGClz0S', 1),
(3, 'novian', '$2y$10$2kHaAb59OhY35QgzclAQKeayFvKY/fMGYslkmFfGcZqZJntXNCPRG', 1),
(4, 'dwi', '$2y$10$MlD3leMQFYxzkfOT7kD2JuJVBJHdtST4qSlsybxxfkfJzXHgg/.o.', 1),
(5, 'syah', '$2y$10$jAklaV56KuK0Vb1cgbnzOe3sa1LY87kkmpQRSKNCc3KryMaQKQnya', 1),
(6, 'rizal', '$2y$10$XQOMwicTs3O.JWocV5x0quIxweZqtlnGRwQN3UPzp1.SD88m/lLwe', 1),
(7, 'hilmi', '$2y$10$Ju4vubZNwuneKnsnb9U3SuxgSp3uhl5ECNmX0K1Ui./8JYTD3qDeu', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `structure`
--
ALTER TABLE `structure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testi`
--
ALTER TABLE `testi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `structure`
--
ALTER TABLE `structure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `testi`
--
ALTER TABLE `testi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
