<?
    require_once(GetPath() .  "BusinessLogic/Repositories/DBContext.php");

    abstract class RepositoryBase{
        protected $db;

        public function __construct(){
            $this->db = new DBContext();
        }

        public abstract function Save($instance);
    }
?>