<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DataBase extends CI_Controller {

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
		redirect('/database/update/');
	}

	function update()
	{
		echo "DataBase update...";
	}

}

/* EOF app/controllers/database.php */
