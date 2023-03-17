<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php do_action( 'wpo_wcpdf_before_document', $this->type, $this->order ); ?>
<div class="etiqueta">
	<table class="head container">
		<tr>
			<td class="header">
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/woocommerce/pdf/nandaresende/logo.svg" width="100%" id="img-logo-js"/>
			</td>
			<td class="order-data topo">
				<table>
					<?php do_action( 'wpo_wcpdf_before_order_data', $this->type, $this->order ); ?>
					<tr class="order-number">
						<th><h3>Pedido:</h3></th>
						<td><h3><?php $this->order_number(); ?></h3></td>
					</tr>
					<tr class="shipping-method">
						<th><h3><?php _e( 'Shipping Method:', 'woocommerce-pdf-invoices-packing-slips' ); ?></h3></th>
						<td><h3><?php $this->shipping_method(); ?></h3></td>
					</tr>
					<?php do_action( 'wpo_wcpdf_after_order_data', $this->type, $this->order ); ?>
				</table>			
			</td>
		</tr>
	</table>

	<table class="recebedor">
		<tr class="linha01">
			<td>Recebedor:</td>
			<td>&nbsp;</td>
		</tr>
		<tr class="linha02">
			<td>Assinatura:</td>
			<td>&nbsp;</td>
		</tr>
	</table>

	<h1 class="document-type-label">
	<!-- <?php// if( $this->has_header_logo() ) echo $this->get_title(); ?> -->
	</h1>

	<h2 class="title-destinatario">Destinatário</h2>

	<?php do_action( 'wpo_wcpdf_after_document_label', $this->type, $this->order ); ?>

	<table class="order-data-addresses">
		<tr>
			<td class="address shipping-address">
				<?php _e( 'Shipping Address:', 'woocommerce-pdf-invoices-packing-slips' ); ?>
				<?php do_action( 'wpo_wcpdf_before_shipping_address', $this->type, $this->order ); ?>
				<?php $this->shipping_address(); ?>
				<?php do_action( 'wpo_wcpdf_after_shipping_address', $this->type, $this->order ); ?>
				<?php if ( isset($this->settings['display_email']) ) { ?>
				<div class="billing-email"><?php $this->billing_email(); ?></div>
				<?php } ?>
				<?php if ( isset($this->settings['display_phone']) ) { ?>
				<div class="billing-phone"><?php $this->billing_phone(); ?></div>
				<?php } ?>
			</td>
		</tr>
		<tr >
			<td class="address codebar">
				<img alt="cep" src="<?php echo esc_url(get_template_directory_uri()); ?>/woocommerce/pdf/nandaresende/php-barcode.php?size=50&text=<?php echo $this->custom_field('billing_postcode'); ?>" />
			</td>
			<td class="address codebar-obs">
				<span>Obs:</span><br>
				<span>ECT: 9912483983</span>
			</td>
		</tr>
	</table>

	<div class="separator"></div>

	<table class="remetente">
		<tr>
			<td class="shop-info">
				<div class="shop-name"><h3>Remetente: <?php $this->shop_name(); ?></h3></div>
				<div class="shop-address"><strong><?php $this->shop_address(); ?></strong></div>
			</td>
		</tr>
	</table>

	<?php do_action( 'wpo_wcpdf_before_order_details', $this->type, $this->order ); ?>

	

	<div class="bottom-spacer"></div>

	<?php do_action( 'wpo_wcpdf_after_order_details', $this->type, $this->order ); ?>

	<?php do_action( 'wpo_wcpdf_before_customer_notes', $this->type, $this->order ); ?>
	<div class="customer-notes">
		<?php if ( $this->get_shipping_notes() ) : ?>
			<h3><?php _e( 'Customer Notes', 'woocommerce-pdf-invoices-packing-slips' ); ?></h3>
			<?php $this->shipping_notes(); ?>
		<?php endif; ?>
	</div>
	<?php do_action( 'wpo_wcpdf_after_customer_notes', $this->type, $this->order ); ?>

	<?php if ( $this->get_footer() ): ?>
	<div id="footer">
		<?php $this->footer(); ?>
	</div><!-- #letter-footer -->
	<?php endif; ?>
</div>

<?php do_action( 'wpo_wcpdf_after_document', $this->type, $this->order ); ?>