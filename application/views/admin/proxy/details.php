<a  href="<?php echo site_url('admin/proxy/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Proxy'); ?></h5>
<!--Data display of proxy with id--> 
<?php
	$c = $proxy;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Server Name</td><td><?php echo $c['server_name']; ?></td></tr>

<tr><td>Location</td><td><?php echo $c['location']; ?>
									</td></tr>

<tr><td>Ip</td><td><?php echo $c['ip']; ?></td></tr>

<tr><td>Port</td><td><?php echo $c['port']; ?></td></tr>

<tr><td>Username</td><td><?php echo $c['username']; ?></td></tr>

<tr><td>Password</td><td><?php echo $c['password']; ?></td></tr>

<tr><td>Price</td><td><?php echo $c['price']; ?></td></tr>

<tr><td>Created At</td><td><?php echo $c['created_at']; ?></td></tr>

<tr><td>Updated At</td><td><?php echo $c['updated_at']; ?></td></tr>


</table>
<!--End of Data display of proxy with id//--> 