<?php
require_once "app/models/genres.model.php";
require_once "app/models/books.model.php";
require_once "app/views/genres.view.php";

class GenreController{
  private $model;
  private $bookModel;
  private $view;

  function __construct(){
    $this->model = new GenresModel();
    $this->bookModel = new BooksModel();
    $this->view = new GenresView();
  }

  //-------------ACCESO PUBLICO-------------
  public function showGenres(){
    $genres = $this->model->getGenres();
    $this->view->showGenres($genres);
  }

  public function showGenre($id){
    $genre = $this->model->getGenreById($id);
    if (!$genre){
      header("Location: " . BASE_URL . "generos");
      return;
    }
    $books = $this->bookModel->getBooksByGenre($id);
    $this->view->showGenre($genre, $books);
  }

  //-------------ACCESO ADMIN-------------
  public function showAdmin(){
    $genres = $this->model->getGenres();
    $this->view->showAdmin($genres);
  }

  public function showAddForm(){
     $this->view->showForm(null);
  }

  //-------------Formulario para ABM de Generos-------------
  public function showEditForm($id){
    $genre = $this->model->getGenreById($id);
    if (!$genre){
      header('Location: ' . BASE_URL . 'admin/generos');
      return;
      }
      $this->view->showForm($genre);
  }

  //-------------Añadir Genero-------------
  public function addGenre(){
    if(!isset($_POST['nombre']) || empty($_POST['nombre']) ||
      !isset($_POST['descripcion']) || empty($_POST['descripcion'])){
        header('Location: ' . BASE_URL . 'admin/generos/agregar');
        return;
      }
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_POST['imagen'];

    $this->model->insertGenre($nombre,$descripcion,$imagen);
    header('Location: ' . BASE_URL . 'admin/generos');
  }

  //-------------Editar Genero-------------
  public function editGenre($id){
    if(!isset($_POST['nombre']) || empty($_POST['nombre']) ||
        !isset($_POST['descripcion']) || empty($_POST['descripcion'])){
          header('Location: ' . BASE_URL . 'admin/generos/editar/' . $id);
          return;
        }
      $nombre = $_POST['nombre'];
      $descripcion = $_POST['descripcion'];
      $imagen = $_POST['imagen'];
  
      $this->model->updateGenre($id, $nombre,$descripcion,$imagen);
      header('Location: ' . BASE_URL . 'admin/generos');
  }

  //-------------Elimnar Genero-------------
  public function deleteGenre($id){
    $this->model->deleteGenre($id);
    header('Location: ' . BASE_URL . 'admin/generos');
  }
}
