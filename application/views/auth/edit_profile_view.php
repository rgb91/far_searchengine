<div class="page-header">
  <div class="row">
    <div class="col-lg-12">
      <h1><?php echo $this->lang->line('site_heading_profile'); ?></h1>
    </div>
  </div>
</div>


<div class="row">
	<div class="col-lg-8">


<?php if ( $this->session->flashdata('message') ) { ?>
<div class="alert alert-dismissable alert-<?php echo $this->session->flashdata('message_type');?>">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <p><?php echo $this->session->flashdata('message');?></p>
</div>
<?php } ?>
<form action="<?php echo base_url();?>index.php/auth/profile_dopost" method="POST" class="form-horizontal">
	<fieldset>
		<legend><?php echo $this->lang->line('label_profile'); ?></legend>
	    <div class="form-group">
	      <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('label_email'); ?></label>
	      <div class="col-lg-10">
	      	<input class="form-control" id="inputEmail" type="text" placeholder="<?php echo $this->lang->line('label_placeholder_email');?>" name="email" value="<?php echo $this->session->userdata('email');?>" readonly/>
	      </div>
	    </div>
	    <div class="form-group">
	      	<label for="inputUserName" class="col-lg-2 control-label"><?php echo $this->lang->line('label_username'); ?></label>
	      		<div class="col-lg-10">
	        		<input class="form-control" id="inputUserName" type="text" placeholder="<?php echo $this->lang->line('label_placeholder_username');?>" name="username" value="<?php echo $this->session->userdata('user_name');?>" />
	      		</div>
	    </div>


		<div class="form-group">
			<label for="inputFirstName" class="col-lg-2 control-label"><?php echo $this->lang->line('label_firstname'); ?></label>
				<div class="col-lg-10">
	    			<input class="form-control" id="inputFirstName" type="text" placeholder="<?php echo $this->lang->line('label_placeholder_firstname');?>" name="firstname" value="<?php echo $this->session->userdata('first_name');?>"/>
	    		</div>
	    </div>
	    <div class="form-group">
			<label for="inputLastName" class="col-lg-2 control-label"><?php echo $this->lang->line('label_lastname'); ?></label>
				<div class="col-lg-10">
	    			<input class="form-control" id="inputLastName" type="text" placeholder="<?php echo $this->lang->line('label_placeholder_lastname');?>" name="lastname" value="<?php echo $this->session->userdata('last_name');?>"/>
	    		</div>
	    </div>

		<div class="form-group">
	      <label for="inputPassword" class="col-lg-2 control-label"><?php echo $this->lang->line('label_password'); ?></label>
	      <div class="col-lg-10">
	        <input class="form-control" id="inputPassword" type="password" placeholder="<?php echo $this->lang->line('label_placeholder_password'); ?>" name="pass">
	      </div>
	    </div>


	    <div class="form-group">
		  <div class="col-lg-10 col-lg-offset-2">
		    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('label_button_editprofile'); ?></button>
		  </div>
		</div>
	</fieldset>
</form>

	</div>
</div>
