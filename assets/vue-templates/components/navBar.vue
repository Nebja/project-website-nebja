<template>
  <modal id="generalModal" btn="false" userId="none"/>
  <modal id="resetModal" btn="Reset" userId="none" @getModal="getModal"/>
  <nav class="navbar fixed-top navbar-expand-lg no-padding navbar-light glowing" v-if="!this.$parent.smallScreen">
    <div class="container-fluid moveArea padding-sm">
      <img src="/img/logo_new.png" class="logo" alt="nebWeb">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-auto" id="navbar-list">
          <!-- Home Link  /-->
          <li :class="this.$parent.smallScreen ? 'nav-item text-center': 'nav-item'">
            <a :class="this.$parent.page==='homeLink'?'nav-link active':'nav-link'" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Home" id="homeLink" aria-current="page"  @click="showPage('homeLink')"><BIconHouseDoor class="nav-item-zoom"/></a>
          </li>
          <!-- Movie Link  /-->
          <li class="nav-item" v-if="this.rolesDump?.includes('ROLE_FRIEND')">
            <a :class="this.$parent.page==='moviesLink'?'nav-link active':'nav-link'" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Movies" id="moviesLink" aria-current="page" @click="showPage('moviesLink')"><BIconCameraReels class="nav-item-zoom"/></a>
          </li>
          <!-- Account Link  /-->
          <li class="nav-item" v-if="this.rolesDump?.includes('ROLE_USER')">
            <a :class="this.$parent.page==='accountLink'?'nav-link active':'nav-link'" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="My account" id="accountLink" aria-current="page" @click="showPage('accountLink')"><BIconPersonCircle class="nav-item-zoom"/></a>
          </li>
          <!-- Common Links  /-->
          <li class="nav-item">
            <a :class="this.$parent.page==='aboutLink'?'nav-link active':'nav-link'" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="About" id="aboutLink" aria-current="page"  @click="showPage('aboutLink')"><BIconGlobe2 class="nav-item-zoom"/></a>
          </li>
          <li class="nav-item">
            <a :class="this.$parent.page==='contactLink'?'nav-link active':'nav-link'" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Contact" id="contactLink" aria-current="page"  @click="showPage('contactLink')"><BIconAt class="nav-item-zoom"/></a>
          </li>
          <!-- Admin Links  /-->
          <li class="nav-item" v-if="this.rolesDump?.includes('ROLE_ADMIN')">
            <a :class="this.$parent.page==='adminLink'?'nav-link active':'nav-link'" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Admin Panel" id="adminLink" aria-current="page" @click="showPage('adminLink')"><BIconTools class="nav-item-zoom"/></a>
          </li>
        </ul>
        <a href="#" v-if="showArrow"   class="nav-link nav-item-zoom links" data-bs-toggle="tooltip" data-bs-placement="top" title="Login" id="loginFormBtn" @click="loginAnimation($event)"><BIconBoxArrowInLeft/></a>
        <LoginBox :modal="false" @getModal="getModal"/>
      </div>
    </div>
  </nav>
  <div class="mobile-bar glowing" v-else>
    <div class="">
      <LoginBox :modal="true"/>
      <div class="col-sm-auto">
        <div class="d-flex flex-sm-column flex-row align-items-center">
          <a href="/" class="d-block p-3 link-dark text-decoration-none">
            <i class="bi-bootstrap fs-1"></i>
          </a>
          <ul class="nav nav-pills nav-flush flex-sm-column flex-row flex-nowrap mb-auto text-center align-items-center">
            <li class="nav-item">
              <a :class="this.$parent.page==='homeLink'?'nav-link active':'nav-link'" data-bs-toggle="tooltip" data-bs-placement="top" title="Home" id="homeLink" aria-current="page" href="#" @click="showPage('homeLink')"><BIconHouseDoor class="nav-item-zoom"/></a>
            </li>
            <li class="nav-item" v-if="this.rolesDump?.includes('ROLE_FRIEND')">
              <a :class="this.$parent.page==='moviesLink'?'nav-link active':'nav-link'" data-bs-toggle="tooltip" data-bs-placement="top" title="Movies" id="moviesLink" aria-current="page" href="#"  @click="showPage('moviesLink')"><BIconFilm class="nav-item-zoom"/></a>
            </li>
            <li class="nav-item">
              <a :class="this.$parent.page==='aboutLink'?'nav-link active':'nav-link'" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="About" id="aboutLink" aria-current="page"  @click="showPage('aboutLink')"><BIconGlobe2 class="nav-item-zoom"/></a>
            </li>
            <li class="nav-item">
              <a :class="this.$parent.page==='contactLink'?'nav-link active':'nav-link'" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Contact" id="contactLink" aria-current="page"  @click="showPage('contactLink')"><BIconAt class="nav-item-zoom"/></a>
            </li>
            <li v-if="this.$parent.viewData.user">
              <a href="/logout" :class="this.$parent.page==='loginLink'?'nav-link active':'nav-link'" title="Logout" id="mobileLogoutLink" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Logout">
                <BIconDoorClosed class="nav-item-zoom"/>
              </a>
            </li>
            <li v-else>
              <a href="javascript:void(0)" :class="this.$parent.page==='loginLink'?'nav-link active':'nav-link'" title="Login" id="mobileLoginLink" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Dashboard" @click="mobileLogin">
                <BIconPersonCircle class="nav-item-zoom"/>
              </a>
            </li>
          </ul>
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
  computed:{
    showArrow: function () {
      return !!(!this.viewData.user || this.$parent.smallScreen);
    }
  },
  updated() {
    this.updateTooltip();
    this.rolesDump = this.viewData['role']
  },
  methods: {
    showPage(page){
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
    },
    updateTooltip(){
      let links = document.getElementsByClassName('nav-link')
      links.forEach((link) => {
        Tooltip.getOrCreateInstance(document.getElementById(link.id)).hide()
      })
    },
    getModal(title, msg, name, show=true){
      this.$parent.getModal(title, msg, name, show)
    }
  }
}
</script>

<style lang="scss" scoped>
</style>
