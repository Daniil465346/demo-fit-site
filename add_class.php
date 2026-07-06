<?php
$servername = "localhost";
$username = "f0951856_qqq1"; 
$password = "Cz111111"; 
$dbname = "f0951856_qqq1"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class_name = $_POST["class_name"];
    $day_of_week = $_POST["day_of_week"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $trainer_email = $_POST["trainer_email"];


    $stmt = $conn->prepare("INSERT INTO class_schedule (class_name, day_of_week, time_slot, end_time, trainer_email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $class_name, $day_of_week, $start_time, $end_time, $trainer_email);


    if ($stmt->execute()) {
        echo "Новое занятие успешно добавлено";
    } else {
        echo "Ошибка: " . $stmt->error;
    }


    $stmt->close();
    $conn->close();
}
?>