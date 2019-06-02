<?php

//chdir('admin');
//$dir = file(__DIR__);
//print_r($dir);
//

$to  = "admin &lt;$to>, " ;
$to .= "Вадим &lt;spbromanovy@mail.ru>";

$subject = "Поступил вопрос #$folder_order от пользователя";

$message = "
<html>
    <head>
        <title>Поступил новый вопрос от пользователя</title>
    </head>
    <body>
        <p>Номер заявки: $folder_order</p>
        <p>Имя пользователя: $user</p>
        <p>Email пользователя: $email</p>
        <p>Вопрос пользователя: $question</p>
    </body>
</html>";

$headers  = "Content-type: text/html; charset=windows-1251 \r\n";
$headers .= "From: Вадим Романов <spbromanov@mail.ru>\r\n";
$headers .= "Bcc: Вадим Романов <spbromanov@mail.ru>\r\n";
mail($to, $subject, $message, $headers);// отправка уведомления о поступившем вопросе

?>