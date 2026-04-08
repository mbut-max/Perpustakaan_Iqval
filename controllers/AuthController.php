<?php
require_once BASEPATH . "core/Controller.php";

class AuthController extends Controller {

    public function login(){
        $this->view('auth','login');
    }

    public function proses(){
        $user = $this->model('User');
        $data = $user->login($_POST['username'],$_POST['password']);

        if($data){
            $_SESSION['user']=$data;
            if($data['role']=='admin'){
                header("Location:index.php?url=admin/dashboard");
            }else{
                header("Location:index.php?url=user/dashboard");
            }
        }else{
            $_SESSION['error'] = "Username atau password salah.";
            header("Location:index.php?url=auth/login");
        }
    }

    public function register(){
        $this->view('auth','register');
    }

    public function simpan(){
        $user = $this->model('User');
        if ($user->register($_POST)) {
            header("Location:index.php");
        } else {
            $_SESSION['error'] = "Username sudah digunakan. Silakan pilih username lain.";
            header("Location:index.php?url=auth/register");
        }
    }

    public function logout(){
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }

        session_destroy();
        header("Location:index.php?url=auth/login");
        exit;
    }
}