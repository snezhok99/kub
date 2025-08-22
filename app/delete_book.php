<?php   

session_start();

require_once __DIR__.'/boot.php';

// Проверяем, был ли передан идентификатор книги
if (isset($_POST['id'])) {
    // Получаем идентификатор книги из POST запроса
    $bookId = $_POST['id'];

    try {
        // Удаляем запись о книге из таблицы Book
        $stmt_book = pdo()->prepare("DELETE FROM `book` WHERE `ID_book` = :bookId");
        $stmt_book->bindParam(':bookId', $bookId);
        $stmt_book->execute();

        // Перенаправляем на главную страницу после успешного удаления
        header('Location: main1.php');
        exit; // Завершаем скрипт после перенаправления
    } catch (PDOException $e) {
        // Если произошла ошибка при удалении, выводим сообщение об ошибке
        echo "Ошибка при удалении книги: " . $e->getMessage();
    }
} else {
    // Если идентификатор книги не был передан, выводим сообщение об ошибке
    echo "Идентификатор книги не был передан";
}