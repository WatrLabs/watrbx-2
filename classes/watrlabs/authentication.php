<?php

namespace watrlabs;

class authentication {

    private $db = null;
    private $sessionName = null;
    private $currentSession = null;

    // inits the class
    // also will return user data depending on if a userid was provided
    function __construct($id = null) {
        global $db;

        $this->db = $db;
        $this->sessionName = $_ENV["COOKIE_NAME"];
        
        if(isset($_COOKIE[$this->sessionName])){
            $this->currentSession = $this->db->table("sessions")->where("session", $this->currentSession)->first();
        }

        if($id){

        }
    }

    // returns user data straight from the database if a userid or username is provided
    public function getUserInfo($User, $Multiple){

        $query = null;

        if(is_int($User)){
            $query = $this->db->table("users")->where("id", $id);
        } else {
            $query = $this->db->table("users")->where("username", $User);
        }

        if($query && $Multiple){
            return $query->get();
        } else {
            return $query->first();
        }
    }

    // checks if the user is currently authenticated and has a session
    public function hasAccount() {
        return (bool) $this->currentSession;
    }

}