import Validations from "@/Validations";

export default {
    install: (app, options) => {
        let viewData = JSON.parse(document.getElementById("app").getAttribute('data-view'))
        let trans = JSON.parse(viewData.trans)
        Validations.setTrans(trans)
        app.config.globalProperties.$validator = Validations
        app.config.globalProperties.$validEmail = (email) => {
            let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
        app.provide('validator')
        app.provide('validEmail')
    }
}
