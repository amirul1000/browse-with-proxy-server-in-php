<script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>

<a href="<?php echo site_url('admin/content/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Content'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/content/save/'.$content['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
	<div class="card-body">
		<div class="form-group">
			<label for="Content Title" class="col-md-4 control-label">Content
				Title</label>
			<div class="col-md-8"> 
           <?php
        $enumArr = $this->customlib->getEnumFieldValues('content', 'content_title');
        ?> 
           <select name="content_title" id="content_title"
					class="form-control" />
				<option value="">--Select--</option> 
             <?php
            for ($i = 0; $i < count($enumArr); $i ++) {
                ?> 
             <option value="<?=$enumArr[$i]?>"
					<?php if($content['content_title']==$enumArr[$i]){ echo "selected";} ?>><?=ucwords($enumArr[$i])?></option> 
             <?php
            }
            ?> 
           </select>
			</div>
		</div>
		<div class="form-group">
			<label for="Description" class="col-md-4 control-label">Description</label>
			<div class="col-md-8">
				<textarea name="description" id="description" class="form-control"
					rows="4" /><?php echo ($this->input->post('description') ? $this->input->post('description') : $content['description']); ?></textarea>
			</div>
		</div>

	</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
		<button type="submit" class="btn btn-success"><?php if(empty($content['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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
<!--JQuery-->
<script>
	 CKEDITOR.replace( 'description', {
	  height: 300,
	  filebrowserUploadUrl: "<?php echo site_url('admin/content/upload_picture'); ?>"
	 });
</script>
