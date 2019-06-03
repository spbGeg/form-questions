<?php
session_start();
if(isset($_POST['register'])){
    if($_POST['login'] != "admin" && $_POST['password'] != "123"){
        header("Location: http://form-questions/index.php?registraionInfo=nopass");


    }else $_SESSION['registratonsuccess'] = 'yes';
}
if($_SESSION['registratonsuccess'] != "yes")  header("Location: http://form-questions/index.php?registraionInfo=nopass");

if(isset($_POST['logout'])) unset($_SESSION['registratonsuccess']);
function remove_dir($dir)
{
    if ($objs = glob($dir . '/*')) {
        foreach ($objs as $obj) {
            is_dir($obj) ? remove_dir($obj) : unlink($obj);
        }
    }
    rmdir($dir);
}

if (isset($_POST['startDelete'])) {
    $deleteQuestion = $_POST['deleteQuestion'];
    chdir('../orders');
    remove_dir($deleteQuestion);


}
if (isset($_POST['changemail'])) {
    $newemail = $_POST['emailsender'];
    $fileemailsender = fopen('emailsender.txt', "a+");
    file_put_contents("emailsender.txt", $newemail);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="shortcut icon" type="image/x-icon" href="../img/favicon.ico"/>
	<meta name="description"
	      content="На нашем сайте вы всегда можете отправить заявку и мы свяжемся с вами в течении 5 минут">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
	      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="../css/main.css" rel="stylesheet" type="text/css"/>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
	        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
	        crossorigin="anonymous"></script>

	<title>Панель администратора</title>
</head>
<body>
<div class="container" id="main">

	<div class="row">
		<div class="col-lg-3 registration">
			<div class="row gitLink">
				<div class="col-lg-12"><img src="../img/git-hub.jpg" alt="git hub"> <a
							href="https://github.com/spbGeg/form-questions.git">Ссылка на репозиторий</a></div>
			</div>
			<h3>Авторизация:</h3>
			<form action="index.php" method="POST">
			<input class="btn-danger" type="submit" value="Выйти" name="logout">
			</form>


		</div>

		<div class="col-lg-9 main-content">
			<h1>Панель администратора</h1>
			<div class="container ">
				<div class="row">
					<div class="col-lg-12 text-center">
						<p>Вернуться на <a href="/index.php"><b>Главную</b></a></p>

					</div>
				</div>


				<div class="row form-order">


				</div>
				<div class="row reed-form">
					<div class="col-lg-12">
						<h5>Список обращений пользователей</h5>
						<table>

							<tr>
								<th style="width:10%">№</th>
								<th style="width:20%">Имя пользователя</th>
								<th style="width:20%">Email</th>
								<th>Вопрос</th>
								<th style="width:10%">Прикр. файлы</th>
								<th style="width:10%">Удалить вопрос</th>
							</tr>

                            <?php

                            chdir("../orders");
                            if ($handle = opendir('.')) {
                                while (false !== ($file = readdir($handle))) {
                                    if ($file != "." && $file != "..") {
                                        //вытаскиваем данные из файла
                                        chdir($file);
                                        //вытаскиваем приложенный файл
                                        $path = array();
                                        $path = scandir(".");
                                        $pathFile = $path[3];
                                        if($pathFile != ""){
                                        	$userFile = "<a href=\"../orders/$file/$pathFile\" target='_blank' ><img style='width:50px;' src='../img/file-jpg.png'></a> ";
                                        }
                                        	
                                        	
                                        $userData = array();
                                        $userData = file("data_user.txt");

                                        echo "<tr><td>" . $file . "</td><td>" . $userData[1] . "</td><td><a href='mailto:" . $userData[2] . "'>" . $userData[2] . "</a></td><td>" . $userData[3] . "</td>
									<td>
							$userFile
									</td>
                                    <td>
                                    <form action='index.php' method='post'>
                                    <input type='hidden' value='$file' name='deleteQuestion'>
                                    <input class='btn-danger' type='submit' name='startDelete' value='Удалить'>
                                     </form>
                                    
                                    
                                    </td></tr>";

                                       
                                        



                                        chdir("..");


                                    }
                                }
                                closedir($handle);
                            }
                            ?>

						</table>

					</div>
				</div>

			</div>

			<div class="row text-center"><h5>Отправка уведомлений на почту администартора</h5></div>
			<div class="row changeEmail">

				<div class="col-lg-4 ">
					Отправка уведомлений производится на адрес: <?php
                    chdir('../admin');
                    $to = file_get_contents('emailsender.txt');
                    echo "<b>$to</b>";
                    chdir('..'); ?>
				</div>
				<div class="col-lg8">
					<form action="index.php" method="post">
						<input type="text" name="emailsender">
						<input type="submit" name="changemail" value="Поменять email">
					</form>
				</div>

			</div>
		</div>

	</div>


</div>
</body>
</html>