<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template{
	protected $_CI;
	function __construct(){
		$this->_CI=&get_instance();
	}

	public function display($template, $data=null){
		$data['_content']=$this->_CI->load->view($template,$data,true);
		$data['_header']=$this->_CI->load->view('templates/header',$data,true);
		$data['_sidebar']=$this->_CI->load->view('templates/sidebar',$data,true);
		$data['_rightbar']=$this->_CI->load->view('templates/rightbar',$data,true);
		$this->_CI->load->view('/template.php',$data);
	}
}

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */