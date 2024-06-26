<?php 
namespace Auth;
use database\DataBase;

class Register extends Auth{
    function index(){
        if(!isset($_SESSION['user'])){
        require_once((BASE_PATH) . '/template/auth/register.php');
    }else {
        $this->redirect('home');
    }}
    function store($request){
        if(empty($request['username']) || empty($request['email']) ||empty($request['password']) ){
            flash('error_register','Please fill in all the fields.');
            $this->redirectBack();
        }else if(strlen($request['password'])< 8){
            flash('error_register','Please make the password more than 8 characters.');
            $this->redirectBack();
        } else if(!filter_var($request['email'],FILTER_VALIDATE_EMAIL)){
            $this->redirectBack();
            flash('error_register','Please enter a valid email.');
        }else{
            $db = new DataBase;
            $user= $db->select('SELECT * FROM users WHERE email = ? OR username = ?',[$request['email'],$request['username']] )->fetch();
           if($user != null){
            flash('error_register','This user is already registered.');
            $this->redirectBack();
            
           }else{
            
           $randomToken = $this->random();
           $activationMessage = $this->verifyAccount($request['username'],$randomToken);
           $email= $request['email'];
           $result = $this->sendMail($email,'activate account', $activationMessage);
           if ($result) {
            $request['verify_token'] = $randomToken;
            $request['password']= $this->hash($request['password']);
            $db->insert('users',array_keys($request), array_values($request));
            $this->redirect('login');
           }else{
            $this->redirectBack();
            flash('error_register','The email sending operation was not successful.');
           }
           }
        }
    }
    function activation($token){
        $db= new DataBase;
        $user = $db->select('SELECT * FROM users WHERE verify_token = ? AND is_active=0;',[$token])->fetch();
        if($user==null){
            $this->redirect('login');
        }else{
            $db->update('users',$user['id'],['is_active'],[1]);
            $this->redirect('login');
        }
       

    }
}