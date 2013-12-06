<?php

class Resource_model extends CI_Model
{

	/*	
	 *	
	 */
	function check_type_date_conflict($date, $type = null, $resource_id = null)
	{
		if ($type != null)
		{
			$this->db->where('type', $type);
		}

		if ($resource_id != null)
		{
			$this->db->where('resource_id !=', $resource_id);
		}

		$this->db->where('published_dt', $date);

		return $this->db->count_all_results('resource');
	}

	/*
	 *	Used to create a unique vanity URL for resources
	 *	Takes in resource title and will spit out a unique-vanity-url
	 */
	function create_vanity_url($title, $resource_translation_id = null)
	{

		$vanity_url = toUrlSlug($title, array('limit'=>50,'transliterate'=>true));

		$i = 0;

		while($this->select_vanity_url_count($vanity_url, $resource_translation_id) != 0)
		{
			if($i == 0)
			{
				$vanity_url .= '-u';
			}

			$vanity_url .= random_string('nozero', 1);

			$i++;
		}

		return $vanity_url;

	}

	/*
	 * Deletes a whole resource and related translations and files
	 * Use with caution
	 */
	function delete_resource($resource_id)
	{	
		$this->db->where('resource_id', $resource_id);
		$this->db->delete('resource');

		$this->db->where('resource_id', $resource_id);
		$this->db->delete('resource_translation');

		$this->db->where('resource_id', $resource_id);
		$this->db->delete('resource_file');
	}

	/*
	 * Deletes a specific translation within a resource
	 * If it is the last translation in the resource, it deletes the resource as well
	 */
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
	
	/*
	 * Inserts an empty resource ready for editing
	 * Auto assigns a type
	 */
	function insert_resource($type)
	{
		
		// Create basic resource fields

		$this->db->set('member_id', $this->session->userdata('member_id'));
		$this->db->set('type', $type);
		$this->db->set('published_dt', date('Y-m-d H:i:s'));
		$this->db->set('status', 0);
		$this->db->set('discussion', 1);
		$this->db->set('featured', 1);
		
		if($type == 'prayer')
		{
			$this->db->set('featured', 1);
		}

		$this->db->insert('resource'); 
		
		$resource_id = $this->db->insert_id();

		// Set up new resource with a new translation

		// If it is a profile then we are going to give it a name from the get go.
		if ($type == 'profile')
		{
			$this->load->model('locale_model');
			$locale = $this->locale_model->select_locale($this->input->post('cbo_locale'));
			$this->db->set('title', $locale[0]->locale_name);
		}
		
		$this->db->set('resource_id',$resource_id);
		$this->db->set('lang_code','en');
		$this->db->set('status', 0);
		$this->db->set('datetime', date('Y-m-d H:i:s'));
		
		$this->db->insert('resource_translation');

		// If it is a profile then we need to tag it up with the correct locale code
		if ($type == 'profile')
		{
			$this->db->set('page_id', $resource_id);
			$this->db->set('tag_id', $this->input->post('cbo_locale'));
			$this->db->insert('tag_link');
		}
		
		// And away we go to the edit form...
		redirect($type . '/edit/' . $resource_id);
		
	}
	
	/*
	 * Add in a new translation for a resource
	 */
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

	/*
	 * Get a summary of resources by type
	 * Selects ID, title, body, status, published_dt, type and author
	 * Mostly used for the resource lists
	 */
	function select_basics($type, $limit = 20, $offset = 0, $drafts = FALSE)
	{

		if ($offset < 0)
		{
			$offset = 0;
		}

		$this->db->select('resource.resource_id, IFNULL(MAX(IF (lang_code = "en" AND resource_translation.status = "1", title, NULL)),title) AS title, IFNULL(MAX(IF (lang_code = "en" AND resource_translation.status = "1", body, NULL)),body) AS body, resource.status, published_dt, type, knownas',false);

		$this->db->from('resource');
		$this->db->join('resource_translation','resource.resource_id = resource_translation.resource_id');
		$this->db->join('individual','resource.member_id = individual.member_id');

		$this->db->group_by('resource.resource_id');

		$this->db->where('type',$type);

		if ($drafts == FALSE)
		{
			$this->db->where('resource.status >',0);
		}

		$this->db->order_by('published_dt', 'DESC');

		$this->db->limit($limit, $offset);

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

	/*
	 * Get total number of resources with type filter
	 * Handy for pagination
	 */
	function select_resource_count($type = null)
	{

		if ($type != null)
		{
			$this->db->where('type', $type);
		}

		return $this->db->count_all_results('resource');

	}

	/*
	 * Get all details of resource and translation for handy dandy editing
	 */
	function select_resource_for_edit($resource_id, $lang_code = null)
	{

		$this->db->select('resource.resource_id, resource.member_id, resource.type, resource.status, resource.discussion, resource.published_dt, resource.end_dt, resource.featured, resource_translation.resource_translation_id, resource_translation.lang_code, resource_translation.title, resource_translation.body, resource_translation.link, resource_translation.desc_short, resource_translation.vanity_url, resource_translation.status AS translation_status');

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

	/*
	 * Returns a list of tags assocated with a resource
	 */
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

	/*
	 * Check if a vanity_url exists within the database
	 */
	function select_vanity_url_count($vanity_url, $resource_translation_id = null)
	{
		if ($resource_translation_id != null)
		{
			$this->db->where('resource_translation_id !=', $resource_translation_id);
		}

		$this->db->where('vanity_url', $vanity_url);
		return $this->db->count_all_results('resource_translation');
	}

	/*
	 * Save changes to resource
	 */
	function update_resource($resource_id)
	{

		// Select a bit of data to do some comparison
		$current = $this->select_resource_for_edit($resource_id, $this->input->post('txt_lang_code'));

		if ($this->input->post('publish_date'))
		{
			$resource['published_dt'] = date('Y-m-d', strtotime($this->input->post('publish_date')));

			if($this->input->post('publish_time'))
			{
				$resource['published_dt'] = date('Y-m-d H:i:s', strtotime($resource['published_dt'] . ' ' . $this->input->post('publish_time')));
			}
		}

		if ($this->input->post('start_date'))
		{

			$resource['published_dt'] = date('Y-m-d', strtotime($this->input->post('start_date')));

			if($this->input->post('end_date') == "")
			{
				$resource['end_dt'] = $resource['published_dt'];
			}
			else if (strtotime($this->input->post('end_date')) < strtotime($resource['published_dt']))
			{
				$resource['end_dt'] = $resource['published_dt'];
			}
			else
			{
				$resource['end_dt'] = date('Y-m-d', strtotime($this->input->post('end_date')));
			}
		}

		if ($this->input->post('week_begin'))
		{

			$input = date('Y-m-d', strtotime($this->input->post('week_begin')));
			$wb = date('Y-m-d', strtotime( ('Monday' == date('l', strtotime($input)) ? 'Monday this week' : 'Last Monday'), strtotime($input)));
			
			if ($current->type == 'prayer' && $current->featured == 1)
			{
				if($this->check_type_date_conflict($wb, $current->type, $current->resource_id) == 0)
				{
					$resource['published_dt'] = $wb;
				}
				else
				{
					$resource['published_dt'] = null;
					$error[] = 'Record already exists in database for this date';
				}

			}

		}

		if ($this->input->post('cbo_post_as'))
		{
			$resource['member_id'] = $this->input->post('cbo_post_as');
		}
		else
		{
			$resource['member_id'] = $this->session->userdata('member_id');
		}

		if ($this->input->post('chk_discussion'))
		{
			$resource['discussion'] = 1;
		}
		else
		{
			$resource['discussion'] = 0;
		}

		if ($this->input->post('chk_featured'))
		{
			$resource['featured'] = 1;
		}
		else
		{
			$resource['featured'] = 0;
		}

		$resource['edited_dt'] = date('Y-m-d H:i:s');

		$this->db->where('resource_id', $resource_id);
		$this->db->update('resource', $resource);

		//------

		$translation = array
		(
			'title'			=> strip_tags(trim($this->input->post('txt_title'))),
			'body'			=> $this->input->post('txt_body'),
			'desc_short'	=> strip_tags(trim($this->input->post('txt_short_description'))),
			'status'		=> 1
		);

		// See: http://semlabs.co.uk/journal/php-strip-attributes-class-for-xml-and-html
		$this->load->library('stripattributes');
		$sa = new stripattributes();
		$sa->allow = array( 'id', 'class');
		$sa->exceptions = array( 
			'img' => array( 'src', 'alt' ),
			'a' => array( 'href', 'title', 'target' )
		);

		$translation['body'] = $sa->strip( $translation['body'] );

		if($translation['title'] == ""){$translation['title'] = null;}

		if($this->input->post('btn_insert_image'))
		{
			$translation['body'] = '<p><img alt="" class="pull img-centre" src="' . $this->input->post('btn_insert_image') . '" /></p>' . $translation['body'];
		}

		// Set vanity_url
		if ($translation['title'] != null AND ($current->status != 1 OR $current->vanity_url == '' OR $current->translation_status != 1))
		{
			$translation['vanity_url'] = $this->create_vanity_url($translation['title'], $current->resource_translation_id);
		}

		// If the resource is not media related then we can expect just one link field... otherwise it gets a bit complicated...
		if($current->type != 'audio' && $current->type != 'video'){
			$translation['link'] = prep_url(trim($this->input->post('txt_link')));
		}
		else
		{

			
			$i = 0; $json = array();
			foreach($this->input->post('txt_link') as $link)
			{
				$link = trim($link);

				if($link != null)
				{

					$url = parse_url(trim($link), PHP_URL_PATH);
					$url = explode('/', $link);
					$url = end($url);

					$json[$i]['resource_path'] 		= $link;
					$json[$i]['resource_filetype'] 	= substr( $url, strrpos( $url, '.' )+1 );
					$json[$i]['resource_filename'] 	= substr($url,0,-4);

					// Do some more work if video link around to extract thumbnail
					if ($current->type == 'video' && array_strpos($link, array('youtube','vimeo')) !== false)
					{
						$translation['thumbnail'] = get_video_thumbnail($link);
					}

					$i++;

				}
			}
			
			$translation['link'] = json_encode($json);

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

		if(isset($error))
		{
			return $error;
		}
		

	}

	/*
	 * Changes the status code of a resource
	 * Useful for 'deleting' or publishing a resource
	 */
	function update_resource_status($resource_id, $status_code)
	{
		$this->db->set('status', $status_code);
		$this->db->where('resource_id', $resource_id);
		$this->db->update('resource');
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
