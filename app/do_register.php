<?php

session_start();

require_once __DIR__.'/boot.php';


$stmt = pdo()->prepare("INSERT INTO `authorization` (ID_user, `login`, `password_hash`, `name`, `surname`) VALUES (Null, :login, :password, :name, :surname)");
$stmt->execute([
    
    'name' => $_POST['name'],
    'surname' => $_POST['surname'],
    'login' => $_POST['login'],
    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),

]);

header('Location: index.php');