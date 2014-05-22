<Response>
<?php
	$callbk = '"/recordMessage.php?Receiver=' . $_REQUEST["Digits"] . '"';
?>
	<Gather action=<?php echo $callbk ?>  method="GET" numDigits="1">
		<Say voice="woman">Now choose your target language. Press 
			 1 for Spanish,
			 2 for French,
			 3 for German,
			 4 for Italian,
			 5 for Russian,
			 6 for Swedish,
			 7 for Dutch,
			 8 for Korean, and
			 9 for Mandarin.
		</Say>
	</Gather>
</Response>
