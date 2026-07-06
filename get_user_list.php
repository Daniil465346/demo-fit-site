<?php

$con = mysqli_connect("localhost", "f0951856_qqq1", "Cz111111", "f0951856_qqq1");
if (!$con) {
    die("Ошибка подключения: " . mysqli_connect_error());
}


$class_id = $_GET['class_id'];


$query = "SELECT u.email, u.first_name, u.last_name, u.profile_image FROM users u INNER JOIN sports s ON u.email = s.email WHERE s.class_schedule_id = ?";

$stmt = $con->prepare($query);
if (!$stmt) {
    die("Ошибка подготовки запроса: " . mysqli_error($con));
}
$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();


if (mysqli_num_rows($result) > 0) {
    echo "<ul>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li class='user-list-item'>";
        echo "<img src='uploads/" . $row["profile_image"] . "' alt='Profile Image'>";
        echo "<p>" . $row["email"] . " - " . $row["first_name"] . " " . $row["last_name"] . "</p>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "Нет записавшихся пользователей.";
}

$stmt->close();
$con->close();
?>