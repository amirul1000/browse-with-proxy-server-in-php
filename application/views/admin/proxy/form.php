<a  href="<?php echo site_url('admin/proxy/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Proxy'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/proxy/save/'.$proxy['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
   <div class="card-body">    
        <div class="form-group"> 
          <label for="Server Name" class="col-md-4 control-label">Server Name</label> 
          <div class="col-md-8"> 
           <input type="text" name="server_name" value="<?php echo ($this->input->post('server_name') ? $this->input->post('server_name') : $proxy['server_name']); ?>" class="form-control" id="server_name" /> 
          </div> 
           </div>
<div class="form-group"> 
                                    <label for="Location" class="col-md-4 control-label">Location</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Location_model'); 
             $dataArr = $this->CI->Location_model->get_all_location(); 
          ?> 
          <select name="location"  id="location"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['contry']?>" <?php if($proxy['location']==$dataArr[$i]['contry']){ echo "selected";} ?>><?=$dataArr[$i]['contry']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
          <label for="Ip" class="col-md-4 control-label">Ip</label> 
          <div class="col-md-8"> 
           <input type="text" name="ip" value="<?php echo ($this->input->post('ip') ? $this->input->post('ip') : $proxy['ip']); ?>" class="form-control" id="ip" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Port" class="col-md-4 control-label">Port</label> 
          <div class="col-md-8"> 
           <input type="text" name="port" value="<?php echo ($this->input->post('port') ? $this->input->post('port') : $proxy['port']); ?>" class="form-control" id="port" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Username" class="col-md-4 control-label">Username</label> 
          <div class="col-md-8"> 
           <input type="text" name="username" value="<?php echo ($this->input->post('username') ? $this->input->post('username') : $proxy['username']); ?>" class="form-control" id="username" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Password" class="col-md-4 control-label">Password</label> 
          <div class="col-md-8"> 
           <input type="text" name="password" value="<?php echo ($this->input->post('password') ? $this->input->post('password') : $proxy['password']); ?>" class="form-control" id="password" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Price" class="col-md-4 control-label">Price</label> 
          <div class="col-md-8"> 
           <input type="text" name="price" value="<?php echo ($this->input->post('price') ? $this->input->post('price') : $proxy['price']); ?>" class="form-control" id="price" /> 
          </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($proxy['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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