<?php
/* TODO:

- faire de la même maniere que idhouse/house les setter/getter player_a player_b 
 */
class Fight extends Db{

    protected $id;
    protected $idPlayerA;
    protected $idPlayerB;
    protected $score;
    protected $isTheWinner;
    protected $playerA;
    protected $playerB;

    const TABLE_NAME = 'Fight';

    public function __construct($score, $is_the_winner, Player $playerA, Player $playerB, $id = null){

        $this->setId($id);
        $this->setScore($score);
        $this->setIsTheWinner($isTheWinner);
        $this->setPlayerA($playerA);
        $this->setPlayerB($playerB);
    }

    public function id() {
        return $this->id;
    }
    public function idPlayerA(){
        return $this->idPlayerA;
    }
    public function idPlayerB(){
        return $this->idPlayerB;
    }
    public function score() {
        return $this->score;
    }
    public function isTheWinner() {
        return $this->isTheWinner;
    }
    public function playerA(){
        if ($this->playerA instanceof Player){
            return $this->playerA;
        }
        $this->playerA = Player::findOne($this->idPlayerA);
        return $this->playerA;
    }
    public function playerB(){
        if ($this->playerB instanceof Player){
            return $this->playerB;
        }
        $this->playerB = Player::findOne($this->idPlayerB);
        return $this->playerB;
    }



    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function setIdPlayerA($idPlayerA){
        $this->idPlayerA = $idPlayerA;
        return $this;
    }
    public function setIdPlayerB($idPlayerB){
        $this->idPlayerB = $idPlayerB;
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
    public function setPlayerA(Player $playerA){
        $this->idPlayerA = $playerA->id();
        $this->playerA = $playerA;
        return $this;
    }
    public function setPlayerB(Player $playerB){
        $this->idPlayerB = $playerB->id();
        $this->playerB = $playerB;
        return $this;
    }

    //methodes
    public function save(){

        $data = [
            'id_player_a'          => $this->idPlayerA(),
            'id_player_b'          => $this->idPlayerB(),
            'score'                => $this->score(),
            'is_the_winner'        => $this->isTheWinner(),
        ];

        if($this->id > 0) return $this->update();

        $newId = Db::dbCreate(self::TABLE_NAME, $data);

        $this->setId($newId);

        return $this;
    }

    private function update(){
        if($this->id > 0){
            $data = [
                'id'                   => $this->id(),
                'id_player_a'          => $this->idPlayerA(),
                'id_player_b'          => $this->idPlayerB(),
                'score'                => $this->score(),
                'is_the_winner'        => $this->isTheWinner(),
            ];

            Db::dbUpdate(self::TABLE_NAME, $data);
            return $this;
        }
        return;
    }
    public function delete(){
        $data = [
            'id' => $this->id(),
        ];
        Db::dbDelete(self::TABLE_NAME, $data);
        return;
    }

    public static function findAll($objects = true) {
        $data = Db::dbFind(self::TABLE_NAME);
        
        if($objects){
            $objectsList = [];
            foreach ($data as $d) {
               
                $playerA = Player::findOne($d['id_player_a']);
                $playerB = Player::findOne($d['id_player_b']);

                $objectsList[] = new Fight ($d['score'], $d['is_the_winner'], $playerA, $playerB, $d['id']);
            }
            return $objectsList;
        }

        return $data;
    }
    public static function find(array $request, $objects = true) {
        $data = Db::dbFind(self::TABLE_NAME, $request);

        if ($objects) {
            $objectsList = [];

            foreach ($data as $d) {
                $playerA = Player::findOne($d['id_player_a']);
                $playerB = Player::findOne($d['id_player_b']);

                $objectsList[] = new Fight ($d['score'], $d['is_the_winner'], $playerA, $playerB, $d['id']);
            }
            return $objectsList;
        }

        return $data;
    }
    public static function findOne(int $id, bool $object = true) {

        $request = [
            ['id', '=', $id]
        ];

        $element = Db::dbFind(self::TABLE_NAME, $request);

        if (count($element) > 0) $element = $element[0];
        else return;

        if ($object) {
            $playerA = Player::findOne($d['id_player_a']);
            $playerB = Player::findOne($d['id_player_b']);

            $fight = new Fight($element['score'], $element['is_the_winner'], $playerA, $playerB, $element['id']);
        
            return $player;
        }

        return $element;
    }


    // On présume que PlayerA commence le combat
    public static function combat(Player $playerA, Player $playerB) {

        $i = 0;
        while ($playerA->defense() > 0 && $playerB->defense() > 0) {

            if ($playerB->defense() > 0) {
                $playerB->frapper($playerA);
            }

            if ($playerA->defense() > 0) {
                $playerA->frapper($playerB);
            }


            echo "Tour " . $i;

            echo "<br>";
            

            echo "PlayerA - bouclier : " . $playerA->bouclier() . ", défense: " . $playerA->defense() . ', attaque rand: ' . $playerA->attackRand();
            echo "<br>";
            echo "PlayerB - bouclier : " . $playerB->bouclier() . ", défense: " . $playerB->defense() . ', attaque rand: ' . $playerB->attackRand();
            echo "<hr>";

            $i++;
        }

        // Cas où B à gagné
        if($playerA->defense() == 0) {
            $playerB->gagnerExperience();
            return $playerB;
        }

        // Cas où A à gagné
        else {
            $playerA->gagnerExperience();
            return $playerA;
        }
    }









}