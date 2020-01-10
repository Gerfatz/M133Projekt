class Validator{
    static Create(models: Array<ErrorModel>){
        document.onreadystatechange = () => {
            if(document.readyState == "complete"){
                const inputs = [...document.querySelectorAll("input, textarea")];

                models.forEach(error => {
                    const element = inputs.filter(i => (i as any).name == error.name)[0];
                    element.classList.add("is-invalid");
                    if(error.message){
                        element.parentElement.appendChild(<div class="invalid-feedback">{error.message}</div>);
                    }
                    if(error.value){
                        (element as any).value = error.value;
                    }
                });
            }
        }
    }
}

class ErrorModel{
    name: string;
    message: string;
    value: any;
}