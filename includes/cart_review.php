<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once($parse_uri[0] . 'wp-load.php');

$WC = WC();

$shipping_total = 'R$'.number_format($WC->cart->shipping_total, 2, ',', '.');

//print_r($WC->cart);
echo $shipping_total;