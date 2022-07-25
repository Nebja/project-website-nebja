<template>
  <div class="container-sm px-5 text-white custom-box">
    <img class="background" ref="background" src="/img/bg/design.jpg"  alt="bg"/>
    <br><br><br>
    <h1>Register</h1>
    <form>
      <div class="row mb-3">
        <label for="register_email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
          <input type="email" class="form-control" id="register_email">
        </div>
      </div>
      <div class="row mb-3">
        <label for="register_password" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="register_password">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-sm-10 offset-sm-2">
          <transition name="fade">
            <agreement ref="agreement" v-show="showAgreement"/>
          </transition>
          <a href="#" class="link-info" @click="showAgreement = !showAgreement">{{ showAgreement ? 'Hide Policy' : 'Show Policy'}}</a>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="register_agreement">
            <label for="register_agreement" class="form-check-label" >Agree with our Policy</label>
          </div>

        </div>
      </div>
      <button type="button" class="btn btn-primary" @click="register">Register</button>
    </form>
  </div>
</template>
<script>
import agreement from "./components/agreement"
export default {
  name: "register",
  components:{
    agreement
  },
  data(){
    return{
      showAgreement: false
    }
  },
  methods: {
    register() {
      const fd = new FormData();
      fd.append('email', document.getElementById('register_email').value)
      fd.append('password', document.getElementById('register_password').value)
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
    disableInputs(bool){
      let inputs = document.getElementsByTagName('input')
      console.log('here')
      inputs.forEach(elem => {
        console.log('here plus')
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
</style>
