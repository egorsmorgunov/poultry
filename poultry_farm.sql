-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 18 2016 г., 15:17
-- Версия сервера: 5.5.47
-- Версия PHP: 5.4.45-0+deb7u2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `poultry`
--

-- --------------------------------------------------------

--
-- Структура таблицы `diet`
--

CREATE TABLE IF NOT EXISTS `diet` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `count` int(6) DEFAULT NULL,
  `day` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `diet`
--

INSERT INTO `diet` (`id`, `name`, `count`, `day`) VALUES
(1, 'мел', 350, 6),
(4, 'пшено', 100, 4),
(6, 'отруби', 65536, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `eggs`
--

CREATE TABLE IF NOT EXISTS `eggs` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `count` int(6) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Дамп данных таблицы `eggs`
--

INSERT INTO `eggs` (`id`, `count`, `date`) VALUES
(19, 245, '2016-04-07'),
(20, 74, '2016-04-05'),
(21, 210, '2016-04-02'),
(22, 163, '2016-04-04'),
(23, 45, '2016-04-08');

-- --------------------------------------------------------

--
-- Структура таблицы `food`
--

CREATE TABLE IF NOT EXISTS `food` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `count` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `food`
--

INSERT INTO `food` (`id`, `name`, `count`) VALUES
(1, 'отруби', 424),
(2, 'мел', 13),
(3, 'пшено', 58);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `login` varchar(10) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(30) NOT NULL,
  `full_name` varchar(60) NOT NULL,
  `level` int(2) NOT NULL,
  `unique_id` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `full_name`, `level`, `unique_id`) VALUES
(9, 'user', '5f4dcc3b5aa765d61d8327deb882cf99', 'usermail@email.ru', 'Иванов Иван Иванович', 99, 'dd418dac093f90814515395bd0ef5297'),
(10, 'user2', '5f4dcc3b5aa765d61d8327deb882cf99', 'user2@email.com', 'user user', 2, '9cbaac2810cad213dff5659b2d2748c5'),
(11, 'user1', '5f4dcc3b5aa765d61d8327deb882cf99', 'user1@email.ru', 'just user', 15, '4f80f5212c06c5aa0d26c3f3eee78c2b'),
(14, 'poultry', '163c3cc97d1c3ae4a21244b2ba294bef', 'poultry123@li.li', 'poultry poulrty', 99, '3e04d1da44f3b1356a774ac9a0a5426e');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
