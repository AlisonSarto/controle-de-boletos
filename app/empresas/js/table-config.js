$(document).ready(function() {

  $.ajax({
    url: '/api/empresas/view',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      const empresas = data.empresas;

      // verifica quantas contas tem

      var tbody = "<tbody>";
      empresas.forEach(empresa => {
        tbody += `
          <tr>
            <td>${empresa.nome}</td>
            <td>
              <div class="d-flex flex-nowrap" data-id="${empresa.id}" data-name="${empresa.nome}">
                <a href="./editar?id=${empresa.id}" class="btn btn-warning btn-sm mr-1">Editar</a>
                <a href="#" class="btn btn-danger btn-sm mr-1 delete">Deletar</a>
              </div>
            </td>
          </tr>
        `;
      });
      tbody += "</tbody>";

      $('#dataTable').append(tbody);

      $('#dataTable').DataTable();
    },
    error: function() {
      $('#dataTable').DataTable();
    }
  });

  $('#dataTable').on('click', '.delete', function(e) {
    e.preventDefault();

    var id = $(this).parent().data('id');
    var name = $(this).parent().data('name');

    if (confirm(`Deseja realmente deletar a empresa ${name}?`)) {
      $.ajax({
        url: `/api/empresas/delete?id=${id}`,
        type: 'DELETE',
        success: function() {
          window.location.reload();
        },
        error: function(err) {
          message = err.responseJSON.message;
          alert(message);
        }
      });
    }
  });
  
});