<template>
  <div class="container-sm px-5 text-white custom-box">
    <img class="background" ref="background" src="/img/bg/design.jpg"  alt="bg"/>
    <br><br><br>
    <h1>{{ trans['navbar.register'] }}</h1>
    <form id="form_register">
      <div class="row mb-3">
        <p id="register_email_val" class="validations-text"></p>
        <label for="register_email" class="col-sm-2 col-form-label">{{ trans['email']}}</label>
        <div class="col-sm-10">
          <input type="email" v-model="email" class="form-control" id="register_email" data-name="email" data-validate="register_email_val" @keyup="validate">
        </div>
      </div>
      <div class="row mb-3">
        <p id="register_username_val" class="validations-text"></p>
        <label for="register_username" class="col-sm-2 col-form-label">{{ trans['navbar.username']}}</label>
        <div class="col-sm-10">
          <input type="text" v-model="username" class="form-control" id="register_username" data-name="username" data-validate="register_username_val" @keyup="validate">
        </div>
      </div>
      <div class="row mb-3">
        <p id="register_password_val" class="validations-text"></p>
        <label for="register_password" class="col-sm-2 col-form-label">{{ trans['navbar.pass']}}</label>
        <div class="col-sm-10">
          <input type="password" v-model="password" class="form-control" id="register_password" data-name="password" data-validate="register_password_val" @keyup="validate">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-sm-10 offset-sm-2">
          <transition name="fade">
            <Agreement ref="agreement" v-show="showAgreement"/>
          </transition>
          <a href="javascript:void(0)" class="link-info" @click="showAgreement = !showAgreement">{{ showAgreement ? trans['registerPage.hide'] : trans['registerPage.show']}}</a>
          <div class="form-check">
            <input type="checkbox" v-model="agreement" data-name="agreement" class="form-check-input" id="register_agreement">
            <label for="register_agreement" class="form-check-label" >{{ trans['modal.agree']}}</label>
          </div>

        </div>
      </div>
      <button type="button" class="btn btn-primary" data-validationBtn="true" @click="register" disabled>{{ trans['navbar.register'] }}</button>
    </form>
  </div>
</template>
<script>
import Agreement from "../components/Agreement";
export default {
  name: "register",
  components: {
    Agreement
  },
  data(){
    return{
      showAgreement: false,
      email: null,
      password: null,
      username: null,
      agreement: null,
      trans: this.$translate,
      validate: ()=>{this.$validator.validate()}
    }
  },
  mounted() {
    this.$CreateFD('form_register')
  },
  methods: {
    register() {
      if (!this.email || !this.password){
        this.$getModal( this.trans['registerPage.regProcess'], this.trans['registerPage.reqEmailPass'], 'generalModal')
        return
      }else if (!this.$validEmail(this.email)){
        this.$getModal(this.trans['registerPage.regProcess'], this.trans['registerPage.validEmail'], 'generalModal')
        return
      }
      const fd = this.$CreateFD('form_register');
      let thisPage = this
      this.axios.interceptors.request.use(function (config) {
      thisPage.disableInputs(true)
        return config;
      }, function (error) {
        this.$getModal(this.trans['registerPage.error'], error, 'generalModal')
        return Promise.reject(error);
      });
      this.$Register(fd).then((res) => {
        this.$getModal(this.trans['registerPage.regProcess'], res.data['msg'], 'generalModal')
        thisPage.disableInputs(false)
      })
    },
    disableInputs(bool){
      let inputs = document.getElementsByTagName('input')
      inputs.forEach(elem => {
        elem.disabled = bool
      })
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
