<?php

  include $_SERVER['DOCUMENT_ROOT'].'/server/db/connect.php';

  if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    send([
      'status' => 405,
      'message' => 'Método no permitido'
    ]);
  }

  $mes = $_GET['mes'] ?? date('Y-m');
  $empresa_id = $_SESSION['empresa_id'];
  $conta_id = $_SESSION['conta_id'];
  $data = date('Y-m-d');

  //? Puxa o total de boletos vencidos desse mês
  $sql = "SELECT SUM(total_a_receber) as total FROM boletos WHERE pagador_id = $empresa_id AND pagador_conta_id = $conta_id AND data_vencimento < '$data' AND data_vencimento LIKE '$mes%' AND situacao = 0";
  $res = $conn->query($sql);

  $vencidos = $res->fetch_assoc();
  $vencidos = (float) $vencidos['total'] ?? 0.00;

  //? Puxa o total de boletos que vencem hoje
  $sql = "SELECT SUM(total_a_receber) as total FROM boletos WHERE pagador_id = $empresa_id AND pagador_conta_id = $conta_id AND data_vencimento = '$data' AND situacao = 0";
  $res = $conn->query($sql);

  $vencem_hoje = $res->fetch_assoc();
  $vencem_hoje = (float) $vencem_hoje['total'] ?? 0.00;

  //? Puxa o total de boletos que vão vencer
  $sql = "SELECT SUM(total_a_receber) as total FROM boletos WHERE pagador_id = $empresa_id AND pagador_conta_id = $conta_id AND data_vencimento > '$data' AND data_vencimento LIKE '$mes%' AND situacao = 0";
  $res = $conn->query($sql);

  $a_vencer = $res->fetch_assoc();
  $a_vencer = (float) $a_vencer['total'] ?? 0.00;

  //? Puxa o total de boletos pagos em decimal
  $sql = "SELECT SUM(total_a_receber) as total FROM boletos WHERE pagador_id = $empresa_id AND pagador_conta_id = $conta_id AND situacao = 1 AND data_vencimento LIKE '$mes%'";
  $res = $conn->query($sql);

  $pagos = $res->fetch_assoc();
  $pagos = (float) $pagos['total'] ?? 0.00;

  $total = $vencidos + $vencem_hoje + $a_vencer + $pagos;

  //* Formata deixando apenas 2 casas decimais, e caso não tenha casa decimal, adiciona .00
  $vencidos = (float) number_format($vencidos, 2, '.', '');
  $vencem_hoje = (float) number_format($vencem_hoje, 2, '.', '');
  $a_vencer = (float) number_format($a_vencer, 2, '.', '');
  $pagos = (float) number_format($pagos, 2, '.', '');
  $total = (float) number_format($total, 2, '.', '');

  //? Puxa os boletos do mês
  $sql = "SELECT * FROM empresas";
  $res = $conn->query($sql);
  $empresas = [];
  while ($row = $res->fetch_assoc()) {
    $empresas[$row['id']] = $row['nome'];
  }

  $sql = "SELECT * FROM contas";
  $res = $conn->query($sql);
  $contas = [];
  while ($row = $res->fetch_assoc()) {
    $contas[$row['id']] = $row['nome'];
  }

  $sql = "SELECT * FROM boletos WHERE pagador_id = $empresa_id AND pagador_conta_id = $conta_id AND data_vencimento LIKE '$mes%' ORDER BY data_vencimento ASC";
  $res = $conn->query($sql);


  $boletos = [];
  while ($row = $res->fetch_assoc()) {

    $nome_recebedor = $empresas[$row['recebedor_id']];
    $conta_recebedor = $contas[$row['recebedor_conta_id']];

    $recebedor = "$nome_recebedor - $conta_recebedor";

    $boletos[] = [
      'id' => $row['id'],
      'situacao' => $row['situacao'],
      'recebedor' => $recebedor,
      'valor' => $row['valor'],
      'data_vencimento' => $row['data_vencimento'],
    ];
  }

  send([
    'status' => 200,
    'message' => 'Aqui está',
    'vencidos' => $vencidos,
    'vencem_hoje' => $vencem_hoje,
    'a_vencer' => $a_vencer,
    'pagos' => $pagos,
    'total' => $total,
    'boletos' => $boletos
  ])


?>