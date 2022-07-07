<template>
  <modal id="generalModal"/>
  <nav class="navbar navbar-expand-lg navbar-light sticky-top no-padding glowing" v-if="!this.$parent.smallScreen">
    <div class="container-fluid moveArea padding-sm">
      <a class="navbar-brand" href="#">N</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li :class="this.$parent.smallScreen ? 'nav-item text-center': 'nav-item'">
            <a :class="this.$parent.page==='homeLink'?'nav-link active':'nav-link'" data-bs-toggle="tooltip" data-bs-placement="top" title="Home" id="homeLink" aria-current="page" href="#" @click="showPage('homeLink')"><BIconHouseDoor class="nav-item-zoom"/></a>
          </li>
          <li :class="this.$parent.smallScreen ? 'nav-item text-center': 'nav-item'" v-if="this.rolesDump?.includes('ROLE_FRIEND')">
            <a :class="this.$parent.page==='moviesLink'?'nav-link active':'nav-link'" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Movies" id="moviesLink" @click="showPage('moviesLink')"><BIconCameraReels class="nav-item-zoom"/></a>
          </li>
          <li :class="this.$parent.smallScreen ? 'nav-item text-center': 'nav-item'" v-if="this.rolesDump?.includes('ROLE_ADMIN')">
            <a :class="this.$parent.page==='adminLink'?'nav-link active':'nav-link'" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Admin Panel" id="adminLink" @click="showPage('adminLink')"><BIconTools class="nav-item-zoom"/></a>
          </li>
<!--          <li :class="this.$parent.smallScreen ? 'nav-item dropdown text-center': 'nav-item dropdown'">
            <a class="nav-link dropdown-toggle nav-item-zoom" href="#" id="navbarDropdown"  title="More" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <BIconMenuDown/>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Get Req</a></li>
              <li><a class="dropdown-item" href="#">Post Req</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Token</a></li>
            </ul>
          </li>-->
        </ul>
        <a href="#" v-if="!this.$parent.smallScreen" class="nav-link nav-item-zoom links" data-bs-toggle="tooltip" data-bs-placement="top" title="Login" id="loginFormBtn" @click="loginAnimation($event)"><BIconBoxArrowInLeft/></a>
          <LoginBox :modal="false"/>
      </div>
    </div>
  </nav>
  <div class="mobile-bar glowing" v-else>
    <div class="">
      <LoginBox :modal="true"/>
      <div class="col-sm-auto">
        <div class="d-flex flex-sm-column flex-row align-items-center">
          <a href="/" class="d-block p-3 link-dark text-decoration-none" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Icon-only">
            <i class="bi-bootstrap fs-1"></i>
          </a>
          <ul class="nav nav-pills nav-flush flex-sm-column flex-row flex-nowrap mb-auto text-center align-items-center">
            <li class="nav-item">
              <a :class="this.$parent.page==='homeLink'?'nav-link active':'nav-link'" data-bs-toggle="tooltip" data-bs-placement="top" title="Home" id="homeLink" aria-current="page" href="#" @click="showPage('homeLink')"><BIconHouseDoor class="nav-item-zoom"/></a>
            </li>
            <li :class="this.$parent.smallScreen ? 'nav-item text-center': 'nav-item'" v-if="this.rolesDump?.includes('ROLE_FRIEND')">
              <a href="#" :class="this.$parent.page==='moviesLink'?'nav-link active':'nav-link'" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Dashboard">
                <a :class="this.$parent.page==='moviesLink'?'nav-link active':'nav-link'" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Movies" id="moviesLink" @click="showPage('moviesLink')"><BIconFilm class="nav-item-zoom"/></a>
              </a>
            </li>
            <li v-if="this.$parent.viewData.user">
              <a href="/logout" :class="this.$parent.page==='loginLink'?'nav-link active':'nav-link'" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Logout">
                <BIconDoorClosed class="nav-item-zoom"/>
              </a>
            </li>
            <li v-else>
              <a href="javascript:void(0)" :class="this.$parent.page==='loginLink'?'nav-link active':'nav-link'" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Dashboard" @click="mobileLogin">
                <BIconPersonCircle class="nav-item-zoom"/>
              </a>
            </li>
          </ul>
<!--          <div class="dropdown">
            <a href="#" class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none dropdown-toggle" id="dropdownUser3" data-bs-toggle="dropdown" aria-expanded="false">
              <BIconMenuDown/>
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser3">
              <li><a class="dropdown-item" href="javascript:void(0)" @click="mobileLogin">Modal</a></li>
              <li><a class="dropdown-item" href="#">Post Req</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Token</a></li>
            </ul>
          </div>-->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import animator from '/assets/js/animations';
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
    },
    mobileLogin(){
      this.$parent.getModal('test', 'test', 'loginModal')
    }
  }
}
</script>

<style lang="scss" scoped>
@import "./assets/styles/scss/custom.scss";
</style>
