<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">N</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tooltip" data-bs-placement="top" title="Home" id="homeLink" aria-current="page" href="#" @click="showPage('home')"><BIconHouseDoor/></a>
          </li>
          <li class="nav-item" v-if="checkRoles(viewData.role)">
            <a class="nav-link" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Movies" id="moviesLink" @click="showPage('movies')"><BIconFilm/></a>
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
              <button class="btn btn-outline-primary" id="registerBtn" data-bs-toggle="tooltip" data-bs-placement="right" title="Register" type="button" @click="showPage('register')" v-if="!this.$parent.registerForm"><BIconPersonLinesFill /> </button>
              <button class="btn btn-danger" id="registerBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Back" type="button" @click="showPage('back')" v-else><BIconBackspace /></button>
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
  methods: {
    showPage(page){
      switch (page){
        case 'movies':
          Tooltip.getOrCreateInstance(document.getElementById('moviesLink')).hide()
          this.activeSelector('moviesLink')
          this.$parent.moviesPage = true;
          this.$parent.homePage = false;
          this.$parent.registerForm = false;
          break
        case 'register':
          Tooltip.getOrCreateInstance(document.getElementById('registerBtn')).hide()
          this.$parent.registerForm = true
          this.$parent.homePage = false
          this.$parent.moviesPage = false
          break
        case 'back':
          Tooltip.getOrCreateInstance(document.getElementById('registerBtn')).hide()
          let id = document.querySelector('.active').id
          this.activeSelector(id)
          if (id === 'homeLink'){
            this.$parent.homePage = true
            this.$parent.moviesPage = false

          }else {
            this.$parent.homePage = false
            this.$parent.moviesPage=true
          }
          this.$parent.registerForm = false
          break
        default:
          this.activeSelector('homeLink')
          Tooltip.getOrCreateInstance(document.getElementById('homeLink')).hide()
          this.$parent.homePage = true;
          this.$parent.registerForm = false;
          this.$parent.moviesPage = false;
          break
      }
    },
    activeSelector(link){
      document.querySelector('.active').classList.remove('active')
      document.querySelector('#'+link).classList.add('active')
    },
    checkRoles(roles){
      console.log(roles)
      let access = false;
      roles?.forEach((role) =>{
        if (role === 'ROLE_FRIEND') access = true
      })
      return access
    },
    myGetReq (){
      this.axios.get(
          '/json', {
            params: {
              testVar: 'I am Ben',
              anotherVar: 'I am Not Ben'
            }
          }
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
      console.log(this.token)
    }
  }
}
</script>

<style scoped>

</style>
