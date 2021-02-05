

<!-- Content Start -->
<div class="main-content">
	<div class="main-content-inner">

       <?php
    echo $pricing_content;
    ?>		 
      
 
        <!-- Pricing Plans Start -->
		<div class="section border-0">
			<div class="pricings row">

           <?php
        foreach ($subscription_item as $c) {
            ?>
           
            <!-- Pricing Item Start -->
				<div class="pricing-item col-xl-4 col-lg-6 col-md-6">
					<div class="pricing-icon">
						<i class="flaticon-candidate"></i>
					</div>
					<div class="pricing-meta">
						<h3><?php echo $c['plan_name']; ?></h3>
						<h6>$<?php echo $c['cost_per_duration']; ?>/<?php echo $c['short_desc']; ?></h6>
					</div>
					<div class="pricing-content">
						<ul>
							<li>Total permitted <?php echo $c['total_permitted']; ?></li>
							<li>Days for <?php echo $c['days_for']; ?></li>
							<li><?php echo $c['description']; ?></li>
						</ul>
					</div>
            
               <?php
            if ($this->session->userdata('validated')) {

                $this->CI = & get_instance();
                $this->CI->load->model('Paypal_model');
                $paypal = $this->CI->Paypal_model->get_all_paypal();

                ?>
                            <div class="purchase-button" align="center">
                              <?php
                if ($paypal[0]['api_type'] == 'sandbox') {
                    $api = "https://www.sandbox.paypal.com/cgi-bin/webscr";
                } else {
                    $api = "https://www.paypal.com/cgi-bin/webscr";
                }
                $paypal_return_url = site_url('pricing/success');
                $paypal_shopping_url = site_url('pricing/index');
                $paypal_notify_url = site_url('pricing/notify');

                $paypal_business = $paypal[0]['seller_email'];

                ?>
                               <form action="<?=$api?>" method="post">
							<span class="lnr lnr-cart"></span> <input type="submit"
								class="btn btn--md theme-button cart-btn" value="Buy Now"
								alt="Make payments with PayPal - it's fast, free and secure!" />
							<input type="hidden" name="business"
								value="<?=$paypal_business?>"> <input type="hidden" name="rm"
								value="2">
                                    <?php

                $on0 = $c['plan_name'];
                $on1 = $c['short_desc'];
                $item_name = $c['plan_name'];
                $item_number = $c['id'];
                $quantity = 1;
                $amount = $c['cost_per_duration'];
                $tax = 0;
                $shipping_charge = 0;
                ?>
                                    <input type="hidden" name="on0_1"
								value="<?=$this->session->userdata('id')?>"> <input
								type="hidden" name="on1_1"
								value="<?=$this->session->userdata('id')?>"> <input
								type="hidden" name="item_name_1" value="<?=$item_name?>"> <input
								type="hidden" name="item_number_1" value="<?=$item_number?>"> <input
								type="hidden" name="amount_1" value="<?=$amount?>"> <input
								type="hidden" name="quantity_1" value="<?=$quantity?>" /> <input
								type="hidden" name="tax_1" value="<?=$tax?>"> <input
								type="hidden" name="shipping_1" value="<?=$shipping_charge?>"> <input
								type="hidden" name="currency_code" value="USD"> <input
								type="hidden" name="cmd" value="_cart" /> <input type="hidden"
								name="upload" value="1" /> <input type="hidden" name="mrb"
								value="3FWGC6LFTMTUG" /> <input type="hidden" name="return"
								value="<?=$paypal_return_url?>" /> <input type="hidden"
								name="shopping_url" value="<?=$paypal_shopping_url?>" /> <input
								type="hidden" name="notify_url" value="<?=$paypal_notify_url?>" />
						</form>
					</div>
                            <?php
            } else {
                ?>
                            <div class="purchase-button" align="center">
						<form action="<?php echo site_url('member/login'); ?>"
							method="post">
							<span class="lnr lnr-cart"></span> <input type="submit"
								class="btn-custom secondary cart-btn" value="Buy Now"
								alt="login" />
						</form>
					</div>
                            
                           <?php
            }
            ?>
            
            
            
            </div>
				<!-- Pricing Item End -->
            <?php
        }
        ?> 
          </div>
		</div>
		<!-- Pricing Plans End -->


	</div>

</div>
<!-- Content End -->

