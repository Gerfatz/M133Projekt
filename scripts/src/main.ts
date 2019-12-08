const validateSearch = (elementId: string): boolean => {
    let element = document.getElementById(elementId) as HTMLInputElement;

    if(validateXSS(element.value)){
        element.value = validateSQL(element.value);
        return true;
    }
    alert("Possible XSS detected");
    return false;
}

const validateXSS = (input: string): boolean => {
    return input.match(/(\b)(on\S+)(\s*)=|javascript|(<\s*)(\/*)script/ig).length == 0;
}

const validateSQL = (input: string): string => {
    return input.match(/(^[a-zA-Z0-9])+/g).join()
}