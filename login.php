<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Controle de Boletos - Login</title>

    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary" style="height: 100vh;">

    <div class="d-flex w-100 h-100 justify-content-center align-items-center my-class">
        <div class="card o-hidden border-0 shadow-lg my-class m-4" style="width: 400px;">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Bem-vindo!</h1>
                                <p class="text-danger" id="alert"></p>
                            </div>
                            <div class="user" action="login.php" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="chave" placeholder="Digite a chave de acesso">
                                </div>
                                <button type="button" id="submit" class="btn btn-primary btn-user btn-block">
                                    Entrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/js/sb-admin-2.js"></script>
    <script>
        $(document).ready(function () {

            $('#chave').focus();

            $('input').keypress(function (e) {
                if (e.which == 13) {
                    $('#submit').click();
                }
            });

            $('#submit').click(function () {
                var chave = $('#chave').val();

                if (chave === "") {
                    $('#chave').addClass('is-invalid');
                    $('#chave').focus();
                    return;
                }
                
                $('#submit').prop('disabled', true);
                $('#submit').text('Entrando...');

                $.ajax({
                    url: '/api/login/',
                    type: 'POST',
                    data: {
                        chave: chave
                    },
                    success: function (data) {
                        if (data.status == 200) {
                            $('#submit').val('Redirecionando...');
                            window.location.href = '/app/dashboard';
                        } else {
                            $('#submit').val('Entrar');
                            $('#submit').prop('disabled', false);
                        }
                    },
                    error: function (xhr) {
                        $('#submit').text('Entrar');
                        $('#submit').prop('disabled', false);
                        if (xhr.status == 401) {
                            $('#chave').addClass('is-invalid');
                            $('#alert').text('Chave de acesso inválida.');
                            $('#chave').focus();
                        } else {
                            $('#alert').text('Erro interno. Tente novamente mais tarde.');
                        }
                    }
                });
                
            });

        });
    </script>

</body>

</html>