<template>
  <div class="youtube-container">
    <iframe
        class="youtube-video"
        :src="'https://www.youtube.com/embed/'+trailer"
        allowfullscreen
        allowtransparency
        allow="autoplay"
    ></iframe>
  </div>
</template>

<script>
export default {
  name: "youtube",
  props:['trailer']
}
</script>

<style scoped>
.youtube-container{
  height: 263px;
}
.youtube-video{
  width: 100%;
  height: 100%;
}
</style>
