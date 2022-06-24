<?php
$oldData = file('file.txt')[0];
$oldData = json_decode($oldData, true);

$newData = [
    [
        'originalURL' => 'google.com',
        'shortCode' => '1232386234',
        'countTransition' => 0,
    ],
    [
        'originalURL' => 'google.com',
        'shortCode' => '1232386234',
        'countTransition' => 0,
    ],
    ];
//$fp = fopen('file.txt', 'a+');

$allData = array_merge($oldData, $newData);
$allData = json_encode($allData);
file_put_contents('file.txt', $allData);

//fclose($fp);
