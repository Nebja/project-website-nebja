<template>
  <div id="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">N</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#"><BIconHouseDoor/></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><BIconFilm/></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <BIconMenuDown/>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#" @click="myGetReq">Get Req</a></li>
                <li><a class="dropdown-item" href="#" @click="myPostReq">Post Req</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#" @click="myToken">Token</a></li>
              </ul>
            </li>
  <!--          <li class="nav-item">
              <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>-->
          </ul>
          <span v-if="user">
            <form action="/logout" class="d-flex">
              <span>{{ user }}</span>&nbsp;&nbsp;&nbsp;
              <button class="btn btn-outline-danger" type="submit"><BIconDoorClosed /></button>
            </form>
          </span>
          <span class="d-flex"  v-else>
              <form method="post" class="d-flex" action="/login">
                <input v-model="form.email" class="form-control me-2" placeholder="username" type="email" name="email" id="inputEmail" autocomplete="email" required autofocus>
                <input v-model="form.password" class="form-control me-2" placeholder="password" type="password" name="password" id="inputPassword" autocomplete="current-password" required>
                <input v-model="form._csrf_token" type="hidden" name="_csrf_token" id="csrf_token" required>
                <button class="btn btn-outline-success" type="submit"><BIconDoorOpen /></button>
              </form>
            <form class="d-flex"  action="/register">
                <button class="btn btn-outline-primary" type="submit"><BIconPersonLinesFill/></button>
            </form>
          </span>
        </div>
      </div>
    </nav>
    <carousel/>
  </div>
  <!-- Navbar -->
</template>
<script>
import carousel from "./components/carousel";
export default {
  name: "homepage",
  data() {
    return {
      form:{
        email: '',
        password: '',
        _csrf_token: ''
      },
      user : ''
    }
  },
  components:{
    carousel
  },
  mounted(){
    this.form._csrf_token = document.getElementById("app").getAttribute('token')
    this.user = document.getElementById("app").getAttribute('user')
  },
  methods: {
    login(e){
      e.preventDefault()
      this.axios.post('/login',this.form, {
        withCredentials: true,
      }).then((res) => {
        //const status = JSON.parse(res.data.response.status)
        console.log(Object.values(res.data.error))
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
      this.axios.post('/json',
          {},
          {
            params:{
              testVar: 'I am Ben'
            }
          }).then((res) => {
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