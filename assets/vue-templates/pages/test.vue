<template>

</template>

<script>
import testClass from '../../js/testClass'
import Atropos from 'atropos/vue'
export default {
  name: "test",
  components: {
    Atropos
  },
  data (){
    return {
      selectedFiles: undefined,
      currentFile: undefined,
      user: '',
      role: ''
    }
  },
  mounted() {
    this.axios('/api/getUserInfo').then((res) => {
      this.user = JSON.parse(res.data['data']).user
      this.role = this.translateRole(this.user.roles[0])
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
        default :
          return 'Guest'
      }
    },
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
  .custom-box {
    text-align: center;
    margin: 30px auto 30px auto;
  }
</style>
