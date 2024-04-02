<?php

  include $_SERVER['DOCUMENT_ROOT'].'/server/db/connect.php';

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send([
      'status' => 405,
      'message' => 'Método no permitido'
    ]);
  }

  $id = $_POST['id'] ?? null;
  $empresa_id = $_SESSION['empresa_id'];
  $nome = $_POST['nome'] ?? null;
  $saldo = $_POST['saldo'] ?? null;

  if ($nome === null || $saldo === null || $id === null) {
    send([
      'status' => 400,
      'message' => 'Dados é obrigatório'
    ]);
  }

  $sql = "UPDATE contas SET nome = '$nome' WHERE id = $id";
  $conn->query($sql);

  if ($conn->error) {
    send([
      'status' => 500,
      'message' => 'Erro ao atualizar conta'
    ]);
  }

  $sql = "UPDATE saldos SET saldo = $saldo WHERE empresa_id = $empresa_id AND conta_id = $id";
  $conn->query($sql);

  if ($conn->error) {
    send([
      'status' => 500,
      'message' => 'Erro ao atualizar saldo'
    ]);
  }

  send([
    'status' => 200,
    'message' => 'Conta editada com sucesso'
  ]);

?>