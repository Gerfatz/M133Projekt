class Login{
    ValidateForm(loginForm: HTMLFormElement){
        loginForm.send();
    }

    ValidateUsername(username: HTMLInputElement){
        let name = username.value

        if(name && validateXSS(name) && name.match(/([A-Za-z0-9_]){0,}\w+/g).join("").length == name.length){
            
            let spinner = username.parentElement.find("usernameCheck");

            if(!spinner){
                spinner = document.createElement("i");
                spinner.setAttribute("ref", "usernameCheck");
            }

            spinner.className = "fa fa-spin fa-refresh";
            username.parentElement.appendChild(spinner);

            API.GET("/api/checkUsernameAvailability.php", {"username" : name}).then((res) => {
                if(res)
                {
                    spinner.className = "fa fa-check";
                }
                else
                {
                    spinner.className = "fa fa-cross";
                }
            })
        }
    }
}