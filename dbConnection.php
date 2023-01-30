<?php
  $host   = "localhost";
  $user   = "root";
  $pass   = "";
  $dbname = "module4labs";
  $db     = null;


  //try to connect to the database using the provided credentials
  //if the connection works, it will keep the persistence, else it will throw an error
  try {
    $db = new PDO( "mysql:host=$host;dbname=$dbname", $user, $pass);
    $db->exec("set names utf8");
  }catch (Exception $e){
    die("Database Connection Error: " . $e->getMessage());
  }

?>  