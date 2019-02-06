<?php
$router = new Router();


$router->get('/joueur', 'PlayersController@index');

$router->run();