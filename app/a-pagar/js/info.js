$(document).ready(function() {

  var mes = $('#mes').val();

  newData(mes);

  $('#mes').change(function() {
    var mes = $(this).val();
    $('#boletos').empty();
    newData(mes);
  });

  $('#boletos').on('click', '.situacao', function() {
  
    const id = $(this).data('id');
    const text = $(this).find('.badge').text();
    const $this = $(this);

    //? Sistema Otimista
    if (text == 'Em aberto') {
      $this.html(`<span class="badge bg-success text-white">Pago</span>`);
    } else {
      $this.html(`<span class="badge bg-secondary text-white">Em aberto</span>`);
    }

    $.ajax({
      url: '/api/boletos/situacao',
      type: 'POST',
      data: {
        id: id
      },
      assync: false,
      error: function() {
        console.log('Erro ao atualizar situação do boleto');
        if (text == 'Em aberto') {
          $this.html(`<span class="badge bg-secondary text-white">Em aberto</span>`);
        } else {
          $this.html(`<span class="badge bg-success text-white">Pago</span>`);
        }
      }
    });

    $.ajax({
      url: '/api/boletos/a-pagar',
      type: 'GET',
      data: {
        mes: $('#mes').val()
      },
      assync: false,
      success: function(data) {
        var vencidos = data.vencidos;
        var vencemHoje = data.vencem_hoje;
        var aVencer = data.a_vencer;
        var pagos = data.pagos;
        var total = data.total;

        //? formata valores em R$
        vencidos = vencidos.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});
        vencemHoje = vencemHoje.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});
        aVencer = aVencer.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});
        pagos = pagos.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});
        total = total.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});

        //* Exibe
        $('#vencidos').text(vencidos);
        $('#vencem-hoje').text(vencemHoje);
        $('#a-vencer').text(aVencer);
        $('#pagos').text(pagos);
        $('#total').text(total);

      },
      error: function(err) {
        console.log(err);
      }
    });

  });

  $('#dataTable').on('click', '.delete', function(e) {
    e.preventDefault();

    var id = $(this).parent().data('id');

    if (confirm(`Deseja realmente deletar esse boleto?`)) {
      $.ajax({
        url: `/api/boletos/delete?id=${id}`,
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

  function newData(mes) {
    
    $.ajax({
      url: '/api/boletos/a-pagar',
      type: 'GET',
      data: {
        mes: mes
      },
      success: function(data) {
        var vencidos = data.vencidos;
        var vencemHoje = data.vencem_hoje;
        var aVencer = data.a_vencer;
        var pagos = data.pagos;
        var total = data.total;

        //? formata valores em R$
        vencidos = vencidos.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});
        vencemHoje = vencemHoje.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});
        aVencer = aVencer.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});
        pagos = pagos.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});
        total = total.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});

        //* Exibe
        $('#vencidos').text(vencidos);
        $('#vencem-hoje').text(vencemHoje);
        $('#a-vencer').text(aVencer);
        $('#pagos').text(pagos);
        $('#total').text(total);

        //? tabela
        const table = $('#boletos');
        const boletos = data.boletos;

        boletos.forEach(boleto => {

          if (boleto.situacao == 0) { // Em aberto
            var badge = `<span class="badge bg-secondary text-white">Em aberto</span>`;
          }else {
            var badge = `<span class="badge bg-success text-white">Pago</span>`;
          }

          var valor = parseFloat(boleto.valor);
          valor = valor.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});

          var dataVencimento = boleto.data_vencimento;
          dataVencimento = dataVencimento.split('-').reverse().join('/');

          table.append(`
            <tr>
              <td>${boleto.recebedor}</td>
              <td>${dataVencimento}</td>
              <td><a href="#">${valor}</a></td>
              <td>
                <a class="situacao" data-id="${boleto.id}">
                  ${badge}
                </a>
              </td>
              <td>
                <div class="d-flex flex-nowrap" data-id="${boleto.id}">
                  <a href="../boletos/visualizar?id=${boleto.id}" class="btn btn-primary btn-sm mr-1"><i class="fas fa-info"></i></a>
                  <a href="../boletos/editar?id=${boleto.id}" class="btn btn-warning btn-sm mr-1">Editar</a>
                  <a href="#" class="btn btn-danger btn-sm mr-1 delete">Deletar</a>
                </div>
              </td>
            </tr>
          `);
        });

      },
      error: function(err) {
        console.log(err);
      }
    });
    
  }

});