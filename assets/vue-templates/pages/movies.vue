<template>
  <div id="page-container" class="flex-column">
    <img class="background" ref="background" src="/img/bg/film.jpg"  alt="bg"/>
    <div  id="movies-container" class="row">
      <div class="col-lg-auto movies-box">
          <movie-label v-for="movie in movies" :id="movie.id" :name="movie.name" :poster="movie.imgPoster" episodes="none" type="movie" :trans="trans"/>
          <movie-label v-for="oneSet in series" id="0" :name="oneSet.name" :poster="oneSet.poster" :episodes="oneSet.episodes" type="series" :trans="trans"/>
      </div>
    </div >
  </div>
</template>

<script>
import MovieLabel from "../components/movie-label";
export default {
  name: "movies",
  components: {MovieLabel},
  props:['trans'],
  data (){
    return {
      movies: '',
      series: ''
    }
  },
  created() {
    this.$Movies().then((res) => {
      let view = JSON.parse(res.data['toView']);
      this.movies = view.movies
      this.series = view.series
    })
  }
}
</script>

<style scoped>
.movies-box{
  width: 70%;
  margin: auto;
  padding-top: 20px;
}
</style>
