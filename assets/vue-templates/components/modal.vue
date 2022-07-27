<template>
  <div class="modal" :id="id" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" :id="id+'Title'">{{ btn ==='Reset' ?'Reset Your Password' : btn }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" :id="id+'Body'">
          <div v-if="btn==='Reset'" >
            <input class="form-control input-group" id="reset_email" type="email" placeholder="Email" name="reset_email">
            <p>Enter your email address and we will send you a link to reset your password</p>

          </div>
        </div>
        <div class="modal-footer">
          <button v-if="btn!=='Logout'" id="xClose" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <form v-if="btn==='Delete'" action="/api/deleteAccount">
            <input name="id" id="id" :value="userId">
            <button type="submit" class="btn btn-primary">{{ btn }}</button>
          </form>
          <form v-if="btn==='Logout'" action="/logout">
            <button type="submit" class="btn btn-primary">{{ btn }}</button>
          </form>
          <button v-if="btn==='Reset'" class="btn btn-primary" data-bs-dismiss="modal" @click="resetPass">Send </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "modal",
  props:{
    id: null,
    btn: null,
    userId: null
  },
  methods:{
    resetPass(){
      let fd = new FormData()
      fd.append('email',document.getElementById('reset_email').value)
      this.axios.post('/reset-password', fd).then((res) => {
        this.$emit('getModal', 'Password Reset Email Sent', res.data['view'], 'generalModal')
        console.log(res.data)
      })
    }
  }
}
</script>

<style scoped>

</style>
