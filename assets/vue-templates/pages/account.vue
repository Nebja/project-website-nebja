<template>
  <div class="card custom-box accountBox" id="account-box">
    <modal id="deleteModal" type="Delete" :data="user.id" />
    <modal id="logoutModal" type="Logout" :data="user.id" />
    <modal id="editModal" type="Edit" :data="user.id" />
    <modal id="policyModal" type="Policy" data="0" />
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
  data (){
    return {
      user: '',
      role: '',
      trans: this.$translate
    }
  },
  created() {
    this.$UserInfo().then((res) => {
      this.user = JSON.parse(res.data['data']).user
      this.role = this.$translateRole(this.user.roles[0])
      document.getElementById('loggedInUser').innerHTML = this.user.username
      let box = document.getElementById('account-box')
      box.classList.add('fadeIn')
    })
  },
  methods:{
    openModal(type){
      if (type === 'Delete'){
        this.$getModal( 'Delete Account', 'Are you sure you want to delete your account?', 'deleteModal')
      }else {
        this.$getModal( 'Edit Account', '', 'editModal')
      }
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
