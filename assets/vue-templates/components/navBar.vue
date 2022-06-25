<template>
  <nav class="navbar navbar-expand-lg navbar-light no-padding glowing" >
    <div class="container-fluid moveArea padding-sm">
      <a class="navbar-brand" href="#">N</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a :class="this.$parent.page==='homeLink'?'nav-link active':'nav-link'" data-bs-toggle="tooltip" data-bs-placement="top" title="Home" id="homeLink" aria-current="page" href="#" @click="showPage('homeLink')"><BIconHouseDoor class="nav-item-zoom"/></a>
          </li>
          <li class="nav-item" v-if="this.rolesDump?.includes('ROLE_FRIEND')">
            <a :class="this.$parent.page==='moviesLink'?'nav-link active':'nav-link'" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Movies" id="moviesLink" @click="showPage('moviesLink')"><BIconFilm class="nav-item-zoom"/></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle nav-item-zoom" href="#" id="navbarDropdown"  title="More" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <BIconMenuDown/>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Get Req</a></li>
              <li><a class="dropdown-item" href="#">Post Req</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Token</a></li>
            </ul>
          </li>
        </ul>
        <a href="#" class="nav-link nav-item-zoom links" data-bs-toggle="tooltip" data-bs-placement="top" title="Login" id="loginFormBtn" @click="loginAnimation($event)"><BIconBoxArrowInLeft/></a>
        <span class="d-flex" id="loginPanel" v-if="viewData.user" >
            <form id="loginForm" action="/logout" class="d-flex logged">
              <button class="btn btn-outline-danger"  data-bs-toggle="tooltip" data-bs-placement="top" title="Logout" type="submit"><BIconDoorClosed /></button>&nbsp;&nbsp;
               <span>{{ viewData.user }}</span>&nbsp;&nbsp;&nbsp;
            </form>
          </span>
        <span class="d-flex" id="loginPanel"  v-else>
            <form id="loginForm" method="post" class="d-flex" action="/login">
              <input v-model="viewData.lastEmail" v-if="viewData.lastEmail" class="form-control me-2" placeholder="username" type="email" name="email" id="inputEmail" autocomplete="email" required autofocus>
               <input v-else class="form-control me-2" placeholder="username" type="email" name="email" id="inputEmail" autocomplete="email" required autofocus>
              <input class="form-control me-2" placeholder="password" type="password" name="password" id="inputPassword" autocomplete="current-password" required>
              <input v-model="token" type="hidden" name="_csrf_token" id="csrf_token" required>
              <button class="btn btn-outline-success btn-round" data-bs-toggle="tooltip" data-bs-placement="top" title="Login" type="submit"><BIconDoorOpen /></button>
              &nbsp;&nbsp;
               <button :class="this.$parent.page==='registerLink'?'btn btn-primary btn-round disabled' :'btn btn-outline-primary btn-round'" id="registerLink" data-bs-toggle="tooltip" data-bs-placement="right" title="Register" type="button" @click="showPage('registerLink')"><BIconPersonLinesFill /> </button>
            </form>
          </span>
      </div>
    </div>
  </nav>
</template>

<script>
import animator from '/assets/js/animations'
import Tooltip from "bootstrap/js/src/tooltip";
export default {
  name: "navBar",
  props: {
    viewData: '',
    token: '',
  },
  data(){
    return {
      x:0,
      rolesDump: '',
      animator: new animator()
    }
  },
  updated() {
    this.rolesDump = this.viewData['role']
  },
  methods: {
    showPage(page){
      Tooltip.getOrCreateInstance(document.getElementById(page)).hide()
      this.$parent.page = page
    },
    loginAnimation(el){
      this.animator.changeEl(document.getElementById('loginForm'))
      let width = this.viewData.user ? '310px' : '562px'
      this.animator.width('5px',width)
      this.animator.changeEl(el.target)
      this.animator.rotate('0','-180')
    }
  }
}
</script>

<style lang="scss" scoped>
@import "./assets/styles/scss/custom.scss";
</style>
