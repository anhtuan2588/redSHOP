<?php
/**
 * @copyright Copyright (C) 2010 redCOMPONENT.com. All rights reserved.
 * @license   GNU/GPL, see license.txt or http://www.gnu.org/copyleft/gpl.html
 *            Developed by email@recomponent.com - redCOMPONENT.com
 *
 * redSHOP can be downloaded from www.redcomponent.com
 * redSHOP is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License 2
 * as published by the Free Software Foundation.
 *
 * You should have received a copy of the GNU General Public License
 * along with redSHOP; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
//	require_once( JPATH_COMPONENT.DS.'helpers'.DS.'helper.php' );
//	$redhelper = new redhelper();
$db = JFactory::getDBO();
$user = JFActory::getUser();
$request = JRequest::get('request');
$orderHelper = new order_functions();
$rs = $orderHelper->getOrderItemDetail($data['order_id']);
$Itemid = $request["Itemid"];

//Authnet vars to send
$formdata = array(
	'sid'                => $this->_params->get("vendor_id"),
	'cart_order_id'      => "Order Id:" . $data['order_id'],
	'merchant_order_id'  => $data['order_id'],
	//   'email_merchant' => ((TWOCO_MERCHANT_EMAIL == 'True') ? 'TRUE' : 'FALSE'),
	// Customer Name and Billing Address
	'card_holder_name'   => $data['billinginfo']->firstname . " " . $data['billinginfo']->lastname,
	'street_address'     => $data['billinginfo']->address,
	'city'               => $data['billinginfo']->city,
	'state'              => $data['billinginfo']->state_code,
	'zip'                => $data['billinginfo']->zipcode,
	'country'            => $data['billinginfo']->country_code,
	'email'              => $data['billinginfo']->user_email,
	'phone'              => $data['billinginfo']->phone,
	// Customer Shipping Address
	'ship_name'          => $data['shippinginfo']->firstname . " " . $data['shippinginfo']->lastname,
	'ship_steet_address' => $data['shippinginfo']->address,
	'ship_city'          => $data['shippinginfo']->city,
	'ship_state'         => $data['shippinginfo']->state_code,
	'ship_zip'           => $data['shippinginfo']->zipcode,
	'ship_country'       => $data['shippinginfo']->country_code,
	'return_url'         => JURI::base() . "index.php?option=com_redshop&view=order_detail&controller=order_detail&task=notify_payment&payment_plugin=rs_payment_2checkout&Itemid=$Itemid&orderid=" . $data['order_id'],
	'x_receipt_link_url' => JURI::base() . "index.php?option=com_redshop&view=order_detail&controller=order_detail&task=notify_payment&payment_plugin=rs_payment_2checkout&Itemid=$Itemid&orderid=" . $data['order_id'],
	'id_type'            => 1,
	'c_tangible_1'       => "Y"
);


for ($p = 0; $p < count($rs); $p++)
{
	$formdata['c_prod_' . ($p + 1)] = "1," . $rs[$p]->product_quantity;
	$formdata['c_name_' . ($p + 1)] = $rs[$p]->order_item_name;
	$formdata['c_price_' . ($p + 1)] = $rs[$p]->product_item_price;
	$formdata['c_description_' . ($p + 1)] = "";
}

if ($this->_params->get("is_test") == "1")
	$formdata['demo'] = "Y";


$version = "2";
$checkouturl = "https://www.2checkout.com/checkout/purchase";
$formdata['total'] = number_format($data['carttotal'], 2, '.', '');

//build the post string
$poststring = '';
$task = $request['task'];
$layout = $request['layout'];

if ($task == "receipt")
{
	$query_string = "?";
	foreach ($formdata as $name => $value)
	{
		$query_string .= $name . "=" . urlencode($value) . "&";
	}

	$mainframe->redirect($checkouturl . $query_string);
}
else
{
	foreach ($formdata AS $key => $val)
	{
		$poststring .= "<input type='hidden' name='$key' value='$val' />";
	}
	?>
	<form action="<?php echo $checkouturl ?>" method="post" name="checkoutfrm" id="checkoutfrm">
		<?php echo $poststring; ?>

	</form>
<?php } ?>

<script type='text/javascript'>
	window.onload = function () {
		document.checkoutfrm.submit();
	}
</script>