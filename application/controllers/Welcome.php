<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct() {
		parent::__construct();
		// $this->load->library('session');
	}


	public function index() {
		echo $_SESSION['set_language'];
    	echo '<br />';
		print_r($this->langs);
	
		// $user = $_SESSION['USER'] = 'giorgosstab';
		// $data = array(
		// 	'page_title' => 'This is the title of the page',
		// 	'user' => $user
		// );
		// $this->load->view('welcome_message',$data,$user);
		// $this->load->database();
	}
}
