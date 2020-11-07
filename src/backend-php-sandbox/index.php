<?php
set_error_handler("error_handler", E_ALL);

$origin = '*';
if (array_key_exists('APP_ACCESS_CONTROL_ALLOW_ORIGIN', $_ENV)) {
    $origin = $_ENV['APP_ACCESS_CONTROL_ALLOW_ORIGIN'];
}

$config = [
    'ip_blacklist' => '',
    'http_origin' => $origin
];


$result = [
    'responseCode' => 0,
    'result' => '',
    'exec_time' => 0,
    'use_memory_mb' => 0,
    'version' => phpversion()
];

if ($config['http_origin'] === '*') {
    header("Access-Control-Allow-Origin: *");
}
if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] == $config['http_origin']) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
}

header('Access-Control-Allow-Credentials: true');
header('Access-Control-Request-Method: POST, OPTIONS');
header('Access-Control-Max-Age: 86400');    // cache for 1 day

function error_handler($errno, $errstr)
{
    if ($errno == E_WARNING) {
        throw new \Exception($errstr);
    } else if ($errno == E_NOTICE) {
        throw new \Exception($errstr);
    }
}

// Проверка на OPTIONS запрос for sensitivity client
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    $result['responseCode'] = 200;
    header('Content-Type: application/json');
    echo json_encode($result);
    die();
}

// Проверка на GET запрос health check
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    http_response_code(200);
    $result['responseCode'] = 200;
    header('Content-Type: application/json');
    echo json_encode($result);
    die();
}

// Проверка на POST запрос
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(403);
    $result['responseCode'] = 403;
    header('Content-Type: application/json');
    echo json_encode($result);
    die();
}

// Установим и проверим на занятость семафор, что бы не допустить большое колличество запросов
// TODO external to billing
/*$semRes = sem_get(intval(str_replace('.', '', $_SERVER['REMOTE_ADDR'])), 1, 0666, 1);
if (!sem_acquire($semRes, true)) {
    http_response_code(429);
    $result['responseCode'] = 429;
    header('Content-Type: application/json');
    echo json_encode($result);
    die();
}
sem_release($semRes);*/

$body = file_get_contents('php://input');
$json = json_decode($body, true);
$jsonCode = '';
if (array_key_exists('code', $json)) {
    $jsonCode = $json['code'];
}

$code = $jsonCode;
if (array_key_exists('code', $_POST)) {
    $jsonCode = $_POST['code'];
}

// Get code
if (empty($code)) {
    http_response_code(400);
    $result['responseCode'] = 400;
    header('Content-Type: application/json');
    echo json_encode($result);
    die();
}


$code = html_entity_decode($code, ENT_HTML5);
$code = preg_replace('/\<\?php\s*|\<\?\s*/', '', $code);
$code = preg_replace('/\?\>\s*/', '', $code);

// replace newlines in the entire code block by the new specified one
// i.e. put #\r\n on the first line to emulate a file with windows line
// endings if you're on a unix box
if (preg_match('{#((?:\\\\[rn]){1,2})}', $code, $m)) {
    $newLineBreak = str_replace(array('\\n', '\\r'), array("\n", "\r"), $m[1]);
    $code = preg_replace('#(\r?\n|\r\n?)#', $newLineBreak, $code);
}

ob_start();
$memBefore = memory_get_usage(true);
$start = microtime(true);

try {
    eval($code);
} catch (\Exception $e) {
    echo 'Uncaught exception: ' . get_class($e) . ' ' . $e->getMessage() . '<br>';
} catch (\Throwable $e) {
    echo 'Uncaught exception: ' . get_class($e) . ' ' . $e->getMessage() . '<br>';
}
$debugOutput = '';

$end = microtime(true);
$memAfter = memory_get_peak_usage(true);
$debugOutput .= ob_get_clean();

$memory = sprintf('%.3f', ($memAfter - $memBefore) / 1024.0 / 1024.0); // in MB
$execTime = sprintf('%.3f', (($end - $start) * 1000)); // in ms

$result = [
    'responseCode' => 200,
    'result' => $debugOutput,
    'exec_time' => $execTime,
    'use_memory_mb' => $memory,
    'version' => phpversion()
];

http_response_code(200);
header('Content-Type: application/json');
echo json_encode($result);
die();
