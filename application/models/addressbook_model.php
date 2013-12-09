<?php

class Addressbook_model extends CI_Model {

	function select_addressbook_summary(){

		$this->db->select('movement_id, name_short, contact_person, role_en AS role, locale_en AS locale, locale_root');
		$this->db->from('movement');
		$this->db->join('movement_role', 'movement.contact_person_role_id = movement_role.movement_role_id','left');
		$this->db->join('locale','locale.locale_code = movement.locale_code');
		$this->db->order_by('locale_root, locale_en');

		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			foreach ($query->result() as $row){ $data[] = $row;}
			return $data;
		}

	}

	function select_contact_details($movement_id) {

		$this->db->select('movement.movement_id, movement.locale_code, movement.contact_person, movement_role.role_en as "role", movement.name_short, movement.name_full, locale.locale_en AS locale_name, movement.office_locale_code');
		$this->db->from('movement');
		$this->db->join('movement_role', 'movement.contact_person_role_id = movement_role.movement_role_id','left');
		$this->db->join('locale', 'movement.office_locale_code = locale.locale_code','left');
		
		$this->db->where('movement.movement_id',$movement_id);

		$query = $this->db->get();

		if($query->num_rows() > 0){

			$data = $query->row();
			$data->contactDetails = $this->select_movementContactDetails($data->movement_id);

			return $data;
		}

	}


	function select_movementContactDetails($movement_id = null){

		if ($movement_id == null) { return; }

		$this->db->select('movement_contact_details.type, movement_contact_details.detail');
		$this->db->from('movement_contact_details');
		$this->db->where('movement_contact_details.movement_id',$movement_id);
		$this->db->order_by('type');

		$query = $this->db->get();

		if($query->num_rows() > 0){
			foreach ($query->result() as $row){
				$data[$row->type] = $row->detail;
			}

			return $data;
		}

	}

	function update_movement($movement_id)
	{

		$basics = array(
			'movement_id'			=> $movement_id,
			'locale_code'			=> trim($this->input->post('country_region')),
			'name_short'			=> trim($this->input->post('name_short')),
			'name_full'				=> trim($this->input->post('name_full')),
			'contact_person'		=> trim($this->input->post('contact_person')),
			'contact_person_role_id'=> trim($this->input->post('contact_person_role')),
			'office_locale_code'	=> trim($this->input->post('office_locale'))
			);

		$i = 0;
		$types = $this->input->post('contactDetailType');
		foreach ($this->input->post('contactDetail') as $detail) {

			if($detail != '')
			{
				$contactDetails[] = array (
					'movement_id'	=> $movement_id,
					'type'			=> $types[$i],
					'detail'		=> $detail
				);
			}

			$i++;

		}

		$contactDetails = $this->validateContactDetails($contactDetails);
		
		if (is_array($contactDetails['error']))
		{
			return $error[] = $contactDetails['error'];
		}
		else
		{
			$this->db->where('movement_id', $basics['movement_id']);
			$this->db->update('movement', $basics);

			$this->db->where('movement_id', $basics['movement_id']);
			$this->db->delete('movement_contact_details');

			$this->db->insert_batch('movement_contact_details', $contactDetails['details']);
		}

	}




	function validateContactDetails($details){
		
		$error = null;
		$type = array();

		foreach ($details as $key => $detail) {

			// If type of data already exists unset and skip over
			if (in_array($detail['type'],$type)) {
				unset($details[$key]);
				continue;
			} else {
				$type[] = $detail['type'];
			}


			$detail['detail'] = trim($detail['detail']);

			// If detail is empty then skip over it.
			if($detail['detail'] == ''){
				unset($details[$key]);
				continue;
			}

			switch($detail['type']){

				case('web'):
				case('twitter'):
				case('facebook'):
				case('instagram'):
				case('youtube'):
				case('vimeo'):
					
					$detail['detail'] = str_replace('http://','',$detail['detail']);

					if($detail['type'] == 'web'){

						if(!filter_var(prep_url($detail['detail']), FILTER_VALIDATE_URL)){
							$error[] = 'url';
							unset($details[$key]);
						}

					}

					if($detail['type'] == 'twitter'){

						$details[$key]['detail'] = $detail['detail'] = str_replace('@','twitter.com/',$detail['detail']);

						if(strpos($detail['detail'], 'twitter.com') === false) {
							$details[$key]['detail'] = $detail['detail'] = 'twitter.com/' . $detail['detail'];
						}

						if(!filter_var(prep_url($detail['detail']), FILTER_VALIDATE_URL)){
							$error[] = 'twitter';
							unset($details[$key]);
						}
						
					}

					if($detail['type'] == 'vimeo'){

						$details[$key]['detail'] = $detail['detail'] = str_replace('@','vimeo.com/',$detail['detail']);

						if(strpos($detail['detail'], 'vimeo.com') === false) {
							$details[$key]['detail'] = $detail['detail'] = 'vimeo.com/' . $detail['detail'];
						}

						if(!filter_var(prep_url($detail['detail']), FILTER_VALIDATE_URL)){
							$error[] = 'vimeo';
							unset($details[$key]);
						}
						
					}

					if($detail['type'] == 'youtube'){

						$details[$key]['detail'] = $detail['detail'] = str_replace('@','youtube.com/',$detail['detail']);

						if(strpos($detail['detail'], 'youtube.com') === false) {
							$details[$key]['detail'] = $detail['detail'] = 'youtube.com/' . $detail['detail'];
						}

						if(!filter_var(prep_url($detail['detail']), FILTER_VALIDATE_URL)){
							$error[] = 'youtube';
							unset($details[$key]);
						}
						
					}

					if($detail['type'] == 'facebook'){

						if(strpos($detail['detail'], 'facebook.com') === false) {
							$details[$key]['detail'] = $detail['detail'] = 'facebook.com/' . $detail['detail'];
						}

						if(!filter_var(prep_url($detail['detail']), FILTER_VALIDATE_URL)){
							$error[] = 'twitter';
							unset($details[$key]);
						}
						
					}

					if($detail['type'] == 'instagram'){

						if(strpos($detail['detail'], 'instagram.com') === false) {
							$details[$key]['detail'] = $detail['detail'] = 'instagram.com/' . $detail['detail'];
						}

						if(!filter_var(prep_url($detail['detail']), FILTER_VALIDATE_URL)){
							$error[] = 'instagram';
							unset($details[$key]);
						}
						
					}

				break;

				case('email'):
					
					if($detail['detail'] != '' && !filter_var($detail['detail'], FILTER_VALIDATE_EMAIL)){
						$error[] = 'email';
						unset($details[$key]);
					}

				break;

			}

		}

		return(array('details'=>$details,'error'=>$error));

	}

}