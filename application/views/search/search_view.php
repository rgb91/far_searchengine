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
<form action="<?php echo base_url();?>index.php/search/query" method="POST" class="form-horizontal">
	<fieldset>
	<div class="form-group">
	  <label class="control-label" for="inputLarge">Search here</label>
	  <input class="form-control input-lg" id="inputLarge" type="text" name="search_text" placeholder="Search Text" autofocus>
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
			<h1><?php echo $this->lang->line('site_search_results');?></h1>
		</div>
	</div>
</div>


<table class="table table-striped table-hover ">
    <thead>
    <tr>
        <th rowspan="2">Collaborator</th>
        <th colspan="2">Primary Appointment</th>
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
		<td><?php echo $collabFullName; ?></td>
		<td><?php echo $collabPrimApptColl; ?></td>
		<td><?php echo $collabPrimApptDept; ?></td>
		<td><?php echo $collabDesignation; ?></td>
		<td><?php echo $collabEmailAddr; ?></td>
	</tr>
<?php } ?>
    </tbody>
</table>
<?php }
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