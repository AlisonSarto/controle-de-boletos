<?php

  include $_SERVER['DOCUMENT_ROOT'].'/server/db/connect.php';

  if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    send([
      'status' => 405,
      'message' => 'Método no permitido'
    ]);
  }

  $id = $_GET['id'] ?? null;

  $sql = "SELECT * FROM empresas";

  if ($id !== null) {
    $sql .= " WHERE id = $id";
  }

  $res = $conn->query($sql);

  if ($res->num_rows === 0) {
    send([
      'status' => 404,
      'message' => 'Nenhuma empresa encontrada'
    ]);
  }

  $empresas = [];

  while ($row = $res->fetch_assoc()) {
    $empresas[] = $row;
  }

  send([
    'status' => 200,
    'message' => 'Empresas encontradas com sucesso',
    'empresas' => $empresas
  ])


?>