class Config {
    static baseUrl: string;
    static isLoggedIn: boolean;
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
        if (typeof content[0] === "string") {
            element.textContent = content[0];
        } else {
            for (const child of content) {
                element.appendChild(child);
            }
        }
    }

    return element;
};
