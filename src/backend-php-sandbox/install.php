<?php
//USE php install.php http://localhost:18081/php-fpm-73/index.php
$publicUrl = '';
if (array_key_exists('1', $argv)) {
    $publicUrl = $argv[1];
}
$phpVersion = phpversion();
echo 'Settings' . PHP_EOL;
echo 'phpVersion: ' . $phpVersion . PHP_EOL;
echo 'publicUrl: ' . $publicUrl . PHP_EOL;

if (!empty($publicUrl)) {
    $curl = curl_init();

    $payload = json_encode(['phpVersion' => $phpVersion, 'publicUrl' => $publicUrl]);
    curl_setopt( $curl, CURLOPT_POSTFIELDS, $payload );

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://codetry-nginx/php-hub/api/v1/php-instance/register",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Content-Type: application/json"
        ),
    ));

    $response = curl_exec($curl);

    var_dump(curl_error($curl));
    var_dump($response);
    curl_close($curl);
} else {
    echo 'Enter public url';
}

