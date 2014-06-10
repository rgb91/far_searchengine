<h1>Register</h1>
<p><?php echo $this->session->flashdata('message');?></p>
<form action="<?php echo base_url();?>index.php/auth/register_dopost" method="POST">
	<input type="text" placeholder="E-mail address" name="email"/> <br>
	<input type="text" placeholder="User name" name="username"/> <br>

	<input type="text" placeholder="First name" name="firstname"/> <br>
	<input type="text" placeholder="Last name" name="lastname"/> <br>

	<input type="password" placeholder="Password" name="pass"/> <br>
	<input type="password" placeholder="Password" name="repass"/> <br>

	<input type="submit" name="submit" value="Register"/>
</form>