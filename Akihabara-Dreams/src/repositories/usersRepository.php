<?php
class UsersRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function showUsers() {
        $statement = $this->pdo->prepare('select * from Users');
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($result as $item) {
            $users[] = new User(
                $item['id_user'],
                $item['name'],
                $item['username'],
                $item['password'],
                $item['email'],
                $item['phone'],
                $item['address'],
                $item['profilePic'],
                $item['role']
            );
        }

        return $users;
    }

    public function searchUser($id) {
        $statement = $this->pdo->prepare('select * from Users where id_user = :id_user');
        $statement->execute(['id_user' => $id]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return new User(
            $result['id_user'],
            $result['name'],
            $result['username'],
            $result['password'],
            $result['email'],
            $result['phone'],
            $result['address'],
            $result['profilePic'],
            $result['role']
        );
    }

    public function updateUser(User $user, $newName) {
        $this->pdo->beginTransaction();

        try {
            $statement = $this->pdo->prepare('update Users set name = :name,
                                                                    username = :username,
                                                                    password = :password,
                                                                    email = :email,
                                                                    phone = :phone,
                                                                    address = :address,
                                                                    profilePic = :profilePic,
                                                                    role = :role
                                                    where id_user = :id_user');
            $statement->execute([
                'name' => $user->getName(),
                'username' => $user->getUsername(),
                'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
                'email' => $user->getEmail(),
                'phone' => $user->getPhone(),
                'address' => $user->getAddress(),
                'profilePic' => $newName,
                'role' => $user->getRole(),
                'id_user' => $user->getId()
            ]);
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception('No se ha podido actualizar el usuario');
        }
    }

    public function deleteUser($id) {
        $statement = $this->pdo->prepare('select profilePic from Users where id_user = :id_user');
        $statement->execute(['id_user' => $id]);
        $photo = $statement->fetch(PDO::FETCH_ASSOC);
        $photo = $photo['profilePic'];

        $statement = $this->pdo->prepare('delete from Users where id_user = :id_user');

        $statement->execute(['id_user' => $id]);

        return $photo;
    }

    public function insertUser(User $user, $newName) {
        $this->pdo->beginTransaction();
        try {
            $statement = $this->pdo->prepare('insert into Users(name, username, password, email, phone, address, profilePic, role)
                                                    values (:name, :username, :password, :email, :phone, :address, :profilePic, :role)');
            $statement->execute([
                'name' => $user->getName(),
                'username' => $user->getUsername(),
                'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
                'email' => $user->getEmail(),
                'phone' => $user->getPhone(),
                'address' => $user->getAddress(),
                'profilePic' => $newName,
                'role' => $user->getRole()
            ]);

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception('No se ha podido insertar el usuario');
        }
    }

    public function registerUser(User $user) {
        $this->pdo->beginTransaction();
        try {
            $statement = $this->pdo->prepare('insert into Users(name, username, password, email)
                                                    values (:name, :username, :password, :email)');
            $statement->execute([
                'name' => $user->getName(),
                'username' => $user->getUsername(),
                'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
                'email' => $user->getEmail()
            ]);

            $id = $this->pdo->lastInsertId();
            if (!$id) {
                throw new Exception('No se pudo obtener el ID del nuevo usuario');
            }

            $this->pdo->commit();
            return new User($id, $user->getName(), $user->getUsername(), $user->getPassword(), $user->getEmail(), null, null, 'default.jpg', 'usuario');
        } catch (Exception $e) {
            $this->pdo->rollBack();
        }
    }
}