<?php
$date = date("Y m d");
$folder_order = 1;
$send_order = false;
if (isset ($_POST["send-order"])) {

    $send_order = $_POST['send-order'];
    if ($_POST['user'] != "") $user = $_POST['user'];
    else $user = "Имя пользователя не задано";
    if ($_POST['email'] != "") {
        $email = $_POST['email'];
        if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email)) {
            $infoEmail = "Email адрес указан не корректно";
        }
    }else $email = "Email не задан";
    if ($_POST['question'] != "") $question = $_POST['question'];
    else $question = "Вопрос не задан";
} else $send_order = null;


if ($send_order) {
    chdir('orders');

    if (file_exists($folder_order)) {


        while (true) {
            $folder_order++;
            if (!file_exists($folder_order)) break;
        }
        mkdir($folder_order);


    } else {
        mkdir($folder_order);

    }
    chdir($folder_order);


    // Прикрепляем файлы
    if (isset($_FILES) && $_FILES['userFile']['error'] == 0) { // Проверяем, загрузил ли пользователь файл
        $destiation_dir = dirname(".") . '/' . $_FILES['userFile']['name']; // Директория для размещения файла
        move_uploaded_file($_FILES['userFile']['tmp_name'], $destiation_dir); // Перемещаем файл в желаемую директорию
        $statusUploadFile = ' c загруженными файлами '; // Оповещаем пользователя об успешной загрузке файла
    } else {
        $statusUploadFile = ' без загруженных файлов '; // Оповещаем пользователя о том, что файл не был загружен
    }
    //Вносим данные юзера
    $file = fopen('data_user.txt', "a");

    $string = $file_order . "\n" . $user . "\n" . $email . "\n" . $question . "\n";

    file_put_contents("data_user.txt", $string);


    chdir('/../..');

}
//fclose($file);