<?php
namespace Model;
class ActiveRecord {

    // DB
    protected static $db;
    protected static $table = '';
    protected static $columnsDB = [];

    // Alerts and Messages
    protected static $alerts = [];
    
    // Define DB connection - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlerts($type, $message) {
        static::$alerts[$type][] = $message;
    }

    // Validation
    public static function getAlerts() {
        return static::$alerts;
    }

    public function validate() {
        static::$alerts = [];
        return static::$alerts;
    }

    // SQL query to create an object in Memory
    public static function querySQL($query) {
        // Consult the database
        $result = self::$db->query($query);

        // Iterate results
        $array = [];
        while($record = $result->fetch_assoc()) {
            $array[] = static::createObject($record);
        }

        // freeing the memory
        $result->free();

        // return results
        return $array;
    }

    // Creates the object in memory that is equal to the one in DB
    protected static function createObject($record) {
        $object = new static;

        foreach($record as $key => $value ) {
            if(property_exists( $object, $key  )) {
                $object->$key = $value;
            }
        }

        return $object;
    }

    // Identify and link DB attributes
    public function attributes() {
        $attributes = [];
        foreach(static::$columnsDB as $column) {
            if($column === 'id') continue;
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    // Sanitize the data before saving them in the DB
    public function sanitizeAttributes() {
        $attributes = $this->attributes();
        $sanitized = [];
        foreach($attributes as $key => $value ) {
            $sanitized[$key] = self::$db->escape_string($value);
        }
        return $sanitized;
    }

    // Synchronize DB with Objects in memory
    public function syncup($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Records - CRUD
    public function save() {
        $result = '';
        if(!is_null($this->id)) {
            // update
            $result = $this->update();
        } else {
            // Creating a new record
            $result = $this->create();
        }
        return $result;
    }

    // All records
    public static function all() {
        $query = "SELECT * FROM " . static::$table;
        $result = self::querySQL($query);
        return $result;
    }

    // Search for a record by its id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$table  ." WHERE id = ${id}";
        $result = self::querySQL($query);
        return array_shift( $result ) ;
    }
    public static function where($column, $value) {
        $query = "SELECT * FROM " . static::$table . " WHERE ${column} = '${value}'";
        $result = self::querySQL($query);
        return array_shift( $result ) ;
    }

// SQL Flat Query (Use when model methods are not sufficient)
    public static function sql($query) {
        $result = self::querySQL($query);
        return $result;
    }


    // Obtain records with a certain quantity
    public static function get($limit) {
        $query = "SELECT * FROM " . static::$table . " LIMIT ${limit}";
        $result = self::querySQL($query);
        return array_shift( $result ) ;
    }

    // create a new record
    public function create() {
        // Sanitize data
        $attributes = $this->sanitizeAttributes();
     
        // Insert in database
        $query = " INSERT INTO " . static::$table . " ( ";
        $query .= join(', ', array_keys($attributes));
        $query .= " ) VALUES (' "; 
        $query .= join("', '", array_values($attributes));
        $query .= " ') ";
        
        // Result of the consultation
        $result = self::$db->query($query);
        return [
            'result' =>  $result,
            'id' => self::$db->insert_id
        ];
    }

    // Update the registry
    public function update() {
        // Sanitize data
        $attributes = $this->sanitizeAttributes();

        // Iterate to add each field in the DB
        $values = [];
        foreach($attributes as $key => $value) {
            $values[] = "{$key}='{$value}'";
        }

        // SQL Query
        $query = "UPDATE " . static::$table ." SET ";
        $query .=  join(', ', $values );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        // Update DB
        $result = self::$db->query($query);
        return $result;
    }

    // 
    public function delete() {
        $query = "DELETE FROM "  . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $result = self::$db->query($query);
        return $result;
    }

}