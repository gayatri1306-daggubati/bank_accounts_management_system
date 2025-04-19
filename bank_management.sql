-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2025 at 03:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank_management`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `deposit_amount` (IN `acc_id` INT, IN `amt` DECIMAL(10,2))   BEGIN
    -- Update the balance of the account
    UPDATE accounts
    SET balance = balance + amt
    WHERE account_id = acc_id;

    -- Insert the transaction into the transactions table with 'transaction_date' column
    INSERT INTO transactions (account_id, type, amount, transaction_date)
    VALUES (acc_id, 'deposit', amt, NOW());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `withdraw_amount` (IN `acc_id` INT, IN `amt` DECIMAL(10,2))   BEGIN
    DECLARE current_balance DECIMAL(10,2);

    -- Get current balance
    SELECT balance INTO current_balance FROM accounts WHERE account_id = acc_id;

    -- Check balance
    IF current_balance >= amt THEN
        -- Update balance
        UPDATE accounts SET balance = balance - amt WHERE account_id = acc_id;

        -- Insert transaction (omit transaction_id so it autoincrements)
        INSERT INTO transactions (account_id, type, amount) 
        VALUES (acc_id, 'withdraw', amt);
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `account_type` varchar(20) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `customer_id`, `account_type`, `balance`) VALUES
(101, 1, 'Savings', 49000.00),
(102, 2, 'Current', 32500.50),
(103, 3, 'Savings', 18500.75),
(104, 4, 'Current', 47000.00),
(105, 5, 'Savings', 12000.20),
(106, 6, 'Current', 54000.00),
(107, 7, 'Savings', 29999.99),
(108, 8, 'Current', 10200.00),
(109, 9, 'Savings', 18000.80),
(110, 10, 'Current', 26500.00),
(111, 11, 'Savings', 15500.00),
(112, 12, 'Current', 23000.00),
(113, 13, 'Savings', 47000.90),
(114, 14, 'Current', 11900.40),
(115, 15, 'Savings', 38000.00),
(116, 16, 'Current', 45000.00),
(117, 17, 'Savings', 13500.00),
(118, 18, 'Current', 31500.60),
(119, 19, 'Savings', 22200.00),
(120, 20, 'Current', 18900.99),
(121, 21, 'Savings', 29999.00),
(122, 22, 'Current', 33200.00),
(123, 23, 'Savings', 22000.75),
(124, 24, 'Current', 41000.10),
(125, 25, 'Savings', 28000.00),
(126, 26, 'Current', 36000.00),
(127, 27, 'Savings', 19000.00),
(128, 28, 'Current', 40000.00),
(129, 29, 'Savings', 16500.25),
(130, 30, 'Current', 50000.00),
(131, 31, 'Savings', 11000.00),
(132, 32, 'Current', 30000.00),
(133, 33, 'Savings', 47000.00),
(134, 34, 'Current', 27000.00),
(135, 35, 'Savings', 29500.00),
(136, 36, 'Current', 39000.00),
(137, 37, 'Savings', 24800.50),
(138, 38, 'Current', 13000.00),
(139, 39, 'Savings', 18000.00),
(140, 40, 'Current', 22000.00),
(141, 41, 'Savings', 37000.00),
(142, 42, 'Current', 26000.00),
(143, 43, 'Savings', 31000.00),
(144, 44, 'Current', 19500.00),
(145, 45, 'Savings', 21000.00),
(146, 46, 'Current', 42500.00),
(147, 47, 'Savings', 29800.00),
(148, 48, 'Current', 34700.00),
(149, 49, 'Savings', 19900.00),
(150, 50, 'Current', 28900.00),
(151, 51, 'Current', 12500.00),
(152, 52, 'Current', 34000.00),
(153, 53, 'Savings', 50000.00);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`) VALUES
(111, 'Ranganayukulu', 'ranga1105'),
(222, 'Suhasini', 'bachi1505');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `email`, `phone`, `address`) VALUES
(1, 'Daggubati Gayatri', 'gayatri1897976@gmail.com', '9876543210', 'Karamchedu, Bapatla'),
(2, 'Ravi Teja', 'raviteja123@gmail.com', '9876543211', 'Guntur, Andhra Pradesh'),
(3, 'Anusha Reddy', 'anushareddy@gmail.com', '9876543212', 'Vijayawada, Andhra Pradesh'),
(4, 'Mahesh Kumar', 'maheshkumar@gmail.com', '9876543213', 'Tenali, Guntur'),
(5, 'Pavani Devi', 'pavanidevi@yahoo.com', '9876543214', 'Narasaraopet, Guntur'),
(6, 'Srinivas Rao', 'srinivasrao@gmail.com', '9876543215', 'Ongole, Prakasam'),
(7, 'Karthik Reddy', 'karthikreddy@gmail.com', '9876543216', 'Addanki, Prakasam'),
(8, 'Bhavani Lakshmi', 'bhavani.lakshmi@gmail.com', '9876543217', 'Chirala, Bapatla'),
(9, 'Chaitanya Varma', 'chaituvarma@gmail.com', '9876543218', 'Ponnur, Guntur'),
(10, 'Sowmya Sree', 'sowmyasree@gmail.com', '9876543219', 'Repalle, Guntur'),
(11, 'Naveen Krishna', 'naveenkrishna@gmail.com', '9876543220', 'Kolluru, Guntur'),
(12, 'Lakshmi Prasanna', 'lakshmiprasanna@gmail.com', '9876543221', 'Vinukonda, Guntur'),
(13, 'Ajay Kumar', 'ajaykumar@gmail.com', '9876543222', 'Piduguralla, Guntur'),
(14, 'Keerthi Raj', 'keerthiraj@yahoo.com', '9876543223', 'Machilipatnam, Krishna'),
(15, 'Harika Devi', 'harikadevi@gmail.com', '9876543224', 'Jaggayyapeta, Krishna'),
(16, 'Rajesh Babu', 'rajeshbabu@gmail.com', '9876543225', 'Markapur, Prakasam'),
(17, 'Sunitha Rao', 'sunitharao@yahoo.com', '9876543226', 'Tadepalli, Guntur'),
(18, 'Tejaswini', 'tejaswini123@gmail.com', '9876543227', 'Mangalagiri, Guntur'),
(19, 'Sravan Kumar', 'sravankumar@gmail.com', '9876543228', 'Sattenapalli, Guntur'),
(20, 'Deepika Naga', 'deepikanaga@gmail.com', '9876543229', 'Bapatla, Andhra Pradesh'),
(21, 'Ramesh Chandra', 'ramesh.chandra@gmail.com', '9876543230', 'Guntur, Andhra Pradesh'),
(22, 'Lavanya Sri', 'lavanyasri@gmail.com', '9876543231', 'Vijayawada, Andhra Pradesh'),
(23, 'Vamshi Krishna', 'vamshikrishna@gmail.com', '9876543232', 'Tenali, Guntur'),
(24, 'Sujatha Latha', 'sujathalatha@gmail.com', '9876543233', 'Narasaraopet, Guntur'),
(25, 'Rahul Varma', 'rahulvarma@gmail.com', '9876543234', 'Ongole, Prakasam'),
(26, 'Yamuna Reddy', 'yamunareddy@gmail.com', '9876543235', 'Addanki, Prakasam'),
(27, 'Sudheer Babu', 'sudheerbabu@gmail.com', '9876543236', 'Chirala, Bapatla'),
(28, 'Pranavi Teja', 'pranaviteja@gmail.com', '9876543237', 'Ponnur, Guntur'),
(29, 'Niharika Rao', 'niharikarao@gmail.com', '9876543238', 'Repalle, Guntur'),
(30, 'Venkatesh Reddy', 'venkateshreddy@gmail.com', '9876543239', 'Kolluru, Guntur'),
(31, 'Sneha Sri', 'snehasri@gmail.com', '9876543240', 'Vinukonda, Guntur'),
(32, 'Sumanth', 'sumanth123@gmail.com', '9876543241', 'Piduguralla, Guntur'),
(33, 'Gayathri N', 'gayathri.n@gmail.com', '9876543242', 'Machilipatnam, Krishna'),
(34, 'Siva Prasad', 'sivaprasad@gmail.com', '9876543243', 'Jaggayyapeta, Krishna'),
(35, 'Indu Madhavi', 'indumadhavi@gmail.com', '9876543244', 'Markapur, Prakasam'),
(36, 'Ragini Devi', 'raginidevi@gmail.com', '9876543245', 'Tadepalli, Guntur'),
(37, 'Rohith Kumar', 'rohithkumar@gmail.com', '9876543246', 'Mangalagiri, Guntur'),
(38, 'Sravya Teja', 'sravyateja@gmail.com', '9876543247', 'Sattenapalli, Guntur'),
(39, 'Mounika R', 'mounikar@gmail.com', '9876543248', 'Bapatla, Andhra Pradesh'),
(40, 'Kiran Kumar', 'kirankumar@gmail.com', '9876543249', 'Guntur, Andhra Pradesh'),
(41, 'Manoj Reddy', 'manojreddy@gmail.com', '9876543250', 'Vijayawada, Andhra Pradesh'),
(42, 'Jahnavi', 'jahnavi@gmail.com', '9876543251', 'Tenali, Guntur'),
(43, 'Praveen K', 'praveenk@gmail.com', '9876543252', 'Narasaraopet, Guntur'),
(44, 'Vijaya Lakshmi', 'vijayalakshmi@gmail.com', '9876543253', 'Ongole, Prakasam'),
(45, 'Santosh Varma', 'santoshvarma@gmail.com', '9876543254', 'Addanki, Prakasam'),
(46, 'Anjali Sharma', 'anjalisharma@gmail.com', '9876543255', 'Chirala, Bapatla'),
(47, 'Nithin Sai', 'nithinsai@gmail.com', '9876543256', 'Ponnur, Guntur'),
(48, 'Akhila Devi', 'akhiladevi@gmail.com', '9876543257', 'Repalle, Guntur'),
(49, 'Vishnu Tej', 'vishnutej@gmail.com', '9876543258', 'Kolluru, Guntur'),
(50, 'Divya Bharathi', 'divyabharathi@gmail.com', '9876543259', 'Vinukonda, Guntur'),
(51, 'moparthi rathna kumari', 'rathna5124@gmail.com', '7869848789', 'veerannapalem,parchur'),
(52, 'rangaiah', 'daggubati456@gmail.com', '7656453875', 'parchur,bapatla'),
(53, 'rohan', 'rohan678@gmail.com', '9865342789', 'chirala');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `transaction_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `account_id`, `type`, `amount`, `transaction_date`) VALUES
(1, 151, 'deposit', 1500.00, '2025-04-17 00:00:00'),
(201, 101, 'Deposit', 10000.00, '2025-03-01 00:00:00'),
(202, 102, 'Withdrawal', 5000.00, '2025-03-02 00:00:00'),
(203, 103, 'Deposit', 15000.00, '2025-03-03 00:00:00'),
(204, 104, 'Transfer', 8000.00, '2025-03-04 00:00:00'),
(205, 105, 'Deposit', 20000.00, '2025-03-05 00:00:00'),
(206, 106, 'Withdrawal', 12000.00, '2025-03-06 00:00:00'),
(207, 107, 'Transfer', 5000.00, '2025-03-07 00:00:00'),
(208, 108, 'Deposit', 8000.00, '2025-03-08 00:00:00'),
(209, 109, 'Withdrawal', 7000.00, '2025-03-09 00:00:00'),
(210, 110, 'Deposit', 11000.00, '2025-03-10 00:00:00'),
(211, 111, 'Transfer', 10000.00, '2025-03-11 00:00:00'),
(212, 112, 'Withdrawal', 15000.00, '2025-03-12 00:00:00'),
(213, 113, 'Deposit', 5000.00, '2025-03-13 00:00:00'),
(214, 114, 'Transfer', 6000.00, '2025-03-14 00:00:00'),
(215, 115, 'Withdrawal', 8000.00, '2025-03-15 00:00:00'),
(216, 116, 'Deposit', 13000.00, '2025-03-16 00:00:00'),
(217, 117, 'Transfer', 4500.00, '2025-03-17 00:00:00'),
(218, 118, 'Deposit', 9000.00, '2025-03-18 00:00:00'),
(219, 119, 'Withdrawal', 20000.00, '2025-03-19 00:00:00'),
(220, 120, 'Deposit', 11000.00, '2025-03-20 00:00:00'),
(221, 121, 'Transfer', 7500.00, '2025-03-21 00:00:00'),
(222, 122, 'Withdrawal', 8000.00, '2025-03-22 00:00:00'),
(223, 123, 'Deposit', 9000.00, '2025-03-23 00:00:00'),
(224, 124, 'Transfer', 12000.00, '2025-03-24 00:00:00'),
(225, 125, 'Withdrawal', 15000.00, '2025-03-25 00:00:00'),
(226, 126, 'Deposit', 16000.00, '2025-03-26 00:00:00'),
(227, 127, 'Transfer', 13000.00, '2025-03-27 00:00:00'),
(228, 128, 'Withdrawal', 20000.00, '2025-03-28 00:00:00'),
(229, 129, 'Deposit', 14000.00, '2025-03-29 00:00:00'),
(230, 130, 'Transfer', 20000.00, '2025-03-30 00:00:00'),
(231, 131, 'Withdrawal', 8000.00, '2025-03-31 00:00:00'),
(232, 132, 'Deposit', 10000.00, '2025-04-01 00:00:00'),
(233, 133, 'Transfer', 9000.00, '2025-04-02 00:00:00'),
(234, 134, 'Withdrawal', 12000.00, '2025-04-03 00:00:00'),
(235, 135, 'Deposit', 7000.00, '2025-04-04 00:00:00'),
(236, 136, 'Transfer', 5000.00, '2025-04-05 00:00:00'),
(237, 137, 'Withdrawal', 13000.00, '2025-04-06 00:00:00'),
(238, 138, 'Deposit', 8000.00, '2025-04-07 00:00:00'),
(239, 139, 'Transfer', 12000.00, '2025-04-08 00:00:00'),
(240, 140, 'Withdrawal', 15000.00, '2025-04-09 00:00:00'),
(241, 141, 'Deposit', 9000.00, '2025-04-10 00:00:00'),
(242, 142, 'Transfer', 7000.00, '2025-04-11 00:00:00'),
(243, 143, 'Withdrawal', 11000.00, '2025-04-12 00:00:00'),
(244, 144, 'Deposit', 25000.00, '2025-04-13 00:00:00'),
(245, 145, 'Transfer', 6000.00, '2025-04-14 00:00:00'),
(246, 146, 'Withdrawal', 14000.00, '2025-04-15 00:00:00'),
(247, 147, 'Deposit', 15000.00, '2025-04-16 00:00:00'),
(248, 148, 'Transfer', 8000.00, '2025-04-17 00:00:00'),
(249, 149, 'Withdrawal', 10000.00, '2025-04-18 00:00:00'),
(250, 150, 'Deposit', 19000.00, '2025-04-16 00:00:00'),
(251, 151, 'withdraw', 3000.00, '0000-00-00 00:00:00'),
(252, 151, 'deposit', 3000.00, '2025-04-17 00:00:00'),
(253, 151, 'deposit', 1000.00, '2025-04-18 00:00:00'),
(254, NULL, 'withdraw', NULL, '2025-04-18 00:00:00'),
(255, 151, 'withdraw', 2000.00, '0000-00-00 00:00:00'),
(256, NULL, 'deposit', NULL, '2025-04-18 07:10:57'),
(257, 151, 'deposit', 10000.00, '2025-04-18 07:13:36'),
(258, 151, 'withdraw', 1500.00, '2025-04-18 07:21:27'),
(259, 101, 'deposit', 25000.00, '2025-04-18 08:06:46'),
(260, 101, 'withdraw', 1000.00, '2025-04-18 08:07:18'),
(261, 152, 'deposit', 25000.00, '2025-04-18 09:52:47'),
(262, 152, 'withdraw', 1000.00, '2025-04-18 09:53:32'),
(263, 153, 'deposit', 50000.00, '2025-04-18 10:00:16'),
(264, 153, 'withdraw', 1000.00, '2025-04-18 10:00:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `account_id` (`account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
