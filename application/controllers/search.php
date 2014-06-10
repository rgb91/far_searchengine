<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	public function index() {

	}

	public function query() {
		$searchText = $this->input->post('search_text');

		$cl = new SphinxClient();

		$cl->SetServer( "localhost", 9312 );
		$cl->SetMatchMode( SPH_MATCH_ALL  );
		// $cl->SetRankingMode ( SPH_RANK_WORDCOUNT );
		// $cl->SetRankingMode ( SPH_RANK_PROXIMITY_BM25 );
		// $cl->setGroupDistinct('dmuserid');
		// $cl->setGroupBy('dmuserid', SPH_GROUPBY_ATTR, "@weight DESC");
		// $cl->SetIndexWeights(array('thread' => 10, 'post' => 5));
		// $cl->SetFieldWeights(array('title' => 10, 'title_secondary' => 9, 'publisher' => 3));
		// $cl->SetSortMode ( SPH_SORT_EXTENDED, "@weight DESC");
		// $cl->SetFilter( 'model', array( 3 ) );
		// $cl->SetLimits(0, 100);
		$cl->SetArrayResult(true);

		$result = $cl->Query( $searchText, 'test1' );
		// echo '<pre>'; print_r($result); die();

		/*foreach ( $result["matches"] as $doc) {
			$scientists[$doc["attrs"]["dmuserid"]] = $doc["weight"]; // * $doc["attrs"]["@count"] //The addition of the following gives advantage to old researchers compared to new that have less publications
		}*/

		$data['result'] = $result;
		$this->render_page('search/results_view', $data);
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