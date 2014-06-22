<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	private $USERNAME_MIN_LENGTH 	= 4;
	private $PASSWORD_MIN_LENGTH 	= 5;

	public function __construct(){
		parent::__construct();
		$this->load->model('Auth_model');
	}

	public function index() {
		if ( $this->session->userdata('user_login') != 1 ) {
			redirect('/auth/login', 'refresh');
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function login() {
		if ( $this->session->userdata('user_login') == 1) {
			redirect(base_url(), 'refresh');
		}

		$this->render_page('auth/login_view', array());
	}

	public function login_dopost(){

		$email 		= $this->input->post('email');
		$pass 		= $this->input->post('pass');

		if ( $this->session->userdata('user_login') == 1) {
			redirect(base_url(), 'refresh');
		}
		if ( !isset($email) || !isset($pass) || empty($email) || empty($pass) ) {
			$this->session->set_flashdata('message', 'Fill up the form correctly');
			redirect('auth/login');
		}

		$user_obj = $this->Auth_model->get_user_by_email($email);

		//	echo '<pre>'; print_r($user_obj); die();
		if ( isset($user_obj)  && !empty($user_obj) && $this->password_check($pass,$user_obj) ) {

			$this->log_user_in($user_obj->uname, $user_obj->email, $user_obj->fname, $user_obj->lname);
			/*$array = array(
				'user_login'	=> 1,
				'email' 		=> $user_obj->email,
				'first_name' 	=> $user_obj->fname,
				'last_name' 	=> $user_obj->lname,
				'user_name' 	=> $user_obj->uname
			);
			$this->session->set_userdata( $array );
			redirect(base_url(), 'refresh');*/
		} else {
			$this->session->set_flashdata('message', 'Login Error!');
			redirect('auth/login');
		}
	}

	public function logout() {
	    $user_data = $this->session->all_userdata();
	        foreach ($user_data as $key => $value) {
	        	$this->session->unset_userdata($key);
	            /*if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
	                $this->session->unset_userdata($key);
	            }*/
	        }
	    $this->session->sess_destroy();
	    redirect('auth/login', 'refresh');
	}

	public function register() {
		if ( $this->session->userdata('user_login') == 1 ) {
			$this->session->set_flashdata('message', 'You are already registered');
			redirect(base_url());
		}

		$this->render_page('auth/register_view', array());
	}

	public function register_dopost() {
		$uname 		= $this->input->post('username');
		$email 		= $this->input->post('email');
		$pass 		= $this->input->post('pass');
		$repass 	= $this->input->post('repass');
		$fname 		= $this->input->post('firstname');
		$lname 		= $this->input->post('lastname');

		$this->registration_validation($uname, $email, $pass, $repass, $fname, $lname);

		// echo '<pre>'; print_r($this->input->post()); die();

		if ( $this->Auth_model->register_new_user($uname, $email, $pass, $fname, $lname) ) {
			$this->session->set_flashdata('message', 'Successfully Registered');
			$this->log_user_in($uname, $email, $fname, $lname);
		} else {
			$this->session->set_flashdata('message', 'Registration is not successful');
			redirect('auth/register', 'refresh');
		}
	}

	private function registration_validation($uname, $email, $pass, $repass, $fname, $lname) {

		if ( !$this->is_valid_reg_form($uname, $email, $pass, $repass, $fname, $lname) ) {
			$this->session->set_flashdata('message', 'Fill up the form correctly');
			redirect('auth/register');
		}
		if ( $this->session->userdata('user_login') == 1) {
			redirect(base_url(), 'refresh');
		}

		if ( strlen($pass) < $this->USERNAME_MIN_LENGTH ) {
			$this->session->set_flashdata('message', 'Username must contain at least '.$this->USERNAME_MIN_LENGTH.' letters');
			redirect('auth/register');
		}

		if ( strlen($pass) < $this->PASSWORD_MIN_LENGTH ) {
			$this->session->set_flashdata('message', 'Password must contain at least '.$this->PASSWORD_MIN_LENGTH.' letters');
			redirect('auth/register');
		}

		if ( strcmp($pass, $repass) != 0 ) {
			$this->session->set_flashdata('message', 'Password mismatch');
			redirect('auth/register');
		}

		if ( $this->Auth_model->is_taken_email($email) ) {
			$this->session->set_flashdata('message', 'This email addess has already been registered');
			redirect('auth/register');
		}

		if ( $this->Auth_model->is_taken_username($uname) ) {
			$this->session->set_flashdata('message', 'This username has already been registered');
			redirect('auth/register');
		}
	}

	private function log_user_in($uname, $email, $fname, $lname) {
		$array = array(
			'user_login'	=> 1,
			'email' 		=> $email,
			'first_name' 	=> $fname,
			'last_name' 	=> $lname,
			'user_name' 	=> $uname
		);
		$this->session->set_userdata( $array );
		redirect(base_url(), 'refresh');
	}

	private function password_check($pass, $user_obj) {
		if (sha1($pass) == $user_obj->upass) {
		// if ($pass == $user_obj->upass) {
			return TRUE;
		}
		return FALSE;
	}

	private function is_valid_reg_form($uname, $email, $pass, $repass, $fname, $lname) {
		if ( !isset($uname) || empty($uname) ){
			return false;
		}
		if ( !isset($email) || empty($email) ){
			return false;
		}
		if ( !isset($pass) || empty($pass) ){
			return false;
		}
		if ( !isset($repass) || empty($repass) ){
			return false;
		}
		if ( !isset($fname) || empty($fname) ){
			return false;
		}
		if ( !isset($lname) || empty($lname) ){
			return false;
		}
		return true;
	}

	private function render_page($filename, $data) {
		$page_data['content'] 		= $this->load->view($filename, $data, TRUE);
		$page_data['is_logged_in']	= 0;
		if ( $this->session->userdata('user_login') == 1 ) {
			$page_data['is_logged_in'] = 1;
		}

		$this->load->view('_shared/template.php', $page_data, FALSE);
	}

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */