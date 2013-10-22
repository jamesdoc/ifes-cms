<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resource extends MY_Controller {

	public function index()
	{
		
		$data['view'] = 'landing';
		$data['title'] = 'IFES CMS: Welcome';

		$this->load->view('container', $data);
	}

	public function edit()
	{

		$data['view'] = 'edit_form';
		$data['title'] = 'IFES CMS: Edit';
		
		$data['javascript'] = array('bootstrap-datetimepicker.min');
		$data['css'] = array('bootstrap-datetimepicker.min');

		$this->load->view('container', $data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */