<?php
get_header();
//$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
//require_once($parse_uri[0] . 'wp-load.php');

$WC = WC();
?>
<main>
	<div class="row mt-5 mb-5">
		
	<div class="container">
		<div class="col-md-8">
			<?php wc_cart_totals_shipping_html(); ?>
		</div>
		<div class="col-4 ml-auto">
			<div class="card p-2">
			<?php foreach ( $WC->cart->get_cart_contents() as $key => $val ):
				$_product = apply_filters( 'woocommerce_cart_item_product', $val['data'], $val, $key );
				?>
					<div class="d-flex flex-row justify-content-between align-items-stretch border-bottom">
						<div>
							<img src="<?php echo wp_get_attachment_image_url( $val['data']->image_id, 'large' ) ?>" class="img-fluid" alt="" style="max-width: 100px">
						</div>
						
						<div class="d-flex flex-column">
							<p class="text-right"><b><?php echo$val['data']->name?></b></p>
							<p class="text-right">Qtd: <?php echo$val['quantity']?> &#8680; <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $val['quantity'] ), $val, $key ); ?></p>
						</div>
					</div>
			<?php endforeach; ?>
			<p class="border-bottom mt-5">
				<span class="float-left">Subtotal</span>
				<span class="float-right"><?php wc_cart_totals_subtotal_html(); ?></span>
			</p>
			<p class="border-bottom mt-2" style="display:<?php echo $WC->cart->shipping_total > 0?'block':'none';   ?>">
				<span class="float-left">Frete</span>
				<span class="float-right">R$<?php echo number_format($WC->cart->shipping_total, 2, ',', '.') ?></span>
			</p>
			<p class="mt-2">
				<span class="float-left"><b>Total</b></span>
				<span class="float-right"><?php wc_cart_totals_order_total_html(); ?></span>
			</p>
			</div>

		</div>
	</div>

	</div>
</main>
<?php

//echo json_encode($data);

get_footer();

?>

