<?php
class Model_chart extends CI_Model {

	public function bulan(){
		$this->db->select('bulan');
		$this->db->from('chart');
		$this->db->where('tahun', '2016');
		$this->db->order_by('id', 'asc');
		return $this->db->get();
	}

	public function hasil_penjualan(){
		$this->db->select('hasil_penjualan');
		$this->db->from('chart');
		$this->db->where('tahun', '2016');
		$this->db->order_by('id', 'asc');
		return $this->db->get();
	}

	public function insert_suhu($simpan){
		$this->db->insert('suhu_log',$simpan);
		return $this->db->insert_id();
	}
}