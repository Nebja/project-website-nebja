export default class ElementTransformer {
    constructor() {
        this.dbClick = false
        this.dbClickFunction = 'none'
    }
    draggable(){
        let targets = this.#findElements(), parent = 'none'
        let position = [], startingPosition =[], mouseIsDown = []
        targets.forEach(item => {
            parent = item.parentNode
            mouseIsDown[item.id] = false
            startingPosition[item.id] = [Number(item.style.left.replace(/\D/g,'')), Number(item.style.top.replace(/\D/g,''))]
            item.addEventListener("mouseenter", () =>{document.body.style.cursor = "pointer"})
            item.addEventListener("mouseleave", () =>{ !mouseIsDown[item.id] ?document.body.style.cursor = "default": ''})
            item.addEventListener('mousedown', (e) => {
                if (e.button === 0){
                    position[item.id] = [
                        Number(item.style.left.replace(/\D/g,'')) - e.clientX,
                        Number(item.style.top.replace(/\D/g,'')) - e.clientY
                    ];
                    mouseIsDown[item.id] = true
                }else {
                    console.log(e.button)
                }
            })
            document.body.addEventListener('mouseup', (e) => {
                if(mouseIsDown[item.id]){
                    let boundaries = this.#getBoundaries(parent, item)
                    let x = e.pageX, y = e.pageY
                    if (boundaries[1].top < boundaries[0].top || boundaries[1].right > boundaries[0].right || boundaries[1].bottom > boundaries[0].bottom || boundaries[1].left < boundaries[0].left){
                        item.style.top = startingPosition[item.id][1]+'px'
                        item.style.left = startingPosition[item.id][0]+'px'
                    }else {
                        item.style.top = (y+position[item.id][1])+'px'
                        item.style.left = (x+position[item.id][0])+'px'
                        startingPosition[item.id] = [Number(item.style.left.replace(/\D/g,'')), Number(item.style.top.replace(/\D/g,''))]
                    }
                    document.body.style.cursor = "default"
                    mouseIsDown[item.id] = false
                }
            })
            document.body.addEventListener('mousemove', (e) => {
                if(mouseIsDown[item.id]){
                    let boundaries = this.#getBoundaries(parent, item), x = e.pageX, y = e.pageY
                    if (boundaries[1].top < boundaries[0].top || boundaries[1].right > boundaries[0].right || boundaries[1].bottom > boundaries[0].bottom || boundaries[1].left < boundaries[0].left){
                        item.style.top = startingPosition[item.id][1]+'px'
                        item.style.left = startingPosition[item.id][0]+'px'
                        mouseIsDown[item.id] = false
                    }else {
                        document.body.style.cursor = "grabbing"
                        item.style.top = (y+position[item.id][1])+'px'
                        item.style.left = (x+position[item.id][0])+'px'
                    }
                }
            })
            if (this.dbClick){
                item.addEventListener("dblclick", this.dbClickFunction)
            }
        })
    }
    setDbClick(bool, fun){
        this.dbClick = bool
        this.dbClickFunction = (item)=>{fun(item)}
    }
    #findElements(){
        return document.querySelectorAll("[data-transformer='yes']")
    }
    #getBoundaries(parent, item){
        return [parent.getBoundingClientRect(), item.getBoundingClientRect()]
    }
}
