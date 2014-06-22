<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $this->lang->line('site_title'); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/bootstrap.css" media="screen">
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/bootswatch.min.css">
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="../bower_components/html5shiv/dist/html5shiv.js"></script>
		  <script src="../bower_components/respond/dest/respond.min.js"></script>
		<![endif]-->
		<script>

		 var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-23019901-1']);
		  _gaq.push(['_setDomainName', "bootswatch.com"]);
		    _gaq.push(['_setAllowLinker', true]);
		  _gaq.push(['_trackPageview']);

		 (function() {
		   var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		   ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		 })();

		</script>
	</head>
<body>
	<div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="#" class="navbar-brand">UKY Reasearch Catalog</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#" target="_blank">University of Kentucky</a></li>
            <?php if (!$is_logged_in) {?><li><a href="<?php echo base_url();?>index.php/auth/register">Register</a></li><?php } ?>
            <li>
              <a href="<?php echo base_url();?>index.php/home/index">Home</a>
            </li>
            <?php if (!$is_logged_in) {?><li><a href="<?php echo base_url();?>index.php/auth/login">Login</a></li><?php } ?>
            <?php if ($is_logged_in) {?><li><a href="<?php echo base_url();?>index.php/auth/logout">Logout</a></li><?php } ?>
          </ul>

        </div>
      </div>
    </div>

    <div class="container">
			<div class="bs-docs-section">
        <?php echo $content; ?>
			</div>


      <footer>
        <div class="row">
          <div class="col-lg-12">

            <ul  class="list-unstyled" >
              <li class="pull-right">
                <a href="#top">Back to top</a>
              </li>
              <li><a href="#" target="_blank">University of Kentucky</a></li>

              <?php if (!$is_logged_in) {?><li><a href="<?php echo base_url();?>index.php/auth/register">Register</a></li><?php } ?>
              <li>
                <a href="<?php echo base_url();?>index.php/home/index">Home</a>
              </li>
              <?php if (!$is_logged_in) {?><li><a href="<?php echo base_url();?>index.php/auth/login">Login</a></li><?php } ?>
              <?php if ($is_logged_in) {?><li><a href="<?php echo base_url();?>index.php/auth/logout">Logout</a></li><?php } ?>
            </ul>
            <p>Copyright &copy; University of Kentucky</p>
            <p>Developed by <a href="http://dreamsunborn.com/profile" rel="nofollow">Sanjay Saha</a>. Contact him at <a href="mailto:mail_sanjaysaha@yahoo.com">mail_sanjaysaha@yahoo.com</a>.</p>
          </div>
        </div>

      </footer>
		</div>

    <script src="<?php echo base_url();?>public/js/jquery-1.10.2.min.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>public/js/bootswatch.js"></script>
</body>

</html>