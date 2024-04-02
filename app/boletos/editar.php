<?php

    include $_SERVER['DOCUMENT_ROOT'].'/server/db/connect.php';

    $id = $_GET['id'];

    if (empty($id)) {
        header('Location: /app/dashboard');
        exit();
    }

    $sql = "SELECT * FROM boletos WHERE id = $id";
    $res = $conn->query($sql);

    if ($res->num_rows == 0) {
        header('Location: /app/dashboard');
        exit();
    }

    $row = $res->fetch_assoc();

    $recebedor_id = $row['recebedor_id'];
    $recebedor_conta_id = $row['recebedor_conta_id'];
    $pagador_id = $row['pagador_id'];
    $pagador_conta_id = $row['pagador_conta_id'];
    $valor = $row['valor'];
    $n_boleto = $row['n_boleto'];
    $data_vencimento = $row['data_vencimento'];
    $taxa_emissao = $row['taxa_emissao'];
    $taxa_antecipacao = $row['taxa_antecipacao'];

    //? Puxa os nomes das empresas
    $sql = "SELECT nome FROM empresas WHERE id = $recebedor_id";
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    $recebedor_nome = $row['nome'];

    $sql = "SELECT nome FROM empresas WHERE id = $pagador_id";
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    $pagador_nome = $row['nome'];

    //? Puxa os nomes das contas
    $sql = "SELECT nome FROM contas WHERE id = $recebedor_conta_id";
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    $recebedor_conta_nome = $row['nome'];

    $sql = "SELECT nome FROM contas WHERE id = $pagador_conta_id";
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    $pagador_conta_nome = $row['nome'];

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Editar Boleto - Controle de Boletos</title>

    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body>

    <main>

        <h1 class="h3 mb-4 text-gray-800">Editar Boleto</h1>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Quem vai receber</label>
                        <select class="form-control" id="recebedor">
                            <option selected disabled>Selecione...</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Conta de quem vai receber</label>
                        <select class="form-control" id="conta-recebedor">
                            <option selected disabled>Selecione...</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Quem vai pagar</label>
                        <select class="form-control" id="pagador">
                            <option selected disabled>Selecione...</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Conta de quem vai pagar</label>
                        <select class="form-control" id="conta-pagador">
                            <option selected disabled>Selecione...</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Valor Total</label>
                        <input type="text" class="form-control" id="total" value="<?= $valor; ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Identificação do Boleto</label>
                        <input type="text" class="form-control" id="n_boleto" value="<?= $n_boleto; ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Data de Vencimento</label>
                        <input type="date" class="form-control" id="data-vencimento" value="<?= $data_vencimento; ?>">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Taxa de Emissão</label>
                        <input type="text" class="form-control" id="taxa-emissao" value="<?= $taxa_emissao; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Taxa de Antecipação</label>
                        <input type="text" class="form-control" id="taxa-antecipacao" value="<?= $taxa_antecipacao; ?>">
                    </div>
                </div>

                <br>
                
                <button class="btn btn-primary mt-3" id="gerar">Gerar Boleto</button>
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