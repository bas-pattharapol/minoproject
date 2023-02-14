<?php

class Controller 
{
    public $model;
    public function __construct()
    {
        if (isset($_GET['page'])) {
            $model =$_GET['page'];
            include_once "models/$model.php";
        } else {

            include_once "models/main.php";
        }
        $this->model = new Model();
    }
    public function invoke()
    {
        $reslt = '';
        $username = '';
        if (isset($_GET['action'])) {
            $action = ($_GET['action']);
            $reslt = $this->model->$action();
        }else{
                
        }
        if(isset($_SESSION['seccion_login']) && isset($_SESSION['seccion_login']) == 'OK' && isset($_SESSION['type_login']) ){
            if ($_SESSION['type_login'] == 'employee'){
                if (isset($_GET['page'])) {
                    $view =$_GET['page'];
                    if (isset($_GET['manage'])){
                        $manage = $_GET['manage'];
                    }else{
                        $manage  = '';
                    }
                    if (isset($_GET['select_manage'])){
                        $select_manage = $_GET['select_manage'];
                    }else{
                        $select_manage = '';
                    }
                    include_once "views/$view.php";
                } else {
                    include_once "views/main.php";
                }
            }else if($_SESSION['type_login'] == 'customer'){
                if (isset($_GET['page'])) {
                    $view =$_GET['page']; 
                    if (isset($_GET['manage'])){
                        $manage = $_GET['manage'];
                    }else{
                        $manage  = '';
                    }
                    if (isset($_GET['select_manage'])){
                        $select_manage = $_GET['select_manage'];
                    }else{
                        $select_manage = '';
                    }
                    include_once "views/storefront/$view.php";
                } else {
                    include_once "views/storefront/index.php";
                }
            }
        }else{
            $username = 'no';
            if (isset($_GET['page'])) {
                if($_GET['page'] == 'login' ){
                    $view =$_GET['page'];
                    include_once "views/$view.php";
                }else{
                    $view =$_GET['page']; 
                    if (isset($_GET['manage'])){
                        $manage = $_GET['manage'];
                    }else{
                        $manage  = '';
                    }
                    if (isset($_GET['select_manage'])){
                        $select_manage = $_GET['select_manage'];
                    }else{
                        $select_manage = '';
                    }
                    include_once "views/storefront/$view.php";
                }    
            }else{
                include 'views/storefront/index.php';
            }
        }

    }
}
