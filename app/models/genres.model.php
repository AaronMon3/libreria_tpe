<?php
require_once 'app/models/database.php';

class GenresModel{

  public function getGenres(){
    $db = Database::getConnection();
    $query = $db->prepare('SELECT * FROM genero');
    $query->execute();
    return $query->fetchAll();
  }

  public function getGenreById($id){
    $db = Database::getConnection();
    $query = $db->prepare('SELECT * FROM genero WHERE id_genero = ?');
    $query->execute([$id]);
    return $query->fetch();
  }
}
