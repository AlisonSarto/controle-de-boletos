$(document).ready(function(){
  
  $('#salvar').click(function(){

    var id = new URLSearchParams(window.location.search).get('id');

    var nome = $('#nome').val();

    if(nome == ''){
      $('#nome').addClass('is-invalid');
      $('#nome').focus();
      return false;
    }

    $('#nome').removeClass('is-invalid');

    $.ajax({
      url: '/api/empresas/edit',
      type: 'POST',
      data: {
        id: id,
        nome: nome,
      },
      success: function(response){
        if (response.status == 200) {
          window.location.href = '../empresas';
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