<?php

class Resource_model extends CI_Model
{	

	function delete_translation($resource_id, $lang_code)
	{

		$this->db->where('resource_id', $resource_id);
		$this->db->where('lang_code', $lang_code);

		$this->db->delete('resource_translation');
		
		// Check if we have just deleted the last translation in the resource...
		$this->db->where('resource_id', $resource_id);
		if ($this->db->count_all_results('resource_translation') == 0)
		{
			$this->db->where('resource_id', $resource_id);
			$this->db->delete('resource');
		}
		
	}
	
	function insert_resource($type)
	{
		
		$this->db->set('member_id', $this->session->userdata('member_id'));
		$this->db->set('type', $type);
		$this->db->set('published_dt', date('Y-m-d H:i:s'));
		$this->db->set('status', 0);
		
		$this->db->insert('resource'); 
		
		$resource_id = $this->db->insert_id();
		
		$this->db->set('resource_id',$resource_id);
		$this->db->set('lang_code','en');
		$this->db->set('status', 0);
		$this->db->set('datetime', date('Y-m-d H:i:s'));
		
		$this->db->insert('resource_translation'); 
		
		redirect($type . '/edit/' . $resource_id);
		
	}
	
	function insert_translation($resource_id, $lang_code)
	{

		// Check if exists
		$this->db->where('resource_id', $resource_id);
		$this->db->where('lang_code', $lang_code);
		$i = $this->db->count_all_results('resource_translation');

		// Translation exists return and exit
		if ($i != 0)
		{
			return;
		}

		$this->db->set('resource_id', $resource_id);
		$this->db->set('lang_code', $lang_code);
		$this->db->set('status', 0);

		$this->db->insert('resource_translation'); 

	}


	function select_basics($type)
	{
		$this->db->select('resource.resource_id, IFNULL(MAX(IF (lang_code = "en" AND resource_translation.status = "1", title, NULL)),title) AS title, IFNULL(MAX(IF (lang_code = "en" AND resource_translation.status = "1", body, NULL)),body) AS body, resource.status, datetime, type, knownas',false);

		$this->db->from('resource');
		$this->db->join('resource_translation','resource.resource_id = resource_translation.resource_id');
		$this->db->join('individual','resource.member_id = individual.member_id');

		$this->db->group_by('resource.resource_id');

		$this->db->where('type',$type);

		$this->db->order_by('published_dt', 'DESC');

		$this->db->limit(20);

		$query = $this->db->get();

		if($query->num_rows()>0)
		{
			
			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}

			return $data;
		}
	}

	function select_resource_for_edit($resource_id, $lang_code = null)
	{

		$this->db->select('resource.resource_id, resource.member_id, resource.type, resource.status, resource.discussion, resource.published_dt, resource.end_dt, resource_translation.resource_translation_id, resource_translation.lang_code, resource_translation.title, resource_translation.body, resource_translation.link, resource_translation.desc_long, resource_translation.desc_short, resource_translation.vanity_url');

		$this->db->select("(SELECT GROUP_CONCAT(lang_code) translations FROM resource_translation WHERE resource_id = $resource_id) AS translations", false);

		$this->qs_resource_from();

		$this->db->where('resource.resource_id', $resource_id);
		
		if ($lang_code != null)
		{
			$this->db->where('lang_code', $lang_code);
		}

		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->row();
		}

	}

	function select_resource_tags($resource_id, $lang_code = 'en')
	{
		
		$query = "
			SELECT * FROM (
				SELECT 
					locale_code AS tag_id,
					locale_".$lang_code." AS tag_name,
					IF (SUBSTRING(tag_id,-3,1) = 'r', CONCAT('region/',SUBSTRING(tag_id,-2)), CONCAT('country/',SUBSTRING(tag_id,-2))) AS tag_url
				FROM tag_link
				JOIN locale ON tag_link.tag_id = locale.locale_code
				WHERE page_id = '".$resource_id."'

				UNION

				SELECT
					tag.tag_id,
					IFNULL(MAX(IF (tag_lang = '".$lang_code."', tag_title, NULL)),tag_title) AS tag_name,
					CONCAT('tags/',IFNULL(MAX(IF (tag_lang = 'en', tag_url, NULL)),tag_url)) AS tag_url
				FROM tag_link
				JOIN tag_translation ON tag_translation.tag_id = tag_link.tag_id
				JOIN tag ON tag.tag_id = tag_link.tag_id
				WHERE page_id = '".$resource_id."' AND public = 1
				GROUP BY tag_link.tag_id
				
			)a ORDER BY tag_name ASC
		";
		
		$query = $this->db->query($query);
		
		if ($query->num_rows() > 0)
		{

			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}

			return $data;

		}
	}




	function update_resource($resource_id)
	{

		
		if($this->input->post('publish_date'))
		{
			$resource['published_dt'] = date('Y-m-d', strtotime($this->input->post('publish_date')));

			if($this->input->post('publish_time'))
			{
				$resource['published_dt'] = date('Y-m-d H:i:s', strtotime($resource['published_dt'] . ' ' . $this->input->post('publish_time')));
			}
			
		}

		$resource['member_id'] = $this->input->post('cbo_post_as');

		$this->db->where('resource_id', $resource_id);
		$this->db->update('resource', $resource);

		//------

		$translation = array
		(
			'title'			=> $this->input->post('txt_title'),
			'body'			=> $this->input->post('txt_body'),
			'link'			=> $this->input->post('txt_link'),
			'desc_short'	=> $this->input->post('txt_short_description'),
			'status'		=> 1
		);

		if ($translation['title'] == '')
		{
			$translation['title'] = 'untitled';
		}

		$this->db->where('resource_id', $resource_id);
		$this->db->where('lang_code', $this->input->post('txt_lang_code'));

		$this->db->update('resource_translation', $translation);

		//------

		
		if ($this->input->post('txt_tags') && $this->input->post('txt_tags') != "")
		{
			
			$this->load->model('tag_model');

			$tags = explode(',', $this->input->post('txt_tags'));
			$this->tag_model->insert_link_tag_resource($resource_id, $tags);
		}
		

	}





	// /*
	//  * Query Snippets
	//  */

	function qs_resource_field_translation($lang_code = 'en', $field, $return_name = null)
	{

		if ($return_name == NULL)
		{
			$return_name = $field;
		}

		$this->db->select("IFNULL(MAX(IF (lang_code = '" . mysql_real_escape_string($lang_code) . "' AND resource_translation.status = '1', $field, NULL)), $field) AS $return_name", FALSE);

	}

	function qs_resource_from()
	{
		$this->db->from('resource');
		$this->db->join('resource_translation', 'resource.resource_id = resource_translation.resource_id');
	}

	function qs_resource_standard_where($type = '*')
	{
		$this->db->where('resource.status', '1');
		$this->db->where('resource_translation.status', '1');
		$this->db->where('type', 'event');
	}
	
	function qs_run_query()
	{
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			
			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}

			return $data;
		}
	}
	
}
