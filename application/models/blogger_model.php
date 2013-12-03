<?php

class Blogger_model extends CI_Model
{

	function select_blogger($member_id = null)
	{

		$query = "
			SELECT `individual`.`member_id`, `username`, `knownas`, `email_primary`, MD5(email_primary) AS gravatar, `bio`, `individual`.`locale_code`
			FROM (`individual`)
			JOIN `individual_login` ON `individual`.`member_id` = `individual_login`.`member_id`
			JOIN `member_contact_details` ON `individual`.`member_id` = `member_contact_details`.`member_id`
			JOIN `tag_link` ON CONCAT('u',individual.member_id) = tag_link.page_id
			WHERE `tag_id` = 'aBLOG'
		";


		if($member_id != null)
		{
			$query .= "AND individual.member_id = '" . $member_id . "'";
		}

		$query .= "ORDER BY knownas";

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


	function update_blogger($member_id)
	{

		$individual['knownas'] = trim($this->input->post('txt_knownas'));
		$individual['locale_code'] = $this->input->post('cbo_locale');
		$individual['bio'] = trim($this->input->post('txt_bio'));

		$this->db->where('member_id', $member_id);
		$this->db->update('individual', $individual);

		$member_contact_details['locale_code'] = $this->input->post('cbo_locale');

		$this->db->where('member_id', $member_id);
		$this->db->update('member_contact_details', $member_contact_details);
	}


	function remove_blogger($member_id)
	{
		$this->db->where('page_id','u'.$member_id);
		$this->db->where('tag_id','aBLOG');

		$this->db->delete('tag_link');
	}

}
