<a href="<?php echo site_url('member/subscriber/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Subscriber'); ?></h5>
<!--Data display of subscriber with id-->
<?php
$c = $subscriber;
?>
<table class="table table-striped table-bordered">
	<tr>
		<td>Subscription Item</td>
		<td><?php
$this->CI = & get_instance();
$this->CI->load->database();
$this->CI->load->model('Subscription_item_model');
$dataArr = $this->CI->Subscription_item_model->get_subscription_item($c['subscription_item_id']);
echo $dataArr['plan_name'];
?>
									</td>
	</tr>

	<tr>
		<td>Subscriber Users</td>
		<td><?php
$this->CI = & get_instance();
$this->CI->load->database();
$this->CI->load->model('Users_model');
$dataArr = $this->CI->Users_model->get_users($c['subscriber_users_id']);
echo $dataArr['email'];
?>
									</td>
	</tr>

	<tr>
		<td>Start Date</td>
		<td><?php echo $c['start_date']; ?></td>
	</tr>

	<tr>
		<td>End Date</td>
		<td><?php echo $c['end_date']; ?></td>
	</tr>

	<tr>
		<td>Transactionid</td>
		<td><?php echo $c['transactionid']; ?></td>
	</tr>

	<tr>
		<td>Paid Amount</td>
		<td><?php echo $c['paid_amount']; ?></td>
	</tr>

	<tr>
		<td>Status</td>
		<td><?php echo $c['status']; ?></td>
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
<!--End of Data display of subscriber with id//-->
