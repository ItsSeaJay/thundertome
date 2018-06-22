<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('load_assets'))
{
	// Loads in all of the assets needed by a particular class
	// based on the contents of an associative array
	function load_assets($assets = array())
	{
		$CI = &get_instance();

		foreach ($assets as $type => $list)
		{
			switch ($type)
			{
				case 'configs':
					foreach ($list as $asset)
					{
						$CI->load->config($asset);
					}
					break;
				case 'helpers':
					foreach ($list as $asset)
					{
						$CI->load->helper($asset);
					}
					break;
				case 'languages':
					foreach ($list as $asset)
					{
						$CI->load->language($asset);
					}
					break;
				case 'libraries':
					foreach ($list as $asset)
					{
						$CI->load->library($asset);
					}
					break;
				case 'models':
					foreach ($list as $asset)
					{
						$CI->load->model($asset);
					}
					break;
			}
		}
	}
}
