<?php

include_once('hyper_table.php');

$curl = new hyper_table(array('url' => 'path/to/url'));
$result = $curl->init(array(
    'key_1' => 'value_1',
    'key_2' => 'value_2' 
));

echo $result;

?>