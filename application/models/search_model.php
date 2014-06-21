<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model {

	public function getCollaboratorsInfoFromSearchResult($scientists) {
		$queryString	= 'SELECT DMUSERID, LastName, FirstName, PrimApptColl, PrimApptDept, TitleSeries, EMailAddr, Designation_name FROM ICTCollab_Collaborator, ICTCollab_Designations WHERE DMUSERID IN (' . implode(',', array_map('intval', array_keys($scientists))) . ') AND Rank=ICTCollab_Designations.id ORDER BY Rank';
		// echo $queryString;
		$query 			= $this->db->query($queryString);

		return $query->result();

	}

}

/* End of file search_model.php */
/* Location: ./application/models/search_model.php */