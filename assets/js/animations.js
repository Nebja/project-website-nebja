export default class animator {
    constructor() {
        this.el = ''
        this.rotated = false
        this.con = { duration: 1000 , fill: 'forwards'};
    }
    /**
     *
     * @param value
     */
     changeEl(value){
        this.el = value
    }
    changeCon(object) {
        this.con = object
    }
    width(start, end){
        let startPoint = this.el.offsetWidth, endPoint = start
        if (this.el.offsetWidth === parseInt(start.replace(/\D/g,''))) {
            startPoint = start
            endPoint = end
        }
            this.el.animate([{width: startPoint}, {width: endPoint}], this.con)
    }
    rotate(start, end){
        let startPoint = start, endPoint = end;
        if (this.rotated){
            startPoint = end
            endPoint = start
        }
        this.rotated = !this.rotated;
        this.el.animate([{transform: 'rotate('+startPoint+'deg)'},{transform: 'rotate('+endPoint+'deg)'}], this.con)
    }
    scale(value){
         this.el.animate([{transform: 'scale(1)'},{transform: 'scale('+value+')'}], this.con)
    }
    slide(){
         this.el.style.left = '0'
        this.el.animate([{left: '100%'}], this.con)
    }
}
