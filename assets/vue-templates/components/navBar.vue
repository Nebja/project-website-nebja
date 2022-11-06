<template>
  <modal id="generalModal" type="false" data="none" />
  <modal id="resetModal" type="Reset" data="none" />
  <nav class="navbar fixed-top navbar-expand-lg no-padding navbar-light glowing" v-if="!this.$root.mobile">
    <div class="container-fluid moveArea padding-sm">
      <img src="/img/logo_new.png" class="logo" alt="nebWeb">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-auto" id="navbar-list">
          <!-- Home Link  /-->
          <li :class="this.$root.mobile ? 'nav-item text-center': 'nav-item'">
            <a :class="this.$parent.page==='homeLink'?'nav-link active':'nav-link'" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" :title="trans['navbar.home']" id="homeLink" aria-current="page"  @click="showPage('homeLink')"><BIconHouseDoor class="nav-item-zoom"/></a>
          </li>
          <!-- Movie Link  /-->
          <li class="nav-item" v-if="this.rolesDump?.includes('ROLE_FRIEND')">
            <a :class="this.$parent.page==='moviesLink'?'nav-link active':'nav-link'" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" :title="trans['navbar.movies']" id="moviesLink" aria-current="page" @click="showPage('moviesLink')"><BIconFilm class="nav-item-zoom"/></a>
          </li>
          <!-- Personal Video /-->
          <li class="nav-item">
            <a :class="this.$parent.page==='personalVideo'?'nav-link active':'nav-link'" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" :title="trans['navbar.personalVideo']" id="personalVideoLink" aria-current="page" @click="showPage('personalVideo')"><BIconCameraReels class="nav-item-zoom"/></a>
          </li>
          <!-- Account Link  /-->
          <li class="nav-item" v-if="this.rolesDump?.includes('ROLE_USER')">
            <a :class="this.$parent.page==='accountLink'?'nav-link active':'nav-link'" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" :title="trans['navbar.account']" id="accountLink" aria-current="page" @click="showPage('accountLink')"><BIconPersonCircle class="nav-item-zoom"/></a>
          </li>
          <!-- Common Links  /-->
          <li class="nav-item">
            <a :class="this.$parent.page==='aboutLink'?'nav-link active':'nav-link'" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" :title="trans['navbar.about']" id="aboutLink" aria-current="page"  @click="showPage('aboutLink')"><BIconGlobe2 class="nav-item-zoom"/></a>
          </li>
          <li class="nav-item">
            <a :class="this.$parent.page==='contactLink'?'nav-link active':'nav-link'" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" :title="trans['navbar.contact']" id="contactLink" aria-current="page"  @click="showPage('contactLink')"><BIconAt class="nav-item-zoom"/></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle nav-item-zoom" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="fi fi-gb" v-if="trans.lang === 'en'"></span>
              <span class="fi fi-gr" v-else-if="trans.lang === 'gr'"></span>
              <span class="fi fi-de" v-else></span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a :class="trans.lang === 'gr' ? 'dropdown-item nav-item-zoom disabled' : 'dropdown-item nav-item-zoom'" href="/gr"><span class="fi fi-gr"></span>{{ trans['languages.gr']}}</a></li>
              <li><a :class="trans.lang === 'en' ? 'dropdown-item nav-item-zoom disabled' : 'dropdown-item nav-item-zoom'" href="/en"><span class="fi fi-gb"></span>{{ trans['languages.en']}}</a></li>
              <li><a :class="trans.lang === 'de' ? 'dropdown-item nav-item-zoom disabled' : 'dropdown-item nav-item-zoom'" href="/de"><span class="fi fi-de"></span>{{ trans['languages.de']}}</a></li>
            </ul>
          </li>
          <!-- Admin Links  /-->
          <li class="nav-item" v-if="this.rolesDump?.includes('ROLE_ADMIN')">
            <a :class="this.$parent.page==='adminLink'?'nav-link active':'nav-link'" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" :title="trans['navbar.admin']" id="adminLink" aria-current="page" @click="showPage('adminLink')"><BIconTools class="nav-item-zoom"/></a>
          </li>
        </ul>
        <a href="javascript:void(0)" v-if="showArrow"   class="nav-link nav-item-zoom links" data-bs-toggle="tooltip" data-bs-placement="top" :title="trans['navbar.login']" id="loginFormBtn" @click="loginAnimation($event)"><BIconBoxArrowInLeft/></a>
        <LoginBox :modal="false" />
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
              <a :class="this.$parent.page==='homeLink'?'nav-link active':'nav-link'" data-bs-toggle="tooltip" data-bs-placement="top" title="Home" id="homeLink" aria-current="page" href="javascript:void(0)" @click="showPage('homeLink')"><BIconHouseDoor class="nav-item-zoom"/></a>
            </li>
            <li class="nav-item" v-if="this.rolesDump?.includes('ROLE_FRIEND')">
              <a :class="this.$parent.page==='moviesLink'?'nav-link active':'nav-link'" data-bs-toggle="tooltip" data-bs-placement="top" title="Movies" id="moviesLink" aria-current="page" href="javascript:void(0)"  @click="showPage('moviesLink')"><BIconFilm class="nav-item-zoom"/></a>
            </li>
            <li class="nav-item">
              <a :class="this.$parent.page==='aboutLink'?'nav-link active':'nav-link'" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" title="About" id="aboutLink" aria-current="page"  @click="showPage('aboutLink')"><BIconGlobe2 class="nav-item-zoom"/></a>
            </li>
            <li class="nav-item">
              <a :class="this.$parent.page==='contactLink'?'nav-link active':'nav-link'" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" title="Contact" id="contactLink" aria-current="page"  @click="showPage('contactLink')"><BIconAt class="nav-item-zoom"/></a>
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
export default {
  name: "navBar",
  data(){
    return {
      x:0,
      rolesDump: this.$viewData['role'],
      animator: new animator(),
      trans: this.$translate,
      token: this.$token
    }
  },
  computed:{
    showArrow: function () {
      return !!(!this.$viewData.user || this.$root.mobile);
    }
  },
  updated() {
    this.$updateTooltip();
    this.rolesDump = this.$viewData['role']
  },
  methods: {
    showPage(page){
      this.$parent.page = page
    },
    loginAnimation(el){
      this.animator.changeEl(document.getElementById('loginForm'))
      let width = this.$viewData.user ? '310px' : '562px'
      this.animator.width('5px',width)
      this.animator.changeEl(el.target)
      this.animator.rotate('0','-180')
    },
    mobileLogin(){
      this.$getModal('test', 'test', 'loginModal')
    },
  }
}
</script>

<style lang="scss" scoped>
</style>
