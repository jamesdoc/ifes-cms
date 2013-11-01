<?php

class Comment_model extends CI_Model
{

	function select_basics($comment_id = null, $limit = 20, $offset = 0)
	{

		if ($offset < 0)
		{
			$offset = 0;
		}

		$this->db->select('comment_id, resource_comment.resource_id, comment_name, comment_content, comment_email, md5(comment_email) AS gravatar, comment_status, IFNULL(MAX(IF (lang_code = "en" AND resource_translation.status = "1", title, NULL)),title) AS resource_title', false);

		$this->db->from('resource_comment');

		$this->db->join('resource_translation','resource_comment.resource_id = resource_translation.resource_id');

		$this->db->where('comment_status >=', 1);

		if($comment_id != null)
		{
			$this->db->where('comment_id', $comment_id);
		}

		$this->db->group_by('comment_id');

		$this->db->order_by('comment_datetime', 'DESC');

		$this->db->limit($limit, $offset);

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


	function select_comment_count()
	{

		$this->db->where('comment_status >=', 1);

		return $this->db->count_all_results('resource_comment');
	}


	function update_comment_status($comment_id, $status = '1')
	{
		$this->db->set('comment_status', $status);
		$this->db->where('comment_id', $comment_id);
		$this->db->update('resource_comment');
	}
}
