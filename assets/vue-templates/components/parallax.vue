<template>
  <div class="root">
    <img class="background" ref="background" src="/img/parallax/tree.jpg"  alt="bg"/>
    <div class="section section-1" ref="first">
      <div class="first-box">
        <h1>NebWeb!<br>
            Scroll for more Info
        </h1>
      </div>
    </div>
    <div class="section section-2" ref="second">
      <div class="box-parallax">
        <h2>Frameworks</h2>
        <img src="/img/carousel/12.png" class="images pos-right" alt="image">
        <img src="/img/carousel/11.png" class="images pos-left" alt="image">
      </div>
    </div>
    <div class="section section-2" ref="third">
      <div class="box-parallax">
        <h2>Coding Languages</h2>
        <img src="/img/carousel/13.png" class="images pos-right" alt="image">
        <img src="/img/carousel/10.png" class="images pos-left" alt="image">
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
export default {
  name: 'parallax',
  setup() {
    const background = ref(background)
    const first = ref(first)
    const second = ref(second)
    const third = ref(third)
    return {
      background,
      first,
      second,
      third
    }
  },
  mounted() {
    document.addEventListener('scroll', this.handleScroll)
  },
  unmounted() {
    document.removeEventListener('scroll', this.handleScroll)
  },
  methods:{
    handleScroll(){
      const scrollY = window.scrollY
      if (scrollY <= 1500){
        this.showDiv(this.first)
        this.hideDiv(this.second)
      }else if (scrollY > 1500 && scrollY <= 5000){
        this.hideDiv(this.first)
        this.hideDiv(this.third)
        this.showDiv(this.second)
      }else if (scrollY > 5000 && scrollY <= 9000){
        this.hideDiv(this.second)
        this.showDiv(this.third)
      }
      const maxBackgroundSize = 120
      const backgroundSize = scrollY / (maxBackgroundSize - 100)
      this.background.style.transform ='scale(' + (100 + backgroundSize * 0.4) / 100 + ')'
    },
    showDiv(elem){
      elem.classList.remove('fadeDiv')
      elem.classList.add('showDiv')
    },
    hideDiv(elem){
      elem.classList.add('fadeDiv')
      elem.classList.remove('showDiv')
    }
  }
}
</script>
<style scoped>
.root{
  height: 10000px;
}
h1{
  text-shadow: 2px 2px black;
}
.first-box{
  background-color: rgba(255, 255, 255, 0.5);
  padding: 80px;
  border-radius: 25%;
  text-align: center;
}
.images{
  width: 500px;
}
img.background{
  /* Fill background */
  min-height: 100%;
  min-width: 1024px;
  /* Scale proportionately */
  width: 100%;
  height: auto;
  /* Positioning */
  position: fixed;
  top: 0;
  left: 0;
}
.box-parallax{
  width: 100vh;
}
.section {
  min-height: 100vh;
  position: relative;
  opacity: 1;
  transition: opacity 1s;
}
.section > div {
  position: fixed;
  color: white;
  /* centers this div */
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}
.section-1 {
  margin-bottom: 500px; /* determines the gap between our two sections */
  font-size: 4em;
}
.section-2 {
  opacity: 0; /* defaults to 0 because it's not visible */
  transition: opacity 1s;
}
.section-2 div {
  color: white;
  text-shadow: 2px 2px black;
  text-align: center;
  padding: 50px;
}
.section-2 h2 {
  font-size: 2em;
  margin-bottom: 40px;
}
.pos-right{
  right:10vh ;
}
.pos-left{
  left:10vh ;
}
.section-2 p {
  line-height: 150%;
}
.showDiv {
  opacity: 1 !important;
}
.fadeDiv{
  opacity: 0 !important;
}
</style>
