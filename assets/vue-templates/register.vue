<template>
  <div class="container-sm px-5 text-white">
    <br><br><br>
    <h1>Register</h1>
    <form>
      <div class="row mb-3">
        <label for="register_email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
          <input type="email" class="form-control" id="register_email">
        </div>
      </div>
      <div class="row mb-3">
        <label for="register_password" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="register_password">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-sm-10 offset-sm-2">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="register_agreement">
            <label for="register_agreement" class="form-check-label" >Agree</label>
          </div>
        </div>
      </div>
      <button type="button" class="btn btn-primary" @click="register">Register</button>
    </form>
  </div>
</template>
<script>
export default {
  name: "register",
  methods: {
    register() {
      const params = new FormData();
      params.append('email', document.getElementById('register_email').value)
      params.append('password', document.getElementById('register_password').value)
      this.axios.post('/register', params).then((res) => {
        this.$emit('getModal','Register Process', res.data['msg'])
      })
    }
  }
}
</script>

<style scoped>

</style>
