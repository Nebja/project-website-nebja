<template>
  <div>
    <h1>ADMIN PANEL</h1>
    <div class="container" style="width:600px">
      <img class="background" ref="background" src="/img/bg/html.jpg"  alt="bg"/>
      <div style="margin: 20px">
        <h4>Vue.js upload Files</h4>
      </div>
      <button class="btn btn-warning" @click="refreshFiles">Refresh Files</button>
      <upload-files></upload-files>
    </div>
  </div>
</template>

<script>
import UploadFiles from "../components/UploadFiles";
export default {
  name: "admin",
  components: {
    UploadFiles
  },
  methods:{
    refreshFiles(){
      this.$AddMovies()
    }
  }
}
</script>
<style scoped>

</style>
