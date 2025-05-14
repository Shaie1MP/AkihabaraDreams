<?php
class AuthUserController{
    private AuthRepository $authRepository;

    public function __construct($authRepository) {
        $this->authRepository = $authRepository;
    }
    
    public function loginUser(AuthUser $authUser) {
        // Validaciones
        if (!$authUser->getUsername()) {
            $_SESSION['login_error'] = 'El usuario no puede estar vacío';
            $_SESSION['login_username'] = $authUser->getUsername();
            header('Location: /Akihabara-Dreams/login');
            exit;
        }

        if (!$authUser->getPassword()) {
            $_SESSION['login_error'] = 'La contraseña no puede estar vacía';
            $_SESSION['login_username'] = $authUser->getUsername();
            header('Location: /Akihabara-Dreams/login');
            exit;
        }

        try {
            $user = $this->authRepository->searchUser($authUser->getUsername());
            
            if (!password_verify($authUser->getPassword(), $user->getPassword())) {
                $_SESSION['login_error'] = 'Las credenciales no son válidas';
                $_SESSION['login_username'] = $authUser->getUsername();
                header('Location: /Akihabara-Dreams/login');
                exit;
            } else {
                $_SESSION['usuario'] = serialize($user);
                return $user->getId();
            }
        } catch (Exception $e) {
            $_SESSION['login_error'] = 'Las credenciales no son válidas';
            $_SESSION['login_username'] = $authUser->getUsername();
            header('Location: /Akihabara-Dreams/login');
            exit;
        }
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
