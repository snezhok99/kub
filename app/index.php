<?php session_start(); ?>

<!DOCTYPE html >
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookLib | Вход</title>
    <link rel="stylesheet" href="LogingPage/style1.css">
</head>

<body>

    <header>
        
        <h1 class="heading" style="color: #ffffff;">BookLib</h1>

    </header>


    <div class="wrapper">

        <form method="post" action="do_login.php">
            <h2>Вход</h2>
            <div class="input-box">
                <input type="login" class="form-control" id="login" name="login" placeholder="Логин"
                required>
            </div>
            <div class="input-box">
                <input type="password" class="form-control" id="password" name="password" placeholder="Пароль"
                required>
            </div>

            <button type = "submit" class = "btn">Войти</button>

            <div class="register-link">
                <p>Еще нет аккаунта? <a
                href="signing.php">Зарегистрируйтесь!</a></p>
            </div>

        </form>
    </div>

</body>

</html>