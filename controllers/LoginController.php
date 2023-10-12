<?php
namespace Controllers;

use Model\User;
use MVC\Router;
use Classes\Email;
class LoginController {
    public static function login(Router $router) {
        $alerts = [];


        if($_SERVER['REQUEST_METHOD'] === 'POST'){
           $auth = new User($_POST);
           $alerts = $auth->validateLogin();

           if(empty($alerts)){
            // Check that the user exists
                $user = User::where('email', $auth->email);

                if($user) {
                //Check  the password
                    if($user->checkPasswordAndVerified($auth->password)) {
                        session_start();

                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name . " " . $user->lastname;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['login'] = true;

                        // Redirect

                        if($user->admin === '1') {
                            $_SESSION['admin'] = $user->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /appointment');
                        }
                    }
                } else {
                    User::setAlerts('fix', 'User not found');
                }
           }
        }
        $alerts = User::getAlerts();

        $router->render('auth/login', [
            'alerts' => $alerts
        ]);
    }
    public static function logout() {
        session_start();  
        $_SESSION = [];
        header('Location: /');
    }
    public static function forget(Router $router) {
        $alerts = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new User($_POST);
            $alerts = $auth->validateEmail();

            if (empty($alerts)) {
                $user = User::where('email', $auth->email);

                if($user && $user->confirmed === '1') {
                    //Generate a token
                    $user->createToken();
                    $user->save();


                    //TODO: Send the email
                    $email = new Email($user->email, $user->name, $user->token);
                    $email->sendInstruction();
                    //Success alert
                    User::setAlerts('success', 'Check your email');
                } else {
                    user::setAlerts('fix', 'The user does not exist or is not confirmed');
                }
            }
        }

        $alerts = User::getAlerts();

        $router->render('auth/forgot-password', [
            'alerts'=>$alerts
        ]);
    }
    public static function recover(Router $router) {
        $alerts = [];
        $fix = false;

        $token = s($_GET['token']);

        //Search user by token
        $user = User::where('token', $token);

        if (empty($user)) {
            user::setAlerts('fix', 'Token not valid');
            $fix = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
           //Read the new password and save it 

            $password = new User($_POST);
            $alerts = $password->validatePassword();

            if(empty($alerts)) {
                $user->password = null;

                $user->password = $password->password;
                $user->hashPassword();
                $user->token = null;

                $result = $user->save();

                if($result) {
                    header('Location: /');
                }

            }
        }
        ;

        $alerts = User::getAlerts();
        $router->render('auth/password-recover', [
            'alerts'=>$alerts,
            'fixs'=>$fix
        ]);
    }
    public static function create(router $router) {
        $user = new User($_POST);

        //Empty alerts
        $alerts = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->syncup($_POST);
            $alerts = $user->validateNewAccount();
            
        //Check which alerts are empty
        if(empty($alerts)) {
            //Verify that the user is not previously registered
                $result = $user->existsUser();
                if($result->num_rows) {
                    $alerts = User::getAlerts();
                } else {
                    //hashing a password
                    $user->hashPassword();

                    //Generate a unique token
                    $user->createToken();

                    //Send the email
                    $email = new Email(
                $user->name,
                $user->email,
                $user->token);
                }
                $email->sendConfirmation();

                //Create the user
                $result = $user->save();
                if($result) {
                    header('Location: /message');
                }
            ;
        }
        }
        $router->render('auth/create-account', [
            'user'=>$user,
            'alerts'=>$alerts
        ]);
    }
    public static function message(Router $router) {
        $router->render('auth/message');
    }

    public static function confirmate(Router $router) {
        $alerts = [];
        $token = s($_GET['token']);
        $user  = User::where('token', $token);

        if(empty($user) || $user->token === '') {
            //Show error message
            User::setAlerts('fix', 'Invalid Token');
        } else {
            //Modify to confirmed user
            $user->confirmed = '1';
            $user->token = null;
            $user->save();
            User::setAlerts('success', 'Account Properly Verified');
        }

        $alerts = User::getAlerts();
        $router->render('auth/confirm-account', [
            'alerts' => $alerts

        ]);
    }
}