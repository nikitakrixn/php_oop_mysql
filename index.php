<?php
include_once 'autoload.php';
$user = new User();
if(!isset($_SESSION['auth']) || empty($_SESSION['auth'])){
    header("location: login.php");
    exit();
}
?>

<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="assets/css/style.css" rel="stylesheet">

    <title>Профиль пользователя</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $_SERVER['PHP_SELF'] ?>">PHP OOP MYSQL</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="index.php" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img src="assets/img/profile-img.jpg" class="img-fluid rounded-circle" width="24" height="24" alt="<?php echo $_SESSION['username']; ?>">
                        <?php echo $_SESSION['username']; ?> <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="editprofile.php">Редактировать профиль</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Выход</a>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row min-vh-100 flex-column flex-md-row">
        <main class="col px-0 flex-grow-1">
            <div class="container py-3">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-4">Профиль пользователя</h5>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Имя пользователя:</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo $_SESSION['username']; ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Дата создания профиля:</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo $_SESSION['created']; ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Роль</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php $user->viewRoleName($_SESSION['role_id']); ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Дата последней авторизации:</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php $user->viewLastTimeAuth($_SESSION['id']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($_SESSION['role_id'] == '2') { ?>
            <div class="container mt-5">
                <div class="col-lg-12">
                    <div class="main-box no-header clearfix">
                        <div class="main-box-body clearfix">
                            <div class="table-responsive">
                                <table class="table user-list">
                                    <thead>
                                    <tr>
                                        <th  class="text-center">SL</th>
                                        <th  class="text-center">Имя пользователя</th>
                                        <th  class="text-center">Дата создания</th>
                                        <th  class="text-center">Роль</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $allUsers = $user->selectAllUserData();
                                    if ($allUsers) {
                                    $i = 0;
                                    foreach ($allUsers as  $value) {
                                    $i++;
                                    ?>
                                    <tr class="text-center"
                                        <?php if ($_SESSION['id'] == $value['account_id']) {
                                            echo "style='background:#d9edf7' ";
                                        } ?>>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value['account_name'] ?></td>
                                        <td><?php echo $value['createdat'] ?></td>
                                        <td><?php if($value['role_name'] == 'Пользователь') {
                                                echo "<span class='badge badge-lg badge-info text-white'>" . $value['role_name'] . "</span>";
                                            } elseif ($value['role_name'] == 'Администратор') {
                                                echo "<span class='badge badge-lg badge-dark text-white'>" . $value['role_name'] . "</span>";
                                            }?></td>
                                    <?php } ?>
                                        </tr>
                                    <?php } else { ?>
                                        <tr class="text-center">
                                            <td>No user availabe now !</td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
 <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>