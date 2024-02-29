<?php

  $hostname = "localhost";
  $username = "root";
  $password = "";
  $database = "wasadu";
  $Connection = mysqli_connect($hostname, $username, $password, $database);

  // $hostname = "172.20.250.202";
  // $username = "sa";
  // $password = "wangchao27443";
  // $database = "wasadu";
  // $Connection = mysqli_connect($hostname, $username, $password, $database);

  if (!$Connection) {
    echo "</br>";
      echo "Error: Unable to connect to MySQL." . PHP_EOL . "</br>";
      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL . "</br>";
      echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
      exit;
  }

  mysqli_set_charset($Connection, "utf8");

  date_default_timezone_set('Asia/Bangkok');

  $title = "Wangchao Hospital";
