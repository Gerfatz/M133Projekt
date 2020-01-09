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
    return (input.match(/(\b)(on\S+)(\s*)=|javascript|(<\s*)(\/*)script/gi) == null);
};
const validateSQL = (input) => {
    return input.match(/(^[a-zA-Z0-9])+/g).join();
};
class Config {
}
const CreateElement = (tagname, attributes, ...content) => {
    let element = document.createElement(tagname);
    if (attributes) {
        for (const key in attributes) {
            if (attributes.hasOwnProperty(key)) {
                if (typeof attributes[key] == "function") {
                    element[key] = attributes[key];
                    element.setAttribute("_" + key, "");
                }
                else {
                    element.setAttribute(key, attributes[key]);
                }
            }
        }
    }
    if (content) {
        if (typeof content[0] === "string") {
            element.textContent = content[0];
        }
        else {
            for (const child of content) {
                element.appendChild(child);
            }
        }
    }
    return element;
};
class Validator {
    static Create(models) {
        document.onreadystatechange = () => {
            if (document.readyState == "complete") {
                const inputs = document.querySelectorAll("input");
                models.forEach(error => {
                    const element = [...inputs].filter(i => i.name == error.name)[0];
                    element.classList.add("is-invalid");
                    if (error.message) {
                        element.parentElement.appendChild(CreateElement("div", { class: "invalid-feedback" }, error.message));
                    }
                    if (error.value) {
                        element.value = error.value;
                    }
                });
            }
        };
    }
}
class ErrorModel {
}
class CategoryUI {
    static renderCategory(parent, category, linkToCategory = false) {
        let title = parent.find("title");
        const subscribeAction = (e) => {
            e.stopPropagation();
            let icon = e.target;
            icon.className = "fa fa-spin fa-sync";
            span.title = category.Subscribed ? "Deabonnieren" : "Abonnieren";
            API.POST("/api/subscribe.php", {
                categoryId: category.Id
            }).then((res) => {
                icon.className = parseInt(res)
                    ? "fa fa-times text-danger"
                    : "fa fa-bell text-primary";
                category.Subscribed = res === "1";
                if (!linkToCategory) {
                    PostUI.RegisterCreatePostModal(document.body.find("create-post"), category);
                }
            });
        };
        let span = title.appendChild(CreateElement("span", { class: "float-right", title: category.Subscribed ? "Deabonnieren" : "Abonnieren", onclick: subscribeAction },
            CreateElement("i", { class: category.Subscribed
                    ? "fa fa-times text-danger"
                    : "fa fa-bell text-primary" })));
        if (linkToCategory) {
            parent.onclick = () => {
                location.href =
                    Config.baseUrl +
                        "/Kategorien/details.php?categoryId=" +
                        category.Id;
            };
        }
        else {
            PostUI.RegisterCreatePostModal(document.body.find("create-post"), category);
        }
    }
}
class PostUI {
    static RegisterCreatePostModal(trigger, category) {
        if (!category || category.Subscribed) {
            trigger.onclick = e => {
                e.stopPropagation();
                $("#create-post-modal").modal("show");
            };
            document.body.find("modal-close-button").onclick = e => {
                e.stopPropagation();
                $("#create-post-modal").modal("hide");
            };
        }
        else {
            trigger.onclick = () => {
                alert("Es kann nur in abonnierten Kategorien gepostet werden");
            };
        }
        const modal = document.getElementById("create-post-modal");
        let select = modal.find("category-select");
        if (category) {
            let defaultOption = select.find("default-option");
            if (!defaultOption) {
                defaultOption = select.appendChild(CreateElement("option", { value: category.Id, ref: "default-option" }, category.Name));
            }
        }
        API.GET("/api/getSubscribedCategories.php").then(res => {
            res = JSON.parse(res);
            for (let cat of res) {
                if (![...select.childNodes]
                    .map(o => o.getAttribute("value"))
                    .filter(v => v == cat.Id).length) {
                    select.appendChild(CreateElement("option", { value: cat.Id }, cat.Name));
                }
            }
        });
    }
    static RenderRating(parent, postId, currentRating) {
        const stars = new Array();
        const ratingClick = e => {
            const userRating = e.target.getAttribute("value");
            API.GET("/api/rate.php", {
                rating: e.target.getAttribute("value"),
                postId: postId
            });
            stars
                .filter(i => i.getAttribute("value") <= userRating)
                .forEach(i => (i.className = "fas fa-star cursor-pointer"));
            stars
                .filter(i => i.getAttribute("value") > userRating)
                .forEach(i => (i.className = "far fa-star cursor-pointer"));
        };
        let i = 1;
        for (; i <= currentRating; i++) {
            stars.push(parent.appendChild(CreateElement("i", { class: "fas fa-star cursor-pointer", value: i, onclick: ratingClick })));
        }
        for (; i <= 5; i++) {
            stars.push(parent.appendChild(CreateElement("i", { class: "far fa-star cursor-pointer", value: i, onclick: ratingClick })));
        }
    }
    static async RenderComments(container, postId) {
        let res = await API.GET("/api/comment.php", { postId });
        res = JSON.parse(res);
        const renderEdit = (parent, parentId) => {
            const edit = parent.appendChild(CreateElement("div", { class: "ml-1 mb-2" },
                CreateElement("div", { class: "form-control-group mb-2" },
                    CreateElement("label", { for: "text" }, "Text"),
                    CreateElement("input", { class: "form-control", type: "text", id: "text", ref: "text" })),
                CreateElement("button", { onclick: async () => {
                        const input = edit.find("text").value;
                        if (validateXSS(input)) {
                            const model = new CommentViewModel();
                            model.Text = input;
                            model.ParentId = parentId;
                            await API.POST("/api/comment.php", model);
                            container.textContent = "";
                            this.RenderComments(container, postId);
                        }
                    }, class: "btn btn-primary" }, "Kommentieren")));
        };
        container.appendChild(CreateElement("h5", { class: "ml-2" }, "Kommentare"));
        renderEdit(container, postId);
        const renderComment = (comment, parent) => {
            const element = parent.appendChild(CreateElement("div", { class: "border-top border-left ml-2" },
                CreateElement("p", null, comment.Text),
                CreateElement("div", { class: "d-flex justify-content-around", ref: "comment-footer" })));
            this.RenderRating(element.find("comment-footer").appendChild(CreateElement("span", { class: "text-warning" })), comment.Id, comment.Rating);
            element.find("comment-footer").appendChild(CreateElement("span", { onclick: () => { renderEdit(element, comment.Id); } },
                CreateElement("i", { class: "fa fa-reply" })));
            if (comment.Comments) {
                for (let child of comment.Comments) {
                    renderComment(child, element);
                }
            }
        };
        for (const comment of res) {
            renderComment(comment, container);
        }
        let icon = container.parentElement.find("comment-icon");
        icon.className = "fa fa-times";
        icon.parentElement.onclick = () => {
            container.textContent = "";
            icon.className = "fa fa-comment-alt";
            icon.parentElement.onclick = () => { this.RenderComments(container, postId); };
        };
    }
}
class API {
    static GET(url, params = null) {
        return new Promise((resolve, reject) => {
            if (params) {
                url += '?';
                for (let key in params) {
                    url += key + "=" + params[key] + "&";
                }
                url = url.substr(0, url.length - 1);
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
        request.open(method, Config.baseUrl + url);
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
class CommentViewModel {
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
