<?php

class Account_model extends CI_Model
{
		
	function check_login($username, $password)
	{
		
		$this->db->select('individual.member_id, username, password, email_primary, knownas');

		$this->db->from('individual_login');
		$this->db->join('individual', 'individual_login.member_id = individual.member_id');
		$this->db->join('member_contact_details', 'individual_login.member_id = member_contact_details.member_id');
		
		if(strstr($this->input->post('username'),'@'))
		{
			$this->db->where('email_primary', $username);
		}
		else
		{
			$this->db->where('username', $username);
		}

		$query = $this->db->get();

		// If num_rows != 1 then bad username
		if($query->num_rows() != 1)
		{
			return false;
		}

		$auth = $query->row();

		// If  hash doesn't match password field then bad password
		if (hash('sha256',$auth->username . $password) != $auth->password)
		{
			return false;
		}

		$data = array
		(
			'logged_in'	=> '1',
			'username'	=> $auth->username,
			'knownas'	=> $auth->knownas,
			'member_id'	=> $auth->member_id,
			'gravatar'	=> md5($auth->email_primary)
		);

		$this->session->set_userdata($data);

		redirect();
		
	}
	
}
