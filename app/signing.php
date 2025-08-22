<?php session_start(); ?>
<!DOCTYPE html >
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookLib | Регистрация </title>
    <link rel="stylesheet" href="SigningPage/style2.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
</head>

<body>

    <header class="header">
        
        <h1 class="heading" style="color: #ffffff;">BookLib</h1>

    </header>

    <div class="wrapper">

        <form method="post" action="do_register.php" onsubmit="checkPasswordMatch(event);">
            <h2>Регистрация</h2>

            <div class="input-box">

                <div class="input-field">
                    <p>Введите имя:</p>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Иван"
                    required>
                </div>             

                <div class="input-field">
                    <p>Введите фамилию:</p>
                    <input type="text" class="form-control" id="surname" name="surname" placeholder="Иванов"
                    required>
                </div>

            </div>

            <div class="input-box">

                <div class="input-field">
                    <p>Введите логин:</p>
                    <input type="login" class="form-control" id="login" name="login" placeholder="ivan436"
                    required>
                </div>

                <div class="input-field">
                    <p>Придумайте пароль (не менее 8 символов):</p>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Пароль"
                    required>
                </div>

            </div>

            <button type = "submit" class = "btn">Создать аккаунт</button>

            <div class="loging-link">
                <p>Уже зарегистрированы?<a
                href="index.php"> Войдите!</a></p>
            </div>

        </form>


    </div>

</body>

</html>