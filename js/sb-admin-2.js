$(document).ready(function () {
  "use strict"; // Start of use strict

  windowResize()

  // Toggle the side navigation
  $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Close any open menu accordions when window is resized below 768px
  $(window).resize(function() {
    windowResize()
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  function windowResize() {
    if ($(window).width() < 768) {
      $('.sidebar .collapse').collapse('hide');
    };
    
    // Toggle the side navigation when window is resized below 480px
    if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
      $("body").addClass("sidebar-toggled");
      $(".sidebar").addClass("toggled");
      $('.sidebar .collapse').collapse('hide');
    };
  }

}); // End of use strict

// Função para formatar o campo de saldo
function maskSaldo(id) {
  var saldoInput = document.getElementById(id);

  saldoInput.addEventListener('input', function (e) {
    var start = this.selectionStart,
    end = this.selectionEnd;

    var value = this.value.replace(/[^0-9-]/g,'') / 100; // Permitir sinal de menos
    this.value = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);

    this.selectionStart = start;
    this.selectionEnd = end;
  });

  // Pré-formatar o valor do campo de entrada
  var start = saldoInput.selectionStart,
  end = saldoInput.selectionEnd;

  var value = saldoInput.value.replace(/[^0-9-]/g,'') / 100; // Permitir sinal de menos
  saldoInput.value = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);

  saldoInput.selectionStart = start;
  saldoInput.selectionEnd = end;
}
