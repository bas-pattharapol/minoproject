<?php
class database
{
    public $con;
    public $re;
    public $stid;
    public function database($host = '203.188.54.7/database', $user = 'USER008', $pass = 'AN172N')
    {
        $this->con = @oci_connect($user, $pass, $host);
        if (!$this->con) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }
    public function insertdata($txtSQL)
    {
        $this->con = @oci_connect('USER008', 'AN172N', '203.188.54.7/database');
        $this->stid = oci_parse($this->con, $txtSQL);
        $this->re = oci_execute($this->stid, OCI_DEFAULT);
       
        oci_commit($this->con);
    }

    public function query($txtSQL)
    {   $this->con = @oci_connect('USER008', 'AN172N', '203.188.54.7/database');
        $this->stid = oci_parse($this->con, $txtSQL);
        $this->re = oci_execute($this->stid, OCI_DEFAULT);
        if ($this->re) {
            return 1;
        } else {
            return 0;
        }
    }
    public function getdata()
    {
        return oci_fetch_array($this->stid);
    }
}
