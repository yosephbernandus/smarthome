<?php
class Model_suhu extends CI_Model {
	
    public function simpan($info){
    	$this->db->insert("administrator",$info);
    }
}