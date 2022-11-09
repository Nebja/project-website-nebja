<template>
  <div id="page-container" class="flex-column">
    <img class="background" ref="background" src="/img/bg/film.jpg"  alt="bg"/>
    <h1>PERSONAL VIDEO</h1>
    <div class="custom_MainBox">
      <span v-for="video in videos">
        <span class="row mb-3 custom_container" v-if="video.name !== 'NONE'">
          <h1 class="custom_Comment">{{ video.name}}</h1>
          <vue-plyr ref="plyr" class="home-video">
            <video
                controls
                crossorigin
                playsinline
                data-poster="/img/posters/generic.jpg"
                data-plyr='{ "title": "Example Title", "settings": ["captions", "quality", "speed", "loop"] }'
            >
              <source
                  size="1080"
                  :src="'/Home/'+video.file"
                  type="video/mp4"
              />
            </video>
          </vue-plyr>
          <span class="custom_Comment"><p>{{ video.comments }}</p></span>
        </span>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  name: "PersonalVideo",
  data (){
    return {
      videos: ''
    }
  },
  created() {
    let fd = new FormData()
    fd.append('folder', 'Home')
    this.$getFiles(fd).then(d =>{
      this.videos = d.data['Home']
      console.log(this.videos)
    })
  }
}
</script>

<style scoped>
.custom_container {
  width: 400px;
  overflow: visible;
  margin-left: 20px;
}
.custom_MainBox{
  padding: 50px;
  display: flex;
  flex-wrap: wrap;
}
.custom_Comment{
  text-align: center;
  color: aliceblue;
  text-shadow: 2px 2px black;
  background-color:rgba(0,0,0,0.4);
}
.home-video{
  height: 300px;
}
</style>
