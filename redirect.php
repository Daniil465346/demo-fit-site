<?php
// redirect.php
session_start();
require('db1.php');


if (isset($_SESSION['email'])) {
    $username = $_SESSION['email'];


    $query_users = "SELECT * FROM `users` WHERE email='$username'";
    $result_users = mysqli_query($con, $query_users) or die(mysqli_error($con));
    $rows_users = mysqli_num_rows($result_users);


    $query_coaches = "SELECT * FROM `coaches` WHERE email='$username'";
    $result_coaches = mysqli_query($con, $query_coaches) or die(mysqli_error($con));
    $rows_coaches = mysqli_num_rows($result_coaches);


    if ($username == 'admin@com' && $rows_users == 1) {
        $_SESSION['user_type'] = 'admin';
        header("Location: admin.php");
    } elseif ($rows_users == 1) {
        $_SESSION['user_type'] = 'user';
        header("Location: tyt.php");
    } elseif ($rows_coaches == 1) {
        $_SESSION['user_type'] = 'coach';
        header("Location: coach_dashboard.php");
    } else {
 
        session_destroy();
        header("Location: login1.php");
    }
    exit();
} else {
   
    header("Location: login1.php");
    exit();
}
?>
