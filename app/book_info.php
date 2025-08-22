<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookLib</title>
    <link rel="stylesheet" href="MainPage/style4.css">
</head>
<body>
    <h1>BookLib</h1>
    <hr>
    <div class="container">

        <?php
        //session_start();

        require_once __DIR__.'/boot.php';

        // Проверка на наличие ID книги в URL
        if (isset($_GET['id'])) {
            $book_id = $_GET['id'];

            // Подготовка запроса для получения данных о книге
            $stmt = pdo()->prepare("SELECT * FROM book WHERE ID_book = :id");
            $stmt->execute(['id' => $book_id]);
            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            // Проверка, была ли найдена книга
            if (!$book) {
                die('Книга не найдена');
            }
            } else {
                die('Не указан ID книги');
            }
        ?>

        <a href="main1.php" class="back-button">Назад</a>
        <h4>Подробная информация о книге</h4>

        <form action="update.php?id=<?= $book['ID_book'] ?>" method="post">
            <input type="hidden" name="id" value="<?= $book['ID_book'] ?>"/>
            <label for="title">Название книги:</label>
            <input type="text" id="title" name="title" value="<?php $book_title = $book['title']; echo $book_title; ?>"/><br><br>

            <label for="author">Автор книги:</label>
            <input type="text" id="author" name="author" value="<?php $book_author = $book['author']; echo $book_author; ?>"/><br><br>

            <label for="year_publication">Год публикации:</label>
            <input type="text" id="year_publication" name="year_publication" value="<?php $book_year = $book['year_publication']; echo $book_year; ?>"/><br><br>

            <label for="publisher">Издательство:</label>
            <input type="text" id="publisher" name="publisher" value="<?php $book_publisher = $book['publisher']; echo $book_publisher; ?>"/><br><br>

            <label for="series">Серия:</label>
            <input type="text" id="series" name="series" value="<?php $book_series = $book['series']; echo $book_series; ?>"/><br><br>

            <div class="form-actions">
                <input type="submit" class="button save-button" value="Сохранить изменения"/>

            </div>
        </form>

        <form class="delete-form" action="delete_book.php" method="post" style="display: inline;">
            <input type="hidden" name="id" value="<?= $book['ID_book'] ?>"/>
            <input type="submit" class="button delete-button" value="Удалить книгу"/>
                   
        </form>
    </div>
</body>
</html>