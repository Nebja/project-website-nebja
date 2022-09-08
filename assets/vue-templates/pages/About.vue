<template>
  <div class="card bg-transparent border-0 w-100 m-auto">
    <div class="card-body text-white text-shadow mw-50 m-auto">
      <h5 class="card-title" v-html="trans['aboutPage.title']"></h5>
      <p class="card-text" v-html="trans['aboutPage.text']"></p>
      <p><small class="text-muted text-white" v-html="trans['aboutPage.footer']"></small></p>
    </div>
      <img src="/img/office.jpg" class="card-img-bottom w-25 auto m-auto Frame" alt="...">
      <img class="background" ref="background" src="/img/bg/coding.jpg"  alt="bg"/>
    </div>
</template>

<script>
export default {
  name: "About",
  data(){
    return{
      trans: this.$translate
    }
  }
}
</script>

<style scoped>
.card-text{
  background-color: rgba(0, 0, 0, 0.47);
  padding: 30px;
  border-radius: 25px;
}
.Frame {
  display: inline-block;
  padding: 40px;
  border-width: 20px;
  border-style: solid;
  border-color: #2F2D2D #434040 #4F4C4C #434040;
  background: #f5f5f5;
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#E5E4DF), to(#CDCDC6));
  background-image: -webkit-linear-gradient(#E5E4DF, #CDCDC6);
  background-image: -moz-linear-gradient(#E5E4DF, #CDCDC6);
  background-image: -o-linear-gradient(#E5E4DF, #CDCDC6);
  background-image: linear-gradient(#E5E4DF, #CDCDC6);
  box-shadow: inset 0 2px 5px rgba(0,0,0,.6),0 5px 2px rgba(0,0,0,.1), 0 10px 20px rgba(0,0,0,.8);
  position: relative;
  overflow: hidden;
}
.Frame::before {
  content: "";
  position: absolute;
  top: -175px;
  right: -20%;
  width: 400px;
  height: 400px;
  transform: rotateZ(-40deg);
  -webkit-transform: rotateZ(-40deg);
  -moz-transform: rotateZ(-40deg);
  -o-transform: rotateZ(-40deg);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(rgba(255,255,255,.4)), to(rgba(255,255,255,0)));
  background-image: -webkit-linear-gradient(rgba(255,255,255,.4), rgba(255,255,255,0));
  background-image: -moz-linear-gradient(rgba(255,255,255,.4), rgba(255,255,255,0));
  background-image: -o-linear-gradient(rgba(255,255,255,.4), rgba(255,255,255,0));
  background-image: linear-gradient(rgba(255,255,255,.4), rgba(255,255,255,0));
}
.Frame img {
  border-width: 2px;
  border-style: solid;
  border-color: #BBBAB4 #C7C7BF #E5E4DF #C7C7BF;
  box-shadow:  0 -1px 1px rgba(0,0,0,.1), 0 1px 1px 1px rgba(255,255,255,.7);
}
</style>
