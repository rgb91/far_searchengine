<h1>Login Page</h1>
<p><?php echo $this->session->flashdata('message');?></p>
<form action="<?php echo base_url();?>index.php/auth/login_dopost" method="POST">
	<input type="text" placeholder="E-mail address" name="email"/> <br>
	<input type="password" placeholder="Password" name="pass"/> <br>
	<input type="submit" name="submit" value="Enter"/>
</form>