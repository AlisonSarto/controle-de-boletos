$(document).ready(function () {

  const main = $("main").html();

  const linkFix = "/app"

  const navbarJson = [

    {
      type: "link",
      title: "Dashboard",
      href: "/dashboard",
      icon: "fas fa-fw fa-tachometer-alt",
    },

    {
      type: "divider",
    },

    {
      type: "link",
      title: "Á receber",
      href: "/a-receber",
      icon: "fas fa-fw fa-wallet",
    },

    {
      type: "link",
      title: "Á pagar",
      href: "/a-pagar",
      icon: "fas fa-fw fa-money-bill-wave",
    },

    {
      type: "divider",
    },

    {
      type: "link",
      title: "Contas Bancarias",
      href: "/contas",
      icon: "fas fa-fw fa-university",
    },

    {
      type: "link",
      title: "Empresas",
      href: "/empresas",
      icon: "fas fa-fw fa-building",
    },

    {
      type: "divider",
    },

    {
      type: "link",
      title: "Chaves de Acesso",
      href: "/chaves",
      icon: "fas fa-key",
    }

  ];

  const navbar = `

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/app/dashboard">
          <div class="sidebar-brand-icon">
            <img src="/favicon.ico" alt="Logo" width="45px">
          </div>
          <div class="sidebar-brand-text mx-3">Controle de Boletos</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        ${jsonToHtml(navbarJson)}

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

      </ul>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

          <!-- Topbar -->
          <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
              <i class="fa fa-bars"></i>
            </button>

            <!-- Swith de empresa -->
            <div class="w-100 text-center">

              <div class="dropdown">
                <a class="dropdown-toggle" href="#" id="empresa-atual" role="button" id="dropdownMenuLink"data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                <div id="empresas" class="dropdown-menu dropdown-menu-center shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                  <div class="dropdown-header">Escolha uma empresa:</div>
                </div>
              </div>
  
            </div>

            -

            <!-- Swith de conta -->
            <div class="w-100 text-center">

              <div class="dropdown">
                <a class="dropdown-toggle" href="#" id="conta-atual" role="button" id="dropdownMenuLink"data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                <div id="contas" class="dropdown-menu dropdown-menu-center shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                  <div class="dropdown-header">Escolha uma conta:</div>
                </div>
              </div>

            </div>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

              <div class="topbar-divider d-none d-sm-block"></div>

              <!-- Nav Item - User Information -->
              <li class="nav-item dropdown no-arrow">

                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-user"></i>
                </a>

                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="/sair">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Sair
                  </a>
                </div>
                
              </li>

            </ul>

          </nav>
          <!-- End of Topbar -->

          <!-- Begin Page Content -->
          <div class="container-fluid">

            ${main}

          </div>
          <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

      </div>
      <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

  `;

  $("body").html(navbar);


  var empresaAtualId;

  $.ajax({
    url: "/api/login/profile",
    type: "GET", 
    success: function (data) {
      empresaAtualId = data.profile.empresa_id;
      contaAtualId = data.profile.conta_id;
      adicionarEmpresas(empresaAtualId, contaAtualId);
    },
    error: function (data) {
      if (data.status == 401) {
        window.location.href = "/login";
      }
    }
  });

  
  function adicionarEmpresas(empresaAtualId, contaAtualId) {

    const urlAtual = window.location.href;

    $.ajax({
      url: "/api/empresas/view",
      type: "GET",
      success: function (data) {
        const empresas = data.empresas;

        empresas.forEach((empresa) => {
          if (empresa.id == empresaAtualId) {
            $("#empresa-atual").text(empresa.nome);
          }else {
            $("#empresas").append(`
              <a class="dropdown-item" href="/api/empresas/acess?id=${empresa.id}&return=${urlAtual}">${empresa.nome}</a>
            `);
          }
        });
      },
      error: function (data) {
        console.log('Nenhuma empresa encontrada!');
      }
    });

    $.ajax({
      url: "/api/contas/view",
      type: "GET",
      success: function (data) {
        const contas = data.contas;
        contas.forEach((conta) => {
          if (conta.id == contaAtualId) {
            $("#conta-atual").text(conta.nome);
          }else {
            $("#contas").append(`
              <a class="dropdown-item" href="/api/contas/acess?id=${conta.id}&return=${urlAtual}">${conta.nome}</a>
            `);
          }
        });
      },
      error: function (data) {
        console.log('Nenhuma conta encontrada!');
      }
    });
  }

  function jsonToHtml(navbarJson) {

    let html = "";

    navbarJson.forEach((item) => {

      if (item.type === "link") {

        html += `
          <li class="nav-item">
            <a class="nav-link" href="${linkFix + item.href}">
              <i class="${item.icon}"></i>
              <span>${item.title}</span>
            </a>
          </li>
        `;

      } else if (item.type === "divider") {

        html += `
          <hr class="sidebar-divider">
        `;

      } else if (item.type === "heading") {

        html += `
          <div class="sidebar-heading">
            ${item.title}
          </div>
        `;

      }

    });

    return html;
    
  }

});