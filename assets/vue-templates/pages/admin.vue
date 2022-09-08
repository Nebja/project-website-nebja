<template>
  <div>
    <h1>ADMIN PANEL</h1>
    <div class="container" style="width:600px">
      <img class="background" ref="background" src="/img/bg/html.jpg"  alt="bg"/>
      <div style="margin: 20px">
        <h4>Vue.js upload Files</h4>
      </div>
      <button class="btn btn-warning" @click="refresh">Refresh Files</button>
      <upload-files></upload-files>
    </div>
  </div>
</template>

<script>
import UploadFiles from "../components/UploadFiles";
export default {
  name: "admin",
  data(){
    return {
      trans: this.$translate,
      refresh: () => {
        this.$AddMovies()
      }
    }
  },
  components: {
    UploadFiles
  }
}
</script>
<style scoped>

</style>
