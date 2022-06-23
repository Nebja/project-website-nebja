<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light no-padding" >
    <div class="container-fluid moveArea padding-sm">
      <a class="navbar-brand" href="#">N</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a :class="this.$parent.page==='homeLink'?'nav-link active':'nav-link'" data-bs-toggle="tooltip" data-bs-placement="top" title="Home" id="homeLink" aria-current="page" href="#" @click="showPage('homeLink')"><BIconHouseDoor/></a>
          </li>
          <li class="nav-item" v-if="checkRoles(viewData.role)">
            <a :class="this.$parent.page==='moviesLink'?'nav-link active':'nav-link'" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Movies" id="moviesLink" @click="showPage('moviesLink')"><BIconFilm/></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"  title="More" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
        <span v-if="viewData.user">
            <form action="/logout" class="d-flex">
              <span>{{ viewData.user }}</span>&nbsp;&nbsp;&nbsp;
              <button class="btn btn-outline-danger"  data-bs-toggle="tooltip" data-bs-placement="top" title="Logout" type="submit"><BIconDoorClosed /></button>
            </form>
          </span>
        <span class="d-flex"  v-else>
            <button class="btn btn-round" id="loginFormBtn" @click="changeColor()"><BIconBoxArrowInRight/></button>
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
      rotated: false
    }
  },
  methods: {
    showPage(page){
      Tooltip.getOrCreateInstance(document.getElementById(page)).hide()
      this.$parent.page = page
    },
    checkRoles(roles){
      let access = false;
      roles?.forEach((role) =>{
        if (role === 'ROLE_FRIEND') access = true
      })
      return access
    },
    changeColor(){
      let degrees = '180'
      if (this.rotated){
        degrees = '0'
      }
      document.getElementById('loginFormBtn').animate([{ transform: 'rotate('+degrees+'deg)'}], { duration: 1000, fill: "forwards" }) //TODO <--------------This
      document.getElementById('loginForm').animate([{ top: '500px' }], { duration: 1000, fill: "forwards" })
      this.rotated = !this.rotated
    }
  }
}
</script>

<style scoped>

</style>
