<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Collaborator extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Collaborator_model');
	}

	public function index() {
	}

	public function details($dmuserid = '') {

		if ( $this->session->userdata('user_login') != 1 ) {
			$this->set_flash_message('You need to login first');
			redirect(base_url());
		}


		if ( !isset($dmuserid) || empty($dmuserid) ){
			redirect(base_url(), 'refresh');
		}

		$data['collaborator_data'] 	= $this->Collaborator_model->get_collaborator_by_dmuserid($dmuserid);

		$this->render_page('collaborator/detail_view', $data);
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

/* End of file  */
/* Location: ./application/controllers/ */