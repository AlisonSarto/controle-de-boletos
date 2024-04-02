$(document).ready(function(){

  $('#salvar').click(function(){

    var nome = $('#nome').val();

    if(nome == ''){
      $('#nome').addClass('is-invalid');
      $('#nome').focus();
      return false;
    }

    $('#nome').removeClass('is-invalid');

    $.ajax({
      url: '/api/contas/add',
      type: 'POST',
      data: {
        nome: nome
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