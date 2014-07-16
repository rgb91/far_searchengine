<!-- <div class="page-header">
  <div class="row">
    <div class="col-lg-12">
      <h1>Collaborator Details</h1>
    </div>
  </div>
</div> -->


<div class="row" style="margin-left: auto; margin-right:auto;">
	<div class="col-lg-12">

<?php if ( $this->session->flashdata('message') != null ) { ?>
<div class="alert alert-dismissable alert-<?php echo $this->session->flashdata('message_type');?>">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <p><?php echo $this->session->flashdata('message');?></p>
</div>
<?php } ?>


<?php if (!empty($collaborator_data)) { ?>

	<h1><?php echo $collaborator_data->FirstName. ' '. $collaborator_data->MiddleInit. '. '. $collaborator_data->LastName; ?></h1>
	<h3><?php echo $collaborator_data->Designation_name; ?></h3>

	<br><br>
	<div class="col-lg-6">
		<div class="panel panel-default">
		  <div class="panel-heading">E-mail Address</div>
		  <div class="panel-body">
		    <a href="mailto:<?php echo $collaborator_data->EMailAddr; ?>"><?php echo $collaborator_data->EMailAddr; ?></a>
		  </div>
		</div>

		<!-- <div class="panel panel-default">
		  <div class="panel-heading">DMUSERID</div>
		  <div class="panel-body">
		    <?php echo $collaborator_data->DMUSERID; ?>
		  </div>
		</div> -->

		<div class="panel panel-default">
		  <div class="panel-heading">College</div>
		  <div class="panel-body">
		    <?php echo $collaborator_data->PrimApptColl; ?>
		  </div>
		</div>

	</div>

	<div class="col-lg-6">
		<div class="panel panel-default">
		  <div class="panel-heading">Department</div>
		  <div class="panel-body">
		    <?php echo $collaborator_data->PrimApptDept; ?>
		  </div>
		</div>

		<div class="panel panel-default">
		  <div class="panel-heading">Title Series</div>
		  <div class="panel-body">
		    <?php echo $collaborator_data->TitleSeries; ?>
		  </div>
		</div>
	</div>

<?php } else { ?>
	<h1>Sorry, no collaborator found!</h1>
<?php } ?>
	</div>
</div>