import axios from "axios";

class UploadFilesService {
    upload(file, onUploadProgress, name, folder) {
        let formData = new FormData();
        formData.append("file", file)
        formData.append("folder", folder)
        formData.append("name", name)
        console.log(formData)
        return axios.post("/admin/upload", formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            },
            onUploadProgress
        });
    }
    getFiles(path) {
        return axios.get("/admin/files");
    }
    deleteFile(file, folder){
        return axios.get("/admin/delete", {
            params:{
                file: file,
                folder: folder
            }
        })
    }
}
export default new UploadFilesService();
