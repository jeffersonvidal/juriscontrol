<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    

    <title>JurisControl - Sistema de Controle Jurídico</title>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark"><!--top nav-->
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{ route('dashboard.index') }}" title="Sistema de Controle Jurídico">JurisControl</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <!--vai um form aqui -->
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <!--alerta de notificações -->
            <div class="dropdown dropstart">
                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-bell"></i>
                    <span class="position-absolute top-0 start-0 translate-bottom badge rounded-pill bg-danger">
                        9
                    </span>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Notificação 01</a></li>
                    <li><a class="dropdown-item" href="#">Notificação 02</a></li>
                    <li><a class="dropdown-item" href="#">Notificação 03</a></li>
                </ul>
            </div>

            <!--Alertas de lembretes -->
            <div class="dropdown dropstart">
                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span class="position-absolute top-0 start-0 translate-bottom badge rounded-pill bg-danger">
                        7
                    </span>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addLembrete">Novo Lembrete</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Lembrete 01</a></li>
                </ul>
            </div>

            <!--Perfil do usuário-->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('profiles.show') }}" title="Ver Perfil">Perfil</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="{{ route('login.destroy') }}" title="Sair do Sistema">Sair</a></li>
                </ul>
            </li>
        </ul>
    </nav><!--end top nav-->

    <!--start sidebar-->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="{{ route('dashboard.index') }}" title="Página Inicial do Painel Administrativo">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Painel
                        </a>
                        
                        <!-- Gestão Administrativa-->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdm" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-briefcase"></i></div>
                                Gestão Adm
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                            <div class="collapse" id="collapseAdm" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ route('users.index') }}" title="Gestão de Usuários do Sistema">Usuários</a>
                                    <a class="nav-link" href="{{ route('external-offices.index') }}" title="Gestão de Escritórios Externos / Parceiros">Escritórios Externos</a>
                                    <a class="nav-link" href="" title="Gestão de Gamificação de Usuários do Sistema">Gamificação</a>
                                </nav>
                            </div>

                        <!-- Gestão de Clientes-->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseClients" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                                Gestão de Clientes
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                            <div class="collapse" id="collapseClients" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ route('customers.index') }}" title="Gestão de Clientes">Clientes</a>
                                </nav>
                            </div>

                        <!-- Gestão Jurídica-->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseJuridico" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-scale-balanced"></i></div>
                                Gestão Jurídica
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                            <div class="collapse" id="collapseJuridico" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ route('events.index') }}" title="Gestão de Agenda">Agenda</a>
                                    <a class="nav-link" href="{{ route('tasks.index') }}" title="Gestão de Tarefas">Tarefas Diárias</a>
                                    <a class="nav-link" href="{{ route('external-petitions.index') }}" title="Petições de Parceiros">Petições Parceiros</a>
                                    <a class="nav-link" href="{{ route('hearings.index') }}" title="Audiências e Perícias de Parceiros">Audiências/Perícias</a>
                                    <a class="nav-link" href="{{ route('legal-processes.index') }}" title="Gestão de Processos">Processos</a>
                                    <a class="nav-link" href="{{ route('document-templates.index') }}" title="Modelos de Documentos">Modelos de Documentos</a>
                                    <a class="nav-link" href="" title="Gestão de Casos e Consultivos">Casos e Consultivos</a>
                                    <a class="nav-link" href="{{ route('labels.index') }}" title="Gestão de Etiquestas do Sistema">Etiquetas</a>
                                </nav>
                            </div>

                        <!-- Gestão Financeira-->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseFinance" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-sack-dollar"></i></div>
                                Gestão Financeira
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                            <div class="collapse" id="collapseFinance" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ route('invoices.index') }}" title="Contas a Pagar e Receber">Pagar e Receber</a>
                                    <a class="nav-link" href="{{ route('payments.index') }}" title="Pagamentos">Pagamentos</a>
                                </nav>
                            </div>

                        <!-- Relacionamento com Clientes-->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCRM" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                                CRM
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                            <div class="collapse" id="collapseCRM" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="" title="">Aniversariantes</a>
                                    <a class="nav-link" href="" title="">Campanhas</a>
                                    <a class="nav-link" href="" title="">Email Marketing</a>
                                </nav>
                            </div>

                        <!-- Gestão de RH-->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRH" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-people-group"></i></div>
                                Gestão de RH
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                            <div class="collapse" id="collapseRH" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="" title="Gestão de Funcionários">Funcionários</a>
                                    <a class="nav-link" href="" title="Gestão de Cargas Horárias de Funcionários">Cargas Horárias</a>
                                    <a class="nav-link" href="" title="Gestão de Treinamentos para Funcionários">Treinamento</a>
                                </nav>
                            </div>

                        <!-- Gestão de Configurações-->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseConfig" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div>
                                Configurações
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                            <div class="collapse" id="collapseConfig" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="" title="Gestão de Funcionários">Tarefas Padrão</a>
                                    <a class="nav-link" href="" title="Gestão de Funcionários">Configurações</a>
                                </nav>
                            </div>

                        <!-- Gestão de Suporte-->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSuporte" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-headset"></i></div>
                                Suporte
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                            <div class="collapse" id="collapseSuporte" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="" title="Aprenda utilizar os recursos do sistema">Tutoriais</a>
                                    <a class="nav-link" href="" title="Pedir ajuda ao suporte do sistema">Abrir Chamado</a>
                                </nav>
                            </div>
                        
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logado:</div>
                    @if (auth()->check())
                        {{ auth()->user()->name }}
                    @endif
                </div>
            </nav>
        </div>

        <!--start content page-->
        <div id="layoutSidenav_content">
            <main>
                @yield('content') <!--conteúdo das páginas dinâmicas-->
            </main>
            
            <!--start footer content page-->
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; JurisControl 2024-{{ date('Y') }}</div>
                        <div>
                            <a class="text-decoration-none" href="#">Política de Privacidade</a>
                            &middot;
                            <a class="text-decoration-none" href="#">Termos &amp; Condições</a>
                        </div>
                    </div>
                </div>
            </footer>
            <!--end footer content page-->
        </div><!--end content page-->
    </div><!--end sidebar-->



<!-- addLembrete -->
<div class="modal fade" id="addLembrete" tabindex="-1" aria-labelledby="addLembreteModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Lembrete</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form id="createAddressForm" class="row g-3">
                @csrf

                
                <fieldset>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="alert_time" class="form-label">Data e Hora</label>
                            <input type="datetime-local" class="form-control" id="alert_time" name="alert_time" value="{{ old('alert_time') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="target_user_id" class="form-label">Para quem?</label>
                            <select id="target_user_id" name="target_user_id" class="form-select">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="message" class="form-label">Mensagem</label>
                            <textarea class="form-control" id="edit_message" name="message" rows="3">{{ old('message') }}</textarea>
                        </div>
                    </div>

                </fieldset>

                
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                    <input type="hidden" class="form-control" id="author_id" name="author_id" value="{{ auth()->user()->id }}">                 
                </div>
                
            
      </div><!--fim modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary addButton">Salvar <i class="fa-regular fa-floppy-disk"></i></button>
      </div><!--fim modal-footer-->
      </form><!--finalizando form aqui para garantir pegar a ação do botão de salvar-->
    </div>
  </div>
</div><!-- fim addLembrete -->


</body>
</html>