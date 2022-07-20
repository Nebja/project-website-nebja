<template>
  <div class="movies-label">
<!--  <input type="text" :value="movies.name" @input="update('name', $event.target.value)">-->
      <a :href="'/movies/'+id"  target="_blank">
          <img :src="'/img/'+poster" data-atropos-offset="-5" alt="" class="w-25 p-3" />
      </a>
  </div>
</template>

<script>
export default {
  name: "movie-label",
  props: ['id','name','poster'],
  data(){
    return {

    }
  }
}
</script>

<style scoped>
.my-atropos {
  width: fit-content;
}
</style>
