<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Collaborator_model extends CI_Model {


	public function __construct() {
		parent::__construct();
	}

	public function get_collaborator_by_dmuserid($dmuserid = '') {

		if ( !isset($dmuserid) || empty($dmuserid) ){
			return;
		}

		// $query = $this->db->get_where('ICTCollab_Collaborator', array('DMUSERID'=>$dmuserid));
		$queryString	= 'SELECT DMUSERID, LastName, FirstName, MiddleInit, PrimApptColl, PrimApptDept, TitleSeries, EMailAddr, Designation_name FROM ICTCollab_Collaborator, ICTCollab_Designations WHERE DMUSERID="'.$dmuserid.'" AND Rank=ICTCollab_Designations.id ORDER BY Rank';
		$query 			= $this->db->query($queryString);

		if ( $query->num_rows() == 1){
			$result_arr = $query->result();
			return $result_arr[0];
		}
		return;
	}

}

/* End of file collaborator_model.php */
/* Location: ./application/models/collaborator_model.php */