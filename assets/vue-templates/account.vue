<template>
  <div class="card custom-box">
    <img class="background" ref="background" src="/img/bg/account.jpg"  alt="bg"/>
    <h5 class="card-header">{{ user.email }}</h5>
    <div class="card-body">
      <h5 class="card-title">Your are here as  {{ role }}</h5>
      <p class="card-text">{{ user.verified ? 'Your Email is verified' : 'You need to verify your email' }} <br>
        {{ user.agreement ? 'You have agreed with our Privacy Policy' : 'You didn\'t agree with our Privacy Policy'}}
      </p>
      <button class="btn btn-warning" disabled>Delete Account</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "account",
  data (){
    return {
      user: '',
      role: ''
    }
  },
  mounted() {
    this.axios('/api/getUserInfo').then((res) => {
      this.user = JSON.parse(res.data['data']).user
      this.role = this.translateRole(this.user.roles[0])
      console.log(JSON.stringify(this.user))
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
    }
  }
}
</script>

<style scoped>
.custom-box {
  text-align: center;
  margin: 30px auto 30px auto;
}
</style>
