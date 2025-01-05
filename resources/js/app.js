import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import $ from 'jquery'

window.Alpine = Alpine;
window.$ = $; 
window.Swal = Swal; 

Alpine.start();
