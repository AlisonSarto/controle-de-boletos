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

  $sql = "SELECT * FROM empresas";
  $res = $conn->query($sql);

  if ($res->num_rows === 0) {
    send([
      'status' => 404,
      'message' => 'Nenhuma empresa encontrada'
    ]);
  }

  $empresas = [];
  while ($row = $res->fetch_assoc()) {
    $idRow = $row['id'];
    $empresas[$idRow] = $row;
  }

  if (!isset($empresas[$id])) {
    send([
      'status' => 404,
      'message' => 'Empresa não encontrada'
    ]);
  }

  if (count($empresas) === 1) {
    send([
      'status' => 400,
      'message' => 'Não é possível deletar a única empresa'
    ]);
  }

  $sql = "DELETE FROM empresas WHERE id = $id";
  $conn->query($sql);

  if ($conn->error) {
    send([
      'status' => 500,
      'message' => 'Erro ao deletar conta'
    ]);
  }

  $sql = "DELETE FROM saldos WHERE empresa_id = $id";
  $conn->query($sql);

  if ($conn->error) {
    send([
      'status' => 500,
      'message' => 'Erro ao deletar saldo'
    ]);
  }


  $empresa_id_session = $_SESSION['empresa_id'];

  if ($empresa_id_session == $id) {
    $sql = "SELECT * FROM empresas LIMIT 1";
    $res = $conn->query($sql);

    $empresa_id = $res->fetch_assoc()['id'];
    
    $_SESSION['empresa_id'] = $empresa_id;
  }

  send([
    'status' => 200,
    'message' => 'Empresa deletada com sucesso'
  ]);

?>