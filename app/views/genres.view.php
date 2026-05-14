<?php
class GenresView{
  //----------------Acceso Publico----------------
  function showGenres($genres){
    require_once "app/views/templates/genres.phtml";
  }

  function showGenre($genre, $books){
    require_once "app/views/templates/genre.phtml";
  }
  
  //----------------Acceso Admin----------------
  function showAdmin($genres){
    require_once "app/views/templates/admin-genres.phtml";
  }

  function showForm($genre){
    require_once "app/views/templates/genre-form.phtml";
  }
}
