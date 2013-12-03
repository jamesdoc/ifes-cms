<?php

class Locale_model extends CI_Model
{

	function select_locale($locale_code = null, $type = null)
	{
		$this->db->select('locale_code, concat("r", locale_root) AS locale_root, locale_en AS locale_name',false);
		$this->db->from('locale');

		if($locale_code != null)
		{
			$this->db->where('locale_code', $locale_code);
		}

		if($type == 'region')
		{
			$this->db->like('locale_code', 'r', 'after'); 
		}
		else if ($type == 'country')
		{
			$this->db->like('locale_code', 'c', 'after'); 
		}

		$this->db->order_by('locale_en');

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

	function select_missing_profile_locales()
	{
		$query = "
			SELECT locale.locale_code, locale.locale_en as locale_name, IF(region.locale_en IS NOT NULL, region.locale_en, 'Region') as region_name
			FROM locale
			LEFT JOIN locale as region ON CONCAT('r', locale.locale_root) = region.locale_code
			WHERE locale.locale_code NOT IN (
				SELECT locale.locale_code
				FROM resource
				JOIN tag_link on resource.resource_id = tag_link.page_id
				JOIN locale on tag_link.tag_id = locale.locale_code
				WHERE resource.type = 'profile'
			)
			AND ( locale.locale_root IS NOT NULL 
				OR locale.locale_code LIKE 'r%')
			ORDER BY locale.locale_root, locale.locale_en
		";

		$query = $this->db->query($query);

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