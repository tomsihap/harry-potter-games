<?php
class House extends Db{

    //atributs
    protected $id;
    protected $name;
    protected $point;

    //constantes
    const TABLE_NAME = "House" ;

    //constructor
    public function __construct($name, $point, $id = null){
    
        $this->setId($id);
        $this->setName($name);
        $this->setPoint($point);
    }

    //getters
    public function id(){
        $this->$id;
    }

    public function name(){
        return $this->name;
    }

    public function point(){
        return $this->point;
    }


    //setters
    public function setId($id){
        $this->id = $id;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setPoint($point){
        $this->point = $point;
    }
    //méthodes
    public function save(){

        $data = [
            'name'          => $this->name(),
            'point'        => $this->point(),
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
               'point'      => $this->point()
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
               
                $objectsList[] = new House($d['id'], $d['name'], $d['point']);
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

        if ($object) { $player = new House($element['name'], $element['point']);
        
            return $player;
        }

        return $element;
    }

}