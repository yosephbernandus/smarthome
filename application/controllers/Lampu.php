<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Makassar');
class Lampu extends CI_Controller {
    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('username')) {
            redirect('login');
        }
        $this->load->library(array('template','ssp'));
        $this->load->model('model_chart');
    }

    public function index(){
        $this->template->display('lampu/index');
    }
}
?>
