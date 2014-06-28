<?php
/**
*  This scripts updates the DMUSERLIST in ICTCollab_Publications
*  from ICTCollab_IntellCont table
**/

$con = mysql_connect ( 'localhost', 'root', '13nov91') or die("Unable to Connect");
if (!$con){die('Could not connect: ' . mysql_error());}
mysql_select_db("far_searchengine") or die(mysql_error()) ;
#$sql = "SELECT * FROM ICTCollab_Collaborator LIMIT 10";
$sql = 'SELECT * FROM ICTCollab_Publications';
$query_result=mysql_query($sql);
if (!$query_result) {die('Invalid query: ' . mysql_error());}


while($sw = mysql_fetch_array($query_result))
{
	$id = $sw['PUB_ID'];
	$title = $sw['TITLE'];
	$title = addslashes($title);
	// select the DMUSERIDs from IntellCont
	$sql = 'SELECT `DMUSERID` FROM ICTCollab_IntellCont WHERE TITLE="'.$title.'"';

	// echo $sql.'<br>';
	$query_result_dm = mysql_query($sql);

	$dmuserlist_st = '';
	while ( $dm = mysql_fetch_array($query_result_dm)) {
		$dmuserlist_st = $dmuserlist_st.$dm['DMUSERID'].',';
	}
	$dmuserlist_st = substr($dmuserlist_st, 0, strlen($dmuserlist_st)-1);


	$sql = 'UPDATE ICTCollab_Publications SET DMUSERLIST="'.$dmuserlist_st.'" WHERE PUB_ID='.$id;
	mysql_query($sql);

}

mysql_close($con);


?>