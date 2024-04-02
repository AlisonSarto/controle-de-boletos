<?php

  include $_SERVER['DOCUMENT_ROOT'].'/server/db/connect.php';

  if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    send([
      'status' => 405,
      'message' => 'Método no permitido'
    ]);
  }

  $id = $_GET['id'] ?? null;

  $empresa_id = $_SESSION['empresa_id'];

  $sql = "SELECT * FROM saldos WHERE empresa_id = $empresa_id";
  $res = $conn->query($sql);

  if ($res->num_rows === 0) {
    send([
      'status' => 404,
      'message' => 'Nenhum saldo encontrado'
    ]);
  }

  $saldos = [];

  while ($row = $res->fetch_assoc()) {
    $conta_id = $row['conta_id'];
    $saldos[$conta_id] = $row['saldo'];
  }

  $sql = "SELECT * FROM contas";

  if ($id !== null) {
    $sql .= " WHERE id = $id";
  }

  $res = $conn->query($sql);

  if ($res->num_rows === 0) {
    send([
      'status' => 404,
      'message' => 'Nenhuma conta encontrada'
    ]);
  }

  $contas = [];

  while ($row = $res->fetch_assoc()) {
    $row['saldo'] = $saldos[$row['id']];
    $contas[] = $row;
  }

  send([
    'status' => 200,
    'message' => 'Contas encontradas com sucesso',
    'contas' => $contas
  ])

?>