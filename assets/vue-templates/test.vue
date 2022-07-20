<template>
  <div>
    <parallax />
<!--    <input type="file" ref="file" id="uploadFile" @change="selectFile">
    <button type="button" @click="upload">Upload</button>
    <atropos class="my-atropos">
      <img src="/img/posters/sq1.jpg" data-atropos-offset="-5" alt="test">
    </atropos>-->
  </div>
</template>

<script>
import testClass from '../vue-service/testClass'
import Atropos from 'atropos/vue'
import Parallax from "./components/parallax";
export default {
  name: "test",
  components: {
    Parallax,
    Atropos
  },
  data (){
    return {
      selectedFiles: undefined,
      currentFile: undefined,
    }
  },
  methods:{
    selectFile() {
      this.selectedFiles = this.$refs.file.files[0];
    },
    upload(){
      this.currentFile = this.selectedFiles;
      testClass.setFile(this.currentFile)
      testClass.setChunkSize(15000000)
      testClass.upload()
    }
  }
}
</script>

<style scoped>
  .my-atropos {
    width: fit-content;
  }
</style>
