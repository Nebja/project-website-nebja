<template>
  <br/><br/><br/>
  <div class="container-sm px-5 align-middle">
    <div class="row mb-3">
      <vue-plyr ref="plyr" :options="options">
        <video
            controls
            crossorigin
            playsinline
            :data-poster="'/img/'+video.imgPoster"
            data-plyr='{ "title": "Example Title", "settings": ["captions", "quality", "speed", "loop"] }'
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
              label="Ελληνικά"
              :src="'/subs/'+video['subsFile']"
              srclang="el"
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
      return sub !== 'generic.vtt';
    }
  }
}
</script>

<style scoped>

</style>
