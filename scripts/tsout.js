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
class API {
    static GET(url, params) {
        return new Promise((resolve, reject) => {
            if (params) {
                url += '?';
            }
            for (let key in params) {
                url += key + "=" + params[key];
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
        loginForm.send();
    }
    ValidateUsername(username) {
        let name = username.value;
        if (name && validateXSS(name) && name.match(/([A-Za-z0-9_]){0,}\w+/g).join("").length == name.length) {
            let spinner = username.parentElement.find("usernameCheck");
            if (!spinner) {
                spinner = document.createElement("i");
                spinner.setAttribute("ref", "usernameCheck");
            }
            spinner.className = "fa fa-spin fa-refresh";
            username.parentElement.appendChild(spinner);
            API.GET("/api/checkUsernameAvailability.php", { "username": name }).then((res) => {
                if (res) {
                    spinner.className = "fa fa-check";
                }
                else {
                    spinner.className = "fa fa-cross";
                }
            });
        }
    }
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
