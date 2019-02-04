<?php
session_start();

$index = "Location: ../../index.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include_once("db.php");

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $pwd = mysqli_real_escape_string($conn, $_POST['password']);

  $query = "SELECT * FROM users WHERE username = '".$name."' AND password = SHA('".$pwd."')";

  if ($res = mysqli_query($conn, $query)) {
    $row = mysqli_fetch_assoc($res);

    if (mysqli_num_rows($res) == 1) {
      $_SESSION['id'] = $row['id'];
      $_SESSION['name'] = $name;
      mysqli_free_result($result);
      mysqli_close($conn);
      header($index);
    }
    else {
      mysqli_close($conn);
      header($index."?errorCon=1");
    }
  } else {
    mysqli_close($conn);
    header($index."?errorCon=2");
  }
}
