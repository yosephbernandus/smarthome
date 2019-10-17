<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Makassar');
class Ac extends CI_Controller {
    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('username')) {
            redirect('login');
        }
        $this->load->library(array('template','ssp'));
        $this->load->model('model_chart');
    }

    public function index(){
        $this->template->display('ac/index');
    }

    public function suhu_proses(){
        if ($_POST == null) {
            redirect('dashboard','refresh');
        } else {
            $suhu = $this->input->post('suhu');
            $state = $this->input->post('state');
            $tahun = date('Y');
            $bulan = date('M');
            $jam = date('H:i:s');
            $hari = date('l');
            $tanggal = date('d');

            $simpan = array(
                'waktu' => $jam,
                'tahun' => $tahun,
                'bulan' => $bulan,
                'nilai_suhu' => $suhu,
                'hari' => $hari,
                'tanggal' => $tanggal
            );
            $this->model_chart->insert_suhu($simpan);
        }
    }

    public function data(){
        $table = 'suhu_log';
        $primaryKey = 'id_suhu';
        $columns = array(
            array('db' => 'tahun', 'dt' => 'tahun'),
            array('db' => 'bulan', 'dt' => 'bulan'),
            array('db' => 'hari', 'dt' => 'hari'),
            array('db' => 'waktu', 'dt' => 'waktu'),
            array('db' => 'tanggal', 'dt' => 'tanggal'),
            array('db' => 'nilai_suhu', 'dt' => 'nilai_suhu'),
        );
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
 
        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
    }
}
?>
