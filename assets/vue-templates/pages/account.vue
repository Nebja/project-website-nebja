<template>
  <div class="card custom-box accountBox" id="account-box">
    <modal id="deleteModal" type="Delete" :data="user.id" @getModal="getModal" :trans="trans"/>
    <modal id="logoutModal" type="Logout" :data="user.id" @getModal="getModal" :trans="trans"/>
    <modal id="editModal" type="Edit" :data="user.id" :trans="trans" @getModal="getModal" @UserInfo="UserInfo"/>
    <modal id="policyModal" type="Policy" :data="user.id" :trans="trans" @getModal="getModal"/>
    <img class="background" ref="background" src="/img/bg/account.jpg"  alt="bg"/>
    <h5 class="card-header" id="email_header" :key="user">{{ user.email }}</h5>
    <div class="card-body">
      <h5 class="card-title">{{ trans['accountPage.here']}} {{ user.email !== 'guest@nebja.eu' ? role : 'Guest' }}</h5>
      <p class="card-text">
        <span v-if="user.email !== 'guest@nebja.eu'" :key="user">
          {{ user.verified ? trans['accountPage.yEmail'] : trans['accountPage.nEmail'] }} <br>
          {{ user.agreement ? trans['accountPage.yAgree'] : trans['accountPage.nAgree'] }}
        </span>
        <span v-else>
          {{ trans['accountPage.gText1'] }} guest@nebja.eu. <span v-html="trans['accountPage.gText2']"></span>
        </span>
      </p>
      <button v-if="user.email !== 'guest@nebja.eu'" class="btn btn-warning" @click="openModal('Delete')" >{{ trans['accountPage.del'] }}</button>&nbsp;
      <button v-if="user.email !== 'guest@nebja.eu'" class="btn btn-success" @click="openModal('Edit')" >{{ trans['accountPage.edit'] }}</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "account",
  emits:["getModal"],
  props: ['trans'],
  data (){
    return {
      user: '',
      role: ''
    }
  },
  created() {
    this.UserInfo();
  },
  methods:{
    UserInfo(){
      this.axios('/api/getUserInfo').then((res) => {
        this.user = JSON.parse(res.data['data']).user
        this.role = this.translateRole(this.user.roles[0])
        document.getElementById('loggedInUser').innerHTML = this.user.username
        let box = document.getElementById('account-box')
        box.classList.add('fadeIn')
      })
    },
    translateRole(role){
      switch (role){
        case 'ROLE_ADMIN':
          return 'Adminstrator'
        case 'ROLE_USER':
          return 'User'
        case 'ROLE_FRIEND':
          return 'Personal Friend'
      }
    },
    openModal(type){
      if (type === 'Delete'){
        this.$emit('getModal', 'Delete Account', 'Are you sure you want to delete your account?', 'deleteModal')
      }else {
        this.$emit('getModal', 'Edit Account', '', 'editModal')
      }
    },
    getModal(title, msg, name, show=true){
      this.$emit('getModal', title, msg, name, show)
    }
  }
}
</script>

<style scoped>
.custom-box {
  text-align: center;
  margin: 30px auto 30px auto;
  max-width: 25%;
  min-width: 400px;
}
.accountBox{
  opacity: 0;
  transition: opacity 1s;
}
.accountBox.fadeIn{
  opacity: 1;
}
</style>
