<template>
  <div class="container-sm px-5">
    <form class="row mb-3" action="/">
      <button type="submit" class="btn btn-danger">Exit</button>
    </form>
    <div class="row mb-3">
      <vue-plyr ref="plyr" :options="options">
        <video
            controls
            crossorigin
            playsinline
            :data-poster="'/img/'+video.imgPoster"
        >
  <!--        <source
              size="720"
              :src="source"
              type="video/mp4"
          />-->
          <source
              size="1080"
              :src="source"
              type="video/mp4"
          />
          <track v-if="subs(video['subsFile'])"
              default
              kind="captions"
              label="English captions"
              :src="video['subsFile']"
              srclang="en"
          />
        </video>
      </vue-plyr>
    </div>
  </div>
</template>

<script>
export default {
  name: "videoMain",
  data (){
    return {
      video: '',
      source: ''
    }
  },
  beforeMount() {
    this.video = JSON.parse(document.getElementById("video").getAttribute('data-video'))
    this.source = "/videos/"+this.video
    this.source = '/videos/'+this.video['file']
  },
  methods: {
    subs(sub){
      return sub !== 'no';
    },
    closeTab(){
      window.close
    }
  }
}
</script>

<style scoped>

</style>
