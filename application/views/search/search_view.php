<!--div class="page-header">
  <div class="row">
    <div class="col-lg-12">
      <h1>Home</h1>
    </div>
  </div>
</div-->


<div class="row">
	<div class="col-lg-12">

<?php if ( $this->session->flashdata('message') != null ) { ?>
<div class="alert alert-dismissable alert-<?php echo $this->session->flashdata('message_type');?>">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <p><?php echo $this->session->flashdata('message');?></p>
</div>
<?php } ?>
<form action="<?php echo base_url();?>index.php/search/query/" method="POST" class="form-horizontal">
	<fieldset>
	<div class="form-group">
	  <label class="control-label" for="inputLarge">Search here</label>
	  <input class="form-control input-lg" id="inputLarge" type="text" name="search_text" placeholder="Search Text" value="<?php echo ( isset($searchText) && strlen($searchText)>0)? $searchText:''; ?>" autofocus>
	</div>
	<div class="checkbox">
      <label>
        <input type="checkbox" name="is_synonym_on" value="1" <?php echo ( isset($is_synonym_on))? 'checked':''; ?>> Add results from synonyms
      </label>
    </div>
	<div class="form-group" >
	   <button style="width: 30%; margin-left:35%;" name="submit" type="submit" class="btn btn-primary btn-lg">Search</button>
	</div>
	</fieldset>
</form>

<?php if (isset($collaborators) && !empty($collaborators)) { ?>
<br><br>
<div class="page-header">
	<div class="row">
		<div class="col-lg-12">
			<h2><?php echo $this->lang->line('site_search_results');?></h2>
		</div>
	</div>
</div>

<?php


?>

<table class="table table-striped table-hover ">
    <thead>
    <tr>
        <th rowspan="2">Collaborator</th>
        <th colspan="2" style="text-align:center;">Primary Appointment</th>
        <th rowspan="2">Designation</th>
        <th rowspan="2">Email Addr.</th>
    </tr>
    <tr>
        <th>College</th>
        <th>Department</th>
    </tr>
    </thead>
    <tbody>

<?php
foreach ($collaborators as $collab) {
	$collabFullName 		= $collab->FirstName. ' '. $collab->LastName;
	$collabPrimApptColl		= $collab->PrimApptColl;
	$collabPrimApptDept		= $collab->PrimApptDept;
	$collabDesignation		= $collab->Designation_name;
	$collabEmailAddr		= $collab->EMailAddr;
?>
	<tr>
		<td><a href="<?php echo base_url();?>index.php/collaborator/details/<?php echo $collab->DMUSERID;?>"><?php echo $collabFullName; ?></a></td>
		<td><?php echo $collabPrimApptColl; ?></td>
		<td><?php echo $collabPrimApptDept; ?></td>
		<td><?php echo $collabDesignation; ?></td>
		<td><a href="mailto:<?php echo $collabEmailAddr; ?>"><?php echo $collabEmailAddr; ?></a></td>
	</tr>
<?php } ?>
    </tbody>
</table>

<div class="row">
	<div class="col-lg-6">
<?php
	echo $links;
}
/* end bracket for if condition */

/*
echo '<pre>';
// if (isset($result))print_r($result['matches']);
if (isset($collaborators)) print_r($collaborators);
echo '================================================<br>';
// if (isset($scientists))print_r($scientists);
echo '</pre>';*/
?>
			</div>
		</div>

	</div>
</div>