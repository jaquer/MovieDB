<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MovieList extends CI_Controller {

	public $_rating_titles;

	function __construct()
	{
		parent::__construct();
		if (! $this->session->userdata('user_id'))
		{
			$this->session->set_userdata('redirect', current_url());
			redirect('/user/');
		}
		$this->_rating_titles = unserialize(RATING_TITLES);
	}

	function index()
	{
		$this->load->view('header');
		$this->load->view('movielist/landing');
		$this->load->view('footer');
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

		$data['caption'] = 'Unrated Movies';

		$this->table->set_template(array('table_open' => '<table class="movielist"><caption>' . $data['caption'] . '</caption><colgroup><col class="rating-column"><col class="movie-name-column"></colgroup>'));
		$this->table->set_heading('Rating', 'Movie');

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$this->table->add_row($this->_radioboxen($row->id, $row->rating_value), anchor('movie/details/' . $row->id, $row->movie_name, 'target="movie-details"'));
			}
		}
		else
		{
			$this->table->set_heading('You have no more movies to rate. Hooray!');
		}

		$data['table'] = $this->table->generate();

		$this->load->view('header');
		$this->load->view('movielist/container', $data);
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

		$data['caption'] = 'Movies to Delete';

		$this->table->set_template(array('table_open' => '<table class="movielist"><caption>' . $data['caption'] . '</caption><colgroup><col class="average-column"><col class="movie-name-column"></colgroup>'));
		$this->table->set_heading('Average', 'Movie');

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$this->table->add_row($row->rating_average, anchor('movie/details/' . $row->id, $row->movie_name, 'target="movie-details"'));
			}
		}
		else
		{
			$this->table->set_heading('There are no candidates for deletion. You only have good movies, man.');
		}

		$data['table'] = $this->table->generate();

		$this->load->view('header');
		$this->load->view('movielist/container', $data);
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

		$data['caption'] = 'Movies Missing Your Rating';

		$this->table->set_template(array('table_open' => '<table class="movielist"><caption>' . $data['caption'] . '</caption><colgroup><col class="rating-column"><col class="movie-name-column"></colgroup>'));
		$this->table->set_heading('Rating', 'Movie');

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$this->table->add_row($this->_radioboxen($row->id, $row->rating_value), anchor('movie/details/' . $row->id, $row->movie_name, 'target="movie-details"'));
			}
		}
		else
		{
			$this->table->set_heading('There are no movies missing only your rating. Good job!');
		}

		$data['table'] = $this->table->generate();

		$this->load->view('header');
		$this->load->view('movielist/container', $data);
		$this->load->view('footer');
	}

	function all()
	{
		$user_id = $this->session->userdata('user_id');

		$this->db->select('movie.*, rating_value');
		$this->db->from('movie');
		$this->db->join('rating', 'movie.id = rating.movie_id AND rating.user_id = ' . $this->db->escape($user_id), 'LEFT');
		$this->db->order_by('movie_name_sort');

		$query = $this->db->get();

		$this->load->library('table');

		$data['caption'] = 'All Movies';

		$this->table->set_template(array('table_open' => '<table class="movielist"><caption>' . $data['caption'] . '</caption><colgroup><col class="rating-column"><col class="movie-name-column"></colgroup>'));
		$this->table->set_heading('Rating', 'Movie');

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$this->table->add_row($this->_radioboxen($row->id, $row->rating_value), anchor('movie/details/' . $row->id, $row->movie_name, 'target="movie-details"'));
			}
		}
		else
		{
			$this->table->set_heading('There are no movies in the database. What a shame.');
		}

		$data['table'] = $this->table->generate();

		$this->load->view('header');
		$this->load->view('movielist/container', $data);
		$this->load->view('footer');
	}

	function _radioboxen($id, $rating)
	{
		if ($rating === NULL)
			$rating = REMOVE_RATING;
		else
			$rating = (int) $rating;

		$ret = '';

		$name = 'rating[' . $id .']';

		foreach ($this->_rating_titles as $value => $title)
		{
			$img = array();
			if ($value === NOT_INTERESTED)
			{
				if ($rating === $value)
					$img['src'] = 'images/not-interested.png';
				else
					$img['src'] = 'images/not-interested-off.png';

				$img['class'] = 'not-interested-button';
			}
			elseif ($value === REMOVE_RATING)
			{
				$img['src']   = 'images/remove.png';
				$img['class'] = 'remove-button';
			}
			else
			{
				if ($value <= $rating)
					$img['src'] = 'images/star.png';
				else
					$img['src'] = 'images/star-off.png';
			}
			$img['title'] = $title;

			$radio = array();
			$radio['name']    = $name;
			$radio['value']   = $value;
			$radio['title']   = $title;
			$radio['checked'] = ($rating == $value);

			$radio = form_radio($radio);
			$img   = img($img);

			$ret .= form_label($img . $radio);
		}

		return $ret;

	}

	function save()
	{

		$user_id = (int) $this->input->post('user_id');

		if (! $user_id)
			show_error('User ID is not set.');

		foreach ($this->input->post('rating') as $movie_id => $rating_value)
		{

			$rating_value = (int) $rating_value;

			if ($rating_value === REMOVE_RATING)
			{
				$this->db->where('user_id', $user_id);
				$this->db->where('movie_id', $movie_id);
				$this->db->delete('rating');
			}
			else
			{
				/* This seems kind of ham-fisted, but neither
				   INSERT INTO ... ON DUPLICATE KEY UPDATE nor
				   REPLACE INTO really achieve what I'm after:
				   to update the rating only if it differs from
				   its current value. */

				$this->db->where('user_id', $user_id);
				$this->db->where('movie_id', $movie_id);
				$query = $this->db->get('rating');

				$this->db->set('user_id', $user_id);
				$this->db->set('movie_id', $movie_id);
				$this->db->set('rating_value', $rating_value);
				$this->db->set('rating_modified', 'NOW()', FALSE);

				/* Rating already exists... */
				if ($query->num_rows() > 0)
				{
					$row = $query->row();
					$current_rating_value = (int) $row->rating_value;

					/* ...and has been changed. */
					if ($current_rating_value !== $rating_value)
					{
						$this->db->where('id', $row->id);
						$this->db->update('rating');
					}

				}
				else
				{
					$this->db->set('rating_added', 'NOW()', FALSE);
					$this->db->insert('rating');
				}

			}

		}

		$this->load->view('header');
		$this->load->view('movielist/save');
		$this->load->view('footer');

	}
}

/* EOF app/controllers/movielist.php */
