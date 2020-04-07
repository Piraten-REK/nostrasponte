<?php
if (!isset($_GET['p'])) {
	http_response_code(400);
	die("No page provided");
} elseif ($_GET['p'] !== 'satzung' && $_GET['p'] !== 'go') {
	http_response_code(400);
	die('Invalid input');
}
$wikiPage = $_GET['p'] === 'satzung' ? '/Kreisverband/Satzung' : '/Vorstand/' . urlencode('Geschäftsordnung');
$content = file_get_contents('https://wiki.piratenpartei.de/Spezial:Exportieren/NRW:Rhein-Erft-Kreis' . $wikiPage, false, stream_context_create(array(
	'http' => array(
		'timeout' => 20
	)
)));
if (!$content) {
	$error = error_get_last()['message'];
	http_response_code(502);
	echo substr($error, strrpos($error, ': ') + 2);
} else {
	header('Content-Type: text/xml; charset=utf-8');
	echo $content;
}
