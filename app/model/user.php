<?php
class User{
    private $user_id;
    private bool $is_admin;
    private $user_first_name;
    private $user_last_name;
    private $user_profile_picture;
    private $user_email;
    private $user_password;
    private $user_created_at;
    private $user_updated_at;

    public function __construct($user_first_name, $user_last_name, $user_email, $user_password){
        
        $this->user_first_name = $user_first_name;
        $this->user_last_name = $user_last_name;
        $this->user_email = $user_email;
        $this->user_password = $user_password;
    }

    public function getUserId(){
        return $this->user_id;
    }

    public function getIsAdmin(){
        return $this->is_admin;
    }
    public function setIsAdmin($is_admin){
        $this->is_admin = $is_admin;
    }

    public function getUserFirstName(){
        return $this->user_first_name;
    }
    public function setUserFirstName($user_first_name){
        $this->user_first_name = $user_first_name;
    }

    public function getUserLastName(){
        return $this->user_last_name;
    }
    public function setUserLastName($user_last_name){
        $this->user_last_name = $user_last_name;
    }

    public function getUserEmail(){
        return $this->user_email;
    }
    public function setUserEmail($user_email){
        $this->user_email = $user_email;
    }

    public function getUserPassword(){
        return $this->user_password;
    }
    public function setUserPassword($user_password){
        $this->user_password = $user_password;
    }

    public function getUserCreatedAt(){
        return $this->user_created_at;
    }

    public function getUserUpdatedAt(){
        return $this->user_updated_at;
    }
    

}
?>