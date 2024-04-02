<?php

  include $_SERVER['DOCUMENT_ROOT'].'/server/db/connect.php';

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send([
      'status' => 405,
      'message' => 'Método no permitido'
    ]);
  }

  $id = $_POST['id'] ?? null;
  $nome = $_POST['nome'] ?? null;

  if ($nome === null || $id === null) {
    send([
      'status' => 400,
      'message' => 'Dados é obrigatório'
    ]);
  }

  $sql = "UPDATE empresas SET nome = '$nome' WHERE id = $id";
  $conn->query($sql);

  if ($conn->error) {
    send([
      'status' => 500,
      'message' => 'Erro ao atualizar conta'
    ]);
  }

  send([
    'status' => 200,
    'message' => 'Conta editada com sucesso'
  ]);

?>