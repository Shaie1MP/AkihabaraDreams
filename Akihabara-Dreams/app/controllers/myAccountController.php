<?php
class MyAccountController {
    private UsersRepository $usersRepository;
    
    public function __construct(UsersRepository $usersRepository) {
        $this->usersRepository = $usersRepository;
    }

    public function index() {
        include '../app/views/micuenta.php';
    }

    public function updateMyData() {
        include '../app/views/actualizarMisDatos.php';
    }

    public function update(User $user) {
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

            $_SESSION['usuario'] = serialize(new User($user->getId(), 
                                                        $user->getName(), 
                                                        $user->getUsername(), 
                                                        $user->getEmail(), 
                                                        $user->getAddress1(), 
                                                        $user->getAddress2(), 
                                                        $user->getAddress3(), 
                                                        $user->getPhone(), 
                                                        $newname, 
                                                        null, 
                                                        $user->getRole()));

            header("Location: /Akihabara-Dreams/micuenta");
            exit;
        } else {
            include('../app/views/errores.php');
        }
    }

    private function validate(User $user)
    {
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
    public function delete($id){
        $this->usersRepository->deleteUser($id);
        
        header('Location: /Akihabara-Dreams/logout');
        exit;
    }

}