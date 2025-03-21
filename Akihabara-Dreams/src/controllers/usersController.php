<?php

class UsersController {
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository) {
        $this->usersRepository = $usersRepository;
    }

    public function validate(User $user) {
        $errors = [];

        // Validaciones formato
        if ($user->getPhone()) {
            if (!preg_match('/^\d{9,10}$/', $user->getPhone())) {
                $errors[] = 'El teléfono no es válido';
            }
        }

        return $errors;
    }

    // Función para insertar un usuario
    public function insertUser(User $user) {
        $errors = [];
        $photo = $_FILES['profilePic'] ?? null;

        // Validaciones
        if (!$user->getName()) {
            $errors[] = 'No has introducido el nombre';
        } else if (strlen($user->getName()) < 3) {
            $errors[] = 'El nombre debe tener como mínimo 3 caracteres';
        }

        if (!$user->getUsername()) {
            $errors[] = 'No has introducido el nombre de usuario';
        }

        if (!$user->getPassword()) {
            $errors[] = 'No has introducido la contraseña';
        } else if (strlen($user->getPassword()) < 8) {
            $errors[] = 'La contraseña debe tener como mínimo 8 caracteres';
        }

        if (!$user->getEmail()) {
            $errors[] = 'No has introducido el correo electrónico';
        } else if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El formato del correo no es válido';
        }

        if (!$user->getAddress()) {
            $errors[] = 'No has introducido la dirección';
        } else if (strlen($user->getAddress()) < 5) {
            $errors[] = 'La dirección debe tener como mínimo 5 caracteres';
        }

        if (!$user->getRole()) {
            $errors[] = 'No has introducido el rol';
        } else if (!in_array($user->getRole(), ['admin', 'usuario'])) {
            $errors[] = 'El rol introducido no es válido';
        }

        $newName = 'default.jpg';

        if ($photo) {
            if ($photo['error'] === UPLOAD_ERR_OK) {
                $rute = '../../resources/images/usuarios/';

                if (!is_dir($rute)) {
                    mkdir($rute, 0777, true);
                }

                $file = pathinfo($photo['name']);
                $extension = strtolower($file['extension']);

                if (in_array($file['extension'], ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'heif', 'heic'])) {
                    $newName = $user->getUsername() . '.' . $extension;
                } else {
                    $errors[] = 'La extensión del archivo no se encuentra entre las válidas';
                }

            } else if ($photo['error'] !== 4) {
                $errors[] = 'Error al subir la foto';
            }
        } else {
            $errors[] = 'No has añadido la foto';
        }

        $aditionalErrors = $this->validate($user);

        if (!empty($aditionalErrors)) {
            foreach ($aditionalErrors as $item) {
                $errors[] = $item;
            }
        }

        if (empty($errors)) {
            //Conectarnos a la base de datos
            if (isset($newName)) {
                $newName = $user->getUsername() . '.' . $file['extension'];
            } else {
                $newName = 'default.jpg';
            }

            $this->usersRepository->insertUser($user, $newName);

            if ($newName !== 'default.jpg') {
                if (!move_uploaded_file($photo['tmp_name'], $rute . $newName)) {
                    throw new Exception('No se ha podido guardar la foto');
                }
            }

            //header("Location: /akihabaraDreams/users");
            //exit;
        } else {
            foreach ($errors as $error) {
                echo $error;
            }
            //include(../src/views/errors.php);
        }

    }

    // Función para actualizar un usuario
    public function updateUser(User $user) {
        $errors = [];
        $photo = $_FILES['profilePic'] ?? null;

        // Validaciones
        if (!$user->getName()) {
            $errors[] = 'No has introducido el nombre';
        } else if (strlen($user->getName()) < 3) {
            $errors[] = 'El nombre debe tener como mínimo 3 caracteres';
        }

        if (!$user->getUsername()) {
            $errors[] = 'No has introducido el nombre de usuario';
        }

        if (!$user->getPassword()) {
            $errors[] = 'No has introducido la contraseña';
        } else if (strlen($user->getPassword()) < 8) {
            $errors[] = 'La contraseña debe tener como mínimo 8 caracteres';
        }

        if (!$user->getEmail()) {
            $errors[] = 'No has introducido el correo electrónico';
        } else if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El formato del correo no es válido';
        }

        if (!$user->getAddress()) {
            $errors[] = 'No has introducido la dirección';
        } else if (strlen($user->getAddress()) < 5) {
            $errors[] = 'La dirección debe tener como mínimo 5 caracteres';
        }

        if (!$user->getRole()) {
            $errors[] = 'No has introducido el rol';
        } else if (!in_array($user->getRole(), ['admin', 'usuario'])) {
            $errors[] = 'El rol introducido no es válido';
        }

        if ($photo) {
            if ($photo['error'] === UPLOAD_ERR_OK) {
                $rute = '../../resources/images/usuarios/';

                if (!is_dir($rute)) {
                    mkdir($rute, 0777, true);
                }

                $file = pathinfo($photo['name']);

                if (in_array($file['extension'], ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'heif', 'heic'])) {
                    $flag = true;
                    $newName = $user->getUsername() . '.' . $file['extension'];
                } else {
                    $errors[] = 'La extensión del archivo no se encuentra entre las válidas';
                }

            } else if ($photo['error'] !== 4) {
                $errors[] = 'Error al subir la foto';
            } else {
                $newName = $user->getProfilePic();
                $flag = false;
            }
        } else {
            $errors[] = 'No has añadido la foto';
        }

        $aditionalErrors = $this->validate($user);

        if (!empty($aditionalErrors)) {
            foreach ($aditionalErrors as $item) {
                $errors[] = $item;
            }
        }

        if (empty($errors)) {
            //Conectarnos a la base de datos
            $this->usersRepository->updateUser($user, $newName);

            if ($flag) {
                if (!move_uploaded_file($photo['tmp_name'], $rute . $newName)) {
                    throw new Exception('No se ha podido guardar la foto');
                }
            }

            //header("Location: /akihabaraDreams/users");
            //exit;
        } else {
            //include(../src/views/errors.php);
        }
    }

    // Función para eliminar un usuario
    public function deleteUser($id) {
        $errors = [];

        // Validaciones
        if (!$id) {
            $errors[] = 'No has introducido el id';
        }

        if ($id < 1) {
            $errors[] = 'El id no puede ser menor a 1';
        }

        if (empty($errors)) {
            $photo = $this->usersRepository->deleteUser($id);
            $rute = '../../resources/images/usuarios/';

            if (file_exists($rute . $photo) && $photo !== 'default.jpg') {
                if (!unlink($rute . $photo)) {
                    throw new Exception('No se ha podido eliminar la foto');
                }
            }

            //header("Location: /akihabaraDreams/users");
            //exit;
        } else {
            //include('../src/views/errors.php');
        }
    }

    // Función para buscar un usuario por su ID
    public function searchUser($id) {
        $errors = [];

        // Validaciones
        if (!$id) {
            $errors[] = 'No has introducido el id';
        }

        if ($id < 1) {
            $errors[] = 'El id no puede ser menor a 1';
        }

        if (empty($errors)) {
            $user = $this->usersRepository->searchUser($id);

            //include('../src/views/account.php');
        } else {
            //include('../src/views/errors.php');
        }
    }

    // Función para mostrar a todos los usuarios registrados en la base de datos
    public function showUsers() {
        $users = $this->usersRepository->showUsers();

        //include('../src/views/showUsers.php');
    }

    // Función para registrar a los usuarios 
    public function register(User $user) {
        $errors = [];

        // Validaciones
        if (!$user->getName()) {
            $errors[] = 'No has introducido el nombre';
        } else if (strlen($user->getName()) < 3) {
            $errors[] = 'El nombre debe tener como mínimo 3 caracteres';
        }

        if (!$user->getUsername()) {
            $errors[] = 'No has introducido el nombre de usuario';
        }

        if (!$user->getPassword()) {
            $errors[] = 'No has introducido la contraseña';
        } else if (strlen($user->getPassword()) < 8) {
            $errors[] = 'La contraseña debe tener como mínimo 8 caracteres';
        }

        if (!$user->getEmail()) {
            $errors[] = 'No has introducido el correo electrónico';
        } else if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El formato del correo no es válido';
        }

        if (empty($errors)) {
            $finalUser = $this->usersRepository->registerUser($user);
            $_SESSION['user'] = serialize($finalUser);

            $_SESSION['cart'] = serialize(new Cart($finalUser->getId()));

            //header("Location: /akihabaraDreams/myAccount");
            //exit;
        } else {
            //include('../src/views/errors.php');
        }
    }
}