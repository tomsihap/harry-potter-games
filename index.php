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





 
// player 1
$nom = 'Luna Lovegood';
$attack = 12;
$defense = 100;
$experience = 10;
$speciality = 'toujours à la recherche de nargles';
$bouclier = 100;

// player 2
$anom = 'Thomas Chose';
$aattack = 11;
$adefense = 100;
$aexperience = 10;
$aspeciality = 'toujours à la recherche de nargles';
$abouclier = 100;

$house = House::findOne(8);


$player = new Player ($nom, $attack, $defense, $experience, $speciality, $house, $bouclier);
$player2 = new Player ($anom, $aattack, $adefense, $aexperience, $aspeciality, $house, $abouclier);

$gagnant = Fight::combat($player, $player2);

echo "Gagnant :<br>";
var_dump($gagnant);

/* 
echo 'Player 2 avant combat';
var_dump($player2);  */

/* echo $player->name();
echo "<br>";
echo $player->house()->name(); */

/* $player->save();  */

/* var_dump($player->gagnerExperience());   */
/* $combat = $player->frapper($player2);   */

/* 
echo 'player 2 après attaque n1';
var_dump($player2);

echo 'Player 2 après attaque n2';
$combat2 = $player->frapper($player2);
var_dump($player2);

echo 'Player 2 après attaque n3';
$combat3 = $player->frapper($player2);
var_dump($player2);

echo 'Player 2 après attaque n4';
$combat4 = $player->frapper($player2);
var_dump($player2);

echo 'Player 2 après attaque n5';
$combat5 = $player->frapper($player2);
var_dump($player2);

echo 'Player 2 après attaque n6';
$combat6 = $player->frapper($player2);
var_dump($player2);
 */