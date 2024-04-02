$(document).ready(function() {

  $('#salvar').click(function() {
    
    var nome = $('#nome').val();
    var chave = $('#chave').val();

    if (nome == '' || chave == '') {
      alert('Preencha todos os campos!');
      return false;
    }

    $.ajax({
      url: '/api/chaves/add',
      type: 'POST',
      data: {
        nome: nome,
        chave: chave
      },
      success: function() {
        alert('Chave adicionada com sucesso!');
        window.location.href = '/app/chaves';
      },
      error: function(err) {
        message = err.responseJSON.message;
        alert(message);
      }
    });

  });

});