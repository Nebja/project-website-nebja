<template>
  <div>
    <input type="file" ref="file" id="uploadFile" @change="selectFile">
    <button type="button" @click="upload">Upload</button>
  </div>
</template>

<script>
import testClass from '../vue-service/testClass'
export default {
  name: "test",
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

</style>
