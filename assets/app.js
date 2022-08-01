/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
import "bootstrap/dist/css/bootstrap.min.css"
import { createApp} from "vue";
import { BootstrapIconsPlugin } from 'bootstrap-icons-vue';
import homepage from './vue-templates/pages/main'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VuePlyr from 'vue-plyr'
import 'vue-plyr/dist/vue-plyr.css'
import 'atropos/atropos.css'
import LoginBox from './vue-templates/components/LoginBox'
import modal from "./vue-templates/components/modal"
// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import './styles/media.scss'
import './styles/mobile.scss'
import './styles/transitions.scss'
import './styles/animations.scss'
// start the Stimulus application
import * as bootstrap from './bootstrap';
const app = createApp(homepage)
app.component('LoginBox', LoginBox)
app.component('modal', modal)
app.use(VueAxios, axios)
app.use(VuePlyr)
app.use(BootstrapIconsPlugin, bootstrap);
app.config.globalProperties.axios=axios
app.mount('#app')
import "bootstrap/dist/js/bootstrap.js"
