<template>
  <div class="root">
    <img class="background" ref="background" src="/img/bg/earth.jpg"  alt="bg"/>
    <div class="section section-1" ref="first">
      <div class="first-box">
        <h1>NebWeb!<br>
           {{ this.trans['home.scroll'] }}
        </h1>
      </div>
    </div>
    <div class="section section-2" ref="second">
      <div class="box-parallax">
        <h2>Frameworks</h2>
        <img src="/img/carousel/1.png" class="images pos-right" alt="image">
        <img src="/img/carousel/2.png" class="images pos-left" alt="image">
      </div>
    </div>
    <div class="section section-2" ref="third">
      <div class="box-parallax">
        <h2>{{ this.trans['home.code'] }}</h2>
        <img src="/img/carousel/3.png" class="images pos-right" alt="image">
        <img src="/img/carousel/4.png" class="images pos-left" alt="image">
      </div>
    </div>
    <div class="section section-2" ref="fourth">
      <div class="box-parallax">
        <h2>{{ this.trans['home.thanks'] }}</h2>
        <img src="/img/carousel/boot.png" class="images" alt="image">
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
export default {
  name: 'parallax',
  props: [ 'trans' ],
  setup() {
    const background = ref(background)
    const first = ref(first)
    const second = ref(second)
    const third = ref(third)
    const fourth = ref(fourth)
    return {
      background,
      first,
      second,
      third,
      fourth
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
      if (scrollY <= 1000){
        this.showDiv(this.first)
        this.hideDiv(this.second)
      }else if (scrollY > 1000 && scrollY <= 4000){
        this.hideDiv(this.first)
        this.hideDiv(this.third)
        this.showDiv(this.second)
      }else if (scrollY > 4000 && scrollY <= 7000){
        this.hideDiv(this.second)
        this.hideDiv(this.fourth)
        this.showDiv(this.third)
      }else if (scrollY > 7000 && scrollY <= 10000){
        this.hideDiv(this.third)
        this.showDiv(this.fourth)
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
