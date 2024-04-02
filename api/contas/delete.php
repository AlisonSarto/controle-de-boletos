<?php

  include $_SERVER['DOCUMENT_ROOT'].'/server/db/connect.php';

  if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    send([
      'status' => 405,
      'message' => 'Método no permitido'
    ]);
  }

  $id = $_GET['id'] ?? null;

  if ($id === null) {
    send([
      'status' => 400,
      'message' => 'ID é obrigatório'
    ]);
  }

  $sql = "SELECT * FROM contas";
  $res = $conn->query($sql);

  if ($conn->error) {
    send([
      'status' => 500,
      'message' => 'Erro ao buscar contas'
    ]);
  }elseif ($res->num_rows === 1) {
    send([
      'status' => 400,
      'message' => 'Não é possível deletar a única conta'
    ]);
  }

  $sql = "DELETE FROM contas WHERE id = $id";
  $conn->query($sql);

  if ($conn->error) {
    send([
      'status' => 500,
      'message' => 'Erro ao deletar conta'
    ]);
  }

  $sql = "DELETE FROM saldos WHERE conta_id = $id";
  $conn->query($sql);

  if ($conn->error) {
    send([
      'status' => 500,
      'message' => 'Erro ao deletar saldo'
    ]);
  }

  $sql = "DELETE FROM boletos WHERE pagador_conta_id = $id OR recebedor_conta_id = $id";
  $conn->query($sql);

  if ($conn->error) {
    send([
      'status' => 500,
      'message' => 'Erro ao deletar boletos'
    ]);
  }

  send([
    'status' => 200,
    'message' => 'Conta deletada com sucesso'
  ]);

?>