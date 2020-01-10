class PostUI {
    static RegisterCreatePostModal(trigger: HTMLElement, category?: Category) {
        if (!category || category.Subscribed) {
            trigger.onclick = e => {
                e.stopPropagation();
                $("#create-post-modal").modal("show");
            };
            document.body.find("modal-close-button").onclick = e =>{
                e.stopPropagation();
                $("#create-post-modal").modal("hide");
            }
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
                        .filter(v => v == cat.Id).length
                ) {
                    select.appendChild(
                        <option value={cat.Id}>{cat.Name}</option>
                    );
                }
            }
        });
    }

    static RenderRating(
        parent: HTMLElement,
        postId: number,
        currentRating: number
    ) {
        const stars = new Array<HTMLElement>();
        const ratingClick = async (e) => {
            if(Config.isLoggedIn){
                const userRating = e.target.getAttribute("value");

                try{
                    await API.GET("/api/rate.php", {
                        rating: e.target.getAttribute("value"),
                        postId: postId
                    });
                }
                catch{
                    parent.appendChild(<p class="text-danger">Sie sind nicht eingeloggt</p>)
                }
    
    
                stars
                    .filter(i => i.getAttribute("value") <= userRating)
                    .forEach(i => (i.className = "fas fa-star cursor-pointer"));
    
                stars
                    .filter(i => i.getAttribute("value") > userRating)
                    .forEach(i => (i.className = "far fa-star cursor-pointer"));
            }
            else{
                location.href = Config.baseUrl + "/Account/login.php";
            }

        };

        let i = 1;

        for (; i <= currentRating; i++) {
            stars.push(
                parent.appendChild(
                    <i
                        class="fas fa-star cursor-pointer"
                        value={i}
                        onclick={ratingClick}
                    ></i>
                )
            );
        }

        for (; i <= 5; i++) {
            stars.push(
                parent.appendChild(
                    <i
                        class="far fa-star cursor-pointer"
                        value={i}
                        onclick={ratingClick}
                    ></i>
                )
            );
        }
    }

    static async RenderComments(container: HTMLElement, postId: number) {
        let res = await API.GET("/api/comment.php", { postId });
        res = JSON.parse(res) as Array<CommentViewModel>;

        const renderEdit = (parent: HTMLElement, parentId: number) => {
            if(Config.isLoggedIn){
                const edit = parent.appendChild(<div class="ml-1 mb-2">
                <div class="form-control-group mb-2">
                    <label for="text">Text</label>
                    <input class="form-control" type="text" id="text" ref="text"/>
                </div>
                <button ref="comment-button" onclick={async () => {
                    const input = edit.find("text").value;
                    const model = new CommentViewModel();
                    model.Text = input;
                    model.ParentId = parentId;
                    
                    try{
                        await API.POST("/api/comment.php", model);
                        container.textContent = "";
                        this.RenderComments(container, postId);
                    }
                    catch{
                        edit.appendChild(<p class="text-danger">Sie sind nicht eingeloggt</p>)
                    }
                    
                }} class="btn btn-primary">Kommentieren</button>
            </div>);
            }
        }

        container.appendChild(<h5 class="ml-2">Kommentare</h5>);
        renderEdit(container, postId);

        const renderComment = (
            comment: CommentViewModel,
            parent: HTMLElement
        ) => {
            const element = parent.appendChild(
                <div class="border-top border-left ml-2">
                    <p>{comment.Text}</p>
                    <div
                        class="d-flex justify-content-around"
                        ref="comment-footer"
                    ></div>
                </div>
            ) as HTMLElement;

            this.RenderRating(
                element.find("comment-footer").appendChild(<span class="text-warning"></span>),
                comment.Id,
                comment.Rating
            );
            element.find("comment-footer").appendChild(
                <span onclick={() => {renderEdit(element, comment.Id)}}>
                    <i class="fa fa-reply"></i>
                </span>
            );
            if(comment.Comments){
                for(let child of comment.Comments){
                    renderComment(child, element);
                }
            }
            
        };

        for (const comment of res) {
            renderComment(comment, container);
        }

        let icon = container.parentElement.find("comment-icon")
        icon.className = "fa fa-times";
        icon.parentElement.onclick = () => {
            container.textContent = "";
            icon.className = "fa fa-comment-alt";
            icon.parentElement.onclick = () => {this.RenderComments(container, postId)};
        }
    }
}
