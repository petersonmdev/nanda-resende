<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once($parse_uri[0] . 'wp-load.php');

$WC = WC();
// Set the product ID to remove
$prod_to_remove = intval($_POST['id']);

// Cycle through each product in the cart
foreach ( $WC->cart->get_cart() as $cart_item_key => $cart_item ) {
    // Get the Variation or Product ID
    $prod_id = $cart_item['product_id'];
    $produtos[] = $cart_item['product_id'];
    $data = ['status' => 'failed', 'msg'=>'Não encontrado'];

    // Check to see if IDs match
    if( $prod_to_remove == $prod_id ) {
		$WC->cart->set_quantity( $cart_item_key, 0, true  );
        $new_subtotal = $WC->cart->get_total();
        $cart_qty = $WC->cart->get_cart_contents_count();
		$msg = 'Removido do carrinho';
		$data = ['status' => 'success', 'id' => $prod_id, 'msg' => 'Removido do carrinho!', 'cart_qty' => $cart_qty, 'subtotal' => $new_subtotal];
		break;
    }

}


echo json_encode($data);