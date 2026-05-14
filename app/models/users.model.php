<?php
require_once 'app/models/database.php';

class UsersModel{

  public function getUserByEmail($email){
    $db = Database::getConnection();
    $query = $db->prepare('SELECT * FROM usuario WHERE email = ?');
    $query->execute([$email]);
    return $query->fetch(PDO::FETCH_OBJ);
  }

}
