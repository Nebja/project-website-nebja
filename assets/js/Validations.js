class Validations {

    constructor() {
        this.elements =''
        this.elem = "none"
        this.label = "none"
        this.type = "none"
        this.btn = "none"
        this.validation = false
    }
    getValidation(){
        return this.validation
    }
    validate (){
        let text;
        this.#findInputs()
        this.elements.forEach(element => {
            this.elem = element
            this.#createVars()
            if(element.value === ''){
                this.elem.setAttribute('data-validated', 'false')
                text = 'Empty field does nothing :D'
            }else{
                switch (this.type){
                    case 'email':
                        text = this.#email()
                        break;
                    case 'text':
                        text = this.#text()
                        break;
                    case 'password':
                        text = this.#password()
                        break;
                    default:
                        break;
                }
            }
            this.#singleLabel(text)
        })
        this.#btnCheck()
    }
    #email(){
        this.validation = false
        if (!/\w+@\w+\.(com|gr|de|org|eu|com.gr)$/.test(this.elem.value)){
            this.elem.setAttribute('data-validated', 'false')
            return 'Please give a correct Email.(com,de,gr,eu,org,com.gr)'
        }else {
            this.elem.setAttribute('data-validated', 'true')
            return ''
        }
    }
    #text(){
        this.validation = false
        if (!/[a-zA-Z]{3}[a-zA-Z]+$/.test(this.elem.value)){
            this.elem.setAttribute('data-validated', 'false')
            return'Username can´t contain special Characters and must be at least 3'
        }else {
            this.elem.setAttribute('data-validated', 'true')
            this.validation = true
            return ''
        }
    }
    #password(){
        this.elem.setAttribute('data-validated', 'true')
        let  text = '';
        if (!/[^a-zA-Z\d]/.test(this.elem.value)){
            this.elem.setAttribute('data-validated', 'false')
            text += 'Password must contain at least one special character<br>'
        }
        if(!/^.{6}/.test(this.elem.value)){
            this.elem.setAttribute('data-validated', 'false')
            text += 'Password must be more than 5 characters<br>'
        }
        if (!/\d/.test(this.elem.value)){
            this.elem.setAttribute('data-validated', 'false')
            text += 'Password must contain at least one Number<br>'
        }
        if (!/[A-Z]/.test(this.elem.value)){
            this.elem.setAttribute('data-validated', 'false')
            text += 'Password must contain at least one Upper case character<br>'
        }
        return text
    }
    #findInputs(){
        this.elements = document.querySelectorAll('input[data-validate]');
        this.btn = document.querySelector('button[data-validationBtn]');
    }
    #createVars(){
        this.label = this.elem.dataset.validate
        this.type = this.elem.type
    }
    #singleLabel(text){
        document.getElementById(this.label).innerHTML = text
    }
    #btnCheck(){
        if(this.btn !== null){
            this.validation = true
            this.elements.forEach( elem => {
                if (elem.dataset.validated === 'false'){
                    this.validation = false
                }
            })
            this.btn.disabled = !this.validation;
        }
    }
}

export default new Validations
