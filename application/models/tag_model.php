<?php

class Tag_model extends CI_Model {


	function insert_link_tag_resource($resource_id, $tags)
	{
		foreach ($tags as $tag)
		{
			$tag_id = $this->select_tag_id($tag, 'en');

		// If there is no tag_id, then we need to create a tag
			if ($tag_id == null){
				$tag_id = $this->insert_tag($tag, 'en');
			}

			$tag_link[] = array
			(
				'page_id' => $resource_id,
				'tag_id' => $tag_id
			);
		}

		$this->db->where('page_id', $resource_id);
		$this->db->delete('tag_link');

		$this->db->insert_batch('tag_link', $tag_link);
	}


	function insert_tag($tag, $lang_code = 'en')
	{
		$tag_translation = (object) array
		(
			'tag_url' => toUrlSlug($tag),
			'tag_title' => $tag,
			'tag_lang' => $lang_code
		);

		$tag = (object) array(
			'public' => 1
		);

		// check tag url
		while ($this->select_check_vanity_url($tag_translation->tag_url) != 0)
		{
			$tag_translation->tag_url .= random_string('nozero', 1);
		}

		$this->db->insert('tag', $tag);

		$tag_id = $this->db->insert_id();

		$tag_translation->tag_id = $tag_id;

		$this->db->insert('tag_translation', $tag_translation);

		return $tag_id;
	}


	function select_check_vanity_url($vanity)
	{
		$this->db->select('tag_url');
		$this->db->where('tag_url',$vanity);
		return $this->db->get('tag_translation')->num_rows();
	}


	function select_tag_id($tag, $lang_code='en')
	{
		$query = "
			SELECT tag_id AS tag_id
			FROM tag_translation
			WHERE tag_title = '$tag'

			UNION

			SELECT locale_code AS tag_id
			FROM locale
			WHERE locale_en = '$tag'
		";

		$query = $this->db->query($query);

		if ($query->num_rows() > 0)
		{
			return $query->row()->tag_id;
		}
	}

}