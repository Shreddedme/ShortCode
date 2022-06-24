<?php
$data = file('file.txt')[0];
$data = json_decode($data, true);
var_dump($data);
