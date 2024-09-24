
/**Importar jQuery */ 
import jQuery from 'jquery';
window.$ = jQuery;

/**Importar select2 */
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
  
});



import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
