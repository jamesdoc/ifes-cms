<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		
		if($this->input->post())
		{
			$this->load->model('account_model');
			$this->account_model->check_login($this->input->post('txt_user'), $this->input->post('txt_pass'));

			// If we get this far then the login has failed
			$data['error'] = TRUE;
		}

		$data['view'] = 'login';
		$data['title'] = 'Please sign in...';

		$this->load->view('container', $data);
	}

	public function logout()
	{

		$this->session->sess_destroy();
		redirect();

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */