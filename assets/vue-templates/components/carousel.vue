<template>
  <div id="carouselExampleDark" class="carousel slide" data-bs-ride="carousel">
<!--    <div class="carousel-indicators">
      <button  v-for="(images, index) in images" type="button" data-bs-target="#carouselExampleDark" :data-bs-slide-to="index" :class="index !== 0 ? '':'active'" :aria-current="index !== 0 ?'':'true'" :aria-label="'Slide '+index"></button>
    </div>-->
    <div class="carousel-inner">
      <div v-for="(image, index) in images" :class="index !== 0 ?'carousel-item ':'carousel-item active'" data-bs-interval="3000">
        <img :src="'/img/carousel/'+image" class="d-block m-auto w-25" alt="...">
        <div class="carousel-caption d-none d-md-block">
        </div>
      </div>
    </div>
<!--    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev" >
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next" >
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>-->
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: "carousel",
  data(){
    return {
      images: ''
    }
  },
  beforeMount() {
    this.getImages();
  },
  methods: {
    getImages(){
      axios.get('/api/images').then(res => {
        this.images = res.data.images
        console.log(this.images)
      })
    }
  }
}
</script>

<style scoped>

</style>
