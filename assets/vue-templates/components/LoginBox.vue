<template>
  <div v-if="!modal">
    <span class="d-flex" id="loginPanel" v-if="this.$parent.viewData.user" >
      <form id="loginForm" action="/logout" class="d-flex logged">
        <button class="btn btn-outline-danger"  data-bs-toggle="tooltip" data-bs-placement="top" title="Logout" type="submit"><BIconDoorClosed /></button>&nbsp;&nbsp;
         <span>{{ this.$parent.viewData.user }}</span>&nbsp;&nbsp;&nbsp;
      </form>
    </span>
    <span class="d-flex" id="loginPanel"  v-else>
      <form id="loginForm" method="post" class="d-flex" action="/login">
        <input v-model="this.$parent.viewData.lastEmail" v-if="this.$parent.viewData.lastEmail" class="form-control me-2" placeholder="username" type="email" name="email" id="inputEmail" autocomplete="email" required autofocus>
         <input v-else class="form-control me-2" placeholder="username" type="email" name="email" id="inputEmail" autocomplete="email" required autofocus>
        <input class="form-control me-2" placeholder="password" type="password" name="password" id="inputPassword" autocomplete="current-password" required>
        <input v-model="this.$parent.token" type="hidden" name="_csrf_token" id="csrf_token" required>
        <button class="btn btn-outline-success btn-round" data-bs-toggle="tooltip" data-bs-placement="top" title="Login" type="submit"><BIconDoorOpen /></button>
        &nbsp;&nbsp;
         <button :class="this.$parent.page==='registerLink'?'btn btn-primary btn-round disabled' :'btn btn-outline-primary btn-round'" id="registerLink" data-bs-toggle="tooltip" data-bs-placement="right" title="Register" type="button" @click="this.$parent.showPage('registerLink')"><BIconPersonLinesFill /> </button>
         <button class="btn btn-outline-warning btn-round" id="resetLink" data-bs-toggle="tooltip" data-bs-placement="right" title="Reset Password" type="button" @click="resetPass"><BIconInfoCircle /> </button>
      </form>
    </span>
  </div>
  <div class="modal" id="loginModal" tabindex="-1" v-else>
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalTitle">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loginModalBody">
          <span class="d-flex" id="loginPanel" v-if="this.$parent.viewData.user" >
            <form id="loginForm" action="/logout" class="d-flex logged">
              <button class="btn btn-outline-danger"  data-bs-toggle="tooltip" data-bs-placement="top" title="Logout" type="submit"><BIconDoorClosed /></button>&nbsp;&nbsp;
               <span>{{ this.$parent.viewData.user }}</span>&nbsp;&nbsp;&nbsp;
            </form>
          </span>
          <span class="d-flex" id="loginPanel"  v-else>
            <form id="loginForm" method="post" class="d-flex" action="/login">
              <input v-model="this.$parent.viewData.lastEmail" v-if="this.$parent.viewData.lastEmail" class="form-control me-2" placeholder="username" type="email" name="email" id="inputEmail" autocomplete="email" required autofocus>
               <input v-else class="form-control me-2" placeholder="username" type="email" name="email" id="inputEmail" autocomplete="email" required autofocus>
              <input class="form-control me-2" placeholder="password" type="password" name="password" id="inputPassword" autocomplete="current-password" required>
              <input v-model="this.$parent.token" type="hidden" name="_csrf_token" id="csrf_token" required>
              <button class="btn btn-outline-success btn-round" data-bs-toggle="tooltip" data-bs-placement="top" title="Login" type="submit"><BIconDoorOpen /></button>
              &nbsp;&nbsp;
               <button :class="this.$parent.page==='registerLink'?'btn btn-primary btn-round disabled' :'btn btn-outline-primary btn-round'" id="registerLink" data-bs-toggle="tooltip" data-bs-placement="right" title="Register" type="button" @click="this.$parent.showPage('registerLink')"><BIconPersonLinesFill /> </button>
            </form>
          </span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "LoginBox",
  props:{
    modal:''
  },
  methods:{
    resetPass(){
        this.$emit('getModal', 'Reset Password Process', '', 'resetModal');
    }
  }
}
</script>

<style scoped>

</style>
