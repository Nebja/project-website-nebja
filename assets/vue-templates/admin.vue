<template>
  <div>
    <h1>ADMIN PANEL</h1>
    <div class="container" style="width:600px">
      <div style="margin: 20px">
        <h4>Vue.js upload Files</h4>
      </div>
      <upload-files></upload-files>
    </div>
  </div>

</template>

<script>
import UploadFiles from "./components/UploadFiles";
export default {
  name: "admin",
  components: {
    UploadFiles
  }
}
</script>

<style scoped>

</style>
