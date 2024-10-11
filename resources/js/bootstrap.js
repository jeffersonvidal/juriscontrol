
/**Importar jQuery */ 
// import jQuery from 'jquery';
// window.$ = jQuery;

// /**Importar select2 */
import select2 from 'select2';
select2();

/**Importar scripts sbadmin */
import './scripts_sbadmin';

/**Importar datatables */
import './simple-datatables.min';
import './datatables-simple-demo';

/**Importar SweetAlert2 */
import Swal from 'sweetalert2';
window.Swal = Swal;

/** Habilitar Campos de parcelas no form de faturas */
let parcelarFatura = document.querySelector('#parcela');
let parcelarUnica = document.querySelector('#unica');
let parcelarFixa = document.querySelector('#fixa');
/**Se clicar em fixa oculta campo parcelas e mostra o período (mensal/anual) */
document.querySelectorAll('input[name="repeat_when"]').forEach(function(radio) {
  radio.addEventListener('change', function() {
    if (document.querySelector('#fixa').checked) {
      $('#campoParcela').hide('slow');
      $('#campoPeriodo').show('slow');
    } else {
      $('#campoPeriodo').hide('slow');
      $('#campoParcela').show('slow');
    }
  });
});

/**UpdateForm - Se clicar em fixa oculta campo parcelas e mostra o período (mensal/anual) */
document.querySelectorAll('input[name="repeat_when"]').forEach(function(radio) {
  radio.addEventListener('change', function() {
    if (document.querySelector('#edit_fixa').checked) {
      $('#editCampoParcela').hide('slow');
      $('#editCampoPeriodo').show('slow');
    } else {
      $('#editCampoPeriodo').hide('slow');
      $('#editCampoParcela').show('slow');
    }
  });
});

if(document.querySelector('#parcela')){
  parcelarFatura.addEventListener("click", () =>{
    /** Habilita campo de parcela em faturas */
    if(parcelarFatura.checked == true){
      document.querySelector('#enrollments').disabled = false;
      document.querySelector('#enrollments').value = '2';
      //alert('parcela habilitada');
    }
    if(parcelarFatura.checked == false){
      document.querySelector('#enrollments').disabled = true;
      document.querySelector('#enrollments').value = '';
    }
    parcelarUnica.addEventListener("click", () =>{
      document.querySelector('#enrollments').disabled = true;
    });

  });
}

/**UpdateForm - Se clicar em pago mostra os métodos de pagamento no form de ExternalPetitions */

  $('#edit_payment_status').change(function() {
    if ($(this).val() == 'paid') {
      $('.paymentMethod').show('slow');
    } else {
      $('.paymentMethod').hide('slow');
    }
  });




//Inputmask
import Inputmask from 'inputmask';

//Criando máscara em campos de formulário
document.addEventListener("DOMContentLoaded", function(){
  /**Máscara para telefone */
  var foneMask = new Inputmask("(99) 99999-9999");
  if(document.querySelector('#phone')){
    foneMask.mask(document.querySelector('#phone'));
  }

  if(document.querySelector('#edit_phone')){
    foneMask.mask(document.querySelector('#edit_phone'));
  }

  /**Máscara para cep */
  var cepMask = new Inputmask("99999-999");
  if(document.querySelector('#zipcode')){
    cepMask.mask(document.querySelector('#zipcode'));
  }
  
  if(document.querySelector('#edit_zipcode')){
    cepMask.mask(document.querySelector('#edit_zipcode'));
  }

  /**Máscara para cpf */
  var cpfMask = new Inputmask("999.999.999-99");
  if(document.querySelector('#cpf')){
    cpfMask.mask(document.querySelector('#cpf'));
  }
  if(document.querySelector('#edit_cpf')){
    cpfMask.mask(document.querySelector('#edit_cpf'));
  }

  /**Máscara para cnpj */
  var cnpjMask = new Inputmask("99.999.999/9999-99");
  if(document.querySelector('#cnpj')){
    cnpjMask.mask(document.querySelector('#cnpj'));
  }
  if(document.querySelector('#edit_cnpj')){
    cnpjMask.mask(document.querySelector('#edit_cnpj'));
  }

  /**Máscara para numeroCNJ de processos */
  var processNumberMask = new Inputmask("9999999-99.9999.9.99.9999");
  if(document.querySelector('#numeroCNJ')){
    processNumberMask.mask(document.querySelector('#numeroCNJ'));
  }
  
});

/**CKEditor em textarea */
ClassicEditor
  .create( document.querySelector( '#content' ) )
  .catch( error => {
  console.error( error );
});



import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
