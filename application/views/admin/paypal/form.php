<a href="<?php echo site_url('admin/paypal/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Paypal'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/paypal/save/'.$paypal['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
	<div class="card-body">
		<div class="form-group">
			<label for="Seller Email" class="col-md-4 control-label">Seller Email</label>
			<div class="col-md-8">
				<input type="text" name="seller_email"
					value="<?php echo ($this->input->post('seller_email') ? $this->input->post('seller_email') : $paypal['seller_email']); ?>"
					class="form-control" id="seller_email" />
			</div>
		</div>
		<div class="form-group">
			<label for="Api Type" class="col-md-4 control-label">Api Type</label>
			<div class="col-md-8"> 
           <?php
        $enumArr = $this->customlib->getEnumFieldValues('paypal', 'api_type');
        ?> 
           <select name="api_type" id="api_type" class="form-control" />
				<option value="">--Select--</option> 
             <?php
            for ($i = 0; $i < count($enumArr); $i ++) {
                ?> 
             <option value="<?=$enumArr[$i]?>"
					<?php if($paypal['api_type']==$enumArr[$i]){ echo "selected";} ?>><?=ucwords($enumArr[$i])?></option> 
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
		<button type="submit" class="btn btn-success"><?php if(empty($paypal['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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
