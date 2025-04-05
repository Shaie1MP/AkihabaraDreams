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

        if ($user->getAddress2()) {
            if (strlen($user->getAddress2()) < 5) {
                $errors[] = 'La dirección debe tener como mínimo 5 caracteres';
            }
        }

        if ($user->getAddress3()) {
            if (strlen($user->getAddress3()) < 5) {
                $errors[] = 'La dirección debe tener como mínimo 5 caracteres';
            }
        }

        return $errors;
    }

    // Funcion para insertar un usuario
    public function insertUser(User $user) {
        $errors = [];
        $photo = $_FILES['profilePic'] ?? null;

        // Validaciones
        if (!$user->getName()) {
            $errors[] = 'No has introducido el nombre';
        }

        if (strlen($user->getName()) < 3) {
            $errors[] = 'El nombre debe tener como mínimo 3 caracteres';
        }

        if (!$user->getUserName()) {
            $errors[] = 'No has introducido el nombre de usuario';
        }

        if (!$user->getEmail()) {
            $errors[] = 'No has introducido el correo electrónico';
        } else if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El formato del correo no es válido';
        }

        if (!$user->getAddress1()) {
            $errors[] = 'No has introducido la dirección';
        }

        if (!$user->getPassword()) {
            $errors[] = 'No has introducido la contraseña';
        }

        if (strlen($user->getPassword()) < 8) {
            $errors[] = 'La contraseña debe tener como mínimo 8 caracteres';
        }

        if (!$user->getRole()) {
            $errors[] = 'No has introducido el rol';
        } else if (!in_array($user->getRole(), ['admin', 'usuario'])) {
            $errors[] = 'El rol introducido no es válido';
        }

        if ($photo) {
            if ($photo['error'] === UPLOAD_ERR_OK) {
                $route = BASE_PATH . '/resources/images/usuarios/';
                $route = str_replace('\\', '/', $route);

                if (!is_dir($route)) {
                    mkdir($route, 0777, true);
                }

                $archivo = pathinfo($photo['name']);

                if (in_array($archivo['extension'], ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'heif', 'heic'])) {

                } else {
                    $errors[] = 'La extensión de la foto no se encuentra entre las válidas';
                }

            } else if ($photo['error'] !== 4) {
                $errors[] = 'La foto se ha subido incorrectamente';
            }
        } else {
            $errors[] = 'No has añadido la foto';
        }


        $additionalErrors = $this->validate($user);

        if (!empty($additionalErrors)) {
            foreach ($additionalErrors as $item) {
                $errors[] = $item;
            }
        }

        if (empty($errors)) {
            // Conectarnos a la base de datos
            if (isset($newName)) {
                $newName = $user->getUserName() . '.' . $archivo['extension'];
            } else {
                $newName = 'default.jpg';
            }
            $this->usersRepository->insertUser($user, $newName);

            if ($newName !== 'default.jpg') {
                if (!move_uploaded_file($photo['tmp_name'], $route . $newName)) {
                    throw new Exception('No se ha podido guardar la foto');
                }
            }

            header("Location: /Akihabara-Dreams/usuarios");
            exit;

        } else {
            include('../app/views/errores.php');
        }
    }

    // Funcion para actualizar un usuario
    public function updateUser(User $user) {
        $errors = [];
        $photo = $_FILES['profilePic'] ?? null;

        // Validaciones
        if (!$user->getId()) {
            $errors[] = 'El ID de usuario no se encuentra en la base de datos';
        }

        if ($user->getId() < 1) {
            $errors[] = 'El ID de usuario no puede ser menor a 1';
        }

        if (!$user->getName()) {
            $errors[] = 'No has introducido el nombre';
        }

        if (strlen($user->getName()) < 3) {
            $errors[] = 'El nombre debe tener como mínimo 3 caracteres';
        }

        if (!$user->getUserName()) {
            $errors[] = 'No has introducido el nombre de usuario';
        }

        if (!$user->getEmail()) {
            $errors[] = 'No has introducido el correo electrónico';
        } else if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El formato del correo no es válido';
        }

        if (!$user->getAddress1()) {
            $errors[] = 'No has introducido la dirección';
        }

        if (!$user->getPassword()) {
            $errors[] = 'No has introducido la contraseña';
        }

        if (strlen($user->getPassword()) < 8) {
            $errors[] = 'La contraseña debe tener como mínimo 8 caracteres';
        }

        if (!$user->getRole()) {
            $errors[] = 'No has introducido el rol';
        }

        if ($photo) {
            if ($photo['error'] === UPLOAD_ERR_OK) {
                $route = BASE_PATH . '/resources/images/usuarios/';
                $route = str_replace('\\', '/', $route);

                if (!is_dir($route)) {
                    mkdir($route, 0777, true);
                }

                $file = pathinfo($photo['name']);

                if (in_array($file['extension'], ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'heif', 'heic'])) {
                    $flag = true;
                    $newname = $user->getUserName() . '.' . $file['extension'];
                } else {
                    $errors[] = 'La extensión de la foto no se encuentra entre las válidas';
                }

            } else if ($photo['error'] !== 4) {
                $errors[] = 'La foto se ha subido incorrectamente';
            } else {
                $newname = $user->getProfilePic();
                $flag = false;
            }
        } else {
            $errors[] = 'No has añadido la foto';
        }

        $additionalErrors = $this->validate($user);

        if (!empty($additionalErrors)) {
            foreach ($additionalErrors as $item) {
                $errors[] = $item;
            }
        }

        if (empty($errors)) {
            // Conectarnos a la base de datos
            $this->usersRepository->updateUser($user, $newname);

            if ($flag) {
                if (!move_uploaded_file($photo['tmp_name'], $route . $newname)) {
                    throw new Exception('No se ha podido guardar la foto');
                }
            }

            header("Location: /Akihabara-Dreams/usuarios");
            exit;

        } else {
            include('../app/views/errores.php');
        }
    }

    // Funcion para eliminar un usuario
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
            $route = BASE_PATH . '/resources/images/usuarios/';
            $route = str_replace('\\', '/', $route);

            if (file_exists($route . $photo) && $photo !== 'default.jpg') {
                if (!unlink($route . $photo)) {
                    throw new Exception('No se ha podido eliminar la foto');
                }
            }
            header("Location: /Akihabara-Dreams/usuarios");
            exit;

        } else {
            include('../app/views/errores.php');
        }

    }

    // Funcion para buscar un usuario por su ID
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

            include('../app/views/cuenta.php');
        } else {
            include('../app/views/errores.php');
        }

    }

    // Funcion para mostrar todos los usuarios registrados en la base de datos
    public function showUsers() {
        // Conexión
        $users = $this->usersRepository->showUsers();

        include('../app/views/mostrarUsuarios.php');
    }

    public function updateForm($id) {
        $user = $this->usersRepository->searchUser($id);

        include('../app/views/actualizarUsuario.php');
    }

    public function createForm() {
        include('../app/views/crearUsuario.php');
    }

    public function register(User $user) {
        $errors = [];

        // Validaciones
        if (!$user->getName()) {
            $errors[] = 'No has introducido el nombre';
        }

        if (strlen($user->getName()) < 3) {
            $errors[] = 'El nombre debe tener como mínimo 3 caracteres';
        }

        if (!$user->getUserName()) {
            $errors[] = 'No has introducido el nombre de usuario';
        }

        if (!$user->getEmail()) {
            $errors[] = 'No has introducido el correo electrónico';
        } else if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El formato del correo no es válido';
        }

        if (!$user->getPassword()) {
            $errors[] = 'No has introducido la contraseña';
        }

        if (strlen($user->getPassword()) < 8) {
            $errors[] = 'La contraseña debe tener como mínimo 8 caracteres';
        }

        if (empty($errors)) {
            $finalUser = $this->usersRepository->registerUser($user);
            $_SESSION['usuario'] = serialize($finalUser);

            $_SESSION['carrito'] = serialize(new Cart($finalUser->getId()));

            header('Location: /Akihabara-Dreams/micuenta');
            exit;

        } else {
            include('../app/views/errores.php');
        }

    }
}