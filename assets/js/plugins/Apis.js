import axios from "axios";

export default {
    install: (app, options) => {
        // ROUTES
            // Get Requests
        app.config.globalProperties.$UserInfo = () => {return axios.get('/api/getUserInfo')}
        app.provide('UserInfo')
        app.config.globalProperties.$Movies =() => {return axios.get('/api/movies')}
        app.provide('Movies')
            // Post Requests
        app.config.globalProperties.$ResetPass =(fd) => {return axios.post('/reset-password', fd)}
        app.provide('ResetPass')
        app.config.globalProperties.$EditInfo =(fd) => {return axios.post('/api/editEmail', fd)}
        app.provide('EditInfo')
        app.config.globalProperties.$AddMovies =(fd) => {return axios.get('/api/addMovies', fd)}
        app.provide('AddMovies')
        app.config.globalProperties.$AddHomeMovies =(fd) => {return axios.get('/api/addHomeMovies', fd)}
        app.provide('AddHomeMovies')
        app.config.globalProperties.$SendEmail =(fd) => {return axios.post('/api/sendEmail', fd)}
        app.provide('SendEmail')
        app.config.globalProperties.$Register =(fd) => {return axios.post('/register', fd)}
        app.provide('Register')

            // IMDB requests
        app.config.globalProperties.$Imdb =(fd) => {
            const options = {
                method: 'GET',
                url: 'https://imdb8.p.rapidapi.com/auto-complete',
                params: fd,
                headers: {
                    'X-RapidAPI-Key': 'c3f3775c70mshc039db4732b3089p1a82c3jsn962b415da993',
                    'X-RapidAPI-Host': 'imdb8.p.rapidapi.com'
                }
            };
            return axios.request(options)
        }
        app.provide('Imdb')
        app.config.globalProperties.$ImdbFind =(fd) => {
            const options = {
                method: 'GET',
                url: 'https://imdb8.p.rapidapi.com/title/get-details',
                params: fd,
                headers: {
                    'X-RapidAPI-Key': 'c3f3775c70mshc039db4732b3089p1a82c3jsn962b415da993',
                    'X-RapidAPI-Host': 'imdb8.p.rapidapi.com'
                }
            };
            return axios.request(options)
        }
        app.provide('ImdbFind')
        app.config.globalProperties.$ImdbJson = (fd) => {
            return axios.post()
        }
        // HELPERS
            // Create Form Data
        app.config.globalProperties.$CreateFD = (form) => {
            const fd = new FormData()
            let f = document.getElementById(form).querySelectorAll('input[data-name], textarea[data-name]')
            for (const item of f){
                if (item.type !== 'checkbox'){
                    fd.append(item.dataset.name, item.value)
                }else {
                    fd.append(item.dataset.name, item.checked)
                }
            }
            return fd
        }
        app.provide('CreateFD')
    }
}
