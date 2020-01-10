class Login{
    ValidateUsername(username: HTMLInputElement){
        let name = username.value

        if(name){
            
            let spinner = username.parentElement.find("username-check");

            spinner.className = "fa fa-spin fa-sync";

            API.GET("/api/checkUsernameAvailability.php", {"username" : name})
            .then((res) => {
                if(JSON.parse(res))
                {
                    spinner.className = "fa fa-check";
                    spinner.removeAttribute("title");
                }
                else
                {
                    spinner.className = "fa fa-times";
                    spinner.setAttribute("title", "Dieser Benutzername ist nicht verfügbar");
                }
            })
        }
    }
}