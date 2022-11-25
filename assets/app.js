/**
 * /*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 *
 * @format
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/_tailwind.css';
import './styles/app.css';
import './styles/main.scss';
import { createApp } from 'vue';
import App from './js/app.vue';
// any JavaScript you import will output into a single JavaScript file (app.js in this case)
import './js/main.js';

// start the Stimulus application
import './bootstrap';



// createApp(App).mount('#vue-app');
