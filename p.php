<?php
header('Content-Type: application/json; charset=utf-8');

$token = '8616824286:AAHG5ACUX1YnG0m_EK1LWGCjKrpIdj255Ts';
$chat_id = '1543694187';

$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$service = trim($_POST['service'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $phone === '') {
    echo json_encode([
        'ok' => false,
        'message' => 'Заполни имя и телефон'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$text = "Новая заявка с сайта GeoGps

";
$text .= "Имя: {$name}
";
$text .= "Телефон: {$phone}
";
$text .= "Что интересует: " . ($service ?: '-') . "
";
$text .= "Комментарий: " . ($message ?: '-');

$url = "https://api.telegram.org/bot{$token}/sendMessage";

$data = [
    'chat_id' => $chat_id,
    'text' => $text
];

$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/x-www-form-urlencoded
",
        'content' => http_build_query($data),
        'timeout' => 20
    ]
];

$context = stream_context_create($options);
$result = @file_get_contents($url, false, $context);

if ($result === false) {
    echo json_encode([
        'ok' => false,
        'message' => 'Ошибка отправки'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$response = json_decode($result, true);

if (!empty($response['ok'])) {
    echo json_encode([
        'ok' => true,
        'message' => 'Заявка принята'
    ], JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode([
        'ok' => false,
        'message' => 'Не смогли отправить заявку'
    ], JSON_UNESCAPED_UNICODE);
}
?>
