<?php

$servername = "localhost";
$username = "f0951856_qqq1";
$password = "Cz111111";
$dbname = "f0951856_qqq1";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['news_id'])) {

        $news_id = $conn->real_escape_string($_POST['news_id']);


        $sql = "DELETE FROM news WHERE news_id = $news_id";


        if ($conn->query($sql) === TRUE) {
            echo "Новость успешно удалена.";
        } else {
            echo "Ошибка при удалении новости: " . $conn->error;
        }
    } else {
        echo "ID новости не указано.";
    }
} else {
    echo "Недопустимый метод запроса.";
}


$conn->close();
?>
