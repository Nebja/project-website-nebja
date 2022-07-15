import axios from "axios";

class testClass {
    constructor (){
        this.file = 'none'
        this.chunkSize = 0
        this.filePointer = 0
        this.chunkId = 0
        this.reader = new FileReader()

    }

    setFile(file){
        this.file = file;
        this.chunkSize = this.chunkSize = 0 ? file.size : this.chunkSize
    }
    getFile(){
        return this.file
    }
    setChunkSize(bytes){
        this.chunkSize = bytes;
    }
    getChunkSize(){
        return this.chunkSize
    }
    reset(){
        this.file = 'none'
        this.filePointer = 0
        this.chunkId = 0
    }
    upload(){
        //const fileChunks = Math.ceil(file.size /chunkSize);
        let fd = new FormData ;
        fd = this.slicer(fd)

/*        for (let pair of fd.entries()) {
            console.log('ID: ' + pair[1]);
            for (const item of Object.entries(pair[0])){
                console.log(item);
            }
        }*/
        console.log('FileChunk :'+ this.chunkId+' is going to be uploaded with startPoint: '+this.formatBytes(this.filePointer))
        this.send(fd).then(res => {

            if (this.filePointer < this.file.size){
                console.log('FilePointer: '+this.formatBytes(this.filePointer)+ ' <  FileSize: '+this.formatBytes(this.file.size))
                console.log('FileChunk :'+ this.chunkId+' is uploaded ')
                this.chunkId = this.chunkId +1
                this.filePointer = this.filePointer + this.chunkSize
                this.upload()
            }else {
                console.log('FilePointer: '+this.formatBytes(this.filePointer)+ ' >=  FileSize: '+this.formatBytes(this.file.size))
                this.reset()
                console.log('File was Uploaded')
            }
        }).catch(error => {
            if (error.response) {
                // The request was made and the server responded with a status code
                // that falls out of the range of 2xx
                console.log(error.response.data);
                console.log(error.response.status);
                console.log(error.response.headers);
            } else if (error.request) {
                // The request was made but no response was received
                // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                // http.ClientRequest in node.js
                console.log(error.request);
            } else {
                // Something happened in setting up the request that triggered an Error
                console.log('Error', error.message);
            }
            console.log(error.config);
        })
    }
    slicer(fd){
        let start = this.filePointer
        let end = start+this.chunkSize
        let blob ;
        let dif = this.file - this.filePointer
        if (dif > this.chunkSize){
            console.log('Start: '+this.formatBytes(start)+' - End: '+this.formatBytes(end))
            blob = this.file.slice(start, end)
        }else{
            console.log('Start: '+this.formatBytes(start)+' - End: '+this.formatBytes(this.file.size))
            blob = this.file.slice(start, this.file.size)
        }
        fd.append('data', blob)
        fd.append('id', this.chunkId)
        return fd
    }
    send(fd) {
        const url = '/admin/test'
        return axios.post(url, fd,{
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            }
        )
    }
    formatBytes(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';

        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

        const i = Math.floor(Math.log(bytes) / Math.log(k));

        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }
}
export default new testClass()
