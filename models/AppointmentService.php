<?php

namespace Model;

class AppointmentService extends ActiveRecord {
    protected static $table = 'appointmentservices';
    protected static $columnsDB = ['id', 'servicesId', 'appointmentId' ];

    public $id;

    public $servicesId;
    public $appointmentId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->servicesId = $args['servicesId'] ?? '';
        $this->appointmentId = $args['appointmentId'] ?? '';
    }

}