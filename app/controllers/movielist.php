<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MovieList extends CI_Controller {

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
		redirect('/movielist/unrated/');
	}

	function unrated()
	{

		$user_id = $this->session->userdata('user_id');

		$this->db->select('movie.*, rating_value');
		$this->db->from('movie');
		$this->db->join('rating', 'movie.id = rating.movie_id AND rating.user_id = ' . $this->db->escape($user_id), 'LEFT');
		$this->db->where('rating_value IS NULL');
		$this->db->order_by('movie_name_sort');

		$query = $this->db->get();

		$this->load->library('table');
		$this->table->set_template(array('table_open' => '<table id="movies-table">'));
		$this->table->set_heading('Rating', 'Movie');

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$this->table->add_row($row->rating_value, '<a href="http://www.imdb.com/title/' . $row->imdb_id . '" target="imdb">' . $row->movie_name . '</a>');
			}
		}
		else
		{
			$this->table->set_heading('You have no more movies to rate. Hooray!');
		}

		$data['table'] = $this->table->generate();

		$data['caption'] = 'Unrated Movies';

		$this->load->view('header');
		$this->load->view('table', $data);
		$this->load->view('footer');

	}

	function delete()
	{

		$user_count = $this->db->count_all('user');

		$this->db->select('movie.*, (SELECT COUNT(*) FROM rating WHERE rating.movie_id = movie.id) AS rating_count, ROUND(AVG(rating_value), 1) AS rating_average', FALSE);
		$this->db->from('movie');
		$this->db->join('rating', 'movie.id = rating.movie_id', 'LEFT');
		$this->db->where('rating_value >', 0);
		$this->db->where('movie_status', 'ACTIVE');
		$this->db->group_by('movie.id');
		$this->db->having('rating_count', $user_count);
		$this->db->having('rating_average <', 3);
		$this->db->order_by('rating_average');
		$this->db->order_by('movie_name_sort');

		$query = $this->db->get();

		$this->load->library('table');
		$this->table->set_template(array('table_open' => '<table id="movies-table">'));
		$this->table->set_heading('Average', 'Name');

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$this->table->add_row($row->rating_average, '<a href="http://www.imdb.com/title/' . $row->imdb_id . '" target="imdb">' . $row->movie_name . '</a>');
			}
		}
		else
		{
			$this->table->set_heading('There are no candidates for deletion. You only have good movies, man.');
		}

		$data['table'] = $this->table->generate();

		$data['caption'] = 'Movies to Delete';
		$this->load->view('header');
		$this->load->view('table', $data);
		$this->load->view('footer');

	}

	function orphaned()
	{

		$user_id = $this->session->userdata('user_id');
		$user_count = $this->db->count_all('user');

		$this->db->select('movie.*, COUNT(rating_value) AS rating_count, NULL as rating_value', FALSE);
		$this->db->from('movie');
		$this->db->join('rating', 'movie.id = rating.movie_id AND (' . $this->db->escape($user_id) . ' NOT IN (SELECT r.user_id FROM rating AS r WHERE r.movie_id = rating.movie_id))', 'INNER');
		$this->db->group_by('movie.id');
		$this->db->having('rating_count', $user_count - 1);
		$this->db->order_by('movie_name_sort');

		$query = $this->db->get();

		$this->load->library('table');
		$this->table->set_template(array('table_open' => '<table id="movies-table">'));
		$this->table->set_heading('Rating', 'Name');

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$this->table->add_row($row->rating_value, '<a href="http://www.imdb.com/title/' . $row->imdb_id . '" target="imdb">' . $row->movie_name . '</a>');
			}
		}
		else
		{
			$this->table->set_heading('There are no movies missing only your rating. Good job!');
		}

		$data['table'] = $this->table->generate();

		$data['caption'] = 'Movies Missing Your Rating';

		$this->load->view('header');
		$this->load->view('table', $data);
		$this->load->view('footer');

	}

}

/* EOF controllers/movielist.php */
