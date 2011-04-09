<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DataBase extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (! $this->session->userdata('user_id'))
		{
			$this->session->set_userdata('redirect', current_url());
			redirect('/user/');
		}
	}

	function index()
	{
		/* TODO: redirection logic */
		redirect('/database/update/');
	}

	function update()
	{
		$this->config->load('moviedb', TRUE);
		$this->load->helper('directory');

		$data = array();
		$data['movies'] = array();
		$data['errors'] = array();

		$base = $this->config->item('base_dir', 'moviedb');

		$map = directory_map($base, 2, TRUE);

		foreach ($map as $directory => $files)
		{
			if (! is_array($files))
				continue;

			$dirsize = 0;
			$xml = FALSE;
			$avi = FALSE;

			foreach ($files as $file)
			{
				$path = $base . '/' . $directory . '/' . $file;

				/* We resort to exec'ing stat because php's filesize() has issues with large files. */
				$dirsize += exec('stat --format=%s ' . escapeshellarg($path));

				$info = pathinfo($file);

				if (array_key_exists('extension', $info))
					if ($info['extension'] === 'nfo')
						$xml = simplexml_load_file($path, 'SimpleXMLElement', LIBXML_COMPACT);
					elseif ($info['extension'] === 'avi')
						$avi = TRUE;
			}

			if (! $xml)
			{
				$data['errors'][] = "Malformed NFO file for '" . $directory . "'";
				continue;
			}
			elseif (! $avi)
			{
				$data['errors'][] = "No AVI file found for '" . $directory . "'";
				continue;
			}

			$movie = array();

			$movie['imdb_id']   = (string) $xml->id;
			$movie['name']      = (string) $xml->title;
			$movie['name_sort'] = $directory;
			$movie['year']      = (string) $xml->year;
			$movie['size']      = $dirsize;

			$data['movies'][] = $movie;

		}

	}

}

/* EOF app/controllers/database.php */
