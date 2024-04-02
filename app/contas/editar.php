<?php

    include $_SERVER['DOCUMENT_ROOT'].'/server/db/connect.php';

    $id = $_GET['id'] ?? null;

    if ($id == null) {
        header('Location: /app/contas');
    }

    $sql = "SELECT * FROM contas WHERE id = $id";
    $res = $conn->query($sql);

    if ($res->num_rows == 0) {
        header('Location: /app/contas');
    }

    $conta = $res->fetch_assoc();

    $conta_id = $conta['id'];
    $conta_nome = $conta['nome'];
    $empresa_id = $_SESSION['empresa_id'];

    $sql = "SELECT * FROM saldos WHERE empresa_id = $empresa_id AND conta_id = $conta_id";
    $res = $conn->query($sql);

    if ($res->num_rows == 0) {
        $saldo = 0;
    } else {
        $saldo = $res->fetch_assoc()['saldo'];
    }

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Editar Conta Bancária - Controle de Boletos</title>

    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body>

    <main>

        <h1 class="h3 mb-4 text-gray-800">Editar Conta Bancária</h1>

        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" value="<?= $conta_nome ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Saldo</label>
                        <input type="text" class="form-control" id="saldo" value="<?= $saldo ?>">
                    </div>
                </div>

                <br>

                <button type="button" class="btn btn-primary" id="salvar">Salvar</button>

            </div>
        </div>
        
    </main>

    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/js/navbar.js"></script>
    <script src="/js/sb-admin-2.js"></script>
    <!--  -->
    <script src="./js/edit.js"></script>
</body>

</html>