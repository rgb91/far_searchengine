<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {


	public function __construct() {
		parent::__construct();
	}

	public function get_user_by_email( $email = '' ){

		if ( !isset($email) || empty($email) ){
			return;
		}

		$query = $this->db->get_where('ICTCollab_Users', array('email'=>$email));
		if ( $query->num_rows() == 1){
			$result_arr = $query->result();
			return $result_arr[0];
		}
		return;
	}

	public function register_new_user($uname, $email, $pass, $fname, $lname) {
		$pass_sha1 = sha1($pass);
		$data = array(
		   'uname' => $uname ,
		   'upass' => $pass_sha1 ,
		   'email' => $email ,
		   'fname' => $fname ,
		   'lname' => $lname
		);

		return $this->db->insert('ICTCollab_Users', $data);
	}

	public function update_user_profile( $uname, $email, $fname, $lname) {
		$data = array(
			'uname' => $uname,
			'fname' => $fname,
			'lname' => $lname
		);

		$this->db->where('email', $email);
		return $this->db->update('ICTCollab_Users', $data);
	}

	public function is_taken_username($uname){
		if ( !isset($uname) || empty($uname) ){
			return;
		}

		$query = $this->db->get_where('ICTCollab_Users', array('uname'=>$uname));
		if ( $query->num_rows() > 0 ){
			return true;
		}
		return false;
	}

	public function is_taken_email($email){
		if ( !isset($email) || empty($email) ){
			return;
		}

		$query = $this->db->get_where('ICTCollab_Users', array('email'=>$email));
		if ( $query->num_rows() > 0 ){
			return true;
		}
		return false;
	}
}

/* End of file login_model.php */
/* Location: ./application/models/login_model.php */