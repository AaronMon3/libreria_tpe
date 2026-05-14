<?php
require_once 'app/models/database.php';

class GenresModel{

  public function getGenres(){
    $db = Database::getConnection();
    //te sedo esta, me gusta como manejas la conexion
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

  public function insertGenre($nombre,$descripcion,$imagen){
    $db = Database::getConnection();
    $query = $db->prepare('INSERT INTO genero (nombre,descripcion,imagen) VALUES (?,?,?)');
    $query->execute([$nombre,$descripcion,$imagen]);
  }

  public function updateGenre($id,$nombre,$descripcion,$imagen){
    $db = Database::getConnection();
    $query = $db->prepare('UPDATE genero SET nombre = ?, descripcion = ?, imagen = ? WHERE id_genero = ?');
    $query->execute([$nombre,$descripcion,$imagen,$id]);
  }

  public function deleteGenre($id){
    $db= Database::getConnection();
    $query = $db->prepare('DELETE FROM genero WHERE id_genero = ?');
    $query->execute([$id]);
  }
}
