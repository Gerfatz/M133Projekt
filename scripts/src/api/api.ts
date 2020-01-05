class API{
    static GET(url: string, params: any = null): Promise<any>{
        return new Promise((resolve: Function, reject: Function) => {        
            if(params){
                url += '?';
                
                for(let key in params){
                    url += key + "=" + params[key] + "&";
                }

                url = url.substr(0, url.length - 1);
            }
    

        
            this.Request("GET", url, "", resolve, reject)
        });       
    }

    static POST(url: string, data: any){
        return new Promise((resolve: Function, reject: Function) => {
            this.Request("POST", url, data, resolve, reject);
        }); 
    }

    static PUT(url: string, data: any){
        return new Promise((resolve: Function, reject: Function) => {
            this.Request("PUT", url, data, resolve, reject);
        }); 
    }

    static DELETE(url: string, data: any){
        return new Promise((resolve: Function, reject: Function) => {
            this.Request("DELETE", url, data, resolve, reject);
        }); 
    }

    private static Request(method: string, url: string, data: any, resolve: Function, reject: Function){

        let request = new XMLHttpRequest();
        request.open(method, Config.baseUrl + url);

        request.onreadystatechange = () => {
            if(request.readyState == 4){
                if(request.status == 200){
                    resolve(request.response);
                }
                else{
                    reject(Error(method + " Request failed: " + request.statusText))
                }
            }
        }

        request.onerror = () => {reject(Error(method + " Request failed because of an network error"))}
        
        request.send(data);
    }
}