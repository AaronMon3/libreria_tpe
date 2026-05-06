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
}
