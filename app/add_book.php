<?php

session_start();

require_once __DIR__.'/boot.php';
    
$user = null;

if (check_auth()) {
    // Получим данные пользователя по сохранённому идентификатору
    $stmt = pdo()->prepare("INSERT INTO book (ID_book, ID_user, title, author, publisher, series, year_publication) VALUES (Null, :id, :title,:author, :publisher, :series, :year_publication)");
    $stmt->execute([
        'id' => $_SESSION['user_id'],
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'publisher' => $_POST['publisher'],
        'series' => $_POST['series'],
        'year_publication' => $_POST['year_publication'],

    ]);
   
}

header('Location: main1.php');