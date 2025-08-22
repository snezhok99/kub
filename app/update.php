<?php
session_start();
require_once __DIR__.'/boot.php';

// Проверка аутентификации пользователя
if (check_auth()) {
    // Проверка на наличие ID книги и данных из формы
  
      // Проверка на наличие данных из формы
    if (!empty($_POST)) {
        $book_id = $_POST['id']; // Получение ID книги из POST

        // Подготовка запроса для обновления данных о книге
        $stmt = pdo()->prepare("UPDATE book SET title = :title, author = :author, publisher = :publisher, series = :series, year_publication = :year_publication WHERE ID_book = :id");
        
        // Выполнение запроса с данными из формы
        $stmt->execute([
            'id' => $book_id,
            'title' => $_POST['title'],
            'author' => $_POST['author'],
            'publisher' => $_POST['publisher'],
            'series' => $_POST['series'],
            'year_publication' => $_POST['year_publication'],
        ]);
        
        // Перенаправление на страницу с информацией о книге после успешного обновления
        header('Location: book_info.php?id=' . $book_id);
        exit; // Завершение скрипта после перенаправления
    }

}    