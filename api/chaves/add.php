<?php

  include $_SERVER['DOCUMENT_ROOT'].'/server/db/connect.php';

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send([
      'status' => 405,
      'message' => 'Método no permitido'
    ]);
  }

  $chave = $_POST['chave'] ?? null;
  $nome = $_POST['nome'] ?? null;

  if ($nome === null || $chave === null) {
    send([
      'status' => 400,
      'message' => 'Nome e chave é obrigatório'
    ]);
  }

  $sql = "SELECT * FROM chaves WHERE nome = '$nome'";
  $res = $conn->query($sql);

  if ($res->num_rows > 0) {
    send([
      'status' => 400,
      'message' => 'Chave já cadastrada'
    ]);
  }

  //* criptografar a chave
  $chave = password_hash($chave, PASSWORD_DEFAULT);

  $sql = "INSERT INTO chaves (nome, chave) VALUES ('$nome', '$chave')";
  $res = $conn->query($sql);

  if ($res === false) {
    send([
      'status' => 500,
      'message' => 'Erro ao adicionar chave'
    ]);
  }

  send([
    'status' => 200,
    'message' => 'Conta adicionada com sucesso'
  ]);

?>