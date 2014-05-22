<?php
$tc = '"/translateAndCall.php?MyParams=' . urlencode($_REQUEST['Receiver'] . '|' . $_REQUEST['Digits']) . '"';
?>
<Response>
	<Say voice="woman">Please say your message now, then press pound.</Say>
	<Record action="/finishedRecording.php" 
			method="GET"
			maxLength="120"
			transcribe="true" 
			transcribeCallback=<?php echo $tc ?> />
</Response>
