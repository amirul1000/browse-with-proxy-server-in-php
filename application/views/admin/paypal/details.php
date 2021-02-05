<a href="<?php echo site_url('admin/paypal/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Paypal'); ?></h5>
<!--Data display of paypal with id-->
<?php
$c = $paypal;
?>
<table class="table table-striped table-bordered">
	<tr>
		<td>Seller Email</td>
		<td><?php echo $c['seller_email']; ?></td>
	</tr>

	<tr>
		<td>Api Type</td>
		<td><?php echo $c['api_type']; ?></td>
	</tr>

	<tr>
		<td>Created At</td>
		<td><?php echo $c['created_at']; ?></td>
	</tr>

	<tr>
		<td>Updated At</td>
		<td><?php echo $c['updated_at']; ?></td>
	</tr>


</table>
<!--End of Data display of paypal with id//-->
