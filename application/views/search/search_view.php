<div class="page-header">
  <div class="row">
    <div class="col-lg-12">
      <h1>Home</h1>
    </div>
  </div>
</div>


<div class="row">
	<div class="col-lg-6">

<?php if ($this->session->flashdata('message') ) { ?>
<div class="alert alert-dismissable alert-<?php echo $this->session->flashdata('message_type');?>">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <p><?php echo $this->session->flashdata('message');?></p>
</div>
<?php } ?>
<form action="<?php echo base_url();?>index.php/search/query" method="post">
	Search here: <input type="text" name="search_text"/>
	<input type="submit" name="submit" value="Search">

<br><br>
<h2><?php echo $this->lang->line('site_search_results');?></h2>

<?php if (isset($collaborators) && !empty($collaborators)) { ?>
<table>
	<tr>
		<th rowspan="2">Collaborator</th>
		<th colspan="2">Pr/dimary Appointment</th>
		<th rowspan="2">Designation</th>
		<th rowspan="2">Email Addr.</th>
	</tr>
	<tr>
		<th>College</th>
		<th>Department</th>
	</tr>
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