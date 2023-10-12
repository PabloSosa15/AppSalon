<?php

namespace Model;

class AdminAppointment extends ActiveRecord {
    protected static $table = 'appointmentServices';
    protected static $columnsDB = ['id', 'hour', 'client', 'email', 'phone', 'service', 'price'];

    public $id;
    public $hour;
    public $client;
    public $email;
    public $phone;
    public $service;
    public $price;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->hour = $args['hour'] ?? '';
        $this->client = $args['client'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->phone = $args['phone'] ?? '';
        $this->service = $args['service'] ?? '';
        $this->price = $args['price'] ?? '';
    }
}