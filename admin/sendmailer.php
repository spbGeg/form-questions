<?php


$headers = "Content-type: text/html; charset=UTF-8 \r\n";
$headers .= "From: Вадим Романов <info@grillux.kz>\r\n";

$config['smtp_username'] = 'info@grillux.kz'; //Смените на имя своего почтового ящика. (ваш email)
$config['smtp_port'] = 25; // Порт работы. Не меняйте, если не уверены. На 2014 порт вроде 465. ЕСЛИ ВООБЩЕ НЕ РАБОТАЕТ - убрать кавычки в 25
$config['smtp_host'] = 'smtp.spaceweb.ru'; //сервер для отправки почты
$config['smtp_password'] = 'Ss081984'; //Измените пароль (от вашего ящика)
$config['smtp_debug'] = true; //Если Вы хотите видеть сообщения ошибок, укажите true вместо false
$config['smtp_charset'] = 'utf-8'; //кодировка сообщений. (или UTF-8, итд) (меняется также в самом низу)
$config['smtp_from'] = 'Вадим Романов'; //Ваше имя - или имя Вашего сайта. Будет показывать при прочтении в поле "От кого"

$subject = "Поступил вопрос #$folder_order от пользователя";
//$to .= <$to>
$message = "<html>
<head>
<title>Новое сообщение формы &quot;Задать вопрос&quot;</title>
</head>
<body>
<style>
body
		{
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
			font-size: 12px;
			color: #000;
		}
	</style>
<table style='background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;' width='850' cellspacing='0' cellpadding='0' bordercolor='#d1d1d1' border='1'>
<tbody>
<tr>
	<td style='border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;' width='850' height='83' bgcolor='#eaf3f5'>
		<table width='100%' cellspacing='0' cellpadding='0'>
		<tbody>
		<tr>
			<td style='font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;' height='75' bgcolor='#ffffff'>
				 &nbsp;Добавлен новый вопрос <br>
				    <p><b>Номер заявки:</b> $folder_order</p>
                    <p><b>Имя пользователя:</b> $user</p>
                    <p><b>Email пользователя:</b> $email</p>
                    <p><b>Вопрос пользователя:</b> $question</p>
                     --------------------------------------------------------------------------------------------------------<br>
		 Необходимо ответить пользвователю на вопрос<br>
            </td>
		</tr>
		<tr>
			<td height='11' bgcolor='#bad3df'>
            <br>
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>

</tbody>
</table>
 <br>
 <br>

</body>
</html>";


//$headers = 'MIME-Version: 1.0' . "\r\n";
//$headers .= 'Content-type: text/html; charset="windows-1251"' . "\r\n";
//$headers .= 'From: info@grillux.kz'. "\r\n";













function smtpmail($mail_to, $subject, $message, $headers = '')
{
    global $config;
    $SEND = "Date: " . date("D, d M Y H:i:s") . " UT\r\n";
    $SEND .= 'Subject: =?' . $config['smtp_charset'] . '?B?' . base64_encode($subject) . "=?=\r\n";
    if ($headers) $SEND .= $headers . "\r\n\r\n";
    else {
        $SEND .= "Reply-To: " . $config['smtp_username'] . "\r\n";
        $SEND .= "MIME-Version: 1.0\r\n";
        $SEND .= "Content-Type: text/plain; charset=\"" . $config['smtp_charset'] . "\"\r\n";
        $SEND .= "Content-Transfer-Encoding: 8bit\r\n";
        $SEND .= "From: \"" . $config['smtp_from'] . "\" <" . $config['smtp_username'] . ">\r\n";
        $SEND .= "To: $mail_to <$mail_to>\r\n";
        $SEND .= "X-Priority: 3\r\n\r\n";
    }
    $SEND .= $message . "\r\n";
    if (!$socket = fsockopen($config['smtp_host'], $config['smtp_port'], $errno, $errstr, 30)) {
        if ($config['smtp_debug']) echo $errno . "<br>" . $errstr;
        return false;
    }

    if (!server_parse($socket, "220", __LINE__)) return false;

    fputs($socket, "HELO " . $config['smtp_host'] . "\r\n");
    if (!server_parse($socket, "250", __LINE__)) {
        if ($config['smtp_debug']) echo '<p>Не могу отправить HELO!</p>';
        fclose($socket);
        return false;
    }
    fputs($socket, "AUTH LOGIN\r\n");
    if (!server_parse($socket, "334", __LINE__)) {
        if ($config['smtp_debug']) echo '<p>Не могу найти ответ на запрос авторизаци.</p>';
        fclose($socket);
        return false;
    }
    fputs($socket, base64_encode($config['smtp_username']) . "\r\n");
    if (!server_parse($socket, "334", __LINE__)) {
        if ($config['smtp_debug']) echo '<p>Логин авторизации не был принят сервером!</p>';
        fclose($socket);
        return false;
    }
    fputs($socket, base64_encode($config['smtp_password']) . "\r\n");
    if (!server_parse($socket, "235", __LINE__)) {
        if ($config['smtp_debug']) echo '<p>Пароль не был принят сервером как верный! Ошибка авторизации!</p>';
        fclose($socket);
        return false;
    }
    fputs($socket, "MAIL FROM: <" . $config['smtp_username'] . ">\r\n");
    if (!server_parse($socket, "250", __LINE__)) {
        if ($config['smtp_debug']) echo '<p>Не могу отправить комманду MAIL FROM: </p>';
        fclose($socket);
        return false;
    }
    fputs($socket, "RCPT TO: <" . $mail_to . ">\r\n");

    if (!server_parse($socket, "250", __LINE__)) {
        if ($config['smtp_debug']) echo '<p>Не могу отправить комманду RCPT TO: </p>';
        fclose($socket);
        return false;
    }
    fputs($socket, "DATA\r\n");

    if (!server_parse($socket, "354", __LINE__)) {
        if ($config['smtp_debug']) echo '<p>Не могу отправить комманду DATA</p>';
        fclose($socket);
        return false;
    }
    fputs($socket, $SEND . "\r\n.\r\n");

    if (!server_parse($socket, "250", __LINE__)) {
        if ($config['smtp_debug']) echo '<p>Не смог отправить тело письма. Письмо не было отправленно!</p>';
        fclose($socket);
        return false;
    }
    fputs($socket, "QUIT\r\n");
    fclose($socket);
    return TRUE;
}

function server_parse($socket, $response, $line = __LINE__)
{
    global $config;
    while (@substr($server_response, 3, 1) != ' ') {
        if (!($server_response = fgets($socket, 256))) {
            if ($config['smtp_debug']) echo "<p>Проблемы с отправкой почты!</p>$response<br>$line<br>";
            return false;
        }
    }
    if (!(substr($server_response, 0, 3) == $response)) {
        if ($config['smtp_debug']) echo "<p>Проблемы с отправкой почты!</p>$response<br>$line<br>";
        return false;
    }
    return true;
}



smtpmail("$to", "$subject", "$message", "$headers");


?>