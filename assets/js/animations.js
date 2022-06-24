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
    width(end){
        let startPoint = this.el.offsetWidth, endPoint = '0'
        console.log(this.el.offsetWidth)
        if (this.el.offsetWidth === 0) {
            startPoint = '0'
            endPoint = end
        }
            this.el.animate([{width: startPoint}, {width: endPoint}], this.con)
    }
    rotate(value){
        let start = '0', end = value;
        if (this.rotated){
            start = value
            end = '0'
            this.rotated = false;
        }else {
            this.rotated = true;
        }
        this.el.animate([{transform: 'rotate('+start+'deg)'},{transform: 'rotate('+end+'deg)'}], this.con)
    }
    scale(value){
         this.el.animate([{transform: 'scale(1)'},{transform: 'scale('+value+')'}], this.con)
    }
    slide(){
         this.el.style.left = '0'
        this.el.animate([{left: '100%'}], this.con)
    }
}
