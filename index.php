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
    <link href="assets/css/style.css.css" rel="stylesheet">

    <title>Профиль пользователя</title>
</head>
<body>
 <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <div class="card" style="width: 25rem">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">Профиль пользователя</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Имя пользователя: <?php echo $_SESSION['username']; ?></h6>
                    <p class="card-text">Дата создания профиля: <?php echo $_SESSION['created']; ?></p>
                    <p class="card-text">Роль: <?php $user->viewRoleName($_SESSION['role_id']); ?></p>
                    <p class="card-text">Дата последней авторизации: <?php $user->viewLastTimeAuth($_SESSION['id']); ?></p>
                    <a class="btn btn-danger btn-block" href="logout.php">Выход</a>
                </div>
            </div>
        </div>
 </div>
 <div class="container mt-5">
     <div class="d-flex justify-content-center">
            <?php if($_SESSION['role_id'] == '2') { ?>
            <div class="card">
                <div class="card-body pr-2 pl-2">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
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
                            <td><?php echo $value['role_name']; ?></td>
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
 <!-- Optional JavaScript; choose one of the two! -->

 <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>