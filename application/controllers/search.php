<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	private $sphinxClient = null;

	function __construct() {
		parent::__construct();
		$this->load->model('Search_model');
	}

	public function index() {
		if ( $this->session->userdata('user_login') != 1 ) {
			redirect(base_url().'index.php/auth/login', 'refresh');
		}

		redirect(base_url().'index.php/search/query', 'refresh');
	}

	public function query() {
		if ( $this->session->userdata('user_login') != 1 ) {
			redirect('/auth/login', 'refresh');
		}

		$searchText 			= $this->input->post('search_text');
		if ( !isset($searchText) || empty($searchText) ) {
			$this->render_page('search/search_view', array());
			return;
		}

		$this->setupSphinxClient();
		$searchTextAdvanced 	= $this->getDetailedQuery($searchText);
		$result 				= $this->sphinxClient->Query( $searchTextAdvanced, 'test1' );
		$scientists 			= $this->getScientistArray($result);
		$collaborators 			= $this->Search_model->getCollaboratorsInfoFromSearchResult($scientists);


		$data['result'] 		= $result;
		// $data['scientists'] 	= $scientists;
		$data['collaborators'] 	= $collaborators;
		$this->render_page('search/search_view', $data);
	}

	private function setupSphinxClient() {
		$this->sphinxClient = new SphinxClient();

		$this->sphinxClient->SetServer( "localhost", 9312 );
		$this->sphinxClient->SetMatchMode( SPH_MATCH_ANY  );
		$this->sphinxClient->SetRankingMode ( SPH_RANK_WORDCOUNT );
		$this->sphinxClient->setGroupBy('dmuserid', SPH_GROUPBY_ATTR, "@weight DESC");
		$this->sphinxClient->SetFieldWeights(array('title' => 10, 'title_secondary' => 9, 'publisher' => 3));
		$this->sphinxClient->SetArrayResult(true);
		// $this->sphinxClient->SetLimits(0,3); // <-- This line doesn't produce any output, has problem
	}

	private function getDetailedQuery($searchText) {

		if ( empty($searchText)) {$searchText = "pseudonym";}

		$searchText_e = explode(" ",$searchText);
		$searchText_stars = "*".implode('* *', $searchText_e)."*";
		$searchText_stars_or =  "*".implode('* | *', $searchText_e)."*";
		$nowords_minus_1 = count($searchText_e) - 1;
		$nowords_minus_2 = count($searchText_e) - 2;
		$nowords_minus_3 = count($searchText_e) - 3;
		$nowords_minus_4 = count($searchText_e) - 4;
		$nowords_minus_5 = count($searchText_e) - 5;
		if ($nowords_minus_1 <= 0) {$nowords_minus_1 = 1;}
		if ($nowords_minus_2 <= 0) {$nowords_minus_2 = 1;}
		if ($nowords_minus_3 <= 0) {$nowords_minus_3 = 1;}
		if ($nowords_minus_4 <= 0) {$nowords_minus_4 = 1;}
		if ($nowords_minus_5 <= 0) {$nowords_minus_5 = 1;}

		return "\"^$searchText\" | \"$searchText\" | \"$searchText\"~1 | \"$searchText\"~2 | \"$searchText\"~5 | \"$searchText\"~100 |
			\"$searchText\"/$nowords_minus_1 | \"$searchText\"/$nowords_minus_2 | \"$searchText\"/$nowords_minus_3 | \"$searchText\"/$nowords_minus_4 | \"$searchText\"/$nowords_minus_5 |
			\"^$searchText_stars\" | \"$searchText_stars\" | \"$searchText_stars\"~1 | \"$searchText_stars\"~2 | \"$searchText_stars\"~5 | \"$searchText_stars\"~100 |
			\"$searchText_stars\"/$nowords_minus_1 | \"$searchText_stars\"/$nowords_minus_2 | \"$searchText_stars\"/$nowords_minus_3 | \"$searchText_stars\"/$nowords_minus_4 | \"$searchText_stars\"/$nowords_minus_5 |
			($searchText_stars_or)";
	}

	private function getScientistArray($result) {
		$scientists = array();
		if ( $result === FALSE ) {
			$this->session->set_flashdata('message', 'Error: '.$this->sphinxClient->GetLastError());
		} else {
			if ( $this->sphinxClient->GetLastWarning() ) { $this->session->set_flashdata('message', 'Warning: '.$this->sphinxClient->GetLastWarning()); }

			if ( !empty( $result['matches']) ) {
				foreach ( $result['matches'] as $doc) {
					$scientists[$doc['attrs']['dmuserid']] = $doc['weight']; // * $doc["attrs"]["@count"] //The addition of the following gives advantage to old researchers compared to new that have less publications
				}
			}
		}
			return $scientists;
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

/* End of file search.php */
/* Location: ./application/controllers/search.php */