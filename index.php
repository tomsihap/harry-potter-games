<?php

require __DIR__ . '/vendor/autoload.php';


spl_autoload_register (function ($class) {
    $sources = array_map(function($s) use ($class) {
        return $s . '/' . $class . '.php';
    },
    CLASSES_SOURCES);
    
    foreach ($sources as $source) {
        if (file_exists($source)) {
            require_once $source;
        } 
    } 
});


require 'config/app.php';
require 'config/database.php';
require 'config/helpers.php';
require 'config/Db.php';
require 'config/routes.php';

/* $nom = 'Harry Potter';
$attack = 80;
$experience = 10;
$speciality = 'patronus';

$player = new Player ($nom, $attack, $experience, $speciality);
$player->save(); */

$name = "gryffindor";
$point = 0;

$house = New House ($name, $point);
$house->save();
