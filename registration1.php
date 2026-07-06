<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Регистрация</title>
    <link rel="stylesheet" href="stylereg.css"/>
</head>
<body>
<?php
    require('db1.php');

    if (isset($_REQUEST['email'])) {
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $confirm_password = stripslashes($_REQUEST['confirm_password']);
        $confirm_password = mysqli_real_escape_string($con, $confirm_password);
        $create_datetime = date("Y-m-d H:i:s");


        $query    = "SELECT * FROM `users` WHERE email='$email'";
        $result   = mysqli_query($con, $query);
        $user_exists = mysqli_num_rows($result);

        if ($user_exists) {
            echo "<div class='form'>
                  <h3>Пользователь с таким email уже зарегистрирован.</h3><br/>
                  <p class='link'>Пожалуйста, используйте другой email или <a href='login1.php'>войдите</a> в систему.</p>
                  </div>";
        } else {

            if ($password == $confirm_password) {
                
                $first_name = isset($_REQUEST['first_name']) ? mysqli_real_escape_string($con, $_REQUEST['first_name']) : '';
                $last_name = isset($_REQUEST['last_name']) ? mysqli_real_escape_string($con, $_REQUEST['last_name']) : '';
                $profile_image = isset($_REQUEST['profile_image']) ? mysqli_real_escape_string($con, $_REQUEST['profile_image']) : '';

               
                $query    = "INSERT into `users` (email, password, first_name, last_name, profile_image, create_datetime)
                             VALUES ('$email', '" . ($password) . "', '$first_name', '$last_name', '$profile_image', '$create_datetime')";
                $result   = mysqli_query($con, $query);
                if ($result) {
                    echo "<div class='form'>
                          <h3>Регистрация прошла успешно</h3><br/>
                          <p class='link'>Нажмите чтобы <a href='login1.php'>Войти</a></p>
                          </div>";
                } else {
                    echo "<div class='form'>
                          <h3>Ошибка регистрации.</h3><br/>
                          <p class='link'>Click here to <a href='registration1.php'>registration</a> again.</p>
                          </div>";
                }
            } else {
                echo "<div class='form'>
                      <h3>Пароли не совпадают.</h3><br/>
                      <p class='link'>Пожалуйста, убедитесь, что вы ввели одинаковые пароли в оба поля.</p>
                      <p class='link'>Нажмите чтобы <a href='registration1.php'>зарегистрироваться</a> снова.</p>
                      </div>";
            }
        }
    } else {
?>

    <form class="form" action="" method="post">
        <h1 class="login-title">Регистрация</h1>
        <input type="text" class="login-input" name="email" placeholder="Email" required />
        <input type="password" class="login-input" name="password" placeholder="Пароль" required />
        <input type="password" class="login-input" name="confirm_password" placeholder="Повторите пароль" required />
        <!-- Необязательные поля -->
        <input type="text" class="login-input" name="first_name" placeholder="Имя" />
        <input type="text" class="login-input" name="last_name" placeholder="Фамилия" />
        <input type="submit" name="submit" value="Зарегистрироваться" class="login-button">
        <p class="link">Уже зарегистрировались ? <a href="login1.php">Войти</a></p>
    </form>
<?php
    }
?>
</body>
</html>


