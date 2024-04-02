<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Á receber - Controle de Boletos</title>

    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        a {
            cursor: pointer;
        }
    </style>

</head>

<body>

    <main>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">Contas á Receber</h1>

            <div class="col-sm-4">
                <input type="month" class="form-control" id="mes" value="<?= date('Y-m') ?>">
            </div>

        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- vencidos -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    vencidos
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="vencidos">R$ ----</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- vencem hoje -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    vencem hoje
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="vencem-hoje">R$ ----</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- á vencer -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    á vencer
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="a-vencer">R$ ----</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- recebidos -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    recebidos
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="pagos">R$ ----</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- total -->
            <div class="col-xl-6 col-md-12 mb-4">
                <div class="card border-left-dark shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    total
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="total">R$ ----</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Pagador</th>
                                <th>Data de Vencimento</th>
                                <th>Valor Total</th>
                                <th>Situação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="boletos"></tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </main>

    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/js/navbar.js"></script>
    <script src="/js/sb-admin-2.js"></script>
    <!--  -->
    <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="./js/info.js"></script>
    <!-- <script src="/js/datatables.js"></script> -->

</body>

</html>