<template>
  <div class="card custom-box accountBox" id="account-box">
    <modal id="deleteModal" btn="Delete" :userId="user.id" @getModal="getModal"/>
    <modal id="logoutModal" btn="Logout" :userId="user.id" @getModal="getModal"/>
    <img class="background" ref="background" src="/img/bg/account.jpg"  alt="bg"/>
    <h5 class="card-header">{{ user.email }}</h5>
    <div class="card-body">
      <h5 class="card-title">Your are here as  {{ user.email !== 'guest@nebja.eu' ? role : 'Guest' }}</h5>
      <p class="card-text">
        <span v-if="user.email !== 'guest@nebja.eu'">
          {{ user.verified ? 'Your Email is verified' : 'You need to verify your email' }} <br>
          {{ user.agreement ? 'You have agreed with our Privacy Policy' : 'You didn\'t agree with our Privacy Policy'}}
        </span>
        <span v-else>
          Please dont send Emails to guest@nebja.eu. Its only use is for guest login.<br>
          This account can be disabled for development purposes , so I recommend to make <br>
          your own account with your email address.
        </span>
      </p>
      <button v-if="user.email !== 'guest@nebja.eu'" class="btn btn-warning" @click="openModal" >Delete Account</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "account",
  emits:["getModal"],
  data (){
    return {
      user: '',
      role: ''
    }
  },
  created() {
    this.axios('/api/getUserInfo').then((res) => {
      this.user = JSON.parse(res.data['data']).user
      this.role = this.translateRole(this.user.roles[0])
      let box = document.getElementById('account-box')
      box.classList.add('fadeIn')
    })
  },
  methods:{
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
    openModal(){
      this.$emit('getModal', 'Delete Account', 'Are you sure you want to delete your account?', 'deleteModal')
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
