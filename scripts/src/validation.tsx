class Validator{
    static Create(models: Array<ErrorModel>){
        document.onreadystatechange = () => {
            if(document.readyState == "complete"){
                const inputs = document.querySelectorAll("input");

                models.forEach(error => {
                    const element = [...inputs].filter(i => i.name == error.name)[0];
                    element.classList.add("is-invalid");
                    if(error.message){
                        element.parentElement.appendChild(<div class="invalid-feedback">{error.message}</div>);
                    }
                    if(error.value){
                        element.value = error.value;
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