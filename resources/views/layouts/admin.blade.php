<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    

    <title>JurisControl - Sistema de Controle Jurídico</title>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark"><!--top nav-->
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="" title="Sistema de Controle Jurídico">JurisControl</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <!--vai um form aqui -->
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="" title="Ver Perfil">Perfil</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="" title="Sair do Sistema">Sair</a></li>
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
                        <a class="nav-link" href="" title="Página Inicial do Painel Administrativo">
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
                                    <a class="nav-link" href="" title="Gestão de Usuários do Sistema">Usuários</a>
                                    <a class="nav-link" href="" title="Gestão de Etiquestas do Sistema">Etiquetas</a>
                                    <a class="nav-link" href="" title="Gestão de Tarefas">Tarefas</a>
                                    <a class="nav-link" href="" title="Gestão de Eventos">Eventos</a>
                                    <a class="nav-link" href="" title="Gestão de Escritórios Externos / Parceiros">Escritórios Externos</a>
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
                                    <a class="nav-link" href="" title="Gestão de Clientes">Clientes</a>
                                    <a class="nav-link" href="" title="Gestão de Casos e Processos">Processos</a>
                                    <a class="nav-link" href="" title="Gestão de Casos / Consultivos">Casos / Consultivos</a>
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
                                    <a class="nav-link" href="" title="Caixa da Empresa">Caixa</a>
                                    <a class="nav-link" href="" title="Contas a Pagar e Receber">Pagar e Receber</a>
                                    <a class="nav-link" href="" title="Pagamentos">Pagamentos</a>
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

                        <!-- Gestão de RH-->
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



</body>
</html>