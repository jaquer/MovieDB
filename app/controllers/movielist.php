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

		$data['caption'] = 'Unrated Movies';

		$this->table->set_template(array('table_open' => '<table class="movielist-table"><caption>' . $data['caption'] . '</caption><colgroup><col class="rating-column"><col class="movie-name-column"></colgroup>'));
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

		$this->table->set_template(array('table_open' => '<table class="movielist-table"><caption>' . $data['caption'] . '</caption><colgroup><col class="average-column"><col class="movie-name-column"></colgroup>'));
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

		$data['caption'] = 'Movies Missing Your Rating';

		$this->table->set_template(array('table_open' => '<table class="movielist-table"><caption>' . $data['caption'] . '</caption><colgroup><col class="rating-column"><col class="movie-name-column"></colgroup>'));
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

		$this->table->set_template(array('table_open' => '<table class="movielist-table"><caption>' . $data['caption'] . '</caption><colgroup><col class="rating-column"><col class="movie-name-column"></colgroup>'));
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
		if ($rating === NULL) $rating = -1;

		$values = array(0 => 'Not Interested', 1 => 'Hated It', 2 => 'Didn\'t Like It', 3 => 'Liked It', 4 => 'Really Liked It', 5 => 'Loved It', -1 => 'Remove Rating');

		$ret = '';

		foreach ($values as $value => $desc)
		{
			$ret .= '<input type="radio" name="movie_id-' . $id . '" title="' . $desc . '" value="' . $value . '"';
			if ($value == $rating)
				$ret .= ' checked="checked"';
			$ret .= '>';
		}

		$ret .= '&nbsp;<img src="' . base_url() . 'images/not-interested-';
		if ($rating == 0)
			$ret .= 'on';
		else
			$ret .= 'off';

		$ret .= '.png" title="' . $values[0] . '" alt="" onClick="selectStar(this, 0)">&nbsp;';

		for ($i = 1; $i <= 5; $i++) {
			$ret .= '<img src="' . base_url() . 'images/star-';
			if ($i <= $rating)
			  $ret .= 'on';
			else
			  $ret .= 'off';
			$ret .= '.png" title="' . $values[$i] . '" alt="" onClick="selectStar(this, ' . $i . ')">';
		}

		$ret .= '&nbsp;<img src="' . base_url() . 'images/remove.png" title="' . $values[-1] .'" alt="" onClick="selectStar(this, -1)">';

		return $ret;
	}
}

/* EOF app/controllers/movielist.php */
