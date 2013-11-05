<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends MY_Controller
{

	public function index()
	{
		
		$this->load->model(array('search_model'));

		$data['view'] = 'search';
		$data['title'] = 'IFES CMS: Search';

		$data['query'] = $this->input->get('for');

		$data['results'] = $this->search_model->resource_search($this->input->get('for'));

		$this->load->view('container', $data);

	}

}

/* End of file comment.php */
/* Location: ./application/controllers/comment.php */