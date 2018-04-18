<?php

$ob    = simplexml_load_file('testXML2.xml');
$json  = json_encode($ob);
$array = json_decode($json, true);

echo "<pre>";
print_r($array);
echo "</pre>";

?>