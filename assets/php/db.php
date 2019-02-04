<?php
  $servername = "serveraddress";
  $username = "username";
  $password = "password";
  $dbname = "databasename";

  $conn = mysqli_connect($servername,$username,$password,$dbname);

  if (!$conn) {
    die("Connexion impossible : ". mysqli_connect_error());
  }
?>
