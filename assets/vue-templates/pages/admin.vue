<template>
  <admin-modal id="adminModal"/>
  <div>
    <h1>ADMIN PANEL</h1>
    <div class="container" style="width:600px">
      <img class="background" ref="background" src="/img/bg/html.jpg"  alt="bg"/>
      <div style="margin: 20px">
        <h4>Vue.js upload Files</h4>
      </div>
      <div class="files-container">
        <span class="folders"><a href="javascript:void(0)" class="thisIcon" @click="openModal"><BIconFolder width="80" height="80" /> <br> Videos</a></span>
        <span class="folders"><a href="javascript:void(0)" class="thisIcon"><BIconFolder width="80" height="80" /> <br> Subtitles</a></span>
        <span class="folders"><a href="javascript:void(0)" class="thisIcon"><BIconFolder width="80" height="80" /> <br> Posters</a></span>
      </div>
      <br><br>
      <button class="btn btn-warning" @click="refresh">Refresh Files</button>
<!--      <upload-files></upload-files>-->
    </div>
  </div>
</template>

<script>
import UploadFiles from "../components/UploadFiles";
import adminModal from "../components/adminComp/adminModal";
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
    UploadFiles,
    adminModal
  },
  methods:{
    openModal(){
      this.$getModal('','','adminModal');
    }
  }
}
</script>
<style scoped>
.thisIcon{
  text-decoration: none;
  color: black;
  text-align: center ;
}
.files-container{
  display: flex;
  text-align: center;
}
.folders{
  margin-left: 20px;
}
</style>
