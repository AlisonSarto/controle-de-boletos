<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gerar Boleto - Controle de Boletos</title>

    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body>

    <main>

        <h1 class="h3 mb-4 text-gray-800">Gerar Boleto</h1>

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
                        <input type="text" class="form-control" id="total">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Identificação do Boleto</label>
                        <input type="text" class="form-control" id="n_boleto">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Data de Vencimento</label>
                        <input type="date" class="form-control" id="data-vencimento">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Taxa de Emissão</label>
                        <input type="text" class="form-control" id="taxa-emissao">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Taxa de Antecipação</label>
                        <input type="text" class="form-control" id="taxa-antecipacao">
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
    <script src="./js/add.js"></script>

</body>

</html>