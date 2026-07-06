<?php
session_start();


if (!isset($_SESSION['email'])) {
    header('Location: login1.php');
    exit;
}
?>
<?php
session_start(); 

if(isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

$con = mysqli_connect("localhost", "f0951856_qqq1", "Cz111111", "f0951856_qqq1");
if (!$con) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

$con->close();
} else {
    echo "Сессия не начата или email не установлен.";
}

?>


<?php
session_start();

if(isset($_SESSION['email'])) {
    $email = $_SESSION['email'];


    $con = mysqli_connect("localhost", "f0951856_qqq1", "Cz111111", "f0951856_qqq1");
    if (!$con) {
        die("Ошибка подключения: " . mysqli_connect_error());
    }


    $stmt = $con->prepare("SELECT bio, photo FROM `coaches` WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $bio = '';
    $photo = '';
    if ($row = $result->fetch_assoc()) {
        $bio = $row['bio'];
        $photo = $row['photo'];
    }

    $con->close();
} else {
    echo "Сессия не начата или email не установлен.";
}
?>






<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель Тренера</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background-image: url('https://i.pinimg.com/originals/d6/d6/59/d6d6599a8ac75805e60409ae582a57e3.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .navbar {
            margin-bottom: 20px;
        }
        .dashboard-container {
            margin: auto;
            max-width: 1100px;
            padding: 15px;
        }
        .dashboard-card {
            background-color: #ffffff;
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }
        .dashboard-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #000000;
            text-shadow: 2px 2px 4px rgba(5, 0, 0, 0.01);
        }



        .modal-content {
            width: 50%; /* Ширина модального окна составляет 50% от ширины экрана */
            margin: 10% auto; /* Отступ сверху и автоматический отступ по бокам для центрирования */
            padding: 20px; /* Внутренний отступ вокруг содержимого модального окна */
            background-color: #fff; /* Фоновый цвет модального окна */
            border-radius: 5px; /* Скругление углов модального окна */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Тень для модального окна */
        }

        .modal {
            display: none; /* Изначально модальное окно не отображается */
            position: fixed; /* Фиксированное позиционирование относительно окна браузера */
            z-index: 10; /* Уровень наложения поверх других элементов */
            left: 0;
            top: 0;
            width: 100%; /* Ширина фона модального окна равна ширине экрана */
            height: 100%; /* Высота фона модального окна равна высоте экрана */
            overflow: auto; /* При необходимости добавляется прокрутка */
            background-color: rgba(0, 0, 0, 0.4); /* Полупрозрачный фон вокруг модального окна */
        }
        ul {
            padding-left: 0; /* Убираем стандартный отступ слева у списка */
            list-style-type: none; /* Убираем маркеры списка */
            text-align: left; /* Выравнивание текста по левому краю */
        }

        .user-list-item {
            display: flex; /* Элементы списка будут в одной строке */
            align-items: center; /* Выравнивание элементов по центру по вертикали */
            margin-bottom: 10px; /* Отступ снизу для каждого элемента списка */
            justify-content: flex-start; /* Выравнивание элементов списка по левому краю */
        }

        .user-list-item img {
            width: 110px; /* Ширина изображения */
            height: 100px; /* Высота изображения */
            border-radius: 40%; /* Скругление углов для создания круглой формы */
            margin-right: 10px; /* Отступ справа от изображения */
        }

        .user-list-item p {
            margin: 0; /* Убираем стандартные отступы у абзацев */
            padding: 0; /* Убираем внутренние отступы у абзацев */
        }
        /* Стили для улучшения внешнего вида текста */
        .user-list-item p {
            font-size: 18px; /* Увеличение размера шрифта */
            font-family: 'Arial', sans-serif; /* Изменение шрифта на Arial */
            color: #333; /* Цвет текста темно-серый для лучшей читаемости */
        }







        .coach-info p {
            font-size: 16px;
            color: #333;
            margin-bottom: 15px;
        }

        .coach-photo {
            text-align: center; /* Центрирование изображения */
        }

        .coach-photo img {
            width: 250px; /* Фиксированная ширина изображения */
            height: auto; /* Автоматическая высота для сохранения пропорций */
            border-radius: 20%; /* Круглое изображение */
            margin-bottom: 15px; /* Отступ снизу */
        }

        #openSecondModalBtn {
    background-color: #4CAF50; /* Зеленый фон */
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 8px; /* Скругленные углы */
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); /* Тень */
    transition-duration: 0.4s; /* Время эффекта перехода */
    }

    #openSecondModalBtn:hover {
        background-color: #45a049; /* Темно-зеленый фон при наведении */
        box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19); /* Изменение тени при наведении */
    }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark transparent90">
        <div class="container">
            <a class="navbar-brand p-0" >
            <img src="logo2.png" alt="html/Logo2" width="100" />
            </a>
            <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
            >
            <span class="navbar-toggler-icon"></span>
            </button>


        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.html">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="news.php">Новости</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="aboutedit.html">Информация о нас</a>
                </li>

            </ul>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="logout1.php">Выход из учетной записи</a>
                </li>
                <li class="nav-item border-start border-secondary-light">
                    <a class="nav-link" href="coach_dashboard.php">Профиль</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-success my-2 my-sm-0" href="registration1.php">Зарегистрироваться</a>
                </li>
            </ul>
        </div>
    </nav>

 




    <div class="dashboard-container">
        <div class="dashboard-header">Добро пожаловать, Тренер!</div>
        <div class="row">

            <div class="col-md-4">
                <div class="dashboard-card">
                    <div class="coach-info">
                        <h5>О тренере</h5>
                        <?php if($bio): ?>
                            <p><?php echo $bio; ?></p>
                        <?php endif; ?>
                        <?php if($photo): ?>
                            <div class="coach-photo">
                                <img src="uploads/<?php echo $photo; ?>" alt="Фото тренера">
                            </div>
                        <?php endif; ?>
                        <button id="openSecondModalBtn">Редактировать</button>
                    </div>
                </div>
            </div>



<div id="mySecondModal" class="modal">
    <div class="modal-content">
        <span class="closeSecond">×</span>
        <h2>Добавить информацию о тренере</h2>
        <form action="update_coach_info.php" method="post" enctype="multipart/form-data">
            <label for="bio">Описание:</label>
            <textarea id="bio" name="bio" required></textarea><br><br>
            
            <label for="photo">Фотография:</label>
            <input type="file" id="photo" name="photo" accept="image/*"><br><br>
            
            <input type="submit" value="Сохранить">
        </form>

        <form action="update_coach_info.php" method="post">
            <input type="hidden" name="delete_photo" value="1">
            <input type="submit" value="Удалить фото">
        </form>
    </div>
</div>



<script>

var secondModal = document.getElementById("mySecondModal");
var secondBtn = document.getElementById("openSecondModalBtn");
var secondSpan = document.getElementsByClassName("closeSecond")[0];

secondBtn.onclick = function() {
    secondModal.style.display = "block";
}

secondSpan.onclick = function() {
    secondModal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == secondModal) {
        secondModal.style.display = "none";
    }
}
</script>



            <div class="col-md-4">
                <div class="dashboard-card">
                    <h5>Профиль</h5>
                    <?php
                session_start(); 


                if(isset($_SESSION['email'])) {
                    $email = $_SESSION['email'];


                    $con = mysqli_connect("localhost", "f0951856_qqq1", "Cz111111", "f0951856_qqq1");
                    if (!$con) {
                        die("Ошибка подключения: " . mysqli_connect_error());
                    }


                    $stmt = $con->prepare("SELECT name, specialization FROM `coaches` WHERE email=?");
                    $stmt->bind_param("s", $email); 
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($row = $result->fetch_assoc()) {

                        $name = $row['name'];
                        $specialization = $row['specialization'];

                        echo "<div class='profile-tab'>
                                
                                <p><strong>Email:</strong> $email</p>
                                <p><strong>Имя:</strong> $name</p>
                                <p><strong>Специализация:</strong> $specialization</p>
                            </div>";
                    } else {
                        echo "<div class='profile-tab'>Профиль не найден.</div>";
                    }

                    $stmt->close();
                    $con->close();
                } else {
                    echo "Сессия не начата или email не установлен.";
                }
                ?>

                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-card">
                    <h5>Расписание</h5>

            <?php

            $con = mysqli_connect("localhost", "f0951856_qqq1", "Cz111111", "f0951856_qqq1");
            if (!$con) {
                die("Ошибка подключения: " . mysqli_connect_error());
            }


            $coachEmail = $_SESSION['email'];


            $query = "SELECT cs.class_id, cs.class_name, cs.day_of_week, cs.time_slot, cs.end_time, 
                    (SELECT COUNT(*) FROM sports WHERE class_schedule_id = cs.class_id) AS user_count
                    FROM class_schedule cs
                    WHERE cs.trainer_email = ? AND cs.available = 1";


            $stmt = $con->prepare($query);
            $stmt->bind_param("s", $coachEmail);
            $stmt->execute();
            $result = $stmt->get_result();


            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "id: " . $row["class_id"]. " - Занятие: " . $row["class_name"]. " - Дата: " . $row["day_of_week"]. " - Время начала: " . $row["time_slot"]. " - Время окончания: " . $row["end_time"]. " - Записалось пользователей: <a href='javascript:void(0);' onclick='showUserList(" . $row["class_id"] . ");'>" . $row["user_count"] . "</a><br>";
                }
            } else {
                echo "Нет доступных занятий.";
            }
            


            $stmt->close();
            $con->close();
            ?>



            <div id="userListModal" class="modal">
            <div class="modal-content">
                <span class="close">×</span>
                <h2>Список записавшихся пользователей</h2>
                <div id="userList"></div>
            </div>
            </div>

            <script>
   
            var modal = document.getElementById('userListModal');

           
            var span = document.getElementsByClassName("close")[0];

  
            span.onclick = function() {
            modal.style.display = "none";
            }

     
            function showUserList(classId) {
           
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_user_list.php?class_id=' + classId, true);
            xhr.onload = function() {
                if (this.status == 200) {
                document.getElementById('userList').innerHTML = this.responseText;
                modal.style.display = "block";
                }
            }
            xhr.send();
            }


            window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
            }
            </script>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.7.11/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>
</html>

