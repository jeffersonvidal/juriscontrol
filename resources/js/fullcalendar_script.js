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
  });
  /**Envia todas as configurações para o html renderizar */
  calendar.render();
});