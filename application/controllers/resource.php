<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resource extends MY_Controller {

	public function index()
	{
		
		$data['view'] = 'landing';
		$data['title'] = 'IFES CMS: Welcome';

		$this->load->view('container', $data);
	}

	public function edit($resource_id = null, $type = null)
	{

		if ($resource_id == null)
		{
			redirect();
		}

		if ($this->input->post())
		{
			$return = $this->_post_handler($resource_id);

			if(isset($return['image_error']))
			{
				$data['error'][] = $return['image_error'];
			}

			if(isset($return['update_alerts']))
			{
				foreach($return['update_alerts'] as $alert)
				{
					$data['error'][] = $alert;
				}
			}
		}



		$this->load->model(array('account_model','language_model','resource_model'));

		$data['view'] = 'edit_form';
		$data['title'] = 'IFES CMS: Edit';

		isset($return['lang_code']) ? $select_lang = $return['lang_code'] :  $select_lang = null;

		$data['resource'] = $this->resource_model->select_resource_for_edit($resource_id, $select_lang);
		
		if ($data['resource'] == null)
		{
			redirect();
		}
		
		if ($data['resource']->type != $type)
		{
			redirect($data['resource']->type . '/edit/' . $resource_id);
		}

		$data['resource_tags'] = $this->resource_model->select_resource_tags($resource_id);
		$data['languages'] = $this->language_model->select_languages();
		$data['post_as'] = $this->account_model->select_user_post_as($this->session->userdata('member_id'));


		$data['javascript'] = array('bootstrap-datepicker','bootstrap-tagsinput','typeahead.min');
		$data['css'] = array('datepicker','bootstrap-tagsinput');

		$this->load->helper('ckeditor');

		$this->ckConfig = array(
			'toolbar' 	=> 	array(
				array('Link','Unlink'),
				array('Bold', 'Italic','Underline', 'Strike')
				),
			'forcePasteAsPlainText ' 	=> false,
			'entities'					=> false,
			'removeFormatTags'			=> 'b,big,code,del,dfn,em,font,i,ins,kbd',
			'toolbarLocation' 			=> 'bottom',
			'width'						=> '100%',
			'height'					=> '300px',
			'removePlugins'				=> 'elementspath' 
		);
		

		switch($type)
		{
			case 'blog':
				$data['modules'] = array('content' => array('title','content','image','short_description'),'publish' => TRUE,'datetime' => array('published_dt'),'translation' => TRUE, 'additionals' => array('post_as','featured','comments'), 'tag' => TRUE);
				$this->ckConfig['toolbar'] = array(array('Link','Unlink'),array('Bold', 'Italic','Underline', 'Strike'),array('NumberedList','BulletedList','Blockquote'),array('Styles'),array('Source'));
				break;
			case 'prayer':
				$data['modules'] = array('content' => array('content'),'publish' => TRUE,'datetime' => array('week_number'),'translation' => TRUE,'additionals' => array('featured'), 'tag' => TRUE);
				$this->ckConfig['forcePasteAsPlainText'] = true;
				$this->ckConfig['height'] = '150px';
				break;
			case 'event':
				$data['modules'] = array('content' => array('title','content','link'),'publish' => TRUE,'datetime' => array('start_dt','end_dt'),'translation' => TRUE, 'tag' => TRUE);
				$this->ckConfig['forcePasteAsPlainText'] = true;
				$this->ckConfig['height'] = '150px';
				break;
		}

		// If image module required then get some recent images...
		if(array_key_exists('content', $data['modules']) && in_array('image', $data['modules']['content']))
		{
			$this->load->model('image_model');
			$data['images'] = $this->image_model->select_recent_images(10);
		}

		$data['ckeditor'] = array('id' => 'txt_body', 'path' => 'assets/js/ckeditor', 'config' => $this->ckConfig);

		$this->load->view('container', $data);
	}
	
	public function create($type = null)
	{
		
		if($type == null)
		{
			redirect();
		}
		
		$this->load->model('resource_model');
		
		$this->resource_model->insert_resource($type);
		
	}

	public function records($type = 'blog')
	{
		
		$this->load->model(array('resource_model'));

		$this->load->helper(array('text'));

		$data['view'] = 'list';
		$data['title'] = 'IFES CMS: ' . $type;
		$data['type'] = $type;


		$data['records'] = $this->resource_model->select_basics($type);

		$this->load->view('container', $data);

	}






	function _post_handler($resource_id)
	{

		// Adding in an image handled by $this->resource_model->update_resource()

		$return = array();

		// Action one: SAVE
		$this->load->model('resource_model');

		$return['update_alerts'] = $this->resource_model->update_resource($resource_id);

		$return['lang_code'] = $this->input->post('txt_lang_code');

		if ($this->input->post('btn_publish'))
		{
			$this->resource_model->update_resource_status($resource_id, '1');
		}

		if ($this->input->post('btn_confirm_resource_delete'))
		{
			$this->resource_model->delete_resource($resource_id);
			//$this->resource_model->update_resource_status($resource_id, '-1');

			redirect($this->uri->segment(1));
		}

		if ($this->input->post('btn_translation_edit'))
		{
			$return['lang_code'] = $this->input->post('btn_translation_edit');
		}

		if ($this->input->post('btn_confirm_translation_delete'))
		{
			$this->resource_model->delete_translation($resource_id, $this->input->post('btn_confirm_translation_delete'));

			unset($return['lang_code']);
		}

		if ($this->input->post('btn_add_translation'))
		{
			$this->resource_model->insert_translation($resource_id, $this->input->post('cbo_add_translation'));

			$return['lang_code'] = $this->input->post('cbo_add_translation');
		}

		if ($this->input->post('btn_upload_image'))
		{
			$this->load->model('image_model');

			$image = $this->image_model->upload_image();

			if(is_array($image))
			{
				$path = $this->config->item('upload_path') . 'originals/' . $image['file_name'];
				$this->image_model->resize_image($path);
			}
			else
			{
				$return['image_error'] = $image;
			}
		}

		return $return;

	}
	
	
	/* This should be replaced by the IFES API... but until such a thing happens please excuse this really ugly piece of legacy code */
	function tags()
	{
		
		$lang = "en";
		
		$sql = "SELECT tag_title AS name_display FROM tag_translation, tag WHERE tag.tag_id = tag_translation.tag_id AND tag.public = 1 AND tag.tag_id != 4 AND tag_title != ''";
		
		$sql.= " UNION SELECT locale_".$lang." AS name_display from locale";
		
		
		$union = $this->db->query('SELECT * FROM ('.$sql.') a ORDER BY name_display ASC'); // sql statement being executed
		
		if($union->num_rows() > 0){ //check if the sql query returned rows more then 0
			
			foreach($union->result() as $row){
				$data[] = $row->name_display;
			}
			
			echo json_encode($data);
			
		}
	}
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */