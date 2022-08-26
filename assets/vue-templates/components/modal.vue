<template>
  <div class="modal" :id="id" tabindex="-1">
    <div :class="btn==='Policy' ? 'modal-dialog modal-dialog-centered modal-dialog-scrollable':'modal-dialog modal-dialog-centered'">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" :id="id+'Title'">{{ btn ==='Reset' ?'Reset Your Password' : btn }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" :id="id+'Body'">
          <div v-if="btn==='Reset'" >
            <input class="form-control input-group" id="reset_email" type="email" placeholder="Email" name="reset_email">
            <p>{{ trans['modal.resetText'] }}</p>
          </div>
          <div v-else-if="btn==='Edit'">
            <p id="edit_text_email">{{ trans['modal.enterEmail'] }}</p>
            <input name="edit_id" id="edit_id" :value="userId" hidden>
            <input class="form-control input-group" id="edit_email" type="email" placeholder="Email" data-validate="edit_text_email" name="edit_email" @keyup="validateInput">
            <br>
            <p id="edit_text_username">{{ trans['modal.enterName'] }}</p>
            <input class="form-control input-group" id="edit_username" type="text" placeholder="Username" data-validate="edit_text_username" name="edit_username" @keyup="validateInput">
            <p>{{ trans['modal.agree'] }}</p>
            <input type="checkbox"  id="edit_agreement" name="edit_agreement">&nbsp;<label for="edit_agreement">{{ trans['modal.agreeWith'] }}<a href="#" @click="policy">{{ trans['modal.policy'] }}</a></label>
          </div>
          <div v-else-if="btn==='Policy'">
            <Agreement :trans="trans" />
          </div>
        </div>
        <div class="modal-footer">
          <button v-if="btn!=='Logout'" id="xClose" type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans.close }}</button>
          <form v-if="btn==='Delete'" action="/api/deleteAccount">
            <input name="id" id="id" :value="userId" hidden>
            <button type="submit" class="btn btn-primary">{{ btn }}</button>
          </form>
          <form v-if="btn==='Logout'" action="/logout">
            <button type="submit" class="btn btn-primary">{{ btn }}</button>
          </form>
          <button v-if="btn==='Reset'" class="btn btn-primary" data-bs-dismiss="modal" @click="resetPass">{{ trans.send }} </button>
          <button v-if="btn==='Edit'" id="btn_change" class="btn btn-primary" data-bs-dismiss="modal" data-validationBtn="true" @click="changeInfo">{{ trans['modal.change'] }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import validations from "../../js/Validations";
export default {
  name: "modal",
  props:[
    'id',
    'btn',
    'userId',
    'trans'
    ],
  data(){
    return {
      editUser: ''
    }
  },
  updated() {
    this.axios.get('/api/getUserInfo').then((res) => {
      this.editUser = JSON.parse(res.data['data']).user
      this.$parent.user = this.editUser
      document.getElementById('edit_email').value = this.editUser.email
      document.getElementById('edit_username').value = this.editUser.username
      document.getElementById('edit_agreement').checked = this.editUser.agreement
    })
  },
  methods:{
    resetPass(){
      let fd = new FormData()
      fd.append('email',document.getElementById('reset_email').value)
      this.axios.post('/reset-password', fd).then((res) => {
        this.$emit('getModal', 'Password Reset Email Sent', res.data['view'], 'generalModal')
      })
    },
    validateInput(){
      validations.validate()
    },
    changeInfo(){
      let editEmail = document.getElementById('edit_email')
      if (editEmail.value === ''){
        editEmail.value = this.editUser.email
      }else if (!editEmail.value.includes("@")){
        editEmail.value=this.editUser.email
        return;
      }
      let fd = new FormData()
      fd.append('email', document.getElementById('edit_email').value)
      fd.append('id', document.getElementById('edit_id').value)
      fd.append('username', document.getElementById('edit_username').value)
      fd.append('agree', document.getElementById('edit_agreement').checked)
      this.axios.post('/api/editInfo', fd).then((res) => {
        this.$emit('getModal', 'Edit Info', 'Your changes were Saved', 'generalModal')
        this.$emit('UserInfo');
      })
    },
    policy(){
      this.$emit('getModal', 'Privacy Policy', '', 'policyModal')
    }
  }
}
</script>

<style scoped>

</style>
