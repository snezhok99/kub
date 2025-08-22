<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookLib | Ваша библиотека</title>
    <link rel="stylesheet" href="MainPage/style3.css">
</head>

<body>

<?php
require_once __DIR__ . '/boot.php';

// Получение книг пользователя из базы данных
$userId = $_SESSION['user_id'];
$stmt = pdo()->prepare("SELECT * FROM `book` WHERE `ID_user` = :user_id");
$stmt->execute(['user_id' => $userId]);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

    <header class="header">

        <h1 class="heading" style="color: #ffffff;">BookLib</h1>
       
        <form method="post" action="do_logout.php" class="logout-form">
            <button type="submit" class="btn btn-primary">Выйти</button>
        </form>

    </header>

    <hr>

    <div class="container">

        <h3>Книги из вашей библиотеки</h3>  

        <hr>  

        <div class="book-list2">
            <h3>Список ваших книг:</h3>
            
            <?php 

            if ($books) {
                foreach ($books as $book) {
                    echo '<div class="book-item">';
                    echo '<p>';
                    echo '<b>' . $book['title'] . '</b> ';
                    echo $book['author'] . ' | ';
                    echo '<a href="book_info.php?id=' . $book['ID_book'] . '">Подробнее...</a>';
                    echo '</p>';
                    echo '</div>';
                }
            } else {
                echo '<h3 class="no-books">Добавьте книги в библиотеку, чтобы увидеть список</h3>';
            }
            ?>

        
        </div>

        <hr>

        <h3>Заполните поля, чтобы добавить новую книгу в библиотеку</h3>

        <form action="add_book.php" method="post">

            Название книги: <input type="text" name="title"/><br><br>
            Автор книги: <input type="text" name="author"/><br><br>
            Год публикации: <input type="text" name="year_publication"/><br><br>
            Издательство: <input type="text" name="publisher"/><br><br>
            Серия: <input type="text" name="series"/><br><br>

            <input type="submit" class="search-button" value="Добавить книгу"/>

        </form>

    </div>
</body>
</html>