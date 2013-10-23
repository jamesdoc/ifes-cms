<?php

class Language_model extends CI_Model
{

	function select_languages()
	{
		$this->db->select('lang_code, name');
		$this->db->from('lang');

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

}