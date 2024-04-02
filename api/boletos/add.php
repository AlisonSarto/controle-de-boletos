<?php

  include $_SERVER['DOCUMENT_ROOT'].'/server/db/connect.php';

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send([
      'status' => 405,
      'message' => 'Método no permitido'
    ]);
  }

  $recebedor_id = $_POST['recebedor'] ?? null; //*✅
  $recebedor_conta_id = $_POST['conta_recebedor'] ?? null; //*✅
  $pagador_id = $_POST['pagador'] ?? null; //*✅
  $pagador_conta_id = $_POST['conta_pagador'] ?? null; //*✅
  $valor = $_POST['total'] ?? null; //*✅
  $n_boleto = $_POST['n_boleto'] ?? null; //*✅
  $data_vencimento = $_POST['data_vencimento'] ?? null; //*✅
  $taxa_emissao = $_POST['taxa_emissao'] ?? 0.00; //*✅
  $taxa_antecipacao = $_POST['taxa_antecipacao'] ?? 0.00; //*✅
  $now = date('Y-m-d H:i:s');
  $total_a_receber = $valor - $taxa_emissao - $taxa_antecipacao;

  if ($total_a_receber <= 0) {
    send([
      'status' => 400,
      'message' => 'Valor não pode ser negativo'
    ]);
  }


  if ($recebedor_id === null || $recebedor_conta_id === null || $pagador_id === null || $pagador_conta_id === null || $valor === null || $n_boleto === null || $data_vencimento === null) {
    // qual está null?
    $nulls = [];
    if ($recebedor_id === null) {
      $nulls[] = 'recebedor';
    }
    if ($recebedor_conta_id === null) {
      $nulls[] = 'recebedor_conta';
    }
    if ($pagador_id === null) {
      $nulls[] = 'pagador';
    }
    if ($pagador_conta_id === null) {
      $nulls[] = 'pagador_conta';
    }
    if ($valor === null) {
      $nulls[] = 'valor';
    }
    if ($n_boleto === null) {
      $nulls[] = 'n_boleto';
    }
    if ($data_vencimento === null) {
      $nulls[] = 'data_vencimento';
    }

    send([
      'status' => 400,
      'message' => 'Campos obrigatórios não preenchidos',
      'fields' => $nulls
    ]);
  }

  if ($recebedor_id === $pagador_id) {
    send([
      'status' => 400,
      'message' => 'Recebedor e pagador não podem ser a mesma empresa'
    ]);
  }

  //? Verifica se o recebedor e o pagador existe
  $sql = "SELECT * FROM empresas WHERE id = $recebedor_id OR id = $pagador_id";
  $res = $conn->query($sql);

  if ($res === false) {
    send([
      'status' => 404,
      'message' => 'Recebedor não encontrado'
    ]);
  }elseif ($res->num_rows !== 2) {
    send([
      'status' => 404,
      'message' => 'Empresa não encontrada'
    ]);
  }

  //? Verifica se as contas existem
  $sql = "SELECT * FROM contas";
  $res = $conn->query($sql);

  if ($res === false) {
    send([
      'status' => 500,
      'message' => 'Erro ao puxar as contas'
    ]);
  }

  $recebedor_conta = false;
  $pagador_conta = false;
  while ($row = $res->fetch_assoc()) {
    if ($row['id'] == $recebedor_conta_id) {
      $recebedor_conta = true;
    }
    if ($row['id'] == $pagador_conta_id) {
      $pagador_conta = true;
    }
  }

  if ($recebedor_conta !== true) {
    send([
      'status' => 404,
      'message' => 'Conta do recebedor não encontrada'
    ]);
  }

  if ($pagador_conta !== true) {
    send([
      'status' => 404,
      'message' => 'Conta do pagador não encontrada'
    ]);
  }

  //? Verifica se o número do boleto já existe
  $sql = "SELECT * FROM boletos WHERE n_boleto = '$n_boleto'";
  $res = $conn->query($sql);

  if ($res === false) {
    send([
      'status' => 500,
      'message' => 'Erro ao verificar boleto'
    ]);
  }elseif ($res->num_rows > 0) {
    send([
      'status' => 400,
      'message' => 'Número Boleto já existe'
    ]);
  }

  //* Cria o boleto
  $sql = "INSERT INTO boletos 
    (n_boleto, pagador_id, pagador_conta_id, recebedor_id, recebedor_conta_id, valor, data_vencimento, data_gerada, taxa_emissao, taxa_antecipacao, total_a_receber)
    VALUES
    ('$n_boleto', $pagador_id, $pagador_conta_id, $recebedor_id, $recebedor_conta_id, $valor, '$data_vencimento', '$now', $taxa_emissao, $taxa_antecipacao, $total_a_receber)
  ";
  $res = $conn->query($sql);

  if ($res === false) {
    send([
      'status' => 500,
      'message' => 'Erro ao gerar boleto'
    ]);
  }

  send([
    'status' => 200,
    'message' => 'Boleto gerado com sucesso'
  ]);

?>