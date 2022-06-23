<template>
  <div id="container">
    <modal/>
    <navBar
        :viewData="viewData"
        :token="token"
    />
    <div id="view-show" ref="viewShow">
      <register v-if="page==='registerLink'" @getModal="getModal"/>
      <carousel v-if="page==='homeLink'" />
      <movies v-if="page==='moviesLink'"/>
    </div>

  </div>
  <!-- Navbar -->
</template>
<script>
import register from "./register";
import Modal from "bootstrap/js/src/modal";
import Tooltip from  'bootstrap/js/src/tooltip'
import navBar from "./components/navBar";
import modal from "./components/modal";
import carousel from "./components/carousel";
import movies from "./movies";
export default {
  name: "homepage",
  data() {
    return {
      token: '',
      viewData: '',
      page: 'homeLink',
      modal: ''
    }
  },
  components:{
    carousel,
    register,
    modal,
    movies,
    navBar
  },
  mounted(){
    this.token = document.getElementById("app").getAttribute('token')
    this.viewData = JSON.parse(document.getElementById("app").getAttribute('data-view'))
    this.modal = new Modal(document.getElementById('generalModal'), {})
    if(this.viewData.error != null){
      this.getModal('Login Error',this.viewData.error === 'Bad credentials.' ? 'Email doesnt exists': this.viewData.error)
    }
    this.refreshTooltip()
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
    getModal(title, msg){
      document.getElementById('modalTitle').innerHTML = title
      document.getElementById('modalBody').innerHTML = msg
      this.modal.show();
    },
  }
}
</script>
<style scoped>
</style>
