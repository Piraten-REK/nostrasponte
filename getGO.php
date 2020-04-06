<?php
$content = file_get_contents('https://wiki.piratenpartei.de/Spezial:Exportieren/NRW:Rhein-Erft-Kreis/Vorstand/Gesch%C3%A4ftsordnung', false, stream_context_create(array(
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
