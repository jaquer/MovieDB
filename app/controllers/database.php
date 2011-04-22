<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DataBase extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (! $this->session->userdata('user_id'))
		{
			$this->session->set_flashdata('redirect', current_url());
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
		$errors = array();

		$current = $this->_get_current($errors);
		if (! $current)
			show_error('No movies found in base directory.');

		$active = $this->_get_active($errors);

		$to_insert = array_diff($current, $active);
		$to_insert = $this->_load_details($to_insert, $errors);

		$to_delete = array_diff($active, $current);
	}

	function _get_active(&$errors)
	{
		$data = array();

		$this->db->select('movie_dirname');
		$this->db->from('movie');
		$this->db->where('movie_status', 'ACTIVE');

		$query = $this->db->get();

		if ($query->num_rows() > 0)
			foreach ($query->result() as $row)
				$data[] = $row->movie_dirname;

		return $data;
	}


	function _get_current(&$errors)
	{
		/* This should go in a config variable. */
		setlocale(LC_ALL, 'en_US.UTF-8');

		$this->config->load('moviedb', TRUE);
		$this->load->helper('directory');

		$data = array();
		$errors['current'] = array();

		$base = $this->config->item('base_dir', 'moviedb');

		$map = directory_map($base, 2, TRUE);

		if (! $map)
			return FALSE;

		foreach ($map as $directory => $files)
		{
			if (! is_array($files))
				continue;

			$nfo = FALSE;
			$avi = FALSE;

			foreach ($files as $file)
			{
				$path = $base . '/' . $directory . '/' . $file;


				$ext = strrchr($file, '.');

				if ($ext !== FALSE)
					if ($ext === '.nfo')
						$nfo = $file;
					elseif ($ext === '.avi')
						$avi = $file;
			}

			if (! $nfo)
			{
				$errors['current'] = "No NFO file found for '" . $directory . "'";
				continue;
			}
			if (! $avi)
			{
				$errors['current'] = "No AVI file found for '" . $directory . "'";
				continue;
			}

			$data[] = $directory;

		}

		return $data;
	}


	function _load_details($directories, &$errors)
	{
		/* Again... this should go in a config variable. */
		setlocale(LC_ALL, 'en_US.UTF-8');

		$this->config->load('moviedb', TRUE);
		$this->load->helper('directory');

		$data = array();
		$errors['load'] = array();

		$base = $this->config->item('base_dir', 'moviedb');

		foreach ($directories as $directory)
		{
			$path = $base . '/' . $directory;

			$map = directory_map($path, 1, TRUE);

			$dirsize = 0;
			$xml = FALSE;

			foreach ($map as $filename)
			{
				/* Subdirs are ignored. */
				if (is_array($filename))
					continue;

				$path = $base . '/' . $directory . '/' . $filename;

				/* We resort to exec'ing stat because php's filesize() has issues with large files. */
				$dirsize += exec('stat --format=%s ' . escapeshellarg($path));

				$info = pathinfo($filename);

				if (array_key_exists('extension', $info))
					if ($info['extension'] === 'nfo')
						$xml = simplexml_load_file($path, 'SimpleXMLElement', LIBXML_COMPACT);
			}

			if (! $xml)
				$data['errors'][] = "Unable to load info from NFO for '" . $directory . "'";

			$movie = array();

			$movie['imdb_id']   = (string) $xml->id;
			$movie['name']      = (string) $xml->title;
			$movie['name_sort'] = (string) $xml->sorttitle;
			$movie['year']      = (string) $xml->year;
			$movie['dirname']   = $directory;
			$movie['size']      = $dirsize;

			$data[$directory] = $movie;

		}

		return $data;
	}

	function _update_or_insert($movies, &$errors)
	{
		$fields = array('name', 'name_sort', 'year', 'dirname', 'size');

		foreach ($movies as $movie)
		{
			$this->db->select('*');
			$this->db->from('movie');
			$this->db->where('movie_dirname', $movie['dirname']);

			$query = $this->db->get();

			if ($query->num_rows() > 0)
			{
				$row = $query->row_array();

				$update = FALSE;

				foreach ($fields as $field)
				{
					if ($movie[$field] !== $row['movie_' . $field])
					{
						$update = TRUE;
						$this->db->set('movie_' . $field, $movie[$field]);
					}
				}

				if ($update)
				{
					$this->db->where('id', $row['id']);
					$this->db->update('movie');
				}
			}
			else
			{
				/* INSERT */
			}
		}
	}

	function _mark_deleted($directories, &$errors)
	{
		foreach ($directories as $directory)
		{
			$this->db->set('status', 'DELETED');
			$this->db->where('movie_dirname', $directory);
			$this->db->update('movie');
		}
	}
}

/* EOF app/controllers/database.php */
