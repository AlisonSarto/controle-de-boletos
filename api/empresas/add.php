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

  $sql = "INSERT INTO empresas (nome) VALUES ('$nome')";
  $res = $conn->query($sql);

  if ($res === false) {
    send([
      'status' => 500,
      'message' => 'Erro ao adicionar conta'
    ]);
  }

  $empresa_id = $conn->insert_id;

  $sql = "SELECT * FROM contas";
  $res = $conn->query($sql);

  while ($row = $res->fetch_assoc()) {
    $conta_id = $row['id'];

    $sql2 = "INSERT INTO saldos (empresa_id, conta_id) VALUES ($empresa_id, $conta_id)";
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
    'message' => 'Empresa adicionada com sucesso'
  ]);

?>