<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{

		/* TODO: move to model */
		$q = $this->db->get('user');
		foreach ($q->result() as $row)
		{
			$data['users'][$row->user_id] = $row->user_name;
		}

		$this->load->view('header');
		$this->load->view('loginform', $data);
		$this->load->view('footer');
	}

	function login()
	{

		$this->session->set_userdata('user_id', $this->input->post('user_id'));
		redirect('/itemlist/');

	}
}

/* EOF controllers/user.php */
