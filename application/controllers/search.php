<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	private $sphinxClient = null;

	function __construct() {
		parent::__construct();
		$this->load->model('Search_model');
		$this->load->library('pagination');
		$this->load->helper('url');
	}

	public function index() {
		if ( $this->session->userdata('user_login') != 1 ) {
			redirect('/auth/login', 'refresh');
		}

		redirect('/search/query', 'refresh');
	}

	public function query($pagination_tmp = '', $page_no='') {
		if ( $this->session->userdata('user_login') != 1 ) {
			redirect('/auth/login', 'refresh');
		}

		$searchText = $this->getSearchText($pagination_tmp);

		if ( !isset($searchText) || empty($searchText) ) {
			$this->render_page('search/search_view', array());
			return;
		}
		// file_put_contents('php://stderr', print_r($searchTextAdvanced.'\n', TRUE));
		$this->session->set_userdata( 'search_text', $searchText );

		$collaborators 			= $this->Search_model->logSearchText($this->session->userdata('email'), $searchText);

		/*
		* Data retrieval from the search text is done here
		*/
		$this->setupSphinxClient();
		$searchTextAdvanced 	= $this->getDetailedQuery($searchText);
		$result 				= $this->sphinxClient->Query( $searchTextAdvanced, 'test1' ); //test1 is the index name
		$scientists 			= $this->getScientistArray($result);
		$numOfCollabs			= count($scientists);

		/*
		* The configuration for pagination
		*/
		$config 				= $this->getConfigForPagination($numOfCollabs);
		$this->pagination->initialize($config);
        $page 					= ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $data['links'] 			= $this->pagination->create_links();
		$data['collaborators'] 	= $this->Search_model->getCollaboratorsInfoFromSearchResult($scientists, $page, $config['per_page']);
		echo '<pre>'; print_r($data['collaborators']); die();
		$data['searchText']		= $searchText;
		$this->render_page('search/search_view', $data);
	}

	private function getConfigForPagination($numOfCollabs) {
		$config = array();
        $config['base_url'] 	= base_url() . "index.php/search/query/page";
        $config['total_rows'] 	= $numOfCollabs;
        $config['per_page'] 	= 10;
        $config['uri_segment'] 	= 4;
        $config['num_links'] 	= 2;

        return $config;
	}

	private function getSearchText($pagination_tmp) {

		$searchText = '';

		if ( !isset($pagination_tmp) || empty($pagination_tmp) ) {
			$this->session->unset_userdata('search_text');
			$searchText 		= $this->input->post('search_text');
		} else {
			$searchText 		= $this->session->userdata('search_text');
		}

		return $searchText;
	}

	private function setupSphinxClient() {
		$this->sphinxClient = new SphinxClient();

		$this->sphinxClient->SetServer( "localhost", 9312 );
		$this->sphinxClient->SetMatchMode( SPH_MATCH_ANY  );
		$this->sphinxClient->SetRankingMode ( SPH_RANK_WORDCOUNT );
		$this->sphinxClient->setGroupBy('dmuserid', SPH_GROUPBY_ATTR, "@weight DESC");
		$this->sphinxClient->SetFieldWeights(array('title' => 10, 'title_secondary' => 9, 'publisher' => 3));
		$this->sphinxClient->SetArrayResult(true);
		$this->sphinxClient->SetLimits(0,MAX_NUMBER_OF_RESULTS,1500); // <-- This line doesn't produce any output, has problem
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

		// return "\"^$searchText\" | \"$searchText\" | \"$searchText\"~1 | \"$searchText\"~2 | \"$searchText\"~5 | \"$searchText\"~100 |
		// 	\"$searchText\"/$nowords_minus_1 | \"$searchText\"/$nowords_minus_2 | \"$searchText\"/$nowords_minus_3 | \"$searchText\"/$nowords_minus_4 | \"$searchText\"/$nowords_minus_5";

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