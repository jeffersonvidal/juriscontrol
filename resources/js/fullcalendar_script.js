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