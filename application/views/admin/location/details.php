<a  href="<?php echo site_url('admin/location/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Location'); ?></h5>
<!--Data display of location with id--> 
<?php
	$c = $location;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Contry</td><td><?php echo $c['contry']; ?></td></tr>

<tr><td>State</td><td><?php echo $c['state']; ?></td></tr>

<tr><td>City</td><td><?php echo $c['city']; ?></td></tr>


</table>
<!--End of Data display of location with id//--> 