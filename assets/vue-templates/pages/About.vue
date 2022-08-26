<template>
  <div class="card bg-transparent border-0 w-100 m-auto">
    <div class="card-body text-white text-shadow mw-50 m-auto">
      <h5 class="card-title" v-html="trans['aboutPage.title']"></h5>
      <p class="card-text" v-html="trans['aboutPage.text']"></p>
      <p><small class="text-muted text-white" v-html="trans['aboutPage.footer']"></small></p>
    </div>
    <img src="/img/about/office.jpg" class="card-img-bottom w-25 auto m-auto" alt="...">
    <img class="background" ref="background" src="/img/bg/coding.jpg"  alt="bg"/>
  </div>
</template>

<script>
export default {
  name: "About",
  props:['trans']
}
</script>

<style scoped>
.card-text{
  background-color: rgba(0, 0, 0, 0.47);
  padding: 30px;
  border-radius: 25px;
}
</style>
