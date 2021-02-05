<a href="<?php echo site_url('member/subscriber/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Subscriber'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('member/subscriber/save/'.$subscriber['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
	<div class="card-body">
		<div class="form-group">
			<label for="Subscription Item" class="col-md-4 control-label">Subscription
				Item</label>
			<div class="col-md-8"> 
          <?php
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Subscription_item_model');
        $dataArr = $this->CI->Subscription_item_model->get_all_subscription_item();
        ?> 
          <select name="subscription_item_id" id="subscription_item_id"
					class="form-control" />
				<option value="">--Select--</option> 
            <?php
            for ($i = 0; $i < count($dataArr); $i ++) {
                ?> 
            <option value="<?=$dataArr[$i]['id']?>"
					<?php if($subscriber['subscription_item_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['plan_name']?></option> 
            <?php
            }
            ?> 
          </select>
			</div>
		</div>
		<div class="form-group">
			<label for="Subscriber Users" class="col-md-4 control-label">Subscriber
				Users</label>
			<div class="col-md-8"> 
          <?php
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Users_model');
        $dataArr = $this->CI->Users_model->get_all_users();
        ?> 
          <select name="subscriber_users_id" id="subscriber_users_id"
					class="form-control" />
				<option value="">--Select--</option> 
            <?php
            for ($i = 0; $i < count($dataArr); $i ++) {
                ?> 
            <option value="<?=$dataArr[$i]['id']?>"
					<?php if($subscriber['subscriber_users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['email']?></option> 
            <?php
            }
            ?> 
          </select>
			</div>
		</div>
		<div class="form-group">
			<label for="Start Date" class="col-md-4 control-label">Start Date</label>
			<div class="col-md-8">
				<input type="text" name="start_date" id="start_date"
					value="<?php echo ($this->input->post('start_date') ? $this->input->post('start_date') : $subscriber['start_date']); ?>"
					class="form-control-static datepicker" />
			</div>
		</div>
		<div class="form-group">
			<label for="End Date" class="col-md-4 control-label">End Date</label>
			<div class="col-md-8">
				<input type="text" name="end_date" id="end_date"
					value="<?php echo ($this->input->post('end_date') ? $this->input->post('end_date') : $subscriber['end_date']); ?>"
					class="form-control-static datepicker" />
			</div>
		</div>
		<div class="form-group">
			<label for="Transactio" class="col-md-4 control-label">Transactionid</label>
			<div class="col-md-8">
				<input type="text" name="transactionid"
					value="<?php echo ($this->input->post('transactionid') ? $this->input->post('transactionid') : $subscriber['transactionid']); ?>"
					class="form-control" id="transactionid" />
			</div>
		</div>
		<div class="form-group">
			<label for="Paid Amount" class="col-md-4 control-label">Paid Amount</label>
			<div class="col-md-8">
				<input type="text" name="paid_amount"
					value="<?php echo ($this->input->post('paid_amount') ? $this->input->post('paid_amount') : $subscriber['paid_amount']); ?>"
					class="form-control" id="paid_amount" />
			</div>
		</div>
		<div class="form-group">
			<label for="Status" class="col-md-4 control-label">Status</label>
			<div class="col-md-8"> 
           <?php
        $enumArr = $this->customlib->getEnumFieldValues('subscriber', 'status');
        ?> 
           <select name="status" id="status" class="form-control" />
				<option value="">--Select--</option> 
             <?php
            for ($i = 0; $i < count($enumArr); $i ++) {
                ?> 
             <option value="<?=$enumArr[$i]?>"
					<?php if($subscriber['status']==$enumArr[$i]){ echo "selected";} ?>><?=ucwords($enumArr[$i])?></option> 
             <?php
            }
            ?> 
           </select>
			</div>
		</div>

	</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
		<button type="submit" class="btn btn-success"><?php if(empty($subscriber['id'])){?>Save<?php }else{?>Update<?php } ?></button>
	</div>
</div>
<?php echo form_close(); ?>
<!--End of Form to save data//-->
<!--JQuery-->
<script>
	$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '<?php echo base_url(); ?>public/datepicker/images/calendar.gif',
	});
</script>
