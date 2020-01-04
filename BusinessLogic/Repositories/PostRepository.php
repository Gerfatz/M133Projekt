<?
    include_once(GetPath() . "BusinessLogic/Repositories/RepositoryBase.php");
    include_once(GetPath() . "BusinessLogic/ViewModels/PostViewModel.php");
    include_once(GetPath() . "BusinessLogic/ViewModels/CommentViewModel.php");

    class PostRepository extends RepositoryBase{
        public function GetPostById(int $id, bool $withComments): PostViewModel{
            $sql = "";
            if($withComments){
                $sql = ""; 
            }
        }

        public function GetAllPostsFromCategory(int $categoryId, int $userId = 0): array{
            $sql = "SELECT post.Id AS Id, post.title AS Title, post.categoryId AS CategoryId, post.creatorId AS CreatorId, post.uploadDate AS UploadDate, post.fileName AS FileName, ( SELECT category.name FROM category WHERE post.categoryId = category.Id ) AS CategoryName, ( SELECT user.username FROM user WHERE post.creatorId = user.Id ) AS CreatorName, (SELECT rating.rating FROM rating WHERE PostId = post.Id AND UserId = :userId) AS Rating FROM post WHERE categoryId = :categoryId";
            $sql = str_replace(":categoryId", $categoryId, $sql);
            $sql = str_replace(":userId", $userId, $sql);
            $statement = $this->db->Query($sql);
            $statement->setFetchMode(PDO::FETCH_CLASS, "PostViewModel");
            return $statement->fetchAll();
        }

        public function SaveRating(int $userId, int $postId, int $rating)
        {
            $existsQuery = $this->db->Query("SELECT * FROM rating WHERE PostId = $postId AND UserId = $userId");
            $sql = "";
            $args = array(
                    ":postId" => $postId,
                    ":userId" => $userId,
                    ":rating" => $rating
                );

            if($existsQuery->rowCount() == 0){
                $sql = "INSERT INTO rating (PostId, UserId, rating) VALUES (:postId, :userId, :rating)";
            }
            else{
                $sql = "UPDATE rating SET rating = :rating WHERE PostId = :postId AND UserId = :userId";
            }

            $statement = $this->db->PrepareQuery($sql);
            $statement->execute($args);
        }

        public function Save($model): PostViewModel{
            $sql = "";

            if($model->Id == 0){
                $sql = "INSERT INTO post (creatorId, categoryId, title, fileName) VALUES (:creatorId, :categoryId, :title, :path)";
                $statement = $this->db->PrepareQuery($sql);
                $args = array(
                    ":creatorId" => $model->CreatorId,
                    ":categoryId" => $model->CategoryId,
                    ":title" => $model->Title,
                    ":path" => $model->FileName
                );

                $statement->execute($args);
            }

            return $model;
        }
    }
?>