<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login1.php");
    exit();
}

$email = $_SESSION['email'];

$db = new mysqli('localhost', 'f0951856_qqq1', 'Cz111111', 'f0951856_qqq1');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


$query = "SELECT * FROM class_schedule WHERE available = 1";
$result = $db->query($query);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $class_id = $_POST['class_id'];
    $user_email = $_SESSION['email']; 


    $classQuery = $db->prepare("SELECT class_name FROM class_schedule WHERE class_id = ?");
    $classQuery->bind_param("i", $class_id);
    $classQuery->execute();
    $classResult = $classQuery->get_result();
    $classRow = $classResult->fetch_assoc();
    $namesport = $classRow['class_name']; 


    $userCheck = $db->prepare("SELECT * FROM users WHERE email = ?");
    $userCheck->bind_param("s", $user_email);
    $userCheck->execute();
    $userResult = $userCheck->get_result();

    if ($userResult->num_rows == 0) {
        echo "Пользователь не найден.";
    } else {
 
        $checkLimit = $db->prepare("SELECT COUNT(*) as count FROM sports WHERE namesport = ?");
        $checkLimit->bind_param("s", $namesport);
        $checkLimit->execute();
        $limitResult = $checkLimit->get_result();
        $limitRow = $limitResult->fetch_assoc();


        $checkDuplicate = $db->prepare("SELECT * FROM sports WHERE email = ? AND class_schedule_id = ?");
        $checkDuplicate->bind_param("si", $user_email, $class_id);
        $checkDuplicate->execute();
        $duplicateResult = $checkDuplicate->get_result();

        if ($duplicateResult->num_rows > 0) {
            echo "Вы уже записаны на это занятие.";
        } elseif ($limitRow['count'] < 10) {

            $insertStmt = $db->prepare("INSERT INTO sports (email, namesport, class_schedule_id) VALUES (?, ?, ?)");
            $insertStmt->bind_param("ssi", $user_email, $namesport, $class_id);
            if ($insertStmt->execute()) {
                echo "Вы успешно записаны на занятие!";
            } else {
                echo "Ошибка: " . $insertStmt->error;
            }
            $insertStmt->close();
        } else {

            echo "Извините, на это занятие уже записано максимальное количество пользователей.";
        }
    }
    $userCheck->close();
}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Запись на занятия</title>









    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Фитнес-клуб CGR главная</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
    <style>
      body {
        background-image: url("background_2 1920-1080.png");
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
      }
      h1 {
        color: rgb(183, 183, 183);
      }

      .kruzhochek {
        width: 60%;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        padding: 0.5em;
        margin-bottom: 2em;
      }
      .transparent50 {
        filter: alpha(Opacity=50);
        opacity: 0.5;
      }
      .transparent90 {
        filter: alpha(Opacity=90);
        opacity: 0.9;
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
      </div>
    </nav>












    <div class="container">
        <h1 class="text-center mb-4">Запись на занятия</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="form-group">
                <label for="class_id">Выберите занятие:</label>
                <select id="class_id" name="class_id" class="form-control">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <option value="<?php echo $row['class_id']; ?>">
                            <?php echo $row['class_name'] . " - " . $row['day_of_week'] . " - " . $row['time_slot'] . " - " . $row['end_time']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Записаться</button>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>



