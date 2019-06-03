<?php
$date = date("Y m d");
$folder_order = 1;
$send_order = false;
chdir("admin");
$to = file_get_contents('emailsender.txt');
chdir("..");
if (isset ($_POST["send-order"])) {

    $send_order = $_POST['send-order'];
    $question = htmlspecialchars($_POST['question']);
    $email = $_POST['email'];
    $user = htmlspecialchars($_POST['user']);
    if ($question == "") {
        $error = 3;
    } elseif (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email)) {
        $error = 1;
    } elseif ($user =="") {
        $error = 2;
    }else  $error = 0;

} else $send_order = null;


switch ($error) {

    case 1:
        $emailError = "Email введен на верно";
        break;
    case 2:
        $nameError = "Имя не введено ";
        break;
    case 3:
        $questionError = "Вопрос не введен";
        break;
    default: break;

}

if ($error == 0 && $send_order == true) {


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
//Вносим данные юзера
    $file = fopen('data_user.txt', "a");

    $string = $folder_order . "\n" . $user . "\n" . $email . "\n" . $question . "\n";

    file_put_contents("data_user.txt", $string);

    // Прикрепляем файлы
    if ($_FILES['userFile']['error'] == UPLOAD_ERR_OK && $_FILES['userFile']['type'] == 'image/jpeg') { // Проверяем на наличие ошибок
        $destiation_dir = dirname(".") . '/' . $_FILES['userFile']['name']; // Директория для размещения файла
        move_uploaded_file($_FILES['userFile']['tmp_name'], $destiation_dir); // Перемещаем файл в желаемую директорию
        $statusUploadFile = ' Вопрос c загруженным файлом отправлен'; // Оповещаем пользователя об успешной загрузке файла


    } else {
        $statusUploadFile = ' Вопрос отправлен'; // Оповещаем пользователя о том, что файл не был загружен
        switch ($_FILES['userFile']['error']) {
            case UPLOAD_ERR_FORM_SIZE:
            case UPLOAD_ERR_INI_SIZE:
            $statusUploadFile = "<i style='color:#ff0000;'> Вопрос отправлен, приложенные файлы передать не удалосьш, размер файла превышен </i>";
                brake;
            case UPLOAD_ERR_NO_FILE:
                $statusUploadFile = ' Вопрос отправлен';
                break;
            default:
                $statusUploadFile = " <i style='color:#ff0000;'>Вопрос отправлен, приложенный файл передать не удалось<br/> загрузите картинку в формате jpg и повторите отправку</i>";

        }



        chdir('/../..');
        require_once("admin/sendmailer.php");
    }
}

