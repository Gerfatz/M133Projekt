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

        public function Save($model): PostViewModel{
            $sql = "";

            if($model->Id == 0){
                $sql = "INSERT INTO post (creatorId, categoryId, title, picturePath) VALUES (:creatorId, :categoryId, :title, :path)";
                $statement = $this->db->PrepareQuery($sql);
                $args = array(
                    ":creatorId" => $model->CreatorId,
                    ":categoryId" => $model->CategoryId,
                    ":title" => $model->Title,
                    ":path" => $model->PicturePath
                );

                $statement->execute($args);
            }

            return $model;
        }
    }
?>