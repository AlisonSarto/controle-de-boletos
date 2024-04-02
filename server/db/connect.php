<?php

  include $_SERVER['DOCUMENT_ROOT'].'/server/funcs/env.php';
  include $_SERVER['DOCUMENT_ROOT'].'/server/funcs/send.php';

  $expireTime = 604800;
  session_set_cookie_params($expireTime);
  session_start();

  date_default_timezone_set('Etc/GMT+3');

  $dbHost = env('DB_HOST');
  $dbUsername = env('DB_USER');
  $dbPassword = env('DB_PASS');
  $dbName = env('DB_NAME');

  $conn = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

?>