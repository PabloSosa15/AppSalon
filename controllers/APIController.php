<?php

namespace Controllers;

use Model\Service;
use Model\Appointment;
use Model\AppointmentService;

class APIController {
    public static function index() {
        $services = Service::all();
        echo json_encode($services);
    }

    public static function save() {
        //Stores the appointment and returns the ID
        $appointment = new Appointment($_POST);
        $result = $appointment->save();

        $id = $result['id'];

        //Stores the appointments and service
        
        // Stores the services with the appointment ID
        $idServices = explode(",", $_POST['services']);
        foreach($idServices as $idService) {
            $args = [
                'appointmentId' => $id,
                'servicesId' => $idService
            ];
            $appointmentService = new AppointmentService($args);
            $appointmentService->save();
        }

        echo json_encode(['result'=>$result]);
    }
    public static function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            ; {
            $id = $_POST['id'];

            if(filter_var($id, FILTER_VALIDATE_INT)) {
                $appointment = Appointment::find($id);
            }

            if($appointment) {
                $appointment->delete();
            }

            header('Location:' . $_SERVER['HTTP_REFERER']);
            }

    }
}