<?php

session_start();

require_once __DIR__.'/boot.php';

try {
                                 
	$stmt = pdo()->prepare("SELECT * FROM `authorization` WHERE `login` = :login");
	$stmt->execute(['login' => $_POST['login']]);
	if (!$stmt->rowCount()) {
    		header('Location: index.php');
    		die;
	}

	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if (password_verify($_POST['password'], $user['password_hash'])) {
    		$_SESSION['user_id'] = $user['ID_user'];
    		header('Location: main1.php');
    		die;
	}  


	if (!password_verify($_POST['password'], $user['password_hash'])) {
    		throw new Exception('Неверный пароль.');
    }

}

catch (Exception $e) {
    // Логирование ошибки (можно писать в файл или показывать пользователю в dev-режиме)
    error_log($e->getMessage());

    // Показываем сообщение об ошибке
    echo '<p>Ошибка: ' . $e->getMessage() . '</p>';

    // Можно сделать перенаправление обратно на страницу логина с сообщением об ошибке
    header('Location: index.php?error=' . urlencode($e->getMessage()));
    exit;
}