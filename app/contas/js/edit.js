$(document).ready(function(){

  maskSaldo('saldo');
  
  $('#salvar').click(function(){

    var id = new URLSearchParams(window.location.search).get('id');

    var nome = $('#nome').val();
    var saldo = $('#saldo').val();

    //? Formata para o banco de dados
    saldo = saldo.replace('R$ ', '');
    saldo = saldo.replace(/\./g, '');
    saldo = saldo.replace(',', '.');

    if(nome == ''){
      $('#nome').addClass('is-invalid');
      $('#nome').focus();
      return false;
    }

    if (saldo == '') {
      $('#saldo').addClass('is-invalid');
      $('#saldo').focus();
      return false;
    }

    $('#nome').removeClass('is-invalid');
    $('#saldo').removeClass('is-invalid');

    $.ajax({
      url: '/api/contas/edit',
      type: 'POST',
      data: {
        id: id,
        nome: nome,
        saldo: saldo
      },
      success: function(response){
        if (response.status == 200) {
          window.location.href = '../contas';
        }else {
          console.log(response);
          alert(response.message);
        }
      },
      error: function(response){
        console.log(response);
        var message = response.responseJSON.message;
        alert(message);
      }
    });

  });

});