<?php
class Model_administrator extends CI_Model {
	
	public function cek ($username){
		$this->db->select('*');
		$this->db->where("user",$username);
		// $this->db->where("password",$password);
		return $this->db->get("administrator");
	}


	public function semua(){
		return $this->db->get('administrator');
	}

	public function cekKode($kode){
		$this->db->where('user',$kode);
		return $this->db->get('administrator');
	}

	public function cekId($kode){
		$this->db->where('id_admin', $kode);
		return $this->db->get("administrator");
	}

	public function cekUser($kode){
		$this->db->where('user', $kode);
		return $this->db->get("administrator");
	}

	public function update($id,$info){
        $this->db->where("id_admin",$id);
        $this->db->update("administrator",$info);
    }

    public function simpan($info){
    	$this->db->insert("administrator",$info);
    }

    public function hapus($kode){
    	$this->db->where('id_admin',$kode);
    	$this->db->delete("administrator");
    }


}