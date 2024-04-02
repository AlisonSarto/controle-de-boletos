<?php

  include $_SERVER['DOCUMENT_ROOT'].'/server/db/connect.php';

  if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    send([
      'status' => 405,
      'message' => 'Método no permitido'
    ]);
  }

  $sql = "SELECT * FROM chaves";
  $res = $conn->query($sql);

  if ($res->num_rows === 0) {
    send([
      'status' => 404,
      'message' => 'Nenhuma chave encontrada'
    ]);
  }

  $chaves = [];
  while ($row = $res->fetch_assoc()) {
    $chaves[] = [
      'id' => $row['id'],
      'nome' => $row['nome']
    ];
  }

  send([
    'status' => 200,
    'message' => 'Chaves encontradas com sucesso',
    'chaves' => $chaves
  ])

?>