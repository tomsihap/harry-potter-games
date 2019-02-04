<?php

class Player extends Db{

    //attribut
    protected $id;
    protected $name;
    protected $attack;
    protected $experience;
    protected $speciality;

    //constantes
    const TABLE_NAME = "Player";

    //constructor
    public function __construct($name, $attack, $experience, $speciality, $id = null){
        $this->setId($id);
        $this->setName($name);
        $this->setAttack($attack);
        $this->setExperience($experience);
        $this->setSpeciality($speciality);
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
    public function experience(){
        return $this->experience;
    }
    public function speciality(){
        return $this->speciality;
    }

    //setters
    public function setId($id){
        $this->id = $id;
    }
    public function  setName($name){
        return $this->name = $name;
    }
    public function setAttack($attack){
        return $this->attack = $attack;
    }
    public function setExperience($experience){
        return $this->experience = $experience;
    }
    public function setSpeciality($speciality){
        return $this->speciality = $speciality;
    }


    //methodes
    public function save(){

        $data = [
            'name'          => $this->name(),
            'attack'        => $this->attack(),
            'experience'    => $this->experience(),
            'speciality'    => $this->speciality(),
        ];

        if($this->id > 0) return $this->update();

        $newId = Db::dbCreate(self::TABLE_NAME, $data);

        $this->setId($newId);

        return $this;
    }

    public function update(){
        if($this->id > 0){
            $data = [
                'id'            => $this->id(),
                'name'          => $this->name(),
                'attack'        => $this->attack(),
                'experience'    => $this->experience(),
                'speciality'    => $this->speciality(),
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
               
                $objectsList[] = new Player ($d['id'], $d['name'], $d['attack'], $d['experience'], $d['speciality']);
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

        $element = $element[0];

        if ($object) { $player = new Player($element['name'], $element['attack'], $element['experience'], $element['speciality']);
        
            return $player;
        }

        return $element;
    }

}
// TODO: 
// adding id_house 