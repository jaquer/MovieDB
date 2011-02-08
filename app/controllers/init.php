<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Init extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		redirect('/user/');
	}
}

/* EOF controllers/init.php */
