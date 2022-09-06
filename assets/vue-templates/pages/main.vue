<template>
  <div class="container-fluid justify-content-center overflow-hidden">
    <navBar
        :viewData="viewData"
        :token="token"
        :trans="trans"
    />
    <div id="view-show" ref="viewShow" class="overflow-hidden">
      <Transition name="fade" mode="out-in">
        <register v-if="page==='registerLink'"  :trans="trans"/>
        <parallax v-else-if="page==='homeLink'" class="box" :trans="trans"/>
        <movies v-else-if="page==='moviesLink'" class="box"  :trans="trans"/>
        <admin v-else-if="page==='adminLink'" class="box" :trans="trans"/>
        <account v-else-if="page==='accountLink'"  :trans="trans"/>
        <Contact v-else-if="page==='contactLink'" :viewData="viewData" :trans="trans"  class="box"/>
        <About v-else-if="page==='aboutLink'" :trans="trans"  class="box"/>
      </Transition>
    </div>
  </div>
</template>
<script>
import register from "./register";
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
  },
  created(){
    this.viewData = JSON.parse(document.getElementById("app").getAttribute('data-view'))
    this.trans = JSON.parse(this.viewData.trans)
  },
  mounted(){
    this.token = document.getElementById("app").getAttribute('token')
    this.flash = document.getElementById("app").getAttribute('flash')
    if(this.viewData.error != null){
      this.$getModal(this.trans['modal.logError'],this.viewData.error === 'Bad credentials.' ? this.trans['navbar.badCre']: this.trans['navbar.wrongPass'], 'generalModal')
    }
    if (this.viewData.form){
      this.$getModal('Reset Password',this.viewData.form, 'generalModal')
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
</style>
