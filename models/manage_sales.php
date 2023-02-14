<?php
class Model
{
    public $db, $db1 , $db2;
    public function __construct()
    {
        include_once('./database.php');
        $this->db = new database();
        $this->db1 = new database();
    }
    public function sell()
    {
        if (isset($_REQUEST['manage'])) {
            if ($_REQUEST['manage'] == 'order') {
                $address =  $_REQUEST['address'];
                $iduser = $_REQUEST['iduser'];
                $this->db->insertdata("insert into RECEIPT_TAB 
                (RC_ON,RC_DATE,RC_FK_CMID,RC_FK_ADID,RC_TOTAL_PRICE)
                values ((SELECT CONCAT('RC',LPAD(substr(NVL(max(RC_ON),'RC000'),3)+1,3,'0'))  FROM RECEIPT_TAB ),
                        (TO_DATE((select to_char(sysdate, 'YYYY-MM-DD hh24:mi:ss') from dual), 'yyyy-mm-dd hh24:mi:ss')),
                        '" . $iduser . "' , '" . $address . "' , ( SELECT  sum((CL_PRICE * sum(CL_AMOUNT) )) AS TOTAL_PRICE FROM CART_LIST_TAB where CL_USER = '" . $_SESSION['iduser'] . "' GROUP BY CL_LIST_PRODUCT,CL_LIST_SIZE,CL_LIST_COLOR ,CL_PRICE ))");

                $this->db->query("SELECT  DISTINCT 
                     (SELECT SP_NAME FROM SHIRT_PRODUCT_TAB WHERE SP_ID = CL_LIST_PRODUCT) AS CL_PD,
                     (SELECT SS_NAME FROM SHIRT_SIZE_TAB   WHERE SS_ID = CL_LIST_SIZE) AS CL_SS,
                     (SELECT SC_NAME FROM SHIRT_COLOR_TAB sct  WHERE SC_ID = CL_LIST_COLOR) AS CL_SC,
                     (SELECT PP_IMG FROM USER008.PRODUCT_PRICE_TAB WHERE PP_FK_PDID = CL_LIST_PRODUCT AND ROWNUM <= 1) AS CL_IMG,
                      CL_PRICE , sum(CL_AMOUNT) as CL_AMOUNT , (CL_PRICE * sum(CL_AMOUNT) ) AS CL_TOTAL ,
                      CL_LIST_PRODUCT , CL_LIST_SIZE,CL_LIST_COLOR
                     FROM CART_LIST_TAB 
                     where CL_USER = '" . $_SESSION['iduser'] . "'
                     GROUP BY CL_LIST_PRODUCT,CL_LIST_SIZE,CL_LIST_COLOR ,CL_PRICE 
                     ");
                $count_on = 0;
                while ($row = $this->db->getdata()) {
                    $count_on++;
                    $this->db1->insertdata("insert into SALES_TAB 
                    (SA_ON,SA_AMOUNT,SA_PRICE_PER,SA_PRICE_TOTAL,SA_FK_RCID,SA_FK_PPSS,SA_FK_PPSC,SA_FK_PPPD)
                    values(" . $count_on . "," . $row['CL_AMOUNT'] . " , " . $row['CL_PRICE'] . " , " . $row['CL_TOTAL'] . " , 
                    (SELECT CONCAT('RC',LPAD(substr(NVL(max(RC_ON),'RC000'),3),3,'0'))  FROM RECEIPT_TAB ),
                    '" . $row['CL_LIST_SIZE'] . "' , '" . $row['CL_LIST_COLOR'] . "' , '" . $row['CL_LIST_PRODUCT'] . "'
                    )
                    ");
                    
                    
                    $this->db1->insertdata(" UPDATE USER008.PRODUCT_LOT_TAB
                    set PL_AMOUNT = (PL_AMOUNT - ".$row['CL_AMOUNT'].")
                
                    WHERE PL_FK_PP_SSID = '".$row['CL_LIST_SIZE']."' AND PL_FK_PP_SCID = '".$row['CL_LIST_COLOR'] ."' AND PL_FK_PP_PDID = '".$row['CL_LIST_PRODUCT']."' AND PL_AMOUNT >= ".$row['CL_AMOUNT'] ."  AND   ROWNUM <= 1                   
                    ");

                    
                }

                $this->db1->insertdata("DELETE FROM CART_LIST_TAB where CL_USER = '" . $_SESSION['iduser'] . "' ");
            }
        }
    }
    public function comfirm(){
        if (isset($_REQUEST['manage'])){
            if ($_REQUEST['manage'] == 'order') {
                $payment = $_REQUEST['payment'];
                $RC_ON = $_REQUEST['RC_ON'];
                $this->db->insertdata("UPDATE RECEIPT_TAB 
                set RC_AMOUNT_RECEIVED = '".$payment."' , RC_STATUS ='PS002' 
                WHERE RC_ON = '".$RC_ON ."'");


            }
        }
    }

}
