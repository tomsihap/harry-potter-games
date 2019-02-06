<?php

class Player extends Db{

    //attribut
    protected $id;
    protected $name;
    protected $attack;
    protected $defense;
    protected $experience;
    protected $speciality;
    protected $bouclier;
    protected $idHouse;
    protected $house;

    //constantes
    const TABLE_NAME = "Player";

    //constructor
    public function __construct($name, $attack, $defense, $experience, $speciality, House $house,  $id = null, $bouclier = 100){
        
        $this->setName($name);
        $this->setAttack($attack);
        $this->setDefense($defense);
        $this->setExperience($experience);
        $this->setSpeciality($speciality);
        $this->setBouclier($bouclier);
        $this-> setHouse($house);
        $this->setId($id);
    }
        
    //getters
    public function id() {
        return $this->id;
    }
    public function name(){
        return $this->name;
    }
    public function attack(){
        return $this->attack;
    }
    public function defense(){
        return $this->defense;
    }
    public function experience(){
        return $this->experience;
    }
    public function speciality(){
        return $this->speciality;
    }
    public function bouclier(){
        return $this->bouclier;
    }
    public function house(){
        if ($this->house instanceof House){
            return $this->house;
        }
        $this->house = House::findOne($this->idHouse);
        return $this->house;
        
    }
    public function idHouse(){
        return $this->idHouse;
    }


    //setters
    public function setId($id){
        $this->id = $id;
    }
    public function setName($name){
        return $this->name = $name;
    }
    public function setAttack($attack){
        return $this->attack = $attack;
    }
    public function setDefense($defense){
        return $this->defense = $defense;
    }
    public function setExperience($experience){
        return $this->experience = $experience;
    }
    public function setSpeciality($speciality){
        return $this->speciality = $speciality;
    }
    public function setBouclier($bouclier){

        $this->bouclier = $bouclier;

         if($this->bouclier <= 0 ){
            $this->bouclier = 0;
            //trigger_error('bouclier est foutu');
        } 
        return $this;
    }
    public function setHouse(House $house){
        $this->idHouse = $house->id();
        $this->house = $house;
        return $this;
    }


    //methodes
    public function save(){

        $data = [
            'name'          => $this->name(),
            'attack'        => $this->attack(),
            'defense'       => $this->defense(),
            'experience'    => $this->experience(),
            'speciality'    => $this->speciality(),
            'bouclier'      => $this->bouclier(),
            'id_house'      => $this->idHouse(),
        ];

        if($this->id > 0) return $this->update();

        $newId = Db::dbCreate(self::TABLE_NAME, $data);

        $this->setId($newId);

        return $this;
    }

    private function update(){
        if($this->id > 0){
            $data = [
                'id'            => $this->id(),
                'name'          => $this->name(),
                'attack'        => $this->attack(),
                'defense'       => $this->defense(),
                'experience'    => $this->experience(),
                'speciality'    => $this->speciality(),
                'bouclier'      => $this->bouclier(),
                'id_house'      => $this->idHouse(),
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
               
                $house = House::findOne($d['id_house']);

                $objectsList[] = new Player ($d['name'], $d['attack'], $d['defense'], $d['experience'], $d['speciality'], $house, $d['id'], $d['bouclier']);
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
                $objectsList[] = new Player ($d['name'], $d['attack'], $d['defense'], $d['experience'], $d['speciality'], $house, $d['id'], $d['bouclier']);
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
            $house = House::findOne($d['id_house']);

            $player = new Player($element['name'], $element['attack'], $element['defense'], $element['experience'], $element['speciality'], $element['bouclier'],$house, $element['id']);
        
            return $player;
        }

        return $element;
    }

     public function frapper($persoAFrapper){

    $resteBouclier = $persoAFrapper->bouclier- $this->attack * 2;

        if($persoAFrapper->bouclier >= 0){
            // Si j'ai un bouclier, je déduis les dégats de bouclier
            $persoAFrapper->setBouclier($resteBouclier);            
        }
        else {

            // Sinon, je déduis tous les dégats dans la défense
            $persoAFrapper->defense -= $this->attack;
        }
        // Je déduis les restes de dégats qui dépassent du bouclier s'il a été détruit
        // ( => bouclier < 0)
        if ($resteBouclier < 0) { 
            $persoAFrapper->defense += $resteBouclier/2;
        }

        $persoAFrapper->save();

        return $this;
    } 
    






}