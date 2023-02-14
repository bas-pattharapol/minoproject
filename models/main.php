<?php
class Model
{
    function logout(){
        $_SESSION['seccion_login'] = '';
        $_SESSION['user'] = '';
        $_SESSION['ds'] = '';
        $_SESSION['type_login'] = '';
        $_SESSION['tel'] = '' ; 
        session_destroy();
        header('location:index.php');
    }
}
