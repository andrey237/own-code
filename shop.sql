-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Сен 25 2016 г., 01:50
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `rs_booking_clients`
--

CREATE TABLE IF NOT EXISTS `rs_booking_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `family` char(100) NOT NULL,
  `first_name` char(100) NOT NULL,
  `last_name` char(100) NOT NULL,
  `email` char(100) NOT NULL,
  `phone` char(21) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `rs_booking_hotels`
--

CREATE TABLE IF NOT EXISTS `rs_booking_hotels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL,
  `stars` tinyint(3) unsigned NOT NULL DEFAULT '5',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `rs_booking_hotels`
--

INSERT INTO `rs_booking_hotels` (`id`, `title`, `stars`) VALUES
(1, 'Моя гостиница', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `rs_booking_orders`
--

CREATE TABLE IF NOT EXISTS `rs_booking_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` int(10) unsigned NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `start_date` int(10) unsigned NOT NULL,
  `end_date` int(10) unsigned NOT NULL,
  `price` float unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `rs_booking_rooms`
--

CREATE TABLE IF NOT EXISTS `rs_booking_rooms` (
  `number` int(10) unsigned NOT NULL,
  `hotel_id` int(10) unsigned NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`number`,`hotel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `rs_booking_rooms`
--

INSERT INTO `rs_booking_rooms` (`number`, `hotel_id`, `type_id`) VALUES
(1, 1, 1),
(2, 1, 1),
(3, 1, 1),
(4, 1, 1),
(5, 1, 2),
(6, 1, 1),
(7, 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `rs_booking_room_types`
--

CREATE TABLE IF NOT EXISTS `rs_booking_room_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL,
  `max_places` tinyint(3) unsigned NOT NULL,
  `description` text,
  `price` float unsigned NOT NULL,
  `hotel_id` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `rs_booking_room_types`
--

INSERT INTO `rs_booking_room_types` (`id`, `title`, `max_places`, `description`, `price`, `hotel_id`) VALUES
(1, 'Одноместный', 1, NULL, 237, 1),
(2, 'Двухместный', 2, NULL, 777, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `rs_components`
--

CREATE TABLE IF NOT EXISTS `rs_components` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tile` char(50) NOT NULL,
  `params` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tile` (`tile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `rs_modules`
--

CREATE TABLE IF NOT EXISTS `rs_modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(50) NOT NULL,
  `params` text,
  `component_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `rs_pages`
--

CREATE TABLE IF NOT EXISTS `rs_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(50) NOT NULL,
  `alias` char(50) NOT NULL,
  `published` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `rs_page_modules`
--

CREATE TABLE IF NOT EXISTS `rs_page_modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(10) unsigned NOT NULL,
  `module_id` int(10) unsigned NOT NULL,
  `position` char(50) DEFAULT NULL,
  `published` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `rs_shop_products`
--

CREATE TABLE IF NOT EXISTS `rs_shop_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(70) NOT NULL,
  `description` text,
  `price` float NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `rs_shop_products`
--

INSERT INTO `rs_shop_products` (`id`, `title`, `description`, `price`) VALUES
(1, 'Монитор 23" LG Flatron LCD W2343S-PF', 'Соотношение сторон 16:9\r\nВ отличие от стандартных широкоформатных моделей, которые имеют соотношение сторон 16:10, панель нового размера идеально подходит для просмотра видео в формате Full HD 1080p, мультимедийных приложений\r\n\r\nСтильный дизайн\r\nСтильный вид и плавные линии создают элегантный дизайн монитора серии W43. Он понравится тем, кого заботится о том, как выглядит интерьер дома или офиса. Обязательно украсит любое помещение и сделает приятным просмотр кинофильмов, работу на компьютере или игру\r\n\r\nВысокое качество изображения\r\nМонитор имеет высокий коэффициент динамической контрастности — 30 000:1 и время отклика 5 мс.\r\n\r\nФункции FUN Key\r\nБлагодаря набору функций Fun Package мониторы серии W43 принесут ещё большее удовольствие всей семье. Например, режим 4:3 in Wide позволяет корректно отображать игры и фильмы с соотношением сторон 4:3 на широкоформатном экране, а не искажать их. Функция Photo Effects понравится любителям потокового видео или слайд-шоу. Нажатием одной кнопки к изображению можно применить один из четырех визуальных эффектов: «Natural», «Gaussian Blur», «Sepia», «Monochrome», не запуская программы редактирования графики, чтобы оживить просмотр.\r\n\r\nПеред покупкой товаров мы настоятельно рекомендуем проконсультироваться с нашим менеджером и уточнить все существенные для вас технические характеристики товаров, внешний вид, условия эксплуатации, гарантии и другие вопросы, которые могут повлиять на его использование. Характеристики и внешний вид товаров могут быть изменены производителем без предварительного уведомления, поэтому рекомендуем проверять их на официальном сайте производителя перед покупкой.', 185),
(2, 'Монитор 22" LG Flatron LCD W2243S-PF', 'Бюджетный 22" широкоформатный монитор с соотношением сторон 16:9. Монитор поддерживает Full HD разрешение: 1920х1080.\r\n\r\nПеред покупкой товаров мы настоятельно рекомендуем проконсультироваться с нашим менеджером и уточнить все существенные для вас технические характеристики товаров, внешний вид, условия эксплуатации, гарантии и другие вопросы, которые могут повлиять на его использование. Характеристики и внешний вид товаров могут быть изменены производителем без предварительного уведомления, поэтому рекомендуем проверять их на официальном сайте производителя перед покупкой.', 153),
(3, 'Монитор 19" LG Flatron LCD W1943SE-PF', 'Монитор серии W43 с соотношением сторон 16:9 позволяет демонстрировать кинофильмы, игры и другие материалы в полный размер, с высокой разрешающей способностью и без искажений. Монитор предлагает превросходное качество изображения по разумной цене.\r\n\r\nПеред покупкой товаров мы настоятельно рекомендуем проконсультироваться с нашим менеджером и уточнить все существенные для вас технические характеристики товаров, внешний вид, условия эксплуатации, гарантии и другие вопросы, которые могут повлиять на его использование. Характеристики и внешний вид товаров могут быть изменены производителем без предварительного уведомления, поэтому рекомендуем проверять их на официальном сайте производителя перед покупкой.', 120),
(4, 'Монитор 19" LG Flatron LCD W1943SS-PF Glossy Black', 'Монитор серии W43 с соотношением сторон 16:9 позволяет демонстрировать кинофильмы, игры и другие материалы в полный размер, с высокой разрешающей способностью и без искажений. Монитор предлагает превросходное качество изображения по разумной цене.\r\n\r\nПеред покупкой товаров мы настоятельно рекомендуем проконсультироваться с нашим менеджером и уточнить все существенные для вас технические характеристики товаров, внешний вид, условия эксплуатации, гарантии и другие вопросы, которые могут повлиять на его использование. Характеристики и внешний вид товаров могут быть изменены производителем без предварительного уведомления, поэтому рекомендуем проверять их на официальном сайте производителя перед покупкой.', 117),
(11, '"dublicate"', 'Test test test with ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates", ''single quates'' and "double quates".', 32412),
(12, 'ghfhs', '', 45664),
(17, 'hjkhj', '', 27),
(18, 'kjljlgjjl', '', 34535),
(19, 'Test', NULL, 23.77),
(20, 'hjghgh', '', 3432),
(23, 'rtyry', '', 12.45),
(24, 'dsfsdfsdf', '', 565);

-- --------------------------------------------------------

--
-- Структура таблицы `rs_users`
--

CREATE TABLE IF NOT EXISTS `rs_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` char(255) NOT NULL,
  `user_password` char(255) NOT NULL,
  `email` char(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
