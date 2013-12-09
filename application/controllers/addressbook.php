<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addressbook extends MY_Controller
{

	public function index()
	{
		
		$this->load->model(array('addressbook_model'));

		$this->load->helper(array('text'));

		$data['view'] = 'addressbook_list';
		$data['title'] = 'IFES CMS: Address Book';

		$data['addresses'] = $this->addressbook_model->select_addressbook_summary();

		$this->load->view('container', $data);
	}

	function edit($movement_id)
	{

		$this->load->model(array('addressbook_model','locale_model'));

		if($this->input->post())
		{
			$return = $this->addressbook_model->update_movement($movement_id);

			if(is_array($return))
			{
				$data['error'] = $return;
			}
		}

		

		$this->load->helper(array('text'));

		$data['view'] = 'addressbook_edit';
		$data['title'] = 'IFES CMS: Address Book';

		$data['contact'] = $this->addressbook_model->select_contact_details($movement_id);
		$data['locale_list'] = $this->locale_model->select_locale();

		$data['contact_options'] = array(
                '' => 'Please select',
                'email'  => 'Email',
                'facebook' => 'Facebook',
                'instagram' => 'Instagram',
                'telephone' => 'Telephone',
                'twitter' => 'Twitter',
                'vimeo' => 'Vimeo',
                'web' => 'Web address',
                'youtube' => 'YouTube',
                'other' => 'Other'
            );

		$this->load->view('container', $data);

	}

}

/* End of file addressbook.php */
/* Location: ./application/controllers/addressbook.php */