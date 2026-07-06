<?php
$servername = "localhost";
$username = "f0951856_qqq1"; 
$password = "Cz111111"; 
$dbname = "f0951856_qqq1"; 

try {

    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class_id'])) {
        $lesson_id = $_POST['class_id'];

 
        $delete_users_sql = "DELETE FROM sports WHERE class_schedule_id = ?";
        $delete_users_stmt = $conn->prepare($delete_users_sql);
        $delete_users_stmt->bind_param("i", $lesson_id);
        $delete_users_stmt->execute();
        $delete_users_stmt->close();


        $delete_lesson_sql = "DELETE FROM class_schedule WHERE class_id = ?";
        $delete_lesson_stmt = $conn->prepare($delete_lesson_sql);
        $delete_lesson_stmt->bind_param("i", $lesson_id);

        if ($delete_lesson_stmt->execute()) {
            echo "Занятие успешно удалено.";
            header("Location: admin.php");
            exit();
        } else {
            echo "Произошла ошибка при удалении занятия. Пожалуйста, попробуйте снова.";
        }
        $delete_lesson_stmt->close();
    }
} catch (Exception $e) {
    echo "Произошла ошибка: " . $e->getMessage();
}

$conn->close();
?>