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
			$this->set_flash_message('Fill up the form correctly');
			redirect('auth/login');
		}

		$user_obj = $this->Auth_model->get_user_by_email($email);

		//	echo '<pre>'; print_r($user_obj); die();
		if ( isset($user_obj)  && !empty($user_obj) && $this->password_check($pass,$user_obj) ) {
			$this->set_flash_message('Successfully Logged in', 'success');
			$this->log_user_in($user_obj->uname, $user_obj->email, $user_obj->fname, $user_obj->lname);

		} else {
			$this->set_flash_message('Login Error!');
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
			$this->set_flash_message('You are already registered', 'warning');
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

		$this->registration_validation($uname, $email, $pass, $repass, $fname, $lname, 'register');

		// echo '<pre>'; print_r($this->input->post()); die();

		if ( $this->Auth_model->register_new_user($uname, $email, $pass, $fname, $lname) ) {
			$this->set_flash_message('Successfully Registered', 'success');
			$this->log_user_in($uname, $email, $fname, $lname);
		} else {
			$this->set_flash_message('Registration is not successful');
			redirect('auth/register', 'refresh');
		}
	}

	public function profile() {
		if ( $this->session->userdata('user_login') != 1 ) {
			$this->set_flash_message('You need to login first');
			redirect(base_url());
		}

		$this->render_page('auth/edit_profile_view', array());
	}

	public function profile_dopost() {
		$uname 		= $this->input->post('username');
		$email 		= $this->input->post('email');
		$pass 		= $this->input->post('pass');
		$fname 		= $this->input->post('firstname');
		$lname 		= $this->input->post('lastname');

		$user_obj = $this->Auth_model->get_user_by_email($email);

		if ( isset($user_obj)  && !empty($user_obj) && $this->password_check($pass,$user_obj) ) {

			$this->registration_validation($uname, $email, $pass, $pass, $fname, $lname, 'profile');

			if ( $this->Auth_model->update_user_profile( $uname, $email, $fname, $lname) ) {
				$this->set_flash_message('Successfully Updated', 'success');
				$this->update_session_data($uname, $email, $fname, $lname );
				redirect('auth/profile', 'refresh');
			} else {
				$this->set_flash_message('Update is not successful');
				redirect('auth/profile', 'refresh');
			}

		} else {
			$this->set_flash_message('Password does not match');
			redirect('auth/profile', 'refresh');
		}
	}

	private function update_session_data($uname, $email, $fname, $lname) {
		$array = array(
			'first_name' 	=> $fname,
			'last_name' 	=> $lname,
			'user_name' 	=> $uname
		);
		$this->session->set_userdata( $array );
	}

	private function registration_validation($uname, $email, $pass, $repass, $fname, $lname, $redirectMethod) {

		if ( !$this->is_valid_reg_form($uname, $email, $pass, $repass, $fname, $lname) ) {
			$this->set_flash_message('Fill up the form correctly');
			$this->session->set_flashdata('message_type', 'danger');
			redirect('auth/'.$redirectMethod);
		}

		if ( strlen($pass) < $this->USERNAME_MIN_LENGTH ) {
			$this->set_flash_message('Username must contain at least '.$this->USERNAME_MIN_LENGTH.' characters');
			redirect('auth/'.$redirectMethod);
		}

		if ( strlen($pass) < $this->PASSWORD_MIN_LENGTH ) {
			$this->set_flash_message('Password must contain at least '.$this->PASSWORD_MIN_LENGTH.' characters');
			redirect('auth/'.$redirectMethod);
		}

		if ( strcmp($pass, $repass) != 0 ) {
			$this->set_flash_message('Password mismatch!');
			redirect('auth/'.$redirectMethod);
		}

		if ( $redirectMethod == 'register' && $this->Auth_model->is_taken_email($email) ) {
			$this->set_flash_message('This email has already been registered');
			redirect('auth/'.$redirectMethod);
		}

		if ( $redirectMethod == 'register' && $this->Auth_model->is_taken_username($uname) ) {
			$this->set_flash_message('This username has already been registered');
			redirect('auth/'.$redirectMethod);
		}
	}

	private function set_flash_message($message, $message_type='danger') {
		$this->session->set_flashdata('message', $message);
		$this->session->set_flashdata('message_type', $message_type);
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
		redirect('search/query/');
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