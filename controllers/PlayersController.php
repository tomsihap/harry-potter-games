<?php

class PlayersController {


    public function index(){
        $players = Player::findAll();
        
        view('joueur.index', compact('players'));
    }
}