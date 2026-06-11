// app.js
import './bootstrap'; // si tu as le fichier bootstrap.js
import '../css/app.css'; // Tailwind
import 'bootstrap/dist/css/bootstrap.min.css'; // Bootstrap CSS
import 'bootstrap'; // JS Bootstrap (dropdowns, modals, tooltips)
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();