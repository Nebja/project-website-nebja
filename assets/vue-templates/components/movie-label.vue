<template>
    <modal v-if="type!=='movie'" :id="'seriesModal'+name" type="Series" :data="array" :trans="trans"/>
    <div class="movies-label">
      <a :href="'/movies/'+id" v-if="type==='movie'"  target="_blank">
            <img :src="'/img/posters/'+poster" data-atropos-offset="-5" alt="" class="w-25 p-3" />
        </a>
      <a href="javascript:void(0)" v-else @click="openModal">
        <img :src="'/img/posters/'+poster" data-atropos-offset="-5" alt="" class="w-25 p-3" />
      </a>
    </div>

</template>

<script>
export default {
  name: "movie-label",
  emits:['getModal'],
  props: ['id','name','poster', 'type', 'episodes', 'trans'],
  data(){
    return {
      array:{'name': this.name,'poster':this.poster, 'ep': this.episodes}
    }
  },
  methods:{
    openModal(){
      this.$emit('getModal', 'Series', '', 'seriesModal'+this.name)
    }
  }
}
</script>

<style scoped>
img{
  width: 15% !important;
}

</style>
