<?php
class Model
{   public $db;
    public function getlogin()
    {
        include_once('./database.php');
        $this->db = new database();
        $ck = false;
       
        if (isset($_REQUEST['email']) && isset($_REQUEST['password'])) {
            if (isset($_REQUEST['for'])) {
                if($_REQUEST['for'] == 'employee' ){
                    $this->db->query("SELECT * FROM EMPLOYEE_TAB");
                    while ($row = $this->db->getdata()) {
                        if ($_REQUEST['email'] == $row['EMP_EMAIL'] && $_REQUEST['password'] == $row['EMP_PASSWORD']) {
                            $_SESSION['seccion_login'] = 'OK';
                            $_SESSION['user'] =  $row['EMP_NAME'];
                            $_SESSION['iduser'] =   $row['EMP_ID'];
                            $_SESSION['ds'] =  $row['EMP_FK_DSID'];
                            $_SESSION['type_login'] =  'employee';
                            header('location: index.php');
                            $ck = true;
                            return 'ok';
                        } else {
                            $_SESSION['seccion_login'] = 'Fail';
                            $_SESSION['user'] = '';
                            $_SESSION['ds'] = '';
                            
            
                        }
                    }
                    if($ck == false){
                        return 'Invalid email or password';
                    }
                }else if($_REQUEST['for'] == 'customer' ){
                    $this->db->query("SELECT * FROM CUSTOMER_TAB");
                    while ($row = $this->db->getdata()) {
                        if ($_REQUEST['email'] == $row['CM_EMAIL'] && $_REQUEST['password'] == $row['CM_PASSWORD']) {
                            $_SESSION['seccion_login'] = 'OK';
                            $_SESSION['user'] =  $row['CM_NAME'];
                            $_SESSION['iduser'] =   $row['CM_ID'];
                            $_SESSION['type_login'] =  'customer';
                            $_SESSION['tel'] =  $row['CM_TEL'];
                            header('location: index.php');
                            $ck = true;
                            return 'ok';
                        } else {
                            $_SESSION['seccion_login'] = 'Fail';
                            $_SESSION['user'] = '';
                           
                            
            
                        }
                    }
                    if($ck == false){
                        return 'Invalid email or password';
                    }
                }
            }
            
           
        }
    }
}
