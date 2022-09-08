import Modal from "bootstrap/js/src/modal";
import Tooltip from "bootstrap/js/src/tooltip";

export default {
    install: (app, options) => {
        const viewData = JSON.parse(document.getElementById("app").getAttribute('data-view'))
        const trans = JSON.parse(viewData.trans)

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
            tooltipTriggerList.map(function (tooltipTriggerEl) {
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
        app.config.globalProperties.$translate = trans
        app.config.globalProperties.$viewData = viewData
        app.config.globalProperties.$token = document.getElementById("app").getAttribute('token')
        app.provide('token')
        app.provide('translate')
        app.provide('viewData')
        app.provide('getModal')
        app.provide( 'refreshTooltip')
        app.provide( 'updateTooltip')
    }
}
