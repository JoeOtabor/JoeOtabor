<?php

namespace App\Controllers;

use App\Models\User;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Register extends \Core\Controller
{
    public function register(){
        $data = $this->validate($_POST);
        if($this->validateRegisterData($data)['flag']){
//            echo '<pre>';print_r($data);exit;
            $name = $data['name'];
            $email = $data['email'];
            $password = password_hash(base64_encode($data['password']),PASSWORD_DEFAULT);
            $username = $this->username($data['email'])."_".rand(1,9999);
            $verify_token = base64_encode($username.time());
            $status =0;
            $query = "INSERT INTO users (name, email, username, password, status, verify_token)
                      VALUES('$name','$email','$username','$password','$status','$verify_token')";
            $register = User::save($query);
            if($register){
                $_SESSION['success'] = 'Your account was created successfully please verify your email.';
                return $_SESSION['success'];
            }
        }

        $_SESSION['errors'] = $this->validateRegisterData($data);
        return $this->validateRegisterData($data);
    }

    public function username($email){
        $pos = strpos($email,'@');
        $username = str_split($email,$pos);
        return $username[0];
    }

    public function validateRegisterData($data){
        $flag = true;
        $errorMessage = [];
        if(empty($data['name'])){
            $flag = false;
            $errorMessage[]="Name is required";
        }
        if(strlen($data['name'])<4){
            $flag = false;
            $errorMessage[]="Name must be longer than three character";
        }
        if (!preg_match("/^[a-zA-Z ]*$/",$data['name'])) {
            $errorMessage[] = "Only letters and white space allowed on name";
        }
        if(empty($data['email'])){
            $flag = false;
            $errorMessage[]="Email is required";
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $flag = false;
            $errorMessage[] = "Invalid email format";
        }
        if(empty($data['password'])){
            $flag = false;
            $errorMessage[] = "Password required";
        }
        if(strlen($data['password'])<8){
            $flag = false;
            $errorMessage[] = "Password need to be grater than eight character";
        }
        if($data['password']!=$data['confirm_password']){
            $flag = false;
            $errorMessage[] = "Password and confirm password didn't match";
        }
        return [
            'flag' => $flag,
            'message' => $errorMessage
        ];
    }
}
