<template>
  <div>
    <div v-if="currentFile" class="progress">
      <div
          class="progress-bar progress-bar-info progress-bar-striped"
          role="progressbar"
          :aria-valuenow="progress"
          aria-valuemin="0"
          aria-valuemax="100"
          :style="{ width: progress + '%' }"
      >
        {{ progress }}%
      </div>
    </div>
    <label class="btn btn-default">
      <input class="form-control" type="file" ref="file" @change="selectFile" />
    </label>
    <button class="btn btn-success" :disabled="!selectedFiles" @click="upload">
      Upload
    </button>
    <select class="form-select-sm" id="folder-select" @change="onChange($event)">
      <option value="img">Images</option>
      <option value="subs">Subtitles</option>
    </select>
    <input class="form-control" type="text" placeholder="Name of the file" id="filename" >
    <br/> <br/>
    <Transition name="slide-up">
      <div class="alert alert-danger" role="alert" v-if="error">{{ message }}</div>
      <div class="alert alert-light" role="alert" v-else >{{ message }}</div>
    </Transition>
    <div id="fileManager">
      <Transition name="fade">
        <div class="card" v-if="this.folder==='img'">
          <div class="card-header">Folder: img</div>
          <ul class="list-group list-group-flush">
            <li
                class="list-group-item"
                v-for="(file, index) in fileInfos.images"
                :key="index"
            >
              <p class="folder-icons"><BIconFileEarmarkImage  width="100" height="50" /> {{ file.name }} <a href="#" @click="deleteFile('img/'+file.name)"> x</a></p>
            </li>
          </ul>
        </div>
        <div class="card" v-else-if="this.folder==='subs'">

        <div class="card-header">Folder: subs</div>
        <ul class="list-group list-group-flush">
          <li
              class="list-group-item"
              v-for="(file, index) in fileInfos.subs"
              :key="index"
          >
            <p class="folder-icons"><BIconFileText width="100" height="50"/> {{ file.name }} <a href="#" @click="deleteFile('subs/'+file.name)"> x</a></p>
          </li>
        </ul>
      </div>
        <div class="card" v-else-if="this.folder==='videos'">
          <div class="card-header">Folder: videos</div>
          <ul class="list-group list-group-flush">
            <li
                class="list-group-item"
                v-for="(file, index) in fileInfos.videos"
                :key="index"
            >
              <p class="folder-icons"><BIconFilm /> {{ file.name }} <a href="#" @click="deleteFile('videos/'+file.name)"> x</a></p>
            </li>
          </ul>
        </div> <!--TODO Big File size Upload-->
      </Transition>
    </div>
  </div>
</template>

<script>
import UploadService from "../../js/UploadFilesService";
export default {
  name: "UploadFiles",
  mounted() {
    UploadService.getFiles('img').then(response => {
      this.fileInfos = response.data;
    });
  },
  data (){
    return {
      folder: 'img',
      selectedFiles: undefined,
      currentFile: undefined,
      progress: 0,
      message: "",
      fileInfos: [],
      error: false
    }
  },
  methods: {
    onChange(event){
      this.folder = event.target.value
    },
    selectFile() {
      this.selectedFiles = this.$refs.file.files[0];
    },
    upload() {
      let filename = document.getElementById('filename').value, folder = document.getElementById('folder-select').value
      this.progress = 0;
      this.currentFile = this.selectedFiles;
      UploadService.upload(this.currentFile, event => {
        this.progress = Math.round((100 * event.loaded) / event.total);
      }, filename, folder)
          .then(response => {
            this.error = !!response.data.error
            this.message = response.data.message;
            return UploadService.getFiles();
          })
          .then(files => {
            this.fileInfos = files.data;
          })
          .catch(() => {
            this.progress = 0;
            this.message = "Could not upload the file!";
            this.currentFile = undefined;
          });
      this.selectedFiles = undefined;
    },
    deleteFile(filepath){
      UploadService.deleteFile(filepath).then(response => {
        this.error = !!response.data.error
        this.message = response.data.message
        return UploadService.getFiles()
      }).then(files => {
          this.fileInfos = files.data
      })
    }
  }
}
</script>

<style scoped>
  .folder-icons{
    display: grid;
    text-align: center;
    width: fit-content;
  }
  li{
    text-decoration: none !important;
    width: fit-content;
    float: left;
  }
  ul{
    display: block;
  }
</style>
