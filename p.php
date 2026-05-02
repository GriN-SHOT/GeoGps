<?php
$token = '8616824286:AAHG5ACUX1YnG0m_EK1LWGCjKrpIdj255Ts';
$chat_id = '1543694187';

$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $phone === '') {
    exit('Заполни имя и телефон');
}

$text = "Новая заявка с сайта GeoGps\n\n";
$text .= "Имя: " . $name . "\n";
$text .= "Телефон: " . $phone . "\n";
$text .= "Комментарий: " . ($message !== '' ? $message : '-');

$url = "https://api.telegram.org/bot{$token}/sendMessage";

$data = [
    'chat_id' => $chat_id,
    'text' => $text
];

$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query($data),
        'timeout' => 20
    ]
];

$context = stream_context_create($options);
$result = @file_get_contents($url, false, $context);

if ($result === false) {
    exit('Ошибка отправки. Проверь токен, chat_id и /start у бота.');
}

$response = json_decode($result, true);

if (isset($response['ok']) && $response['ok'] === true) {
    echo 'Заявка отправлена в Telegram';
} else {
    echo 'Ошибка Telegram: ' . ($response['description'] ?? 'неизвестная ошибка');
}
?>