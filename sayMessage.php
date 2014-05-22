<Response>
<?php
$args = explode('|', urldecode($_REQUEST['MyParams']));
$targetLang = $args[0];
$message = $args[1];

$sayCodes = ['en' => '"en-US"',
			 'es' => '"es-MX"',
			 'fr' => '"fr-FR"',
			 'de' => '"de-DE"',
			 'it' => '"it-IT"',
			 'ru' => '"ru-RU"',
			 'sv' => '"sv-SE"',
			 'nl' => '"nl-NL"',
			 'ko' => '"ko-KR"',
			 'zh-CN' => '"zh-CN"'];
$lang = $sayCodes[$targetLang];
?>
	<Say voice="alice" language=<?php echo $lang ?> >
		<?php echo urldecode($message) ?>
	</Say>
	<Pause length="3" />
</Response>

