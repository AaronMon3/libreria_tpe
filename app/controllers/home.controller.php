<?php
require_once 'app/views/home.view.php';

class HomeController{
  private $view;

  function __construct(){
    $this->view = new ViewHome();
  }

  function showHome(){
    $this->view->showHome();
  }
}