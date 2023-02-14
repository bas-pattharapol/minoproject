<?php
function check(){
    include_once('database.php');
    $db = new database();
    $PL_AMOUNT = 0;
    
    if (isset($_REQUEST['size']) && isset($_REQUEST['color'])) {
        $sizeid = $_REQUEST['size'];
        $colorid = $_REQUEST['color'];
        $productid = $_REQUEST['productid'];
        $db->query("SELECT sum(PL_AMOUNT) as PL_AMOUNT
                    FROM USER008.PRODUCT_LOT_TAB 
                    WHERE PL_FK_PP_PDID = '".$productid."' 
                    AND  PL_FK_PP_SCID = '".$colorid."'  
                    AND PL_FK_PP_SSID = '".$sizeid."' ");
        while ($row = $db->getdata()) {
            $PL_AMOUNT = $row['PL_AMOUNT'];
            
        }
        if ($PL_AMOUNT  > 0){
            echo $PL_AMOUNT;
        }else{
            echo '0';
        }
        
    }
}
check();
?>