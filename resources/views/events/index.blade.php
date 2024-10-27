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


<!-- addModal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog">
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
                                <input class="form-check-input" type="checkbox" role="switch" id="is_all_day" name="is_all_day" >
                                <label class="form-check-label" for="is_all_day">Dia Inteiro</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="start" class="form-label">Hora Início</label>
                            <input type="time" class="form-control" id="startTime" name="startTime" value="08:00">
                            <input type="hidden" class="form-control" id="start" name="start" value="{{ old('start') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="end" class="form-label">Hora Fim</label>
                            <input type="time" class="form-control" id="endTime" name="endTime" value="{{ old('endTime') }}">
                            <input type="hidden" class="form-control" id="end" name="end" value="{{ old('end') }}">
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
      events: '/fetch-events',
      /**Traduz para português Brasil */
      locale: 'pt-br',
      /**Mostrar grid com dia e mês */
      initialView: 'dayGridMonth',
      /**Permite clicar nos dias da semana */
      navLinks:true,
      /**Permitir clicar e arrastar o mouse sobre um ou vários dias no calendário */
      selectable:true,
      /**Indicar visualmente a área que será selecionada antes que o usuário solte o btn do mouse para confirmar seleção */
      selectMirror:true,
      /**Permitir arrastar e redimensionar os eventos diretamente no calendário */
      editable:true,
      /**Nº máximo de eventos em um determinado dia, se for true, o nº de eventos será limitado à altura da célula do dia */
      dayMaxEvents:true,
      initialDate: new Date(),
      dateClick:function(info){
        openModal();
        let isAllDay = document.querySelector('#is_all_day');
        if(isAllDay.checked === true){
            info.allDay = true;
        }else{
            info.allDay = false;
        }
        $('#is_all_day').change(function() {
            if (this.checked) {
                //$(this).val('true');
                info.allDay = true;
            } else {
                //$(this).val('false');
                info.allDay = false;
            }
            console.log('allDay agora é: ', info.allDay); // Só para verificar no console
        });

        
        console.log('allDay = ' + info.allDay);
        //console.log($('#startTime').val());
        //$('#start').val(info.dateStr + 'T00:00');
        $('#start').val(info.dateStr + 'T' + $('#startTime').val());
        $('#end').val(info.dateStr + 'T' + $('#endTime').val());
        $('#is_all_day').val(info.allDay);
        //console.log($('#start').val());
      },
      /**Retorna informações do evento cadastrado*/
      eventClick: function(info) {
        openModal();        
        $('#eventId').val(info.event.id);
        $('#title').val(info.event.title);
        $('#description').val(info.event.extendedProps.description);
        $('#start').val(info.event.start.toISOString().slice(0,16));
        $('#end').val(info.event.end.toISOString().slice(0,16));
        $('#author_id').val(info.event.author_id);
        $('#company_id').val(info.event.company_id);
        $('#color').val(info.event.color);
        $('#is_all_day').val(info.event.is_all_day);
        
    },
    eventDrop: function(info) {
        updateEvent(info.event);
    },
    eventResize: function(info) {
        updateEvent(info.event);
    }
  });
  /**Envia todas as configurações para o html renderizar */
  calendar.render();

  /**Envia requisição do form para salvar no banco de dados e google agenda */
  $('#createForm').on('submit', function(e) {
        e.preventDefault();
        saveEvent();
    });

    /**Mostra Modal */
    function openModal() {
        $('#createModal').modal('show');
    }

    /**Fecha Modal */
    function closeModal() {
        $('#createModal').modal('hide');
        $('#createForm')[0].reset();
    }

    /**Salva o evento no BD e Google Agenda */
    function saveEvent() {
        let eventData = {
            title: $('#title').val(),
            description: $('#description').val(),
            start: $('#start').val(),
            end: $('#end').val(),
            author_id: $('#author_id').val(),
            company_id: $('#company_id').val(),
            color: $('#color').val(),
            is_all_day: $('#is_all_day').val(),
            //eventId: $('#eventId').val(),
            
        };

        let url = '/store-events';
        let method = 'POST';
        let eventId = $('#eventId').val();

        if (eventId) {
            url += '/' + eventId;
            method = 'PUT';
        }

        $.ajax({
            url: url,
            type: method,
            data: eventData,
            success: function(response) {
                calendar.refetchEvents();
                closeModal();
            },
            error: function(response) {
                alert('Erro ao salvar evento');
            }
        });
    }

    /**Atualiza os dados do evento no BD E Google Agenda */
    function updateEvent(event) {
        let eventData = {
            title: event.title,
            description: event.extendedProps.description,
            start: event.start.toISOString().slice(0,16),
            end: event.end.toISOString().slice(0,16),
            author_id: event.author_id,
            company_id: event.company_id,
            color: event.color,
            is_all_day: event.is_all_day,
            eventId: event.eventId,
        };

        $.ajax({
            url: '/events/' + event.id,
            type: 'PUT',
            data: eventData,
            success: function(response) {
                calendar.refetchEvents();
            },
            error: function(response) {
                alert('Erro ao atualizar evento');
            }
        });
    }

    /**Exclui evento do BD e Google Agenda */
    function deleteEvent(event) {
        $.ajax({
            url: '/events/' + event.id,
            type: 'DELETE',
            success: function(response) {
                calendar.refetchEvents();
            },
            error: function(response) {
                alert('Erro ao deletar evento');
            }
        });
    }

  
  
});/**Fim document.addEventListener('DOMContentLoaded' */
</script>

@endsection
   
