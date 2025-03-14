<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $id_user;
    private $name;
    private $username;
    private $password;
    private $email;
    private $phone;
    private $address;
    private $profilePic;
    private $role;

    public function __construct($id_user, $name, $username, $password, $email, $phone, $address, $profilePic, $role) {
        $this->id_user = $id_user;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->profilePic = $profilePic;
        $this->role = $role;
    }

    public function getId() {
        return $this->id_user;
    }

    public function getName() {
        return $this->name;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getProfilePic() {
        return $this->profilePic;
    }

    public function getRole() {
        return $this->role;
    }
}