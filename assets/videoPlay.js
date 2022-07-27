/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
import "bootstrap/dist/css/bootstrap.min.css"
import { createApp } from "vue";
import VuePlyr from 'vue-plyr'
import 'vue-plyr/dist/vue-plyr.css'
import './styles/app.scss';
import './styles/media.scss'
import './styles/mobile.scss'
import videoMain from "./vue-templates/pages/videoMain";
// start the Stimulus application
import './bootstrap';
const video = createApp(videoMain)
video.use(VuePlyr)
video.mount('#video')
