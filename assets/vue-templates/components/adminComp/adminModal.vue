<template>
  <div :id="id" class="modal" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="file-window">
            <span id="1" class="folders" data-transformer="yes" ><BIconFolder width="60" height="60" /><br>Videos</span>
            <span id="2" class="folders" data-transformer="yes" ><BIconFolder width="60" height="60" /><br>Subtitles</span>
            <span id="3" class="folders" data-transformer="yes" ><BIconFolder width="60" height="60" /><br>Posters</span>
            <span id="4" class="folders" data-transformer="yes" ><BIconFolder width="60" height="60" /></span>
            <span id="5" class="folders" data-transformer="yes" ><BIconFolder width="60" height="60" /></span>
            <span id="6" class="folders" data-transformer="yes" ><BIconFolder width="60" height="60" /></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ElementTransformer from './../../../js/ElementTransformer'
export default {
  name: "adminModal",
  props:['id'],
  mounted() {
    let transformer = new ElementTransformer()
    transformer.setDbClick(true, (item) => { return console.log(item)})
    transformer.draggable()
  }
}
</script>

<style scoped>
.file-window{
  position: relative;
  background-color: #0dcaf0;
  width: 100%;
  height: 600px;
}
.folders{
  display: inline-table;
  position: relative;
  text-align: center;
  margin-left: 20px;
}
</style>
