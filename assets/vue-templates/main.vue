<template>
  <div class="container-fluid justify-content-center">
    <navBar
        :viewData="viewData"
        :token="token"
    />
    <div id="view-show" ref="viewShow">
      <Transition name="fade">
        <register v-if="page==='registerLink'" @getModal="getModal" class="box"/>
        <carousel v-else-if="page==='homeLink'" class="box"/>
        <movies v-else-if="page==='moviesLink'" class="box"/>
        <admin v-else-if="page==='adminLink'" class="box"/>
        <test v-else-if="page==='testLink'" class="box"/>
        <Contact v-else-if="page==='contactLink'" class="box"/>
        <About v-else-if="page==='aboutLink'" class="box"/>
      </Transition>
    </div>
  </div>
</template>
<script>
import register from "./register";
import Modal from "bootstrap/js/src/modal";
import Tooltip from  'bootstrap/js/src/tooltip'
import navBar from "./components/navBar";
import carousel from "./components/carousel";
import movies from "./movies";
import admin from "./admin"
import test from "./test"
import Contact from "./Contact";
import About from "./About";
export default {
  name: "homepage",
  data() {
    return {
      show: true,
      token: '',
      viewData: '',
      page: 'homeLink',
      smallScreen: ''
    }
  },
  components:{
    About,
    Contact,
    carousel,
    register,
    movies,
    navBar,
    admin,
    test
  },
  mounted(){
    this.token = document.getElementById("app").getAttribute('token')
    this.viewData = JSON.parse(document.getElementById("app").getAttribute('data-view'))
    if(this.viewData.error != null){
      this.getModal('Login Error',this.viewData.error === 'Bad credentials.' ? 'Email doesnt exists': this.viewData.error, 'generalModal')
    }
    this.refreshTooltip()
    this.smallScreen = window.innerWidth <= 1000
  },
  updated() {
    this.refreshTooltip()
  },
  methods: {
  refreshTooltip(){
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new Tooltip(tooltipTriggerEl, {
        trigger: 'hover'
      })
    })
  },
    getModal(title, msg, name){
      let modal = new Modal(document.getElementById(name), {})
      if(name !== 'loginModal'){
        document.getElementById(name+'Title').innerHTML = title
        document.getElementById(name+'Body').innerHTML = msg
      }
      modal.show();
    },
  }
}
</script>
<style lang="scss" scoped>
@import "./assets/styles/app-mobile.scss";
@import "./assets/styles/scss/custom.scss";
</style>
