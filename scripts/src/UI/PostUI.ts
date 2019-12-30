class PostUI{
    static RenderCategoryDropdown(parent: HTMLElement, categoryId: number = 0, categoryName: string = ""){

        let select = parent.find("category-select");
        let default = select.appendChild(document.createElement("option"));
        default.textContent = categoryName;
        default.setAttribute("value", categoryId);

        API.GET("api/getSubscribedCategories").then((res) => {
            res = JSON.parse(res);
            for(let category of res){
                let option = select.appendChild(document.createElement("option"));
                option.textContent = category.Name;
                option.setAttribute("value", category.Id);
            }
        })
    }
}