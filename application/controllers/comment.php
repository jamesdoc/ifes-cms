<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends MY_Controller
{

	public function index()
	{
		
		$this->load->model(array('comment_model'));

		$this->load->library(array('pagination'));

		$this->load->helper(array('text'));

		$data['view'] = 'comment_list';
		$data['title'] = 'IFES CMS: Moderate comments';

		$pagination_config['base_url'] = site_url('comment?');
		$pagination_config['total_rows'] = $this->comment_model->select_comment_count();
		$pagination_config['per_page'] = 20;
		$pagination_config['use_page_numbers'] = TRUE;
		$pagination_config['page_query_string'] = TRUE;
		$pagination_config['query_string_segment'] = 'page';

		$this->pagination->initialize($pagination_config);

		$page = $this->input->get('page', TRUE);

		$data['comments'] = $this->comment_model->select_basics(null, $pagination_config['per_page'], ($page-1)*$pagination_config['per_page']);

		$this->load->view('container', $data);

	}

	

	function view($comment_id = null)
	{

		if ($comment_id == null)
		{
			redirect('comment');
		}

		$this->load->model(array('comment_model'));

		if ($this->input->post('btn_confirm_comment_delete') == TRUE)
		{
			$this->comment_model->update_comment_status($comment_id, '0');
			redirect('comment');
		}

		$data['view'] = 'comment';
		$data['title'] = 'IFES CMS: Moderate comments';

		$data['comment'] = $this->comment_model->select_basics($comment_id);

		if (count($data['comment']) != 1)
		{
			redirect('comment');
		}

		$this->load->view('container', $data);

	}

}

/* End of file comment.php */
/* Location: ./application/controllers/comment.php */