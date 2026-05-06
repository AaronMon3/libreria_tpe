<?php
class GenresView{
  function showGenres($genres){
    require_once "app/views/templates/genres.phtml";
  }

  function showGenre($genre, $books){
    require_once "app/views/templates/genre.phtml";
  }
}
