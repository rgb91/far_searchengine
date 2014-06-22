<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index() {
		if ( $this->session->userdata('user_login') != 1 ) {
			redirect('/auth/login', 'refresh');
		}

		$this->render_page('home/home_view', array(), FALSE);
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

/* End of file home.php */
/* Location: ./application/controllers/home.php */