<?php
session_start();


if (!isset($_SESSION['email'])) {
    header('Location: login1.php');
    exit;
}
?>
<?php

$conn = new mysqli('localhost', 'f0951856_qqq1', 'Cz111111', 'f0951856_qqq1');
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}


$trainers = [];
$result = $conn->query("SELECT email, name, specialization FROM coaches");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $trainers[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
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
        background-image: url('adminbg.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
    }

    header {
      background-color: #333;
      color: #fff;
      padding: 20px 0;
      text-align: center;
      margin-bottom: 20px;
    }
    h1 {
      margin: 0;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    p {
      line-height: 39px;
    }
    .custom-paragraph{
      font-size: 24px;
      font-weight: bold;
      color: #fff;
    }
    ul {
      list-style: none;
      padding: 0;
    }
    .info {
      margin-bottom: 32px;
    }
    .info div {
      margin-bottom: 20px;
      padding-top: 27px;
      
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .info h2 {
      font-size: 1.8em;
      margin-bottom: 0px;
    }
    .info p {
      font-size: 20px;
    }
    .container-secondary{
      background-color: rgba(255, 255, 255, 0.4);
      backdrop-filter: blur(8px);
      padding: 30px;
      border-radius: 16px;
    }
    .signup{
      background: linear-gradient(to right, rgba(255, 92, 111), rgba(255, 154, 76));
      width: 152px;
      height: 237px;
      padding-top: 11px;
      padding-left: 18px;
      float: right;
      border-radius: 16px;
      margin-left: 45px;
      margin-bottom: 32px;
    }
    .services {
      background-color: #ffd700;
      color: #333;
      width: 100%;
      border-radius: 16px;
    }
    .team {
      background-color: white;
      color: #333;
      width: 53%;
      height: 237px;
      border-radius: 16px;
    }
    .stats {
      background-color: #afeeee;
      color: #333;
    }
    .mission {
      background-color: #add8e6;
      color: #333;
    }
    .help {
      background-color: #90ee90;
      color: #333;
    }

    .service-card {
      padding: 20px;
      background-color: #ffffff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 10px; 
    }

    .help-buttons {
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    .help-buttons a {
      display: inline-block;
      padding: 12px 24px;
      border-radius: 5px;
      background-color: #6cb5f5;
      color: #fff;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .help-buttons a:hover {
      background-color: #4a8fdc;
    }

    .container-secondary {
      margin-top: 49px;
    }
    .split-container {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 20px;
    }

    .split-container > div {
      width: calc(50% - 20px);
    }

    .kruzhochek {
      width: 180px;
      height: 180px;
      border-radius: 100%;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      float: left;
      margin-top: 29px;
      margin-left: 25px;
      justify-content: center;
      align-items: center;
    }
    .transparent90 {
        filter: alpha(Opacity=90);
        opacity: 0.9;
    }
    .transparent75 {
      filter: alpha(Opacity=75);
      opacity: 0.75;
    }
    .block {
        margin-right: 100px; 
    }

    @media (max-width: 768px) {
      .split-container > div {
        width: 100%;
        margin-bottom: 20px;
      }
    }
</style>
<head>

    <script>
    var allTrainers = []; 

    function updateTrainers() {
        var selectedClass = document.getElementById('class_name').value;
        var trainersSelect = document.getElementById('trainer_email');
        

        trainersSelect.innerHTML = '';

        // Для "SPA-процедуры" и "Персональная тренировка" тренер не требуется
        if (selectedClass === "SPA-процедуры" || selectedClass === "Персональная тренировка") {
            trainersSelect.style.display = 'none';
        } else {
            trainersSelect.style.display = '';

  
            allTrainers.forEach(function(trainer) {
                if (trainer.specialization === selectedClass) {
                    var option = document.createElement('option');
                    option.value = trainer.email;
                    option.textContent = trainer.name + ' (' + trainer.email + ')';
                    trainersSelect.appendChild(option);
                }
            });
        }
    }

    // Функция для инициализации всех тренеров
    function initTrainers(trainers) {
        allTrainers = trainers;
        updateTrainers(); 
    }

    document.addEventListener('DOMContentLoaded', function() {

        initTrainers(<?php echo json_encode($trainers); ?>);
    });
    </script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark transparent90">
      <div class="container block">
        <a class="navbar-brand p-0" >
          <img src="logo2.png" alt="Logo" width="100" />
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
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

            
                <li class="nav-item border-start border-secondary-light">
                    <a class="nav-link active" href="redirect.php">Профиль</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-success my-2 my-sm-0" href="registration1.php" type="submit">Зарегистрироваться</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout1.php">Выход из учетной записи</a>
                </li>
            </ul>
        </div>
      </div>
    </nav>
    <div class="container">
        <div class="container-secondary">
            <div class="info services transparent75">
            <div class="service-card transparent75">
    <?php
$servername = "localhost";
$username = "f0951856_qqq1"; 
$password = "Cz111111"; 
$dbname = "f0951856_qqq1"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}


$sql = "SELECT class_id, class_name, day_of_week, time_slot, end_time FROM class_schedule";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "class_id: " . $row["class_id"]. " - Название: " . $row["class_name"]. " - День: " . $row["day_of_week"]. " - Время начала: " . $row["time_slot"]. " - Время окончания: " . $row["end_time"]. "<br>";

        echo "<form method='post' action='delete_lesson.php'>";
        echo "<input type='hidden' name='class_id' value='".$row["class_id"]."'>";
        echo "<input type='submit' value='Удалить'>";
        echo "</form><br>";
    }
} else {
    echo "Занятий нет";
}


$conn->close();

?>
</div>
</div>
<div class="info services transparent75">
    <h2 class="color: #fff">Добавить Занятие</h2>
    <div class="service-card transparent75>">
    <form method="post" action="add_class.php">
        Название занятия:
        <select id="class_name" name="class_name" required onchange="updateTrainers()">
            <option value="">Выберите занятие</option>
            <option value="Йога">Йога</option>
            <option value="Танцы">Танцы</option>
            <option value="SPA-процедуры">SPA-процедуры</option>
            <option value="Персональная тренировка">Персональная тренировка</option>
            <option value="Посещение зала">Посещение зала</option>
        </select>
        Дата:
        <input type="date" name="day_of_week" required>
        <br><br>
        Время начала занятия:
        <input type="time" name="start_time" required>
        <br><br>
        Время окончания занятия:
        <input type="time" name="end_time" required>
        <br><br>
        Тренер:
        <select id="trainer_email" name="trainer_email" style="display: none;">
            <option value="">Выберите тренера</option>
        </select>
    
        <input type="submit" value="Добавить">
    </form>
</div>
</div>




    <?php
$servername = "localhost";
$username = "f0951856_qqq1"; 
$password = "Cz111111"; 
$dbname = "f0951856_qqq1"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["news_title"])) {
    $news_title = $_POST["news_title"];
    $news_content = $_POST["news_content"];
    $news_date_published = date("Y-m-d H:i:s");

    $sql = "INSERT INTO news (title, content, date_published) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $news_title, $news_content, $news_date_published);

    if ($stmt->execute()) {
        echo "Новость успешно добавлена";
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<div class="info services transparent75">
<h2>Добавить Новость</h2>
<div class="service-card transparent75>">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Заголовок новости: <input type="text" name="news_title" required>
    <br><br>
    Содержание новости: <textarea name="news_content" required></textarea>
    <br><br>
    <input type="submit" value="Добавить">
</form>
</div>
</div>

    <div class="container-secondary">
        <div class="info services transparent75">
            <h1>Новости</h1>
        <?php

        $servername = "localhost";
        $username = "f0951856_qqq1";
        $password = "Cz111111";
        $dbname = "f0951856_qqq1";


        $conn = new mysqli($servername, $username, $password, $dbname);


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        $sql = "SELECT news_id, title, content, date_published FROM news";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {
                echo "<div class='service-card'>";
                echo "<div class='news-item'>";
                echo "<h2 class='news-title'>" . $row["title"] . "</h2>";
                echo "<p class='news-content'>" . $row["content"] . "</p>";
                echo "<p class='date-published'>Дата публикации: " . $row["date_published"] . "</p>";
                echo "<form method='post' action='delete_news.php'>";
                echo "<input type='hidden' name='news_id' value='" . $row["news_id"] . "'>";
                echo "<button type='submit' class='delete-btn'>Удалить</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "Нет доступных новостей.";
        }


        $conn->close();
        ?>
    </div>
    </div>





  <?php
$servername = "localhost";
$username = "f0951856_qqq1";
$password = "Cz111111";
$dbname = "f0951856_qqq1";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_trainer'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $password = $_POST['password'];


    $check_sql = "SELECT * FROM coaches WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_stmt->close();

    if ($check_result->num_rows > 0) {
        echo "Тренер с таким email уже существует.";
    } else {

        $insert_sql = "INSERT INTO coaches (email, password, name, specialization) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssss", $email, $password, $name, $specialization);

        if ($stmt->execute()) {
            echo "Тренер успешно добавлен.";
        } else {
            echo "Ошибка: " . $stmt->error;
        }
        $stmt->close();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_trainer'])) {
  $email = $_POST['trainer_email'];


  $delete_classes_sql = "DELETE FROM class_schedule WHERE trainer_email = ?";
  $delete_classes_stmt = $conn->prepare($delete_classes_sql);
  $delete_classes_stmt->bind_param("s", $email);
  $delete_classes_stmt->execute();
  $delete_classes_stmt->close();


  $delete_trainer_sql = "DELETE FROM coaches WHERE email = ?";
  $delete_trainer_stmt = $conn->prepare($delete_trainer_sql);
  $delete_trainer_stmt->bind_param("s", $email);

  if ($delete_trainer_stmt->execute()) {
      echo "Тренер и все его занятия успешно удалены.";
  } else {
      echo "Ошибка: " . $delete_trainer_stmt->error;
  }
  $delete_trainer_stmt->close();
}


$trainers = [];
$trainers_result = $conn->query("SELECT email FROM coaches");
if ($trainers_result->num_rows > 0) {
    while($row = $trainers_result->fetch_assoc()) {
        $trainers[] = $row['email'];
    }
}

$conn->close();
?>

<!-- Форма для добавления тренера -->
<div class="info services transparent75">
    <h2>Добавление тренера</h2>
    <div class="service-card transparent75">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Email: <input type="email" name="email" required>
    <br><br>
    Имя: <input type="text" name="name" required>
    <br><br>
    Специализация:
    <select name="specialization" required>
        <option value="Танцы">Танцы</option>
        <option value="Йога">Йога</option>
        <option value="Посещение зала">Посещение зала</option>
    </select>
    Пароль: <input type="password" name="password" required>
    <input type="submit" name="add_trainer" value="Добавить тренера">
</form>
</div>
<h2>Тренеры</h2>
<div class="service-card transparent75">
<!-- Форма для удаления тренера -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Email тренера:
    <select name="trainer_email" required>
        <?php foreach ($trainers as $trainer_email): ?>
            <option value="<?php echo $trainer_email; ?>"><?php echo $trainer_email; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit" name="delete_trainer" value="Удалить тренера">
</form>
        </div>
        </div>
        </div>
</body>
</html>