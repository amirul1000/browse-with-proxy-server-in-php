<a  href="<?php echo site_url('admin/location/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Location'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/location/save/'.$location['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
   <div class="card-body">    
        <div class="form-group"> 
          <label for="Contry" class="col-md-4 control-label">Contry</label> 
          <div class="col-md-8"> 
           <input type="text" name="contry" value="<?php echo ($this->input->post('contry') ? $this->input->post('contry') : $location['contry']); ?>" class="form-control" id="contry" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="State" class="col-md-4 control-label">State</label> 
          <div class="col-md-8"> 
           <input type="text" name="state" value="<?php echo ($this->input->post('state') ? $this->input->post('state') : $location['state']); ?>" class="form-control" id="state" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="City" class="col-md-4 control-label">City</label> 
          <div class="col-md-8"> 
           <input type="text" name="city" value="<?php echo ($this->input->post('city') ? $this->input->post('city') : $location['city']); ?>" class="form-control" id="city" /> 
          </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($location['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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