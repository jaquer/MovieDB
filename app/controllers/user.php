<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$query = $this->db->get('user');
		foreach ($query->result() as $row)
		{
			$data['users'][$row->id] = $row->user_name;
		}

		$this->load->view('header');
		$this->load->view('user/login', $data);
		$this->load->view('footer');
	}

	function login()
	{

		$this->session->set_userdata('user_id', $this->input->post('user_id'));

		if ($this->session->userdata('redirect'))
		{
			redirect($this->session->userdata('redirect'));
		}
		else
		{
			redirect('/movielist/');
		}
	}
}

/* EOF app/controllers/user.php */
