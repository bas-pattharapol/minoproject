<?php
function check(){
    include_once('database.php');
    $db = new database();
    $PP_PRICE = 0;
    
    if (isset($_REQUEST['size']) && isset($_REQUEST['color'])) {
        $sizeid = $_REQUEST['size'];
        $colorid = $_REQUEST['color'];
        $productid = $_REQUEST['productid'];
        $db->query("SELECT PP_PRICE
                    FROM USER008.PRODUCT_PRICE_TAB 
                    WHERE PP_FK_PDID = '".$productid."' 
                    AND PP_FK_SCID = '".$colorid."'  
                    AND PP_FK_SSID = '".$sizeid."' ");
        while ($row = $db->getdata()) {
            $PP_PRICE = $row['PP_PRICE'];
            
        }
        if ($PP_PRICE  > 0){
            echo $PP_PRICE;
        }else{
            echo '0';
        }
        
    }
}
check();
?>