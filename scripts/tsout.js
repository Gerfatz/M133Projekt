const validateSearch = (elementId) => {
    let element = document.getElementById(elementId);
    if (validateXSS(element.value)) {
        element.value = validateSQL(element.value);
        return true;
    }
    alert("Possible XSS detected");
    return false;
};
const validateXSS = (input) => {
    return input.match(/(\b)(on\S+)(\s*)=|javascript|(<\s*)(\/*)script/ig) == null;
};
const validateSQL = (input) => {
    return input.match(/(^[a-zA-Z0-9])+/g).join();
};
class Config {
}
class CategoryUI {
    static renderCategory(parent, category, linkToCategory = false) {
        let title = parent.find("title");
        let span = title.appendChild(document.createElement("span"));
        let icon = span.appendChild(document.createElement("i"));
        span.className = "float-right";
        span.setAttribute("_onclick", "");
        span.title = category.Subscribed ? "Deabonnieren" : "Abonnieren";
        icon.className = category.Subscribed ? "fa fa-times text-danger" : "fa fa-bell text-primary";
        if (linkToCategory) {
            parent.onclick = () => {
                location.href = Config.baseUrl + "/Kategorien/details.php?categoryId=" + category.Id;
            };
        }
        span.onclick = (e) => {
            e.stopPropagation();
            icon.className = "fa fa-spin fa-sync";
            span.title = category.Subscribed ? "Deabonnieren" : "Abonnieren";
            API.POST("/api/subscribe.php", { categoryId: category.Id }).then((res) => {
                icon.className = parseInt(res) ? "fa fa-times text-danger" : "fa fa-bell text-primary";
            });
        };
        let createButton = parent.find("create-post");
        if (createButton) {
            createButton.onclick = (e) => {
                e.stopPropagation();
                $("#create-post-modal").modal();
            };
        }
    }
}
class PostUI {
    constructor() {
        this.default = select.appendChild(document.createElement("option"));
        this.textContent = categoryName;
    }
    static RenderCategoryDropdown(parent, categoryId = 0, categoryName = "") {
        let select = parent.find("category-select");
        let;
    }
    GET() { }
    then() { }
}
(res) => {
    res = JSON.parse(res);
    for (let category of res) {
        let option = select.appendChild(document.createElement("option"));
        option.textContent = category.Name;
        option.setAttribute("value", category.Id);
    }
};
class API {
    static GET(url, params = null) {
        return new Promise((resolve, reject) => {
            if (params) {
                url += '?';
                for (let key in params) {
                    url += key + "=" + params[key];
                }
            }
            this.Request("GET", url, "", resolve, reject);
        });
    }
    static POST(url, data) {
        return new Promise((resolve, reject) => {
            this.Request("POST", url, data, resolve, reject);
        });
    }
    static PUT(url, data) {
        return new Promise((resolve, reject) => {
            this.Request("PUT", url, data, resolve, reject);
        });
    }
    static DELETE(url, data) {
        return new Promise((resolve, reject) => {
            this.Request("DELETE", url, data, resolve, reject);
        });
    }
    static Request(method, url, data, resolve, reject) {
        let request = new XMLHttpRequest();
        request.open("POST", Config.baseUrl + url);
        request.onreadystatechange = () => {
            if (request.readyState == 4) {
                if (request.status == 200) {
                    resolve(request.response);
                }
                else {
                    reject(Error(method + " Request failed: " + request.statusText));
                }
            }
        };
        request.onerror = () => { reject(Error(method + " Request failed because of an network error")); };
        request.send(JSON.stringify(data));
    }
}
class Login {
    ValidateForm(loginForm) {
        loginForm.submit();
    }
    ValidateUsername(username) {
        let name = username.value;
        if (name && validateXSS(name) && name.match(/([A-Za-z0-9_]){0,}\w+/g).join("").length == name.length) {
            let spinner = username.parentElement.find("username-check");
            spinner.className = "fa fa-spin fa-sync";
            API.GET("/api/checkUsernameAvailability.php", { "username": name })
                .then((res) => {
                if (JSON.parse(res)) {
                    spinner.className = "fa fa-check";
                    spinner.removeAttribute("title");
                }
                else {
                    spinner.className = "fa fa-times";
                    spinner.setAttribute("title", "Dieser Benutzername ist nicht verfügbar");
                }
            });
        }
    }
}
class Category {
}
if (!HTMLElement.prototype.find) {
    HTMLElement.prototype.find = function (ref) {
        for (let child of this.children) {
            if (child.getAttribute("ref") == ref) {
                return child;
            }
            else {
                let res = child.find(ref);
                if (res) {
                    return res;
                }
            }
        }
        return undefined;
    };
}
