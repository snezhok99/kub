<?php 
$host = 'db'; // Имя хоста 
$dbname = 'db2'; // Имя базы данных 
$username = 'root'; // Имя пользователя базы данных 
$password = 'secret'; // Пароль для доступа к базе данных 
 
try { 
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
     
    echo "Соединение с базой данных установлено"; 
} catch (PDOException $e) { 
    echo "Ожидаю подключения к базе данных..."; 
} 