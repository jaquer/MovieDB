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

		$this->db->select('movie.*, rating.rating_value');
		$this->db->from('movie');
		$this->db->join('rating', 'movie.movie_id = rating.movie_id AND rating.user_id = ' . $this->db->escape($user_id), 'left');
		$this->db->where('rating_value IS NULL');
		$this->db->order_by('movie_name');

		$query = $this->db->get();

		$this->load->library('table');
		$this->table->set_template(array('table_open' => '<table id="item-table">'));
		$this->table->set_heading('ID', 'Name', 'URL', 'Deleted', 'Added', 'Rating');
		$data['table'] = $this->table->generate($query);

		$this->load->view('header');
		$this->load->view('table', $data);
		$this->load->view('footer');

	}

}

/* EOF controllers/itemlist.php */
