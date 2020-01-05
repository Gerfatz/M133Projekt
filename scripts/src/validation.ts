const markInputError = (input: HTMLInputElement, message: string) => {
    input.style.border = "solid 1px red";
    input.setAttribute("title", message)
}

document.onkeyup = (e) =>{
    const inputs = document.querySelectorAll("input");

    for(const input of inputs){
        if(input.type == "number"){
            if(parseInt(input.value) == NaN){
                markInputError(input, "Eingabe muss eine Zahl sein");
            }

            if(input.hasAttribute("min") && input.value < input.getAttribute("min")){
                markInputError(input, "Die eingegebene Zahl ist zu klein");
            }

            if(input.hasAttribute("max") && input.value > input.getAttribute("max")){
                markInputError(input, "Die eingegebene Zahl ist zu gross");
            }
        }
    }
}

const forms = document.querySelectorAll("form");

for(const form of forms){
    form.onsubmit
}