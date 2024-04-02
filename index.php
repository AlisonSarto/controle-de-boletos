<?php

  $expireTime = 604800;
  session_set_cookie_params($expireTime);
  session_start();

  if (isset($_SESSION['hash'])) {

    header("Location: /app/dashboard");
    exit;

  }else {
    header('Location: /sair');
    exit;
  }

?>