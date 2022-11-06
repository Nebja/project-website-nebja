<template>
  <div class="loading-stuff">
    <div class="spinner-border loader" role="status"></div>
    <div class="loader"> <img src="/img/logo_new.png"></div>
  </div>
  <div class="container-fluid justify-content-center overflow-hidden">
    <navBar/>
    <div id="view-show" ref="viewShow" class="overflow-hidden">
      <Transition name="fade" mode="out-in">
        <register v-if="page==='registerLink'" />
        <parallax v-else-if="page==='homeLink'" class="box" />
        <movies v-else-if="page==='moviesLink'" class="box" />
        <admin v-else-if="page==='adminLink'" class="box" />
        <account v-else-if="page==='accountLink'" />
        <Contact v-else-if="page==='contactLink'" class="box"/>
        <About v-else-if="page==='aboutLink'" class="box"/>
        <personal-video v-else-if="page==='personalVideo'" class="box"/>
      </Transition>
    </div>
  </div>
</template>
<script>
import register from "./register";
import personalVideo from "./PersonalVideo";
import parallax from "../components/parallax"
import navBar from "../components/navBar";
import movies from "./movies";
import admin from "./admin"
import Contact from "./Contact";
import About from "./About";
import account from "./account";
export default {
  name: "homepage",
  data() {
    return {
      show: true,
      token: '',
      viewData: '',
      page: 'homeLink',
      flash: '',
      trans: '',
      mobile: window.innerWidth <= 1000
    }
  },
  components:{
    About,
    Contact,
    register,
    movies,
    navBar,
    admin,
    parallax,
    account,
    personalVideo
  },
  created(){
    this.viewData = this.$viewData
    this.trans = this.$translate
  },
  mounted(){
    this.token = this.$token
    this.flash = document.getElementById("app").getAttribute('flash')
    if(this.$viewData.error != null){
      this.$getModal(this.trans['modal.logError'],this.$viewData.error === 'Bad credentials.' ? this.trans['navbar.badCre']: this.trans['navbar.wrongPass'], 'generalModal')
    }
    if (this.$viewData.form){
      this.$getModal('Reset Password',this.$viewData.form, 'generalModal')
    }
    this.$refreshTooltip()
    if(this.flash !== ''){
      this.$getModal('NebWeB', this.flash, 'generalModal')
    }
  },
  updated() {
    this.$refreshTooltip()
  }
}
</script>
<style lang="scss" scoped>
.loader{
  position: absolute;
  margin: auto;
  left: 40%;
  z-index: -1;
  top: 30%;
  width: 20rem;
  height: 20rem;
}
.loader img{
  width: 15rem;
  margin: 93px 0 0 30px;
}
</style>
