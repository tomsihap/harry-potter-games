<?php

class HousesController {


    public function index(){
        $houses = House::findAll();
        
        view('maison.index', compact('houses'));
    }
}