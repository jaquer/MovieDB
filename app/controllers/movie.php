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

}

/* EOF controllers/movie.php */
