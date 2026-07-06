<?php
session_start();
require('db1.php');

if (isset($_POST['email'])) {
    $username = stripslashes($_REQUEST['email']);
    $username = mysqli_real_escape_string($con, $username);
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con, $password);


    $query_users = "SELECT * FROM `users` WHERE email='$username' AND password='".($password)."'";
    $result_users = mysqli_query($con, $query_users) or die(mysqli_error($con));
    $rows_users = mysqli_num_rows($result_users);


    $query_coaches = "SELECT * FROM `coaches` WHERE email='$username' AND password='".($password)."'";
    $result_coaches = mysqli_query($con, $query_coaches) or die(mysqli_error($con));
    $rows_coaches = mysqli_num_rows($result_coaches);

    if ($username == 'admin@com' && $rows_users == 1) {
        $_SESSION['email'] = $username;
        $_SESSION['user_type'] = 'admin';
        header("Location: admin.php");
        exit();
    } elseif ($rows_users == 1) {
        $_SESSION['email'] = $username;
        $_SESSION['user_type'] = 'user';
        header("Location: tyt.php");
        exit();
    } elseif ($rows_coaches == 1) {
        $_SESSION['email'] = $username;
        $_SESSION['user_type'] = 'coach';
        header("Location: coach_dashboard.php");
        exit();
    } else {

        $_SESSION['error_message'] = "Неправильный логин или пароль";

        header("Location: login1.php");
        exit();
    }
} else {

    if(isset($_SESSION['error_message'])) {
        $error_message = $_SESSION['error_message'];
        unset($_SESSION['error_message']);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="stylereg.css"/>
</head>
<body>
    <?php if(isset($error_message)): ?>
        <div class='form'>
            <h3><?php echo $error_message; ?></h3><br/>
            <p class='link'>Попробуйте <a href='login1.php'>войти</a> снова.</p>
        </div>
    <?php endif; ?>
    <form class="form" method="post" name="login">
        <h1 class="login-title">Логин</h1>
        <input type="text" class="login-input" name="email" placeholder="Email" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Password"/>
        <input type="submit" value="Войти" name="submit" class="login-button"/>
        <p class='link'>Нет аккаунта? <a href='registration1.php'>Зарегистрироваться!</a></p>
    </form>

</body>
</html>



