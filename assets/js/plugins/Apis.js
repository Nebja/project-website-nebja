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
        app.config.globalProperties.$SendEmail =(fd) => {return axios.post('/api/sendEmail', fd)}
        app.provide('SendEmail')
        app.config.globalProperties.$Register =(fd) => {return axios.post('/register', fd)}
        app.provide('Register')
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
