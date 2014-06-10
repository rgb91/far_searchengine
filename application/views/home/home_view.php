<h1>Home Page</h1>
<p><?php echo $this->session->flashdata('message');?></p>
<form action="<?php echo base_url();?>index.php/search/query" method="post">
	Search here: <input type="text" name="search_text"/>
	<input type="submit" name="submit" value="Search">
