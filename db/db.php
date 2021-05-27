<?php
try {
  $configs = require_once('config.php');
  $dbUserName = $configs['userName'];
  $dbPassword = $configs['password'];
  $dbConnection = 'pgsql:host=localhost; dbname=db-exam';

  $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // try-catch
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ 
    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NUM // [[],[],[]]
  ];
  $db = new PDO(
    $dbConnection,
    $dbUserName,
    $dbPassword,
    $options
  );
} catch (PDOException $ex) {
  echo $ex;
  echo 'error';
  exit();
}