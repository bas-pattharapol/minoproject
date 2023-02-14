<?php

class Model
{
    public $db;
    public function __construct()
    {
        include_once('./database.php');
        $this->db = new database();
    }

    public function insertdata()
    {
        if (isset($_REQUEST['manage'])) {
            if ($_REQUEST['manage'] == 'shirt') {
                if (isset($_REQUEST['colorname'])) {
                    $color = $_REQUEST['colorname'];
                    $this->db->insertdata("insert into SHIRT_COLOR_TAB (SC_ID,SC_NAME)
                values((SELECT CONCAT('SC',LPAD(substr(NVL(max(SC_ID),'SC000'),3)+1,3,'0'))  FROM SHIRT_COLOR_TAB sct ),'" . $color . "')");
                }
                if (isset($_REQUEST['sizename'])) {
                    $size = $_REQUEST['sizename'];
                    $this->db->insertdata("insert into SHIRT_SIZE_TAB (SS_ID,SS_NAME)
                values((SELECT CONCAT('SS',LPAD(substr(NVL(max(SS_ID),'SS000'),3)+1,3,'0'))  FROM SHIRT_SIZE_TAB sct ),'" . $size . "')");
                }
                if (isset($_REQUEST['typename'])) {
                    $type = $_REQUEST['typename'];
                    $this->db->insertdata("insert into SHIRT_TYPE_TAB (ST_ID,ST_NAME)
                values((SELECT CONCAT('ST',LPAD(substr(NVL(max(ST_ID),'ST000'),3)+1,3,'0'))  FROM SHIRT_TYPE_TAB sct ),'" . $type . "')");
                }
                if (isset($_REQUEST['seasonalname'])) {
                    $seasonal = $_REQUEST['seasonalname'];
                    $this->db->insertdata("insert into SHIRT_SEASONAL_TAB (SSS_ID,SSS_NAME)
                values((SELECT CONCAT('SSS',LPAD(substr(NVL(max(SSS_ID),'SSS000'),4)+1,3,'0'))  FROM SHIRT_SEASONAL_TAB sct ),'" . $seasonal . "')");
                }
            } else if ($_REQUEST['manage'] == 'division') {
                if (isset($_REQUEST['divisionname'])) {
                    $division = $_REQUEST['divisionname'];
                    $this->db->insertdata("insert into DIVISION_TAB (DS_ID,DS_NAME)
                values((SELECT CONCAT('DS',LPAD(substr(NVL(max(DS_ID),'DS000'),3)+1,3,'0'))  FROM DIVISION_TAB ),'" . $division . "')");
                }
            } else if ($_REQUEST['manage'] == 'membershipLevel') {
                if (isset($_REQUEST['membershipLevelname'])) {
                    $membershipLevelname = $_REQUEST['membershipLevelname'];
                    $membershipLevelmin_score = $_REQUEST['membershipLevelmin_score'];
                    $membershipLevelmix_score = $_REQUEST['membershipLevelmax_score'];
                    $this->db->insertdata("insert into MEMBERSHIP_LEVEL_TAB (ML_ID,ML_NAME,ML_MIN_SCORE,ML_MAX_SCORE)
                values((SELECT CONCAT('ML',LPAD(substr(NVL(max(ML_ID),'ML000'),3)+1,3,'0'))  FROM MEMBERSHIP_LEVEL_TAB ),'" . $membershipLevelname . "','" . $membershipLevelmin_score . "','" . $membershipLevelmix_score . "')");
                }
            } else if ($_REQUEST['manage'] == 'employee') {
                if (isset($_REQUEST['employeename'])) {
                    $employeename = $_REQUEST['employeename'];
                    $employeetel = $_REQUEST['employeetel'];
                    $employeeemail = $_REQUEST['employeeemail'];
                    $employeepassword = $_REQUEST['employeepassword'];
                    $employeedivision = $_REQUEST['employeedivision'];
                    $this->db->insertdata("insert into EMPLOYEE_TAB (EMP_ID,EMP_NAME,EMP_TEL,EMP_EMAIL,EMP_PASSWORD,EMP_FK_DSID)
                values((SELECT CONCAT('EMP',LPAD(substr(NVL(max(EMP_ID),'EMP000'),4)+1,3,'0'))  FROM EMPLOYEE_TAB )
                ,'" . $employeename . "','" . $employeetel . "','" . $employeeemail . "','" . $employeepassword . "','" . $employeedivision . "')");
                }
            } else if ($_REQUEST['manage'] == 'shirtproduct') {
                if (isset($_REQUEST['shirtproductname'])) {
                    $shirtproductname = $_REQUEST['shirtproductname'];
                    $shirtproducttype = $_REQUEST['shirtproducttype'];
                    $shirtproductseasonal = $_REQUEST['shirtproductseasonal'];
                    $this->db->insertdata("insert into SHIRT_PRODUCT_TAB (SP_ID,SP_NAME,SP_FK_STID,SP_FK_SSSID)
                values((SELECT CONCAT('PD',LPAD(substr(NVL(max(SP_ID),'PD000'),3)+1,3,'0'))  FROM SHIRT_PRODUCT_TAB ),'" . $shirtproductname . "','" . $shirtproducttype . "','" . $shirtproductseasonal . "')");

                }
            }  else if ($_REQUEST['manage'] == 'promotion') {
                if (isset($_REQUEST['promotiondiscount'])) {
                    $promotiondiscount = $_REQUEST['promotiondiscount'];
                    $promotiontype = $_REQUEST['promotiontype'];
                    $promotionmembershipLevel = $_REQUEST['promotionmembershipLevel'];
                    $count = 0;

                    $this->db->query("SELECT * FROM MEMBER_PROMOTION_TAB WHERE MP_FK_STID = '".$promotiontype."' AND MP_FK_MLID = '".$promotionmembershipLevel."'");
                    while ($row = $this->db->getdata()) {
                        $count = 1;
                    }
                    if( $count == 0){
                    $this->db->insertdata("insert into MEMBER_PROMOTION_TAB (MP_ID,MP_DISCOUNT,MP_FK_STID,MP_FK_MLID)
                values((SELECT CONCAT('MP',LPAD(substr(NVL(max(MP_ID),'MP000'),3)+1,3,'0'))  FROM MEMBER_PROMOTION_TAB ),'" . $promotiondiscount . "','" . $promotiontype . "','" . $promotionmembershipLevel . "')");
                    }else{
                        return 'โปรโมชั่นนี้มีอยู่แล้ว'; 
                    }
                }
            } else if ($_REQUEST['manage'] == 'product'){        
            
                if (isset($_REQUEST['productname'])) {
                    $productname = $_REQUEST['productname'];
                    $productcolor = $_REQUEST['productcolor'];
                    $productsize = $_REQUEST['productsize'];
                    $count = 0;

                    $this->db->query("SELECT * FROM PRODUCT_PRICE_TAB WHERE PP_FK_PDID = '".$productname."' AND PP_FK_SCID = '".$productcolor."' AND PP_FK_SSID = '". $productsize."'");
                    while ($row = $this->db->getdata()) {
                        $count = 1;
                    }
                    if( $count == 0){
                        if(isset($_FILES['upload'])){
                            $name_file =  $productname;
                            $name_file_all = $_FILES['upload']['name'];
                            $tmp_name =  $_FILES['upload']['tmp_name'];
                            $type_name =  $_FILES['upload']['type'];
                            $locate_img = "static/img/";
    
                            $dataname = explode(".", $name_file_all);
                            $type_name  = $dataname[count($dataname)-1];
                            move_uploaded_file($tmp_name, $locate_img . $name_file.$productcolor.'.'. $type_name );
                            


                            $this->db->insertdata("insert into PRODUCT_PRICE_TAB (PP_IMG,PP_FK_PDID,PP_FK_SSID,PP_FK_SCID)
                            values('". $name_file.$productcolor.'.'. $type_name."' , '".$productname."' , '".$productsize."' , '".$productcolor."')");
                            
                        }
                    }else{
                        return 'สินค้านี้มีอยู่แล้ว'; 
                    }
                    
                
                   
                }
              

            }
        }
    }

    public function deldata()
    {
        if (isset($_REQUEST['manage'])) {
            if ($_REQUEST['manage'] == 'shirt') {
                if ($_REQUEST['select_manage'] == 'color') {
                    if (isset($_REQUEST['id'])) {
                        $id = $_REQUEST['id'];
                        $this->db->insertdata("delete from SHIRT_COLOR_TAB where SC_ID = '" . $id . "'");
                    }
                }
                if ($_REQUEST['select_manage'] == 'size') {
                    if (isset($_REQUEST['id'])) {
                        $id = $_REQUEST['id'];
                        $this->db->insertdata("delete from SHIRT_SIZE_TAB where SS_ID = '" . $id . "'");
                    }
                }
                if ($_REQUEST['select_manage'] == 'type') {
                    if (isset($_REQUEST['id'])) {
                        $id = $_REQUEST['id'];
                        $this->db->insertdata("delete from SHIRT_TYPE_TAB where ST_ID = '" . $id . "'");
                    }
                }
                if ($_REQUEST['select_manage'] == 'seasonal') {
                    if (isset($_REQUEST['id'])) {
                        $id = $_REQUEST['id'];
                        $this->db->insertdata("delete from SHIRT_SEASONAL_TAB where SSS_ID = '" . $id . "'");
                    }
                }
            } else if ($_REQUEST['manage'] == 'division') {
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    $this->db->insertdata("delete from DIVISION_TAB where DS_ID = '" . $id . "'");
                }
            } else if ($_REQUEST['manage'] == 'promotion') {
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    $this->db->insertdata("delete from MEMBER_PROMOTION_TAB where MP_ID = '" . $id . "'");
                }
            } else if ($_REQUEST['manage'] == 'membershipLevel') {
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    $this->db->insertdata("delete from MEMBERSHIP_LEVEL_TAB where ML_ID = '" . $id . "'");
                }
            } else if ($_REQUEST['manage'] == 'employee') {
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    $this->db->insertdata("delete from EMPLOYEE_TAB where EMP_ID = '" . $id . "'");
                }
            }else if ($_REQUEST['manage'] == 'shirtproduct') {
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    $this->db->insertdata("delete from SHIRT_PRODUCT_TAB where SP_ID = '" . $id . "'");
                }
            }else if ($_REQUEST['manage'] == 'product') {
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    $color = $_REQUEST['color'];
                    $size = $_REQUEST['size'];
                    $filename = $_REQUEST['img']; //get the filename
                    unlink('static/img/'.$filename);
                    //echo "delete from PRODUCT_PRICE_TAB where PP_FK_PDID = '" . $id . "' and PP_FK_SCID = '".$color."' and PP_FK_SSID = '".$size."'";
                    $this->db->insertdata("delete from PRODUCT_PRICE_TAB where PP_FK_PDID = '" . $id . "' and PP_FK_SCID = '".$color."' and PP_FK_SSID = '".$size."'");
                }
            }
        }
        
    }
    public function editdata()
    {
        if (isset($_REQUEST['manage'])) {
            if ($_REQUEST['manage'] == 'shirt') {
                if ($_REQUEST['select_manage'] == 'color') {
                    if (isset($_REQUEST['id'])) {
                        $id = $_REQUEST['id'];
                        $color = $_REQUEST['colorname'];
                        $this->db->insertdata("UPDATE SHIRT_COLOR_TAB set SC_NAME = '" . $color . "' where SC_ID = '" . $id . "'");
                    }
                }
                if ($_REQUEST['select_manage'] == 'size') {
                    if (isset($_REQUEST['id'])) {
                        $id = $_REQUEST['id'];
                        $size = $_REQUEST['sizename'];
                        $this->db->insertdata("UPDATE SHIRT_SIZE_TAB set SS_NAME = '" . $size . "' where SS_ID = '" . $id . "'");
                    }
                }
                if ($_REQUEST['select_manage'] == 'type') {
                    if (isset($_REQUEST['id'])) {
                        $id = $_REQUEST['id'];
                        $type = $_REQUEST['typename'];
                        $this->db->insertdata("UPDATE SHIRT_TYPE_TAB set ST_NAME = '" . $type . "' where ST_ID = '" . $id . "'");
                    }
                }
                if ($_REQUEST['select_manage'] == 'seasonal') {
                    if (isset($_REQUEST['id'])) {
                        $id = $_REQUEST['id'];
                        $seasonal = $_REQUEST['seasonalname'];
                        $this->db->insertdata("UPDATE SHIRT_SEASONAL_TAB set SSS_NAME = '" . $seasonal . "' where SSS_ID = '" . $id . "'");
                    }
                }
            } else if ($_REQUEST['manage'] == 'division') {
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    $division = $_REQUEST['divisionname'];
                    $this->db->insertdata("UPDATE  DIVISION_TAB set DS_NAME = '" . $division . "' where DS_ID = '" . $id . "'");
                }
            } else if ($_REQUEST['manage'] == 'membershipLevel') {
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    $membershipLevelname = $_REQUEST['membershipLevelname'];
                    $membershipLevelmin_score = $_REQUEST['membershipLevelmin_score'];
                    $membershipLevelmix_score = $_REQUEST['membershipLevelmax_score'];
                    $this->db->insertdata("UPDATE MEMBERSHIP_LEVEL_TAB set ML_NAME = '" . $membershipLevelname . "' , ML_MIN_SCORE = '" . $membershipLevelmin_score . "' , ML_MAX_SCORE = '" . $membershipLevelmix_score . "' where ML_ID = '" . $id . "'");
                }
            } else if ($_REQUEST['manage'] == 'employee') {
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    $employeename = $_REQUEST['employeename'];
                    $employeetel = $_REQUEST['employeetel'];
                    $employeeemail = $_REQUEST['employeeemail'];
                    $employeedivision = $_REQUEST['employeedivision'];
                    $this->db->insertdata("UPDATE EMPLOYEE_TAB set EMP_NAME = '" . $employeename . "' , EMP_TEL = '" . $employeetel . "' , EMP_EMAIL= '" . $employeeemail . "' , EMP_FK_DSID = '" . $employeedivision . "'  where EMP_ID = '" . $id . "'");
                }
            }else if ($_REQUEST['manage'] == 'shirtproduct') {
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    $shirtproductname = $_REQUEST['shirtproductname'];
                    $shirtproducttype = $_REQUEST['shirtproducttype'];
                    $shirtproductseasonal = $_REQUEST['shirtproductseasonal'];
                    $this->db->insertdata("UPDATE SHIRT_PRODUCT_TAB set SP_NAME = '".$shirtproductname."' , SP_FK_STID = '".$shirtproducttype."' , SP_FK_SSSID = '".$shirtproductseasonal."'  where SP_ID = '" . $id . "'");
                }
            }else if ($_REQUEST['manage'] == 'product') {
                if (isset($_REQUEST['idPD'])) {
                    $id = $_REQUEST['idPD'];
                    $color = $_REQUEST['idSC'];
                    $size = $_REQUEST['idSS'];
                    $productstatus = $_REQUEST['productstatus'];
                    $productprice = $_REQUEST['productprice'];
                    $this->db->insertdata("UPDATE PRODUCT_PRICE_TAB set PP_PRICE =  '".$productprice."' ,  PP_FK_PSID = '".$productstatus."' where PP_FK_PDID = '" . $id . "' and PP_FK_SCID = '".$color."' and PP_FK_SSID = '".$size."'");
                }
            } else if ($_REQUEST['manage'] == 'checkPayment') {
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    $emp = $_SESSION['iduser'];
                  
                    $this->db->insertdata("UPDATE RECEIPT_TAB set RC_FK_EMPID =  '".$emp."' ,  RC_STATUS = 'PS003' where RC_ON = '" . $id . "'");
                }
            }       
        }
    }
    
}
