<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ItemList extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (! $this->session->userdata('user_id'))
		{
			redirect('/user/');
		}

	}

	function index()
	{
		/* TODO: redirection logic */
		redirect('/itemlist/unrated/');
	}

	function unrated()
	{

		$user_id = $this->session->userdata('user_id');

		/* TODO: move to model */
		$sql = "
		SELECT
			movie.*,
			rating.rating_value
		FROM
			movie
		LEFT JOIN
			rating
		ON
			movie.movie_id = rating.movie_id
		AND
			rating.user_id = ?
		ORDER BY
			rating_value,
			movie_name
		LIMIT
			?, ?
		";

		$query = $this->db->query($sql, array($user_id, (int) $this->uri->segment(3), 20));

		$this->load->library('table');
		$this->table->set_heading('ID', 'Name', 'URL', 'Deleted', 'Added', 'Rating');
		$data['table'] = $this->table->generate($query);

		$sql = "
		SELECT
			COUNT(*) AS total_rows
		FROM
			movie
		LEFT JOIN
			rating
		ON
			movie.movie_id = rating.movie_id
		AND
			rating.user_id = ?
		ORDER BY
			rating_value,
			movie_name
		";

		$query = $this->db->query($sql, array($user_id));

		$this->load->library('pagination');
		$config['base_url'] = site_url('/itemlist/unrated/');
		$config['total_rows'] = $query->row()->total_rows;
		$config['per_page'] = 20;
		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('header');
		$this->load->view('table', $data);
		$this->load->view('footer');

	}

}

/* EOF controllers/itemlist.php */
