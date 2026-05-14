<?php
require_once 'app/models/database.php';

class BooksModel{

  public function getBooks(){
    $db = Database::getConnection();
    $query = $db->prepare('SELECT l.*, g.nombre AS nombre_genero
                           FROM libro l
                           INNER JOIN genero g ON l.id_genero_fk = g.id_genero');
    $query->execute();
    return $query->fetchAll(PDO::FETCH_OBJ);
  }

  public function getBookById($id){
    $db = Database::getConnection();
    $query = $db->prepare('SELECT l.*, g.nombre AS nombre_genero
                           FROM libro l
                           INNER JOIN genero g ON l.id_genero_fk = g.id_genero
                           WHERE l.id_libro = ?');
    $query->execute([$id]);
    return $query->fetch(PDO::FETCH_OBJ);
  }

  public function getBooksByGenre($idGenero){
    $db = Database::getConnection();
    $query = $db->prepare('SELECT l.*, g.nombre AS nombre_genero
                           FROM libro l
                           INNER JOIN genero g ON l.id_genero_fk = g.id_genero
                           WHERE l.id_genero_fk = ?');
    $query->execute([$idGenero]);
    return $query->fetchAll(PDO::FETCH_OBJ);
  }

  public function insertBook($titulo, $autor, $precio, $imagen, $idGenero){
    $db = Database::getConnection();
    $query = $db->prepare('INSERT INTO libro (titulo, autor, precio, imagen, id_genero_fk)
                           VALUES (?, ?, ?, ?, ?)');
    $query->execute([$titulo, $autor, $precio, $imagen, $idGenero]);
    return $db->lastInsertId();
  }

  public function deleteBook($id){
    $db = Database::getConnection();
    $query = $db->prepare('DELETE FROM libro WHERE id_libro = ?');
    $query->execute([$id]);
  }

  public function updateBook($id, $titulo, $autor, $precio, $imagen, $idGenero){
    $db = Database::getConnection();
    $query = $db->prepare('UPDATE libro
                           SET titulo = ?, autor = ?, precio = ?, imagen = ?, id_genero_fk = ?
                           WHERE id_libro = ?');
    $query->execute([$titulo, $autor, $precio, $imagen, $idGenero, $id]);
  }
}
