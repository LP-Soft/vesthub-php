<?php

namespace Classes;

class User {
    public $userID;       // Auto-incremented by the database
    public $name;
    public $surname;
    public $email;
    public $phone;
    public $password;
    public $city;
    public $isActive;
    public $district;
    public $neighborhood;
    public $street;

    public function __construct($postData) {
        // Basic user info setup
        $this->name = $postData['name'] ?? '';
        $this->surname = $postData['surname'] ?? '';
        $this->email = $postData['email'] ?? '';
        $this->phone = $postData['phone'] ?? '';
        
        // Hash the password for secure storage
        $this->password = isset($postData['password']) ? password_hash($postData['password'], PASSWORD_DEFAULT) : '';
        
        // Address and status details
        $this->city = $postData['city'] ?? '';
        $this->isActive = isset($postData['isActive']) ? (bool)$postData['isActive'] : false;
        $this->district = $postData['district'] ?? '';
        $this->neighborhood = $postData['neighborhood'] ?? '';
        $this->street = $postData['street'] ?? '';
    }
    
    // Method to set userID after database insertion (optional)
    public function setUserID($userID) {
        $this->userID = $userID;
    }
}
