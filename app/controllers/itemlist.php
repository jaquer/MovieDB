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

	function delete()
	{

		$user_count = $this->db->count_all('user');

		$this->db->select('movie.*, (SELECT COUNT(*) FROM rating WHERE rating.movie_id = movie.movie_id) AS rating_count, ROUND(AVG(rating_value), 1) AS rating_average', FALSE);
		$this->db->from('movie');
		$this->db->join('rating', 'movie.movie_id = rating.movie_id', 'left');
		$this->db->where('rating_value >', 0);
		$this->db->where('movie_status IS NULL');
		$this->db->group_by('movie_id');
		$this->db->having('rating_count', $user_count);
		$this->db->having('rating_average <', 3);
		$this->db->order_by('rating_average');
		$this->db->order_by('movie_name');

		$query = $this->db->get();

		$this->load->library('table');
		$this->table->set_template(array('table_open' => '<table id="item-table">'));
		$this->table->set_heading('ID', 'Name', 'URL', 'Deleted', 'Added', 'Count', 'Average');
		$data['table'] = $this->table->generate($query);

		$this->load->view('header');
		$this->load->view('table', $data);
		$this->load->view('footer');

	}

	function orphaned()
	{

		$user_id = $this->session->userdata('user_id');
		$user_count = $this->db->count_all('user');

		$this->db->select('movie.*, COUNT(rating.rating_value) AS rating_count, NULL as rating_value', FALSE);
		$this->db->from('movie');
		$this->db->join('rating', 'movie.movie_id = rating.movie_id AND (' . $this->db->escape($user_id) . ' NOT IN (SELECT r.user_id FROM rating AS r WHERE r.movie_id = rating.movie_id))', 'inner');
		$this->db->group_by('movie_id');
		$this->db->having('rating_count', $user_count - 1);
		$this->db->order_by('movie_name');

		$query = $this->db->get();

		$this->load->library('table');
		$this->table->set_template(array('table_open' => '<table id="item-table">'));
		$this->table->set_heading('ID', 'Name', 'URL', 'Deleted', 'Added', 'Count', 'Rating');
		$data['table'] = $this->table->generate($query);

		$this->load->view('header');
		$this->load->view('table', $data);
		$this->load->view('footer');

	}

}

/* EOF controllers/itemlist.php */
