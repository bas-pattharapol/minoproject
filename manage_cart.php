<?php
function php_func(){
    include_once('database.php');
    $db = new database();
    if (isset($_REQUEST['size']) && isset($_REQUEST['color'])) {
        $sizeid = $_REQUEST['size'];
        $colorid = $_REQUEST['color'];
        $productid = $_REQUEST['productid'];
        $amount = $_REQUEST['amount'];
        $price = $_REQUEST['price'];
        $user =$_REQUEST['iduser'];        
       
        if($user == ''){

        }else{
            $db->insertdata("insert into CART_LIST_TAB (CL_USER,CL_LIST_PRODUCT,CL_LIST_SIZE,CL_LIST_COLOR,CL_AMOUNT,CL_PRICE)
            values('".$user."' , '".$productid."' , '".$sizeid."' , '".$colorid."' , ".$amount." , ".$price." )");
        }
    }
    
}
php_func();
?>