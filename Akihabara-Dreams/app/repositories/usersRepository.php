<?php
class UsersRepository {
    private PDO $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    public function showUsers() {
        $statement = $this->connection->prepare('select * from Users');
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($result as $item) {
            $usuarios[] = new User(
                $item['id_user'],
                $item['name'],
                $item['username'],
                $item['email'],
                $item['address_1'],
                $item['address_2'],
                $item['address_3'],
                $item['phone'],
                $item['profilePic'],
                $item['password'],
                $item['role']
            );
        }

        return $users;
    }

    public function searchUser($id) {
        $statement = $this->connection->prepare('select * from Users where id_user = :id_user');
        $statement->execute(['id_user' => $id]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

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

    public function updateUser(User $user, $newname) {

        $this->connection->beginTransaction();
        try {

            $statement = $this->connection->prepare('update Users set name = :name, 
                                                                                  username = :username,
                                                                                  email = :email,
                                                                                  address_1 = :address_1,
                                                                                  address_2 = :address_2,
                                                                                  address_3 = :address_3,
                                                                                  phone = :phone,
                                                                                  profilePic = :profilePic,
                                                                                  password = :password,
                                                                                  role = :role
                                                                where id_user = :id_user');

            $statement->execute([
                'name' => $user->getName(),
                'username' => $user->getUserName(),
                'email' => $user->getEmail(),
                'address_1' => $user->getAddress1(),
                'address_2' => $user->getAddress2(),
                'address_3' => $user->getAddress3(),
                'phone' => $user->getPhone(),
                'profilePic' => $newname,
                'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
                'role' => $user->getRole(),
                'id_user' => $user->getId()
            ]);

            $this->connection->commit();
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw new Exception('No se ha podido actualizar el usuario');
        }
    }

    public function deleteUser($id) {
        $statement = $this->connection->prepare('select profilePic from Users where id_user = :id_user');
        $statement->execute(['id_user' => $id]);
        $photo = $statement->fetch(PDO::FETCH_ASSOC);
        $photo = $photo['profilePic'];

        $statement = $this->connection->prepare('delete from Users where id_user = :id_user');
        $statement->execute(['id_user' => $id]);

        return $photo;
    }

    public function insertUser(User $user, $newname) {

        $this->connection->beginTransaction();
        try {
            $statement = $this->connection->prepare('insert into Users (name, username, email, address_1, address_2, address_3, phone, profilePic, password, role) 
                                                            values (:name, :username, :email, :address_1, :address_2, :address_3, :phone, :profilePic, :password, :role)');

            $statement->execute([
                'name' => $user->getName(),
                'username' => $user->getUserName(),
                'email' => $user->getEmail(),
                'address_1' => $user->getAddress1(),
                'address_2' => $user->getAddress2(),
                'address_3' => $user->getAddress3(),
                'phone' => $user->getPhone(),
                'profilePic' => $newname,
                'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
                'role' => $user->getRole()
            ]);
            $this->connection->commit();
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw new Exception('No se ha podido insertar el usuario');
        }
    }
    public function registerUser(User $user) {

        try {
            $this->connection->beginTransaction();
            $statement = $this->connection->prepare('insert into Users (name, username, email, password) 
                                                            values (:name, :username, :email, :password)');

            $statement->execute([
                'name' => $user->getName(),
                'username' => $user->getUserName(),
                'email' => $user->getEmail(),
                'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT)
            ]);

            $id = $this->connection->lastInsertId();
            if (!$id) {
                throw new Exception('No se pudo obtener el ID del nuevo usuario');
            }

            $this->connection->commit();
            return new User($id, $user->getName(), $user->getUserName(), $user->getEmail(),null, null, null, null, 'default.jpg',null, 'usuario');
             
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw new Exception('No se ha podido insertar el usuario');
        }
    }
}