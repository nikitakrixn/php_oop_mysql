<?php
	include_once 'autoload.php';
	$user = new User();
    if(isset($_SESSION["auth"]) !="")
    {
        header("Location: index.php");
        exit;
    }
	if(isset($_POST["register"]))
	{
		$register = $user->addAccount($_POST['username'], $_POST['password'], $_POST['role']);
		echo $user->getMessage();
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

	<title>Регистрация пользователя.</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Авторизация</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="register.php">Регистрация</a>
                </li>
            </ul>

        </div>
    </div>
</nav>
<!-- FORM AREA -->
<main class="col px-0 flex-grow-1">
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class='text-center'>Регистрация</h3>
                    </div>
                    <div class="card-body">
                        <form class="" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                            <div class="form-group">
                                <label for="username">Имя пользователя</label>
                                <input type="text" name="username"  class="form-control" autofocus required>
                            </div>
                            <div class="form-group">
                                <label for="password">Пароль</label>
                                <input type="password" name="password" class="form-control"  required>
                            </div>
                            <div class="form-group">
                                <label for="role">Роль</label>
                                <select class="form-control" name="role" id="role">
                                    <?php
                                    $allRoles = $user->selectAllRoles();
                                    $i = 1;
                                    if(!empty($allRoles)){
                                        foreach($allRoles as $row){
                                            ?>
                                            <option value="<?php echo $row['role_id']; ?>"><?php echo $row['role_name'] ?></option>;
                                            <?php
                                        }}?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="register" class="btn btn-success">Зарегистрироваться</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>

