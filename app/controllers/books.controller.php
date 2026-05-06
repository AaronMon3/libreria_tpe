<?php
require_once __DIR__ . '/../models/books.model.php';
require_once __DIR__ . '/../models/genres.model.php';
require_once __DIR__ . '/../views/books.view.php';

class BooksController{
  private $model;
  private $genresModel;
  private $view;

  function __construct(){
    $this->model = new BooksModel();
    $this->genresModel = new GenresModel();
    $this->view = new BooksView();
  }

  public function showBooks(){
    $books = $this->model->getBooks();
    $this->view->showBooks($books);
  }

  public function showBook($id){
    $book = $this->model->getBookById($id);
    if (!$book){
      header('Location: ' . BASE_URL . 'libros');
      return;
    }
    $this->view->showBook($book);
  }

  public function showAdmin(){
    $books = $this->model->getBooks();
    $this->view->showAdmin($books);
  }

  public function showAddForm(){
    $genres = $this->genresModel->getGenres();
    $this->view->showForm($genres, null);
  }

  public function addBook(){
    $titulo = trim($_POST['titulo'] ?? '');
    $autor  = trim($_POST['autor'] ?? '');
    $precio = $_POST['precio'] ?? '';
    $imagen = trim($_POST['imagen'] ?? '');
    $idGen  = $_POST['id_genero_fk'] ?? '';

    if ($titulo === '' || $autor === '' || $precio === '' || $idGen === ''){
      header('Location: ' . BASE_URL . 'admin/libros/agregar');
      return;
    }
    $this->model->insertBook($titulo, $autor, $precio, $imagen ?: null, $idGen);
    header('Location: ' . BASE_URL . 'admin/libros');
  }

  public function showEditForm($id){
    $book = $this->model->getBookById($id);
    if (!$book){
      header('Location: ' . BASE_URL . 'admin/libros');
      return;
    }
    $genres = $this->genresModel->getGenres();
    $this->view->showForm($genres, $book);
  }

  public function editBook($id){
    $titulo = trim($_POST['titulo'] ?? '');
    $autor  = trim($_POST['autor'] ?? '');
    $precio = $_POST['precio'] ?? '';
    $imagen = trim($_POST['imagen'] ?? '');
    $idGen  = $_POST['id_genero_fk'] ?? '';

    if ($titulo === '' || $autor === '' || $precio === '' || $idGen === ''){
      header('Location: ' . BASE_URL . 'admin/libros/editar/' . $id);
      return;
    }
    $this->model->updateBook($id, $titulo, $autor, $precio, $imagen ?: null, $idGen);
    header('Location: ' . BASE_URL . 'admin/libros');
  }

  public function deleteBook($id){
    $this->model->deleteBook($id);
    header('Location: ' . BASE_URL . 'admin/libros');
  }
}
