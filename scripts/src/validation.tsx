class Validator{
    static Create(models: Array<ErrorModel>){
        const inputs = document.querySelectorAll("input");

        models.forEach(error => {
            const element = [...inputs].filter(i => i.getAttribute("name") == i.name)[0];
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

class ErrorModel{
    name: string;
    message: string;
    value: any;
}