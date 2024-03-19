<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Авторизация</title>
</head>
<body>
<?php
session_start();

$host='localhost';
$database='avto_procat';
$user='root';
$password='';

$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка: " . mysqli_error($link));

if(isset($_POST['email']) && isset($_POST['parol'])) {
    $email = $_POST['email'];
    $parol = $_POST['parol'];

    $query = "SELECT * FROM klienti WHERE Email='$email' AND Parol='$parol'";
    $result = mysqli_query($link, $query);

    if(mysqli_num_rows($result) == 1) {
        $_SESSION['email'] = $email;
        echo "success"; // Отправляем "success" при успешной аутентификации
        exit();
    } else {
        echo "error"; // Отправляем "error" если пользователь не найден
        exit();
    }
}
?>

<div class="container">
    <h1>Авторизация</h1>
    <form id="loginForm" class="wrapper">
        <input type="text" name="email" placeholder="логин (Ваша почта)" class="input" style="margin-top:20px">
        <input type="password" name="parol" placeholder="пароль" class="input" style="margin-top:10px">
        <div>
            <button type="submit" id="loginBtn" class="btn" style="margin-top:15px">войти</button>
        </div>
    </form>
    <button class="btn" style="margin-top:15px"><a href="reg.php">регистрация</a></button>
</div>

<script>
    document.getElementById('loginBtn').addEventListener('click', function(event) {
        event.preventDefault();
        var formData = new FormData(document.getElementById('loginForm'));

        var emailInput = document.querySelector('input[name="email"]');
        var email = emailInput.value;

        var passwordInput = document.querySelector('input[name="parol"]');
        var password = passwordInput.value;

        if (email.trim() === '' || password.trim() === '') {
            alert('Не введены поля. Пожалуйста, заполните оба поля.');
            return false;
        }

        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        if (!emailPattern.test(email)) {
            alert('Пожалуйста, введите корректный адрес электронной почты.');
            return false;
        }

        fetch('check_login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(result => {
            if (result === 'success') {
                window.location.href = 'sait.php'; // Перенаправляем на dashboard.php при успешной аутентификации
            } else if (result === 'error') {
                alert('Неправильный логин или пароль. Пожалуйста, попробуйте снова.');
            }
        });
    });
</script>

</body>
</html>