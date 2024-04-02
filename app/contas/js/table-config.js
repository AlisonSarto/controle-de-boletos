$(document).ready(function() {

  $.ajax({
    url: '/api/contas/view',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      const contas = data.contas;

      var tbody = "<tbody>";
      contas.forEach(conta => {

        var saldo = parseFloat(conta.saldo).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

        tbody += `
          <tr>
            <td>${conta.nome}</td>
            <td>
              <a href="#" class="editar">${saldo}</a>
            </td>
            <td>
              <div class="d-flex flex-nowrap" data-id="${conta.id}" data-name="${conta.nome}" data-saldo="${conta.saldo}">
                <a href="./editar?id=${conta.id}" class="btn btn-warning btn-sm mr-1">Editar</a>
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

    if (confirm(`Deseja realmente deletar a conta ${name}?`)) {
      $.ajax({
        url: `/api/contas/delete?id=${id}`,
        type: 'DELETE',
        success: function() {
          window.location.reload();
        },
        error: function() {
          alert('Erro ao deletar conta');
        }
      });
    }
  });
  
});