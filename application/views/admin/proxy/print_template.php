<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css"> 
<h3 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Proxy'); ?></h3>
Date: <?php echo date("Y-m-d");?>
<hr>
<!--*************************************************
*********mpdf header footer page no******************
****************************************************-->
<htmlpageheader name="firstpage" class="hide">
</htmlpageheader>

<htmlpageheader name="otherpages" class="hide">
    <span class="float_left"></span>
    <span  class="padding_5"> &nbsp; &nbsp; &nbsp;
     &nbsp; &nbsp; &nbsp;</span>
    <span class="float_right"></span>         
</htmlpageheader>      
<sethtmlpageheader name="firstpage" value="on" show-this-page="1" />
<sethtmlpageheader name="otherpages" value="on" /> 
   
<htmlpagefooter name="myfooter"  class="hide">                          
     <div align="center">
               <br><span class="padding_10">Page {PAGENO} of {nbpg}</span> 
     </div>
</htmlpagefooter>    

<sethtmlpagefooter name="myfooter" value="on" />
<!--*************************************************
*********#////mpdf header footer page no******************
****************************************************-->
<!--Data display of proxy-->    
<table   cellspacing="3" cellpadding="3" class="table" align="center">
    <tr>
		<th>Server Name</th>
<th>Location</th>
<th>Ip</th>
<th>Port</th>
<th>Username</th>
<th>Password</th>
<th>Price</th>

    </tr>
	<?php foreach($proxy as $c){ ?>
    <tr>
		<td><?php echo $c['server_name']; ?></td>
<td><?php echo $c['location']; ?>
									</td>
<td><?php echo $c['ip']; ?></td>
<td><?php echo $c['port']; ?></td>
<td><?php echo $c['username']; ?></td>
<td><?php echo $c['password']; ?></td>
<td><?php echo $c['price']; ?></td>

    </tr>
	<?php } ?>
</table>
<!--End of Data display of proxy//--> 