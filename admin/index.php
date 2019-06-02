<?php

//if(isset($_POST['register'])){
//    if(isset($_POST['login']) && isset($_POST['password'])){
//        $login = $_POST['login'];
//        $password = $_POST['password'];
//        if($login != 'admin' && $password != '123'){
//            header('Location:http://form-send-file/index.php');
//            exit;
//
//        }
//
//    }else {
//        header('Location:http://form-send-file/index.php');
//        exit;
//    };
//    if(isset($_POST['email'])) $email= $_POST['email'];
//    else $email = "Email не задан";
//    if(isset($_POST['question']))$question= $_POST['question'];
//    else $question = "Вопрос не задан";
//} else $send_order = null;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

            <h3>Авторизация:</h3>
            <form action="adimin/index.php" method="POST">
                <label for="login">Введите имя:</label>
                <input type="text" name="login">
                <label for="password">Введите пароль:</label>
                <input type="password" name="password">
                <input class="btn-dangerх" type="submit" value="Выйти" name="register">

            </form>


        </div>

        <div class="col-lg-9 ">
            <h1>Панель администратора</h1>
            <div class="container main-content">
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
                            <th style="width:20%">Удалить вопрос</th>
                        </tr>

                        <?php

                        chdir("../orders");
                        if ($handle = opendir('.')) {
                            while (false !== ($file = readdir($handle))) {
                                if ($file != "." && $file != "..") {
                                   //вытаскиваем данные из файла
                                   chdir($file);
                                   $userData = array();
                                    $userData = file("data_user.txt");
                                    //print_r( $userData);
                                    echo"<tr><td>" . $file . "</td><td>" . $userData[1] . "</td><td><a href='mailto:" . $userData[2] ."'>". $userData[2] . "</a></td><td>" . $userData[3] . "</td><td></td></tr>";


                                   chdir("..");

                                    //echo "$file\n";
                                }
                            }
                            closedir($handle);
                        }
                        ?>

                    </table>

                    </div>
                </div>


            </div>


        </div>
    </div>


</div>
</body>
</html>