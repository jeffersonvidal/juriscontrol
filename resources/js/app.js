/**Bootstrap Laravel */
import './bootstrap';

/**Importar Framework Boostrap (CSS/JS) */
import 'bootstrap';

/**Importar scripts sbadmin */
import './scripts_sbadmin';

/**Importar datatables */
import './simple-datatables.min';
import './datatables-simple-demo';

/**Axios */
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';