<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Movie extends CI_Controller {

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
		/* Nothing to see here... */
		redirect('/');
	}

	function details()
	{

		$user_id = $this->session->userdata('user_id');
		$movie_id = $this->uri->segment(3);

		if (! $movie_id)
		{
			redirect('/');
		}

		$this->_rating_titles = unserialize(RATING_TITLES);
		$this->_rating_titles[REMOVE_RATING] = 'Not rated';

		$this->load->helper('date');

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

				$rating_value = $row->rating_value;
				if ($rating_value === NULL)
					$rating_value = REMOVE_RATING;
				else
					$rating_value = (int) $rating_value;

				if ($row->rating_modified && $row->rating_modified !== '0000-00-00 00:00:00')
				{
					$rating_date = $row->rating_modified;
					$rating_date = mysql_to_unix($rating_date);

					$rating_timespan = pretty_timespan($rating_date);

					$rating_date = mdate('%F %j, %Y at %g:%i%a', $rating_date);
				}
				else
				{
					$rating_date = '';
					$rating_timespan = '';
				}

				$rating_stars = '<span title="' . $this->_rating_titles[$rating_value] . '">';

				if ($rating_value === NOT_INTERESTED)
					$rating_stars .= img('images/not-interested.png');
				else
					$rating_stars .= img('images/not-interested-off.png');

				foreach (array_keys($this->_rating_titles) as $value)
				{
					if ($value === REMOVE_RATING || $value === NOT_INTERESTED)
						continue;

					if ($value <= $rating_value)
						$rating_stars .= img('images/star.png');
					else
						$rating_stars .= img('images/star-off.png');
				}

				$rating_stars .= '</span>';

				$user = array();
				$user['user_name']    = $row->user_name;
				$user['rating_stars'] = $rating_stars;
				$user['rating_date']  = $rating_date;
				$user['rating_timespan'] = $rating_timespan;

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
