<?php
$router = new Router();


$router->get('/joueur', 'PlayersController@index');
$router->get('/maison', 'HousesController@index');

$router->run();