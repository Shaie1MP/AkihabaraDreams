<?php
class AuthRepository {
    private $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    public function searchUser($user) {
        $statement = $this->connection->prepare('select * from Users where username = :username');
        $statement->execute(['username' => $user]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$result || empty($result)) {
            throw new Exception('Usuario no encontrado');
        }

        return new User(
            $result['id_user'],
            $result['name'],
            $result['username'],
            $result['email'],
            $result['address_1'],
            $result['address_2'],
            $result['address_3'],
            $result['phone'],
            $result['profilePic'],
            $result['password'],
            $result['role']
        );
    }
}
