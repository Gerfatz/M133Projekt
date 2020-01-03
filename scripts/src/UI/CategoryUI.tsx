class CategoryUI{
    static renderCategory(parent: HTMLElement, category: Category, linkToCategory: boolean = false){
        //Create Elements
        let title = parent.find("title");
        let span = title.appendChild(<span class="float-right" title={category.Subscribed ? "Deabonnieren" : "Abonnieren"} onclick={(e) => {
            e.stopPropagation();
            let icon = e.target.firstChildElement;
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
        }}>
            <i class={category.Subscribed ? "fa fa-times text-danger" : "fa fa-bell text-primary"}></i>
        </span>);

        
        //Actions

        if(linkToCategory){
            parent.onclick = () => {
                location.href = Config.baseUrl + "/Kategorien/details.php?categoryId=" + category.Id;
            }
        }
        
        PostUI.RegisterCreatePostModal(
            document.body.find("create-post"),
            category
        );
    }
}