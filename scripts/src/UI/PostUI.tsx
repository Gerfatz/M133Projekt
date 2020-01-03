class PostUI {
    static RegisterCreatePostModal(trigger: HTMLElement, category?: Category) {
        if (!category || category.Subscribed) {
            trigger.onclick = e => {
                e.stopPropagation();
                $("#create-post-modal").modal("show");
            };
        } else {
            trigger.onclick = () => {
                alert("Es kann nur in abonnierten Kategorien gepostet werden");
            };
        }

        const modal = document.getElementById("create-post-modal");

        let select = modal.find("category-select");
        if (category) {
            let defaultOption = select.find("default-option");
            if (!defaultOption) {
                defaultOption = select.appendChild(
                    <option value={category.Id} ref="default-option">
                        {category.Name}
                    </option>
                );
            }
        }

        API.GET("/api/getSubscribedCategories.php").then(res => {
            res = JSON.parse(res);
            for (let cat of res) {
                if (
                    ![...select.childNodes]
                        .map(o => (o as HTMLElement).getAttribute("value"))
                        .filter(v => v == cat.Id)
                        .length
                ) {
                    select.appendChild(
                        <option value={cat.Id}>{cat.Name}</option>
                    );
                }
            }
        });
    }

    static RenderRating(parent: HTMLElement, currentRating: number){
        let i = 1;

        for(; i<=currentRating; i++){
            parent.appendChild(<i class="fas fa-star" value={i}></i>);
        }

        for(; i<=5; i++){
            parent.appendChild(<i class="far fa-star" value={i}></i>);
        }
    }
}