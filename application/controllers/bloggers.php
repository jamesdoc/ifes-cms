<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bloggers extends MY_Controller
{

	public function index()
	{
		
		$this->load->model(array('blogger_model'));

		$this->load->helper(array('text'));

		$data['view'] = 'bloggers_list';
		$data['title'] = 'IFES CMS: Update blogger details';

		$data['bloggers'] = $this->blogger_model->select_blogger(null);

		$this->load->view('container', $data);

	}

	

	function view($member_id = null)
	{

		if ($member_id == null)
		{
			redirect('bloggers');
		}

		$this->load->model(array('blogger_model','locale_model'));

		if($this->input->post())
		{
			$this->_input_handler($member_id);
		}
		
		$data['view'] = 'blogger';
		$data['title'] = 'IFES CMS: Update blogger details';

		$data['locale_list'] = $this->locale_model->select_locale(null, 'country');

		$data['blogger'] = $this->blogger_model->select_blogger($member_id);

		if($data['blogger'] == null) { redirect('bloggers'); }

		$data['blogger'] = $data['blogger'][0];
		
		$this->load->view('container', $data);
		

	}

	function _input_handler($member_id){



		if($this->input->post('txt_knownas') != null)
		{
			$this->blogger_model->update_blogger($member_id);
		}

		if($this->input->post('btn_confirm_blogger_removal'))
		{
			$this->blogger_model->remove_blogger($member_id);
		}

	}

}

/* End of file bloggers.php */
/* Location: ./application/controllers/comment.php */