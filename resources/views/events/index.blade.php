@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>

<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3">Agenda</h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Agenda</li>
        </ol>
    </div>    

    <div class="card mb-4 border-light shadow-sm">
        

        <div class="card-body">
            <div id="calendar"></div>
        </div><!--fim card-body-->
    </div><!--fim card -->


<!-- detailsModal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="detailsModalLabel">Detalhes do evento</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!--conteúdo -->
        <dl class="row">
            <dt class="col-sm-3">ID: #</dt>
            <dd class="col-sm-9" id="details_id"></dd>
            
            <dt class="col-sm-3">Título</dt>
            <dd class="col-sm-9" id="details_title"></dd>
            
            <dt class="col-sm-3">Início</dt>
            <dd class="col-sm-9" id="details_start"></dd>
            
            <dt class="col-sm-3">Fim</dt>
            <dd class="col-sm-9" id="details_end"></dd>
            
            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9" id="details_description"></dd>

        </dl>
        <!--fim conteúdo -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fim detailsModal -->

<!-- addModal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Evento</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form id="createForm" class="row g-3">
                @csrf

                
                <fieldset>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mt-4">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_all_day" >
                                <input type="hidden" id="isAllDayHidden" name="is_all_day">
                                <label class="form-check-label" for="is_all_day">Dia Inteiro</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="start" class="form-label">Hora Início</label>
                            <input type="datetime-local" class="form-control" id="start" name="start" value="{{ old('start') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="endTime" class="form-label">Hora Fim</label>
                            <input type="datetime-local" class="form-control" id="end" name="end" value="{{ old('end') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <label for="responsible_id" class="form-label">Responsável</label>
                            <select id="responsible_id" name="responsible_id" class="form-select select2">
                                <option value="">Informe o Responsável</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label for="color" class="form-label">Cor</label>
                            <input type="color" class="form-control" id="color" name="color" value="#50301E">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="description" class="form-label">Observações</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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
        <button type="submit" class="btn btn-primary addButton" onclick="submitEventFormData()">Cadastrar <i class="fa-solid fa-paper-plane"></i></button>
      </div><!--fim modal-footer-->
      </form><!--finalizando form aqui para garantir pegar a ação do botão de salvar-->
    </div>
  </div>
</div><!-- fim addModal -->

</div><!--fim container-fluid-->

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
<script src="{{ mix('resources/js/core/locales-all.global.min.js') }}"></script>
{{-- <script src="{{ mix('resources/js/fullcalendar_script.js') }}"></script> --}}
<script src="https://momentjs.com/downloads/moment.min.js"></script>

<script>
/**Executar quando o documento html for completamente carregado */
document.addEventListener('DOMContentLoaded', function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  /**Recebe o seletor calendar do atributo id da div onde será exibido o calendário */
  var calendarEl = document.getElementById('calendar');
  /**Instanciar FullCalendar.Calendar e atribuir a variável calendar */
  var calendar = new FullCalendar.Calendar(calendarEl, {
      /**Criar cabeçalho do calendário*/
      headerToolbar:{
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      events: '/fetch-events', /**url que carrega todos os eventos salvos no bd */
      locale: 'pt-br', /**Traduz para português Brasil */
      initialView: 'dayGridMonth', /**Mostrar grid com dia e mês */
      navLinks:true, /**Permite clicar nos dias da semana */
      selectable:true, /**Permitir clicar e arrastar o mouse sobre um ou vários dias no calendário */
      selectMirror:true, /**Indicar visualmente a área que será selecionada antes que o usuário solte o btn do mouse para confirmar seleção */
      editable:true, /**Permitir arrastar e redimensionar os eventos diretamente no calendário */
      dayMaxEvents:true, /**Nº máximo de eventos em um determinado dia, se for true, o nº de eventos será limitado à altura da célula do dia */
      initialDate: new Date(),
      dateClick:function(info){
        openCreateModal();
        //console.log('allDay = ' + info.allDay);
        //console.log($('#endTime').val());
        //$('#start').val(info.dateStr + 'T00:00');
        
        // Obtém a data do dia clicado 
        var clickedDate = new Date(info.date); 
        // Define a hora como 00:00:00 
        clickedDate.setUTCHours(0, 0, 0, 0); 
        $('#start').val(clickedDate.toISOString().slice(0,16));
        $('#end').val(clickedDate.toISOString().slice(0,16));
        $('#is_all_day').val();
        //console.log($('#start').val());
      },
      /**Retorna informações do evento cadastrado*/
      eventClick: function(info) {
        console.log(info.event.extendedProps);
        detailsModal();
        document.getElementById('details_id').innerText =info.event.id;
        document.getElementById('details_title').innerText =info.event.title;
        document.getElementById('details_start').innerText =info.event.start.toLocaleString();
        document.getElementById('details_end').innerText =info.event.end.toLocaleString();
        document.getElementById('details_description').innerText =info.event.extendedProps.description;
        
    }, //fim de calendar = new FullCalendar.Calendar()

  });
  /**Envia todas as configurações para o html renderizar */
  calendar.render();

  /**Envia requisição do form para salvar no banco de dados e google agenda */
  $('#createForm').on('submit', function(e) {
        e.preventDefault();
        updateCheckboxState();
        saveEvent();
    });

    /**Mostra Modal */
    function openCreateModal() {
        $('#createModal').modal('show');
        updateCheckboxState();
    }

    /**Mostra Modal de detalhes do evento */
    function detailsModal() {
        $('#detailsModal').modal('show');
    }

    /**Fecha Modal */
    function closeModal() {
        $('#createModal').modal('hide');
        $('#createForm')[0].reset();
    }

    // Evento de mudança no checkbox para atualizar o valor
    $('#is_all_day').change(function() {
        updateCheckboxState();
    });

    // Função para atualizar o valor do hidden input com base no estado do checkbox
    function updateCheckboxState() {
        var isChecked = $('#is_all_day').is(':checked');
        $('#isAllDayHidden').val(isChecked ? '1' : '0');
    }

  
  
});/**Fim document.addEventListener('DOMContentLoaded' */
</script>

@endsection
   
