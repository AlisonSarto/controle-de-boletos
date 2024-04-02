<?php
  $expireTime = 604800;
  session_set_cookie_params($expireTime);
  session_start();
  session_unset();
  session_destroy();
  header("Location: /login");
?>