-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2025 at 12:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `timetable_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `batch_id` int(11) NOT NULL,
  `batch_name` varchar(100) NOT NULL,
  `sem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`batch_id`, `batch_name`, `sem`) VALUES
(1, 'BCA-B BATCH', 4),
(2, 'BCA-A BATCH', 4),
(3, 'BCA-C BATCH', 4);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_name`, `email`, `password`, `batch_id`) VALUES
(1, 'Rejo Thomas', 'rejo@example.com', '4ea89717a1c151d7c6138e261727645b', 1),
(2, 'Alan Chacko', 'alan@example.com', 'bab891de979ae791cfa37bfc88ed9e88', 2),
(3, 'Reeba Treesa', 'reeba@example.com', 'd984478bd09b043e471e24e894fc694e', 3);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `sem` int(11) NOT NULL,
  `subject_group` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`, `sem`, `subject_group`) VALUES
(1, 'DAA', 4, 'DAA'),
(2, 'SASE', 4, 'SASE'),
(3, 'PHP', 4, 'PHP'),
(4, 'LINUX', 4, 'LINUX'),
(5, 'OR', 4, 'OR'),
(6, 'LINUX LAB', 4, 'LINUX'),
(7, 'PHP LAB', 4, 'PHP\r\n'),
(8, 'IELTS', 4, 'IELTS');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `teacher_name`, `email`, `password`) VALUES
(1, 'AJITH PS', 'ajithps@gmail.com', 'ac76017654a4235513e403fa5e52984f'),
(2, 'ELDHOSE PU', 'eldhosepu@gmail.com', 'feb3f990c2c6f0ec4c3c035be9031df4'),
(3, 'PRIYA  P G', 'priyapg@gmail.com', '63eb3549a53be8b40e4e8c1c3a62ea4f'),
(5, 'DR.RAGHUNATH', 'raghunath@gmail.com', 'e581d0752801aafe8d9583862c72dfc0'),
(6, 'VANDANA', 'vandana@gmail.com', 'e5a443b39e03eef4dc7ef39056a3a59e'),
(7, 'RESMI K P', 'resmikp@gmail.com', '8caa43e61e1534e06f1dea288d0609ce'),
(8, 'TANIYA ELDHOSE', 'taniyaeldhose@gmail.com', '5b6d9574942d0ad9e51319c3070c7028'),
(9, 'NANDHANA THAMPI', 'nandhanathampi@gmail.com', '5d3162c5ba5748ecc73c34ae1c3b51a7'),
(10, 'BINDHU P', 'bindhup@gmail.com', '8a6e80edf1d69b03d85cad788ba211b5');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_availability`
--

CREATE TABLE `teacher_availability` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `day` varchar(10) NOT NULL,
  `hour` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_availability`
--

INSERT INTO `teacher_availability` (`id`, `teacher_id`, `day`, `hour`) VALUES
(1, 1, 'Monday', 1),
(2, 1, 'Tuesday', 1),
(3, 1, 'Wednesday', 1),
(4, 1, 'Thursday', 1),
(5, 1, 'Friday', 1),
(6, 1, 'Monday', 2),
(7, 1, 'Tuesday', 2),
(8, 1, 'Wednesday', 2),
(9, 1, 'Thursday', 2),
(10, 1, 'Friday', 2),
(11, 1, 'Monday', 3),
(12, 1, 'Tuesday', 3),
(13, 1, 'Wednesday', 3),
(14, 1, 'Thursday', 3),
(15, 1, 'Friday', 3),
(16, 1, 'Monday', 4),
(17, 1, 'Tuesday', 4),
(18, 1, 'Wednesday', 4),
(19, 1, 'Thursday', 4),
(20, 1, 'Friday', 4),
(21, 1, 'Monday', 5),
(22, 1, 'Tuesday', 5),
(23, 1, 'Wednesday', 5),
(24, 1, 'Thursday', 5),
(25, 1, 'Friday', 5),
(26, 1, 'Monday', 6),
(27, 1, 'Tuesday', 6),
(28, 1, 'Wednesday', 6),
(29, 1, 'Thursday', 6),
(30, 1, 'Friday', 6),
(31, 2, 'Monday', 1),
(32, 2, 'Tuesday', 1),
(33, 2, 'Wednesday', 1),
(34, 2, 'Thursday', 1),
(35, 2, 'Friday', 1),
(36, 2, 'Monday', 2),
(37, 2, 'Tuesday', 2),
(38, 2, 'Wednesday', 2),
(39, 2, 'Thursday', 2),
(40, 2, 'Friday', 2),
(41, 2, 'Monday', 3),
(42, 2, 'Tuesday', 3),
(43, 2, 'Wednesday', 3),
(44, 2, 'Thursday', 3),
(45, 2, 'Friday', 3),
(46, 2, 'Monday', 4),
(47, 2, 'Tuesday', 4),
(48, 2, 'Wednesday', 4),
(49, 2, 'Thursday', 4),
(50, 2, 'Friday', 4),
(51, 2, 'Monday', 5),
(52, 2, 'Tuesday', 5),
(53, 2, 'Wednesday', 5),
(54, 2, 'Thursday', 5),
(55, 2, 'Friday', 5),
(56, 2, 'Monday', 6),
(57, 2, 'Tuesday', 6),
(58, 2, 'Wednesday', 6),
(59, 2, 'Thursday', 6),
(60, 2, 'Friday', 6),
(61, 3, 'Monday', 1),
(62, 3, 'Tuesday', 1),
(63, 3, 'Wednesday', 1),
(64, 3, 'Thursday', 1),
(65, 3, 'Friday', 1),
(66, 3, 'Monday', 2),
(67, 3, 'Tuesday', 2),
(68, 3, 'Wednesday', 2),
(69, 3, 'Thursday', 2),
(70, 3, 'Friday', 2),
(71, 3, 'Monday', 3),
(72, 3, 'Tuesday', 3),
(73, 3, 'Wednesday', 3),
(74, 3, 'Thursday', 3),
(75, 3, 'Friday', 3),
(76, 3, 'Monday', 4),
(77, 3, 'Tuesday', 4),
(78, 3, 'Wednesday', 4),
(79, 3, 'Thursday', 4),
(80, 3, 'Friday', 4),
(81, 3, 'Monday', 5),
(82, 3, 'Tuesday', 5),
(83, 3, 'Wednesday', 5),
(84, 3, 'Thursday', 5),
(85, 3, 'Friday', 5),
(86, 3, 'Monday', 6),
(87, 3, 'Tuesday', 6),
(88, 3, 'Wednesday', 6),
(89, 3, 'Thursday', 6),
(90, 3, 'Friday', 6),
(91, 5, 'Monday', 1),
(92, 5, 'Tuesday', 1),
(93, 5, 'Wednesday', 1),
(94, 5, 'Thursday', 1),
(95, 5, 'Friday', 1),
(96, 5, 'Monday', 2),
(97, 5, 'Tuesday', 2),
(98, 5, 'Wednesday', 2),
(99, 5, 'Thursday', 2),
(100, 5, 'Friday', 2),
(101, 5, 'Monday', 3),
(102, 5, 'Tuesday', 3),
(103, 5, 'Wednesday', 3),
(104, 5, 'Thursday', 3),
(105, 5, 'Friday', 3),
(106, 5, 'Monday', 4),
(107, 5, 'Tuesday', 4),
(108, 5, 'Wednesday', 4),
(109, 5, 'Thursday', 4),
(110, 5, 'Friday', 4),
(111, 5, 'Monday', 5),
(112, 5, 'Tuesday', 5),
(113, 5, 'Wednesday', 5),
(114, 5, 'Thursday', 5),
(115, 5, 'Friday', 5),
(116, 5, 'Monday', 6),
(117, 5, 'Tuesday', 6),
(118, 5, 'Wednesday', 6),
(119, 5, 'Thursday', 6),
(120, 5, 'Friday', 6),
(121, 6, 'Monday', 1),
(122, 6, 'Tuesday', 1),
(123, 6, 'Wednesday', 1),
(124, 6, 'Thursday', 1),
(125, 6, 'Friday', 1),
(126, 6, 'Monday', 2),
(127, 6, 'Tuesday', 2),
(128, 6, 'Wednesday', 2),
(129, 6, 'Thursday', 2),
(130, 6, 'Friday', 2),
(131, 6, 'Monday', 3),
(132, 6, 'Tuesday', 3),
(133, 6, 'Wednesday', 3),
(134, 6, 'Thursday', 3),
(135, 6, 'Friday', 3),
(136, 6, 'Monday', 4),
(137, 6, 'Tuesday', 4),
(138, 6, 'Wednesday', 4),
(139, 6, 'Thursday', 4),
(140, 6, 'Friday', 4),
(141, 6, 'Monday', 5),
(142, 6, 'Tuesday', 5),
(143, 6, 'Wednesday', 5),
(144, 6, 'Thursday', 5),
(145, 6, 'Friday', 5),
(146, 6, 'Monday', 6),
(147, 6, 'Tuesday', 6),
(148, 6, 'Wednesday', 6),
(149, 6, 'Thursday', 6),
(150, 6, 'Friday', 6),
(151, 7, 'Monday', 1),
(152, 7, 'Tuesday', 1),
(153, 7, 'Wednesday', 1),
(154, 7, 'Thursday', 1),
(155, 7, 'Friday', 1),
(156, 7, 'Monday', 2),
(157, 7, 'Tuesday', 2),
(158, 7, 'Wednesday', 2),
(159, 7, 'Thursday', 2),
(160, 7, 'Friday', 2),
(161, 7, 'Monday', 3),
(162, 7, 'Tuesday', 3),
(163, 7, 'Wednesday', 3),
(164, 7, 'Thursday', 3),
(165, 7, 'Friday', 3),
(166, 7, 'Monday', 4),
(167, 7, 'Tuesday', 4),
(168, 7, 'Wednesday', 4),
(169, 7, 'Thursday', 4),
(170, 7, 'Friday', 4),
(171, 7, 'Monday', 5),
(172, 7, 'Tuesday', 5),
(173, 7, 'Wednesday', 5),
(174, 7, 'Thursday', 5),
(175, 7, 'Friday', 5),
(176, 7, 'Monday', 6),
(177, 7, 'Tuesday', 6),
(178, 7, 'Wednesday', 6),
(179, 7, 'Thursday', 6),
(180, 7, 'Friday', 6),
(181, 8, 'Monday', 1),
(182, 8, 'Tuesday', 1),
(183, 8, 'Wednesday', 1),
(184, 8, 'Thursday', 1),
(185, 8, 'Friday', 1),
(186, 8, 'Monday', 2),
(187, 8, 'Tuesday', 2),
(188, 8, 'Wednesday', 2),
(189, 8, 'Thursday', 2),
(190, 8, 'Friday', 2),
(191, 8, 'Monday', 3),
(192, 8, 'Tuesday', 3),
(193, 8, 'Wednesday', 3),
(194, 8, 'Thursday', 3),
(195, 8, 'Friday', 3),
(196, 8, 'Monday', 4),
(197, 8, 'Tuesday', 4),
(198, 8, 'Wednesday', 4),
(199, 8, 'Thursday', 4),
(200, 8, 'Friday', 4),
(201, 8, 'Monday', 5),
(202, 8, 'Tuesday', 5),
(203, 8, 'Wednesday', 5),
(204, 8, 'Thursday', 5),
(205, 8, 'Friday', 5),
(206, 8, 'Monday', 6),
(207, 8, 'Tuesday', 6),
(208, 8, 'Wednesday', 6),
(209, 8, 'Thursday', 6),
(210, 8, 'Friday', 6),
(211, 9, 'Monday', 1),
(212, 9, 'Tuesday', 1),
(213, 9, 'Wednesday', 1),
(214, 9, 'Thursday', 1),
(215, 9, 'Friday', 1),
(216, 9, 'Monday', 2),
(217, 9, 'Tuesday', 2),
(218, 9, 'Wednesday', 2),
(219, 9, 'Thursday', 2),
(220, 9, 'Friday', 2),
(221, 9, 'Monday', 3),
(222, 9, 'Tuesday', 3),
(223, 9, 'Wednesday', 3),
(224, 9, 'Thursday', 3),
(225, 9, 'Friday', 3),
(226, 9, 'Monday', 4),
(227, 9, 'Tuesday', 4),
(228, 9, 'Wednesday', 4),
(229, 9, 'Thursday', 4),
(230, 9, 'Friday', 4),
(231, 9, 'Monday', 5),
(232, 9, 'Tuesday', 5),
(233, 9, 'Wednesday', 5),
(234, 9, 'Thursday', 5),
(235, 9, 'Friday', 5),
(236, 9, 'Monday', 6),
(237, 9, 'Tuesday', 6),
(238, 9, 'Wednesday', 6),
(239, 9, 'Thursday', 6),
(240, 9, 'Friday', 6),
(241, 10, 'Monday', 1),
(242, 10, 'Tuesday', 1),
(243, 10, 'Wednesday', 1),
(244, 10, 'Thursday', 1),
(245, 10, 'Friday', 1),
(246, 10, 'Monday', 2),
(247, 10, 'Tuesday', 2),
(248, 10, 'Wednesday', 2),
(249, 10, 'Thursday', 2),
(250, 10, 'Friday', 2),
(251, 10, 'Monday', 3),
(252, 10, 'Tuesday', 3),
(253, 10, 'Wednesday', 3),
(254, 10, 'Thursday', 3),
(255, 10, 'Friday', 3),
(256, 10, 'Monday', 4),
(257, 10, 'Tuesday', 4),
(258, 10, 'Wednesday', 4),
(259, 10, 'Thursday', 4),
(260, 10, 'Friday', 4),
(261, 10, 'Monday', 5),
(262, 10, 'Tuesday', 5),
(263, 10, 'Wednesday', 5),
(264, 10, 'Thursday', 5),
(265, 10, 'Friday', 5),
(266, 10, 'Monday', 6),
(267, 10, 'Tuesday', 6),
(268, 10, 'Wednesday', 6),
(269, 10, 'Thursday', 6),
(270, 10, 'Friday', 6);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_subjects`
--

CREATE TABLE `teacher_subjects` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_subjects`
--

INSERT INTO `teacher_subjects` (`id`, `teacher_id`, `subject_id`, `batch_id`) VALUES
(28, 1, 1, 2),
(29, 1, 1, 1),
(30, 1, 1, 3),
(31, 8, 8, 1),
(32, 8, 8, 2),
(33, 8, 8, 3),
(34, 10, 5, 1),
(35, 10, 5, 2),
(36, 10, 5, 3),
(37, 2, 3, 1),
(38, 2, 3, 2),
(39, 2, 7, 1),
(40, 2, 7, 2),
(41, 7, 3, 3),
(42, 7, 7, 3),
(43, 6, 2, 1),
(44, 6, 2, 3),
(45, 5, 2, 2),
(46, 5, 4, 3),
(47, 5, 6, 3),
(48, 3, 4, 1),
(49, 3, 4, 2),
(50, 3, 6, 1),
(51, 3, 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `teaching_hours`
--

CREATE TABLE `teaching_hours` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `hours` int(11) NOT NULL,
  `batch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teaching_hours`
--

INSERT INTO `teaching_hours` (`id`, `teacher_id`, `subject_id`, `hours`, `batch_id`) VALUES
(42, 1, 1, 4, 2),
(43, 10, 5, 4, 2),
(44, 2, 3, 5, 2),
(45, 2, 7, 3, 2),
(46, 5, 2, 4, 2),
(47, 3, 4, 5, 2),
(48, 3, 6, 3, 2),
(49, 8, 8, 2, 2),
(50, 1, 1, 4, 1),
(51, 10, 5, 4, 1),
(52, 2, 3, 5, 1),
(53, 2, 7, 3, 1),
(54, 3, 4, 5, 1),
(55, 3, 6, 3, 1),
(56, 8, 8, 2, 1),
(57, 6, 2, 4, 1),
(58, 1, 1, 4, 3),
(59, 10, 5, 4, 3),
(60, 8, 8, 2, 3),
(61, 7, 3, 5, 3),
(62, 7, 7, 3, 3),
(63, 5, 4, 5, 3),
(64, 5, 6, 3, 3),
(65, 6, 2, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `day` varchar(20) NOT NULL,
  `hour` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`id`, `batch_id`, `day`, `hour`, `subject_id`, `teacher_id`) VALUES
(2433, 2, 'Wednesday', 1, 3, 2),
(2434, 2, 'Tuesday', 4, 3, 2),
(2435, 2, 'Friday', 1, 3, 2),
(2436, 2, 'Tuesday', 5, 3, 2),
(2437, 2, 'Monday', 3, 3, 2),
(2438, 2, 'Friday', 6, 4, 3),
(2439, 2, 'Tuesday', 2, 4, 3),
(2440, 2, 'Wednesday', 5, 4, 3),
(2441, 2, 'Thursday', 5, 4, 3),
(2442, 2, 'Wednesday', 3, 4, 3),
(2443, 2, 'Friday', 5, 1, 1),
(2444, 2, 'Monday', 2, 1, 1),
(2445, 2, 'Thursday', 6, 1, 1),
(2446, 2, 'Wednesday', 2, 1, 1),
(2447, 2, 'Thursday', 4, 2, 5),
(2448, 2, 'Tuesday', 1, 2, 5),
(2449, 2, 'Thursday', 2, 2, 5),
(2450, 2, 'Thursday', 1, 5, 10),
(2451, 2, 'Monday', 5, 2, 5),
(2452, 2, 'Friday', 2, 5, 10),
(2453, 2, 'Friday', 4, 5, 10),
(2454, 2, 'Friday', 3, 6, 3),
(2455, 2, 'Monday', 6, 5, 10),
(2456, 2, 'Monday', 4, 6, 3),
(2457, 2, 'Wednesday', 4, 6, 3),
(2458, 2, 'Wednesday', 6, 7, 2),
(2459, 2, 'Tuesday', 6, 8, 8),
(2460, 2, 'Monday', 1, 7, 2),
(2461, 2, 'Thursday', 3, 7, 2),
(2462, 2, 'Tuesday', 3, 8, 8),
(2463, 1, 'Wednesday', 3, 3, 2),
(2464, 1, 'Thursday', 5, 3, 2),
(2465, 1, 'Thursday', 4, 3, 2),
(2466, 1, 'Wednesday', 6, 4, 3),
(2467, 1, 'Thursday', 6, 4, 3),
(2468, 1, 'Monday', 3, 4, 3),
(2469, 1, 'Monday', 6, 3, 2),
(2470, 1, 'Monday', 1, 4, 3),
(2471, 1, 'Monday', 5, 3, 2),
(2472, 1, 'Monday', 2, 2, 6),
(2473, 1, 'Wednesday', 2, 4, 3),
(2474, 1, 'Friday', 3, 1, 1),
(2475, 1, 'Friday', 1, 1, 1),
(2476, 1, 'Friday', 4, 2, 6),
(2477, 1, 'Monday', 4, 1, 1),
(2478, 1, 'Friday', 6, 2, 6),
(2479, 1, 'Tuesday', 6, 1, 1),
(2480, 1, 'Wednesday', 1, 2, 6),
(2481, 1, 'Thursday', 1, 6, 3),
(2482, 1, 'Tuesday', 2, 5, 10),
(2483, 1, 'Tuesday', 3, 5, 10),
(2484, 1, 'Tuesday', 1, 6, 3),
(2485, 1, 'Thursday', 2, 5, 10),
(2486, 1, 'Tuesday', 4, 6, 3),
(2487, 1, 'Tuesday', 5, 8, 8),
(2488, 1, 'Friday', 5, 5, 10),
(2489, 1, 'Wednesday', 4, 7, 2),
(2490, 1, 'Friday', 2, 7, 2),
(2491, 1, 'Thursday', 3, 8, 8),
(2492, 1, 'Wednesday', 5, 8, 8),
(2493, 3, 'Thursday', 4, 3, 7),
(2494, 3, 'Monday', 5, 3, 7),
(2495, 3, 'Wednesday', 3, 3, 7),
(2496, 3, 'Thursday', 6, 3, 7),
(2497, 3, 'Tuesday', 2, 3, 7),
(2498, 3, 'Thursday', 5, 4, 5),
(2499, 3, 'Thursday', 2, 1, 1),
(2500, 3, 'Tuesday', 3, 4, 5),
(2501, 3, 'Friday', 4, 4, 5),
(2502, 3, 'Monday', 4, 4, 5),
(2503, 3, 'Thursday', 3, 4, 5),
(2504, 3, 'Friday', 2, 1, 1),
(2505, 3, 'Friday', 6, 1, 1),
(2506, 3, 'Wednesday', 4, 1, 1),
(2507, 3, 'Tuesday', 6, 2, 6),
(2508, 3, 'Tuesday', 5, 2, 6),
(2509, 3, 'Tuesday', 4, 5, 10),
(2510, 3, 'Monday', 1, 2, 6),
(2511, 3, 'Friday', 1, 2, 6),
(2512, 3, 'Wednesday', 5, 5, 10),
(2513, 3, 'Friday', 5, 6, 5),
(2514, 3, 'Monday', 6, 6, 5),
(2515, 3, 'Wednesday', 1, 5, 10),
(2516, 3, 'Tuesday', 1, 5, 10),
(2517, 3, 'Wednesday', 6, 6, 5),
(2518, 3, 'Monday', 3, 7, 7),
(2519, 3, 'Friday', 3, 7, 7),
(2520, 3, 'Monday', 2, 7, 7),
(2521, 3, 'Thursday', 1, 8, 8),
(2522, 3, 'Wednesday', 2, 8, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`batch_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `teacher_availability`
--
ALTER TABLE `teacher_availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `teaching_hours`
--
ALTER TABLE `teaching_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `fk_batch` (`batch_id`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `batch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `teacher_availability`
--
ALTER TABLE `teacher_availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;

--
-- AUTO_INCREMENT for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `teaching_hours`
--
ALTER TABLE `teaching_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2523;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`batch_id`);

--
-- Constraints for table `teacher_availability`
--
ALTER TABLE `teacher_availability`
  ADD CONSTRAINT `teacher_availability_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);

--
-- Constraints for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD CONSTRAINT `teacher_subjects_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`),
  ADD CONSTRAINT `teacher_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `teacher_subjects_ibfk_3` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`batch_id`);

--
-- Constraints for table `teaching_hours`
--
ALTER TABLE `teaching_hours`
  ADD CONSTRAINT `fk_batch` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`batch_id`),
  ADD CONSTRAINT `teaching_hours_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`),
  ADD CONSTRAINT `teaching_hours_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);

--
-- Constraints for table `timetable`
--
ALTER TABLE `timetable`
  ADD CONSTRAINT `timetable_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`batch_id`),
  ADD CONSTRAINT `timetable_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `timetable_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
