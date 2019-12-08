interface HTMLElement{
    find(ref: string): HTMLElement | undefined;
}

if(!HTMLElement.prototype.find){
    HTMLElement.prototype.find = function(ref: string): HTMLElement | undefined{
        for(let child of this.children){
            if(child.getAttribute("ref") == ref){
                return child;
            }
            else{
                let res = child.find(ref);
                if(res){
                    return res;
                }
            }
        }
        return undefined;
    }
}