<?php

  include  $_SERVER['DOCUMENT_ROOT'].'/server/db/connect.php';

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send([
      'status' => 405,
      'message' => 'Método não permitido'
    ]);
  }

  if (empty($_POST['chave'])) {
    send([
      'status' => 400,
      'message' => 'Chave não informada'
    ]);
  }

  $chave = $_POST['chave'];

  $sql = "SELECT * FROM chaves";
  $res = $conn->query($sql);

  $verify = false;
  while ($row = $res->fetch_assoc()) {
    $hash = $row['chave'];

    if (password_verify($chave, $hash)) {
      $verify = true;
      break;
    }

  }

  if ($verify === false) {
    send([
      'status' => 401,
      'message' => 'Chave inválida'
    ]);
  }



  $_SESSION['hash'] = $hash;

  $sql = "SELECT * FROM empresas LIMIT 1";
  $res = $conn->query($sql);

  $empresa_id = 0;
  while ($row = $res->fetch_assoc()) {
    $empresa_id = $row['id'];
  }
  
  $_SESSION['empresa_id'] = $empresa_id;

  $conta_id = 0;
  $sql = "SELECT * FROM contas LIMIT 1";
  $res = $conn->query($sql);

  while ($row = $res->fetch_assoc()) {
    $conta_id = $row['id'];
  }

  $_SESSION['conta_id'] = $conta_id;

  send([
    'status' => 200,
    'message' => 'Login efetuado com sucesso'
  ]);

?>