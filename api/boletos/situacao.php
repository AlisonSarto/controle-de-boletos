<?php

  include $_SERVER['DOCUMENT_ROOT'].'/server/db/connect.php';

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send([
      'status' => 405,
      'message' => 'Método no permitido'
    ]);
  }

  $id = $_POST['id'] ?? null;

  if ($id === null) {
    send([
      'status' => 400,
      'message' => 'ID não informado'
    ]);
  }

  $sql = "SELECT * FROM boletos WHERE id = $id";
  $res = $conn->query($sql);

  if ($res->num_rows === 0) {
    send([
      'status' => 404,
      'message' => 'Boleto não encontrado'
    ]);
  }

  $row = $res->fetch_assoc();

  $new = $row['situacao'] == 0 ? 1 : 0;
  $a_receber = $row['total_a_receber'];
  $a_pagar = $row['valor'];

  $pagador_id = $row['pagador_id'];
  $pagador_conta_id = $row['pagador_conta_id'];

  $recebedor_id = $row['recebedor_id'];
  $recebedor_conta_id = $row['recebedor_conta_id'];

  $sql = "UPDATE boletos SET situacao = $new WHERE id = $id";
  $res = $conn->query($sql);

  if ($res === false) {
    send([
      'status' => 500,
      'message' => 'Erro ao atualizar boleto'
    ]);
  }

  if ($new == 1) {
    //? Boleto pago
    $sql = "UPDATE saldos SET saldo = saldo + $a_receber WHERE conta_id = $recebedor_conta_id AND empresa_id = $recebedor_id";
    $res = $conn->query($sql);

    if ($res === false) {
      send([
        'status' => 500,
        'message' => 'Erro ao atualizar saldo do recebedor'
      ]);
    }

    $sql = "UPDATE saldos SET saldo = saldo - $a_pagar WHERE conta_id = $pagador_conta_id AND empresa_id = $pagador_id";
    $res = $conn->query($sql);

    if ($res === false) {
      send([
        'status' => 500,
        'message' => 'Erro ao atualizar saldo do pagador'
      ]);
    }
  } else {
    //? Boleto em aberto
    $sql = "UPDATE saldos SET saldo = saldo - $a_receber WHERE conta_id = $recebedor_conta_id AND empresa_id = $recebedor_id";
    $res = $conn->query($sql);

    if ($res === false) {
      send([
        'status' => 500,
        'message' => 'Erro ao atualizar saldo do recebedor'
      ]);
    }

    $sql = "UPDATE saldos SET saldo = saldo + $a_pagar WHERE conta_id = $pagador_conta_id AND empresa_id = $pagador_id";
    $res = $conn->query($sql);

    if ($res === false) {
      send([
        'status' => 500,
        'message' => 'Erro ao atualizar saldo do pagador'
      ]);
    }
  }

  send([
    'status' => 200,
    'message' => 'Boleto atualizado com sucesso'
  ])


?>