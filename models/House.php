<?php
class House extends Db{

    //atributs
    protected $id;
    protected $name;
    protected $points;

    //constantes
    const TABLE_NAME = "House" ;

    //constructor
    public function __construct($name, $points, $id = null){
    
        $this->setId($id);
        $this->setName($name);
        $this->setPoints($points);
    }

    //getters
    public function id(){
        return $this->id;
    }

    public function name(){
        return $this->name;
    }

    public function points(){
        return $this->points;
    }


    //setters
    public function setId($id){
        $this->id = $id;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setPoints($points){
        $this->points = $points;
    }
    //méthodes
    public function save(){

        $data = [
            'name'          => $this->name(),
            'points'        => $this->points(),
        ];

        if($this->id > 0) return $this->update();

        $newId = Db::dbCreate(self::TABLE_NAME, $data);

        $this->setId($newId);

        return $this;
    }

    public function update(){
        if($this->id > 0){
            $data = [
               'id'         => $this->id(),
               'name'      => $this->name(),
               'points'      => $this->points()
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
               
                $objectsList[] = new House($d['name'], $d['points'], $d['id']);
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
                $objectsList[] = new House($d['name'], $d['points'], $d['id']);
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
            
            $house = new House($element['name'], $element['points'], $element['id']);
        
            return $house;
        }

        return $element;
    }

}