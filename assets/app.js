/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
import "bootstrap/dist/css/bootstrap.min.css"
import { createApp} from "vue";
import { BootstrapIconsPlugin } from 'bootstrap-icons-vue';
import homepage from './vue-templates/main'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VuePlyr from 'vue-plyr'
import 'vue-plyr/dist/vue-plyr.css'
// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import * as bootstrap from './bootstrap';
const app = createApp(homepage)
app.use(VueAxios, axios)
app.use(VuePlyr)
app.use(BootstrapIconsPlugin, bootstrap);
app.config.globalProperties.axios=axios
app.mount('#app')
import "bootstrap/dist/js/bootstrap.js"
