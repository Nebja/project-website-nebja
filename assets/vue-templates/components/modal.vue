<template>
  <div class="modal" :id="id" tabindex="-1">
    <div :class="'modal-dialog modal-dialog-centered'+(type==='Policy'? ' modal-lg modal-dialog-scrollable':'')+(type==='Series'?' modal-dialog-scrollable':'')">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" :id="id+'Title'">{{ type ==='Reset' ? trans['navbar.reset'] : type }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" :id="id+'Body'">
          <div v-if="type==='Reset'" >
            <input class="form-control input-group" id="reset_email" type="email" :placeholder="trans.email" name="reset_email">
            <p>{{ trans['modal.resetText'] }}</p>
          </div>
          <div v-else-if="type==='Edit'">
            <p id="edit_text_email">{{ trans['modal.enterEmail'] }}</p>
            <input name="edit_id" id="edit_id" :value="data" hidden>
            <input class="form-control input-group" id="edit_email" type="email" placeholder="Email" data-validate="edit_text_email" name="edit_email" @keyup="validateInput">
            <br>
            <p id="edit_text_username">{{ trans['modal.enterName'] }}</p>
            <input class="form-control input-group" id="edit_username" type="text" placeholder="Username" data-validate="edit_text_username" name="edit_username" @keyup="validateInput">
            <p>{{ trans['modal.agree'] }}</p>
            <input type="checkbox"  id="edit_agreement" name="edit_agreement">&nbsp;<label for="edit_agreement">{{ trans['modal.agreeWith'] }}<a href="javascript:void(0)" @click="policy">{{ trans['modal.policy'] }}</a></label>
          </div>
          <div v-else-if="type==='Policy'">
            <Agreement :trans="trans" />
          </div>
          <div v-else-if="type==='Series'" class="seriesC">
            <h2>{{data.name}}</h2>
<!--            <youtube :trailer="data.ep[0].YoutubeTrailer"/><br>-->
            <img :src="'/img/posters/'+data.poster"><br>
            <div v-for="ep in data.ep">
              {{trans.play}}  <a :href="'/movies/'+ep.id"  target="_blank">{{ep.name}}</a>
                <br></div>
          </div>
        </div>
        <div class="modal-footer">
          <button v-if="type!=='Logout'" id="xClose" type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans.close }}</button>
          <form v-if="type==='Delete'" action="/api/deleteAccount">
            <input name="id" id="id" :value="data" hidden>
            <button type="submit" class="btn btn-primary">{{ type }}</button>
          </form>
          <form v-if="type==='Logout'" action="/logout">
            <button type="submit" class="btn btn-primary">{{ type }}</button>
          </form>
          <button v-if="type==='Reset'" class="btn btn-primary" data-bs-dismiss="modal" @click="resetPass">{{ trans.send }} </button>
          <button v-if="type==='Edit'" id="btn_change" class="btn btn-primary" data-bs-dismiss="modal" data-validationBtn="true" @click="changeInfo">{{ trans['modal.change'] }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import validations from "../../js/Validations";
import Youtube from "./youtube";
export default {
  name: "modal",
  components: {Youtube},
  props:[
    'id',
    'type',
    'data',
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
.seriesC{
  text-align: center;
}
</style>
