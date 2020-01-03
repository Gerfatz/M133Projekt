const validateSearch = (elementId: string): boolean => {
    let element = document.getElementById(elementId) as HTMLInputElement;

    if (validateXSS(element.value)) {
        element.value = validateSQL(element.value);
        return true;
    }
    alert("Possible XSS detected");
    return false;
};

const validateXSS = (input: string): boolean => {
    return (
        input.match(/(\b)(on\S+)(\s*)=|javascript|(<\s*)(\/*)script/gi) == null
    );
};

const validateSQL = (input: string): string => {
    return input.match(/(^[a-zA-Z0-9])+/g).join();
};

class Config {
    static baseUrl: string;
}

const CreateElement = (
    tagname: string,
    attributes?: Object,
    ...content: Array<HTMLElement>
): HTMLElement => {
    let element = document.createElement(tagname);

    if (attributes) {
        for (const key in attributes) {
            if (attributes.hasOwnProperty(key)) {
                if(typeof attributes[key] == "function"){
                    element[key] = attributes[key];
                    element.setAttribute("_" + key, "");
                }else{
                    element.setAttribute(key, attributes[key]);
                }
            }
        }
    }

    if (content) {
        if (typeof content === "string") {
            element.textContent = content;
        } else {
            for (const child of content) {
                element.appendChild(child);
            }
        }
    }

    return element;
};
