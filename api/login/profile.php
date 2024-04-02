<?php

  //? Puxa o perfil do usuário 

  function send($message) {
    header('Content-Type: application/json;');
    http_response_code($message['status'] ?? 200);
    echo json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
  }

  $expireTime = 604800;
  session_set_cookie_params($expireTime);
  session_start();

	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    send([
      'status' => 405,
      'message' => 'Método não aceitado',
    ]);
	}

  if (empty($_SESSION)) {
    send([
      'status' => 401,
      'message' => 'Não autorizado',
    ]);
  }

  send( [
    'status' => 200,
    'profile' => $_SESSION,
  ]);

?>