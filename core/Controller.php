<?php
class Controller {
    public function view($folder,$file,$data=[]){
        extract($data);
        require BASEPATH . "views/layout/header.php";
        require BASEPATH . "views/$folder/$file.php";
        require BASEPATH . "views/layout/footer.php";
    }

    public function model($model){
        require BASEPATH . "models/$model.php";
        return new $model;
    }
}