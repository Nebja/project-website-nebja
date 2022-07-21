<template>
  <div id="page-container" class="flex-column">
    <div  id="movies-container" class="row">
      <div class="col-lg-auto movies-box">
          <movie-label v-for="movie in this.movies" :id="movie.id" :name="movie.name" :poster="movie.imgPoster"/>
      </div>
    </div >
  </div>
</template>

<script>
import MovieLabel from "./components/movie-label";
export default {
  name: "movies",
  components: {MovieLabel},
  data (){
    return {
      movies: ''
    }
  },
  created() {
    this.axios.get('/api/movies').then((res) => {
      this.movies = JSON.parse(res.data['toView']).movies
      console.log(this.movies)
    })
  },
  methods: {}
}
</script>

<style scoped>
.movies-box{
  width: 70%;
  margin: auto;
  padding-top: 20px;
}
</style>
