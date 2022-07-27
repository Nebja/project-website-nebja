<template>
  <div class="container-fluid justify-content-center overflow-hidden">
    <navBar
        :viewData="viewData"
        :token="token"
    />
    <div id="view-show" ref="viewShow" class="overflow-hidden">
      <Transition name="fade" mode="out-in">
        <register v-if="page==='registerLink'" @getModal="getModal"/>
        <parallax v-else-if="page==='homeLink'" class="box"/>
        <movies v-else-if="page==='moviesLink'" class="box"/>
        <admin v-else-if="page==='adminLink'" class="box"/>
        <account v-else-if="page==='accountLink'" @getModal="getModal"/>
        <test v-else-if="page==='testLink'"  @getModal="getModal" />
        <Contact v-else-if="page==='contactLink'" :viewData="viewData" @getModal="getModal" class="box"/>
        <About v-else-if="page==='aboutLink'" class="box"/>
      </Transition>
    </div>
  </div>
</template>
<script>
import register from "./register";
import parallax from "../components/parallax"
import Modal from "bootstrap/js/src/modal";
import Tooltip from  'bootstrap/js/src/tooltip'
import navBar from "../components/navBar";
import movies from "./movies";
import admin from "./admin"
import test from "./test"
import Contact from "./Contact";
import About from "./About";
import account from "./account"
export default {
  name: "homepage",
  data() {
    return {
      show: true,
      token: '',
      viewData: '',
      page: 'homeLink',
      smallScreen: '',
      flash: ''
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
    test,
    account
  },
  mounted(){
    this.token = document.getElementById("app").getAttribute('token')
    this.flash = document.getElementById("app").getAttribute('flash')
    this.viewData = JSON.parse(document.getElementById("app").getAttribute('data-view'))
    if(this.viewData.error != null){
      this.getModal('Login Error',this.viewData.error === 'Bad credentials.' ? 'Email doesnt exists': this.viewData.error, 'generalModal')
    }
    this.refreshTooltip()
    this.smallScreen = window.innerWidth <= 1000
    if(this.flash !== ''){
      this.getModal('NebWeB', this.flash, 'generalModal')
    }
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
    getModal(title, msg, name, show=true){
      let modal = new Modal(document.getElementById(name), {})
      if(show) {
        if (name !== 'loginModal') {
          document.getElementById(name + 'Title').innerHTML = title
          document.getElementById(name + 'Body').innerHTML = msg
        }
        modal.show();
      }else {
        modal.hide();
      }
    },
  }
}
</script>
<style lang="scss" scoped>
</style>
