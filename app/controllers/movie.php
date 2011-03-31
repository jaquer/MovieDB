<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Movie extends CI_Controller {

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
		/* Nothing to see here... */
		redirect('/movielist/');
	}

	function details()
	{

		$user_id = $this->session->userdata('user_id');
		$movie_id = $this->uri->segment(3);

		if (! $movie_id)
		{
			redirect('/movielist/');
		}

		$this->_rating_titles = unserialize(RATING_TITLES);
		$this->_rating_titles[REMOVE_RATING] = 'Not rated';

		$this->db->select('movie.*, (SELECT COUNT(*) FROM rating WHERE rating.movie_id = movie.id) AS rating_count, ROUND(AVG(rating_value), 1) AS rating_average', FALSE);
		$this->db->from('movie');
		$this->db->join('rating', 'movie.id = rating.movie_id', 'LEFT');
		$this->db->where('rating_value >', 0);
		$this->db->where('movie.id', $movie_id);

		$query = $this->db->get();

		$row = $query->row();

		if ($row->id !== NULL)
		{
			$data['movie_id'] = $row->id;

			foreach (array('imdb_id', 'movie_name', 'movie_year', 'movie_status', 'movie_added', 'rating_count', 'rating_average') as $attr)
			{
				$data[$attr] = $row->$attr;
			}
		}
		else
		{
			die('Invalid Movie ID');;
		}

		$this->db->select('user_name, rating.*');
		$this->db->from('user');
		$this->db->join('rating', 'user.id = rating.user_id AND movie_id = ' . $this->db->escape($movie_id), 'LEFT');

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{

				if ($row->rating_value === NULL)
					$row->rating_value = -1;
				$user = array();
				$user['user_name']    = $row->user_name;
				$user['rating_value'] = $row->rating_value;
				$user['rating_title'] = $this->_rating_titles[$row->rating_value];
				$user['rating_added'] = $row->rating_added;

				$data['users'][] = $user;
			}
		}
		else
		{
			/* This "can't happen" at this point, but better safe than sorry? */
			die('Invalid Movie ID');;
		}

		$this->load->view('movie/details', $data);

	}

}

/* EOF controllers/movie.php */
