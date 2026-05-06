<?php
require_once 'app/models/database.php';

class UsersModel{

  public function getUserByEmail($email){
    $db = Database::getConnection();
    $query = $db->prepare('SELECT * FROM usuario WHERE email = ?');
    $query->execute([$email]);
    return $query->fetch();
  }

  public function ensureDefaultAdmin(){
    if ($this->getUserByEmail(DEFAULT_ADMIN_USER)) return;
    $db = Database::getConnection();
    $hash = password_hash(DEFAULT_ADMIN_PASS, PASSWORD_DEFAULT);
    $query = $db->prepare('INSERT INTO usuario (email, password) VALUES (?, ?)');
    $query->execute([DEFAULT_ADMIN_USER, $hash]);
  }
}
