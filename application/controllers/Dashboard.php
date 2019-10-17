<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Makassar');
class Dashboard extends CI_Controller {
    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('username')) {
         redirect('login');
        }
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('template','form_validation'));
        $this->load->model('model_administrator');
    }

    public function logout(){
        $this->session->unset_userdata('username');
        redirect('login');
    }

    public function test(){
        $suhu = '30.3';
        $state = 'ONLINE';
        $tahun = date('Y');
        $bulan = date('M');
        $jam = date('H:i:s');
        $hari = date('l');

        $info = array(
            'waktu' => $jam,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'nilai_suhu' => $suhu,
            'hari' => $hari,
            'state' => $state
            );
        $this->model_chart->insert_suhu($info);
    }

    public function proses(){
        if ($_POST == null) {
            redirect('dashboard');
        } else {
            $id = $this->input->post('id');
            $info = array(
                'user' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
                );
            $this->model_administrator->update($id,$info);
        }
    }

    public function change_password($username){
        $data['message']="";
        $data['admin'] = $this->model_administrator->cekUser($username)->row_array();
        $this->template->display('dashboard/edit',$data);
    }

    public function index(){
        $this->template->display('dashboard/dashboard');
    }

    public function table(){
        $this->template->display('table');
    }

}
?>
