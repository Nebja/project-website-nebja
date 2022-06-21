<template>
  <div id="container">
    <modal/>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">N</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" data-bs-toggle="tooltip" data-bs-placement="top" title="Home" aria-current="page" href="#"><BIconHouseDoor/></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Movies"><BIconFilm/></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"  title="More" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <BIconMenuDown/>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#" @click="myGetReq">Get Req</a></li>
                <li><a class="dropdown-item" href="#" @click="myPostReq">Post Req</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#" @click="myToken">Token</a></li>
              </ul>
            </li>
          </ul>
          <span v-if="viewData.user">
            <form action="/logout" class="d-flex">
              <span>{{ viewData.user }}</span>&nbsp;&nbsp;&nbsp;
              <button class="btn btn-outline-danger"  data-bs-toggle="tooltip" data-bs-placement="top" title="Logout" type="submit"><BIconDoorClosed /></button>
            </form>
          </span>
          <span class="d-flex"  v-else>
            <form method="post" class="d-flex" action="/login">
              <input v-model="viewData.lastEmail" v-if="viewData.lastEmail" class="form-control me-2" placeholder="username" type="email" name="email" id="inputEmail" autocomplete="email" required autofocus>
               <input v-else class="form-control me-2" placeholder="username" type="email" name="email" id="inputEmail" autocomplete="email" required autofocus>
              <input class="form-control me-2" placeholder="password" type="password" name="password" id="inputPassword" autocomplete="current-password" required>
              <input v-model="token" type="hidden" name="_csrf_token" id="csrf_token" required>
              <button class="btn btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Login" type="submit"><BIconDoorOpen /></button>
              &nbsp;&nbsp;
              <button class="btn btn-outline-primary" id="registerBtn" data-bs-toggle="tooltip" data-bs-placement="right" title="Register" type="button" @click="showRegister(this)" v-if="!registerForm"><BIconPersonLinesFill /> </button>
              <button class="btn btn-danger" id="registerBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Back" type="button" @click="showRegister" v-else><BIconBackspace /></button>
            </form>
          </span>
        </div>
      </div>
    </nav>
    <div id="view-show" ref="viewShow">
      <register v-if="registerForm"/>
      <carousel v-else/>
    </div>

  </div>
  <!-- Navbar -->
</template>
<script>
import qs from 'qs'
import register from "./register";
import Modal from "bootstrap/js/src/modal";
import Tooltip from  'bootstrap/js/src/tooltip'
import modal from "./components/modal";
import carousel from "./components/carousel";
export default {
  name: "homepage",
  data() {
    return {
      token: '',
      viewData: '',
      registerForm: false,
      modal: ''
    }
  },
  components:{
    carousel,
    register,
    modal
  },
  mounted(){
    this.token = document.getElementById("app").getAttribute('token')
    this.viewData = JSON.parse(document.getElementById("app").getAttribute('data-view'))
    this.modal = new Modal(document.getElementById('generalModal'), {})
    if(this.viewData.error != null){
      this.getModal(this.viewData.error === 'Bad credentials.' ? 'Email doesnt exists': this.viewData.error)
    }
    this.refreshTooltip()
  },
  updated() {
    this.refreshTooltip()
  },
  methods: {
     showRegister(el){
       const tltip =Tooltip.getOrCreateInstance(document.getElementById('registerBtn'))
       tltip.hide()
       this.registerForm = !this.registerForm
    },
    getModal(msg){
       document.getElementById('modalBody').innerHTML = msg
       this.modal.show();
    },
    refreshTooltip(){
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new Tooltip(tooltipTriggerEl, {
          trigger: 'hover'
        })
      })
    },
    myGetReq (){
      this.axios.get(
          '/json', {
            params: {
              testVar: 'I am Ben',
              anotherVar: 'I am Not Ben'
            }
          },
      ).then((res) => {
        console.log(res.data)
      }).catch(error => {
        if (error.response) {
          console.log(error.response.status);
        } else if (error.request) {
          console.log(error.request);
        } else {
          console.log(error.message);
        }
      });
    },
    myPostReq (){
       const params = new FormData();
       params.append('testVar', 'no Json')
      this.axios.post('/json',params
          ).then((res) => {
            console.log(res.data)
          }).catch(error => {
            if (error.response) {
              console.log(error.response.status);
            } else if (error.request) {
              console.log(error.request);
            } else {
              console.log(error.message);
            }
      });
    },
    myToken(){
      console.log(this.form._csrf_token)
    }
  }
}
</script>
<style scoped>
</style>
