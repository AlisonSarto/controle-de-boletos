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
      'message' => 'ID da chave é obrigatório'
    ]);
  }

  $sql = "SELECT * FROM chaves WHERE id != $id";
  $res = $conn->query($sql);

  if ($res->num_rows === 0) {
    send([
      'status' => 400,
      'message' => 'Não é possivel deletar a ultima chave'
    ]);
  }

  $sql = "DELETE FROM chaves WHERE id = $id";
  $res = $conn->query($sql);

  if ($res === false) {
    send([
      'status' => 500,
      'message' => 'Erro ao deletar chave'
    ]);
  }

  send([
    'status' => 200,
    'message' => 'Chaves deletada com sucesso',
  ])

?>