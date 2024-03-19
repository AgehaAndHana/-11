<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
<body>
    <div>
		
    <?php
			$host='localhost';
			$database='avto_procat';
			$user='root';
			$password='';
			
			$link=mysqli_connect($host,$user,$password,$database) or die ("Ошибка".mysqli_error($link));
			if(isset($_POST['familiya']) && isset($_POST['imya']) && isset($_POST['otchestvo']) && isset($_POST['adres']) && isset($_POST['email']) && isset($_POST['parol'])) {
				$familiya = $_POST['familiya'];
                $imya = $_POST['imya'];
                $otchestvo = $_POST['otchestvo'];
                $adres = $_POST['adres'];
				$email = $_POST['email'];
                $parol = $_POST['parol'];
				
				if($familiya && $imya && $otchestvo && $adres && $email && $parol) {
					$query = "INSERT INTO klienti(Famaliya,Imya,Otchestvo,Adres,Email,Parol) values ('$familiya','$imya','$otchestvo','$adres', '$email', '$parol')";
					$result = mysqli_query($link, $query) or die ("Ошибка".mysqli_error($link));
                    if($result) {
                        header("Location: index.php"); // Перенаправление на index.php после успешного добавления данных
                    }
				}
			}
		?>
    </div>

    <div class="container__reg">
        <h1>Регистрация</h1>
        <form id="loginForm" class="wrapper">
            <input type="text" name="familiya" placeholder="Фамилия" class="input" style="margin-top:20px">
            <input type="text" name="imya" placeholder="Имя" class="input" style="margin-top:20px">
            <input type="text" name="otchestvo" placeholder="Отчество" class="input" style="margin-top:20px">
            <input type="text" name="adres" placeholder="Адрес" class="input" style="margin-top:20px">
            <input type="text" name="email" placeholder="email" class="input" style="margin-top:20px">
            <input type="text" name="parol" placeholder="Пароль" class="input" style="margin-top:10px">
            <button class="btn" id="loginBtn" style="margin-top:15px">Зарегистрироваться</button>
        </form>
        <button class="btn" style="margin-top:15px"><a href="index.php">EXIT</a></button>
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
                alert('Неправильный заплнены поля. Пожалуйста, попробуйте снова.');
            }
        });
    });
    </script>
</body>
</html>