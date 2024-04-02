$(document).ready(function() {

  $.ajax({
    url: '/api/chaves/view',
    type: 'GET',
    success: function(data) {
      const chaves = data.chaves;

      chaves.forEach(chave => {
        $('#chaves').append(`
          <tr>
            <td>${chave.nome}</td>
            <td>
              <div class="d-flex flex-nowrap" data-id="${chave.id}"">
                <a href="#" class="btn btn-danger btn-sm mr-1 delete">Deletar</a>
              </div>
            </td>
        `);
      });
    },
    error: function(data) {
      console.log(data);
    }  
  });

  $('#chaves').on('click', '.delete', function(e) {
    e.preventDefault();

    var id = $(this).parent().data('id');

    if (confirm('Deseja realmente deletar a chave?')) {
      $.ajax({
        url: `/api/chaves/delete?id=${id}`,
        type: 'DELETE',
        success: function() {
          window.location.reload();
        },
        error: function(err) {
          var message = err.responseJSON.message;
          alert(message);
        }
      });
    }
  });

});