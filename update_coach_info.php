<?php

session_start();

if(isset($_SESSION['email'])) {
    $email = $_SESSION['email'];


    $con = mysqli_connect("localhost", "f0951856_qqq1", "Cz111111", "f0951856_qqq1");
    if (!$con) {
        die("Ошибка подключения: " . mysqli_connect_error());
    }

    $message = ''; 

   
    if(isset($_POST['delete_photo'])) {

        $stmt = $con->prepare("SELECT photo FROM `coaches` WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $photo = $row['photo'];
            if($photo && file_exists('uploads/' . $photo)) {
                unlink('uploads/' . $photo); 
            }
        }

 
        $stmt = $con->prepare("UPDATE `coaches` SET `photo`=NULL WHERE `email`=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $message = ($stmt->affected_rows > 0) ? "Фотография успешно удалена." : "Ошибка при удалении фотографии.";
        $stmt->close();
    }


    $bio = isset($_POST['bio']) ? $_POST['bio'] : "";

 
    if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo = uniqid() . "-" . basename($_FILES['photo']['name']);
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . $photo;

    
        if(move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            
            $stmt = $con->prepare("UPDATE `coaches` SET `bio`=?, `photo`=? WHERE `email`=?");
            $stmt->bind_param("sss", $bio, $photo, $email);
            $stmt->execute();

            $message = ($stmt->affected_rows > 0) ? "Информация о тренере успешно обновлена." : "Ошибка при обновлении информации о тренере.";
            $stmt->close();
        } else {
            $message = "Ошибка при загрузке файла.";
        }
    } elseif(!empty($bio)) {
  
        $stmt = $con->prepare("UPDATE `coaches` SET `bio`=? WHERE `email`=?");
        $stmt->bind_param("ss", $bio, $email);
        $stmt->execute();

        $message = ($stmt->affected_rows > 0) ? "Информация о тренере успешно обновлена." : "Описание обновлено, фотография не изменена.";
        $stmt->close();
    } else {
        $message = "Нет данных для обновления.";
    }

    $con->close();
} else {
    $message = "Сессия не начата или email не установлен.";
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Обновление информации о тренере</title>
    <style>

    .modal {
        display: block; /* Показать модальное окно */
        position: fixed; /* Остается на месте при прокрутке */
        z-index: 1; /* Сидит на вершине */
        left: 0;
        top: 0;
        width: 100%; /* Полная ширина */
        height: 100%; /* Полная высота */
        overflow: auto; /* Включить прокрутку, если нужно */
        background-color: rgb(0,0,0); /* Цвет фона */
        background-color: rgba(7,888,0,0.2); /* Цвет фона с прозрачностью */
    }

    /* Стиль контента модального окна */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* 15% от верхнего края и по центру */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Ширина может быть изменена */
    }


    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }


    @keyframes modalopen {
        from {opacity: 0}
        to {opacity: 1}
    }

    .modal {
        animation-name: modalopen;
        animation-duration: 1s;
    }
    </style>
</head>
<body>


<div id="myModal" class="modal">

    <div class="modal-content">
        <span class="close">×</span>
        <p><?php echo $message; ?></p>
    </div>
</div>

<script>

var modal = document.getElementById("myModal");


var span = document.getElementsByClassName("close")[0];


span.onclick = function() {
    modal.style.display = "none";
    window.history.back();
}


window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        window.history.back();
    }
}


modal.style.display = "block";
</script>

</body>
</html>