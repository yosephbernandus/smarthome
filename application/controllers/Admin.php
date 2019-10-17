<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Makassar');
class Admin extends CI_Controller {
    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('username')) {
         redirect('login');
        }

        if ($this->session->userdata('level') != "admin") {
            redirect('dashboard');
        }
        
        $this->load->model('model_administrator');
        $this->load->library(array('form_validation','template'));
    }

    public function index(){
        $data['admin']=$this->model_administrator->semua()->result();
        if ($this->uri->segment(3)=="delete_success")
            $data['message']="<div class='alert alert-success'>User Deleted</div>";
        else if($this->uri->segment(3)=="add_success")
            $data['message']="<div class='alert alert-success'>User Added</div>";
        else
            $data['message']='';
        $this->template->display('admin/index',$data);
    }

    public function delete(){
        if ($_POST == null) {
            redirect('admin');
        } else {
            $kode = $this->input->post('kode');
            $this->model_administrator->hapus($kode);
        }
    }

    public function e_proses(){
        if ($_POST == null) {
            redirect('admin');
        } else {
            $id = $this->input->post('id');
            $info = array(
                'user' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'email' => $this->input->post('email'),
                'level' => $this->input->post('level')
                );
            $this->model_administrator->update($id,$info);
            $data['message']="<div class='alert alert-success'>User Updated</div>";
            $data['admin']=$this->model_administrator->cekId($id)->row_array();
            $this->template->display('admin/edit',$data);
        }
    }

    public function edit($id){
        $data['message']="";
        $data['admin']=$this->model_administrator->cekId($id)->row_array();
        $this->template->display('admin/edit',$data);
    }

    public function proses(){
        if ($_POST == null) {
            redirect('admin');
        } else {
            $user = $this->input->post('username');
            $cek=$this->model_administrator->cekKode($user);
            if ($cek->num_rows()>0) {
                $data['message']="<div class='alert alert-danger'>Username Already Used</div>";
                $this->template->display('admin/index',$data);
            } else {
                $info=array(
                    'user' => $this->input->post('username'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'email' => $this->input->post('email'),
                    'level' => $this->input->post('level')
                    );
                $this->model_administrator->simpan($info);
                redirect('admin/index/add_success');
            }
        }
    }

    function _set_rules(){
        $this->form_validation->set_rules('user','username','required|trim');
        $this->form_validation->set_rules('password','password','required|trim');
        $this->form_validation->set_error_delimiters("<div class='alert alert-danger'>","</div>");
    }
}
?>
