class CategoryUI {
    static renderCategory(
        parent: HTMLElement,
        category: Category,
        linkToCategory: boolean = false
    ) {
        //Create Elements
        let title = parent.find("title");

        const subscribeAction = (e: Event) => {
            e.stopPropagation();
            let icon = e.target as any;
            icon.className = "fa fa-spin fa-sync";
            span.title = category.Subscribed ? "Deabonnieren" : "Abonnieren";

            API.POST("/api/subscribe.php", {
                categoryId: category.Id
            }).then((res: string) => {
                icon.className = parseInt(res)
                    ? "fa fa-times text-danger"
                    : "fa fa-bell text-primary";
                category.Subscribed = res === "1";

                if(!linkToCategory){                 
                    PostUI.RegisterCreatePostModal(
                        document.body.find("create-post"),
                        category
                    );
                }
            });
        };

        let span = title.appendChild(
            <span
                class="float-right"
                title={category.Subscribed ? "Deabonnieren" : "Abonnieren"}
                onclick={subscribeAction}>
                <i
                    class={
                        category.Subscribed
                            ? "fa fa-times text-danger"
                            : "fa fa-bell text-primary"
                    }
                ></i>
            </span>
        );

        //Actions

        if (linkToCategory) {
            parent.onclick = () => {
                location.href =
                    Config.baseUrl +
                    "/Kategorien/details.php?categoryId=" +
                    category.Id;
            };
        }
        else
        {
            PostUI.RegisterCreatePostModal(
                document.body.find("create-post"),
                category
            );
        }
    }
}