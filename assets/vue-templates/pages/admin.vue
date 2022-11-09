<template>
  <div>
    <h1>ADMIN PANEL</h1>
    <div class="container" style="width:600px">
      <img class="background" ref="background" src="/img/bg/html.jpg"  alt="bg"/>
      <div style="margin: 20px">
        <h4>Vue.js upload Files</h4>
      </div>
      <button class="btn btn-warning" @click="home">Refresh Home</button><br><br>
      <button class="btn btn-success" @click="getFiles">Files</button><br><br>
      <button class="btn btn-warning" @click="refresh">Refresh Files</button>
      <br><br><input type="text" id="title"><br><br>
      <button class="btn btn-success" @click="imdb">Title</button><br><br>
      <select id="yearSelect" @change="imdbDetails($event)">
        <option>Search for Movie name</option>
      </select>
      <div id="results"></div>
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
      },
      home: () =>{
        this.$AddHomeMovies()
      },
      getFiles : () =>{
        let fd = new FormData()
        fd.append('folder', 'Home' )
        this.$getFiles(fd).then(d => {
          console.log(d.data)
        })
      }
    }
  },
  components: {
    UploadFiles
  },
  methods: {
    imdb(){
      const title = document.getElementById('title').value
      this.$Imdb({'q': title}).then((res) => {
        let string = '<option value="none" selected>Pick a choice</option>';
        console.log(res.data)
        res.data.d.forEach((item) => {
          string += '<option value="'+item.id+'">'+item.y + ' - ' + item.l + '</option>'
        })
        document.getElementById('yearSelect').innerHTML = string
      })
    },
    imdbDetails(event){
      let string = ''
        this.$ImdbFind({'tconst': event.target.value}).then((res) => {
          if(res.data.image !== undefined){
             string = '<img style="width: 450px" src="'+res.data.image.url+'">'
          }else {
            string = 'NO IMAGE TO DISPLAY'
          }
          string +='<br>'+res.headers['x-ratelimit-requests-remaining']+'<br>'
          document.getElementById('results').innerHTML = string
        })
    }
  }
}
</script>
<style scoped>
</style>
