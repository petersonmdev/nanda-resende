<?php

 
$subtotal_ = WC()->session->get( 'cart_totals', null )['subtotal'];
$total_ = WC()->session->get( 'cart_totals', null )['subtotal'];
$frete = WC()->session->get( 'cart_totals', null )['shipping_total'];//($total_ - $subtotal_);

//$shipping_total = WC()->session->cart_totals['shipping_total'];
//echo $frete;

echo WC()->session->get( 'cart_totals', null )['shipping_total'];