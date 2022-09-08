<template>
  <div class="modal" :id="id" tabindex="-1">
    <div :class="'modal-dialog modal-dialog-centered'+(type==='Policy'? ' modal-lg modal-dialog-scrollable':'')+(type==='Series'?' modal-dialog-scrollable':'')">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" :id="id+'Title'">{{ type ==='Reset' ? trans['navbar.reset'] : type }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" :id="id+'Body'">
          <div v-if="type==='Reset'"  id="form_reset_email">
            <input class="form-control input-group" id="reset_email" data-name="email" type="email" :placeholder="trans.email" name="reset_email">
            <p>{{ trans['modal.resetText'] }}</p>
          </div>
          <div v-else-if="type==='Edit'" id="form_edit">
            <p id="edit_text_email">{{ trans['modal.enterEmail'] }}</p>
            <input name="edit_id" id="edit_id" data-name="id" :value="data" hidden>
            <input class="form-control input-group" id="edit_email" data-name="email" type="email" placeholder="Email" data-validate="edit_text_email" name="edit_email" @keyup="validate">
            <br>
            <p id="edit_text_username">{{ trans['modal.enterName'] }}</p>
            <input class="form-control input-group" id="edit_username" data-name="username" type="text" placeholder="Username" data-validate="edit_text_username" name="edit_username" @keyup="validate">
            <p>{{ trans['modal.agree'] }}</p>
            <input type="checkbox"  id="edit_agreement" data-name="agree" name="edit_agreement">&nbsp;<label for="edit_agreement">{{ trans['modal.agreeWith'] }}<a href="javascript:void(0)" @click="policy">{{ trans['modal.policy'] }}</a></label>
          </div>
          <div v-else-if="type==='Policy'">
            <Agreement />
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
import Agreement from "./Agreement";
import Youtube from "./youtube";
export default {
  name: "modal",
  components: {Youtube, Agreement},
  props:[
    'id',
    'type',
    'data'
    ],
  data(){
    return {
      editUser: '',
      trans: this.$translate,
      validate: () => {this.$validator.validate()}
    }
  },
  updated() {
    this.$UserInfo().then((res) => {
      this.editUser = JSON.parse(res.data['data']).user
      this.$parent.user = this.editUser
      document.getElementById('edit_email').value = this.editUser.email
      document.getElementById('edit_username').value = this.editUser.username
      document.getElementById('edit_agreement').checked = this.editUser.agreement
    })
  },
  methods:{
    resetPass(){
      let fd = this.$CreateFD('form_reset_email')
      this.$ResetPass(fd).then((res) => {
        this.$getModal( this.trans['modal.PassEmailSent'], res.data['view'], 'generalModal')
      })
    },
    changeInfo(){
      let editEmail = document.getElementById('edit_email')
      if (editEmail.value === ''){
        editEmail.value = this.editUser.email
      }else if (!editEmail.value.includes("@")){
        editEmail.value=this.editUser.email
        return;
      }
      let fd = this.$CreateFD('form_edit')
      this.$EditInfo(fd).then((res) => {
        this.$getModal( this.trans['modal.EditInfo'], this.trans['modal.EditInfoSaved'], 'generalModal')
        this.$UserInfo()
      })
    },
    policy(){
      this.$getModal( this.trans['modal.policy'], '', 'policyModal')
    }
  }
}
</script>

<style scoped>
.seriesC{
  text-align: center;
}
</style>
