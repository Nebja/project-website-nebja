import Modal from "bootstrap/js/src/modal";
import Tooltip from "bootstrap/js/src/tooltip";

export default {
    install: (app, options) => {
        app.config.globalProperties.$getModal = (title, msg, name, show=true) =>{
            let modal = new Modal(document.getElementById(name), {})
            if(show) {
                if (name === 'generalModal' || name ==='deleteModal'){
                    document.getElementById(name + 'Title').innerHTML = title
                    document.getElementById(name + 'Body').innerHTML = msg
                }
                modal.show();
            }else {
                modal.hide();
            }
        }
        app.config.globalProperties.$refreshTooltip = () =>{
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new Tooltip(tooltipTriggerEl, {
                    trigger: 'hover'
                })
            })
        }
        app.config.globalProperties.$updateTooltip = () =>{
            let links = document.getElementsByClassName('nav-link')
            links.forEach((link) => {
                Tooltip.getOrCreateInstance(document.getElementById(link.id)).hide()
            })
        }
        app.config.globalProperties.$translateRole = (role) => {
            switch (role){
                case 'ROLE_ADMIN':
                    return 'Administrator'
                case 'ROLE_USER':
                    return 'User'
                case 'ROLE_FRIEND':
                    return 'Personal Friend'
            }
        }
        app.provide(['getModal', options])
        app.provide( ['refreshTooltip', options])
        app.provide( ['updateTooltip', options])
        app.provide( ['translateRole', options])
    }
}
