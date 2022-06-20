<template>
  <div id="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
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
          <span class="d-flex">
            <input class="form-control me-2" placeholder="username" type="email" value="" name="email" id="inputEmail" autocomplete="email" required autofocus>
            <input class="form-control me-2" placeholder="password" type="password" name="password" id="inputPassword" autocomplete="current-password" required>
            <input type="hidden" v-bind:value="token" name="_csrf_token" id="csrf_token" required>
            <button class="btn btn-outline-success" @click="login">login</button>
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
      token: ''
    }
  },
  components:{
    carousel
  },
  mounted(){
    this.token = document.getElementById("app").getAttribute('token')
  },
  methods: {
    login(){
      this.axios.get('/login',{
        params: {
          email: document.getElementById('inputEmail').value,
          password: document.getElementById('inputPassword').value,
          _csrf_token: document.getElementById('csrf_token').value
        }
      }).then((res) => {
        console.log(res.data)
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
      console.log(this.token)
    }
  }
}
</script>
<style scoped>
</style>