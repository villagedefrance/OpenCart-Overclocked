<?php
// Heading
$_['heading_title']         = 'Authorize.Net (SIM)';

// Link
$_['text_authorizenet_sim'] = '<a onclick="window.open(\'https://www.authorize.net/solutions/merchantsolutions/pricing/\');"><img src="view/image/payment/authorizenet.png" alt="Authorize.Net" title="Authorize.Net" style="border:1px solid #EEEEEE;" /></a>';

// Text
$_['text_payment']          = 'Payment';
$_['text_success']          = 'Success: You have modified <b>Authorize.Net (SIM)</b> account details !';

// Entry
$_['entry_merchant']        = 'Merchant ID';
$_['entry_key']             = 'Transaction Key';
$_['entry_callback']        = 'Relay Response URL';
$_['entry_md5']             = 'MD5 Hash Value';
$_['entry_test']            = 'Test Mode';
$_['entry_total']           = 'Total';
$_['entry_total_max']       = 'Total Maximum';
$_['entry_order_status']    = 'Order Status';
$_['entry_geo_zone']        = 'Geo Zone';
$_['entry_status']          = 'Status';
$_['entry_sort_order']      = 'Sort Order';

// Help
$_['help_callback']         = 'Please login and set this at <a onclick="window.open(\'https://secure.authorize.net\');">https://secure.authorize.net</a>.';
$_['help_md5']              = 'The MD5 Hash feature enables you to authenticate that a transaction response is securely received from Authorize.Net. Please login and set this at <a onclick="window.open(\'https://secure.authorize.net\');">https://secure.authorize.net</a>. (Optional)';
$_['help_total']            = 'The checkout total the order must reach before this payment method becomes <b>active</b>';
$_['help_total_max']        = 'The maximum checkout total the order must reach before this payment method becomes <b>inactive</b>.<br />Leave empty for no maximum.';

// Error
$_['error_permission']      = 'Warning: You do not have permission to modify payment <b>Authorize.Net (SIM)</b> !';
$_['error_merchant']        = 'Merchant ID Required!';
$_['error_key']             = 'Transaction Key Required!';
