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
                                <input class="form-check-input" type="checkbox" role="switch" id="is_all_day" name="i1s_all_day" checked value="1">
                                <label class="form-check-label" for="is_all_day">Dia Inteiro</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="start" class="form-label">Data Início</label>
                            <input type="datetime" class="form-control" id="startDateTime" name="start" value="{{ old('start') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="end" class="form-label">Data Fim</label>
                            <input type="datetime" class="form-control" id="endDateTime" name="end" value="{{ old('end') }}">
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
          let startDate, endDate, allDay;
          allDay = $('#is_all-day').prop('checked');
          if(allDay){
              startDate = moment(info.date).format("YYY-MM-DD");
              endDate = moment(info.date).format("YYY-MM-DD");
              initializeStartDateEndDateFormat("Y-m-d", true);
          }else{
              initializeStartDateEndDateFormat("Y-m-d", false);
              startDate = moment(info.date).format("YYY-MM-DD HH:mm:ss");
              endDate = moment(info.date).format("YYY-MM-DD HH:mm:ss");
          }
          $('#startDateTime').val(startDate);
          $('#endDateTime').val(endDate);
          modalReset();
          $('#createModal').modal("show");
      }
  });
  /**Envia todas as configurações para o html renderizar */
  calendar.render();
  $('#is_all_day').change(function(){
    let is_all_day = $(this).prop('checked');
    if(is_all_day){
        let start = $('#startDateTime').val().slice(0, 10);
        $('#startDateTime').val(start);
        let endDateTime = $('#endDateTime').val().slice(0, 10);
        $('#endDateTime').val(endDateTime);
        initializeStartDateEndDateFormat("Y-m-d", is_all_day);
    }else{
        let start = $('#startDateTime').val().slice(0, 10);
        $('#startDateTime').val(start + "00:00");
        let endDateTime = $('#endDateTime').val().slice(0, 10);
        $('#endDateTime').val(endDateTime + "00:30");
        initializeStartDateEndDateFormat("Y-m-d", is_all_day);
    }
  });

  function initializeStartDateEndDateFormat(format, allDay){
    let timePicker = !allDay;
    $('#startDateTime').datetimepicker({
        format:format,
        timepicker:timePicker
    });
    $('#endDateTime').datetimepicker({
        format:format,
        timepicker: timePicker
    });
  }

  function modalReset(){
      $('#title').val('');
      $('#description').val('');
      $('#eventId').val('');
      $('#deleteBtn').hide();
  }

  function submitEventFormData(){
      let evetId = $('#eventId').val();
      let url = '{{ route('events.store') }}';
      let postData = {
          start: $('#startDateTime').val(),
          end: $('#endDateTime').val(),
          title: $('#title').val(),
          description: $('#description').val(),
          is_all_day: $('#is_all_day').prop('checked') ? 1 : 0,
      }
      if(eventId){
          utl = '{{ url('/') }}' + '/events/${eventId}';
          postData.method = "PUT"
      }
      $.ajax({
          type: 'POST',
          url: url,
          dataType: "json",
          data:postData,
          success:function(res){
              if(res.success){
                  //calendar.refetchEvents();
                  $('#createModal').modal('hide');
              }else{
                  //alert('Algo deu errado!');
                  Swal.fire('Erro!', res.message, 'error');
              }
          }
      });
  }
});/**Fim document.addEventListener('DOMContentLoaded' */
</script>

@endsection
   
