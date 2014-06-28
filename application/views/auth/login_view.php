<div class="page-header">
  <div class="row">
    <div class="col-lg-12">
      <h1>Login Page</h1>
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
<form action="<?php echo base_url();?>index.php/auth/login_dopost" method="POST" class="form-horizontal">
	<fieldset>
	   <legend>Login</legend>
	    <div class="form-group">
	      <label for="inputEmail" class="col-lg-2 control-label">Email</label>
	      <div class="col-lg-10">
	        <input class="form-control" id="inputEmail" type="text" placeholder="E-mail address" name="email">
	      </div>
	    </div>
		<div class="form-group">
	      <label for="inputPassword" class="col-lg-2 control-label">Password</label>
	      <div class="col-lg-10">
	        <input class="form-control" id="inputPassword" type="password" placeholder="Password" name="pass">
	      </div>
	    </div>
	    <div class="form-group">
		  <div class="col-lg-10 col-lg-offset-2">
		    <button class="btn btn-default">Cancel</button>
		    <button type="submit" class="btn btn-primary">Submit</button>
		  </div>
		</div>
	</fieldset>
</form>

	</div>
</div>
