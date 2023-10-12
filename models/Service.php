<?php
namespace Model;

class Service extends ActiveRecord {
    // DB
    protected static $table = 'services';
    protected static $columnsDB = ['id', 'name', 'price'];

    public $id;
    public $name;
    public $price;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->price = $args['price'] ?? 0;
    }

    public function validate(){
        if(!$this->name) {
            self::$alerts['fix'][]= 'The Name is Mandatory';
        }
        if(!$this->price) {
            self::$alerts['fix'][]= 'The Price is Mandatory';
        }
        if(!is_numeric($this->price)) {
            self::$alerts['fix'][] = 'The Price is not validate';
        }
        return self::$alerts;

    }
}