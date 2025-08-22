<?php

session_start();

require_once __DIR__.'/boot.php';

if (check_auth()) {
    // Получаем ID пользователя
    $user_id = $_SESSION['user_id'];

    // Получаем значение из поля поиска
    $title = isset($_GET['title']) ? trim($_GET['title']) : '';

    // Инициализация массивов
    $foundBooks = [];
    $allBooks = [];

    // Если введено название для поиска
    if ($title) {
        // Выполняем поиск книг по названию
        $stmt = pdo()->prepare("SELECT * FROM book WHERE ID_user = :user_id AND title LIKE :title");
        $stmt->execute(['user_id' => $user_id, 'title' => '%' . $title . '%']);
        $foundBooks = $stmt->fetchAll(PDO::FETCH_ASSOC); // Найденные книги
    }

    // Получаем все книги пользователя
    $stmt = pdo()->prepare("SELECT * FROM book WHERE ID_user = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $allBooks = $stmt->fetchAll(PDO::FETCH_ASSOC); // Все книги

    // Подключаемся к HTML-шаблону
    include 'main1.php';
}