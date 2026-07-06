<?php
session_start();
require('db1.php');

if (!isset($_SESSION['email'])) {
    header("Location: login1.php");
    exit();
}

$email = $_SESSION['email'];
$upload_dir = 'uploads/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $profile_image = $_FILES['profile_image']['name'];
    $profile_image_tmp = $_FILES['profile_image']['tmp_name'];
    $profile_image_type = $_FILES['profile_image']['type'];
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $profile_image_updated = false;


    if (!empty($profile_image) && in_array($profile_image_type, $allowed_types)) {
        $target_file = $upload_dir . basename($profile_image);
        if (move_uploaded_file($profile_image_tmp, $target_file)) {
            $profile_image_updated = true;
        } else {
            echo "<script>alert('Ошибка при обновлении данных профиля');</script>";
        }
    }


    $update_query = $profile_image_updated ?
        "UPDATE `users` SET first_name = ?, last_name = ?, profile_image = ? WHERE email = ?" :
        "UPDATE `users` SET first_name = ?, last_name = ? WHERE email = ?";
    $stmt = $con->prepare($update_query);
    if ($profile_image_updated) {
        $stmt->bind_param('ssss', $first_name, $last_name, $profile_image, $email);
    } else {
        $stmt->bind_param('sss', $first_name, $last_name, $email);
    }
    if ($stmt->execute()) {
        echo "<script>alert('Успешно!');</script>";
    } else {
        echo "<script>alert('Ошибка при обновлении данных профиля');</script>";
    }
}


$query = "SELECT * FROM `users` WHERE email='$email'";
$result = mysqli_query($con, $query) or die(mysqli_error($con));
$user = mysqli_fetch_assoc($result);


$profile_image_path = $upload_dir . $user['profile_image'];


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_photo'])) {
    $current_image = $user['profile_image'];
    if ($current_image) {
        $file_path = $upload_dir . $current_image;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $update_query = "UPDATE `users` SET profile_image = '' WHERE email = ?";
        $stmt = $con->prepare($update_query);
        $stmt->bind_param('s', $email);
        if ($stmt->execute()) {
            echo "<script>alert('Фото профиля удалено');</script>";
        } else {
            echo "<script>alert('Ошибка при удалении фото профиля');</script>";
        }
    }
}


if (isset($_POST['cancel'])) {
    $class_id = $_POST['class_id'];
    $cancel_query = "DELETE FROM sports WHERE email='$email' AND class_schedule_id='$class_id'";
    $cancel_result = mysqli_query($con, $cancel_query) or die(mysqli_error($con));
    if ($cancel_result) {
        echo "<script>alert('Запись на занятие отменена');</script>";
    }
}

// Получение списка занятий, на которые записался пользователь
$class_query = "SELECT cs.class_id, cs.class_name, cs.day_of_week, cs.time_slot, cs.end_time, c.name AS trainer_name, c.bio, c.photo
                FROM class_schedule cs
                LEFT JOIN sports s ON cs.class_id = s.class_schedule_id
                LEFT JOIN coaches c ON c.email = cs.trainer_email
                WHERE s.email = ? AND cs.available = 1";
$stmt = $con->prepare($class_query);
$stmt->bind_param('s', $email);
$stmt->execute();
$class_result = $stmt->get_result();



$coaches_info = [];


$coaches_query = "SELECT email, bio, photo FROM coaches";
$coaches_result = mysqli_query($con, $coaches_query) or die(mysqli_error($con));
while ($coach = mysqli_fetch_assoc($coaches_result)) {
    $coaches_info[$coach['email']] = $coach;
}
?>





<!DOCTYPE html>
<html lang="en">
  <head>
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
  </head>

  <style>
    body {
      background-image: url('https://catherineasquithgallery.com/uploads/posts/2021-03/1615820565_8-p-yoga-fon-10.jpg');
        background-size: cover;
        background-repeat: no-repeat;
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
      line-height: 1.8;
      margin-bottom: 15px;
    }
    ul {
      list-style: none;
      padding: 0;
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
      background-color: #ffa07a;
      color: #333;
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
      margin-top: 30px;
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
    .container1 {
      width: 50%;
    }

    .kruzhochek {
      width: 300px;
      height: 300px;
      border-radius: 40%;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      padding: 0.5em;
      float: right;
      margin: 0 160px 0 0;
      justify-content: center;
      align-items: center;
    }
    .transparent90 {
        filter: alpha(Opacity=90);
        opacity: 0.9;
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
      <div class="container">
        <a class="navbar-brand p-0" >
          <img src="logo2.png" alt="Logo2" width="100" />
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

            <!-- 
            <li class="nav-item"> 
            <a class="nav-link disabled" href="#">Disabled</a>
            </li> 
        -->
          </ul>

          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="logout1.php">Выход из учетной записи</a>
            </li>
            <li class="nav-item border-start border-secondary-light">
              <a class="nav-link active" href="redirect.php">Профиль</a>
            </li>
            <a
              class="btn btn-outline-success my-2 my-sm-0"
              href="registration1.php"
              type="submit"
            >
              Зарегистрироваться
            </a>
          </ul>
        </div>
      </div>
    </nav>

    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="<?php echo $profile_image_path; ?>" class="card-img-top" alt="Фото профиля">
                    <div class="card-body">
                        <h5 class="card-title">Профиль пользователя</h5>
                        <p class="card-text">Имя: <?php echo $user['first_name']; ?></p>
                        <p class="card-text">Фамилия: <?php echo $user['last_name']; ?></p>
                        <p class="card-text">Email: <?php echo $user['email']; ?></p>
                        <a href="wod.php" class="btn btn-primary" style="background-color: #4CAF50; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: block; font-size: 16px; margin-top: 20px; cursor: pointer; border-radius: 8px;">Записаться на занятие</a>
                        
                        
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            Редактировать профиль
                        </button>



                    </div>
              
                </div>
            </div>
            <div class="col-md-8">
    <h2>Занятия</h2>
    <?php if ($class_result->num_rows > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Дата</th>
                    <th>Время начала</th>
                    <th>Время окончания</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $class_result->fetch_assoc()): ?>
              <tr>
                  <td><?php echo $row['class_name']; ?></td>
                  <td><?php echo $row['day_of_week']; ?></td>
                  <td><?php echo $row['time_slot']; ?></td>
                  <td><?php echo $row['end_time']; ?></td>
                  <td>
                      <form method="post">
                          <input type="hidden" name="class_id" value="<?php echo $row['class_id']; ?>">
                          <button type="submit" name="cancel" class="btn btn-danger">Отменить</button>
                      </form>
                      <?php if (!empty($row['trainer_name'])): ?>
                          <button type="button" class="btn btn-info" onclick="showCoachInfo('<?php echo htmlspecialchars($row['trainer_name'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['bio'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['photo'], ENT_QUOTES); ?>')">Тренер</button>
                      <?php endif; ?>
                  </td>
              </tr>
          <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Занятия не найдены.</p>
    <?php endif; ?>
</div>
        </div>
    </div>

      </div>
    </div>



     <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Редактирование профиля</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">Имя:</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Фамилия:</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="profile_image" class="form-label">Фото профиля:</label>
                                
                            <input type="file" name="profile_image" accept="image/*">

                             
                            <button type="submit" name="delete_photo" class="btn btn-danger">Удалить фото профиля</button>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            <button type="submit" name="submit" class="btn btn-success">Сохранить изменения</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    function showCoachInfo(trainerName, bio, photo) {
      // Создание фона модального окна
      var modalBackdrop = document.createElement('div');
      modalBackdrop.style.position = 'fixed';
      modalBackdrop.style.left = '0';
      modalBackdrop.style.top = '0';
      modalBackdrop.style.width = '100%';
      modalBackdrop.style.height = '100%';
      modalBackdrop.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
      modalBackdrop.style.zIndex = '1000';

      // Создание модального окна
      var modal = document.createElement('div');
      modal.style.position = 'fixed';
      modal.style.left = '50%';
      modal.style.top = '50%';
      modal.style.transform = 'translate(-50%, -50%)';
      modal.style.backgroundColor = '#fff';
      modal.style.padding = '60px';
      modal.style.zIndex = '1001';
      modal.style.borderRadius = '15px';
      modal.style.boxShadow = '0 6px 12px rgba(0, 8888, 0, 0.2)';
      modal.style.maxWidth = '600px';
      modal.style.boxSizing = 'border-box';


      var nameElement = document.createElement('h3');
      nameElement.textContent = trainerName;
      modal.appendChild(nameElement);


      var bioElement = document.createElement('p');
      bioElement.textContent = bio;
      modal.appendChild(bioElement);

      // Добавление фотографии тренера, если она есть
      if (photo) {
          var photoElement = document.createElement('img');
          photoElement.src = 'uploads/' + photo;
          photoElement.alt = 'Фото тренера';
          photoElement.style.maxWidth = '380px';
          modal.appendChild(photoElement);
      }

      // Добавление кнопки закрыть
      var closeButton = document.createElement('button');
      closeButton.textContent = '✖';
      closeButton.style.position = 'absolute';
      closeButton.style.top = '10px';
      closeButton.style.right = '20px';
      closeButton.style.border = 'none';
      closeButton.style.background = 'none';
      closeButton.style.color = '#333';
      closeButton.style.fontSize = '24px';
      closeButton.style.cursor = 'pointer';
      closeButton.onclick = function() {
          document.body.removeChild(modalBackdrop);
      };
      modal.appendChild(closeButton);


      modalBackdrop.appendChild(modal);


      modalBackdrop.onclick = function(event) {
          if (event.target === modalBackdrop) {
              document.body.removeChild(modalBackdrop);
          }
      };

  
      document.body.appendChild(modalBackdrop);
    }
    </script>

  </body>
</html>