import axios from 'axios'
import Alpine from 'alpinejs'

axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
window.axios = axios

window.Alpine = Alpine
Alpine.start()
