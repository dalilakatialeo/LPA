-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2015 at 07:44 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: 'lpa_ecomms'
--

-- --------------------------------------------------------

--
-- Table structure for table 'lpa_clients'
--

CREATE TABLE IF NOT EXISTS 'lpa_clients' (
  'lpa_client_ID' int(10) NOT NULL AUTO_INCREMENT,
  'lpa_client_firstname' varchar(50) NOT NULL,
  'lpa_client_lastname' varchar(50) NOT NULL,
  'lpa_client_address' varchar(250) NOT NULL,
  'lpa_client_phone' varchar(30) NOT NULL,
  'lpa_client_status' char(1) NOT NULL,
  PRIMARY KEY ('lpa_client_ID')
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table 'lpa_clients'
--

INSERT INTO 'lpa_clients' ('lpa_client_ID', 'lpa_client_firstname', 'lpa_client_lastname', 'lpa_client_address', 'lpa_client_phone', 'lpa_client_status') VALUES
(1, 'Juan Fernando', 'Osorio Salazar', '135 Bage Street', '0467345283', 'E'),
(2, 'Carlos', 'Velasquez', 'Surfers Paradise', '0423457892', 'D');

-- --------------------------------------------------------

--
-- Table structure for table 'lpa_invoices'
--

CREATE TABLE IF NOT EXISTS 'lpa_invoices' (
  'lpa_inv_no' int(10) NOT NULL AUTO_INCREMENT,
  'lpa_inv_date' datetime NOT NULL,
  'lpa_inv_client_ID' varchar(20) NOT NULL,
  'lpa_inv_client_name' varchar(50) NOT NULL,
  'lpa_inv_client_address' varchar(250) NOT NULL,
  'lpa_inv_status' char(1) NOT NULL,
  PRIMARY KEY ('lpa_inv_no')
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table 'lpa_invoices'
--

INSERT INTO 'lpa_invoices' ('lpa_inv_no', 'lpa_inv_date', 'lpa_inv_client_ID', 'lpa_inv_client_name', 'lpa_inv_client_address', 'lpa_inv_amount', 'lpa_inv_status') VALUES
(1, '2014-06-12 17:10:03', 'jfosorios', 'Juan Fernando Osorio', '135 Bage Street', '450.00', 'P'),
(2, '2014-10-03 14:16:04', 'carlosvz', 'Carlos Velasquez', 'Surfers Paradise', '320.00', 'U'),
(3, '2014-10-02 10:41:12', 'anaosorio', 'Ana Osorio', 'Toombul Shopping Centre', '1250.00', 'P'),
(4, '2014-10-02 10:41:12', 'alma23', 'Alma Torres', '13 Bumbil Street', '230.00', 'P');

-- --------------------------------------------------------

--
-- Table structure for table 'lpa_invoice_items'
--

CREATE TABLE IF NOT EXISTS 'lpa_invoice_items' (
  'lpa_invitem_no' varchar(20) NOT NULL,
  'lpa_invitem_inv_no' varchar(20) NOT NULL,
  'lpa_invitem_stock_ID' varchar(20) NOT NULL,
  'lpa_invitem_stock_name' varchar(250) NOT NULL,
  'lpa_invitem_qty' varchar(6) NOT NULL,
  'lpa_invitem_stock_price' decimal(7,2) NOT NULL,
  'lpa_invitem_stock_amount' decimal(7,2),
  'lpa_inv_status' char(1) NOT NULL,
  PRIMARY KEY ('lpa_invitem_no')
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'lpa_stock'
--

CREATE TABLE IF NOT EXISTS 'lpa_stock' (
  'lpa_stock_ID' int(10) NOT NULL AUTO_INCREMENT,
  'lpa_stock_name' varchar(250) NOT NULL,
  'lpa_stock_desc' text NOT NULL,
  'lpa_stock_onhand' varchar(5) NOT NULL,
  'lpa_stock_price' decimal(7,2) NOT NULL,
  'lpa_stock_amount' decimal(7,2) N
  'lpa_image' varchar(255) NOT NULL,
  'lpa_stock_status' char(1) NOT NULL,
  PRIMARY KEY ('lpa_stock_ID')
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=129 ;

--
-- Dumping data for table 'lpa_stock'
--

INSERT INTO 'lpa_stock' ('lpa_stock_ID', 'lpa_stock_name', 'lpa_stock_desc', 'lpa_stock_onhand', 'lpa_stock_price', 'lpa_image', 'lpa_stock_status') VALUES
(123, 'Computer', 'Computer system', '4', '1500.00', 'Computer.png', 'a'),
(124, 'Apple iPad 4', 'This is an apple iPad 4', '4', '250.00', 'iPad.png', 'a'),
(125, 'Mini Display Port to VGA', 'Cable for Apple', '3', '33.00', '', 'a'),
(126, 'StLab U-470 USB 2.0 to VGA Adapter', ' VGA Adapter', '5', '42.00', 'adapter.jpg', 'a'),
(127, 'USB2.0 To Ethernet Adapter', 'Cable ', '5', '9.00', '', 'a'),
(128, 'Computer Monitor', 'LCD screen', '4', '21.54', 'monitor.png', 'a');

-- --------------------------------------------------------

--
-- Table structure for table 'lpa_users'
--

CREATE TABLE IF NOT EXISTS 'lpa_users' (
  'lpa_user_ID' int(10) NOT NULL AUTO_INCREMENT,
  'lpa_user_username' varchar(30) NOT NULL,
  'lpa_user_password' varchar(50) NOT NULL,
  'lpa_user_firstname' varchar(50) NOT NULL,
  'lpa_user_lastname' varchar(50) NOT NULL,
  'lpa_user_group' varchar(50) NOT NULL,
  'lpa_user_status' char(1) NOT NULL,
  PRIMARY KEY ('lpa_user_ID')
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table 'lpa_users'
--

INSERT INTO 'lpa_users' ('lpa_user_ID', 'lpa_user_username', 'lpa_user_password', 'lpa_user_firstname', 'lpa_user_lastname', 'lpa_user_group', 'lpa_user_status') VALUES
(1, 'admin', 'password', 'Juan Fernando', 'Osorio S', 'administrator', '1'),
(2, 'user', '12345', 'Oscar Mauricio', 'Salazar Ospina', 'user', '1'),
(3, 'codea', 'password', 'Steve', 'Coleman', 'administrator', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
