<html>
<head>
	<title>FAR Seach Engine</title>
</head>

<body>
	<div style="float: right;">
		<?php if (!$is_logged_in) {?><a href="<?php echo base_url();?>index.php/auth/login">Login</a><?php } ?>
		<?php if ($is_logged_in) {?><a href="<?php echo base_url();?>index.php/auth/logout">Logout</a><?php } ?>
		<?php if (!$is_logged_in) {?><a href="<?php echo base_url();?>index.php/auth/register">Register</a><?php } ?>
		<a href="<?php echo base_url();?>index.php/home/index">Home</a>
	</div>

	<div><?php echo $content; ?></div>
</body>

</html>