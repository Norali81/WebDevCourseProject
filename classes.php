<?php
require_once('functions.php');

// the only, lonely class of this project. 
// We decided that classes are really not needed, but wanted to use at least one
// just to give it a try

class User {
    
    // variables
    private $username;
    private $role;
    private $userData;
    private $userDataJson;
    
    // function to get all the userdata
    function getUserData() {
        return $this->userData;
    }

    // function to get user data in JSON format
    function getUserDataJson() {
        return $this->userDataJson;
    }

    // setters 
    function setUserData($userData) {
        $this->userData = $userData;
    }

    function setUserDataJson($userDataJson) {
        $this->userDataJson = $userDataJson;
    }

    // Constructor   
    function __construct($username, $dbConnect) {
        $this->username = $username;
        $this->role = getUserRole($dbConnect, $username);
        // using a function to get data from the database. Was thinking to reuse this function but ended up not to
        $this->userData = getDataByComperator($dbConnect, "user", "username", $username);
        // json encode data
        $this->userDataJson = json_encode($this->userData);
    }

    // getters
    function getUserDetails() {
        
    }
    
    function getUsername() {
        return $this->username;
    }

    function getRole() {
        return $this->role;
    }

    // more setters
    function setUsername($username) {
        $this->username = $username;
    }

    function setRole($role) {
        $this->role = $role;
    }
}