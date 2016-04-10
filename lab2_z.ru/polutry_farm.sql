-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 26 2016 г., 02:17
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `polutry_farm`
--

-- --------------------------------------------------------

--
-- Структура таблицы `egg`
--

CREATE TABLE IF NOT EXISTS `egg` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `kol` double NOT NULL,
  `date` date NOT NULL,
  `ed_izm` varchar(2) NOT NULL COMMENT '1- шт, 0 -кг ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `egg`
--

INSERT INTO `egg` (`id`, `kol`, `date`, `ed_izm`) VALUES
(1, 100, '2016-03-01', 'шт');

-- --------------------------------------------------------

--
-- Структура таблицы `feed`
--

CREATE TABLE IF NOT EXISTS `feed` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `kol` double NOT NULL,
  `name_feed` varchar(30) NOT NULL,
  `ed_izm` varchar(2) NOT NULL COMMENT '1- шт, 0 -кг ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `feed`
--

INSERT INTO `feed` (`id`, `kol`, `name_feed`, `ed_izm`) VALUES
(1, 20, 'Корм для куриц', 'шт');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `login` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `fio` varchar(60) NOT NULL,
  `level` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `fio`, `level`) VALUES
(1, 'pirat', '12345', 'pirat@mail.ru', 'Иванов Иван Иванович', 0),
(2, 'peter', '55555', 'peter@mail.ru', 'Петр Петрович Петров', 0),
(3, 'Kichkun', 'Nastya1995', 'Kirinushka@mail.ru', '', 0),
(4, 'Kirinushka', 'Nastya1995', 'Kichkun@yandex.ru', '', 0),
(5, 'mgofrs', 'Nastya1995', 'Kichkun@yandex.ru', '', 1),
(6, 'qwert', 'Nastya1995', 'Kichkun@yandex.ru', '', 1),
(7, 'ewrwer', 'Nastya1995', 'Kichkun@yandex.ru', '', 2),
(8, 'Kirinush', 'Nastya1995', 'kichkun@yandex.ru', '', 1),
(9, 'Kirinus', 'Nastya1995', 'kichkun@yandex.ru', '', 1),
(10, 'Kichkunf', 'Nastya1995', 'kirinushka@mail.ru', 'fsdfsdfsdfssdfdsf', 1),
(11, 'Kichkuns', 'Nastya1995', 'kirinushka@mail.ru', 'fsdfsdfsdfssdfdsf', 1),
(12, 'Kichku', 'Nastya1995', 'kirinushka@mail.ru', 'fsdfsdfsdfssdfdsf', 1),
(13, 'Kichk', 'Nastya1995', 'kirinushka@mail.ru', 'fsdfsdfsdfssdfdsf', 1),
(14, 'Kich', 'Nastya1995', 'kirinushka@mail.ru', 'fsdfsdfsdfssdfdsf', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
