<?php

class Fight extends Db{

    protected $id;
    protected $score;
    protected $isTheWinner;

    const TABLE_NAME = 'Fight';

    public function __construct($score, $is_the_winner = true, $id = null){

    }

    public function id() {
        return $this->id;
    }
    public function score() {
        return $this->score;
    }
    public function isTheWinner() {
        return $this->isTheWinner;
    }

    public function setId() {
        $this->id = $id;
        return $this;
        
    }
    public function setScore() {
        $this->score = $score;
        return $this;
    }
    public function setIsTheWinner() {
        $this->isTheWinner = $isTheWinner;
        return $this;
    }



    public function gagnerExperience(){
        $this->experience = $this->experience +10;
        return $this;
     }


}