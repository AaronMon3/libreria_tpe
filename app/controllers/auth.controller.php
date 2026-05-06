<?php
require_once __DIR__ . '/../models/users.model.php';
require_once __DIR__ . '/../views/auth.view.php';

class AuthController{
  private $model;
  private $view;

  function __construct(){
    $this->model = new UsersModel();
    $this->view = new AuthView();
    $this->model->ensureDefaultAdmin();
  }

  public function showLogin(){
    if (!empty($_SESSION['id'])) {
      header('Location: ' . BASE_URL . 'admin/libros');
      return;
    }
    $this->view->showLogin(null);
  }

  public function authenticate(){
    if (empty($_POST['email']) || empty($_POST['password'])) {
      return $this->view->showLogin('Completá usuario y contraseña');
    }

    $user = $this->model->getUserByEmail($_POST['email']);
    if (!$user || !password_verify($_POST['password'], $user->password)) {
      return $this->view->showLogin('Credenciales inválidas');
    }

    $_SESSION['id'] = $user->id_usuario;
    $_SESSION['email'] = $user->email;
    header('Location: ' . BASE_URL . 'admin/libros');
  }

  public function logout(){
    session_destroy();
    header('Location: ' . BASE_URL . 'home');
  }
}
