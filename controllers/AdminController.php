<?php

namespace Controllers;

use Model\AdminAppointment;
use MVC\Router;


class AdminController {
    public static function index( Router $router) {

        isAdmin();

        $date = $_GET['date'] ?? $date = date('Y-m-d');
        $dates = explode('-', $date);
        if(!checkdate($dates[1], $dates[2], $dates[0])) {
            header('Location: /404');
        }

        //Query DB
        $query = "SELECT appointment.id, appointment.hour, CONCAT( users.name, ' ', users.lastname) as client, ";
        $query .= " users.email, users.phone, services.name as service, services.price  ";
        $query .= " FROM appointment  ";
        $query .= " LEFT OUTER JOIN users ";
        $query .= " ON appointment.userId=users.id  ";
        $query .= " LEFT OUTER JOIN appointmentservices ";
        $query .= " ON appointmentservices.appointmentId=appointment.id ";
        $query .= " LEFT OUTER JOIN services ";
        $query .= " ON services.id=appointmentservices.servicesId ";
        $query .= " WHERE date =  '${date}' ";

        $appointments = AdminAppointment::sql($query);

        $router->render('admin/index', [
            'name' => $_SESSION['name'],
            'appointments' => $appointments,
            'date' => $date,

        ]);
    }
}