<?php

include_once('curl_request.php');

$curl = new curl(array('url' => 'path/to/url'));
$result = $curl->init(array(
    'key_1' => 'value_1',
    'key_2' => 'value_2' 
));

echo $result;

?>