$(document).ready(function(){

  maskSaldo('total');
  maskSaldo('taxa-emissao');
  maskSaldo('taxa-antecipacao');

  //? Ajax Empresas
  $.ajax({
    url: '/api/empresas/view',
    type: 'GET',
    success: function(data) {
      const empresas = data.empresas;
    
      empresas.forEach(empresa => {
        $('#pagador').append(`<option value="${empresa.id}">${empresa.nome}</option>`);
        $('#recebedor').append(`<option value="${empresa.id}">${empresa.nome}</option>`);
      });
    },
    error: function(err) {
      console.log(err);
      $('#gerar').attr('disabled', true);
    }
  });

  //? Ajax Contas
  $.ajax({
    url: '/api/contas/view',
    type: 'GET',
    success: function(data) {
      const contas = data.contas;
    
      contas.forEach(conta => {
        $('#conta-recebedor').append(`<option value="${conta.id}">${conta.nome}</option>`);
        $('#conta-pagador').append(`<option value="${conta.id}">${conta.nome}</option>`);
      });
    },
    error: function(err) {
      console.log(err);
      $('#gerar').attr('disabled', true);
    }
  });

  //* Quem vai pagar não pode receber
  $('#pagador').change(function() {
    const pagador = $('#pagador').val();
    const recebedor = $('#recebedor').val();

    if (pagador == recebedor) {
      $('#recebedor').val('');
    }
  });

  //* Quem vai receber não pode pagar
  $('#recebedor').change(function() {
    const pagador = $('#pagador').val();
    const recebedor = $('#recebedor').val();

    if (pagador == recebedor) {
      $('#pagador').val('');
    }
  });


  $('#gerar').click(function() {
  
    var recebedor = $('#recebedor').val();
    var pagador = $('#pagador').val();
    var contaRecebedor = $('#conta-recebedor').val();
    var contaPagador = $('#conta-pagador').val();
    var total = formataValor($('#total').val());
    var nBoleto = $('#n_boleto').val();
    var dataVencimento = $('#data-vencimento').val();
    var taxaEmissao = formataValor($('#taxa-emissao').val());
    var taxaAntecipacao = formataValor($('#taxa-antecipacao').val());

    if (recebedor === null) {
      return invalidField('recebedor');
    }
    if (pagador === null) {
      return invalidField('pagador');
    }
    if (contaRecebedor === null) {
      return invalidField('conta-recebedor');
    }
    if (contaPagador === null) {
      return invalidField('conta-pagador');
    }
    if (total === '' || total <= 0) {
      return invalidField('total');
    }
    if (nBoleto === '') {
      return invalidField('n_boleto');
    }
    if (dataVencimento === '') {
      return invalidField('data-vencimento');
    }

    var urlParams = new URLSearchParams(window.location.search);
    var id = urlParams.get('id');

    $.ajax({
      url: '/api/boletos/edit',
      type: 'POST',
      data: {
        id: id,
        recebedor: recebedor,
        pagador: pagador,
        conta_recebedor: contaRecebedor,
        conta_pagador: contaPagador,
        total: total,
        n_boleto: nBoleto,
        data_vencimento: dataVencimento,
        taxa_emissao: taxaEmissao,
        taxa_antecipacao: taxaAntecipacao
      },
      success: function(data) {
        var message = data.message;
        alert(message);
        window.location.href = '/app/dashboard';
      },
      error: function(err) {
        console.log(err);
        var message = err.responseJSON.message;
        alert(message);
      }
    });

    function invalidField(id) {
      $(`#${id}`).addClass('is-invalid');
      $(`#${id}`).focus(function() {
        $(`#${id}`).removeClass('is-invalid');
      });
      $(`#${id}`).change(function() {
        $(`#${id}`).removeClass('is-invalid');
      });
      return false;
    }

    function formataValor(valor) {
      valor = valor.replace('R$ ', '');
      valor = valor.replace(/\./g, '');
      valor = valor.replace(',', '.');
      return valor;
    }

  });

});