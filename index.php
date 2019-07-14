<?php
session_start();
if(isset($_SESSION['registratonsuccess']))if($_SESSION['registratonsuccess'] = 'yes') $registration_success = "yes";
if(isset($_POST['logout'])) unset($_SESSION['registratonsuccess']);
require_once "create_folder.php";

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico" />
	<meta name="description"
          content="На нашем сайте вы всегда можете отправить заявку и мы свяжемся с вами в течении 5 минут">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="css/main.css" rel="stylesheet" type="text/css"/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>

    <title>Форма отправки заявки</title>
</head>
<body>
<div class="container" id="main">
    <div class="row">
        <div class="col-lg-3 registration">

	        <h3>Авторизация:</h3>
            <?php if($registration_success == "yes")echo"<a href='/admin/index.php'>Перейти в панель администратора</a><div style='text-align: center;'>Вы зарегистрировались как администратор</div>";?>
            <form  <?php if($registration_success == "yes")echo"style='display: none;'";?>
		            action="admin/index.php" method="POST">
	            <p>Для перехода в админ панель пройдите авторизацию</p>
                <label for="login">Введите имя:</label>
                <input type="text" name="login">
                <label for="password">Введите пароль:</label>
                <input type="password" name="password">
                <input class="btn-success" type="submit" value="Войти" name="register">

            </form>

	        <form  <?php if($registration_success != "yes") echo"style='display: none;'";?>
			        action="index.php" method="POST">
		        <input class="btn-danger" type="submit" value="Выйти" name="logout">
	        </form>


		<?php
			if(isset($_GET['registraionInfo']))if($_GET['registraionInfo'] =="nopass")echo "<p><span>Проверьте имя пользователя и/или пароль</span></p>";?>
        </div>

        <div class="col-lg-9 main-content">
            <h1>Задать вопрос</h1>
            <div class="container ">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p>На данной странице вы можете задать свой вопрос и прикрепить файлы
                            заполните все поля формы и нажмите "Отправить" с вами свяжутся наши сотрудники в ближайшее
                            время</p>

                    </div>
                </div>

                <?php echo $emailError; ?>
                <div class="row form-order">
                    <?php if($send_order == null || $error > 0){
                        echo"
                    <form action='index.php' method='POST' enctype='multipart/form-data'>
                        <div class='row'>
                            <div class='col-lg-6 text-center'><label for='question'>Введите вопрос:<br/><span class='errorForm'>$questionError</span></label></div>
                            <div class='col-lg-6'><textarea name='question' id='question' >$question</textarea></div>
                        </div>

                        <div class='row'>
                            <div class='col-lg-6 text-center'><label for='user'>Введите имя:<br/><span class='errorForm' >$nameError</span></label></div>
                            <div class='col-lg-6'><input type='text' name='user' value='$user' id='user'></div>
                        </div>
                        <div class='row'>
                            <div class='col-lg-6 text-center'><label for='email'>Введите email:<br/><span class='errorForm' >$emailError</span></label></div>
                            <div class='col-lg-6 text-left'><input type='text' name='email' value='$email' id='email'></div>
                        </div>
                        <div class='row'>
                          <input type='hidden' name='MAX_FILE_SIZE' value='3000000'>
                            <div class='col-lg-6 text-center'><label for='userFile'>Прикрепить файл <br/> (в формате jpg):</label></div>
                            <div class='col-lg-6 text-left'><input type='file' name='userFile' id='userFile'></div>
                        </div>

                        <div class='row'>
                            <div class='col-lg-12 text-right'>
                                <input class='btn-info ' type='submit' value='Отправить' name='send-order' >
                            </div>
                        </div>


                    </form>'";
            }else echo "<h3>$statusUploadFile</h3>";?>



                </div>
                <div class="row reed-form">
                    <div class="col-lg-12">


                    </div>
                </div>


            </div>


        </div>
    </div>


</div>
</body>
</html>