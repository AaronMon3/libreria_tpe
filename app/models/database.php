<?php
require_once 'config.php';

class Database {
  private static $instance = null;

  public static function getConnection() {
    if (self::$instance === null) {
      $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
      self::$instance = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
      ]);
    }
    return self::$instance;
  }
}
