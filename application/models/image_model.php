<?php

class Image_model extends CI_Model {
	
	function select_recent_images($count = 5)
	{

		$images_dir = $this->config->item('upload_path');

		$images = glob($images_dir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

		if(is_array($images))
		{
			usort($images, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));

			$image_array = array_slice($images, 0, $count);

			unset($images);

			return $image_array = str_replace($images_dir, "", $image_array);
		}

	}

	
	function upload_image($path = 'originals')
	{

		// Set up upload config
		$config = array(
			'allowed_types'	=> 'jpg|jpeg|gif',
			'max_filename'	=> 20,
			'max_size'		=> 2048,
			'remove_spaces' => true
		);

		if($this->config->item('is_local') == TRUE)
		{
			$config['upload_path'] = realpath(APPPATH . '../assets/uploads/'.$path);
		}
		else
		{
			$config['upload_path'] = realpath($this->config->item('upload_path').$path);
		}
		
		// Upload image
		$this->load->library('upload', $config);

		if($this->upload->do_upload('file_image'))
		{
			return $this->upload->data();
		}
		else
		{
			return $this->upload->display_errors();
		}
		
	}
	
	function resize_image($image, $path = '', $width=620, $height=500)
	{

		$path = $this->config->item('upload_path') . $path;
		
		// Do some set up
		$config = array(
			'source_image'	=> $image,
			'new_image'		=> $path,
			'maintain_ratio'=> TRUE,
			'width'			=> $width,
			'height'		=> $height
		);
		
		$this->load->library('image_lib',$config);
		$this->image_lib->resize();

		return true;
	}
	

}