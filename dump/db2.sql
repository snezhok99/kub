-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Окт 27 2024 г., 18:31
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `db2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `authorization`
--

CREATE TABLE `authorization` (
  `ID_user` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `name` varchar(25) NOT NULL,
  `surname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `authorization`
--

INSERT INTO `authorization` (`ID_user`, `login`, `password_hash`, `name`, `surname`) VALUES
(1, 'nina16', '$2y$10$CPmmjsvkaDvQi.kabvqeqeH2AgGUxxo7/ZrAOu5UPB9Ps9j9M/uou', 'Нина', 'Чарьянц'),
(2, 'dasha123', '$2y$10$aGgerkhBO6iq4mEqETLQYu.7XwMqMdHeVRXpAGNS4bsnP1iEx8bqW', 'Дарья', 'Матвеева'),
(3, 'ivan123', '$2y$10$mYu.ObCdl3AqD8eW7N5Ehump.9JVn..yzep/nASwkoo5fwHe4H8Pe', 'Иван', 'Иванов'),
(4, 'ivan321', '$2y$10$uN/Mf5vWpFFbgZTvDSInleBELlaFDOGmFlwChBdUg8T/d5ac6R1Aa', 'Иван', 'Петров'),
(5, 'ser12', '$2y$10$jMIlgVCQW537QoKln3.UauWBsP9oEhYcd2PhDDbL8ZCs13Q5XX85y', 'Сергей', 'Иванов');

-- --------------------------------------------------------

--
-- Структура таблицы `book`
--

CREATE TABLE `book` (
  `ID_book` int(11) NOT NULL,
  `ID_user` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `author` varchar(50) NOT NULL,
  `publisher` varchar(50) NOT NULL,
  `series` varchar(50) NOT NULL,
  `year_publication` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `book`
--

INSERT INTO `book` (`ID_book`, `ID_user`, `title`, `author`, `publisher`, `series`, `year_publication`) VALUES
(1, 1, 'Чемодан', 'Сергей Довлатов', 'АСТ', 'Эксклюзивная классика', 2022),
(2, 1, 'Евгений Онегин', 'Александр Пушкин', 'АСТ', 'Эксклюзивная классика', 2020),
(3, 2, 'Герой нашего времени', 'Михаил Лермонтов', 'АСТ', 'Эксклюзивная классика', 2021),
(6, 2, 'Театр', 'Сомерсет Моэм', 'АСТ', 'Эксклюзивная классика', 2023);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `authorization`
--
ALTER TABLE `authorization`
  ADD PRIMARY KEY (`ID_user`);

--
-- Индексы таблицы `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`ID_book`),
  ADD KEY `ID_user` (`ID_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `authorization`
--
ALTER TABLE `authorization`
  MODIFY `ID_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `book`
--
ALTER TABLE `book`
  MODIFY `ID_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `authorization` (`ID_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
