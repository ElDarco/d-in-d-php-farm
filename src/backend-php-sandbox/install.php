<?php
//USE php install.php https://codetry.online/php-fpm-81/index.php https://codetry.online/php-hub/api/v1/php-instance/register
$publicUrl = '';
$registrUrl  = '';
if (array_key_exists('1', $argv)) {
    $publicUrl = $argv[1];
}
if (array_key_exists('2', $argv)) {
    $registrUrl = $argv[2];
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
        CURLOPT_URL => $registrUrl,
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

