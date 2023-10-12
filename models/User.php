<?php

namespace Model;

use Model\ActiveRecord;

class User extends ActiveRecord {
    // DB
    protected static $table = 'users';
    protected static $columnsDB = ['id', 'name', 'lastname', 'email', 'phone', 'password', 'admin', 'confirmed', 'token'];

    public $id;
    public $name;
    public $lastname;
    public $email;
    public $phone;
    public $password;
    public $admin;
    public $confirmed;
    public $token;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->lastname = $args['lastname'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->phone = $args['phone'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmed = $args['confirmed'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    //Validation message for creating an account
    public function validateNewAccount() {
        if(!$this->name) {
            self::$alerts['fix'] [] = 'The name is required';
        }
        if(!$this->lastname) {
            self::$alerts['fix'] [] = 'The last name is required';
        }
        if(!$this->email) {
            self::$alerts['fix'] [] = 'The email is required';
        }
        if(!$this->phone) {
            self::$alerts['fix'] [] = 'The number phone is required';
        }
        if(!$this->password) {
            self::$alerts['fix'] [] = 'The password is mandatory';
        }
        if(strlen($this->password) < 6) {
            self::$alerts['fix'] [] = 'The password must have a minimum of 6 characters.';
        }

        return self::$alerts;
    }

    public function validateLogin() {
        if(!$this->email) {
            self::$alerts['fix'][] = 'The email is mandatory';
        }
        if(!$this->password) {
            self::$alerts['fix'][] = 'The password is mandatory';
        }
        
        return self::$alerts;
    }

    public function validateEmail() {
        if(!$this->email) {
            self::$alerts['fix'][] = 'The email is mandatory';
        }
        return self::$alerts;
    }

    public function validatePassword(){
        if(!$this->password) {
            self::$alerts['fix'][] = 'The password is mandatory';
        }
        if(strlen($this->password) < 8) {
            self::$alerts['fix'][] = 'The password must be at least 8 characters long';
        }

        return self::$alerts;
    }

    //Check if the user exists
    public function existsUser() {
        $query = " SELECT * FROM " . self::$table . " WHERE email = '" . $this->email . "' LIMIT 1";

        $result = self::$db->query($query);

        if($result->num_rows) {
            self::$alerts['fix'][] = 'User already registered';
        }
        return $result;
        
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function createToken() {
        $this->token = uniqid();
    } 


    public function checkPasswordAndVerified($password) {
        $result = password_verify($password, $this->password);
        if(!$result || !$this->confirmed) {
            self::$alerts['fix'][] = 'Incorrect password or your account has not been confirmed';
        } else {
            return true;
        }

}

}