<?php

namespace watrlabs;

class authentication {

    private $db = null;
    private $sessionName = null;
    private $currentSession = null;

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

    public function getUserInfo($User, $Multiple){

        $useId = false;
        $query = null;

        if(is_int($User)){
            $useId = True;
        }

        if($useId){
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

    public function hasAccount() {
        return (bool) $this->currentSession;
    }

}