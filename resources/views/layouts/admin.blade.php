<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    

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
                    @foreach($notifications as $notification) 
                        <li><a class="dropdown-item" href="#">{{ $notification }}</a></li>
                    @endforeach
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
                <ul id="reminder-list" class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addLembrete"><i class="fa-solid fa-plus"></i> Novo Lembrete</a></li>
                    <li><hr class="dropdown-divider"></li>
                    @foreach($reminders as $reminder) 
                            <span class="d-flex flex-row justify-content-center">
                                <a href="#" class="dropdown-item reminderDetails" data-id="{{ $reminder->id }}" data-description="{{ $reminder->description }}" data-responsible_id="{{ $reminder->responsible_id }}" data-author_id="{{ $reminder->author_id }}" data-company_id="{{ $reminder->company_id }}" data-reminder_date="{{ $reminder->reminder_date }}" data-status="{{ $reminder->status }}">{{ limitText($reminder->description, 17) }}</a>
                                <button class="text-decoration-none btn btn-sm editBtn" title="Alterar Registro" data-id="{{ $reminder->id }}" data-description="{{ $reminder->description }}" data-responsible_id="{{ $reminder->responsible_id }}" data-author_id="{{ $reminder->author_id }}" data-company_id="{{ $reminder->company_id }}" data-reminder_date="{{ $reminder->reminder_date }}" data-status="{{ $reminder->status }}"
                                    data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fa-solid fa-pencil"></i></button>
                                <button class="text-decoration-none btn btn-sm text-danger deleteBtn" title="Apagar Registro" data-id="{{ $reminder->id }}"  ><i class="fa-solid fa-trash"></i></button>
                            </span>
                        </li>
                    @endforeach
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
      <div class="cadReminderView">
        <div class="modal-body">

            <form id="createReminderForm" class="row g-3">
                    @csrf

                    
                    <fieldset>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="reminder_date" class="form-label">Data e Hora</label>
                                <input type="datetime-local" class="form-control" id="reminder_date" name="reminder_date" value="{{ old('reminder_date') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="target_user_id" class="form-label">Para quem?</label>
                                <select id="responsible_id" name="responsible_id" class="form-select">
                                    <option value="">Escolha um usuário</option>
                                    
                                    @foreach ($usersByCompany as $userByCompany)
                                        <option value="{{ $userByCompany->id }}">{{ $userByCompany->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <label for="description" class="form-label">Mensagem</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>
                        </div>

                    </fieldset>

                    
                    <div class="col-md-12">
                        <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                        <input type="hidden" class="form-control" id="author_id" name="author_id" value="{{ auth()->user()->id }}">                 
                    </div>
                    
                </form><!--finalizando form aqui para garantir pegar a ação do botão de salvar-->
        </div><!--fim modal-body-->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary addButton">Salvar <i class="fa-regular fa-floppy-disk"></i></button>
        </div><!--fim modal-footer-->
      </div><!--Fim cadReminderView -->
      
    </div>
  </div>
</div><!-- fim addLembrete -->

<!-- updateLembrete -->
<div class="modal fade" id="updateLembrete" tabindex="-1" aria-labelledby="updateLembreteModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="detailsModalLabel">Detalhes do Lembrete</h1>
        <h1 class="modal-title fs-5" id="updateModalLabel" style="display:none;">Alterar Lembrete</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="detailsReminder" id="detailsReminder">
        <div class="modal-body">
        <dl class="row">              
                <dt class="col-sm-3">ID #:</dt>
                <dd class="col-sm-9" id="details_id"></dd>
                
                <div class="col-md-12">
                    <dt class="col-sm-3">Data / Hora:</dt>
                    <dd class="col-sm-9" id="details_reminder_date"></dd>
                </div>

                <div class="col-md-12">
                    <dt class="col-sm-3">Lembrete para:</dt>
                    <dd class="col-sm-9" id="details_end"></dd>
                </div>
                
                <dt class="col-sm-3">Descrição:</dt>
                <dd class="col-sm-9" id="details_description"></dd>
    
            </dl>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnViewEditReminder" id="btnViewEditReminder" data-id="{{ $reminder->id }}" data-description="{{ $reminder->description }}" data-responsible_id="{{ $reminder->responsible_id }}" data-author_id="{{ $reminder->author_id }}" data-company_id="{{ $reminder->company_id }}" data-reminder_date="{{ $reminder->reminder_date }}" data-status="{{ $reminder->status }}">Alterar Lembrete <i class="fa-solid fa-pen"></i></button>
            </div><!--fim modal-footer-->
        </div><!--Fim modal-body-->
      </div><!--Fim viewReminder-->

      <!--updateReminderView-->
      <div class="updateReminderView" id="updateReminderView" style="display:none;">
        <div class="modal-body">

            <form id="updateReminderForm" class="row g-3">
                    @csrf

                    
                    <fieldset>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="reminder_date" class="form-label">Data e Hora</label>
                                <input type="datetime-local" class="form-control" id="edit_reminder_date" name="reminder_date" value="{{ old('reminder_date') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="target_user_id" class="form-label">Para quem?</label>
                                <select id="edit_responsible_id" name="responsible_id" class="form-select">
                                    <option value="">Escolha um usuário</option>
                                    
                                    @foreach ($usersByCompany as $userByCompany)
                                        <option value="{{ $userByCompany->id }}">{{ $userByCompany->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <label for="description" class="form-label">Mensagem</label>
                                <textarea class="form-control" id="edit_description" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>
                        </div>

                    </fieldset>

                    
                    <div class="col-md-12">
                        <input type="hidden" class="form-control" id="edit_company_id" name="company_id" value="{{ auth()->user()->company_id }}">                 
                        <input type="hidden" class="form-control" id="edit_author_id" name="author_id" value="{{ auth()->user()->id }}">                 
                        <input type="hidden" class="form-control" id="edit_id" name="id" value="">                 
                    </div>
                    
                </form><!--finalizando form aqui para garantir pegar a ação do botão de salvar-->
        </div><!--fim modal-body-->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="editReminderCancel">Cancelar</button>
            <button type="submit" class="btn btn-primary updateReminderBtn" id="updateReminderBtn">Salvar Alterações <i class="fa-regular fa-floppy-disk"></i></button>
        </div><!--fim modal-footer-->
      </div><!--Fim updateReminderView -->
      
    </div>
  </div>
</div><!-- fim updateLembrete -->


<!--Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!--Scripts -->
<script>
$(document).ready(function(){
    /** Cadastrar lembrete */
    $('#createReminderForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route('reminders.store') }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#createModal').modal('hide');
                if(response){
                    Swal.fire('Pronto!', response.success, 'success');
                }
                setTimeout(function() {
                    location.reload(true); // O parâmetro 'true' força o recarregamento a partir do servidor
                }, 2000); // 3000 milissegundos = 3 segundos
            },
            error: function(response) {
                console.log(response.responseJSON);
                if(response.responseJSON){
                    Swal.fire('Erro!', response.responseJSON.message, 'error');
                }
            }
        });
    });

    /**Função para alarme dos lembretes */
    function loadReminders() {
        $.ajax({
            url: '{{ route('fetch.index') }}',
            method: 'GET',
            success: function(data) {
                var reminderList = $('#reminder-list');
                reminderList.empty();

                data.forEach(function(reminder) {
                    var listItem = $('<li>')
                        .attr('data-id', reminder.id)
                        .attr('data-status', reminder.status)
                        .attr('data-description', reminder.description)
                        .attr('data-reminder_date', reminder.reminder_date)
                        .text(reminder.description + ' - ' + reminder.reminder_date);
                    reminderList.append(listItem);
                });
            }
        });
    }

    /**Verifica novos lembretes */
    function checkReminders() {
        console.log('checkReminders function called');
        var reminders = document.querySelectorAll('#reminder-list li');
        console.log('Number of reminders found:', reminders.length);

        reminders.forEach(function(reminder) {
            var description = reminder.dataset.description;
            var reminderTimeText = reminder.dataset.reminder_date;

            if (!reminderTimeText) {
                console.log('reminder_time is undefined or invalid');
                return;
            }

            var reminderTime = new Date(reminderTimeText);
            if (isNaN(reminderTime)) {
                console.log('Invalid date format:', reminderTimeText);
                return;
            }

            var now = new Date();

            console.log('Reminder description:', description);
            console.log('Reminder time text:', reminderTimeText);
            console.log('Reminder time:', reminderTime, 'Current time:', now);

            if (reminderTime.getFullYear() === now.getFullYear() &&
                reminderTime.getMonth() === now.getMonth() &&
                reminderTime.getDate() === now.getDate() &&
                reminderTime.getHours() === now.getHours() &&
                reminderTime.getMinutes() === now.getMinutes() &&
                reminder.dataset.status != 'read') {

                console.log('Condition passed: ', 'reminderTime:', reminderTime, 'now:', now, 'status:', reminder.dataset.status);

                var reminderId = reminder.dataset.id;
                console.log('Displaying reminder with ID:', reminderId);

                toastr.options = {
                    "closeButton": true,
                    "positionClass": "toast-top-right",
                    "onclick": function() {
                        markAsRead(reminderId);
                    }
                };
                toastr.info('Lembrete: ' + description);

                var audio = new Audio('{{ asset('AlarmRadiate.mp3') }}');
                audio.loop = true;

                // Garantir que o áudio está pronto para ser reproduzido
                audio.addEventListener('canplaythrough', function() {
                    audio.play().catch(function(error) {
                        console.log('Audio playback failed:', error);
                    });
                });

                toastr.options.onHidden = function() {
                    audio.pause();
                    audio.currentTime = 0; // Reseta o som para o início
                };
            } else {
                console.log('Condition not met', 'reminderTime:', reminderTime, 'now:', now, 'status:', reminder.dataset.status);
            }
        });
    }


    function markAsRead(reminderId) {
        $.ajax({
            url: '/mark-as-read-reminders/' + reminderId,
            type: 'PUT',
            data: {_token: '{{ csrf_token() }}'},
            success: function(response) {
                console.log(response.success);
                // Atualiza o status no DOM
                $('li[data-id="' + reminderId + '"]').attr('data-status', 'read');
            }
        });
    }

    setInterval(checkReminders, 60000); // Verifica a cada minuto 60000


    /**Popula a modal de detalhes do lembrete com os dados vindos do banco de dados */
    $('.reminderDetails').on('click', function(event) {
        //console.log($('.reminderDetails'));
        
        var dados = {
            id: $(this).attr('data-id'),
            description: $(this).attr('data-description'),
            responsible_id: $(this).attr('data-responsible_id'),
            author_id: $(this).attr('data-author_id'),
            company_id: $(this).attr('data-company_id'),
            reminder_date: $(this).attr('data-reminder_date'),
            status: $(this).attr('data-status')
        };

        // Popula os dados na modal
        $('#details_id').text(dados.id);
        $('#details_description').text(dados.description);
        $('#details_responsible_id').text(dados.responsible_id);
        $('#details_author_id').text(dados.author_id);
        $('#details_company_id').text(dados.company_id);
        $('#details_reminder_date').text(dados.reminder_date);
        $('#details_status').text(dados.status);

        // Armazena os dados no botão de edição para uso posterior 
        $('#btnViewEditReminder').data('reminderData', dados);
        
        // Abre a modal
        $('#updateLembrete').modal('show');
    });


    /**Pega os dados do lembrete vindos do banco de dados e salva em um array */
    $('.btnViewEditReminder').on('click', function(event) {
        var dados = $(this).data('reminderData'); // Recupera os dados armazenados
        fillUpdateReminderForm(dados);
    });

    /**Ocultar detalhes do lembrete e mostra formulário de alteração de lembrete */
    document.getElementById("btnViewEditReminder").addEventListener("click", function() { 
        // Esconder viewEventDetails e detailsModalLabel 
        document.getElementById("detailsReminder").style.display = "none"; 
        document.getElementById("detailsModalLabel").style.display = "none"; 
        document.getElementById("btnViewEditReminder").style.display = "none"; 
        // Mostrar viewEditEvent e editModalLabel 
        document.getElementById("updateReminderView").style.display = "block"; 
        document.getElementById("updateModalLabel").style.display = "block"; 
    });

    /**Mostra os detalhes do lembrete e fecha formulário de alterar lembrete*/
    document.getElementById("editReminderCancel").addEventListener("click", function() { 
        // Esconder viewEditEvent e editModalLabel 
        document.getElementById("updateReminderView").style.display = "none"; 
        document.getElementById("updateModalLabel").style.display = "none"; 
        // Mostrar viewEventDetails e detailsModalLabel 
        document.getElementById("detailsReminder").style.display = "block"; 
        document.getElementById("detailsModalLabel").style.display = "block"; 
        document.getElementById("btnViewEditReminder").style.display = "block"; 
    });

    /**Função para preencher campos do formuláro de update */
    function fillUpdateReminderForm(dados){
        //console.log(dados);
        $('#edit_id').val(dados.id);
        $('#edit_reminder_date').val(dados.reminder_date);
        $('#edit_responsible_id').val(dados.responsible_id);
        $('#edit_company_id').val(dados.company_id);
        $('#edit_description').val(dados.description);
        $('#edit_status').val(dados.status);
        $('#edit_author_id').val(dados.author_id);
    }
    
    

}); //Fim document.ready

    
</script>

</body>
</html>



