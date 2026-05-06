<?php
class BooksView{
  function showBooks($books){
    require_once "app/views/templates/books.phtml";
  }

  function showBook($book){
    require_once "app/views/templates/book.phtml";
  }

  function showAdmin($books){
    require_once "app/views/templates/admin-books.phtml";
  }

  function showForm($genres, $book){
    require_once "app/views/templates/book-form.phtml";
  }
}
