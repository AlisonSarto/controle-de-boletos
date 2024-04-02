<?php

  include $_SERVER['DOCUMENT_ROOT'].'/server/db/connect.php';

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send([
      'status' => 405,
      'message' => 'Método no permitido'
    ]);
  }

  $nome = $_POST['nome'] ?? null;

  if ($nome === null) {
    send([
      'status' => 400,
      'message' => 'Nome é obrigatório'
    ]);
  }

  $sql = "INSERT INTO contas (nome) VALUES ('$nome')";
  $res = $conn->query($sql);

  if ($res === false) {
    send([
      'status' => 500,
      'message' => 'Erro ao adicionar conta'
    ]);
  }

  $conta_id = $conn->insert_id;

  $sql = "SELECT * FROM empresas";
  $res = $conn->query($sql);

  while ($row = $res->fetch_assoc()) {
    $empresa_id = $row['id'];

    $sql2 = "INSERT INTO saldos (conta_id, empresa_id) VALUES ($conta_id, $empresa_id)";
    $res2 = $conn->query($sql2);

    if ($res2 === false) {
      send([
        'status' => 500,
        'message' => 'Erro ao adicionar saldo'
      ]);
    }
  }

  send([
    'status' => 200,
    'message' => 'Conta adicionada com sucesso'
  ]);

?>