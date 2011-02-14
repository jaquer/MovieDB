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
		";

		$query = $this->db->query($sql, array($user_id));

		$this->load->library('table');
		$this->table->set_heading('ID', 'Name', 'URL', 'Deleted', 'Added', 'Rating');
		$data['table'] = $this->table->generate($query);

		$this->load->view('header');
		$this->load->view('table', $data);
		$this->load->view('footer');

	}

}

/* EOF controllers/itemlist.php */
