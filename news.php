<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Новости</title>
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
  </head>

  <style>
    body {
      background-image: url("bcknews.png");
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
      margin-bottom: 40px;
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    p {
      line-height: 1.8;
      margin-bottom: 15px;
    }
    ul {
      list-style: none;
      padding: 0;
    }
    .transparent75 {
      filter: alpha(Opacity=75);
      opacity: 0.75;
    }
    .info {
      margin-bottom: 20px;
      border-radius: 10%;
    }
    .info div {
      margin-bottom: 20px;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }
    .info h2 {
      font-size: 1.8em;
      margin-bottom: 0px;
    }
    .info p {
      font-size: 1.1em;
    }
    .services {
      background-color: #ffd700;
      color: #333;
    }
    .team {
      background-color: #bfbf40;
      color: #727f28;
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
      border-radius: 8px;
      background-color: #fff;
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

    .split-container {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 20px;
      backdrop-filter: blur(8px);
    }

    .split-container > div {
      width: calc(50% - 20px);
    }
    .transparent90 {
        filter: alpha(Opacity=90);
        opacity: 0.9;
    }
    .container-secondary {
      margin-top: 30px;
    }
    .container1 {
      width: 50%;
    }
    .table {
      color: #ffffff;
    }

    .block {
        margin-right: 117px; /* Добавьте отступы, если это необходимо */
    }

    @media (max-width: 768px) {
      .split-container > div {
        width: 100%;
        margin-bottom: 20px;
      }
    }
  </style>

  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark transparent90">
      <div class="container block">
          <a class="navbar-brand p-0" >
              <img src="logo2.png" alt="html/Logo2" width="100" />
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
  
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                      <a class="nav-link" href="index.html">Главная</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link active" href="news.php">Новости</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="aboutedit.html">Информация о нас</a>
                  </li>
                  
                  <li class="nav-item border-start border-secondary-light">
                    <a class="nav-link" href="redirect.php">Профиль</a>
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
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container">
      <div class="container-secondary text-center my-5">
        <h1 class="fw-dark">Новости и публикации</h1>
      </div>
      <div class="split-container transparent75">
      <?php

$servername = "localhost";
$username = "f0951856_qqq1";
$password = "Cz111111";
$dbname = "f0951856_qqq1";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT news_id, title, content FROM news";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        echo '<div class="info team transparent75">';
        echo '<h2>' . $row["title"] . '</h2>';
        echo '<div>';
        echo '<p>' . $row["content"] . '</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "Нет доступных новостей.";
}


$conn->close();
?>

    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>