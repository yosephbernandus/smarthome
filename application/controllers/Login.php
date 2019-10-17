<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Makassar');
Class Login extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('template');
		if ($this->session->userdata('username')) {
			redirect('dashboard');
		}
		$this->load->model('model_administrator');
	}

	public function index(){
		$data = array(
			'action' => site_url('login/proses'),
			'username' => set_value('username'),
			'password' => set_value('password')
		);
		$this->load->view('login/index.php',$data);
	}

	public function proses(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean');
		$this->form_validation->set_rules('password', 'password', 'required|trim|xss_clean');

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$cek = $this->model_administrator->cek($username);

		if ($cek->num_rows()>0) {
			$hash = $this->model_administrator->cek($username)->result();
			foreach ($hash as $row) {
				if (password_verify($password, $row->password)) {
					$admin = array (
						'username' => $username,
						'password' => $password,
						'level' => $row->level,
						'email' => $row->email
					);
					$this->session->set_userdata($admin);
					redirect('dashboard');
				} else {
					$this->session->set_flashdata('message', 'Wrong username or password');
					redirect('login');
				}
			}
		} else {
			$this->session->set_flashdata('message', 'Wrong username or password');
			redirect('login');
		}
	}
}