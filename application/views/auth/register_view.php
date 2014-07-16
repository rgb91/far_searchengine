<div class="page-header">
  <div class="row">
    <div class="col-lg-12">
      <h1><?php echo $this->lang->line('site_heading_register'); ?></h1>
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
<form action="<?php echo base_url();?>index.php/auth/register_dopost" method="POST" class="form-horizontal" onsubmit="return validateRegistrationForm()">
	<fieldset>
		<!-- <legend><?php echo $this->lang->line('label_register'); ?></legend> -->
	    <div class="form-group">
	      <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('label_email'); ?></label>
	      <div class="col-lg-10">
	      	<input class="form-control" id="inputEmail" type="text" placeholder="<?php echo $this->lang->line('label_placeholder_email');?>" name="email"/>
	      </div>
	    </div>
	    <div class="form-group">
	      	<label for="inputUserName" class="col-lg-2 control-label"><?php echo $this->lang->line('label_username'); ?></label>
	      		<div class="col-lg-10">
	        		<input class="form-control" id="inputUserName" type="text" placeholder="<?php echo $this->lang->line('label_placeholder_username');?>" name="username"/>
	      		</div>
	    </div>


		<div class="form-group">
			<label for="inputFirstName" class="col-lg-2 control-label"><?php echo $this->lang->line('label_firstname'); ?></label>
				<div class="col-lg-10">
	    			<input class="form-control" id="inputFirstName" type="text" placeholder="<?php echo $this->lang->line('label_placeholder_firstname');?>" name="firstname"/>
	    		</div>
	    </div>
	    <div class="form-group">
			<label for="inputLastName" class="col-lg-2 control-label"><?php echo $this->lang->line('label_lastname'); ?></label>
				<div class="col-lg-10">
	    			<input class="form-control" id="inputLastName" type="text" placeholder="<?php echo $this->lang->line('label_placeholder_lastname');?>" name="lastname"/>
	    		</div>
	    </div>

		<div class="form-group">
	      <label for="inputPassword" class="col-lg-2 control-label"><?php echo $this->lang->line('label_password'); ?></label>
	      <div class="col-lg-10">
	        <input class="form-control" id="inputPassword" type="password" placeholder="<?php echo $this->lang->line('label_placeholder_password'); ?>" name="pass">
	      </div>
	    </div>
	    <div class="form-group">
	      <label for="inputRePassword" class="col-lg-2 control-label"><?php echo $this->lang->line('label_repassword'); ?></label>
	      <div class="col-lg-10">
	        <input class="form-control" id="inputRePassword" type="password" placeholder="<?php echo $this->lang->line('label_placeholder_repassword'); ?>" name="repass">
	      </div>
	    </div>


	    <div class="form-group">
		  <div class="col-lg-10 col-lg-offset-2">
		    <button class="btn btn-default"><?php echo $this->lang->line('label_button_cancel'); ?></button>
		    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('label_button_register'); ?></button>
		  </div>
		</div>
	</fieldset>
</form>

	</div>
</div>


<script type="text/javascript">
function validateRegistrationForm() {
	if ( emptyFieldExists() ) {
		alert('Form can not be incomplete, please fill up all the fields.');
		return false;
	}
	if ( !validateEmail() ) {
		alert('Email address format is not correct!');
		return false;
	}
	return true;
}

function emptyFieldExists() {
	var field = document.getElementById('inputEmail').value;
	if (!field) return true;

	field = document.getElementById('inputUserName').value;
	if (!field) return true;

	field = document.getElementById('inputFirstName').value;
	if (!field) return true;

	field = document.getElementById('inputLastName').value;
	if (!field) return true;

	field = document.getElementById('inputPassword').value;
	if (!field) return true;

	field = document.getElementById('inputRePassword').value;
	if (!field) return true;

	return false;
}

function validateEmail() {
	var email 	= document.getElementById('inputEmail').value;
    var re 		= /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
    // return true;
}
</script>