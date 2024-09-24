/**Bootstrap Laravel */
import './bootstrap';

/**Importar framework de estilos Bootstrap */
import 'bootstrap';

/**Importar Custom_adm */
import './custom_adm';


/**Axios */
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';