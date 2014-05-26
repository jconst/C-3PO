<?php
require 'vendor/autoload.php';
 
// Get Parameters
$args = explode('|', urldecode($_REQUEST['MyParams']));
$receiver = $args[0];
$langIndex = $args[1];
$secrets = parse_ini_file("secrets.ini", true);

// TRANSLATE
$translateEndpoint = "https://www.googleapis.com/language/translate/v2";
$langCodes = ['en', 'es', 'fr', 'de', 'it', 'ru', 'sv', 'nl', 'ko', 'zh-CN'];
$targetLang = $langCodes[intval($langIndex)];
$translated = $_REQUEST['TranscriptionText'];

if ($targetLang != 'en') {
	$params = ['source' => 'en',
			   'target' => $targetLang,
			   'q' => $_REQUEST['TranscriptionText'],
			   'key' => $secrets['google']['key']];

	$queryString = http_build_query($params);
	$url = $translateEndpoint . '?' . $queryString;
	$response = Requests::get($url);
	$decoded = json_decode($response->body);
	$translated = $decoded->data->translations[0]->translatedText;
}

// CALL AND SEND MESSAGE
$sid = $secrets['twilio']['sid']; 
$token = $secrets['twilio']['token']; 
$client = new Services_Twilio($sid, $token);

$serverName = $_SERVER['SERVER_NAME'];
if ($serverName == '127.0.0.1' || $serverName == 'localhost') {
	$serverName = "c3po.ngrok.com";
}

$callbk = "http://" . $serverName . "/sayMessage.php?MyParams=" . urlencode($targetLang . '|' . $translated);
echo $callbk;
$call = $client->account->calls->create($secrets['twilio']['number'], 
										$receiver, 
										$callbk, 
										["IfMachine" => "Continue"]);
?>