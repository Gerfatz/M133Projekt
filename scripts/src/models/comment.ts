class CommentViewModel {
    Id: number;
    CreatorId: number;
    CreatorName: string;
    ParentId: number;
    UploadDate: Date;
    Text: string;
    Rating: number;

    Comments: Array<CommentViewModel>;
}
