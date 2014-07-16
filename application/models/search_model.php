<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model {

	public function getCollaboratorsInfoFromSearchResult($scientists, $start_point, $range) {

		$queryString	= 'SELECT DMUSERID, LastName, FirstName, PrimApptColl, PrimApptDept, TitleSeries, EMailAddr, Designation_name FROM ICTCollab_Collaborator, ICTCollab_Designations WHERE DMUSERID IN (' . implode(',', array_map('intval', array_keys($scientists))) . ') AND Rank=ICTCollab_Designations.id ORDER BY Rank LIMIT '.$start_point.', '.$range ;
		// echo $queryString;
		$query 			= $this->db->query($queryString);

		return $query->result();

	}

	public function logSearchText($email, $searchText) {
		$count 		 = $this->getCountInLogTable($email);

		if ( MAX_ENTRIES_IN_SEARCH_LOG && $count >= MAX_ENTRIES_IN_SEARCH_LOG ) {
			$queryString = 'DELETE FROM `ICTCollab_SearchHistory` WHERE USER_EMAIL="'.$email.'"  ORDER BY SEARCH_TIME DESC LIMIT '.($count-MAX_ENTRIES_IN_SEARCH_LOG);
			$this->db->query($queryString);
		}
		$data = array(
			'USER_EMAIL' => $email,
			'SEARCH_TEXT' => $searchText
			);
		$this->db->insert('ICTCollab_SearchHistory', $data);
	}

	private function getCountInLogTable($email) {
		$queryString = 'SELECT COUNT(*) as cnt FROM ICTCollab_SearchHistory WHERE USER_EMAIL= "'.$email.'"';
		$query 		 = $this->db->query($queryString);
		$count 		 = $query->result()[0]->cnt;

		return $count;
	}

}

/* End of file search_model.php */
/* Location: ./application/models/search_model.php */