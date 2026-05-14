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

  //-------------Formulario para editar Genero-------------
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
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $imagen = trim($_POST['imagen'] ?? '');

    if ($nombre === '' || $descripcion === ''){
      header('Location: ' . BASE_URL . 'admin/generos/agregar');
      return;
    }

    $this->model->insertGenre($nombre, $descripcion, $imagen ?: null);
    header('Location: ' . BASE_URL . 'admin/generos');
  }

  //-------------Editar Genero-------------
  public function editGenre($id){
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $imagen = trim($_POST['imagen'] ?? '');

    if ($nombre === '' || $descripcion === ''){
      header('Location: ' . BASE_URL . 'admin/generos/editar/' . $id);
      return;
    }

    $this->model->updateGenre($id, $nombre, $descripcion, $imagen ?: null);
    header('Location: ' . BASE_URL . 'admin/generos');
  }

  //-------------Eliminar Genero-------------
  public function deleteGenre($id){
    // Verificar que no tenga libros asociados antes de eliminar
    $books = $this->bookModel->getBooksByGenre($id);
    if (!empty($books)){
      // No se puede eliminar un género con libros asociados
      header('Location: ' . BASE_URL . 'admin/generos');
      return;
    }
    $this->model->deleteGenre($id);
    header('Location: ' . BASE_URL . 'admin/generos');
  }
}
