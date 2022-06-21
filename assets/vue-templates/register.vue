<template>
<div id="register-form" ref="regForm" class="container-xxl"></div>
</template>

<script>
export default {
  name: "register",
  mounted() {
      this.axios.get('/register').then((res) => {
        this.$refs.regForm.innerHTML = res.data.form
    })
  }
}
</script>

<style scoped>

</style>