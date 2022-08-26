<template>
  <div class="container-sm px-5 text-white custom-box">
    <img class="background" ref="background" src="/img/bg/design.jpg"  alt="bg"/>
    <br><br><br>
    <h1>Register</h1>
    <form>
      <div class="row mb-3">
        <p id="register_email_val" class="validations-text"></p>
        <label for="register_email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
          <input type="email" v-model="email" class="form-control" id="register_email" data-validate="register_email_val" @keyup="validate">
        </div>
      </div>
      <div class="row mb-3">
        <p id="register_username_val" class="validations-text"></p>
        <label for="register_username" class="col-sm-2 col-form-label">Username</label>
        <div class="col-sm-10">
          <input type="text" v-model="username" class="form-control" id="register_username" data-validate="register_username_val" @keyup="validate">
        </div>
      </div>
      <div class="row mb-3">
        <p id="register_password_val" class="validations-text"></p>
        <label for="register_password" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
          <input type="password" v-model="password" class="form-control" id="register_password" data-validate="register_password_val" @keyup="validate">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-sm-10 offset-sm-2">
          <transition name="fade">
            <Agreement ref="agreement" :trans="trans" v-show="showAgreement"/>
          </transition>
          <a href="javascript:void(0)" class="link-info" @click="showAgreement = !showAgreement">{{ showAgreement ? 'Hide Policy' : 'Show Policy'}}</a>
          <div class="form-check">
            <input type="checkbox" v-model="agreement" class="form-check-input" id="register_agreement">
            <label for="register_agreement" class="form-check-label" >Agree with our Policy</label>
          </div>

        </div>
      </div>
      <button type="button" class="btn btn-primary" data-validationBtn="true" @click="register" disabled>Register</button>
    </form>
  </div>
</template>
<script>
import validations from "../../js/Validations";
export default {
  name: "register",
  props: ['trans'],
  data(){
    return{
      showAgreement: false,
      email: null,
      password: null,
      username: null,
      agreement: null
    }
  },
  methods: {
    register() {
      if (!this.email || !this.password){
        this.$emit('getModal','Register Process', 'Email and Password are required for the registration.', 'generalModal')
        return
      }else if (!this.validEmail(this.email)){
        this.$emit('getModal','Register Process', 'Valid Email is required. ', 'generalModal')
        return
      }
      const fd = new FormData();
      fd.append('email', document.getElementById('register_email').value)
      fd.append('password', document.getElementById('register_password').value)
      fd.append('username', document.getElementById('register_username').value)
      fd.append('agreement', document.getElementById('register_agreement').checked)
      let thisPage = this
      this.axios.interceptors.request.use(function (config) {
      thisPage.disableInputs(true)
        return config;
      }, function (error) {
        this.$emit('getModal','Error', error, 'generalModal')
        return Promise.reject(error);
      });
      this.axios.post('/register', fd).then((res) => {
        this.$emit('getModal','Register Process', res.data['msg'], 'generalModal')
        thisPage.disableInputs(false)
      })
    },
    validate(){
      validations.validate()
    },
    disableInputs(bool){
      let inputs = document.getElementsByTagName('input')
      inputs.forEach(elem => {
        elem.disabled = bool
      })
    },
    validEmail(email) {
      let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    }
  }
}
</script>

<style scoped>
.custom-box{
  position: relative;
  width: 50%;
  padding-bottom: 30px;
  background-color: rgba(0, 0, 0, 0.47);
  border-radius: 25px;
}
.validations-text{
  text-align: center;
  color: red;
  text-shadow: 1px 1px black;
}
</style>
