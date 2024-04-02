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

  //? Puxa o boleto
  $sql = "SELECT * FROM boletos WHERE id = $id";
  $res = $conn->query($sql);

  if ($res === false) {
    send([
      'status' => 500,
      'message' => 'Erro ao deletar boleto'
    ]);
  }elseif ($res->num_rows === 0) {
    send([
      'status' => 404,
      'message' => 'Boleto não encontrado'
    ]);
  }

  $row = $res->fetch_assoc();

  if($row['situacao'] == 1){
    send([
      'status' => 400,
      'message' => 'Não é possível deletar um boleto pago'
    ]);
  }

  $sql = "DELETE FROM boletos WHERE id = $id";
  $res = $conn->query($sql);
  
  if ($res === false) {
    send([
      'status' => 500,
      'message' => 'Erro ao deletar boleto'
    ]);
  }

  send([
    'status' => 200,
    'message' => 'Boleto deletado com sucesso'
  ]);

?>