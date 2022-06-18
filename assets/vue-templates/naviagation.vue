<template>
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Nebja Home Page</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#" @click="loadComp('home')">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" @click="loadComp('work')">Work</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" @click="loadComp('movies')">Movies</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" @click="loadComp('about')">About</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div v-if="home"><home /></div>
    <div v-if="about"><about /></div>
    <div v-if="work"><work /></div>
    <div v-if="movies"><movies /></div>
  </div>
</template>

<script>
import home from './pages/home'
import about from './pages/about'
import work from "./pages/work";
import movies from "./pages/movies";
export default {
  name: "navigation",
  components:{
    'home': home,
    'work': work,
    'movies': movies,
    'about': about
  },
  data() {
    return{
      home: true,
      about: false,
      work: false,
      movies: false
    }
  },
  methods: {
    loadComp(comp){
      switch (comp){
        case 'home':
          this.home = true
          this.movies = false
          this.about = false
          this.work = false
          break
        case 'about':
          this.about = true
          this.movies = false
          this.work = false
          this.home = false
          break
        case 'movies':
          this.movies = true
          this.about = false
          this.work = false
          this.home = false
          break
        case  'work':
          this.work = true
          this.about = false;
          this.movies = false
          this.home = false
          break
        default :break
      }
      this.comp= !this.comp
    }
  }
}
</script>

<style scoped>

</style>