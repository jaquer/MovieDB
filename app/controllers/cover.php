<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cover extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (! $this->session->userdata('user_id'))
			return;
	}

	function index()
	{
		redirect('/');
	}

	function show()
	{
		$movie_id = $this->uri->segment(3);

		if (! $movie_id)
			redirect('/');

		$this->config->load('moviedb', TRUE);

		$this->db->select('movie_dirname');
		$this->db->from('movie');
		$this->db->where('id', $movie_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			$row = $query->row();

			$dirname = $row->movie_dirname;

			$this->db->select('cover_filename');
			$this->db->from('cover');
			$this->db->where('movie_id', $movie_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0)
			{
				$row = $query->row();

				$base = $this->config->item('base_dir', 'moviedb');

				$path = $base . '/' . $dirname . $row->cover_filename;

				if (! $this->stream(urlencode($path)))
				{
					$this->db->select('cover_image');
					$this->db->from('cover');
					$this->db->where('movie_id', $movie_id);

					$data = $this->db->get()->row()->cover_image;

					$this->_display_binary($data);
					return;
				}
			}
			else
			{
				$default_cover = $this->config->item('default_cover', 'moviedb');

				$path = realpath($default_cover);

				if ($path === FALSE)
					show_error('Unable to find default cover image');
				elseif ($this->stream(urlencode($path)) === FALSE)
					show_error('Unable to read default cover image');
			}
		}
		else
		{
			show_error('Invalid Movie ID');
		}
	}

	function stream($encoded_path)
	{
		$this->load->helper('file');

		$data = read_file(urldecode($encoded_path));

		if (! $data)
			return false;
		else
			$this->_display_binary($data);
	}

	function _display_binary($data)
	{
		$this->output->set_content_type('png');
		$this->output->append_output($data);
	}


}

/* EOF app/controllers/cover.php */
