<?php 

class User {
    private $id_user;
    private $name;
    private $username;
    private $email;
    private $address1;
    private $address2;
    private $address3;
    private $phone;
    private $profilePic;
    private $password;
    private $role;

    public function __construct($id_user, $name, $username, $email, $address1, $address2, $address3, $phone, $profilePic, $password, $role)
    {
        $this->id_user = $id_user;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->address3 = $address3;
        $this->phone = $phone;
        $this->profilePic = $profilePic;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId() {
        return $this->id_user;
    }

    public function getName() {
        return $this->name;
    }

    public function getUserName() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getAddress1() {
        return $this->address1;
    }

    public function getAddress2() {
        return $this->address2;
    }

    public function getAddress3() {
        return $this->address3;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getProfilePic() {
        return $this->profilePic;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRole() {
        return $this->role;
    }

    // Función para obtener un array con las 3 direcciones que introduce el usuario
    public function getAddresses(): array {
        return [$this->getAddress1(), $this->getAddress2(), $this->getAddress3()];
    }

}
