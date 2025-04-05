<?php
class AuthUserController{
    private AuthRepository $authRepository;

    public function __construct($authRepository) {
        $this->authRepository = $authRepository;
    }
    
    public function loginUser(AuthUser $authUser) {
        if (!$authUser->getUsername()) {
            throw new Exception('El usuario no tiene nombre');
        }

        if (!$authUser->getPassword()) {
            throw new Exception('El usuario no tiene contraseña');
        }

        $user = $this->authRepository->searchUser($authUser->getUsername());

        if (!$user) {
            throw new Exception('No se ha encontrado al usuario');
        }

        if (!password_verify($authUser->getPassword(), $user->getPassword())) {
            throw new Exception('Las contraseñas no coinciden');
        }

        $_SESSION['usuario'] = serialize($user);

        return $user->getId();

    }
    
    public function logoutUser() {
        foreach($_COOKIE as $item=>$value){
            setcookie($item,'',time() - 3600, '/');
        }
        session_unset();
        session_destroy();

        header('Location: /Akihabara-Dreams/');
        exit;
    }
    
    public function index() {
        include('../app/views/login.php');
    }
}
