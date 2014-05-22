<?php
require_once('vendor/autoload.php');
 
// Get Parameters
$args = explode('|', urldecode($_REQUEST['MyParams']));
$receiver = $args[0];
$langIndex = $args[1];
$secrets = parse_ini_file("secrets.ini", true);
var_dump($secrets);
// TRANSLATE
$translateEndpoint = "https://www.googleapis.com/language/translate/v2";
$langCodes = ['en', 'es', 'fr', 'de', 'it', 'ru', 'sv', 'nl', 'ko', 'zh-CN'];
$targetLang = $langCodes[intval($langIndex)];
$translated = $message;

if ($targetLang != 'en') {
	$params = ['source' => 'en',
			   'target' => $targetLang,
			   'q' => $_REQUEST['TranscriptionText'],
			   'key' => $secrets['google']['key']];

	$queryString = http_build_query($params);
	$url = $translateEndpoint . '?' . $queryString;
	$response = Requests::get($url);
	$decoded = json_decode($response->body);
	var_dump($decoded);
	$translated = $decoded->data->translations[0]->translatedText;
}

// CALL AND SEND MESSAGE
$sid = $secrets['twilio']['sid']; 
$token = $secrets['twilio']['token']; 
$client = new Services_Twilio($sid, $token);

$callbk = "http://c3po.ngrok.com/sayMessage.php?MyParams=" . urlencode($targetLang . '|' . $translated);

$call = $client->account->calls->create("+12487960351", 
										$receiver, 
										$callbk, 
										["IfMachine" => "Continue"]);
echo $call->sid;
?>