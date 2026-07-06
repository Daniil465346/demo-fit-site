-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 10.0.0.57
-- Время создания: Май 13 2024 г., 23:44
-- Версия сервера: 5.7.37-40
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `f0951856_qqq1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `class_schedule`
--

CREATE TABLE `class_schedule` (
  `class_id` int(11) NOT NULL,
  `class_name` enum('Йога','SPA-процедуры','Персональная тренировка','Танцы','Посещение зала') COLLATE utf8mb4_unicode_ci NOT NULL,
  `day_of_week` date NOT NULL,
  `time_slot` time NOT NULL,
  `end_time` time NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `class_schedule`
--

INSERT INTO `class_schedule` (`class_id`, `class_name`, `day_of_week`, `time_slot`, `end_time`, `available`) VALUES
(30, 'Посещение зала', '2024-04-30', '14:00:00', '16:00:00', 1),
(35, 'Йога', '2024-04-30', '22:29:00', '22:31:00', 1),
(38, 'Йога', '2024-05-05', '13:10:00', '15:20:00', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `coaches`
--

CREATE TABLE `coaches` (
  `coach_id` int(11) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialization` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `coaches`
--

INSERT INTO `coaches` (`coach_id`, `email`, `password`, `name`, `specialization`) VALUES
(1, 'coach1@gmail.com', '123', 'Иван Иванов', 'Йога'),
(2, 'coach2@gmail.com', '123', 'Сергей Смирнов', 'Танцы'),
(3, 'coach3@gmail.com', '123', 'Алексей Кондрашов', 'Посещение зала');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_published` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`news_id`, `title`, `content`, `date_published`) VALUES
(2, 'Добро пожаловать!', 'Мы уже открылись!', '2024-04-29 18:56:38'),
(5, 'vfve', 'evrvref', '2024-04-29 20:41:17');

-- --------------------------------------------------------

--
-- Структура таблицы `sports`
--

CREATE TABLE `sports` (
  `userid` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namesport` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_schedule_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sports`
--

INSERT INTO `sports` (`userid`, `name`, `surname`, `email`, `namesport`, `class_schedule_id`) VALUES
(1, NULL, NULL, 'uoio@S3322', '', NULL),
(5, NULL, NULL, 'uoio@S', '', NULL),
(42, NULL, NULL, 'yt', 'Посещение зала', 30),
(45, NULL, NULL, 'user@gmail.com', 'Посещение зала', 30),
(48, NULL, NULL, 'mmm@mmm', 'Посещение зала', 30),
(49, NULL, NULL, 'user1@gmail.com', 'Йога', 35);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `create_datetime`) VALUES
(1, 'frt@dzffr', '6512bd43d9caa6e02c990b0a82652dca', '2024-03-07 17:39:22'),
(2, 'x@w', 'c81e728d9d4c2f636f067f89cc14862c', '2024-03-07 17:42:29'),
(3, 'uoio@S', 'c4ca4238a0b923820dcc509a6f75849b', '2024-03-07 18:09:12'),
(4, 'eqtwqet@com', 'c4ca4238a0b923820dcc509a6f75849b', '2024-03-07 20:02:59'),
(5, 'uoio@S3322', 'c4ca4238a0b923820dcc509a6f75849b', '2024-03-07 21:04:35'),
(6, 'й@q', 'c4ca4238a0b923820dcc509a6f75849b', '2024-03-08 17:37:26'),
(7, 'q@ttt', 'c4ca4238a0b923820dcc509a6f75849b', '2024-03-14 18:45:39'),
(8, 'www@yy', 'c4ca4238a0b923820dcc509a6f75849b', '2024-03-14 18:52:47'),
(9, 'ннн@qq', 'c4ca4238a0b923820dcc509a6f75849b', '2024-04-21 16:10:14'),
(10, 'admin@com', '123', '2024-04-22 17:02:09'),
(11, 'nnnnn@nn', 'c4ca4238a0b923820dcc509a6f75849b', '2024-04-22 17:39:34'),
(12, 'mmm@mmm', '1', '2024-04-22 17:43:09'),
(13, 'ркшре', '1', '2024-04-22 19:46:48'),
(14, 'Я@Я', '12', '2024-04-22 21:43:38'),
(15, 'etyr@w', '1', '2024-04-24 15:36:27'),
(16, 'yt', '1', '2024-04-24 15:43:38'),
(17, 'user@gmail.com', '77', '2024-04-27 12:59:20'),
(18, 'user1@gmail.com', '111', '2024-04-29 20:48:40');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `class_schedule`
--
ALTER TABLE `class_schedule`
  ADD PRIMARY KEY (`class_id`);

--
-- Индексы таблицы `coaches`
--
ALTER TABLE `coaches`
  ADD PRIMARY KEY (`coach_id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Индексы таблицы `sports`
--
ALTER TABLE `sports`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `sports_ibfk_1` (`class_schedule_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `class_schedule`
--
ALTER TABLE `class_schedule`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT для таблицы `coaches`
--
ALTER TABLE `coaches`
  MODIFY `coach_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `sports`
--
ALTER TABLE `sports`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `sports`
--
ALTER TABLE `sports`
  ADD CONSTRAINT `sports_ibfk_1` FOREIGN KEY (`class_schedule_id`) REFERENCES `class_schedule` (`class_id`) ON DELETE CASCADE;

DELIMITER $$
--
-- События
--
CREATE DEFINER=`f0951856`@`10.0.1.23` EVENT `delete_expired_classes` ON SCHEDULE EVERY 1 MINUTE STARTS '2024-05-01 20:45:29' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM class_schedule WHERE CONCAT(day_of_week, ' ', end_time) < NOW()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
