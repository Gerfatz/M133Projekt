class CategoryUI{
    static renderCategory(parent: HTMLElement, category: Category, linkToCategory: boolean = false){
        //Create Elements
        let title = parent.find("title");
        let span = title.appendChild(document.createElement("span"));
        let icon = span.appendChild(document.createElement("i"));
        span.className = "float-right";
        span.setAttribute("_onclick", "");
        span.title = category.Subscribed ? "Deabonnieren" : "Abonnieren";
        icon.className = category.Subscribed ? "fa fa-times text-danger" : "fa fa-bell text-primary";

        
        //Actions

        if(linkToCategory){
            parent.onclick = () => {
                location.href = Config.baseUrl + "/Kategorien/details.php?categoryId=" + category.Id;
            }
        }

        span.onclick = (e) => {
            e.stopPropagation();

            icon.className = "fa fa-spin fa-sync";
            span.title = category.Subscribed ? "Deabonnieren" : "Abonnieren";
            
            API.POST("/api/subscribe.php", {categoryId: category.Id}).then((res: string) => {      
                icon.className = parseInt(res) ? "fa fa-times text-danger" : "fa fa-bell text-primary";
                category.Subscribed = res === "1";
                PostUI.RegisterCreatePostModal(
                    document.body.find("create-post"), 
                    category
                );
            })
        }
        
        PostUI.RegisterCreatePostModal(
            document.body.find("create-post"),
            category
        );
    }
}