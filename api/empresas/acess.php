<?php

  include $_SERVER['DOCUMENT_ROOT']."/server/db/connect.php";

  if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['error' => 'Metodo não aceito']);
    exit;
  }

  $id = $_GET['id'] ?? null;
  $return = $_GET['return'] ?? '/app/dashboard';

  if ($id === null) {
    echo json_encode(['error' => 'ID não informado']);
    exit;
  }

  $sql = "SELECT * FROM empresas WHERE id = $id";
  $res = $conn->query($sql);

  if ($res->num_rows === 0) {
    echo json_encode(['error' => 'Empresa não encontrada']);
    exit;
  }

  $_SESSION['empresa_id'] = $id;
  header("Location: $return");

?>